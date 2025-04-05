<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
$tz = 'Asia/Kolkata';
date_default_timezone_set($tz);


class Todayswork_model extends MY_model
{
    public function __construct()
    {
        parent::__construct();
        $this->current_session = $this->setting_model->getCurrentSession();
        $this->current_session_name = $this->setting_model->getCurrentSessionName();
    }

    public function addTodaysClassWork($data, $teachingClassworkIds, $teachingHomeworkIds, $classnoteIds, $homenoteIds)
    {
        $this->db->trans_start();
        $this->db->trans_strict(false);

        $this->db->insert('today_work', $data);
        $today_work_id = $this->db->insert_id();
        // echo $this->db->last_query();
        // die();

        $message   = INSERT_RECORD_CONSTANT . " On today work id " . $today_work_id;
        $action    = "Insert";
        $record_id = $today_work_id;
        $this->log($message, $record_id, $action);

        $classWorkData = [];
        foreach ($teachingClassworkIds as $teachingClassworkId) {
            $classWorkData[] = [
                'today_work_id' => $today_work_id,
                'teaching_activity_id'    => $teachingClassworkId,
            ];
        }

        if (!empty($classWorkData)) {
            $this->db->insert_batch('today_home_work', $classWorkData);
        }
        $homeWorkData = [];
        foreach ($teachingHomeworkIds as $teachingHomeworkId) {
            $homeWorkData[] = [
                'today_work_id' => $today_work_id,
                'teaching_activity_id'    => $teachingHomeworkId,
            ];
        }


        if (!empty($homeWorkData)) {
            $this->db->insert_batch('today_class_work', $homeWorkData);
        }
        $classNotebookData = [];
        foreach ($classnoteIds as $classnoteId) {
            $classNotebookData[] = [
                'today_work_id' => $today_work_id,
                'note_book_type_id'    => $classnoteId,
            ];
        }

        if (!empty($classNotebookData)) {
            $this->db->insert_batch('class_work_note_book', $classNotebookData);
        }

        $homeNoteBookData = [];
        foreach ($homenoteIds as $homenoteId) {
            $homeNoteBookData[] = [
                'today_work_id' => $today_work_id,
                'note_book_type_id'    => $homenoteId,
            ];
        }

        if (!empty($homeNoteBookData)) {
            $this->db->insert_batch('home_work_note_book', $homeNoteBookData);
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === false) {

            $this->db->trans_rollback();
            return false;
        } else {
            return $today_work_id;
        }
    }
    public function getLessionDetailsBySubjectId($subject_id, $class_id)
    {
        $this->db->select('lesson_diary.*');
        $this->db->from('lesson_diary');
        $this->db->where('lesson_diary.subject_id', $subject_id);
        $this->db->where('lesson_diary.class_id', $class_id);
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
        if (!empty($teaching_activity_id) && is_array($teaching_activity_id)) {
            $this->db->select('note_book_type.note_book_type_id, note_book_type.note_book_title');
            $this->db->from('teaching_notebook');
            $this->db->join('note_book_type', 'teaching_notebook.note_book_type_id = note_book_type.note_book_type_id', 'left');
            $this->db->where_in('teaching_notebook.teaching_activity_id', $teaching_activity_id);
            $query = $this->db->get();
            // echo $this->db->last_query();


            return $query->result_array();
        } else {
            return [];
        }
    }
    public function getNotebookByHomework($teaching_activity_home_work_id)
    {
        if (!empty($teaching_activity_home_work_id) && is_array($teaching_activity_home_work_id)) {
            $this->db->select('note_book_type.note_book_type_id, note_book_type.note_book_title');
            $this->db->from('teaching_notebook');
            $this->db->join('note_book_type', 'teaching_notebook.note_book_type_id = note_book_type.note_book_type_id', 'left');
            $this->db->where_in('teaching_notebook.teaching_activity_id', $teaching_activity_home_work_id);
            $query = $this->db->get();
            //echo $this->db->last_query();
            return $query->result_array();
        } else {
            return [];
        }
    }
    public function todaysWorkList()
    {
        $today = date('Y-m-d');
        $this->db->select('today_work.today_work_id, today_work.work_date,today_work.class_id, today_work.subject_id, today_work.lesson_id, subjects.name as subject_name, today_work.lesson_name, lesson_diary.lesson_number');
        $this->db->from('today_work');
        $this->db->join("subjects", "subjects.id = today_work.subject_id");
        $this->db->join("lesson_diary", "lesson_diary.lesson_id = today_work.lesson_id");
        //$this->db->where('today_work.today_status', '0');
        $this->db->where('today_work.status', '1');
        $this->db->where('DATE(today_work.work_date)', $today);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            foreach ($result as &$row) {
                $row['class_work'] = $this->getClassWorkData($row['today_work_id']);
                $row['class_notebook'] = $this->getClassWorkNoteBookData($row['today_work_id']);
                $row['home_work'] = $this->getHomeWorkData($row['today_work_id']);
                $row['home_notebook'] = $this->getHomeWorkNoteBookData($row['today_work_id']);
                $row['total_lessons'] = $this->countLessonsBySubject($row['subject_id'], $row['class_id']);
            }
            return $result;
        } else {
            return [];
        }
    }
    public function getlessonnumber($lesson_id)
    {
        $this->db->select('lesson_number');
        $this->db->from('lesson_diary');
        $this->db->where('lesson_id', $lesson_id);
        $query = $this->db->get();
        $result = $query->row_array();
        return $result['lesson_number'];
    }
    public function countLessonsBySubject($subject_id, $class_id)
    {
        $this->db->select('COUNT(*) as total_lessons');
        $this->db->from('lesson_diary');
        $this->db->where('subject_id', $subject_id);
        $this->db->where('class_id', $class_id);
        $query = $this->db->get();
        // echo  $this->db->last_query();
        // die();
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

    public function goForStudentWorkReport($today_work_id)
    {
       
        //=======================Code Start===========================
        if (isset($today_work_id) && !empty($today_work_id)) {
            $id_list = explode(",", $today_work_id);
            $data = [
                'today_status' => 1,
            ];
            $this->db->where_in('today_work_id', $id_list);
            $result = $this->db->update('today_work', $data);
            return $result;
        } else {

            return false;
        }
    
        
    }
    //Student Report
    public function getStudents($class_id, $subject_id)
    {
        $this->db->select('classes.id AS `class_id`,classes.class as class_name, student_session.id as student_session_id, students.id, students.firstname, students.middlename, students.lastname')
            ->from('students')
            ->join('student_session', 'student_session.student_id = students.id')
            ->join('classes', 'student_session.class_id = classes.id')
            ->where('student_session.class_id', $class_id)
            ->where('students.is_active', 'yes')
            ->where("students.id NOT IN (SELECT student_id FROM student_work_report where date(created_at)='" . date('Y-m-d') . "' and subject_name in(" . $subject_id . "))", NULL, FALSE)
            ->order_by('students.firstname', 'ASC')
             ->limit(2);
        $query = $this->db->get();
        // echo $this->db->last_query();
        // die();

        return $query->result_array();
    }

    public function getSubjectDetails($subject_id){
        $subject_id=explode(",",$subject_id);

        $this->db->select('subjects.id AS `subject_id`,subjects.name')
            ->from('subjects')
            ->where_in('subjects.id', $subject_id)
            ->order_by('subjects.name', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
        
    }

    public function insertTodayStudentReport($data)
    {

        $this->db->trans_start();
        $this->db->trans_strict(false);

        // $this->db->insert('student_work_report', $data);
        $this->db->insert_batch('student_work_report', $data);
        $student_work_report_id = $this->db->insert_id();

        // echo $this->db->last_query();
        // die();

        $message   = INSERT_RECORD_CONSTANT . " On student work report  id " . $student_work_report_id;
        $action    = "Insert";
        $record_id = $student_work_report_id;
        $this->log($message, $record_id, $action);
        $this->db->trans_complete();

        if ($this->db->trans_status() === false) {

            $this->db->trans_rollback();
            return false;
        } else {
            return $student_work_report_id;
        }
    }

    public function insertTodayWorkReport($data)
    {
        $this->db->trans_start();
        $this->db->trans_strict(false);

        // Since $data is a single record, use insert() instead of insert_batch()
       $this->db->insert('today_work_report', $data);
      
        // echo $this->db->last_query();
        // die();
        $today_work_report_id = $this->db->insert_id();

        // Logging the insert action
        $message   = INSERT_RECORD_CONSTANT . " On today work report ID " . $today_work_report_id;
        $action    = "Insert";
        $record_id = $today_work_report_id;
        $this->log($message, $record_id, $action);

        $this->db->trans_complete();

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            return $today_work_report_id;
        }
    }


    public function getclassworkid($today_work_id)
    {
        $this->db->select('today_work.*');
        $this->db->from('today_work');
        $this->db->where('today_work.today_work_id', $today_work_id);
        $query = $this->db->get();
        // echo $this->db->last_query();
        // die();
        return $query->row_array();
    }

    public function getLessionId($class_id,$subject_id,$lession_number)
    {
        $this->db->select('lesson_id');
        $this->db->from('lesson_diary');
        $this->db->where('class_id', $class_id);
        $this->db->where('subject_id', $subject_id);
        $this->db->where('lesson_number', $lession_number);
        $query = $this->db->get();
        $result = $query->row_array();
        return $result['lesson_id'];
    }
}
