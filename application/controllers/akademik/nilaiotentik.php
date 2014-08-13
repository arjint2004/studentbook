<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Nilaiotentik extends CI_Controller {
	 function __construct()
	 {
		parent::__construct();
		$this->load->library('auth');
		$this->load->helper('global');
		$this->auth->logged_in();
	 }
	function index(){
		$data['main'] 	= 'akademik/nilaiotentik/index';
		$data['page_title'] 	= 'Nilai';
		$this->load->view('layout/ad_blank',$data);
	}
	function pranilai($param=''){
		$this->load->model('ad_kelas');
		$data['jenis'] 	=base64_decode($jenis);
		
		if(isset($_POST['kelas'])){
			
		}
		
		$data['kelas'] 	=$this->ad_kelas->getkelasByPengajar($this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['user_authentication']['id_pengguna']);
		$data['main'] 	= 'akademik/nilaiotentik/pranilaiotentik';
		$data['page_title'] 	= 'Nilai Otentik';
		$this->load->view('layout/ad_blank',$data);
	}
	function nilai($param=''){
		$this->load->model('ad_kelas');
		$data['jenis'] 	=base64_decode($jenis);
		
		if(isset($_POST['kelas'])){
			
		}
		
		$data['kelas'] 	=$this->ad_kelas->getkelasByPengajar($this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['user_authentication']['id_pengguna']);
		$data['main'] 	= 'akademik/nilaiotentik/nilaiotentik';
		$data['page_title'] 	= 'Nilai Otentik';
		$this->load->view('layout/ad_blank',$data);
	}

	
}
?>