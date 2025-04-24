<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_aspect extends CI_Model
{

   function get_all_aspect()
   {
      return $this->db->get('aspect')->result();
   }

   function get_aspect_by_id($id) {
        $this->db->where('id', $id);
        return $this->db->get('aspect')->row();
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

    function save_aspect($code_aspect, $name, $persentase, $created_on) {
        $simpan = [
            'code_aspect' => $code_aspect,
            'name' => $name,
            'persentase' => $persentase,
            'created_on' => $created_on,
            'updated_on' => null
        ];

        // var_dump($simpan);
        return $this->db->insert('aspect', $simpan);
    }

    function update_aspect($id, $name, $persentase, $updated_on) {
        $update = [
            'name' => $name,
            'persentase' => $persentase,
            'updated_on' => $updated_on
        ];

        $this->db->where('id', $id);
        return $this->db->update('aspect', $update);

    }

    public function delete_aspect($id)
    {
        return $this->db->delete('aspect', ['id' => $id]);
    }
}
