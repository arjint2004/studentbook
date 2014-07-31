<?php
class Group extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('global');
        $this->load->library('session');
        $this->load->library('auth');
        $this->auth->user_logged_in();
        $this->load->library('image_moo');
        $this->load->model('group_model');
        $this->load->library('Online_Users');
        $this->load->library('pagination');
    }
    
    public function index()
    {
        $data['sidebar']        = 'layout/template_sidebar';
        $data['main']           = 'sosial/groupview';
        $this->load->view('layout/fr_default',$data);    
    }
    
    public function view($id)
    {
        if($id!=0) {
            $session                = session_data();
            $data['user']           = $session['id'];
            $data['user_online']    = $this->online_users->get_online();
            $data['status_group']   = $this->group_model->get_status_group($id);
            $data['member_group']   = $this->group_model->get_member_group($id);
            $data['album_group']    = $this->group_model->get_album_group($id);
            $data['get_foto_album'] = $this->group_model->get_foto_dan_album($id);
            $data['acara_group']    = $this->group_model->get_acara_group($id);
            $data['dokumen_group']  = $this->list_dokumen_group($id);
            $data['foto_group']     = $this->foto_group($id);
            $data['member_or_not']  = $this->group_model->cek_member_group($session['id']);
            $data['data_group']     = $this->group_model->get_data_group($id);
            $data['sidebar']        = 'layout/template_sidebar';
            $data['main']           = 'sosial/viewgroup';
            $this->load->view('layout/fr_group',$data);
        }
    }
    
    public function detail_foto_group($id_group,$id_album)
    {
        echo 'masuih dalam pengembangan';exit;
    }
    
    public function ubah_data_group()
    {
        if(!empty($_POST))
        {
            $id_group   = $this->input->post('id_group');
            $this->group_model->edit_data_group();
            set_blue_notification('Data Group Berhasil Dirubah');
            redirect('sos/group/view/'.$id_group);
        }
    }
    
    public function list_group_foto()
    {
        if(!empty($_POST)) {
            $result = $this->group_model->group_foto_list();
            echo $result;
        }
    }
    public function list_dokumen_group($id_group)
    {
        $config['uri_segment']  	= 6;
        $config['base_url']     	= site_url('sos/group/view/'.$id_group.'/dokumen/');
        $config['per_page']     	= 10;
        $config['total_rows']   	= $this->group_model->get_total_dokumen($id_group);
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
        
        $dokumen['data']	        = $this->group_model->get_dokumen($id_group,$config['per_page'],$this->uri->segment(6));
        $dokumen['pagination']	        = $this->pagination->create_links();
        return $dokumen;
    }
    
    public function foto_group($id_group)
    {
        $config['uri_segment']  	= 5;
        $config['base_url']     	= site_url('sos/group/view/'.$id_group.'/');
        $config['per_page']     	= 6;
        $config['total_rows']   	= $this->group_model->tot_paging_foto($id_group);
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
        
        $foto['data']	                = $this->group_model->get_foto_paging($id_group,$config['per_page'],$this->uri->segment(5));
        $foto['pagination']	        = $this->pagination->create_links();
        return $foto;
    }
    
    public function multiple_upload()
    {
        $this->group_model->upload_multi_foto();
        print_r($this->session->userdata('session_foto_group'));exit;
    }
    
    public function simpan_multiple_foto()
    {
        $id_group   = $this->input->post('id_group');
        $this->group_model->multiple_simpan_foto();
        set_blue_notification('Foto Anda Berhasil Di Upload');
        redirect('sos/group/view/'.$id_group);
    }
    
    public function edit_album()
    {
        if(!empty($_POST)) {
            $id_group   = $this->input->post('id_group');
            $this->group_model->edit_data_album();
            set_blue_notification('Data Album Foto Berhasil Dirubah');
            redirect('sos/group/view/'.$id_group);
        }
    }
    
    public function hapus_album($id_group,$id)
    {
        if($id!=0)
        {
            $this->group_model->hapus_group_album($id);
            set_blue_notification('Album Foto Berhasil Dihapus');
            redirect('sos/group/view/'.$id_group);
        }
    }
    
    //upload dokumen
    public function upload_dokumen()
    {
        if(!empty($_POST)) {
            $id_group   = $this->input->post('id_group');
            $this->group_model->dokumen_upload();
            set_blue_notification('Dokumen Anda Berhasil Di Upload');
            redirect('sos/group/view/'.$id_group);
        }
    }
    
    public function tambah_anggota_group($id)
    {
        if($id!=0) {
            $session                = session_data();
            $list_member            = $this->get_tambah_member($id);
            $data['teman']          = $list_member['data'];
            $data['pagination']     = $list_member['pagination'];
            $data['user']           = $session['id'];
            $data['user_online']    = $this->online_users->get_online();
            $data['status_group']   = $this->group_model->get_status_group();
            //$data['member_group']   = $this->group_model->get_member_group($id);
            $data['acara_group']    = $this->group_model->get_acara_group($id);
            $data['member_or_not']  = $this->group_model->cek_member_group($session['id']);
            $data['data_group']     = $this->group_model->get_data_group($id);
            $data['sidebar']        = 'layout/template_sidebar';
            $data['main']           = 'sosial/viewgroup';
            $this->load->view('layout/fr_group',$data);
        }
    }
    
    public function get_tambah_member($id=0) {
        $config['uri_segment']  	= 5;
        $config['base_url']     	= site_url('sos/group/tambah_anggota_group/'.$id.'/');
        $config['per_page']     	= 12;
        $config['total_rows']   	= $this->group_model->tot_paging_get_member();
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
        $config['num_links']    	= 3;
        $this->pagination->initialize($config);
        
        $data['data']	        	= $this->group_model->list_get_member($id,$config['per_page'],$this->uri->segment(5));
        $data['pagination']		= $this->pagination->create_links();
        return $data;
    }
    
    public function anggota_baru()
    {
        if(!empty($_POST))
        {
            $this->group_model->tambah_anggota();
            $id_group = $this->input->post('id_group');
            set_blue_notification('Anggota Baru Berhasil Ditambahkan');
            redirect('sos/group/view/'.$id_group);
        }
    }
    
    
    //status group
    public function set_status()
    {
        $id_group   = $this->input->post('id_group');
        $status     = $this->input->post('status');
        $foto       = $this->input->post('images');
        
        if(!empty($_POST)) {
            $result = $this->group_model->set_status_group();
                if(empty($result->foto_member)) {
                    $result->foto_member = 'asset/default/images/no_profile.jpg';
                }
                $hasil = '<div class="itemOut status_parent" id="hapusstatus_'.$result->id_stat_group.'">
                            <a href="'.base_url($result->foto_member).'" class="prev_image image"><img src="'.base_url($result->foto_member).'" alt="" title="" width="50" class="img-polaroid"/></a>
                            <div class="text">';
                                    if($result->id_foto==0) {
                                        $hasil .= '<div class="info clearfix">
                                                        <span class="name">'.$result->nama.'</span>
                                                        <span class="date">'.CheckTime($result->tgl_status).'<span class="delete_status" id="status_'.$result->id_stat_group.'">x</span></span>
                                                    </div>
                                                    <p>'.MessageCheck($result->status).'</p>';
                                    }
                                    else
                                    {
                                        $hasil.= '<div class="info clearfix">
                                                    <span class="name">'.$result->nama.'</span>
                                                    <span class="date">'.CheckTime($result->tgl_status).'<span class="delete_status" id="status_'.$result->id_stat_group.'">x</span></span>
                                                </div>
                                        <a href="'.base_url($result->large).'" class="prev_image image"></a>
                                        <p>'.MessageCheck($result->status).'</p>
                                        <img src="'.base_url($result->small).'"/>
                                        <span class="delete_status" id="status_'.$result->id_stat_group.'">X</span>';
                                    }
                                    
                                    $hasil .= '</div>
                                    <div id="'.$result->id_stat_group.'" id="hapusstatus_'.$result->id_stat_group.'"></div>
                                    <div class="komentar_user">                            
                                        <div class="span2">
                                        </div>
                                        <div class="span10">
                                            <form method="POST" id="komentar" action="'.site_url('sos/group/set_komentar').'">
                                                <div class="itemOut">
                                                    <div class="controls">
                                                        <div class="control">
                                                            <textarea name="komentar" class="komentar_teks" placeholder="Komentar anda '.$result->nama.'" style="height: 50px; width: 100%;background: white;"></textarea>
                                                            <input type="hidden" name="id_group" value="'.$result->id_group.'"/>
                                                            <input type="hidden" name="id_status" value="'.$result->id_stat_group.'"/>
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
    
    public function hapus_member($id_group,$id_member) {
        $this->group_model->hapus_member_group($id_group,$id_member);
        set_blue_notification('Anggota Group Berhasil Dihapus');
        redirect('sos/group/view/'.$id_group);
    }
    
    public function hapus_acara($id_group,$id_acara) {
        $this->group_model->hapus_acara_group($id_group,$id_acara);
        set_blue_notification('Acara Group Telah Dihapus');
        redirect('sos/group/view/'.$id_group);
    }
    
    public function set_komentar()
    {
        if(!empty($_POST)) {
            $result = $this->group_model->set_komentar_group();
            if(empty($result->foto_member)) {
                $result->foto_member = 'asset/default/images/no_profile.jpg';
            }
            echo '<div class="row-fluid komentar_user" id="hapuskomentar_'.$result->id_komen_status.'">
                    <div class="span2"></div>
                    <div class="span10">
                        <div class="itemOut">
                            <a href="'.base_url($result->foto_member).'" class="prev_image image"><img src="'.base_url($result->foto_member).'" width="50" class="img-polaroid"/></a>
                            <div class="text">
                                <div class="info clearfix">
                                    <span class="name">'.$result->nama.'</span>
                                    <span class="date">'.CheckTime($result->tgl_komen).'<span class="delete_status tooltip" title="Delete" id="komentar_'.$result->id_komen_status.'">x</span></span>
                                </div>                                
                                <p>'.MessageCheck($result->komentar).'</p>
                            </div>
                        </div>                                        
                    </div>
                </div>';
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
    
    public function del_status()
    {
        if(!empty($_POST)) {
            $this->group_model->delete_status();
        }
    }
    
    public function del_komentar()
    {
        if(!empty($_POST)) {
            $this->group_model->delete_komentar();
        }
    }
    
    public function tambah_group()
    {
        if(!empty($_POST)) {
            $this->group_model->set_group();
            redirect('sos/group');
        }else{
            $data['sidebar']        = 'layout/template_sidebar';
            $data['main']           = 'sosial/tbhgroupview';
            $this->load->view('layout/fr_default',$data);
        }
    }
    
    public function edit_group()
    {
        if(!empty($_POST)) {
            $this->group_model->group_edit();
            redirect('sos/group');
        }else{
            $data['sidebar']        = 'layout/template_sidebar';
            $data['main']           = 'sosial/edtgroupview';
            $this->load->view('layout/fr_default',$data);
        }
    }
    
    public function del_group()
    {
        $this->group_model->delete_group();
        redirect('sos/group');
    }
    
    public function create_album()
    {
        if(!empty($_POST))
        {
            $id_group = $this->input->post('id_group');
            $this->group_model->buat_album();
            set_blue_notification("Album Group Berhasil Dibuat");
            redirect('sos/group/view/'.$id_group);
        }
    }
    
    public function tambah_member()
    {
        if(!empty($_POST)) {
            $this->group_model->add_member();
            redirect('sos/group');
        }
    }

    
    //acara group
    public function create_acara()
    {
        $id_group   = $this->input->post('id_group');
        if(!empty($_POST)) {
            $this->group_model->acara_create();
            set_blue_notification('Acara Group Berhasil Di Buat');
            redirect('sos/group/view/'.$id_group);
        }else{
            redirect('sos/group/view/'.$id_group);
        }
        
    }
    
    
}
?>