<?php
Class Ad_siswa extends CI_Model
{
	function getDetjenjang($id_siswa=null,$id_sekolah=null){
		$query=$this->db->query('SELECT * FROM 
							     ak_det_jenjang
								 WHERE id_siswa=?
								 AND id_sekolah=?
		',array($id_siswa,$id_sekolah));
		return $query->result_array();
	}
	function getsiswaByKelas($kelas=null){
		$query=$this->db->query('SELECT s.*, adj.id as id_siswa_det_jenjang FROM 
									ak_det_jenjang adj 
									JOIN ak_siswa s 
									JOIN ak_kelas ak 
									ON adj.id_siswa=s.id 
									AND adj.id_kelas=ak.id 
									WHERE 
									ak.kelas=? 
									AND adj.id_sekolah=?
									AND adj.id_ta=?
									AND ak.publish=1
									ORDER BY s.nama ASC',array($kelas,$this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['ak_setting']['ta']));
		return $query->result_array();
	}
	function getsiswaByIdSekTa(){
		$query=$this->db->query('SELECT s.nama,ap.hp  FROM
									ak_det_jenjang adj JOIN
									ak_siswa s JOIN
									ak_pegawai ap JOIN
									ak_fitur_sekolah af
									ON
									adj.id_siswa=s.id 
									AND s.id=ap.id_siswa
									AND s.id_sekolah=af.id_sekolah
									WHERE
									af.id_sekolah=?
									AND
									adj.id_sekolah=?
									AND adj.id_ta=?
									AND af.aktif=?
									',array($this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['ak_setting']['ta'],1));
		return $query->result_array();
	}
	function getKelulusanByIdKelasTa($id_kelas){
		$query=$this->db->query('SELECT s.nama as nama_siswa, adj.* FROM 
									ak_det_jenjang adj 
									JOIN ak_siswa s
									ON adj.id_siswa=s.id
									WHERE 
									adj.id_kelas=? 
									AND adj.id_sekolah=?
									AND adj.id_ta=?
									ORDER BY s.nama ASC',array($id_kelas,$this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['ak_setting']['ta']));
									//echo $this->db->last_query();
		return $query->result_array();
 
	}
	function getsiswaByIdKelas($id_kelas=null){
		$query=$this->db->query('SELECT s.*,ap.id as id_ortu,ap.hp, adj.id as id_siswa_det_jenjang FROM
									ak_det_jenjang adj 
									JOIN ak_siswa s 
									JOIN ak_kelas ak 
									JOIN ak_pegawai ap
									ON adj.id_siswa=s.id 
									AND adj.id_kelas=ak.id
									AND ap.id_siswa=s.id
									WHERE ak.id=?
									AND adj.id_sekolah=?
									AND adj.id_ta=?
									AND ak.publish=1
									ORDER BY s.nama ASC
									',array($id_kelas,$this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['ak_setting']['ta']));
		return $query->result_array();	
	}
	function getsiswaByIdSiswa($id_siswa=null){
		$query=$this->db->query('SELECT s.*, adj.id as id_siswa_det_jenjang, ak.id as id_kelas,ak.nama as nama_kelas, ak.kelas as kelas, aj.nama as nama_jurusan,ap.hp as hportu FROM
									 ak_det_jenjang adj 
									 JOIN ak_siswa s 
									 JOIN ak_kelas ak 
									 JOIN ak_jurusan aj 
									 JOIN ak_pegawai ap 
									 ON adj.id_siswa=s.id
									 AND adj.id_kelas=ak.id 
									 AND ak.id_jurusan=aj.id 
									 AND ap.id_siswa=s.id 
									 WHERE s.id=?
									AND ak.publish=1
									 ORDER BY s.nama ASC',array($id_siswa));
		return $query->result_array();	
	}
	function getsiswaByIdSiswaTa($id_siswa=null){
		$query=$this->db->query('SELECT s.*, adj.id as id_siswa_det_jenjang, ak.id as id_kelas,ak.nama as nama_kelas, ak.kelas as kelas, aj.nama as nama_jurusan,ap.hp as hportu FROM
									 ak_det_jenjang adj 
									 JOIN ak_siswa s 
									 JOIN ak_kelas ak 
									 JOIN ak_jurusan aj 
									 JOIN ak_pegawai ap 
									 ON adj.id_siswa=s.id
									 AND adj.id_kelas=ak.id 
									 AND ak.id_jurusan=aj.id 
									 AND ap.id_siswa=s.id 
									 WHERE s.id=? 
									 AND adj.id_ta=?
									AND ak.publish=1
									 ORDER BY s.nama ASC',array($id_siswa,$this->session->userdata['ak_setting']['ta']));
		return $query->result_array();	
	}
	function getsiswaByIdDetJenjang($id_det_jenjang=null){
		$query=$this->db->query('SELECT s.*, adj.id as id_siswa_det_jenjang, ak.id as id_kelas,ak.nama as nama_kelas, ak.kelas as kelas, aj.nama as nama_jurusan FROM
									 ak_det_jenjang adj 
									 JOIN ak_siswa s 
									 JOIN ak_kelas ak 
									 JOIN ak_jurusan aj 
									 ON adj.id_siswa=s.id
									 AND adj.id_kelas=ak.id 
									 AND ak.id_jurusan=aj.id 
									 WHERE adj.id=?
									AND ak.publish=1
									 ORDER BY s.nama ASC',array($id_det_jenjang));
		return $query->result_array();	
	}
	function getSiswaIdDetJenjang($id_sekolah,$ta,$id_siswa){
		$query=$this->db->query('SELECT s.*, adj.id as id_siswa_det_jenjang, adj.id_kelas as id_kelas_siswa_det_jenjang  FROM
									ak_det_jenjang adj JOIN
									ak_siswa s 
									ON
									adj.id_siswa=s.id 
									WHERE
									adj.id_sekolah=?
									AND adj.id_ta=?
									AND adj.id_siswa=?
									ORDER BY s.nama ASC',array($id_sekolah,$ta,$id_siswa));
		return $query->result_array();	
	}
	function getSiswaTaSekarang(){
		$query=$this->db->query('SELECT s.*, adj.id as id_siswa_det_jenjang, adj.id_kelas as id_kelas_siswa_det_jenjang  FROM
									ak_det_jenjang adj JOIN
									ak_siswa s 
									ON
									adj.id_siswa=s.id 
									WHERE
									adj.id_sekolah=?
									AND adj.id_ta=?
									AND adj.id_siswa=? 
									ORDER BY s.nama ASC',array($this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['ak_setting']['ta'],$this->session->userdata['user_authentication']['id_siswa']));
		return $query->result_array();	
	}
	function naikOrTinggalkelas($id_siswa,$id_kelas,$id_ta_berikutnya){
		$kelascurrentq=$this->db->query('SELECT * FROM
											ak_kelas WHERE
											id=?
											AND publish=1
										',array($id_kelas));
		$kelascurrent=$kelascurrentq->result_array();	
		
		$query=$this->db->query('SELECT adj.*, ak.kelas, ak.nama as nama_kelas, aj.nama as jurusan FROM
									ak_det_jenjang  adj
									JOIN ak_kelas ak
									JOIN ak_jurusan aj
									ON ak.id=adj.id_kelas
									AND aj.id=ak.id_jurusan
									WHERE
									adj.id_sekolah=?
									AND adj.id_siswa=?
									AND adj.id_ta=?
									AND ak.publish=1
									',array($this->session->userdata['user_authentication']['id_sekolah'],$id_siswa,$id_ta_berikutnya));
		$kenaikan=$query->result_array();	
		if(!empty($kenaikan)){
			if($kelascurrent[0]['kelas']==$kenaikan[0]['kelas']){
				$kenaikannya['statusnaik']='Tinggal di kelas '.$kelascurrent[0]['kelas'].''.$kelascurrent[0]['nama'].'';
			}else{
				$kenaikannya['statusnaik']='Naik ke kelas '.$kenaikan[0]['kelas'].''.$kenaikan[0]['nama_kelas'].'';
			}
			$kenaikannya['data']=$kenaikan;
			return	$kenaikannya;
		}else{
			$querylulusan=$this->db->query('SELECT adj.*, ak.kelas, ak.nama as nama_kelas, aj.nama as jurusan FROM
									ak_det_jenjang  adj
									JOIN ak_kelas ak
									JOIN ak_jurusan aj
									ON ak.id=adj.id_kelas
									AND aj.id=ak.id_jurusan
									WHERE
									adj.id_sekolah=?
									AND adj.id_siswa=?
									AND adj.id_ta=?
									AND ak.publish=1
									',array($this->session->userdata['user_authentication']['id_sekolah'],$id_siswa,$this->session->userdata['ak_setting']['ta']));
			$kelulusan=$querylulusan->result_array();
			if($kelulusan[0]['kelulusan']==1){
				$kelulusannya['statuslulus']='LULUS';
			}elseif($kelulusan[0]['kelulusan']==0){
				$kelulusannya['statuslulus']='TIDAK LULUS';
			}elseif($kelulusan[0]['kelulusan']==2){
				$kelulusannya['statuslulus']='BELUM LULUS';
			}
			$kelulusannya['data']=$kelulusan;		
			return	$kelulusannya;
		}	
		
	}
	function getSiswaTaBerikut($id_ta_berikutnya,$id_kelas){
		$query=$this->db->query('SELECT s.*, adj.id as id_siswa_det_jenjang, adj.id_kelas as id_kelas_siswa_det_jenjang  FROM
									ak_det_jenjang adj JOIN
									ak_siswa s 
									ON
									adj.id_siswa=s.id 
									WHERE
									adj.id_sekolah=?
									AND adj.parent_kelas=?
									AND adj.id_ta=?
									ORDER BY s.nama ASC',array($this->session->userdata['user_authentication']['id_sekolah'],$id_kelas,$id_ta_berikutnya));
		return $query->result_array();	
	}
}
?>