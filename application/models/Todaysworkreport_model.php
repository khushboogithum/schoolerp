<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

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

    public function todaysWorkList()
    {
        $today = date('Y-m-d');
        $this->db->select('today_work.today_work_id, today_work.work_date, today_work.subject_id, today_work.lesson_id, subjects.name as subject_name, today_work.lesson_name, lesson_diary.lesson_number');
        $this->db->from('today_work');
        $this->db->join("subjects", "subjects.id = today_work.subject_id");
        $this->db->join("lesson_diary", "lesson_diary.lesson_id = today_work.lesson_id");
        $this->db->where('today_work.today_status', '1');
        $this->db->where('today_work.status', '1');
        $this->db->where('DATE(today_work.work_date)', $today);
        $query = $this->db->get();
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

    
}
