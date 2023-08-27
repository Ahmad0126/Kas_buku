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
            $this->buat_pmn($data);
        }else{
            $this->buat_pp_all($data);
        }
    }
    private function buat_pmn(array $data){
        $this->load->library('fpdf');
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
        $this->fpdf->Cell(25, 6, 'Tanggal', 1, 0);
        $this->fpdf->Cell(85, 6, 'Keterangan', 1, 0);
        $this->fpdf->Cell(30, 6, 'Username', 1, 0);
        $this->fpdf->Cell(35, 6, 'Nominal', 1, 1);

        $this->fpdf->SetFont('Arial', '', 10);
        $no = 1;
        foreach($data['duit'] as $fer){
            $this->fpdf->Cell(7, 6, $no++ , 1, 0);
            $this->fpdf->Cell(25, 6, $fer['tanggal'], 1, 0);
            $this->fpdf->Cell(85, 6, $fer['keterangan'], 1, 0);
            $this->fpdf->Cell(30, 6, $fer['username'], 1, 0);
            $this->fpdf->Cell(35, 6, 'Rp '.number_format($fer['nominal']), 1, 1);
        }
        $this->fpdf->Output();
    }
    private function buat_pp_all($data){
        $this->load->library('fpdf');
        $this->fpdf->AddPage();
        $this->fpdf->SetFont('Arial', 'B', 16);
        $this->fpdf->Cell(190, 7, $data['title'], 0, 1, 'C');
        if($data['subtitle'] != ''){
            $this->fpdf->SetFont('Arial', 'B', 12);
            $this->fpdf->Cell(190, 7, $data['subtitle'], 0, 1, 'C');
        }
        $this->fpdf->Cell(190, 7, '', 0, 1);
        //title <th>
        $this->fpdf->SetFont('Arial', 'B', 9);
        $this->fpdf->Cell(6, 6, 'No', 1, 0);
        $this->fpdf->Cell(20, 6, 'Tanggal', 1, 0);
        $this->fpdf->Cell(70, 6, 'Keterangan', 1, 0);
        $this->fpdf->Cell(20, 6, 'Username', 1, 0);
        $this->fpdf->Cell(25, 6, 'Pemasukan', 1, 0);
        $this->fpdf->Cell(25, 6, 'Pengeluaran', 1, 0);
        $this->fpdf->Cell(25, 6, 'Saldo', 1, 1);

        if($data['subsubtitle'] != ''){
            $this->fpdf->Cell(166, 6, $data['subsubtitle'], 1, 0);
            $this->fpdf->Cell(25, 6, 'Rp '.number_format($data['saldos']['saldobefore']), 1, 1);
        }

        $this->fpdf->SetFont('Arial', '', 9);
        $no = 1;
        $num = 0;
        if($data['saldos']['saldo'] != array()){
            foreach($data['duit'] as $fer){
                $this->fpdf->Cell(6, 6, $no++ , 1, 0);
                $this->fpdf->Cell(20, 6, $fer['tanggal'], 1, 0);
                $this->fpdf->Cell(70, 6, $fer['keterangan'], 1, 0);
                $this->fpdf->Cell(20, 6, $fer['username'], 1, 0);
                if($fer['jenis_transaksi'] == 'masuk'){$this->fpdf->Cell(25, 6, 'Rp '.number_format($fer['nominal']), 1, 0);}
                else{ $this->fpdf->Cell(25, 6, 'Rp -', 1, 0); }
                if($fer['jenis_transaksi'] == 'keluar'){ $this->fpdf->Cell(25, 6, 'Rp '.number_format($fer['nominal']), 1, 0); }
                else{ $this->fpdf->Cell(25, 6, 'Rp -', 1, 0); }
                $this->fpdf->Cell(25, 6, 'Rp '.number_format($data['saldos']['saldo'][$num++]), 1, 1);
            }

            $this->fpdf->SetFont('Arial', 'B', 9);
            $this->fpdf->Cell(116, 6, 'Total Keseluruhan', 1, 0);
            $this->fpdf->Cell(25, 6, 'Rp '.number_format($data['total_pm']), 1, 0);
            $this->fpdf->Cell(25, 6, 'Rp '.number_format($data['total_pn']), 1, 0);
            $this->fpdf->Cell(25, 6, 'Rp '.number_format($data['saldos']['saldo'][$num - 1]), 1, 1);
        }else{
            $this->fpdf->SetFont('Arial', '', 9);
            $this->fpdf->Cell(191, 6, 'tidak ada data', 1, 0, 'C');
        }

        $this->fpdf->Output();
    }
}
