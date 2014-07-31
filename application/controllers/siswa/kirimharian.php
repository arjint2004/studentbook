<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Kirimharian extends CI_Controller
    {
		var $upload_dir='upload/akademik/harian/';
		public $denied_mime_types = array('application/x-php','application/x-httpd-php', 'text/html', 'text/css', 'text/javascript'); //array of denied mime types used when check_file_type is set to denied
        public function __construct()
        {
            parent::__construct();
            $this->load->helper('global');
            $this->load->library('session');
            $this->load->library('auth');
            $this->auth->user_logged_in();
        }

        public function daftarharianlist()
        {
			$this->load->model('ad_harian');
			$harian=$this->ad_harian->getharianByKelasPelajaranId($_POST['pelajaran'],$_POST['id_kelas']);
			foreach($harian as $ky=>$dataharian){
				$harian[$ky]['file']=$this->ad_harian->getFileharianByIdharian($dataharian['id']);
				//$harian[$ky]['dikirim']=$this->ad_harian->getDetharianByKelasPelajaran($_POST['pelajaran'],$_POST['id_kelas']);
			}
			
			$data['harian']=$harian;
			$data['main']= 'siswa/kirimharian/daftarharianlist';
            $this->load->view('layout/ad_blank',$data);	
		}
        public function daftarharian()
        {	
			$this->load->model('ad_siswa');
			$siswa=$this->ad_siswa->getSiswaTaSekarang();
			$data['siswa']=$siswa;
			$data['harian']=array();
			$data['main']= 'siswa/kirimharian/daftarharian';
            $this->load->view('layout/ad_blank',$data);		
		}
    }
?>