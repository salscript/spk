<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_auth extends CI_Model
{
   function validate($email, $password)
   {
      $this->db->where('email', $email);
      $this->db->where('password', $password);
      return $this->db->get('user')->row();
   }
}
