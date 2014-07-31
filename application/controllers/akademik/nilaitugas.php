<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Nilaitugas extends CI_Controller
    {
        public function __construct()
        {
            parent::__construct();
            $this->load->helper('global');
            $this->load->library('session');
            $this->load->library('auth');
            $this->auth->user_logged_in();
        }
        
        public function index()
        {
			$this->load->model('ad_siswa');
			$data['siswa']= $this->ad_siswa->getsiswaByIdKelas($_POST['id_kelas']);
            $session = session_data();
            $data['main']           = 'akademik/nilaipr/index';
            $this->load->view('layout/ad_blank',$data);
        } 
        public function add()
        {
			$siswa2=array();
			$this->load->model('ad_siswa');
			$session = session_data();
			
			
			$siswa=$this->ad_siswa->getsiswaByIdKelas(@$_POST['id_kelas']);
			foreach($siswa as $siswadata){
				$siswa2[$siswadata['id_siswa_det_jenjang']]=$siswadata;
			}
			$data['siswa']= $siswa2;
            $session = session_data();
            $data['main']           = 'akademik/nilaipr/add';
            $this->load->view('layout/ad_blank',$data);
        }
        public function edit()
        {
			$siswa2=array();
			$this->load->model('ad_siswa');
			$this->load->model('ad_nilai');
			$session = session_data();
			//ambil nilai berdasarkan subject
			$jenis=base64_decode($_POST['jenis']);
			$nilai= $this->ad_nilai->getNilaiBySubjectTaSm($_POST['id_subject'],$jenis);
			$nilai2=array();
			foreach($nilai as $nilaidata){
				$nilai2[$nilaidata['id_siswa_det_jenjang']]=$nilaidata;
			}
			
			$siswa=$this->ad_siswa->getsiswaByIdKelas(@$_POST['id_kelas']);
			foreach($siswa as $siswadata){
				$siswa2[$siswadata['id_siswa_det_jenjang']]=$siswadata;
			}
			
			$data['id_subject']= $_POST['id_subject'];
			$data['nilai']= $nilai2;
			$data['siswa']= $siswa2;
			
            $session = session_data();
            $data['main']           = 'akademik/nilaipr/edit';
            $this->load->view('layout/ad_blank',$data);
        }        

        
        
    }
?>