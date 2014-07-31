<?php
Class Ad_jurnal extends CI_Model{


	function getJurnalWaliById_siswa_det_jenjang($id_siswa_det_jenjang){
		$query=$this->db->query('SELECT *
								FROM `ak_jurnal_wali`
								WHERE id_siswa_det_jenjang=?
								',array($id_siswa_det_jenjang));
		//echo $this->db->last_query(); 
		$jurnal=$query->result_array();
		foreach($jurnal as $ky=>$datajurnal){
			$queryfile=$this->db->query('SELECT *
								FROM `ak_jurnal_wali_file`
								WHERE id_jurnal=?
								',array($datajurnal['id']));
			$jurnalfile=$queryfile->result_array();					
			$jurnal[$ky]['file']=$jurnalfile;
		}
		
		return $jurnal;
	}
	
	function getDataPenghubungBysiswa($id_sekolah,$id_kelas){
		$query=$this->db->query('SELECT peng.*,ak.nama,ak.kelas,ak.id as id_kelas
								FROM `ak_penghubung` peng 
								JOIN ak_kelas ak
								ON ak.id=peng.id_kelas
								JOIN
								ak_penghubung_kirim apk 
								ON peng.id=apk.id_penghubung
								WHERE peng.id_sekolah=?
								AND 
								peng.id_ta=?
								AND 
								peng.semester=?
								AND
								apk.id_siswa=?
								AND 
								peng.id_kelas=?
								',array($this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['ak_setting']['ta'],$this->session->userdata['ak_setting']['semester'],$this->session->userdata['user_authentication']['id_siswa'],$id_kelas));		
								//echo $this->db->last_query(); 
		return $query->result_array();
	}
	function getCountPenghubung($id_kelas=0){
		$query=$this->db->query('SELECT COUNT(*) AS count
								FROM `ak_penghubung` peng 
								JOIN ak_kelas ak
								ON ak.id=peng.id_kelas
								WHERE peng.id_sekolah=?
								AND 
								peng.id_ta=?
								AND 
								peng.semester=?
								AND 
								peng.id_kelas=?
								',array($this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['ak_setting']['ta'],$this->session->userdata['ak_setting']['semester'],$id_kelas));
		$rslt=$query->result_array();				
		return $rslt[0]['count'];
	}
	function getDataPenghubung($id_sekolah,$id_kelas,$limit){
		if($this->session->userdata['user_authentication']['otoritas']=='ortu' || $this->session->userdata['user_authentication']['otoritas']=='siswa' ){
			$query=$this->db->query('SELECT peng.*,ak.nama,ak.kelas,ak.id as id_kelas
									FROM `ak_penghubung` peng 
									JOIN ak_kelas ak
									JOIN ak_penghubung_kirim apk
									ON ak.id=peng.id_kelas
									AND peng.id=apk.id_penghubung
									WHERE peng.id_sekolah=?
									AND 
									peng.id_ta=?
									AND 
									peng.semester=?
									AND 
									peng.id_kelas=?
									AND 
									apk.id_siswa=?
									ORDER BY id DESC
									LIMIT '.$limit.'
									',array($this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['ak_setting']['ta'],$this->session->userdata['ak_setting']['semester'],$id_kelas,$this->session->userdata['user_authentication']['id_siswa']));				
		}else{
			$query=$this->db->query('SELECT peng.*,ak.nama,ak.kelas,ak.id as id_kelas
									FROM `ak_penghubung` peng 
									JOIN ak_kelas ak
									ON ak.id=peng.id_kelas
									WHERE peng.id_sekolah=?
									AND 
									peng.id_ta=?
									AND 
									peng.semester=?
									AND 
									peng.id_kelas=?
									ORDER BY id DESC
									LIMIT '.$limit.'
									',array($this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['ak_setting']['ta'],$this->session->userdata['ak_setting']['semester'],$id_kelas));		
									
		}//echo $this->db->last_query(); 
		return $query->result_array();
	}
	function getdataPengById($id_penghubung){
		$query=$this->db->query('SELECT ap.*,ak.nama as nama_kelas,ak.kelas,ak.id as id_kelas FROM ak_penghubung ap
								JOIN ak_kelas ak
								ON ak.id=ap.id_kelas
								WHERE
								ap.id=?
								',array($id_penghubung));
		//echo $this->db->last_query();
		return $query->result_array();
	}
	function getFilePengByIdPeng($id_penghubung){
		$query=$this->db->query('SELECT af.* FROM ak_penghubung ap JOIN
								ak_penghubung_file af 
								ON
								af.id_penghubung=ap.id
								WHERE
								ap.id=?
								',array($id_penghubung));
		//echo $this->db->last_query();
		return $query->result_array();
	}
	function getPengDikirim($id_penghubung){
		$query=$this->db->query('SELECT af.*,asis.nama,asis.NmOrtu FROM ak_penghubung ap JOIN
								ak_penghubung_kirim af JOIN
								ak_siswa asis
								ON
								af.id_penghubung=ap.id
								AND
								af.id_siswa=asis.id
								WHERE
								ap.id=?
								AND ap.id_ta=?
								AND ap.semester=?
								',array($id_penghubung,$this->session->userdata['ak_setting']['ta'],$this->session->userdata['ak_setting']['semester']));
		//echo $this->db->last_query();
		return $query->result_array();
	}
 }
 