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
      
      
      $this->template->load('spk/template_admin', 'spk/admin/division/adddivision');
   }
}
