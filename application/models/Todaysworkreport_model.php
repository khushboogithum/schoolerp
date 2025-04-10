<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
date_default_timezone_set('Asia/Kolkata');

class Todaysworkreport_model extends MY_model
{

    public function __construct()
    {
        parent::__construct();
        $this->current_session = $this->setting_model->getCurrentSession();
        $this->current_session_name = $this->setting_model->getCurrentSessionName();
    }
    public function getLessionDetailsBySubjectId($subject_id)
    {
        $this->db->select('lesson_diary.*');
        $this->db->from('lesson_diary');
        $this->db->where('lesson_diary.subject_id', $subject_id);
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result_array();
    }

    public function getLessionDetailsByLessionId($lession_id)
    {
        $this->db->select('lesson_diary.*');
        $this->db->from('lesson_diary');
        $this->db->where('lesson_diary.lesson_id', $lession_id);
        $query = $this->db->get();
        // echo $this->db->last_query();
        // die();
        return $query->result_array();
    }
    public function getclasswork()
    {
        $this->db->select('teaching_activity.*');
        $this->db->from('teaching_activity');
        $this->db->where('teaching_activity.status', 1);
        $query = $this->db->get();
        // echo $this->db->last_query();
        // die();
        return $query->result_array();
    }
    public function getNotebookByClasswork($teaching_activity_id)
    {
        $this->db->select('note_book_type.note_book_type_id, note_book_type.note_book_title');
        $this->db->from('teaching_notebook');
        $this->db->join('note_book_type', 'teaching_notebook.note_book_type_id = note_book_type.note_book_type_id', 'left');
        $this->db->where_in('teaching_notebook.teaching_activity_id', $teaching_activity_id);
        $query = $this->db->get();
        //echo $this->db->last_query();

        return $query->result_array();
    }
    public function getNotebookByHomework($teaching_activity_home_work_id)
    {
        $this->db->select('note_book_type.note_book_type_id, note_book_type.note_book_title');
        $this->db->from('teaching_notebook');
        $this->db->join('note_book_type', 'teaching_notebook.note_book_type_id = note_book_type.note_book_type_id', 'left');
        $this->db->where_in('teaching_notebook.teaching_activity_id', $teaching_activity_home_work_id);
        $query = $this->db->get();
        //echo $this->db->last_query();

        return $query->result_array();
    }

    public function todaysWorkList($todays_date = NULL, $class_id = NULL, $section_id = NULL, $subject_group_id, $subject_id = NULL)
    {
        $today = date('Y-m-d');
        $this->db->select('today_work.today_work_id,today_work.class_id,today_work.work_date, today_work.subject_id, today_work.lesson_id, subjects.name as subject_name, today_work.lesson_name, lesson_diary.lesson_number');
        $this->db->from('today_work');
        $this->db->join("subjects", "subjects.id = today_work.subject_id");
        $this->db->join("lesson_diary", "lesson_diary.lesson_id = today_work.lesson_id");
        $this->db->where('today_work.today_status', '1');
        $this->db->where('today_work.status', '1');
      
        if (!empty($todays_date)) {
            $this->db->where('DATE(today_work.work_date)', $todays_date);
        }

        if (!empty($class_id)) {
            $this->db->where('today_work.class_id', $class_id);
        }
        if (!empty($section_id)) {
            $this->db->where('today_work.section_id', $section_id);
        }
        if (!empty($subject_group_id)) {
            $this->db->where('today_work.subject_group_id', $subject_group_id);
        }
        if (!empty($subject_id)) {
            $this->db->where('today_work.subject_id', $subject_id);
        }
        $query = $this->db->get();
        // echo $this->db->last_query();
        // die();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();

            foreach ($result as &$row) {
                $this->db->select('subject_timetable.staff_id');
                $this->db->from('subject_timetable');
                $this->db->join("subject_group_subjects", "subject_group_subjects.subject_group_id = subject_timetable.subject_group_id");
                $this->db->where('subject_timetable.class_id', $row['class_id']);
                $this->db->where('subject_group_subjects.subject_id', $row['subject_id']);
                $staff_query = $this->db->get();
                $staff_row = $staff_query->row_array();
                $row['staff_id'] = !empty($staff_row) ? $staff_row['staff_id'] : null;

                $row['class_work'] = $this->getClassWorkData($row['today_work_id']);
                $row['class_notebook'] = $this->getClassWorkNoteBookData($row['today_work_id']);
                $row['home_work'] = $this->getHomeWorkData($row['today_work_id']);
                $row['home_notebook'] = $this->getHomeWorkNoteBookData($row['today_work_id']);
                $row['total_lessons'] = $this->countLessonsBySubject($row['subject_id'], $row['class_id']);
                $row['studentWorkPerstange'] = $this->studentWorkPerstange($row['class_id'], $row['subject_id'], date('Y-m-d', strtotime($row['work_date'])));
            }

            $result;
        } else {
            [];
        }

        return $result;
    }
    public function insertWorkReport($data)
    {
        if (!empty($data)) {
            $this->db->trans_start();

            // $this->db->insert_batch('class_teacher_report', $data);
            // echo $this->db->last_query(); 
            foreach ($data as $key => $value) {
                $class_id = $value['class_id'];
                $subject_id = $value['subject_id'];
                $today_work_id = $value['today_work_id'];
                $today_date = $value['today_date'];
                $this->db->select('class_teacher_report.class_id');
                $this->db->from('class_teacher_report');
                $this->db->where('class_teacher_report.class_id', $class_id);
                $this->db->where('class_teacher_report.subject_id', $subject_id);
                $this->db->where('class_teacher_report.today_work_id', $today_work_id);
                $this->db->where('class_teacher_report.today_date', $today_date);
                $query = $this->db->get();
                $num_rows = $query->num_rows();

                if ($num_rows < 1) {
                    $this->db->insert('class_teacher_report', $data[$key]);
                    $insert_id = $this->db->insert_id();
                    $message   = INSERT_RECORD_CONSTANT . " On class_teacher_report id " . $insert_id;
                    $action    = "Insert";
                    $record_id = $insert_id;

                    $this->log($message, $record_id, $action);

                    $this->db->trans_complete();
                }
            }
            if ($this->db->trans_status() === false) {
                $this->db->trans_rollback();
                return false;
            } else {
                return $insert_id;
            }
        }
    }

    public function countLessonsBySubject($subject_id, $class_id)
    {
        $this->db->select('COUNT(*) as total_lessons');
        $this->db->from('lesson_diary');
        $this->db->where('subject_id', $subject_id);
        $this->db->where('class_id', $class_id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            return $result['total_lessons'];
        } else {
            return 0;
        }
    }
    public function getClassWorkData($today_work_id)
    {
        $this->db->select('today_class_work.teaching_activity_id, teaching_activity.teaching_activity_title');
        $this->db->from('today_class_work');
        $this->db->join('teaching_activity', 'teaching_activity.teaching_activity_id = today_class_work.teaching_activity_id');
        $this->db->where('today_class_work.today_work_id', $today_work_id);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function getClassWorkNoteBookData($today_work_id)
    {
        $this->db->select('class_work_note_book.class_work_note_book_id, note_book_type.note_book_title');
        $this->db->from('class_work_note_book');
        $this->db->join('note_book_type', 'note_book_type.note_book_type_id = class_work_note_book.note_book_type_id');
        $this->db->where('class_work_note_book.today_work_id', $today_work_id);
        $query = $this->db->get();
        // echo $this->db->last_query();
        // die();
        return $query->result_array();
    }
    public function getHomeWorkData($today_work_id)
    {
        $this->db->select('today_home_work.teaching_activity_id, teaching_activity.teaching_activity_title');
        $this->db->from('today_home_work');
        $this->db->join('teaching_activity', 'teaching_activity.teaching_activity_id = today_home_work.teaching_activity_id');
        $this->db->where('today_home_work.today_work_id', $today_work_id);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function getHomeWorkNoteBookData($today_work_id)
    {
        $this->db->select('home_work_note_book.home_work_note_book_id, note_book_type.note_book_title');
        $this->db->from('home_work_note_book');
        $this->db->join('note_book_type', 'note_book_type.note_book_type_id = home_work_note_book.note_book_type_id');
        $this->db->where('home_work_note_book.today_work_id', $today_work_id);
        $query = $this->db->get();
        // echo $this->db->last_query();
        // die();
        return $query->result_array();
    }

    public function getTodayReportData($classId,$subject_id,$today_work_id)
    {

        $finaldata = array();
        $this->db->select('student_work_report.*');
        $this->db->from('student_work_report');

       
        if (!empty($classId)) {
            $this->db->where('student_work_report.class_id', $classId);
        }
       
        if (!empty($subject_id)) {
            
            $this->db->where_in('student_work_report.subject_id', explode(',',$subject_id));
        }
        if (!empty($today_work_id)) {
            $this->db->where_in('student_work_report.today_work_id', explode(',',$today_work_id));
        }

        // $this->db->where('student_work_report.status', 1);
       // $this->db->where('date(created_at)', date('Y-m-d'));
        $query = $this->db->get();
        // echo $this->db->last_query();
        // die();

        $results = $query->result_array();
        $subject_array = [];

        foreach ($results as $result) {
            $student_name = trim($result['student_name']);
            $subject_name = trim($result['subject_name']);
            if (!isset($subject_array[$subject_name])) {
                $subject_array[$subject_name] = $subject_name;
            }

            $finaldata[$student_name][$subject_array[$subject_name]] = [
                'fair_copy' => $result['fair_copy'],
                'learning_work' => $result['learning_work'],
                'writing_work' => $result['writing_work'],
            ];

            $finaldata[$student_name]['discipline'] = [
                'dress' => $result['discipline_dress'],
                'conduct' => $result['discipline_conduct'],
            ];
        }
        // echo "<pre>";
        // print_r($finaldata);
        // die();
        return $finaldata;
    }

    public function getSubjectWiseReport($classId,$subject_id,$today_work_id)
    {
        $this->db->select('student_work_report.*');
        $this->db->from('student_work_report');
        if (!empty($classId)) {
            $this->db->where('student_work_report.class_id', $classId);
        }
       
        if (!empty($subject_id)) {
            
            $this->db->where_in('student_work_report.subject_id', explode(',',$subject_id));
        }
        if (!empty($today_work_id)) {
            $this->db->where_in('student_work_report.today_work_id', explode(',',$today_work_id));
        }
        // $this->db->where('student_work_report.status', 2);
       // $this->db->where('date(created_at)', date('Y-m-d'));

        $query = $this->db->get();
        $results = $query->result_array();
        $resultArray = array();
        $Complete = 0;
        $totalstudent = 0;
        $resultArray = [];
        
        foreach ($results as $key => $result) {

            $subjectName = $result['subject_name'];
            $subject_id = $result['subject_id'];
            $class_id = $result['class_id'];
            $today_work_id = $result['today_work_id'];
            if (!isset($resultArray[$subjectName])) {
                $Complete = 0;
                $totalstudent = 0;
            }

            if ($result['fair_copy'] == 1 && $result['writing_work'] == 1 && $result['learning_work'] == 1) {
                $Complete++;
                $totalstudent++;
            } else {
                $totalstudent++;
            }
            $resultArray[$subjectName] = [
                'subject_id' => $subject_id,
                'class_id' => $class_id,
                'today_work_id' => $today_work_id,
                'complete' => $Complete,
                'totalstudent' => $totalstudent,
            ];
        }
            // echo "<pre>";
            // print_r($resultArray);
            // die();
        return $resultArray;
    }
    public function studentWorkPerstange($class_id, $subject_id, $date)
    {
        $this->db->select('student_work_report.*');
        $this->db->from('student_work_report');
        // $this->db->where('student_work_report.status', 2);
        $this->db->where('student_work_report.class_id', $class_id);
        $this->db->where('student_work_report.subject_id', $subject_id);
        $this->db->where('date(created_at)', $date);

        $query = $this->db->get();
        $results = $query->result_array();
        $Complete = 0;
        $totalstudent = 0;
        foreach ($results as $key => $result) {

            if ($result['fair_copy'] == 1 && $result['writing_work'] == 1 && $result['learning_work'] == 1) {
                $Complete++;
            }
            $totalstudent++;
        }
        if ($totalstudent > 0) {
            $result = round(($Complete / $totalstudent) * 100, 2);
        } else {
            $result = 0;
        }
        return $result;
    }

    public function ApproveStudentWorkReport($class_id,$today_work_id, $data)
    {

      //  $this->db->trans_start(); # Starting Transaction
      //  $this->db->trans_strict(false); # See Note 01. If you wish can remove as well
        //=======================Code Start===========================
        if (isset($class_id) && $class_id != '') {
            $this->db->where('class_id', $class_id);
            $this->db->where_in('today_work_id', $today_work_id);
            // $this->db->where('date(created_at)', date('Y-m-d'));
            $query     = $this->db->update('student_work_report', $data);
            // echo $this->db->last_query();
            // die();
            $insert_id = $class_id;
            $message   = UPDATE_RECORD_CONSTANT . " On student_work_report id " . $insert_id;
            $action    = "update";
            $record_id = $insert_id;
            $this->db->where('class_id', $class_id);
        }

        $this->log($message, $record_id, $action);

        //======================Code End==============================

        $this->db->trans_complete(); # Completing transaction
        /* Optional */

        if ($this->db->trans_status() === false) {
            # Something went wrong.
            $this->db->trans_rollback();
            return false;
        } else {
            return $insert_id;
        }
    }
    public function insertSubjectReport($data)
    {
        if (!empty($data)) {
            $this->db->trans_start();
            // $this->db->insert_batch('class_teacher_report', $data);
            // echo $this->db->last_query(); 
            foreach ($data as $key => $value) {
                $class_id = $value['class_id'];
                $subject_id = $value['subject_id'];
                $today_work_id = $value['today_work_id'];
                $this->db->select('subject_wise_report.class_id');
                $this->db->from('subject_wise_report');
                $this->db->where('subject_wise_report.class_id', $class_id);
                $this->db->where('subject_wise_report.subject_id', $subject_id);
                $this->db->where('subject_wise_report.today_work_id', $today_work_id);
                // $this->db->where('subject_wise_report.today_date', date('Y-m-d'));
                $query = $this->db->get();
                $num_rows = $query->num_rows();

                if ($num_rows < 1) {
                    $this->db->insert('subject_wise_report', $data[$key]);
                    $insert_id = $this->db->insert_id();
                    $message   = INSERT_RECORD_CONSTANT . " On subject_wise_report id " . $insert_id;
                    $action    = "Insert";
                    $record_id = $insert_id;

                    $this->log($message, $record_id, $action);

                    $this->db->trans_complete();
                }
            }
            if ($this->db->trans_status() === false) {
                $this->db->trans_rollback();
                return false;
            } else {
                return $insert_id;
            }
        }
    }
    public function insertClassReport($data)
    {
      
        $class_id = $data['class_id'];
       // $this->db->trans_start(); # Starting Transaction
       // $this->db->trans_strict(false); # See Note 01. If you wish can remove as well
        //=======================Code Start===========================
        $this->db->select('class_wise_report.class_id');
        $this->db->from('class_wise_report');
        $this->db->where('class_wise_report.class_id', $class_id);
        $this->db->where('class_wise_report.today_date', date('Y-m-d'));
        $query = $this->db->get();
        // echo  $this->db->last_query();
        // die();
        $num_rows = $query->num_rows();

        if ($num_rows < 1) {
            $this->db->insert('class_wise_report', $data);
            //   echo  $this->db->last_query();
            //   die();
            $insert_id = $this->db->insert_id();
            $message   = INSERT_RECORD_CONSTANT . " On class_wise_report id " . $insert_id;
            $action    = "Insert";
            $record_id = $insert_id;

            $this->log($message, $record_id, $action);
            $this->db->trans_complete(); # Completing transaction
        }
        //======================Code End==============================
        /* Optional */
        if ($this->db->trans_status() === false) {
            # Something went wrong.
            $this->db->trans_rollback();
            return false;
        } else {
            return $insert_id;
        }
    }
}
