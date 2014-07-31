<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Commentmodel extends CI_Model{
     
		function __construct()
		{
		parent::__construct();
		$this->load->library('session');
		}
       public function getcommentfoto($id_siswa,$id_pegawai)
        {
			//pr($id_siswa);
			$siswafoto=array();
			if(!empty($id_siswa)){
			$siswafoto= $this->db->query("SELECT id,foto,nama FROM ak_siswa WHERE id IN(".implode(',',$id_siswa).")")->result_array();
			}
			
			$pegawaifoto=array();
			if(!empty($id_pegawai)){
			$pegawaifoto= $this->db->query("SELECT id,foto,nama FROM ak_pegawai WHERE id IN(".implode(',',$id_pegawai).")")->result_array();
			}
			$mergerdata=array_merge($siswafoto,$pegawaifoto);
			foreach($mergerdata as $dtxp){
				$out[$dtxp['id']]=$dtxp;
			}
			return $out;
		}
       public function getcommentGroupByIdUser($id,$jenis)
        {
			return $this->db->query("SELECT * FROM ak_comment WHERE	id_information=".$id." AND jenis='".$jenis."' GROUP BY id_user")->result_array();
		}
       public function getDataOwnerComment($id,$jenis)
        {
			if($jenis=='materi'){
				$jenis='materi_pelajaran';
			}
			return $this->db->query("SELECT cm.id as id_user , cm.id_group FROM users cm JOIN ak_".$jenis." jns
									ON cm.id=jns.id_pegawai
									WHERE	jns.id=".$id." GROUP BY id_user")->result_array();
		}
       public function getcomment($id,$jenis)
        {
			return $this->db->query("SELECT * FROM ak_comment WHERE	id_information=".$id." AND jenis='".$jenis."' ORDER BY date DESC")->result_array();
		}
        public function getcommentreply($id)
        {
			return $this->db->query("SELECT * FROM ak_commentreply WHERE	id_comment=".$id." ORDER BY date ASC")->result_array();
		}
        public function savecomment($id,$data)
        {
             if($this->db->query("INSERT INTO ak_comment SET id_information=".$id." ,jenis='".$data['jenis']."' ,id_user='".$this->session->userdata['user_authentication']['id']."',id_group='".$this->session->userdata['user_authentication']['id_group']."' , comment='".mysql_real_escape_string($data['comment'])."' ,`date`='".date("Y-m-d H:i:s")."', publish=1")){
				return true;
			 }else{
				return false;
			 }
        }
        public function delcommentpost($id){
			if($this->db->query("DELETE FROM ak_comment WHERE id=".$id."")){
				$this->db->query("DELETE FROM ak_commentreply WHERE id_comment=".$id."");
				return true;
			 }else{
				return false;
			 }		
		}
        public function delcommentreply($id){
			if($this->db->query("DELETE FROM ak_commentreply WHERE id=".$id."")){
				return true;
			 }else{
				return false;
			 }		
		}
        public function editcommentpost($id,$reply){
			 if($this->db->query("UPDATE ak_comment SET comment='".mysql_real_escape_string($reply['commentpost'])."' ,`date`='".date("Y-m-d  H:i:s")."', publish=1 WHERE id=".$id."")){
				return true;
			 }else{
				return false;
			 }		
		}
        public function editcommentreply($id,$reply){
			 if($this->db->query("UPDATE ak_commentreply SET comment='".mysql_real_escape_string($reply['commentreply'])."' ,`date`='".date("Y-m-d  H:i:s")."', publish=1 WHERE id=".$id."")){
				return true;
			 }else{
				return false;
			 }		
		}
        public function savecommentreply($id,$reply)
        {
		if($this->db->query("INSERT INTO ak_commentreply SET id_comment=".$id.",jenis='".$reply['jenis']."' ,id_user='".$this->session->userdata['user_authentication']['id']."',id_group='".$this->session->userdata['user_authentication']['id_group']."' , comment='".mysql_real_escape_string($reply['commentreply'])."' ,`date`='".date("Y-m-d  H:i:s")."', publish=1")){
				return true;
			 }else{
				return false;
			 }
        }
}