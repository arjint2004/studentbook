<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Rekapabsensi extends CI_Controller
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
		
			$data['main']= 'siswa/rekapabsensi/index';
            $this->load->view('layout/ad_blank',$data);	
		} 
        public function rekapabsensilist($bulan)
        {
			$this->load->model('ad_absen');
			$data['absenpbymonth']=$this->ad_absen->getAbsensiByMonth($bulan);
			$data['main']= 'siswa/rekapabsensi/rekapabsensilist';
            $this->load->view('layout/ad_blank',$data);	
		}   
    }
?>