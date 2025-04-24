<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_aspect extends CI_Model
{

   function get_all_aspect()
   {
      return $this->db->get('aspect')->result();
   }
}
