<?php
Class Ad_artikel extends CI_Model{

	function getkatById($id=0){
		$query=$this->db->query('SELECT * FROM ak_kategori_artikel WHERE id_kategori='.$id.'');
		//echo $this->db->last_query();
		return $query->result_array();
	}
	function getkatPaging($limit='0,0'){
		$query=$this->db->query('SELECT * FROM ak_kategori_artikel LIMIT '.$limit.'');
		//echo $this->db->last_query();
		return $query->result_array();
	}
	function getkat(){
		$query=$this->db->query('SELECT * FROM ak_kategori_artikel');
		//echo $this->db->last_query();
		return $query->result_array();
	}
	function getkathomeisslide(){
		$query=$this->db->query('SELECT * FROM ak_kategori_artikel WHERE is_slide_home=1');
		//echo $this->db->last_query();
		return $query->result_array();
	}
	function getdatahome(){
		$query=$this->db->query('SELECT *
								FROM ak_artikel aa
								JOIN ak_slide_poshome asp
								JOIN ak_kategori_artikel aka ON aa.id_artikel = asp.id_artikel
								AND aka.id_kategori = aa.id_kategori
								WHERE aka.is_slide_home
								');
		//echo $this->db->last_query();
		return $query->result_array();
	}
	function getkathomebyIdkat($id_kat=1){
	
		$query=$this->db->query('SELECT * FROM ak_kategori_artikel WHERE is_slide_home=1 AND id_kategori='.$id_kat.'');
		$kat=$query->result_array();
		//pr($kat);die();
		//foreach($kat as $ky => $dtkt){
		if($kat[0]['id_kategori']==''){$kat[0]['id_kategori']=1;}
			$query2=$this->db->query('SELECT aa.judul,aa.id_artikel,aa.id_kategori,aa.foto,aa.sub_desc,asp.*
								FROM ak_artikel aa
								JOIN ak_slide_poshome asp
								ON aa.id_artikel = asp.id_artikel
								WHERE  aa.id_kategori='.$kat[0]['id_kategori'].'
								');
								
			$dataart=$query2->result_array();			
			foreach($dataart as $ky2=>$dtkt2){
				$dataart2[$dtkt2['position']]=$dtkt2;
			}	
	
			$kat[0]['data']=$dataart2;
			unset($dataart);		
			unset($dataart2);		
		//}
		//echo $this->db->last_query();
		return $kat;
	}
	function getkathome(){
		$query=$this->db->query('SELECT * FROM ak_kategori_artikel WHERE is_slide_home=1');
		$kat=$query->result_array();
		foreach($kat as $ky => $dtkt){
			$query2=$this->db->query('SELECT aa.judul,aa.id_artikel,aa.id_kategori,aa.foto,asp.*
								FROM ak_artikel aa
								JOIN ak_slide_poshome asp
								JOIN ak_kategori_artikel aka ON aa.id_artikel = asp.id_artikel
								AND aka.id_kategori = aa.id_kategori
								WHERE aka.is_slide_home=1 AND aa.id_kategori='.$dtkt['id_kategori'].'
								');
								
			$dataart=$query2->result_array();			
			foreach($dataart as $ky2=>$dtkt2){
				$dataart2[$dtkt2['position']]=$dtkt2;
			}	
	
			$kat[$ky]['data']=$dataart2;
			unset($dataart);		
			unset($dataart2);		
		}
		//echo $this->db->last_query();
		return $kat;
	}
	function getCountArtikelKat(){
	
		$query=$this->db->query('SELECT COUNT(*) as count FROM ak_kategori_artikel');
		//echo $this->db->last_query();
		$rslt=$query->result_array();				
		return $rslt[0]['count'];
	}
	function getCountArtikel($id_kategori=0){
	
		$query=$this->db->query('SELECT COUNT(*) as count FROM ak_artikel WHERE id_kategori='.$id_kategori.'');
		//echo $this->db->last_query();
		$rslt=$query->result_array();				
		return $rslt[0]['count'];
	}
	function getdataByIdKat($id_kategori){
		$query=$this->db->query('SELECT * FROM ak_artikel WHERE id_kategori='.$id_kategori.'');
		//echo $this->db->last_query();
		return $query->result_array();
	}
	function getdataByIdKatPaging($id_kategori=0,$limit='0,0'){
		$query=$this->db->query('SELECT * FROM ak_artikel WHERE id_kategori='.$id_kategori.' LIMIT '.$limit.'');
		//echo $this->db->last_query();
		return $query->result_array();
	}
	function getdataSponsor($limit=4){
		$query=$this->db->query('SELECT art.*,u.username,kat.nama_kategori FROM 
								ak_artikel art JOIN
								users u JOIN ak_kategori_artikel kat
								ON 
								art.id_user=u.id AND 
								kat.id_kategori=art.id_kategori
								WHERE art.id_kategori=3 AND art.status=1
								ORDER BY viewed DESC LIMIT '.$limit.'');
		//echo $this->db->last_query();
		return $query->result_array();
	}
	function getdataPopuler($limit=4){
		$query=$this->db->query('SELECT art.*,u.username,kat.nama_kategori FROM 
								ak_artikel art JOIN
								users u JOIN ak_kategori_artikel kat
								ON 
								art.id_user=u.id AND 
								kat.id_kategori=art.id_kategori
								WHERE   art.status=1
								ORDER BY viewed DESC LIMIT '.$limit.'');
		//echo $this->db->last_query();
		return $query->result_array();
	}
	function getdataByid($id=0){
		$query=$this->db->query('SELECT art.*,u.username,kat.nama_kategori FROM 
								ak_artikel art JOIN
								users u JOIN ak_kategori_artikel kat
								ON 
								art.id_user=u.id AND 
								kat.id_kategori=art.id_kategori
								WHERE art.id_artikel='.$id.' AND art.status=1');
		//echo $this->db->last_query();
		return $query->result_array();
	}
	function countcomment($id=0){
		$query=$this->db->query('SELECT COUNT(*) as cnt FROM ak_comment
								WHERE ak_comment.jenis="artikel" AND id_information='.$id.'');
		//echo $this->db->last_query();
		return $query->result_array();
	}
	function getselectartikelbykat($id_kat=0){
		$query=$this->db->query('SELECT id_artikel,judul  FROM ak_artikel
								WHERE status=1 AND id_kategori='.$id_kat.' ORDER BY id_artikel DESC');
		//echo $this->db->last_query();
		$artkat= $query->result_array();
		foreach($artkat as $datart){
			echo "<option value='".$datart['id_artikel']."'>".$datart['judul']."</option>";
		}
	}
  
 }
 