<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Question extends MY_Controller
{
   public function __construct()
   {
      parent::__construct();
      cek_login();
      check_admin();
      $this->load->model('M_question');
   }

   public function question()
   {
      $data['question'] = $this->M_question->get_all_questions();
      $this->template->load('spk/template_admin', 'spk/admin/question/index', $data);
   }
}
