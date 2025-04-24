<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends MY_Controller
{
   public function __construct()
   {
      parent::__construct();
      cek_login();
      check_admin();
      $this->load->model('M_user');
      $this->load->model('M_userrole');
   }

   public function user()
   {
      $data['user'] = $this->M_user->get_all_users();
      $this->template->load('spk/template_admin', 'spk/admin/user/index', $data);
   }

   public function new_user()
   {
      $data['code_user'] = $this->M_user->code_user();
      $data['role'] = $this->M_userrole->get_all_roles();
      // $data['position'] = $this->M_position->get_position();
      // $data['division'] = $this->M_division->get_division();
      $this->template->load('spk/template_admin', 'spk/admin/user/addUser', $data);
   }

   public function edit_user($id_user)
   {
      $data['user'] = $this->M_user->get_user_by_id($id_user);
      $data['role'] = $this->M_userrole->get_all_roles();
      
      $this->template->load('spk/template_admin', 'spk/admin/user/editUser', $data);
   }

   // public function save_user()
   // {
   //    if ($this->input->is_ajax_request() == true) {
   //       $code_user = $this->input->post('code_user', true);
   //       $fullname = $this->input->post('fullname', true);
   //       $email = $this->input->post('email', true);
   //       $password = $this->input->post('password', true);
   //       $company = $this->input->post('company', true);
   //       $divisi = $this->input->post('divisi', true);
   //       $role = $this->input->post('role', true);
   //       $status = "1";
   //       $update = date('Y-m-d');

   //       if ($role == 1) {
   //          $avatar = '/dist/img/avatar3.png';
   //       } elseif ($role == 2) {
   //          $avatar = '/dist/img/avatar4.png';
   //       } else {
   //          $avatar = '/dist/img/avatar5.png';
   //       }

   //       if ($divisi == 0) {
   //          $divisi = "0";
   //          $this->form_validation->set_rules('fullname', 'Full Name', 'required', ['required' => '%s tidak boleh kosong']);
   //          $this->form_validation->set_rules('email', 'Email', 'trim|required|is_unique[user.email]', ['required' => '%s tidak boleh kosong', 'is_unique' => 'Email sudah ada']);
   //          $this->form_validation->set_rules('password', 'Password', 'trim|required', ['required' => '%s tidak boleh kosong']);
   //          $this->form_validation->set_rules('company', 'Company', 'required', ['required' => '%s tidak boleh kosong']);
   //          $this->form_validation->set_rules('role', 'Role', 'required', ['required' => '%s tidak boleh kosong']);
   //       } else {
   //          $this->form_validation->set_rules('fullname', 'Full Name', 'required', ['required' => '%s tidak boleh kosong']);
   //          $this->form_validation->set_rules('email', 'Email', 'trim|required|is_unique[user.email]', ['required' => '%s tidak boleh kosong', 'is_unique' => 'Email sudah ada']);
   //          $this->form_validation->set_rules('password', 'Password', 'trim|required', ['required' => '%s tidak boleh kosong']);
   //          $this->form_validation->set_rules('company', 'Company', 'required', ['required' => '%s tidak boleh kosong']);
   //          $this->form_validation->set_rules('divisi', 'Divisi', 'required', ['required' => '%s tidak boleh kosong']);
   //          $this->form_validation->set_rules('role', 'Role', 'required', ['required' => '%s tidak boleh kosong']);
   //       }

   //       if ($this->form_validation->run() == TRUE) {
   //          $this->M_user->save_user($code_user, $fullname, $email, $password, $company, $divisi, $role, $status, $avatar, $update);
   //          $msg = [
   //             'success' => 'user berhasil disimpan'
   //          ];
   //       } else {
   //          $msg = [
   //             'error' => validation_errors()
   //          ];
   //       }
   //       echo json_encode($msg);
   //    }
   // }

   // public function update_account()
   // {
   //    $response = array('error' => '', 'success' => '');

   //    $this->form_validation->set_rules('fullname', 'Full Name', 'required', ['required' => '%s tidak boleh kosong']);
   //    if ($this->form_validation->run() == TRUE) {
   //       $id_user = $this->input->post('user_id');
   //       $fullname = $this->input->post('fullname');

   //       $config['upload_path'] = './assets/back/dist/img/avatar/';
   //       $config['allowed_types'] = 'jpg|png|jpeg';
   //       $config['max_size'] = 2048; // 2MB
   //       $config['file_name'] = 'avatar_' . $id_user;

   //       $this->load->library('upload', $config);

   //       if (!empty($_FILES['avatar']['name']) && !$this->upload->do_upload('avatar')) {
   //          $response['error'] = $this->upload->display_errors();
   //       } else if (!empty($_FILES['avatar']['name'])) {
   //          $data = $this->upload->data();
   //          if (empty($data['file_name'])) {
   //             $response['error'] = 'File upload failed, no file name returned.';
   //          } else {
   //             $avatar_path = '/dist/img/avatar/' . $data['file_name'];

   //             $data = array(
   //                'fullname' => $this->input->post('fullname'),
   //                'avatar' => $avatar_path
   //             );

   //             if ($this->M_user->update_account($id_user, $data)) {
   //                $response['success'] = 'Account update successfully.';
   //                $this->session->set_userdata('fullname', $fullname);
   //                $this->session->set_userdata('avatar', $avatar_path);
   //             } else {
   //                $response['error'] = 'Failed to update account.';
   //             }
   //          }
   //       } else {
   //          // $response['error'] = 'No file uploaded.';
   //          $data = array(
   //             'fullname' => $this->input->post('fullname')
   //          );

   //          if ($this->M_user->update_account($id_user, $data)) {
   //             $response['success'] = 'Account updated successfully.';
   //             $this->session->set_userdata('fullname', $fullname);
   //          } else {
   //             $response['error'] = 'Failed to update account.';
   //          }
   //       }
   //    } else {
   //       $response['error'] = validation_errors();
   //    }
   //    echo json_encode($response);
   // }

   // public function update_user()
   // {
   //    check_admin();
   //    if ($this->input->is_ajax_request() == true) {
   //       $id_user = $this->input->post('id_user', true);
   //       $code_user = $this->input->post('code_user', true);
   //       $fullname = $this->input->post('fullname', true);
   //       $email = $this->input->post('email', true);
   //       $password = $this->input->post('password', true);
   //       $company = $this->input->post('company', true);
   //       $divisi = $this->input->post('divisi', true);
   //       $role = $this->input->post('role', true);
   //       $status = $this->input->post('status', true);
   //       // $status = "1";
   //       $update = date('Y-m-d');

   //       $this->form_validation->set_rules(
   //          'fullname',
   //          'Full Name',
   //          'required[user.fullname]',
   //          [
   //             'required' => '%s tidak boleh kosong'
   //          ]
   //       );
   //       $this->form_validation->set_rules(
   //          'email',
   //          'Email',
   //          'trim|required[user.email]',
   //          [
   //             'required' => '%s tidak boleh kosong'
   //          ]
   //       );
   //       $this->form_validation->set_rules(
   //          'password',
   //          'Password',
   //          'trim|required[user.password]',
   //          [
   //             'required' => '%s tidak boleh kosong'
   //          ]
   //       );

   //       if ($this->form_validation->run() == TRUE) {
   //          $this->M_user->update_user($id_user, $fullname, $email, $password, $company, $divisi, $role, $status, $update);
   //          // $this->M_user->update_user_detail($code_user, $company);
   //          $msg = [
   //             'success' => 'User Berhasil Diupdate'
   //          ];
   //       } else {
   //          $msg = [
   //             'error' => validation_errors()
   //          ];
   //       }
   //       echo json_encode($msg);
   //    }
   // }

   // public function deleteUser()
   // {
   //    check_admin();
   //    if ($this->input->is_ajax_request() == true) {
   //       $id = $this->input->post('id_user', true);
   //       $delete = $this->M_user->delete_user($id);

   //       if ($delete) {
   //          $msg = [
   //             'success' => 'User Berhasil Terhapus'
   //          ];
   //       }
   //       echo json_encode($msg);
   //    }
   // }

   // public function account_admin()
   // {
   //    check_admin();
   //    // $data['cln'] = $this->M_client->get_client();
   //    $this->template->load('template_admin', 'admin/account');
   // }

   // public function account_user()
   // {
   //    check_user();
   //    // $data['cln'] = $this->M_client->get_client();
   //    $this->template->load('template_user', 'user/account');
   // }

   // function change_password()
   // {
   //    $response = array('error' => '', 'success' => '');
   //    $id_user = $this->input->post('user_id', true);
   //    $current_pass = $this->input->post('current_pass', true);
   //    $new_pass = $this->input->post('new_pass', true);
   //    $confirm_pass = $this->input->post('confirm_pass', true);

   //    $this->form_validation->set_rules('current_pass', 'Current Password', 'required', ['required' => '%s tidak boleh kosong']);
   //    $this->form_validation->set_rules('new_pass', 'New Password', 'required', ['required' => '%s tidak boleh kosong']);
   //    $this->form_validation->set_rules('confirm_pass', 'Confirm Password', 'required', ['required' => '%s tidak boleh kosong']);

   //    if ($this->form_validation->run() == TRUE) {
   //       $password = $this->M_user->get_password($id_user);

   //       if ($current_pass == $password) {
   //          if ($new_pass == $confirm_pass) {
   //             // $this->M_user->update_password($new_pass);
   //             if ($this->M_user->update_password($id_user, $new_pass)) {
   //                $response['success'] = 'Password updated successfully.';
   //             } else {
   //                $response['error'] = 'Failed to update password.';
   //             }
   //          } else {
   //             $response['error'] = 'Confirm Password Salah.';
   //          }
   //       } else {
   //          $response['error'] = 'Password Salah';
   //       }
   //    } else {
   //       $response['error'] = validation_errors();
   //    }

   //    echo json_encode($response);
   // }
}
