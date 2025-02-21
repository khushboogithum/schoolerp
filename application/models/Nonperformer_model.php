<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
date_default_timezone_set('Asia/Kolkata');

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

    public function nonPerformerStudent()
    {
        
        $this->db->select('student_work_report.*');
        $this->db->from('student_work_report');
        $this->db->where('date(created_at)', date('Y-m-d'));
        $query = $this->db->get();
        $results = $query->result_array();
        $student_data = array();
        foreach ($results as $key => $result) {
            $student_id = $result['student_id'];
            if ($result['fair_copy'] == 0 || $result['writing_work'] == 0 || $result['learning_work'] == 0 || $result['discipline_dress'] == 0 || $result['discipline_conduct'] == 0) {
                $student_data[]=$student_id;
            } 
        }
        // print_r($student_data);
        // die();
       $query= $this->db->select('classes.id AS `class_id`,student_session.id as student_session_id,students.id,classes.class,sections.id AS `section_id`,sections.section,students.id,students.admission_no, students.roll_no,students.admission_date,students.firstname,students.middlename,  students.lastname,students.image,students.mobileno,students.email ,students.state,students.city, students.pincode,students.religion,DATE(students.dob) as dob,students.current_address,students.permanent_address,IFNULL(students.category_id, 0) as `category_id`,IFNULL(categories.category, "") as `category`,students.adhar_no,students.samagra_id,students.bank_account_no,students.bank_name,students.ifsc_code , students.guardian_name, students.guardian_relation,students.guardian_phone,students.guardian_address,students.is_active,students.created_at ,students.updated_at,students.father_name,students.mother_name,students.app_key,students.parent_app_key,students.rte,students.gender')->from('students')
        ->join('student_session', 'student_session.student_id = students.id')
        ->join('classes', 'student_session.class_id = classes.id')
        ->join('sections', 'sections.id = student_session.section_id')
        ->join('categories', 'students.category_id = categories.id', 'left')
        ->where('students.is_active', 'yes')
        ->where_in('students.id', $student_data)
        ->group_By('students.id')
        ->order_By('students.admission_no', 'ASC')
        
        ->get(); 
        // echo $this->db->last_query();
        // die();
        $reuslt=$query->result_array();
        return $reuslt;
        

    }
}
