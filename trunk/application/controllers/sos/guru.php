<?php
    class Guru extends CI_Controller
    {
        public function __construct()
        {
            parent::__construct();
            $this->load->helper('global');
            $this->load->library('session');
            $this->load->library('auth');
            $this->auth->user_logged_in();
            $this->load->library('image_moo');
        }
        
        public function index()
        {
            $session = session_data();
            $data['main']           = 'sosial/guruview';
            $this->load->view('layout/fr_default',$data);
        }
        
        
    }
?>