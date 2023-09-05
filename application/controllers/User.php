<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
	public function __construct(){
        parent::__construct();
		if($this->session->userdata('level')!='admin'){ redirect(base_url('err')); }
        $this->load->model('M_user');
    }
	private function buat_notif($message, $warna){
		return '
		<div class="alert alert-'.$warna.' alert-dismissable fade show" role="alert">
			<i class="mdi mdi-exclamation"></i>'.$message.'
		</div>';
	}

	//view
	public function index(){
		$data['user'] = $this->M_user->get_user();
		$this->template->load('layout/template', 'user_index', 'Daftar User', $data);
	}
	public function tambah(){
		$this->template->load('layout/template', 'form_user', 'Tambah User');
	}
	public function edit($id){
		$data['user'] = $this->M_user->get_user_by_id($id);
		$this->template->load('layout/template', 'form_user', 'Edit User', $data);
	}

	//backend
	public function hapus_user($id){
        if($this->M_user->delete($id)){
			$this->session->set_flashdata('alert',$this->buat_notif('User berhasil dihapus!', 'warning'));
			redirect(base_url('user'));
        }else{
            $this->session->set_flashdata('alert',$this->buat_notif('User gagal dihapus!', 'danger'));
			redirect(base_url('user'));
        }
	}
	public function simpan(){
		$username = $this->input->post('username');
		$cekusername = $this->M_user->cek_user($username);
		if($cekusername){
			$this->session->set_flashdata('alert',$this->buat_notif('User sudah dipakai!', 'warning'));
			redirect(base_url('user'));
		}
		if($this->M_user->insert_data_user()){
			$this->session->set_flashdata('alert',$this->buat_notif('User berhasil ditambahkan!', 'success'));
			redirect(base_url('user'));
        } else {
            $this->session->set_flashdata('alert',$this->buat_notif('User gagal ditambahkan!', 'danger'));
			redirect(base_url('user'));
        }
	}
	public function update_user($id){
		if($this->M_user->update_data_user($id)){
			$this->session->set_flashdata('alert',$this->buat_notif('User berhasil diedit!', 'success'));
			redirect(base_url('user'));
        } else {
            $this->session->set_flashdata('alert',$this->buat_notif('User gagal diedit!', 'danger'));
			redirect(base_url('user'));
        }
	}
}
