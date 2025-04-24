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
      // $data['code_user'] = $this->M_user->code_user();
      // $data['role'] = $this->M_userrole->get_all_roles();
      
      $this->template->load('spk/template_admin', 'spk/admin/factor/addfactor', $data);
   }
}
