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
        $data['pn_total'] = $this->get_total_pp('keluar');
        $data['pm_hari'] = $this->get_total_pp_by_tanggal('masuk', date('Y-m-d'));
        $data['pm_bulan'] = $this->get_total_pp_by_tanggal('masuk', date('Y-m'));
        $data['pm_total'] = $this->get_total_pp('masuk');
        $data['saldo'] = $this->get_saldo();
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
        $this->db->select('nominal');
        $this->db->from($this->table1);
        $this->db->where('jenis_transaksi', $field);
        $this->db->like('tanggal', $tanggal);
        $list = $this->db->get()->result_array();
        $total = 0;
        foreach($list as $fer){
            $total += $fer['nominal'];
        }
        return $total;
    }
    private function get_total_pp($field){
        $this->db->select('nominal');
        $this->db->from($this->table1);
        $this->db->where('jenis_transaksi', $field);
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