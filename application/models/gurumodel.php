<?php
    class Gurumodel extends CI_Model
    {
        
        public function get_guru_by_id($id)
        {
            if($id!=0)
            {
                // $this->db->join('provinsi','sc_sekolah.IDprov=provinsi.IDprov','left');
                $this->db->join('ak_sekolah as s','s.id=p.id_sekolah','left');
                $this->db->where('p.id',$id);
                $sql = $this->db->get('ak_pegawai as p');
                if($sql->num_rows()>0) {
                    return $sql->row();
                }else {
                    return '';
                }
            }
        }
        
        
    }
?>