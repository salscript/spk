<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Aspect extends MY_Controller
{
   public function __construct()
   {
      parent::__construct();
      cek_login();
      check_admin();
   }

   public function aspect()
   {
         $this->template->load('spk/template_admin', 'spk/admin/aspect/index');
   }
}
