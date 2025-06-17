<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Question extends MY_Controller
{
   public function __construct()
   {
      parent::__construct();
      cek_login();
      // check_admin();
      $this->load->model('M_question');
      $this->load->model('M_criteria');
   }

   public function question()
   {
      $data['question'] = $this->M_question->get_all_questions();
      $role = $this->session->userdata('role_id');
       if($role == 1){
           $this->template->load('spk/template_admin', 'spk/admin/question/index', $data);
        } else if($role == 3){
           $this->template->load('spk/template_operator', 'spk/operator/question/index', $data);
       }
   }

   public function new_question()
   {
      $data['code_question'] = $this->M_question->code_question();
      $data['criteria'] = $this->M_criteria->get_all_criteria();
      
      $role = $this->session->userdata('role_id');
       if($role == 1){
           $this->template->load('spk/template_admin', 'spk/admin/question/addQuestion', $data);
        } else if($role == 3){
           $this->template->load('spk/template_operator', 'spk/operator/question/addQuestion', $data);
       }
   }

   public function save_question() {
      if($this->input->is_ajax_request() == TRUE) {
         $code = $this->input->post('code_question', true);
         $criteria_id = $this->input->post('criteria', true);
         $name = $this->input->post('question', true);
         $created_on = date("Y-m-d H:i:s");

         $this->form_validation->set_rules('question', 'Question', 'required', ['required' => '%s tidak boleh kosong']);

         if ($this->form_validation->run() == TRUE) {
            $data = array(
               'code_question' => $code,
               'criteria_id' => $criteria_id,
               'name' => $name,
               'created_on' => $created_on
            );
   
            $save = $this->M_question->save_question($data);
   
            if ($save) {
               $msg = ['success' => 'Question berhasil disimpan'];
            } else {
               $msg = ['error' => 'Gagal menyimpan question'];
            } 
         } else {
            $msg = ['error' => validation_errors()];
         }
         echo json_encode($msg);
      }
   }

   public function edit_question($id = null) {
      if ($id != null) {
         $data['dataq'] = $this->M_question->get_question_by_id($id);
         $data['criteria'] = $this->M_criteria->get_all_criteria();
         $this->template->load('spk/template_admin', 'spk/admin/question/editQuestion', $data);
      } else {
         if ($this->input->is_ajax_request() == TRUE) {
            $id = $this->input->post('id_question', true);
            $code = $this->input->post('code_question', true);
            $criteria_id = $this->input->post('criteria', true);
            $name = $this->input->post('question', true);
            $updated_on = date("Y-m-d H:i:s");

            $this->form_validation->set_rules('question', 'Question', 'required', ['required' => '%s tidak boleh kosong']);

            if ($this->form_validation->run() == TRUE) {
               $data = array(
                  'code_question' => $code,
                  'criteria_id' => $criteria_id,
                  'name' => $name,
                  'updated_on' => $updated_on
               );
      
               $save = $this->M_question->update_question($id, $data);
      
               if ($save) {
                  $msg = ['success' => 'Question berhasil diupdate'];
               } else {
                  $msg = ['error' => 'Gagal mengupdate question'];
               } 
            } else {
               $msg = ['error' => validation_errors()];
            }
            echo json_encode($msg);
         }
      }
   }

   public function delete_question() {
      if ($this->input->is_ajax_request() == true) {
         $id = $this->input->post('id_question', true);
         $delete = $this->M_question->delete_question($id);

         if ($delete) {
            $msg = ['success' => 'Quesion Berhasil Terhapus'];
         } else {
            $msg = ['error' => 'Gagal menghapus question: '. $this->db->error()['message']];
         }
         echo json_encode($msg);
      }
   }
    
}
