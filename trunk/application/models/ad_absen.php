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
		WHERE ab.tanggal=? AND ab.jam_ke=? AND ab.id_sekolah=?',array($_POST['tanggalnyaabsensi'],$_POST['jamabsen'],$this->session->userdata['user_authentication']['id_sekolah']));
		//echo $this->db->last_query();
		return $query->result_array();
	}
	function getAbsensiByMonth($month){
		$query=$this->db->query('SELECT *
								FROM `ak_absensi`
								WHERE month( `tanggal` ) =?
								AND id_siswa_det_jenjang=?
								',array($month,$this->session->userdata['user_authentication']['id_siswa_det_jenjang']));
		echo $this->db->last_query();
		return $query->result_array();
	}
	function getAbsensiByMonthByKelasPel($month=0,$id_kelas=0){
		if($month==0){$month=date('m');}
		//get jam
		$queryj=$this->db->query('SELECT id,jam_ke,day(tanggal) as tanggal
								FROM `ak_absensi`
								WHERE month( `tanggal` ) =?
								AND id_kelas=?
								AND id_semester=?
								AND id_ta=?
								AND id_sekolah=?
								AND id_pelajaran=?
								GROUP BY jam_ke
								',array($month,$id_kelas,$this->session->userdata['ak_setting']['semester'],$this->session->userdata['ak_setting']['ta'],$this->session->userdata['user_authentication']['id_sekolah'],$_POST['id_pelajaran']));
		
		$jam_ke=$queryj->result_array();
		
		$query=$this->db->query('SELECT id,id_siswa_det_jenjang,jam_ke,absensi,day(tanggal) as tanggal
								FROM `ak_absensi`
								WHERE month( `tanggal` ) =?
								AND id_kelas=?
								AND id_semester=?
								AND id_ta=?
								AND id_sekolah=?
								AND id_pelajaran=?
								',array($month,$id_kelas,$this->session->userdata['ak_setting']['semester'],$this->session->userdata['ak_setting']['ta'],$this->session->userdata['user_authentication']['id_sekolah'],$_POST['id_pelajaran']));
		$absennya=$query->result_array();						
		//echo $this->db->last_query();
		foreach($jam_ke as $jamkenya){
			foreach($absennya as $jamkenyaabsen){
					$array1[$jamkenya['jam_ke']]['tanggal']=$jamkenyaabsen['tanggal'];
				if($jamkenya['jam_ke']==$jamkenyaabsen['jam_ke']){
					$array1[$jamkenya['jam_ke']]['data'][$jamkenyaabsen['id_siswa_det_jenjang']]=$jamkenyaabsen;
				}
				
			}
		}
		//pr($array1);
		//echo $this->db->last_query();
		
		return $array1;
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
 