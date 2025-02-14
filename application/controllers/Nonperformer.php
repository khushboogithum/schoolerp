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

        $this->load->view('layout/header', $data);
        $this->load->view('nonperformer/non_performer');
        $this->load->view('layout/footer', $data);
      
    }
}
