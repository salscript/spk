<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Position extends MY_Controller
{
   public function __construct()
   {
      parent::__construct();
      cek_login();
      check_admin();
      $this->load->model('M_position');
   }

   public function position()
   {
      $data['position'] = $this->M_position->get_all_position();
      $this->template->load('spk/template_admin', 'spk/admin/position/index', $data);
   }
   
   public function new_position()
   {
      $this->template->load('spk/template_admin', 'spk/admin/position/addposition');
   }
   public function edit_position($id) {
      $data['position'] = $this->M_position->get_position_by_id($id);
      $this->template->load('spk/template_admin', 'spk/admin/position/editposition', $data);
   }

   public function save_position()
   {
      if ($this->input->is_ajax_request() == true) {
         $position = $this->input->post('position', true);
         $created_on = date("Y-m-d H:i:s");

         $this->form_validation->set_rules('position', 'position', 'required', ['required' => '%s tidak boleh kosong']);
   
         if ($this->form_validation->run() == TRUE) {
            $save = $this->M_position->save_position( $position, $created_on);
            if ($save) {
               $msg = ['success' => 'position berhasil disimpan'];
            } else {
               $msg = ['error' => 'Gagal menyimpan position: '. $this->db->error()['message']];
            }
         } else {
            $msg = ['error' => validation_errors()];
         }

         echo json_encode($msg);
      }
   }

   public function update_position()
   {
      if ($this->input->is_ajax_request() == true) {
         $id = $this->input->post('id', true);
         $name = $this->input->post('position', true);
         $updated_on = date("Y-m-d H:i:s");

         $this->form_validation->set_rules('position', 'position', 'required', ['required' => '%s tidak boleh kosong']);
        
         if ($this->form_validation->run() == TRUE) {
            $update = $this->M_position->update_position($id, $name, $updated_on);
            if ($update) {
               $msg = ['success' => 'position berhasil diupdated'];
            } else {
               $msg = ['error' => 'Gagal mengupdate position: '. $this->db->error()['message']];
            }
         } else {
            $msg = ['error' => validation_errors()];
         }

         echo json_encode($msg);
      }
   }

   public function deletePosition() {
      if ($this->input->is_ajax_request() == true) {
         $id = $this->input->post('id_position', true);
         $delete = $this->M_position->delete_position($id);

         if ($delete) {
            $msg = ['success' => 'position Berhasil Terhapus'];
         } else {
            $msg = ['error' => 'Gagal menghapus position: '. $this->db->error()['message']];
         }
         echo json_encode($msg);
      }
   }
}
