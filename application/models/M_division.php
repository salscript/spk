<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_division extends CI_Model
{

   function get_all_division()
   {
      return $this->db->get('division')->result();
   }
   
   public function insert_division($data)
   {
       return $this->db->insert('division', $data);
   }

   public function get_by_id($id)
   {
       return $this->db->get_where('division', ['id' => $id])->row();
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
