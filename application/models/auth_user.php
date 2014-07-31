<?php
    class Auth_user extends CI_Model
    {
        public function get_user($username,$password)
        {
            if(!empty($username) AND $password) {
                $this->db->select('a.*,b.otoritas,b.auth, s.nama_sekolah, s.alamat_sekolah, s.logo,ap.nama as nama_peg,ap.id_siswa,asis.nama as nama_siswa');
                $this->db->from('users a');
                $this->db->join('group b','a.id_group=b.id','left');
                $this->db->join('ak_sekolah s','s.id=a.id_sekolah','left');
                $this->db->join('ak_pegawai ap','ap.id=a.id_pengguna','left');
                $this->db->join('ak_siswa asis','asis.id=a.id_pengguna','left');
                $this->db->where('a.username',$username);
                $this->db->where('a.password',md5($password));
                $this->db->where('a.aktif',1);
                $sql = $this->db->get();
				//echo $this->db->last_query();
                if($sql->num_rows()>0) {
                    $sql = $sql->row();
                    return $sql;
                }
            }            
        } 
		public function get_det_group($id_user) {
			$query=$this->db->query('SELECT dg.*,g.otoritas,g.home_url FROM det_group dg JOIN `group` g ON g.id=dg.id_group WHERE dg.id_user='.mysql_real_escape_string($id_user).'');
			//echo $this->db->last_query();
			return $query->result_array();
		}
		public function get_auth($username,$password)
        {
            if(!empty($username) AND $password) {
                $query=$this->db->query("SELECT b.auth
					FROM (
					`users` a
					)
					JOIN `group` b
					JOIN `det_group` d ON `d`.`id_group` = `b`.`id`
					AND `a`.`id` = `d`.`id_user`
					WHERE `a`.`username` = ?
					AND `a`.`password` = ?
					AND `a`.`aktif` = 1 
				",array($username,md5($password)));
                
                if($query->num_rows()>0) {
                    $data = $query->result_array();
					$auths=array();
					//pr($data);
					foreach($data as $auth){
						$authnya=unserialize($auth['auth']);
						if(!empty($authnya)){
							$auths=array_merge($auths,$authnya);
						}
					}
                    return serialize($auths);
                }
            }            
        }
    }
?>