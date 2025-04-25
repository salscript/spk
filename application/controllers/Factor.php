<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Factor extends MY_Controller
{
   public function __construct()
   {
      parent::__construct();
      cek_login();
      check_admin();
      $this->load->model('M_factor');
   }

   public function factor()
   {
      $data['factor'] = $this->M_factor->get_all_factor();
      $this->template->load('spk/template_admin', 'spk/admin/factor/index', $data);
   }
   
   public function new_factor()
   {
      $data['code_factor'] = $this->M_factor->code_factor();
      $this->template->load('spk/template_admin', 'spk/admin/factor/addFactor', $data);
   }

   public function edit_factor($id) {
      $data['factor'] = $this->M_factor->get_factor_by_id($id);
      $this->template->load('spk/template_admin', 'spk/admin/factor/editFactor', $data);
   }

   public function save_factor()
   {
      if ($this->input->is_ajax_request() == true) {
         $code_factor = $this->input->post('code_factor', true);
         $factor = $this->input->post('factor', true);
         $created_on = date("Y-m-d H:i:s");

         $this->form_validation->set_rules('factor', 'Factor', 'required', ['required' => '%s tidak boleh kosong']);
   
         if ($this->form_validation->run() == TRUE) {
            $save = $this->M_factor->save_factor($code_factor, $factor, $created_on);
            if ($save) {
               $msg = ['success' => 'factor berhasil disimpan'];
            } else {
               $msg = ['error' => 'Gagal menyimpan factor: '. $this->db->error()['message']];
            }
         } else {
            $msg = ['error' => validation_errors()];
         }

         echo json_encode($msg);
      }
   }

   public function update_factor()
   {
      if ($this->input->is_ajax_request() == true) {
         $id = $this->input->post('id', true);
         $name = $this->input->post('factor', true);
         $updated_on = date("Y-m-d H:i:s");

         $this->form_validation->set_rules('factor', 'Factor', 'required', ['required' => '%s tidak boleh kosong']);
        
         if ($this->form_validation->run() == TRUE) {
            $update = $this->M_factor->update_factor($id, $name, $updated_on);
            if ($update) {
               $msg = ['success' => 'factor berhasil diupdated'];
            } else {
               $msg = ['error' => 'Gagal mengupdate factor: '. $this->db->error()['message']];
            }
         } else {
            $msg = ['error' => validation_errors()];
         }

         echo json_encode($msg);
      }
   }

   public function delete_factor() {
      if ($this->input->is_ajax_request() == true) {
         $id = $this->input->post('id_factor', true);
         $delete = $this->M_factor->delete_factor($id);

         if ($delete) {
            $msg = ['success' => 'factor Berhasil Terhapus'];
         } else {
            $msg = ['error' => 'Gagal menghapus factor: '. $this->db->error()['message']];
         }
         echo json_encode($msg);
      }
   }
}
