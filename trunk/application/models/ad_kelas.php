<?php
Class Ad_kelas extends CI_Model
{
 function thisjenjang($id=null){
	$query=$this->db->query('SELECT j.*,s.bentuk FROM users u JOIN ak_sekolah s JOIN ak_jenjang j ON u.id_sekolah=s.id AND j.id=s.id_jenjang WHERE u.id='.$id.'');
	//echo $this->db->last_query();
	return $query->result_array();
 }
 
 function getkelas($id_sekolah=null){
	if($id_sekolah!=null){
		$cond='AND k.id_sekolah='.$id_sekolah.'';
	}
	$query=$this->db->query('SELECT k.* FROM ak_kelas k JOIN ak_sekolah s ON k.id_sekolah=s.id WHERE 1 '.$cond.' AND k.publish=1 ORDER BY k.kelas,k.nama ASC');
	return $query->result_array();
	
 }
 function getdatanokelas(){
	$query=$this->db->query('SELECT k.* FROM ak_kelas k  WHERE  k.id_pegawai=0 AND k.id_jurusan=0 AND k.id_jenjang=0 AND k.id_sekolah=0 AND k.kelas=0 AND k.nama=""  AND k.publish=1');
	return $query->result_array();
	
 }
 function getKelasByIdWaliPeg($id_pegawai){
	$query=$this->db->query('SELECT * FROM ak_kelas WHERE id_pegawai=? AND id_sekolah=?',array($id_pegawai,$this->session->userdata['user_authentication']['id_sekolah']));
	return $query->result_array();	
 }
 function getnextkelaswali($id_sekolah,$id_kelas){
	$kelascurrent=$this->getkelasById($id_sekolah,$id_kelas);
	$kelascurrent[0]['status']='Tinggal Kelas';
	//pr($kelascurrent);
	$kelasnext=$kelascurrent[0]['kelas']+1;
	$query=$this->db->query('SELECT k.* FROM ak_kelas k WHERE k.id_sekolah='.$id_sekolah.' AND k.kelas='.$kelasnext.'  AND k.publish=1  ORDER BY k.kelas ASC');
	$kelasnext=$query->result_array();
	$kelasnext2=array();
	foreach($kelasnext as $ky=>$dtc){
		if($ky==0){
			$kelasnext2[$ky]=$dtc;
			$kelasnext2[$ky]['status']='Naik Kelas';
		}

	}
	$out=array_merge($kelasnext2,$kelascurrent);
	
	return $out;
 }
 function getnextkelas($id_sekolah,$id_kelas){
	$kelascurrent=$this->getkelasById($id_sekolah,$id_kelas);
	//pr($kelascurrent);
	$kelasnext=$kelascurrent[0]['kelas']+1;
	//$query=$this->db->query('SELECT k.* FROM ak_kelas k WHERE  k.kelas='.$kelasnext.' OR k.kelas='.$kelascurrent[0]['kelas'].' AND k.id_sekolah='.$id_sekolah.' GROUP BY k.id ORDER BY k.kelas ASC');
	$querycurrent=$this->db->query('SELECT k.* FROM ak_kelas k WHERE k.kelas='.$kelascurrent[0]['kelas'].' AND k.id_sekolah='.$id_sekolah.' GROUP BY k.id ORDER BY k.kelas ASC');
	$query=$this->db->query('SELECT k.* FROM ak_kelas k WHERE k.id_sekolah='.$id_sekolah.' AND k.kelas='.$kelasnext.'  AND k.publish=1 ORDER BY k.kelas ASC');
	//echo $this->db->last_query();
	$kls['current']=$querycurrent->result_array();
	$kls['next']=$query->result_array();
	return $kls;
 }
 function getKelasByWali($id_sekolah=null,$id_pengguna=null){
	$querypengguna=$this->db->query('SELECT k.* FROM
							 ak_kelas k 
							 JOIN ak_pegawai p
							 ON k.id_pegawai=p.id
							 WHERE k.id_sekolah='.$id_sekolah.' AND k.id_pegawai='.$id_pengguna.'  AND k.publish=1 ORDER BY k.kelas ASC');
	//echo $this->db->last_query();
	
	return $querypengguna->result_array();
 }
 function getWaliByIdKelas($id_sekolah=null,$id_kelas=null){
	$querypengguna=$this->db->query('SELECT p.nama,p.alamat,p.id FROM
							 ak_kelas k 
							 JOIN ak_pegawai p
							 ON 
							 k.id_pegawai=p.id
							 WHERE k.id_sekolah='.$id_sekolah.' AND k.id='.$id_kelas.' AND k.publish=1 ORDER BY k.kelas ASC');
	return $querypengguna->result_array();
 }
 function getkelasWali($id_sekolah=null,$id_pengguna=null){

	$kls2=array();
	
	$querypengguna=$this->db->query('SELECT k.* FROM
							 ak_kelas k 
							 JOIN ak_sekolah s
							 JOIN ak_pegawai p
							 ON k.id_sekolah=s.id 
							 AND k.id_pegawai=p.id
							 WHERE k.id_sekolah='.$id_sekolah.' AND k.id_pegawai='.$id_pengguna.' AND k.publish=1 ORDER BY k.kelas ASC');
	$klspengguna= $querypengguna->result_array();
	$query=$this->db->query('SELECT * FROM ak_kelas WHERE id NOT IN(SELECT k.id FROM
							 ak_kelas k 
							 JOIN ak_sekolah s
							 JOIN ak_pegawai p
							 ON k.id_sekolah=s.id 
							 AND k.id_pegawai=p.id
							 WHERE k.id_sekolah='.$id_sekolah.' AND k.publish=1 ORDER BY k.kelas ASC) AND id_sekolah='.$id_sekolah.' AND publish=1');
	$kls= $query->result_array();
	//echo $this->db->last_query();
	$klsx=array_merge($klspengguna,$kls);
	foreach($klsx as $datakls){
		$kls2[$datakls['kelas'].$datakls['nama']]=$datakls;
	}
	$out['current']=$klspengguna;
	$out['array']=$kls2;
	return $out;
	
 }
 function getkelasIdIset($id_sekolah=null){
	if($id_sekolah!=null){
		$cond='AND k.id_sekolah='.$id_sekolah.'';
	}
	$kls2=array();
	$query=$this->db->query('SELECT k.* FROM ak_kelas k JOIN ak_sekolah s ON k.id_sekolah=s.id WHERE 1 '.$cond.' AND k.publish=1 ORDER BY k.kelas ASC');
	$kls= $query->result_array();
	foreach($kls as $datakls){
		$kls2[$datakls['kelas']]=$datakls;
	}
	return $kls2;
	
 }
 function getJenjangByIdKelas($id_kelas){
	$query=$this->db->query('SELECT ak.*, aj.*,ak.nama as nama_kelas FROM ak_kelas ak JOIN ak_jenjang aj ON ak.id_jenjang=aj.id WHERE ak.id='.$id_kelas.' AND ak.publish=1');
	//echo $this->db->last_query();
	return $query->result_array();	
 }
 function getkelasByPengajar($id_sekolah=null,$id_pegawai=null){
	$query=$this->db->query('SELECT ak.* FROM
							ak_kelas ak
							JOIN ak_mengajar am
							ON
							ak.id=am.id_kelas
							WHERE 
							am.id_pegawai='.$id_pegawai.'
							AND ak.id_sekolah='.$id_sekolah.'
							 AND ak.publish=1
							GROUP BY ak.id
	');
	//echo $this->db->last_query();
	return $query->result_array();
 }
 function getkelasByIdDetjenjang($id_sekolah=null,$id_det_jenjang=null){
	$query=$this->db->query('SELECT ak.* FROM
							ak_kelas ak
							JOIN ak_det_jenjang adj
							ON
							ak.id=adj.id_kelas
							WHERE 
							adj.id='.$id_det_jenjang.'
							AND ak.id_sekolah='.$id_sekolah.'
							 AND ak.publish=1
							GROUP BY ak.id
	');
	//echo $this->db->last_query();
	return $query->result_array();
 }
 function getkelasByPengajarAllkelas($id_sekolah=null,$id_pegawai=null){
	$query=$this->db->query('SELECT ak.* FROM
							ak_kelas ak
							JOIN ak_pelajaran ap
							JOIN ak_mengajar am
							ON
							ap.kelas=ak.kelas
							AND am.id_pelajaran=ap.id
							WHERE 
							am.id_pegawai='.$id_pegawai.'
							AND ak.id_sekolah='.$id_sekolah.'
							 AND ak.publish=1
							GROUP BY ak.id
	');
	//echo $this->db->last_query();
	return $query->result_array();
 }
 function getFreeKelas($id_kelas=null,$id_sekolah=null){
	$table=array(
				'ak_absensi',
				'ak_catatanguru',
				'ak_det_jenjang',
				'ak_det_materi',
				'ak_harian_det',
				'ak_harian_det_remidial',
				'ak_jadwal',
				'ak_jurnal_wali',
				'ak_materi_kirim',
				'ak_pr',
				'ak_pr_det',
				'ak_pr_det_remidial',
				'ak_prestasi',
				'ak_subject_nilai',
				'ak_timeline_pembelajaran',
				'ak_tugas',
				'ak_tugas_det',
				'ak_tugas_det_remidial',
				'ak_uas_det',
				'ak_uas_det_remidial',
				'ak_uts_det',
				'ak_uts_det_remidial',
				'ak_siswa'
	);
	foreach($table as $namatable){
		if($namatable=='ak_siswa'){
			$q=$this->db->query('SELECT COUNT(*) AS count FROM '.$namatable.' WHERE IDkel='.$id_kelas.'');
		}else{
			$q=$this->db->query('SELECT COUNT(*) AS count FROM '.$namatable.' WHERE id_kelas='.$id_kelas.'');
		}
		$c=$q->result_array();
		//$out[$namatable]=$c;
		//echo $this->db->last_query();
		//echo $namatable.'====';
		//echo $c[0]['count']."<br />";
		$out=$out+$c[0]['count'];
	}
	return $out;
 }
 function getkelasById($id_sekolah=null,$id_kelas=null){
	if($id_sekolah!=null){
		$cond='AND k.id_sekolah='.mysql_real_escape_string($id_sekolah).'';
	}
	if($id_kelas!=null){
		$cond='AND k.id_sekolah='.mysql_real_escape_string($id_sekolah).' AND k.id='.mysql_real_escape_string($id_kelas).'';
	}
	$query=$this->db->query('SELECT k.* FROM ak_kelas k JOIN ak_sekolah s ON k.id_sekolah=s.id WHERE 1 '.$cond.' AND k.publish=1 ORDER BY k.kelas ASC');
	return $query->result_array();
	
 }
 
 function getkelasByKelas($kelas,$id_sekolah){
		$kelas=$this->db->query('SELECT k.* FROM ak_kelas k  WHERE k.kelas=? AND k.id_sekolah=? AND k.publish=1 ORDER BY k.kelas ASC',array($kelas,$id_sekolah))->result_array();
		return $kelas;
	
 }
 function getWaliKelas($id_sekolah){
		$kelas=$this->db->query('SELECT p.id,p.nama FROM ak_pegawai p JOIN
								users u
								ON p.id=u.id_pengguna
								WHERE 
								p.id_sekolah=? 
								AND u.id_group=13
								ORDER BY p.nama  ASC
								',array($id_sekolah))->result_array();
		return $kelas;
	
 }
 function getWaliKelasByIdKelas($id_kelas){
		$kelas=$this->db->query('SELECT * FROM ak_kelas  k JOIN ak_pegawai p ON k.id_pegawai=p.id WHERE k.id=? AND k.id_sekolah=?
								',array($id_kelas,$this->session->userdata['user_authentication']['id_sekolah']))->result_array();
		return $kelas;
	
 }
 function getkelasByKelasSelect($kelas,$id_sekolah){
		$kelas=$this->db->query('SELECT k.* FROM ak_kelas k  WHERE k.kelas=? AND k.id_sekolah=? AND k.publish=1 ORDER BY k.kelas ASC',array($kelas,$id_sekolah))->result_array();

		echo "<option value=''>Pilih Kelas</option>";
		foreach($kelas as $selectpel){
			if(@$_POST['id_pelajaran']==$selectpel['id']){ $slctd='selected';}else{ $slctd=''; }
			echo "<option ".$slctd." value='".$selectpel['id']."'>".$selectpel['kelas']." ".$selectpel['nama']."</option>";
		}

		die();
	
 }
 function getKelasByPelajaranMengajar($id_pelajaran=0,$id_sekolah=0,$semester=0,$id_pegawai=0){
		$kelas=$this->db->query('SELECT k.*,m.id as id_mengajar FROM 
								ak_kelas k  
								JOIN ak_pelajaran p 
								JOIN ak_mengajar m 
								ON 
								k.kelas=p.kelas 
								AND m.id_pelajaran=p.id 
								WHERE 
								p.id=?
								AND k.id_sekolah=? 
								AND p.semester=? 
								AND m.id_pegawai=? 
								AND m.id_kelas=k.id 
								AND k.id_jurusan=p.id_jurusan
								GROUP BY k.id',array($id_pelajaran,$id_sekolah,$semester,$id_pegawai))->result_array();
		return $kelas;

 }
 function getAllKelas($id_sekolah){
		$kelas=$this->db->query('SELECT k.* FROM ak_kelas k  WHERE  k.id_sekolah=? AND k.publish=1 ORDER BY k.kelas ASC',array($id_sekolah))->result_array();

		echo "<option value=''>Pilih Kelas</option>";
		foreach($kelas as $selectpel){
			if(@$_POST['id_pelajaran']==$selectpel['id']){ $slctd='selected';}else{ $slctd=''; }
			echo "<option ".$slctd." value='".$selectpel['id']."'>".$selectpel['kelas']." ".$selectpel['nama']."</option>";
		}

		die();
	
 }
 
}