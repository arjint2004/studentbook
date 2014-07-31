<?php
class DBConnection{
	function getConnection(){
	  //change to your database server/user name/password
		//define('BASEPATH', '');
		//include('../../application/config/database.php');	
		$db['default']['hostname'] = 'localhost';
		$db['default']['username'] = 'root';
		$db['default']['password'] = '';
		$db['default']['database'] = 'studentbook';
		mysql_connect($db['default']['hostname'],$db['default']['username'],$db['default']['password']) or
         die("Could not connect: " . mysql_error());
    //change to your database name
		mysql_select_db($db['default']['database']) or 
		     die("Could not select database: " . mysql_error());
	}
} 
?>