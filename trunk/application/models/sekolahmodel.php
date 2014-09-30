<?php
    class Sekolahmodel extends CI_Model
    {
        public function get_nama_sekolah($cari='')
        {
            $this->db->select("*");
            $this->db->from('sc_sekolah');
            $this->db->where('stat_sekolah','aktif');
            $this->db->like('nama',$cari,'both');
            $result = $this->db->get();
            if($result->num_rows()>0) {
                return $result->result();
            }else {
                return '';
            }
            
        }
        
        public function pendaftaran_pegawai()
        {
            $sekolah    = $this->input->post('sekolah');
            $pegawai    = $this->input->post('pegawai');
            $nip        = $this->input->post('nip');
            $nama       = $this->input->post('nama');
            $alamat     = $this->input->post('alamat');
            $kota       = $this->input->post('kota');
            $password   = $this->input->post('password');
            $gender     = $this->input->post('gender');
            $telp       = $this->input->post('telp');
            $email      = $this->input->post('email');
            $foto       = $this->input->post('foto');
            
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
                
                $data_user = array('id_group'=>$pegawai,
                                   'id_sekolah'=>$sekolah,
                                   'username'=>$nama,
                                   'password'=>md5($password),
                                   'images'=>'upload/images/thumb/'.$file_name,
                                   'aktif'=>1);
                $this->db->insert('users',$data_user);
                $id_pegawai = $this->db->insert_id();
                
                $data       = array('id'=>$id_pegawai,
                                'nip'=>$nip,
                                'id_sekolah'=>$sekolah,
                                'nip'=>$nip,
                                'tgl_daftar'=>date('Y-m-d H:m:s'),
                                'nama'=>$nama,
                                'alamat'=>$alamat,
                                'kota'=>$kota,
                                'email'=>$email,
                                'telp'=>$telp,
                                'password'=>$password,
                                'foto'=>'upload/images/thumb/'.$file_name);
                $this->db->insert('ak_pegawai',$data);
                
            }else{
                
                $data_user = array('id_group'=>$pegawai,
                                   'id_sekolah'=>$sekolah,
                                   'username'=>$nama,
                                   'images'=>'upload/images/thumb/'.$file_name,
                                   'password'=>md5($password),
                                   'aktif'=>1);
                $this->db->insert('users',$data_user);
                $id_pegawai = $this->db->insert_id();
                
                $data       = array('id'=>$id_pegawai,
                                'nip'=>$nip,
                                'id_sekolah'=>$sekolah,
                                'nip'=>$nip,
                                'tgl_daftar'=>date('Y-m-d H:m:s'),
                                'nama'=>$nama,
                                'alamat'=>$alamat,
                                'kota'=>$kota,
                                'email'=>$email,
                                'telp'=>$telp,
                                'password'=>$password);
                $this->db->insert('ak_pegawai',$data);
            }
        }
        
        public function ubah_profil($id,$foto)
        {
            if($id!=0 AND !empty($foto)) {
                $this->db->where('id_sek',$id);
                $data = array(
                    'foto'=>$foto
                );
                
                $this->db->update('sc_sekolah',$data);
            }
        }
        
        public function get_sekolah($id)
        {
            if($id!=0)
            {
                $this->db->from('sc_sekolah');
                $this->db->join('provinsi','sc_sekolah.IDprov=provinsi.IDprov','left');
                $this->db->join('kota','sc_sekolah.IDkota=kota.IDkota','left');
                $this->db->where('id_sek',$id);
                $sql = $this->db->get();
                if($sql->num_rows()>0) {
                    return $sql->result();
                }else {
                    return '';
                }
            }
        }

        public function get_sekolah_by_id($id)
        {
            if($id!=0)
            {
                $this->db->where('id',$id);
                $sql = $this->db->get('ak_sekolah');
                if($sql->num_rows()>0) {
                    return $sql->row();
                }else {
                    return '';
                }
            }
        }
        
        public function get_provinsi()
        {
            $this->db->select('*');
            $this->db->from('provinsi');
            $this->db->order_by('NmProv','ASC');
            $sql = $this->db->get();
            if($sql->num_rows()>0) {
                return $sql->result();
            }else {
                return '';
            }
            
        }
        
        public function get_jenjang()
        {
            $this->db->from('ak_jenjang');
            $sql = $this->db->get();
            if($sql->num_rows()>0) {
                return $sql->result();
            }else{
                return '';
            }
        }
        
        public function get_kota_by($id)
        {
            $this->db->select('*');
            $this->db->from('kota');
            $this->db->where('IDprov',$id);
            $this->db->order_by('NmKota','Asc');
            $sql = $this->db->get();
            if($sql->num_rows()>0)
            {
                return $sql->result_array();
            }
            else{
                return '';
            }
        }
        
        public function set_sekolah()
        { 	
            $jenjang    = $this->input->post('jenjang');
            $telp_pendaftar    = $this->input->post('selular');
            $nama_pendaftar    = $this->input->post('nama_pendaftar');
            $email_pendaftar    = $this->input->post('email_pendaftar');
            $sekolah    = $this->input->post('sekolah');
            $alamat     = $this->input->post('alamat');
            $provinsi   = $this->input->post('provinsi');
            $kabupaten  = $this->input->post('kabupaten');
            $email  	= $this->input->post('email_sk');
            $bentuk       = $this->input->post('bentuk');
            $telp       = $this->input->post('telp');
           // $selular    = $this->input->post('selular');
            $username   = $this->input->post('email_sk');
            $password   = $this->input->post('password');
            
            $data = array('id_jenjang'=>$jenjang,
                          'nama_pendaftar'=>$nama_pendaftar,
                          'telp_pendaftar'=>$telp_pendaftar,
                          'email_pendaftar'=>$email_pendaftar,
                          'nama_sekolah'=>$sekolah,
                          'alamat_sekolah'=>$alamat,
                          'prop'=>$provinsi,
                          'kec'=>$kabupaten,
                          'telepon'=>$telp,
                          'email'=>$email,
                          'bentuk'=>$bentuk
						  );
            
            $this->db->insert('ak_sekolah',$data);
            $id = $this->db->insert_id();
            $datausers = array(
								   'id_group' => 11,
								   'id_sekolah' => $id,
								   'username' => $username,
								   'password' => md5($password),
								   'id_pengguna' => $id,
								   'aktif' => 0
								);
								$this->db->insert('users', $datausers); 
								$this->db->insert('ak_step_registrasi', array('id_sekolah'=>$id)); 
								
								$rumus=array('rumus_raport'=>'((25/100) * $UAS)+((25/100) * $UTS)+((20/100) * $PR)+((20/100) * $TUGAS)+((10/100) * $HARIAN)');
								$insertrumus=array(
										'id_sekolah'=>$id,
										'key'=>'rumusraport_'.$id.'',
										'value'=>serialize($rumus)
								);
								$this->db->insert('ak_setting',$insertrumus);
			//email verifikasi
			// multiple recipients
			$to  = $email. ', '; // note the comma
			//$to .= 'wez@example.com';

			// subject
			$subject = 'Studentbook verifikasi';
			$l['unm']=$username;
			$l['pwd']=$password;
			$link=serialize($l);
			// message
			for($i=0;$i<5;$i++){
				$link= base64_encode($link);
			}
			
			$message = '
			<html>
			<head>
			  <title>Selamat datang '.$nama_pendaftar.' di STUDENTBOOK</title>
			</head>
			<body>
			  <p><b>Selamat Bergabung dalam Komunitas Sekolah Digital Indonesia</b></p>
			  <p>Untuk Mengaktifkan akun STUDENTBOOK anda silahkan klik link dibawah ini</p>
			  <table>
				<tr>
				  <td>
					<a href="'.base_url().'sos/sekolah/verifikasi/'.$link.'" >'.base_url().'sos/sekolah/verifikasi/'.$link.'</a>
				  </td>
				</tr>
				<tr>
				  <td>
					username: '.$email.'<br />
					password: '.$password.'
				  </td>
				</tr>
				<tr>
				  <td>contact: mail@studentbook.co</td>
				</tr>
			  </table>
			</body>
			</html>
			';
			//echo $message;
			// To send HTML mail, the Content-type header must be set
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

			// Additional headers
			$headers .= 'To: '.$nama_pendaftar.' <'.$email_pendaftar.'>' . "\r\n";
			$headers .= 'From: Studentbook <mail@studentbook.co>' . "\r\n";
			//$headers .= 'Cc: birthdayarchive@example.com' . "\r\n";
			//$headers .= 'Bcc: birthdaycheck@example.com' . "\r\n";

			// Mail it
			mail($to, $subject, $message, $headers);
            return $id; 
        }
        
        public function data_content($id) {
            $this->db->from('ak_content');
            $this->db->where('id_sekolah',$id);
            $sql = $this->db->get();
            if($sql->num_rows()>0) {
                return $sql->result();
            }else{
                return '';
            }
        }
        
        public function berita_sekolah($id)
        {
            $this->db->from('sc_berita');
            $this->db->where('id_sek',$id);
            $sql = $this->db->get();
            if($sql->num_rows()>0) {
                return $sql->result();
            }else{
                return '';
            }
            
        }
        
        public function data_sekolah($id)
        {
            $this->db->from('ak_sekolah');
            $this->db->where('id',$id);
            $sql = $this->db->get();
            if($sql->num_rows()>0) {
                return $sql->row();
            }else{
                return '';
            }
        }

        public function get_pencarian($limit,$offset) {
            $search = $this->input->post('pencarian');
            $this->db->from('ak_sekolah');
            if(!empty($search)) {
                $this->db->like('nama_sekolah',$search,'both');    
                $this->session->set_userdata('search',array('key'=>$search));
            }else{
                $session = $this->session->userdata('search');
                if(!empty($session)) {
                    $this->db->like('nama_sekolah',$session['key'],'both');    
                }
            }
            $this->db->limit($limit,$offset);
            $sql = $this->db->get();
            if($sql->num_rows()>0) {
                return $sql->result();
            }else{
                return '';
            }
        }
        
        public function get_foto_galleri($id) {
            $this->db->from('ak_galleri_sekolah');
            $this->db->where('id_sekolah',$id);
            $sql = $this->db->get();
            if($sql->num_rows()>0) {
                return $sql->result();
            }else{
                return '';
            }
        }
        
        public function tot_paging_pencarian() {
            $search = $this->input->post('pencarian');
            $this->db->from('ak_sekolah');
            if(!empty($search)) {
                $this->db->like('nama_sekolah',$search,'both');    
                $this->session->set_userdata('search',array('key'=>$search));
            }else{
                $session = $this->session->userdata('search');
                if(!empty($session)) {
                    $this->db->like('nama_sekolah',$session['key'],'both');    
                }
            }
            $sql = $this->db->get();
            if($sql->num_rows()>0) {
                return $sql->num_rows();
            }else{
                return '';
            }
        }
        
        public function pencarian_sekolah()
        {
            $keyword = $this->input->post('pencarian');
            $this->db->from('ak_sekolah');
            $this->db->select('*');
            $this->db->like('nama_sekolah',$keyword,'both');
            $sql = $this->db->get();
            if($sql->num_rows()>0) {
                return $sql->result();
            }else{
                return '';
            }
        }
        
        public function get_all_sekolah()
        {
            $this->db->select('id,nama_sekolah');
            $this->db->from('ak_sekolah');
            $sql = $this->db->get();
            if($sql->num_rows()>0) {
                return $sql->result();
            }else{
                return '';
            }
        }
        
    }
?>