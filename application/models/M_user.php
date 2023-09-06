<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_user extends CI_Model{
    protected $_table = 'user';
    protected $rules1 = [
        [
            'field' => 'username',
            'label' => 'Username',
            'rules' => 'required|is_unique[user.username]'
        ], 
        [
            'field' => 'password',
            'label' => 'Password',
            'rules' => 'required'
        ], 
        [
            'field' => 'nama',
            'label' => 'Nama',
            'rules' => 'required'
        ],
        [
            'field' => 'level',
            'label' => 'Level',
            'rules' => 'required|in_list[admin,user]'
        ]
    ];
    protected $rules2 = [
        [
            'field' => 'nama',
            'label' => 'Nama',
            'rules' => 'required|min_length[5]'
        ],
        [
            'field' => 'level',
            'label' => 'Level',
            'rules' => 'required|in_list[admin,user]'
        ]
    ];
    protected $default_rules;
    protected $update;

    private function validation(){
        $this->form_validation->set_rules($this->default_rules);
        if ($this->form_validation->run() == TRUE){
            if($this->update){
                $user = [
                    'nama' => $this->input->post('nama'),
                    'level' => $this->input->post('level')
                ];
            }else{
                $user = [
                    'username' => $this->input->post('username'),
                    'password' => md5($this->input->post('password')),
                    'nama' => $this->input->post('nama'),
                    'level' => $this->input->post('level')
                ];
            }
            return $user;
        }
        return FALSE;
    }
    
    public function get_user(){
        return $this->db->get($this->_table)->result();
    }
    public function get_user_by_id($id){
        return $this->db->get_where($this->_table, array('id_user' => $id))->row_array();
    }
    public function getwu_user($user){
        return $this->db->get_where($this->_table, array('username' => $user))->row_array();
    }
    public function cek_user($username){
        return $this->db->where('username', $username)->count_all_results('user');
    }
    
    private function insert_user($data){
        $this->db->insert($this->_table, $data);
        return TRUE;
    }
    public function delete($id){
        $this->db->delete($this->_table, array('id_user' => $id));
        return TRUE;
    }
    public function insert_data_user(){
        $this->default_rules = $this->rules1;
        $this->update = false;
        $validation_user = $this->validation();
        if ($validation_user){
            return $this->insert_user($validation_user);
        } else {
            return FALSE;
        }
    }
    private function update_user($data, $id){
        $this->db->where('id_user',$id);
        $this->db->update($this->_table, $data);
        return TRUE;
    }
    public function update_data_user($id){
        $this->default_rules = $this->rules2;
        $this->update = true;
        $validation_user = $this->validation();
        if ($validation_user){
            return $this->update_user($validation_user, $id);
        } else {
            return FALSE;
        }
    }
}