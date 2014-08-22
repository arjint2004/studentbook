<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Online
 *
 * This model contains the nessesary database functions for maintaining a list of currently online users
 *
 * @package		Online_Users
 * @author		Joseph Pugh
 */

class Online extends CI_Model
{
	private $table_online = 'online';
	function __construct()
	{
		parent::__construct();		
		$ci =& get_instance();
	}
	
	/**
	 * Check if the hit is unique per user id.
	 *
	 * @param	int
	 * @return	bool
	 */
	function is_online($user_id) {
		$q=$this->db->query('SELECT COUNT(*) as jml FROM '.$this->table_online.' WHERE user_id='.$user_id.'');
		$dt=$q->result_array();
		return $dt[0]['jml']; 
	}
	
	/**
	 * Insert a new online user.
	 *
	 * @param	array
	 * @return	void
	 */
	function set_online($data) {
		$this->db->insert($this->table_online, $data);
	}
	
	/**
	 * Update the user's last hit time.
	 *
	 * @param	int
	 * @return	void
	 */
	function update_online($user_id) {
		$this->db->set('time', time());
		$this->db->where('user_id', $user_id);
		$this->db->update($this->table_online);
	}
	
	/**
	 * Purge all expired online users.
	 *
	 * @param	int
	 * @return	void
	 */
	function purge_expired($expired) {
		$this->db->where('time <=', $expired);
		$this->db->delete($this->table_online);
	}
	
	/**
	 * Get an array of the currently online users.
	 *
	 * @return	array
	 */
	function get_online() { 
		$session = session_data();
		/*$this->db->select('user_id,username,
							(SELECT nama FROM ak_pegawai WHERE ak_pegawai.id=users.id) as nama_pegawai,
							(SELECT nama FROM ak_siswa WHERE ak_siswa.id=users.id) as nama_siswa
		');
		$this->db->from('online');
		$this->db->join('users','online.user_id=users.id_pengguna');
		$this->db->where('online.user_id !=',$session['id_pengguna']);
		$query = $this->db->get();return $query->result();*/
		

		$query=$this->db->query('SELECT users.id as user_id, `username` ,
								(
								
								SELECT nama
								FROM ak_pegawai
								WHERE ak_pegawai.id = users.id
								) AS nama_pegawai, 
								
								(
								SELECT nama
								FROM ak_siswa
								WHERE ak_siswa.id = users.id
								) AS nama_siswa
								
								FROM sc_teman
								JOIN users ON sc_teman.id_teman = users.id
								JOIN online ON online.user_id = users.id
								WHERE sc_teman.id_user ='.$session['id_pengguna'].'
								AND users.id !='.$session['id_pengguna'].'
								');
								
		return $query->result_object();
	}
}

/* End of file online.php */
/* Location: ./application/models/online.php */