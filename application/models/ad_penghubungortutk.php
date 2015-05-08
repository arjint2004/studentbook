<?php
Class Ad_penghubungortutk extends CI_Model
{

	function getdataByIdSekolah($id_sekolah=0){
		$query=$this->db->query('SELECT * FROM ak_penghubung_tk_cont WHERE id_sekolah='.$id_sekolah.'');
		//echo $this->db->last_query();
		return $query->result_array();
	}
	function getdataPengByIdSiswaTgl($id_siswa=0,$tanggal=''){
		$query=$this->db->query('SELECT * FROM ak_penghubung_tk 
								 WHERE
								 id_siswa=?
								 AND id_sekolah=?
								 AND id_ta =?
								 AND semester=?
								 AND tanggal=?
		',array($id_siswa,$this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['ak_setting']['ta'],$this->session->userdata['ak_setting']['semester'],$tanggal));
		//echo $this->db->last_query();
		return $query->result_array();
	}
	 
}