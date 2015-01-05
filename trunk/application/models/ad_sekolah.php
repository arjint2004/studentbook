<?php
Class Ad_sekolah extends CI_Model
{
	 function getSekolahdata($id_sekolah=null,$field=null){
	 $join='JOIN kota ON ak_sekolah.kota=kota.IDkota JOIN provinsi ON  ak_sekolah.prop=provinsi.IDprov';
	 if($field==null){
		$query=$this->db->query('SELECT * FROM ak_sekolah '.$join.' WHERE id='.$id_sekolah.'');
	 }else{
		$query=$this->db->query('SELECT '.implode(',',$field).' FROM ak_sekolah '.$join.' WHERE id='.$id_sekolah.'');
	 }//echo $this->db->last_query();	
		return $query->result_array();		
	 }
	 
	 function getfiturbyname($id_sekolah=null,$fitur=null){
		$query=$this->db->query('SELECT * FROM ak_fitur_sekolah  WHERE id_sekolah='.$id_sekolah.' AND fitur="'.$fitur.'"');
		return $query->result_array();	
	 }
	 function getSekolahdataandUser($id_sekolah=null,$field=null){
	 if($field==null){
		$query=$this->db->query('SELECT * FROM ak_sekolah ask JOIN users u on ask.id=u.id_sekolah WHERE ask.id='.$id_sekolah.'');
	 }else{
		$query=$this->db->query('SELECT '.implode(',',$field).' FROM ak_sekolah ask JOIN users u on ask.id=u.id_sekolah WHERE ask.id='.$id_sekolah.'');
	 }
		return $query->result_array();		
	 }
	 
	 function getFitur($id_sekolah=null){
		$query=$this->db->query('SELECT * FROM ak_fitur_sekolah  WHERE id_sekolah='.$id_sekolah.'');
		$f= $query->result_array();		
		$f2=array();
		foreach($f as $dataf){
			$f2[$id_sekolah][$dataf['fitur']]=$dataf;
		}
		unset($f);
		
		return $f2;
	}
	 
	 function getKepsek($id_sekolah=null){
		$query=$this->db->query('SELECT dg.id as id_det_group,u.id as id_user, u.username, u.id_pengguna, u.aktif, p.password,p.*
									FROM ak_pegawai p
									JOIN users u
									JOIN det_group dg
									JOIN ak_sekolah ask ON u.id_pengguna = p.id
									AND u.id = dg.id_user
									AND dg.id_group =16
									AND u.id_sekolah = ask.id
									WHERE u.id_sekolah ='.$id_sekolah.'');
		return $query->result_array();		
	 }
	 
	 function getdataSekolah($limit='0,10',$cond='')
	 { 
	   $query=$this->db->query('SELECT `ak_sekolah` . *, users.aktif, users.id as id_user
								FROM 
								`ak_sekolah` JOIN
								`users`
								ON
								ak_sekolah.id=users.id_sekolah
								WHERE 1 '.$cond.'
								AND users.id_group=11
								ORDER BY ak_sekolah.nama_sekolah ASC
								LIMIT '.$limit.'
								');
		//echo $this->db->last_query();						
	   return $query->result_array();
	 }
	 function getdataSekolahsms($limit='0,10',$cond='')
	 { 
	   $query=$this->db->query('SELECT `ak_sekolah` . *, users.aktif, users.id as id_user
								FROM 
								`ak_sekolah` JOIN
								`users`
								ON
								ak_sekolah.id=users.id_sekolah
								WHERE 1 '.$cond.'
								AND users.id_group=11
								ORDER BY ak_sekolah.aktifasisendername ASC
								LIMIT '.$limit.'
								');
		//echo $this->db->last_query();
	   return $query->result_array();
	 }
 
	function getsekolahcountall($cond)
	 {
	   
	    $query=$this->db->query('SELECT count(*) as count
								FROM (
								`ak_sekolah`
								)
								WHERE 1 '.$cond.'
								');
	   $rslt= $query->result_array();
	   return $rslt[0]['count'];
	 }
	 public function getAllCols(){
		   include('application/config/database.php');
	 	   $query=$this->db->query("
				SELECT DISTINCT TABLE_NAME
				FROM INFORMATION_SCHEMA.COLUMNS
				WHERE COLUMN_NAME
				IN (
				'id_sekolah'
				)
				AND TABLE_SCHEMA = '".$db['default']['database']."'
		   ");
		//echo $this->db->last_query();
	   return $query->result_array();

	 }
	 public function get_provinsi()
			{
				$this->db->select('*');
				$this->db->from('provinsi');
				$this->db->order_by('NmProv','ASC');
				$sql = $this->db->get();
				if($sql->num_rows()>0) {
					return $sql->result();
				}else {
					return '';
				}
				
	 }
}