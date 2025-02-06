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
        $this->load->model('staff_model');
    }

    public function index()
    {
        // if (!$this->rbac->hasPrivilege('syallabusreport', 'can_view')) {
        //     access_denied();
        // }
        $this->session->set_userdata('top_menu', 'syallabusreport');
        $this->session->set_userdata('sub_menu', 'syallabusreport/index');
        $data['title']      = 'Syallabus Report';
        $data['title_list'] = 'Syallabus Report';

        $classlist         = $this->class_model->get();
        $data['classlist'] = $classlist;
        $data['subjectgroup'] = $this->Syallabusreport_model->getGroupByClassandSection();

        ////////////////////////////teacher list//////////////////////////////////////////////////
        $teacherlist = $this->staff_model->getStaffbyrole($role = 2);
        $data['teacherlist'] = $teacherlist;
        $workData = [];
        ///////////////////////////////filter wise data/////////////////////////////////////////////////////////
        $data['report_type'] = $report_type = $this->input->post('report_type');
        $this->form_validation->set_rules('report_type', $this->lang->line('report_type'), 'required');
        $this->form_validation->set_message('required', 'Please select atleast one.');
        $this->form_validation->set_rules('from_date', $this->lang->line('from_date'), 'required');
        $this->form_validation->set_rules('to_date', $this->lang->line('to_date'), 'required');
        if ($report_type == 'class_wise') {

            $this->form_validation->set_rules('class_id', $this->lang->line('class_id'), 'required');
            $this->form_validation->set_rules('section_id', $this->lang->line('section_id'), 'required');
        }
        if ($report_type == 'teacher_wise') {
            $this->form_validation->set_rules('teacher_id', $this->lang->line('teacher_id'), 'required');
        }
        if ($report_type == 'subject_wise') {
           // $this->form_validation->set_rules('subject_group_id', $this->lang->line('subject_group_id'), 'required');
           // $this->form_validation->set_rules('subject_id', $this->lang->line('subject_id'), 'required');
        }

        $data['from_date'] = $from_date = $this->input->post('from_date');
        $data['to_date'] = $to_date = $this->input->post('to_date');

        if ($this->form_validation->run() == false) {
            
            $data['syallabusReport'] = $workData;
            $this->load->view('layout/header', $data);
            $this->load->view('syallabusreport/syallabus_report', $data);
            $this->load->view('layout/footer', $data);
        } else {
            if ($report_type == 'class_wise') {
                $data['class_id'] = $class_id = $this->input->post('class_id');
                $data['section_id'] = $section_id = $this->input->post('section_id');

                $syallabusReport = $this->Syallabusreport_model->syallabusReport($from_date,$to_date,$class_id,$section_id);
                foreach ($syallabusReport as $work) {
                    $lesson_number = $work['lesson_number'];
                    if ($work['total_lessons'] > 0) {
                        $work['syllabus_percentage'] = round(($lesson_number / $work['total_lessons']) * 100, 2);
                    } else {
                        $work['syllabus_percentage'] = 0;
                    }
                    $workData[] = $work;
                }
            }

            if ($report_type == 'teacher_wise') {
                 $teacher_id= $this->input->post('teacher_id');
             
                $data['teacher_id'] =$teacher_id;
                $data['teacherwisereport'] = $this->Syallabusreport_model->TeacherWisesyallabus($from_date,$to_date,$teacher_id);
               
            }

            if ($report_type == 'subject_wise') {
            
               $data['subjectWiseReport'] = $this->Syallabusreport_model->getSubjectWiseReport();
              
           }

            $data['syallabusReport'] = $workData;
            $this->load->view('layout/header', $data);
            $this->load->view('syallabusreport/syallabus_report', $data);
            $this->load->view('layout/footer', $data);
        }
    }
}
