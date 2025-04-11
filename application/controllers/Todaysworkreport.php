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
        // if (!$this->rbac->hasPrivilege('todaysworkreport', 'can_view')) {
        //     access_denied();
        // }
        $this->session->set_userdata('top_menu', 'todaysworkreport');
        $this->session->set_userdata('sub_menu', 'todaysworkreport/index');
        $data['title']      = 'Student Home Work Report';
        $data['title_list'] = 'Student Home Work Report';


        $classlist         = $this->class_model->get();
        $data['classlist'] = $classlist;


        ////////////Filter/////////////
        $search = $this->input->post('search');
        $this->form_validation->set_rules('todays_date', $this->lang->line('todays_date'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('class_id', $this->lang->line('class_id'), 'trim|required|xss_clean');
        // $this->form_validation->set_rules('section_id', $this->lang->line('section'), 'trim|required|xss_clean');
        // $this->form_validation->set_rules('subject_group_id', $this->lang->line('subject_group'), 'trim|required|xss_clean');
        // $this->form_validation->set_rules('subject_id', $this->lang->line('subject'), 'trim|required|xss_clean');
       

        if ($this->form_validation->run() == false) {
            $this->load->view('layout/header', $data);
            $this->load->view('todaysworkreport/homeworksyllabusreport', $data);
            $this->load->view('layout/footer', $data);
        } else {

            if ($search != '') {
                $data['todays_date'] = $todays_date = $this->input->post('todays_date');
                $data['class_id'] = $class_id = $this->input->post('class_id');
                $data['section_id'] = $section_id = $this->input->post('section_id');
                $data['subject_group_id'] = $subject_group_id = $this->input->post('subject_group_id');
                $data['subject_id'] = $subject_id = $this->input->post('subject_id');
    
                $todaysWorkList = $this->Todaysworkreport_model->todaysWorkList($todays_date, $class_id, $section_id, $subject_group_id, $subject_id);
                $workData = [];
                foreach ($todaysWorkList as $work) {
                    $subject_id = $work['subject_id'];
                    $lesson_number = $work['lesson_number'];
                    if ($work['total_lessons'] > 0) {
                        $work['syllabus_percentage'] = round(($lesson_number / $work['total_lessons']) * 100, 2);
                    } else {
                        $work['syllabus_percentage'] = 0;
                    }
                    $workData[] = $work;
                }
                $data['todaysWork'] = $workData;
            }
            $this->load->view('layout/header', $data);
            $this->load->view('todaysworkreport/homeworksyllabusreport', $data);
            $this->load->view('layout/footer', $data);


        }


       
    }
    public function allStudentWorkReport()
    {
        $class_ids = $this->input->post('classid');
        $subject_ids = $this->input->post('subjectid');
        $staff_ids = $this->input->post('staffid');
        $syllabus_percentages = $this->input->post('syallabus_percentage');
        $student_work_percentages = $this->input->post('studuent_work_percentage');
        $total_percentages = $this->input->post('total_percentage');
        $today_work_id = $this->input->post('today_work_id');
        $work_date = $this->input->post('work_date');
       
        

        if (!empty($class_ids)) {
            $insertData = [];
            foreach ($class_ids as $key => $class_id) {
                $insertData[] = [
                    'class_id' => $class_id,
                    'subject_id' => $subject_ids[$key],
                    'staff_id' => $staff_ids[$key],
                    'syallabus_percentage' => $syllabus_percentages[$key],
                    'student_work_percentage' => $student_work_percentages[$key],
                    'total_percentage' => $total_percentages[$key],
                    'today_work_id' => $today_work_id[$key],
                    'today_date' => $work_date[$key]
                ];
                
            }

            $url="?class_id=".$class_id.'&subject_id='.implode(',',$subject_ids).'&today_work_id='.implode(',',$today_work_id);
            $result = $this->Todaysworkreport_model->insertWorkReport($insertData);
            redirect('todaysworkreport/allstudentworkreports'.$url);
            //   $this->session->set_flashdata('msg', '<div class="alert alert-success">' . $this->lang->line('submit_message') . '</div>');
        } else {

            $this->session->set_flashdata('msg', '<div class="alert alert-success">' . $this->lang->line('error_message') . '</div>');
            redirect('todaysworkreport');
        }
    }

    // public function allStudentWorkReport()
    // {
    // $today_work_id = $this->input->post('today_work_id');
    // $data = ['today_status' => 1];
    // $this->Todayswork_model->goForStudentWorkReport($today_work_id, $data);
    // $this->session->set_flashdata('msg', '<div class="alert alert-success">' . $this->lang->line('submit_message') . '</div>');
    // redirect('todaysworkreport');
    // }
    public function allstudentworkreports()
    {
        $this->session->set_userdata('top_menu', 'todaysworkreport');
        $this->session->set_userdata('sub_menu', 'todaysworkreport/index');
        $data['title']      = 'Student Home and Syllabus  Work Report';
        $data['title_list'] = 'Student Home and Syllabus  Work Report';

        $classId= $this->input->get('class_id');
        $subject_id = $this->input->get('subject_id');
        $today_work_id = $this->input->get('today_work_id');
      
        

        $data['getreportdata'] = $this->Todaysworkreport_model->getTodayReportData($classId,$subject_id,$today_work_id);
        $data['getsubjectwisestatus'] = $this->Todaysworkreport_model->getSubjectWiseReport($classId,$subject_id,$today_work_id);

        $class_id = $this->input->post('class_id');
        $today_work_id = $this->input->post('today_work_id');
        $updateData = [
            'status' => $this->input->post('status')
        ];
        //todays report data
        $resultData = $this->Todaysworkreport_model->ApproveStudentWorkReport($class_id,$today_work_id,$updateData);
        //subject_wise_report data
        if ($resultData) {
            $today_work_id = $this->input->post('today_work_id');
            $class_ids = $this->input->post('classid');
            $subject_ids = $this->input->post('subjectid');
            $total_student = $this->input->post('total_student');
            $complate_student = $this->input->post('complate_student');
            $incomplate_student = $this->input->post('incomplate_student');
            $subject_percentage = $this->input->post('subject_percentage');
            $class_percentage = $this->input->post('class_percentage');
            
            if (!empty($class_ids)) {
                $insertSubjectData = [];
                foreach ($class_ids as $key => $class_id) {
                    $insertSubjectData[] = [
                        'class_id' => $class_id,
                        'today_work_id' => $today_work_id[$key],
                        'subject_id' => $subject_ids[$key],
                        'total_student' => $total_student[$key],
                        'complate_student' => $complate_student[$key],
                        'incomplate_student' => $incomplate_student[$key],
                        'subject_percentage' => $subject_percentage[$key],
                        'subject_percentage' => $subject_percentage[$key],
                        'today_date' => date('Y-m-d')
                    ];
                }
                // print_r($insertSubjectData);
                // die();
                $this->Todaysworkreport_model->insertSubjectReport($insertSubjectData); 
            }
            //class_wise_report data
            $insertClassData = [
                'class_id' => $class_id,
                'class_percentage' => $class_percentage,
                'today_date' => date('Y-m-d')
            ];
            $this->Todaysworkreport_model->insertClassReport($insertClassData);
            $this->session->set_flashdata('msg', '<div class="alert alert-success">' . $this->lang->line('success_message') . '</div>');
            redirect('todaysworkreport/index');
        } else {
            $this->load->view('layout/header', $data);
            $this->load->view('todaysworkreport/allstudentworkreports', $data);
            $this->load->view('layout/footer', $data);
        }
    }
    
}
