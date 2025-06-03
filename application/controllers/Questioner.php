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
        $user_id = $this->session->userdata('user_id');
        $employee_id = $this->M_employee->get_employee_id($user_id);
        
        $data = array(
            'title' => 'Kuisioner Penilaian',
            'peer_questioners' => $this->M_questioner->get_peer_questioners($employee_id),
            'supervisor_questioners' => $this->M_questioner->get_supervisor_questioners($employee_id),
            'is_hrd' => $this->M_employee->is_hrd($employee_id),
            'is_pic' => $this->M_employee->is_pic($employee_id)
        );

        $this->template->load('spk/template_user', 'spk/user/questioner/index.php', $data);
    }

    // Form untuk mengisi kuisioner rekan kerja
    public function peer($evaluatee_id) {
        $user_id = $this->session->userdata('user_id');
        $evaluator_id = $this->M_employee->get_employee_id($user_id);
        
        if (!$this->M_questioner->validate_peer_relation($evaluator_id, $evaluatee_id)) {
            $this->session->set_flashdata('error', 'Anda tidak diizinkan menilai karyawan ini');
            redirect('questioner');
        }
        
        $data = array(
            'title' => 'Kuisioner Rekan Kerja',
            'evaluatee' => $this->M_employee->get_employee_details($evaluatee_id),
            'questions' => $this->M_questioner->get_questions_by_aspect('Sikap Kerja')
        );

        $this->template->load('spk/template_user', 'spk/user/questioner/peer_form', $data);
    }

    // Form untuk mengisi kuisioner atasan
    public function supervisor($evaluatee_id) {
        $user_id = $this->session->userdata('user_id');
        $evaluator_id = $this->M_employee->get_employee_id($user_id);
        
        if (!$this->M_questioner->validate_supervisor_relation($evaluator_id, $evaluatee_id)) {
            $this->session->set_flashdata('error', 'Anda tidak diizinkan menilai karyawan ini');
            redirect('questioner');
        }
        
        $data = array(
            'title' => 'Kuisioner Atasan',
            'evaluatee' => $this->M_employee->get_employee_details($evaluatee_id),
            'questions' => $this->M_questioner->get_questions_by_aspect('Kemampuan')
        );

        $this->template->load('spk/template_user', 'spk/user/questioner/supervisor_form', $data);
    }

    // Proses submit kuisioner rekan kerja
    public function submit_peer() {
        $this->load->library('form_validation');
        $user_id = $this->session->userdata('user_id');
        $evaluator_id = $this->M_employee->get_employee_id($user_id);
        $evaluatee_id = $this->input->post('evaluatee_id');
        
        $this->form_validation->set_rules('evaluatee_id', 'ID Dinilai', 'required|numeric');
        
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('questioner/peer/'.$evaluatee_id);
        }
        
        if ($this->M_questioner->save_questioner($evaluator_id, $evaluatee_id, 'peer', $this->input->post())) {
            $this->session->set_flashdata('success', 'Kuisioner rekan kerja berhasil disimpan');
        } else {
            $this->session->set_flashdata('error', 'Gagal menyimpan kuisioner');
        }
        
        redirect('questioner');
    }

    // Proses submit kuisioner atasan
    public function submit_supervisor() {
        $this->load->library('form_validation');
        $user_id = $this->session->userdata('user_id');
        $evaluator_id = $this->M_employee->get_employee_id($user_id);
        $evaluatee_id = $this->input->post('evaluatee_id');
        
        $this->form_validation->set_rules('evaluatee_id', 'ID Dinilai', 'required|numeric');
        
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('questioner/supervisor/'.$evaluatee_id);
        }
        
        if ($this->M_questioner->save_questioner($evaluator_id, $evaluatee_id, 'supervisor', $this->input->post())) {
            $this->session->set_flashdata('success', 'Kuisioner atasan berhasil disimpan');
        } else {
            $this->session->set_flashdata('error', 'Gagal menyimpan kuisioner');
        }
        
        redirect('questioner');
    }

    // Endpoint tambahan untuk AJAX (untuk kebutuhan JS)
    public function questioner_user() {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $user_id = $this->session->userdata('user_id');
        if (!$user_id) {
            echo json_encode(['status' => 'error', 'message' => 'Belum login']);
            return;
        }

        $employee_id = $this->M_employee->get_employee_id($user_id);

        $data = array(
            'peer_questioners' => $this->M_questioner->get_peer_questioners($employee_id),
            'supervisor_questioners' => $this->M_questioner->get_supervisor_questioners($employee_id),
            'is_hrd' => $this->M_employee->is_hrd($employee_id),
            'is_pic' => $this->M_employee->is_pic($employee_id)
        );

        echo json_encode(['status' => 'success', 'data' => $data]);
    }
}
