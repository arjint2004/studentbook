<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Kirimuts extends CI_Controller
    {
		var $upload_dir='upload/akademik/uts/';
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
			$this->ak_file->send_download('upload/akademik/uts/',$filename);	
		}
        public function daftarutslist()
        {
			$this->load->model('ad_uts');
			$uts=$this->ad_uts->getutsByKelasPelajaranId($_POST['pelajaran'],$_POST['id_kelas']);
			foreach($uts as $ky=>$datauts){
				$uts[$ky]['file']=$this->ad_uts->getFileutsByIduts($datauts['id']);
				//$uts[$ky]['dikirim']=$this->ad_uts->getDetutsByKelasPelajaran($_POST['pelajaran'],$_POST['id_kelas']);
			}
			//uts($uts);
			$data['uts']=$uts;
			$data['main']= 'siswa/kirimuts/daftarutslist';
            $this->load->view('layout/ad_blank',$data);	
		}
        public function daftaruts()
        {	
			
			$this->load->model('ad_siswa');
			$siswa=$this->ad_siswa->getSiswaTaSekarang();
			$data['siswa']=$siswa;
			$data['uts']=array();
			$data['main']= 'siswa/kirimuts/daftaruts';
            $this->load->view('layout/ad_blank',$data);		
		} 
		
		     
    }
?>