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
      $this->load->model('M_position');
      $this->load->model('M_division');
   }

   public function user()
   {
      $data['user'] = $this->M_user->get_all_users();

      foreach ($data['user'] as $key => $user) {
         $division = $this->M_division->get_division_by_user_id($user->id);
         $data['user'][$key]->divisions = $division;
      }
      
      $this->template->load('spk/template_admin', 'spk/admin/user/index', $data);
      
      // echo "<pre>";
      // print_r($data['user']);
      // echo "</pre>";
      // exit;
   }

   public function new_user()
   {
      $data['code_user'] = $this->M_user->code_user();
      $data['role'] = $this->M_userrole->get_all_roles();
      $data['position'] = $this->M_position->get_all_position();
      $data['division'] = $this->M_division->get_all_division();
      $this->template->load('spk/template_admin', 'spk/admin/user/addUser', $data);
   }

   public function edit_user($id_user)
   {
      $data['user'] = $this->M_user->get_user_by_id($id_user);
      $data['role'] = $this->M_userrole->get_all_roles();
      $data['position'] = $this->M_position->get_all_position();
      $data['division'] = $this->M_division->get_all_division();
      
      $this->template->load('spk/template_admin', 'spk/admin/user/editUser', $data);
   }

   public function save_user()
   {
      if ($this->input->is_ajax_request() == true) {
         $code_user = $this->input->post('code_user', true);
         $fullname = $this->input->post('fullname', true);
         $email = $this->input->post('email', true);
         $password = $this->input->post('password', true);
         $position = $this->input->post('position');
         $division = $this->input->post('division[]');
         $address = $this->input->post('address', true);
         $no_telp = $this->input->post('nomortelepon', true);
         $role = $this->input->post('role', true);
         $status = "1";
         $create = date('Y-m-d');

         if ($role == 1) {
            $avatar = '/dist/img/avatar3.png';
         } elseif ($role == 2) {
            $avatar = '/dist/img/avatar4.png';
         }

         $this->form_validation->set_rules('fullname', 'Full Name', 'required', ['required' => '%s tidak boleh kosong']);
         $this->form_validation->set_rules('email', 'Email', 'trim|required|is_unique[user.email]', ['required' => '%s tidak boleh kosong', 'is_unique' => 'Email sudah ada']);
         $this->form_validation->set_rules('password', 'Password', 'trim|required', ['required' => '%s tidak boleh kosong']);
         $this->form_validation->set_rules('position', 'Position', 'required', ['required' => '%s tidak boleh kosong']);
         // $this->form_validation->set_rules('division', 'Division', 'required', ['required' => '%s tidak boleh kosong']);
         $this->form_validation->set_rules('address', 'Address', 'required', ['required' => '%s tidak boleh kosong']);
         $this->form_validation->set_rules('nomortelepon', 'Nomor Telepon', 'required|numeric', [
           'required' => '%s tidak boleh kosong',
           'numeric' => '%s harus berupa angka']);
         $this->form_validation->set_rules('role', 'Role', 'trim|required', ['required' => '%s tidak boleh kosong']);
         
         if (empty($division)) {
            $msg = ['error' => 'Division tidak boleh kosong'];
            echo json_encode($msg);
            return;
         }

         if ($this->form_validation->run() == TRUE) {
            $user_id = $this->M_user->save_user($code_user, $email, $password, $role, $status, $avatar, $create);
            if ($user_id) {
               $employee_id = $this->M_user->save_biodata($user_id, $fullname, $address, $no_telp, $position, $create);
               if($employee_id) {
                  $insert_batch = [];
                  foreach($division as $div) {
                     $insert_batch[] = [
                        'employee_id' => $employee_id,
                        'division_id' => $div,
                        'created_on' => $create
                     ];
                  }
                  $save_divisions = $this->M_user->save_division($insert_batch);

                  if ($save_divisions) {
                     $msg = ['success' => 'User berhasil disimpan'];
                  } else {
                     $msg = ['error' => 'Gagal menyimpan data divisi'];
                  }
               } else {
                  $msg = ['error' => 'Gagal menyimpan data karyawan'];
               }
            } else {
               $msg = ['error' => 'Gagal menyimpan user'];
            }
         } else {
            $msg = ['error' => validation_errors()];
         }
         
         echo json_encode($msg);
       }
    }

   //  public function update_user()
   //  {
   //    if ($this->input->is_ajax_request() == true) {
   //       $code_user = $this->input->post('code_user', true);
   //       $fullname = $this->input->post('fullname', true);
   //       $email = $this->input->post('email', true);
   //       $password = $this->input->post('password', true);
   //       $position = $this->input->post('position', true);
   //       $division = $this->input->post('division', true);
   //       $address = $this->input->post('address', true);
   //       $nomortelepon = $this->input->post('nomortelepon', true);
   //       $role = $this->input->post('role', true);
   //       $status = "1";
   //       $update = date('Y-m-d');
 
   //       $this->form_validation->set_rules('fullname', 'Full Name', 'required', ['required' => '%s tidak boleh kosong']);
   //       $this->form_validation->set_rules('email', 'Email', 'trim|required|is_unique[user.email]', ['required' => '%s tidak boleh kosong', 'is_unique' => 'Email sudah ada']);
   //       $this->form_validation->set_rules('password', 'Password', 'trim|required', ['required' => '%s tidak boleh kosong']);
   //       $this->form_validation->set_rules('position', 'Position', 'required', ['required' => '%s tidak boleh kosong']);
   //       $this->form_validation->set_rules('division', 'Division', 'required', ['required' => '%s tidak boleh kosong']);
   //       $this->form_validation->set_rules('address', 'Address', 'required', ['required' => '%s tidak boleh kosong']);
   //       $this->form_validation->set_rules('nomortelepon', 'Nomor Telepon', 'required|numeric', [
   //         'required' => '%s tidak boleh kosong',
   //         'numeric' => '%s harus berupa angka']);
   //       $this->form_validation->set_rules('role', 'Role', 'trim|required', ['required' => '%s tidak boleh kosong']);

   //        if ($this->form_validation->run() == TRUE) {
   //           $this->M_user->save_user($code_user, $fullname, $email, $password, $position, $division, $address, $nomortelepon, $role, $status, $avatar, $update);
   //              $msg = ['success' => 'user berhasil diupdated'];
   //           } else {
   //              $msg = ['error' => 'Gagal mengupdate user: '. $this->db->error()['message']];
   //           }
   //        } else {
   //           $msg = ['error' => validation_errors()];
   //        }
 
   //        echo json_encode($msg);
   //     }
    
   
 
    public function delete_user() {
      if ($this->input->is_ajax_request() == true) {
         $id = $this->input->post('id_user', true);
         $delete = $this->M_user->delete_user($id);

         if ($delete) {
            $msg = ['success' => 'user Berhasil Terhapus'];
         } else {
            $msg = ['error' => 'Gagal menghapus user: '. $this->db->error()['message']];
         }
         echo json_encode($msg);
      }
   }
}