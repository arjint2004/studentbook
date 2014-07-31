<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Nilaikkm extends CI_Controller {
	 function __construct()
	 {
		parent::__construct();
		$this->load->library('auth');
		$this->auth->logged_in();
		$this->load->model('ad_pelajaran');
	 }
	function index(){
		$data['main'] 	= 'schooladmin/pelajaran/index';
		$data['page_title'] 	= 'Data Pelajaran';
		$this->load->view('layout/ad_adminsekolah',$data);	 
	}
	function editdata($id=0){
		$this->load->model('ad_jurusan');
		$this->load->model('ad_kelas');
		$this->load->model('ad_pelajaran');
		if(isset($_POST['addpelajaran'])){
			$datamapel=array(
						'id_sekolah'=>$this->session->userdata['user_authentication']['id_sekolah'],
						'id_jurusan'=>$_POST['id_jurusan'],
						'nama'=>$_POST['nama'],
						'kelompok'=>$_POST['kelompok'],
						'semester'=>$_POST['semester'],
						'kelas'=>$_POST['jenjang']
			);
			
			$this->db->where('id', $_POST['id']);
			$this->db->update('ak_pelajaran',$datamapel);
			//die();
		}
		$datajenjang=$this->ad_kelas->thisjenjang($this->session->userdata['user_authentication']['id']);
		$jur=$this->ad_jurusan->getdata($this->session->userdata['user_authentication']['id_sekolah']);
		
		$data['pelajaran'] 	=  $this->ad_pelajaran->getdataById($id);
		$data['grade'] 	=  unserialize($datajenjang[0]['grade']);
		$data['jurusan'] 	= $jur;
		$data['main'] 	= 'schooladmin/pelajaran/editData';
		$data['page_title'] 	= 'Tambah Pelajaran';
		$this->load->view('layout/ad_blank',$data);
	}
	function adddata(){
		$this->load->model('ad_jurusan');
		$this->load->model('ad_kelas');
		if(isset($_POST['addpelajaran'])){
			$datamapel=array(
						'id_sekolah'=>$this->session->userdata['user_authentication']['id_sekolah'],
						'id_jurusan'=>$_POST['id_jurusan'],
						'nama'=>$_POST['nama'],
						'kelompok'=>$_POST['kelompok'],
						'semester'=>$_POST['semester'],
						'kelas'=>$_POST['jenjang']
			);
			$this->db->insert('ak_pelajaran',$datamapel);
			//die();
		}
		$datajenjang=$this->ad_kelas->thisjenjang($this->session->userdata['user_authentication']['id']);
		$jur=$this->ad_jurusan->getdata($this->session->userdata['user_authentication']['id_sekolah']);
		
		$data['grade'] 	=  unserialize($datajenjang[0]['grade']);
		$data['jurusan'] 	= $jur;
		$data['main'] 	= 'schooladmin/pelajaran/addData';
		$data['page_title'] 	= 'Tambah Pelajaran';
		$this->load->view('layout/ad_blank',$data);
	}
	
	function listData(){
	
		$this->load->model('ad_jurusan');
		$this->load->model('ad_kelas');
		$this->load->model('ad_pelajaran');
		
		
		//get data pelajaran
		$param['id_sekolah']=$this->session->userdata['user_authentication']['id_sekolah'];
		
		if(@$_POST['jenjang']!='' ){
			$param['jenjang']=$_POST['jenjang'];
		}
		if(@$_POST['jenjang']!='' && @$_POST['id_jurusan']!=''){
			$param['id_jurusan']=$_POST['id_jurusan'];
		}
		if(@$_POST['jenjang']!='' && @$_POST['id_jurusan']!='' && @$_POST['semester']!='' ){
			$param['semester']=$_POST['semester'];
		}
		
		$datajenjang=$this->ad_kelas->thisjenjang($this->session->userdata['user_authentication']['id']);
		$jur=$this->ad_jurusan->getdata($this->session->userdata['user_authentication']['id_sekolah']);
		
		$data['grade'] 	=  unserialize($datajenjang[0]['grade']);
		$data['jurusan'] 	= $jur;
		
		$data['pelajaran'] 	=  $this->ad_pelajaran->getdata($param);
		
		$data['page_title'] 	= 'Data Pelajaran';
		 if ($this->input->post('ajax')) {
		   $data['main'] 	= 'schooladmin/pelajaran/listData'; // memilih view
		   $this->load->view('layout/ad_blank',$data); // memilih layout
		} else {
		   $data['main'] 	= 'schooladmin/pelajaran/listData';// memilih view
		   $this->load->view('layout/ad_adminsekolah',$data);
		} 
	}
	public function getMapelByKelasAndPegawai($id_kelas=null,$id_mapel=null)
    {
       $this->load->model('ad_pelajaran');
       $this->load->model('ad_kelas');
	   $jurusankelasnya=$this->ad_kelas->getkelasById($this->session->userdata['user_authentication']['id_sekolah'],$id_kelas);
		// pr($jurusankelasnya);die();
	   $mapel=$this->ad_pelajaran->getdatabySemesterJenjangJurusanKelasPegawaimengajar($this->session->userdata['ak_setting']['semester'],$jurusankelasnya[0]['kelas'],$jurusankelasnya[0]['id_jurusan']);
	   $select ='';
	   $select ="<option value=''>Pilih Pelajaran</option>";
	   foreach($mapel as $datamapel){
			if($id_mapel==$datamapel['id']){
				$slct="selected";
			}else{
				$slct="";
			}
			$select .="<option ".@$slct." value='".$datamapel['id']."'>".$datamapel['nama']."</option>";
	   }
	   echo $select;
	   die();
    }
	public function getMapelByKelas($id_kelas=null,$id_mapel=null)
    {
       $this->load->model('ad_pelajaran');
       $this->load->model('ad_kelas');
	   $jurusankelasnya=$this->ad_kelas->getkelasById($this->session->userdata['user_authentication']['id_sekolah'],$id_kelas);
		// pr($jurusankelasnya);die();
	   $mapel=$this->ad_pelajaran->getdatabySemesterJenjangJurusanKelas($this->session->userdata['ak_setting']['semester'],$jurusankelasnya[0]['kelas'],$jurusankelasnya[0]['id_jurusan']);
	   $select ='';
	   $select ="<option value=''>Pilih Pelajaran</option>";
	   foreach($mapel as $datamapel){
			if($id_mapel==$datamapel['id']){
				$slct="selected";
			}else{
				$slct="";
			}
			$select .="<option ".@$slct." value='".$datamapel['id']."'>".$datamapel['nama']."</option>";
	   }
	   echo $select;
	   die();
    }
}
?>