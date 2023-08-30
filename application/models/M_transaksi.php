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
    function get_tahun_awal(){
        $this->db->select('tanggal');
        $this->db->from($this->table1);
        $this->db->where('sebab', 'kas');
        $this->db->order_by('tanggal', 'ASC');
        return $this->db->get()->row_array();
    }
    function merge_kas(){
        $kas = $this->get_kas();
        $bukan_kas = $this->get_bukan_kas();
        $no = 0;
        $last_no = 0;
        $ringkasan_kas = array();
        $hasil_kas = array();
        $last_tanggal = '';
        foreach ($kas as $fer) {
            $tanggal = substr($fer['tanggal'],0,10);
            $pemasukan = intval($fer['masuk']);
            $saldo = intval($fer['saldo']);
            if ($last_tanggal == $tanggal) {
                $ringkasan_kas[$last_no]['masuk'] += $pemasukan;
                $ringkasan_kas[$last_no]['saldo'] = $saldo;
            } else {
                $ringkasan_kas[$no] = ['tanggal' => $fer['tanggal'], 'masuk' => $pemasukan, 'keluar' => $fer['keluar'], 'sebab' => $fer['sebab'], 'saldo' => $saldo];
                $last_tanggal = $tanggal;
                $last_no = $no;
                $no++;
            }
        }
        function cmp_tgg($a, $b) {
            return strcmp($a['tanggal'], $b['tanggal']);
        }
        $hasil_kas = array_merge($ringkasan_kas, $bukan_kas);
        usort($hasil_kas, 'cmp_tgg');
        return $hasil_kas;
    }
    
    function extend_kas($tanggal){
        $this->db->select('id_anggota, nama');
        $query = $this->db->get($this->table3)->result_array();
        $no = 0;
        $bulan = [];
        foreach($query as $fer){
            for($i=1; $i<=12; $i++){
                if($i < 10){ $j = '0'.$i; }else{ $j = $i; }
                $look = $this->get_io($tanggal.'-'.$j, $fer['id_anggota']);
                if($look){
                    $bulan += [
                        $no++ => array('nama' => $fer['nama'],'value' => $look['masuk'], 'bulan' => $i)
                    ];
                }else{
                    $bulan += [
                        $no++ => array('nama' => $fer['nama'],'value' => '-', 'bulan' => $i)
                    ];
                }
            }
        }
        return $bulan;
    }
    private function get_io($tanggal, $id){
        $this->db->select('masuk');
        $this->db->like('tanggal', $tanggal);
        return $this->db->get_where($this->table1, array('id_anggota' => $id))->row_array();
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
    public function masuk_kas(){
        $this->db->select('id_anggota');
        $id = $this->db->get($this->table3)->result_array();
        foreach($id as $fer){
            $masuk = $this->input->post('user_'.$fer['id_anggota']);
            if(isset($masuk)){
                $validation_ = $this->validation($masuk, $fer['id_anggota']);
                if($validation_){
                    $this->insert($validation_);
                }
            }
        }
        return true;
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
