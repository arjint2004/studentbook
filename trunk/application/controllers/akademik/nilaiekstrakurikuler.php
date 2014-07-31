<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Nilaiekstrakurikuler extends CI_Controller {
	 function __construct()
	 {
		parent::__construct();
		$this->load->library('auth');
		$this->auth->logged_in();
	 }
	function index(){
		$this->load->model('ad_extrakurikuler');
		$data['ekstra'] 	=$this->ad_extrakurikuler->getdataByPegawai($this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['user_authentication']['id_pengguna']);
		$data['main'] 	= 'akademik/nilaiekstrakurikuler/index';
		$data['page_title'] 	= 'Data Nilai Ekstrakurikuler';
		$this->load->view('layout/ad_blank',$data);	 
	}
	function nilaiekstralist(){
		$this->load->model('ad_extrakurikuler');
		$datax=$this->ad_extrakurikuler->getEkstrakurikulerById_seri($_POST['id_ekstra']);
		$nilai=$this->ad_extrakurikuler->getNilaiByIdEkstra($_POST['id_ekstra']);
		if(isset($_POST['nilai'])){
			//pr($_POST);
			foreach($_POST['nilai'] as $id_siswa_det_jenjang=>$nilaiextra){
				foreach($nilaiextra as $id_ekstra=>$nilaiin){
				
					$nilaiinsert=array(
										'id_ekstrakurikuler'=>$id_ekstra,
										'id_sekolah'=>$this->session->userdata['user_authentication']['id_sekolah'],
										'id_siswa_det_jenjang'=>$id_siswa_det_jenjang,
										'ta'=>$this->session->userdata['ak_setting']['ta'],
										'semester'=>$this->session->userdata['ak_setting']['semester'],
										'nilai'=>$nilaiin,
										'keterangan'=>$_POST['keterangan'][$id_siswa_det_jenjang][$id_ekstra]
					);
					if(isset($nilai[$id_siswa_det_jenjang][$id_ekstra])){
						$this->db->where('id',$nilai[$id_siswa_det_jenjang][$id_ekstra]['id']);
						$this->db->update('ak_nilai_ekstrakurikuler',$nilaiinsert);
					}else{
						$this->db->insert('ak_nilai_ekstrakurikuler',$nilaiinsert);
					}
					//echo $this->db->last_query().'<br />';
				}
			}
		}
		
		//pr($nilai);
		$data['nilai'] 	= $nilai;
		$data['siswaekstra'] 	= $datax;
		$data['main'] 	= 'akademik/nilaiekstrakurikuler/nilaiekstralist';
		$data['page_title'] 	= 'Data Nilai Ekstrakurikuler';
		$this->load->view('layout/ad_blank',$data);	 
	}
	
}
?>