<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_subkriteria extends CI_Model
{

   function get_all_subkriteria()
   {
      return $this->db->get('sub_criteria')->result();
   }

   function get_subkriteria_by_id($id) {
        $this->db->where('id', $id);
        return $this->db->get('sub_criteria')->row();
   }

   function code_subkriteria()
    {
        $q = $this->db->query("SELECT MAX(RIGHT(code_sub_criteria,4)) AS code_sub_criteria FROM sub_criteria");
        $kd = "";
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $k) {
                $tmp = ((int) $k->code_sub_criteria) + 1;
                $kd = sprintf("%04s", $tmp);
            }
        } else {
            $kd = "0001";
        }
        // date_default_timezone_set('Asia/Jakarta');
        return "ASP" . $kd;
    }

    function save_subkriteria($criteria_id, $code_subkriteria, $name, $bobot, $created_on) {
        $simpan = [
            'criteria_id' => $criteria_id,
            'code_sub_criteria' => $code_subkriteria,
            'name' => $name,
            'value' => $bobot,
            'created_on' => $created_on
        ];

        // var_dump($simpan);
        return $this->db->insert('sub_criteria', $simpan);
    }

    function update_subkriteria($id, $name, $bobot, $updated_on) {
        $update = [
            'name' => $name,
            'bobot' => $bobot,
            'updated_on' => $updated_on
        ];

        $this->db->where('id', $id);
        return $this->db->update('sub_criteria', $update);

    }

    public function delete_subkriteria($id)
    {
        return $this->db->delete('sub_criteria', ['id' => $id]);
    }
}
