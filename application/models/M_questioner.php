<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_questioner extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_all_questioners(){
        return $this->db->get('questioner')->result();
    }

    function code_questioner()
    {
        $q = $this->db->query("SELECT MAX(RIGHT(code_questioner,4)) AS code_questioner FROM questioner");
        $kd = "";
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $k) {
                $tmp = ((int) $k->code_questioner) + 1;
                $kd = sprintf("%04s", $tmp);
            }
        } else {
            $kd = "0001";
        }
        // date_default_timezone_set('Asia/Jakarta');
        return "QUE" . $kd;
    }

    function save_new_questioner($data){
        return $this->db->insert('questioner', $data);
    }

    // Mendapatkan semua status kuisioner (untuk admin)
    public function get_all_questioners_status() {
        return $this->db->select('qs.*, e1.fullname as evaluator_name, e2.fullname as evaluatee_name, 
                                p1.name as evaluator_position, p2.name as evaluatee_position,
                                d1.name as evaluator_division, d2.name as evaluatee_division')
            ->from('questioner_status qs')
            ->join('employee e1', 'e1.id = qs.evaluator_id')
            ->join('employee e2', 'e2.id = qs.evaluatee_id')
            ->join('position p1', 'p1.id = e1.position_id', 'left')
            ->join('position p2', 'p2.id = e2.position_id', 'left')
            ->join('employee_division ed1', 'ed1.employee_id = e1.id', 'left')
            ->join('division d1', 'd1.id = ed1.division_id', 'left')
            ->join('employee_division ed2', 'ed2.employee_id = e2.id', 'left')
            ->join('division d2', 'd2.id = ed2.division_id', 'left')
            ->order_by('qs.status ASC, qs.updated_at DESC')
            ->get()
            ->result();
    }

    // Mendapatkan kuisioner yang belum lengkap (untuk admin)
    public function get_incomplete_questioners() {
        return $this->db->select('e.id, e.fullname, p.name as position, d.name as division,
                                COUNT(CASE WHEN qs.status = "completed" THEN 1 END) as completed_count,
                                (SELECT COUNT(*) FROM employee WHERE id != e.id) as total_count')
            ->from('employee e')
            ->join('position p', 'p.id = e.position_id', 'left')
            ->join('employee_division ed', 'ed.employee_id = e.id', 'left')
            ->join('division d', 'd.id = ed.division_id', 'left')
            ->join('questioner_status qs', 'qs.evaluator_id = e.id', 'left')
            ->group_by('e.id')
            ->having('completed_count < total_count OR completed_count IS NULL')
            ->get()
            ->result();
    }

    // Mendapatkan daftar rekan kerja yang perlu dinilai
    public function get_peer_questioners($employee_id, $id) {
        $employee = $this->db->select('ed.division_id, e.sub_divisi')
            ->from('employee e')
            ->join('employee_division ed', 'ed.employee_id = e.id')
            ->where('e.id', $employee_id)
            ->get()
            ->row();
        
        if (!$employee) return array();
        
        return $this->db->select(
            'e.id, e.fullname, 
            p.name as position_name,   
            d.name as division_name,
            qs.status, 
            qs.created_on'
            )
            ->from('employee e')
            ->join('employee_division ed', 'ed.employee_id = e.id')
            ->join('division d', 'd.id = ed.division_id')
            ->join('position p', 'p.id = e.position_id')
            ->join('questioner_status qs', "qs.questioner_id = $id AND qs.evaluatee_id = e.id AND qs.evaluator_id = $employee_id AND qs.type = 'peer'", 'left')
            ->where('d.id', $employee->division_id)
            ->where('e.sub_divisi', $employee->sub_divisi)
            ->where('e.id !=', $employee_id) 
            ->get()
            ->result();
    }

    // Mendapatkan daftar bawahan yang perlu dinilai (otomatis berdasarkan divisi dan level)
    public function get_supervisor_questioners($employee_id,$id) {
        $evaluator = $this->db->select('p.level_position, ed.division_id')
            ->from('employee e')
            ->join('position p', 'p.id = e.position_id')
            ->join('employee_division ed', 'ed.employee_id = e.id')
            ->where('e.id', $employee_id)
            ->get()
            ->row();
        
        if (!$evaluator) return array();
        
        // HRD menilai semua PIC/Managerial (tanpa memandang divisi)
        if ($evaluator->level_position == 'hrd') {
            return $this->db->select('
                    e.id, e.fullname, 
                    p.name as position_name, 
                    d.name as division_name, qs.status, qs.created_on
                ')
                ->from('employee e')
                ->join('position p', 'p.id = e.position_id')
                ->join('employee_division ed', 'ed.employee_id = e.id')
                ->join('division d', 'd.id = ed.division_id')
                ->join('questioner_status qs', "qs.questioner_id = $id AND qs.evaluatee_id = e.id AND qs.evaluator_id = $employee_id AND qs.type = 'supervisor'", 'left')
                ->where('p.level_position', 'managerial')
                ->where('e.id !=', $employee_id)
                ->get()
                ->result();
        }
        // PIC/Managerial menilai staff dalam divisi yang sama
        elseif ($evaluator->level_position == 'managerial') {
            return $this->db->select('
                    e.id, e.fullname, 
                    p.name as position_name, 
                    d.name as division_name, qs.status, qs.created_on
                ')
                ->from('employee e')
                ->join('position p', 'p.id = e.position_id')
                ->join('employee_division ed', 'ed.employee_id = e.id')
                ->join('division d', 'd.id = ed.division_id')
                ->join('questioner_status qs', "qs.evaluatee_id = e.id AND qs.evaluator_id = $employee_id", 'left')
                ->where('ed.division_id', $evaluator->division_id)
                ->where('p.level_position !=', 'hrd')
                ->where('e.id !=', $employee_id)
                ->get()
                ->result();
        }
        
        return array();
    }

    
    // Cek apakah sudah pernah menilai
    public function check_already_rated($evaluator_id, $evaluatee_id, $type) {
        return $this->db->where('evaluator_id', $evaluator_id)
            ->where('evaluatee_id', $evaluatee_id)
            ->where('type', $type)
            ->where('status', 'completed')
            ->count_all_results('questioner_status') > 0;
    }

    // // Mendapatkan pertanyaan berdasarkan aspek
    //  public function get_questions_by_aspect($aspect) {
    //     return $this->db->get_where('question', ['aspect' => $aspect])->result();
    // }

    // Validasi relasi penilaian rekan kerja: evaluator dan evaluatee harus di divisi dan sub divisi sama
    public function validate_peer_relation($evaluator_id, $evaluatee_id) {
        $eval = $this->db->get_where('employee_division', ['employee_id' => $evaluator_id])->row();
        $evale = $this->db->get_where('employee_division', ['employee_id' => $evaluatee_id])->row();

        if (!$eval || !$evale) return false;

        $eval_sub_division = $this->db->get_where('employee', ['id' => $evaluator_id])->row();
        $evale_sub_division = $this->db->get_where('employee', ['id' => $evaluatee_id])->row();
        
        return ($eval->division_id == $evale->division_id && $eval_sub_division->sub_divisi == $evale_sub_division->sub_divisi);
    }

    // Validasi relasi penilaian atasan: evaluator lebih tinggi level & di divisi sama
    public function validate_supervisor_relation($evaluator_id, $evaluatee_id) {
        // Contoh logika: evaluator harus managerial (level 1), evaluatee harus non-managerial (level 2)
        // $eval = $this->db->get_where('employee_division', ['employee_id' => $evaluator_id])->row();
        // $evale = $this->db->get_where('employee_division', ['employee_id' => $evaluatee_id])->row();

        // if (!$eval || !$evale) return false;

        // return ($eval->division_id == $evale->division_id); 

        $this->db->select('e.id, e.position_id, p.name as position_name');
        $this->db->from('employee e');
        $this->db->join('position p', 'e.position_id = p.id');
        $this->db->where('e.id', $evaluator_id);
        $evaluator = $this->db->get()->row();

        if (!$evaluator) return false;

        // Jika evaluator adalah HRD (berdasarkan nama posisi)
        if (strtolower($evaluator->position_name) == 'hrd') {
            return true;
        }

        // Jika bukan HRD, cek divisinya
        $eval_div = $this->db->get_where('employee_division', ['employee_id' => $evaluator_id])->row();
        $evale_div = $this->db->get_where('employee_division', ['employee_id' => $evaluatee_id])->row();

        if (!$eval_div || !$evale_div) return false;

        return ($eval_div->division_id == $evale_div->division_id);

    }



    // Menyimpan hasil kuisioner
    public function save_questioner($evaluator_id, $evaluatee_id, $type, $post_data) {
        $this->db->trans_start();
        
        // Simpan status kuisioner
        $this->db->replace('questioner_status', [
            'evaluator_id' => $evaluator_id,
            'evaluatee_id' => $evaluatee_id,
            'type' => $type,
            'status' => 'completed',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        
        $questioner_id = $this->db->insert_id();
        
        // Simpan jawaban
        foreach ($post_data['question'] as $question_id => $nilai) {
            $this->db->insert('questioner_answers', [
                'questioner_id' => $questioner_id,
                'question_id' => $question_id,
                'nilai' => $nilai,
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }
        
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

 public function get_monitoring_kuisioner($questioner_id)
{
    $this->load->model('M_employee');
    $this->load->model('M_position');

    $employees = $this->M_employee->get_all_employees();
    $result = [];

    foreach ($employees as $evaluator) {
        $evaluator_pos = $this->M_position->get_position_employee($evaluator->id);
        $evaluator_div = $this->M_employee->get_division_id($evaluator->id);

        if (!$evaluator_pos || !$evaluator_div) continue;

        foreach ($employees as $evaluatee) {
            if ($evaluator->id == $evaluatee->id) continue;

            $evaluatee_pos = $this->M_position->get_position_employee($evaluatee->id);
            $evaluatee_div = $this->M_employee->get_division_id($evaluatee->id);

            if (!$evaluatee_pos || !$evaluatee_div) continue;

            $relation_type = null;

            // === HRD menilai semua MANAGERIAL ===
            if (
                $evaluator_pos->level_position == 'hrd' &&
                $evaluatee_pos->level_position == 'managerial'
            ) {
                $relation_type = 'supervisor';
            }
            // === SESAMA MANAGERIAL di divisi sama => PEER ===
            elseif (
                $evaluator_pos->level_position == 'managerial' &&
                $evaluatee_pos->level_position == 'managerial' &&
                $evaluator_div == $evaluatee_div
            ) {
                $relation_type = 'peer';
            }
            // === MANAGERIAL menilai SENIOR/STAFF di divisi sama => SUPERVISOR ===
            elseif (
                $evaluator_pos->level_position == 'managerial' &&
                in_array($evaluatee_pos->level_position, ['senior_staff', 'staff']) &&
                $evaluator_div == $evaluatee_div
            ) {
                $relation_type = 'supervisor';
            }
            // === REKAN KERJA di divisi & sub divisi sama => PEER ===
            elseif (
                $evaluator_div == $evaluatee_div &&
                $evaluator->sub_divisi != null &&
                $evaluator->sub_divisi == $evaluatee->sub_divisi
            ) {
                $relation_type = 'peer';
            }

            // Jika ada hubungan valid, cek apakah sudah ada di questioner_status
            if ($relation_type) {
                $this->db->where([
                    'questioner_id' => $questioner_id,
                    'evaluator_id' => $evaluator->id,
                    'evaluatee_id' => $evaluatee->id,
                    'type' => $relation_type
                ]);
                $status_row = $this->db->get('questioner_status')->row();

                $result[] = [
                    'evaluator' => $this->M_employee->get_employee_details($evaluator->id),
                    'evaluatee' => $this->M_employee->get_employee_details($evaluatee->id),
                    'type' => $relation_type,
                    'status' => $status_row ? $status_row->status : 'pending'
                ];
            }
        }
    }

    return $result;
}

public function auto_deactivate_expired_questioners()
{
    $now = date('Y-m-d H:i:s');
    $this->db->where('deadline <', $now);
    $this->db->where('status', 1); // hanya yang masih aktif
    $this->db->update('questioner', ['status' => 0]);
}

public function get_by_id($id)
{
    return $this->db->get_where('questioner', ['id' => $id])->row();
}

public function get_latest_active_questioner()
{
    $this->db->where('status', 1);
    $this->db->where('deadline >=', date('Y-m-d H:i:s'));
    $this->db->order_by('deadline', 'ASC');
    // $this->db->limit(1);
    return $this->db->get('questioner')->result();
}


public function get_questioner_by_Id($id)
{
    return $this->db->get_where('questioner', ['id' => $id])->row();
}

public function updateQuestioner($id, $data)
{
    $this->db->where('id', $id);
    return $this->db->update('questioner', $data);
}

public function get_rekap_rata_rata_kriteria($questioner_id)
{
    $this->db->select("
        e.id AS employee_id,
        e.fullname AS employee_name,
        c.id AS criteria_id,
        c.name AS criteria_name,
        a.name AS aspect_name,
        qs.type AS penilaian_type,

        COUNT(DISTINCT qa.evaluator_id) AS jumlah_penilai,

        (
            SELECT COUNT(*) FROM question q2 
            WHERE q2.criteria_id = c.id
        ) AS jumlah_pertanyaan,

        (
            SELECT COUNT(*) 
            FROM questioner_status qs2 
            WHERE qs2.questioner_id = $questioner_id 
              AND qs2.evaluatee_id = qa.evaluatee_id 
              AND qs2.type = qs.type
        ) AS expected_evaluator_count,

        SUM(qa.nilai) AS total_nilai,
        ROUND(AVG(qa.nilai), 0) AS avg_score

    ");
    $this->db->from("questioner_answers qa");
    $this->db->join("employee e", "e.user_id = qa.evaluatee_id");
    $this->db->join("question q", "q.id = qa.question_id");
    $this->db->join("criteria c", "c.id = q.criteria_id");
    $this->db->join("aspect a", "a.id = c.aspect_id");
    $this->db->join("questioner_status qs", "qs.questioner_id = qa.questioner_id AND qs.evaluator_id = qa.evaluator_id AND qs.evaluatee_id = qa.evaluatee_id");
    $this->db->where("qa.questioner_id", $questioner_id);
    $this->db->group_by(["qa.evaluatee_id", "c.id", "qs.type"]);
    $this->db->order_by("e.fullname, a.name, c.name");

    return $this->db->get()->result();
}

public function get_all()
{
    $this->db->order_by('created_on', 'DESC');
    return $this->db->get('questioner')->result();
}

public function generate_code_questioner()
{
    $bulan = date('n'); // angka bulan (1–12)
    $tahun = date('Y'); // tahun sekarang

    // Daftar nama bulan
    $nama_bulan = [
        1 => 'JANUARI', 2 => 'FEBRUARI', 3 => 'MARET', 4 => 'APRIL',
        5 => 'MEI', 6 => 'JUNI', 7 => 'JULI', 8 => 'AGUSTUS',
        9 => 'SEPTEMBER', 10 => 'OKTOBER', 11 => 'NOVEMBER', 12 => 'DESEMBER'
    ];

    return 'Q-' . $nama_bulan[$bulan] . '-' . $tahun;
}

 public function delete_questioner($id)
    {
        return $this->db->delete('questioner', ['id' => $id]);
    }
}