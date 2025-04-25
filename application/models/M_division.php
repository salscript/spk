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
   public function insert_division($data)
   {
       return $this->db->insert('division', $data);
   }
   function save_division($division, $created_on) {
    $simpan = [
        'name' => $division,
        'created_on' => $created_on
    ];

    // var_dump($simpan);
    return $this->db->insert('division', $simpan);
}
   public function update_division($id, $data)
   {
       return $this->db->update('division', $data, ['id' => $id]);
   }

   public function delete_division($id)
   {
       return $this->db->delete('division', ['id' => $id]);
   }
}
