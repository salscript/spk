<?php
class M_employee extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    // Ambil data karyawan berdasarkan user_id (termasuk divisi dan posisi)
    public function get_employee_by_user_id($user_id)
    {
        $this->db->select('e.*, ed.division_id, d.name as division_name, p.name as position_name');
        $this->db->from('employee e');
        $this->db->join('employee_division ed', 'e.id = ed.employee_id', 'left');
        $this->db->join('division d', 'ed.division_id = d.id', 'left');
        $this->db->join('position p', 'e.position_id = p.id', 'left');
        $this->db->where('e.user_id', $user_id);
        return $this->db->get()->row_array();
    }

    // Ambil id_employee berdasarkan user_id
public function get_employee_id($user_id)
{
    $this->db->select('id');
    $this->db->from('employee');
    $this->db->where('user_id', $user_id);
    $query = $this->db->get();
    if ($query->num_rows() > 0) {
        return $query->row()->id;
    }
    return null;
}

    // Ambil rekan kerja satu divisi kecuali dirinya sendiri
    public function get_colleagues($employee_id, $division_id)
    {
        $this->db->select('e.id, e.fullname, p.name as position_name, d.name as division_name');
        $this->db->from('employee e');
        $this->db->join('employee_division ed', 'e.id = ed.employee_id');
        $this->db->join('division d', 'ed.division_id = d.id');
        $this->db->join('position p', 'e.position_id = p.id', 'left');
        $this->db->where('ed.division_id', $division_id);
        $this->db->where('e.id !=', $employee_id);
        return $this->db->get()->result_array();
    }
public function is_hrd($user_id)
{
    $this->db->select('p.name');
    $this->db->from('employee e');
    $this->db->join('position p', 'e.position_id = p.id', 'left');
    $this->db->where('e.user_id', $user_id);
    $query = $this->db->get();

    if ($query->num_rows() > 0) {
        $position_name = strtolower($query->row()->name);
        return $position_name === 'hrd'; // atau gunakan strpos untuk lebih fleksibel
    }

    return false;
}
public function is_pic($user_id)
{
    $this->db->select('p.name');
    $this->db->from('employee e');
    $this->db->join('position p', 'e.position_id = p.id', 'left');
    $this->db->where('e.user_id', $user_id);
    $query = $this->db->get();

    if ($query->num_rows() > 0) {
        $position_name = strtolower($query->row()->name);
        return $position_name === 'supervisor'; // atau sesuaikan jika nama posisi di tabel bukan 'PIC'
    }

    return false;
}

  public function get_employee_details($employee_id){
    $this->db->select("
        e.id,
        e.user_id,
        e.fullname,
        e.sub_divisi,
        p.name as position_name,
        p.level_position,
        d.name as division_name
    ");
    $this->db->from("employee e");
    $this->db->join("user u", "u.id = e.user_id", 'left');
    $this->db->join("position p", "p.id = e.position_id", "left");
    $this->db->join("employee_division ed", "ed.employee_id = e.id", "left");
    $this->db->join("division d", "d.id = ed.division_id", "left");
    $this->db->where("e.id", $employee_id);
    return $this->db->get()->row();
}



    public function get_all_employees() {
    $this->db->select('employee.*, position.level_position');
    $this->db->from('employee');
    $this->db->join('position', 'employee.position_id = position.id', 'left');
    return $this->db->get()->result();
}

public function get_division_id($employee_id) {
    $this->db->select('division_id');
    $this->db->from('employee_division');
    $this->db->where('employee_id', $employee_id);
    $res = $this->db->get()->row();
    return $res ? $res->division_id : null;
}

public function get_all_aktif()
{
    $this->db->select('e.id, e.fullname, p.name as position_name, p.level_position');
    $this->db->from('employee e');
    $this->db->join('position p', 'e.position_id = p.id', 'left');
    $this->db->join('user u', 'u.id = e.user_id', 'left');
    $this->db->where_not_in('u.role_id', [1, 3]); // ❌ role_id admin dan operator
     $this->db->where_not_in('p.level_position', ['admin', 'operator', 'hrd']);
    return $this->db->get()->result();
}



}