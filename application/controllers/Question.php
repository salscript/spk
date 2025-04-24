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
      $this->load->model('M_criteria');
   }

   public function question()
   {
      $data['question'] = $this->M_question->get_all_questions();
      $this->template->load('spk/template_admin', 'spk/admin/question/index', $data);
   }
   public function new_question()
   {
      $data['code_question'] = $this->M_question->code_question();
      $data['criteria'] = $this->M_criteria->get_all_criteria();
      
      $this->template->load('spk/template_admin', 'spk/admin/question/addQuestion', $data);
   }
}
