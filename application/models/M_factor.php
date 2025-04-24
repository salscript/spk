<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_factor extends CI_Model
{

   function get_all_factor()
   {
      return $this->db->get('factor')->result();
   }
   function code_factor()
    {
        $q = $this->db->query("SELECT MAX(RIGHT(code_factor,4)) AS code_factor FROM factor");
        $kd = "";
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $k) {
                $tmp = ((int) $k->code_factor) + 1;
                $kd = sprintf("%04s", $tmp);
            }
        } else {
            $kd = "0001";
        }
        // date_default_timezone_set('Asia/Jakarta');
        return "FAC" . $kd;
    }
}
