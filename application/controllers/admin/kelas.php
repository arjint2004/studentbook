<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Kelas extends CI_Controller {
	 function __construct()
	 {
		  parent::__construct();
		  $this->load->library('auth');
		  $this->auth->logged_in();
		  $this->load->model('ad_kelas');
		  $this->datajenjang=$this->ad_kelas->thisjenjang($this->session->userdata['user_authentication']['id']);
	 }
	function index(){
		 $datajenjang=$this->datajenjang;
		 $data['jenjang'] 	=  $datajenjang[0]['nama'];
		 $data['grade'] 	=  unserialize($datajenjang[0]['grade']);
		 $data['page_title'] 	= 'Data Kelas';
		 
		if ($this->input->post('ajax')) {
		   $data['main'] 	= 'schooladmin/kelas/index'; // memilih view
		   $this->load->view('layout/ad_blank',$data); // memilih layout
		} else {
		   $data['main'] 	= 'schooladmin/kelas/index';// memilih view
		   $this->load->view('layout/ad_adminsekolah',$data);
		} 
	 }
	function listData(){
		 $this->load->model('ad_kelas');
		 $datajenjang=$this->datajenjang;
		 //pr($this->session->userdata['user_authentication']);
		 if(isset($_POST['simpleupdate'])){
			$this->db->query('UPDATE ak_kelas SET nama="'.$_POST['kelas'].'" WHERE id='.$_POST['id_kelas'].'');
		 }
		 $grade 	=  unserialize($datajenjang[0]['grade']);
		 
		 foreach($grade as $keygrade=>$gradevalue){
			$gradeout[$keygrade]['grade']=$gradevalue;
			$query=$this->db->query('SELECT * FROM ak_kelas WHERE id_jenjang='.$this->datajenjang[0]['id'].' AND kelas='.$gradevalue.' AND id_sekolah='.$this->session->userdata['user_authentication']['id_sekolah'].'');
			$gradeout[$keygrade]['kelas']=$query->result_array();;
		 }
		 //pr($gradeout);
		 $data['gradeout'] 	=  $gradeout;
		 $data['jenjang'] 	=  $datajenjang[0]['nama'];
		 $data['datajenjang'] 	=  $datajenjang;
		 $data['page_title'] 	= 'Data Kelas';
		// pr($this->input->post());die();
		 if ($this->input->post('ajax')) {
		   $data['main'] 	= 'schooladmin/kelas/listData'; // memilih view
		   $this->load->view('layout/ad_blank',$data); // memilih layout
		} else {
		   $data['main'] 	= 'schooladmin/kelas/listData';// memilih view
		   $this->load->view('layout/ad_adminsekolah',$data);
		}
	 }
	 function editdata($id_kelas=null,$id_jurusan=null,$namakelas=null)
	 {
		if($_POST['value']!=''){
			$namakelas=$_POST['value'];
		}
		if(isset($_POST['editkelas'])){
			$datamapel=array(
						'id_jurusan'=>$_POST['id_jurusan'],
						'publish'=>$_POST['publish'],
						'nama'=>$_POST['kelas']
			);
			
			$this->db->where('id', $_POST['id_kelas']);
			$this->db->update('ak_kelas',$datamapel);
		}
		$this->load->model('ad_jurusan');
		$this->load->model('ad_kelas');
		$datakelas=$this->ad_kelas->getkelasById($this->session->userdata['user_authentication']['id_sekolah'],$id_kelas);
		$data['jurusan']=$this->ad_jurusan->getdata($this->session->userdata['user_authentication']['id_sekolah']);
		$data['id_kelas'] 	= $id_kelas;
		$data['id_jurusan'] 	= $id_jurusan;
		$data['kelas'] 	= $namakelas;
		$data['datakelas'] 	= $datakelas;
		$data['main'] 	= 'schooladmin/kelas/editData'; // memilih view
		$this->load->view('layout/ad_blank',$data); // memilih layout
	 }
	 function adddata()
	 {
		if(isset($_POST['addkelas'])){
			$datakelas=$this->ad_kelas->getkelas($this->session->userdata['user_authentication']['id_sekolah']);
			foreach($_POST['nama'] as $kelas=>$namakelas){
				foreach($namakelas as $namesave){
					if($this->session->userdata['ak_setting']['jenjang'][0]['nama']=='SMA'){
						$datasave=array(
									'id_jurusan'=>$_POST['id_jurusan'][$kelas],
									'id_sekolah' => $this->session->userdata['user_authentication']['id_sekolah'],
									'id_jenjang'=>$this->datajenjang[0]['id'],
									'kelas'=>$kelas,
									'nama'=>$namesave
						);
					}else{
						$datasave=array(
									'id_jurusan'=>$_POST['id_jurusan'],
									'id_sekolah' => $this->session->userdata['user_authentication']['id_sekolah'],
									'id_jenjang'=>$this->datajenjang[0]['id'],
									'kelas'=>$kelas,
									'nama'=>$namesave
						);
					}
					//pr($datasave);
					if($namesave!=''){
						$this->db->insert('ak_kelas',$datasave);
					}
				}
			}
			if(empty($datakelas)){
				$this->db->where('id_sekolah',$this->session->userdata['user_authentication']['id_sekolah']);
				$this->db->update('ak_step_registrasi',array('set_tahun_ajaran'=>1,'set_semester'=>1,'set_jurusan'=>1,'set_kelas'=>1,'set_pelajaran'=>1));
			}
		}
		$datajenjang=$this->datajenjang;
		$datajenjang[0]['grade'] 	=  unserialize($datajenjang[0]['grade']);
		$data['datajenjang'] 	=  $datajenjang;
		//$data['havejurusan'] 	=  array('SMA','SMK');
		
		//if(in_array($datajenjang[0]['nama'],$data['havejurusan'])){
			$this->load->model('ad_jurusan');
			$data['jurusan']=$this->ad_jurusan->getdata($this->session->userdata['user_authentication']['id_sekolah']);
			//pr($data['jurusan']);
		//}
		$data['main'] 	= 'schooladmin/kelas/addData'; // memilih view
		$this->load->view('layout/ad_blank',$data); // memilih layout
	 }
	 function edit()
	 {
	 
	 }
	 function delete($id_kelas=null)
	 {
		$freekelas=$this->ad_kelas->getFreeKelas($id_kelas,$this->session->userdata['user_authentication']['id_sekolah']);
		if($freekelas==0){
			$this->db->query('DELETE FROM ak_kelas WHERE id='.$id_kelas.'');
			echo $freekelas;
		}else{
			$this->db->query('UPDATE ak_kelas SET publish=0 WHERE id='.$id_kelas.'');
			echo 0;
		}
		
		//return $freekelas;
	 }
	 
	 
	 function setwali()
	 {
		$data=json_decode($_POST['id_pegawai']);
		$this->db->where('id',$data->id_kelas);
		$this->db->update('ak_kelas',array('id_pegawai'=>$data->id_pegawai));
		//echo $this->db->last_query();
	 }
	 function walikelas()
	 {
		$data['kelas']=$this->ad_kelas->getkelas($this->session->userdata['user_authentication']['id_sekolah']);
		$data['wali']=$this->ad_kelas->getWaliKelas($this->session->userdata['user_authentication']['id_sekolah']);
		
		$data['main'] 	= 'schooladmin/kelas/walikelas'; // memilih view
		$this->load->view('layout/ad_adminsekolah',$data); // memilih layout
	 }
}
?>