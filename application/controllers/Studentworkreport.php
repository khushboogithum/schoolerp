<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Studentworkreport extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Studentworkreport_model');
    }

    public function index()
    {
        // if (!$this->rbac->hasPrivilege('Studentworkreport', 'can_view')) {
        //     access_denied();
        // }

        $this->session->set_userdata('top_menu', 'studentworkreport');
        $this->session->set_userdata('sub_menu', 'studentworkreport/index');
        $data['title']      = 'Studentworkreport Report';
        $data['title_list'] = 'Studentworkreport Report';
        
        $data['getreportdata'] = $this->Studentworkreport_model->getStudentMonthlyReport();
        $data['getsubjectwisestatus'] = $this->Studentworkreport_model->getSubjectWiseReportMonthly();

        $this->load->view('layout/header', $data);
        $this->load->view('studentworkreport/student_work_report');
        $this->load->view('layout/footer', $data);
      
    }
}
