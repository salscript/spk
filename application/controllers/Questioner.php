<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Questioner extends MY_Controller
{
   public function __construct()
   {
      parent::__construct();
      cek_login();
      $this->load->model('M_question');
   }

   public function questioner()
   {
      // $data['question'] = $this->M_question->get_all_questions();
      $this->template->load('spk/template_admin', 'spk/admin/questioner/index');
   }

   public function questioner_user()
   {
      // $data['question'] = $this->M_question->get_all_questions();
      $this->template->load('spk/template_user', 'spk/user/questioner/index');
   }

}
