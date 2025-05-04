<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_user extends CI_Model
{
    function get_all_users()
    {
        $this->db->select("
            u.id as id,
            u.code_user as code_user,
            u.email as email,
            u.status as status,
            u.avatar as avatar,
            e.fullname as fullname,
            e.address as alamat,
            e.no_telp as nomortelepon,
            p.name as position_name,
            r.name as role_name
        ");
        $this->db->from('user u');
        $this->db->join('employee e', 'e.user_id = u.id', 'left');
        $this->db->join('position p', 'p.id = e.position_id', 'left');
        $this->db->join('role r', 'r.id = u.role_id', 'left');
        $this->db->order_by('u.id', 'DESC');
        return $this->db->get()->result();
    }

    function get_user_by_id($id) {
        $this->db->select("
            u.id as id,
            u.code_user as code_user,
            u.email as email,
            u.password as password,
            u.status as status,
            u.role_id as role_id,
            e.fullname as fullname,
            e.address as alamat,
            e.position_id as position_id,
            e.no_telp as nomortelepon,
        ");
        $this->db->from('user u');
        $this->db->join('employee e', 'e.user_id = u.id', 'left');
        $this->db->join('position p', 'p.id = e.position_id', 'left');
        $this->db->join('role r', 'r.id = u.role_id', 'left');
        $this->db->where('u.id', $id);
        return $this->db->get()->row();
    }


    function code_user()
    {
        $q = $this->db->query("SELECT MAX(RIGHT(code_user,4)) AS code_user FROM user");
        $kd = "";
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $k) {
                $tmp = ((int) $k->code_user) + 1;
                $kd = sprintf("%04s", $tmp);
            }
        } else {
            $kd = "0001";
        }
        date_default_timezone_set('Asia/Jakarta');
        return "USR" . $kd;
    }

    function get_password($id)
    {
        $this->db->where('id_user', $id);
        $query = $this->db->get('user');
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                return $row->password;
            }
        }
        return null;
    }

    function get_employee_id_by_user($id_user){
        return $this->db->get_where('employee', ['user_id' => $id_user])->row('id');
    }
    
    function save_user($code_user, $email, $password, $role, $status, $avatar, $create) {
        $data_user = [
            'code_user' => $code_user,
            'email' => $email,
            'password' => $password,
            'role_id' => $role,
            'status' => $status,
            'avatar' => $avatar,
            'created_on' => $create
        ];

        $this->db->insert('user', $data_user);
        return $this->db->insert_id();
    }

    function save_biodata($user_id, $fullname, $address, $no_telp, $position, $create) {
        $data_employee = [
            'user_id' => $user_id,
            'fullname' => $fullname,
            'address' => $address,
            'no_telp'=> $no_telp,
            'position_id' => $position,
            'created_on' => $create
        ];

        $this->db->insert('employee', $data_employee);
        return $this->db->insert_id();
    }

    function save_division($insert_batch) {
        return $this->db->insert_batch('employee_division', $insert_batch);
    }

    function update_user($id_user, $password, $role, $status, $update) {
        $data_user = [
            'password' => $password,
            'role_id' => $role,
            'status' => $status,
            'updated_on' => $update
        ];

        $this->db->where('id', $id_user);
        return $this->db->update('user', $data_user);
    }

    function update_employee($id_user, $fullname, $position, $address, $nomortelepon, $update) {
        $data_employee = [
            'user_id' => $id_user,
            'fullname' => $fullname,
            'address' => $address,
            'no_telp'=> $nomortelepon,
            'position_id' => $position,
            'updated_on' => $update
        ];

        $this->db->where('user_id', $id_user);
        return $this->db->update('employee', $data_employee);
    }

    /**function save_user($code_user, $fullname, $email, $password, $position, $division, $address, $nomortelepon, $role, $status, $avatar, $update)
    {
        // Simpan ke tabel user
        $data_user = [
            'code_user' => $code_user,
            'email' => $email,
            'password' => $password,
            'role_id' => $role,
            'status' => $status,
            'avatar' => $avatar,
            'updated_on' => $update
        ];
        $this->db->insert('user', $data_user);
        $user_id = $this->db->insert_id(); // Ambil ID dari user baru
    
        // Simpan ke tabel employee
        $data_employee = [
            'user_id' => $user_id,
            'fullname' => $fullname,
            'address' => $address,
            'no_telp' => $nomortelepon
        ];
        $this->db->insert('employee', $data_employee);
        $employee_id = $this->db->insert_id();
    
        // Simpan ke tabel employee_division
        $data_employee_division = [
            'employee_id' => $employee_id,
            'division_id' => $division
        ];
        $this->db->insert('employee_division', $data_employee_division);
    } */

    /**function update_user($user_id, $fullname, $email, $password, $position, $division, $address, $nomortelepon, $role, $status, $avatar, $updated_on) 
    {
    // Update data di tabel user
        $data_user = [
            'email' => $email,
            'password' => $password,
            'role_id' => $role,
            'status' => $status,
            'avatar' => $avatar,
            'updated_on' => $updated_on
        ];
        $this->db->where('id', $user_id);
        $this->db->update('user', $data_user);

        // Update data di tabel employee
        $data_employee = [
            'fullname' => $fullname,
            'address' => $address,
            'no_telp' => $nomortelepon
        ];
        $this->db->where('user_id', $user_id);
        $this->db->update('employee', $data_employee);

    // Ambil employee_id berdasarkan user_id
        $employee = $this->db->get_where('employee', ['user_id' => $user_id])->row();
        if ($employee) {
            $data_employee_division = [
                'division_id' => $division
            ];
            $this->db->where('employee_id', $employee->id);
            $this->db->update('employee_division', $data_employee_division);
        }
    }*/


    function delete_user($user_id)
    {
        // Hapus employee_division berdasarkan user_id
        $employee = $this->db->get_where('employee', ['user_id' => $user_id])->row();
        if ($employee) {
            $this->db->delete('employee_division', ['employee_id' => $employee->id]);
            $this->db->delete('employee', ['id' => $employee->id]);
        }

        // Hapus user
        return $this->db->delete('user', ['id' => $user_id]);
    }

}

