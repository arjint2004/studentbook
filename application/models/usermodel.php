<?php
class Usermodel extends CI_Model
{
    public function get_status_pribadi($id)
    {
        if($id!=0){
            $this->db->from('sc_status');
            $this->db->join('users','sc_status.id_user=users.id_pengguna');
            $this->db->join('sc_foto','sc_status.id_foto=sc_foto.id_foto','left');
            $this->db->where('kategori','pribadi');
            $this->db->where('id_untuk',$id);
            //$this->db->where('sc_status.id_foto !=','0');
            $this->db->order_by('sc_status.id_status','DESC');
            $this->db->limit(10);
            $sql = $this->db->get();
            if($sql->num_rows()>0) {
                $data['status'] = $sql->result();
                $komentar = array();
                foreach($sql->result() as $st_komen) {
                    $this->db->from('sc_komentar');
                    $this->db->join('users','users.id_pengguna=sc_komentar.id_user');
                    $this->db->where('sc_komentar.id_status',$st_komen->id_status);
                    $this->db->order_by('sc_komentar.id_komen','ASC');
                    $kom = $this->db->get();
                    if($kom->num_rows()>0) {
                          $komentar[$st_komen->id_status] = $kom->result();
                    }
                }
                $data['komentar'] = $komentar;
                return $data;
            }else {
                return '';
            }
        }
    }
    
    public function kirim_pesan()
    {
        $lampiran   = $_FILES['lampiran'];
        
        if(!empty($_FILES['lampiran']['tmp_name']))
        {
            $config['upload_path']      = $path_large = "upload/dokumen/surat_pribadi/";
            $config['allowed_types']    = 'docx|gif|jpg|png|doc|xls|xlsx|ppt|pptx|zip|rar|pdf';
            $config['max_size']	        = '30000000';
            $config['remove_spaces']    = 'TRUE';
            $this->load->library('upload', $config);
            if ( ! $this->upload->do_upload('lampiran'))
            {
                $error = array('error' => $this->upload->display_errors());
                print_r($error);exit;
            }
            else
            {
                $data       = array('upload_data' => $this->upload->data());
                $session    = session_data();
                $id_user    = $this->input->post('id_user');
                $pesan      = $this->input->post('pesan');
                $data = array('untuk'=>$id_user,
                              'pesan'=>$pesan,
                              'lampiran'=>$path_large."".$data['upload_data']['file_name'],
                              'penulis'=>$session['id_pengguna']);
                
                $this->db->insert('sc_pesan',$data);
            }
        }else{
                $data       = array('upload_data' => $this->upload->data());
                $session    = session_data();
                $id_user    = $this->input->post('id_user');
                $pesan      = $this->input->post('pesan');
                $data = array('untuk'=>$id_user,
                              'pesan'=>$pesan,
                              'penulis'=>$session['id_pengguna']);
                
                $this->db->insert('sc_pesan',$data);
        }

    }
    
    public function set_komentar_user()
    {
        $session = session_data();
        $user       = $this->input->post('user');
        $id_status  = $this->input->post('id_status');
        $komentar   = $this->input->post('komentar');
        if(!empty($id_status) AND !empty($komentar))
        {
            $data = array('id_status'=>$id_status,
                          'id_user'=>$session['id_pengguna'],
                          'komentar'=>$komentar);
            
            $this->db->insert('sc_komentar',$data);
            $id = $this->db->insert_id();
            
            if($user=='siswa') {
                $this->db->from('sc_komentar');
                $this->db->join('ak_siswa','ak_siswa.id=sc_komentar.id_user');
                $this->db->where('id_komen',$id);
                $sql = $this->db->get();
                if($sql->num_rows()>0) {
                    return $sql->row();
                }else{
                    return '';
                }
            }else{
                $this->db->from('sc_komentar');
                $this->db->join('ak_pegawai','ak_pegawai.id=sc_komentar.id_user');
                $this->db->where('id_komen',$id);
                $sql = $this->db->get();
                if($sql->num_rows()>0) {
                    return $sql->row();
                }else{
                    return '';
                }
            }
        }
    }
    
    public function get_view_profile($id)
    {
        $this->db->select('otoritas,id_sekolah');
        $this->db->from('users');
        $this->db->join('group','users.id_group=group.id');
        $this->db->where('users.id',$id);
        $this->db->limit('1');
        $sql= $this->db->get();
        if($sql->num_rows()>0) {
            $sql = $sql->row();
            $data['id_sekolah'] = $sql->id_sekolah;
            $sql = $sql->otoritas;
            if($sql=='siswa') {
                $data['jenis_user'] = $sql;
                $data['data_user']  = $this->get_siswa($id);
                return $data;
            }else{
                $data['jenis_user'] = $sql;
                $data['data_user']  = $this->get_pegawai($id);
                return $data;
            }
        }
    }
    
    public function get_siswa($id=0){
        if($id!=0) {
            $this->db->select('ak_siswa.id,
                              ak_siswa.id_sekolah,
                              ak_siswa.nama,
                              ak_siswa.alamat,
                              ak_siswa.kota,
                              ak_siswa.telp,
                              ak_siswa.email,
                              ak_siswa.foto,
                              ak_sekolah.id as id_sekolah,
                              ak_sekolah.nama_sekolah,
                              ak_sekolah.alamat_sekolah,
                              ak_sekolah.desa,
                              ak_sekolah.kec,
                              ak_sekolah.kota,
                              ak_sekolah.prop');
            $this->db->from('ak_siswa');
            $this->db->join('ak_sekolah','ak_siswa.id_sekolah=ak_sekolah.id','left');
            //$this->db->where('ak_siswa.aktif',1);
            $this->db->where('ak_siswa.id',$id);
            $sql = $this->db->get();
            if($sql->num_rows()>0) {
                return $sql->row();
            }else {
                return '';
            }
        }
    }
    
    public function get_pegawai($id=0){
        if($id!=0) {
            $this->db->select('a.id,
                              a.nip,
                              a.nama,
                              a.password,
                              a.id_sekolah,
                              a.tgl_lahir,
                              a.foto,
                              b.nama_sekolah,
                              b.id as id_sek,
                              b.alamat_sekolah');
            $this->db->from('ak_pegawai a');
            $this->db->join('ak_sekolah b','a.id_sekolah=b.id');
            //$this->db->join('ak_mengajar c','c.id_pegawai=a.id');
            //$this->db->join('ak_pelajaran d','d.id=c.id_pelajaran');
            //$this->db->join('ak_jurusan e','d.id_jurusan=e.id');
            $this->db->where('a.id',$id);
            $sql = $this->db->get();
            if($sql->num_rows()>0) {
                return $sql->row();
            }else {
                return '';
            }
        }
    }
    
    public function set_status_user()
    {
        $id_user    = $this->input->post('id_user');
        $status     = $this->input->post('status');
        $foto       = $this->input->post('images');
        $user       = $this->input->post('user');
        
        if(!empty($status))
        {
            $session = session_data();
            if(!empty($foto)) {
                $data = array('id_user'=>$session['id_pengguna'],
                              'small'=>'upload/images/thumb/'.$foto,
                              'medium'=>'upload/images/medium/'.$foto,
                              'large'=>'upload/images/larger/'.$foto,
                              'ket_foto'=>$status);
                $this->db->insert('sc_foto',$data);
                $id_foto = $this->db->insert_id();
                
                $data = array('pesan'=>$status,
                          'id_user'=>$session['id_pengguna'],
                          'id_foto'=>$id_foto,
                          'kategori'=>'pribadi',
                          'id_untuk'=>$id_user);
            
                $this->db->insert('sc_status',$data);
                $id = $this->db->insert_id();
                
                if($user=='siswa'){
                    $this->db->from('sc_status');
                    $this->db->join('ak_siswa','ak_siswa.id=sc_status.id_user');
                    $this->db->join('sc_foto','sc_status.id_foto=sc_foto.id_foto');
                    $this->db->where('id_status',$id);
                    $sql = $this->db->get();
                    if($sql->num_rows()>0) {
                        return $sql->row();
                    }else{
                        return '';
                    }
                }else{
                    $this->db->from('sc_status');
                    $this->db->join('ak_pegawai','ak_pegawai.id=sc_status.id_user');
                    $this->db->join('sc_foto','sc_status.id_foto=sc_foto.id_foto');
                    $this->db->where('id_status',$id);
                    $sql = $this->db->get();
                    if($sql->num_rows()>0) {
                        return $sql->row();
                    }else{
                        return '';
                    }
                }
            
            }else{
                $data = array('pesan'=>$status,
                          'id_user'=>$session['id_pengguna'],
                          'kategori'=>'pribadi',
                          'id_untuk'=>$id_user);
            
                $this->db->insert('sc_status',$data);
                $id = $this->db->insert_id();
                
                if($user=='siswa'){
                    $this->db->from('sc_status');
                    $this->db->join('ak_siswa','ak_siswa.id=sc_status.id_user');
                    $this->db->where('id_status',$id);
                    $sql = $this->db->get();
                    if($sql->num_rows()>0) {
                        return $sql->row();
                    }else{
                        return '';
                    }
                }else{
                    $this->db->from('sc_status');
                    $this->db->join('ak_pegawai','ak_pegawai.id=sc_status.id_user');
                    $this->db->where('id_status',$id);
                    $sql = $this->db->get();
                    if($sql->num_rows()>0) {
                        return $sql->row();
                    }else{
                        return '';
                    }
                }
            }
        }
    }
}
?>