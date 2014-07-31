<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Rekapnilai extends CI_Controller
    {
		public function __construct()
        {
            parent::__construct();
            $this->load->helper('akademik');
            $this->load->library('session');
            $this->load->library('auth');
            $this->auth->user_logged_in();
        }
        public function index()
        {
		
			$data['main']= 'siswa/rekapnilai/index';
            $this->load->view('layout/ad_blank',$data);	
		} 
  
    }
?>