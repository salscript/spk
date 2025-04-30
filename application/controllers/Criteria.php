<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Criteria extends MY_Controller
{
   public function __construct()
   {
      parent::__construct();
      cek_login();
      check_admin();
      $this->load->model('M_criteria');
      $this->load->model('M_aspect');
      $this->load->model('M_factor');
   }

   public function criteria()
   {
      $data['criteria'] = $this->M_criteria->get_all_criteria();
      $this->template->load('spk/template_admin', 'spk/admin/criteria/index', $data);
   }
   
   public function new_criteria()
   {
      $data['code_criteria'] = $this->M_criteria->code_criteria();
      $data['aspect'] = $this->M_aspect->get_all_aspect();
      $data['factor'] = $this->M_factor->get_all_factor();
      // $data['role'] = $this->M_userrole->get_all_roles();
      
      $this->template->load('spk/template_admin', 'spk/admin/criteria/addCriteria', $data);
   }

   public function save_criteria() {
      if ($this->input->is_ajax_request() == true) {
         $code_criteria = $this->input->post('code_criteria', true);
         $aspect_id = $this->input->post('aspect_id', true);
         $criteria = $this->input->post('criteria', true);
         $persentase = $this->input->post('persentase', true);
         $target = $this->input->post('target', true);
         $factor_id = $this->input->post('factor_id', true);
   
         $this->form_validation->set_rules('criteria', 'Nama Kriteria', 'required', ['required' => '%s tidak boleh kosong']);
         $this->form_validation->set_rules('persentase', 'Persentase', 'required|numeric', ['required' => '%s tidak boleh kosong', 'numeric' => '%s harus berupa angka']);
         $this->form_validation->set_rules('target', 'Target', 'required|numeric', ['required' => '%s tidak boleh kosong', 'numeric' => '%s harus berupa angka']);
         
         if ($this->form_validation->run() == TRUE) {
            $data = array(
               'code_criteria' => $code_criteria,
               'aspect_id' => $aspect_id,
               'factor_id' => $factor_id,
               'name' => $criteria,
               'persentase' => $persentase,
               'target' => $target
            );

            $save = $this->M_criteria->save_criteria($data);

            if ($save) {
               $msg = ['success' => 'Criteria berhasil disimpan'];
            } else {
               $msg = ['error' => 'Gagal menyimpan criteria'];
            }
         } else {
            $msg = ['error' => validation_errors()];
         }
         echo json_encode($msg);
      }
   }

   public function edit_criteria($id = null) {
      if ($id != null) {
         $data['datac'] = $this->M_criteria->get_criteria_by_id($id);
         $data['aspect'] = $this->M_aspect->get_all_aspect();
         $data['factor'] = $this->M_factor->get_all_factor();
         $this->template->load('spk/template_admin', 'spk/admin/criteria/editCriteria', $data);
      } else {
         if($this->input->is_ajax_request() == true) {
            $id = $this->input->post('criteria_id', true);
            $code_criteria = $this->input->post('code_criteria', true);
            $aspect_id = $this->input->post('aspect_id', true);
            $criteria = $this->input->post('criteria', true);
            $persentase = $this->input->post('persentase', true);
            $target = $this->input->post('target', true);
            $factor_id = $this->input->post('factor_id', true);
      
            $this->form_validation->set_rules('criteria', 'Nama Kriteria', 'required', ['required' => '%s tidak boleh kosong']);
            $this->form_validation->set_rules('persentase', 'Persentase', 'required|numeric', ['required' => '%s tidak boleh kosong', 'numeric' => '%s harus berupa angka']);
            $this->form_validation->set_rules('target', 'Target', 'required|numeric', ['required' => '%s tidak boleh kosong', 'numeric' => '%s harus berupa angka']);
            
            if ($this->form_validation->run() == TRUE) {
               $data = array(
                  'code_criteria' => $code_criteria,
                  'aspect_id' => $aspect_id,
                  'factor_id' => $factor_id,
                  'name' => $criteria,
                  'persentase' => $persentase,
                  'target' => $target
               );

               $update = $this->M_criteria->update_criteria($id, $data);

               if ($update) {
                  $msg = ['success' => 'Criteria berhasil disimpan'];
               } else {
                  $msg = ['error' => 'Gagal menyimpan criteria'];
               }
            } else {
               $msg = ['error' => validation_errors()];
            }
            echo json_encode($msg);
         }
      }
   }

   function delete_criteria() {
      if ($this->input->is_ajax_request() == true) {
         $id = $this->input->post('id', true);
         $delete = $this->M_criteria->delete_criteria($id);

         if ($delete) {
            $msg = ['success' => 'Criteria Berhasil Terhapus'];
         } else {
            $msg = ['error' => 'Gagal menghapus criteria: '. $this->db->error()['message']];
         }
         echo json_encode($msg);
      }
   }
}
