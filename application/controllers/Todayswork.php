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
        $this->load->model('Section_model'); 
        $this->load->model('subjectgroup_model'); 
        $this->load->model('Subject_model');
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
            
            // if ($this->input->post('class_id') != $this->input->post('old_class_id')) {
            //     echo '<script type="text/javascript">
            //             alert("Please submit this class data after adding another class data.");
            //             window.location.href = "' . site_url('todayswork') . '";
            //           </script>';
            //     exit; // Prevent further execution
            // }
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

    public function edit($id)
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

        $data['today_work_id']=$today_work_id=$id;
        
        $data['editData']=$todayworkedit = $this->Todayswork_model->getClassworkid($today_work_id);
        $classworkedit = $this->Todayswork_model->getClassworkdrop($today_work_id);
        $homeworkedit = $this->Todayswork_model->getHomeworkdrop($today_work_id);
        
        $data['teaching_activity_id']=$teaching_activity_ids = $classworkedit['teaching_activity_ids'];
        $teachingactivityID=explode(',',$teaching_activity_ids);
        
        $data['homework_teaching_activity_id']=$homework_teaching_activity_id = $homeworkedit['teaching_activity_ids'];
        $hometeachingactivityID=explode(',',$homework_teaching_activity_id);

        $todays_class_notebooks=$this->Todayswork_model->getNotebookByClasswork($teachingactivityID);
        $data['todays_class_notebook']=$todays_class_notebooks;

        $todays_homework_notebooks=$this->Todayswork_model->getNotebookByHomework($hometeachingactivityID);
        $data['todays_homework_notebook']=$todays_homework_notebooks;
       
        
        $classworkNoteedit = $this->Todayswork_model->getClassworkNotedrop($today_work_id);
        $data['note_book_type_id'] = $classworkNoteedit['note_book_type_ids'];

        $homeworkNoteedit = $this->Todayswork_model->getClassworkNotedrop($today_work_id);
        $data['homework_note_book_type_id'] = $homeworkNoteedit['note_book_type_ids'];

        $data['work_date']=$todayworkedit['work_date'];
       // print_r($todayworkedit);
        // print_r($);
       // die();
        $data['class_id']=$todayworkedit['class_id'];
        $data['section_id']=$todayworkedit['section_id'];
        $data['subject_group_id']=$todayworkedit['subject_group_id'];
        $data['subject_id']=$todayworkedit['subject_id'];
        $data['lesson_number']=$todayworkedit['lesson_id'];
        $data['lesson_name']=$todayworkedit['lesson_name'];

        $data['lesson_id']= $this->Todayswork_model->getLessionId($data['class_id'],$data['subject_id'],$data['lesson_number']);
        $data['classlist']         = $this->class_model->get();
          
        $classwork = $this->Todayswork_model->getClasswork();
        $data['teachingClassWork'] = $classwork;

        $todaysWorkList = $this->Todayswork_model->todaysWorkListEdit($today_work_id);
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
        $data['todaysWork'] = $workData;
        $teaching_activity_id = $this->input->post('teaching_activity_id');
        $teaching_activity_home_work_id = $this->input->post('teaching_activity_home_work_id');
        $note_book_type_id = $this->input->post('note_book_type_id');
        $note_book_type_id_home_work = $this->input->post('note_book_type_id_home_work');

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
            
            $update_id = $this->Todayswork_model->updateTodaysClassWork($todays_data,$today_work_id, $teaching_activity_id, $teaching_activity_home_work_id, $note_book_type_id, $note_book_type_id_home_work);
            if ($update_id) {
                $this->session->set_flashdata('msg', '<div class="alert alert-success">' . $this->lang->line('update_message') . '</div>');
                redirect('todayswork/edit/'.$today_work_id);
            } else {

                $this->session->set_flashdata('msg', '<div class="alert alert-danger">' . $this->lang->line('error_message') . '</div>');
                redirect('todayswork/edit/'.$today_work_id);
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
        $subject_id = $this->input->post('subject_id');
        $class_id = $this->input->post('class_id');
        $today_work_id = $this->input->post('today_work_id');
        // print_r($today_work_id);
        // die();
        $data = ['today_status' => 1];
        $result=$this->Todayswork_model->goForStudentWorkReport($today_work_id, $data);
        if ($result) {
          //  $classSubjectID = '?class_id=' . $classid . '&subject_name=' . $subjectname. '&subject_id=' . $subjectid;
           
            $this->session->set_flashdata('msg', '<div class="alert alert-success">' . $this->lang->line('submit_message') . '</div>');

            redirect('todayswork/studentworkreport?class_id='.$class_id.'&subject_id[]='.$subject_id[0]);
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
        $subject_id = $this->input->get('subject_id');
        $class_id = $this->input->get('class_id');
        $today_work_id = $this->input->get('today_work_id');

        $data['class_id']=$class_id = $this->input->get('class_id');
        $data['subject_name'] =$subject_name= $this->input->get('subject_name');
        $data['subject_id'] =$subject_id= $this->input->get('subject_id');
        $data['student_data'] = $this->Todayswork_model->getStudents($class_id,$subject_id);
        $data['subject_details'] = $this->Todayswork_model->getSubjectDetails($subject_id,$today_work_id);

        $postdata = $this->input->post();
        
        $insertData = [];
        foreach ($postdata['studentId'] as $key => $studentId) {
            foreach ($postdata['subject_id'][$key] as $subKey => $subjectId) {
                $insertData[] = array(
                    'student_name'       => $postdata['student_name'][$key],
                    'student_id'         => $studentId,
                    'subject_id'         => $subjectId,
                    'subject_name'       => $postdata['subject_name'][$key][$subKey],
                    'today_work_id'       => $postdata['todayWorkId'][$key][$subKey],
                    'class_id'           => $postdata['class_id'],
                    'discipline_dress'   => $postdata['dress'][$key],
                    'discipline_conduct' => $postdata['conduct'][$key],
                    'fair_copy'          => $postdata['fair_copy'][$key][$subKey],
                    'writing_work'       => $postdata['writing_copy'][$key][$subKey],
                    'learning_work'      => $postdata['learning_copy'][$key][$subKey],
                    'remarks'            => $postdata['remarks'][$key],
                );
            }
        }
       $resultData = $this->Todayswork_model->insertTodayStudentReport($insertData);

       $total_students = $postdata['total_student'];
       $insertTodayReport=array();
        foreach($total_students as $rkey=>$total_student){

            $today = date('Y-m-d');
            $insertTodayReport= array(
                'class_id'                     =>  $postdata['class_id'],
                'subject_id'                   =>  $postdata['report_subject_id'][$rkey],
                'today_work_id'                 => $postdata['report_today_work_id'][$rkey],
                'total_student'                 => $total_student,
                'today_completed_work'          => $postdata['today_completed_work'][$rkey],
                'today_uncompleted_work'        => $postdata['today_uncompleted_work'][$rkey],
                'today_completed_percentage'    => $postdata['today_completed_percentage'][$rkey],
                'today_uncompleted_percentage'  => $postdata['today_uncompleted_percentage'][$rkey],
                'today_date'  => $today,
            );  
         $todayData= $this->Todayswork_model->insertTodayWorkReport($insertTodayReport);
        }
        


        if (!empty($resultData)) {
            $result=$this->Todayswork_model->goForStudentWorkReport($today_work_id);
            
           // $classSubjectID = '?subject_id=' . $subject_id . '&class_id=' . $class_id. '&today_work_id=' . $today_work_id;

            $this->session->set_flashdata('msg', '<div class="alert alert-success">' . $this->lang->line('success_message') . '</div>');
            redirect('todaysworkreport/index');
        } else {
            $this->load->view('layout/header', $data);
            $this->load->view('todayswork/studentworkreport', $data);
            $this->load->view('layout/footer', $data);
        }
    }

    public function todayStudentWorkReportEdit()
    {
        $this->session->set_userdata('top_menu', 'todayswork');
        $this->session->set_userdata('sub_menu', 'todayswork/index');
        $data['title']      = 'Student Work Report';
        $data['title_list'] = 'Student Work Report';
        $subject_id = $this->input->get('subject_id');
        $class_id = $this->input->get('class_id');
        $today_work_id = $this->input->get('today_work_id');
        $data['class_id']=$class_id = $this->input->get('class_id');
        $data['subject_name'] =$subject_name= $this->input->get('subject_name');
        $data['subject_id'] =$subject_id= $this->input->get('subject_id');
        $data['student_data'] = $this->Todayswork_model->getStudents($class_id,$subject_id);
        $data['subject_details'] = $this->Todayswork_model->getSubjectDetails($subject_id,$today_work_id);

        $data['getreportdata'] = $this->Todayswork_model->getSubjectWiseReportEdit($today_work_id);
        $data['getTodayWorkReport'] = $this->Todayswork_model->getTodayWorkReportSubjectWise($today_work_id);

        $postdata = $this->input->post();
        
            foreach ($postdata['student_id'] as $key => $student_id) {
                $student_work_report_id=$postdata['student_work_report_id'][$key];
                $updatetData= array(
                    'student_id'         => $student_id,
                    'student_name'       => $postdata['student_name'][$key],
                    'subject_id'         => $postdata['subject_id'][$key],
                    'subject_name'       => $postdata['subject_name'][$key],
                    'today_work_id'       => $postdata['today_work_id'][$key],
                    'class_id'           => $postdata['class_id'][$key],
                    'discipline_dress'   => $postdata['discipline_dress'][$key],
                    'discipline_conduct' => $postdata['discipline_conduct'][$key],
                    'fair_copy'          => $postdata['fair_copy'][$key],
                    'writing_work'       => $postdata['writing_work'][$key],
                    'learning_work'      => $postdata['learning_work'][$key],
                    'remarks'            => $postdata['remarks'][$key],
                );
                $resultData = $this->Todayswork_model->updateTodayStudentReport($updatetData,$student_work_report_id);

            }
        

            $updateTodayReport= array(
                'class_id'                     =>  $postdata['report_class_id'],
                'subject_id'                   =>  $postdata['report_subject_id'],
                'today_work_id'                   =>  $postdata['report_today_work_id'],
                'total_student'                 => $postdata['total_student'],
                'today_completed_work'          => $postdata['today_completed_work'],
                'today_uncompleted_work'        => $postdata['today_uncompleted_work'],
                'today_completed_percentage'    => $postdata['today_completed_percentage'],
                'today_uncompleted_percentage'  => $postdata['today_uncompleted_percentage'],
            );
            
        // echo "<pre>";
        // print_r($insertTodayReport);
        // die();
         $todayData= $this->Todayswork_model->updateTodayWorkReport($updateTodayReport,$postdata['today_work_report_id']);
        //}


        if (!empty($resultData)) {
            $result=$this->Todayswork_model->goForStudentWorkReport($today_work_id);
            
           // $classSubjectID = '?subject_id=' . $subject_id . '&class_id=' . $class_id. '&today_work_id=' . $today_work_id;

            $this->session->set_flashdata('msg', '<div class="alert alert-success">' . $this->lang->line('success_message') . '</div>');
            redirect('todaysworkreport/index');
        } else {
            $this->load->view('layout/header', $data);
            $this->load->view('todayswork/studentworkreportedit', $data);
            $this->load->view('layout/footer', $data);
        }
    }
}
