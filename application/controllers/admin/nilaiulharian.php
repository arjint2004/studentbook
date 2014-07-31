<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Nilaiulharian extends CI_Controller {
	 function __construct()
	 {
		parent::__construct();
		$this->load->library('auth');
		$this->auth->logged_in();
		$this->load->model('ad_pelajaran');
	 }
	function index(){
		$data['main'] 	= 'schooladmin/nilai/index';
		$data['page_title'] 	= 'Nilai';
		$this->load->view('layout/ad_adminsekolah',$data);
	}
	function harian(){
		$data['main'] 	= 'schooladmin/nilai/subjectulanganharian';
		$data['page_title'] 	= 'Nilai Ulangan Harian';
		$this->load->view('layout/ad_adminsekolah',$data);
	}
	function addSubjectUlHarian($jenis=''){
	
		$this->load->model('ad_kelas');
		if(isset($_POST['subject']) && isset($_POST['id_kelas']) && isset($_POST['id_pelajaran'])){
			$insert=array(
							'id_sekolah'=>$this->session->userdata['user_authentication']['id_sekolah'],
							'id_kelas'=>$_POST['id_kelas'],
							'id_pelajaran'=>$_POST['id_pelajaran'],
							'ta'=>$this->session->userdata['ak_setting']['ta'],
							'semester'=>$this->session->userdata['ak_setting']['semester'],
							'jenis'=>$_POST['jenis'],
							'subject'=>$_POST['subject']
			);
			$this->db->insert('ak_subject_nilai',$insert);
		}
		$data['jenis'] 	=base64_decode($jenis);
		$data['kelas'] 	=$this->ad_kelas->getkelas($this->session->userdata['user_authentication']['id_sekolah']);
		$data['main'] 	= 'schooladmin/nilai/addsubjectulharian'; // memilih view
		$this->load->view('layout/ad_blank',$data); // memilih layout
		
	}
	function listSubjectUlanganHarian(){
		$this->load->model('ad_kelas');
		$this->load->model('ad_ulharian');
		$data['subject'] 	= array();	
		if(isset($_POST['kelas'])){
			$data['subject'] 	=  $this->ad_ulharian->getSubjectUlangan($_POST['kelas'],$_POST['pelajaran']);		
		}

		$data['kelas'] 	=$this->ad_kelas->getkelas($this->session->userdata['user_authentication']['id_sekolah']);
		if ($this->input->post('ajax')) {
		   $data['main'] 	= 'schooladmin/nilai/listsubjectulanganharian'; // memilih view
		   $this->load->view('layout/ad_blank',$data); // memilih layout
		} else {
		   $data['main'] 	= 'schooladmin/nilai/listsubjectulanganharian';// memilih view
		   $this->load->view('layout/ad_adminsekolah',$data);
		}
	}
	
	function inputDataUlanganHarian(){
		$this->load->model('ad_kelas');
		$this->load->model('ad_siswa');
		$data['siswa'] 	= array();	
		if(isset($_POST['kelas'])){
			$data['siswa'] 	=  $this->ad_siswa->getsiswaByIdKelas($_POST['kelas']);		
		}

		$data['kelas'] 	=$this->ad_kelas->getkelas($this->session->userdata['user_authentication']['id_sekolah']);
		if ($this->input->post('ajax')) {
		   $data['main'] 	= 'schooladmin/nilai/listdataulanganharian'; // memilih view
		   $this->load->view('layout/ad_blank',$data); // memilih layout
		} else {
		   $data['main'] 	= 'schooladmin/nilai/listdataulanganharian';// memilih view
		   $this->load->view('layout/ad_adminsekolah',$data);
		}
	}
	
	
}
?>