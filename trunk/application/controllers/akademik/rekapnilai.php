<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Rekapnilai extends CI_Controller
    {
		public function __construct()
        {
            parent::__construct();
            $this->load->helper('akademik');
            $this->load->library('session');
            $this->load->library('auth');
            $this->auth->user_logged_in();
        }
        public function index()
        {
			$this->load->model('ad_kelas');
			$data['kelas'] 	=$this->ad_kelas->getkelasByPengajar($this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['user_authentication']['id_pengguna']);
			$data['main']= 'akademik/rekapnilai/index';
            $this->load->view('layout/ad_blank',$data);	
		}
        public function rekapnilailist()
        {
			echo rekapitulasinilaiByKelasMapel($_POST['id_kelas'],$_POST['pelajaran']);
			die();
			//$data['main']= 'akademik/rekapnilai/rekapnilai';
            //$this->load->view('layout/ad_blank',$data);	
		} 
  
    }
?>