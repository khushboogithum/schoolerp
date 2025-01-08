<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Lesson extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('lessondiary_model');  // Load the model here

    }

    public function index()
    {
        if (!$this->rbac->hasPrivilege('class', 'can_view')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'Lession');
        $this->session->set_userdata('sub_menu', 'Lessions/index');
        $data['title']      = 'Add Lession';
        $data['title_list'] = 'Lession List';

        $classlist         = $this->class_model->get();
        $data['classlist'] = $classlist;

        $data['title'] = 'Add Lesson';
        $this->form_validation->set_rules('class_id', $this->lang->line('class'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('section_id', $this->lang->line('section'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('subject_group_id', $this->lang->line('subject_group'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('subject_id', $this->lang->line('subject'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('lesson_number', $this->lang->line('lesson_no'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('lesson_name', $this->lang->line('lesson_name'), 'trim|required|xss_clean');

        if ($this->form_validation->run() == false) {
           
        }  else {
                $data = array(
                    'class_id'        => $this->input->post('class_id'),
                    'section_id'      => $this->input->post('section_id'),                  
                    'subject_group_id' => $this->input->post('subject_group_id'),
                    'subject_id'       => $this->input->post('subject_id'),
                    'lesson_number'    => $this->input->post('lesson_number'),
                    'lesson_name'      => $this->input->post('lesson_name'),
                    'created_by'      => '3',
                );
                $this->lessondiary_model->add_lesson($data);
                return redirect('lesson');
            
        }

        $this->load->view('layout/header', $data);
        $this->load->view('lesson/lessonlist', $data);
        $this->load->view('layout/footer', $data);
    }
    public function createlesson()
    {
      
        
    }

    public function delete($id)
    {
        if (!$this->rbac->hasPrivilege('class', 'can_delete')) {
            access_denied();
        }
        $data['title'] = 'Fees Master List';
        $this->class_model->remove($id);

        $student_delete=$this->student_model->getUndefinedStudent();
        if(!empty($student_delete)){
            $delte_student_array=array();
            foreach ($student_delete as $student_key => $student_value) {

                $delte_student_array[]=$student_value->id;
            }
            $this->student_model->bulkdelete($delte_student_array);
        }
     
        redirect('classes');
    }

    public function edit($id)
    {
        if (!$this->rbac->hasPrivilege('class', 'can_edit')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'Academics');
        $this->session->set_userdata('sub_menu', 'classes/index');
        $data['title']      = 'Edit Class';
        $data['id']         = $id;
        $vehroute           = $this->classsection_model->getByID($id);
        $data['vehroute']   = $vehroute;
        $data['title_list'] = 'Fees Master List';

        $this->form_validation->set_rules(
            'class', $this->lang->line('class'), array(
                'required',
                array('class_exists', array($this->class_model, 'class_exists')),
            )
        );
        $this->form_validation->set_rules('sections[]', $this->lang->line('sections'), 'trim|required|xss_clean');

        if ($this->form_validation->run() == false) {
            $vehicle_result       = $this->section_model->get();
            $data['vehiclelist']  = $vehicle_result;
            $routeList            = $this->route_model->get();
            $data['routelist']    = $routeList;
            $vehroute_result      = $this->classsection_model->getByID();
            $data['vehroutelist'] = $vehroute_result;
            $this->load->view('layout/header', $data);
            $this->load->view('class/classEdit', $data);
            $this->load->view('layout/footer', $data);
        } else {
            $sections      = $this->input->post('sections');
            $prev_sections = $this->input->post('prev_sections');
            $route_id      = $this->input->post('route_id');
            $class_id      = $this->input->post('pre_class_id');
            if (!isset($prev_sections)) {
                $prev_sections = array();
            }
            $add_result    = array_diff($sections, $prev_sections);
            $delete_result = array_diff($prev_sections, $sections);
            if (!empty($add_result)) {
                $vehicle_batch_array = array();
                $class_array         = array(
                    'id'    => $class_id,
                    'class' => $this->input->post('class'),
                );
                foreach ($add_result as $vec_add_key => $vec_add_value) {
                    $vehicle_batch_array[] = $vec_add_value;
                }
                $this->classsection_model->add($class_array, $vehicle_batch_array);
            } else {
                $class_array = array(
                    'id'    => $class_id,
                    'class' => $this->input->post('class'),
                );
                $this->classsection_model->update($class_array);
            }

            if (!empty($delete_result)) {
                $classsection_delete_array = array();
                foreach ($delete_result as $vec_delete_key => $vec_delete_value) {
                    $classsection_delete_array[] = $vec_delete_value;
                }

                $this->classsection_model->remove($class_id, $classsection_delete_array);
            }

            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">' . $this->lang->line('update_message') . '</div>');
            redirect('classes/index');
        }
    }


}
