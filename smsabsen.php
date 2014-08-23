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
		$sql="SELECT sms.notifikasi,sms.id ,ap.hp,ap.password,u.username,u.id as iduser
						FROM ak_notifikasi_sms sms
						JOIN ak_pegawai ap 
						JOIN users u
						ON ap.id_siswa = sms.id_siswa
						AND u.id_pengguna=ap.id
						WHERE date(waktu)='".date('Y-m-d')."'";
		$q=mysql_query($sql);		
		echo $sql;
		$apikey='81f6cf2706d2302a33782a6126b16469';
		//$nohp  = '+6283867139945';
		//$pesan = 'cek api';
		
		$this->sms->key   = '81f6cf2706d2302a33782a6126b16469';
		$this->sms->phone = '2rajasms';
		
		while($hsl=mysql_fetch_assoc($q)){
			if(strlen($hsl['hp'])>8 && strlen($hsl['hp'])<13){

			$encode=$hsl['notifikasi'].'. Pantau akademik putra/putri anda di https://studentbook.co/u/'.base64_encode($hsl['iduser']);						
			echo '<pre>';				
			print_r($hsl['hp']);			
			echo '</pre>';			
			echo '<pre>';
			print_r($encode);			
			echo '</pre>';	

			$this->sms->setTo('083867139945'); 
			$this->sms->setText($encode);
			$sts=$this->sms->send();	
			mysql_query("DELETE FROM `ak_notifikasi_sms` WHERE id=".$hsl['id']."");
			//die();
		}		}
		
	}
}

$dom=new sms();
$dom->execute_sms();

?>