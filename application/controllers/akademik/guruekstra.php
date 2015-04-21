<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Guruekstra extends CI_Controller
    {
        public function __construct()
        {
            parent::__construct();
            $this->load->helper('global');
            $this->load->library('session');
            $this->load->library('auth');
            $this->auth->user_logged_in();
        }
		
        public function index()
        {
			$this->load->model('ad_kelas');
			$data['kelas'] 	=$this->ad_kelas->getkelas($this->session->userdata['user_authentication']['id_sekolah']);

            $data['main']           = 'akademik/guruekstra/guruekstra';
            $this->load->view('layout/ak_default',$data);
        }

        public function filter()
        {
			$this->load->model('ad_kelas');
			$data['pembelajaran']=array();
			$data['url']=base_url().base64_decode($_POST['jenis']);
			$data['kelas'] 	=$this->ad_kelas->getkelas($this->session->userdata['user_authentication']['id_sekolah']);
            $data['main']= 'akademik/bk/filter';
            $this->load->view('layout/ad_blank',$data);
		}
        public function filterbysiswa()
        {
			$this->load->model('ad_kelas');
			$data['pembelajaran']=array();
			$data['url']=base_url().base64_decode($_POST['jenis']);
			$data['kelas'] 	=$this->ad_kelas->getkelas($this->session->userdata['user_authentication']['id_sekolah']);
            $data['main']= 'akademik/bk/filterbysiswa';
            $this->load->view('layout/ad_blank',$data);
		}
        public function filterbykelas()
        {
			$this->load->model('ad_kelas');
			$data['pembelajaran']=array();
			$data['url']=base_url().base64_decode($_POST['jenis']);
			$data['kelas'] 	=$this->ad_kelas->getkelas($this->session->userdata['user_authentication']['id_sekolah']);
            $data['main']= 'akademik/bk/filterbykelas';
            $this->load->view('layout/ad_blank',$data);
		}
        public function absensifilter()
        {
			$this->load->model('ad_kelas');
            $data['kelas'] 	=$this->ad_kelas->getkelas($this->session->userdata['user_authentication']['id_sekolah']);
           
            $data['main']= 'akademik/bk/absensifilter';
            $this->load->view('layout/ad_blank',$data);
		}
        public function catatangurufilter()
        {
			$this->load->model('ad_kelas');
            $data['kelas'] 	=$this->ad_kelas->getkelas($this->session->userdata['user_authentication']['id_sekolah']);
           
            $data['main']= 'akademik/bk/catatangurufilter';
            $this->load->view('layout/ad_blank',$data);
		}
		
		
    }
?>