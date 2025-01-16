<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Todayswork_model extends MY_model
{
    public function __construct()
    {
        parent::__construct();
        $this->current_session = $this->setting_model->getCurrentSession();
        $this->current_session_name = $this->setting_model->getCurrentSessionName();
      
    }
    
    public function addTodaysClassWork($data, $teachingClassworkIds,$teachingHomeworkIds,$classnoteIds,$homenoteIds)
    {
        $this->db->trans_start();
        $this->db->trans_strict(false);
        // echo "<pre>";
        // print_r($data);
    //      echo "hello";
    //     print_r($homenoteIds);
    //    die();
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
    public function getLessionDetailsBySubjectId($subject_id){
        $this->db->select('lesson_diary.*');
        $this->db->from('lesson_diary');
        $this->db->where('lesson_diary.subject_id', $subject_id);
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result_array();
    }

    public function getLessionDetailsByLessionId($lession_id){
        $this->db->select('lesson_diary.*');
        $this->db->from('lesson_diary');
        $this->db->where('lesson_diary.lesson_id', $lession_id);
        $query = $this->db->get();
        // echo $this->db->last_query();
        // die();
        return $query->result_array();
    }
    public function getclasswork(){
        $this->db->select('teaching_activity.*');
        $this->db->from('teaching_activity');
        $this->db->where('teaching_activity.status', 1);
        $query = $this->db->get();
        // echo $this->db->last_query();
        // die();
        return $query->result_array();
    }
    public function getNotebookByClasswork($teaching_activity_id) {
        $this->db->select('note_book_type.note_book_type_id, note_book_type.note_book_title');
        $this->db->from('teaching_notebook');
        $this->db->join('note_book_type', 'teaching_notebook.note_book_type_id = note_book_type.note_book_type_id', 'left');
        $this->db->where_in('teaching_notebook.teaching_activity_id', $teaching_activity_id);
        $query = $this->db->get();
        //echo $this->db->last_query();
    
        return $query->result_array();
    }
    public function getNotebookByHomework($teaching_activity_home_work_id) {
        $this->db->select('note_book_type.note_book_type_id, note_book_type.note_book_title');
        $this->db->from('teaching_notebook');
        $this->db->join('note_book_type', 'teaching_notebook.note_book_type_id = note_book_type.note_book_type_id', 'left');
        $this->db->where_in('teaching_notebook.teaching_activity_id', $teaching_activity_home_work_id);
        $query = $this->db->get();
        //echo $this->db->last_query();
    
        return $query->result_array();
    }
    
    // public function add_lesson($data)
    // {
    //     // print_r($data);
    //     // die();
    //     $this->db->trans_start(); # Starting Transaction
    //     $this->db->trans_strict(false); # See Note 01. If you wish can remove as well
    //     //=======================Code Start===========================
    //     if (isset($data['lesson_id']) && $data['lesson_id'] != '') {
    //         $this->db->where('lesson_id', $data['lesson_id']);
    //         $query     = $this->db->update('lesson_diary', $data);
    //         $insert_id = $data['lesson_id'];
    //         $message   = UPDATE_RECORD_CONSTANT . " On lesson id " . $insert_id;
    //         $action    = "Update";
    //         $record_id = $insert_id;
    //     } else {

    //         // print_r($data);
    //         // die();
    //         $this->db->insert('lesson_diary', $data);
    //         //   echo  $this->db->last_query();
    //         //   die();
    //         $insert_id = $this->db->insert_id();
    //         $message   = INSERT_RECORD_CONSTANT . " On lesson id " . $insert_id;
    //         $action    = "Insert";
    //         $record_id = $insert_id;
    //     }

    //     $this->log($message, $record_id, $action);

    //     //======================Code End==============================

    //     $this->db->trans_complete(); # Completing transaction
    //     /* Optional */

    //     if ($this->db->trans_status() === false) {
    //         # Something went wrong.
    //         $this->db->trans_rollback();
    //         return false;
    //     } else {
    //         return $insert_id;
    //     }
    // }
    
    
}
