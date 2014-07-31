<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Nilaikegiatansekolah extends CI_Controller {
	 function __construct()
	 {
		parent::__construct();
		$this->load->library('auth');
		$this->auth->logged_in();
	 }
	function index(){
		$this->load->model('ad_kelas');
		$data['kelas'] 	=$this->ad_kelas->getKelasByWali($this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['user_authentication']['id_pengguna']);
		$data['main'] 	= 'akademik/nilaikegiatansekolah/index';
		$data['page_title'] 	= 'Data Nilai Kegiatan';
		$this->load->view('layout/ad_blank',$data);	 
	}
	function kesiswaanindex(){
		$this->load->model('ad_kelas');
		$data['kelas'] 	=$this->ad_kelas->getKelas($this->session->userdata['user_authentication']['id_sekolah']);
		$data['main'] 	= 'akademik/nilaikegiatansekolah/index';
		$data['page_title'] 	= 'Data Nilai Kegiatan';
		$this->load->view('layout/ad_blank',$data);	 
	}
	function nilaiekstralist(){
		$this->load->model('ad_kegiatan');
		$datax=$this->ad_kegiatan->getSiswaByIdKelas($_POST['id_kelas']);
		$datakegiatan=$this->ad_kegiatan->getdata($_POST['id_kelas']);
		$nilai=$this->ad_kegiatan->getNilaiByKelas($_POST['id_kelas']);
		if(isset($_POST['keterangan'])){
			foreach($_POST['keterangan'] as $id_det_jenjang=>$nilaikegiatan){
				foreach($nilaikegiatan as $id_kegiatan=>$nilaikegiatan){
					if($nilaikegiatan!=''){
						$insertdata=array(
									'id_sekolah'=>$this->session->userdata['user_authentication']['id_sekolah'],
									'id_kegiatan_sekolah'=>$id_kegiatan,
									'id_siswa_det_jenjang'=>$id_det_jenjang,
									'semester'=>$this->session->userdata['ak_setting']['semester'],
									'ta'=>$this->session->userdata['ak_setting']['ta'],
									'nilai'=>$nilaikegiatan
						);
					if(isset($nilai[$id_det_jenjang][$id_kegiatan])){
						$this->db->where('id',$nilai[$id_det_jenjang][$id_kegiatan]['id']);
						$this->db->update('ak_nilai_kegiatan_sekolah',$insertdata);echo $this->db->last_query().'<br />';
					}else{
						$this->db->insert('ak_nilai_kegiatan_sekolah',$insertdata);echo $this->db->last_query().'<br />';
					}
					}
					
				}
			}
		}
		
		//pr($nilai);
		$data['nilai'] 	= $nilai;
		$data['datakegiatan'] 	= $datakegiatan;
		$data['siswakegiatan'] 	= $datax;
		$data['main'] 	= 'akademik/nilaikegiatansekolah/nilaikegiatanlist';
		$data['page_title'] 	= 'Data Nilai Kegiatan';
		$this->load->view('layout/ad_blank',$data);	 
	}
	
}
?>