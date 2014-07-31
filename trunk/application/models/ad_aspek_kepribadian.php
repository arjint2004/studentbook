<?php
Class Ad_aspek_kepribadian extends CI_Model{
	function getAllAspek(){
		$query=$this->db->query('SELECT *
								 FROM ak_aspek_kepribadian
								');
		
		return $query->result_array();
	}
	function getAllAspekByIdSekolah($id_sekolah=0){
		$query=$this->db->query('SELECT *
								 FROM ak_aspek_kepribadian
								 WHERE id_sekolah='.$id_sekolah.'
								');
		
		return $query->result_array();
	}
	function getCurrentNilaiPoint($id_det_jenjang=0){
		$query=$this->db->query('SELECT *
								 FROM ak_nilai_kepribadian 
								 WHERE id_sekolah='.$this->session->userdata['user_authentication']['id_sekolah'].'
								 AND id_siswa_det_jenjang='.$id_det_jenjang.'
								 AND ta='.$this->session->userdata['ak_setting']['ta'].'
								 AND semester='.$this->session->userdata['ak_setting']['semester'].'
								');
		$nilai=$query->result_array();
		foreach($nilai as $ky=>$dataout){
			$nilai2[$dataout['id_aspek_kepribaian']]=$dataout;
		}
		unset($nilai);
		return $nilai2;
	}
 }
 ?>