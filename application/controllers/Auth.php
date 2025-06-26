<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
   public function __construct()
   {
      parent::__construct();
      $this->load->model('M_auth');
   }

   function login()
   {
      $this->load->view('spk/login');
   }

  public function login_aksi()
{
   // Validasi input
   $this->form_validation->set_rules('email', 'Email', 'trim|required', ['required' => '%s tidak boleh kosong']);
   $this->form_validation->set_rules('password', 'Password', 'trim|required', ['required' => '%s tidak boleh kosong']);

   // Ambil data dari form
   $email = $this->input->post('email', true);
   $password = $this->input->post('password', true);

   // Cek validasi
   if ($this->form_validation->run() == TRUE) {
      $user = $this->M_auth->validate($email, $password);

      if (!$user) {
         $msg = ['error' => 'Email atau password salah'];
      } else if ($user->status == '0') {
         $msg = ['error' => 'Akun belum aktif'];
      } else {
         // Simpan data ke session
         $session = array(
            'id_user'   => $user->id_user,
            'code_user' => $user->code_user,
            'email'     => $user->email,
            'fullname'  => $user->fullname,
            'role_id'   => $user->role_id,
            'avatar'    => $user->avatar,
            'position'  => $user->position_name,
            'logged_in' => TRUE
         );
         $this->session->set_userdata($session);

         // Kirim pesan sukses ke JavaScript
         $msg = [
            'role' => $user->role_id,
            'success' => 'Login berhasil sebagai ' . $user->fullname
         ];
      }
   } else {
      $msg = [
         'error' => validation_errors()
      ];
   }

   // Penting: hanya kirim JSON, jangan kirim HTML apa pun
   header('Content-Type: application/json');
   ob_clean();
   echo json_encode($msg);
   exit;
}



   function logout()
   {
      $this->session->set_userdata('email', FALSE);
      $this->session->sess_destroy();
      redirect('auth/login');
   }
}
