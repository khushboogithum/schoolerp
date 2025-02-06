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
}
