<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Notebooktype_model extends MY_model
{
    public function __construct()
    {
        parent::__construct();
        $this->current_session = $this->setting_model->getCurrentSession();

        $this->current_session_name = $this->setting_model->getCurrentSessionName();
        $this->start_month          = $this->setting_model->getStartMonth();
    }

    public function add_notebooktype($data)
    {
        // print_r($data);
        // die();
        $this->db->trans_start(); # Starting Transaction
        $this->db->trans_strict(false); # See Note 01. If you wish can remove as well
        //=======================Code Start===========================
        if (isset($data['lesson_id']) && $data['lesson_id'] != '') {
            $this->db->where('lesson_id', $data['lesson_id']);
            $query     = $this->db->update('lesson_diary', $data);
            $insert_id = $data['lesson_id'];
            $message   = UPDATE_RECORD_CONSTANT . " On lesson id " . $insert_id;
            $action    = "Update";
            $record_id = $insert_id;
        } else {
            $this->db->insert('note_book_type', $data);
        //   echo  $this->db->last_query();
        //   die();
            $insert_id = $this->db->insert_id();
            $message   = INSERT_RECORD_CONSTANT . " On lesson id " . $insert_id;
            $action    = "Insert";
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

    public function update_notebooktype($id,$data)
    {
        $this->db->trans_start(); # Starting Transaction
        $this->db->trans_strict(false); # See Note 01. If you wish can remove as well
        //=======================Code Start===========================
        if (isset($id) && $id != '') {
            $this->db->where('note_book_type_id', $id);
            $query     = $this->db->update('note_book_type', $data);
            $insert_id = $data['note_book_type_id'];
            $message   = UPDATE_RECORD_CONSTANT . " On note_book_type id " . $insert_id;
            $action    = "Update";
            $record_id = $insert_id;
        } else {
            $this->db->insert('note_book_type', $data);
        //   echo  $this->db->last_query();
        //   die();
            $insert_id = $this->db->insert_id();
            $message   = INSERT_RECORD_CONSTANT . " On lesson id " . $insert_id;
            $action    = "Insert";
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

    public function removeNoteBook($id,$data){
        $this->db->where('note_book_type_id', $id);
        $query     = $this->db->update('note_book_type', $data);
     
    }

    public function getByID($id = null)
    {
        $this->db->select('note_book_type.*')->from('note_book_type');
        if ($id != null) {
            $this->db->where('note_book_type.note_book_type_id', $id);
        } else {
            $this->db->order_by('note_book_type.note_book_type_id', 'DESC');
        }

        
        $query = $this->db->get()->result_object();
            return $query;
    }

    public function listNoteBookDairy()
    {
        return $this->db->select('*')->from('note_book_type')->where('status','1')->order_by('note_book_type_id','DESC')->get()->result_object();
    }

}
