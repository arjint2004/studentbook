<?php
Class Ad_sms extends CI_Model{
	
	function getCurrentSms($tanggal){
		$query=$this->db->query('SELECT sms.* FROM ak_notifikasi_sms sms
								JOIN ak_det_jenjang adj
								ON adj.id=sms.id_det_jenjang
								WHERE date(sms.waktu)=? AND adj.id_kelas=?',array($tanggal,$_POST['id_kelas']));
		//echo $this->db->last_query();
		return $query->result_array();
	}
	
	/*function getCurrentSms($tanggal){
		$query=$this->db->query('SELECT * FROM ak_notifikasi_sms sms
								JOIN ak_det_jenjang adj
								ON adj.id=sms.id_det_jenjang
								WHERE date(sms.waktu)=? 
								AND adj.id_kelas=?
								AND sms.id_pelajaran=?
								',array($tanggal,$_POST['id_kelas'],$_POST['id_pelajaran']));
		//echo $this->db->last_query();
		return $query->result_array();
	}*/
	function getSms($tanggal='',$start=0,$offset=0){
		if($tanggal==''){$tanggal=date('Y-m-d');}
		$query=$this->db->query('SELECT * FROM ak_sms
								WHERE date(waktu)=? AND id_pegawai=? LIMIT '.$start.','.$offset.'',array($tanggal,$this->session->userdata['user_authentication']['id_pengguna']));
		//echo $this->db->last_query();
		return $query->result_array();
	}
	function getSmsCount(){
		$query=$this->db->query('SELECT COUNT(*) FROM ak_sms WHERE id_pegawai=?',array($this->session->userdata['user_authentication']['id_pengguna']));
		$cn=$query->result_array();
		return $cn[0]['COUNT(*)'];
	}
}
 