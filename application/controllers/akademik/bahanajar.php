<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Bahanajar extends CI_Controller
    {
	
	    var $roots = array(
        'test' => '/home'
		);
		
        public function __construct()
        {
            parent::__construct();
            $this->load->helper('global');
            $this->load->library('session');
            $this->load->library('auth');
            $this->auth->user_logged_in();
            $this->load->library('ak_file');
        }
        
        public function index(){
            
			$arrdir=$this->ak_file->dirToArray('D:/webdevel/studentbookrepo/upload');
			pr($arrdir);die();
			$data['main']= 'akademik/bahanajar/index';
            $this->load->view('layout/ad_blank',$data);			
        }    

    }
?>