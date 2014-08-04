<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Ak_db {

    public function getAllCols($col=''){
		   include('application/config/database.php');
		   $CI =& get_instance();
	 	   $query=$CI->db->query("
				SELECT DISTINCT TABLE_NAME
				FROM INFORMATION_SCHEMA.COLUMNS
				WHERE COLUMN_NAME
				IN (
				'".$col."'
				)
				AND TABLE_SCHEMA = '".$db['default']['database']."'
		   ");
		//echo $CI->db->last_query();
		$cols=$query->result_array();
		foreach($cols as $datacols){
			$cols2[]=$datacols['TABLE_NAME'];
		}
		unset($cols);
	   return $cols2;

	 }
   
}

