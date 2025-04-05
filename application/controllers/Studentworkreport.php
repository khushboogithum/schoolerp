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
        // echo "hello";
        // die();

        $classlist         = $this->class_model->get();
        $data['classlist'] = $classlist;


        $this->session->set_userdata('top_menu', 'studentworkreport');
        $this->session->set_userdata('sub_menu', 'studentworkreport/index');
        $data['title']      = 'Studentworkreport Report';
        $data['title_list'] = 'Studentworkreport Report';

        $this->form_validation->set_rules('class_id', $this->lang->line('class_id'), 'required');
        $this->form_validation->set_rules('section_id', $this->lang->line('section_id'), 'required');
        $this->form_validation->set_rules('student_id', $this->lang->line('student_id'), 'required');
           
            $data['class_id'] = $class_id = $this->input->post('class_id');
            $data['section_id'] = $section_id = $this->input->post('section_id');
            $data['student_id'] = $student_id = $this->input->post('student_id');
            $data['from_date'] = $from_date = $this->input->post('from_date');
            $data['to_date'] = $to_date = $this->input->post('to_date');


            if ($this->form_validation->run() == false) {

                $this->load->view('layout/header', $data);
                $this->load->view('studentworkreport/student_work_report');
                $this->load->view('layout/footer', $data);
            }else{
                
                $data['getreportdata'] = $this->Studentworkreport_model->getStudentMonthlyReport($student_id,$from_date,$to_date);
                $data['getsubjectwisestatus'] = $this->Studentworkreport_model->getSubjectWiseReportMonthly($student_id,$from_date,$to_date);
                $data['getAttendenceReport'] = $this->Studentworkreport_model->getAttendenceReport($student_id,$from_date,$to_date);
                $this->load->view('layout/header', $data);
                $this->load->view('studentworkreport/student_work_report');
                $this->load->view('layout/footer', $data);
            }
      
    }

    public function getstudent()
    {
        $class_id = $this->input->get('class_id');
        $section_id = $this->input->get('section_id');
        $data     = $this->Studentworkreport_model->getAllStudentBySection($class_id,$section_id);
        echo json_encode($data);
    }
}
