<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Parentsreport extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Parents_model');
    }

    public function index()
    {
        // if (!$this->rbac->hasPrivilege('lesson', 'can_view')) {
        //     access_denied();
        // }
        $admin = $this->session->userdata('admin');
        $user_id=$admin['id'];
        $this->session->set_userdata('top_menu', 'todayswork');
        $this->session->set_userdata('sub_menu', 'todayswork/index');
        $data['title']      = 'Todays Work';
        $data['title_list'] = 'Todays Work';


        $this->form_validation->set_rules('class_id', $this->lang->line('class_id'), 'required');
        $this->form_validation->set_rules('section_id', $this->lang->line('section_id'), 'required');
        $this->form_validation->set_rules('student_id', $this->lang->line('student_id'), 'required');
        $this->form_validation->set_rules('tdate', $this->lang->line('tdate'), 'required');

        $data['class_id'] = $class_id = $this->input->post('class_id');
        $data['section_id'] = $section_id = $this->input->post('section_id');
        $data['student_id'] = $student_id = $this->input->post('student_id');
        $data['tdate'] = $tdate = $this->input->post('tdate');

        
        $classlist= $this->class_model->get();
        $data['classlist'] = $classlist;
        
        if ($this->form_validation->run() == false) {
            $this->load->view('layout/header', $data);
            $this->load->view('parents/parents_report', $data);
            $this->load->view('layout/footer', $data);
        }else{
 
            $classwork = $this->Parents_model->getClasswork();
            $data['teachingClassWork'] = $classwork;
            $todaysWorkList = $this->Parents_model->todaysWorkList($class_id,$student_id,$tdate);
            $workData = [];
            foreach ($todaysWorkList as $work) {
                $lesson_number = $work['lesson_number'];
                if ($work['total_lessons'] > 0) {
                    $work['syllabus_percentage'] = round(($lesson_number / $work['total_lessons']) * 100, 2);
                } else {
                    $work['syllabus_percentage'] = 0;
                }
                $workData[] = $work;
            }
            $data['todaysWork'] = $workData;
            $data['studentDetails'] = $this->Parents_model->studentDetails($student_id);
            $data['studentAttendence'] = $this->Parents_model->getAttendenceReport($student_id,$tdate);
            $data['getSubjectWiseReport'] = $this->Parents_model->getSubjectWiseReport($student_id,$tdate);
            

            $this->load->view('layout/header', $data);
            $this->load->view('parents/parents_report', $data);
            $this->load->view('layout/footer', $data);
        }

    }

    

}
