<?php
class MY_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('Auth');

        $user = $this->session->userdata('id_user');
    }

    protected function check_access($role)
    {
        if ($this->session->userdata('role_id') != $role) {
            $this->session->set_flashdata('error', 'Silahkan masuk terlebih dahulu !!');
            redirect('auth/login');
        }
    }

    protected function check_admin()
    {
        $this->check_access('1');
    }

    protected function check_user()
    {
        $this->check_access('2');
    }
}
