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
   }

   public function criteria()
   {
      $data['criteria'] = $this->M_criteria->get_all_criteria();
      $this->template->load('spk/template_admin', 'spk/admin/criteria/index', $data);
   }
   
   public function new_criteria()
   {
      $data['code_criteria'] = $this->M_criteria->code_criteria();
      // $data['code_user'] = $this->M_user->code_user();
      // $data['role'] = $this->M_userrole->get_all_roles();
      
      $this->template->load('spk/template_admin', 'spk/admin/criteria/addcriteria', $data);
   }
}
