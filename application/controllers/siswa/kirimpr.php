<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Kirimpr extends CI_Controller
    {
		var $upload_dir='upload/akademik/pr/kumpul';
		public $denied_mime_types = array('application/x-php','application/x-httpd-php', 'text/html', 'text/css', 'text/javascript'); //array of denied mime types used when check_file_type is set to denied
        public function __construct()
        {
            parent::__construct();
            $this->load->helper('global');
            $this->load->library('session');
            $this->load->library('auth');
            $this->auth->user_logged_in();
        }
        
        public function send_download($filename=null)
        {
			$filename=base64_decode($filename);
			$this->load->library('ak_file');
			$this->ak_file->send_download('upload/akademik/pr/',$filename);	
		}

		public function kumpulkanfilepr($id_pr)
        {
			if(isset($_FILES)){
			if(!empty($_FILES)){
				foreach ($_FILES["file"]["error"] as $key => $error) {
					if ($error == UPLOAD_ERR_OK) {
						$name = date('Ymdhis').str_replace(" ","",$_FILES["file"]["name"][$key]);
						if(!in_array($_FILES["file"]["type"][$key], $this->denied_mime_types)){
							if(move_uploaded_file($_FILES["file"]["tmp_name"][$key], $this->upload_dir . $name)){
								$this->db->insert('ak_pr_file', array('id_pr'=>$id_pr,'file_name'=>''.$name.''));
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
        public function daftarprlist()
        {
			$this->load->model('ad_pr');
			$pr=$this->ad_pr->getPrByKelasPelajaranId($_POST['pelajaran'],$_POST['id_kelas']);
			//pr($pr);
			foreach($pr as $ky=>$datapr){
				$pr[$ky]['file']=$this->ad_pr->getFilePrByIdPr($datapr['id']);
				//$pr[$ky]['dikirim']=$this->ad_pr->getDetPrByKelasPelajaran($_POST['pelajaran'],$_POST['id_kelas']);
			}
			
			$data['pr']=$pr;
			$data['main']= 'siswa/kirimpr/daftarprlist';
            $this->load->view('layout/ad_blank',$data);	
		}
        public function daftarpr()
        {	
			$this->load->model('ad_siswa');
			$siswa=$this->ad_siswa->getSiswaTaSekarang();
			$data['siswa']=$siswa;
			$data['pr']=array();
			$data['main']= 'siswa/kirimpr/daftarpr';
            $this->load->view('layout/ad_blank',$data);		
		}      
    }
?>