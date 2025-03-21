<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class lessondiary_model extends MY_model
{
    public function __construct()
    {
        parent::__construct();
        $this->current_session = $this->setting_model->getCurrentSession();

        $this->current_session_name = $this->setting_model->getCurrentSessionName();
        $this->start_month          = $this->setting_model->getStartMonth();
    }

    public function add_lesson($data)
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

            // print_r($data);
            // die();
            $this->db->insert('lesson_diary', $data);
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
    public function get()
    {
        $this->db->select('lesson_diary.*, classes.class, sections.section, subjects.name as subject_name,subject_groups.name as subject_group');
        $this->db->from('lesson_diary');
        $this->db->join('classes', 'classes.id = lesson_diary.class_id', 'left');
        $this->db->join('sections', 'sections.id = lesson_diary.section_id', 'left');
        $this->db->join('subjects', 'subjects.id = lesson_diary.subject_id', 'left');
        $this->db->join('subject_groups', 'subject_groups.id = lesson_diary.subject_group_id', 'left');
        $this->db->where('lesson_diary.status', 1);
        $this->db->group_by('lesson_diary.section_id');
        $this->db->group_by('lesson_diary.class_id');
        $this->db->order_by('lesson_diary.class_id', 'ASC');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function getviewsubjectgroup($classId,$sectionId)
    {
        $this->db->select('lesson_diary.*, classes.class, sections.section, subjects.name as subject_name,subject_groups.name as subject_group');
        $this->db->from('lesson_diary');
        $this->db->join('classes', 'classes.id = lesson_diary.class_id', 'left');
        $this->db->join('sections', 'sections.id = lesson_diary.section_id', 'left');
        $this->db->join('subjects', 'subjects.id = lesson_diary.subject_id', 'left');
        $this->db->join('subject_groups', 'subject_groups.id = lesson_diary.subject_group_id', 'left');
        $this->db->where('lesson_diary.status', 1);
        $this->db->where('lesson_diary.class_id',$classId);
        $this->db->where('lesson_diary.section_id',$sectionId);
        $this->db->group_by('lesson_diary.subject_group_id');
        $this->db->group_by('lesson_diary.subject_id');
        $this->db->order_by('lesson_diary.subject_group_id', 'ASC');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function viewlessionBysubjectgroup($subject_group_id,$subject_id)
    {
        $this->db->select('lesson_diary.*, classes.class, sections.section, subjects.name as subject_name,subject_groups.name as subject_group');
        $this->db->from('lesson_diary');
        $this->db->join('classes', 'classes.id = lesson_diary.class_id', 'left');
        $this->db->join('sections', 'sections.id = lesson_diary.section_id', 'left');
        $this->db->join('subjects', 'subjects.id = lesson_diary.subject_id', 'left');
        $this->db->join('subject_groups', 'subject_groups.id = lesson_diary.subject_group_id', 'left');
        $this->db->where('lesson_diary.status', 1);
        $this->db->where('lesson_diary.subject_group_id',$subject_group_id);
        $this->db->where('lesson_diary.subject_id',$subject_id);
        // $this->db->group_by('lesson_diary.subject_group_id');
        // $this->db->group_by('lesson_diary.subject_id');
        $this->db->order_by('lesson_diary.subject_group_id', 'ASC');

        $query = $this->db->get();
        return $query->result_array();
    }
   
    
    public function remove($id)
    {
        $this->db->where('lesson_id', $id); 
        $this->db->update('lesson_diary', ['status' => 0]);
    }
    public function get_lesson_by_id($id)
    {
        $this->db->select('lesson_diary.*, classes.class, sections.section, subjects.name as subject_name');
        $this->db->from('lesson_diary');
        $this->db->join('classes', 'classes.id = lesson_diary.class_id', 'left');
        $this->db->join('sections', 'sections.id = lesson_diary.section_id', 'left');
        $this->db->join('subjects', 'subjects.id = lesson_diary.subject_id', 'left');
        $this->db->join('subject_group_subjects', 'subject_group_subjects.id = lesson_diary.subject_group_id', 'left');
        $this->db->where('lesson_diary.lesson_id', $id);
    
        $query = $this->db->get();
        return $query->row_array();
    }


    public function getLessionByClassIdsectionId($classId,$sectionId)
    {
        $this->db->select('lesson_diary.*, classes.class, sections.section, subjects.name as subject_name,subject_groups.name as subject_group');
        $this->db->from('lesson_diary');
        $this->db->join('classes', 'classes.id = lesson_diary.class_id', 'left');
        $this->db->join('sections', 'sections.id = lesson_diary.section_id', 'left');
        $this->db->join('subjects', 'subjects.id = lesson_diary.subject_id', 'left');
        $this->db->join('subject_groups', 'subject_groups.id = lesson_diary.subject_group_id', 'left');
        $this->db->where('lesson_diary.status', 1);
        $this->db->where('lesson_diary.class_id',$classId);
        $this->db->where('lesson_diary.section_id',$sectionId);
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getLessionBysubjectGroup($subject_group_id,$subject_id)
    {
        $this->db->select('lesson_diary.*, classes.class, sections.section, subjects.name as subject_name,subject_groups.name as subject_group');
        $this->db->from('lesson_diary');
        $this->db->join('classes', 'classes.id = lesson_diary.class_id', 'left');
        $this->db->join('sections', 'sections.id = lesson_diary.section_id', 'left');
        $this->db->join('subjects', 'subjects.id = lesson_diary.subject_id', 'left');
        $this->db->join('subject_groups', 'subject_groups.id = lesson_diary.subject_group_id', 'left');
        $this->db->where('lesson_diary.status', 1);
        $this->db->where('lesson_diary.subject_group_id',$subject_group_id);
        $this->db->where('lesson_diary.subject_id',$subject_id);
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getSectionListClassId($class_id)
    {
        $this->db->select('class_sections.class_id,class_sections.section_id,sections.section,sections.id');
        $this->db->from('class_sections');
        $this->db->join('sections', 'sections.id = class_sections.section_id', 'left');
        $this->db->where('class_sections.class_id', $class_id);
        $query = $this->db->get();
        // echo $this->db->last_query();
        // die();
        return $query->result_array();
    }

    public function getSubjectGroupBySectionId($section_id)
    {
        $this->db->select('subject_group_class_sections.subject_group_id,subject_group_class_sections.class_section_id,subject_groups.name,subject_groups.id');
        $this->db->from('subject_group_class_sections');
        $this->db->join('subject_groups', 'subject_groups.id = subject_group_class_sections.subject_group_id', 'left');
        $this->db->where('subject_group_class_sections.class_section_id', $section_id);
        $query = $this->db->get();
        echo $this->db->last_query();
        die();
        return $query->result_array();
    }
}

