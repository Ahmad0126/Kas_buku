<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengeluaran extends CI_Controller {
    public function __construct(){
        parent::__construct();
		if(!$this->session->userdata('id')){ redirect(base_url('err')); }
        $this->load->model('M_transaksi');
    }
    private function buat_notif($message, $warna){
		return '
		<div class="alert alert-'.$warna.' alert-dismissable fade show" role="alert">
			<i class="fa fa-exclamation-circle me-2"></i>'.$message.'
			<button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>';
	}

    public function index(){
		$data['transaksi'] = $this->M_transaksi->get_transaksi('keluar');
        $this->template->load('layout/template', 'pn_index', 'Daftar pengeluaran', $data);
	}

    public function hapus($id){
        if($this->M_transaksi->delete($id)){
			$this->session->set_flashdata('alert',$this->buat_notif('Transaksi berhasil dihapus!', 'warning'));
			redirect(base_url('pengeluaran'));
        }else{
            $this->session->set_flashdata('alert',$this->buat_notif('Transaksi gagal dihapus!', 'danger'));
			redirect(base_url('pengeluaran'));
        }
	}
    public function simpan(){
		if($this->M_transaksi->masuk('keluar')){
			$this->session->set_flashdata('alert',$this->buat_notif('Transaksi berhasil ditambahkan!', 'success'));
			redirect(base_url('pengeluaran'));
        } else {
            $this->session->set_flashdata('alert',$this->buat_notif('Transaksi gagal ditambahkan!', 'danger'));
			redirect(base_url('pengeluaran'));
        }
	}
}