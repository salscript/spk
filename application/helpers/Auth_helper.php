<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('cek_login')) {
    function cek_login()
    {
        $CI = &get_instance();
        $email = $CI->session->userdata('email');

        if ($email == NULL) {
            $CI->session->set_flashdata('message', '<div class="alert alert-danger"> Harus Login Bro</div>');
            redirect('auth/login');
        }
    }
}

if (!function_exists('check_admin')) {
    function check_admin()
    {
        cek_login();
        $CI = &get_instance();
        if ($CI->session->userdata('role_id') != '1') {
            $CI->session->set_flashdata('message', '<div class="alert alert-danger"> Access Denied: Admins only.</div>');
            redirect('auth/login');
        }
    }
}

if (!function_exists('check_user')) {
    function check_user()
    {
        cek_login();
        $CI = &get_instance();
        if ($CI->session->userdata('role_id') != '2') {
            $CI->session->set_flashdata('message', '<div class="alert alert-danger"> Access Denied: Users only.</div>');
            redirect('auth/login');
        }
    }
}
