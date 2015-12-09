<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Soalonline extends CI_Controller
    {
		var $upload_dir='upload/akademik/soalonline/';
        public $denied_mime_types = array('application/x-php','application/x-httpd-php', 'text/html', 'text/css', 'text/javascript'); //array of denied mime types used when check_file_type is set to denied
        public function __construct()
        {
            parent::__construct();
            $this->load->helper('global');
            $this->load->library('auth');
            $this->auth->user_logged_in();
        }
        
        public function take($param=''){
			$data['params']=unserialize(base64_decode($param));
			$data['main'] 	= 'siswa/soalonline/take';
			$data['page_title'] 	= 'Kerjakan Soal';
			$this->load->view('layout/ad_fullwidth',$data);
		}
        public function index(){
			$this->load->model('ad_siswa');
			$siswa=$this->ad_siswa->getSiswaTaSekarang();
			//pr($siswa);
			$data['siswa']=$siswa;
			$data['soalonline']=array();
            $data['main']= 'siswa/soalonline/index';
            $this->load->view('layout/ad_blank',$data);
        }

		public function getOptionFileSoalonlineByIdSoalonline($id_pr=null)
        {
			$this->load->library('ak_soalonline');
			echo $this->ak_soalonline->createOptionFileSoalonlineByIdSoalonline($id_pr);
		}

        public function daftarsoalonlinelist()
        {
			$this->load->model('ad_soalonline');
			$soalonline=$this->ad_soalonline->getsoalonlineAndFileByKelasPelajaranId($_POST['pelajaran'],$_POST['id_kelas']);

			$data['soalonline']=$soalonline;
			$data['main']= 'siswa/soalonline/daftarsoalonlinelist';
            $this->load->view('layout/ad_blank',$data);	
		}
        public function send_download($filename=null)
        {
			$filename=base64_decode($filename);
			$this->load->library('ak_file');
			$this->ak_file->send_download('upload/akademik/soalonline/',$filename);	
		}
        
        
    }
?>