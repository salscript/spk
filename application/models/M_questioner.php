<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_questioner extends CI_Model {

    public function __construct() {
        parent::__construct();
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
    public function get_peer_questioners($employee_id) {
        $employee = $this->db->select('ed.division_id, e.sub_divisi')
            ->from('employee e')
            ->join('employee_division ed', 'ed.employee_id = e.id')
            ->where('e.id', $employee_id)
            ->get()
            ->row();
        
        if (!$employee) return array();
        
        return $this->db->select('e.id, e.fullname, p.name as position_name, 
                                d.name as division_name, qs.status, qs.created_at')
            ->from('employee e')
            ->join('employee_division ed', 'ed.employee_id = e.id')
            ->join('division d', 'd.id = ed.division_id')
            ->join('position p', 'p.id = e.position_id')
            ->join('questioner_status qs', "qs.evaluatee_id = e.id AND qs.evaluator_id = $employee_id AND qs.type = 'peer'", 'left')
            ->where('d.id', $employee->division_id)
            ->where('e.sub_divisi', $employee->sub_divisi)
            ->where('e.id !=', $employee_id)
            ->get()
            ->result();
    }

    // Mendapatkan daftar bawahan yang perlu dinilai (otomatis berdasarkan divisi dan level)
    public function get_supervisor_questioners($employee_id) {
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
            return $this->db->select('e.id, e.fullname, p.name as position_name, 
                                    d.name as division_name, qs.status, qs.created_at')
                ->from('employee e')
                ->join('position p', 'p.id = e.position_id')
                ->join('employee_division ed', 'ed.employee_id = e.id')
                ->join('division d', 'd.id = ed.division_id')
                ->join('questioner_status qs', "qs.evaluatee_id = e.id AND qs.evaluator_id = $employee_id AND qs.type = 'supervisor'", 'left')
                ->where_in('p.level_position', ['managerial', 'senior_staff'])
                ->where('e.id !=', $employee_id)
                ->get()
                ->result();
        }
        // PIC/Managerial menilai staff dalam divisi yang sama
        elseif (in_array($evaluator->level_position, ['managerial', 'senior_staff'])) {
            return $this->db->select('e.id, e.fullname, p.name as position_name, 
                                    d.name as division_name, qs.status, qs.created_at')
                ->from('employee e')
                ->join('position p', 'p.id = e.position_id')
                ->join('employee_division ed', 'ed.employee_id = e.id')
                ->join('division d', 'd.id = ed.division_id')
                ->join('questioner_status qs', "qs.evaluatee_id = e.id AND qs.evaluator_id = $employee_id AND qs.type = 'supervisor'", 'left')
                ->where('ed.division_id', $evaluator->division_id)
                ->where('p.level_position', 'staff')
                ->where('e.id !=', $employee_id)
                ->get()
                ->result();
        }
        
        return array();
    }

    // Validasi relasi rekan kerja (dalam divisi dan sub divisi yang sama)
    public function validate_peer_relation($evaluator_id, $evaluatee_id) {
        $evaluator = $this->db->select('ed.division_id, e.sub_divisi')
            ->from('employee e')
            ->join('employee_division ed', 'ed.employee_id = e.id')
            ->where('e.id', $evaluator_id)
            ->get()
            ->row();
        
        if (!$evaluator) return false;
        
        return $this->db->select('e.id')
            ->from('employee e')
            ->join('employee_division ed', 'ed.employee_id = e.id')
            ->where('e.id', $evaluatee_id)
            ->where('ed.division_id', $evaluator->division_id)
            ->where('e.sub_divisi', $evaluator->sub_divisi)
            ->count_all_results() > 0;
    }

    // Validasi relasi atasan-bawahan (berdasarkan level dan divisi)
    public function validate_supervisor_relation($evaluator_id, $evaluatee_id) {
        $evaluator = $this->db->select('p.level_position, ed.division_id')
            ->from('employee e')
            ->join('position p', 'p.id = e.position_id')
            ->join('employee_division ed', 'ed.employee_id = e.id')
            ->where('e.id', $evaluator_id)
            ->get()
            ->row();
        
        if (!$evaluator) return false;
        
        $evaluatee = $this->db->select('p.level_position, ed.division_id')
            ->from('employee e')
            ->join('position p', 'p.id = e.position_id')
            ->join('employee_division ed', 'ed.employee_id = e.id')
            ->where('e.id', $evaluatee_id)
            ->get()
            ->row();
        
        if (!$evaluatee) return false;
        
        // HRD bisa menilai semua PIC/Managerial
        if ($evaluator->level_position == 'hrd') {
            return in_array($evaluatee->level_position, ['managerial', 'senior_staff']);
        }
        // PIC/Managerial hanya bisa menilai staff dalam divisi yang sama
        elseif (in_array($evaluator->level_position, ['managerial', 'senior_staff'])) {
            return ($evaluatee->level_position == 'staff') && 
                   ($evaluator->division_id == $evaluatee->division_id);
        }
        
        return false;
    }

    // Cek apakah sudah pernah menilai
    public function check_already_rated($evaluator_id, $evaluatee_id, $type) {
        return $this->db->where('evaluator_id', $evaluator_id)
            ->where('evaluatee_id', $evaluatee_id)
            ->where('type', $type)
            ->where('status', 'completed')
            ->count_all_results('questioner_status') > 0;
    }

    // Mendapatkan pertanyaan berdasarkan aspek
    public function get_questions_by_aspect($aspect_name) {
        return $this->db->select('q.id, q.code_question, q.name, c.name as criteria_name')
            ->from('question q')
            ->join('criteria c', 'c.id = q.criteria_id')
            ->join('aspect a', 'a.id = c.aspect_id')
            ->where('a.name', $aspect_name)
            ->order_by('q.id', 'ASC')
            ->get()
            ->result();
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
}