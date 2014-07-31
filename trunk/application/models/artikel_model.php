<?php
Class Artikel_model extends CI_Model{

	function get_all_artikel(){
		$this->db->join('ak_kategori_artikel as k', 'k.id_kategori = a.id_kategori');
		$this->db->where('a.status', 1);
		return  $this->db->get('ak_artikel as a')->result();	
	}

	function get_artikel_by_id($id_artikel){
		$this->db->join('ak_kategori_artikel as k', 'k.id_kategori = a.id_kategori');
		$this->db->where('id_artikel', $id_artikel);
		$this->db->where('a.status', 1);
		return  $this->db->get('ak_artikel as a')->row();
	}

	function get_artikel_by_idkat($id_kategori){
		$this->db->join('ak_kategori_artikel as k', 'k.id_kategori = a.id_kategori');
		$this->db->where('a.id_kategori', $id_kategori);
		$this->db->where('a.status', 1);
		return  $this->db->get('ak_artikel as a')->result();
	}


}