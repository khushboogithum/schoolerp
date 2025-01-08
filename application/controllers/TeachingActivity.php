<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class TeachingActivity extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Teachingactivity_model');  

    }

    public function index()
    {
        echo "hello";
       
    }

    public function delete($id)
    {
       
    }
    public function edit($id)
    {
        
    }
}
