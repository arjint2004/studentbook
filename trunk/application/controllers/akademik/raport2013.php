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
			$this->load->library('ak_akademik');
			$this->load->model('ad_siswa');
			$this->load->model('ad_sekolah');
			$this->load->model('ad_extrakurikuler');
			$this->load->model('ad_kelas');
			$data['kelas']=$this->ad_kelas->getWaliByIdKelas($this->session->userdata['user_authentication']['id_sekolah'],$datasiswa['id_kelas']);
			$data['ekstra']=$this->ad_extrakurikuler->getEkstrakurikulerByIdDetjenjang($datasiswa['id_siswa_det_jenjang']);
			$data['nilaiekstra']=$this->ad_extrakurikuler->getNilaiByidDetJenjang($datasiswa['id_siswa_det_jenjang']);
			$data['raport']=$this->ak_akademik->nilaiRaportPerSiswa2013($datasiswa['id_siswa_det_jenjang']);
			$data['nilai_kompt']=$this->ak_akademik->get_nilaiKompetensiKogn($datasiswa['id_siswa_det_jenjang']);
			unset($data['raport']['submapel']);
			//pr($data['nilai_kompt']);die();
			$data['siswa']=$this->ad_siswa->getsiswaByIdSiswa($datasiswa['id']);
			$data['sekolah']=$this->ad_sekolah->getSekolahdata($this->session->userdata['user_authentication']['id_sekolah']);
			$data['kepsek']=$this->ad_sekolah->getKepsek($this->session->userdata['user_authentication']['id_sekolah']);
			//pr($data['sekolah']);die();
			$data['main']= 'akademik/raport2013/raport';
            $this->load->view('layout/ad_blank',$data);	
		}		
    }
?>