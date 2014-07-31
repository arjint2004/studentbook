<?php
Class Ad_prestasi extends CI_Model{



	function getprestasiByKelasIdPegawaiIdSiswaDetJenjang($id_kelas,$id_siswa_det_jenjang){
		$query=$this->db->query('SELECT ac.*,ak_kelas.kelas,ak_kelas.nama as nama_kelas
								 FROM ak_prestasi ac JOIN
								 ak_kelas
								 ON
								 ac.id_kelas=ak_kelas.id
								 WHERE
								 ac.id_sekolah='.$this->session->userdata['user_authentication']['id_sekolah'].'
								 AND ac.id_kelas="'.$id_kelas.'"
								 AND ac.id_siswa_det_jenjang="'.$id_siswa_det_jenjang.'"
								 AND ac.id_pegawai='.$this->session->userdata['user_authentication']['id_pengguna'].'
									AND ak_kelas.publish=1
								 GROUP BY ac.id
								');
		//echo $this->db->last_query();
		return 	$query->result_array();
		
	}	
	 function getNilaiByidDetJenjang($id_det_jenjang){
		$qcurrentextra=$this->db->query('SELECT ane.*  
										FROM 
										ak_prestasi ane
										WHERE ane.ta='.$this->session->userdata['ak_setting']['ta'].' 
										AND ane.semester='.$this->session->userdata['ak_setting']['semester'].' 
										AND ane.id_siswa_det_jenjang='.$id_det_jenjang.'');
		$xx=$qcurrentextra->result_array();
		$xx2=array();
		
		foreach($xx as $idx=>$dtx){
			$xx2[$dtx['id_siswa_det_jenjang']][$dtx['id']]=$dtx;
		}
		return $xx2;
	 }
	function getprestasiByKelasIdPegawai($id_kelas){
		$query=$this->db->query('SELECT ac.*,ak_kelas.kelas,ak_kelas.nama as nama_kelas
								 FROM ak_prestasi ac JOIN
								 ak_kelas
								 ON
								 ac.id_kelas=ak_kelas.id
								 WHERE
								 ac.id_sekolah='.$this->session->userdata['user_authentication']['id_sekolah'].'
								 AND ac.id_kelas="'.$id_kelas.'"
								 AND ac.id_pegawai='.$this->session->userdata['user_authentication']['id_pengguna'].'
									AND ak_kelas.publish=1
								 GROUP BY ac.id
								');

		return 	$query->result_array();
		
	}
	function getprestasiById($id){
		$query=$this->db->query('SELECT *
								 FROM ak_prestasi  
								 WHERE
								 id_sekolah='.$this->session->userdata['user_authentication']['id_sekolah'].'
								 AND id_pegawai='.$this->session->userdata['user_authentication']['id_pengguna'].'
								 AND
								 id="'.$id.'"
								');
		
		return $query->result_array();
	}
	
	
 }
 