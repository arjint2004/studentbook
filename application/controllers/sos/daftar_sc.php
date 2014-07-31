<?php
class Daftar extends CI_Controller {
    
    public function __construct(){
        parent::__construct();
        $this->load->helper(array('form','file','html'));
        $this->load->model('sekolah');
    }
    
    public function index() {
        $data['main'] = 'sosial/viewdaftar';
        $this->load->view('layout/default',$data);
    }
    
    public function sekolah() {
        //upload image ukuran besar
        $config['upload_path'] = './upload/images/larger/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size']	= '200000';
        $config['max_width']  = '1024';
        $config['max_height']  = '768';
        $this->load->library('upload', $config);
                
        $data['main'] = 'sosial/viewdaftar';
        if ( ! $this->upload->do_upload('logo'))
        {
            $data['error'] = array('error' => $this->upload->display_errors());
            $this->load->view('layout/default', $data);
        }
        else
        {
            $config2['image_library'] = 'gd2';
            $config2['source_image'] = $this->upload->upload_path.$this->upload->file_name;
            $config2['new_image'] = './upload/images/thumb/';
            $config2['maintain_ratio'] = TRUE;
            $config2['create_thumb'] = TRUE;
            $config2['thumb_marker'] = '_thumb';
            $config2['width'] = 75;
            $config2['height'] = 50;
            $this->load->library('image_lib',$config2);
            $this->image_lib->initialize($config2);
            $this->image_lib->resize();
            $this->image_lib->clear();
            
            $config4['image_library'] = 'gd2';
            $config4['source_image'] = $this->upload->upload_path.$this->upload->file_name;
            $config4['new_image'] = './upload/images/medium/';
            $config4['maintain_ratio'] = TRUE;
            $config4['create_thumb'] = TRUE;
            $config4['thumb_marker'] = '_thumb';
            $config4['width'] = 150;
            $config4['height'] = 150;
            
            $this->load->library('image_lib',$config4); 
            $this->image_lib->initialize($config4);
            $this->image_lib->resize();
            $this->image_lib->clear();
            
            $data = array('upload_data' => $this->upload->data());
            $this->sekolah->create_user();
            $this->load->view('layout/default',$data);   
        }
    }
    
    public function siswa() {
        $data['main']       = 'sosial/viewdaftarsiswa';
        $data['sekolah']    = '';
        $data['group']      = '';
        $this->load->view('layout/default',$data);
    }
}
?>