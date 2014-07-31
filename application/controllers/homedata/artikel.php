<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Artikel extends CI_Controller {
	 var $upload_dir='upload/images/artikel/';
     public $denied_mime_types = array('application/x-php','application/x-httpd-php', 'text/html', 'text/css', 'text/javascript'); //array of denied mime types used when check_file_type is set to denied
	 function __construct()
	 {
		  parent::__construct();
		  //$this->load->library('auth');
		  //$this->auth->logged_in();
	 }
	 
	 public function index() {
		  $data['main'] 	= 'homedata/artikel/index';
		  $data['page_title'] 	= 'News & Artikel';
		  $this->load->view('layout/home_default',$data);
	 }
	 
	 public function detailmenu($id=0) {
		$this->load->model('ad_artikel');
		$data['artikel']=$this->ad_artikel->getdataByid($id);
		$data['countcommand']=$this->ad_artikel->countcomment($id);
		$this->db->query('UPDATE ak_artikel SET viewed=viewed+1 WHERE id_artikel='.$id.'');
		//pr($data['countcommand']);
		$data['id'] 	=$id;
		$data['main'] 	= 'homedata/artikel/artikel_detailmenu';
		$data['page_title'] 	= $data['artikel'][0]['judul'];
		$this->load->view('layout/home_default',$data);
	 }
	 public function detail($id=0) {
		$this->load->model('ad_artikel');
		$data['artikel']=$this->ad_artikel->getdataByid($id);
		$data['countcommand']=$this->ad_artikel->countcomment($id);
		$this->db->query('UPDATE ak_artikel SET viewed=viewed+1 WHERE id_artikel='.$id.'');
		//pr($data['countcommand']);
		$data['id'] 	=$id;
		$data['main'] 	= 'homedata/artikel/artikel_detail';
		$data['page_title'] 	= 'News & Artikel';
		$this->load->view('layout/home_default',$data);
	 }
	
	 
}
?>