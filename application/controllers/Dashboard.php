<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends MY_Controller
{
   public function __construct()
   {
      parent::__construct();
      $this->load->model('M_user');
      $this->load->model('M_questioner');
      $this->load->model('M_penilaian');
      $this->load->model('M_criteria');
      cek_login();
   }

 public function admin()
{
    check_admin();

//     // Load model yang dibutuhkan
//     $this->load->model('M_employee');
//     $this->load->model('M_questioner');
//     $this->load->model('M_penilaian');

//     // Persiapkan data dashboard
    
//    $data['total_karyawan'] = $this->M_employee->count_karyawan_wajib_dinilai();
// $data['sudah_dinilai']  = $this->M_questioner->count_sudah_dinilai();
// $data['belum_dinilai']  = $data['total_karyawan'] - $data['sudah_dinilai'];

//     $data['periode_aktif']    = $this->M_questioner->get_periode_aktif();
//     $data['nilai_kriteria']   = $this->M_penilaian->get_rata_rata_per_kriteria();
//     $data['top_karyawan']     = $this->M_penilaian->get_top_karyawan(5);
//     $data['title']            = "Dashboard";

//     // Kirim ke view
      // $data = array();
      $data["user"] = $this->M_user->jumlah_user();
      $data["questioner"] = $this->M_questioner->jumlah_questioner();
      $data["criteria"] = $this->M_criteria->jumlah_criteria();
      $data["penilaian"] = $this->M_penilaian->get_questioner_sudah_dinilai();
      $this->template->load('spk/template_admin', 'spk/admin/dashboard', $data);
   }

 
   public function user()
   {
      check_user();
      $this->template->load('spk/template_user', 'spk/user/dashboard');
   }

   public function operator()
   {
      check_operator();
      $data["questioner"] = $this->M_questioner->jumlah_questioner();
      $data["penilaian"] = $this->M_penilaian->get_questioner_sudah_dinilai();
      $this->template->load('spk/template_operator', 'spk/operator/dashboard', $data);
   }
}
