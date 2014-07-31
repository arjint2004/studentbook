<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Berita extends CI_Controller {
	 var $upload_dir='upload/images/berita/';
     public $denied_mime_types = array('application/x-php','application/x-httpd-php', 'text/html', 'text/css', 'text/javascript'); //array of denied mime types used when check_file_type is set to denied
	 function __construct()
	 {
		  parent::__construct();
		  //$this->load->library('auth');
		  //$this->auth->logged_in();
	 }
	 
	 public function index($id=0) {
		$this->load->model('ad_berita');
		$this->load->library('pagination');
		$config['uri_segment']  	= 4;
        $config['base_url']     	= site_url('homedata/berita/index');
        $config['per_page']     	= 5;
        $config['total_rows']   	= $this->ad_berita->tot_paging_berita();
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
        
        $data['data']	        = $this->ad_berita->get_data($id,$config['per_page'],$this->uri->segment(6));
        $data['pagination']		= $this->pagination->create_links();
		$data['page_title'] 	= 'Berita';
		$data['main'] 	= 'homedata/berita/index';
		$this->load->view('layout/home_default',$data);
	 }
	 
	 public function detail($id=0) {
		$this->load->model('ad_berita');
		$data['berita']=$this->ad_berita->get_berita_by_id($id);
		$data['countcommand']=$this->ad_berita->countcomment($id);
		$this->db->query('UPDATE sc_berita SET viewed=viewed+1 WHERE id_berita='.$id.'');
		//pr($data['countcommand']);
		$data['id'] 	=$id;
		$data['main'] 	= 'homedata/berita/berita_detail';
		$data['page_title'] 	= 'Berita';
		$this->load->view('layout/home_default',$data);
	 }
	
	 
}
?>