<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Studentworkreport_model extends MY_model
{
    public function __construct()
    {
        parent::__construct();
        $this->current_session = $this->setting_model->getCurrentSession();
        $this->current_session_name = $this->setting_model->getCurrentSessionName();
        $this->start_month          = $this->setting_model->getStartMonth();
    }

    public function getStudentMonthlyReport()
    {

        $finaldata = array();
        $this->db->select('student_work_report.*');
        $this->db->from('student_work_report');
        $this->db->where('student_work_report.student_id',12);
        $this->db->group_by('date(created_at)');
        $this->db->group_by('subject_id');
        $query = $this->db->get();
        // echo $this->db->last_query();
        // die();

        $results = $query->result_array();
        $subject_array = [];

        foreach ($results as $result) {
            $created_at = date('d-m-Y',strtotime($result['created_at']));
            $subject_name = trim($result['subject_name']);
            if (!isset($subject_array[$subject_name])) {
                $subject_array[$subject_name] = $subject_name;
            }

            $finaldata[$created_at][$subject_array[$subject_name]] = [
                'fair_copy' => $result['fair_copy'],
                'learning_work' => $result['learning_work'],
                'writing_work' => $result['writing_work'],
            ];

            $finaldata[$created_at]['discipline'] = [
                'dress' => $result['discipline_dress'],
                'conduct' => $result['discipline_conduct'],
            ];
        }
        // echo "<pre>";
        // print_r($finaldata);
        // die();
        return $finaldata;
    }

    public function getSubjectWiseReportMonthly()
    {
        $this->db->select('student_work_report.*');
        $this->db->from('student_work_report');
        // $this->db->where('student_work_report.status', 2);
        $this->db->where('date(created_at)', date('Y-m-d'));

        $query = $this->db->get();
        $results = $query->result_array();
        $resultArray = array();
        $Complete = 0;
        $totalstudent = 0;
        $resultArray = [];
        
        foreach ($results as $key => $result) {

            $subjectName = $result['subject_name'];
            $subject_id = $result['subject_id'];
            $class_id = $result['class_id'];
            if (!isset($resultArray[$subjectName])) {
                $Complete = 0;
                $totalstudent = 0;
            }

            if ($result['fair_copy'] == 1 && $result['writing_work'] == 1 && $result['learning_work'] == 1) {
                $Complete++;
                $totalstudent++;
            } else {
                $totalstudent++;
            }
            $resultArray[$subjectName] = [
                'subject_id' => $subject_id,
                'class_id' => $class_id,
                'complete' => $Complete,
                'totalstudent' => $totalstudent,
            ];
        }
        return $resultArray;
    }
}

