<?php
Class Ad_pengajaran extends CI_Model
{

	function getdataGuru(){
		
		$query=$this->db->query('SELECT ap.id as id, ap.nama FROM ak_mengajar am JOIN ak_pegawai ap ON am.id_pegawai=ap.id WHERE am.id_sekolah='.$this->session->userdata['user_authentication']['id_sekolah'].' GROUP BY ap.id ORDER BY ap.nama');
		//echo $this->db->last_query();
		return $query->result_array();
	}
	 function getFreePengajaran($id_mengajar=null,$id_sekolah=null){

		$table=array(
		  	'ak_harian',
		  	'ak_harian_det',
		  	'ak_jadwal',
		  	'ak_pr',
		  	'ak_pr_det',
		  	'ak_tugas',
		  	'ak_tugas_det',
		  	'ak_uas',
		  	'ak_uas_det',
		  	'ak_uts',
		  	'ak_uts_det'

		);
		foreach($table as $namatable){

			$q=$this->db->query('SELECT COUNT(*) AS count FROM '.$namatable.' WHERE id_mengajar='.$id_mengajar.'');

			$c=$q->result_array();
			//$out[$namatable]=$c;
			//echo $this->db->last_query();
			//pr($c);
			echo $namatable.'=>'.$c[0]['count'].'<br />';
			$out=$out+$c[0]['count'];
		}
		die();
		return $out;
	}
	function cekcurrentpengajaran($param=array()){
		$query=$this->db->query('SELECT COUNT(*) as cn FROM ak_mengajar WHERE
								 id_kelas='.$param['id_kelas'].' AND
								 id_sekolah ='.$this->session->userdata['user_authentication']['id_sekolah'].' AND
								 id_pegawai  ='.$param['id_pegawai'].' AND
								 id_pelajaran ='.$param['id_pelajaran'].'
		');
		//echo $this->db->last_query();
		$out=$query->result_array();
		$ret=$out[0]['cn'];
		
		return $ret;
	}
	function getdataByIdkelas($param=array()){
		$cond="";
		//pr($param);
		if(@$param['id_pegawai']!='' ){
			$cond .="AND mng.id_pegawai=".$param['id_pegawai']." ";
		}
		if(@$param['id_kelas']!='' ){
			$cond .="AND mng.id_kelas='".$param['id_kelas']."' ";
		}
		$query=$this->db->query('SELECT ak.nama,pg.id as id_pegawai, mng.id_kelas, mng.id_pelajaran, mng.id as id_pengajaran, pj.nama as nama_pelajaran , pg.nama as nama_guru, aj.nama as nama_jurusan, sm.nama as semester, pj.kelas FROM
									ak_mengajar mng
									JOIN ak_pegawai pg
									JOIN ak_pelajaran pj
									JOIN ak_kelas ak
									JOIN ak_jurusan aj
									JOIN ak_semester sm
									ON mng.id_pegawai=pg.id
									AND mng.id_pelajaran=pj.id
									AND pj.id_jurusan=aj.id
									AND pj.semester=sm.id
									AND mng.id_kelas=ak.id
									WHERE
									mng.id_sekolah='.$this->session->userdata['user_authentication']['id_sekolah'].'
									'.$cond.'
									AND ak.publish=1');
		//echo $this->db->last_query();
		return $query->result_array();
	}
	function getdata($param=array()){
		$cond="";
		if(@$param['id_pegawai']!='' ){
			$cond .="AND mng.id_pegawai=".$param['id_pegawai']." ";
		}
		$query=$this->db->query('SELECT  mng.id as id_mengajar,ak.nama,pg.id as id_pegawai, mng.id_kelas, mng.id_pelajaran, mng.id as id_pengajaran, pj.nama as nama_pelajaran , pg.nama as nama_guru, aj.nama as nama_jurusan, sm.nama as semester,sm.id as id_semester, pj.kelas FROM
									ak_mengajar mng
									JOIN ak_pegawai pg
									JOIN ak_pelajaran pj
									JOIN ak_kelas ak
									JOIN ak_jurusan aj
									JOIN ak_semester sm
									ON mng.id_pegawai=pg.id
									AND mng.id_pelajaran=pj.id
									AND pj.id_jurusan=aj.id
									AND pj.semester=sm.id
									AND mng.id_kelas=ak.id
									WHERE
									mng.id_sekolah='.$this->session->userdata['user_authentication']['id_sekolah'].'
									'.$cond.'
									AND ak.publish=1');
		//echo $this->db->last_query();
		return $query->result_array();
	}
	function getdataforindikator($param=array()){

		$query=$this->db->query('SELECT  mng.id as id_mengajar,ak.nama,pg.id as id_pegawai, mng.id_kelas, mng.id_pelajaran, mng.id as id_pengajaran, pj.nama as nama_pelajaran , pg.nama as nama_guru, aj.nama as nama_jurusan, sm.nama as semester, pj.kelas FROM
									ak_mengajar mng
									JOIN ak_pegawai pg
									JOIN ak_pelajaran pj
									JOIN ak_kelas ak
									JOIN ak_jurusan aj
									JOIN ak_semester sm
									ON mng.id_pegawai=pg.id
									AND mng.id_pelajaran=pj.id
									AND pj.id_jurusan=aj.id
									AND pj.semester=sm.id
									AND mng.id_kelas=ak.id
									WHERE
									mng.id_sekolah='.$this->session->userdata['user_authentication']['id_sekolah'].'
									AND sm.nama="ganjil"
									AND ak.publish=1');
		//echo $this->db->last_query();
		return $query->result_array();
	}
	function getdataById($id=0){
		$query=$this->db->query('SELECT mng.*,pj.kelas,pj.id_jurusan,pj.semester FROM ak_mengajar mng JOIN ak_pegawai pg JOIN ak_pelajaran pj ON mng.id_pegawai=pg.id AND mng.id_pelajaran=pj.id WHERE mng.id_sekolah='.$this->session->userdata['user_authentication']['id_sekolah'].' AND mng.id='.$id.'');
		return $query->result_array();
	}
}