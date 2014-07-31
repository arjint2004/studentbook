<?php
    class Group_model extends CI_Model
    {
        public function get_data_group($id)
        {
            if($id!=0) {
                $this->db->from('sc_group');
                $this->db->where('id_group',$id);
                $sql=$this->db->get();
                if($sql->num_rows()>0){
                    return $sql->row();
                }else{
                    return '';
                }
            }
        }
        
        public function set_group()
        {
            $nama   = $this->input->post('nama');
            $desk   = $this->input->post('deskripsi');
            $data   = array('nama_group'=>$nama,
                            'deskripsi'=>$desk);
            
            $this->db->insert('sc_group',$data);
        }
        
        public function group_edit()
        {
            $nama   = $this->input->post('nama');
            $desk   = $this->input->post('deskripsi');
            $data   = array('nama_group'=>$nama,
                            'deskripsi'=>$desk);
            $id_group = $this->input->post('id_group');
            $this->db->where('id_group',$id_group);
            $this->db->update('sc_group',$data);
        }
        
        public function delete_group()
        {
            $id_group = $this->input->post('id_group');
            $this->db->where('id_group',$id_group);
            $this->db->delete('sc_group');
        }
        
        public function add_member()
        {
            $id_member = $this->input->post('id_member');
            if(is_array($id_member) and !empty($id_member)) {
                
            }
        }
        
        public function get_member_group($id) {
            $session = session_data();
            $this->db->from('sc_member');
            $this->db->where('id_group',$id);
            //$this->db->where('id_user !=',$session['id']);
            $sql = $this->db->get();
            if($sql->num_rows()>0) {
                return $sql->result();
            }else{
                return '';
            }
        }
        
        public function hapus_acara_group($id_group,$id_acara)
        {
            $this->db->where('id_group',$id_group);
            $this->db->where('id_acara',$id_acara);
            $this->db->delete('sc_acara_group');
        }
        
        public function tambah_anggota()
        {
            $id_group   = $this->input->post('id_group');
            $foto       = $this->input->post('foto');
            $nama       = $this->input->post('nama');
            $id_user    = $this->input->post('anggota_baru');
            $group      = $this->input->post('group');
            
            if(!empty($id_user)) {
                foreach($id_user as $idx=>$new) {
                    $data = array('id_group'=>$id_group,
                                  'id_user'=>$new,
                                  'nama'=>$nama[$idx],
                                  'foto_member'=>$foto[$idx],
                                  'user'=>$group[$idx],
                                  'stat_member'=>'not aktif',
                                  'stat_confirm'=>'menunggu');
                    $this->db->insert('sc_member',$data);
                }
            }
        }
        
        public function get_foto_paging($id_group,$limit,$offset)
        {
            $this->db->where('id_group',$id_group);
            $this->db->from('sc_foto_group');
            $this->db->where('id_album',0);
            $this->db->limit($limit,$offset);
            $sql = $this->db->get();
            if($sql->num_rows()>0)
            {
                return $sql->result();
            }else{
                return '';
            }
        }
        
        public function tot_paging_foto($id_group)
        {
            $this->db->where('id_group',$id_group);
            $this->db->where('id_album',0);
            $this->db->from('sc_foto_group');
            $sql = $this->db->get();
            if($sql->num_rows()>0)
            {
                return $sql->num_rows();
            }else{
                return '';
            }
        }
        
        public function multiple_simpan_foto()
        {
            if(!empty($_POST))
            {
                $id_group   = $this->input->post('id_group');
                $ket_foto   = $this->input->post('ket_foto');
                $foto       = $this->input->post('foto');
                $session    = session_data();
                $album      = $this->input->post('album');
                $sess_foto  = $this->session->userdata('session_foto_group');
                
                //cari id_member
                $this->db->where('id_user',$session['id']);
                $this->db->where('id_group',$id_group);
                $sql = $this->db->get('sc_member');
                $id_member = '';
                if($sql->num_rows()>0) {
                    $id_member = $sql->row()->id_member;
                }
                
                if(!empty($sess_foto)) {
                    foreach($sess_foto as $images) {
                        if(in_array($images['name'],$foto)) {
                            foreach($foto as $idx=>$val) {
                                if($images['name']==$val) {
                                    $val = str_replace(' ','_',$val);
                                    if(!empty($album)) {
                                        $data = array('id_album'=>$album,
                                                      'id_member'=>$id_member,
                                                      'id_group'=>$id_group,
                                                      'small'=>'upload/images/thumb/'.$val,
                                                      'medium'=>'upload/images/medium/'.$val,
                                                      'large'=>'upload/images/larger/'.$val,
                                                      'keterangan'=>$ket_foto[$idx]);
                                        $this->db->insert('sc_foto_group',$data);
                                    }else{
                                        $data = array('id_member'=>$id_member,
                                                      'id_group'=>$id_group,
                                                      'small'=>'upload/images/thumb/'.$val,
                                                      'medium'=>'upload/images/medium/'.$val,
                                                      'large'=>'upload/images/larger/'.$val,
                                                      'keterangan'=>$ket_foto[$idx]);
                                        $this->db->insert('sc_foto_group',$data);
                                    }
                                }else{
                                    delete_files(FCPATH.'upload/images/larger/'.$val);
                                    delete_files(FCPATH.'upload/images/thumb/'.$val);
                                }
                            }
                        }
                    }
                }
                $this->session->unset_userdata('session_foto_group');
            }
        }
        
        public function get_dokumen($id,$limit,$offset)
        {
            $this->db->from('sc_dokumen');
            $this->db->where('id_group',$id);
            $this->db->order_by('id_dokumen','DESC');
            $this->db->limit($limit,$offset);
            $sql = $this->db->get();
            if($sql->num_rows()>0)
            {
                return $sql->result();
            }else{
                return '';
            }
        }
        
        public function get_total_dokumen($id)
        {
            $this->db->from('sc_dokumen');
            $this->db->where('id_group',$id);
            $this->db->order_by('id_dokumen','DESC');
            $sql = $this->db->get();
            if($sql->num_rows()>0)
            {
                return $sql->num_rows();
            }else{
                return 0;
            }
        }
        
        public function edit_data_group()
        {
            $id_group       = $this->input->post('id_group');
            $nama_group     = $this->input->post('nama_group');
            $deskripsi      = $this->input->post('deskripsi');
            if(!empty($_FILES['logo']['tmp_name']))
            {
                 // insert photo lokasi
                $config['upload_path']      = $path_large = "upload/images/larger/";
                $config['allowed_types']    = 'gif|jpg|png';
                $config['max_size']	        = '7000';
                $config['max_width']        = '4000';
                $config['max_height']       = '4000';
                $config['remove_spaces']    = 'TRUE';
                $this->load->library('upload', $config);
                if ( ! $this->upload->do_upload('logo'))
                {
                    $error = array('error' => $this->upload->display_errors());
                    print_r($error);exit;
                    $this->load->view('upload_form', $error);
                }
                else
                {
                    $this->load->library('image_moo');
                    $data           = array('upload_data' => $this->upload->data());
                    $path_small     = "upload/images/thumb/";
                    $this->image_moo
                        ->load($data['upload_data']['full_path'])
                        ->resize_crop(100,100)
                        ->save($path_small.$data['upload_data']['file_name']);
                    
                    if ($this->image_moo->errors) {
                        print_r($this->image_moo->display_errors()) ;
                    }
                    
                    $this->db->where('id_group',$id_group);
                    $data_edit       = array('nama_group'=>$nama_group,
                                        'deskripsi'=>$deskripsi,
                                        'logo'=>'upload/images/thumb/'.$data['upload_data']['file_name']);
                    $this->db->update('sc_group',$data_edit);
                }
            }else{
                    $this->db->where('id_group',$id_group);
                    $data_edit       = array('nama_group'=>$nama_group,
                                        'deskripsi'=>$deskripsi);
                    $this->db->update('sc_group',$data_edit);
            }
        }
        
        //upload dokumen
        public function dokumen_upload()
        {
             // insert photo lokasi
            $config['upload_path']      = $path_large = "upload/dokumen/";
            $config['allowed_types']    = '*';
            $config['max_size']	        = '900000000';
            $config['remove_spaces']    = 'TRUE';
            $this->load->library('upload', $config);
            if ( ! $this->upload->do_upload('dokumen'))
            {
                $error = array('error' => $this->upload->display_errors());
                print_r($error);exit;
                $this->load->view('upload_form', $error);
            }
            else
            {
                $id_group       = $this->input->post('id_group');
                $nama_dokumen   = $this->input->post('nama_dokumen'); 
                $data           = array('upload_data' => $this->upload->data());
                $upload         = array('nama_dokumen'=>$nama_dokumen,
                                'path'=>'upload/dokumen/'.$data['upload_data']['file_name'],
                                'size'=>$data['upload_data']['file_size'],
                                'tgl_dokumen'=>date('Y-m-d'),
                                'id_group'=>$id_group);
                $this->db->insert('sc_dokumen',$upload);
            }
        }
        
        public function upload_multi_foto()
        {
             // insert photo lokasi
            $config['upload_path']      = $path_large = "upload/images/larger/";
            $config['allowed_types']    = 'gif|jpg|png';
            $config['max_size']	        = '7000';
            $config['max_width']        = '4000';
            $config['max_height']       = '4000';
            $config['remove_spaces']    = 'TRUE';
            $this->load->library('upload', $config);
            if ( ! $this->upload->do_upload('file'))
            {
                $error = array('error' => $this->upload->display_errors());
                print_r($error);exit;
                $this->load->view('upload_form', $error);
            }
            else
            {
                $this->load->library('image_moo');
                $data           = array('upload_data' => $this->upload->data());
                $path_small     = "upload/images/thumb/";
                $this->image_moo
                    ->load($data['upload_data']['full_path'])
                    ->resize_crop(100,100)
                    ->save($path_small.$data['upload_data']['file_name']);
                
                if ($this->image_moo->errors) {
                    print_r($this->image_moo->display_errors()) ;
                }
                
                if($this->session->userdata('session_foto_group')){
			$jml 		= count($this->session->userdata('session_foto_group'));
			$file		= $this->session->userdata('session_foto_group');
			$file[$jml]	= $_FILES['file'];
			$this->session->set_userdata('session_foto_group',$file);
		}else{
			$this->session->set_userdata('session_foto_group',array('0'=>$_FILES['file']));
		}
            }                        
        }
        
        public function edit_data_album()
        {
            $id_album   = $this->input->post('id_album');
            $id_group   = $this->input->post('id_group');
            $nama_album = $this->input->post('nama_album');
            $deskripsi  = $this->input->post('deskripsi');
            
            $data = array('nama_album'=>$nama_album,
                          'deskripsi'=>$deskripsi);
            $this->db->where('id_album',$id_album);
            $this->db->where('id_group',$id_group);
            $this->db->update('sc_album_group',$data);
        }
        
        public function hapus_group_album($id)
        {
            //hapus fotonya dulu
            $this->db->where('id_album',$id);
            $this->db->delete('sc_foto_group');
            
            //hapus albumnya
            $this->db->where('id_album',$id);
            $this->db->delete('sc_album_group');   
        }
        
        public function get_foto_dan_album($id)
        {
            $this->db->from('sc_album_group a');
            $this->db->join('sc_foto_group b','a.id_album=b.id_album');
            $this->db->where('a.id_group',$id);
            $this->db->group_by('a.id_album');
            $sql = $this->db->get();
            if($sql->num_rows()>0)
            {
                return $sql->result();
            }else{
                return '';
            }
        }
        
        public function group_foto_list()
        {
            $id_album   = $this->input->post('id_album');
            $this->db->from('sc_album_group a');
            $this->db->join('sc_foto_group b','a.id_album=b.id_album');
            $this->db->where('a.id_album',$id_album);
            $sql = $this->db->get();
            if($sql->num_rows()>0) {
                return json_encode($sql->result_array());
            }else{
                return '';
            }
        
        }
        
        public function get_album_group($id)
        {
            $this->db->where('id_group',$id);
            $sql = $this->db->get('sc_album_group');
            if($sql->num_rows()>0) {
                return $sql->result();
            }else{
                return '';
            }
        }
        
        public function buat_album()
        {
            $id_group   = $this->input->post('id_group');
            $nama_album = $this->input->post('nama_album');
            $keterangan = $this->input->post('deskripsi');
            $data = array('id_group'=>$id_group,
                          'nama_album'=>$nama_album,
                          'deskripsi'=>$keterangan);
            $this->db->insert('sc_album_group',$data);
        }
        
        public function list_get_member($id,$limit,$offset)
        {
            if(empty($offset)) {
                $offset = 0;
            }
            $session = session_data();
            $sql = $this->db->query('SELECT *,
                                    (SELECT nama FROM ak_pegawai WHERE id=a.id AND a.id_group=13) as nama_pegawai,
                                    (SELECT nama FROM ak_siswa WHERE id=a.id AND a.id_group=12) as nama_siswa
                                    FROM users a
                                    WHERE a.id
                                    NOT IN
                                    (SELECT id_user
                                    FROM sc_member
                                    WHERE id_group=1) LIMIT '.$offset.','.$limit.'');
            if($sql->num_rows()>0) {
                return $sql->result();
            }else{
                return '';
            }
        }
        
        public function tot_paging_get_member()
        {
            $session = session_data();
            $sql = $this->db->query('SELECT *,
                                    (SELECT nama FROM ak_pegawai WHERE id=a.id AND a.id_group=13) as nama_pegawai,
                                    (SELECT nama FROM ak_siswa WHERE id=a.id AND a.id_group=12) as nama_siswa
                                    FROM users a
                                    WHERE a.id
                                    NOT IN
                                    (SELECT id_user
                                    FROM sc_member
                                    WHERE id_group=1)');
            if($sql->num_rows()>0) {
                return $sql->num_rows();
            }else{
                return '';
            }
        }
        public function cek_member_group($id){
            $this->db->from('sc_member');
            $this->db->where('id_user',$id);
            $this->db->where('stat_member','aktif');
            $this->db->where('stat_confirm','terima');
            $sql = $this->db->get();
            if($sql->num_rows()>0) {
                return $sql->row();
            }else{
                return '';
            }
        }
        
        public function acara_create()
        {
            //insert dulu acara group
            $acara      = $this->input->post('acara');
            $hari       = $this->input->post('hari');
            $tgl        = $this->input->post('tgl');
            $jam        = $this->input->post('jam');
            $tempat     = $this->input->post('tempat');
            $keterangan = $this->input->post('keterangan');
            $id_group   = $this->input->post('id_group');
            
            $data   = array('nama_acara'=>$acara,
                            'tgl_acara'=>$tgl,
                            'tempat'=>$tempat,
                            'keterangan'=>$keterangan,
                            'jam'=>$jam,
                            'id_group'=>$id_group);
            $this->db->insert('sc_acara_group',$data);
            
            //insert undangan acara group
            $id_undangan    = $this->input->post('id_undangan');
            if(is_array($id_undangan) and !empty($id_undangan)) {
                foreach($id_undangan as $id_und) {
                    $data = array('id_member'=>$id_und,
                                  'id_group'=>$id_group);
                    
                    $this->db->insert('sc_und_acara_group',$data);
                }
            }
        }
        
        public function hapus_member_group($id_group,$id_member) {
            $this->db->where('id_group',$id_group);
            $this->db->where('id_member',$id_member);
            $this->db->delete('sc_member');
        }
        
        public function get_acara_group($id)
        {
            $this->db->from('sc_acara_group');
            $this->db->where('id_group',$id);
            $sql = $this->db->get();
            if($sql->num_rows()>0) {
                return $sql->result();
            }else{
                return '';
            }
        }
        
        public function get_status_group($id=0) {
            if($id!=0){
                $this->db->from('sc_group');
                $this->db->join('sc_status_group','sc_group.id_group=sc_status_group.id_group');
                $this->db->join('sc_member','sc_member.id_member=sc_status_group.id_member');
                $this->db->join('sc_foto_group','sc_status_group.id_foto=sc_foto_group.id_foto_group','left');
                $this->db->where('sc_member.id_group',$id);
                $this->db->limit(10);
                $this->db->order_by('sc_status_group.id_stat_group','DESC');
                $sql = $this->db->get();
                if($sql->num_rows()>0) {
                    $data['status'] = $sql->result();
                    $komentar = array();
                    foreach($sql->result() as $st_komen) {
                        $this->db->select("*,(SELECT nama FROM sc_member WHERE id_member=sc_komen_status.id_member)as nama_komentar");
                        $this->db->from('sc_komen_status');
                        $this->db->join('sc_status_group','sc_status_group.id_stat_group=sc_komen_status.id_stat_group');
                        $this->db->where('sc_komen_status.id_stat_group',$st_komen->id_stat_group);
                        $this->db->order_by('sc_komen_status.id_komen_status','ASC');
                        $kom = $this->db->get();
                        if($kom->num_rows()>0) {
                              $komentar[$st_komen->id_stat_group] = $kom->result();
                        }
                    }
                    $data['komentar'] = $komentar;
                    return $data;
                }else {
                    return '';
                }
            }
            
        }
        
        //set komentar
        public function set_komentar_group()
        {
            $id_group   = $this->input->post('id_group');
            $id_status  = $this->input->post('id_status');
            $komentar   = $this->input->post('komentar');
            
            $id_member  = '';
            //cari id_member dulu
            $session    = session_data();
            $this->db->from('sc_member');
            $this->db->where('id_user',$session['id']);
            $this->db->where('stat_member','aktif');
            $this->db->where('id_group',$id_group);
            $this->db->where('stat_confirm','terima');
            $sql = $this->db->get();
            if($sql->num_rows()>0) {
                $id_member =  $sql->row();
                $id_member = $id_member->id_member;
            }else{
                $id_member = '';
            }
            
            if(!empty($id_status) AND !empty($komentar) AND !empty($id_group))
            {
                $data = array('id_stat_group'=>$id_status,
                              'id_member'=>$id_member,
                              'komentar'=>$komentar);
                
                $this->db->insert('sc_komen_status',$data);
                $id = $this->db->insert_id();
                
                $this->db->from('sc_komen_status');
                $this->db->join('sc_member','sc_member.id_member=sc_komen_status.id_member');
                $this->db->where('id_komen_status',$id);
                $sql = $this->db->get();
                if($sql->num_rows()>0) {
                    return $sql->row();
                }else{
                    return '';
                }
            }
        }
        
        public function delete_status()
        {
            $id_status = $this->input->post('id_status');
            $this->db->from('sc_status_group');
            $this->db->where('id_stat_group',$id_status);
            $sql= $this->db->get();
            if($sql->num_rows()>0){
                $sql = $sql->row();
                if($sql->id_foto!=0) {
                    $this->db->delete('sc_foto_group',array('id_foto_group'=>$sql->id_foto));   
                }
            }
            
            //hapus komentar dulu
            $this->db->delete('sc_komen_status',array('id_stat_group'=>$id_status));
            $this->db->delete('sc_status_group',array('id_stat_group'=>$id_status));
        }
        
        public function delete_komentar()
        {
            $id_komen = $this->input->post('id_komen');
            $this->db->delete('sc_komentar',array('id_komen'=>$id_komen));
        }
        
        //set status
        public function set_status_group()
        {
            $id_group   = $this->input->post('id_group');
            $status     = $this->input->post('status');
            $foto       = $this->input->post('images');
            $id_member  = '';
            //cari id_member dulu
            $session    = session_data();
            $this->db->from('sc_member');
            $this->db->where('id_user',$session['id']);
            $this->db->where('stat_member','aktif');
            $this->db->where('stat_confirm','terima');
            $sql = $this->db->get();
            if($sql->num_rows()>0) {
                $id_member =  $sql->row();
                $id_member = $id_member->id_member;
            }else{
                $id_member = '';
            }
            
            if(!empty($status) and !empty($id_member))
            {
                if(!empty($foto)) {
                    $data = array('id_member'=>$id_member,
                                  'small'=>'upload/images/thumb/'.$foto,
                                  'medium'=>'upload/images/medium/'.$foto,
                                  'large'=>'upload/images/larger/'.$foto,
                                  'keterangan'=>$status,
                                  'tgl_foto'=>date('Y-m-d'),
                                  'id_group'=>$id_group);
                    $this->db->insert('sc_foto_group',$data);
                    $id_foto = $this->db->insert_id();
                    
                    $data = array('status'=>$status,
                              'id_member'=>$id_member,
                              'id_foto'=>$id_foto,
                              'id_group'=>$id_group);
                    $this->db->insert('sc_status_group',$data);
                    
                    $id = $this->db->insert_id();
                    $this->db->from('sc_status_group');
                    $this->db->join('sc_member','sc_member.id_member=sc_status_group.id_member');
                    $this->db->join('sc_foto_group','sc_status_group.id_foto=sc_foto_group.id_foto_group');
                    $this->db->where('id_stat_group',$id);
                    $sql = $this->db->get();
                    if($sql->num_rows()>0) {
                        return $sql->row();
                    }else{
                        return '';
                    }
                
                }else{
                    $data = array('status'=>$status,
                              'id_member'=>$id_member,
                              'id_group'=>$id_group);
                    $this->db->insert('sc_status_group',$data);
                    $id = $this->db->insert_id();
                    
                    $this->db->from('sc_status_group');
                    $this->db->join('sc_member','sc_member.id_member=sc_status_group.id_member');
                    $this->db->where('id_stat_group',$id);
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
?>