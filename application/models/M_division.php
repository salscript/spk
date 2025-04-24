<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_division extends CI_Model
{

   function get_all_division()
   {
      return $this->db->get('division')->result();
   }
   function code_division()
    {
        $q = $this->db->query("SELECT MAX(RIGHT(code_division,4)) AS code_division FROM division");
        $kd = "";
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $k) {
                $tmp = ((int) $k->code_division) + 1;
                $kd = sprintf("%04s", $tmp);
            }
        } else {
            $kd = "0001";
        }
        // date_default_timezone_set('Asia/Jakarta');
        return "DIV" . $kd;
    }
}
