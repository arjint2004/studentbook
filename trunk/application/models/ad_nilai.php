<?php
Class Ad_nilai extends CI_Model{

	function getJenisForSubject($jenis=null,$remidijenis=''){
		$query=$this->db->query('SELECT * FROM ak_'.base64_decode($jenis).'								
								 WHERE jenis="'.$remidijenis.'"
								 AND id_pegawai='.$this->session->userdata['user_authentication']['id_pengguna'].'
								 AND id_sekolah='.$this->session->userdata['user_authentication']['id_sekolah'].'
								 AND ta='.$this->session->userdata['ak_setting']['ta'].'
								 AND semester='.$this->session->userdata['ak_setting']['semester'].'
								');
		return $query->result_array();		
	}
	function getNilaiBySubjectTaSm($id_subject=null,$jenis=null){
		$table=str_replace(' ','_',$jenis);
		$query=$this->db->query('SELECT * FROM ak_'.$table.' 
								WHERE id_sekolah='.$this->session->userdata['user_authentication']['id_sekolah'].'
								AND ta='.$this->session->userdata['ak_setting']['ta'].'
								AND semester='.$this->session->userdata['ak_setting']['semester'].'
								AND id_subject='.$id_subject.'
								
								');
		return $query->result_array();		
	}
	function ifinsertedUAS(){
		$query=$this->db->query('SELECT * FROM ak_nilai_uas nilai JOIN
								 ak_subject_nilai s 
								 ON
								 s.id=nilai.id_subject
								 WHERE 
								 nilai.ta='.$this->session->userdata['ak_setting']['ta'].' AND
								 nilai.semester='.$this->session->userdata['ak_setting']['semester'].' AND
								 s.jenis="nilai uas"
								
								');

		$res=$query->result_array();
		if(empty($res)){
			return false;
		}else{
			return true;
		}						
		
	}
	function ifinsertedUTS(){
		$query=$this->db->query('SELECT * FROM ak_nilai_uts nilai JOIN
								 ak_subject_nilai s 
								 ON
								 s.id=nilai.id_subject
								 WHERE 
								 nilai.ta='.$this->session->userdata['ak_setting']['ta'].' AND
								 nilai.semester='.$this->session->userdata['ak_setting']['semester'].' AND
								 s.jenis="nilai uts"
								
								');
							
		$res=$query->result_array();
		if(empty($res)){
			return false;
		}else{
			return true;
		}							
		
	}
	
	function getSubjectNilaiById($id=null){
		$query=$this->db->query('
								SELECT * FROM ak_subject_nilai WHERE id='.$id.'
								');//echo $this->db->last_query();
		return $query->result_array();
	}
	function getSubjectNilai($id_kelas=null,$id_pelajaran=null,$jenis=null){
		//pr($jenis);
		$cond='';
		if($id_pelajaran!=null){
			$cond .='AND id_pelajaran='.$id_pelajaran.'';
		}
		if($id_kelas!=null){
			$cond .=' AND id_kelas='.$id_kelas.'';
		}
	
		$query=$this->db->query('
								SELECT `asn`.*, k.nama as nama_kelas, k.kelas, k.id as id_kelas, pl.nama as pelajaran, pl.id as id_pelajaran FROM
								ak_subject_nilai `asn` JOIN
								ak_kelas k JOIN
								ak_pelajaran pl
								ON k.id=`asn`.id_kelas 
								AND pl.id=`asn`.id_pelajaran
								WHERE `asn`.id_sekolah='.$this->session->userdata['user_authentication']['id_sekolah'].' AND
								`asn`.ta='.$this->session->userdata['ak_setting']['ta'].' AND
								`asn`.semester='.$this->session->userdata['ak_setting']['semester'].' '.$cond.' 
								AND asn.id_pegawai='.$this->session->userdata['user_authentication']['id_pengguna'].'
								AND asn.jenis="'.$jenis.'"
								AND k.publish=1
								ORDER BY asn.id DESC
								');//echo $this->db->last_query();
		return $query->result_array();
	}
	function getNilaiPsikoAfektif($id_kelas=0,$id_pelajaran=0,$jenis){
				$query=$this->db->query('SELECT an.* , asis.nama, asis.nis
								 FROM ak_nilai_'.$jenis.' an
								 JOIN ak_det_jenjang adj
								 JOIN ak_siswa asis
								 ON adj.id=an.id_siswa_det_jenjang
								 AND adj.id_siswa=asis.id
								 WHERE 
								 adj.id_kelas=?
								 AND an.id_pelajaran=?
								 AND an.id_sekolah=?
								 AND an.semester=?
								 AND an.ta=?
									',array($id_kelas,$id_pelajaran,$this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['ak_setting']['semester'],$this->session->userdata['ak_setting']['ta']));
		echo $this->db->last_query();
		return $query->result_array();
	}
	function getSubjectNilaiListNilai($id_kelas=null,$id_pelajaran=null,$jenis=null){
		//pr($jenis);
		$cond='';
		if($id_pelajaran!=null && $id_pelajaran!=0){
			$cond .='AND id_pelajaran='.$id_pelajaran.'';
		}
		if($id_kelas!=null){
			$cond .=' AND id_kelas='.$id_kelas.'';
		}
		if($id_pelajaran!=null && $id_pelajaran!=0){
		$query=$this->db->query('
								SELECT `asn`.*, k.nama as nama_kelas, k.kelas, k.id as id_kelas, pl.nama as pelajaran, pl.id as id_pelajaran FROM
								ak_subject_nilai `asn` JOIN
								ak_kelas k JOIN
								ak_pelajaran pl
								ON k.id=`asn`.id_kelas 
								AND pl.id=`asn`.id_pelajaran
								WHERE `asn`.id_sekolah='.$this->session->userdata['user_authentication']['id_sekolah'].' AND
								`asn`.ta='.$this->session->userdata['ak_setting']['ta'].' AND
								`asn`.semester='.$this->session->userdata['ak_setting']['semester'].' '.$cond.' 
								AND asn.id_pegawai='.$this->session->userdata['user_authentication']['id_pengguna'].'
								AND asn.jenis="'.$jenis.'"
									AND k.publish=1
								ORDER BY asn.id DESC
								');		
		}else{
		$query=$this->db->query('
								SELECT `asn`.*, k.nama as nama_kelas, k.kelas, k.id as id_kelas FROM
								ak_subject_nilai `asn` JOIN
								ak_kelas k 
								ON k.id=`asn`.id_kelas
								WHERE `asn`.id_sekolah='.$this->session->userdata['user_authentication']['id_sekolah'].' AND
								`asn`.ta='.$this->session->userdata['ak_setting']['ta'].' AND
								`asn`.semester='.$this->session->userdata['ak_setting']['semester'].' '.$cond.' 
								AND asn.id_pegawai='.$this->session->userdata['user_authentication']['id_pengguna'].'
								AND asn.jenis="'.$jenis.'"
									AND k.publish=1
								ORDER BY asn.id DESC
								');	

		}
		$subject=	$query->result_array();		
		
		$table='ak_'.str_replace(" ","_",$jenis);
		foreach($subject as $ids=>$datasubject){
			$qlistnilai=$this->db->query('
								SELECT nil.*, s.nama, s.nis, ak.nama as nama_kelas, ak.kelas  FROM
								ak_det_jenjang adj JOIN
								ak_siswa s JOIN
								ak_kelas ak JOIN
								'.$table.' nil
								ON
								adj.id_siswa=s.id AND
								adj.id_kelas=ak.id AND
								adj.id=nil.id_siswa_det_jenjang
								WHERE
								nil.id_subject='.$datasubject['id'].'
								'.$cond.'
									AND ak.publish=1
								ORDER BY s.nama ASC
								');
								//echo $this->db->last_query();
			$datanilai=$qlistnilai->result_array();
			$subject[$ids]['datanilai']=$datanilai;
		}
		
		return  $subject;
		
	}
	
	//nilai
	function getNilaiByIddetjenjangIdkelasIdPelajaran($id_det_jenjang,$id_pelajaran,$jenis){
		$query=$this->db->query('
								SELECT nilai.nilai,nilai.id_siswa_det_jenjang  FROM
								ak_siswa sis JOIN 
								ak_det_jenjang dj JOIN
								ak_'.str_replace(' ','_',$jenis).' nilai JOIN
								ak_pelajaran pl
								ON
								sis.id=dj.id_siswa AND
								dj.id=nilai.id_siswa_det_jenjang AND
								pl.id=nilai.id_pelajaran
								WHERE
								nilai.ta='.$this->session->userdata['ak_setting']['ta'].' AND
								nilai.semester='.$this->session->userdata['ak_setting']['semester'].' AND
								nilai.id_sekolah='.$this->session->userdata['user_authentication']['id_sekolah'].' AND
								dj.id='.$id_det_jenjang.' AND
								pl.id="'.$id_pelajaran.'"
								ORDER BY sis.nama ASC
								');
								//pr($this->db->last_query());
		return $query->result_array();
	}
	//nilai
	function getNilaiByIddetjenjangIdkelasIdPelajaranPersubject($id_det_jenjang,$id_pelajaran,$jenis,$id_referensi){
		$query=$this->db->query('
								SELECT nilai.nilai,nilai.id_siswa_det_jenjang,nilai.id as id_nilai,nilai.id_subject  FROM
								ak_siswa sis JOIN 
								ak_det_jenjang dj JOIN
								ak_'.str_replace(' ','_',$jenis).' nilai JOIN
								ak_pelajaran pl JOIN
								ak_subject_nilai asn
								ON
								sis.id=dj.id_siswa AND
								dj.id=nilai.id_siswa_det_jenjang AND
								pl.id=nilai.id_pelajaran AND
								asn.id=nilai.id_subject
								WHERE
								nilai.ta='.$this->session->userdata['ak_setting']['ta'].' AND
								nilai.semester='.$this->session->userdata['ak_setting']['semester'].' AND
								nilai.id_sekolah='.$this->session->userdata['user_authentication']['id_sekolah'].' AND
								dj.id='.$id_det_jenjang.' AND
								asn.id_referensi='.$id_referensi.' AND
								pl.id="'.$id_pelajaran.'"
								ORDER BY sis.nama ASC
								');
								//echo $this->db->last_query();
		return $query->result_array();
	}
	//get nilai berdasar remidi tertinggi
	function getNilaiByIddetjenjangIdkelasIdPelajaranRemidi($id_det_jenjang,$id_pelajaran,$jenis){
		$query=$this->db->query('
								SELECT MAX(nilai.nilai) as nilai,nilai.id_siswa_det_jenjang  FROM
								ak_siswa sis JOIN 
								ak_det_jenjang dj JOIN
								ak_'.str_replace(' ','_',$jenis).' nilai JOIN
								ak_pelajaran pl
								ON
								sis.id=dj.id_siswa AND
								dj.id=nilai.id_siswa_det_jenjang AND
								pl.id=nilai.id_pelajaran
								WHERE
								nilai.ta='.$this->session->userdata['ak_setting']['ta'].' AND
								nilai.semester='.$this->session->userdata['ak_setting']['semester'].' AND
								nilai.id_sekolah='.$this->session->userdata['user_authentication']['id_sekolah'].' AND
								dj.id='.$id_det_jenjang.' AND
								pl.id="'.$id_pelajaran.'" 
								ORDER BY sis.nama ASC
								');
								//echo $this->db->last_query();
		return $query->result_array();
	}
	//end ulangan harian
	
	// mengambil setting prosentase bobot nilai
	
	function getBobotNilai($id_sekolah=null){
		$query=$this->db->query('SELECT * FROM ak_nilai_formulasi WHERE id_sekolah='.$id_sekolah.'');
		//echo $this->db->last_query();
		return $query->result_array();
	}
	function getnilaiByIdSiswaDetjenjang($id_siswa_det_jenjang,$tablenilai){
		$query=$this->db->query('SELECT anp.*
								FROM `ak_pelajaran` ap
								JOIN '.$tablenilai.' anp
								JOIN ak_subject_nilai asn ON ap.id = anp.id_pelajaran
								AND asn.id = anp.id_subject
								WHERE anp.id_siswa_det_jenjang ='.$id_siswa_det_jenjang.'
								');
		//echo $this->db->last_query();
		return $query->result_array();
	}
	function array_group_by($arr, $key_selector) {
		$result = array();

		foreach($arr as $i){
			$key = $key_selector($i);
			$group;
			if(!array_key_exists($key, $result)) {
				$result[$key] = array();

			}
			$result[$key][] = $i;
		}

		return $result;
	}
	function getCatatanRaportByIdDetjenjangTaSm($id_det_jenjang){
		$query=$this->db->query('SELECT * FROM ak_catatan_raport 
								WHERE
								id_sekolah='.$this->session->userdata['user_authentication']['id_sekolah'].'
								AND ta='.$this->session->userdata['ak_setting']['ta'].'
								AND semester='.$this->session->userdata['ak_setting']['semester'].'
								AND id_det_jenjang='.$id_det_jenjang.'
								');
		//echo $this->db->last_query();
		return $query->result_array();
	}
	function getnilaiByKelasMapelSiswa($id_kelas,$id_pelajaran,$tablenilai){
		$query=$this->db->query('SELECT anp. *
									FROM `ak_pelajaran` ap
									JOIN '.$tablenilai.' anp
									JOIN ak_subject_nilai asn 
									JOIN ak_det_jenjang adj
									ON ap.id = anp.id_pelajaran
									AND asn.id = anp.id_subject
									AND adj.id = anp.id_siswa_det_jenjang
									WHERE anp.id_pelajaran ='.$id_pelajaran.'
									AND adj.id_kelas='.$id_kelas.'
									AND anp.ta='.$this->session->userdata['ak_setting']['ta'].'
									AND anp.semester='.$this->session->userdata['ak_setting']['semester'].'
									ORDER BY adj.id DESC
								');
		$nilai=$query->result_array();	
		$grouped = $this->array_group_by($nilai, function($i){  return $i['id_siswa_det_jenjang']; });

		//pr($grouped);
		//pr($grouped);
		//echo $this->db->last_query();
		//die();
		return $grouped;
	}
 }
 