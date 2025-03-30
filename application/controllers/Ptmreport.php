<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Ptmreport extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Ptm_model');
    }

    public function index()
    {
             
        // if (!$this->rbac->hasPrivilege('Studentworkreport', 'can_view')) {
        //     access_denied();
        // }
        $this->form_validation->set_data($this->input->get());

        $classlist         = $this->class_model->get();
        $data['classlist'] = $classlist;


        $this->session->set_userdata('top_menu', 'ptmreport');
        $this->session->set_userdata('sub_menu', 'ptmreport/index');
        $data['title']      = 'Ptm Report';
        $data['title_list'] = 'Ptm Report';

        $this->form_validation->set_rules('class_id', $this->lang->line('class_id'), 'required');
        $this->form_validation->set_rules('section_id', $this->lang->line('section_id'), 'required');
        $this->form_validation->set_rules('student_id', $this->lang->line('student_id'), 'required');
           
            $data['class_id'] = $class_id = $this->input->get('class_id');
            $data['section_id'] = $section_id = $this->input->get('section_id');
            $data['student_id'] = $student_id = $this->input->get('student_id');
            $data['from_date'] = $from_date = $this->input->get('from_date');
            $data['to_date'] = $to_date = $this->input->get('to_date');


            if ($this->form_validation->run() == false) {
                $this->load->view('layout/header', $data);
                $this->load->view('ptm/ptm_report');
                $this->load->view('layout/footer', $data);
            }else{
                $data['getreportdata'] = $this->Ptm_model->getStudentMonthlyReport($student_id,$from_date,$to_date);
                $data['getsubjectwisestatus'] = $this->Ptm_model->getSubjectWiseReportMonthly($student_id,$from_date,$to_date);
                $data['getAttendenceReport'] = $this->Ptm_model->getAttendenceReport($student_id,$from_date,$to_date);
                $data['studentDetails'] = $this->Ptm_model->studentDetails($student_id,$from_date,$to_date);
                // echo "<pre>";
                // print_r($data['studentDetails']);
                // die();
                $this->load->view('layout/header', $data);
                $this->load->view('ptm/ptm_report');
                $this->load->view('layout/footer', $data);
            }
      
    }

    public function getstudent()
    {
        $class_id = $this->input->get('class_id');
        $section_id = $this->input->get('section_id');
        $data     = $this->Ptm_model->getAllStudentBySection($class_id,$section_id);
        echo json_encode($data);
    }
}
