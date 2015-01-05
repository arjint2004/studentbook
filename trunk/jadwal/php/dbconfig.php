<?php
class DBConnection{
	function getConnection(){
	  //change to your database server/user name/password
		//define('BASEPATH', '');
		//include('../../application/config/database.php');	
		$db['default']['hostname'] = 'localhost';
		$db['default']['username'] = 'studoid1_develop';
		$db['default']['password'] = 'develop123';
		$db['default']['database'] = 'studoid1_develop';
		mysql_connect($db['default']['hostname'],$db['default']['username'],$db['default']['password']) or
         die("Could not connect: " . mysql_error());
    //change to your database name
		mysql_select_db($db['default']['database']) or 
		     die("Could not select database: " . mysql_error());
	}
} 
?>