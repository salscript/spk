<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_auth extends CI_Model
{
   function validate($email, $password)
   {
      $this->db->select(" 
            u.id as id_user,
            u.code_user as code_user,
            u.email as email,
            u.role_id as role_id,
            u.avatar as avatar,
            u.status as status,
            e.fullname as fullname
      ");
      $this->db->from('user u');
      $this->db->join('employee e', 'e.user_id = u.id');
      $this->db->where('u.email', $email);
      $this->db->where('u.password', $password);
      return $this->db->get()->row();

      // print_r($this->db->get()->row());

      // $query = $this->db->get();
      // return $query->row();
      // return $this->db->query($sql, array($email, $password));

      // $this->db->where('email', $email);
      // $this->db->where('password', $password);
      // return $this->db->get('user')->row();
   }
}
