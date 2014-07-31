<?php
    class Auth extends CI_Model
    {
        public function get_user() {
            $username = $this->input->post('username');
            $password = md5($this->input->post('password'));
            $this->db->select('*');
            $this->db->from('users');
            $this->db->where('username',$username);
            $this->db->where('password',$password);
            $result = $this->db->get();
            if($result->num_rows()>0) {
                return $result->row();
            }else {
                return '';
            }
        }
    }
?>