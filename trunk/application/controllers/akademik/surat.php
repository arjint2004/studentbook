<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Surat extends CI_Controller
    {
		var $upload_dir='upload/akademik/surat/';
        public $denied_mime_types = array('application/x-php','application/x-httpd-php', 'text/html', 'text/css', 'text/javascript'); //array of denied mime types used when check_file_type is set to denied
        public function __construct()
        {
            parent::__construct();
            $this->load->helper('global');
            $this->load->library('auth');
            $this->auth->user_logged_in();
        }
        
        public function index(){
		
			$this->load->model('ad_kelas');
			$data['kelas'] 	=$this->ad_kelas->getkelasByPengajar($this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['user_authentication']['id_pengguna']);
            $data['main']= 'akademik/surat/index';
            $this->load->view('layout/ad_blank',$data);
        }
		
        
        
    }
?>