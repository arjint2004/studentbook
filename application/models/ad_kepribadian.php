<?php
Class Ad_kepribadian extends CI_Model{



	function getkepribadianByKelasIdPegawaiIdSiswaDetJenjang($id_kelas,$id_siswa_det_jenjang){
		$query=$this->db->query('SELECT ac.*,ak_kelas.kelas,ak_kelas.nama as nama_kelas
								 FROM ak_catatanguru ac JOIN
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
	
	 function getNilaiByidDetJenjangktsp($id_det_jenjang){
		$qcurrentextra=$this->db->query('SELECT ae.nama,ae.id as id_aspek_kepribadian,ank.*,ank.point as nilai_kepribadian
										FROM ak_aspek_kepribadian ae 
										JOIN ak_nilai_kepribadian ank
										ON ank.id_aspek_kepribaian=ae.id
										WHERE ank.ta='.$this->session->userdata['ak_setting']['ta'].' 
										AND ank.semester='.$this->session->userdata['ak_setting']['semester'].' 
										AND ank.id_siswa_det_jenjang="'.$id_det_jenjang.'"');
		$xx=$qcurrentextra->result_array();
		$xx2=array();
		//echo $this->db->last_query();
		foreach($xx as $idx=>$dtx){
			$xx2[$dtx['id_siswa_det_jenjang']][$dtx['id_aspek_kepribadian']]=$dtx;
		}
		return $xx2;
	 }	
	 function getNilaiByidDetJenjang($id_det_jenjang){
		$qcurrentextra=$this->db->query('SELECT ane.*,ae.nama,ank.point as nilai_kepribadian
										FROM 
										ak_catatanguru ane 
										JOIN ak_aspek_kepribadian ae 
										JOIN ak_nilai_kepribadian ank
										ON 
										ane.id_aspek_kepribadian =ae.id 
										AND ank.id_aspek_kepribaian=ae.id
										WHERE ane.ta='.$this->session->userdata['ak_setting']['ta'].' 
										AND ane.semester='.$this->session->userdata['ak_setting']['semester'].' 
										AND ane.id_siswa_det_jenjang="'.$id_det_jenjang.'"');
		$xx=$qcurrentextra->result_array();
		$xx2=array();
		//echo $this->db->last_query();
		foreach($xx as $idx=>$dtx){
			$xx2[$dtx['id_siswa_det_jenjang']][$dtx['id_aspek_kepribadian']]=$dtx;
		}
		return $xx2;
	 }
	function getkepribadianByKelasIdPegawai($id_kelas){
		$query=$this->db->query('SELECT ac.*,ak_kelas.kelas,ak_kelas.nama as nama_kelas
								 FROM ak_catatanguru ac JOIN
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
	function getkepribadianById($id){
		$query=$this->db->query('SELECT *
								 FROM ak_catatanguru  
								 WHERE
								 id_sekolah='.$this->session->userdata['user_authentication']['id_sekolah'].'
								 AND id_pegawai='.$this->session->userdata['user_authentication']['id_pengguna'].'
								 AND
								 id="'.$id.'"
								');
		
		return $query->result_array();
	}
	
	
 }
 