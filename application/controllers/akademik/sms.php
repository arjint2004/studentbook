<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Sms extends CI_Controller
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
        
        public function md($token=''){

			if($this->auth($token)==true){
				$sms=$this->db->query("SELECT no_hp,pesan FROM ak_sms LIMIT 100")->result_array();
				$encrypted = base64_encode(serialize($sms));
				echo $encrypted;
			}
		}
        public function mdupdate($id=''){
			
		}
		function auth($token='')
		{
			//YToyOntzOjg6InVzZXJuYW1lIjtzOjI6InNiIjtzOjg6InBhc3N3b3JkIjtzOjE5OiJzdHVkZW50Ym9vayEqJCVeJiMkIjt9
			//$token= base64_encode(serialize(array('username'=>'sb','password'=>'studentbook!*$%^&#$')));
			$tokendec=unserialize(base64_decode($token));
			//pr($tokendec);
			if(!empty($tokendec) && $tokendec['username']=='sb' && $tokendec['password']=='studentbook!*$%^&#$'){
				return true;
			}else{
				return false;
			}
		}
	
        public function replacenohp(){
			$nohperr=$this->db->query("SELECT id,hp FROM ak_pegawai WHERE CHAR_LENGTH(hp)>14")->result_array();
			pr($nohperr);
			foreach($nohperr as $datano){
				$nohpfix=str_replace(" ","",str_replace("'","",str_replace("/","",$datano['hp'])));
				$this->db->query("UPDATE ak_pegawai SET hp=".$nohpfix." WHERE id=".$datano['id']."");
			}
		}
        public function index($start=0,$page=0){
			
			$this->load->model('ad_sms');		
			$this->load->library('smsprivate');
			
			$this->load->library('pagination');
			$config['base_url']   = site_url('akademik/sms/index');
			$config['per_page']   = 5;
			//$config['uri_segment']   = 5;
			$config['cur_page']   = $start;
			$data['start'] = $start;
			$config['total_rows'] = $this->ad_sms->getSmsCount();
            $data['smsakademik'] =$this->ad_sms->getSms('',$start,$config['per_page']);
			$this->pagination->initialize($config);
			$data['pagination'] = $this->pagination->create_links();

			
			if(isset($_POST['id_sms']) && !empty($_POST['id_sms']) && $_POST['kirim']=='Kirim Yang dipilih'){
				foreach($_POST['id_sms'] as $id_sms=>$idnya){
					$this->smsprivate->setTo($_POST['no_hp'][$id_sms]);
					$this->smsprivate->setText($_POST['pesan'][$id_sms]);
					$this->smsprivate->send();
					//pr($_POST['no_hp'][$id_sms]);
					//pr($_POST['pesan'][$id_sms]);
					
				}
			}
			if($_POST['kirim']=='Kirim Semua'){
				$datasmsq=$this->db->query('SELECT * FROM ak_sms WHERE id_pegawai='.$this->session->userdata['user_authentication']['id_pengguna'].'');
				$datasms=$datasmsq->result_array();
				//pr($datasms);
				foreach($datasms as $datasms){
					$this->smsprivate->setTo($datasms['no_hp']);
					$this->smsprivate->setText($datasms['pesan']);
					$this->smsprivate->send();
					//pr($datasms['no_hp']);
					//pr($datasms['pesan']);
				}
			}
			
            $data['main']= 'akademik/sms/sms';
            $this->load->view('layout/ad_blank',$data);
        }
		
		public function notifguru(){
			pr($_SERVER);
		}
    }
?>