<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Todaysworkreport_model extends MY_model
{
    public function __construct()
    {
        parent::__construct();
        $this->current_session = $this->setting_model->getCurrentSession();
        $this->current_session_name = $this->setting_model->getCurrentSessionName();
    }
    public function homeworkreport($data) {

        
    }
}
