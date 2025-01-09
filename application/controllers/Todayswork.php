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
        echo "today work";
       
    }

    public function delete($id)
    {
       
    }
    public function edit($id)
    {
        
    }
}
