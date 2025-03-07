<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Ptm_model extends MY_model
{
    public function __construct()
    {
        parent::__construct();
        $this->current_session = $this->setting_model->getCurrentSession();
        $this->current_session_name = $this->setting_model->getCurrentSessionName();
        $this->start_month          = $this->setting_model->getStartMonth();
    }

    public function getStudentMonthlyReport($student_id,$from_date,$to_date)
    {
        if($from_date!='' && $to_date!=''){
            $start_date = date("Y-m-d",strtotime($from_date));
            $end_date = date("Y-m-d",strtotime($to_date));
        }else{
            $start_date = date("Y-m-d", strtotime("first day of last month"));
            $end_date = date("Y-m-d", strtotime("last day of last month"));

        }

        $finaldata = array();
        if($student_id!=''){
            $this->db->select('student_work_report.*');
            $this->db->from('student_work_report');
            $this->db->where('student_work_report.student_id',$student_id);
            $this->db->where('date(created_at) >=', $start_date);
            $this->db->where('date(created_at) <=', $end_date);
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

        }
        
        // echo "<pre>";
        // print_r($finaldata);
        // die();
        return $finaldata;
    }

    public function getSubjectWiseReportMonthly($student_id,$from_date,$to_date)
    {
        if($from_date!='' && $to_date!=''){
            $start_date = date("Y-m-d",strtotime($from_date));
            $end_date = date("Y-m-d",strtotime($to_date));
        }else{
            $start_date = date("Y-m-d", strtotime("first day of last month"));
            $end_date = date("Y-m-d", strtotime("last day of last month"));

        }
        $resultArray = array();
        $Complete = 0;
        $totalstudent = 0;
        $withoutDress=0;
        $bedconduct=0;
        if($student_id!=''){
        $this->db->select('student_work_report.*');
        $this->db->from('student_work_report');
        $this->db->where('student_work_report.student_id',$student_id);
        $this->db->where('date(created_at) >=', $start_date);
        $this->db->where('date(created_at) <=', $end_date);
        $this->db->group_by('subject_id');
        $this->db->group_by('date(created_at)');
        $query = $this->db->get();

        $results = $query->result_array();
        foreach ($results as $key => $result) {

            $subjectName = trim($result['subject_name']);
            $subject_id = $result['subject_id'];
            $class_id = $result['class_id'];
            if (!isset($resultArray[$subjectName])) {
                $Complete = 0;
                $totalstudent = 0;
            }

            if($result['discipline_dress'] == 0){
                    $withoutDress++;
            }

            if($result['discipline_conduct'] == 0){
                $bedconduct++;
            }   

            if ($result['fair_copy'] == 1 && $result['writing_work'] == 1 && $result['learning_work'] == 1) {
                $Complete++;
                $totalstudent++;
            } else {
                $totalstudent++;
            }
            $resultArray[$subjectName] = [
                'complete' => $Complete,
                'totalstudent' => $totalstudent,
            ];
        }
        }

        return array('subjectReport'=>$resultArray,'withoutDress'=>$withoutDress,'bedconduct'=>$bedconduct);
        
    }

    public function getAttendenceReport($student_id,$from_date,$to_date)
    {
        if($from_date!='' && $to_date!=''){
            $start_date = date("Y-m-d",strtotime($from_date));
            $end_date = date("Y-m-d",strtotime($to_date));
        }else{
            $start_date = date("Y-m-d", strtotime("first day of last month"));
            $end_date = date("Y-m-d", strtotime("last day of last month"));

        }
        $attendenceArray = [];
        if($student_id!=''){
        $this->db->select('student_attendences.date as attendece_date,attendence_type_id');
        $this->db->from('student_attendences');
        $this->db->where_in('student_attendences.student_session_id', 'SELECT id FROM student_session WHERE student_id ="'.$student_id.'"', false);
        $this->db->where('student_attendences.date >=', $start_date);
        $this->db->where('student_attendences.date <=', $end_date);
        $this->db->group_by('date(date)');
        $query = $this->db->get();
        $results = $query->result_array();
        $attendence='';
        $school_open=$student_attend=0;
        foreach ($results as $result) {
            $school_open++;
            
            $created_at = date('d-m-Y',strtotime($result['attendece_date']));

            if($result['attendence_type_id']==1){
                $attendence='P';
                $student_attend++;
            }
            if($result['attendence_type_id']==4){
                $attendence='A';
            }
            $attendenceArray[$created_at] = [
                'attendence'=>$attendence
            ];

        }
        $attendenceArray['school_open']=$school_open;
        $attendenceArray['student_attend']=$student_attend;
     }
        // echo "<pre>";
        // print_r($attendenceArray);
        // die();

        return $attendenceArray;
    }

    public function getAllStudentBySection($class_id,$section_id) {

        $this->db->select('students.id as student_id, students.firstname');
        $this->db->from('student_session');
        $this->db->join('students', 'students.id = student_session.student_id', 'left');
        $this->db->where('student_session.class_id', $class_id);
        $this->db->where('student_session.section_id', $section_id);
        $query = $this->db->get();
        $section = $query->result_array();

        return $section;
    }
    
    public function studentDetails($student_id)
    {
        
            $query= $this->db->select('classes.id AS `class_id`,student_session.id as student_session_id,students.id,classes.class,sections.id AS `section_id`,sections.section,students.id,students.admission_no, students.roll_no,students.admission_date,students.firstname,students.middlename,  students.lastname,students.image,students.mobileno,students.email ,students.state,students.city, students.pincode,students.religion,DATE(students.dob) as dob,students.current_address,students.permanent_address,IFNULL(students.category_id, 0) as `category_id`,IFNULL(categories.category, "") as `category`,students.adhar_no,students.samagra_id,students.bank_account_no,students.bank_name,students.ifsc_code , students.guardian_name, students.guardian_relation,students.guardian_phone,students.guardian_address,students.is_active,students.created_at ,students.updated_at,students.father_name,students.mother_name,students.app_key,students.parent_app_key,students.rte,students.gender')->from('students')
            ->join('student_session', 'student_session.student_id = students.id')
            ->join('classes', 'student_session.class_id = classes.id')
            ->join('sections', 'sections.id = student_session.section_id')
            ->join('categories', 'students.category_id = categories.id', 'left')
            ->where('students.is_active', 'yes')
            ->where_in('students.id', $student_id)
            ->group_By('students.id')   
            ->order_By('students.admission_no', 'ASC')
            ->get(); 
            $reuslt=$query->result_array();
            return $reuslt;
    }
}

