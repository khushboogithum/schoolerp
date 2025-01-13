<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Todayswork extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Todayswork_model');  

    }

    public function index()
    {
        if (!$this->rbac->hasPrivilege('lesson', 'can_view')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'todayswork');
        $this->session->set_userdata('sub_menu', 'todayswork/index');
        $data['title']      = 'Todays Work';
        $data['title_list'] = 'Todays Work';

        $classlist         = $this->class_model->get();
        $data['classlist'] = $classlist;

        // $this->form_validation->set_rules('class_id', $this->lang->line('class'), 'trim|required|xss_clean');
        // $this->form_validation->set_rules('section_id', $this->lang->line('section'), 'trim|required|xss_clean');
        // $this->form_validation->set_rules('subject_group_id', $this->lang->line('subject_group'), 'trim|required|xss_clean');
        // $this->form_validation->set_rules('subject_id', $this->lang->line('subject'), 'trim|required|xss_clean');
        // $this->form_validation->set_rules('lesson_number', $this->lang->line('lesson_no'), 'trim|required|xss_clean');
        // $this->form_validation->set_rules('lesson_name', $this->lang->line('lesson_name'), 'trim|required|xss_clean');

        // if ($this->form_validation->run() == false) {
        // } else {
        //     $data = array(
        //         'class_id'        => $this->input->post('class_id'),
        //         'section_id'      => $this->input->post('section_id'),
        //         'subject_group_id' => $this->input->post('subject_group_id'),
        //         'subject_id'       => $this->input->post('subject_id'),
        //         'lesson_number'    => $this->input->post('lesson_number'),
        //         'lesson_name'      => $this->input->post('lesson_name'),
        //         'created_by'      => '3',
        //     );
        //     $this->lessondiary_model->add_lesson($data);
        //     $this->session->set_flashdata('msg', '<div class="alert alert-success">' . $this->lang->line('success_message') . '</div>');
        //     return redirect('lesson', $data);
        // }

        $this->load->view('layout/header', $data);
        $this->load->view('todayswork/todayworklist', $data);
        $this->load->view('layout/footer', $data);
    }

    public function delete($id)
    {
       
    }
    public function edit($id)
    {
        
    }
}
