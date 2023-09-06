<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_transaksi extends CI_Model{
    protected $table1 = 'transaksi';
    protected $table3 = 'user';
    protected $status = '';
    protected $rules1 = [
        [
            'field' => 'nominal',
            'label' => 'Nominal',
            'rules' => 'required|integer|is_natural'
        ],
        [
            'field' => 'keterangan',
            'label' => 'Keterangan',
            'rules' => 'required'
        ]
    ];
    private function validation(){
        $this->form_validation->set_rules($this->rules1);
        if ($this->form_validation->run() == TRUE){
            $user = [
                'username' => $this->session->userdata('username'),
                'tanggal' => $this->input->post('tanggal'),
                'nominal' => $this->input->post('nominal'),
                'keterangan' => $this->input->post('keterangan'),
                'jenis_transaksi' => $this->status
            ];
            return $user;
        }
        return FALSE;
    }
    public function get_info(){
        $data = array();
        $data['pn_hari'] = $this->get_total_pp_by_tanggal('keluar', date('Y-m-d'));
        $data['pn_bulan'] = $this->get_total_pp_by_tanggal('keluar', date('Y-m'));
        $data['pn_total'] = $this->get_total_pp(array('jenis_transaksi' => 'keluar'));
        $data['pm_hari'] = $this->get_total_pp_by_tanggal('masuk', date('Y-m-d'));
        $data['pm_bulan'] = $this->get_total_pp_by_tanggal('masuk', date('Y-m'));
        $data['pm_total'] = $this->get_total_pp(array('jenis_transaksi' => 'masuk'));
        $data['saldo'] = $this->get_saldo();
        return $data;
    }
    public function get_laporan_pp($select){
        $where = array();
        $like = array();
        $data = array();
        $tanggal = '';
        $saldo = array();
        $user = 'semua user';
        $t1 = '';
        $t2 = '';
        $u1 = '';
        
            if($this->input->post('tanggal1') != null && $this->input->post('tanggal2') != null){
                $where += array(
                    'tanggal >=' => $this->input->post('tanggal1'),
                    'tanggal <=' => $this->input->post('tanggal2')
                );
                $tanggal = 'Dari tanggal '.$this->input->post('tanggal1').' sampai '.$this->input->post('tanggal2');
                $t1 = $this->input->post('tanggal1');
                $t2 = $this->input->post('tanggal2');
            }
            if($this->input->post('user') != 'semua'){
                $this->db->like('username', $this->input->post('user'));
                $user = 'user '.$this->input->post('user');
                $u1 = $this->input->post('user');
            }
        
        if($select == 'pm'){
            $where += array('jenis_transaksi' => 'masuk');
            $data = array(
                'title' => 'Laporan Pemasukan '.$user,
                'jenis' => 'masuk'
            );
        }else if($select == 'pn'){
            $where += array('jenis_transaksi' => 'keluar');
            $data = array(
                'title' => 'Laporan Pengeluaran '.$user,
                'jenis' => 'keluar'
            );
        }else if($select == 'pp'){
            $saldo = $this->get_array_saldo($t1, $t2, $u1);
            if($this->input->post('user') != 'semua'){
                $where += array('username' => $u1);
            }
            $subtt = '';
            if($t1 != ''){
                $subtt = 'Saldo sebelum tanggal '.$t1;
            }
            $totalpm = $this->get_total_pp($where + array('jenis_transaksi' => 'masuk'));
            $totalpn = $this->get_total_pp($where + array('jenis_transaksi' => 'keluar'));
            // var_dump($totalpm, $totalpn); die;
            $data = array(
                'title' => 'Laporan Pemasukan dan Pengeluaran '.$user,
                'jenis' => 'pp',
                'saldos' => $saldo,
                'total_pm' => $totalpm,
                'total_pn' => $totalpn,
                'subsubtitle' => $subtt
            );
        }
        $this->db->where($where);
        $this->db->order_by('tanggal', 'ASC');
        $data += array('duit' => $this->db->get($this->table1)->result_array(), 'subtitle' => $tanggal);
        // var_dump($data); die;
        return $data;
    }
    public function get_transaksi($jenis){
        $this->db->order_by('tanggal', 'DESC');
        return $this->db->get_where($this->table1, array('jenis_transaksi' => $jenis))->result();
    }
    private function get_tr(){
        $this->db->order_by('tanggal', 'ASC');
        return $this->db->get($this->table1)->result_array();
    }
    private function get_total_pp_by_tanggal($field, $tanggal){
        $this->db->select('sum(nominal) as total');
        $this->db->from($this->table1);
        $this->db->where('jenis_transaksi', $field);
        $this->db->like('tanggal', $tanggal);
        $list = $this->db->get()->row_array();
        if($list['total'] == null){
            return 0;
        }else{ return $list['total']; }
    }
    private function get_total_pp(array $field){
        $this->db->select('nominal');
        $this->db->from($this->table1);
        $this->db->where($field);
        $list = $this->db->get()->result_array();
        $total = 0;
        foreach($list as $fer){
            $total += $fer['nominal'];
        }
        return $total;
    }
    private function get_saldo(){
        $saldo = 0;
        $list = $this->get_tr();
        foreach($list as $fer){
            if($fer['jenis_transaksi'] == 'keluar'){
                $saldo -= $fer['nominal'];
            }else{
                $saldo += $fer['nominal'];
            }
        }
        return $saldo;
    }
	public function get_array_saldo($tanggal1 = '', $tanggal2 = '', $user = ''){
		$hasil = array(); //saldobefore, saldo, total_masuk, total_keluar
        $saldobefore = 0;
        $where1 = array();
        $where2 = array();
        $saldo = array();
        if($user != ''){
            $where1 += array('username' => $user);
            $where2 += array('username' => $user);
        }
        if($tanggal1 != ''){
            $where1 += array('tanggal <' => $tanggal1);
            $this->db->select('nominal, id_transaksi, jenis_transaksi');
			$this->db->order_by('tanggal', 'ASC');
			$this->db->where($where1);
			$list = $this->db->get($this->table1)->result_array();
			foreach($list as $fer){
				if($fer['jenis_transaksi'] == 'keluar'){
					$saldobefore -= $fer['nominal'];
				}else{
					$saldobefore += $fer['nominal'];
				}
			}
        }
        $hasil += array('saldobefore' => $saldobefore);
        if($tanggal2 != ''){
            $where2 += array('tanggal >=' => $tanggal1, 'tanggal <=' => $tanggal2);
        }
        		
        $this->db->select('nominal, jenis_transaksi');
        $this->db->order_by('tanggal', 'ASC');
        $this->db->where($where2);
        $list = $this->db->get($this->table1)->result_array();
        foreach($list as $fer){
            if($fer['jenis_transaksi'] == 'keluar'){
                array_push($saldo, $saldobefore -= $fer['nominal']);
            }else{
                array_push($saldo, $saldobefore += $fer['nominal']);
            }
        }
        $hasil += array('saldo' => $saldo);
        return $hasil;
    }
    public function masuk($status){
        $this->status = $status;
        $validation_ = $this->validation();
        if($validation_){
            return $this->insert($validation_);
        }else{
            return FALSE;
        }
    }
    private function insert($data){
        $this->db->insert($this->table1, $data);
        return TRUE;
    }
    public function delete($id){
        $this->db->delete($this->table1, array('id_transaksi' => $id));
        return TRUE;
    }
}
