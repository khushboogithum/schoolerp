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
        $this->load->model('Subjectgroup_model');

    }

    public function index()
    {
        if (!$this->rbac->hasPrivilege('lesson', 'can_view')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'Lesson');
        $this->session->set_userdata('sub_menu', 'Lesson/index');
        $data['title']      = 'Add Lesson';
        $data['title_list'] = 'Lesson List';
       
        $admin = $this->session->userdata('admin');
        $user_id=$admin['id'];
        $data['lessonlist'] = $this->lessondiary_model->get();
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
            
        } else {
            $data = array(
                'class_id'        => $this->input->post('class_id'),
                'section_id'      => $this->input->post('section_id'),
                'subject_group_id' => $this->input->post('subject_group_id'),
                'subject_id'       => $this->input->post('subject_id'),
                'lesson_number'    => $this->input->post('lesson_number'),
                'lesson_name'      => $this->input->post('lesson_name'),
                'created_by'      => $user_id,
            );
            $this->lessondiary_model->add_lesson($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success">' . $this->lang->line('success_message') . '</div>');
            return redirect('lesson', $data);
        }

        $this->load->view('layout/header', $data);
        $this->load->view('lesson/lessonlist', $data);
        $this->load->view('layout/footer', $data);
    }

    public function delete($id)
    {
        if (!$this->rbac->hasPrivilege('lesson', 'can_delete')) {
            access_denied();
        }

        $this->lessondiary_model->remove($id);
        $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">' . $this->lang->line('delete_message') . '</div>');

        redirect('lesson');
    }
    public function edit($subject_group_id,$subject_id,$id)
    {
        if (!$this->rbac->hasPrivilege('lesson', 'can_edit')) {
            access_denied();
        }

        $data['title'] = 'Edit Lesson';
        $data['id'] = $id;
        $data['lessonlist'] = $this->lessondiary_model->viewlessionBysubjectgroup($subject_group_id,$subject_id);
        $data['lesson']=$lessionDetails = $this->lessondiary_model->get_lesson_by_id($id);
        $class_id=$lessionDetails['class_id'];
        $section_id=$lessionDetails['section_id'];
        $subject_group_id=$lessionDetails['subject_group_id'];
        $data['classlist'] = $this->class_model->get();
        $data['sectionlist'] = $this->lessondiary_model->getSectionListClassId($class_id);
        $data['subjectlist'] = $this->subjectgroup_model->getGroupsubjects($subject_group_id,$session_id);
        $data['subjectgrouplist'] = $this->Subjectgroup_model->getGroupByClassandSection($class_id, $section_id,$session_id=NULL);;
      
      
        $this->form_validation->set_rules('class_id', $this->lang->line('class'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('section_id', $this->lang->line('section'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('subject_group_id', $this->lang->line('subject_group'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('subject_id', $this->lang->line('subject'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('lesson_number', $this->lang->line('lesson_no'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('lesson_name', $this->lang->line('lesson_name'), 'trim|required|xss_clean');

        if ($this->form_validation->run() === false) {
            $this->load->view('layout/header', $data);
            $this->load->view('lesson/lessonEdit', $data);
            $this->load->view('layout/footer', $data);
        } else {
            $update_data = array(
                'lesson_id'       => $id,
                'class_id'        => $this->input->post('class_id'),
                'section_id'      => $this->input->post('section_id'),
                'subject_group_id' => $this->input->post('subject_group_id'),
                'subject_id'      => $this->input->post('subject_id'),
                'lesson_number'   => $this->input->post('lesson_number'),
                'lesson_name'     => $this->input->post('lesson_name'),
            );



            $this->lessondiary_model->add_lesson($update_data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">' . $this->lang->line('update_message') . '</div>');
            redirect('lesson/viewlession/'.$subject_group_id.'/'.$subject_id);
        }
    }

    public function viewsubjectgroup($classId,$sectionId)
    {
        if (!$this->rbac->hasPrivilege('lesson', 'can_edit')) {
            access_denied();
        }

        $admin = $this->session->userdata('admin');
        $user_id=$admin['id'];
        $data['title'] = 'Edit Lesson';
        $data['id'] = $id;
        $data['lesson'] = $this->lessondiary_model->getLessionByClassIdsectionId($classId,$sectionId);
        $data['lessonlist']=$lessionDetails= $this->lessondiary_model->getviewsubjectgroup($classId,$sectionId);
        $class_id=$lessionDetails[0]['class_id'];
        $section_id=$lessionDetails[0]['section_id'];
        $subject_group_id=$lessionDetails[0]['subject_group_id'];
        $data['classlist'] = $this->class_model->get();
        $data['sectionlist'] = $this->lessondiary_model->getSectionListClassId($class_id);
        $data['subjectlist'] = $this->subjectgroup_model->getGroupsubjects($subject_group_id,$session_id);
        $data['subjectgrouplist'] = $this->Subjectgroup_model->getGroupByClassandSection($class_id, $section_id,$session_id=NULL);;
      
        $this->form_validation->set_rules('class_id', $this->lang->line('class'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('section_id', $this->lang->line('section'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('subject_group_id', $this->lang->line('subject_group'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('subject_id', $this->lang->line('subject'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('lesson_number', $this->lang->line('lesson_no'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('lesson_name', $this->lang->line('lesson_name'), 'trim|required|xss_clean');

        if ($this->form_validation->run() === false) {
            $this->load->view('layout/header', $data);
            $this->load->view('lesson/lessionsubjectgroup', $data);
            $this->load->view('layout/footer', $data);
        } else {
            $data = array(
                'class_id'        => $this->input->post('class_id'),
                'section_id'      => $this->input->post('section_id'),
                'subject_group_id' => $this->input->post('subject_group_id'),
                'subject_id'       => $this->input->post('subject_id'),
                'lesson_number'    => $this->input->post('lesson_number'),
                'lesson_name'      => $this->input->post('lesson_name'),
                'created_by'      => $user_id,
            );
            $this->lessondiary_model->add_lesson($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success">' . $this->lang->line('success_message') . '</div>');
           
            redirect('lesson/viewsubjectgroup/'.$classId.'/'.$sectionId);
        }
    }
    public function viewlession($subject_group_id,$subject_id)
    {
        if (!$this->rbac->hasPrivilege('lesson', 'can_edit')) {
            access_denied();
        }
        $admin = $this->session->userdata('admin');
        $user_id=$admin['id'];

        $data['title'] = 'Edit Lesson';
        $data['id'] = $id;
        $data['lesson']=$lessionDetails= $this->lessondiary_model->getLessionBysubjectGroup($subject_group_id,$subject_id);

        $class_id=$lessionDetails[0]['class_id'];
        $section_id=$lessionDetails[0]['section_id'];
        $subject_group_id=$lessionDetails[0]['subject_group_id'];
        $data['classlist'] = $this->class_model->get();
        $data['sectionlist'] = $this->lessondiary_model->getSectionListClassId($class_id);
        $data['subjectlist'] = $this->subjectgroup_model->getGroupsubjects($subject_group_id,$session_id);
        $data['subjectgrouplist'] = $this->Subjectgroup_model->getGroupByClassandSection($class_id, $section_id,$session_id=NULL);
        $data['lessonlist'] = $this->lessondiary_model->viewlessionBysubjectgroup($subject_group_id,$subject_id);
      
        $this->form_validation->set_rules('class_id', $this->lang->line('class'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('section_id', $this->lang->line('section'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('subject_group_id', $this->lang->line('subject_group'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('subject_id', $this->lang->line('subject'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('lesson_number', $this->lang->line('lesson_no'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('lesson_name', $this->lang->line('lesson_name'), 'trim|required|xss_clean');

        if ($this->form_validation->run() === false) {
            $this->load->view('layout/header', $data);
            $this->load->view('lesson/viewlession', $data);
            $this->load->view('layout/footer', $data);
        } else {
            $data = array(
                'class_id'        => $this->input->post('class_id'),
                'section_id'      => $this->input->post('section_id'),
                'subject_group_id' => $this->input->post('subject_group_id'),
                'subject_id'       => $this->input->post('subject_id'),
                'lesson_number'    => $this->input->post('lesson_number'),
                'lesson_name'      => $this->input->post('lesson_name'),
                'created_by'      => $user_id,
            );
            $this->lessondiary_model->add_lesson($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success">' . $this->lang->line('success_message') . '</div>');
           
            redirect('lesson/viewlession/'.$subject_group_id.'/'.$subject_id);
        }
    }
}
