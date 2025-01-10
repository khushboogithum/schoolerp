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
    // public function add_teachinActivity($data)
    // {

    //     $this->db->trans_start(); # Starting Transaction
    //     $this->db->trans_strict(false); # See Note 01. If you wish can remove as well
    //         $this->db->insert('teaching_activity', $data);

    //         $insert_id = $this->db->insert_id();
    //         $message   = INSERT_RECORD_CONSTANT . " On lesson id " . $insert_id;
    //         $action    = "Insert";
    //         $record_id = $insert_id;


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
    public function addTeachingActivityWithNotebooks($data, $notebookIds)
    {
        $this->db->trans_start();
        $this->db->trans_strict(false);

        $this->db->insert('teaching_activity', $data);
        $teaching_activity_id = $this->db->insert_id();

        $message   = INSERT_RECORD_CONSTANT . " On lesson id " . $teaching_activity_id;
        $action    = "Insert";
        $record_id = $teaching_activity_id;
        $this->log($message, $record_id, $action);

        $notebookData = [];
        foreach ($notebookIds as $notebookId) {
            $notebookData[] = [
                'teaching_activity_id' => $teaching_activity_id,
                'note_book_type_id'    => $notebookId,
            ];
        }

        if (!empty($notebookData)) {
            $this->db->insert_batch('teaching_notebook', $notebookData);
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === false) {

            $this->db->trans_rollback();
            return false;
        } else {
            return $teaching_activity_id;
        }
    }

    public function update_teachingActivity($id, $data, $notebookIds)
    {
        $this->db->trans_start(); # Starting Transaction
        $this->db->trans_strict(false);

        if (isset($id) && $id != '') {
            $this->db->where('teaching_activity_id', $id);
            $query = $this->db->update('teaching_activity', $data);
            $insert_id = $data['teaching_activity_id'];
            $message = UPDATE_RECORD_CONSTANT . " On teaching_activity id " . $insert_id;
            $action = "Update";
            $record_id = $insert_id;
            
        $this->db->where('teaching_activity_id', $id);
        $this->db->delete('teaching_notebook');
        }

        $this->log($message, $record_id, $action);


        if (!empty($notebookIds)) {
            $notebookData = [];
            foreach ($notebookIds as $notebookId) {
                $notebookData[] = [
                    'teaching_activity_id' => $id,
                    'note_book_type_id'    => $notebookId,
                ];
            }

            $this->db->insert_batch('teaching_notebook', $notebookData);
        }

        $this->db->trans_complete(); 

        /* Optional */
        if ($this->db->trans_status() === false) {
            
            $this->db->trans_rollback();
            return false;
        } else {
            return $insert_id;
        }
    }

    // public function update_teachingActivity($id, $data)
    // {
    //     $this->db->trans_start(); # Starting Transaction
    //     $this->db->trans_strict(false); # See Note 01. If you wish can remove as well
    //     //=======================Code Start===========================
    //     if (isset($id) && $id != '') {
    //         $this->db->where('teaching_activity_id', $id);
    //         $query     = $this->db->update('teaching_activity', $data);
    //         $insert_id = $data['teaching_activity_id'];
    //         $message   = UPDATE_RECORD_CONSTANT . " On teaching_activity id " . $insert_id;
    //         $action    = "Update";
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


    public function delete_teachingActivity($id, $data)
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
            $this->db->where('teaching_activity_id', $id);
            $this->db->delete('teaching_notebook');
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

    public function teachingActivityList($id=null)
    {
        $this->db->select('teaching_activity.*');
        $this->db->from('teaching_activity');
        if($id!=null){  
             $this->db->where('teaching_activity.teaching_activity_id',$id);
        }
        $this->db->where('teaching_activity.status', '1');
        $this->db->order_by('teaching_activity.teaching_activity_id', 'DESC');
        $query = $this->db->get();
        $result=$query->result_array();
        $finalArray=array();
        foreach($result as $key=>$results){
            $resultdata=array();
            $resultdata['teaching_activity_id']=$results['teaching_activity_id'];
            $resultdata['teaching_activity_title']=$results['teaching_activity_title'];
            $resultdata['remark']=$results['remark'];
            $resultdata['status']=$results['status'];
            $resultdata['created_by']=$results['created_by'];
            $resultdata['created_at']=$results['created_at'];
            $resultdata['note_book_type']=$this->getNoteBookData($results['teaching_activity_id']);
            $finalArray[]=$resultdata;
        }
        
        return $finalArray;
        // echo "<pre>";
        // print_r($finalArray);
        // die();
    }

    public function getNoteBookData($teaching_notebook_id)
    {
        $this->db->select('teaching_notebook.teaching_notebook_id,teaching_notebook.teaching_activity_id,teaching_notebook.note_book_type_id,note_book_type.note_book_title')->from('teaching_notebook');
        $this->db->join('note_book_type', 'note_book_type.note_book_type_id = teaching_notebook.note_book_type_id');
        $this->db->where('teaching_notebook.teaching_activity_id', $teaching_notebook_id);
        $this->db->order_by('teaching_notebook.teaching_notebook_id', 'DESC');
        $query = $this->db->get();
        // echo $this->db->last_query();
        return $vehicle_routes = $query->result_array();
    }
}
