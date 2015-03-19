<?php
class Facebook_controll extends CI_Controller {
 
    public function __construct()
    {
        parent::__construct();
        $this->load->library('auth');
        $this->load->helper('global');
        $this->auth->user_logged_in();
    }

    public function saveId() {
		$fbakun=json_decode($_POST['fbaccount']);
		/*
		stdClass Object
		(
			[id] => 10206257977435076
			[email] => arjint2004@gmail.com
			[first_name] => Arjint
			[gender] => male
			[last_name] => Asbin
			[link] => https://www.facebook.com/app_scoped_user_id/10206257977435076/
			[locale] => id_ID
			[name] => Arjint Asbin
			[timezone] => 7
			[updated_time] => 2015-02-28T10:13:52 0000
			[verified] => 1
		)*/
		
		if (isset($fbakun->id) && $fbakun->id!='') {
			
			$cekexixts=$this->db->query("SELECT COUNT(*) as cnt FROM users WHERE fb_id='".$fbakun->id."'")->result_array();	
			if($cekexixts[0]['cnt']>0){
				echo "Facebook <b>".$fbakun->first_name." ".$fbakun->last_name."</b> sudah dipakai akun orang lain";die();
			}else{
				$this->db->query("UPDATE users SET fb_id='".$fbakun->id."' WHERE id=".$this->session->userdata['user_authentication']['id']."");
				$auth=$this->session->userdata['user_authentication'];
				$auth['fb_id']=$fbakun->id;
				$this->session->set_userdata('user', $auth);
				$this->session->set_userdata('user_authentication', $auth);
				
				echo "Sekarang akun Facebook <b>".$fbakun->first_name." ".$fbakun->last_name."</b> sudah terhubung dengan Studentbook. Kamu bisa menerima notifikasi studentbook di facebook kamu";die();
			}

		}
	}
    public function xx() {
        require_once 'facebook-php-sdk-master/src/facebook.php';

		
		$app_id	='701889786512635';
		$app_secret='969f2165b189358482928e708d70f48c';
		
		$facebook = new Facebook(array(
		  'appId'  => $app_id,
		  'secret' => $app_secret,
		));
		$accessToken = $app_id . '|' . $app_secret;
		$params = array(
					'access_token' => $accessToken,
					'href' => 'studentbook.co',
					'template' => 'test notif',
				);
		$facebook->api('/1434750659/notifications', 'post', $params);
	}
}
?>