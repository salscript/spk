<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Account extends MY_Controller
{
   public function __construct()
   {
      parent::__construct();
      cek_login();
      $this->load->model('M_user');
   }

   function account_admin() {
      check_admin();
      $this->template->load('spk/template_admin', 'spk/admin/account');
   }
   
   function account_user() {
      check_user();
      $this->template->load('spk/template_user', 'spk/user/account');
   }
   function account_operator() {
      check_operator();
      $this->template->load('spk/template_operator', 'spk/operator/account');
   }

   function update_account() {
      $response = array('error' => '', 'success' => '');

      $this->form_validation->set_rules('fullname', 'Full Name', 'required', ['required' => '%s tidak boleh kosong']);
      if ($this->form_validation->run() == TRUE) {
          $id_user = $this->input->post('user_id');
          $fullname = $this->input->post('fullname');

          $config['upload_path'] = './assets/back/dist/img/avatar/';
          $config['allowed_types'] = 'jpg|png|jpeg';
          $config['max_size'] = 2048; // 2MB
          $config['file_name'] = 'avatar_' . $id_user;

          $this->load->library('upload', $config);

          if (!empty($_FILES['avatar']['name']) && !$this->upload->do_upload('avatar')) {
              $response['error'] = $this->upload->display_errors();
          } else if (!empty($_FILES['avatar']['name'])) {
              $data = $this->upload->data();
              if (empty($data['file_name'])) {
                  $response['error'] = 'File upload failed, no file name returned.';
              } else {
                  $avatar_path = '/dist/img/avatar/' . $data['file_name'];

                  $data = array(
                     'avatar' => $avatar_path
                  );

                  if ($this->M_user->update_account($id_user, $data)) {
                     $data_name = array(
                        'fullname' => $fullname
                     );

                     if($this->M_user->update_fullname($id_user, $data_name)) {

                        $response['success'] = 'Account update successfully.';
                        $this->session->set_userdata('fullname', $fullname);
                        $this->session->set_userdata('avatar', $avatar_path);
                     } else {
                        $response['error'] = 'Failed to update account.';
                     }
                  } else {
                      $response['error'] = 'Failed to update account.';
                  }
              }
          } else {
              // $response['error'] = 'No file uploaded.';
              $data = array(
                  'fullname' => $this->input->post('fullname')
              );

              if ($this->M_user->update_fullname($id_user, $data)) {
                  $response['success'] = 'Account updated successfully.';
                  $this->session->set_userdata('fullname', $fullname);
              } else {
                  $response['error'] = 'Failed to update account.';
              }
          }
      } else {
          $response['error'] = validation_errors();
      }
      echo json_encode($response);

   }
}
