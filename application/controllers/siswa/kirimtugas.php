<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Kirimtugas extends CI_Controller
    {
		var $upload_dir='upload/akademik/tugas/';
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
			$this->ak_file->send_download('upload/akademik/tugas/',$filename);	
		}
        public function daftartugaslist()
        {
			$this->load->model('ad_tugas');
			$tugas=$this->ad_tugas->gettugasByKelasPelajaranId($_POST['pelajaran'],$_POST['id_kelas']);
			foreach($tugas as $ky=>$datatugas){
				$tugas[$ky]['file']=$this->ad_tugas->getFiletugasByIdtugas($datatugas['id']);
				//$tugas[$ky]['dikirim']=$this->ad_tugas->getDettugasByKelasPelajaran($_POST['pelajaran'],$_POST['id_kelas']);
			}
			//tugas($tugas);
			$data['tugas']=$tugas;
			$data['main']= 'siswa/kirimtugas/daftartugaslist';
            $this->load->view('layout/ad_blank',$data);	
		}
        public function daftartugas()
        {		
			$this->load->model('ad_siswa');
			$siswa=$this->ad_siswa->getSiswaTaSekarang();
			$data['siswa']=$siswa;
			$data['tugas']=array();
			$data['main']= 'siswa/kirimtugas/daftartugas';
            $this->load->view('layout/ad_blank',$data);		
		} 
		      
    }
?>