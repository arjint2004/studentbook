<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Shorturl extends CI_Controller {
	
	function short($id=0){
		//$CI =& get_instance();
		$qdata=$this->db->query("SELECT u.username,ap.password FROM ak_pegawai ap JOIN users u ON u.id=ap.id WHERE u.id=?",array(base64_decode($id)));
		$data=$qdata->result_array();
		//pr($data);
		redirect('authentication/auth/'.$data[0]['username'].'/'.$data[0]['password'].'');
	}
}
?>