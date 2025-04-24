<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Position extends MY_Controller
{
   public function __construct()
   {
      parent::__construct();
      cek_login();
      check_admin();
      $this->load->model('M_position');
   }

   public function position()
   {
      $data['position'] = $this->M_position->get_all_position();
      $this->template->load('spk/template_admin', 'spk/admin/position/index', $data);
   }
   
   public function new_position()
   {
      $this->template->load('spk/template_admin', 'spk/admin/position/addposition');
   }
}
