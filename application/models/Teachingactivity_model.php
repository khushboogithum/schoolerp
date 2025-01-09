<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Teachingactivity_model extends MY_model
{
    public function __construct()
    {

        parent::__construct();
        $this->current_session = $this->setting_model->getCurrentSession();

        $this->current_session_name = $this->setting_model->getCurrentSessionName();
        $this->start_month          = $this->setting_model->getStartMonth();
    }
    public function add_teachinActivity($data)
    {
 
        $this->db->trans_start(); # Starting Transaction
        $this->db->trans_strict(false); # See Note 01. If you wish can remove as well
        // print_r($data);
        // die();
            $this->db->insert('teaching_activity', $data);
        //   echo  $this->db->last_query();
        //   die();
            $insert_id = $this->db->insert_id();
            $message   = INSERT_RECORD_CONSTANT . " On lesson id " . $insert_id;
            $action    = "Insert";
            $record_id = $insert_id;
        

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

    public function update_teachingActivity($id,$data)
    {
        $this->db->trans_start(); # Starting Transaction
        $this->db->trans_strict(false); # See Note 01. If you wish can remove as well
        //=======================Code Start===========================
        if (isset($id) && $id != '') {
            $this->db->where('teaching_activity_id', $id);
            $query     = $this->db->update('teaching_activity', $data);
            $insert_id = $data['teaching_activity_id'];
            $message   = UPDATE_RECORD_CONSTANT . " On teaching_activity id " . $insert_id;
            $action    = "Update";
            $record_id = $insert_id;
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


    public function delete_teachingActivity($id,$data)
    {
        $this->db->trans_start(); # Starting Transaction
        $this->db->trans_strict(false); # See Note 01. If you wish can remove as well
        //=======================Code Start===========================
        if (isset($id) && $id != '') {
            $this->db->where('teaching_activity_id', $id);
            $query     = $this->db->update('teaching_activity', $data);
            $insert_id = $data['teaching_activity_id'];
            $message   = DELETE_RECORD_CONSTANT . " On teaching_activity id " . $insert_id;
            $action    = "Delete";
            $record_id = $insert_id;
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



    
    public function getByID($id = null)
    {
        $this->db->select('teaching_activity.*');
        $this->db->from('teaching_activity');
        $this->db->where('teaching_activity.teaching_activity_id', $id);
        $query = $this->db->get()->result_object();
        return $query;
    }

    public function teachingActivityList()
    {
        $this->db->select('teaching_activity.*, note_book_type.note_book_title as note_book_title');
        $this->db->from('teaching_activity');
        $this->db->join('note_book_type', 'note_book_type.note_book_type_id = teaching_activity.note_book_type_id', 'left');
        $this->db->where('teaching_activity.status', '1');
        $this->db->order_by('teaching_activity.teaching_activity_id', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }
    




}
