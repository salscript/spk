<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_user extends CI_Model
{
    function get_all_users()
    {
        $this->db->select("
            u.id as id,
            u.email as email,
            u.role_id as role_id,
            u.status as status,
            u.avatar as avatar,
            e.fullname as fullname,
            e.position_id as position_id
        ");
        $this->db->from('user u');
        $this->db->join('employee e', 'e.user_id = u.id', 'left');
        $this->db->order_by('u.id', 'DESC');
        return $this->db->get()->result();
    }

    function get_user_by_id($id)
    {
        $this->db->select("
            u.id as id,
            u.code_user as code_user,
            u.email as email,
            u.password as password,
            u.role_id as role_id,
            u.status as status,
            e.fullname as fullname,
            e.position_id as position_id
        ");
        $this->db->from('user u');
        $this->db->join('employee e', 'e.user_id = u.id');
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
        // date_default_timezone_set('Asia/Jakarta');
        return "USR" . $kd;
    }

    function get_users()
    {
        $this->db->join('role', 'user.role_id = role.id', 'left');
        // $this->db->join('divisi', 'user.divisi_id = divisi.id_divisi', 'left');
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



    function save_user($code_user, $fullname, $email, $password, $company, $divisi, $role, $status, $avatar, $update)
    {
        $simpan = [
            'code_user' => $code_user,
            'fullname' => $fullname,
            'email' => $email,
            'password' => $password,
            'company_id' => $company,
            'divisi_id' => $divisi,
            'role_id' => $role,
            'status' => $status,
            'avatar' => $avatar,
            'updated_at' => $update
        ];

        // var_dump($simpan);
        $this->db->insert('user', $simpan);
    }

    function data_user($id)
    {
        $this->db->join('user_role', 'user.role_id = user_role.id_role', 'left');
        $this->db->join('company', 'user.company_id = company.id_company', 'left');
        $this->db->join('divisi', 'user.divisi_id = divisi.id_divisi', 'left');
        $this->db->where('id', $id);
        return $this->db->get('user')->row();
    }

    function update_user($id_user, $fullname, $email, $password, $company, $divisi, $role, $status, $update)
    {
        $update = [
            'id_user' => $id_user,
            'email' => $email,
            'password' => $password,
            'fullname' => $fullname,
            'company_id' => $company,
            'divisi_id' => $divisi,
            'role_id' => $role,
            'status' => $status,
            'updated_at' => $update
        ];
        // var_dump($update);
        $this->db->where('id_user', $id_user);
        $this->db->update('user', $update);
    }

    public function delete_user($id)
    {
        return $this->db->delete('user', ['id_user' => $id]);
    }

    function update_account($id_user, $data)
    {
        $this->db->where('id_user', $id_user);
        return $this->db->update('user', $data);
    }

    function update_password($id_user, $new_pass)
    {
        $update = ['password' => $new_pass];
        $this->db->where('id_user', $id_user);
        return $this->db->update('user', $update);
    }

    function jumlah_user()
    {
        $this->db->select('*');
        $this->db->from('user');
        // $this->db->where('status_ticket', 2);

        return $this->db->get()->num_rows();
    }

    function user_divisi()
    {
        $divisi = $this->session->divisi_id;

        $this->db->select('*');
        $this->db->from('user');
        $this->db->where('divisi_id', $divisi);

        return $this->db->get()->num_rows();
    }
}
