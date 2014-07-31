<?php
class Pegawai extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('global');
        $this->load->library('session');
        $this->load->library('auth');
        $this->auth->user_logged_in();
        $this->load->library('pagination');
        $this->load->library('image_moo');
        $this->load->model('pegawaimodel');
        $this->load->library('form_validation');
        $this->load->library('Online_Users');
    }
    
    public function hapus_foto_pribadi($id=0) {
        if($id!=0) {
            $this->pegawaimodel->foto_pribadi_hapus($id);
            set_green_notification('Foto Berhasil Dihapus');
            redirect('sos/pegawai');
        }else{
            redirect('sos/pegawai');
        }
    }
    
    public function cari_teman_user() {
        $config['uri_segment']  	= 4;
        $config['base_url']     	= site_url('sos/pegawai/cari_teman_user/');
        $config['per_page']     	= 10;
        $config['total_rows']   	= $this->pegawaimodel->tot_pencarian_teman();
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
        $config['num_links']    	= 5;
        $this->pagination->initialize($config);
        
        $data['data']	        	= $this->pegawaimodel->user_cari_teman($config['per_page'],$this->uri->segment(4));
        $data['pagination']		= $this->pagination->create_links();
        $data['sidebar']                = 'layout/template_sidebar';
        $data['main']                   = 'sosial/pencarian_teman';
        $this->load->view('layout/fr_default',$data);
        
    }
    
    public function index()
    {
        $session = session_data();
        $config['uri_segment']  	= 6;
        $config['base_url']     	= site_url('sos/pegawai/index/kegiatan/pegawai/');
        $config['per_page']     	= 6;
        $config['total_rows']   	= $this->pegawaimodel->tot_paging_kegiatan();
        $config['prev_tag_open'] 	= '<a href="" class="prev-post" title=""> ';
        $config['prev_link'] 		= ' ';
        $config['prev_tag_close'] 	= '</a>';
        
        $config['cur_tag_open']		= '<li class="active-page">';
        $config['cur_tag_close'] 	= '</li>';
        
        $config['next_tag_open'] 	= '<a href="" class="next-post" title=""> ';
        $config['next_link']		= ' ';
        $config['next_tag_close'] 	= '</a>';
        $config['num_tag_open']		= '<li>';
        $config['num_tag_close'] 	= '</li>';
        $config['num_links']    	='10';
        $this->pagination->initialize($config);
        
        $kegiatan['data']	        = $this->pegawaimodel->get_index_kegiatan($config['per_page'],$this->uri->segment(6));
        $kegiatan['pagination']	        = $this->pagination->create_links();
        $data['kegiatan']               = $kegiatan;
        
        $config2['uri_segment']  	= 5;
        $config2['base_url']     	= site_url('sos/pegawai/index/berita/');
        $config2['per_page']     	= 6;
        $config2['total_rows']   	= $this->pegawaimodel->tot_paging_berita();
        $config2['prev_tag_open'] 	= '<a href="" class="prev-post" title=""> ';
        $config2['prev_link'] 		= ' ';
        $config2['prev_tag_close'] 	= '</a>';
        
        $config2['cur_tag_open']	= '<li class="active-page">';
        $config2['cur_tag_close'] 	= '</li>';
        
        $config['next_tag_open'] 	= '<a href="" class="next-post" title=""> ';
        $config['next_link']		= ' ';
        $config['next_tag_close'] 	= '</a>';
        $config2['num_tag_open']	= '<li>';
        $config2['num_tag_close'] 	= '</li>';
        $config2['num_links']    	='10';
        $this->pagination->initialize($config2);
        
        $this->load->model('sekolahmodel');
        //$data['sekolah']        = $this->pegawaimodel->get_sekolah();
        $berita['data']	        = $this->pegawaimodel->get_index_berita($config2['per_page'],$this->uri->segment(5));
        $berita['pagination']	= $this->pagination->create_links();
        $data['berita']         = $berita;
        
        $data['pesan_keluar']       = $this->pegawaimodel->get_pesan_keluar();
        $data['album_foto']         = $this->pegawaimodel->get_album_foto();
        $data['berita_terbaru']     = $this->pegawaimodel->get_berita_terbaru();
        $data['kegiatan_terbaru']   = $this->pegawaimodel->get_kegiatan_terbaru();
        //$data['user_online']        = $this->online_users->get_online();
        $data['pesan']              = $this->pegawaimodel->get_pesan();
        $data['galleri']            = $this->pegawaimodel->foto_galleri($session['id']);
        //$data['pegawai']            = $this->pegawaimodel->get_pegawai($session['id']);
        //$data['sidebar']            = 'layout/template_sidebar';
		$data['group']=$this->auth->get_det_group($this->session->userdata['user_authentication']['id']);
        $data['main']               = 'sosial/pegawaiview';
        $this->load->view('layout/fr_default',$data);
    }
    
    //function status begin
    public function last_message($id=0) {
        if($id!=0) {
            $result = $this->pegawaimodel->get_lates_status($id);
            if(!empty($result)) {?>
                 <?php foreach($result['status'] as $stat_item):?>
                    <div class="itemOut status_parent" id="hapusstatus_<?=$stat_item->id_status?>">
                        <a href="<?=base_url($stat_item->foto)?>" class="prev_image image"><img src="<?=base_url($stat_item->foto)?>" alt="" title="" width="50" class="img-polaroid"/></a>
                        <div class="text">
                            <div class="info clearfix">
                                <span class="name">Aqvatarius</span>
                                <span class="date"><?=CheckTime($stat_item->tgl_status)?></span>
                            </div>                                
                             <?php
                                if($stat_item->id_foto==0) {
                                    echo '<p>'.MessageCheck($stat_item->pesan).'<span class="delete_status" id="status_'.$stat_item->id_status.'">x</span></p>';
                                }
                                else
                                {
                                    echo '<a href="'.base_url($stat_item->large).'" class="prev_image image">
                                    <img src="'.base_url($stat_item->small).'"/>
                                    </a>
                                    <p>'.MessageCheck($stat_item->pesan).'</p>
                                    <span class="delete_status" id="status_'.$stat_item->id_status.'">X</span>';
                                }
                            ?>
                        </div>
                        <!-- komentar -->
                        <?php
                            $status_cek = false;
                            if(!empty($result['komentar'])){
                                foreach($result['komentar'] as $idx=>$kom_item) {
                                    if($idx==$stat_item->id_status) {
                                        foreach($kom_item as $val){
                                        $status_cek = true;
                                        ?>
                                            <div class="row-fluid komentar_user" id="hapuskomentar_<?=$val->id_komen?>">
                                                <div class="span2"></div>
                                                <div class="span10">
                                                    <div class="itemOut">
                                                        <a href="<?=base_url($val->foto)?>" class="prev_image image"><img src="<?=base_url($val->foto)?>" width="50" class="img-polaroid"/></a>
                                                        <div class="text">
                                                            <div class="info clearfix">
                                                                <span class="name">Aqvatarius</span>
                                                                <span class="date"><?=CheckTime($val->tgl_komen)?></span>
                                                            </div>                                
                                                            <p><?=MessageCheck($val->komentar)?>
                                                                <span class="delete_status" id="komentar_<?=$val->id_komen?>">x</span>
                                                            </p>
                                                        </div>
                                                    </div>                                        
                                                </div>
                                            </div>
                                        <?php
                                        }
                                        echo '<div id="'.$stat_item->id_status.'"></div>';
                                    }
                                }
                            }
                        ?>
        
                        <?php
                        if($status_cek)
                        {
                        ?>
                            <div class="komentar_user" id="hapusstatus_<?=$stat_item->id_status?>">                            
                                <div class="span2"></div>
                                <div class="span10">
                                    <form method="POST" id="komentar" action="<?=site_url('sos/pegawai/set_komentar')?>">
                                        <div class="itemOut">
                                            <div class="controls">
                                                <div class="control">
                                                    <textarea name="komentar" class="komentar_teks" placeholder="Komentar anda <?=$stat_item->nama?>" style="height: 70px; width: 100%;background: white;"></textarea>
                                                    <input type="hidden" name="id_pegawai" value="<?=$stat_item->id_user?>"/>
                                                    <input type="hidden" name="id_status" value="<?=$stat_item->id_status?>"/>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                        
                        <?php
                        if($status_cek==FALSE)
                        {
            
                        ?>
                            <div id="<?=$stat_item->id_status?>" id="hapusstatus_<?=$stat_item->id_status?>"></div>
                            <div class="komentar_user">                            
                                <div class="span2">
                                </div>
                                <div class="span10">
                                    <form method="POST" id="komentar" action="<?=site_url('sos/siswa/set_komentar')?>">
                                        <div class="itemOut">
                                            <div class="controls">
                                                <div class="control">
                                                    <textarea name="komentar" class="komentar_teks" placeholder="Komentar anda <?=$stat_item->nama?>" style="height: 70px; width: 100%;background: white;"></textarea>
                                                    <input type="hidden" name="id_pegawai" value="<?=$stat_item->id_user?>"/>
                                                    <input type="hidden" name="id_status" value="<?=$stat_item->id_status?>"/>
                                                </div>
                                            </div>
                                        </div>    
                                    </form>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                       
                        <!-- end komentar-->
                    </div>
                    <div class="hr" id="hapusstatus_<?=$stat_item->id_status?>"></div>
                <?php endforeach ?>
            <?php
            }
        }
    }
    
    //tulis pesan
    public function getAllKelas()
    {
		$this->load->model('ad_kelas');
		return $this->ad_kelas->getAllKelas($this->session->userdata['user_authentication']['id_sekolah']);
	}
    public function getAllGuru()
    {
		$this->load->library('ak_pegawai');
		 $siswa=$this->ak_pegawai->createOptionGuruByIdSekolah($this->session->userdata['user_authentication']['id_sekolah']);
		
		echo $siswa;
	}
    public function getSiswaByKelas($id_kelas)
    {
		$this->load->library('ak_siswa');
		 $siswa=$this->ak_siswa->createOptionSiswaByIdKelasId_sis($id_kelas,'multiple');
		
		echo $siswa;
	}
    public function pesan_user()
    {
        $this->pegawaimodel->kirim_pesan();
        redirect('sos/pegawai');
    }
    public function balas_pesan()
    {
        $this->pegawaimodel->balas_pesan_user();
        set_blue_notification('Pesan Berhasil Dikirimkan');
        redirect('sos/pegawai/');
    }
    
    public function baca_pesan()
    {
        if(!empty($_POST)) {
            $this->pegawaimodel->baca_pesan_user();
            redirect('sos/pegawai/pertemanan');
        }
    }
    
    public function multiple_upload()
    {	
        $this->pegawaimodel->upload_multi_foto();
        print_r($this->session->userdata('session_foto'));exit;
    }
    
    public function buat_album()
    {
        $this->pegawaimodel->create_album_foto();
        set_blue_notification('Album Foto Berhasil Dibuat');
        redirect('sos/pegawai/');
    }
    
    public function upload_foto()
    {
        if (!empty($_FILES)) {
            $config['upload_path']  = "upload/images/larger/";
            $config['allowed_types']= 'gif|jpg|png|jpeg';
            $config['max_size']     = '2000';
            $config['max_width']    = '4000';
            $config['max_height']   = '4000';
            $width_gambar           = 656;
            $height_gambar          = 300;
            $file_name = '';
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('images')) {
                $data['img']	 = $this->upload->data();
                $file_name = $this->upload->file_name;
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
                $this->image_moo
                    ->load("upload/images/larger/". $file_name)
                    ->resize_crop(100,100)
                    ->save("upload/images/thumb/". $file_name);
                $msg = '<img src="'.base_url('upload/images/thumb/'.$file_name.'').'" style="border:3px grey solid;margin:0px;">';
                echo "{";
                echo    "file: '" . $file_name . "',\n";	
                echo    "msg: '" . $msg . "'\n";
                echo "}";
            }else{
                $data['error'] = $this->upload->display_errors();
                print_r($data['error']);
            }
        }
    }
    
    public function set_status()
    {
        $id_pegawai     = $this->input->post('id_pegawai');
        $status         = $this->input->post('status');
        $foto           = $this->input->post('images');
        
        if(!empty($_POST)) {
            $result = $this->pegawaimodel->set_status_siswa();
            if(empty($result->foto)) {
                $result->foto = 'asset/default/images/no_profile.jpg';
            }
            $hasil = '<div class="itemOut status_parent" id="hapusstatus_'.$result->id_status.'">
                        <a href="'.base_url($result->foto).'" class="prev_image image"><img src="'.base_url($result->foto).'" alt="" title="" width="50" class="img-polaroid"/></a>
                        <div class="text">
                            <span class="delete_status tooltip" title="Delete" id="status_'.$result->id_status.'">x</span>
                            <div class="info clearfix">
                                <span class="name"><a href="'.site_url('sos/siswa/view_profile/'.$result->id).'">'.$result->nama.'</a></span>
                                <span class="date">'.CheckTime($result->tgl_status).'</span>
                            </div>';
                            
                                if($result->id_foto==0) {
                                    $hasil .= '<p>'.MessageCheck($result->pesan).'</p>';
                                }
                                else
                                {
                                    $hasil.= '<p>'.MessageCheck($result->pesan).'</p>
                                    <a href="'.base_url($result->large).'" class="prev_image"><img src="'.base_url($result->small).'"/></a>';
                                }
                                
                                $hasil .= '</div>
                                <div id="'.$result->id_status.'" id="hapusstatus_'.$result->id_status.'"></div>
                                <div class="komentar_user">                            
                                    <div class="span2">
                                    </div>
                                    <div class="span10">
                                        <form method="POST" id="komentar" action="'.site_url('sos/pegawai/set_komentar').'">
                                            <div class="itemOut">
                                                <div class="controls">
                                                    <div class="control">
                                                        <textarea name="komentar" class="komentar_teks" placeholder="Komentar anda '.$result->nama.'" style="height: 50px; width: 100%;background: white;"></textarea>
                                                        <input type="hidden" name="id_pegawai" value="'.$result->id_user.'"/>
                                                        <input type="hidden" name="id_status" value="'.$result->id_status.'"/>
                                                    </div>
                                                </div>
                                            </div>    
                                        </form>
                                    </div>
                                    <div class="hr"></div>
                                </div>
                    </div>';
            echo $hasil;
        }
    }
  
    
    public function set_komentar()
    {
        if(!empty($_POST)) {
            $result = $this->pegawaimodel->set_komentar_siswa();
            if(empty($result->foto)) {
                $result->foto = 'asset/default/images/no_profile.jpg';
            }
                echo '<div class="row-fluid komentar_user" id="hapuskomentar_'.$result->id_komen.'">
                    <div class="span2"></div>
                    <div class="span10">
                        <div class="itemOut">
                            <a href="'.base_url($result->foto).'" class="prev_image image"><img src="'.base_url($result->foto).'" width="50" class="img-polaroid"/></a>
                            <div class="text">
                                <div class="info clearfix">
                                    <span class="name">'.$result->nama.'</span>
                                    <span class="date">'.CheckTime($result->tgl_komen).'<span class="delete_status tooltip" title="Delete" id="komentar_'.$result->id_komen.'">x</span></span>
                                </div>                                
                                <p>'.MessageCheck($result->komentar).'</p>
                            </div>
                        </div>                                        
                    </div>
                </div>';
        }
    }
    
    public function get_all_status()
    {
        $this->db->from('ak_pegawai');
        $this->db->join('sc_status','ak_pegawai.id=sc_status.id_user');
        //$this->db->where('ak_siswa.id',$id);
        $this->db->order_by('sc_status.id_status','DESC');
        $sql = $this->db->get();
        if($sql->num_rows()>0) {
            $data['status'] = $sql->result();
            $komentar = array();
            foreach($sql->result() as $st_komen) {
                $this->db->from('sc_komentar');
                $this->db->join('ak_pegawai','ak_pegawai.id=sc_komentar.id_user');
                $this->db->where('sc_komentar.id_status',$st_komen->id_status);
                $this->db->order_by('sc_komentar.id_komen','ASC');
                $kom = $this->db->get();
                if($kom->num_rows()>0) {
                      $komentar[$st_komen->id_status] = $kom->result();
                }
            }
            $data['komen_pegawai'] = $komentar;
            echo json_encode($data);
        }else{
            echo json_encode(array(''));
        }
        
    }
    
    public function del_status()
    {
        if(!empty($_POST)) {
            $this->pegawaimodel->delete_status();
        }
    }
    
    public function del_komentar()
    {
        if(!empty($_POST)) {
            $this->pegawaimodel->delete_komentar();
        }
    }
    //end function status
    
    //function manipulate user
    public function edit_pegawai()
    {
        $session = session_data();
        $data['pegawai_edit']       = $this->pegawaimodel->edit_data_pegawai($session['id']);
		//pr($data['pegawai_edit']);
        $data['pegawai']            = $this->pegawaimodel->get_pegawai($session['id']);  
        $data['main']               = 'sosial/editpegawai';
        $data['sidebar']            = 'layout/template_sidebar';
        $this->load->view('layout/fr_default',$data);
    }
    //end function manipulate user
    
    public function ubah_data()
    {
        $this->form_validation->set_rules('nama','nama','required');
        $this->form_validation->set_rules('email','Email','required|valid_email');
        $this->form_validation->set_rules('alamat','Alamat','required');
        $this->form_validation->set_rules('kota','Kota','required');
        $this->form_validation->set_rules('hp','Hp','required');
        $this->form_validation->set_rules('pwd_baru', 'Password', 'trim|matches[konfirm]');
        $this->form_validation->set_rules('konfirm', 'Password Confirmation', 'trim');
		$pwb=$_POST['pwd_baru'];
	  if($this->form_validation->run()==FALSE){
            $this->edit_pegawai();
        }
        else{
			$_POST['pwd_baru']=$pwb;
			//pr($_POST);die(); 
            $this->pegawaimodel->ubah_data_user();
            set_blue_notification('Data Anda Telah Berhasil Dirubah');
            redirect('sos/pegawai');
        }
    }
    //end function manipulate user
    
    
    //function untuk pertemanan
    public function temanlainsekolah()
    {	
		$session = session_data();
		$data['orang_dikenal']  = $this->pegawaimodel->get_orang_dikenal_lainsekolah($session['id_sekolah']);
		$data['sidebar']        = 'layout/template_sidebar';
        $data['main']           = 'sosial/temanlainsekolah';
        $this->load->view('layout/ad_blank',$data);
	}
    public function pertemanan()
    {
        $session = session_data();
        //chat
        $data['user_online']    = $this->online_users->get_online();
        
		switch($_POST['pertload']){
			case "statusload":
				$data['status_pegawai']   = $this->pegawaimodel->get_status_pegawai($session['id']);
				$data['statusload']="block";
				$data['temanload']="none";
				$data['groupload']="none";
				$data['acaraload']="none";
				$data['catatanload']="none";
			break;
			case "temanload":
				//pertemanan
				$data['ultah']          = $this->pegawaimodel->pengingat_ultah($session['id']);
				$data['teman']          = $this->pegawaimodel->get_teman($session['id']);
				$data['orang_dikenal']  = $this->pegawaimodel->get_orang_dikenal($session['id_sekolah']);
				$data['pending']        = $this->pegawaimodel->pending_confirm($session['id']);
				$data['permintaan']     = $this->pegawaimodel->cek_teman_add($session['id']);
			
				$data['statusload']="none";
				$data['temanload']="block";
				$data['groupload']="none";
				$data['acaraload']="none";
				$data['catatanload']="none";
			
			break;
			case "groupload":
				//group
				$data['group_diikuti']  = $this->pegawaimodel->get_group_diikuti($session['id']);
				$data['group_anda']     = $this->pegawaimodel->get_group_anda($session['id']);
				$data['undangan_group'] = $this->pegawaimodel->get_undangan_group($session['id']);
				$data['statusload']="none";
				$data['temanload']="none";
				$data['groupload']="block";
				$data['acaraload']="none";
				$data['catatanload']="none";
			
			break;
			case "acaraload":
        //acara
        $data['acara_user']     = $this->pegawaimodel->get_acara_user($session['id']);
        $data['undangan_acara'] = $this->pegawaimodel->undangan_acara($session['id']);
        $data['reminder_acara'] = $this->pegawaimodel->reminder_acara($session['id']);
				$data['statusload']="none";
				$data['temanload']="none";
				$data['groupload']="none";
				$data['acaraload']="block";
				$data['catatanload']="none";
			
			break;
			case "catatanload":
				$data['statusload']="none";
				$data['temanload']="none";
				$data['groupload']="none";
				$data['acaraload']="none";
				$data['catatanload']="block";
			
			break;
			default:
				//teman
				$data['status_pegawai']   = $this->pegawaimodel->get_status_pegawai($session['id']);
				$data['pegawai']          = $this->pegawaimodel->get_pegawai($session['id']);
				$data['statusload']="block";
				$data['temanload']="none";
				$data['groupload']="none";
				$data['acaraload']="none";
				$data['catatanload']="none";			
			break;
		}
		
        //$data['pesan']          = $this->pegawaimodel->get_pesan();
        $data['sidebar']        = 'layout/template_sidebar';
        $data['main']           = 'sosial/temanview';
        $this->load->view('layout/fr_default',$data);
    }
    
    
    public function ajax_get_teman()
    {
        $config['uri_segment']  	= 5;
        $config['base_url']     	= site_url('sos/pegawaimodel/pertemanan/teman/');
        $config['per_page']     	= 1;
        $config['total_rows']   	= $this->pegawaimodel->tot_paging_ajax_teman();
        $config['prev_tag_open'] 	= '<a href="" class="prev-post" title=""> ';
        $config['prev_link'] 		= ' ';
        $config['prev_tag_close'] 	= '</a>';
        
        $config['cur_tag_open']		= '<li class="active-page">';
        $config['cur_tag_close'] 	= '</li>';
        
        $config['next_tag_open'] 	= '<a href="" class="next-post" title=""> ';
        $config['next_link']		= ' ';
        $config['next_tag_close'] 	= '</a>';
        $config['num_tag_open']		= '<li>';
        $config['num_tag_close'] 	= '</li>';
        $config['num_links']    	='10';
        $this->pagination->initialize($config);
        
        $teman['data']	        = $this->siswamodel->get_ajax_teman($config['per_page'],$this->uri->segment(5));
        $teman['pagination']	= $this->pagination->create_links();
        return $teman;        
    }
    
    //public function ajax_pesan_masuk()
    //{
    //    $config['uri_segment']  	= 6;
    //    $config['base_url']     	= site_url('sos/pegawai/pertemanan/daftar/pesan/');
    //    $config['per_page']     	= 1;
    //    $config['total_rows']   	= $this->pegawaimodel->tot_paging_pesan();
    //    $config['prev_tag_open'] 	= '<a href="" class="prev-post" title=""> ';
    //    $config['prev_link'] 		= ' ';
    //    $config['prev_tag_close'] 	= '</a>';
    //    
    //    $config['cur_tag_open']		= '<li class="active-page">';
    //    $config['cur_tag_close'] 	= '</li>';
    //    
    //    $config['next_tag_open'] 	= '<a href="" class="next-post" title=""> ';
    //    $config['next_link']		= ' ';
    //    $config['next_tag_close'] 	= '</a>';
    //    $config['num_tag_open']		= '<li>';
    //    $config['num_tag_close'] 	= '</li>';
    //    $config['num_links']    	='10';
    //    $this->pagination->initialize($config);
    //    
    //    $pesan['data']	        = $this->siswamodel->get_ajax_pesan($config['per_page'],$this->uri->segment(6));
    //    $pesan['pagination']	= $this->pagination->create_links();
    //    return $pesan; 
    //}
    
    public function tambah_teman()
    {
        $this->pegawaimodel->add_teman();
        echo 'sukses';
    }
    
    public function tambahkan_teman()
    {
        $id_user = $this->input->post('id_user');
        if(!empty($_POST)) {
            $this->pegawaimodel->add_teman();
            set_blue_notification('Permintaan Teman Telah Dikirimkan');
            redirect('sos/user/view_profile/'.$id_user);
        }else{
            set_red_notification('Permintaan Gagal Di Proses');
            redirect('sos/user/view_profile/'.$id_user);
        }
    }
    
    
    public function terima_permintaan($id)
    {
        $this->pegawaimodel->permintaan_diterima($id);
        redirect('sos/pegawai/pertemanan');
    }
    
    public function tolak($id)
    {
        $this->pegawaimodel->tolak_permintaan($id);
        redirect('sos/pegawai/permintaan');
    }
    
    public function blokir_pertemanan($id)
    {
        if($id!=0) {
            $this->pegawaimodel->teman_blokir($id);
            set_blue_notification('Teman Berhasil di Blokir');
            redirect('sos/pegawai/pertemanan');
        }
    }
    
    public function hapus_pertemanan($id)
    {
        if($id!=0) {
            $this->pegawaimodel->hapus_teman($id);
            set_blue_notification('Teman Berhasil Dihapus');
            redirect('sos/pegawai/pertemanan');
        }
    }
    
    public function simpan_multiple_foto()
    {
        $this->pegawaimodel->multiple_simpan_foto();
        set_blue_notification('Foto Anda Berhasil Di Upload');
        redirect('sos/pegawai/');
    }
    
    
    public function cari_teman()
    {
        $session = session_data();
        $nama = $this->input->get('term');
        if(!empty($nama)) {
            $this->db->select('id as id_user,
							  (SELECT nama FROM ak_pegawai WHERE id=users.id_pengguna) as nama_pegawai,
							  (SELECT nama FROM ak_siswa WHERE id=users.id_pengguna) as nama_siswa,
			');            
            $this->db->from('sc_teman');
            $this->db->join('users','users.id=sc_teman.id_teman');
            $this->db->like('users.username',$nama,'both');
            $this->db->where('sc_teman.id_user',$session['id']);
            $sql = $this->db->get();
			
            if($sql->num_rows()>0) {
				$data=$sql->result_array();
				
				foreach($data as $ky=>$dataout){
					$data2[$ky]['id_user']=$dataout['id_user'];
					if($dataout['nama_pegawai']!=''){
						$data2[$ky]['label']=str_replace(" ","_",$dataout['nama_pegawai']);
						$data2[$ky]['value']=str_replace(" ","_",$dataout['nama_pegawai']);
					}else{
						$data2[$ky]['label']=str_replace(" ","_",$dataout['nama_siswa']);
						$data2[$ky]['value']=str_replace(" ","_",$dataout['nama_siswa']);
					}
				}
				unset($data);
                echo json_encode($data2);
            }else{
                echo '';
            }
			//echo $this->db->last_query();
        }
    }
    //end function pertemanan
    
    //acara user
    public function simpan_acara()
    {
        $this->pegawaimodel->set_acara_user();
        redirect('sos/pegawai/pertemanan');
    }
    
    //group user
    public function keluar_group($id) {
        if($id!=0) {
            $this->pegawaimodel->keluar_user_group($id);
            set_blue_notification('Anda Telah Keluar Dari Group');
            redirect('sos/pegawai/pertemanan');
        }else{
            redirect('sos/pegawai/pertemanan');
        }
    }
    public function simpan_group()
    {
        if(!empty($_POST)) {
            $this->pegawaimodel->set_group_user();
            redirect('sos/pegawai/pertemanan');
        }else{
            redirect('sos/pegawai/pertemanan');
        }
    }
    
    public function terima_group($id)
    {
        if($id!=0) {
            $this->pegawaimodel->group_diterima($id);
            set_blue_notification('Anda Telah Bergabung Dengan Group');
            redirect('sos/pegawai/pertemanan');
        }
    }
    
    public function tolak_group($id)
    {
        if($id!=0) {
            $this->pegawaimodel->group_ditolak($id);
            redirect('sos/siswa/pertemanan');
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
    
    public function kegiatan_simpan()
    {
        if(!empty($_POST))
        {
            $this->pegawaimodel->simpan_kegiatan();
            set_blue_notification('Kegiatan Baru Berhasil Disimpan');
            redirect('sos/siswa/');
        }
    }
    
    public function berita_simpan()
    {
        if(!empty($_POST))
        {
            $this->pegawaimodel->simpan_berita();
            set_blue_notification('Berita Baru Berhasil Disimpan');
            redirect('sos/siswa/');
        }
    }
    
    //lihat profil teman
    public function view_profile($id)
    {
        if($id!=0) {
            $config['uri_segment']  	= 6;
            $config['base_url']     	= site_url('sos/siswa/view_profile/kegiatan/siswa/');
            $config['per_page']     	= 6;
            $config['total_rows']   	= $this->siswamodel->tot_paging_kegiatan();
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
            
            $kegiatan['data']	        = $this->siswamodel->get_index_kegiatan($config['per_page'],$this->uri->segment(6));
            $kegiatan['pagination']	= $this->pagination->create_links();
            $data['kegiatan']           = $kegiatan;
            
            $config2['uri_segment']  	= 5;
            $config2['base_url']     	= site_url('sos/siswa/siswa/view_profile/berita/');
            $config2['per_page']     	= 6;
            $config2['total_rows']   	= $this->siswamodel->tot_paging_berita();
            $config2['prev_tag_open'] 	= '<a href="" class="prev-post" title=""> ';
            $config2['prev_link'] 		= ' ';
            $config2['prev_tag_close'] 	= '</a>';
            
            $config2['cur_tag_open']	= '<li class="active-page">';
            $config2['cur_tag_close'] 	= '</li>';
            
            $config['next_tag_open'] 	= '<a href="" class="next-post" title=""> ';
            $config['next_link']		= ' ';
            $config['next_tag_close'] 	= '</a>';
            $config2['num_tag_open']	= '<li>';
            $config2['num_tag_close'] 	= '</li>';
            $config2['num_links']    	='10';
            $this->pagination->initialize($config2);
            
            $berita['data']	        = $this->siswamodel->get_index_berita($config2['per_page'],$this->uri->segment(5));
            $berita['pagination']	= $this->pagination->create_links();
            $data['berita']             = $berita;
            
            $data['album_foto']         = $this->siswamodel->get_album_foto();
            $data['berita_terbaru']     = $this->siswamodel->get_berita_terbaru();
            $data['kegiatan_terbaru']   = $this->siswamodel->get_kegiatan_terbaru();
            $data['user_online']        = $this->online_users->get_online();
            
            $profile                = $this->siswamodel->get_view_profile($id);
            $data['last_status_user']   = $this->siswamodel->get_last_status_user($id);
            $data['status_pribadi'] = $this->siswamodel->get_status_pribadi($id);
            $data['profile_user']   = $profile['data_user'];
            $data['galleri']        = $this->siswamodel->foto_galleri($id);
            $data['jenis_user']      = $profile['jenis_user'];
            $data['cek_pertemanan'] = $this->siswamodel->cek_pertemanan_user($id);
            $data['sidebar']        = 'layout/template_sidebar';
            $data['main']           = 'viewuser';
            $this->load->view('layout/fr_view',$data);    
        }
    }
    
}
?>