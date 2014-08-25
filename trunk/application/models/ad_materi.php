<?php
Class Ad_materi extends CI_Model{

	function getmateriByKelasPelajaranIdPegawai($id_pelajaran=0,$id_kelas=0){
		$cnd='';
		$cnd2='';
		if($id_pelajaran!=0){$cnd='AND amp.id_pelajaran="'.mysql_real_escape_string($id_pelajaran).'"';}
		if($id_kelas!=0){$cnd2='AND amk.id_kelas="'.mysql_real_escape_string($id_kelas).'"';}
		$query=$this->db->query('SELECT amp.* FROM ak_materi_pelajaran amp JOIN
								 ak_materi_kirim amk
								 ON
								 amp.id=amk.id_materi
								 WHERE
								 amp.id_sekolah=?
								 '.$cnd.'
								 '.$cnd2.'
								 AND amp.id_pegawai=?
								 GROUP BY amp.id
								 ORDER BY amp.id DESC
								 LIMIT 15
								',array($this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['user_authentication']['id_pengguna']));
		//echo $this->db->last_query();
		return $query->result_array();
	}
	function getmateriByKelasPelajaranIdPegawaiKirim($id_pelajaran=0,$id_kelas=0){
		$cnd='';
		$cnd2='';
		$materi=array();
		if($id_pelajaran!=0){$cnd='AND amp.id_pelajaran="'.mysql_real_escape_string($id_pelajaran).'"';}
		if($id_kelas!=0){$cnd2='AND amk.id_kelas="'.mysql_real_escape_string($id_kelas).'"';}
		$query=$this->db->query('SELECT amk.*,ak.nama as nama_kelas,ak.kelas FROM ak_materi_pelajaran amp JOIN
								 ak_materi_kirim amk JOIN ak_kelas ak
								 ON
								 amp.id=amk.id_materi
								 AND amk.id_kelas=ak.id
								 WHERE
								 amp.id_sekolah=?
								 '.$cnd.'
								 '.$cnd2.'
								 AND amp.id_pegawai=?
								 ORDER BY amp.id DESC
								 LIMIT 15
								',array($this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['user_authentication']['id_pengguna']));
		foreach($query->result_array() as $mtrkrm){
			$materi[$mtrkrm['id_materi']][$mtrkrm['id']]=$mtrkrm;
		}
		return $materi;
	}
	function getmateriByKelasPelajaranIdPegawaiAll($id_pelajaran=0,$id_kelas=0){
		$cnd='';
		$cnd2='';
		if($id_pelajaran!=0){$cnd='AND amp.id_pelajaran="'.mysql_real_escape_string($id_pelajaran).'"';}
		//if($id_kelas!=0){$cnd2='AND amk.id_kelas="'.mysql_real_escape_string($id_kelas).'"';}
		$query=$this->db->query('SELECT amp.*,ap.nama as pelajaran,amk.tanggal_diajarkan FROM ak_materi_pelajaran amp JOIN
								 ak_materi_kirim amk JOIN
								 ak_pelajaran ap
								 ON ap.id=amp.id_pelajaran
								 WHERE
								 amp.id_sekolah=?
								 '.$cnd.'
								 '.$cnd2.'
								 AND amp.id_pegawai=?
								 GROUP BY amp.id
								 ORDER BY amp.id DESC
								 LIMIT 15
								',array($this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['user_authentication']['id_pengguna']));
		//echo $this->db->last_query();
		return $query->result_array();
	}
	function getFileMatById_mat($id_materi){
		$query=$this->db->query('SELECT * FROM ak_materi_file 
								WHERE
								id_materi=?
								',array($id_materi));
		
		return $query->result_array();	
	}
	function getMateriStok($id_pelajaran=0){
		$query=$this->db->query('SELECT * FROM `ak_materi_pelajaran` a WHERE
									/*a.id NOT IN(SELECT id_materi FROM ak_materi_kirim WHERE id_materi=a.id) 
									AND*/ a.id_sekolah='.$this->session->userdata['user_authentication']['id_sekolah'].'
									AND a.id_pegawai='.$this->session->userdata['user_authentication']['id_pengguna'].'
									AND a.id_pelajaran='.$id_pelajaran.'
								');
		//echo $this->db->last_query();
		return $query->result_array();	
	}
	function getmateriAndFileByKelasPelajaranId($id_pelajaran,$id_kelas){
		if($id_pelajaran!=''){
			$condpel='AND amp.id_pelajaran='.$id_pelajaran.'';
		}else{
			$condpel='';
			$limit='LIMIT 10';
		}
		$query=$this->db->query('SELECT amp.*, ak.nama as nama_kelas,ak.kelas ,ap.nama as nama_pelajaran,ag.nama as nama_guru FROM ak_materi_pelajaran amp JOIN
								 ak_materi_kirim amk JOIN
								 ak_kelas ak JOIN 
								 ak_pelajaran ap JOIN
								 ak_pegawai ag
								 ON
								 amp.id=amk.id_materi
								 AND ak.id=amk.id_kelas
								 AND amp.id_pelajaran=ap.id
								 AND amp.id_pegawai=ag.id
								 WHERE
								 amp.id_sekolah='.$this->session->userdata['user_authentication']['id_sekolah'].'
								 '.$condpel.'
								 AND amk.id_kelas='.$id_kelas.'
								 AND ak.publish=1
								 ORDER BY amk.id DESC
								 '.$limit.'
								');
		//echo $this->db->last_query();
		$materi= $query->result_array();
		foreach($materi as $k=>$datam){
			$qdatam=$this->db->query('SELECT * FROM ak_materi_file WHERE id_materi='.$datam['id'].'
								');
			$materi[$k]['file']=$qdatam->result_array();
		}
		
		return $materi;
	}
	function getmateriById($id){
		$query=$this->db->query('SELECT amp.*, amk.id_kelas FROM ak_materi_pelajaran amp JOIN
								 ak_materi_kirim amk
								 
								 WHERE
								 amp.id=?
								 GROUP BY amp.id
								',array($id));
		//echo $this->db->last_query();
		return $query->result_array();
	}
 	function getFileMateriById_materi($id_materi){
		$query=$this->db->query('SELECT amf.* FROM
								ak_materi_pelajaran am JOIN 
								ak_materi_file amf
								ON
								amf.id_materi=am.id
								WHERE
								amf.id_materi="'.$id_materi.'"
								');
		//echo $this->db->last_query();
		return $query->result_array();
	}
 	function getMateriByIdSekolah($id_sekolah){
		if(isset($_POST['filter'])){
			$cond='AND date(tanggal_buat) > "'.date("Y-m-d", mktime(0, 0, 0,  date("m")  , date("d")-$_POST['filter'], date("Y"))).'"';
		}
		$query=$this->db->query('SELECT * FROM
								ak_materi_pelajaran am
								WHERE
								am.id_sekolah=?
								'.$cond.'
								',array($id_sekolah));
		return $query->result_array();
	}
 	function getFileMateriById($id){
		$query=$this->db->query('SELECT amf.* FROM
								ak_materi_pelajaran am JOIN 
								ak_materi_file amf
								ON
								amf.id_materi=am.id
								WHERE
								amf.id="'.$id.'"
								');
		//echo $this->db->last_query();
		return $query->result_array();;
	}	
	function getMateriByIdFordetail($id_materi){
		$query=$this->db->query('SELECT ak.id as id_kelas,ak.kelas,ak.nama as nama_kelas,apl.nama as nama_pelajaran,ap.pokok_bahasan as judul, ap.* FROM ak_materi_pelajaran ap JOIN
								ak_kelas ak JOIN
								ak_pelajaran apl JOIN
								ak_materi_kirim amk
								ON
								amk.id_kelas=ak.id
								AND
								apl.id=ap.id_pelajaran
								AND
								amk.id_materi=ap.id
								WHERE
								ap.id='.$id_materi.'
									AND ak.publish=1
								');
		$out=$query->result_array();						
		$out[0]['file']=$this->getFileMateriByIdMateri($id_materi);			
		//echo $this->db->last_query();
		return $out;
	}
	function getFileMateriByIdMateri($id_materi){
		$query=$this->db->query('SELECT af.* FROM ak_materi_pelajaran ap JOIN
								ak_materi_file af 
								ON
								af.id_materi=ap.id
								WHERE
								ap.id='.$id_materi.'
								');
		//echo $this->db->last_query();
		return $query->result_array();
	}
	function getDataByIdPegawaiGuru($limit=5,$id_user=0,$guruorsiswa=''){
		
		if($guruorsiswa=='guru'){
			$query=$this->db->query('SELECT amp.*, ak.nama as nama_kelas,ak.kelas ,ap.nama as nama_pelajaran,ag.nama as nama_guru 
								FROM 
								 ak_materi_pelajaran amp JOIN
								 ak_materi_kirim amk JOIN
								 ak_kelas ak JOIN 
								 ak_pelajaran ap JOIN
								 ak_pegawai ag
								 ON
								 amp.id=amk.id_materi
								 AND ak.id=amk.id_kelas
								 AND amp.id_pelajaran=ap.id
								 AND amp.id_pegawai=ag.id
								 WHERE
								 amp.id_sekolah='.$this->session->userdata['user_authentication']['id_sekolah'].'
								 AND amp.id_pegawai='.$id_user.'
								 AND ak.publish=1
								 ORDER BY amp.id DESC
								 LIMIT '.$limit.'
								');
			$out=$query->result_array();
		}elseif($guruorsiswa=='siswa'){
			$query=$this->db->query('SELECT amp.*, ak.nama as nama_kelas,ak.kelas ,ap.nama as nama_pelajaran,ag.nama as nama_guru 
								 FROM 
								 ak_materi_pelajaran amp JOIN
								 ak_materi_kirim amk JOIN
								 ak_kelas ak JOIN 
								 ak_pelajaran ap JOIN
								 ak_pegawai ag JOIN
								 ak_det_jenjang adj
								 ON
								 amp.id=amk.id_materi
								 AND ak.id=amk.id_kelas
								 AND amp.id_pelajaran=ap.id
								 AND amp.id_pegawai=ag.id
								 AND amk.id_kelas=adj.id_kelas
								 WHERE
								 amp.id_sekolah='.$this->session->userdata['user_authentication']['id_sekolah'].'
								 AND adj.id_siswa='.$this->session->userdata['user_authentication']['id_siswa'].'
								 AND ak.publish=1
								 ORDER BY amp.id DESC
								 LIMIT '.$limit.'
								');
			$out=$query->result_array();		
		}elseif($guruorsiswa=='all'){
			$query=$this->db->query('SELECT amp.*, ak.nama as nama_kelas,ak.kelas ,ap.nama as nama_pelajaran,ag.nama as nama_guru 
								 FROM 
								 ak_materi_pelajaran amp JOIN
								 ak_materi_kirim amk JOIN
								 ak_kelas ak JOIN 
								 ak_pelajaran ap JOIN
								 ak_pegawai ag
								 ON
								 amp.id=amk.id_materi
								 AND ak.id=amk.id_kelas
								 AND amp.id_pelajaran=ap.id
								 AND amp.id_pegawai=ag.id
								 WHERE
								 amp.id_sekolah=?
								 AND ak.publish=1
								 ORDER BY amp.id DESC
								 LIMIT ?
									',array($this->session->userdata['user_authentication']['id_sekolah'],$limit));
			$out=$query->result_array();		
		}
		//echo $this->db->last_query();
		return $out;
	}
	
	function getIdKelasPenerima($id=0){
		$query=$this->db->query('SELECT ak.* FROM ak_materi_kirim amk JOIN ak_kelas ak ON amk.id_kelas=ak.id WHERE amk.id_materi=?',array($id));
		$out=$query->result_array();	
		
		return $out;
	}
	 function getKelasByPelajaranMengajar($id_pelajaran=0,$id_sekolah=0,$semester=0,$id_pegawai=0){
		$kelas=$this->db->query('SELECT k.*,m.id as id_mengajar FROM 
								ak_kelas k  
								JOIN ak_pelajaran p 
								JOIN ak_mengajar m 
								JOIN ak_materi_kirim amk
								ON 
								k.kelas=p.kelas 
								AND m.id_pelajaran=p.id 
								AND amk.id_kelas!=k.id
								WHERE 
								p.id=?
								AND k.id_sekolah=? 
								AND p.semester=? 
								AND m.id_pegawai=? 
								AND m.id_kelas=k.id 
								AND k.id_jurusan=p.id_jurusan
								GROUP BY k.id',array($id_pelajaran,$id_sekolah,$semester,$id_pegawai))->result_array();echo $this->db->last_query();
		return $kelas;

  }
 }
 