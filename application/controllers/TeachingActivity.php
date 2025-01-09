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
        $this->load->model('Notebooktype_model'); 

    }

    public function index()
    {
        if (!$this->rbac->hasPrivilege('class', 'can_view')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'Teacher Activity');
        $this->session->set_userdata('sub_menu', 'Teacher Activity/index');
        $data['title']      = 'Teacher Activity';
        $data['title_list'] = 'Teacher Activity List';

        $notebookList         = $this->Notebooktype_model->listNoteBookDairy();
        $data['notebookList'] = $notebookList;

        
        $teachingActivityList         = $this->Teachingactivity_model->teachingActivityList();
        $data['teachingActivityList'] = $teachingActivityList;

        $data['title'] = 'Add Teacher Activity';
        $this->form_validation->set_rules('teaching_activity_title', $this->lang->line('teaching_activity_title'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('note_book_type_id', $this->lang->line('note_book_type_id'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('remarks', $this->lang->line('remarks'), 'trim|required|xss_clean');

        if ($this->form_validation->run() == false) {
        } else {
            $data = array(
                'teaching_activity_title'        => $this->input->post('teaching_activity_title'),
                'note_book_type_id'        => $this->input->post('note_book_type_id'),
                'remark'        => $this->input->post('remarks'),
                'created_by'      => '3',
            );
            $this->Teachingactivity_model->add_teachinActivity($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success">' . $this->lang->line('success_message') . '</div>');
          
            return redirect('teachingactivity');
        }

        $this->load->view('layout/header', $data);
        $this->load->view('teachingactivity/teaching_activity_list', $data);
        $this->load->view('layout/footer', $data);
       
    }

    public function delete($id)
    {
        if (!$this->rbac->hasPrivilege('class', 'can_delete')) {
            access_denied();
        }
        $data['title'] = 'Fees Master List';
        $data = ['status' => 0];
        $this->Teachingactivity_model->delete_teachingActivity($id,$data);
        $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">' . $this->lang->line('delete_message') . '</div>');
        redirect('teachingactivity');

    }
    public function edit($id)
    {
        if (!$this->rbac->hasPrivilege('class', 'can_edit')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'Teacher Activity');
        $this->session->set_userdata('sub_menu', 'Teacher Activity/index');
        $data['title']      = 'Teacher Activity';
        $data['title_list'] = 'Teacher Activity List';
        $data['id'] = $id;
        $notebookList         = $this->Notebooktype_model->listNoteBookDairy();
        $data['notebookList'] = $notebookList;
        $teachingActivityList         = $this->Teachingactivity_model->teachingActivityList();
        $data['teachingActivityList'] = $teachingActivityList;

        
        $teachingactivityedit         = $this->Teachingactivity_model->getByID($id);
        $data['teachingactivityedit'] = $teachingactivityedit;

        $data['title'] = 'Add Teacher Activity';
        $this->form_validation->set_rules('teaching_activity_title', $this->lang->line('teaching_activity_title'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('note_book_type_id', $this->lang->line('note_book_type_id'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('remarks', $this->lang->line('remarks'), 'trim|required|xss_clean');

        // $this->form_validation->set_rules(
        //     'class', $this->lang->line('class'), array(
        //         'required',
        //         array('class_exists', array($this->class_model, 'class_exists')),
        //     )
        // );

        if ($this->form_validation->run() == false) {
            $this->load->view('layout/header', $data);
            $this->load->view('teachingactivity/teaching_activity_edit', $data);
            $this->load->view('layout/footer', $data);
        } else {
            $data = array(
                'teaching_activity_title'        => $this->input->post('teaching_activity_title'),
                'note_book_type_id'        => $this->input->post('note_book_type_id'),
                'remark'        => $this->input->post('remarks'),
                'created_by'      => '3',
            );
            $this->Teachingactivity_model->update_teachingActivity($id, $data);

          $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">' . $this->lang->line('update_message') . '</div>');
          redirect('teachingactivity');
        } 
    }
}
