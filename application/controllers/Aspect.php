<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Aspect extends MY_Controller
{
   public function __construct()
   {
      parent::__construct();
      cek_login();
      check_admin();
      $this->load->model('M_aspect');
   }

   public function aspect()
   {
      $data['aspect'] = $this->M_aspect->get_all_aspect();
      $this->template->load('spk/template_admin', 'spk/admin/aspect/index', $data);
   }
   
   public function new_aspect()
   {
      $data['code_aspect'] = $this->M_aspect->code_aspect();
      $this->template->load('spk/template_admin', 'spk/admin/aspect/addAspect', $data);
   }

   public function edit_aspect($id) {
      $data['aspect'] = $this->M_aspect->get_aspect_by_id($id);
      $this->template->load('spk/template_admin', 'spk/admin/aspect/editAspect', $data);
   }

   public function save_aspect()
   {
      if ($this->input->is_ajax_request() == true) {
         $code_aspect = $this->input->post('code_aspect', true);
         $name = $this->input->post('name', true);
         $persentase = $this->input->post('persentase', true);
         $created_on = date("Y-m-d H:i:s");

         $this->form_validation->set_rules('name', 'Name', 'required', ['required' => '%s tidak boleh kosong']);
         $this->form_validation->set_rules('persentase', 'Persentase', 'required|numeric', ['required' => '%s tidak boleh kosong', 'numeric' => '%s harus berupa angka']);

         if ($this->form_validation->run() == TRUE) {
            $save = $this->M_aspect->save_aspect($code_aspect, $name, $persentase, $created_on);
            if ($save) {
               $msg = ['success' => 'Aspect berhasil disimpan'];
            } else {
               $msg = ['error' => 'Gagal menyimpan aspect: '. $this->db->error()['message']];
            }
         } else {
            $msg = ['error' => validation_errors()];
         }

         echo json_encode($msg);
      }
   }

   public function update_aspect()
   {
      if ($this->input->is_ajax_request() == true) {
         $id = $this->input->post('id', true);
         $name = $this->input->post('name', true);
         $persentase = $this->input->post('persentase', true);
         $updated_on = date("Y-m-d H:i:s");

         $this->form_validation->set_rules('name', 'Name', 'required', ['required' => '%s tidak boleh kosong']);
         $this->form_validation->set_rules('persentase', 'Persentase', 'required|numeric', ['required' => '%s tidak boleh kosong', 'numeric' => '%s harus berupa angka']);

         if ($this->form_validation->run() == TRUE) {
            $update = $this->M_aspect->update_aspect($id, $name, $persentase, $updated_on);
            if ($update) {
               $msg = ['success' => 'Aspect berhasil diupdated'];
            } else {
               $msg = ['error' => 'Gagal mengupdate aspect: '. $this->db->error()['message']];
            }
         } else {
            $msg = ['error' => validation_errors()];
         }

         echo json_encode($msg);
      }
   }

   public function delete_aspect() {
      if ($this->input->is_ajax_request() == true) {
         $id = $this->input->post('id_aspect', true);
         $delete = $this->M_aspect->delete_aspect($id);

         if ($delete) {
            $msg = ['success' => 'Aspect Berhasil Terhapus'];
         } else {
            $msg = ['error' => 'Gagal menghapus aspect: '. $this->db->error()['message']];
         }
         echo json_encode($msg);
      }
   }
}
