<?php
Class Ad_pelajaran extends CI_Model
{

	function getdata($param=array()){
		$cond="";
		if(@$param['jenjang']!='' ){
			$cond="AND pl.kelas=".$param['jenjang']." ";
		}
		if(@$param['jenjang']!='' && @$param['id_jurusan']!=''){
			$cond .="AND pl.id_jurusan=".$param['id_jurusan']." ";
		}
		if(@$param['jenjang']!='' && @$param['id_jurusan']!='' && @$param['semester']!='' ){
			$cond .="AND pl.semester=".$param['semester']." ";
		}
		
		$query=$this->db->query('SELECT pl.*,jr.nama as nama_jurusan, sm.nama as nama_semester FROM ak_pelajaran pl JOIN ak_jurusan jr JOIN ak_semester sm ON pl.id_jurusan=jr.id AND pl.semester=sm.id  WHERE pl.id_sekolah='.$this->session->userdata['user_authentication']['id_sekolah'].'  '.$cond.'');
		//echo $this->db->last_query();
		return $query->result_array();
	}
	function getdataadminsub($param=array()){
		$cond="AND pl.id_parent=".$param['id_parent']."";
		if(@$param['jenjang']!='' ){
			$cond="AND pl.kelas=".$param['jenjang']." ";
		}
		if(@$param['jenjang']!='' && @$param['id_jurusan']!=''){
			$cond .="AND pl.id_jurusan=".$param['id_jurusan']." ";
		}
		if(@$param['jenjang']!='' && @$param['id_jurusan']!='' && @$param['semester']!='' ){
			$cond .="AND pl.semester=".$param['semester']." ";
		}
		
		$query=$this->db->query('SELECT pl.*,jr.nama as nama_jurusan, sm.nama as nama_semester FROM ak_pelajaran pl JOIN ak_jurusan jr JOIN ak_semester sm ON pl.id_jurusan=jr.id AND pl.semester=sm.id WHERE pl.id_sekolah='.$this->session->userdata['user_authentication']['id_sekolah'].'  '.$cond.' ORDER BY pl.nama ASC');
		return $query->result_array();
	}
	function getdataadmin($param=array()){
		$cond="";
		if(@$param['jenjang']!='' ){
			$cond="AND pl.kelas=".$param['jenjang']." ";
		}
		if(@$param['jenjang']!='' && @$param['id_jurusan']!=''){
			$cond .="AND pl.id_jurusan=".$param['id_jurusan']." ";
		}
		if(@$param['jenjang']!='' && @$param['id_jurusan']!='' && @$param['semester']!='' ){
			$cond .="AND pl.semester=".$param['semester']." ";
		}
		
		$query=$this->db->query('SELECT pl.*,jr.nama as nama_jurusan, sm.nama as nama_semester FROM ak_pelajaran pl JOIN ak_jurusan jr JOIN ak_semester sm ON pl.id_jurusan=jr.id AND pl.semester=sm.id WHERE pl.id_sekolah='.$this->session->userdata['user_authentication']['id_sekolah'].' AND pl.id_parent=0 '.$cond.' ORDER BY pl.nama ASC');
		//echo $this->db->last_query();
		return $query->result_array();
	}
	function getdatabySemesterJenjangJurusanKelas($sm=0,$kelas=0,$jur=0){
		$query=$this->db->query('SELECT pl.*,jr.nama as nama_jurusan FROM ak_pelajaran pl JOIN ak_jurusan jr ON pl.id_jurusan=jr.id WHERE pl.id_sekolah='.$this->session->userdata['user_authentication']['id_sekolah'].' AND pl.semester="'.$sm.'" AND pl.kelas="'.$kelas.'" AND pl.id_jurusan="'.$jur.'"');
		//echo $this->db->last_query();
		return $query->result_array();		
	}
	function getdatabySemesterJenjangJurusanKelasPegawaimengajar($sm=0,$kelas=0,$jur=0,$id_kelas=0,$id_penggunas=0){
		if($id_penggunas!=0){$id_pengguna=$id_penggunas;}else{$id_pengguna=$this->session->userdata['user_authentication']['id_pengguna'];}
		$query=$this->db->query('SELECT pl.*,jr.nama as nama_jurusan , am.id as id_mengajar
								FROM ak_pelajaran pl 
								JOIN ak_jurusan jr 
								JOIN ak_mengajar am
								ON pl.id_jurusan=jr.id 
								AND am.id_pelajaran=pl.id
								WHERE pl.id_sekolah='.$this->session->userdata['user_authentication']['id_sekolah'].' 
								AND pl.semester="'.$sm.'" 
								AND pl.kelas="'.$kelas.'" 
								AND pl.id_jurusan="'.$jur.'"
								AND am.id_pegawai="'.$id_pengguna.'"
								AND am.id_kelas="'.$id_kelas.'"
								
								');
		//echo $this->db->last_query();
		return $query->result_array();		
	}
	function getdatabySemesterJenjangJurusanPegawaimengajar(){
		$query=$this->db->query('SELECT pl.*,jr.nama as nama_jurusan
								FROM ak_pelajaran pl 
								JOIN ak_jurusan jr 
								JOIN ak_mengajar am
								ON pl.id_jurusan=jr.id 
								AND am.id_pelajaran=pl.id
								WHERE pl.id_sekolah='.$this->session->userdata['user_authentication']['id_sekolah'].' 
								AND pl.semester="'.$this->session->userdata['ak_setting']['semester'].'"
								AND am.id_pegawai="'.$this->session->userdata['user_authentication']['id_pengguna'].'"
								GROUP BY pl.id
								
								');
		//echo $this->db->last_query();
		return $query->result_array();		
	}
	
	function getFreePelajaran($id_pelajaran=null,$id_sekolah=null){
		
		$table=array(
				'ak_absensi', 	
				'ak_harian', 	
				'ak_materi_pelajaran',
				'ak_mengajar',
				'ak_nilai_afektif', 	
				'ak_nilai_kkm', 	
				'ak_nilai_kompetensi', 	
				'ak_nilai_lain_lain', 	
				'ak_nilai_pr', 	
				'ak_nilai_praktik', 	
				'ak_nilai_tugas', 	
				'ak_nilai_uan', 	
				'ak_nilai_uas', 	
				'ak_nilai_ulangan_harian', 	
				'ak_nilai_uts', 	
				'ak_pr',
				'ak_subject_nilai', 	
				'ak_timeline_pembelajaran', 	
				'ak_tugas', 	
				'ak_uas', 	
				'ak_uts'
		);
		foreach($table as $namatable){
			
			$q=$this->db->query('SELECT COUNT(*) AS count FROM '.$namatable.' WHERE id_pelajaran='.$id_pelajaran.'');
			$c=$q->result_array();
			//$out[$namatable]=$c;
			//echo $this->db->last_query();
			//pr($c);
			$out=$out+$c[0]['count'];
		}
		return $out;
	}
	function getdataByIdDetJenjang($id_det_jenjang=0){
		$query=$this->db->query('
								SELECT ap.id,ap.havechild,ap.nama,ank.nilai
								FROM `ak_pelajaran` ap
								JOIN ak_kelas ak
								JOIN ak_det_jenjang adj 
								JOIN ak_nilai_kkm ank
								ON ap.kelas = ak.kelas
								AND adj.id_kelas = ak.id
								AND ap.id=ank.id_pelajaran
								WHERE adj.id ='.$id_det_jenjang.'
								AND ap.id_sekolah='.$this->session->userdata['user_authentication']['id_sekolah'].'
								AND ap.semester='.$this->session->userdata['ak_setting']['semester'].'
								AND ap.id_parent=0
								AND ak.publish=1
		');
		//echo $this->db->last_query();
		return $query->result_array();
	}
	function getdataByIdDetJenjangByparentmapel($id_det_jenjang=0,$id_parentmapel=0){
		$query=$this->db->query('
								SELECT ap.id,ap.havechild,ap.nama,ank.nilai
								FROM `ak_pelajaran` ap
								JOIN ak_kelas ak
								JOIN ak_det_jenjang adj 
								JOIN ak_nilai_kkm ank
								ON ap.kelas = ak.kelas
								AND adj.id_kelas = ak.id
								AND ap.id=ank.id_pelajaran
								WHERE adj.id ='.$id_det_jenjang.'
								AND ap.id_sekolah='.$this->session->userdata['user_authentication']['id_sekolah'].'
								AND ap.semester='.$this->session->userdata['ak_setting']['semester'].'
								AND ap.id_parent='.$id_parentmapel.'
								AND ak.publish=1
		');
		//echo $this->db->last_query();
		return $query->result_array();
	}
	function getdataChild($id_parentmapel=0){
		$query=$this->db->query('
								SELECT * FROM ak_pelajaran ap
								WHERE 
								ap.id_sekolah='.$this->session->userdata['user_authentication']['id_sekolah'].'
								AND ap.semester='.$this->session->userdata['ak_setting']['semester'].'
								AND ap.id_parent='.$id_parentmapel.'
								
		');
		//echo $this->db->last_query();
		return $query->result_array();
	}
	function getdataById($id=0){
		
		$query=$this->db->query('SELECT pl.*,jr.nama as nama_jurusan FROM ak_pelajaran pl JOIN ak_jurusan jr ON pl.id_jurusan=jr.id WHERE pl.id_sekolah='.$this->session->userdata['user_authentication']['id_sekolah'].' AND pl.id='.$id.'');
		return $query->result_array();
	}
	function getdataByIdSekolah($id_sekolah){
		
		$query=$this->db->query('SELECT pl.*,jr.nama as nama_jurusan FROM ak_pelajaran pl JOIN ak_jurusan jr ON pl.id_jurusan=jr.id WHERE pl.id_sekolah='.$this->session->userdata['user_authentication']['id_sekolah'].' AND pl.id_sekolah='.$id_sekolah.'');
		return $query->result_array();
	}
	function getSelectedPelajaran(){
		$query=$this->db->query("
								SELECT ap.*
								FROM ak_jadwal aj
								JOIN ak_mengajar am
								JOIN ak_pelajaran ap ON aj.id_mengajar = am.id
								AND am.id_pelajaran = ap.id
								WHERE aj.id_kelas ='".@$_POST['id_kelas']."'
								AND aj.StartTime='".@$_POST['start']."' AND aj.EndTime='".@$_POST['end']."'
								");
		return $query->result_array();
	}
}