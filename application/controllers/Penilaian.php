<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penilaian extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_penilaian');
        $this->load->model('M_employee');
        $this->load->model('M_aspect');
        $this->load->model('M_criteria');
        $this->load->model('M_subkriteria');
        $this->load->model('M_questioner');
    }

   public function index()
{
    $data['title'] = 'Data Penilaian';
    $data['questioners'] = $this->M_questioner->get_all();

    foreach ($data['questioners'] as &$q) {
        // Cek apakah sudah ada nilai apapun
        $q->sudah_diisi = $this->M_penilaian->sudah_ada_nilai($q->id);

        // ✅ Tambahan: cek apakah semua aspek sudah diisi
        $q->sudah_diisi_semua_aspek = $this->M_penilaian->is_all_aspect_completed($q->id);
    }
 $role = $this->session->userdata('role_id');
       if($role == 1){
           $this->template->load('spk/template_admin', 'spk/admin/penilaian/index', $data);
        } else if($role == 3){
           $this->template->load('spk/template_operator', 'spk/operator/penilaian/index', $data);
       }
    // $this->template->load('spk/template_admin', 'spk/admin/penilaian/index', $data);
}


    // FORM INPUT NILAI AKTUAL BERDASARKAN ASPEK
    public function input($questioner_id)
    {
        $this->load->model('M_questioner');
        $this->load->model('M_subkriteria');
        $this->load->model('M_criteria');

        $data['title'] = 'Input Nilai Aktual';
        $data['questioner'] = $this->M_questioner->get_by_id($questioner_id);
        $data['aspek'] = $this->M_aspect->get_all();
        $data['questioner_id'] = $questioner_id;

        $aspek_id = $this->input->post('aspect_id');
        if ($aspek_id) {
            $data['selected_aspect'] = $aspek_id;
            $data['criteria'] = $this->M_criteria->get_by_aspect($aspek_id);
            $data['employees'] = $this->M_employee->get_all_aktif();
            $data['subkriteria'] = $this->M_subkriteria->get_grouped();
            $data['is_aspek_sudah_isi'] = $this->M_penilaian->sudah_input_aspek($questioner_id, $aspek_id);

            $selected_aspect_name = '';
            foreach ($data['aspek'] as $asp) {
                if ($asp->id == $aspek_id) {
                    $selected_aspect_name = $asp->name;
                    break;
                }
            }
            $data['selected_aspect_name'] = $selected_aspect_name;

            $rekap = $this->M_questioner->get_rekap_rata_rata_kriteria($questioner_id);
            $auto_subkriteria = [];

            foreach ($rekap as $r) {
                $sub = $this->M_subkriteria->get_subkriteria_by_value($r->criteria_id, $r->avg_score);
                if ($sub) {
                    $auto_subkriteria[$r->employee_id][$r->criteria_id] = $sub->id;
                }
            }

            $kriteria_jabatan_id = 7;
            $map_jabatan = [
                'staff' => 'Staff',
                'senior_staff' => 'Staff Senior',
                'managerial' => 'Staff Managerial'
            ];

            foreach ($data['employees'] as $emp) {
                $level = $emp->level_position;
                $nama_subkriteria = $map_jabatan[$level] ?? null;

                if ($nama_subkriteria) {
                    $sub = $this->M_subkriteria->get_subkriteria_by_name($kriteria_jabatan_id, $nama_subkriteria);
                    if ($sub) {
                        $auto_subkriteria[$emp->id][$kriteria_jabatan_id] = $sub->id;
                    }
                }
            }

            $data['auto_subkriteria'] = $auto_subkriteria;
        }

         if($role == 1){
           $this->template->load('spk/template_admin', 'spk/admin/penilaian/addNilai', $data);
        } else if($role == 3){
           $this->template->load('spk/template_operator', 'spk/operator/penilaian/addNilai', $data);
       }
    }

    public function simpan()
{
    $questioner_id = $this->input->post('questioner_id');
    $tanggal_input = date('Y-m-d H:i:s');
    $data = [];

    $karyawan_ids = $this->input->post('employee_id');

    // Validasi input kosong
    foreach ($karyawan_ids as $emp_id => $kriteria_values) {
        foreach ($kriteria_values as $criteria_id => $subkriteria_id) {
            if (empty($subkriteria_id)) {
                $this->session->set_flashdata('error', 'Semua nilai aktual harus diisi sebelum disimpan.');
                redirect('penilaian/input/' . $questioner_id);
                return;
            }

            if ($this->M_penilaian->nilai_aktual_exists($emp_id, $criteria_id, $questioner_id)) {
                $this->session->set_flashdata('error', 'Nilai aktual sudah pernah diinput. Tidak dapat disimpan ulang.');
                redirect('penilaian/input/' . $questioner_id);
                return;
            }

            $data[] = [
                'employee_id' => $emp_id,
                'criteria_id' => $criteria_id,
                'subkriteria_id' => $subkriteria_id,
                'questioner_id' => $questioner_id,
                'tanggal_input' => $tanggal_input,
            ];
        }
    }

    // Simpan batch
    $this->M_penilaian->insert_batch($data);
    $this->session->set_flashdata('success', 'Nilai aktual berhasil disimpan.');

    // ✅ Cek apakah semua aspek sudah diisi
    if ($this->M_penilaian->is_all_aspect_completed($questioner_id)) {
        redirect('penilaian'); // ke halaman index
    } else {
        redirect('penilaian/input/' . $questioner_id); // tetap di halaman input
    }
}

}
