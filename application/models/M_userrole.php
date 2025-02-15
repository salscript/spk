<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_userrole extends CI_Model
{
   function get_all_roles()
   {
      return $this->db->get('role')->result();
   }
}
