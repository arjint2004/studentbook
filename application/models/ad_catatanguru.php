<?php
Class Ad_catatanguru extends CI_Model{

	function getCatatanByIdSekolah($id_sekolah=0,$field=array('*')){
		if(isset($_POST['filter'])){
			$cond='AND date(tanggal) > "'.date("Y-m-d", mktime(0, 0, 0,  date("m")  , date("d")-$_POST['filter'], date("Y"))).'"';
		}
		$query=$this->db->query('SELECT '.implode(",",$field).' FROM ak_catatanguru ap 
								WHERE
								ap.id_sekolah='.$id_sekolah.'
								'.$cond.'
								',array($id_kelas,$id_pelajaran));
		return $query->result_array();
	}
	function getCatatanguruByKelasTanggalIdPegawai($id_kelas,$id_siswa_det_jenjang,$tanggal){
		$query=$this->db->query('SELECT ac.*,ak_kelas.kelas,ak_kelas.nama as nama_kelas
								 FROM ak_catatanguru ac JOIN
								 ak_kelas
								 ON
								 ac.id_kelas=ak_kelas.id
								 WHERE
								 ac.id_sekolah='.$this->session->userdata['user_authentication']['id_sekolah'].'
								 AND ac.id_kelas="'.$id_kelas.'"
								 AND ac.id_siswa_det_jenjang="'.$id_siswa_det_jenjang.'"
								 AND ac.tanggal="'.$tanggal.'"
								 AND ac.id_pegawai='.$this->session->userdata['user_authentication']['id_pengguna'].'
								  AND ak_kelas.publish=1
								 GROUP BY ac.id
								');
		//echo $this->db->last_query();
		return 	$query->result_array();
		
	}
	function getCatatanguruByKelasIdPegawai($id_kelas){
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
	function getCatatanguruById($id){
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
	function getCatatanguruByMonth($month){
		$query=$this->db->query('SELECT *
								FROM `ak_catatanguru`
								WHERE month( `tanggal` ) ='.$month.'
								AND id_siswa_det_jenjang='.$this->session->userdata['user_authentication']['id_siswa_det_jenjang'].'
								');
		//echo $this->db->last_query();
		return $query->result_array();
	}
	
	
 }
 