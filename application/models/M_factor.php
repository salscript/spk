<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_factor extends CI_Model
{

   function get_all_factor()
   {
      return $this->db->get('factor')->result();
   }
   function get_factor_by_id($id) {
    $this->db->where('id', $id);
    return $this->db->get('factor')->row();
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
    function save_factor($code_factor, $factor, $created_on) {
        $simpan = [
            'code_factor' => $code_factor,
            'name' => $factor,
            'created_on' => $created_on
        ];

        // var_dump($simpan);
        return $this->db->insert('factor', $simpan);
    }
    function update_factor($id, $factor, $updated_on) {
        $update = [
            'name' => $factor,
            'updated_on' => $updated_on
        ];

        $this->db->where('id', $id);
        return $this->db->update('factor', $update);

    }

    public function delete_factor($id)
    {
        return $this->db->delete('factor', ['id' => $id]);
    }
}
