<?php
Class Ad_nilaikepribadian extends CI_Model
{	 
	 function getdataByKelas($id_kelas){
		$query=$this->db->query('SELECT * FROM ak_aspek_kepribadian aks JOIN ak_det_jenjang adj ON aks.id_siswa_det_jenjang=adj.id WHERE adj.id_kelas='.$id_kelas.'');
		//echo $this->db->last_query();
		return $query->result_array();
	 }
	 function getNilaiByidDetJenjang($id_det_jenjang){
		$qcurrentextra=$this->db->query('SELECT ane.*,ae.nama as nama_kegiatan FROM ak_nilai_kepribadian ane JOIN ak_aspek_kepribadian ae ON ane.id_aspek_kepribaian=ae.id WHERE ane.ta='.$this->session->userdata['ak_setting']['ta'].' AND ane.semester='.$this->session->userdata['ak_setting']['semester'].' AND ane.id_siswa_det_jenjang='.$id_det_jenjang.'');
		$xx=$qcurrentextra->result_array();
		$xx2=array();
		
		foreach($xx as $idx=>$dtx){
			$xx2[$dtx['id_siswa_det_jenjang']][$dtx['id_aspek_kepribaian']]=$dtx;
		}
		return $xx2;
	 }
	 function getNilaiByKelas($id_kelas){
		$qcurrentextra=$this->db->query('SELECT ane.* FROM ak_nilai_kepribadian ane JOIN ak_det_jenjang ad ON ane.id_siswa_det_jenjang=ad.id WHERE ane.ta='.$this->session->userdata['ak_setting']['ta'].' AND ane.semester='.$this->session->userdata['ak_setting']['semester'].' AND ad.id_kelas='.$id_kelas.'');
		$xx=$qcurrentextra->result_array();
		$xx2=array();
		//pr($xx);
		foreach($xx as $idx=>$dtx){
			$xx2[$dtx['id_siswa_det_jenjang']][$dtx['id_aspek_kepribaian']]=$dtx;
		}
		return $xx2;
	 }
	 function getdata(){
		$query=$this->db->query('SELECT * FROM ak_aspek_kepribadian WHERE id_sekolah='.$this->session->userdata['user_authentication']['id_sekolah'].'');
		$xx=$query->result_array();
		echo $this->db->last_query();
		$xx2=array();
		foreach($xx as $idx=>$dtx){
			$xx2[$dtx['id']]=$dtx;
		}
		return $xx2;
		
	 }
	 function getKegiatanByIdDetjenjang($id_det_jenjang){
		$qcurrentextra=$this->db->query('SELECT ae.* FROM  ak_extrakurikuler ae  ON ase.id_siswa_det_jenjang='.$id_det_jenjang.'  

										 WHERE ase.id_siswa_det_jenjang='.$id_det_jenjang.' AND  ase.ta='.$this->session->userdata['ak_setting']['ta'].' AND ase.id_semester='.$this->session->userdata['ak_setting']['semester'].'');
		$xx=$qcurrentextra->result_array();
		$xx2=array();
		foreach($xx as $idx=>$dtx){
			$xx2[$dtx['id']]=$dtx;
		}
		return $xx2;
	 }
	 function getSiswaByIdKelas($id_kelas){
		$siswakelasq=$this->db->query('SELECT adj.*,siswa.nama,siswa.nis FROM ak_siswa siswa  JOIN ak_det_jenjang adj  ON siswa.id=adj.id_siswa WHERE adj.id_kelas='.$id_kelas.' AND adj.id_ta='.$this->session->userdata['ak_setting']['ta'].'');
		$siswakelas=$siswakelasq->result_array();
		return $siswakelas;
	 }
}