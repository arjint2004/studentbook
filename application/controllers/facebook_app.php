<?php
class Facebook_app extends CI_Controller {
 
    public function __construct()
    {
        parent::__construct();
        //$this->load->library('auth');
        //$this->load->helper('global');
        //$this->auth->user_logged_in();
    }
    
    public function index() {
        require_once '/home/studoid1/public_html/fb/sdkm/src/facebook.php';

		
		/*$app_id	='701889786512635';
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
		$facebook->api('/1434750659/notifications', 'post', $params);*/
		 
		
		define("FB_APP_ID", "701889786512635");
		define("FB_APP_SECRET", "969f2165b189358482928e708d70f48c");
		$facebook = new Facebook(array(
		  'appId'  => FB_APP_ID,
		  'secret' => FB_APP_SECRET,
		  'grant_type' => 'client_credentials'
		));
		 $user = $facebook->getUser();
		 echo $user;
		
	}
}
?>