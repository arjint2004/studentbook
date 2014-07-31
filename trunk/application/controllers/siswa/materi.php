<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Materi extends CI_Controller
    {
		var $upload_dir='upload/akademik/materi/';
        public $denied_mime_types = array('application/x-php','application/x-httpd-php', 'text/html', 'text/css', 'text/javascript'); //array of denied mime types used when check_file_type is set to denied
        public function __construct()
        {
            parent::__construct();
            $this->load->helper('global');
            $this->load->library('auth');
            $this->auth->user_logged_in();
        }
        
        public function index(){
			$this->load->model('ad_siswa');
			$siswa=$this->ad_siswa->getSiswaTaSekarang();
			//pr($siswa);
			$data['siswa']=$siswa;
			$data['materi']=array();
            $data['main']= 'siswa/materi/index';
            $this->load->view('layout/ad_blank',$data);
        }

		public function getOptionFileMateriByIdMateri($id_pr=null)
        {
			$this->load->library('ak_materi');
			echo $this->ak_materi->createOptionFileMateriByIdMateri($id_pr);
		}

        public function daftarmaterilist()
        {
			$this->load->model('ad_materi');
			$materi=$this->ad_materi->getmateriAndFileByKelasPelajaranId($_POST['pelajaran'],$_POST['id_kelas']);

			$data['materi']=$materi;
			$data['main']= 'siswa/materi/daftarmaterilist';
            $this->load->view('layout/ad_blank',$data);	
		}
        public function send_download($filename=null)
        {
			$filename=base64_decode($filename);
			$this->load->library('ak_file');
			$this->ak_file->send_download('upload/akademik/materi/',$filename);	
		}
        
        
    }
?>