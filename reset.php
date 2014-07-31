#!/usr/bin/php
<?
$system_path = 'system';
define('BASEPATH', str_replace("\\", "/", $system_path));
include('application/config/database.php');	

		mysql_connect($db['default']['hostname'],$db['default']['username'],$db['default']['password']) or
         die("Could not connect: " . mysql_error());
    //change to your database name
		mysql_select_db($db['default']['database']) or 
		     die("Could not select database: " . mysql_error());
			 
	$q=mysql_query('SELECT *
	FROM `ak_sms_report`
	WHERE status="Format Http Api SMS Salah" AND id>1907');
	
	while($hsl=mysql_fetch_assoc($q)){
		
		$rep=unserialize($hsl['id_notif_sms']);
		echo "<pre>";
		print_r($rep);
		$imp=implode(",",$rep);
		$ssql= 'update ak_notifikasi_sms SET status=0 WHERE id IN('.$imp.')';
		mysql_query($ssql);
		//echo "<pre>";
		//mysql_query('update ak_notifikasi_sms SET status=0 WHERE id IN('.implode(",",unserialize($hsl['id_notif_sms'])).'');
		//$vv++;
	}
	//echo $vv;
	//echo "<pre>";
	//print_r(unserialize('a:2:{s:8:"response";O:8:"stdClass":2:{s:13:"message-count";s:1:"1";s:8:"messages";a:1:{i:0;O:8:"stdClass":6:{s:2:"to";s:13:"6283867139945";s:10:"error-text";s:25:"Quota Exceeded - rejected";s:13:"message-price";s:10:"0.00700000";s:6:"status";s:1:"9";s:17:"remaining-balance";s:10:"0.00100000";s:7:"network";s:5:"51008";}}}s:13:"response_code";i:200;}'));
 
?>