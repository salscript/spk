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
      $this->load->model('M_criteria');
   }

   public function subkriteria()
   {
      $data['subkriteria'] = $this->M_subkriteria->get_all_subkriteria();
      // print_r("cek");
      $this->template->load('spk/template_admin', 'spk/admin/subkriteria/index', $data);
   }
   
   public function new_subkriteria()
   {
      $data['code_sub_kriteria'] = $this->M_subkriteria->code_subkriteria();
      $data['criteria'] = $this->M_criteria->get_all_criteria();
      $this->template->load('spk/template_admin', 'spk/admin/subkriteria/addSubkriteria', $data);
   }

   public function edit_subkriteria($id) {
      $data['datasc'] = $this->M_subkriteria->get_subkriteria_by_id($id);
      $data['criteria'] = $this->M_criteria->get_all_criteria();
      $this->template->load('spk/template_admin', 'spk/admin/subkriteria/editSubkriteria', $data);
   }

   public function save_subkriteria()
   {
      if ($this->input->is_ajax_request() == true) {
         $code = $this->input->post('code_sub_kriteria', true);
         $criteria_id = $this->input->post('criteria', true);
         $name = $this->input->post('name', true);
         $bobot = $this->input->post('bobot', true);
         $created_on = date("Y-m-d H:i:s");

         $this->form_validation->set_rules('name', 'Name', 'required', ['required' => '%s tidak boleh kosong']);
         $this->form_validation->set_rules('bobot', 'Bobot', 'required|numeric', ['required' => '%s tidak boleh kosong', 'numeric' => '%s harus berupa angka']);

         if ($this->form_validation->run() == TRUE) {
            $save = $this->M_subkriteria->save_subkriteria($code, $criteria_id, $name, $bobot, $created_on);
            if ($save) {
               $msg = ['success' => 'Sub Kriteria berhasil disimpan'];
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
         $id = $this->input->post('id_sub', true);
         $criteria_id = $this->input->post('criteria', true);
         $name = $this->input->post('name', true);
         $bobot = $this->input->post('bobot', true);
         $updated_on = date("Y-m-d H:i:s");

         $this->form_validation->set_rules('name', 'Nama Kriteria', 'required', ['required' => '%s tidak boleh kosong']);
         $this->form_validation->set_rules('bobot', 'Bobot', 'required|numeric', ['required' => '%s tidak boleh kosong', 'numeric' => '%s harus berupa angka']);

         if ($this->form_validation->run() == TRUE) {
            $update = $this->M_subkriteria->update_subkriteria($id, $criteria_id, $name, $bobot, $updated_on);
            if ($update) {
               $msg = ['success' => 'Sub Kriteria berhasil diupdated'];
            } else {
               $msg = ['error' => 'Gagal mengupdate Sub Kriteria: '. $this->db->error()['message']];
            }
         } else {
            $msg = ['error' => validation_errors()];
         }

         echo json_encode($msg);
      }
   }

   public function delete_subkriteria() {
      if ($this->input->is_ajax_request() == true) {
         $id = $this->input->post('id_sub', true);
         $delete = $this->M_subkriteria->delete_subkriteria($id);

         if ($delete) {
            $msg = ['success' => 'Sub Kriteria Berhasil Terhapus'];
         } else {
            $msg = ['error' => 'Gagal menghapus subkriteria: '. $this->db->error()['message']];
         }
         echo json_encode($msg);
      }
   }
}
