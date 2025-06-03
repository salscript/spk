<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Questioner extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('M_questioner');
        $this->load->model('M_employee');

        // Cek login
        if (!$this->session->userdata('logged_in')) {
            if ($this->input->is_ajax_request()) {
                echo json_encode(['status' => 'error', 'message' => 'Belum login']);
                exit;
            } else {
                redirect('auth/login');
            }
        }
    }

    // Tampilan admin untuk monitoring kuisioner
    public function admin() {
        if ($this->session->userdata('role_id') != 1) {
            redirect('questioner');
        }

        $data = array(
            'title' => 'Monitoring Kuisioner',
            'all_questioners' => $this->M_questioner->get_all_questioners_status(),
            'incomplete_questioners' => $this->M_questioner->get_incomplete_questioners()
        );

        $this->template->load('spk/template_admin', 'spk/admin/questioner/index.php', $data);
    }

    // Tampilan user untuk mengisi kuisioner
    public function index() {
        $user_id = $this->session->userdata('id_user');
        $employee_id = $this->M_employee->get_employee_id($user_id);
        // $sub_divisi = $this->M_employee->get_sub_divisi($user_id);
        
        $data = array(
            'title' => 'Kuisioner Penilaian',
            'peer_questioners' => $this->M_questioner->get_peer_questioners($employee_id),
            'supervisor_questioners' => $this->M_questioner->get_supervisor_questioners($employee_id),
            'is_hrd' => $this->M_employee->is_hrd($employee_id),
            'is_pic' => $this->M_employee->is_pic($employee_id)
        );

        var_dump("user_id:", $user_id, "employee_id", $employee_id, $data);

        // $this->template->load('spk/template_user', 'spk/user/questioner/index.php', $data);
    }

     public function peer($evaluatee_id) {
        $user_id = $this->session->userdata('user_id');
        $evaluator_id = $this->M_employee->get_employee_id($user_id);
        

        // Validasi boleh menilai atau tidak (harus di divisi dan sub divisi sama)
        if (!$this->M_questioner->validate_peer_relation($evaluator_id, $evaluatee_id)) {
            $this->session->set_flashdata('error', 'Anda tidak diizinkan menilai karyawan ini');
            redirect('questioner');
        }

        $data = [
            'title' => 'Kuisioner Rekan Kerja (Sikap Kerja)',
            'evaluatee' => $this->M_employee->get_employee_details($evaluatee_id),
            'questions' => $this->M_questioner->get_questions_by_aspect('Sikap Kerja')
        ];

        $this->load->view('user/questioner/peer_form', $data);
    }

    // Form kuisioner atasan
    public function supervisor($evaluatee_id) {
        $user_id = $this->session->userdata('user_id');
        $evaluator_id = $this->M_employee->get_employee_id($user_id);

        // Validasi boleh menilai bawahannya atau tidak (bawahan di divisi sama, level lebih rendah)
        if (!$this->M_questioner->validate_supervisor_relation($evaluator_id, $evaluatee_id)) {
            $this->session->set_flashdata('error', 'Anda tidak diizinkan menilai karyawan ini');
            redirect('questioner');
        }

        $data = [
            'title' => 'Kuisioner Atasan (Kemampuan)',
            'evaluatee' => $this->M_employee->get_employee_details($evaluatee_id),
            'questions' => $this->M_questioner->get_questions_by_aspect('Kemampuan')
        ];

        $this->load->view('user/questioner/supervisor_form', $data);
    }

   public function submit_peer() {
    $evaluator_id = $this->M_employee->get_employee_id($this->session->userdata('user_id'));
    $evaluatee_id = $this->input->post('evaluatee_id');
    $answers = $this->input->post('answers');

    // Simpan data ke tabel questioner_answer (buat sendiri tabelnya ya)
    foreach ($answers as $question_id => $answer_value) {
        $data = [
            'evaluator_id' => $evaluator_id,
            'evaluatee_id' => $evaluatee_id,
            'question_id' => $question_id,
            'answer' => $answer_value,
            'aspect' => 'Sikap Kerja'
        ];
        $this->db->insert('questioner_answers', $data);
    }

    $this->session->set_flashdata('success', 'Penilaian rekan kerja berhasil disimpan');
    redirect('questioner');
}

public function submit_supervisor() {
    $evaluator_id = $this->M_employee->get_employee_id($this->session->userdata('user_id'));
    $evaluatee_id = $this->input->post('evaluatee_id');
    $answers = $this->input->post('answers');

    foreach ($answers as $question_id => $answer_value) {
        $data = [
            'evaluator_id' => $evaluator_id,
            'evaluatee_id' => $evaluatee_id,
            'question_id' => $question_id,
            'answer' => $answer_value,
            'aspect' => 'Kemampuan'
        ];
        $this->db->insert('questioner_answers', $data);
    }

    $this->session->set_flashdata('success', 'Penilaian atasan berhasil disimpan');
    redirect('questioner');
}

}
