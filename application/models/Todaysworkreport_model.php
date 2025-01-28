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

    public function todaysWorkList($todays_date=NULL,$class_id=NULL,$section_id=NULL,$subject_group_id,$subject_id=NULL)
    {
        $today = date('Y-m-d');
        $this->db->select('today_work.today_work_id, today_work.work_date, today_work.subject_id, today_work.lesson_id, subjects.name as subject_name, today_work.lesson_name, lesson_diary.lesson_number');
        $this->db->from('today_work');
        $this->db->join("subjects", "subjects.id = today_work.subject_id");
        $this->db->join("lesson_diary", "lesson_diary.lesson_id = today_work.lesson_id");
        $this->db->where('today_work.today_status', '1');
        $this->db->where('today_work.status', '1');
        $this->db->where('DATE(today_work.work_date)', $today);
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
                $row['class_work'] = $this->getClassWorkData($row['today_work_id']);
                $row['home_work'] = $this->getHomeWorkData($row['today_work_id']);
                $row['total_lessons'] = $this->countLessonsBySubject($row['subject_id']);
            }
            return $result;
        } else {
            return [];
        }
    }

    public function countLessonsBySubject($subject_id)
    {
        $this->db->select('COUNT(*) as total_lessons');
        $this->db->from('lesson_diary');
        $this->db->where('subject_id', $subject_id);
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
    public function getHomeWorkData($today_work_id)
    {
        $this->db->select('today_home_work.teaching_activity_id, teaching_activity.teaching_activity_title');
        $this->db->from('today_home_work');
        $this->db->join('teaching_activity', 'teaching_activity.teaching_activity_id = today_home_work.teaching_activity_id');
        $this->db->where('today_home_work.today_work_id', $today_work_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getTodayReportData()
    {
       
        $finaldata = array();
        $this->db->select('student_work_report.*');
        $this->db->from('student_work_report');
        // $this->db->where('student_work_report.status', 1);
        $this->db->where('date(created_at)', date('Y-m-d'));
        $query = $this->db->get();

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
        return $finaldata;
    }

    public function getSubjectWiseReport(){
        $this->db->select('student_work_report.*');
        $this->db->from('student_work_report');
        $this->db->where('student_work_report.status', 1);
        $this->db->where('date(created_at)', date('Y-m-d'));

        $query = $this->db->get();
        $results = $query->result_array();
        $resultArray=array();
        $Complete=0;
        $totalstudent=0;
        $resultArray = [];
        foreach ($results as $key => $result) {
            
            $subjectName = $result['subject_name'];
            if (!isset($resultArray[$subjectName])) {
                $Complete = 0;
                $totalstudent=0; 
            } 
            
            if ($result['fair_copy'] == 1 && $result['writing_work'] == 1 && $result['learning_work'] == 1) {
                $Complete++;
                $totalstudent++; 
            }else{
              $totalstudent++;  
            }
            $resultArray[$subjectName] = [
                'complete' => $Complete,
                'totalstudent' => $totalstudent,
            ];
        }
        return $resultArray;
    }

    
}
