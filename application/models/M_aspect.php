<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_aspect extends CI_Model
{

   function get_all_aspect()
   {
      return $this->db->get('aspect')->result();
   }
   function code_aspect()
    {
        $q = $this->db->query("SELECT MAX(RIGHT(code_aspect,4)) AS code_aspect FROM aspect");
        $kd = "";
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $k) {
                $tmp = ((int) $k->code_aspect) + 1;
                $kd = sprintf("%04s", $tmp);
            }
        } else {
            $kd = "0001";
        }
        // date_default_timezone_set('Asia/Jakarta');
        return "ASP" . $kd;
    }
}
