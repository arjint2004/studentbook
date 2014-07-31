<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Super extends CI_Controller {
	 function __construct()
	 {
		  parent::__construct();
		  $this->load->library('auth');
		  $this->auth->logged_in();
	 }
	 
	 public function index() {
		  $this->load->model('ad_setting');
		  $cekcompletereg=$this->ad_setting->getDataStepRegistrasi($this->session->userdata['user_authentication']['id_sekolah']);
			
		  if($cekcompletereg[0]['set_tahun_ajaran']==0 || $cekcompletereg[0]['set_semester']==0 || $cekcompletereg[0]['set_kelas']==0 || $cekcompletereg[0]['set_jurusan']==0 || $cekcompletereg[0]['set_pelajaran']==0 || $cekcompletereg[0]['finish']==0 ){
				  //redirect('admin/schooladmin/completereg');
				 // die();
		  }
		  
		  
		  $data['main'] 	= 'schooladmin/datanilai';
		  $data['page_title'] 	= 'Super Admin';
		  $this->load->view('layout/ad_adminsekolah',$data);
	 }
	 public function accountindex() {
		  $data['main'] 	= 'superadmin/super/accountindex';
		  $data['page_title'] 	= 'Super Admin';
		  $this->load->view('layout/ad_adminsekolah',$data);
	 }
	 public function addadmin() {
		  $data['main'] 	= 'superadmin/super/addacount';
		  $data['page_title'] 	= 'Super Admin';
		  $this->load->view('layout/ad_adminsekolah',$data);
	 }
	 public function addaccount() {
		  if(isset($_POST['username'])){
				$admininsert=array(
									'id_group'=>$_POST['id_group'],
									'username'=>$_POST['username'],
									'password'=>md5($_POST['password']),
									'aktif'=>0,
				);
				
				if($this->db->insert('users',$admininsert)){
					$this->auth->send_mail_verifikasi($_POST['email'],$_POST['username'],$_POST['password'],$_POST['nama_pendaftar']);
					echo $this->db->last_query();
				}
		  }
		  $data['group']=array(30=>'Admin');
		  $data['main'] 	= 'superadmin/super/addaccount';
		  $data['page_title'] 	= 'Super Admin';
		  $this->load->view('layout/ad_blank',$data);
	 }
	 public function accountlist() {
		  $this->load->model('ad_akun');		  
		  if(isset($_POST['id_group'])){
				$data['users']=$this->ad_akun->getUsersByIdGroup($_POST['id_group']);
		  }
		  
		  $data['group']=array(11=>'Admin Sekolah',30=>'Admin');
		  $data['main'] 	= 'superadmin/super/accountlist';
		  $data['page_title'] 	= 'Super Admin';
		  $this->load->view('layout/ad_blank',$data);
	 }
}
?>
