<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_penilaian extends CI_Model
{
    // Menyimpan banyak data nilai aktual sekaligus
    public function insert_batch($data)
    {
        return $this->db->insert_batch('nilai_aktual', $data);
    }

    // Ambil semua data periode (questioner)
    public function get_all_periode()
    {
        return $this->db->get('questioner')->result();
    }

    // Ambil kriteria berdasarkan aspek tertentu
    public function get_criteria_by_aspect($aspect_id)
    {
        return $this->db->get_where('criteria', ['aspect_id' => $aspect_id])->result();
    }

    // Cek apakah nilai aktual sudah ada (untuk validasi edit/hapus atau mencegah duplikasi)
    public function cek_nilai_exist($employee_id, $criteria_id, $questioner_id)
    {
        return $this->db->get_where('nilai_aktual', [
            'employee_id' => $employee_id,
            'criteria_id' => $criteria_id,
            'questioner_id' => $questioner_id
        ])->num_rows() > 0;
    }

    // Ambil semua nilai aktual berdasarkan periode tertentu (opsional untuk preview)
    public function get_nilai_by_questioner($questioner_id)
    {
        $this->db->select('n.*, e.fullname, c.name as criteria_name, s.name as subkriteria_name');
        $this->db->from('nilai_aktual n');
        $this->db->join('employee e', 'e.id = n.employee_id');
        $this->db->join('criteria c', 'c.id = n.criteria_id');
        $this->db->join('sub_criteria s', 's.id = n.subkriteria_id');
        $this->db->where('n.questioner_id', $questioner_id);
        return $this->db->get()->result();
    }

    // Hapus nilai aktual berdasarkan periode (jika perlu)
    public function delete_by_questioner($questioner_id)
    {
        $this->db->where('questioner_id', $questioner_id);
        return $this->db->delete('nilai_aktual');
    }

    public function nilai_aktual_exists($employee_id, $criteria_id, $questioner_id)
{
    return $this->db->get_where('nilai_aktual', [
        'employee_id' => $employee_id,
        'criteria_id' => $criteria_id,
        'questioner_id' => $questioner_id
    ])->num_rows() > 0;
}

public function sudah_ada_nilai($questioner_id)
{
    $this->db->where('questioner_id', $questioner_id);
    return $this->db->count_all_results('nilai_aktual') > 0;
}

public function sudah_input_aspek($questioner_id, $aspect_id)
{
    $this->db->select('na.id');
    $this->db->from('nilai_aktual na');
    $this->db->join('criteria c', 'c.id = na.criteria_id');
    $this->db->where('na.questioner_id', $questioner_id);
    $this->db->where('c.aspect_id', $aspect_id);
    $query = $this->db->get();
    return $query->num_rows() > 0;
}

public function is_all_aspect_completed($questioner_id)
{
    $aspek_total = $this->db->count_all('aspect');

    $this->db->select('DISTINCT c.aspect_id', false);
    $this->db->from('nilai_aktual na');
    $this->db->join('criteria c', 'c.id = na.criteria_id');
    $this->db->where('na.questioner_id', $questioner_id);
    $aspek_terisi = $this->db->get()->num_rows();

    return $aspek_terisi == $aspek_total;
}

public function get_rata_rata_per_kriteria()
{
    return $this->db->select('c.name AS kriteria, AVG(sc.value) AS nilai')
        ->from('nilai_aktual na')
        ->join('criteria c', 'c.id = na.criteria_id')
        ->join('sub_criteria sc', 'sc.id = na.subkriteria_id') // ✅ gunakan sub_criteria
        ->group_by('c.id')
        ->get()
        ->result();
}



public function get_top_karyawan($limit = 5)
{
    return $this->db->select('e.fullname, p.name as position_name, SUM(sc.value) as nilai')
        ->from('nilai_aktual na')
        ->join('employee e', 'e.id = na.employee_id')
        ->join('sub_criteria sc', 'sc.id = na.subkriteria_id')
        ->join('position p', 'p.id = e.position_id') // jika kamu ingin tampilkan posisi juga
        ->group_by('na.employee_id')
        ->order_by('nilai', 'DESC')
        ->limit($limit)
        ->get()->result();
}


}
