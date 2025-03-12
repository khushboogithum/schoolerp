<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Todayswork extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Todayswork_model');
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

        $classlist         = $this->class_model->get();
        $data['classlist'] = $classlist;

        $classwork = $this->Todayswork_model->getClasswork();
        $data['teachingClassWork'] = $classwork;

        $todaysWorkList = $this->Todayswork_model->todaysWorkList();
        $workData = [];
        foreach ($todaysWorkList as $work) {
           // $class_id = $work['class_id'];
            //$subject_id = $work['subject_id'];
            $lesson_number = $work['lesson_number'];
            // $countLessonsBySubject = $this->Todayswork_model->countLessonsBySubject($subject_id,$class_id);
            // $work['total_lessons'] = $countLessonsBySubject;

            if ($work['total_lessons'] > 0) {
                $work['syllabus_percentage'] = round(($lesson_number / $work['total_lessons']) * 100, 2);
            } else {
                $work['syllabus_percentage'] = 0;
            }

            $workData[] = $work;
        }
        // echo "<pre>";
        // print_r($workData);
        // die();
        $data['todaysWork'] = $workData;

        $this->form_validation->set_rules('work_date', $this->lang->line('work_date'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('class_id', $this->lang->line('class'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('section_id', $this->lang->line('section'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('subject_group_id', $this->lang->line('subject_group'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('subject_id', $this->lang->line('subject'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('lesson_number', $this->lang->line('lesson_no'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('lesson_name', $this->lang->line('lesson_name'), 'trim|required|xss_clean');

        $this->form_validation->set_rules('teaching_activity_id[]', $this->lang->line('teaching_activity_id'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('note_book_type_id[]', $this->lang->line('note_book_type_id'), 'trim|required|xss_clean');

        $this->form_validation->set_rules('teaching_activity_home_work_id[]', $this->lang->line('teaching_activity_home_work_id'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('note_book_type_id_home_work[]', $this->lang->line('note_book_type_id_home_work'), 'trim|required|xss_clean');
        if ($this->form_validation->run() == false) {

            $this->load->view('layout/header', $data);
            $this->load->view('todayswork/todayworklist', $data);
            $this->load->view('layout/footer', $data);
        } else {
            $lessonNumber = $this->Todayswork_model->getlessonnumber($this->input->post('lesson_number'));
            $todays_data = array(
                'work_date'        => $this->input->post('work_date'),
                'class_id'           => $this->input->post('class_id'),
                'section_id'         => $this->input->post('section_id'),
                'subject_group_id'   => $this->input->post('subject_group_id'),
                'subject_id'         => $this->input->post('subject_id'),
                'lesson_id'         => $lessonNumber,
                'lesson_name'       => $this->input->post('lesson_name'),
                'created_by'        => $user_id,
            );

            $teaching_activity_id = $this->input->post('teaching_activity_id');
            $teaching_activity_home_work_id = $this->input->post('teaching_activity_home_work_id');
            $note_book_type_id = $this->input->post('note_book_type_id');
            $note_book_type_id_home_work = $this->input->post('note_book_type_id_home_work');
            $insert_id = $this->Todayswork_model->addTodaysClassWork($todays_data, $teaching_activity_id, $teaching_activity_home_work_id, $note_book_type_id, $note_book_type_id_home_work);

            if ($insert_id) {
                $this->session->set_flashdata('msg', '<div class="alert alert-success">' . $this->lang->line('success_message') . '</div>');
                redirect('todayswork');
            } else {

                $this->session->set_flashdata('msg', '<div class="alert alert-danger">' . $this->lang->line('error_message') . '</div>');
                redirect('todayswork');
            }
        }
    }

    public function edit()
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

        $classlist         = $this->class_model->get();
        $data['classlist'] = $classlist;

        $classwork = $this->Todayswork_model->getClasswork();
        $data['teachingClassWork'] = $classwork;

        $todaysWorkList = $this->Todayswork_model->todaysWorkList();
        $workData = [];
        foreach ($todaysWorkList as $work) {
           // $class_id = $work['class_id'];
            //$subject_id = $work['subject_id'];
            $lesson_number = $work['lesson_number'];
            // $countLessonsBySubject = $this->Todayswork_model->countLessonsBySubject($subject_id,$class_id);
            // $work['total_lessons'] = $countLessonsBySubject;

            if ($work['total_lessons'] > 0) {
                $work['syllabus_percentage'] = round(($lesson_number / $work['total_lessons']) * 100, 2);
            } else {
                $work['syllabus_percentage'] = 0;
            }

            $workData[] = $work;
        }
        // echo "<pre>";
        // print_r($workData);
        // die();
        $data['todaysWork'] = $workData;

        $this->form_validation->set_rules('work_date', $this->lang->line('work_date'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('class_id', $this->lang->line('class'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('section_id', $this->lang->line('section'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('subject_group_id', $this->lang->line('subject_group'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('subject_id', $this->lang->line('subject'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('lesson_number', $this->lang->line('lesson_no'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('lesson_name', $this->lang->line('lesson_name'), 'trim|required|xss_clean');

        $this->form_validation->set_rules('teaching_activity_id[]', $this->lang->line('teaching_activity_id'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('note_book_type_id[]', $this->lang->line('note_book_type_id'), 'trim|required|xss_clean');

        $this->form_validation->set_rules('teaching_activity_home_work_id[]', $this->lang->line('teaching_activity_home_work_id'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('note_book_type_id_home_work[]', $this->lang->line('note_book_type_id_home_work'), 'trim|required|xss_clean');
        if ($this->form_validation->run() == false) {

            $this->load->view('layout/header', $data);
            $this->load->view('todayswork/todayworkedit', $data);
            $this->load->view('layout/footer', $data);
        } else {
            $lessonNumber = $this->Todayswork_model->getlessonnumber($this->input->post('lesson_number'));
            $todays_data = array(
                'work_date'        => $this->input->post('work_date'),
                'class_id'           => $this->input->post('class_id'),
                'section_id'         => $this->input->post('section_id'),
                'subject_group_id'   => $this->input->post('subject_group_id'),
                'subject_id'         => $this->input->post('subject_id'),
                'lesson_id'         => $lessonNumber,
                'lesson_name'       => $this->input->post('lesson_name'),
                'created_by'        => $user_id,
            );

            $teaching_activity_id = $this->input->post('teaching_activity_id');
            $teaching_activity_home_work_id = $this->input->post('teaching_activity_home_work_id');
            $note_book_type_id = $this->input->post('note_book_type_id');
            $note_book_type_id_home_work = $this->input->post('note_book_type_id_home_work');
            $insert_id = $this->Todayswork_model->addTodaysClassWork($todays_data, $teaching_activity_id, $teaching_activity_home_work_id, $note_book_type_id, $note_book_type_id_home_work);

            if ($insert_id) {
                $this->session->set_flashdata('msg', '<div class="alert alert-success">' . $this->lang->line('success_message') . '</div>');
                redirect('todayswork');
            } else {

                $this->session->set_flashdata('msg', '<div class="alert alert-danger">' . $this->lang->line('error_message') . '</div>');
                redirect('todayswork');
            }
        }
    }






    public function getlessionData()
    {
        $subject_id = $this->input->post('subject_id');
        $class_id = $this->input->post('class_id');
        $data     = $this->Todayswork_model->getLessionDetailsBySubjectId($subject_id,$class_id);
        echo json_encode($data);
    }

    public function getlessionDataByLessionId()
    {
        $lession_id = $this->input->post('lesson_id');
        $data     = $this->Todayswork_model->getLessionDetailsByLessionId($lession_id);
        echo json_encode($data);
    }

    public function getNotebooksByClasswork()
    {
        $teaching_activity_id = $this->input->post('teaching_activity_id');
        //print_r($teaching_activity_id);
        $data = $this->Todayswork_model->getNotebookByClasswork($teaching_activity_id);
        echo json_encode($data);
    }
    public function getNotebooksByHomeswork()
    {
        $teaching_activity_home_work_id = $this->input->post('teaching_activity_home_work_id');
        $data = $this->Todayswork_model->getNotebookByHomework($teaching_activity_home_work_id);
        echo json_encode($data);
    }
    public function todayStudentWorkReport()
    {
        $today_work_id = $this->input->post('today_work_id');
        $data = ['today_status' => 1];
        $result = $this->Todayswork_model->todaysWorkList();

        if (!empty($result)) {
            $classid = $result[0]['class_id'];
            $subjectname = $result[0]['subject_name'];
            $subjectid = $result[0]['subject_id'];
            $classSubjectID = '?class_id=' . $classid . '&subject_name=' . $subjectname. '&subject_id=' . $subjectid;
            $this->Todayswork_model->goForStudentWorkReport($today_work_id, $data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success">' . $this->lang->line('submit_message') . '</div>');

            redirect('todayswork/studentworkreport' . $classSubjectID);
        } else {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger">No work data found for the given ID.</div>');
            redirect('todayswork');
        }
    }

    public function studentworkreport()
    {
        $this->session->set_userdata('top_menu', 'todayswork');
        $this->session->set_userdata('sub_menu', 'todayswork/index');
        $data['title']      = 'Student Work Report';
        $data['title_list'] = 'Student Work Report';

        $data['class_id']=$class_id = $this->input->get('class_id');
        $data['subject_name'] =$subject_name= $this->input->get('subject_name');
        $data['subject_id'] =$subject_id= $this->input->get('subject_id');
        $data['student_data'] = $this->Todayswork_model->getStudents($class_id,$subject_name);

    //    $result = $this->Todayswork_model->todaysWorkList();
    //     if (!empty($result)) {
    //         $classid = $result[0]['class_id'];
    //         $subjectname = $result[0]['subject_name'];
    //         $subjectid = $result[0]['subject_id'];
    //     }

        
        $postdata = $this->input->post();
        // echo "<pre>";
        // print_r($postdata);
        // die();

        $student_data = $postdata['student_name'];
        $total_student = $postdata['total_student'];
        $today_completed_work = $postdata['today_completed_work'];
        $today_uncompleted_work = $postdata['today_uncompleted_work'];
        $today_completed_percentage = $postdata['today_completed_percentage'];
        $today_uncompleted_percentage = $postdata['today_uncompleted_percentage'];
        $insertData = array();
        foreach ($student_data as $key => $studentdata) {

            $insertData[] = array(
                'student_name'        => $studentdata,
                'subject_id'        => $postdata['subject_id'],
                'student_id'        => $postdata['studentId'][$key],
                'discipline_dress'           => $postdata['dress'][$key],
                'discipline_conduct'         => $postdata['conduct'][$key],
                'fair_copy'   => $postdata['fair_copy'][$key],
                'writing_work'         => $postdata['writing_copy'][$key],
                'learning_work'         => $postdata['learning_copy'][$key],
                'subject_name'       => $postdata['subject_name'],
                'class_id'       => $postdata['class_name'],
                'remarks'        => $postdata['remarks'][$key],
            );
        }
        $resultData = $this->Todayswork_model->insertTodayStudentReport($insertData);
        $today = date('Y-m-d');
        $insertTodayReport = array(
            'class_id'                     => $postdata['class_name'],
            'subject_id'                   => $postdata['subject_id'],
            'total_student'                 => $total_student,
            'today_completed_work'          => $today_completed_work,
            'today_uncompleted_work'        => $today_uncompleted_work,
            'today_completed_percentage'    => $today_completed_percentage,
            'today_uncompleted_percentage'  => $today_uncompleted_percentage,
            'today_date'  => $today,
        );
        
       $todayData= $this->Todayswork_model->insertTodayWorkReport($insertTodayReport);
        
        if (!empty($resultData) && !empty($todayData)) {
            
            $classSubjectID = '?class_id=' . $postdata['class_name'] . '&subject_name=' . $postdata['subject_name']. '&subject_id=' . $postdata['subject_id'];

            $this->session->set_flashdata('msg', '<div class="alert alert-success">' . $this->lang->line('success_message') . '</div>');
            redirect('todayswork/studentworkreport' . $classSubjectID);
        } else {
            $this->load->view('layout/header', $data);
            $this->load->view('todayswork/studentworkreport', $data);
            $this->load->view('layout/footer', $data);
        }
    }
}
