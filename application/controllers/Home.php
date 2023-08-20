<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	public function index(){
		if(!$this->session->userdata('id')){ redirect(base_url('login')); }
        $this->load->model('M_transaksi');
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
    public function laporan(){
        $this->load->library('fpdf');
        $this->load->model('M_transaksi');
        $select = $this->input->post('pp');
        $data = $this->M_transaksi->get_laporan_pp($select);
        $no = 1;
        $this->fpdf->AddPage();
        $this->fpdf->SetFont('Arial', 'B', 16);
        $this->fpdf->Cell(190, 7, $data['title'], 0, 1, 'C');
        if($data['subtitle'] != ''){
            $this->fpdf->SetFont('Arial', 'B', 12);
            $this->fpdf->Cell(190, 7, $data['subtitle'], 0, 1, 'C');
        }
        $this->fpdf->Cell(190, 7, '', 0, 1);
        //title <th>
        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->Cell(7, 6, 'No', 1, 0);
        $this->fpdf->Cell(30, 6, 'Tanggal', 1, 0);
        $this->fpdf->Cell(80, 6, 'Keterangan', 1, 0);
        $this->fpdf->Cell(30, 6, 'Username', 1, 0);
        $this->fpdf->Cell(40, 6, 'Nominal', 1, 1);

        $this->fpdf->SetFont('Arial', '', 10);
        foreach($data['duit'] as $fer){
            $this->fpdf->Cell(7, 6, $no++ , 1, 0);
            $this->fpdf->Cell(30, 6, $fer['tanggal'], 1, 0);
            $this->fpdf->Cell(80, 6, $fer['keterangan'], 1, 0);
            $this->fpdf->Cell(30, 6, $fer['username'], 1, 0);
            $this->fpdf->Cell(40, 6, 'Rp '.number_format($fer['nominal']), 1, 1);
        }
        $this->fpdf->Output();
    }
}
