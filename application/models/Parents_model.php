<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
$tz = 'Asia/Kolkata';
date_default_timezone_set($tz);

class Parents_model extends MY_model
{
    public function __construct()
    {
        parent::__construct();
        $this->current_session = $this->setting_model->getCurrentSession();
        $this->current_session_name = $this->setting_model->getCurrentSessionName();
    }

    public function getLessionDetailsBySubjectId($subject_id, $class_id)
    {
        $this->db->select('lesson_diary.*');
        $this->db->from('lesson_diary');
        $this->db->where('lesson_diary.subject_id', $subject_id);
        $this->db->where('lesson_diary.class_id', $class_id);
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result_array();
    }

    public function getLessionDetailsByLessionId($lession_id)
    {
        $this->db->select('lesson_diary.*');
        $this->db->from('lesson_diary');
        $this->db->where('lesson_diary.lesson_id', $lession_id);
        $query = $this->db->get();
        // echo $this->db->last_query();
        // die();
        return $query->result_array();
    }
    public function getclasswork()
    {
        $this->db->select('teaching_activity.*');
        $this->db->from('teaching_activity');
        $this->db->where('teaching_activity.status', 1);
        $query = $this->db->get();
        // echo $this->db->last_query();
        // die();
        return $query->result_array();
    }
    public function todaysWorkList($class_id,$student_id,$tdate)
    {
        $today = date('Y-m-d');
        $this->db->select('today_work.today_work_id, today_work.work_date,today_work.class_id, today_work.subject_id, today_work.lesson_id, subjects.name as subject_name, today_work.lesson_name, lesson_diary.lesson_number');
        $this->db->from('today_work');
        $this->db->join("subjects", "subjects.id = today_work.subject_id");
        $this->db->join("lesson_diary", "lesson_diary.lesson_id = today_work.lesson_id");
        //$this->db->where('today_work.today_status', '0');
        if($class_id!=''){
            $this->db->where('today_work.class_id', $class_id);
        }if($tdate!=''){
            $this->db->where('DATE(today_work.work_date)', $tdate);
        }else{
            $this->db->where('DATE(today_work.work_date)', $today);

        }
        $query = $this->db->get();
        // echo $this->db->last_query();
        // die();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            foreach ($result as &$row) {
                $row['class_work'] = $this->getClassWorkData($row['today_work_id']);
                $row['class_notebook'] = $this->getClassWorkNoteBookData($row['today_work_id']);
                $row['home_work'] = $this->getHomeWorkData($row['today_work_id']);
                $row['home_notebook'] = $this->getHomeWorkNoteBookData($row['today_work_id']);
                $row['total_lessons'] = $this->countLessonsBySubject($row['subject_id'], $row['class_id']);
            }
            return $result;
        } else {
            return [];
        }
       
    }
    public function countLessonsBySubject($subject_id, $class_id)
    {
        $this->db->select('COUNT(*) as total_lessons');
        $this->db->from('lesson_diary');
        $this->db->where('subject_id', $subject_id);
        $this->db->where('class_id', $class_id);
        $query = $this->db->get();
        // echo  $this->db->last_query();
        // die();
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            return $result['total_lessons'];
        } else {
            return 0;
        }
    }
    public function getClassWorkData($today_work_id)
    {
        $this->db->select('today_class_work.teaching_activity_id, teaching_activity.teaching_activity_title');
        $this->db->from('today_class_work');
        $this->db->join('teaching_activity', 'teaching_activity.teaching_activity_id = today_class_work.teaching_activity_id');
        $this->db->where('today_class_work.today_work_id', $today_work_id);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function getClassWorkNoteBookData($today_work_id)
    {
        $this->db->select('class_work_note_book.class_work_note_book_id, note_book_type.note_book_title');
        $this->db->from('class_work_note_book');
        $this->db->join('note_book_type', 'note_book_type.note_book_type_id = class_work_note_book.note_book_type_id');
        $this->db->where('class_work_note_book.today_work_id', $today_work_id);
        $query = $this->db->get();
        // echo $this->db->last_query();
        // die();
        return $query->result_array();
    }
    public function getHomeWorkData($today_work_id)
    {
        $this->db->select('today_home_work.teaching_activity_id, teaching_activity.teaching_activity_title');
        $this->db->from('today_home_work');
        $this->db->join('teaching_activity', 'teaching_activity.teaching_activity_id = today_home_work.teaching_activity_id');
        $this->db->where('today_home_work.today_work_id', $today_work_id);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function getHomeWorkNoteBookData($today_work_id)
    {
        $this->db->select('home_work_note_book.home_work_note_book_id, note_book_type.note_book_title');
        $this->db->from('home_work_note_book');
        $this->db->join('note_book_type', 'note_book_type.note_book_type_id = home_work_note_book.note_book_type_id');
        $this->db->where('home_work_note_book.today_work_id', $today_work_id);
        $query = $this->db->get();
        // echo $this->db->last_query();
        // die();
        return $query->result_array();
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


    public function getAttendenceReport($student_id,$tdate)
    {
        if($student_id!=''){
            $this->db->select('student_attendences.date as attendece_date,attendence_type_id');
            $this->db->from('student_attendences');
            $this->db->where_in('student_attendences.student_session_id', 'SELECT id FROM student_session WHERE student_id ="'.$student_id.'"', false);
            if($tdate!=''){
                $this->db->where('DATE(student_attendences.date)', $tdate);
            }else{
                $this->db->where('DATE(student_attendences.date)', date('Y-m-d'));
            }
            $query = $this->db->get();
            $results = $query->result_array();
        }
        return $results;
    }

    public function getSubjectWiseReport($student_id,$tdate)
    {
        
        $resultArray = array();
        $subStatus=$backgroundColor ='';
        $dreessStatus='found guilty';
        $conductStatus='found guilty';
        $dreessStatus='NA';
        $conductStatus='NA';
        $grade='NA';
        $complatetot=0;
        $total=0;
        $percentage=0;
        if($student_id!=''){
        $this->db->select('student_work_report.*');
        $this->db->from('student_work_report');
        $this->db->where('student_work_report.student_id',$student_id);
        if($tdate!=''){
            $this->db->where('date(created_at)', $tdate);
        }else{
           // $this->db->where('date(created_at)', date('Y-m-d'));
        
        }
      
        $this->db->group_by('subject_id');
        $query = $this->db->get();
        // echo $this->db->last_query();
        // die();

        $results = $query->result_array();
        foreach ($results as $key => $result) {

            $subjectName = trim($result['subject_name']);
            if($result['discipline_dress'] == 1){
                $dreessStatus='Completed';
                $complatetot++;
                $total++;
            }

            if($result['discipline_conduct'] == 1){
                $conductStatus='Completed';
                $complatetot++;
                $total++;
            }   

            if ($result['fair_copy'] == 1 && $result['writing_work'] == 1 && $result['learning_work'] == 1) {
                $subStatus='Completed';
                $backgroundColor='completed';
                $total++;
                $complatetot++;
            }elseif($result['fair_copy'] == 0 && $result['writing_work'] == 0 && $result['learning_work'] == 0) {
                $subStatus='Not Completed';
                $backgroundColor='critical';
                $total++;
            }else{
                $subStatus='Not Completed';
                $backgroundColor='not-completed';
                $total++;
            }
            $resultArray[$subjectName] = [
                'subStatus' => $subStatus,
                'backgroundColor' => $backgroundColor,
            ];
        }
        if($total>0 && $complatetot>0){
            $percentage=($complatetot/$total)*100;
            $grade=getGrade($percentage);

        }
       

        }

        return array('subjectReport'=>$resultArray,'dreessStatus'=>$dreessStatus,'conductStatus'=>$conductStatus,'grade'=>$grade);
        
    }

}
