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
    public function get_peer_questioners($employee_id) {
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
                                    d.name as division_name, qs.status, qs.created_on')
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
                                    d.name as division_name, qs.status, qs.created_on')
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
        $eval = $this->db->get_where('employee', ['id' => $evaluator_id])->row();
        $evale = $this->db->get_where('employee', ['id' => $evaluatee_id])->row();

        if (!$eval || !$evale) return false;

        if ($eval->position_level < $evale->position_level // level kecil = lebih tinggi jabatan
            && $eval->division_id == $evale->division_id) {
            return true;
        }
        return false;
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