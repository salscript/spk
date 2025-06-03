<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_division extends CI_Model
{

    function get_all_division()
    {
        return $this->db->get('division')->result();
    }

    function get_division_by_id($id) {
        $this->db->where('id', $id);
        return $this->db->get('division')->row();
    }

    function get_division_by_user_id($id) {
        $this->db->select('d.*');
        $this->db->from('division d');
        $this->db->join('employee_division ed', 'ed.division_id=d.id', 'left');
        $this->db->join('employee e', 'e.id=ed.employee_id', 'left');
        $this->db->where('e.user_id', $id);
        return $this->db->get()->result();
    }

    public function insert_division($data)
    {
        return $this->db->insert('division', $data);
    }
    
    public function update_division($id, $data)
    {
            $this->db->where('id', $id);
            return $this->db->update('division', $data);
    }

    function delete_user_divisions($employee_id){
        $this->db->where('employee_id', $employee_id);
        return $this->db->delete('employee_division');
    }

    public function delete_division($id)
    {
        return $this->db->delete('division', ['id' => $id]);
    }
    public function get_division_by_employee($employee_id) {
    $this->db->select('d.id, d.name');
    $this->db->from('division d');
    $this->db->join('employee_division ed', 'd.id = ed.division_id');
    $this->db->where('ed.employee_id', $employee_id);
    return $this->db->get()->row_array();
}
}
