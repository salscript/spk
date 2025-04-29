<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SubKriteria extends MY_Controller
{
   public function __construct()
   {
      parent::__construct();
      cek_login();
      check_admin();
      $this->load->model('M_subkriteria');
   }

   public function subkriteria()
   {
      $data['subkriteria'] = $this->M_subkriteria->get_all_subkriteria();
      // print_r("cek");
      $this->template->load('spk/template_admin', 'spk/admin/subkriteria/index', $data);
   }
   
   public function new_subkriteria()
   {
      $data['code_subkriteria'] = $this->M_subkriteria->code_subkriteria();
      $this->template->load('spk/template_admin', 'spk/admin/subkriteria/addSubkriteria', $data);
   }

   public function edit_subkriteria($id) {
      $data['subkriteria'] = $this->M_subkriteria->get_subkriteria_by_id($id);
      $this->template->load('spk/template_admin', 'spk/admin/subkriteria/editSubkriteria', $data);
   }

   public function save_subkriteria()
   {
      if ($this->input->is_ajax_request() == true) {
         $code_subkriteria = $this->input->post('code_subkriteria', true);
         $name = $this->input->post('name', true);
         $bobot = $this->input->post('bobot', true);
         $created_on = date("Y-m-d H:i:s");

         $this->form_validation->set_rules('name', 'Name', 'required', ['required' => '%s tidak boleh kosong']);
         $this->form_validation->set_rules('bobot', 'Bobot', 'required|numeric', ['required' => '%s tidak boleh kosong', 'numeric' => '%s harus berupa angka']);

         if ($this->form_validation->run() == TRUE) {
            $save = $this->M_subkriteria->save_subkriteria($code_subkriteria, $name, $bobot, $created_on);
            if ($save) {
               $msg = ['success' => 'subkriteria berhasil disimpan'];
            } else {
               $msg = ['error' => 'Gagal menyimpan subkriteria: '. $this->db->error()['message']];
            }
         } else {
            $msg = ['error' => validation_errors()];
         }

         echo json_encode($msg);
      }
   }

   public function update_subkriteria()
   {
      if ($this->input->is_ajax_request() == true) {
         $id = $this->input->post('id', true);
         $name = $this->input->post('name', true);
         $bobot = $this->input->post('bobot', true);
         $updated_on = date("Y-m-d H:i:s");

         $this->form_validation->set_rules('name', 'Name', 'required', ['required' => '%s tidak boleh kosong']);
         $this->form_validation->set_rules('bobot', 'Bobot', 'required|numeric', ['required' => '%s tidak boleh kosong', 'numeric' => '%s harus berupa angka']);

         if ($this->form_validation->run() == TRUE) {
            $update = $this->M_subkriteria->update_subkriteria($id, $name, $bobot, $updated_on);
            if ($update) {
               $msg = ['success' => 'subkriteria berhasil diupdated'];
            } else {
               $msg = ['error' => 'Gagal mengupdate subkriteria: '. $this->db->error()['message']];
            }
         } else {
            $msg = ['error' => validation_errors()];
         }

         echo json_encode($msg);
      }
   }

   public function delete_subkriteria() {
      if ($this->input->is_ajax_request() == true) {
         $id = $this->input->post('id_subkriteria', true);
         $delete = $this->M_subkriteria->delete_subkriteria($id);

         if ($delete) {
            $msg = ['success' => 'subkriteria Berhasil Terhapus'];
         } else {
            $msg = ['error' => 'Gagal menghapus subkriteria: '. $this->db->error()['message']];
         }
         echo json_encode($msg);
      }
   }
}
