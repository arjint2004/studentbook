<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Catatanguru extends CI_Controller
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
			$data['main']= 'siswa/catatanguru/index';
            $this->load->view('layout/ad_blank',$data);	
		} 
        public function catatangurulist($bulan)
        {
			$this->load->model('ad_catatanguru');
			$data['absenpbymonth']=$this->ad_catatanguru->getCatatanguruByMonth($bulan);
			$data['main']= 'siswa/catatanguru/catatangurulist';
            $this->load->view('layout/ad_blank',$data);	
		}   
    }
?>