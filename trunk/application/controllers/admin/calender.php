<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Calender extends CI_Controller {
    function __construct()
    {
      parent::__construct();
	  $this->load->library('auth');
	  $this->auth->logged_in();
    }
   
    public function index()
    {
		$this->load->model('ad_kelas');
		$_SESSION['userdata']=$this->session->userdata;
		$_SESSION['session_id']=$this->session->userdata['session_id'];
		//pr($data['kelas']);
		$data['ak_setting'] 	= $this->session->userdata['ak_setting'];
		$data['session_id'] 	= $this->session->userdata['session_id'];
		$data['id_sekolah'] 	= $this->session->userdata['user_authentication']['id_sekolah'];
        $data['main'] 	= 'schooladmin/calender/index';
		$data['page_title'] 	= 'Kalender Akademik';
		$this->load->view('layout/ad_fullwidth',$data);
    }
	
    
}
?>