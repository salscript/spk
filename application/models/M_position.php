<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_position extends CI_Model
{

   function get_all_position()
   {
      return $this->db->get('position')->result();
   }
   function get_position_by_id($id) {
    $this->db->where('id', $id);
    return $this->db->get('position')->row();
}
public function save_position($position, $level_position, $created_on)
{
    return $this->db->insert('position', [
        'name' => $position,
        'level_position' => $level_position,
        'created_on' => $created_on
    ]);
}

public function update_position($id, $name, $level_position, $updated_on)
{
    return $this->db->where('id', $id)->update('position', [
        'name' => $name,
        'level_position' => $level_position,
        'updated_on' => $updated_on
    ]);
}


public function delete_position($id)
{
    return $this->db->delete('position', ['id' => $id]);
}

    // public function get_position_employee($id){
    //     $this->db->select('p.level_position');
    //     $this->db->from('position p');
    //     $this->db->join('employee e', 'e.position_id=p.id', 'left');
    //     $this->db->where('e.id', $id);
    //     return $this->db->get()->row();
    // }

    public function get_position_employee($employee_id) {
    $this->db->select('position.*');
    $this->db->from('employee');
    $this->db->join('position', 'employee.position_id = position.id', 'left');
    $this->db->where('employee.id', $employee_id);
    return $this->db->get()->row(); // Bisa saja null jika tidak ada posisi
}

}
