<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Todayswork extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Todayswork_model');  

    }

    public function index()
    {
        if (!$this->rbac->hasPrivilege('lesson', 'can_view')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'todayswork');
        $this->session->set_userdata('sub_menu', 'todayswork/index');
        $data['title']      = 'Todays Work';
        $data['title_list'] = 'Todays Work';


        $this->load->view('layout/header', $data);
        $this->load->view('todayswork/todayworklist', $data);
        $this->load->view('layout/footer', $data);
    }

    public function delete($id)
    {
       
    }
    public function edit($id)
    {
        
    }
}
