<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Administrasi extends CI_Controller
    {
		var $upload_diradministrasi='upload/akademik/rencana_administrasi/';
		var $upload_dirtimelineadministrasi='upload/akademik/timeline_administrasi/';
		public $denied_mime_types = array('application/x-php','application/x-httpd-php', 'text/html', 'text/css', 'text/javascript'); //array of denied mime types used when check_file_type is set to denied
        public function __construct()
        {
            parent::__construct();
            $this->load->helper('global');
            $this->load->library('session');
            $this->load->library('auth');
            $this->auth->user_logged_in();
        }
		
        //AREA PERENCANAAN administrasi 
        public function admin($jenis=''){
			$this->load->model('ad_kelas');
			$data['administrasi']=array();
			$data['kelas'] 	=$this->ad_kelas->getkelasByPengajar($this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['user_authentication']['id_pengguna']);
            $data['jenis']= $_POST['jenis'];
            $data['main']= 'akademik/administrasi/administrasi';
            $this->load->view('layout/ad_blank',$data);
        }
		
        public function administrasilist(){

			$this->load->model('ad_administrasi');
			$data['administrasi']=$this->ad_administrasi->getadministrasiByKelasPelajaranIdPegawai($_POST['pelajaran'],$_POST['id_kelas'],$_POST['jenis']);
            $data['main']= 'akademik/administrasi/administrasilist';
            $this->load->view('layout/ad_blank',$data);
        }
		public function deletefilepemb($id=null)
        {	
		
			$this->load->model('ad_administrasi');
			$datafile=$this->ad_administrasi->getFilePembById($id);
			//pr($datafile);
			if($this->db->query('DELETE FROM ak_administrasi_file WHERE id='.$id.'')){
				if(file_exists($this->upload_diradministrasi.$datafile[0]['file_name'])){
					unlink($this->upload_diradministrasi.$datafile[0]['file_name']);
				}
			}
		}

		public function deletepemb($id_pemb=null)
        {	
			$this->load->model('ad_administrasi');
			$datafile=$this->ad_administrasi->getFilePembById_pemb($id_pemb);
			
			//delete file
			foreach($datafile as $datainfile){
				$this->deletefilepemb($datainfile['id']);
			}
			
			//delete data
			
			if($this->db->query('DELETE FROM ak_administrasi WHERE id='.$id_pemb.'')){
				echo 1;
			}else{
				echo 0;
			}
		}
		public function uploadadministrasi($id_administrasi,$jenis='')
        {
			
			
			if(isset($_FILES)){
			if(!empty($_FILES)){
				//pr($_FILES);
				foreach ($_FILES["file"]["error"] as $key => $error) {
					if ($error == UPLOAD_ERR_OK) {
						
						$name = str_replace(" ","",$jenis).'_'.date('Ymdhis').str_replace(" ","",$_FILES["file"]["name"][$key]);
						if(!in_array($_FILES["file"]["type"][$key], $this->denied_mime_types)){
							if(move_uploaded_file( $_FILES["file"]["tmp_name"][$key], $this->upload_diradministrasi . $name)){
								$this->db->insert('ak_administrasi_file', array('id_administrasi'=>$id_administrasi,'file_name'=>''.$name.''));
							}
						}else{
							echo "Anda tidak diperbolehkan mengunggah file type ini. Silahkan edit data anda dan masukkan file yang benar.";
							die();
						}
						
					}
				}				
			}
			}

        }
        public function addadministrasi(){

			$this->load->model('ad_administrasi');
			$this->load->model('ad_kelas');
			
			if(isset($_POST['id_pelajaran'])){
				 	 	 	 	 	 	 	 	 	 	 	 	 	 
				$datainsert=array(
									'id_sekolah'=>$this->session->userdata['user_authentication']['id_sekolah'],
									'id_pelajaran'=>$_POST['id_pelajaran'],
									'id_pegawai'=>$this->session->userdata['user_authentication']['id_pengguna'],
									'id_kelas'=>$_POST['id_kelas'],
									'ta'=>$this->session->userdata['ak_setting']['ta'],
									'semester'=>$this->session->userdata['ak_setting']['semester'],
									'keterangan'=>$_POST['keterangan'],
									'share'=>"".@$_POST['share']."",
									'jenis'=>"".@$_POST['jenis']."",
				);
				
				$this->db->insert('ak_administrasi',$datainsert);
				$id_administrasi=mysql_insert_id();
				echo $id_administrasi;
				die();
			}
			
			$data['kelas'] 	=$this->ad_kelas->getkelasByPengajar($this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['user_authentication']['id_pengguna']);
            $data['main']= 'akademik/administrasi/addadministrasi';
            $this->load->view('layout/ad_blank',$data);
        }   
        public function editadministrasi($id){

			$this->load->model('ad_administrasi');
			$this->load->model('ad_kelas');
			
			if(isset($_POST['id_pelajaran'])){
				 	 	 	 	 	 	 	 	 	 	 	 	 	 
				$datainsert=array(
									'id_sekolah'=>$this->session->userdata['user_authentication']['id_sekolah'],
									'id_pelajaran'=>$_POST['id_pelajaran'],
									'id_pegawai'=>$this->session->userdata['user_authentication']['id_pengguna'],
									'id_kelas'=>$_POST['id_kelas'],
									'ta'=>$this->session->userdata['ak_setting']['ta'],
									'semester'=>$this->session->userdata['ak_setting']['semester'],
									'keterangan'=>$_POST['keterangan'],
									'share'=>"".@$_POST['share']."",
				);
				
				$this->db->where('id',$_POST['id']);
				$this->db->update('ak_administrasi',$datainsert);
				
				echo $_POST['id'];
				die();
			}
			
			$data['administrasi'] 	=$this->ad_administrasi->getadministrasiById($id);//pr($data['administrasi']);
			$data['files'] 	=$this->ad_administrasi->getFilePembById_pemb($id);
			$data['kelas'] 	=$this->ad_kelas->getkelasByPengajar($this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['user_authentication']['id_pengguna']);
            $data['main']= 'akademik/administrasi/editadministrasi';
            $this->load->view('layout/ad_blank',$data);
        }        
    }
?>