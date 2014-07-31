<?php
Class Ad_jadwal extends CI_Model{

	function getJadwalByTanggalKelasSemuaHariini($tanggal,$id_kelas){
		//pr($this->session->userdata['user_authentication']);
		if(isset($id_kelas) && $id_kelas!=0){$cnd=" AND ak.id=".$id_kelas."";}
		if($this->session->userdata['user_authentication']['id_group']==13){
			$query=$this->db->query('SELECT aj.*, ak.nama as nama_kelas, ak.kelas FROM ak_jadwal aj JOIN
									ak_mengajar am JOIN
									ak_kelas ak
									ON
									am.id=aj.id_mengajar
									AND
									ak.id=aj.id_kelas
									WHERE
									date(aj.StartTime)="'.$tanggal.'"
									AND ak.publish=1
									'.$cnd.'
									AND 
									am.id_pegawai='.$this->session->userdata['user_authentication']['id_pengguna'].'
									AND 
									aj.id_sekolah='.$this->session->userdata['user_authentication']['id_sekolah'].'
			');		
		}else{
			$query=$this->db->query('SELECT aj.*, ak.nama as nama_kelas, ak.kelas FROM ak_jadwal aj JOIN
									ak_mengajar am JOIN
									ak_kelas ak
									ON
									am.id=aj.id_mengajar
									AND
									ak.id=aj.id_kelas
									WHERE
									date(aj.StartTime)="'.$tanggal.'"
									AND ak.publish=1
									'.$cnd.'
									AND 
									aj.id_sekolah='.$this->session->userdata['user_authentication']['id_sekolah'].'
			');
		}
		//echo $this->db->last_query()."<br>";
		return $query->result_array();
	}
	function getJadwalByTanggalKelas($tanggal,$id_kelas){
		//pr($this->session->userdata['user_authentication']);
		if($this->session->userdata['user_authentication']['id_group']==13){
			$query=$this->db->query('SELECT aj.*, ak.nama as nama_kelas, ak.kelas FROM ak_jadwal aj JOIN
									ak_mengajar am JOIN
									ak_kelas ak
									ON
									am.id=aj.id_mengajar
									AND
									ak.id=aj.id_kelas
									WHERE
									date(aj.StartTime)="'.$tanggal.'"
									AND 
									aj.id_kelas='.$id_kelas.'
									AND ak.publish=1
									AND 
									am.id_pegawai='.$this->session->userdata['user_authentication']['id_pengguna'].'
									AND 
									aj.id_sekolah='.$this->session->userdata['user_authentication']['id_sekolah'].'
			');		
		}else{
			$query=$this->db->query('SELECT aj.*, ak.nama as nama_kelas, ak.kelas FROM ak_jadwal aj JOIN
									ak_mengajar am JOIN
									ak_kelas ak
									ON
									am.id=aj.id_mengajar
									AND
									ak.id=aj.id_kelas
									WHERE
									date(aj.StartTime)="'.$tanggal.'"
									AND 
									aj.id_kelas='.$id_kelas.'
									AND ak.publish=1
									AND 
									aj.id_sekolah='.$this->session->userdata['user_authentication']['id_sekolah'].'
			');
		}
		//echo $this->db->last_query()."<br>";
		return $query->result_array();
	}
	function getJadwalByWeek($tanggal){
		$query=$this->db->query('
		SELECT aj.*, ak.nama as nama_kelas, ak.kelas FROM ak_jadwal aj JOIN
								ak_mengajar am JOIN
								ak_kelas ak
								ON
								am.id=aj.id_mengajar
								AND
								ak.id=aj.id_kelas
								WHERE
								date(aj.StartTime)="'.$tanggal.'"
								AND 
								aj.id_sekolah='.$this->session->userdata['user_authentication']['id_sekolah'].'
								AND ak.publish=1
		');
		//echo $this->db->last_query();
		return $query->result_array();
	}
	function getJadwalByMonth($tanggal){
		$query=$this->db->query('SELECT * FROM ak_absensi WHERE tanggal="'.$tanggal.'" AND id_kelas='.$_POST['id_kelas'].'  AND id_sekolah='.$this->session->userdata['user_authentication']['id_sekolah'].'');
		//echo $this->db->last_query();
		return $query->result_array();
	}
 }
 