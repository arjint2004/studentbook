<?php
Class Ad_administrasi extends CI_Model{

	function getFilePembById_pemb($id_pemb){
		$query=$this->db->query('SELECT * FROM ak_administrasi_file 
								WHERE
								id_administrasi="'.$id_pemb.'"
								');
		
		return $query->result_array();	
	}
	function getFilePembById($id){
		$query=$this->db->query('SELECT * FROM ak_administrasi_file 
								WHERE
								id="'.$id.'"
								');
		
		return $query->result_array();	
	}
	function getadministrasiByKelasPelajaranIdPegawai($id_pelajaran=0,$id_kelas=0,$jenis=''){
		if($id_pelajaran!=0 && $id_kelas!=0){
			$cnd='AND arp.id_pelajaran="'.$id_pelajaran.'" AND arp.id_kelas="'.$id_kelas.'"';
			$limit='LIMIT 10';
		}
		$query=$this->db->query('SELECT arp.*,sm.nama as semester,ak_kelas.kelas,ak_kelas.nama as nama_kelas, ak_pelajaran.nama as nama_pelajaran
								 FROM ak_administrasi arp JOIN
								 ak_kelas JOIN
								 ak_pelajaran JOIN
								 ak_semester sm
								 ON
								 arp.id_kelas=ak_kelas.id
								 AND
								 arp.id_pelajaran=ak_pelajaran.id
								 AND 
								 arp.semester=sm.id
								 WHERE
								 arp.id_sekolah='.$this->session->userdata['user_authentication']['id_sekolah'].'
								 '.$cnd.'
								 AND arp.id_pegawai='.$this->session->userdata['user_authentication']['id_pengguna'].'
								 AND arp.jenis="'.$jenis.'"
								 GROUP BY arp.id
								 '.$limit.'
								');
		
		
		$in=array(-1);
		//echo $this->db->last_query();
		foreach($query->result_array() as $datapemb){
			$datapemb2[$datapemb['id']]=$datapemb;
			$queryfile=$this->db->query('SELECT * FROM ak_administrasi_file WHERE id_administrasi="'.$datapemb['id'].'"');
			$datapemb2[$datapemb['id']]['file']=$queryfile->result_array();
		}

		$pem['administrasi']=$datapemb2;
		return $pem;
	}
	function getadministrasiById($id){
		$query=$this->db->query('SELECT *
								 FROM ak_administrasi  
								 WHERE
								 id_sekolah='.$this->session->userdata['user_authentication']['id_sekolah'].'
								 AND id_pegawai='.$this->session->userdata['user_authentication']['id_pengguna'].'
								 AND
								 id="'.$id.'"
								');
		
		return $query->result_array();
	}
	
	
 }
 