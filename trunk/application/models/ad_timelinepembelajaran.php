<?php
Class Ad_timelinepembelajaran extends CI_Model{

	function getFilePembById_pemb($id_pemb){
		$query=$this->db->query('SELECT * FROM ak_timeline_pembelajaran_file 
								WHERE
								id_timeline_pembelajaran="'.$id_pemb.'"
								');
		
		return $query->result_array();	
	}
	function getFileTimeById_time($id_time){
		$query=$this->db->query('SELECT * FROM ak_timeline_pembelajaran_file 
								WHERE
								id_timeline_pembelajaran="'.$id_time.'"
								');
		
		return $query->result_array();	
	}
	function getFilePembById($id){
		$query=$this->db->query('SELECT * FROM ak_timeline_pembelajaran_file 
								WHERE
								id="'.$id.'"
								');
		
		return $query->result_array();	
	}
	function gettimelinepembelajaranByKelasPelajaranIdPegawai($id_pelajaran=0,$id_kelas=0){
		$cnd='';
		$cnd2='';
		if($id_pelajaran!=0){$cnd='AND arp.id_pelajaran="'.mysql_real_escape_string($id_pelajaran).'"';}
		if($id_kelas!=0){$cnd2='AND arp.id_kelas="'.mysql_real_escape_string($id_kelas).'"';}
		$query=$this->db->query('SELECT arp.*,sm.nama as semester,ak_kelas.kelas,ak_kelas.nama as nama_kelas, ak_pelajaran.nama as nama_pelajaran
								 FROM ak_timeline_pembelajaran arp JOIN
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
								 arp.id_sekolah=?
								 '.$cnd.'
								 '.$cnd2.'
								 AND arp.id_pegawai=?
								 AND ak_kelas.publish=1
								 GROUP BY arp.id DESC
								 LIMIT 15 
								',array($this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['user_authentication']['id_pengguna']));
		
		
		$in=array(-1);
		$datapemb2=array();
		foreach($query->result_array() as $datapemb){
			$datapemb2[$datapemb['id']]=$datapemb;
			$queryfile=$this->db->query('SELECT * FROM ak_timeline_pembelajaran_file WHERE id_timeline_pembelajaran="'.$datapemb['id'].'"');
			$datapemb2[$datapemb['id']]['file']=$queryfile->result_array();
		}

		
		$pem['timelinepembelajaran']=$datapemb2;
		return $pem;
	}
	function gettimelinepembelajaranById($id){
		$query=$this->db->query('SELECT *
								 FROM ak_timeline_pembelajaran  
								 WHERE
								 id_sekolah='.$this->session->userdata['user_authentication']['id_sekolah'].'
								 AND id_pegawai='.$this->session->userdata['user_authentication']['id_pengguna'].'
								 AND
								 id="'.$id.'"
								');
		
		return $query->result_array();
	}
	
	
 }
 