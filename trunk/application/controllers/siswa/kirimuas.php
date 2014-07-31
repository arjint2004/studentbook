<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Kirimuas extends CI_Controller
    {
		var $upload_dir='upload/akademik/uas/';
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
			$this->ak_file->send_download('upload/akademik/uas/',$filename);	
		}

        public function daftaruaslist()
        {
			$this->load->model('ad_uas');
			$uas=$this->ad_uas->getuasByKelasPelajaranId($_POST['pelajaran'],$_POST['id_kelas']);
			foreach($uas as $ky=>$datauas){
				$uas[$ky]['file']=$this->ad_uas->getFileuasByIduas($datauas['id']);
				//$uas[$ky]['dikirim']=$this->ad_uas->getDetuasByKelasPelajaran($_POST['pelajaran'],$_POST['id_kelas']);
			}
			//uas($uas);
			$data['uas']=$uas;
			$data['main']= 'siswa/kirimuas/daftaruaslist';
            $this->load->view('layout/ad_blank',$data);	
		}
        public function daftaruas()
        {	
			$this->load->model('ad_siswa');
			$siswa=$this->ad_siswa->getSiswaTaSekarang();
			$data['siswa']=$siswa;
			$data['uas']=array();
			$data['main']= 'siswa/kirimuas/daftaruas';
            $this->load->view('layout/ad_blank',$data);		
		}      
    }
?>