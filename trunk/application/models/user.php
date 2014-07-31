<?php
Class User extends CI_Model
{
 function cekusername($username)
 {
	$query=$this->db->query('SELECT COUNT(*) as countusername FROM users WHERE username="'.$username.'"');
	$result=$query->result_array();
	return $result[0]['countusername'];
 }
 function login($username, $password)
 {
   $this->db->select('users.id, users.username, users.password, group.id as id_group,group.otoritas');
   $this->db->from('users');
   $this->db->join('group', 'users.id_group = group.id');
   $this->db->where('username = ' . "'" . $username . "'");
   $this->db->where('password = ' . "'" . MD5($password) . "'");
   $this->db->limit(1);

   $query = $this->db->get();

   if($query->num_rows()==1)
   {
     return $query->result();
   }
   else
   {
     return false;
   }
 }
 
 /*function getuserByIdUser($id_user){
	$query=$this->db->query('SELECT g.*,u.id_pengguna FROM users u 
							JOIN group g
							ON
							u.id_group=g.id
							WHERE u.id='.$id_user.'
							');
	$group= $query->result_array();
	pr($group);
 }*/
}
?>