<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Biodatasiswa extends CI_Controller
    {
		public function __construct()
        {
            parent::__construct();
            $this->load->helper('akademik');
            $this->load->library('session');
            $this->load->library('auth');
            $this->auth->user_logged_in();
        }
		
		function edit($param=''){
			if(isset($_POST['param'])){$param=$_POST['param'];}
			$params=unserialize($this->myencrypt->decode($param));
			$this->load->model('ad_siswa');
			if(isset($_POST['param'])){
				unset($_POST['param']);
				$this->db->where('id',$params['id']);
				if($this->db->update('ak_siswa',$_POST)){
					//echo $this->db->last_query();
					die();
				}
				
			}
			$data['siswa']=$this->ad_siswa->getsiswaByIdSiswa($params['id']);
			//pr($data['siswa']);die();
			$data['page_title'] 	= 'Edit Biodata Siswa';
			$data['param'] 	=$param;
			$data['main']= 'akademik/siswa/editsiswa';
			$this->load->view('layout/ad_blank',$data);
		}
}