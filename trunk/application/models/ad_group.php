<?php
Class Ad_group extends CI_Model{

	function getdata(){
		$query=$this->db->query('SELECT id,otoritas FROM `group` ORDER BY otoritas ASC');
		return $query->result_array();
	}
	
 
 }
 