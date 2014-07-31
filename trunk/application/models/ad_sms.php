<?php
Class Ad_sms extends CI_Model{
	
	function getCurrentSms($tanggal){
		$query=$this->db->query('SELECT * FROM ak_notifikasi_sms sms
								JOIN ak_det_jenjang adj
								ON adj.id=sms.id_det_jenjang
								WHERE date(sms.waktu)=? AND adj.id_kelas=?',array($tanggal,$_POST['id_kelas']));
		//echo $this->db->last_query();
		return $query->result_array();
	}
}
 