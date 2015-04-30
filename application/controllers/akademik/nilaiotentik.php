<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Nilaiotentik extends CI_Controller {
	 function __construct()
	 {
		parent::__construct();
		$this->load->library('auth');
		$this->load->helper('global');
		$this->auth->logged_in();
	 }
	function index(){
		$data['main'] 	= 'akademik/nilaiotentik/index';
		$data['page_title'] 	= 'Nilai';
		$this->load->view('layout/ad_blank',$data);
	}
	public function getOptionSiswaByIdKelas()
        {
			$this->load->library('ak_siswa');
			echo $this->ak_siswa->createOptionSiswaByIdKelas($_POST['id_kelas'],1);
		}
	function pranilai($param=''){
		$this->load->model('ad_kelas');
		
		if(isset($_POST['kelas'])){
			
		}
		$data['jenis']=base64_decode($param);
		$data['kelas'] 	=$this->ad_kelas->getkelasByPengajar($this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['user_authentication']['id_pengguna']);
		$data['main'] 	= 'akademik/nilaiotentik/pranilaiotentik';
		$data['page_title'] 	= 'Nilai Otentik';
		$this->load->view('layout/ad_blank',$data);
	}
	function nilai($param=''){
		$this->load->model('ad_instrumen');
		$this->load->library('ak_akademik');
		$data['jenis'] 	=base64_decode($jenis);
		
		//get indikator
		if(isset($_POST['id_kelas'])){
			
			if($_POST['jenis']=='psikomotorik'){
				$data['indikator']=$this->ad_instrumen->getPointIndikatorByKelasMaplelJenisPsikomotorik($_POST['pelajaran'],$_POST['id_kelas'],$_POST['jenis'],$_POST['id_det_jenjang']);
			}else{
				$data['indikator']=$this->ad_instrumen->getPointIndikatorByKelasMaplelJenis($_POST['pelajaran'],$_POST['id_kelas'],$_POST['jenis'],$_POST['id_det_jenjang']);
			}
				 	 	 	 	
			$Qc=$this->db->query('SELECt * FROM ak_nilai_kompetensi_kogn WHERE id_sekolah=? AND id_siswa_det_jenjang=? AND id_pelajaran=? AND ta=? AND semester=? AND penilaian=?',array($this->session->userdata['user_authentication']['id_sekolah'],$_POST['id_det_jenjang'],$_POST['pelajaran'],$this->session->userdata['ak_setting']['ta'],$this->session->userdata['ak_setting']['semester'],$_POST['jenis']));
			$desc_kogn=$Qc->result_array();
			if(isset($_POST['nilai'])){
				if(empty($desc_kogn)){
					$insert_des_kogn=array(
						'id_sekolah'=>$this->session->userdata['user_authentication']['id_sekolah'],
						'id_siswa_det_jenjang'=>$_POST['id_det_jenjang'],
						'id_pelajaran'=>$_POST['pelajaran'],
						'ta'=>$this->session->userdata['ak_setting']['ta'],
						'semester'=>$this->session->userdata['ak_setting']['semester'],
						'nilai'=>$_POST['nilai'],
						'penilaian'=>$_POST['jenis']
					);
					$this->db->insert('ak_nilai_kompetensi_kogn',$insert_des_kogn);
				}else{
					$insert_des_kogn=array(
						'id_sekolah'=>$this->session->userdata['user_authentication']['id_sekolah'],
						'id_siswa_det_jenjang'=>$_POST['id_det_jenjang'],
						'id_pelajaran'=>$_POST['pelajaran'],
						'ta'=>$this->session->userdata['ak_setting']['ta'],
						'semester'=>$this->session->userdata['ak_setting']['semester'],
						'nilai'=>$_POST['nilai'],
						'penilaian'=>$_POST['jenis']
					);
					$where=$insert_des_kogn;
					$where['id']=$desc_kogn[0]['id'];
					unset($where['nilai']);
					$this->db->where($where);
					$this->db->update('ak_nilai_kompetensi_kogn',$insert_des_kogn);
				}
				//echo $this->db->last_query();
				
			}
			
		}
		if($this->session->userdata['ak_setting']['jenjang'][0]['bentuk']!='TK'){
			$kogn=$this->ak_akademik->nilaiKognByIdDetJenPelOtentik($_POST['id_det_jenjang'],$_POST['pelajaran']);
			if($_POST['jenis']=='kognitif'){
				$data['kogn']	=$kogn[$_POST['pelajaran']]['kognitif'];
			}elseif($_POST['jenis']=='afektif'){
				$data['kogn']	=$kogn[$_POST['pelajaran']]['afektif'][0]['nilai'];
			}elseif($_POST['jenis']=='psikomotorik'){
				$data['kogn']	=$kogn[$_POST['pelajaran']]['Psikomotorik'][0]['nilai'];
			}
		}
		
		$data['desc_kogn']	=$desc_kogn;
		$data['main'] 	= 'akademik/nilaiotentik/nilaiotentik';
		$data['page_title'] 	= 'Nilai Otentik';
		$this->load->view('layout/ad_blank',$data);
	}

	
}
?>