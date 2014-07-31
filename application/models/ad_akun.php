<?php
Class Ad_akun extends CI_Model
{
 function disableakun($id=null){
	if($id!=null){
		if($this->db->query("UPDATE users SET aktif=0 WHERE id=".$id."")){return true;}else{return false;}	
	}else{
		return false;
	}

 }
 function enableakun($id=null){
	if($id!=null){
		if($this->db->query("UPDATE users SET aktif=1 WHERE id=".$id."")){return true;}else{return false;}	
	}else{
		return false;
	}

 }
 function getsiswacountall($group=null,$id_kelas=null)
 {
   
   $this->db->select('count(*) as count');
   $this->db->from('users');
   $this->db->join('group', 'users.id_group = group.id');
   $this->db->join('ak_siswa', 'users.id_pengguna = ak_siswa.id');
   $this->db->join('ak_det_jenjang', 'ak_det_jenjang.id_siswa = ak_siswa.id');
   $this->db->where('group.id ='.$group.' AND users.id_sekolah='.$this->session->userdata['user_authentication']['id_sekolah'].'
						AND ak_det_jenjang.id_kelas="'.$id_kelas.'"
   ');
   //$this->db->limit($limit);

   $query = $this->db->get();
  // echo $this->db->last_query();
   $rslt= $query->result_array();
   return $rslt[0]['count'];
 }
 function getortucountall($group=null,$id_kelas=null)
 {
	if($id_kelas!=null){$conkelas=' AND adj.id_kelas='.$id_kelas.'';}else{$conkelas='';}
   
   $query=$this->db->query('SELECT COUNT(*) as count
							FROM ak_pegawai ap 
							JOIN ak_siswa asis
							JOIN ak_det_jenjang adj
							ON ap.id_siswa=asis.id
							AND asis.id=adj.id_siswa
							WHERE
							adj.id_sekolah='.$this->session->userdata['user_authentication']['id_sekolah'].'
							AND adj.id_kelas="'.$id_kelas.'"
							');
		//echo $this->db->last_query();
   $rslt=$query->result_array();
   return $rslt[0]['count'];
 }
 function getgurucountall($group=null)
 {
   $this->db->select('count(*) as count');
   $this->db->from('users');
   $this->db->join('group', 'users.id_group = group.id');
   $this->db->join('ak_pegawai', 'users.id_pengguna = ak_pegawai.id');
   $this->db->where('group.id ='.$group.' AND users.id_sekolah='.$this->session->userdata['user_authentication']['id_sekolah'].'');
   //$this->db->limit($limit);

   $query = $this->db->get();
   //echo $this->db->last_query();
   $rslt= $query->result_array();
   return $rslt[0]['count'];
 }
 function getCurrentOtoritas($id_user=null){
	$query=$this->db->query('SELECT u.id as id_user, dg.id_group as id_group, dg.id as id_det_group, g.otoritas FROM users u JOIN `group` g JOIN det_group dg ON u.id_group=g.id AND u.id=dg.id_user WHERE u.id='.$id_user.'');
	return $query->result_array();
 }
 function getdataortu($limit='0,10',$listtype=13,$cond='')
 { 
   $this->db->select('users.id as id_user, users.username, users.id_pengguna, users.aktif, ak_pegawai.password, group.id as id_group,group.otoritas,ak_siswa.nama as nama_siswa,ak_pegawai.*');
   $this->db->from('users');
   $this->db->join('group', 'users.id_group = group.id');
   $this->db->join('ak_pegawai', 'users.id_pengguna = ak_pegawai.id');
   $this->db->join('ak_siswa', 'ak_pegawai.id_siswa = ak_siswa.id');
   $this->db->join('ak_det_jenjang', 'ak_det_jenjang.id_siswa = ak_siswa.id');
   $aktifcond=' AND ak_pegawai.id_sekolah='.$this->session->userdata['user_authentication']['id_sekolah'].'';

   if($limit==null){
   $this->db->where('group.id ='.$listtype.' '.$aktifcond.' '.$cond.' AND ak_det_jenjang.id_ta='.$this->session->userdata['ak_setting']['ta'].' ORDER BY ak_pegawai.nama ASC');
   }else{
   $this->db->where('group.id ='.$listtype.' '.$aktifcond.' '.$cond.' AND ak_det_jenjang.id_ta='.$this->session->userdata['ak_setting']['ta'].' ORDER BY ak_pegawai.nama ASC LIMIT '.$limit.'');
   }
   
   //$this->db->limit($limit);

   $query = $this->db->get();
   //echo $this->db->last_query();
   return $query->result_array();
 }
 function getdataSiswaByDetjenjang($id_siswa_det_jenjang=null)
 {  

	$query=$this->db->query('SELECT sis.* FROM ak_siswa sis JOIN ak_det_jenjang adj 
							 ON
							 adj.id_siswa=sis.id
							 WHERE adj.id='.$id_siswa_det_jenjang.'
							 ');
	$out=$query->result_array();		
	//echo $this->db->last_query();
	return $out;
 }
 function getUsersByIdGroup($id_group=0)
 {  

	$query=$this->db->query('SELECT `group`.otoritas ,users.* FROM users JOIN `group` ON users.id_group=`group`.id WHERE users.id_group='.$id_group.' ORDER BY users.id DESC');
	$out=$query->result_array();		
	//echo $this->db->last_query();
	return $out;
 }
 function getdata($limit='0,10',$listtype=13,$aktif=null)
 {
   $this->db->select('users.id as id_user, users.username, users.id_pengguna, users.aktif, ak_pegawai.password, group.id as id_group,group.otoritas,ak_pegawai.*');
   $this->db->from('users');
   $this->db->join('group', 'users.id_group = group.id');
   $this->db->join('ak_pegawai', 'users.id_pengguna = ak_pegawai.id');
   $aktifcond=' AND ak_pegawai.id_sekolah='.$this->session->userdata['user_authentication']['id_sekolah'].'';
   if($aktif!=null){
		$aktifcond .=" AND users.aktif=".$aktif."";
   }
   if($limit==null){
   $this->db->where('group.id ='.$listtype.' '.$aktifcond.' ORDER BY ak_pegawai.nama ASC');
   }else{
   $this->db->where('group.id ='.$listtype.' '.$aktifcond.'  ORDER BY ak_pegawai.nama ASC LIMIT '.$limit.'');
   }
   
   //$this->db->limit($limit);

   $query = $this->db->get();
   //echo $this->db->last_query();
   return $query->result_array();
 }
 function getdataById($id_pengguna=null,$listtype=13,$aktif=null)
 {
   $this->db->select('users.id as id_user, users.username, users.id_pengguna, users.aktif, ak_pegawai.password,ak_pegawai.nama, group.id as id_group,group.otoritas,ak_pegawai.*');
   $this->db->from('users');
   $this->db->join('group', 'users.id_group = group.id');
   $this->db->join('ak_pegawai', 'users.id_pengguna = ak_pegawai.id');
   $aktifcond=' AND ak_pegawai.id_sekolah='.$this->session->userdata['user_authentication']['id_sekolah'].' AND users.id_pengguna='.$id_pengguna.'';
   if($aktif!=null){
		$aktifcond .=" AND users.aktif=".$aktif."";
   }
   $this->db->where('group.id ='.$listtype.' '.$aktifcond.' ORDER BY ak_pegawai.nama ASC');
   
   //$this->db->limit($limit);

   $query = $this->db->get();
   //echo $this->db->last_query();
   return $query->result_array();
 }
 function getdataSiswaOrtu($limit='0,10',$listtype=12,$cond='')
 {
   $this->db->select('users.id as id_user, users.username, users.aktif, ak_siswa.password, group.id as id_group,group.otoritas,ak_siswa.nama,ak_siswa.tgl_daftar,ak_siswa.NmOrtu,ak_siswa.id,ak_siswa.nis,ak_det_jenjang.id as id_siswa_det_jenjang');
   $this->db->from('users');
   $this->db->join('group', 'users.id_group = group.id');
   $this->db->join('ak_siswa', 'users.id_pengguna = ak_siswa.id');
   $this->db->join('ak_det_jenjang', 'ak_det_jenjang.id_siswa = ak_siswa.id');
   $this->db->where('group.id ='.$listtype.' '.$cond.' AND ak_det_jenjang.id_ta='.$this->session->userdata['ak_setting']['ta'].' ORDER BY ak_siswa.nama ASC LIMIT '.$limit.'');
   //$this->db->limit($limit);

   $query = $this->db->get();
   //echo $this->db->last_query();
   return $query->result_array();
 }
 
 function cekAvailabelUsername($username=null)
 {
	if($username!=null){
	   $this->db->select('count(*) as available_username');
	   $this->db->from('users');
	   $this->db->where('users.username ="'.$username.'"');

	   $query = $this->db->get();
	   //echo $this->db->last_query();
	   $rslt=$query->result_array();
	   if($rslt[0]['available_username']==0){
			//echo 'available';
			return true;
			
	   }else{
			//echo 'not_available';
			return false;
	   }
	} 
 }
 
 function getGuruBySekolah(){
       $this->db->select('users.id as id_user, users.aktif, group.id as id_group,group.otoritas,ak_pegawai.nama,ak_pegawai.id as id_peg');
	   $this->db->from('users');
	   $this->db->join('group', 'users.id_group = group.id');
	   $this->db->join('ak_pegawai', 'users.id_pengguna = ak_pegawai.id');
	   $this->db->where('group.id =13 AND ak_pegawai.id_sekolah='.$this->session->userdata['user_authentication']['id_sekolah'].' ORDER BY ak_pegawai.nama ASC');
	   $query = $this->db->get();
	   //echo $this->db->last_query();
	   return $query->result_array();
 }
 function getFreePegawai($id_pegawai=null,$id_sekolah=null){
	$table=array(
				'ak_catatanguru',
				'ak_extrakurikuler',
				'ak_harian',
				'ak_jurnal_wali',
				'ak_kelas',
				'ak_materi_pelajaran',
				'ak_mengajar',
				'ak_pr',
				'ak_prestasi',
				'ak_subject_nilai',
				'ak_timeline_pembelajaran',
				'ak_tugas',
				'ak_uas',
				'ak_uts'
	);
	foreach($table as $namatable){

		$q=$this->db->query('SELECT COUNT(*) AS count FROM '.$namatable.' WHERE id_pegawai='.$id_pegawai.'');

		$c=$q->result_array();
		//$out[$namatable]=$c;
		//echo $this->db->last_query();
		//pr($c);
		$out=$out+$c[0]['count'];
	}
	return $out;
 }

 function getFreesiswa($detjenjang=null,$id_sekolah=null){
	
	$table=array(
				'ak_absensi',
				'ak_catatan_raport',
				'ak_catatanguru',
				'ak_harian_det_remidial',
				'ak_jurnal_wali',
				'ak_nilai_afektif',
				'ak_nilai_ekstrakurikuler',
				'ak_nilai_kegiatan_sekolah',
				'ak_nilai_kompetensi',
				'ak_nilai_lain_lain',
				'ak_nilai_pr',
				'ak_nilai_praktik',
				'ak_nilai_tugas',
				'ak_nilai_uan',
				'ak_nilai_uas',
				'ak_nilai_ulangan_harian',
				'ak_nilai_uts',
				'ak_pr_det_remidial',
				'ak_prestasi',
				'ak_siswa_ekstrakurikuler',
				'ak_siswa_notif',
				'ak_tugas_det_remidial',
				'ak_uas_det_remidial',
				'ak_uts_det_remidial'
	);
	foreach($table as $namatable){
		if($namatable=='ak_catatan_raport'){
			$q=$this->db->query('SELECT COUNT(*) AS count FROM '.$namatable.' WHERE id_det_jenjang='.$detjenjang[0]['id'].'');
		}else{
			$q=$this->db->query('SELECT COUNT(*) AS count FROM '.$namatable.' WHERE id_siswa_det_jenjang='.$detjenjang[0]['id'].'');
		}
		$c=$q->result_array();
		$out=$out+$c[0]['count'];
	}
	return $out;
 }
 
 function cekAvailabelNIS($nis=null)
 {
	/*if($nis!=null){
	   $this->db->select('count(*) as available_nis');
	   $this->db->from('ak_siswa');
	   $this->db->where('ak_siswa.nis ="'.$nis.'" AND id_sekolah='.$this->session->userdata['user_authentication']['id_sekolah'].'');

	   $query = $this->db->get();
	   //echo $this->db->last_query();
	   $rslt=$query->result_array();
	   if($rslt[0]['available_nis']==0){
			return true;
	   }else{
			return false;
	   }
	}*/
	return true;

 }
}
?>