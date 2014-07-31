<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Admin extends CI_Controller {
	 var $upload_dir='upload/images/artikel/';
     public $denied_mime_types = array('application/x-php','application/x-httpd-php', 'text/html', 'text/css', 'text/javascript'); //array of denied mime types used when check_file_type is set to denied
        public function __construct()
        {
            parent::__construct();
            $this->load->library('session');
            $this->load->library('auth');
            $this->auth->user_logged_in();
        }
	 
	 public function index() {
		  $this->load->model('ad_setting');
		  $cekcompletereg=$this->ad_setting->getDataStepRegistrasi($this->session->userdata['user_authentication']['id_sekolah']);
			
		  if($cekcompletereg[0]['set_tahun_ajaran']==0 || $cekcompletereg[0]['set_semester']==0 || $cekcompletereg[0]['set_kelas']==0 || $cekcompletereg[0]['set_jurusan']==0 || $cekcompletereg[0]['set_pelajaran']==0 || $cekcompletereg[0]['finish']==0 ){
				  //redirect('admin/schooladmin/completereg');
				 // die();
		  }

		  $data['main'] 	= 'schooladmin/datanilai';
		  $data['page_title'] 	= 'Admin Studentbook';
		  $this->load->view('layout/ad_adminsekolah',$data);
	 }
	 public function flow($position=0,$id_kat=0,$id_artikel=0) {
			$this->load->model('ad_artikel');	
			$data['kategori'] 	= $this->ad_artikel->getkatById($id_kat);
			
		  $data['position'] = $position;
		  $data['id_kat'] 	= $id_kat;
		  $data['id_artikel'] 	= $id_artikel;
		  $data['main'] 	= 'adminsb/admin/flow';
		  $data['page_title'] 	= 'Admin Studentbook';
		  $this->load->view('layout/ad_blank',$data);		
	 }
	 public function homecontrol() {
		  $this->load->model('ad_artikel');
		  $data['artikelkat']=$this->ad_artikel->getkathome();
		 // $data['artikeldata']=$this->ad_artikel->getdatahome();
		  $data['main'] 	= 'adminsb/admin/homecontrol';
		  $data['page_title'] 	= 'Admin Studentbook';
		  $this->load->view('layout/ad_adminsekolah',$data);
	 }
	 
	 public function getselectartikelbykat() {
		$this->load->model('ad_artikel');	
		if(isset($_POST['id_kategori'])){
			$this->ad_artikel->getselectartikelbykat($_POST['id_kategori']);
		}
	 }
	 public function addslideother($position=0,$id_kat=0,$id_artikel=0) {
		$this->load->model('ad_artikel');	
		$data['kategori'] 	= $this->ad_artikel->getkat();
			if(isset($_POST['simpan'])){
				$this->db->query('DELETE FROM ak_slide_poshome WHERE id_kat_artikel='.$id_kat.' AND position='.$position.'  AND id_artikel='.$_POST['id_artikel'].' ');
				$this->db->insert('ak_slide_poshome',array('id_kat_artikel'=>$_POST['id_kategori'],'id_artikel'=>$_POST['id_artikel'],'position'=>$_POST['position']));
				redirect('adminsb/admin/homecontrol');
			}
		$data['id_kat'] 	= $id_kat;
		$data['position'] 	= $position;
		$data['main'] 	= 'adminsb/admin/addslideother';
		$data['page_title'] 	= 'Tambah data dari daftar artikel';
		$this->load->view('layout/ad_blank',$data);
	 }
	 public function addslide($position=0,$id_kat=0,$id_artikel=0) {
		$this->load->model('ad_artikel');

		if(isset($_POST['content'])){
			//pr($_FILES);
			if(isset($_FILES)){
				if(!empty($_FILES)){
						if ($error == UPLOAD_ERR_OK) {
							if($_FILES["images"]["name"]!=''){
							$name = date('Ymdhis').str_replace(" ","",$_FILES["images"]["name"]);
							}else{
							$name = $_POST['foto'];
							}
							if(!in_array($_FILES["images"]["type"], $this->denied_mime_types)){
								
									$datainsert=array(
											'id_kategori'=>$_POST['id_kategori'],
											'id_user'=>$this->session->userdata['user_authentication']['id'],
											'tagline'=>$_POST['tagline'],
											'judul'=>$_POST['judul'],
											'sub_desc'=>$_POST['sub_desc'],
											'foto'=>$name,
											'content'=>$_POST['content'],
											'status'=>$_POST['status']
									);
									if(isset($_POST['id_artikel']) && $_POST['id_artikel']!=''){
										//update area
										$this->db->where('id_artikel',$_POST['id_artikel']);
										if($this->db->update('ak_artikel',$datainsert)){
											if(file_exists($this->upload_dir.$_POST['foto'])){
												if($_FILES["images"]["name"]!=''){
													unlink($this->upload_dir.$_POST['foto']);
												}
												
											}
											move_uploaded_file( $_FILES["images"]["tmp_name"], $this->upload_dir . $name);
											redirect('adminsb/admin/homecontrol');
										}
									}else{
										//insert area
										if($this->db->insert('ak_artikel',$datainsert)){
											//$this->db->query('DELETE FROM ak_slide_poshome WHERE id_kat_artikel='.$_POST['id_kategori'].' AND position='.$_POST['position'].'  AND id_artikel='.$_POST['id_artikel'].' ');
											$this->db->insert('ak_slide_poshome',array('id_kat_artikel'=>$_POST['id_kategori'],'id_artikel'=>mysql_insert_id(),'position'=>$_POST['position']));
											move_uploaded_file( $_FILES["images"]["tmp_name"], $this->upload_dir . $name);
											redirect('adminsb/admin/homecontrol');
										}									
									}
								
							}else{
								echo "
								<script>
									alert('Anda tidak diperbolehkan mengunggah file type ini. Silahkan edit data anda dan masukkan file yang benar.');
									window.location='".base_url()."adminsb/admin/homecontrol';
								</script>
								";
								die();
							}

						}
				
				}
			}
			
		}
		
			if($id_artikel!=0){
				$data['data']=$this->ad_artikel->getdataByid($id_artikel);
			}
		  $data['kategori'] 	= $this->ad_artikel->getkat();
		  $data['id_artikel'] 	= $id_artikel;
		  $data['id_kat'] 	= $id_kat;
		  $data['position'] 	= $position;
		  $data['action'] 	= 'addslide';
		  $data['main'] 	= 'adminsb/admin/addslide';
		  $data['page_title'] 	= 'Tambah data artikel';
		  $this->load->view('layout/ad_blank',$data);
	 }
	 
}
?>
