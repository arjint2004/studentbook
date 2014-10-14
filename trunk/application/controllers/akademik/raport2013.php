<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Raport2013 extends CI_Controller
    {
		public function __construct()
        {
            parent::__construct();
            $this->load->helper('akademik');
            $this->load->library('session');
            $this->load->library('auth');
            $this->auth->user_logged_in();
        }
        public function index($id_det_jenjang=null)
        {
			$this->load->model('ad_siswa');
			$data['siswa']=$this->ad_siswa->getsiswaByIdKelas(@$_POST['id_kelas']);
			$data['main']= 'akademik/raport2013/index';
            $this->load->view('layout/ad_blank',$data);	
		}
        public function lihat($param='')
        {
			$datasiswa=unserialize($this->myencrypt->decode($param));
			$this->load->model('ad_siswa');
			$data['siswa']=$this->ad_siswa->getsiswaByIdKelas(@$_POST['id_kelas']);
			$data['main']= 'akademik/raport2013/raport';
            $this->load->view('layout/ad_blank',$data);	
		}		
    }
?>