<?php
Class Ad_jenjang extends CI_Model{


	function getjenjang(){
		$query=$this->db->query('SELECT *
								FROM `ak_jenjang`
								');
								
		return $query->result_array();
	}
 
 }
 