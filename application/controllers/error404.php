<?php
class error404 extends CI_Controller {

    function __construct()
    {
        parent::__construct();
    }

    function index()
    {   
       $data=array();
	   $this->load->view('error/404/index',$data);//loading in my template 
    }
}