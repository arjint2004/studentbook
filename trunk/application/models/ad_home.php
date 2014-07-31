<?php
Class Ad_home extends CI_Model{

	public function get_guru_by_id($id_guru){
	
	}
	public function get_artikel_by_rand(){
		$querypengguna=$this->db->query('SELECT id_artikel,judul,sub_desc,foto,tagline FROM ak_artikel WHERE status=1 ORDER BY id_artikel DESC LIMIT 11');
		$data=$querypengguna->result_array();
		shuffle($data);
		return $data;
	}
	public function get_artikel_by_id($id_artikel){
	
	}
	public function siswa_prestasi(){
	
	}
	public function get_sekolah_by_id($id1){
	
	}
}
 