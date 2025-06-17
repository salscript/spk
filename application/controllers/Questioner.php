<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Questioner extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('M_questioner');
        $this->load->model('M_question');
        $this->load->model('M_employee');
        $this->load->model('M_position');
        $this->M_questioner->auto_deactivate_expired_questioners();

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
    

    public function questioner()
    {
       $data['questioner'] = $this->M_questioner->get_all_questioners();
       $role = $this->session->userdata('role_id');
       if($role == 1){
           $this->template->load('spk/template_admin', 'spk/admin/questioner/index', $data);
        } else if($role == 3){
           $this->template->load('spk/template_operator', 'spk/operator/questioner/index', $data);
       }
    }
    
    public function questioner_user()
    {
    //    $data['questioner'] = $this->M_questioner->get_all_questioners();
       $data['questioner'] = $this->M_questioner->get_latest_active_questioner();

    //    var_dump($data);
       $this->template->load('spk/template_user', 'spk/user/questioner/index', $data);
    }
 
    public function new_questioner()
    {
       $data['code_questioner'] = $this->M_questioner->code_questioner();  
       $role = $this->session->userdata('role_id');
       if($role == 1){
           $this->template->load('spk/template_admin', 'spk/admin/questioner/addQuestioner', $data);
        } else if($role == 3){
           $this->template->load('spk/template_operator', 'spk/operator/questioner/addQuestioner', $data);
       }
    }
 
    public function save_questioner() {
        if($this->input->is_ajax_request() == TRUE) {
          $code = $this->input->post('code_questioner', true);
          $deadline_unformated = urldecode($this->input->post('deadline-data'));
          $created_on = date("Y-m-d H:i:s");

        //   var_dump($deadline_unformated);
            
          // $deadline_formated = new DateTime($deadline_unformated);
          // $deadline = $deadline_formated->format('Y-m-d H:i:s');
 
          if (!preg_match('/^\d{2}-\d{2}-\d{4} \d{2}:\d{2}$/', $deadline_unformated)) {
             echo json_encode(['error' => 'Format deadline tidak valid. Gunakan format DD-MM-YYYY HH:MM']);
             return;
          }
 
          $deadline_formated = DateTime::createFromFormat('d-m-Y H:i', $deadline_unformated);
          if (!$deadline_formated) {
             echo json_encode(['error' => 'Nilai tanggal tidak valid.']);
             return;
          }
 
          $deadline = $deadline_formated->format('Y-m-d H:i:s');
 
          $data = array(
             'code_questioner' => $code,
             'deadline' => $deadline,
             'status' => true,
             'created_on' => $created_on
          );

        //  var_dump($data);
 
          $save = $this->M_questioner->save_new_questioner($data);
 
          if ($save) {
             $msg = ['success' => 'Questioner berhasil disimpan'];
          } else {
             $msg = ['error' => 'Gagal menyimpan questioner'];
          } 
          
          echo json_encode($msg);
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

       $role = $this->session->userdata('role_id');
       if($role == 1){
           $this->template->load('spk/template_admin', 'spk/admin/questioner/index', $data);
        } else if($role == 3){
           $this->template->load('spk/template_operator', 'spk/operator/questioner/index', $data);
       }
    }

    // Tampilan user untuk mengisi kuisioner
  public function index($id) {
    $questioner = $this->M_questioner->get_by_id($id);
    $now = date('Y-m-d H:i:s');

    // ✅ Validasi apakah kuisioner ada, masih aktif, dan belum lewat deadline
    if (!$questioner || $questioner->status != 1 || $questioner->deadline < $now) {
        $this->session->set_flashdata('error', 'Kuisioner sudah tidak aktif atau telah ditutup.');
        redirect('dashboard'); // atau ke halaman lain sesuai kebutuhanmu
    }

    // Ambil ID user & employee
    $user_id = $this->session->userdata('id_user');
    $employee_id = $this->M_employee->get_employee_id($user_id);

    // Siapkan data untuk ditampilkan di view
    $data = array(
        'questioner_id' => $id,
        'title' => 'Kuisioner Penilaian',
        'peer_questioners' => $this->M_questioner->get_peer_questioners($employee_id, $id),
        'supervisor_questioners' => $this->M_questioner->get_supervisor_questioners($employee_id, $id),
        'is_hrd' => $this->M_employee->is_hrd($employee_id),
        'is_pic' => $this->M_employee->is_pic($employee_id)
    );

    $this->template->load('spk/template_user', 'spk/user/questioner/evaluatee_list.php', $data);
}


    public function peer() {
        $evaluatee_id = $this->input->get('evaluatee_id');
        $questioner_id = $this->input->get('questioner_id');
        $user_id = $this->session->userdata('id_user');
        $evaluator_id = $this->M_employee->get_employee_id($user_id);
        

        // Validasi boleh menilai atau tidak (harus di divisi dan sub divisi sama)
        if (!$this->M_questioner->validate_peer_relation($evaluator_id, $evaluatee_id)) {
            $this->session->set_flashdata('error', 'Anda tidak diizinkan menilai karyawan ini');
            redirect('questioner/index/'. $questioner_id);
        }

        $data = [
            'questioner_id' => $questioner_id,
            'title' => 'Kuisioner Rekan Kerja (Sikap Kerja)',
            'evaluatee' => $this->M_employee->get_employee_details($evaluatee_id),
            'questions' => $this->M_question->get_questions_by_aspect('Sikap Kerja')
        ];
        // var_dump($data);
        $this->template->load('spk/template_user', 'spk/user/questioner/peer_form.php', $data);
    }

    // Form kuisioner atasan
    public function supervisor() {
        $evaluatee_id = $this->input->get('evaluatee_id');
        $questioner_id = $this->input->get('questioner_id');
        $user_id = $this->session->userdata('id_user');
        $evaluator_id = $this->M_employee->get_employee_id($user_id);

        // Validasi boleh menilai bawahannya atau tidak (bawahan di divisi sama, level lebih rendah)
        if (!$this->M_questioner->validate_supervisor_relation($evaluator_id, $evaluatee_id)) {
            $this->session->set_flashdata('error', 'Anda tidak diizinkan menilai karyawan ini');
            redirect('questioner/index/'. $questioner_id);
        }

        $position_eval = $this->M_position->get_position_employee($evaluatee_id);
        $position_evale = $this->M_position->get_position_employee($evaluator_id);
        $data = [];
        // var_dump($position_eval, $position_evale);

        if ($position_eval->level_position == $position_evale->level_position) {
            $data = [
                'questioner_id' => $questioner_id,
                'title' => 'Kuisioner Rekan Kerja (Sikap Kerja)',
                'evaluatee' => $this->M_employee->get_employee_details($evaluatee_id),
                'questions' => $this->M_question->get_questions_by_aspect('Sikap Kerja')
            ];
        } else {
            $data = [
                'questioner_id' => $questioner_id, 
                'title' => 'Kuisioner Atasan (Kemampuan)',
                'evaluatee' => $this->M_employee->get_employee_details($evaluatee_id),
                'questions' => $this->M_question->get_questions_by_aspect('Kemampuan')
            ];
        }

        $this->template->load('spk/template_user', 'spk/user/questioner/supervisor_form.php', $data);
    }

    public function submit_peer() {
        $questioner_id = $this->input->post('questioner_id');
        $evaluator_id = $this->M_employee->get_employee_id($this->session->userdata('id_user'));
        $evaluatee_id = $this->input->post('evaluatee_id');
        $answers = $this->input->post('answers');

        // Simpan data ke tabel questioner_answer (buat sendiri tabelnya ya)
        foreach ($answers as $question_id => $answer_value) {
            $data = [
                'questioner_id' => $questioner_id,
                'evaluator_id' => $evaluator_id,
                'evaluatee_id' => $evaluatee_id,
                'question_id' => $question_id,
                'nilai' => $answer_value
            ];
            $this->db->insert('questioner_answers', $data);
        }

        $data_qs = [
            'questioner_id' => $questioner_id,
            'evaluator_id' => $evaluator_id,
            'evaluatee_id' => $evaluatee_id,
            'type' => 'peer',
            'status' => 'completed'
        ];

        $save = $this->db->insert('questioner_status', $data_qs);
        if ($save) {
            $this->session->set_flashdata('success', 'Penilaian rekan kerja berhasil disimpan');
            redirect('questioner/index/'. $questioner_id);
        }
        
        $this->session->set_flashdata('error', 'Penilaian rekan kerja Gagal');
        redirect('questioner/index/'. $questioner_id);
    }

    public function submit_supervisor() {
        $questioner_id = $this->input->post('questioner_id');
        $evaluator_id = $this->M_employee->get_employee_id($this->session->userdata('id_user'));
        $evaluatee_id = $this->input->post('evaluatee_id');
        $answers = $this->input->post('answers');

        foreach ($answers as $question_id => $answer_value) {
            $data = [
                'questioner_id' => $questioner_id,
                'evaluator_id' => $evaluator_id,
                'evaluatee_id' => $evaluatee_id,
                'question_id' => $question_id,
                'nilai' => $answer_value
            ];
            $this->db->insert('questioner_answers', $data);
        }

        $data_qs = [
            'questioner_id' => $questioner_id,
            'evaluator_id' => $evaluator_id,
            'evaluatee_id' => $evaluatee_id,
            'type' => 'supervisor',
            'status' => 'completed'
        ];

        $save = $this->db->insert('questioner_status', $data_qs);
        if ($save) {
            $this->session->set_flashdata('success', 'Penilaian Atasan berhasil disimpan');
            redirect('questioner/index/'. $questioner_id);
        }
        
        $this->session->set_flashdata('error', 'Penilaian Atasan Gagal');
        redirect('questioner/index/'. $questioner_id);

        // $this->session->set_flashdata('success', 'Penilaian atasan berhasil disimpan');
        // redirect('questioner');
    }

    public function monitoring($questioner_id)
{
    // if ($this->session->userdata('role_id') != 1) {
    //     redirect('auth/login');
    // }

    $data = [
        'title' => 'Monitoring Kuisioner',
        'monitoring_data' => $this->M_questioner->get_monitoring_kuisioner($questioner_id)
    ];
  $role = $this->session->userdata('role_id');
       if($role == 1){
           $this->template->load('spk/template_admin', 'spk/admin/questioner/monitoring', $data);
        } else if($role == 3){
           $this->template->load('spk/template_operator', 'spk/operator/questioner/monitoring', $data);
       }
    // $this->template->load('spk/template_admin', 'spk/admin/questioner/monitoring', $data);
}

public function toggle_status($id)
{
    $questioner = $this->M_questioner->get_by_id($id);
    if (!$questioner) {
        show_404();
    }

    // Ubah status: 1 -> 0, atau 0 -> 1
    $new_status = $questioner->status == 1 ? 0 : 1;

    $this->db->where('id', $id);
    $this->db->update('questioner', ['status' => $new_status]);

    $msg = $new_status == 1 ? 'Kuisioner diaktifkan kembali.' : 'Kuisioner dinonaktifkan.';
    $this->session->set_flashdata('success', $msg);

    redirect('questioner/questioner'); // arahkan kembali ke daftar kuisioner admin
}


     // Edit data (optional)
     public function edit_questioner($id)
     {
         $data['questioner'] = $this->M_questioner->get_questioner_by_id($id);
           $role = $this->session->userdata('role_id');
       if($role == 1){
           $this->template->load('spk/template_admin', 'spk/admin/questioner/editQuestioner', $data);
        } else if($role == 3){
           $this->template->load('spk/template_operator', 'spk/operator/questioner/editQuestioner', $data);
       }
     }
 
    public function update_questioner()
{
    if ($this->input->is_ajax_request()) {
        $id = $this->input->post('id', true);
        $code_questioner = $this->input->post('code_questioner', true);
        $deadline_input = $this->input->post('deadline', true); // format: d-m-Y H:i

        // Validasi input
        $this->form_validation->set_rules('code_questioner', 'Kode Kuisioner', 'required');
        $this->form_validation->set_rules('deadline', 'Deadline', 'required');

        // Cek format tanggal
        $deadline = DateTime::createFromFormat('d-m-Y H:i', $deadline_input);
        if (!$deadline) {
            echo json_encode(['error' => 'Format deadline tidak valid. Gunakan format DD-MM-YYYY HH:mm']);
            return;
        }

        if ($this->form_validation->run() === TRUE) {
            $data = [
                'code_questioner' => $code_questioner,
                'deadline' => $deadline->format('Y-m-d H:i:s')
            ];

            $this->load->model('M_questioner');
            $update = $this->M_questioner->updateQuestioner($id, $data);

            if ($update) {
                echo json_encode(['success' => 'Data kuisioner berhasil diperbarui']);
            } else {
                echo json_encode(['error' => 'Gagal memperbarui data kuisioner']);
            }
        } else {
            echo json_encode(['error' => validation_errors()]);
        }
    } else {
        show_404();
    }
}

    
      public function delete_questioner() {
        if ($this->input->is_ajax_request() == true) {
           $id = $this->input->post('id', true);
           $delete = $this->M_questioner->delete_questioner($id);
  
           if ($delete) {
              $msg = ['success' => 'Questioner Berhasil Terhapus'];
           } else {
              $msg = ['error' => 'Gagal menghapus questioner: '. $this->db->error()['message']];
           }
           echo json_encode($msg);
        }
     }

     public function create()
{
    $this->load->model('M_questioner');

    $code = $this->M_questioner->generate_code_questioner();

    $data = [
        'code_questioner' => $code,
        'created_on' => date('Y-m-d H:i:s'),
        'deadline' => $this->input->post('deadline'), // kalau pakai deadline
        'status' => 1
    ];

    $this->db->insert('questioner', $data);
    $this->session->set_flashdata('success', 'Periode penilaian berhasil ditambahkan.');
    redirect('questioner'); // atau halaman sesuai
}


   public function rekap_nilai($questioner_id) {
    $this->load->model('M_questioner');

    $data['title'] = 'Rekap Nilai Kuisioner';
    $data['questioner_id'] = $questioner_id;
    $data['rekap'] = $this->M_questioner->get_rekap_rata_rata_kriteria($questioner_id);

     $role = $this->session->userdata('role_id');
       if($role == 1){
           $this->template->load('spk/template_admin', 'spk/admin/questioner/rekap_nilai', $data);
        } else if($role == 3){
           $this->template->load('spk/template_operator', 'spk/operator/questioner/rekap_nilai', $data);
       }
}

}
