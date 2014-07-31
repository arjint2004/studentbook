<?php
class Sekolah extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('sekolahmodel');
        $this->load->model('siswamodel');
        $this->load->helper('akademik');
        $this->load->library('form_validation');
	$this->load->library('pagination');
        $this->load->library('image_moo');
        $this->load->helper('global');
    }
    
    public function index() {
        $data['main']       = 'daftarview';
        $data['jenjang']    = $this->sekolahmodel->get_jenjang();
        $data['provinsi']   = $this->sekolahmodel->get_provinsi();
        $data['breadcumbs']   = 'LANGKAH 1 : SILAHKAN DAFTARKAN SEKOLAH ANDA!';
        $this->load->view('layout/fr_blank',$data);
    }
    
    public function pencari_sekolah() {
	$result			= $this->show_all_pencarian();
	$data['result']		= $result['data'];
	$data['pagination']	= $result['pagination'];
	$data['breadcumbs']   = 'DAFTAR HASIL PENCARIAN SEKOLAH';
	$data['main']       	= 'list_pencarian';
	$this->load->view('layout/fr_blank',$data);
    }
    
    public function content($id_sekolah=0,$title='') {
		$this->load->model('ad_content');
		$title=str_replace("_"," ",$title);
		$content=$this->ad_content->getdata($id_sekolah,$title);
		$data['content']=$content;
		$data['data']		= $this->sekolahmodel->data_sekolah($id_sekolah);
		$data['id_sekolah']     =$id_sekolah;
		$data['main']       	= 'sosial/contentsekolah';
		$this->load->view('layout/home_default',$data);
	}
    public function detail_sekolah($id) {
	if($id!=0) {
		
		$this->load->model('ad_content');
	    $content 		= $this->ad_content->getAlldata($id);
		foreach($content as $kk=>$datcont){
			$cnt2[$datcont['title']]=$datcont;
		}
		$data['content']=$cnt2;
	    $config['uri_segment']  	= 6;
	    $config['base_url']     	= site_url('sos/sekolah/detail_sekolah/'.$id.'/k/');
	    $config['per_page']     	= 5;
	    $config['total_rows']   	= $this->siswamodel->tot_paging_kegiatan2($id);
	    $config['prev_tag_open'] 	= '<a href="" class="prev-post" title=""> ';
	    $config['prev_link'] 	= ' ';
	    $config['prev_tag_close'] 	= '</a>';
	    
	    $config['cur_tag_open']	= '<li class="active-page">';
	    $config['cur_tag_close'] 	= '</li>';
	    
	    $config['next_tag_open'] 	= '<a href="" class="next-post" title=""> ';
	    $config['next_link']	= ' ';
	    $config['next_tag_close'] 	= '</a>';
	    $config['num_tag_open']	= '<li>';
	    $config['num_tag_close'] 	= '</li>';
	    $config['num_links']    	='10';
	    $this->pagination->initialize($config);
	    
	    $kegiatan['data']	        = $this->siswamodel->get_index_kegiatan2($id,$config['per_page'],$this->uri->segment(6));
	    $kegiatan['pagination']	= $this->pagination->create_links();
	    $data['kegiatan']           = $kegiatan;
	    
	    $config2['uri_segment']  	= 5;
	    $config2['base_url']     	= site_url('sos/sekolah/detail_sekolah/'.$id.'/');
	    $config2['per_page']     	= 6;
	    $config2['total_rows']   	= $this->siswamodel->tot_paging_berita2($id);
	    $config2['prev_tag_open'] 	= '<a href="" class="prev-post" title=""> ';
	    $config2['prev_link'] 	= ' ';
	    $config2['prev_tag_close'] 	= '</a>';
	    
	    $config2['cur_tag_open']	= '<li class="active-page">';
	    $config2['cur_tag_close'] 	= '</li>';
	    
	    $config['next_tag_open'] 	= '<a href="" class="next-post" title=""> ';
	    $config['next_link']	= ' ';
	    $config['next_tag_close'] 	= '</a>';
	    $config2['num_tag_open']	= '<li>';
	    $config2['num_tag_close'] 	= '</li>';
	    $config2['num_links']    	='10';
	    $this->pagination->initialize($config2);
	    
	    $this->load->model('sekolahmodel');
	    $data['sekolah']        	= $this->sekolahmodel->get_all_sekolah();
	    $berita['data']	        = $this->siswamodel->get_index_berita2($id,$config2['per_page'],$this->uri->segment(5));
	    $berita['pagination']	= $this->pagination->create_links();
	    $data['berita']         	= $berita;
	    
	    $data['data']		= $this->sekolahmodel->data_sekolah($id);
	    $data['berita_terbaru']	= $this->siswamodel->get_berita_custom($id);
	    $data['kegiatan_terbaru']  	= $this->siswamodel->get_kegiatan_custom($id);
	    $data['id_sekolah']  	= $id;
		
	    $this->load->view('layout/profil',$data);
	}
    }
    
    public function show_all_pencarian() {
	$config['uri_segment']  	= 4;
        $config['base_url']     	= site_url('sos/sekolah/pencari_sekolah/');
        $config['per_page']     	= 6;
        $config['total_rows']   	= $this->sekolahmodel->tot_paging_pencarian();
        $config['prev_tag_open'] 	= '<li>';
        $config['prev_link'] 		= 'Prev';
        $config['prev_tag_close'] 	= '</li>';
        
        $config['cur_tag_open']		= '<li class="active-page">';
        $config['cur_tag_close'] 	= '</li>';
        
	$config['first_link'] 		= 'First';
	$config['first_tag_open'] 	= '<li>';
	$config['first_tag_close']	= '</li>';
	$config['last_link'] 		= 'Last';
	$config['last_tag_open'] 	= '<li>';
	$config['last_tag_close'] 	= '</li>';

        $config['next_tag_open'] 	= '<li>';
        $config['next_link']		= 'Next';
        $config['next_tag_close'] 	= '</li>';
        
	$config['num_tag_open']		= '<li>';
        $config['num_tag_close'] 	= '</li>';
        $config['num_links']    	= 1;
        $this->pagination->initialize($config);
        
        $data['data']	        	= $this->sekolahmodel->get_pencarian($config['per_page'],$this->uri->segment(4));
        $data['pagination']		= $this->pagination->create_links();
        return $data;
    }
    
    public function profil_sekolah($id=0)
    {
	if($id!=0) {
	    $data['content']		= $this->sekolahmodel->data_content($id);
	    $data['data']		= $this->sekolahmodel->data_sekolah($id);
	    $data['berita_terbaru']	= $this->siswamodel->get_berita_custom($id);
	    $data['kegiatan_terbaru']  	= $this->siswamodel->get_kegiatan_custom($id);
	    $this->load->view('layout/profil_sekolah',$data);
	}
    }
    
    public function cari() {
        if(!empty($_GET)) {
            $search = $_GET['search'];
            $result = $this->sekolahmodel->get_sekolah($search);
            if(!empty($result)) {
                return $result;
            }else{
                return 'Nama Sekolah Tidak Ditemukan';
            }
        }
    }
    
    public function kirim_pesan() {
	$this->form_validation->set_rules('nama','Name','required');
	$this->form_validation->set_rules('email','Email','required|valid_email');
	$this->form_validation->set_rules('subject','Judul','required');
	$this->form_validation->set_rules('pesan','Pesan','required');
	$id_sekolah		= $this->input->post('id_sekolah');
	
	if($this->form_validation->run()==FALSE) {
            $this->detail_sekolah($id_sekolah);
        }else{			
	    $email_sekolah		= $this->input->post('email_sekolah');
	    $nama			= $this->input->post('nama');
	    $email			= $this->input->post('email');
	    $subject			= $this->input->post('subject');
	    $pesan			= $this->input->post('pesan');
	    
	    $config_pesan = array(
		'protocol' 	=> 'smtp',
		'smtp_host' 	=> 'smtp.gmail.com',
		'smtp_port' 	=> '465',
		'smtp_crypto' 	=> 'ssl',
		'smtp_user' 	=> 'zenuddin@tlab.co.id',
		'smtp_pass' 	=> 'zenuddin123',
		'mailtype' 	=> 'html',
		'charset' 	=> 'iso-8859-1'
	    );
	    $this->load->library('email', $config_pesan);
	    $this->email->initialize($config_pesan);
	    $this->email->set_newline("\r\n");
	    
	    $this->email->from('User Studentbook',$email);
	    $this->email->to($email_sekolah);
	    $this->email->subject($subject);
	    $this->email->message($pesan);
	    $this->email->send();
	    set_green_notification('Pesan Berhasil Dikirim');
	    redirect('sos/sekolah/detail_sekolah/'.$id_sekolah);
	}
    }
    
    public function galleri_sekolah($id) {
	if($id!=0) {
	    $data['content']		= $this->sekolahmodel->data_content($id);
	    $data['data']		= $this->sekolahmodel->data_sekolah($id);
	    $data['berita_terbaru']	= $this->siswamodel->get_berita_custom($id);
	    $data['kegiatan_terbaru']  	= $this->siswamodel->get_kegiatan_custom($id);
	    $data['galleri_foto']	= $this->sekolahmodel->get_foto_galleri($id);
	    $this->load->view('layout/galleri_sekolah',$data);
	}
    }
    
    public function view_sekolah($id)
    {
        if($id!=0) {
            $data['data_sekolah'] = $this->sekolahmodel->data_sekolah($id);
            $data['berita']         = $this->siswamodel->get_berita($id);
            $data['kegiatan']       = $this->siswamodel->get_kegiatan($id);
            $data['main']         = 'viewsekolah';
            $data['sidebar']      = 'layout/template_sidebar';
            $this->load->view('layout/fr_blank',$data);            
        }
    }
    public function get_kota()
    {
        $id = $this->input->post('id');
        $hasil = $this->sekolahmodel->get_kota_by($id);
        echo json_encode($hasil);
    }
    
    public function cari_sekolah()
    {
        if(!empty($_POST)) {
            $result = $this->sekolahmodel->pencarian_sekolah();
            echo json_encode($result);
        }
        
    }
    
    public function verifikasi($link=''){
		if($link!=''){
			for($i=0;$i<5;$i++){
				$link= base64_decode($link);
			}
			$link=unserialize($link);
			$arrayupdate=array('username'=>$link['unm'],'password'=>md5($link['pwd']));
			$this->db->where($arrayupdate);
			$this->db->update('users ', array('aktif'=>1)); 
			//echo $this->db->last_query();
			redirect('authentication/auth/'.$link['unm'].'/'.$link['pwd']);
		}else{
			redirect('/');
		}
		//pr($link);
		
	}
    public function daftar_sekolah()
    {
        $this->form_validation->set_rules('jenjang','jenjang','required');
        $this->form_validation->set_rules('sekolah','sekolah','required');
        $this->form_validation->set_rules('alamat','alamat','required');
        $this->form_validation->set_rules('provinsi','provinsi','required');
        $this->form_validation->set_rules('kabupaten','kabupaten','required');
        //$this->form_validation->set_rules('akreditasi','akreditasi','required');
        $this->form_validation->set_rules('nama_pendaftar','nama pendaftar','required');
        $this->form_validation->set_rules('telp','telp','required|numeric');
        $this->form_validation->set_rules('email_sk','email sekolah','required|valid_email');
        $this->form_validation->set_rules('selular','selular','required|numeric');
        $this->form_validation->set_rules('email_pendaftar','email pendaftar','required|valid_email');
        //$this->form_validation->set_rules('username','username','required');
        $this->form_validation->set_rules('password','password','required');
        $this->form_validation->set_rules('konfirmasi','konfirmasi','required|matches[password]');
		
        if($this->form_validation->run()==FALSE) {
            $this->index();
        }else{
		   $id=$this->sekolahmodel->set_sekolah();
           redirect('sos/sekolah/daftarsuccess');
        }
    }
    
    public function daftarsuccess($id=1){
			$data['main']       = 'daftarsuccess'; 
			$data['datadaftar']=$_POST;
			$this->load->view('layout/fr_blank',$data);
	}
    public function add_foto($id=1){
        $data['upload_path']        = $upload_path          = "upload/images/larger/" ;
        $data['destination_thumbs'] = $destination_thumbs   = "upload/images/thumb/" ;
        $data['id']                 = $id;
        $data['large_photo_exists'] = $data['thumb_photo_exists'] = $data['error'] = NULL ;
        $data['thumb_width']        = "150";
        $data['thumb_height']       = "150";
        $width_gambar  =656;
        $height_gambar =300;
                
        if (!empty($_POST['upload'])) {
            $config['upload_path']  = $upload_path ;
            $config['allowed_types']= 'gif|jpg|png|jpeg';
            $config['max_size']     = '2000';
            $config['max_width']    = '4000';
            $config['max_height']   = '4000';
            $this->load->library('upload', $config);
            if ($this->upload->do_upload("image")) {
                $data['img']	 = $this->upload->data();
                if($data['img']['image_width'] > $width_gambar) {
                        $config2['image_library'] = 'gd2';
                        $config2['source_image'] = $this->upload->upload_path.$this->upload->file_name;
                        $config2['new_image'] = './upload/images/medium/';
                        $config2['maintain_ratio'] = TRUE;
                        $config2['create_thumb'] = TRUE;
                        $config2['thumb_marker'] = '';
                        $config2['height'] = $height_gambar;
                        $this->load->library('image_lib',$config2);
                        $this->image_lib->initialize($config2);
                        $this->image_lib->resize();
                        $this->image_lib->clear();
                        $upload_path = '/upload/images/medium/';
                        list($width_new_image,$height_new_image) = getimagesize(base_url().$upload_path.$data['img']['file_name']);
                        $data['img']['image_width'] = $width_new_image;
                        $data['img']['image_height'] = $height_new_image;
                        $data['upload_path'] = $upload_path;
                }
                $data['large_photo_exists']  = "<img src=\"".base_url() . $upload_path.$data['img']['file_name']."\" alt=\"Large Image\"/>";
            }else{
                $data['error'] = $this->upload->display_errors();
            }
        }
        elseif (!empty($_POST['upload_thumbnail'])) {
            $upload_path = 'upload/images/medium/';
            $x1 = $this->input->post('x1',TRUE) ;
            $y1 = $this->input->post('y1',TRUE) ;
            $x2 = $this->input->post('x2',TRUE) ;
            $y2 = $this->input->post('y2',TRUE) ;
            $w  = $this->input->post('w',TRUE) ;
            $h  = $this->input->post('h',TRUE) ;

            $file_name = $this->input->post('file_name',TRUE) ;
            
            if ($file_name) {
                $this->image_moo
                    ->load($upload_path . $file_name)
                    ->crop($x1,$y1,$x2,$y2)
                    ->save($destination_thumbs . $file_name) ;

                if ($this->image_moo->errors) {
                    $data['error'] = $this->image_moo->display_errors() ;
                }
                else {
                    $this->sekolahmodel->ubah_profil($id,$destination_thumbs.$file_name);
                    $data['thumb_photo_exists'] = "<img src=\"".base_url() . $destination_thumbs . $file_name."\" alt=\"Thumbnail Image\"/>";
                    $data['large_photo_exists'] = "<img src=\"".base_url() . $upload_path.$file_name."\" alt=\"Large Image\"/>";
                    redirect('sos/sekolah');
                }
            }

        }
        $data['main']       = 'add_foto';
        $data['sekolah']    = $this->sekolahmodel->get_sekolah($id);
        $this->load->view('layout/fr_blank',$data);
    }
    
    public function finish()
    {
        if(!empty($_POST)) {
            $file   = $this->input->post('file_name');
            $id     = $this->input->post('id');
            if(empty($file)) {
                redirect('sos/sekolah');
            }
        }
    }
    
    public function daftar_siswa()
    {
        $data['main']       = 'daftaruser';
        $data['sekolah']    = $this->sekolahmodel->get_all_sekolah();
        $this->load->view('layout/fr_blank',$data);
    }
    
    public function daftar_pegawai()
    {
        $data['main']       = 'daftarpegawai';
        $data['group']      = $this->db->get('group')->result();
        $data['sekolah']    = $this->sekolahmodel->get_all_sekolah();
        $this->load->view('layout/fr_blank',$data);
    }
    
    public function pegawaidaftar()
    {
        $this->sekolahmodel->pendaftaran_pegawai();
        redirect('sos/sekolah/daftar_pegawai');   
    }
    
    public function daftaruser()
    {
        $sekolah    = $this->input->post('sekolah');
        $nis        = $this->input->post('nis');
        $nama       = $this->input->post('nama');
        $password   = $this->input->post('password');
        $gender     = $this->input->post('gender');
        $alamat     = $this->input->post('alamat');
        $kota       = $this->input->post('kota');
        $telp       = $this->input->post('telp');
        $email      = $this->input->post('email');
    
        
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
            
            $data_user = array('id_group'=>12,
                               'id_sekolah'=>$sekolah,
                               'username'=>$nama,
                               'password'=>md5($password),
                               'images'=>'upload/images/thumb/'.$file_name,
                               'aktif'=>1);
            $this->db->insert('users',$data_user);
            $id_siswa = $this->db->insert_id();
            
            $data= array('id'=>$id_siswa,
                         'id_sekolah'=>$sekolah,
                         'nis'=>$nis,
                         'nama'=>$nama,
                         'password'=>$password,
                         'gender'=>$gender,
                         'alamat'=>$alamat,
                         'kota'=>$kota,
                         'telp'=>$telp,
                         'email'=>$email,
                         'foto'=>'upload/images/thumb/'.$file_name);
            $this->db->insert('ak_siswa',$data);
        }else{
            $data_user = array('id_group'=>12,
                               'id_sekolah'=>$sekolah,
                               'username'=>$nama,
                               'images'=>'upload/images/thumb/'.$file_name,
                               'password'=>md5($password),
                               'aktif'=>1);
            $this->db->insert('users',$data_user);
            $id_siswa = $this->db->insert_id();
            
            $data= array('id'=>$id_siswa,
                         'id_sekolah'=>$sekolah,
                         'nis'=>$nis,
                         'nama'=>$nama,
                         'password'=>$password,
                         'gender'=>$gender,
                         'alamat'=>$alamat,
                         'kota'=>$kota,
                         'telp'=>$telp,
                         'email'=>$email);
            $this->db->insert('ak_siswa',$data);
        }
        redirect('sos/sekolah');
    }
    
    public function berita_sekolah()
    {
        $data['main']       = 'beritaview';
        $data['sekolah']    = $this->sekolahmodel->get_all_sekolah();
        $this->load->view('layout/fr_blank',$data);
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
            }
            $data = array('id_admin'=>$user['id_pengguna'],
                          'id_sek'=>$user['id_sekolah'],
                          'foto'=>$file_name,
                          'judul'=>$judul,
                          'berita'=>$berita,
                          'stat_berita'=>'aktif');
            $this->db->insert('sc_berita',$data);

        }else{
            $data = array('id_admin'=>$user['id_pengguna'],
                          'id_sek'=>$user['id_sekolah'],
                          'judul'=>$judul,
                          'berita'=>$berita,
                          'stat_berita'=>'aktif');
            $this->db->insert('sc_berita',$data);
        }
        redirect('sos/sekolah');
    }
    
    public function kegiatan_sekolah()
    {
        $data['main']       = 'kegiatanview';
        $data['sekolah']    = $this->sekolahmodel->get_all_sekolah();
        $this->load->view('layout/fr_blank',$data);
    }
    
    public function simpan_kegiatan()
    {
        $session = session_data();
        $judul  = $this->input->post('judul');
        $tgl    = $this->input->post('tgl_kegiatan');
        $jam    = $this->input->post('jam');
        $tempat = $this->input->post('tempat');
        $ket    = $this->input->post('keterangan');
        
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
            $data = array('id_admin'=>$session['id_pengguna'],
                            'id_sek'=>$session['id_sekolah'],
                            'judul'=>$judul,
                            'tgl_keg'=>$tgl,
                            'foto'=>$file_name,
                            'jam'=>$jam,
                            'lokasi'=>$tempat,
                            'keterangan'=>$ket);
              $this->db->insert('sc_kegiatan',$data);

        }else{
            $data = array('id_admin'=>$session['id_pengguna'],
                            'id_sek'=>$session['id_sekolah'],
                            'judul'=>$judul,
                            'tgl_keg'=>$tgl,
                            'jam'=>$jam,
                            'lokasi'=>$tempat,
                            'keterangan'=>$ket);
              $this->db->insert('sc_kegiatan',$data);
        }
        redirect('sos/sekolah');
    }
    
    public function side()
    {
        $data['main']       = 'sideview';
        $data['sekolah']    = $this->sekolahmodel->get_all_sekolah();
        $this->load->view('layout/fr_blank',$data);
    }
    
    public function simpan_side()
    {
        
    }
}
?>