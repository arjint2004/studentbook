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
		pr($_POST);
		/*if ($user->fb_id=='') {
			$this->load->library('ak_facebook');
			$userfbid=$this->ak_facebook->getuserid();
			//echo $userfbid;die();
			if ($userfbid) {
				$this->db->query("UPDATE users SET fb_id='".$userfbid."' WHERE id=".$user->id."");
				$sessiondata['fb_id'] = $userfbid;
			}
		}*/
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