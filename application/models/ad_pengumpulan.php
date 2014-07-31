<?php
Class Ad_pengumpulan extends CI_Model
{
 function getdataSubjectByIdReferensi($id_referensi=null)
 {
	
	$query=$this->db->query('
		SELECT * FROM ak_subject_nilai WHERE id_referensi=?
	',array($id_referensi));
	$result=$query->result_array();
	return $result;
 }
 function getdataByIdkelas($id_kelas=null,$id_sekolah=null,$jenis='',$id=null,$id_pelajaran=null)
 {
	
	$query=$this->db->query('
		SELECT peng.*,sis.nama,adj.id as id_det_jenjang FROM 
			ak_pengumpulan_'.$jenis.' peng 
			JOIN ak_'.$jenis.' jns
			JOIN ak_siswa sis
			JOIN ak_det_jenjang adj
			ON peng.id_'.$jenis.'=jns.id
			AND sis.id=peng.id_siswa
			AND sis.id=adj.id_siswa
			WHERE
			jns.id_sekolah='.$id_sekolah.'
			AND peng.id_kelas='.$id_kelas.'
			AND jns.id_pelajaran='.$id_pelajaran.'
			AND peng.id_'.$jenis.'='.$id.'
			AND adj.id_ta='.$this->session->userdata['ak_setting']['ta'].'
			AND jns.semester='.$this->session->userdata['ak_setting']['semester'].'
	');
	$result=$query->result_array();
	return $result;
 }
 function getdataByIdJenis($id_jenis=null,$id_sekolah=null,$jenis='')
 {
	$query=$this->db->query('
							SELECT * FROM ak_pengumpulan_'.$jenis.' WHERE id_'.$jenis.'='.$id_jenis.' AND id_sekolah='.$id_sekolah.'
	');
	$result=$query->result_array();
	return $result;
 }
 function getdataReferensiById($id_referensi,$jenis){
	$query=$this->db->query('
		SELECT * FROM ak_'.$jenis.' WHERE id='.$id_referensi.'
	');
	$result=$query->result_array();
	return $result;
 }
 function getdataById($id=0,$jenis='')
 {
	$query=$this->db->query('
							SELECT * FROM ak_pengumpulan_'.$jenis.' WHERE id='.$id.'
	');
	$result=$query->result_array();
	return $result;
 }
 	function getsiswaRemidi($id_kelas,$id=0,$jenis=''){
		//echo $jenis;
		$query=$this->db->query('SELECT asis.nama,asis.nis FROM ak_'.$jenis.'_det_remidial apdr 
									JOIN ak_siswa asis
									JOIN ak_det_jenjang adj
									ON
									apdr.id_siswa_det_jenjang=adj.id
									AND
									adj.id_siswa=asis.id
									WHERE apdr.id_kelas='.$id_kelas.'
									AND
									apdr.id_'.$jenis.'='.$id.'
								');					
		//echo $this->db->last_query();
		return $query->result_array();
	}
}
?>