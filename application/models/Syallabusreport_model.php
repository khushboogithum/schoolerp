<?php

// if (!defined('BASEPATH')) {
//     exit('No direct script access allowed');
// }

class Syallabusreport_model extends MY_model
{
    public function __construct()
    {
        parent::__construct();
        $this->current_session = $this->setting_model->getCurrentSession();
        $this->current_session_name = $this->setting_model->getCurrentSessionName();
    }


    public function syallabusReport($from_date = null, $to_date = null, $class_id = null, $section_id = null)
    {
        $today = date('Y-m-d');
        $this->db->select('today_work.today_work_id, today_work.work_date,today_work.class_id, today_work.subject_id, today_work.lesson_id, subjects.name as subject_name, today_work.lesson_name, lesson_diary.lesson_number');
        $this->db->from('today_work');
        $this->db->join("subjects", "subjects.id = today_work.subject_id");
        $this->db->join("lesson_diary", "lesson_diary.lesson_id = today_work.lesson_id");
        $this->db->where('today_work.status', '1');
        if (!empty($from_date)) {
            $this->db->where('DATE(today_work.work_date)>=', $from_date);
        }
        if (!empty($to_date)) {
            $this->db->where('DATE(today_work.work_date)<=', $to_date);
        }

        if (!empty($class_id)) {
            $this->db->where('today_work.class_id', $class_id);
        }
        if (!empty($section_id)) {
            $this->db->where('today_work.section_id', $section_id);
        }

        $this->db->group_by('DATE(today_work.work_date)');
        $this->db->group_by('today_work.subject_id');




        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            foreach ($result as &$row) {
                $row['class_work'] = $this->getClassWorkData($row['today_work_id']);
                $row['home_work'] = $this->getHomeWorkData($row['today_work_id']);
                $row['total_lessons'] = $this->countLessonsBySubject($row['subject_id'], $row['class_id']);
            }
            return $result;
        } else {
            return [];
        }
    }


    public function TeacherWisesyallabus($from_date = null, $to_date = null, $teacher_id = null)
    {
        $this->db->select('class_teacher.staff_id, GROUP_CONCAT(class_teacher.class_id) as class_ids');
      //  $this->db->select('class_id');
        $this->db->from('class_teacher');
        $this->db->where('class_teacher.staff_id', $teacher_id);
        $query = $this->db->get();
        // echo $this->db->last_query();
        // die();
        $query = $query->row_array();
        $class_ids =explode(',',$query['class_ids']);

        $this->db->select('today_work.today_work_id, today_work.work_date,today_work.class_id, today_work.subject_id, today_work.lesson_id, subjects.name as subject_name, today_work.lesson_name, lesson_diary.lesson_number,classes.class as class_name');
        $this->db->from('today_work');
        $this->db->join("subjects", "subjects.id = today_work.subject_id");
        $this->db->join("lesson_diary", "lesson_diary.lesson_id = today_work.lesson_id");
        $this->db->join("classes", "classes.id=today_work.class_id");
        $this->db->where('today_work.status', '1');
        $this->db->where_in('today_work.class_id', $class_ids);

        if (!empty($from_date)) {
            $this->db->where('DATE(today_work.work_date)>=', $from_date);
        }
        if (!empty($to_date)) {
            $this->db->where('DATE(today_work.work_date)<=', $to_date);
        }

        if (!empty($class_id)) {
            $this->db->where('today_work.class_id', $class_id);
        }
        if (!empty($section_id)) {
            $this->db->where('today_work.section_id', $section_id);
        }
        $this->db->group_by('DATE(today_work.work_date)');
        $this->db->group_by('today_work.subject_id');
        $this->db->group_by('today_work.class_id');
        $query = $this->db->get();
        // echo $this->db->last_query();
        // die();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            foreach ($result as &$row) {
                $row['class_work'] = $this->getClassWorkData($row['today_work_id']);
                $row['home_work'] = $this->getHomeWorkData($row['today_work_id']);
                $row['total_lessons'] = $this->countLessonsBySubject($row['subject_id'], $row['class_id']);
                $lesson_number = $row['lesson_number'];
                if ($row['total_lessons'] > 0) {
                    $row['syllabus_percentage'] = round(($lesson_number / $row['total_lessons']) * 100, 2);
                } else {
                    $row['syllabus_percentage'] = 0;
                }
            }
            $result;
        }
        return $result;
        // echo $this->db->last_query();
        // die();
        // echo "<pre>";
        // print_r($result);
        // die();

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
    public function getHomeWorkData($today_work_id)
    {
        $this->db->select('today_home_work.teaching_activity_id, teaching_activity.teaching_activity_title');
        $this->db->from('today_home_work');
        $this->db->join('teaching_activity', 'teaching_activity.teaching_activity_id = today_home_work.teaching_activity_id');
        $this->db->where('today_home_work.today_work_id', $today_work_id);
        $query = $this->db->get();
        return $query->result_array();
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

    public function getGroupByClassandSection()
    {

        $sql = "SELECT subject_groups.name,subject_groups.id as subject_id, subject_group_class_sections.* 
        FROM subject_group_class_sections 
        INNER JOIN class_sections ON class_sections.id = subject_group_class_sections.class_section_id 
        INNER JOIN subject_groups ON subject_groups.id = subject_group_class_sections.subject_group_id 
        ORDER BY subject_groups.id DESC";
        $query = $this->db->query($sql);
        $result = $query->result_array();

        return $result;
    }

    public function getSubjectWiseReport($from_date=null, $to_date=null, $subject_id=null){

            
        $this->db->select('subjects.*');
        $this->db->from('subjects');
        $this->db->order_by('name','ASC');
        $query = $this->db->get();
        $subjectresult = $query->result_array();
        $subjectArray=array();
        foreach($subjectresult as $key=>$subjectdata){
                $subjectArray[]=$subjectdata['name'];

        }

        $this->db->select('student_work_report.*');
        $this->db->from('student_work_report');
        if (!empty($from_date)) {
            $this->db->where('DATE(student_work_report.created_at)>=', $from_date);
        }
        if (!empty($to_date)) {
            $this->db->where('DATE(student_work_report.created_at)<=', $to_date);
        }

        if (!empty($subject_id)) {
            $this->db->where('student_work_report.subject_id', $subject_id);
        }
        $query = $this->db->get();
        $results = $query->result_array();
        $resultArray = [];
        foreach ($results as $result) {
            $subjectName = $result['subject_name'];
            $dateData = date("Y-m-d", strtotime($result['created_at']));
            if (!isset($resultArray[$dateData][$subjectName])) {
                $resultArray[$dateData][$subjectName] = [
                    'complete' => 0,
                    'totalstudent' => 0,
                    'incomplete' => 0
                ];
            }
        
            $resultArray[$dateData][$subjectName]['totalstudent']++;
            if ($result['fair_copy'] == 1 && $result['writing_work'] == 1 && $result['learning_work'] == 1) {
                $resultArray[$dateData][$subjectName]['complete']++;
            } else {
                $resultArray[$dateData][$subjectName]['incomplete']++;
            }
        }
        
        
        return array('subjectdata'=>$subjectArray,'subjectReport'=>$resultArray);
    }

    public function get_winning_class() {
        $todayDate = date('Y-m-d');
        
        $this->db->select('class_id, class_percentage,class as class_name');
        $this->db->from('class_wise_report');
        $this->db->join('classes', 'classes.id = class_wise_report.class_id');
        $this->db->where('today_date', $todayDate);
        $this->db->order_by('class_percentage', 'DESC');
        $todayQuery = $this->db->get();
        $todayMax = $todayQuery->result_array();
        if (empty($todayMax)) {
            return [
                'final_class_name' => null,
                'final_percentage' => null
            ];
        }

        $maxPercentage = $todayMax[0]['class_percentage'];
        $filteredClasses = [];

        foreach ($todayMax as $row) {
            if ($row['class_percentage'] == $maxPercentage) {
                $filteredClasses[$row['class_name']] = $row['class_percentage'];
            }
        }
        if (count($filteredClasses) > 1) {
            $this->db->select('class_id, class_percentage,class as class_name');
            $this->db->from('class_wise_report');
            $this->db->join('classes', 'classes.id = class_wise_report.class_id');
            $this->db->where('YEAR(today_date)', date('Y'));
            $this->db->order_by('class_percentage', 'DESC');
            $this->db->order_by('today_date', 'DESC');
            $this->db->limit(1);
            $yearlyQuery = $this->db->get();
            $yearlyMax = $yearlyQuery->row_array();

            return [
                'final_class_name' => $yearlyMax['class_name'],
                'final_percentage' => $yearlyMax['class_percentage']
            ];
        } else {
            $finalClassId = array_key_first($filteredClasses);
            $finalPercentage = $filteredClasses[$finalClassId];
            return [
                'final_class_name' => $finalClassId,
                'final_percentage' => $finalPercentage
            ];
        }
    }


    
    public function get_winning_teacher() {
        $todayDate = date('Y-m-d');
        
        $this->db->select('staff_id, total_percentage,name,image');
        $this->db->from('class_teacher_report');
        $this->db->join('staff', 'staff.id = class_teacher_report.staff_id');
        $this->db->where('today_date', $todayDate);
        $this->db->order_by('total_percentage', 'DESC');
        $todayQuery = $this->db->get();
        // echo $this->db->last_query();
        // die();
        $todayMax = $todayQuery->result_array();
        // print_r($todayMax);
        if (empty($todayMax)) {
            return [
                'final_teacher_name' => null,
                'final_percentage' => null
            ];
        }

        $maxPercentage = $todayMax[0]['total_percentage'];
        $filteredClasses = [];

        foreach ($todayMax as $row) {
            if ($row['total_percentage'] == $maxPercentage) {
                $filteredClasses[] = $row['total_percentage'];
            }
        }
        if (count($filteredClasses) > 1) {
            $this->db->select('staff_id, total_percentage,name,image');
            $this->db->from('class_teacher_report');
            $this->db->join('staff', 'staff.id = class_teacher_report.staff_id');
            $this->db->where('YEAR(today_date)', date('Y'));
            $this->db->order_by('total_percentage', 'DESC');
            $this->db->order_by('today_date', 'DESC');
            $this->db->limit(1);
            $yearlyQuery = $this->db->get();
            $yearlyMax = $yearlyQuery->row_array();

            return [
                'name' => $yearlyMax['name'],
                'image' => $yearlyMax['image'],
                'percentage' => $yearlyMax['total_percentage']
            ];
        } else {
            return [
                'name' => $todayMax[0]['name'],
                'image' => $todayMax[0]['image'],
                'percentage' => $todayMax[0]['total_percentage']
            ];
        }
    }

    public function get_winning_subjectwise() {
        $todayDate = date('Y-m-d');
        
        $this->db->select('subject_id, subject_percentage,name');
        $this->db->from('subject_wise_report');
        $this->db->join('subjects', 'subjects.id = subject_wise_report.subject_id');
        $this->db->where('today_date', $todayDate);
        $this->db->order_by('subject_percentage', 'DESC');
        $todayQuery = $this->db->get();
        // echo $this->db->last_query();
        // die();
        $todayMax = $todayQuery->result_array();
        // print_r($todayMax);
        if (empty($todayMax)) {
            return [
                'final_teacher_name' => null,
                'final_percentage' => null
            ];
        }

        $maxPercentage = $todayMax[0]['subject_percentage'];
        $filteredClasses = [];

        foreach ($todayMax as $row) {
            if ($row['subject_percentage'] == $maxPercentage) {
                $filteredClasses[] = $row['subject_percentage'];
            }
        }
        if (count($filteredClasses) > 1) {
            $this->db->select('subject_id, subject_percentage,name');
            $this->db->from('subject_wise_report');
            $this->db->join('subjects', 'subjects.id = subject_wise_report.subject_id');
            $this->db->where('YEAR(today_date)', date('Y'));
            $this->db->order_by('subject_percentage', 'DESC');
            $this->db->order_by('today_date', 'DESC');
            $this->db->limit(1);
            $yearlyQuery = $this->db->get();
            $yearlyMax = $yearlyQuery->row_array();

            return [
                'name' => $yearlyMax['name'],
                'percentage' => $yearlyMax['subject_percentage']
            ];
        } else {
            return [
                'name' => $todayMax[0]['name'],
                'percentage' => $todayMax[0]['subject_percentage']
            ];
        }
    }
}
