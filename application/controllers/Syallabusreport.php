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


        
        $syallabusReport = $this->Syallabusreport_model->syallabusReport();
        $workData = [];
        foreach ($syallabusReport as $work) {
            $lesson_number = $work['lesson_number'];
            if ($work['total_lessons'] > 0) {
                $work['syllabus_percentage'] = round(($lesson_number / $work['total_lessons']) * 100, 2);
            } else {
                $work['syllabus_percentage'] = 0;
            }

            $workData[] = $work;
        }
        $data['syallabusReport']=$workData;
        

        $this->session->set_userdata('top_menu', 'syallabusreport');
        $this->session->set_userdata('sub_menu', 'syallabusreport/index');
        $data['title']      = 'Syallabus Report';
        $data['title_list'] = 'Syallabus Report';
       
       
        $this->load->view('layout/header', $data);
        $this->load->view('syallabusreport/syallabus_report', $data);
        $this->load->view('layout/footer', $data);
    }
    

}
