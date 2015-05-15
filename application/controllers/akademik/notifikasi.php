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
			if($this->session->userdata['user_authentication']['otoritas']=='siswa'){
				$id_pengguna=$this->session->userdata['user_authentication']['id_siswa'];
			}elseif($this->session->userdata['user_authentication']['otoritas']=='ortu'){
				$id_pengguna=$this->session->userdata['user_authentication']['id_pengguna'];
			}
			$data['notif']=$this->ad_notifikasi->get_notifByIdPengguna($id_pengguna);
			//pr($id_pengguna);
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
        public function hportu()
        {
			$this->load->model('ad_siswa');
			$this->load->model('ad_kelas');
			
			if(isset($_POST['hp']) && !empty($_POST['hp'])){
				foreach($_POST['hp'] as $id_ortu=>$hpnya){
					$this->db->where(array('id'=>$id_ortu,'id_sekolah'=>$this->session->userdata['user_authentication']['id_sekolah']));
					$this->db->update('ak_pegawai',array('hp'=>$hpnya));
					//pr($this->db->last_query());
				}
			}
			
			$kelas 	=$this->ad_kelas->getKelasByWali($this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['user_authentication']['id_pengguna']);
			
			$data['siswa']=$this->ad_siswa->getsiswaByIdKelas($kelas[0]['id'],'s.id as id_siswa, s.nama, ap.id as id_ortu, ap.hp, ap.nama as nama_ortu,ak.nama as nama_kelas,ak.kelas');
			$data['main'] 	= 'akademik/notifikasi/hportu';
			$this->input->is_ajax_request() and $this->load->view('layout/ad_blank',$data);
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