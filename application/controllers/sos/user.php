<?php
    class User extends CI_Controller
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
            $this->load->model('siswamodel');
            $this->load->model('usermodel'); 
            $this->load->library('Online_Users');
        }
        
        public function index()
        {
            
        }
        
        
        
        public function set_status()
        {
            $id_user                     = $this->input->post('id_user');
            $status                     = $this->input->post('status');
            $foto                       = $this->input->post('images');
            $profile                    = $this->siswamodel->get_view_profile($id_user);
            $profile                    = $profile['data_user'];
            $session                    = session_data();
            if(!empty($_POST)) {
                $result = $this->usermodel->set_status_user();
                    $hasil = '<div class="itemOut status_parent" id="hapusstatus_'.$result->id_status.'">
                                <a href="'.base_url($result->foto).'" class="prev_image image"><img src="'.base_url($result->foto).'" alt="" title="" width="50" class="img-polaroid"/></a>
                                <div class="text">
                                    <div class="info clearfix">
                                        <span class="name"><a href="'.site_url('sos/siswa/view_profile/'.$result->id).'">'.$session['username'].' > </a>'.$profile->nama.'</span>
                                        <span class="date">'.CheckTime($result->tgl_status).'</span>
                                    </div>';
                                    
                                        if($result->id_foto==0) {
                                            $hasil .= '<p>'.MessageCheck($result->pesan).'<span class="delete_status" id="status_'.$result->id_status.'">x</span></p>';
                                        }
                                        else
                                        {
                                            $hasil.= '<p>'.MessageCheck($result->pesan).'</p>
                                            <a href="'.base_url($result->large).'" class="prev_image"><img src="'.base_url($result->small).'"/></a>
                                            <span class="delete_status" id="status_'.$result->id_status.'">X</span>';
                                        }
                                        
                                        $hasil .= '</div>
                                        <div id="'.$result->id_status.'" id="hapusstatus_'.$result->id_status.'"></div>
                                        <div class="komentar_user">                            
                                            <div class="span2">
                                            </div>
                                            <div class="span10">
                                                <form method="POST" id="komentar" action="'.site_url('sos/siswa/set_komentar').'">
                                                    <div class="itemOut">
                                                        <div class="controls">
                                                            <div class="control">
                                                                <textarea name="komentar" class="komentar_teks" placeholder="Komentar anda '.$result->nama.'" style="height: 50px; width: 100%;background: white;"></textarea>
                                                                <input type="hidden" name="id_siswa" value="'.$result->id_user.'"/>
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
        
        public function upload_foto()
        {
            if (!empty($_FILES)) {
                $config['upload_path']  = "upload/images/larger/";
                $config['allowed_types']= 'gif|jpg|png|jpeg';
                $config['max_size']     = '2000';
                $config['max_width']    = '4000';
                $config['max_height']   = '4000';
                $width_gambar  =656;
                $height_gambar =300;
                $file_name = '';
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('images')) {
                    $data['img']	 = $this->upload->data();
                    $file_name = $this->upload->file_name;
                    if($data['img']['image_width'] > $width_gambar) {
                            $config2['image_library'] = 'gd2';
                            $config2['source_image'] = $this->upload->upload_path.$this->upload->file_name;
                            $config2['new_image'] = "upload/images/medium/";
                            $config2['maintain_ratio'] = TRUE;
                            $config2['create_thumb'] = TRUE;
                            $config2['thumb_marker'] = '';
                            $config2['height'] = $height_gambar;
                            $this->load->library('image_lib',$config2);
                            $this->image_lib->initialize($config2);
                            if ( ! $this->image_lib->resize())
                            {
                                echo $this->image_lib->display_errors();exit;
                            }
                            $this->image_lib->clear();
                            $upload_path = "/upload/images/medium/";
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
        
        public function set_komentar()
        {
            if(!empty($_POST)) {
                $result = $this->usermodel->set_komentar_user();
                echo '<div class="row-fluid komentar_user" id="hapuskomentar_'.$result->id_komen.'">
                        <div class="span2"></div>
                        <div class="span10">
                            <div class="itemOut">
                                <a href="'.base_url($result->foto).'" class="prev_image image"><img src="'.base_url($result->foto).'" width="50" class="img-polaroid"/></a>
                                <div class="text">
                                    <div class="info clearfix">
                                        <span class="name"><a href="'.site_url('sos/user/view_profile/'.$result->id).'">'.$result->nama.'</a></span>
                                        <span class="date">'.CheckTime($result->tgl_komen).'<span class="delete_status tooltip" title="Delete" id="komentar_'.$result->id_komen.'">x</span></span>
                                    </div>                                
                                    <p>'.MessageCheck($result->komentar).'</p>
                                </div>
                            </div>                                        
                        </div>
                    </div>';
            }
        }
        
        public function tulis_pesan_pribadi()
        {
            if(!empty($_POST))
            {
                $id_user = $this->input->post('id_user');
                $this->usermodel->kirim_pesan();
                redirect('sos/user/view_profile/'.$id_user);
            }else{
                echo 'gak ada pos';
            }
        }
        
        //lihat profil teman
        public function view_profile($id)
        {
            if($id!=0) {
                $config['uri_segment']  	= 6;
                $config['base_url']     	= site_url('sos/user/view_profile/kegiatan/siswa/');
                $config['per_page']     	= 6;
                $config['total_rows']   	= $this->siswamodel->tot_paging_kegiatan();
                $config['prev_tag_open'] 	= '<a href="" class="prev-post" title=""> ';
                $config['prev_link'] 	        = ' ';
                $config['prev_tag_close'] 	= '</a>';
                
                $config['cur_tag_open']	        = '<li class="active-page">';
                $config['cur_tag_close'] 	= '</li>';
                
                $config['next_tag_open'] 	= '<a href="" class="next-post" title=""> ';
                $config['next_link']	        = ' ';
                $config['next_tag_close'] 	= '</a>';
                $config['num_tag_open']	        = '<li>';
                $config['num_tag_close'] 	= '</li>';
                $config['num_links']    	='10';
                $this->pagination->initialize($config);
                
                $kegiatan['data']	        = $this->siswamodel->get_index_kegiatan($config['per_page'],$this->uri->segment(6));
                $kegiatan['pagination']	        = $this->pagination->create_links();
                $data['kegiatan']               = $kegiatan;
                
                $config2['uri_segment']  	= 5;
                $config2['base_url']     	= site_url('sos/user/siswa/view_profile/berita/');
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
                $data['berita']         = $berita;
                
                $data['album_foto']         = $this->siswamodel->get_album_foto();
                $data['berita_terbaru']     = $this->siswamodel->get_berita_terbaru();
                $data['kegiatan_terbaru']   = $this->siswamodel->get_kegiatan_terbaru();
                $data['user_online']        = $this->online_users->get_online();
                
                $profile                    = $this->usermodel->get_view_profile($id);
                $data['last_status_user']   = $this->siswamodel->get_last_status_user($id);
                $data['status_pribadi']     = $this->usermodel->get_status_pribadi($id);
                $data['profile_user']       = $profile['data_user'];
                $data['galleri']            = $this->siswamodel->foto_galleri($id);
                $data['jenis_user']         = $profile['jenis_user'];
                $data['cek_pertemanan']     = $this->siswamodel->cek_pertemanan_user($id);
                $data['sidebar']            = 'layout/template_sidebar';
                $data['main']               = 'viewuser';
                $this->load->view('layout/fr_view',$data);    
            }
        }
    }
?>