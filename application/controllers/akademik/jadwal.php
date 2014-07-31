<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jadwal extends CI_Controller {
    function __construct()
    {
      parent::__construct();
	  $this->load->library('auth');
	  $this->load->helper('akademik');
	  $this->auth->logged_in();
    }
   
    public function index()
    {
		
        $data['main'] 	= 'akademik/jadwal/index';
		$this->load->view('layout/ad_blank',$data);
    }
	
    
}
?>