<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Kegiatan extends CI_Controller {
	 function __construct()
	 {
		parent::__construct();
		$this->load->library('auth');
		$this->auth->logged_in();
		$this->load->model('ad_kegiatan');
	 }
	function index(){
		$data['main'] 	= 'schooladmin/kegiatan/index';
		$data['page_title'] 	= 'Data kegiatan';
		$this->load->view('layout/ad_adminsekolah',$data);	 
	}
	
	function delete($id=null){
		if($id==null){
			if(isset($_POST['id'])){
				$id=$_POST['id'];
				$this->db->delete('ak_kegiatan_sekolah', array('id' => $id)); 
				$this->db->delete('ak_nilai_kegiatan_sekolah', array('id_kegiatan_sekolah' => $id)); 
			}
		}
	}
	function adddata(){
		if(isset($_POST['addkegiatan'])){
			$simpan['id_sekolah']=$this->session->userdata['user_authentication']['id_sekolah'];
			$simpan['nama']=$_POST['nama'];
			$this->db->insert('ak_kegiatan_sekolah',$simpan);
		}
		
		$data['main'] 	= 'schooladmin/kegiatan/addData';
		$data['page_title'] 	= 'Tambah kegiatan';
		$this->load->view('layout/ad_blank',$data);
	}
	function listData(){
		$data['page_title'] 	= 'Data kegiatan';
		 if(isset($_POST['simpleupdate'])){
						$dataupdate=$_POST;
			$dataupdate['id']=$_POST['id_kegiatan'];
			unset($dataupdate['id_kegiatan']);
			unset($dataupdate['ajax']);
			unset($dataupdate['simpleupdate']);
			$this->db->where('id', $_POST['id_kegiatan']);
			$this->db->update('ak_kegiatan_sekolah', $dataupdate);
		 }
		$data['kegiatan']=$this->ad_kegiatan->getdata($this->session->userdata['user_authentication']['id_sekolah']);
		 if ($this->input->post('ajax')) {
		   $data['main'] 	= 'schooladmin/kegiatan/listData'; // memilih view
		   $this->load->view('layout/ad_blank',$data); // memilih layout
		} else {
		   $data['main'] 	= 'schooladmin/kegiatan/listData';// memilih view
		   $this->load->view('layout/ad_adminsekolah',$data);
		} 
	}
}
?>