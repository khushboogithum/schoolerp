<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}


class Nonperformer extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Nonperformer_model');
      
    }

    public function index()
    {
        // if (!$this->rbac->hasPrivilege('nonperformer', 'can_view')) {
        //     access_denied();
        // }
        $this->session->set_userdata('top_menu', 'nonperformer');
        $this->session->set_userdata('sub_menu', 'nonperformer/index');
        $data['title']      = 'Nonperformer Report';
        $data['title_list'] = 'Nonperformer Report';

        $classlist         = $this->class_model->get();
        $data['classlist'] = $classlist;
        

        $data['nonPerformerStudent']=$this->Nonperformer_model->nonPerformerStudent();   
        $data['classPercentage']=$this->Nonperformer_model->getClassPercentageToday();  
        $data['subjectPercentage']=$this->Nonperformer_model->getClassSubjectPercentage();  
        // echo "<pre>";
        // print_r($classPercentage); 
        // die();     

        $this->load->view('layout/header', $data);
        $this->load->view('nonperformer/non_performer',$data);
        $this->load->view('layout/footer', $data);
      
    }
}
