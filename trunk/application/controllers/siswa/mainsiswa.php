<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Mainsiswa extends CI_Controller
    {
        public function __construct()
        {
            parent::__construct();
            $this->load->helper('akademik');
            $this->load->helper('global');
            $this->load->library('session');
            $this->load->library('auth');
            $this->auth->user_logged_in();
            $this->load->library('image_moo');
        }
        
        public function index()
        {	
			$this->load->model('ad_siswa');
            $datasiswa=$this->ad_siswa->getsiswaByIdDetJenjang($this->session->userdata['user']['id_siswa_det_jenjang']);
            $data['datasiswa']= $datasiswa;
            $data['main']= 'siswa/main';
            $this->load->view('layout/ak_default',$data);
        }
        
    }
?>