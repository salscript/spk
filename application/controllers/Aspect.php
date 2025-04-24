<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Aspect extends MY_Controller
{
   public function __construct()
   {
      parent::__construct();
      cek_login();
      check_admin();
      $this->load->model('M_aspect');
   }

   public function aspect()
   {
      $data['aspect'] = $this->M_aspect->get_all_aspect();
      $this->template->load('spk/template_admin', 'spk/admin/aspect/index', $data);
   }
}
