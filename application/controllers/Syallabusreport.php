<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Syallabusreport extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Syallabusreport_model');  


    }

    public function index()
    {
        if (!$this->rbac->hasPrivilege('syallabusreport', 'can_view')) {
            access_denied();
        }
        $classlist         = $this->class_model->get();
        $data['classlist'] = $classlist;
        $data['syallabusReport'] = $this->Syallabusreport_model->syallabusReport();

        $this->session->set_userdata('top_menu', 'syallabusreport');
        $this->session->set_userdata('sub_menu', 'syallabusreport/index');
        $data['title']      = 'Syallabus Report';
        $data['title_list'] = 'Syallabus Report';
       
       
        $this->load->view('layout/header', $data);
        $this->load->view('syallabusreport/syallabus_report', $data);
        $this->load->view('layout/footer', $data);
    }
    

}
