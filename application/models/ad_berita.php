<?php
    class Ad_berita extends CI_Model
    {
    
        public function get_data($limit=4,$offset=5)
        {
			$query=$this->db->query('SELECT b.*,u.username,k.nama_sekolah FROM 
									sc_berita b JOIN 
									users u JOIN ak_sekolah k
									ON 
									b.id_admin=u.id 
									AND b.id_sek=k.id
									ORDER BY tgl_berita DESC LIMIT '.$limit.','.$offset.'');
			//echo $this->db->last_query();
			return $query->result_array();
        } 
        public function get_berita_sc_terkini($limit=4)
        {
			$query=$this->db->query('SELECT * FROM sc_berita ORDER BY tgl_berita DESC LIMIT '.$limit.'');
			//echo $this->db->last_query();
			return $query->result_array();
        } 
        public function tot_paging_berita()
        {
            $this->db->from('sc_berita');
            $this->db->where('stat_berita','aktif'); 
            $sql = $this->db->get();
            if($sql->num_rows()>0) {
                return $sql->num_rows();
            }else{
                return '';
            }
        } 
        public function get_berita_by_id($id=0,$limit=4)
        {
			$query=$this->db->query('SELECT art.*,u.username, ase.nama_sekolah FROM 
								sc_berita art JOIN
								users u JOIN
								ak_sekolah ase
								ON 
								art.id_admin=u.id AND
								ase.id=art.id_sek
								WHERE art.id_berita='.$id.' AND art.stat_berita="aktif"');
			//echo $this->db->last_query();
			return $query->result_array();
        }  
		function countcomment($id=0){
			$query=$this->db->query('SELECT COUNT(*) as cnt FROM ak_comment
									WHERE ak_comment.jenis="berita" AND id_information='.$id.'');
			//echo $this->db->last_query();
			return $query->result_array();
		}
		
    }
?>