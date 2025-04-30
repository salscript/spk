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
        u.role_id as role_id,
        u.status as status,
        u.avatar as avatar,
        e.fullname as fullname,
        e.address as alamat,
        e.no_telp as nomortelepon,
        e.position_id as position_id,
        d.division_id as division_id
    
");
$this->db->from('user u');
$this->db->join('employee e', 'e.user_id = u.id', 'left');
$this->db->join('employee_division d', 'd.employee_id = e.id', 'left');
$this->db->order_by('u.id', 'DESC');
return $this->db->get()->result();
    }



    function get_user_by_id($id)
    {
       $this->db->select("
            u.id as id,
            u.code_user as code_user,
            u.email as email,
            u.role_id as role_id,
            u.status as status,
            u.avatar as avatar,
            e.fullname as fullname,
            e.address as alamat,
            e.no_telp as nomortelepon,
            e.position_id as position_id,
            d.division_id as division_id
           
    ");
    
    $this->db->from('user u');
    $this->db->join('employee e', 'e.user_id = u.id', 'left');
    $this->db->join('employee_division d', 'd.employee_id = e.id', 'left');
    $this->db->order_by('u.id', 'DESC');
    return $this->db->get()->result();
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

    function get_users()
    {
        $this->db->join('role', 'user.role_id = role.id', 'left');
        $this->db->join('divisi', 'user.division_id = division.id_division', 'left');
        $this->db->order_by('user.created_on', 'ASC');

        return $this->db->get('user')->result();
    }

    function get_user($code_user)
    {
        $this->db->join('client', 'user.' . $code_user . '= client.user_code', 'left');
        $this->db->join('company', 'client.company_id = company.id_company', 'left');
        $this->db->join('application', 'client.company_id = application.company_id', 'left');
        return $this->db->get('user')->result();
    }

    function get_all_data()
    {
        return $this->db->get('user')->result();
    }

    function get_all_data_user()
    {
        $this->db->where('role_id', 3);
        return $this->db->get('user')->result();
    }

    function get_sender_name($sender)
    {
        $this->db->where('id_user', $sender);
        $query = $this->db->get('user');
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                return $row->fullname;
            }
        }
        return null;
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


    function save_user($code_user, $fullname, $email, $password, $position, $division, $address, $nomortelepon, $role, $status, $avatar, $update)
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
    }

    function update_user($user_id, $fullname, $email, $password, $position, $division, $address, $nomortelepon, $role, $status, $avatar, $updated_on) 
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
}


public function delete_user($user_id)
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

