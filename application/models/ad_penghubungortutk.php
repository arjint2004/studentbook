<?php
Class Ad_penghubungortutk extends CI_Model
{

	function getdataByIdSekolah($id_sekolah=0){
		$query=$this->db->query('SELECT * FROM ak_penghubung_tk_cont WHERE id_sekolah='.$id_sekolah.'');
		//echo $this->db->last_query();
		return $query->result_array();
	}
	function getdataPengByIdSiswa($id_siswa=0){
		$query=$this->db->query('SELECT * FROM ak_penghubung_tk_cont WHERE id_sekolah='.$id_siswa.'');
		//echo $this->db->last_query();
		return $query->result_array();
	}
	 
}