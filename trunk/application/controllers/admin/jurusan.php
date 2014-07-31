<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Jurusan extends CI_Controller {
	 function __construct()
	 {
		parent::__construct();
		$this->load->library('auth');
		$this->auth->logged_in();
		$this->load->model('ad_jurusan');
	 }
	function index(){
		
		$data['page_title'] 	= 'Data Jurusan';
		
		
		if ($this->input->post('ajax')) {
		   $data['main'] 	= 'schooladmin/jurusan/index'; // memilih view
		   $this->load->view('layout/ad_blank',$data); // memilih layout
		} else {
		   $data['main'] 	= 'schooladmin/jurusan/index';// memilih view
		   $this->load->view('layout/ad_adminsekolah',$data);
		} 
	}
	function adddata(){
		if(isset($_POST['addjurusan'])){
		
			//$datajur=$this->ad_jurusan->getdata($this->session->userdata['user_authentication']['id_sekolah']);
			
			$simpan['id_sekolah']=$this->session->userdata['user_authentication']['id_sekolah'];
			$simpan['nama']=$_POST['nama'];
			$simpan['keterangan']=$_POST['keterangan'];
			$this->db->insert('ak_jurusan',$simpan);
			
			if(empty($datajur)){
				$this->db->update('ak_step_registrasi',array('set_tahun_ajaran'=>1,'set_semester'=>1,'set_jurusan'=>1,'set_kelas'=>1));
			}
		//$data['jurusan'] 	= $datajur;
		}
		$data['main'] 	= 'schooladmin/jurusan/addData';
		$data['page_title'] 	= 'Tambah Jurusan';
		$this->load->view('layout/ad_blank',$data);
	}
	function listData(){
		$data['page_title'] 	= 'Data Jurusan';
		 if(isset($_POST['simpleupdate'])){
			$dataupdate=$_POST;
			$dataupdate['id']=$_POST['id_jurusan'];
			unset($dataupdate['id_jurusan']);
			unset($dataupdate['ajax']);
			unset($dataupdate['simpleupdate']);
			$this->db->where('id', $_POST['id_jurusan']);
			$this->db->update('ak_jurusan', $dataupdate);
		 }
		$data['jurusan']=$this->ad_jurusan->getdata($this->session->userdata['user_authentication']['id_sekolah']);
		 if ($this->input->post('ajax')) {
		   $data['main'] 	= 'schooladmin/jurusan/listData'; // memilih view
		   $this->load->view('layout/ad_blank',$data); // memilih layout
		} else {
		   $data['main'] 	= 'schooladmin/jurusan/listData';// memilih view
		   $this->load->view('layout/ad_adminsekolah',$data);
		} 
	}
	
}
?>