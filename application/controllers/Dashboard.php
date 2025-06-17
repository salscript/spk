<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends MY_Controller
{
   public function __construct()
   {
      parent::__construct();
      cek_login();
   }

   public function admin()
   {
      check_admin();
      $data = array();
      $this->template->load('spk/template_admin', 'spk/admin/dashboard', $data);
   }
 
   public function user()
   {
      check_user();
      $data = array();
      $this->template->load('spk/template_user', 'spk/user/dashboard', $data);
   }

   public function operator()
   {
      check_operator();
      $data = array();
      $this->template->load('spk/template_operator', 'spk/operator/dashboard', $data);
   }
}
