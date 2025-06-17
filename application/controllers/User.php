<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends MY_Controller
{
   public function __construct()
   {
      parent::__construct();
      cek_login();
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

    $role = $this->session->userdata('role');

    if ($role == 'admin') {
        $this->template->load('spk/template_admin', 'spk/admin/user/index', $data);
    } elseif ($role == 'operator') {
        $this->template->load('spk/template_operator', 'spk/operator/user/index', $data);
    } else {
        show_error('Access Denied', 403, 'Unauthorized Role');
    }
}


   public function new_user()
{
    $data['code_user'] = $this->M_user->code_user();
    $data['role'] = $this->M_userrole->get_all_roles();
    $data['position'] = $this->M_position->get_all_position();
    $data['division'] = $this->M_division->get_all_division();

    $role = $this->session->userdata('role');

    if ($role == 'admin') {
        $this->template->load('spk/template_admin', 'spk/admin/user/addUser', $data);
    } elseif ($role == 'operator') {
        $this->template->load('spk/template_operator', 'spk/operator/user/addUser', $data);
    } else {
        show_error('Access Denied', 403, 'Unauthorized Role');
    }
}


   public function edit_user($id_user)
{
    $data['user'] = $this->M_user->get_user_by_id($id_user);
    $data['role'] = $this->M_userrole->get_all_roles();
    $data['position'] = $this->M_position->get_all_position();
    $data['division'] = $this->M_division->get_all_division();

    $user_division = $this->M_division->get_division_by_user_id($id_user);
    $data['user_division_ids'] = array_map(function($d) {
        return $d->id;
    }, $user_division);

    $role = $this->session->userdata('role');

    if ($role == 'admin') {
        $this->template->load('spk/template_admin', 'spk/admin/user/editUser', $data);
    } elseif ($role == 'operator') {
        $this->template->load('spk/template_operator', 'spk/operator/user/editUser', $data);
    } else {
        show_error('Access Denied', 403, 'Unauthorized Role');
    }
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
         $sub_divisi = $this->input->post('sub_divisi', true); 
         $address = $this->input->post('address', true);
         $no_telp = $this->input->post('nomortelepon', true);
         $role = $this->input->post('role', true);
         $status = "1";
         $create = date('Y-m-d H:i:s');

         $avatar = $role == 1 ? '/dist/img/avatar3.png' : '/dist/img/avatar4.png';

         $this->form_validation->set_rules('fullname', 'Full Name', 'required');
         $this->form_validation->set_rules('email', 'Email', 'trim|required|is_unique[user.email]');
         $this->form_validation->set_rules('password', 'Password', 'trim|required');
         $this->form_validation->set_rules('position', 'Position', 'required');
         $this->form_validation->set_rules('sub_divisi', 'Sub Divisi', 'required'); 
         $this->form_validation->set_rules('address', 'Address', 'required');
         $this->form_validation->set_rules('nomortelepon', 'Nomor Telepon', 'required|numeric');
         $this->form_validation->set_rules('role', 'Role', 'trim|required');

         if (empty($division)) {
            echo json_encode(['error' => 'Division tidak boleh kosong']);
            return;
         }

         if ($this->form_validation->run() == TRUE) {
            $user_id = $this->M_user->save_user($code_user, $email, $password, $role, $status, $avatar, $create);
            if ($user_id) {
               $employee_id = $this->M_user->save_biodata($user_id, $fullname, $address, $no_telp, $position, $sub_divisi, $create);
               if($employee_id) {
                  $insert_batch = array_map(function($div) use ($employee_id) {
                     return [
                         'employee_id' => $employee_id,
                         'division_id' => $div
                     ];
                 }, $division);

                  if ($this->M_user->save_division($insert_batch)) {
                     echo json_encode(['success' => 'User berhasil disimpan']);
                     return;
                  } else {
                     echo json_encode(['error' => 'Gagal menyimpan data divisi']);
                     return;
                  }
               }
            }
            echo json_encode(['error' => 'Gagal menyimpan user']);
         } else {
            echo json_encode(['error' => validation_errors()]);
         }
      }
   }

   public function update_user()
{
    if ($this->input->is_ajax_request() == true) {
        $id_user = $this->input->post('id_user', true);
        $fullname = $this->input->post('fullname', true);
        $password = $this->input->post('password', true);
        $position = $this->input->post('position', true);
        $division = $this->input->post('division', true);
        $sub_divisi = $this->input->post('sub_divisi', true);
        $address = $this->input->post('address', true);
        $no_telp = $this->input->post('nomortelepon', true);
        $role = $this->input->post('role', true);
        $status = $this->input->post('status', true);
        $update = date('Y-m-d H:i:s');

        $this->form_validation->set_rules('fullname', 'Full Name', 'required');
        if (!empty($password)) {
            $this->form_validation->set_rules('password', 'Password', 'required');
        }
        $this->form_validation->set_rules('position', 'Position', 'required');
        $this->form_validation->set_rules('sub_divisi', 'Sub Divisi', 'required');
        $this->form_validation->set_rules('address', 'Address', 'required');
        $this->form_validation->set_rules('nomortelepon', 'Nomor Telepon', 'required|numeric');
        $this->form_validation->set_rules('role', 'Role', 'required');

        if (empty($division)) {
            echo json_encode(['error' => 'Division tidak boleh kosong']);
            return;
        }

        if ($this->form_validation->run() == TRUE) {
            // ✅ Update tabel user, tapi hanya update password jika diisi
            if (!empty($password)) {
                $this->M_user->update_user($id_user, $password, $role, $status, $update);
            } else {
                $this->M_user->update_user_without_password($id_user, $role, $status, $update);
            }

            if ($this->M_user->update_employee($id_user, $fullname, $position, $address, $no_telp, $sub_divisi, $update)) {
                $employee_id = $this->M_user->get_employee_id_by_user($id_user);
                $this->M_division->delete_user_divisions($employee_id);

               //  $insert_batch = array_map(fn($div) => [
               //      'employee_id' => $employee_id,
               //      'division_id' => $div
               //  ], $division);
               $insert_batch = array_map(function($div) use ($employee_id) {
                  return [
                      'employee_id' => $employee_id,
                      'division_id' => $div
                  ];
              }, $division);

                if ($this->M_user->save_division($insert_batch)) {
                    echo json_encode(['success' => 'User berhasil diupdate']);
                    return;
                } else {
                    echo json_encode(['error' => 'Gagal menyimpan ulang data divisi']);
                    return;
                }
            } else {
                echo json_encode(['error' => 'Gagal mengupdate data karyawan']);
            }
        } else {
            echo json_encode(['error' => validation_errors()]);
        }
    }
}


   public function delete_user()
   {
      if ($this->input->is_ajax_request() == true) {
         $id = $this->input->post('id_user', true);
         if ($this->M_user->delete_user($id)) {
            echo json_encode(['success' => 'User Berhasil Terhapus']);
         } else {
            echo json_encode(['error' => 'Gagal menghapus user: ' . $this->db->error()['message']]);
         }
      }
   }
}
