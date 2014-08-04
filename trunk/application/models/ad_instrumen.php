<?php
Class Ad_instrumen extends CI_Model{

	function getFilePembById_pemb($id_pemb){
		$query=$this->db->query('SELECT * FROM ak_rencana_pembelajaran_file 
								WHERE
								id_rencana_pembelajaran="'.$id_pemb.'"
								');
		
		return $query->result_array();	
	}
	function getPertemuanByIdkelas($id_kelas=0){
				$query=$this->db->query('SELECT arpt.*,ap.nama as pegawai,sm.nama as semester,ak_kelas.kelas,ak_kelas.nama as nama_kelas, ak_pelajaran.nama as nama_pelajaran
								 FROM 
								 ak_rencana_pertemuan arpt  JOIN
								 ak_kelas JOIN
								 ak_pelajaran JOIN
								 ak_pegawai ap JOIN
								 ak_semester sm
								 ON
								 ap.id=arpt.id_pegawai
								 AND
								 arpt.id_kelas=ak_kelas.id
								 AND
								 arpt.id_pelajaran=ak_pelajaran.id
								 AND 
								 arpt.semester=sm.id
								 WHERE
								 arpt.id_sekolah=?
								 AND arpt.id_pegawai=?
								 AND arpt.semester=?
								 AND arpt.ta=?
								 AND arpt.id_kelas=?
								 AND ak_kelas.publish=1
								 GROUP BY arpt.id DESC
								 LIMIT 15
								',array($this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['user_authentication']['id_pengguna'],$this->session->userdata['ak_setting']['semester'],$this->session->userdata['ak_setting']['ta'],$id_kelas));
		
		return $query->result_array();	
	}
	function getFilePembById_pertemuan($id){
		$query=$this->db->query('SELECT * FROM ak_rencana_pembelajaran
								WHERE
								id_pertemuan="'.$id.'"
								');
		
		return $query->result_array();	
	}
	function getFilePembById($id){
		$query=$this->db->query('SELECT * FROM ak_rencana_pembelajaran_file 
								WHERE
								id="'.$id.'"
								');
		
		return $query->result_array();	
	}
	
	function getWaktuPembelajaranByKelasPelajaranIdPegawai($id_pelajaran=0,$id_kelas=0){
		$cnd='';
		$cnd2='';
		if($id_pelajaran!=0){$cnd='AND arpt.id_pelajaran="'.mysql_real_escape_string($id_pelajaran).'"';}
		if($id_kelas!=0){$cnd2='AND arpt.id_kelas="'.mysql_real_escape_string($id_kelas).'"';}
		$query=$this->db->query('SELECT arpt.*,ap.nama as pegawai,sm.nama as semester,ak_kelas.kelas,ak_kelas.nama as nama_kelas, ak_pelajaran.nama as nama_pelajaran
								 FROM 
								 ak_rencana_pertemuan arpt  JOIN
								 ak_kelas JOIN
								 ak_pelajaran JOIN
								 ak_pegawai ap JOIN
								 ak_semester sm
								 ON
								 ap.id=arpt.id_pegawai
								 AND
								 arpt.id_kelas=ak_kelas.id
								 AND
								 arpt.id_pelajaran=ak_pelajaran.id
								 AND 
								 arpt.semester=sm.id
								 WHERE
								 arpt.id_sekolah=?
								 '.$cnd.'
								 '.$cnd2.'
								 AND arpt.id_pegawai=?
								 AND ak_kelas.publish=1
								 GROUP BY arpt.id DESC
								 LIMIT 15
								',array($this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['user_authentication']['id_pengguna']));
		
		//echo $this->db->last_query();


		//pr($query->result_array());
		//$pem['pembelajaran']=$datapemb2;
		return $query->result_array();
	}
	function getPertemuanByIdPegSemTaIdSek($id_pegawai=0,$semester=0,$ta=0,$id_sekolah=0){
		$query=$this->db->query('SELECT arpt.*,ap.nama as pegawai,sm.nama as semester,ak_kelas.kelas,ak_kelas.nama as nama_kelas, ak_pelajaran.nama as nama_pelajaran
								 FROM 
								 ak_rencana_pertemuan arpt  JOIN
								 ak_kelas JOIN
								 ak_pelajaran JOIN
								 ak_pegawai ap JOIN
								 ak_semester sm
								 ON
								 ap.id=arpt.id_pegawai
								 AND
								 arpt.id_kelas=ak_kelas.id
								 AND
								 arpt.id_pelajaran=ak_pelajaran.id
								 AND 
								 arpt.semester=sm.id
								 WHERE
								 arpt.id_sekolah=?
								 AND arpt.id_pegawai=?
								 AND arpt.semester=?
								 AND arpt.ta=?
								 AND ak_kelas.publish=1
								 GROUP BY arpt.id DESC
								 LIMIT 15
								',array($this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['user_authentication']['id_pengguna'],$semester,$ta));
		
		return $query->result_array();
	}
	function getPembelajaranByKelasPelajaranIdPegawai($id_pelajaran=0,$id_kelas=0,$id_pegawai=0){
		if($id_pegawai==0){
			$id_pegawai=$this->session->userdata['user_authentication']['id_pengguna'];
		}
		$cnd='';
		$cnd2='';
		if($id_pelajaran!=0){$cnd='AND arpt.id_pelajaran="'.mysql_real_escape_string($id_pelajaran).'"';}
		if($id_kelas!=0){$cnd2='AND arpt.id_kelas="'.mysql_real_escape_string($id_kelas).'"';}
		$query=$this->db->query('SELECT arpt.*,am.id as id_mengajar,ap.nama as pegawai,sm.nama as semester,ak_kelas.kelas,ak_kelas.nama as nama_kelas, ak_pelajaran.nama as nama_pelajaran
								 FROM 
								 ak_rencana_pertemuan arpt  JOIN
								 ak_kelas JOIN
								 ak_pelajaran JOIN
								 ak_pegawai ap JOIN
								 ak_semester sm JOIN 
								 ak_mengajar am
								 ON
								 ap.id=arpt.id_pegawai
								 AND
								 arpt.id_kelas=ak_kelas.id
								 AND
								 arpt.id_pelajaran=ak_pelajaran.id
								 AND 
								 arpt.semester=sm.id
								 AND am.id_pegawai = arpt.id_pegawai
								 AND am.id_pelajaran = arpt.id_pelajaran
								 AND am.id_kelas = arpt.id_kelas
								 WHERE
								 arpt.id_sekolah=?
								 '.$cnd.'
								 '.$cnd2.'
								 AND arpt.id_pegawai=?
								 AND ak_kelas.publish=1
								 ORDER BY arpt.id
								',array($this->session->userdata['user_authentication']['id_sekolah'],$id_pegawai));
		//echo $this->db->last_query();
		$in=array(-1);
		foreach($query->result_array() as $datapemb){
			$datapemb2[$datapemb['id']]=$datapemb;
			//$queryfile=$this->db->query('SELECT * FROM ak_rencana_pembelajaran_file WHERE id_rencana_pembelajaran="'.$datapemb['id'].'"');
			//$datapemb2[$datapemb['id']]['file']=$queryfile->result_array();
		}
		
		
		$pem['pembelajaran']=$datapemb2;
		return $pem;
	}
	function getPembelajaranByKelasPelajaranIdPegawaiIdPertemuan($id_pelajaran=0,$id_kelas=0,$id_pertemuan=0){
		$cnd='';
		$cnd2='';
		if($id_pelajaran!=0){$cnd='AND arpt.id_pelajaran="'.mysql_real_escape_string($id_pelajaran).'"';}
		if($id_kelas!=0){$cnd2='AND arpt.id_kelas="'.mysql_real_escape_string($id_kelas).'"';}
		$query=$this->db->query('SELECT arp.*,arpt.id_kelas,arpt.id_pelajaran,arpt.topik,arpt.waktu,arpt.pertemuan_ke,ap.nama as pegawai,sm.nama as semester,ak_kelas.kelas,ak_kelas.nama as nama_kelas, ak_pelajaran.nama as nama_pelajaran
								 FROM 
								 ak_rencana_pertemuan arpt  JOIN
								 ak_rencana_pembelajaran arp JOIN
								 ak_kelas JOIN
								 ak_pelajaran JOIN
								 ak_pegawai ap JOIN
								 ak_semester sm
								 ON
								 arp.id_pertemuan=arpt.id
								 AND
								 ap.id=arpt.id_pegawai
								 AND
								 arpt.id_kelas=ak_kelas.id
								 AND
								 arpt.id_pelajaran=ak_pelajaran.id
								 AND 
								 arpt.semester=sm.id
								 WHERE
								 arpt.id_sekolah=?
								 '.$cnd.'
								 '.$cnd2.'
								 AND arpt.id_pegawai=?
								 AND arp.id_pertemuan=?
								 AND ak_kelas.publish=1
								',array($this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['user_authentication']['id_pengguna'],$id_pertemuan));
		
		
		$in=array(-1);
		foreach($query->result_array() as $datapemb){
			$datapemb2[$datapemb['id']]=$datapemb;
			$queryfile=$this->db->query('SELECT * FROM ak_rencana_pembelajaran_file WHERE id_rencana_pembelajaran="'.$datapemb['id'].'"');
			$datapemb2[$datapemb['id']]['file']=$queryfile->result_array();
		}

		
		$pem['pembelajaran']=$datapemb2;
		return $pem;
	}
	function getPembelajaranById($id){
		$query=$this->db->query('SELECT arp.*
								 FROM ak_rencana_pembelajaran  arp JOIN
								 ak_rencana_pertemuan arpt
								 ON arp.id_pertemuan=arpt.id
								 WHERE
								 arpt.id_sekolah='.$this->session->userdata['user_authentication']['id_sekolah'].'
								 AND arpt.id_pegawai='.$this->session->userdata['user_authentication']['id_pengguna'].'
								 AND
								 arp.id="'.$id.'"
								');
		
		return $query->result_array();
	}
	function getPembelajaranByIdSekolah($id_sekolah){
		$query=$this->db->query('SELECT arpt.id_pegawai,arp.judul,arp.id
								 FROM ak_rencana_pembelajaran  arp JOIN
								 ak_rencana_pertemuan arpt
								 ON arp.id_pertemuan=arpt.id
								 WHERE
								 arpt.id_sekolah=?
								',array($id_sekolah));
		//echo $this->db->last_query();
		return $query->result_array();
	}
	function getPertemuanById($id){
		$query=$this->db->query('SELECT *
								 FROM ak_rencana_pertemuan  
								 WHERE
								 id="'.$id.'"
								');
		
		return $query->result_array();
	}

	function getIndikatorByPegSmTaSk($indikator='',$id_pelajaran=0,$id_mengjar=0,$id_kelas=0,$id_siswa_det_jenjang=0){
		$query=$this->db->query('SELECT *
								 FROM ak_rencana_indikator
								 WHERE
								 penilaian="'.$indikator.'"
								 AND id_sekolah=?
								 AND id_pelajaran="'.$id_pelajaran.'"
								 AND id_pegawai=?
								 AND semester=?
								 AND id_mengajar=?
								',array($this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['user_authentication']['id_pengguna'],$this->session->userdata['ak_setting']['semester'],$id_mengjar));
		//echo $this->db->last_query();
		$indikator=$query->result_array();
		foreach($indikator as $indikdata){
			$indikator2[$indikdata['id']]=$indikdata;
			$querypoint=$this->db->query('SELECT * FROM ak_rencana_point_indikator WHERE id_sekolah=? AND id_indikator=? AND id_pelajaran=? AND id_kelas=? AND id_siswa_det_jenjang=?',array($this->session->userdata['user_authentication']['id_sekolah'],$indikdata['id'],$id_pelajaran,$id_kelas,$id_siswa_det_jenjang));
			$indikator2[$indikdata['id']]['point']=$querypoint->result_array();
			
		}
		unset($indikator);
		return $indikator2;
	}
	function getPointIndikatorBySekPelJenKel($id_sekolah=0,$id_pelajaran=0,$id_det_jenjang=0,$id_kelas=0){
		$query=$this->db->query('SELECT *
								 FROM 
								 ak_rencana_point_indikator arpi
								 JOIN  ak_rencana_indikator ari
								 ON arpi.id_indikator=ari.id
								 WHERE arpi.id_sekolah=?
								 AND arpi.id_pelajaran=?
								 AND arpi.id_siswa_det_jenjang=?
								 AND arpi.id_kelas=?
								',array($this->session->userdata['user_authentication']['id_sekolah'],$id_pelajaran,$id_det_jenjang,$id_kelas));
		//echo $this->db->last_query();
		return $query->result_array();
	}
	function getPointIndikatorByPegSk($id_indikator=0,$id_kelas=0){
		$query=$this->db->query('SELECT *
								 FROM 
								 ak_rencana_point_indikator
								 WHERE id_sekolah=?
								 AND id_indikator=?
								 AND id_kelas=?
								',array($this->session->userdata['user_authentication']['id_sekolah'],$id_indikator,$id_kelas));
		//echo $this->db->last_query();
		return $query->result_array();
	}
	function getPointIndikatorByDetjenjangKlsPelSek($id_siswa_det_jenjang=0,$id_kelas=0,$id_pelajaran=0){
		$query=$this->db->query('SELECT arpi . * , arp.id_pelajaran
									FROM `ak_rencana_point_indikator` arpi
									JOIN ak_rencana_indikator arp ON arpi.id_indikator = arp.id
									WHERE arpi.`id_siswa_det_jenjang` =?
									AND arpi.id_kelas =?
									AND arp.id_pelajaran =?
									AND arpi.id_sekolah =?
									AND arp.semester =?
									',array($id_siswa_det_jenjang,$id_kelas,$id_pelajaran,$this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['ak_setting']['semester']));
		//echo $this->db->last_query();
		return $query->result_array();
	}
	function getNilaicurrent($id_siswa_det_jenjang=0,$id_pelajaran=0,$jenis){
		$query=$this->db->query('SELECT * FROM ak_nilai_'.$jenis.' 
								 WHERE 
								 id_siswa_det_jenjang=?
								 AND id_pelajaran=?
								 AND id_sekolah=?
								 AND semester=?
									',array($id_siswa_det_jenjang,$id_pelajaran,$this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['ak_setting']['semester']));
		//echo $this->db->last_query();
		return $query->result_array();
	}

	
 }
 