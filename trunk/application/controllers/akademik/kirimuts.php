<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Kirimuts extends CI_Controller
    {
		var $upload_dir='upload/akademik/uts/';
		public $denied_mime_types = array('application/x-php','application/x-httpd-php', 'text/html', 'text/css', 'text/javascript'); //array of denied mime types used when check_file_type is set to denied
        public function __construct()
        {
            parent::__construct();
            $this->load->helper('global');
            $this->load->helper('akademik');
            $this->load->library('session');
            $this->load->library('auth');
            $this->auth->user_logged_in();
        }
		public function getutsStok($id_pelajaran)
        { 
			
			$this->load->model('ad_uts');
			$uts =$this->ad_uts->getutsStok($id_pelajaran);
			if(empty($uts)){
				echo '<option value="">uts TIDAK TERSEDIA</option>';
			}else{
				echo '<option value="">Pilih uts</option>';
				foreach($uts as $duts){
					echo '<option value="'.$duts['id'].'">'.$duts['judul'].'</option>';
				}
			}
			
		}
		public function kirimutsnya()
        { 
			//$this->load->model('ad_kelas');
			$this->load->model('ad_pelajaran');
			//$data['kelas'] 	=$this->ad_kelas->getkelasByPengajar($this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['user_authentication']['id_pengguna']);
			$data['pelajaran'] 	=$this->ad_pelajaran->getdatabySemesterJenjangJurusanPegawaimengajar();
			if($_POST['id_kelas']){
				$this->load->library('smsprivate');
				foreach($_POST['id_kelas'] as $idm => $id_kelas){
						$insert_detail=array('id_uts'=>$_POST['id_uts'],
											 'id_kelas'=>$id_kelas,
											 'id_mengajar'=>$_POST['id_mengajar'][$idm],
											 'tanggal_kumpul'=>$_POST['tanggal_kumpul'],
											 'keterangan'=>$_POST['keterangan'],
											 'tanggal'=>date('Y-m-d H:i:s')
											);
											
						$this->db->insert('ak_uts_det',$insert_detail);
						$this->load->library('ak_notifikasi');
						$this->ak_notifikasi->set_notifikasi_akademik_per_kelas($id_kelas,$gorup_notif='uts',$_POST['id_pelajaran'],$_POST['judul'],$this->session->userdata['user_authentication']['id_pengguna'],$_POST['keterangan'],$_POST['id_uts'],'uts');
						$this->smsprivate->send_by_kelas($id_kelas,$_POST['keterangan'],'uts',$_POST['id_uts']);
				}
			}

		    $data['main']= 'akademik/kirimuts/kirimuts';
            $this->load->view('layout/ad_blank',$data);
		}
       	public function delete($id_uts=null)
        {	
			$this->load->model('ad_uts');
			$datafile=$this->ad_uts->getFileutsById_uts($id_uts);
			
			//delete file
			foreach($datafile as $datainfile){
				$this->deletefile($datainfile['id']);
			}
			
			//delete data
			//$this->db->query('DELETE FROM ak_uts_kirim WHERE id_uts='.$id_uts.'');
			if(
			$this->db->query('DELETE FROM ak_uts WHERE id='.$id_uts.'') && 
			$this->db->query('DELETE FROM ak_uts_file WHERE id_uts='.$id_uts.'') && 
			$this->db->query('DELETE FROM ak_uts_det WHERE id_uts='.$id_uts.'') &&
			$this->db->query('DELETE FROM ak_uts_det_remidial WHERE id_uts='.$id_uts.'') &&
			$this->db->query('DELETE FROM ak_pengumpulan_uts WHERE id_uts='.$id_uts.'') 
			){
				echo 1;
			}else{
				echo 0;
			}
		}
        public function uploadfileuts($id_uts)
        {
			
			if(isset($_FILES)){
			if(!empty($_FILES["file"]["error"])){
				foreach ($_FILES["file"]["error"] as $key => $error) {
					if ($error == UPLOAD_ERR_OK) {
						$name = date('Ymdhis').str_replace(" ","",$_FILES["file"]["name"][$key]);
						if(!in_array($_FILES["file"]["type"][$key], $this->denied_mime_types)){
							if(move_uploaded_file($_FILES["file"]["tmp_name"][$key], $this->upload_dir . $name)){
								$this->db->insert('ak_uts_file', array('id_uts'=>$id_uts,'file_name'=>''.$name.''));
							}
						}else{
							echo "Anda tidak diperbolehkan mengunggah file type ini. Silahkan edit data anda dan masukkan file yang benar.";
							die();
						}						
						

						
					}
				}				
			}
			}

        }
        public function daftarutslist()
        {
			$this->load->model('ad_uts');
			$uts=$this->ad_uts->getutsByKelasPelajaranIdPegawaiAll($_POST['pelajaran'],$_POST['id_kelas']);
			$terkirim=$this->ad_uts->getutsByKelasPelajaranIdPegawaiKirim($_POST['pelajaran'],$_POST['id_kelas']);
			$telahdikirim=array();
			$uts2=array();
			
			if(!empty($uts)){
				foreach($uts as $ky=>$datauts){
					if(isset($terkirim[$datauts['id']])){
						$telahdikirim[$datauts['id']]=$datauts;
						$telahdikirim[$datauts['id']]['file']=$this->ad_uts->getFileutsByIduts($datauts['id']);
						$telahdikirim[$datauts['id']]['dikirim']=$terkirim[$datauts['id']];
					}else{
						$uts2[$ky]=$datauts;
						$uts2[$ky]['file']=$this->ad_uts->getFileutsByIduts($datauts['id']);
					}
					
				}
				$uts=array_merge($telahdikirim,$uts2);
			}
			unset($uts2);
			
			$data['uts']=$uts;
			//uts($telahdikirim);
			$data['terkirim']=$telahdikirim;
			$data['id_kelas']=$_POST['id_kelas'];
			$data['main']= 'akademik/kirimuts/daftarutslist';
            $this->load->view('layout/ad_blank',$data);	
		}
        public function daftaruts()
        {	
			$this->load->model('ad_kelas');
			$data['uts']=array();
			$data['kelas'] 	=$this->ad_kelas->getkelasByPengajar($this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['user_authentication']['id_pengguna']);
			$data['main']= 'akademik/kirimuts/daftaruts';
            $this->load->view('layout/ad_blank',$data);		
		}
        public function kirimutsutama()
        {
			$this->load->model('ad_kelas');
			//$data['kelas'] 	=$this->ad_kelas->getkelasByPengajar($this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['user_authentication']['id_pengguna']);
			if(isset($_POST['id_pelajaran'])){
				
				@$_POST['id_sekolah']=$this->session->userdata['user_authentication']['id_sekolah'];
				@$_POST['id_pegawai']=$this->session->userdata['user_authentication']['id_pengguna'];
				@$_POST['semester']=$this->session->userdata['ak_setting']['semester'];
				@$_POST['ta']=$this->session->userdata['ak_setting']['ta'];
				@$_POST['tanggal_buat']=date('Y-m-d H:i:s');
				@$_POST['jenis']='non_remidial';
				//@$_POST['id_mengajar']=$mengajar[0]['id_mengajar'];
				$id_kelas=$_POST['id_kelas'];
				$tanggal_kumpul=$_POST['tanggal_kumpul'];
				
				$postkelas=$_POST['id_kelas'];
				$id_mengajar=$_POST['id_mengajar'];
				$keterangan=$_POST['keterangan'];
				unset($_POST['ajax']);
				unset($_POST['id_kelas']);
				unset($_POST['id_mengajar']);
				unset($_POST['simpanarsiputs']);
				unset($_POST['tanggal_kumpul']);
				unset($_POST['keterangan']);

				$this->db->insert('ak_uts',$_POST);
				
				$id_uts=mysql_insert_id();
				
				if(isset($postkelas) && !empty($postkelas)){
				$this->load->library('smsprivate');
				foreach($postkelas as $id_kelas){
					$insert_detail=array('id_uts'=>$id_uts,
										'id_kelas'=>$id_kelas,
										'tanggal'=>date('Y-m-d H:i:s'),
										'tanggal_kumpul'=>$tanggal_kumpul,
										'keterangan'=>$keterangan,
										'id_mengajar'=>$id_mengajar[$id_kelas]
										);
										
					$this->db->insert('ak_uts_det',$insert_detail);
					$this->smsprivate->send_by_kelas($id_kelas,$keterangan,'uts',$id_uts);
					//notifikasi
					$this->load->library('ak_notifikasi');
					$this->ak_notifikasi->set_notifikasi_akademik_per_kelas($id_kelas,$gorup_notif='uts',$_POST['id_pelajaran'],$_POST['judul'],$_POST['id_pegawai'],$keterangan,$id_uts,'uts');
					//$this->load->model('ad_notifikasi');
					//$this->ad_notifikasi->add_notif_sms_ortu_perkelas($id_kelas,$_POST['id_pelajaran'],$data=array('group'=>'uts'));
					//end notifikasi
				}
				}
				echo $id_uts;
				die();
			}
			
			$this->load->model('ad_pelajaran');
			$data['pelajaran'] 	=$this->ad_pelajaran->getdatabySemesterJenjangJurusanPegawaimengajar();
            $data['main']           = 'akademik/kirimuts/kirimutsutama';
            $this->load->view('layout/ad_blank',$data);
        }
        public function kirimutsremidial()
        { 
			$this->load->model('ad_kelas');
			$data['kelas'] 	=$this->ad_kelas->getkelasByPengajar($this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['user_authentication']['id_pengguna']);
			if(isset($_POST['id_pelajaran'])){
				$kls=$this->ad_kelas->getkelasById($this->session->userdata['user_authentication']['id_sekolah'],$_POST['id_kelas']);
				
				//get id mengajar
				$this->load->model('ad_pelajaran');
				$mengajar=$this->ad_pelajaran->getdatabySemesterJenjangJurusanKelasPegawaimengajar($this->session->userdata['ak_setting']['semester'],$kls[0]['kelas'],$data['kelas'][0]['id_jurusan'],$_POST['id_kelas']);
				
				@$_POST['id_sekolah']=$this->session->userdata['user_authentication']['id_sekolah'];
				@$_POST['id_pegawai']=$this->session->userdata['user_authentication']['id_pengguna'];
				@$_POST['semester']=$this->session->userdata['ak_setting']['semester'];
				@$_POST['ta']=$this->session->userdata['ak_setting']['ta'];
				@$_POST['tanggal_buat']=date('Y-m-d H:i:s');
				@$_POST['jenis']='remidial';
				@$_POST['id_mengajar']=$mengajar[0]['id_mengajar'];
				$id_kelas=$_POST['id_kelas'];
				$tanggal_kumpul=$_POST['tanggal_kumpul'];
				$siswa=$_POST['siswa'];
				$filenamecurrent=$_POST['file_name_cek'];
				
				unset($_POST['file_name_cek']);
				unset($_POST['siswa']);
				unset($_POST['ajax']);
				//unset($_POST['id_kelas']);
				//unset($_POST['tanggal_kumpul']);
				
				$this->db->insert('ak_uts',$_POST);
				
				$id_uts=mysql_insert_id();
				if(!empty($filenamecurrent)){
					foreach($filenamecurrent as $namafile){
						$this->db->insert('ak_uts_file', array('id_uts'=>$id_uts,'file_name'=>''.$namafile.''));
					}
				}
				
					//notifikasi
					$this->load->model('ad_notifikasi');
					$this->load->library('ak_notifikasi');
					//notifikasi
				
				$insert_detailuts=array('id_uts'=>$id_uts,
										'id_kelas'=>$id_kelas,
										'tanggal'=>date('Y-m-d H:i:s'),
										'tanggal_kumpul'=>$tanggal_kumpul,
										'id_mengajar'=>$_POST['id_mengajar']
										);
										
				$this->db->insert('ak_uts_det',$insert_detailuts);
				
				foreach($siswa as $id_siswa_det_jenjang){
				$insert_detail=array('id_uts'=>$id_uts,
									'id_kelas'=>$id_kelas,
									'id_siswa_det_jenjang'=>$id_siswa_det_jenjang,
									'tanggal'=>date('Y-m-d H:i:s'),
									'tanggal_kumpul'=>$tanggal_kumpul
									);
									
				$this->db->insert('ak_uts_det_remidial',$insert_detail);
				
					//notifikasi
					//$this->ak_notifikasi->set_notifikasi_akademik_per_siswa($id_siswa,$gorup_notif='uts',$_POST['id_pelajaran'],$_POST['judul'],$_POST['id_pegawai'],$_POST['keterangan']);
					$this->ak_notifikasi->set_notifikasi_akademik_per_siswa_detjenjang($id_siswa_det_jenjang,$gorup_notif='uts',$_POST['id_pelajaran'],$_POST['judul'],$_POST['id_pegawai'],$_POST['keterangan'],$id_uts,'uts');
					//$this->ad_notifikasi->add_notif_sms_ortu_per_siswa_detjenjang($id_siswa_det_jenjang,$_POST['id_pelajaran'],$data=array('group'=>'uts'));
					//end notifikasi
				
				}
				
				echo $id_uts;
				die();
			}
			
            $data['main']           = 'akademik/kirimuts/kirimutsremidial';
            $this->load->view('layout/ad_blank',$data);
        }
        public function kirimutsremidialedit($id)
        { 
			$this->load->model('ad_uts');
			if(isset($_POST['id_pelajaran'])){
				$id_uts=$_POST['id'];
				@$_POST['id_sekolah']=$this->session->userdata['user_authentication']['id_sekolah'];
				@$_POST['id_pegawai']=$this->session->userdata['user_authentication']['id_pengguna'];
				@$_POST['semester']=$this->session->userdata['ak_setting']['semester'];
				@$_POST['ta']=$this->session->userdata['ak_setting']['ta'];
				@$_POST['tanggal_buat']=date('Y-m-d H:i:s');
				@$_POST['jenis']='remidial';
				$id_kelas=$_POST['id_kelas'];
				$tanggal_kumpul=$_POST['tanggal_kumpul'];
				$siswa=$_POST['siswa'];
				$filenamecurrent=$_POST['file_name_cek'];
				
				unset($_POST['file_name_cek']);
				unset($_POST['siswa']);
				unset($_POST['ajax']);
				unset($_POST['id_kelas']);
				//unset($_POST['tanggal_kumpul']);
				
				$this->db->where('id',$_POST['id']);
				$this->db->update('ak_uts',$_POST);
				$this->db->query('DELETE FROM ak_uts_det_remidial WHERE id_uts='.$id_uts.'');
				
				if(!empty($filenamecurrent)){
					foreach($filenamecurrent as $namafile){
						$this->db->insert('ak_uts_file', array('id_uts'=>$id_uts,'file_name'=>''.$namafile.''));
					}
				}
				if(!empty($siswa)){
					foreach($siswa as $id_siswa_det_jenjang){
					$insert_detail=array('id_uts'=>$id_uts,
										'id_kelas'=>$id_kelas,
										'id_siswa_det_jenjang'=>$id_siswa_det_jenjang,
										'tanggal'=>date('Y-m-d H:i:s'),
										'tanggal_kumpul'=>$tanggal_kumpul
										);
										
					$this->db->insert('ak_uts_det_remidial',$insert_detail);
					}
				}
				echo $id_uts;
				die();
			}
			$data['uts']=$this->ad_uts->getutsByIdForRemidi($id);
			$this->load->model('ad_kelas');
			$data['kelas'] 	=$this->ad_kelas->getkelasByPengajar($this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['user_authentication']['id_pengguna']);
            $data['main']           = 'akademik/kirimuts/kirimutsremidialedit';
            $this->load->view('layout/ad_blank',$data);
        } 
		
        public function deletefile($id=null)
        {	
		
			$this->load->model('ad_uts');
			$datafile=$this->ad_uts->getFileById($id);
			if(file_exists($this->upload_dir.$datafile[0]['file_name'])){
			unlink($this->upload_dir.$datafile[0]['file_name']);
			}
			$this->db->query('DELETE FROM ak_uts_file WHERE id='.$id.'');
		}
        public function getOptionFileutsByIduts($id_uts=null)
        {
			$this->load->library('ak_uts');
			echo $this->ak_uts->createOptionFileutsByIduts($id_uts);
		}
        public function getOptionSiswaRemidiByIdKelas($id_kelas=null,$id_uts=null)
        {
			$this->load->library('ak_uts');
			echo $this->ak_uts->createOptionSiswaRemidiByIdKelas($id_kelas,$id_uts);
		}
        public function getOptionSiswaByIdKelas($id_kelas=null)
        {
			$this->load->library('ak_siswa');
			echo $this->ak_siswa->createOptionSiswaByIdKelas($id_kelas);
		}
        public function createOptionutsByKelasPelajaranIdPegawai($id_pelajaran=null,$id_kelas=null)
        {
			$this->load->library('ak_uts');
			echo $this->ak_uts->createOptionutsByKelasPelajaranIdPegawai($id_pelajaran,$id_kelas);
		}
        public function createOptionutsRemidiEditByKelasPelajaranIdPegawai($id_pelajaran=null,$id_kelas=null,$id_parent_uts)
        {
			$this->load->library('ak_uts');
			echo $this->ak_uts->createOptionutsRemidiEditByKelasPelajaranIdPegawai($id_pelajaran,$id_kelas,$id_parent_uts);
		}
		
        public function kirimutsutamaedit($id=null)
        {
			$this->load->model('ad_kelas');
			$this->load->model('ad_pelajaran');
			$this->load->model('ad_uts');
			
			
			if(isset($_POST['id_pelajaran'])){
				
				@$_POST['id_sekolah']=$this->session->userdata['user_authentication']['id_sekolah'];
				@$_POST['semester']=$this->session->userdata['ak_setting']['semester'];
				@$_POST['ta']=$this->session->userdata['ak_setting']['ta'];
				@$_POST['tanggal_buat']=date('Y-m-d H:i:s');
				$id_kelasarray=$_POST['id_kelas'];
				$tanggal_kumpul=$_POST['tanggal_kumpul'];
				$id_mengajar=$_POST['id_mengajar'];
				unset($_POST['id_mengajar']);
				unset($_POST['ajax']);
				unset($_POST['id_kelas']);
				unset($_POST['tanggal_kumpul']);
				$this->db->where('id',$_POST['id']);
				$this->db->update('ak_uts',$_POST);
				
				$id_uts=$_POST['id'];
				/*
									
				$this->db->insert('ak_uts_det',$insert_detail);*/
				
				if(isset($id_kelasarray) AND !empty($id_kelasarray)){
					foreach($id_kelasarray as $id_kelas){
						$insert_detail=array('id_uts'=>$id_uts,
										'id_kelas'=>$id_kelas,
										'tanggal'=>date('Y-m-d H:i:s'),
										'tanggal_kumpul'=>$tanggal_kumpul,
										'id_mengajar'=>$id_mengajar[$id_kelas]
										);
											
						$this->db->insert('ak_uts_det',$insert_detail);
						
						///notifikasi
						$this->load->library('ak_notifikasi');
						$this->ak_notifikasi->set_notifikasi_akademik_per_kelas($id_kelas,$gorup_notif='uts',$_POST['id_pelajaran'],$_POST['judul'],$this->session->userdata['user_authentication']['id_pengguna'],$_POST['keterangan'],$id_uts,'uts');
						//$this->load->model('ad_notifikasi');
						//$this->ad_notifikasi->add_notif_sms_ortu_perkelas($id_kelas,$_POST['id_pelajaran'],$data=array('group'=>'uts'));
						//end notifikasi
						
					}				
				}
				
				echo $id_uts;
				die();
			}else{
			
			$data['uts']=$this->ad_uts->getJustutsById($id);

			}
			
			
			$data['kelaspenerima'] 	=$this->ad_uts->getIdKelasPenerima($id);
			
			foreach($data['kelaspenerima'] as $kelaspenerimadto){
				$kelaspenerima2[$kelaspenerimadto['id']]=$kelaspenerimadto['id'];
			}
			$data['kelaspenerima2']=$kelaspenerima2;

			$data['kelas'] 	=$this->ad_kelas->getKelasByPelajaranMengajar($data['uts']['uts'][0]['id_pelajaran'],$this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['ak_setting']['semester'],$this->session->userdata['user_authentication']['id_pengguna']);
			$data['pelajaran'] 	=$this->ad_pelajaran->getdatabySemesterJenjangJurusanPegawaimengajar($this->session->userdata['ak_setting']['semester']);
			
            $data['main']           = 'akademik/kirimuts/kirimutsutamaedit';
            $this->load->view('layout/ad_blank',$data);
        }      
		
		function makedetail(){
			$query=$this->db->query('SELECT * FROM ak_uts');
			//echo $this->db->last_query();
			$data=$query->result_array();
			foreach($data as $datauts){
				$insert_detail=array(
								'id_uts'=>$datauts['id'],
								'id_kelas'=>$datauts['id_kelass'],
								'tanggal'=>$datauts['tanggal_buat'],
								'tanggal_kumpul'=>$datauts['tanggal_kumpul'],
								'id_mengajar'=>$datauts['id_mengajar']
				);
				//$this->db->insert('ak_uts_det',$insert_detail);
			}
		}
    }
?>