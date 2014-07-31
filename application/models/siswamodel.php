<?php
    class Siswamodel extends CI_Model
    {
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
        
        public function foto_pribadi_hapus($id) {
	    $session = session_data();
	    $this->db->delete('sc_foto',array('id_foto'=>$id,'id_user'=>$session['id']));
	}
        
        public function get_pesan_keluar() {
            $session = session_data();
            $this->db->from('sc_pesan');
	    $this->db->join('users','sc_pesan.untuk=users.id','left');
            $this->db->where('penulis',$session['id']);
            $sql = $this->db->get();
            if($sql->num_rows()>0) {
                return $sql->result();
            }else{
                return '';
            }
        }
        
        public function get_sekolah() {
            $session = session_data();
            $this->db->from('ak_sekolah');
            $this->db->where('id',$session['id_sekolah']);
            $sql = $this->db->get();
            if($sql->num_rows()>0) {
                return $sql->result();
            }else{
                return '';
            }
        }
        
        public function get_status_pribadi($id)
        {
            if($id!=0){
                $this->db->from('sc_status');
                $this->db->join('users','sc_status.id_user=users.id');
                $this->db->where('kategori','pribadi');
                $this->db->where('id_untuk',$id);
                $this->db->order_by('sc_status.id_status','DESC');
                $this->db->limit(10);
                $sql = $this->db->get();
                if($sql->num_rows()>0) {
                    $data['status'] = $sql->result();
                    $komentar = array();
                    foreach($sql->result() as $st_komen) {
                        $this->db->from('sc_komentar');
                        $this->db->join('users','users.id=sc_komentar.id_user');
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
        
        public function get_last_status_user($id)
        {
            $this->db->from('sc_status');
            $this->db->where('id_user',$id);
            $this->db->order_by('id_status','DESC');
            $this->db->limit(1);
            $sql = $this->db->get();
            if($sql->num_rows()>0){
                return $sql->row();
            }else{
                return '';
            }
        }
        
        public function get_kegiatan_terbaru()
        {
            $session = session_data();
            $this->db->from('sc_kegiatan');
            $this->db->where('id_sek',$session['id_sekolah']);
            $this->db->limit(2);
            $sql = $this->db->get();
            if($sql->num_rows()>0) {
                return $sql->result();
            }else{
                return '';
            }
        }
        
        public function get_kegiatan_custom($id)
        {
            $this->db->from('sc_kegiatan');
            $this->db->where('id_sek',$id);
            $this->db->limit(2);
            $sql = $this->db->get();
            if($sql->num_rows()>0) {
                return $sql->result();
            }else{
                return '';
            }
        }

        function siswa_prestasi(){
            $this->db->join('ak_sekolah as sk','s.id_sekolah=sk.id');
            $this->db->join('ak_nilai_uas as n','s.id=n.id_siswa_det_jenjang');
            $this->db->order_by('n.nilai', 'DESC'); 
            $this->db->limit(1);
            $siswa = $this->db->get('ak_siswa as s')->row();
            return $siswa;
        }
        
        public function get_index_kegiatan($limit,$offset)
        {
            $session = session_data();
            $this->db->from('sc_kegiatan');
            $this->db->limit($limit,$offset);
            $this->db->where('id_sek',$session['id_sekolah']);
            $sql = $this->db->get();
            if($sql->num_rows()>0) {
                return $sql->result();
            }else{
                return '';
            }
        }
        
        public function tot_paging_kegiatan() {
            $session = session_data();
            $this->db->from('sc_kegiatan');
            $this->db->where('id_sek',$session['id_sekolah']);
            $sql = $this->db->get();
            if($sql->num_rows()>0) {
                return $sql->num_rows();
            }else{
                return '';
            }
        
        }
        
        public function get_index_kegiatan2($id,$limit,$offset)
        {
            $this->db->from('sc_kegiatan');
            $this->db->limit($limit,$offset);
            $this->db->where('id_sek',$id);
            $sql = $this->db->get();
            if($sql->num_rows()>0) {
                return $sql->result();
            }else{
                return '';
            }
        }
        
        public function tot_paging_kegiatan2($id) {
            $this->db->from('sc_kegiatan');
            $this->db->where('id_sek',$id);
            $sql = $this->db->get();
            if($sql->num_rows()>0) {
                return $sql->num_rows();
            }else{
                return '';
            }
        
        }
        
        public function get_index_berita($limit,$offset)
        {
            $session = session_data();
            $this->db->from('sc_berita');
            $this->db->limit($limit,$offset);
            $this->db->where('id_sek',$session['id_sekolah']);
            $sql = $this->db->get();
            if($sql->num_rows()>0) {
                return $sql->result();
            }else{
                return '';
            }
        }
        
        public function tot_paging_berita() {
            $session = session_data();
            $this->db->from('sc_berita');
            $this->db->where('id_sek',$session['id_sekolah']);
            $sql = $this->db->get();
            if($sql->num_rows()>0) {
                return $sql->num_rows();
            }else{
                return '';
            }
        }
        
        
        public function get_index_berita2($id,$limit,$offset)
        {
            $this->db->from('sc_berita');
            $this->db->limit($limit,$offset);
            $this->db->where('id_sek',$id);
            $sql = $this->db->get();
            if($sql->num_rows()>0) {
                return $sql->result();
            }else{
                return '';
            }
        }
        
        public function tot_paging_berita2($id) {
            $session = session_data();
            $this->db->from('sc_berita');
            $this->db->where('id_sek',$id);
            $sql = $this->db->get();
            if($sql->num_rows()>0) {
                return $sql->num_rows();
            }else{
                return '';
            }
        }
        
        public function get_teman($id){
            if($id!=0){
		$this->db->select("*,
				  (SELECT nama FROM ak_pegawai WHERE id=sc_teman.id_teman) as nama_pegawai,
				  (SELECT id as id_pegawai FROM ak_pegawai WHERE id=sc_teman.id_teman) as id,
				  (SELECT id as id_siswa FROM ak_siswa WHERE id=sc_teman.id_teman) as id,
				  (SELECT nama FROM ak_siswa WHERE id=sc_teman.id_teman) as nama_siswa");
		$this->db->from('sc_teman');
		$this->db->join('users','users.id=sc_teman.id_teman');
		$this->db->where('sc_teman.id_user',$id);
		$this->db->where('sc_teman.stat_confirm','terima');
		$this->db->where('sc_teman.stat_teman','ya');
		$this->db->where('sc_teman.blokir','tidak');
		$sql = $this->db->get();
		//echo $this->db->last_query();exit;
		if($sql->num_rows()>0){
		    return $sql->result();
		}else{
		    return '';
		}
	    }
        }
        
        //pagination
        public function get_ajax_orang_dikenal($limit,$offset)
        {
            $session    = session_data();
            $result     = $this->db->query('SELECT * 
                                            FROM ak_pegawai 
                                            WHERE id_sekolah='.$id.'
                                            AND id!='.$session['id'].'
                                            AND id
                                            NOT IN (SELECT id_teman FROM sc_teman WHERE id_user='.$session['id'].')');
                if($result->num_rows()>0) {
                    $data['pegawai_dikenal']=$result->result();
                }else{
                    $data['pegawai_dikenal'] = '';
                }
		
		$sql=$this->db->query('SELECT * 
                                    FROM ak_siswa 
                                    WHERE id_sekolah='.$id.'
                                    AND id!='.$session['id'].'
                                    AND id
                                    NOT IN (SELECT id_teman FROM sc_teman WHERE id_user='.$session['id'].')');
                if($sql->num_rows()>0) {
                    $data['siswa_dikenal']=$sql->result();
                }else{
                    $data['siswa_dikenal'] =  '';
                }
		return $data;
        }
        
        public function get_ajax_teman($limit,$offset) {
            $this->db->from('sc_teman');
            $this->db->join('ak_siswa','ak_siswa.id=sc_teman.id_teman');
            $this->db->where('id_user',$id);
            $this->db->where('blokir','tidak');
            $this->db->where('stat_teman','ya');
            $this->db->limit($limit,$offset);
            $sql = $this->db->get();
            if($sql->num_rows()>0) {
                return $sql->result();
            }else{
                return '';
            }
        }
        
        public function tot_paging_ajax_teman()
        {
            $this->db->from('sc_teman');
            $this->db->join('ak_siswa','ak_siswa.id=sc_teman.id_teman');
            $this->db->where('id_user',$id);
            $this->db->where('blokir','tidak');
            $this->db->where('stat_teman','ya');
            $sql = $this->db->get();
            if($sql->num_rows()>0) {
                return $sql->num_rows();
            }else{
                return '';
            }
        }
        
        
        
        
        public function kirim_pesan()
        {
            $lampiran   = $_FILES['lampiran'];
	    $nama_file  = '';
	    if(!empty($_FILES['lampiran']['tmp_name']))
	    {
		$config['upload_path']      = $path_large = "upload/dokumen/surat_pribadi/";
		$config['allowed_types']    = 'docx|gif|jpg|png|doc|xls|xlsx|ppt|pptx|zip|rar|pdf';
		$config['max_size']	    = '30000000';
		$config['remove_spaces']    = 'TRUE';
		$this->load->library('upload', $config);
		if ( ! $this->upload->do_upload('lampiran'))
		{
		    $error = array('error' => $this->upload->display_errors());
		    print_r($error);exit;
		}else{
		    $data = array('upload_data' => $this->upload->data());
		    $nama_file = base_url($path_large."/".$data['upload_data']['file_name']);
		}
	    }
            
            $session    = session_data();
            $id_untuk   = $this->input->post('untuk');
            $pesan      = $this->input->post('pesan');
            if(is_array($id_untuk)) {
                foreach($id_untuk as $id_pengirim) {
                    if($id_pengirim!=0) {
                        $data = array('untuk'=>$id_pengirim,
                                      'pesan'=>$pesan ."<br> Lampiran File : <a target='_blank' href='".$nama_file."'>Unduh File</a>",
                                      'penulis'=>$session['id']);
                        
                        $this->db->insert('sc_pesan',$data);
                    }
                }
            }
        }
        
        public function get_album_foto()
        {
            $session = session_data();
            $this->db->from('sc_album');
            $this->db->order_by('id_album','DESC');
            $this->db->where('id_user',$session['id']);
            $sql = $this->db->get();
            if($sql->num_rows()>0) {
                return $sql->result();
            }else{
                return '';
            }
        }
        
        public function create_album_foto()
        {
            $session = session_data();
            $nama_album     = $this->input->post('nama_album');
            $deskripsi      = $this->input->post('deskripsi');
            $data           = array('nama_album'=>$nama_album,
                                    'deskripsi'=>$deskripsi,
                                    'id_user'=>$session['id'],
                                    'id_sek'=>$session['id_sekolah']);
            $this->db->insert('sc_album',$data);
        }
        
        public function ubah_data_user()
        {
            $pwd_lama   = $this->input->post('pwd_lama');
            $pwd_baru   = $this->input->post('pwd_baru');
            $konfirm    = $this->input->post('konfirm');
            $jenis_kelamin      = $this->input->post('jenis_kelamin');
            $tgl_lahir          = $this->input->post('tgl_lahir');
            $alamat             = $this->input->post('alamat');
            $telp               = $this->input->post('telp');
            $email              = $this->input->post('email');
            $orangtua           = $this->input->post('orangtua');
            $session = session_data();
                                    
            if(!empty($_FILES['foto_siswa']['tmp_name']))
            {
                $config['upload_path']      = $path_large = "upload/images/larger/";
                $config['allowed_types']    = 'gif|jpg|png';
                $config['max_size']	    = '7000';
                $config['max_width']        = '4000';
                $config['max_height']       = '4000';
                $config['remove_spaces']    = 'TRUE';
                $this->load->library('upload', $config);
                if ( ! $this->upload->do_upload('foto_siswa'))
                {
                    $error = array('error' => $this->upload->display_errors());
                    print_r($error);exit;
                    $this->load->view('upload_form', $error);
                }
                else
                {
                    $this->load->library('image_moo');
                    $data           = array('upload_data' => $this->upload->data());
                    $path_small     = 'upload/images/thumb/';
                    $path_small2    = 'upload/images/larger/';
                    
                    $this->image_moo
                        ->load($data['upload_data']['full_path'])
                        ->resize_crop(150,150)
                        ->save($path_small.$data['upload_data']['file_name']);
                    
                     $this->image_moo
                            ->load($data['upload_data']['full_path'])
                            ->resize(560,350)
                            ->save($path_small2.$data['upload_data']['file_name']);
                    
                    if ($this->image_moo->errors) {
                        print_r($this->image_moo->display_errors()) ;
                    }
                    
                    if(!empty($pwd_baru) AND !empty($konfirm))
                    {
                        print_r('rubah password');exit;
                        $this->db->where('id',$session['id']);
                        $this->db->where('password',$pwd_lama);
                        $sql=$this->db->get('ak_siswa');
                        if($sql->num_rows()>0)
                        {
                            //ubah password
                            $this->db->where('id',$session['id']);
                            $this->db->update('ak_siswa',array('password'=>$pwd_baru));
                            
                            $this->db->where('id',$session['id']);
                            $this->db->update('users',array('password'=>md5($pwd_baru)));
                        }
                    }
                    
                    $foto       = "upload/images/thumb/".$data['upload_data']['file_name'];
                    $update     = array('gender'=>$jenis_kelamin,
                                  'tglahir'=>$tgl_lahir,
                                  'alamat'=>$alamat,
                                  'telp'=>$telp,
                                  'email'=>$email,
                                  'NmOrtu'=>$orangtua,
                                  'foto'=>$foto);
                    $this->db->where('id',$session['id']);
                    $this->db->update('ak_siswa',$update);
                }
            }else{
                if(!empty($pwd_baru) AND !empty($konfirm))
                {
                    $session = session_data();
                    $this->db->where('id',$session['id']);
                    $this->db->where('password',$pwd_lama);
                    $sql=$this->db->get('ak_siswa');
                    if($sql->num_rows()>0)
                    {
                        //ubah password
                        $this->db->where('id',$session['id']);
                        $this->db->update('ak_siswa',array('password'=>$pwd_baru));
                        
                        $this->db->where('id',$session['id']);
                        $this->db->update('users',array('password'=>md5($pwd_baru)));
                    }
                }
                
                $data = array('gender'=>$jenis_kelamin,
                              'tglahir'=>$tgl_lahir,
                              'alamat'=>$alamat,
                              'telp'=>$telp,
                              'email'=>$email,
                              'NmOrtu'=>$orangtua);
                $this->db->where('id',$session['id']);
                $this->db->update('ak_siswa',$data);
            }
        }
        
        public function simpan_kegiatan()
	{
	    $session = session_data();
	    $judul  = $this->input->post('judul');
	    $tgl    = $this->input->post('tgl_kegiatan');
	    $jam    = $this->input->post('jam');
	    $tempat = $this->input->post('tempat');
	    $ket    = $this->input->post('kegiatan');
	    
	    if (!empty($_FILES)) {
		$config['upload_path']  = "upload/images/larger/";
		$config['allowed_types']= 'gif|jpg|png|jpeg';
		$config['max_size']     = '2000';
		$config['max_width']    = '4000';
		$config['max_height']   = '4000';
		$file_name='';
		$this->load->library('upload', $config);
		if ($this->upload->do_upload('foto')) {
		    $data['img']	 = $this->upload->data();
		    $file_name = $this->upload->file_name;
		    $this->image_moo
			->load("upload/images/larger/". $file_name)
			->resize_crop(100,100)
			->save("upload/images/thumb/". $file_name);
                    
                    
                }
		$data = array('id_admin'=>$session['id'],
				'id_sek'=>$session['id_sekolah'],
				'judul'=>$judul,
				'tgl_keg'=>$tgl,
				'foto'=>$file_name,
				'jam'=>$jam,
				'lokasi'=>$tempat,
				'keterangan'=>$ket);
		  $this->db->insert('sc_kegiatan',$data);
    
	    }else{
		$data = array('id_admin'=>$session['id'],
				'id_sek'=>$session['id_sekolah'],
				'judul'=>$judul,
				'tgl_keg'=>$tgl,
				'jam'=>$jam,
				'lokasi'=>$tempat,
				'keterangan'=>$ket);
		  $this->db->insert('sc_kegiatan',$data);
	    }
	}
        
        
        public function simpan_berita()
        {
            $user       = session_data();
            $sekolah    = $this->input->post('sekolah');
            $judul      = $this->input->post('judul');
            $berita     = $this->input->post('berita');
            
            if (!empty($_FILES)) {
                $config['upload_path']  = "upload/images/larger/";
                $config['allowed_types']= 'gif|jpg|png|jpeg';
                $config['max_size']     = '2000';
                $config['max_width']    = '4000';
                $config['max_height']   = '4000';
                $file_name='';
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('foto')) {
                    $data['img']	 = $this->upload->data();
                    $file_name = $this->upload->file_name;
                    $this->image_moo
                        ->load("upload/images/larger/". $file_name)
                        ->resize_crop(100,100)
                        ->save("upload/images/thumb/". $file_name);
                                        
                    $this->image_moo
                        ->load("upload/images/larger/". $file_name)
                        ->resize(560,350)
                        ->save("upload/images/larger/". $file_name);
                }
                $data = array('id_admin'=>$user['id'],
                              'id_sek'=>$user['id_sekolah'],
                              'foto'=>$file_name,
                              'judul'=>$judul,
                              'berita'=>$berita,
                              'stat_berita'=>'aktif');
                $this->db->insert('sc_berita',$data);
    
            }else{
                $data = array('id_admin'=>$user['id'],
                              'id_sek'=>$user['id_sekolah'],
                              'judul'=>$judul,
                              'berita'=>$berita,
                              'stat_berita'=>'aktif');
                $this->db->insert('sc_berita',$data);
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
                
                $this->image_moo
                        ->load($data['upload_data']['full_path'])
                        ->resize(560,350)
                        ->save("upload/images/larger/".$data['upload_data']['file_name']);
                        
                if ($this->image_moo->errors) {
                    print_r($this->image_moo->display_errors()) ;
                }
                
                if($_SESSION['session_foto']){
			$jml 		= count($_SESSION['session_foto']);
			$file		= $_SESSION['session_foto'];
			$file[$jml]	= $_FILES['file'];
			$this->session->set_userdata('session_foto',$file);
		}else{
			$this->session->set_userdata('session_foto',array('0'=>$_FILES['file']));
		}
            }             
                    
        }
        
        public function multiple_simpan_foto()
        {
            if(!empty($_POST))
            {
                $ket_foto   = $this->input->post('ket_foto');
                $foto       = $this->input->post('foto');
                $session    = session_data();
                $album      = $this->input->post('album');
                $sess_foto  = $_SESSION['session_foto'];
                
                if(!empty($sess_foto)) {
                    foreach($sess_foto as $images) {
                        if(in_array($images['name'],$foto)) {
                            foreach($foto as $idx=>$val) {
                                if($images['name']==$val) {
                                    $val = str_replace(' ','_',$val);
                                    if(!empty($album)) {
                                        $data = array('id_album'=>$album,
                                                      'id_user'=>$session['id'],
                                                      'small'=>'upload/images/thumb/'.$val,
                                                      'medium'=>'upload/images/medium/'.$val,
                                                      'large'=>'upload/images/larger/'.$val,
                                                      'ket_foto'=>$ket_foto[$idx]);
                                        $this->db->insert('sc_foto',$data);
                                    }else{
                                        $data = array('id_user'=>$session['id'],
                                                      'small'=>'upload/images/thumb/'.$val,
                                                      'medium'=>'upload/images/medium/'.$val,
                                                      'large'=>'upload/images/larger/'.$val,
                                                      'ket_foto'=>$ket_foto[$idx]);
                                        $this->db->insert('sc_foto',$data);
                                    }
                                }else{
                                    delete_files(FCPATH.'upload/images/larger/'.$val);
                                    delete_files(FCPATH.'upload/images/thumb/'.$val);
                                }
                            }
                        }
                    }
                }
                unset($_SESSION['session_foto']);
            }
        }
        
        public function balas_pesan_user()
        {
            $session    = session_data();
            $id_balas   = $this->input->post('id_balas');
            $pesan      = $this->input->post('pesan');
            $data = array('untuk'=>$id_balas,
                        'pesan'=>$pesan,
                        'penulis'=>$session['id']);
              
            $this->db->insert('sc_pesan',$data);   
        }
        
        public function baca_pesan_user()
        {
            if(!empty($_POST)) {
                $id_pesan   = $this->input->post('id_pesan');
                $this->db->where('id_pesan',$id_pesan);
                $this->db->update('sc_pesan',array('status'=>'sudah'));
            }
        }
        
        public function get_pesan()
        {
            $session = session_data();
            $this->db->select('sc_pesan.id_pesan,
                              sc_pesan.untuk,
                              sc_pesan.pesan,
                              sc_pesan.tgl_pesan,
                              sc_pesan.penulis,
                              sc_pesan.status,
                              users.username as nama,
                              users.id');
            $this->db->from('sc_pesan');
            $this->db->join('users','sc_pesan.penulis=users.id');
            $this->db->where('untuk',$session['id']);
            $this->db->order_by('tgl_pesan','desc');
            $sql = $this->db->get();
            if($sql->num_rows()>0) {
                return $sql->result();
            }else{
                return '';
            }
        }
        
        public function permintaan_diterima($id)
        {
            $session    = session_data();
            //terima pertemanan
            $data = array('stat_teman'=>'ya',
                          'stat_confirm'=>'terima');
            $this->db->where('id_user',$id);
            $this->db->where('id_teman',$session['id']);
            $this->db->update('sc_teman',$data);
            
            //membuat daftar teman baru
            $data = array('id_user'=>$session['id'],
                          'id_teman'=>$id,
                          'blokir'=>'tidak',
                          'stat_teman'=>'ya',
                          'stat_confirm'=>'terima');
            $this->db->insert('sc_teman',$data);
        }
        
        public function teman_blokir($id)
        {
            $session    = session_data();
            $this->db->where('id_user',$session['id']);
            $this->db->where('id_teman',$id);
            $this->db->update('sc_teman',array('blokir'=>'ya'));
            
            $this->db->where('id_user',$id);
            $this->db->where('id_teman',$session['id']);
            $this->db->update('sc_teman',array('blokir'=>'ya'));            
        }
        
        public function tolak_permintaan($id)
        {
            $this->db->where('id_user',$id);
            $this->db->delete('sc_teman');
        }
        
        public function cek_teman_add($id)
        {
            if($id!=0)
            {
		$this->db->select("*,users.username as nama,(SELECT id as id_pegawai FROM ak_pegawai WHERE id=sc_teman.id_user) as id,(SELECT id as id_siswa FROM ak_siswa WHERE id=sc_teman.id_user) as id");
                $this->db->from('sc_teman');
                $this->db->join('users','users.id=sc_teman.id_user');
                $this->db->where('sc_teman.id_teman',$id);
                $this->db->where('sc_teman.stat_confirm','menunggu');
		$this->db->where('sc_teman.stat_teman','tidak');
                $sql = $this->db->get();
		if($sql->num_rows()>0){
                    return $sql->result();
                }else{
                    return '';
                }
            }
        }
        
        public function hapus_teman($id)
        {
            $session    = session_data();
            $this->db->where('id_user',$session['id']);
            $this->db->where('id_teman',$id);
            $this->db->where('stat_teman','ya');
            $this->db->where('stat_confirm','terima');
            $this->db->delete('sc_teman');
            
            $this->db->where('id_user',$id);
            $this->db->where('id_teman',$session['id']);
            $this->db->where('stat_teman','ya');
            $this->db->where('stat_confirm','terima');
            $this->db->delete('sc_teman');
        }
        
        public function cek_pertemanan_user($id)
        {
            if($id!=0)
            {
                $session = session_data();
                $this->db->from('sc_teman');
                $this->db->where('id_user',$session['id']);
                $this->db->where('id_teman',$id);
                $sql = $this->db->get();
                if($sql->num_rows()>0) {
                    
                    return $sql->row();
                }else{
                    $this->db->from('sc_teman');
                    $this->db->where('id_teman',$session['id']);
                    $this->db->where('id_user',$id);
                    $sql = $this->db->get();
                    if($sql->num_rows()>0) {
                        return $sql->row();
                    }else{
                        return '';
                    }
                }
            }
        }
        
        public function add_teman()
        {
            $session    = session_data();
            $id_teman   = $this->input->post('id_user');
            $id_user    = $session['id'];
            $data       = array('id_user'=>$id_user,
                                'id_teman'=>$id_teman,
                                'blokir'=>'tidak',
                                'stat_teman'=>'tidak',
                                'stat_confirm'=>'menunggu');
            
            $this->db->insert('sc_teman',$data);
        }
        
        public function get_orang_dikenal($id) {
            if($id!=0) {
                $session = session_data();
		$result=$this->db->query('SELECT * 
                                    FROM ak_pegawai 
                                    WHERE id_sekolah='.$id.'
                                    AND id!='.$session['id'].'
                                    AND id
                                    NOT IN (SELECT id_user FROM sc_teman WHERE id_teman='.$session['id'].')');
                if($result->num_rows()>0) {
                    $data['pegawai_dikenal']=$result->result();
                }else{
                    $data['pegawai_dikenal'] = '';
                }
		
		$sql=$this->db->query('SELECT * 
                                    FROM ak_siswa 
                                    WHERE id_sekolah='.$id.'
                                    AND id!='.$session['id'].'
                                    AND id
                                    NOT IN (SELECT id_user FROM sc_teman WHERE id_teman='.$session['id'].')');
                if($sql->num_rows()>0) {
                    $data['siswa_dikenal']=$sql->result();
                }else{
                    $data['siswa_dikenal'] =  '';
                }
		return $data;
            }
        }
        
        public function pengingat_ultah($id)
        {
            $today = date('m-d');
            $this->db->from('sc_teman');
            $this->db->join('ak_siswa','sc_teman.id_teman=ak_siswa.id');
            $this->db->where('SUBSTR(ak_siswa.tglahir,6,5)',$today);
            $this->db->where('sc_teman.id_user',$id);
            $sql = $this->db->get();
            if($sql->num_rows()>0) {
                return $sql->result();
            }else{
                return '';
            }
            
        }
        
        public function pending_confirm($id)
        {
            if(!empty($id)){
                $this->db->select('id_teman');
                $this->db->from('sc_teman');
                $this->db->where('id_user',$id);
                $this->db->where('stat_confirm','menunggu');   
                $sql = $this->db->get();
                $data = array();
                if($sql->num_rows()>0) {
                    foreach($sql->result() as $item){
                        $data[] = $item->id_teman;
                    }
                    return $data;
                }else{
                    return '';
                }
            }
        }
        
        
        // public function get_status_siswa($id=0) {
        public function get_berita_terbaru()
        {
            $session = session_data();
            $this->db->from('sc_berita');
            $this->db->where('id_sek',$session['id_sekolah']);
            $this->db->limit(2);
            $sql = $this->db->get();
            if($sql->num_rows()>0) {
                return $sql->result();
            }else{
                return '';
            }
        }
        
        
        
        public function get_berita_custom($id)
        {
            $this->db->from('sc_berita');
            $this->db->where('id_sek',$id);
            $this->db->limit(2);
            $sql = $this->db->get();
            if($sql->num_rows()>0) {
                return $sql->result();
            }else{
                return '';
            }
        
        }
        
        public function get_lates_status($id=0) {
            if($id!=0) {
                $this->db->from('ak_siswa');
                $this->db->join('sc_status','ak_siswa.id=sc_status.id_user');
                $this->db->join('sc_foto','sc_status.id_foto=sc_foto.id_foto');
                $this->db->where('sc_status.id_status <',$id);
                $this->db->limit(10);
                $this->db->order_by('sc_status.id_status','DESC');
                $sql = $this->db->get();
                if($sql->num_rows()>0) {
                    $data['status'] = $sql->result();
                    $komentar = array();
                    foreach($sql->result() as $st_komen) {
                        $this->db->from('sc_komentar');
                        $this->db->join('ak_siswa','ak_siswa.id=sc_komentar.id_user');
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
        public function get_status_siswa($id=0) {
            $session = session_data();
	    //echo $session['id'];exit;
	    $this->db->select('*,
			      (SELECT nama
			      FROM ak_pegawai
			      WHERE id=b.id AND b.id_group=13)as nama_pegawai,
			      (SELECT nama
			      FROM ak_siswa
			      WHERE id=b.id AND b.id_group=12)as nama_siswa');
	    $this->db->from('sc_status a');
	    $this->db->join('sc_foto d','a.id_foto=d.id_foto','left');
	    $this->db->join('users b','a.id_user=b.id');
	    $this->db->join('sc_teman c','b.id=c.id_teman');
	    $this->db->where('c.id_user',$session['id']);
	    $this->db->or_where('b.id',$session['id']);
	    $this->db->order_by('a.id_status','DESC');
	    $this->db->limit(10);
	    $sql = $this->db->get();
	    if($sql->num_rows()>0) {
		$data['status'] = $sql->result();
		$komentar = array();
		foreach($sql->result() as $st_komen) {
		    $this->db->select('*,
                                        (SELECT nama
                                        FROM ak_pegawai
                                        WHERE id=b.id AND b.id_group=13)as nama_pegawai,
                                        (SELECT nama
                                        FROM ak_siswa
                                        WHERE id=b.id AND b.id_group=12)as nama_siswa');
                    $this->db->from('sc_komentar');
		    $this->db->join('users b','sc_komentar.id_user=b.id');
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
	    
            //if($id!=0){
            //    $this->db->from('ak_siswa');
            //    $this->db->join('sc_status','ak_siswa.id=sc_status.id_user');
            //    $this->db->join('sc_foto','sc_status.id_foto=sc_foto.id_foto','left');
            //    $this->db->limit(10);
            //    $this->db->order_by('sc_status.id_status','DESC');
            //    $sql = $this->db->get();
            //    if($sql->num_rows()>0) {
            //        $data['status'] = $sql->result();
            //        $komentar = array();
            //        foreach($sql->result() as $st_komen) {
            //            $this->db->from('sc_komentar');
            //            $this->db->join('ak_siswa','ak_siswa.id=sc_komentar.id_user');
            //            $this->db->where('sc_komentar.id_status',$st_komen->id_status);
            //            $this->db->order_by('sc_komentar.id_komen','ASC');
            //            $kom = $this->db->get();
            //            if($kom->num_rows()>0) {
            //                  $komentar[$st_komen->id_status] = $kom->result();
            //            }
            //        }
            //        $data['komentar'] = $komentar;
            //        return $data;
            //    }else {
            //        return '';
            //    }
            //}
        }
        
        public function set_status_siswa()
        {
            $id_siswa = $this->input->post('id_siswa');
            $status = $this->input->post('status');
            $foto   = $this->input->post('images');
            
            if(!empty($status))
            {
                if(!empty($foto)) {
                    $data = array('id_user'=>$id_siswa,
                                  'small'=>'upload/images/thumb/'.$foto,
                                  'medium'=>'upload/images/medium/'.$foto,
                                  'large'=>'upload/images/larger/'.$foto,
                                  'ket_foto'=>$status);
                    $this->db->insert('sc_foto',$data);
                    $id_foto = $this->db->insert_id();
                    
                    $data = array('pesan'=>$status,
                              'id_user'=>$id_siswa,
                              'id_foto'=>$id_foto);
                
                    $this->db->insert('sc_status',$data);
                    $id = $this->db->insert_id();
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
                    $data = array('pesan'=>$status,
                              'id_user'=>$id_siswa);
                
                    $this->db->insert('sc_status',$data);
                    $id = $this->db->insert_id();
                    $this->db->from('sc_status');
                    $this->db->join('ak_siswa','ak_siswa.id=sc_status.id_user');
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
        
        public function user_cari_teman($limit,$offset) {
	    $search 	= $this->input->post('search');
	    $sess	= session_data();
	    $this->db->select('*,
			      (SELECT nama
			      FROM ak_pegawai
			      WHERE users.id=ak_pegawai.id)
			      as nama_pegawai,
			      (SELECT nama
			      FROM ak_siswa
			      WHERE users.id=ak_siswa.id)
			      as nama_siswa');            
            $this->db->from('users');
	    if(!empty($search)) {
		$this->db->like('users.username',$search,'both');
		$this->session->set_userdata('cari_nama',array('key'=>$search));
	    }else{
		$session = $this->session->userdata('cari_nama');
		if(!empty($session)) {
		    $this->db->like('users.username',$session['key'],'both');
		}
	    }
	    
            $this->db->where('users.id_sekolah',$sess['id_sekolah']);
            $this->db->limit($limit,$offset);
	    $sql = $this->db->get();
            if($sql->num_rows()>0) {
                return $sql->result();
            }else{
                return '';
            }
	}
	
	public function tot_pencarian_teman() {
	    $search 	= $this->input->post('search');
	    $sess 	= session_data();
	    $this->db->select('*,
			      (SELECT nama
			      FROM ak_pegawai
			      WHERE users.id=ak_pegawai.id)
			      as nama_pegawai,
			      (SELECT nama
			      FROM ak_siswa
			      WHERE users.id=ak_siswa.id)
			      as nama_siswa');            
            $this->db->from('users');
	    if(!empty($search)) {
		$this->db->like('users.username',$search,'both');
		$this->session->set_userdata('cari_nama',array('key'=>$search));
	    }else{
		$session = $this->session->userdata('cari_nama');
		if(!empty($session)) {
		    $this->db->like('users.username',$session['key'],'both');
		}
	    }
            $this->db->where('users.id_sekolah',$sess['id_sekolah']);
	    $sql = $this->db->get();
	    if($sql->num_rows()>0) {
                return $sql->num_rows();
            }else{
                return 0;
            }
	}
        
        public function foto_galleri($id)
        {
            $this->db->from('sc_foto');
            $this->db->where('id_user',$id);
            $sql = $this->db->get();
            if($sql->num_rows()>0) {
                return $sql->result();
            }else{
                return '';
            }
        }
        
        public function set_komentar_siswa()
        {
            $id_siswa = $this->input->post('id_siswa');
            $id_status = $this->input->post('id_status');
            $komentar = $this->input->post('komentar');
            if(!empty($id_status) AND !empty($komentar) AND !empty($id_siswa))
            {
                $data = array('id_status'=>$id_status,
                              'id_user'=>$id_siswa,
                              'komentar'=>$komentar);
                
                $this->db->insert('sc_komentar',$data);
                $id = $this->db->insert_id();
                
                $this->db->from('sc_komentar');
                $this->db->join('ak_siswa','ak_siswa.id=sc_komentar.id_user');
                $this->db->where('id_komen',$id);
                $sql = $this->db->get();
                if($sql->num_rows()>0) {
                    return $sql->row();
                }else{
                    return '';
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
        
        public function get_pegawai($id=0){
            if($id!=0) {
                $this->db->select('a.id as id_user,
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
        
        public function edit_data_siswa($id)
        {

            $this->db->from('ak_siswa');
            $this->db->join('ak_sekolah','ak_siswa.id_sekolah=ak_sekolah.id','left');
            $this->db->where('ak_siswa.id',$id);
            $sql = $this->db->get();
            if($sql->num_rows()>0)
            {
                return $sql->row();
            }
            else
            {
                return '';
            }
        }
        
        public function delete_status()
        {
            $this->db->select('ak_siswa.*');
			$id_status = $this->input->post('id_status');
            $this->db->from('sc_status');
            $this->db->where('id_status',$id_status);
            $sql= $this->db->get();
            if($sql->num_rows()>0){
                $sql = $sql->row();
                if($sql->id_foto!=0) {
                    $this->db->delete('sc_foto',array('id_foto'=>$sql->id_foto));   
                }
            }
            
            //hapus komentar dulu
            $this->db->delete('sc_komentar',array('id_status'=>$id_status));
            $this->db->delete('sc_status',array('id_status'=>$id_status));
        }
        
        public function delete_komentar()
        {
            $id_komen = $this->input->post('id_komen');
            $this->db->delete('sc_komentar',array('id_komen'=>$id_komen));
        }
        
        //acara user siswa
        public function get_acara_user($id)
        {
            $this->db->from('sc_acara');
            $this->db->where('id_admin_acara',$id);
            $sql = $this->db->get();
            if($sql->num_rows()>0) {
                return $sql->result();
            }else{
                return '';
            }
        }
        
        public function undangan_acara($id)
        {
            $this->db->from('sc_undangan');
            $this->db->join('sc_acara','sc_undangan.id_acara=sc_acara.id_acara');
            $this->db->where('sc_undangan.id_user',$id);
            $this->db->where('id_user',$id);
            $sql = $this->db->get();
            if($sql->num_rows()>0) {
                return $sql->result();
            }else{
                return '';
            }
        }
        
        public function reminder_acara($id)
        {
            $this->db->from('sc_acara');
            $this->db->join('sc_undangan','sc_acara.id_acara=sc_undangan.id_acara');
            $this->db->where('sc_undangan.id_user',$id);
            $this->db->where('sc_acara.tgl_acara',date('Y-m-d'));
            $sql = $this->db->get();
            if($sql->num_rows()>0) {
                return $sql->result();
            }else{
                return '';
            }
        }
        
        public function set_acara_user()
        {
            $session    = session_data();
            $acara      = $this->input->post('acara');
            $hari       = $this->input->post('hari');
            $tgl        = $this->input->post('tgl');
            $jam        = $this->input->post('jam');
            $tempat     = $this->input->post('tempat');
            $keterangan = $this->input->post('keterangan');
            $id_undangan= $this->input->post('id_undangan');
            
            $data  = array('tgl_acara'=>$tgl,
                           'waktu'=>$jam,
                           'tempat'=>$tempat,
                           'nama_acara'=>$acara,
                           'id_admin_acara'=>$session['id'],
                           'pengundang'=>$session['username'],
                           'keterangan'=>$keterangan);
            $this->db->insert('sc_acara',$data);
            $id_acara = $this->db->insert_id();
            
            if(!empty($id_undangan)){
                foreach($id_undangan as $id_user){
                    $data = array('id_acara'=>$id_acara,
                                  'id_user'=>$id_user);
                    
                    $this->db->insert('sc_undangan',$data);
                }
            }
        }
        
        //group
        public function get_group_anda($id)
        {
            $this->db->from('sc_group');
            $this->db->where('pendiri',$id);
            $sql = $this->db->get();
            if($sql->num_rows()>0) {
                return $sql->result();
            }else{
                return '';
            }
        }
        
        public function set_group_user()
        {
            $group          = trim($this->input->post('group'));
            $desk           = trim($this->input->post('deskripsi'));
            $undang_group    = $this->input->post('undang_group'); 
            
            //upload logo
            $config['upload_path']      = './upload/images/larger/';
            $config['allowed_types']    = 'gif|jpg|png';
            $config['max_size']	        = '7000';
            $config['max_width']        = '4000';
            $config['max_height']       = '4000';
            $session = session_data();
            $this->load->library('upload', $config);
            if($_FILES['logo']['tmp_name']!='') {
                if ( ! $this->upload->do_upload('logo'))
                {
                    $error = array('error' => $this->upload->display_errors());
                    print_r($error);exit;
                }
                else
                {
                    $this->load->library('image_moo');
                    $data           = array('upload_data' => $this->upload->data());
                    $path_small     = 'upload/images/thumb/';
                    $path_small2    = 'upload/images/larger/';
                    
                    $this->image_moo
                        ->load($data['upload_data']['full_path'])
                        ->resize_crop(150,150)
                        ->save($path_small.$data['upload_data']['file_name']);
                    
                     $this->image_moo
                            ->load($data['upload_data']['full_path'])
                            ->resize(560,350)
                            ->save($path_small2.$data['upload_data']['file_name']);
                            
                    if ($this->image_moo->errors) {
                        print_r($this->image_moo->display_errors()) ;
                    }
                    
                    $data = array('nama_group'=>$group,
                                'deskripsi'=>$desk,
                                'tgl_daftar'=>date('Y-m-d'),
                                'pendiri'=>$session['id'],
                                'logo'=>$path_small.$this->upload->file_name);
                    $this->db->insert('sc_group',$data);
                    $id_group = $this->db->insert_id();
                    
                    //insert member group
                    if(is_array($undang_group) and !empty($undang_group)) {
                        foreach($undang_group as $idx=>$ug) {
                            $this->db->from('users');
                            $this->db->join('group','users.id_group=group.id');
                            $this->db->where('users.id',$idx);
                            $user = $this->db->get();
                            if($user->num_rows()>0) {
                                $user = $user->row();
                            }else{
                                $user = 0;
                            }
                            
                            $data = array('id_group'=>$id_group,
                                          'id_user'=>$idx,
                                          'nama'=>$ug,
                                          'user'=>$user->otoritas,
                                          'foto_member'=>$user->images,
                                          'jenis_member'=>'user',
                                          'stat_member'=>'not aktif',
                                          'stat_confirm'=>'menunggu');
                            
                            $this->db->insert('sc_member',$data);
                        }
                    }
                    
                     $this->db->select('*,
				  (SELECT nama
				  FROM ak_pegawai
				  WHERE id=users.id) as nama_pegawai,
				  (SELECT nama
				  FROM ak_siswa
				  WHERE id=users.id) as nama_siswa');
                    $this->db->from('users');
                    $this->db->where('users.id',$session['id']);
                    $nama_admin = $this->db->get();
                    if($nama_admin->num_rows()>0) {
                        $nama_admin = (!empty($nama_admin->row()->nama_pegawai) ? $nama_admin->row()->nama_pegawai : $nama_admin->row()->nama_siswa);
                    }
                    
                    $data = array('id_group'=>$id_group,
                                'id_user'=>$session['id'],
                                'nama'=>$nama_admin,
                                'user'=>$session['otoritas'],
                                'foto_member'=>$session['images'],
                                'jenis_member'=>'admin',
                                'stat_member'=>'aktif',
                                'stat_confirm'=>'terima');
                            
                    $this->db->insert('sc_member',$data);
                    
                }
            }else{
                $data = array('nama_group'=>$group,
                            'deskripsi'=>$desk,
                            'tgl_daftar'=>date('Y-m-d'),
                            'pendiri'=>$session['id']);
                $this->db->insert('sc_group',$data);
                $id_group = $this->db->insert_id();
                //insert member group tes
                if(is_array($undang_group) and !empty($undang_group)) {
                    foreach($undang_group as $idx=>$ug) {
                        
                        $this->db->from('users');
                        $this->db->join('group','users.id_group=group.id');
                        $this->db->where('users.id',$idx);
                        $user = $this->db->get();
                        if($user->num_rows()>0) {
                            $user = $user->row();
                        }else{
                            $user = 0;
                        }
                        
                        $data = array('id_group'=>$id_group,
                                      'id_user'=>$idx,
                                      'nama'=>$ug,
                                      'user'=>$user->otoritas,
                                      'foto_member'=>$user->images,
                                      'jenis_member'=>'user',
                                      'stat_member'=>'not aktif',
                                      'stat_confirm'=>'menunggu');
                        
                        $this->db->insert('sc_member',$data);
                    }
                }
                
                $this->db->select('*,
				  (SELECT nama
				  FROM ak_pegawai
				  WHERE id=users.id) as nama_pegawai,
				  (SELECT nama
				  FROM ak_siswa
				  WHERE id=users.id) as nama_siswa');
		$this->db->from('users');
		$this->db->where('users.id',$session['id']);
		$nama_admin = $this->db->get();
		if($nama_admin->num_rows()>0) {
		    $nama_admin = (!empty($nama_admin->row()->nama_pegawai) ? $nama_admin->row()->nama_pegawai : $nama_admin->row()->nama_siswa);
		}
                
                $data = array('id_group'=>$id_group,
                                'id_user'=>$session['id'],
                                'nama'=>$nama_admin,
                                'user'=>$session['otoritas'],
                                'foto_member'=>$session['images'],
                                'jenis_member'=>'admin',
                                'stat_member'=>'aktif',
                                'stat_confirm'=>'terima');
                            
                $this->db->insert('sc_member',$data);
            }
        }
        
        public function keluar_user_group($id)
        {
            $session = session_data();
            $this->db->where('id_group',$id);
            $this->db->where('id_user',$session['id']);
            $this->db->delete('sc_member');
        }
        
        public function get_undangan_group($id) {
            $this->db->from('sc_member');
            $this->db->join('sc_group','sc_group.id_group=sc_member.id_group');
            $this->db->where('id_user',$id);
            $this->db->where('stat_member','not aktif');
            $this->db->where('stat_confirm','menunggu');
            $sql = $this->db->get();
            if($sql->num_rows()>0) {
                return $sql->result();
            }else{
                return '';
            }
        }
        
        public function group_diterima($id)
        {
            if($id!=0) {
                $session = session_data();
                $data = array('stat_member'=>'aktif',
                              'stat_confirm'=>'terima');
                $this->db->where('id_group',$id);
                $this->db->where('id_user',$session['id']);
                $this->db->update('sc_member',$data);
            }
        }
        
        public function group_ditolak($id)
        {
            if($id!=0) {
                $session = session_data();
                $this->db->where('id_group',$id);
                $this->db->where('id_user',$session['id']);
                $this->db->where('stat_confirm','menunggu');
                $this->db->delete('sc_member');
            }
        }
        
        public function get_group_diikuti($id)
        {
            if($id!=0) {
                $this->db->from('sc_member');
                $this->db->join('sc_group','sc_member.id_group=sc_group.id_group');
                $this->db->where('id_user',$id);
                $this->db->where('pendiri !=',$id);
                $this->db->where('stat_confirm','terima');
                $this->db->where('stat_member','aktif');
                $sql = $this->db->get();
                if($sql->num_rows()>0) {
                    return $sql->result();
                }else{
                    return '';
                }
            }
        }
    }
	
?>