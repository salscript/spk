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
      
      $this->template->load('spk/template_admin', 'spk/admin/division/adddivision' );
   }
   public function save_division()
    {
        $name = $this->input->post('division_name');
        $data = [
            'name' => $name,  
        ];

        $this->M_division->insert_division($data);
        redirect('division');
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
