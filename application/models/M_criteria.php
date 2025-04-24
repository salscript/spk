<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_criteria extends CI_Model
{

   function get_all_criteria()
   {
      return $this->db->get('criteria')->result();
   }
   function code_criteria()
    {
        $q = $this->db->query("SELECT MAX(RIGHT(code_criteria,4)) AS code_criteria FROM criteria");
        $kd = "";
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $k) {
                $tmp = ((int) $k->code_criteria) + 1;
                $kd = sprintf("%04s", $tmp);
            }
        } else {
            $kd = "0001";
        }
        // date_default_timezone_set('Asia/Jakarta');
        return "CRI" . $kd;
    }
}
