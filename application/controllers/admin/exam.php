<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Exam extends CI_Controller {

	 function __construct()
	 {
		  parent::__construct();
		  $this->load->library('auth');
		  $this->auth->logged_in();
	 }
	function index(){
	
	
		$data['main'] 	= 'schooladmin/exam/index';// memilih view
		$this->load->view('layout/ad_adminsekolah',$data);
	 }

}