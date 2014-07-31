<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sekolah extends CI_Controller {
    function __construct()
    {
		parent::__construct();
		$this->load->library('auth');
		$this->auth->logged_in();
    }
   
    function uploadimage($column='',$currentimg=''){
	
		foreach ($_FILES["images"]["error"] as $key => $error) {
			if ($error == UPLOAD_ERR_OK) {
				$name = $_FILES["images"]["name"][$key];
				$filename=date('YmdHis').$_FILES['images']['name'][$key];
				$cond = array('id'=>$this->session->userdata['user_authentication']['id_sekolah']);
				$insert=array(
							$column=>$filename,
				);
				$this->db->where($cond);
				$this->db->update('ak_sekolah',$insert);
				if(file_exists("upload/akademik/sekolah/".base64_decode($currentimg))){
					unlink("upload/akademik/sekolah/".base64_decode($currentimg));
				}
				//echo $this->db->last_query();
				move_uploaded_file( $_FILES["images"]["tmp_name"][$key], "upload/akademik/sekolah/".$filename);
			}
		}
		echo base64_encode($filename);
		//echo "<h2>Successfully Uploaded Images</h2>";	
	}
    function setkepsek(){
		if(isset($_POST['id_user'])){
			$this->db->where(array('id'=>$_POST['id_det_group']));
			$this->db->update('det_group',array('id_user'=>$_POST['id_user']));
			//echo $this->db->last_query();
		}
		
	}
    function cekusername($username=''){
		if(isset($_POST['username'])){
			$username=$_POST['username'];
		}
		$this->load->model('user');
		$status=$this->user->cekusername($username);
		//if($status>0){
		//	echo "Email sudah terdaftar";
		//}
		echo $status;
	}
    function editprofil(){
		
		$this->load->model('ad_sekolah');
		$this->load->model('ad_akun');
		$this->load->model('sekolahmodel');
		if(isset($_POST['submit'])){
			$insert=$_POST;
			unset($insert['submit']);
			unset($insert['id_jenjang']);
			unset($insert['ajax']);
			$arrayaksetting=$this->session->userdata['ak_setting'];
			$arrayaksetting['nama_sekolah']=$_POST['nama_sekolah'];
			$this->session->set_userdata('ak_setting', $arrayaksetting);
			$cond = array('id'=>$this->session->userdata['user_authentication']['id_sekolah']);
			//pr($_POST);
			//pr($cond);
			$this->db->where($cond);
			$this->db->update('ak_sekolah',$insert);
			//echo $this->db->last_query();
		}
		$sekolah=$this->ad_sekolah->getSekolahdata($this->session->userdata['user_authentication']['id_sekolah']);
		//kepsek
		$kepsek=$this->ad_sekolah->getKepsek($this->session->userdata['user_authentication']['id_sekolah']);
		$pegawai=$this->ad_akun->getdata($limit=null,$listtype=13,$aktif=1);
		//pr($kepsek);
		$data['provinsi']   = $this->sekolahmodel->get_provinsi();
		$data['kepsek']=$kepsek;
		$data['pegawai']=$pegawai;
		$data['sekolah']=$sekolah;
		if ($this->input->post('ajax')) {
		   $data['main'] 	= 'schooladmin/sekolah/editprofil'; // memilih view
		   $this->load->view('layout/ad_blank',$data); // memilih layout
		} else {
		   $data['main'] 	= 'schooladmin/sekolah/editprofil';// memilih view
		   $this->load->view('layout/ad_adminsekolah',$data);
		}
	}

}
?>