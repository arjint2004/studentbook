<?php
Class Home_model extends CI_Model{

	function contact_us($data_pesan){
		$this->db->insert('contact', $data_pesan);
	}
}
 