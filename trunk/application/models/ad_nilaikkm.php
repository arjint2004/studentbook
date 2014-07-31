<?php
Class Ad_nilaikkm extends CI_Model{

	
	function getAllKkm(){
		$query=$this->db->query('SELECT * FROM ak_nilai_kkm WHERE 
								 ta='.$this->session->userdata['ak_setting']['ta'].' AND
								 semester='.$this->session->userdata['ak_setting']['semester'].' AND
								 id_sekolah='.$this->session->userdata['user_authentication']['id_sekolah'].'
								');
								
		return $query->result_array();
								
	}
	
 }
 