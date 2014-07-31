<?php
Class Ad_setting extends CI_Model
{
 function getSemester($id_sekolah=null){
	$query=$this->db->query('SELECT * FROM ak_semester WHERE id_sekolah='.$id_sekolah.'');
	return $query->result_array();		
 }
 function getSemesterAktif($id_sekolah=null){
	
 }
 function getTa($id_sekolah=null){
	$query=$this->db->query('SELECT * FROM ak_tahun_ajaran WHERE id_sekolah='.$id_sekolah.' ORDER BY nama');
	return $query->result_array();	
 }
 function getTaAktif($id_sekolah=null){
	
	
 }

 function getNextTa($id_ta=null){
	$queryta=$this->db->query("SELECT * FROM ak_tahun_ajaran WHERE id=".$id_ta."");
	$ta_sekarang=$queryta->result_array();
	//pr($ta_sekarang);
	$query=$this->db->query("SELECT * FROM ak_tahun_ajaran WHERE nama > '".$ta_sekarang[0]['nama']."' AND id_sekolah=".$ta_sekarang[0]['id_sekolah']." ORDER BY id LIMIT 1 ;");
	//pr($query->result_array());
	return $query->result_array();
 }
 function getTaSemesterAktif($id_sekolah=null){
	$query=$this->db->query('SELECT * FROM ak_semester WHERE aktif=1 AND id_sekolah='.$id_sekolah.'');
	$semester= $query->result_array();	
	$query2=$this->db->query('SELECT * FROM ak_tahun_ajaran WHERE aktif=1 AND  id_sekolah='.$id_sekolah.'');
	$ta= $query2->result_array();	
	$set['semester']=@$semester[0];
	$set['ta']=@$ta[0];
	return $set;
 }
  function getSetting($key=null, $id_sekolah=null){
	$query=$this->db->query('SELECT * FROM ak_setting WHERE id_sekolah='.$id_sekolah.' AND `key`="'.$key.'_'.$id_sekolah.'"');
	$data= $query->result_array();	
	return $data;	
 }
  function getAspek($id_sekolah=null){
	$query=$this->db->query('SELECT * FROM ak_aspek_kepribadian WHERE id_sekolah='.$id_sekolah.'');
	$data= $query->result_array();	
	return $data;	
 }
 function getDataStepRegistrasi($id_sekolah=null){
	$query=$this->db->query('SELECT * FROM ak_step_registrasi WHERE id_sekolah='.$id_sekolah.'');
	$data= $query->result_array();	
	return $data;
 }
  function getFreeAspek($id_aspek=null,$id_sekolah=null){
	$table=array('ak_catatanguru');
	foreach($table as $namatable){
			$q=$this->db->query('SELECT COUNT(*) AS count FROM '.$namatable.' WHERE id_aspek_kepribadian='.$id_aspek.'');
		$c=$q->result_array();
		//$out[$namatable]=$c;
		//echo $this->db->last_query();
		//pr($c);
		$out=$out+$c[0]['count'];
	}
	return $out;
 }
}