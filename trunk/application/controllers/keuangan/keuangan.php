<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Keuangan extends CI_Controller {
	 var $upload_dir='upload/images/berita/';
     public $denied_mime_types = array('application/x-php','application/x-httpd-php', 'text/html', 'text/css', 'text/javascript'); //array of denied mime types used when check_file_type is set to denied
	 function __construct()
	 {
		  parent::__construct();
		  //$this->load->library('auth');
		  //$this->auth->logged_in();
	 }
	 
	 public function index($id=0) {
		
		$data['page_title'] 	= 'Keuangan';
		$data['main'] 	= 'keuangan/index';
		$this->load->view('layout/ak_default',$data);
	 }
	
	 
}
?>