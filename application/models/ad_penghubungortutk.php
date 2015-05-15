<?php
Class Ad_penghubungortutk extends CI_Model
{

	function getdataByIdSekolah($id_sekolah=0,$type=''){
		$query=$this->db->query('SELECT * FROM ak_penghubung_tk_cont WHERE id_sekolah=? AND type=?',array($id_sekolah,$type));
		//echo $this->db->last_query();
		return $query->result_array();
	}
	function getdataPengSiswaById($id){
		$query=$this->db->query('SELECT * FROM ak_penghubung_tk 
								 WHERE
								 id=?
		',array($id));
		//echo $this->db->last_query();
		return $query->result_array();
	}
	function getdataPengContByIdPeng($id){
		$query=$this->db->query('SELECT * FROM ak_penghubung_tk 
								 WHERE
								 id=?
		',array($id));
		//echo $this->db->last_query();
		return $query->result_array();
	}
	function getdataPengByIdSiswaTgl($id_siswa=0,$tanggal=''){
		if($id_siswa==0 || $id_siswa==""){$cndsis="";}else{$cndsis="id_siswa=".$id_siswa." AND";}
		$query=$this->db->query('SELECT * FROM ak_penghubung_tk 
								 WHERE
								 '.$cndsis.'
								  id_sekolah=?
								 AND id_ta =?
								 AND semester=?
								 AND tanggal=?
		',array($this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['ak_setting']['ta'],$this->session->userdata['ak_setting']['semester'],$tanggal));
		//echo $this->db->last_query();
		return $query->result_array();
	}
	function getdataPengByIdSiswaTglType($id_siswa=0,$tanggal='',$type=''){
		if($id_siswa==0 || $id_siswa==""){$cndsis="";}else{$cndsis="id_siswa=".$id_siswa." AND";}
		if($type=="menu_makan"){$cndkls=" AND id_kelas='".$_POST['id_kelasmanu']."'";}else{$cndkls="";}
		$query=$this->db->query('SELECT * FROM ak_penghubung_tk 
								 WHERE
								 '.$cndsis.'
								  id_sekolah=?
								 AND id_ta =?
								 AND semester=?
								 AND tanggal=?
								 AND type=?
								 '.$cndkls.'
		',array($this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['ak_setting']['ta'],$this->session->userdata['ak_setting']['semester'],$tanggal,$type));
		//echo $this->db->last_query();
		return $query->result_array();
	}
	 
}