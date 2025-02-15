<?php
defined('BASEPATH') or exit('No direct script access allowed');

class UserRole extends MY_Controller
{
   public function __construct()
   {
      parent::__construct();
      cek_login();
      $this->load->model('M_userrole');
   }

   public function user_roles()
   {
      check_admin();
      $data['role'] = $this->M_userrole->get_all_roles();
      $this->template->load('spk/template_admin', 'spk/admin/user_roles/index', $data);
   }
}
