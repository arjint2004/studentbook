<?php
Class Ad_jurusan extends CI_Model
{

	 function getdata($id_sekolah){
		$query=$this->db->query('SELECT * FROM ak_jurusan WHERE id_sekolah='.$id_sekolah.'');
		return $query->result_array();
	 }
}