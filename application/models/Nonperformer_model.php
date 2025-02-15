<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Nonperformer_model extends MY_model
{
    public function __construct()
    {
        parent::__construct();
        $this->current_session = $this->setting_model->getCurrentSession();
        $this->current_session_name = $this->setting_model->getCurrentSessionName();
        $this->start_month          = $this->setting_model->getStartMonth();
    }

    public function getClassPercentageToday()
    {
        $this->db->select('class_wise_report.class_id,class_wise_report.class_percentage')
            ->from('class_wise_report');
        $this->db->where("class_wise_report.today_date", date('Y-m-d'));
        $query = $this->db->get();
        $result = $query->result_array();
        $classPercentage = [];
        foreach ($result as $key => $results) {
            $classPercentage[$results['class_id']] = $results['class_percentage'] . '%';
        }
        return $classPercentage;
    }
    public function getClassSubjectPercentage()
    {
        $this->db->select('AVG(subject_wise_report.subject_percentage) as subject_percentage,subjects.name as subject_name,subjects.id')
            ->from('subject_wise_report');
        $this->db->join('subjects', 'subjects.id = subject_wise_report.subject_id');
        $this->db->where("subject_wise_report.today_date", date('Y-m-d'));
        $this->db->group_by("subject_wise_report.subject_id");
        $query = $this->db->get();
        $result = $query->result_array();
         return $result; 
    }
}
