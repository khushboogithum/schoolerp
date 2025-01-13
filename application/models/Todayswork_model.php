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
