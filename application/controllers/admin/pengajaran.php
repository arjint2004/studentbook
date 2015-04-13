<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Pengajaran extends CI_Controller {
	 function __construct()
	 {
		parent::__construct();
		$this->load->library('auth');
		$this->auth->logged_in();
		$this->load->model('ad_pengajaran');
		$this->load->library('CSVReader');
	 }
	function index(){
		$data['main'] 	= 'schooladmin/pengajaran/index';
		$data['page_title'] 	= 'Data Pengajaran';
		$this->load->view('layout/ad_adminsekolah',$data);	 
	}
	function listData(){
		$this->load->model('ad_akun');
		$param=array();
		$data['pengajaran']=array(); 
		if(isset($_POST['id_pegawai']) && $_POST['id_pegawai']!=''){
			$param['id_pegawai']=$_POST['id_pegawai'];
			$data['pengajaran'] = $this->ad_pengajaran->getdata($param);
		}
	
		
		$data['pegawai'] 	= $this->ad_pengajaran->getdataGuru();
		$data['page_title'] 	= 'Data Pengajaran';
		if ($this->input->post('ajax')) {
		   $data['main'] 	= 'schooladmin/pengajaran/listData'; // memilih view
		   $this->load->view('layout/ad_blank',$data); // memilih layout
		} else {
		   $data['main'] 	= 'schooladmin/pengajaran/listData';// memilih view
		   $this->load->view('layout/ad_adminsekolah',$data);
		} 		
	}
	function getPelajaranCekbox($semester=null,$kelas=null,$jurusan=null,$id_kelas=null){
		if(isset($_POST['kelas'])){
			$semester=@$_POST['semester'];
			$kelas=@$_POST['kelas'];
			$id_kelas=@$_POST['id_kelas'];
			$jurusan=@$_POST['id_jurusan'];
			$pelajaran=@$_POST['id_pelajaran'];
		}
		$this->load->model('ad_pelajaran');
		$mapel=$this->ad_pelajaran->getdatabySemesterJenjangJurusanKelas($semester,$kelas,$jurusan);

				
		$param=array();
		$pengajaran=array(); 
		if(isset($_POST['id_pegawai']) && $_POST['id_pegawai']!=''){
			$param['id_pegawai']=$_POST['id_pegawai'];
			$param['id_kelas']=$_POST['id_kelas'];
			$pengajaran = $this->ad_pengajaran->getdataByIdkelas($param);
			foreach($pengajaran as $dtpeng){
				$pengajaran2[$dtpeng['id_pelajaran']]=$dtpeng;
			}
			
			unset($pengajaran);
		}
		
		foreach($mapel as $selectpel){
			if(@$pengajaran2[$selectpel['id']]['id_pelajaran']==$selectpel['id']){ $slctd='checked disabled';}else{ $slctd=''; }
			echo "<li><input type='checkbox' ".$slctd." value='".$selectpel['id']."' name='id_pelajaran[".$semester."][".$selectpel['id']."]' />".$selectpel['nama']."</li>";
		}

		die();
	}
	function getPelajaran($semester=null,$kelas=null,$jurusan=null){
		if(isset($_POST['kelas'])){
			$semester=@$_POST['semester'];
			$kelas=@$_POST['kelas'];
			$jurusan=@$_POST['id_jurusan'];
			$pelajaran=@$_POST['id_pelajaran'];
		}
		$this->load->model('ad_pelajaran');
		$mapel=$this->ad_pelajaran->getdatabySemesterJenjangJurusanKelas($semester,$kelas,$jurusan);

		echo "<option value=''>Pilih Pelajaran</option>";
		foreach($mapel as $selectpel){
			if(@$_POST['id_pelajaran']==$selectpel['id']){ $slctd='selected';}else{ $slctd=''; }
			echo "<option ".$slctd." value='".$selectpel['id']."'>".$selectpel['nama']."</option>";
		}

		die();
	}
	function getKelas($kelas=null){
		if(isset($_POST['kelas'])){
			$kelas=@$_POST['kelas'];
		}
		$this->load->model('ad_kelas');
		$this->ad_kelas->getkelasByKelasSelect($kelas,$this->session->userdata['user_authentication']['id_sekolah']);
	}
	function deleteData($id=null,$id_pegawai=null){
		$freepengajar=$this->ad_pengajaran->getFreePengajaran($id,$this->session->userdata['user_authentication']['id_sekolah']);
		if($freepengajar==0){
			$this->db->query('DELETE FROM ak_mengajar WHERE id='.$id.'');
			$this->db->query('DELETE FROM ak_rencana_indikator WHERE id_mengajar='.$id.'');
		}
		echo $freepengajar;
	}
	function editData($id=null){
		$this->load->model('ad_kelas');
		$this->load->model('ad_akun');		
		$this->load->model('ad_jurusan');
		$this->load->model('ad_setting');
		if($id!=null){
			$data['pengajaranedit'] 	= $this->ad_pengajaran->getdataById($id);
			$data['kelas'] 	=  $this->ad_kelas->getkelasByKelas($data['pengajaranedit'][0]['kelas'],$this->session->userdata['user_authentication']['id_sekolah']);
		}
		//pr($data['pengajaranedit']);
		$data['semester'] 	=  $this->ad_setting->getSemester($this->session->userdata['user_authentication']['id_sekolah']);
		if(isset($_POST['addpengajaran'])){
			$datamengajar=array(
						'id_kelas'=>$_POST['id_kelas'],
						'id_sekolah'=>$this->session->userdata['user_authentication']['id_sekolah'],
						'id_pegawai'=>$_POST['id_pegawai'],
						'id_pelajaran'=>$_POST['id_pelajaran']
			);
			$this->db->where('id', $_POST['id_pengajaran']);
			$this->db->update('ak_mengajar',$datamengajar);
			//echo $this->db->last_query();
			/*$tableforupdate=array(
				'ak_harian',
				'ak_materi_pelajaran',
				'ak_pr',
				'ak_subject_nilai',
				'ak_tugas',
				'ak_uas',
				'ak_uts'
			);
			foreach($tableforupdate as $dataforupdate){
				$cond='';
				if($dataforupdate=='ak_subject_nilai'){
					$cond='AND id_kelas='.$_POST['id_kelas'].'';
				}
				$this->db->query('UPDATE '.$dataforupdate.' SET id_pegawai='.$_POST['id_pegawai'].' WHERE id_sekolah='.$this->session->userdata['user_authentication']['id_sekolah'].' AND id_pegawai='.$_POST['id_pegawai'].' '.$cond.'');
			}*/

			//die();
		}
		$datajenjang=$this->ad_kelas->thisjenjang($this->session->userdata['user_authentication']['id']);
		$jur=$this->ad_jurusan->getdata($this->session->userdata['user_authentication']['id_sekolah']);

		$data['pegawai'] 	= $this->ad_akun->getdata(null,$listtype=13,1);		
		$data['grade'] 	=  unserialize($datajenjang[0]['grade']);
		$data['jurusan'] 	= $jur;
		
		$data['main'] 	= 'schooladmin/pengajaran/editData';
		$data['page_title'] 	= 'Tambah pengajaran';
		$this->load->view('layout/ad_blank',$data);	
	}
	public function makeIndikator(){
		$csv_dir='upload/akademik/';
		$this->load->library('CSVReader');
        //$result =   $this->CSVReader->saveindikator($csv_dir.'indikator.csv');
	}
	private function setIndikator($id_mengajar,$id_pelajaran,$id_pegawai,$semester){
		$csv_dir='upload/akademik/';
        $this->load->model('ad_pengajaran');

		$result=$this->CSVReader->parse_file($csv_dir.'indikator.csv');
		
		foreach($result as $datapenilaian){
				//$q=$this->db->query('SELECT COUNT(*) as jml FROM ak_rencana_indikator WHERE id_pelajaran=? AND id_mengajar=? AND id_sekolah=? AND penilaian=?',array($id_pelajaran,$id_mengajar,$this->session->userdata['user_authentication']['id_sekolah'],$datapenilaian[0]));
				//$cek=$q->result_array();
				
				//if($cek[0]['jml']==0){
					$insert_indikator=array(
										'id_sekolah'=>$this->session->userdata['user_authentication']['id_sekolah'],
										'id_pelajaran'=>$id_pelajaran,
										'id_mengajar'=>$id_mengajar,
										'id_pegawai'=>$id_pegawai,
										'semester'=>$semester,
										'ta'=>0,
										'penilaian'=>$datapenilaian[0],
										'indikator'=>$datapenilaian[1]
					);
					//pr($insert_indikator);
					$this->db->insert('ak_rencana_indikator',$insert_indikator);
					//pr($this->db->last_query());
				//}
			}
	}
	function addData(){

		$this->load->model('ad_akun');		
		$this->load->model('ad_pengajaran');		
		$this->load->model('ad_jurusan');
		$this->load->model('ad_kelas');
		$this->load->model('ad_setting');
		$data['semester'] 	=  $this->ad_setting->getSemester($this->session->userdata['user_authentication']['id_sekolah']);
		if(isset($_POST['addpengajaran'])){
			$cek=$this->ad_pengajaran->cekcurrentpengajaran($_POST);
			if($cek>0){
				echo 0;die();
			}else{
				$datamengajar=array(
							'id_kelas'=>$_POST['id_kelas'],
							'id_sekolah'=>$this->session->userdata['user_authentication']['id_sekolah'],
							'id_pegawai'=>$_POST['id_pegawai'],
							'id_pelajaran'=>$_POST['id_pelajaran']
				);
			
				$this->db->insert('ak_mengajar',$datamengajar);
				$id_mengajar=$this->db->insert_id();
				$this->setIndikator($id_mengajar,$_POST['id_pelajaran']);
				echo 1;die();
			}
			die();
		}
		$datajenjang=$this->ad_kelas->thisjenjang($this->session->userdata['user_authentication']['id']);
		$jur=$this->ad_jurusan->getdata($this->session->userdata['user_authentication']['id_sekolah']);

		$data['pegawai'] 	= $this->ad_akun->getdata(null,$listtype=13,1);		
		$data['grade'] 	=  unserialize($datajenjang[0]['grade']);
		$data['jurusan'] 	= $jur;
		
		$data['main'] 	= 'schooladmin/pengajaran/addData';
		$data['page_title'] 	= 'Tambah pengajaran';
		$this->load->view('layout/ad_blank',$data);	
	}
	
	function addDataSimple(){

		$this->load->model('ad_akun');		
		$this->load->model('ad_pengajaran');		
		$this->load->model('ad_jurusan');
		$this->load->model('ad_kelas');
		$this->load->model('ad_setting');
		$data['semester'] 	=  $this->ad_setting->getSemester($this->session->userdata['user_authentication']['id_sekolah']);
		
		if(isset($_POST['addpengajaran'])){
			//$this->countsem=0;
			$param['id_kelas']=$_POST['id_kelas'];
			$param['id_pegawai']=$_POST['id_pegawai'];		
			foreach($_POST['id_pelajaran'] as $id_semester=>$idpel){
				foreach($idpel as $id_pelajaran){
					$param['id_pelajaran']=$id_pelajaran;
					$cek=$this->ad_pengajaran->cekcurrentpengajaran($param);
					if($cek>0){
						echo 0;die();
					}else{
						$datamengajar=array(
									'id_kelas'=>$_POST['id_kelas'],
									'id_sekolah'=>$this->session->userdata['user_authentication']['id_sekolah'],
									'id_pegawai'=>$_POST['id_pegawai'],
									'id_pelajaran'=>$id_pelajaran
						);
					
						$this->db->insert('ak_mengajar',$datamengajar);
						//if($this->countsem==0){
							$id_mengajar=$this->db->insert_id();
							$this->setIndikator($id_mengajar,$id_pelajaran,$_POST['id_pegawai'],$id_semester);
							
						//}
						
					}		
				}
				//$this->countsem++;
			}
			
			echo 1;die();
		}

		
		
		$data['pegawai'] 	= $this->ad_akun->getdata(null,$listtype=13,1);		
		$data['kelas'] 	=  $this->ad_kelas->getkelas($this->session->userdata['user_authentication']['id_sekolah']);
		$data['jurusan'] 	= $this->ad_jurusan->getdata($this->session->userdata['user_authentication']['id_sekolah']);
		
		$data['main'] 	= 'schooladmin/pengajaran/addDataSimple';
		$data['page_title'] 	= 'Tambah pengajaran';
		$this->load->view('layout/ad_blank',$data);	
	}
	
	function setmengajar(){
		$data['main'] 	= 'schooladmin/pengajaran/setmengajar';
		$data['page_title'] 	= 'Set Pengajaran';
		$this->load->view('layout/ad_adminsekolah',$data);	 
	}
	function oper(){
		$id=$_POST['id_pengajar'];
		$this->load->model('ad_kelas');
		$this->load->model('ad_akun');		
		$this->load->model('ad_jurusan');
		$this->load->model('ad_setting');
		if($id!=null){
			$data['pengajaranedit'] 	= $this->ad_pengajaran->getdataById($id);
			$data['kelas'] 	=  $this->ad_kelas->getkelasByKelas($data['pengajaranedit'][0]['kelas'],$this->session->userdata['user_authentication']['id_sekolah']);
		}
		//pr($data['pengajaranedit']);
		$data['semester'] 	=  $this->ad_setting->getSemester($this->session->userdata['user_authentication']['id_sekolah']);
		if(isset($_POST['addpengajaran'])){
			$tableforupdate=array(
				'ak_harian',
				'ak_materi_pelajaran',
				'ak_mengajar',
				'ak_pr',
				'ak_subject_nilai',
				'ak_tugas',
				'ak_uas',
				'ak_uts'
			);
			foreach($tableforupdate as $dataforupdate){
				$cond='';
				if($dataforupdate=='ak_mengajar' || $dataforupdate=='ak_subject_nilai'){
					$cond='AND id_kelas='.$_POST['id_kelas'].'';
				}
				$this->db->query('UPDATE '.$dataforupdate.' SET id_pegawai='.$_POST['id_pegawai2'].' WHERE id_sekolah='.$this->session->userdata['user_authentication']['id_sekolah'].' AND id_pegawai='.$_POST['id_pegawai'].' '.$cond.'');
			}

		}
		$datajenjang=$this->ad_kelas->thisjenjang($this->session->userdata['user_authentication']['id']);
		$jur=$this->ad_jurusan->getdata($this->session->userdata['user_authentication']['id_sekolah']);

		$data['pegawai'] 	= $this->ad_akun->getdata(null,$listtype=13,1);		
		$data['no_kelas'] 	= $this->ad_kelas->getdatanokelas();
		$data['grade'] 	=  unserialize($datajenjang[0]['grade']);
		$data['jurusan'] 	= $jur;
		
		$data['main'] 	= 'schooladmin/pengajaran/oper';
		$data['page_title'] 	= 'Tambah pengajaran';
		$this->load->view('layout/ad_blank',$data); 
	}

}
?>