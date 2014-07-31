<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Artikel extends CI_Controller {
	 var $upload_dir='upload/images/artikel/';
     public $denied_mime_types = array('application/x-php','application/x-httpd-php', 'text/html', 'text/css', 'text/javascript'); //array of denied mime types used when check_file_type is set to denied
	 function __construct()
	 {
		  parent::__construct();
		  $this->load->library('auth');
		  $this->auth->logged_in();
	 }
	 
	 public function index() {
		  $data['main'] 	= 'adminsb/artikel/index';
		  $data['page_title'] 	= 'Admin Studentbook';
		  $this->load->view('layout/ad_adminsekolah',$data);
	 }
	 public function artikellist($start=0,$page=0) {
		$this->load->model('ad_artikel');
			if(isset($_POST['id_kategori'])){
			  //data
				$this->load->model('ad_artikel');
				$this->load->library('pagination');
				
				$config['base_url']   = site_url('adminsb/artikel/artikellist');
				$config['per_page']   = 10;

				$config['cur_page']   = $start;
				$config['total_rows'] = $this->ad_artikel->getCountArtikel($_POST['id_kategori']);
				$data['start'] = $start;
				$data['config'] = $config;
				
				$data['artikeldata']=array();
				$data['artikeldata']=$this->ad_artikel->getdataByIdKatPaging($_POST['id_kategori'],''.$start.','.$config['per_page'].'');
				$this->pagination->initialize($config);
				$data['pagination'] = $this->pagination->create_links();
				//pr($config);
			}	
			$data['start'] 	= $start;
			$data['kategori'] 	= $this->ad_artikel->getkat();
			$data['main'] 	= 'adminsb/artikel/artikellist';
			$data['page_title'] 	= 'Admin Studentbook';
			$this->load->view('layout/ad_blank',$data);
	}
	 
	 public function addartikel() {
		$this->load->model('ad_artikel');
		if(isset($_POST['content'])){
			//pr($_FILES);
			
					if ($_FILES["images"]["name"]!='') {
						$name = date('Ymdhis').str_replace(" ","",$_FILES["images"]["name"]);
						if(!in_array($_FILES["images"]["type"], $this->denied_mime_types)){
							if(move_uploaded_file( $_FILES["images"]["tmp_name"], $this->upload_dir . $name)){
								$datainsert=array(
										'id_kategori'=>$_POST['id_kategori'],
										'id_user'=>$this->session->userdata['user_authentication']['id'],
										'tagline'=>$_POST['tagline'],
										'judul'=>$_POST['judul'],
										'sub_desc'=>$_POST['sub_desc'],
										'foto'=>$name,
										'content'=>$_POST['content'],
										'tanggal'=>date("Y-m-d"),
										'status'=>$_POST['status']
								);
								if($this->db->insert('ak_artikel',$datainsert)){
									redirect('adminsb/artikel/index');
								}
							}
						}else{
							echo "
							<script>
								alert('Anda tidak diperbolehkan mengunggah file type ini. Silahkan edit data anda dan masukkan file yang benar.');
								window.location='".base_url()."adminsb/artikel/index';
							</script>
							";
							die();
						}

					}else{
								$datainsert=array(
										'id_kategori'=>$_POST['id_kategori'],
										'id_user'=>$this->session->userdata['user_authentication']['id'],
										'tagline'=>$_POST['tagline'],
										'judul'=>$_POST['judul'],
										'sub_desc'=>$_POST['sub_desc'],
										'foto'=>'',
										'content'=>$_POST['content'],
										'tanggal'=>date("Y-m-d"),
										'status'=>$_POST['status']
								);
								if($this->db->insert('ak_artikel',$datainsert)){
									redirect('adminsb/artikel/index');
								}
					}
			
			
			
			
		}
		
		$data['kategori'] 	= $this->ad_artikel->getkat();
		$data['main'] 	= 'adminsb/artikel/addartikel';
	    $data['page_title'] 	= 'Tambah Data';
		$this->load->view('layout/ad_blank',$data);
	 }
	 
	 public function updateslide($cek=0) {
		$this->db->where('id_kategori',$_POST['id_kategori']);
		if($this->db->update('ak_kategori_artikel',array('is_slide_home'=>$_POST['cek']))){
		
		}
	 }
	 public function deletekat() {
		if($this->db->query('DELETE FROM ak_kategori_artikel WHERE id_kategori='.$_POST['id_kategori'].'')){
				$this->db->query('DELETE FROM ak_artikel WHERE id_kategori='.$_POST['id_kategori'].'');
				echo 1;
				//redirect('adminsb/artikel/listartikelkat');
			}else{
				echo 0;
			}
	 }
	 public function listartikelkat($start=0,$page=0) {
		$this->load->model('ad_artikel');

			
			  //data
				$this->load->model('ad_artikel');
				$this->load->library('pagination');
				
				$config['base_url']   = site_url('adminsb/artikel/listartikelkat');
				$config['per_page']   = 10;

				$config['cur_page']   = $start;
				$config['total_rows'] = $this->ad_artikel->getCountArtikelKat($_POST['id_kategori']);
				$data['start'] = $start;
				$data['config'] = $config;
				
				$data['artikelkatdata']=array();
				$data['artikelkatdata']=$this->ad_artikel->getkatPaging(''.$start.','.$config['per_page'].'');
				$this->pagination->initialize($config);
				$data['pagination'] = $this->pagination->create_links();
				
			$data['start'] 	= $start;
			
		$data['main'] 	= 'adminsb/artikel/listartikelkat';
	    $data['page_title'] 	= 'Kategori Artikel';
		$this->load->view('layout/ad_blank',$data);
	 }
	 public function editartikelkat() {
		$dataupdate=array(
					'nama_kategori'=>$_POST['nama']
		);
		$this->db->where('id_kategori',$_POST['id_kategori']);
		if($this->db->update('ak_kategori_artikel',$dataupdate)){
		
		}
	 }
	 public function addartikelkat() {
		$this->load->model('ad_artikel');
		if(isset($_POST['nama_kategori'])){ 	
			$datainsert=array(
				'nama_kategori'=>$_POST['nama_kategori'],
				'is_slide_home'=>$_POST['is_slide_home']
			);
			if($this->db->insert('ak_kategori_artikel',$datainsert)){
				echo 1;
				//redirect('adminsb/artikel/listartikelkat');
			}else{
				echo 0;
			}
		}
		
		$data['main'] 	= 'adminsb/artikel/addartikelkat';
	    $data['page_title'] 	= 'Tambah Kategori Artikel';
		$this->load->view('layout/ad_blank',$data);
	 }
	 public function delete($id=0) {
		//if(isset($_POST['id_artikel'])){$id=$_POST['id_artikel'];}
		$this->load->model('ad_artikel');
		$data=$this->ad_artikel->getdataByid($id);
		if($this->db->query('DELETE FROM ak_artikel WHERE id_artikel='.$id.'')){
			if(file_exists($this->upload_dir . $data[0]['foto'])){
				unlink($this->upload_dir . $data[0]['foto']);
			}
			echo 1;
		}else{
			echo 0;
		}
	 }
	 public function edit($id=0) {
		if(isset($_POST['id_artikel'])){$id=$_POST['id_artikel'];}
		$this->load->model('ad_artikel');
		$data['data']=$this->ad_artikel->getdataByid($id);
		if(isset($_POST['content'])){
			//pr($_FILES);
			
			
				if(isset($_FILES)){
				if(!empty($_FILES) && $_FILES["images"]["name"]!=''){
						if ($error == UPLOAD_ERR_OK) {
							$name = date('Ymdhis').str_replace(" ","",$_FILES["images"]["name"]);
							if(!in_array($_FILES["images"]["type"], $this->denied_mime_types)){
								if(move_uploaded_file( $_FILES["images"]["tmp_name"], $this->upload_dir . $name)){
									if(file_exists($this->upload_dir . $data['data'][0]['foto'])){
										unlink($this->upload_dir . $data['data'][0]['foto']);
									}
								}
							}else{
								echo "
								<script>
									alert('Anda tidak diperbolehkan mengunggah file type ini. Silahkan edit data anda dan masukkan file yang benar.');
									window.location='".base_url()."adminsb/artikel/index';
								</script>
								";
								die();
							}

						}
				
				}
				}
				$datainsert=array(
					'id_kategori'=>$_POST['id_kategori'],
					'tagline'=>$_POST['tagline'],
					'judul'=>$_POST['judul'],
					'sub_desc'=>$_POST['sub_desc'],
					'foto'=>$name,
					'content'=>$_POST['content'],
					'status'=>$_POST['status']
				);
				if($name==''){unset($datainsert['foto']);}
				$this->db->where('id_artikel',$id);
				if($this->db->update('ak_artikel',$datainsert)){
					redirect('adminsb/artikel/index');
				}
				
			
		}
		
		$data['kategori'] 	= $this->ad_artikel->getkat();
		$data['main'] 	= 'adminsb/artikel/addartikel';
	    $data['page_title'] 	= 'Edit Data';
		$this->load->view('layout/ad_blank',$data);
	 }
	 
}
?>