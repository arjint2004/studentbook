<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Content extends CI_Controller {
    function __construct()
    {
		parent::__construct();
		$this->load->library('auth');
		$this->auth->logged_in();
    }
   
    function index($y='',$title=''){
		$data['simpan']=$y;
		$data['title']=$title;
		if ($this->input->post('ajax')) {
		   
		   $data['main'] 	= 'schooladmin/content/index'; // memilih view
		   $this->load->view('layout/ad_blank',$data); // memilih layout
		} else {
		   $data['main'] 	= 'schooladmin/content/index';// memilih view
		   $this->load->view('layout/ad_adminsekolah',$data);
		}
	}
    function edit($title=''){
		$this->load->model('ad_content');
		$content=$this->ad_content->getdata($this->session->userdata['user_authentication']['id_sekolah'],base64_decode($title));
		if(isset($_POST['simpan'])){
			$insert=array(
					'id_sekolah'=>$this->session->userdata['user_authentication']['id_sekolah'],
					'title'=>$_POST['title'],
					'content'=>$_POST['content'],
					'publish'=>1
			);
			if(empty($content)){
				$this->db->insert('ak_content',$insert);
				$content=$this->ad_content->getdata($this->session->userdata['user_authentication']['id_sekolah'],base64_decode($title));
			}else{
				unset($insert['id_sekolah']);
				$array = array('id_sekolah' => $this->session->userdata['user_authentication']['id_sekolah'], 'title' => base64_decode($title));
				$this->db->where($array); 
				$this->db->update('ak_content',$insert);
				$content=$this->ad_content->getdata($this->session->userdata['user_authentication']['id_sekolah'],base64_decode($title));
			}
			redirect('admin/content/index/simpan/'.$title.'');
			//echo $this->db->last_query();
		}
		//pr($content);
		$data['title']=$title;
		$data['content']=$content;
		if ($this->input->post('ajax')) {
		   $data['main'] 	= 'schooladmin/content/edit'; // memilih view
		   $this->load->view('layout/ad_blank',$data); // memilih layout
		} else {
		   $data['main'] 	= 'schooladmin/content/edit';// memilih view
		   $this->load->view('layout/ad_adminsekolah',$data);
		}
	}

}
?>