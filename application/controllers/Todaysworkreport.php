<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class TodaysworkReport extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Todaysworkreport_model');  

    }

    public function index()
    {
        
        if (!$this->rbac->hasPrivilege('todaysworkreport', 'can_view')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'todaysworkreport');
        $this->session->set_userdata('sub_menu', 'todaysworkreport/index');
        $data['title']      = 'Student Home Work Report';
        $data['title_list'] = 'Student Home Work Report';

        $classlist         = $this->class_model->get();
        $data['classlist'] = $classlist;


        $this->load->view('layout/header', $data);
        $this->load->view('todaysworkreport/homeworksyllabusreport', $data);
        $this->load->view('layout/footer', $data);
    }

  
}
