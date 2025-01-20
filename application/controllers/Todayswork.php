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
        if (!$this->rbac->hasPrivilege('lesson', 'can_view')) {
            access_denied();
        }
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
            $subject_id = $work['subject_id'];
            $lesson_id = $work['lesson_id'];

            $countLessonsBySubject = $this->Todayswork_model->countLessonsBySubject($subject_id);
            $work['total_lessons'] = $countLessonsBySubject;

            if ($work['total_lessons'] > 0) {
                $work['syllabus_percentage'] = round(($lesson_id / $work['total_lessons']) * 100, 2);
            } else {
                $work['syllabus_percentage'] = 0;
            }

            $workData[] = $work;
        }

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

            $todays_data = array(
                'work_date'        => $this->input->post('work_date'),
                'class_id'           => $this->input->post('class_id'),
                'section_id'         => $this->input->post('section_id'),
                'subject_group_id'   => $this->input->post('subject_group_id'),
                'subject_id'         => $this->input->post('subject_id'),
                'lesson_id'         => $this->input->post('lesson_number'),
                'lesson_name'       => $this->input->post('lesson_name'),
                'created_by'        => 3,
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
        $data     = $this->Todayswork_model->getLessionDetailsBySubjectId($subject_id);
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
        //print_r($teaching_activity_id);
        $data = $this->Todayswork_model->getNotebookByHomework($teaching_activity_home_work_id);
        echo json_encode($data);
    }
    public function todayStudentWorkReport()
    {
        $today_work_id = $this->input->post('today_work_id');
        $data = ['today_status' => 1];
        $this->Todayswork_model->goForStudentWorkReport($today_work_id, $data);
        $this->session->set_flashdata('msg', '<div class="alert alert-success">' . $this->lang->line('submit_message') . '</div>');
        redirect('todayswork');
    }
    public function studentworkreport()
    {
        $this->session->set_userdata('top_menu', 'todayswork');
        $this->session->set_userdata('sub_menu', 'todayswork/index');
        $data['title']      = 'Student Work Report';
        $data['title_list'] = 'Student Work Report';

        $this->load->view('layout/header', $data);
        $this->load->view('todayswork/studentworkreport', $data);
        $this->load->view('layout/footer', $data);
    }
}
