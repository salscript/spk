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
function save_position( $position, $created_on) {
    $simpan = [
        'name' => $position,
        'created_on' => $created_on
    ];

    // var_dump($simpan);
    return $this->db->insert('position', $simpan);
}
function update_position($id, $position, $updated_on) {
    $update = [
        'name' => $position,
        'updated_on' => $updated_on
    ];

    $this->db->where('id', $id);
    return $this->db->update('position', $update);

}

public function delete_position($id)
{
    return $this->db->delete('position', ['id' => $id]);
}
}
