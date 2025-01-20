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
        $todaysWorkList = $this->Todaysworkreport_model->todaysWorkList();
        $workData = [];

        foreach ($todaysWorkList as $work) {
            $subject_id = $work['subject_id'];
            $lesson_id = $work['lesson_id'];

            $countLessonsBySubject = $this->Todaysworkreport_model->countLessonsBySubject($subject_id);
            $work['total_lessons'] = $countLessonsBySubject;

            if ($work['total_lessons'] > 0) {
                $work['syllabus_percentage'] = round(($lesson_id / $work['total_lessons']) * 100, 2);
            } else {
                $work['syllabus_percentage'] = 0;
            }

            $workData[] = $work;
        }

        $data['todaysWork'] = $workData;

        $this->load->view('layout/header', $data);
        $this->load->view('todaysworkreport/homeworksyllabusreport', $data);
        $this->load->view('layout/footer', $data);
    }
    public function allStudentWorkReport()
    {
        
        // $today_work_id = $this->input->post('today_work_id');
        // $data = ['today_status' => 1];
        // $this->Todayswork_model->goForStudentWorkReport($today_work_id, $data);
        // $this->session->set_flashdata('msg', '<div class="alert alert-success">' . $this->lang->line('submit_message') . '</div>');
        // redirect('todaysworkreport');
    }
    public function allstudentworkreports()
    {
        $this->session->set_userdata('top_menu', 'todaysworkreport');
        $this->session->set_userdata('sub_menu', 'todaysworkreport/index');
        $data['title']      = 'Student Home and Syllabus  Work Report';
        $data['title_list'] = 'Student Home and Syllabus  Work Report';

        $this->load->view('layout/header', $data);
        $this->load->view('todaysworkreport/allstudentworkreports', $data);
        $this->load->view('layout/footer', $data);
    }

  
}
