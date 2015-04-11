#!/usr/bin/php
<?php
$system_path = 'system';
define('BASEPATH', str_replace("\\", "/", $system_path));
class sms{

	function __construct(){
		
		error_reporting(E_ALL);
		$this->getConnection();
		
		require_once('rajasmsprivate.php'); // panggil class rajasmsreuler
		$this->sms = new smsprivate();
	}
	function getConnection(){
		//change to your database server/user name/password
		//define('BASEPATH', '');
		include('application/config/database.php');	
		/*$db['default']['hostname'] = 'localhost';
		$db['default']['username'] = 'root';
		$db['default']['password'] = '';
		$db['default']['database'] = 'studentbook';*/
		mysql_connect($db['default']['hostname'],$db['default']['username'],$db['default']['password']) or
         die("Could not connect: " . mysql_error());
		//change to your database name
		mysql_select_db($db['default']['database']) or 
		die("Could not select database: " . mysql_error());
	}
	
	function execute_sms(){
	
		//get data sms
		$q=mysql_query("SELECT * FROM ak_sms GROUP BY pesan,no_hp LIMIT 50");
		$apikey='81f6cf2706d2302a33782a6126b16469';
		//$nohp  = '+6283867139945';
		//$pesan = 'cek api';
		
		$this->sms->key   = '81f6cf2706d2302a33782a6126b16469';
		$this->sms->phone = '2rajasms';
		
		while($hsl=mysql_fetch_assoc($q)){
			if(strlen($hsl['no_hp'])>8 && strlen($hsl['no_hp'])<15 && strlen($hsl['pesan'])>10){
				//echo"<pre>";
				//print_r($hsl);
				//echo"</pre>";
				$this->sms->setTo($hsl['no_hp']);
				$this->sms->setText($hsl['pesan']);
				$sts=$this->sms->send();
				mysql_query("DELETE FROM `ak_sms` WHERE pesan='".mysql_real_escape_string($hsl['pesan'])."' AND no_hp='".mysql_real_escape_string($hsl['no_hp'])."'");
				echo "DELETE FROM `ak_sms` WHERE pesan='".mysql_real_escape_string($hsl['pesan'])."' AND no_hp='".mysql_real_escape_string($hsl['no_hp'])."'";
			}
		}
		
	}
}

$dom=new sms();
$dom->execute_sms();

?>