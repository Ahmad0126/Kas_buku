<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	public function index(){
		if(!$this->session->userdata('id')){ redirect(base_url('login')); }
        $this->load->model('M_transaksi');
        $this->load->model('M_user');
        $data['user'] = $this->M_user->get_user();
        $data['info'] = $this->M_transaksi->get_info();
		$this->template->load('layout/template', 'dashboard', 'Dashboard', $data);
	}
	public function login(){
		$this->template->load('layout/template1', 'login', 'Login');
	}

	public function log_in(){
		$this->load->model('M_user');
        $user = $this->input->post('username');
        $pass = $this->input->post('password');
		$cek = $this->M_user->getwu_user($user);
        if($cek){
            if(md5($pass) == $cek['password']){
                $this->session->set_userdata('level', $cek['level']);
                $this->session->set_userdata('id', $cek['id_user']);
                $this->session->set_userdata('nama', $cek['nama']);
                $this->session->set_userdata('username', $cek['username']);
                redirect(base_url());
            }else{
                $this->session->set_flashdata('username_val', $user);
                $this->session->set_flashdata('password', 'Password Salah!');
                redirect(base_url('login'));
            }
        }else{
            $this->session->set_flashdata('username_val', $user);
                $this->session->set_flashdata('username', 'Username tidak terdaftar!');
            redirect(base_url('login'));
        }
	}
	public function log_out(){
        $user = array('level', 'id', 'nama');
        $this->session->unset_userdata($user);
        $this->session->sess_destroy();
        redirect(base_url('login'));
    }
	public function err(){
		$this->template->load('layout/template1', 'errors/html/err_404', 'Halaman tidak ditemukan');
	}
    public function tes_model(){
        $this->load->model('M_transaksi');
        $this->M_transaksi->get_array_saldo();
    }
    public function laporan(){
        $this->load->model('M_transaksi');
        $select = $this->input->post('pp');
        $data = $this->M_transaksi->get_laporan_pp($select);
        if($data['jenis'] != 'pp'){
            $this->load->view('laporan', array('data' => $data));
        }else{
            $this->load->view('laporanpp', array('data' => $data));
        }
    }
}
