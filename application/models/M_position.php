<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_position extends CI_Model
{

   function get_all_position()
   {
      return $this->db->get('position')->result();
   }
   function code_position()
    {
        $q = $this->db->query("SELECT MAX(RIGHT(code_position,4)) AS code_position FROM position");
        $kd = "";
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $k) {
                $tmp = ((int) $k->code_position) + 1;
                $kd = sprintf("%04s", $tmp);
            }
        } else {
            $kd = "0001";
        }
        // date_default_timezone_set('Asia/Jakarta');
        return "POS" . $kd;
    }
}
