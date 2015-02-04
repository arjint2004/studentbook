<?php
Class Ad_tugas extends CI_Model{

	function getTugasByIdSekolah($id_sekolah=0,$field=array('*')){
		if(isset($_POST['filter'])){
			$cond='AND date(tanggal_buat) > "'.date("Y-m-d", mktime(0, 0, 0,  date("m")  , date("d")-$_POST['filter'], date("Y"))).'"';
		}
		$query=$this->db->query('SELECT '.implode(",",$field).' FROM ak_tugas ap
								JOIN ak_pelajaran apj
								ON apj.id=ap.id_pelajaran
								WHERE
								ap.id_sekolah=?
								AND ap.id_parent=0
								'.$cond.'
								',array($id_sekolah));
		//echo $this->db->last_query();
		return $query->result_array();
	}
	function getTugasByKelasPelajaran($id_pelajaran,$id_kelas){
		$query=$this->db->query('SELECT ap.* FROM ak_tugas ap JOIN
								ak_kelas ak
								JOIN ak_tugas_det apd
								ON
								ap.id=apd.id_tugas
								AND 
								apd.id_kelas=ak.id
								WHERE
								apd.id_kelas=?
								AND
								ap.id_pelajaran=?
									AND ak.publish=1
								',array($id_kelas,$id_pelajaran));
		//echo $this->db->last_query();
		return $query->result_array();
	}

	function getOptionTugasByIdKelasIdPegawaiform($id_pelajaran,$id_kelas){
		$query=$this->db->query('SELECT ap . *
								FROM ak_tugas ap
								JOIN ak_kelas ak
								JOIN ak_tugas_det apd
								ON
								ap.id=apd.id_tugas
								AND 
								apd.id_kelas=ak.id
								WHERE
								apd.id_kelas=?
								AND
								ap.id_parent=0
								AND
								ap.id_pelajaran=?
								AND ap.id_pegawai=?
								AND ak.publish=1
								GROUP BY ap.id
								',array($id_kelas,$id_pelajaran,$this->session->userdata['user_authentication']['id_pengguna']));
		//echo $this->db->last_query();
		return $query->result_array();
	}
	
	function getTugasByKelasPelajaranIdPegawaiNotParent($id_pelajaran,$id_kelas){
		$query=$this->db->query('SELECT ap . *
								FROM ak_tugas ap
								JOIN ak_kelas ak
								JOIN ak_tugas_det apd
								ON
								ap.id=apd.id_tugas
								AND 
								apd.id_kelas=ak.id
								WHERE
								apd.id_kelas=?
								AND ak.publish=1
								AND
								ap.id_pelajaran=?
								AND ap.id_pegawai=?
								AND 
								ap.id_parent=0
								GROUP BY ap.id
								ORDER BY ap.id DESC
								',array($id_kelas,$id_pelajaran,$this->session->userdata['user_authentication']['id_pengguna']));
		//echo $this->db->last_query();
		return $query->result_array();
	}
	function getTugasByKelasPelajaranId($id_pelajaran,$id_kelas){
		
		if($id_pelajaran!=''){
			$condpel='AND aj.id="'.mysql_real_escape_string($id_pelajaran).'" AND ap.id_pelajaran="'.mysql_real_escape_string($id_pelajaran).'"';
		}else{
			$condpel='';
			$limit='LIMIT 10';
		}
		$query=$this->db->query('SELECT ap . *,apd.tanggal_kumpul, ak.nama as nama_kelas, ak.kelas as kelas, ag.nama as nama_guru, aj.nama as nama_pelajaran,apd.id_kelas as id_kelas
								FROM ak_tugas ap
								JOIN ak_tugas_det apd
								JOIN ak_kelas ak
								JOIN ak_pegawai ag
								JOIN ak_pelajaran aj
								ON
								ap.id=apd.id_tugas
								AND 
								apd.id_kelas=ak.id
								AND 
								ag.id=ap.id_pegawai
								AND 
								aj.id=ap.id_pelajaran
								WHERE
								apd.id_kelas=?
								AND
								ak.id=?
								AND 
								ak.publish=1
								'.$condpel.'
								GROUP BY ap.id
								ORDER BY ap.id DESC
								'.$limit.'
								',array($id_kelas,$id_kelas));
		//echo $this->db->last_query();
		return $query->result_array();
	}
	function getTugasByKelasPelajaranIdPegawai($id_pelajaran=0,$id_kelas=0){
		$cnd='';
		$cnd2='';
		$cnd3='';
		if(in_array(16,$this->session->userdata['user_authentication']['det_group']) && isset($_POST['kepsek'])){$cnd3='';}else{$cnd3='AND am.id_pegawai='.mysql_real_escape_string($this->session->userdata['user_authentication']['id_pengguna']).'';}
		if($id_pelajaran!=0){$cnd='AND ap.id_pelajaran="'.mysql_real_escape_string($id_pelajaran).'"';}
		if($id_kelas!=0){$cnd2='AND apd.id_kelas="'.mysql_real_escape_string($id_kelas).'"';}
		$query=$this->db->query('SELECT ap. * , apd.id_kelas, apj.nama AS nama_pelajaran, ak.nama AS nama_kelas, ak.kelas, peg.nama AS nama_peg FROM 
								ak_tugas ap  
								JOIN ak_tugas_det apd 
								JOIN ak_kelas ak
								JOIN ak_mengajar am
								JOIN ak_pelajaran apj
								JOIN ak_pegawai peg 

								ON 
								ap.id=apd.id_tugas
								AND ak.id=apd.id_kelas
								AND am.id = apd.id_mengajar
								AND ap.id_pelajaran = apj.id
								AND am.id_pegawai = peg.id
								
								WHERE
								ap.id_parent=0
								'.$cnd2.'
								AND 
								ak.publish=1
								'.$cnd.'
								'.$cnd3.'
								
								GROUP BY ap.id
								ORDER BY ap.id DESC
								LIMIT 8
								');
		//echo $this->db->last_query();
		$query2=$this->db->query('SELECT ap. * , apd.id_kelas, apj.nama AS nama_pelajaran, ak.nama AS nama_kelas, ak.kelas, peg.nama AS nama_peg FROM 
								ak_tugas ap  
								JOIN ak_tugas_det apd 
								JOIN ak_kelas ak
								JOIN ak_mengajar am
								JOIN ak_pelajaran apj
								JOIN ak_pegawai peg 

								ON 
								ap.id=apd.id_tugas
								AND ak.id=apd.id_kelas
								AND am.id = apd.id_mengajar
								AND ap.id_pelajaran = apj.id
								AND am.id_pegawai = peg.id
								WHERE
								ap.id_parent!=0
								'.$cnd2.'
								AND 
								ak.publish=1
								'.$cnd.'
								'.$cnd3.'
								
								GROUP BY ap.id DESC
								ORDER BY ap.judul,ap.id DESC
								
								');
		$utama=$query->result_array();
		$remidi=$query2->result_array();
		
		foreach($remidi as $remididata){
			$remidi2[$remididata['id_parent']][]=$remididata;
		}
		foreach($utama as $ky=>$utamadata){

			$utamadata2[]=$utamadata;
			///echo ''.$utamadata['id'].'=='.$remidi2[$utamadata['id']][0]['id_parent'].'<br />';
			if($utamadata['id']==$remidi2[$utamadata['id']][0]['id_parent']){
				foreach($remidi2[$utamadata['id']] as $kyid=>$remidi3){
					$utamadata2[]=$remidi3;
				}
			}
		}
		//tugas($utamadata2);
		
		return $utamadata2;
	}
	function getTugasByKelasPelajaranIdPegawaiAllCount($id_pelajaran=0,$id_kelas=0,$id_penggunas=0){
		
		if($id_penggunas!=0){
			$id_pengguna=$id_penggunas;
		}else{
			$id_pengguna=$this->session->userdata['user_authentication']['id_pengguna'];
		}
		
		$cnd='';
		$cnd2='';
		if($id_pelajaran!=0){$cnd='AND ap.id_pelajaran="'.mysql_real_escape_string($id_pelajaran).'"';}
		//if($id_kelas!=0){$cnd2='AND amk.id_kelas="'.mysql_real_escape_string($id_kelas).'"';}
		$query=$this->db->query('SELECT COUNT(*) as jml FROM ak_tugas ap 
								 WHERE
								 ap.id_sekolah=?
								 '.$cnd.'
								 '.$cnd2.'
								 AND ap.id_pegawai=?
								',array($this->session->userdata['user_authentication']['id_sekolah'],$id_pengguna));
		$out=$query->result_array();						
		//echo $this->db->last_query();
		//tugas($out);
		return $out[0]['jml'];
	}
	function getTugasByKelasPelajaranIdPegawaiAll($id_pelajaran=0,$id_kelas=0,$start=0,$page=0,$id_penggunas=0){
		$cnd='';
		$cnd2='';
		$cnd3='';
		
		//if(in_array(16,$this->session->userdata['user_authentication']['det_group']) && isset($_POST['kepsek'])){$cnd3='';}else{$cnd3='AND ap.id_pegawai='.mysql_real_escape_string($this->session->userdata['user_authentication']['id_pengguna']).'';}

		if($id_penggunas!=0){
			$cnd3='AND ap.id_pegawai='.mysql_real_escape_string($id_penggunas).'';
		}else{
			$cnd3='AND ap.id_pegawai='.mysql_real_escape_string($this->session->userdata['user_authentication']['id_pengguna']).'';
		}
		
		
		if($id_pelajaran!=0){$cnd='AND ap.id_pelajaran="'.mysql_real_escape_string($id_pelajaran).'"';}
		//if($id_kelas!=0){$cnd2='AND apd.id_kelas="'.mysql_real_escape_string($id_kelas).'"';}
		$query=$this->db->query('SELECT ap. *,apj.nama as nama_pelajaran FROM 
								ak_tugas ap  
								JOIN ak_pelajaran apj
								ON apj.id=ap.id_pelajaran
								WHERE
								ap.id_parent=0
								'.$cnd2.'
								'.$cnd.'
								'.$cnd3.'
								
								GROUP BY ap.id
								ORDER BY ap.id DESC
								 LIMIT '.$start.','.$page.'
								');
		//echo $this->db->last_query();
		$query2=$this->db->query('SELECT ap. *,apj.nama as nama_pelajaran FROM 
								ak_tugas ap  
								JOIN ak_pelajaran apj
								ON apj.id=ap.id_pelajaran
								WHERE
								ap.id_parent!=0
								'.$cnd2.'
								'.$cnd.'
								'.$cnd3.'
								
								GROUP BY ap.id
								ORDER BY ap.id DESC
								
								');
		$utama=$query->result_array();
		$remidi=$query2->result_array();
		
		foreach($remidi as $remididata){
			$remidi2[$remididata['id_parent']][]=$remididata;
		}
		foreach($utama as $ky=>$utamadata){

			$utamadata2[]=$utamadata;
			///echo ''.$utamadata['id'].'=='.$remidi2[$utamadata['id']][0]['id_parent'].'<br />';
			if($utamadata['id']==$remidi2[$utamadata['id']][0]['id_parent']){
				foreach($remidi2[$utamadata['id']] as $kyid=>$remidi3){
					$utamadata2[]=$remidi3;
				}
			}
		}
		//tugas($utamadata2);
		
		return $utamadata2;
	}
	function getDetTugasByKelasPelajaran($id_pelajaran,$id_kelas){
		$query=$this->db->query('SELECT ak.id,ak.kelas,ak.nama FROM ak_tugas ap JOIN
								JOIN ak_tugas_det apd 
								ak_kelas ak
								ON
								ap.id=apd.id_tugas
								AND 
								apd.id_kelas=ak.id
								WHERE
								ap.id_pelajaran=?
								AND ak.publish=1
								',array($id_pelajaran));
		//echo $this->db->last_query();
		return $query->result_array();
	}
	function getFileTugasByIdTugas($id_tugas){
		$query=$this->db->query('SELECT af.* FROM 
								ak_tugas_file af 
								
								WHERE
								af.id_tugas=?
								',array($id_tugas));
		//tugas($this->db->last_query());
		return $query->result_array();
	}
	function getFileTugasInId($id_tugas=array()){
		$query=$this->db->query('SELECT * FROM 
								ak_tugas_file
								WHERE id_tugas IN('.implode(',',$id_tugas).')
								');
		//tugas($this->db->last_query());
		return $query->result_array();
	}
	function getFileTugasById_tugas($id_tugas){
		return $this->getFileTugasByIdTugas($id_tugas);
	}
	function getJustTugasById($id_tugas){
		$query=$this->db->query('SELECT ak.id as id_kelas,ak.kelas,ak.nama as nama_kelas,ap.* FROM 
								ak_tugas ap 
								JOIN ak_tugas_det apd 
								JOIN ak_kelas ak
								ON
								apd.id_kelas=ak.id
								WHERE
								ap.id=?
								AND ak.publish=1
								GROUP BY ap.id
								',array($id_tugas));
		$out['tugas']=$query->result_array();						
		$out['file']=$this->getFileTugasByIdTugas($id_tugas);						
		//echo $this->db->last_query();
		//tugas($out['tugas']);
		return $out;
	}
	function getTugasById($id_tugas){
		$query=$this->db->query('SELECT ak.id as id_kelas,ak.kelas,ak.nama as nama_kelas,ap.* FROM 
								ak_tugas ap 
								JOIN ak_tugas_det apd 
								JOIN ak_kelas ak
								ON
								ap.id=apd.id_tugas
								AND
								apd.id_kelas=ak.id
								WHERE
								ap.id=?
								AND ak.publish=1
								GROUP BY ap.id
								',array($id_tugas));
		$out['tugas']=$query->result_array();						
		$out['file']=$this->getFileTugasByIdTugas($id_tugas);						
		//echo $this->db->last_query();
		return $out;
	}
	function getTugasByIdFordetail($id_tugas){
		$query=$this->db->query('SELECT ak.kelas,ak.nama as nama_kelas,apl.nama as nama_pelajaran, ap.*, ak.id as id_kelas FROM 
								ak_tugas ap 
								JOIN ak_tugas_det apd
								JOIN ak_kelas ak JOIN
								ak_pelajaran apl
								ON
								ap.id=apd.id_tugas
								AND
								apd.id_kelas=ak.id
								AND
								apl.id=ap.id_pelajaran
								WHERE
								ap.id=?
								AND ak.publish=1
								',array($id_tugas));
		//echo $this->db->last_query();
		$out=$query->result_array();						
		$out[0]['file']=$this->getFileTugasByIdTugas($id_tugas);			 
		return $out;
	}
	function getTugasByIdForRemidi($id_tugas){
		$query=$this->db->query('SELECT ak.id as id_kelas,ak.kelas,ak.nama as nama_kelas,ap.* FROM
								ak_tugas ap 
								JOIN ak_tugas_det apd 
								JOIN ak_kelas ak
								ON
								ap.id=apd.id_tugas
								AND
								apd.id_kelas=ak.id
								WHERE
								ap.id=?
								AND ak.publish=1
								',array($id_tugas));
		$out['tugas']=$query->result_array();						
		$out['file']=$this->getFileTugasByIdTugas($id_tugas);						
		//echo $this->db->last_query();
		return $out;
	}
	function getFileById($id_file){
		$query=$this->db->query('SELECT apf.* FROM
									ak_tugas_file apf JOIN
									ak_tugas ap 
									ON
									apf.id_tugas=ap.id
									WHERE apf.id=?
								',array($id_file));					
		//echo $this->db->last_query();
		return $query->result_array();
	}
	function getsiswaRemidiByIdKelasIdTugas($id_kelas,$id_tugas){
		$query=$this->db->query('SELECT * FROM ak_tugas ap JOIN
								 ak_tugas_det_remidial apd JOIN
								 ak_det_jenjang adj JOIN 
								 ak_siswa sis
								 ON ap.id=apd.id_tugas
								 AND apd.id_siswa_det_jenjang=adj.id
								 AND adj.id_siswa=sis.id
								 WHERE apd.id_kelas=?
								 AND
								 apd.id_tugas=?
								',array($id_kelas,$id_tugas));					
		//echo $this->db->last_query();
		return $query->result_array();
	}
	function getTugasByIdDetJenjang($id_det_jenjang){
		$query=$this->db->query('SELECT ap . *, ak.nama as nama_kelas, ak.kelas as kelas, ag.nama as nama_guru, aj.nama as nama_pelajaran
								FROM ak_tugas ap
								JOIN ak_det_jenjang adj
								ON ap.id_sekolah=adj.id_sekolah
								WHERE adj.id=?
								',array($id_det_jenjang));
		//echo $this->db->last_query();
		return $query->result_array();
	}
	function getDataByIdPegawaiGuru($limit=5,$id_user=0,$guruorsiswa=''){
	
		if($guruorsiswa=='guru'){
			$query=$this->db->query('SELECT ap . *,apj.nama as nama_pelajaran,ak.nama as nama_kelas,ak.kelas,peg.nama as guru
									FROM ak_tugas ap
									JOIN ak_tugas_det apd 
									JOIN ak_kelas ak
									JOIN ak_pelajaran apj
									JOIN ak_mengajar am
									JOIN ak_pegawai peg
									ON
									ap.id=apd.id_tugas
									AND
									apd.id_kelas=ak.id
									AND
									ap.id_pelajaran=apj.id
									AND
									am.id=apd.id_mengajar
									AND
									am.id_pegawai=peg.id
									WHERE
									ap.id_sekolah=?
									AND
									ak.publish=1
									AND am.id_pegawai=?
									GROUP BY ap.id
									ORDER BY ap.id DESC
									LIMIT '.$limit.'
									',array($this->session->userdata['user_authentication']['id_sekolah'],$id_user));
			$out=$query->result_array();
		}elseif($guruorsiswa=='siswa'){
			$query=$this->db->query('SELECT ap . *,apj.nama as nama_pelajaran,ak.nama as nama_kelas,ak.kelas,peg.nama as guru
									FROM ak_tugas ap
									JOIN ak_tugas_det apd 
									JOIN ak_mengajar am
									JOIN ak_pegawai peg
									JOIN ak_kelas ak
									JOIN ak_pelajaran apj
									JOIN ak_det_jenjang adj
									ON
									apd.id_tugas=ap.id
									AND
									apd.id_mengajar=am.id
									AND 
									am.id_pegawai=peg.id
									AND
									am.id_kelas=ak.id
									AND
									ap.id_pelajaran=apj.id
									AND 
									am.id_kelas=adj.id_kelas
									WHERE
									adj.id_siswa=?
									AND
									ap.id_sekolah=?
									AND
									apd.id_kelas=?
									AND
									ak.publish=1
									GROUP BY ap.id
									ORDER BY ap.id DESC
									LIMIT '.$limit.'
									',array($this->session->userdata['user_authentication']['id_siswa'],$this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['user_authentication']['id_kelas_siswa_det_jenjang']));
			$out=$query->result_array();		
		}elseif($guruorsiswa=='all'){
			$query=$this->db->query('SELECT ap . *,apj.nama as nama_pelajaran,ak.nama as nama_kelas,ak.kelas,peg.nama as guru
									FROM ak_tugas ap
									JOIN ak_tugas_det apd 
									JOIN ak_kelas ak
									JOIN ak_pelajaran apj
									JOIN ak_mengajar am
									JOIN ak_pegawai peg
									ON
									apd.id_tugas=ap.id
									AND
									apd.id_kelas=ak.id
									AND
									ap.id_pelajaran=apj.id
									AND
									am.id=apd.id_mengajar
									AND
									am.id_pegawai=peg.id
									WHERE
									ap.id_sekolah=?
									AND
									ak.publish=1
									GROUP BY ap.id
									ORDER BY ap.id DESC
									LIMIT '.$limit.'
									',array($this->session->userdata['user_authentication']['id_sekolah']));
			$out=$query->result_array();		
		}
		//echo $this->db->last_query();
		return $out;
	}
	function getIdKelasPenerima($id=0){
		$query=$this->db->query('SELECT ak.* FROM ak_tugas_det apd JOIN ak_kelas ak ON apd.id_kelas=ak.id WHERE apd.id_tugas=?',array($id));
		$out=$query->result_array();	
		
		return $out;
	}
	function getTugasStok($id_pelajaran=0){
		$query=$this->db->query('SELECT * FROM `ak_tugas` a WHERE
									a.id_sekolah='.$this->session->userdata['user_authentication']['id_sekolah'].'
									AND a.id_pegawai='.$this->session->userdata['user_authentication']['id_pengguna'].'
									AND a.id_pelajaran='.$id_pelajaran.'
								');
		//echo $this->db->last_query();
		return $query->result_array();	
	}
	
	function gettugasByKelasPelajaranIdPegawaiKirim($id_pelajaran=0,$id_kelas=0,$id_tugasarray=array(),$start=0,$page=0,$id_penggunas=0){
		
		if($id_penggunas!=0){
			$id_pengguna=$id_penggunas;
		}else{
			$id_pengguna=$this->session->userdata['user_authentication']['id_pengguna'];
		}
		
		$cnd='';
		$cnd2='';
		$tugas=array();
		if($id_pelajaran!=0){$cnd='AND amp.id_pelajaran="'.mysql_real_escape_string($id_pelajaran).'"';}
		if($id_kelas!=0){$cnd2='AND amk.id_kelas="'.mysql_real_escape_string($id_kelas).'"';}
		if(!empty($id_tugasarray)){ $cndin='AND amp.id IN('.implode(',',$id_tugasarray).')';}else{$cndin='';}
		$query=$this->db->query('SELECT amk.*,ak.nama as nama_kelas,ak.kelas FROM ak_tugas amp JOIN
								 ak_tugas_det amk JOIN ak_kelas ak
								 ON
								 amp.id=amk.id_tugas
								 AND amk.id_kelas=ak.id
								 WHERE
								 amp.id_sekolah=?
								 '.$cnd.'
								 '.$cnd2.'
								 AND amp.id_pegawai=?
								 '.$cndin.'
								 GROUP BY amp.id
								 ORDER BY amp.id DESC
								',array($this->session->userdata['user_authentication']['id_sekolah'],$id_pengguna));
								//echo $this->db->last_query();
		foreach($query->result_array() as $mtrkrm){
			$tugas[$mtrkrm['id_tugas']][$mtrkrm['id']]=$mtrkrm;
		}
		return $tugas;
	}
 }
 