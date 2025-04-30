<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_criteria extends CI_Model
{

    function get_all_criteria()
    {
        $this->db->select("
            c.id as id,
            c.code_criteria as code, 
            c.name as criteria, 
            c.persentase as persentase, 
            c.target as target, 
            a.name as aspect, 
            f.name as factor
        ");
        $this->db->from("criteria c");
        $this->db->join("aspect a", "a.id = c.aspect_id", "left");
        $this->db->join("factor f", "f.id = c.factor_id", "left");
        return $this->db->get()->result();
    }

    function get_criteria_by_id($id) {
        $this->db->select("
            c.id as id,
            c.code_criteria as code, 
            c.name as criteria, 
            c.persentase as persentase, 
            c.target as target,
            a.id as aspect_id,
            a.name as aspect, 
            f.id as factor_id,
            f.name as factor
        ");
        $this->db->from("criteria c");
        $this->db->join("aspect a", "a.id = c.aspect_id", "left");
        $this->db->join("factor f", "f.id = c.factor_id", "left");
        $this->db->where("c.id", $id);
        return $this->db->get()->row();
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

    function save_criteria($data) {
        return $this->db->insert('criteria', $data);
    }

    function update_criteria($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('criteria', $data);
    }

    public function delete_criteria($id)
    {
        return $this->db->delete('criteria', ['id' => $id]);
    }
}
