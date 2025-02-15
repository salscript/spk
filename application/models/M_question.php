<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_question extends CI_Model
{

   function get_all_questions()
   {
      return $this->db->get('question')->result();
   }
}
