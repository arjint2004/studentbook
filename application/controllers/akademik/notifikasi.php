<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Notifikasi extends CI_Controller
    {
		public function __construct()
        {
            parent::__construct();
            $this->load->helper('akademik');
            $this->load->library('session');
            $this->load->library('ak_notifikasi');
            $this->load->model('ad_notifikasi');
            $this->load->library('auth');
            $this->auth->user_logged_in();
        }
        public function notifcount()
        {
			$data['jmlnotif']=$this->ad_notifikasi->get_notifAktif($this->session->userdata['user_authentication']['id_pengguna']);
			echo $data['jmlnotif'];
		}
        public function notif()
        {
			if(isset($this->session->userdata['user_authentication']['id_siswa'])){
				$id_pengguna=$this->session->userdata['user_authentication']['id_siswa'];
			}else{
				$id_pengguna=$this->session->userdata['user_authentication']['id_pengguna'];
			}
			$data['notif']=$this->ad_notifikasi->get_notifByIdPengguna($id_pengguna);
			$this->ad_notifikasi->setnotifreaded($this->session->userdata['user_authentication']['id_pengguna']);
			//$data['notifp']=$this->ad_notifikasi->get_notifByIdPengirim($this->session->userdata['user_authentication']['id_pengguna']);
			
			if ($this->input->post('ajax')) {
			   $data['main'] 	= 'akademik/notifikasi/notiflist'; // memilih view
			   $this->load->view('layout/ad_blank',$data); // memilih layout
			} else {
			   $data['main'] 	= 'akademik/notifikasi/notiflist';// memilih view
			   $this->load->view('layout/ad_adminsekolah',$data);
			} 
		}
        public function index($id_det_jenjang=null)
        {
			if ($this->input->post('ajax')) {
			   $data['main'] 	= 'akademik/notifikasi/index'; // memilih view
			   $this->load->view('layout/ad_blank',$data); // memilih layout
			} else {
			   $data['main'] 	= 'akademik/notifikasi/index';// memilih view
			   $this->load->view('layout/ad_adminsekolah',$data);
			} 
		}
		
        public function sms_notifikasi_ortu_perkelas($data=array())
        {
			/*
			$tmp='Ananda ';*/
		}
        public function akademik_notifikasi()
        {
			//$this->ad_notifikasi->add_notif_siswa_perkelas(7,'pr','pr=87');
			//$temp_notif=$this->ad_notifikasi->get_notif_tmp('pr');
			//$this->ak_notifikasi->set_notifikasi_akademik_per_kelas($id_kelas=7,$gorup_notif='tugas',$mapel='matematika',$judul='geometri',$nama_pengirim='asbin',$keterangan='segera kumpulkan bsok pagi') ;
			$this->ak_notifikasi->set_notifikasi_akademik_per_siswa($id_siswa=18,$gorup_notif='tugas',$mapel=5,$judul='geometri',$nama_pengirim='asbin',$keterangan='segera kumpulkan bsok pagi') ;
			//$this->ak_notifikasi->set_notifikasi_akademik_per_kelas($id_kelas=7,$gorup_notif='pr',$mapel=5,$judul='geometri',$nama_pengirim='asbin',$keterangan='segera kumpulkan bsok ');
			
		}
    }
?>