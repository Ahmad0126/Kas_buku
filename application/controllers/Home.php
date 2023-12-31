<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->model('M_user');
    }
	public function index(){
		if(!$this->session->userdata('id')){ redirect(base_url('login')); }
        $this->load->model('M_transaksi');
        $data['user'] = $this->M_user->get_user();
        $data['info'] = $this->M_transaksi->get_info();
		$this->template->load('layout/template', 'dashboard', 'Dashboard', $data);
	}
	public function login(){
		$this->template->load('layout/template1', 'login', 'Login');
	}
    public function profil(){
        $data['user'] = $this->M_user->get_user_by_id($this->session->userdata('id'));
        $this->template->load('layout/template', 'profil', 'Profil', $data);
    }

    public function update_user($id){
        $this->M_user->update_data(array('nama' => $this->input->post('nama')), $id);
        $this->session->set_userdata('nama', $this->input->post('nama'));
        $this->session->set_flashdata('oop', $this->template->notif('Profil berhasil diubah!', 'success'));
        redirect(base_url());
    }
    public function update_pass($id){
        $pass = $this->input->post('password');
        $pl = $this->input->post('pl');
        $pk = $this->input->post('pk');
		$cek = $this->M_user->getwu_user($this->session->userdata('username'));
        if($cek){
            if(md5($pl) == $cek['password']){
                if($pass == $pk){
                    $this->M_user->update_data(array('password' => md5($pass)), $id);
                    $user = array('level', 'id', 'nama', 'username');
                    $this->session->unset_userdata($user);
                    $this->session->set_flashdata('oop', $this->template->notif('Password berhasil diubah!', 'success'));
                    redirect(base_url('login'));
                }else{
                    $this->session->set_flashdata('pl_val', $pl);
                    $this->session->set_flashdata('pp_val', $pass);
                    $this->session->set_flashdata('pk_val', $pk);
                    $this->session->set_flashdata('konf', 'Password Tidak Sama!');
                    redirect(base_url('home/profil'));
                }
            }else{
                $this->session->set_flashdata('pl_val', $pl);
                $this->session->set_flashdata('pp_val', $pass);
                $this->session->set_flashdata('pk_val', $pk);
                $this->session->set_flashdata('password', 'Password Salah!');
                redirect(base_url('home/profil'));
            }
        }
    }
	public function log_in(){
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
        $user = array('level', 'id', 'nama', 'username');
        $this->session->unset_userdata($user);
        $this->session->sess_destroy();
        redirect(base_url('login'));
    }
	public function err(){
		$this->template->load('layout/template1', 'errors/html/err_404', 'Halaman tidak ditemukan');
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
        $total = 0;
        foreach($data['duit'] as $fer){
            $this->fpdf->Cell(7, 6, $no++ , 1, 0);
            $this->fpdf->Cell(25, 6, $fer['tanggal'], 1, 0);
            $this->fpdf->Cell(85, 6, $fer['keterangan'], 1, 0);
            $this->fpdf->Cell(30, 6, $fer['username'], 1, 0);
            $this->fpdf->Cell(35, 6, 'Rp '.number_format($fer['nominal']), 1, 1);
            $total += $fer['nominal'];
        }

        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->Cell(147, 6, 'Total Keseluruhan', 1, 0);
        $this->fpdf->Cell(35, 6, 'Rp '.number_format($total), 1, 1);

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
