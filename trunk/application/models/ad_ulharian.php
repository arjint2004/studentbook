<?php
Class Ad_ulharian extends CI_Model
{
	function getSubjectUlangan($id_kelas=null,$id_pelajaran=null){
		$cond='';
		if($id_kelas!=null){
			$cond='AND id_pelajaran='.$id_pelajaran.'';
		}
		if($id_pelajaran!=null){
			$cond=' AND id_kelas='.$id_kelas.'';
		}
		$query=$this->db->query('SELECT * FROM ak_subject_nilai WHERE id_sekolah='.$this->session->userdata['user_authentication']['id_sekolah'].' AND ta='.$this->session->userdata['ak_setting']['ta'].' AND semester='.$this->session->userdata['ak_setting']['semester'].' '.$cond.' ');
		return $query->result_array();
	}

}
?>