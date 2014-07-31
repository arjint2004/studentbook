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
		
		$this->load->model('ad_jurusan');
		$this->load->model('ad_kelas');
		$this->load->model('ad_setting');
		$data['semester'] 	=  $this->ad_setting->getSemester($this->session->userdata['user_authentication']['id_sekolah']);
		
		$datajenjang=$this->ad_kelas->thisjenjang($this->session->userdata['user_authentication']['id']);
		$jur=$this->ad_jurusan->getdata($this->session->userdata['user_authentication']['id_sekolah']);
		
		$data['grade'] 	=  unserialize($datajenjang[0]['grade']);
		$data['jurusan'] 	= $jur;
		$data['main'] 	= 'schooladmin/nilaikkm/index';
		$data['page_title'] 	= 'Data Pelajaran';
		$this->load->view('layout/ad_adminsekolah',$data);	 
	}

	function listData(){
	
		$this->load->model('ad_pelajaran');
		$kkm2=array();			
			$this->load->model('ad_nilaikkm');
			$kkm=$this->ad_nilaikkm->getAllKkm();
			
			foreach($kkm as $datakkm){
				$kkm2[$datakkm['id_pelajaran']]=$datakkm;
			}
			unset($kkm);
		if(isset($_POST['addkkm'])){

			//pr($kkm2);
			
			foreach($_POST['nilaikkm'] as $id_pelajaran=>$nilai){
				$datainsertkkm=array(
						'id_sekolah'=>$this->session->userdata['user_authentication']['id_sekolah'],		
						'id_pelajaran'=>$id_pelajaran,		
						'semester'=>$this->session->userdata['ak_setting']['semester'],		
						'ta'=>$this->session->userdata['ak_setting']['ta'],		
						'nilai'=>$nilai
				);
				if(!isset($kkm2[$id_pelajaran])){
				//insert
				$this->db->insert('ak_nilai_kkm',$datainsertkkm);
				}else{
				//update
				$this->db->where('id',$_POST['idkkm'][$id_pelajaran]);
				$this->db->update('ak_nilai_kkm',$datainsertkkm);
				}
				//echo $this->db->last_query()."<br />"; 
			}
			$kkm=$this->ad_nilaikkm->getAllKkm();
			
			foreach($kkm as $datakkm){
				$kkm2[$datakkm['id_pelajaran']]=$datakkm;
			}
			unset($kkm);
		}
		
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
		
		
		$data['pelajaran'] 	=  $this->ad_pelajaran->getdata($param);
		$data['kkm'] 	=  $kkm2;
		
		$data['page_title'] 	= 'Data Pelajaran';
		 if ($this->input->post('ajax')) {
		   $data['main'] 	= 'schooladmin/nilaikkm/listData'; // memilih view
		   $this->load->view('layout/ad_blank',$data); // memilih layout
		} else {
		   $data['main'] 	= 'schooladmin/nilaikkm/listData';// memilih view
		   $this->load->view('layout/ad_adminsekolah',$data);
		} 
	}
	
}
?>