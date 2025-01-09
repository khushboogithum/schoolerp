<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Notebooktype extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Notebooktype_model');  // Load the model here

    }

    public function index()
    {
        if (!$this->rbac->hasPrivilege('class', 'can_view')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'Note Book Type');
        $this->session->set_userdata('sub_menu', 'Note Book Type/index');
        $data['title']      = 'Note Book Type';
        $data['title_list'] = 'Note Book Type List';

        $notebookList         = $this->Notebooktype_model->listNoteBookDairy();
        $data['notebookList'] = $notebookList;

        $data['title'] = 'Add Note Book Type';
        $this->form_validation->set_rules('note_book_title', $this->lang->line('note_book_type'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('remarks', $this->lang->line('remarks'), 'trim|required|xss_clean');

        if ($this->form_validation->run() == false) {
        } else {
            $data = array(
                'note_book_title'        => $this->input->post('note_book_title'),
                'remark'        => $this->input->post('remarks'),
                'created_by'      => '3',
            );
            $this->Notebooktype_model->add_notebooktype($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success">' . $this->lang->line('success_message') . '</div>');
          
            return redirect('notebooktype');
        }

        $this->load->view('layout/header', $data);
        $this->load->view('notebooktype/notebooktypelist', $data);
        $this->load->view('layout/footer', $data);
    }
    public function edit($id)
    {
        if (!$this->rbac->hasPrivilege('class', 'can_edit')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'Note Book Type');
        $this->session->set_userdata('sub_menu', 'notebooktype/index');
        $data['title']      = 'Edit Note Book Type';
        $data['id']         = $id;
        $editnotbooktype           = $this->Notebooktype_model->getByID($id);
        $data['editnotbooktype']   = $editnotbooktype;
        $data['title_list'] = 'Note Book Type List';
        $notebookList         = $this->Notebooktype_model->listNoteBookDairy();
        $data['notebookList'] = $notebookList;

        // $this->form_validation->set_rules(
        //     'class', $this->lang->line('class'), array(
        //         'required',
        //         array('class_exists', array($this->class_model, 'class_exists')),
        //     )
        // );
        $this->form_validation->set_rules('note_book_title', $this->lang->line('note_book_type'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('remarks', $this->lang->line('remarks'), 'trim|required|xss_clean');

        if ($this->form_validation->run() == false) {
            $this->load->view('layout/header', $data);
            $this->load->view('notebooktype/notebooktypeedit', $data);
            $this->load->view('layout/footer', $data);
        } else {
            $data = array(
                'note_book_title'        => $this->input->post('note_book_title'),
                'remark'        => $this->input->post('remarks'),
                // 'note_book_type_id'        => $this->input->post('note_book_type_id'),
                'created_by'      => '3',
            );
            $this->Notebooktype_model->update_notebooktype($id, $data);

          $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">' . $this->lang->line('update_message') . '</div>');
          redirect('notebooktype');
        }
    }

    public function delete($id)
    {
        if (!$this->rbac->hasPrivilege('class', 'can_delete')) {
            access_denied();
        }
        $data['title'] = 'Fees Master List';
        $data = ['status' => 0];

        $this->Notebooktype_model->removeNoteBook($id,$data);
        $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">' . $this->lang->line('delete_message') . '</div>');
        redirect('notebooktype');
    }
}
