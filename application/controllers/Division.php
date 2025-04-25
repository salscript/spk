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
         $data['division'] = $this->M_division->get_by_id($id);
         $this->template->load('spk/template_admin', 'spk/admin/division/editdivision', $data);
     }
 
     // Update data (optional)
     public function update_division()
     {
         $id   = $this->input->post('id');
         $name = $this->input->post('division_name');
         
         $data = [
             'name' => $name,
         ];
 
         $this->M_division->update_division($id, $data);
         redirect('division');
     }
 
     // Hapus data (optional)
     public function delete_division($id)
     {
         $this->M_division->delete_division($id);
         redirect('division');
     }
}
