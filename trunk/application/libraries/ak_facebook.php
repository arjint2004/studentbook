<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Ak_facebook {

	function __construct(){
		require_once 'facebook-php-sdk-master/src/facebook.php';
		define("FB_APP_ID", "701889786512635");
		define("FB_APP_SECRET", "969f2165b189358482928e708d70f48c");		
		$this->facebook = new Facebook(array(
		  'appId'  => FB_APP_ID,
		  'secret' => FB_APP_SECRET,
		  'grant_type' => 'client_credentials'
		));
	}
	function ceklogin(){
		$user = $this->facebook->getUser();
		
		if ($user) {
			return true;
		} else {
			return false;
		}		
	}
	function getuser(){

	}
}

