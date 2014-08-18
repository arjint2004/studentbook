<?php
Class Ad_absen extends CI_Model{

	function getCurrentAbsensi($tanggal,$jam_ke){
		$query=$this->db->query('SELECT * FROM ak_absensi WHERE tanggal=? AND id_kelas=? AND jam_ke=?',array($tanggal,$_POST['id_kelas'],$jam_ke));
		//echo $this->db->last_query();
		return $query->result_array();
	}
	function getCurrentAbsensiExport(){
		$query=$this->db->query('SELECT s.nis,s.nama,ab.* FROM ak_absensi ab
								JOIN ak_det_jenjang adj
								JOIN ak_siswa s
								ON ab.id_siswa_det_jenjang=adj.id
								AND s.id=adj.id_siswa
		WHERE ab.tanggal=? AND ab.jam_ke=? AND ab.id_sekolah',array($_POST['tanggalnyaabsensi'],$_POST['jamabsen'],$this->session->userdata['user_authentication']['id_sekolah']));
		//echo $this->db->last_query();
		return $query->result_array();
	}
	function getAbsensiByMonth($month){
		$query=$this->db->query('SELECT *
								FROM `ak_absensi`
								WHERE month( `tanggal` ) =?
								AND id_siswa_det_jenjang=?
								',array($month,$this->session->userdata['user_authentication']['id_siswa_det_jenjang']));
		//echo $this->db->last_query();
		return $query->result_array();
	}
	function getKetidakhadiranByIdDetjenjang($id_det_jenjang){
		$query=$this->db->query('SELECT *
								FROM `ak_absensi`
								WHERE absensi!="masuk"
								AND id_siswa_det_jenjang=?
								AND id_semester=?
								AND id_ta=?
								',array($id_det_jenjang,$this->session->userdata['ak_setting']['semester'],$this->session->userdata['ak_setting']['ta']));
		//echo $this->db->last_query(); 
		return $query->result_array();
	}
  
 }
 