<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Nilaikepribadian extends CI_Controller {
	 function __construct()
	 {
		parent::__construct();
		$this->load->library('auth');
		$this->auth->logged_in();
	 }
	function index(){
		$this->load->model('ad_kelas');
		$data['kelas'] 	=$this->ad_kelas->getKelasByWali($this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['user_authentication']['id_pengguna']);
		$data['main'] 	= 'akademik/nilaikepribadian/index';
		$data['page_title'] 	= 'Data Nilai kepribadian';
		$this->load->view('layout/ad_blank',$data);	 
	}
	function kesiswaanindex(){
		$this->load->model('ad_kelas');
		$data['kelas'] 	=$this->ad_kelas->getKelasByWali($this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['user_authentication']['id_pengguna']);
		$data['main'] 	= 'akademik/nilaikepribadian/index';
		$data['page_title'] 	= 'Data Nilai kepribadian';
		$this->load->view('layout/ad_blank',$data);	 
	}
	function nilaiekstralist(){
		$this->load->model('ad_nilaikepribadian');
		$datax=$this->ad_nilaikepribadian->getSiswaByIdKelas($_POST['id_kelas']);
		$datakepribadian=$this->ad_nilaikepribadian->getdata($_POST['id_kelas']);
		$nilai=$this->ad_nilaikepribadian->getNilaiByKelas($_POST['id_kelas']);
		if(isset($_POST['keterangan'])){
			foreach($_POST['keterangan'] as $id_det_jenjang=>$nilaikepribadian){
				foreach($nilaikepribadian as $id_kepribadian=>$nilaikepribadian){
					if($nilaikepribadian!=''){
						$insertdata=array(
									/*'id_sekolah'=>$this->session->userdata['user_authentication']['id_sekolah'],
									'id_aspek_kepribadian'=>$id_kepribadian,
									'id_siswa_det_jenjang'=>$id_det_jenjang,
									'semester'=>$this->session->userdata['ak_setting']['semester'],
									'ta'=>$this->session->userdata['ak_setting']['ta'],*/
									
									'nilai'=>$_POST['nilai'][$id_det_jenjang][$id_kepribadian],
									'keterangan'=>$nilaikepribadian
						);
					if(isset($nilai[$id_det_jenjang][$id_kepribadian])){
						$this->db->where('id',$nilai[$id_det_jenjang][$id_kepribadian]['id']);
						$this->db->update('ak_nilai_kepribadian',$insertdata);echo $this->db->last_query().'<br />';
					}else{
						$this->db->insert('ak_nilai_kepribadian',$insertdata);echo $this->db->last_query().'<br />';
					}
					}
					
				}
			}
		}
		
		//pr($nilai);
		$data['nilai'] 	= $nilai;
		$data['datakepribadian'] 	= $datakepribadian;
		$data['siswakepribadian'] 	= $datax;
		$data['main'] 	= 'akademik/nilaikepribadian/nilaikepribadianlist';
		$data['page_title'] 	= 'Data Nilai kepribadian';
		$this->load->view('layout/ad_blank',$data);	 
	}
	
}
?>