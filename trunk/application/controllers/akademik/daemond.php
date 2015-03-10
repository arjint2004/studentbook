<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Daemond extends CI_Controller
    {
        public function __construct()
        {
            parent::__construct();
            $this->load->helper('global');
            $this->load->library('session');
        }
        
        public function md($token=''){

			if($this->auth($token)==true){
				$sms=$this->db->query("SELECT id,no_hp,pesan FROM ak_sms LIMIT 1")->result_array();
				$encrypted = base64_encode(serialize($sms));
				echo $encrypted;
			}
		}
        public function mdupdate($token='',$id=''){
			if($this->auth($token)==true){
				$this->db->query("DELETE FROM ak_sms WHERE id IN(".$id.")");
			}			
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
	
    }
?>