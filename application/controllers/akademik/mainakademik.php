<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Mainakademik extends CI_Controller
    {
        public function __construct()
        {
            parent::__construct();
            $this->load->helper('global');
			$this->load->helper('akademik');
            $this->load->library('session');
            $this->load->library('auth');
            $this->auth->user_logged_in();
            $this->load->library('image_moo');
        }
        
        public function index()
        {
			
           	$this->load->model('ad_kelas');
			$data['kelas'] 	=$this->ad_kelas->getkelas($this->session->userdata['user_authentication']['id_sekolah']);
			$data['kelaswali']=$this->ad_kelas->getKelasByWali($this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['user_authentication']['id_pengguna']);
			$data['group']=$this->auth->get_det_group($this->session->userdata['user_authentication']['id']);
			$jenjang=$this->ad_kelas->thisjenjang($this->session->userdata['user_authentication']['id']);
			
			//pr($data['group']);
		    $session = session_data();
			//echo $jenjang[0]['bentuk'];
			if($jenjang[0]['bentuk']=='TK'){
				$data['main']           = 'akademik/mainakademik/maintk';
			}elseif($jenjang[0]['bentuk']=='PESANTREN'){
				$data['main']           = 'akademik/mainakademik/mainpesantren';
			}else{
				$data['main']           = 'akademik/mainakademik/main';
			}
            $this->load->view('layout/ak_default',$data);
        }
        
        public function akademikguru()
        {
            $session = session_data();
            $data['main']           = 'akademik/mainakademik/akademikguru';
            $this->load->view('layout/ak_default',$data);
        }
        
        public function kepsek()
        {
            $session = session_data();
            $data['main']           = 'akademik/mainakademik/kepsek';
            $this->load->view('layout/ak_default',$data);
        }
        
        
    }
?>