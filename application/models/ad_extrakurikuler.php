<?php
Class Ad_extrakurikuler extends CI_Model
{
	 function getdataSiswaExtra(){
		$qcurrentextra=$this->db->query('SELECT ase.* FROM ak_siswa_ekstrakurikuler ase JOIN ak_det_jenjang ad JOIN ak_siswa siswa JOIN ak_kelas ak ON ase.id_siswa_det_jenjang=ad.id AND ad.id_kelas=ak.id AND ad.id_siswa=siswa.id WHERE ad.id_kelas='.$_POST['id_kelas'].' AND ase.id_ekstrakurikuler="'.$_POST['id_extrakurikuler'].'" AND ak.publish=1');
		//echo $this->db->last_query();
		return $qcurrentextra->result_array();
	 }
	 function getEkstrakurikulerByIdDetjenjang($id_det_jenjang){
		$qcurrentextra=$this->db->query('SELECT ae.* FROM ak_siswa_ekstrakurikuler ase JOIN ak_extrakurikuler ae  ON ase.id_ekstrakurikuler=ae.id AND ase.id_siswa_det_jenjang='.$id_det_jenjang.'   WHERE ase.id_siswa_det_jenjang='.$id_det_jenjang.' AND  ase.ta='.$this->session->userdata['ak_setting']['ta'].' AND ase.id_semester='.$this->session->userdata['ak_setting']['semester'].'');
		//echo $this->db->last_query();
		$xx=$qcurrentextra->result_array();
		$xx2=array();
		foreach($xx as $idx=>$dtx){
			$xx2[$dtx['id']]=$dtx;
		}
		return $xx2;
	 }
	 function getNilaiByidDetJenjang($id_det_jenjang){
		$qcurrentextra=$this->db->query('SELECT ane.*,ae.nama as nama_ekstra FROM ak_nilai_ekstrakurikuler ane JOIN ak_extrakurikuler ae ON ane.id_ekstrakurikuler=ae.id WHERE ane.ta='.$this->session->userdata['ak_setting']['ta'].' AND ane.semester='.$this->session->userdata['ak_setting']['semester'].' AND ane.id_siswa_det_jenjang='.$id_det_jenjang.'');
		$xx=$qcurrentextra->result_array();
		//echo $this->db->last_query();
		$xx2=array();
		
		foreach($xx as $idx=>$dtx){
			$xx2[$dtx['id_siswa_det_jenjang']][$dtx['id_ekstrakurikuler']]=$dtx;
		}
		return $xx2;
	 }
	 function getNilaiByKelas($id_kelas){
		$qcurrentextra=$this->db->query('SELECT ane.* FROM ak_nilai_ekstrakurikuler ane JOIN ak_det_jenjang ad ON ane.id_siswa_det_jenjang=ad.id WHERE ane.ta='.$this->session->userdata['ak_setting']['ta'].' AND ane.semester='.$this->session->userdata['ak_setting']['semester'].' AND ad.id_kelas='.$id_kelas.'');
		$xx=$qcurrentextra->result_array();
		$xx2=array();
		
		foreach($xx as $idx=>$dtx){
			$xx2[$dtx['id_siswa_det_jenjang']][$dtx['id_ekstrakurikuler']]=$dtx;
		}
		return $xx2;
	 }
	 function getNilaiByIdEkstra($id_ekstra){
		$qcurrentextra=$this->db->query('SELECT ane.* FROM ak_nilai_ekstrakurikuler ane JOIN ak_det_jenjang ad ON ane.id_siswa_det_jenjang=ad.id WHERE ane.ta='.$this->session->userdata['ak_setting']['ta'].' AND ane.semester='.$this->session->userdata['ak_setting']['semester'].' AND ane.id_ekstrakurikuler='.$id_ekstra.'');
		$xx=$qcurrentextra->result_array();
		$xx2=array();
		//echo $this->db->last_query();
		foreach($xx as $idx=>$dtx){
			$xx2[$dtx['id_siswa_det_jenjang']][$dtx['id_ekstrakurikuler']]=$dtx;
		}
		return $xx2;
	 }
	 
	 function getEkstrakurikulerByIdKelas($id_kelas){
		$siswakelasq=$this->db->query('SELECT adj.*,siswa.nama,siswa.nis FROM ak_siswa siswa  JOIN ak_det_jenjang adj JOIN ak_siswa_ekstrakurikuler ase ON siswa.id=adj.id_siswa AND ase.id_siswa_det_jenjang=adj.id WHERE adj.id_kelas='.$id_kelas.'');
		$siswakelas=$siswakelasq->result_array();
		$siswa=array();
		foreach($siswakelas as $dataadj){
			$siswa[$dataadj['id']]['siswa']=$dataadj;
			$siswa[$dataadj['id']]['ekstra']=$this->getEkstrakurikulerByIdDetjenjang($dataadj['id']);
		}
		//pr($siswa);
		return $siswa;
	 }
	 function getEkstrakurikulerById($id_ekstra){
		$siswakelasq=$this->db->query('SELECT adj.*,siswa.nama,siswa.nis,kel.nama as nama_kelas, kel.kelas FROM ak_siswa siswa  JOIN ak_det_jenjang adj JOIN ak_siswa_ekstrakurikuler ase JOIN ak_kelas kel ON siswa.id=adj.id_siswa AND ase.id_siswa_det_jenjang=adj.id AND kel.id=adj.id_kelas WHERE ase.id_ekstrakurikuler='.$id_ekstra.' AND kel.publish=1');
		//echo $this->db->last_query();
		$siswakelas=$siswakelasq->result_array();
		$siswa=array();
		foreach($siswakelas as $dataadj){
			$siswa[$dataadj['id']]['siswa']=$dataadj;
			$siswa[$dataadj['id']]['ekstra']=$this->getEkstrakurikulerByIdDetjenjang($dataadj['id']);
			//pr($siswakelas);
		}
		
		return $siswa;
	 }
	 function getEkstrakurikulerById_seri($id_ekstra){
		$siswakelasq=$this->db->query('SELECT adj.*,siswa.nama,siswa.nis,kel.nama as nama_kelas, kel.kelas ,ase.id_ekstrakurikuler FROM ak_siswa siswa  JOIN ak_det_jenjang adj JOIN ak_siswa_ekstrakurikuler ase JOIN ak_kelas kel ON siswa.id=adj.id_siswa AND ase.id_siswa_det_jenjang=adj.id AND kel.id=adj.id_kelas WHERE ase.id_ekstrakurikuler='.$id_ekstra.'  AND ase.id_sekolah='.$this->session->userdata['user_authentication']['id_sekolah'].' AND kel.publish=1');
		//echo $this->db->last_query();
		$siswakelas=$siswakelasq->result_array();
		return $siswakelas;
	 }
	 function getEkstrakurikulerById_seriIdkelas($id_ekstra,$id_kelas){
		$siswakelasq=$this->db->query('SELECT adj.*,siswa.nama,siswa.nis,kel.nama as nama_kelas, kel.kelas ,ase.id_ekstrakurikuler FROM ak_siswa siswa  JOIN ak_det_jenjang adj JOIN ak_siswa_ekstrakurikuler ase JOIN ak_kelas kel ON siswa.id=adj.id_siswa AND ase.id_siswa_det_jenjang=adj.id AND kel.id=adj.id_kelas WHERE ase.id_ekstrakurikuler='.$id_ekstra.'  AND adj.id_kelas='.$id_kelas.' AND adj.id_ta='.$this->session->userdata['ak_setting']['ta'].' AND ase.id_sekolah='.$this->session->userdata['user_authentication']['id_sekolah'].'  AND ase.id_semester='.$this->session->userdata['ak_setting']['semester'].'  AND kel.publish=1');
		//echo $this->db->last_query();
		$siswakelas=$siswakelasq->result_array();
		return $siswakelas;
	 }
	 function getdata(){
		$query=$this->db->query('SELECT ax.*, ap.id as id_pegawai, ap.nama as nama_pegawai FROM ak_extrakurikuler ax JOIN ak_pegawai ap ON ax.id_pegawai=ap.id WHERE ax.id_sekolah='.$this->session->userdata['user_authentication']['id_sekolah'].'');
		//echo $this->db->last_query();
		return $query->result_array();
	 }
	 function getdataByPegawai(){
		$query=$this->db->query('SELECT ax.*, ap.id as id_pegawai, ap.nama as nama_pegawai FROM ak_extrakurikuler ax JOIN ak_pegawai ap ON ax.id_pegawai=ap.id WHERE ax.id_sekolah='.$this->session->userdata['user_authentication']['id_sekolah'].' AND ax.id_pegawai='.$this->session->userdata['user_authentication']['id_pengguna'].'');
		//echo $this->db->last_query();
		return $query->result_array();
	 }
	 
	 function getGuru(){
		$query=$this->db->query('SELECT ap.* FROM 
								ak_pegawai ap 
								JOIN users u 
								JOIN det_group dg
								ON 
								ap.id=u.id_pengguna
								AND dg.id_user=u.id
								WHERE ap.id_sekolah='.$this->session->userdata['user_authentication']['id_sekolah'].'
								AND dg.id_group=20
								AND u.aktif=1
								');
		
		return $query->result_array();
	 }
	function getFreeEkstrakurikuler($id_kelas=null,$id_sekolah=null){
		$table=array(
					'ak_nilai_ekstrakurikuler',
					'ak_siswa_ekstrakurikuler'
		);
		foreach($table as $namatable){
			$q=$this->db->query('SELECT COUNT(*) AS count FROM '.$namatable.' WHERE id_ekstrakurikuler='.$id_kelas.'');
			$c=$q->result_array();
			//$out[$namatable]=$c;
			//echo $this->db->last_query();
			//pr($c);
			$out=$out+$c[0]['count'];
		}
		return $out;
	}
}