<?php
Class Ad_content extends CI_Model{

	function getdata($id_sekolah,$title=''){
		$query=$this->db->query('SELECT * FROM ak_content WHERE id_sekolah='.$id_sekolah.' AND title="'.$title.'"');
		
		return $query->result_array();
	}
	function getAlldata($id_sekolah){
		$query=$this->db->query('SELECT * FROM ak_content WHERE id_sekolah='.$id_sekolah.'');
		
		return $query->result_array();
	}
	
 
 }
 