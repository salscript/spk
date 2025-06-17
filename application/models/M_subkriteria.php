<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_subkriteria extends CI_Model
{

    function get_all_subkriteria()
    {
        $this->db->select("
            sc.id as id,
            sc.code_sub_criteria as code,
            sc.name as sub_name,
            sc.value as value,
            c.name as criteria_name
        ");
        $this->db->from('sub_criteria sc');
        $this->db->join('criteria c', 'c.id=sc.criteria_id', 'left');
        return $this->db->get()->result();
    }

    function get_subkriteria_by_id($id) {
        $this->db->select("
            sc.id as id,
            sc.code_sub_criteria as code,
            sc.name as sub_name,
            sc.value as value,
            c.id as criteria_id,
            c.name as criteria_name
        ");
        $this->db->from('sub_criteria sc');
        $this->db->join('criteria c', 'c.id=sc.criteria_id', 'left');
        $this->db->where('sc.id', $id);
        return $this->db->get()->row();
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

    function save_subkriteria($code, $criteria_id, $name, $bobot, $created_on) {
        $simpan = [
            'code_sub_criteria' => $code,
            'criteria_id' => $criteria_id,
            'name' => $name,
            'value' => $bobot,
            'created_on' => $created_on
        ];

        // var_dump($simpan);
        return $this->db->insert('sub_criteria', $simpan);
    }

    function update_subkriteria($id, $criteria_id, $name, $bobot, $updated_on) {
        $update = [
            'criteria_id' => $criteria_id,
            'name' => $name,
            'value' => $bobot,
            'updated_on' => $updated_on
        ];

        $this->db->where('id', $id);
        return $this->db->update('sub_criteria', $update);

    }

    public function delete_subkriteria($id)
    {
        return $this->db->delete('sub_criteria', ['id' => $id]);
    }

    public function get_grouped()
{
    $result = [];
    $query = $this->db->order_by('criteria_id', 'ASC')->order_by('value', 'DESC')->get('sub_criteria')->result();

    foreach ($query as $row) {
        $result[$row->criteria_id][] = $row;
    }

    return $result;
}
public function get_subkriteria_by_value($criteria_id, $value)
{
    $this->db->where('criteria_id', $criteria_id);
    $this->db->where('value', $value); // nilai harus sama
    return $this->db->get('sub_criteria')->row();
}

public function get_subkriteria_by_name($criteria_id, $name)
{
    $this->db->where('criteria_id', $criteria_id);
    $this->db->where('name', $name); // cocokkan tepat dengan nama seperti "Staff"
    return $this->db->get('sub_criteria')->row();
}


}
