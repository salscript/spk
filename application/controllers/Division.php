<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Division extends MY_Controller
{
   public function __construct()
   {
      parent::__construct();
      cek_login();
      check_admin();
      $this->load->model('M_division');
   }

   public function division()
   {
      $data['division'] = $this->M_division->get_all_division();
      $this->template->load('spk/template_admin', 'spk/admin/division/index', $data);
   }
   
   public function new_division()
   {
        $this->template->load('spk/template_admin', 'spk/admin/division/addDivision' );
   }

   public function save_division()
    {
        if ($this->input->is_ajax_request() == true) {
            $name = $this->input->post('division');

            $this->form_validation->set_rules('division', 'Nama Division', 'required', ['required' => '%s tidak boleh kosong']);

            if ($this->form_validation->run() == TRUE) {
                $data = [
                    'name' => $name,  
                ];
        
                $save = $this->M_division->insert_division($data);
                
                if ($save) {
                    $msg = ['success' => 'Division berhasil disimpan'];
                } else {
                    $msg = ['error' => 'Gagal menyimpan division: '. $this->db->error()['message']];
                }
            } else {
                $msg = ['error' => validation_errors()];
            }
            
            echo json_encode($msg);
        }
    }

     // Edit data (optional)
     public function edit_division($id)
     {
         $data['division'] = $this->M_division->get_division_by_id($id);
         $this->template->load('spk/template_admin', 'spk/admin/division/editDivision', $data);
     }
 
     // Update data (optional)
     public function update_factor()
   {
      if ($this->input->is_ajax_request() == true) {
         $id = $this->input->post('id', true);
         $name = $this->input->post('division', true);
         $updated_on = date("Y-m-d H:i:s");

         $this->form_validation->set_rules('division', 'Division', 'required', ['required' => '%s tidak boleh kosong']);
        
         if ($this->form_validation->run() == TRUE) {
            $update = $this->M_division->update_division($id, $name, $updated_on);
            if ($update) {
               $msg = ['success' => 'division berhasil diupdated'];
            } else {
               $msg = ['error' => 'Gagal mengupdate division: '. $this->db->error()['message']];
            }
         } else {
            $msg = ['error' => validation_errors()];
         }

         echo json_encode($msg);
      }
    }
    
      public function delete_division() {
        if ($this->input->is_ajax_request() == true) {
           $id = $this->input->post('id_division', true);
           $delete = $this->M_division->delete_division($id);
  
           if ($delete) {
              $msg = ['success' => 'Division Berhasil Terhapus'];
           } else {
              $msg = ['error' => 'Gagal menghapus division: '. $this->db->error()['message']];
           }
           echo json_encode($msg);
        }
     }
}
