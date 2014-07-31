<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Kirimharian extends CI_Controller
    {
		var $upload_dir='upload/akademik/harian/';
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
		public function getharianStok($id_pelajaran)
        { 
			
			$this->load->model('ad_harian');
			$harian =$this->ad_harian->getharianStok($id_pelajaran);
			if(empty($harian)){
				echo '<option value="">harian TIDAK TERSEDIA</option>';
			}else{
				echo '<option value="">Pilih harian</option>';
				foreach($harian as $dharian){
					echo '<option value="'.$dharian['id'].'">'.$dharian['judul'].'</option>';
				}
			}
			
		}
		public function kirimhariannya()
        { 
			//$this->load->model('ad_kelas');
			$this->load->model('ad_pelajaran');
			//$data['kelas'] 	=$this->ad_kelas->getkelasByPengajar($this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['user_authentication']['id_pengguna']);
			$data['pelajaran'] 	=$this->ad_pelajaran->getdatabySemesterJenjangJurusanPegawaimengajar();
			if($_POST['id_kelas']){
				$this->load->library('smsprivate');
				foreach($_POST['id_kelas'] as $idm => $id_kelas){
						$insert_detail=array('id_harian'=>$_POST['id_harian'],
											 'id_kelas'=>$id_kelas,
											 'id_mengajar'=>$_POST['id_mengajar'][$idm],
											 'tanggal_kumpul'=>$_POST['tanggal_kumpul'],
											 'keterangan'=>$_POST['keterangan'],
											 'tanggal'=>date('Y-m-d H:i:s')
											);
											
						$this->db->insert('ak_harian_det',$insert_detail);
						$this->smsprivate->send_by_kelas($id_kelas,$_POST['keterangan'],'harian',$_POST['id_harian']);
				}
			}

		    $data['main']= 'akademik/kirimharian/kirimharian';
            $this->load->view('layout/ad_blank',$data);
		}
       	public function delete($id_harian=null)
        {	
			$this->load->model('ad_harian');
			$datafile=$this->ad_harian->getFileharianById_harian($id_harian);
			
			//delete file
			foreach($datafile as $datainfile){
				$this->deletefile($datainfile['id']);
			}
			
			//delete data
			//$this->db->query('DELETE FROM ak_harian_kirim WHERE id_harian='.$id_harian.'');
			if(
			$this->db->query('DELETE FROM ak_harian WHERE id='.$id_harian.'') && 
			$this->db->query('DELETE FROM ak_harian_file WHERE id_harian='.$id_harian.'') && 
			$this->db->query('DELETE FROM ak_harian_det WHERE id_harian='.$id_harian.'') &&
			$this->db->query('DELETE FROM ak_harian_det_remidial WHERE id_harian='.$id_harian.'') &&
			$this->db->query('DELETE FROM ak_pengumpulan_harian WHERE id_harian='.$id_harian.'') 
			){
				echo 1;
			}else{
				echo 0;
			}
		}
        public function uploadfileharian($id_harian)
        {
			
			if(isset($_FILES)){
			if(!empty($_FILES["file"]["error"])){
				foreach ($_FILES["file"]["error"] as $key => $error) {
					if ($error == UPLOAD_ERR_OK) {
						$name = date('Ymdhis').str_replace(" ","",$_FILES["file"]["name"][$key]);
						if(!in_array($_FILES["file"]["type"][$key], $this->denied_mime_types)){
							if(move_uploaded_file($_FILES["file"]["tmp_name"][$key], $this->upload_dir . $name)){
								$this->db->insert('ak_harian_file', array('id_harian'=>$id_harian,'file_name'=>''.$name.''));
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
        public function daftarharianlist()
        {
			$this->load->model('ad_harian');
			$harian=$this->ad_harian->getharianByKelasPelajaranIdPegawaiAll($_POST['pelajaran'],$_POST['id_kelas']);
			$terkirim=$this->ad_harian->getharianByKelasPelajaranIdPegawaiKirim($_POST['pelajaran'],$_POST['id_kelas']);
			$telahdikirim=array();
			$harian2=array();
			
			if(!empty($harian)){
				foreach($harian as $ky=>$dataharian){
					if(isset($terkirim[$dataharian['id']])){
						$telahdikirim[$dataharian['id']]=$dataharian;
						$telahdikirim[$dataharian['id']]['file']=$this->ad_harian->getFileharianByIdharian($dataharian['id']);
						$telahdikirim[$dataharian['id']]['dikirim']=$terkirim[$dataharian['id']];
					}else{
						$harian2[$ky]=$dataharian;
						$harian2[$ky]['file']=$this->ad_harian->getFileharianByIdharian($dataharian['id']);
					}
					
				}
				$harian=array_merge($telahdikirim,$harian2);
			}
			unset($harian2);
			
			$data['harian']=$harian;
			//harian($telahdikirim);
			$data['terkirim']=$telahdikirim;
			$data['id_kelas']=$_POST['id_kelas'];
			$data['main']= 'akademik/kirimharian/daftarharianlist';
            $this->load->view('layout/ad_blank',$data);	
		}
        public function daftarharian()
        {	
			$this->load->model('ad_kelas');
			$data['harian']=array();
			$data['kelas'] 	=$this->ad_kelas->getkelasByPengajar($this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['user_authentication']['id_pengguna']);
			$data['main']= 'akademik/kirimharian/daftarharian';
            $this->load->view('layout/ad_blank',$data);		
		}
        public function kirimharianutama()
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
				unset($_POST['simpanarsipharian']);
				unset($_POST['tanggal_kumpul']);
				unset($_POST['keterangan']);

				$this->db->insert('ak_harian',$_POST);
				
				$id_harian=mysql_insert_id();
				
				if(isset($postkelas) && !empty($postkelas)){
				$this->load->library('smsprivate');
				foreach($postkelas as $id_kelas){
					$insert_detail=array('id_harian'=>$id_harian,
										'id_kelas'=>$id_kelas,
										'tanggal'=>date('Y-m-d H:i:s'),
										'tanggal_kumpul'=>$tanggal_kumpul,
										'keterangan'=>$keterangan,
										'id_mengajar'=>$id_mengajar[$id_kelas]
										);
										
					$this->db->insert('ak_harian_det',$insert_detail);
					$this->smsprivate->send_by_kelas($id_kelas,$keterangan,'harian',$id_harian);
					//notifikasi
					$this->load->library('ak_notifikasi');
					$this->ak_notifikasi->set_notifikasi_akademik_per_kelas($id_kelas,$gorup_notif='harian',$_POST['id_pelajaran'],$_POST['judul'],$_POST['id_pegawai'],$keterangan,$id_harian,'harian');
					//$this->load->model('ad_notifikasi');
					//$this->ad_notifikasi->add_notif_sms_ortu_perkelas($id_kelas,$_POST['id_pelajaran'],$data=array('group'=>'harian'));
					//end notifikasi
				}
				}
				echo $id_harian;
				die();
			}
			
			$this->load->model('ad_pelajaran');
			$data['pelajaran'] 	=$this->ad_pelajaran->getdatabySemesterJenjangJurusanPegawaimengajar();
            $data['main']           = 'akademik/kirimharian/kirimharianutama';
            $this->load->view('layout/ad_blank',$data);
        }
        public function kirimharianremidial()
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
				
				$this->db->insert('ak_harian',$_POST);
				
				$id_harian=mysql_insert_id();
				if(!empty($filenamecurrent)){
					foreach($filenamecurrent as $namafile){
						$this->db->insert('ak_harian_file', array('id_harian'=>$id_harian,'file_name'=>''.$namafile.''));
					}
				}
				
					//notifikasi
					$this->load->model('ad_notifikasi');
					$this->load->library('ak_notifikasi');
					//notifikasi
				
				$insert_detailharian=array('id_harian'=>$id_harian,
										'id_kelas'=>$id_kelas,
										'tanggal'=>date('Y-m-d H:i:s'),
										'tanggal_kumpul'=>$tanggal_kumpul,
										'id_mengajar'=>$_POST['id_mengajar']
										);
										
				$this->db->insert('ak_harian_det',$insert_detailharian);
				
				foreach($siswa as $id_siswa_det_jenjang){
				$insert_detail=array('id_harian'=>$id_harian,
									'id_kelas'=>$id_kelas,
									'id_siswa_det_jenjang'=>$id_siswa_det_jenjang,
									'tanggal'=>date('Y-m-d H:i:s'),
									'tanggal_kumpul'=>$tanggal_kumpul
									);
									
				$this->db->insert('ak_harian_det_remidial',$insert_detail);
				
					//notifikasi
					//$this->ak_notifikasi->set_notifikasi_akademik_per_siswa($id_siswa,$gorup_notif='harian',$_POST['id_pelajaran'],$_POST['judul'],$_POST['id_pegawai'],$_POST['keterangan']);
					$this->ak_notifikasi->set_notifikasi_akademik_per_siswa_detjenjang($id_siswa_det_jenjang,$gorup_notif='harian',$_POST['id_pelajaran'],$_POST['judul'],$_POST['id_pegawai'],$_POST['keterangan'],$id_harian,'harian');
					//$this->ad_notifikasi->add_notif_sms_ortu_per_siswa_detjenjang($id_siswa_det_jenjang,$_POST['id_pelajaran'],$data=array('group'=>'harian'));
					//end notifikasi
				
				}
				
				echo $id_harian;
				die();
			}
			
            $data['main']           = 'akademik/kirimharian/kirimharianremidial';
            $this->load->view('layout/ad_blank',$data);
        }
        public function kirimharianremidialedit($id)
        { 
			$this->load->model('ad_harian');
			if(isset($_POST['id_pelajaran'])){
				$id_harian=$_POST['id'];
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
				$this->db->update('ak_harian',$_POST);
				$this->db->query('DELETE FROM ak_harian_det_remidial WHERE id_harian='.$id_harian.'');
				
				if(!empty($filenamecurrent)){
					foreach($filenamecurrent as $namafile){
						$this->db->insert('ak_harian_file', array('id_harian'=>$id_harian,'file_name'=>''.$namafile.''));
					}
				}
				if(!empty($siswa)){
					foreach($siswa as $id_siswa_det_jenjang){
					$insert_detail=array('id_harian'=>$id_harian,
										'id_kelas'=>$id_kelas,
										'id_siswa_det_jenjang'=>$id_siswa_det_jenjang,
										'tanggal'=>date('Y-m-d H:i:s'),
										'tanggal_kumpul'=>$tanggal_kumpul
										);
										
					$this->db->insert('ak_harian_det_remidial',$insert_detail);
					}
				}
				echo $id_harian;
				die();
			}
			$data['harian']=$this->ad_harian->getharianByIdForRemidi($id);
			$this->load->model('ad_kelas');
			$data['kelas'] 	=$this->ad_kelas->getkelasByPengajar($this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['user_authentication']['id_pengguna']);
            $data['main']           = 'akademik/kirimharian/kirimharianremidialedit';
            $this->load->view('layout/ad_blank',$data);
        } 
		
        public function deletefile($id=null)
        {	
		
			$this->load->model('ad_harian');
			$datafile=$this->ad_harian->getFileById($id);
			if(file_exists($this->upload_dir.$datafile[0]['file_name'])){
			unlink($this->upload_dir.$datafile[0]['file_name']);
			}
			$this->db->query('DELETE FROM ak_harian_file WHERE id='.$id.'');
		}
        public function getOptionFileharianByIdharian($id_harian=null)
        {
			$this->load->library('ak_harian');
			echo $this->ak_harian->createOptionFileharianByIdharian($id_harian);
		}
        public function getOptionSiswaRemidiByIdKelas($id_kelas=null,$id_harian=null)
        {
			$this->load->library('ak_harian');
			echo $this->ak_harian->createOptionSiswaRemidiByIdKelas($id_kelas,$id_harian);
		}
        public function getOptionSiswaByIdKelas($id_kelas=null)
        {
			$this->load->library('ak_siswa');
			echo $this->ak_siswa->createOptionSiswaByIdKelas($id_kelas);
		}
        public function createOptionharianByKelasPelajaranIdPegawai($id_pelajaran=null,$id_kelas=null)
        {
			$this->load->library('ak_harian');
			echo $this->ak_harian->createOptionharianByKelasPelajaranIdPegawai($id_pelajaran,$id_kelas);
		}
        public function createOptionharianRemidiEditByKelasPelajaranIdPegawai($id_pelajaran=null,$id_kelas=null,$id_parent_harian)
        {
			$this->load->library('ak_harian');
			echo $this->ak_harian->createOptionharianRemidiEditByKelasPelajaranIdPegawai($id_pelajaran,$id_kelas,$id_parent_harian);
		}
		
        public function kirimharianutamaedit($id=null)
        {
			$this->load->model('ad_kelas');
			$this->load->model('ad_pelajaran');
			$this->load->model('ad_harian');
			
			
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
				$this->db->update('ak_harian',$_POST);
				
				$id_harian=$_POST['id'];
				/*
									
				$this->db->insert('ak_harian_det',$insert_detail);*/
				
				if(isset($id_kelasarray) AND !empty($id_kelasarray)){
					foreach($id_kelasarray as $id_kelas){
						$insert_detail=array('id_harian'=>$id_harian,
										'id_kelas'=>$id_kelas,
										'tanggal'=>date('Y-m-d H:i:s'),
										'tanggal_kumpul'=>$tanggal_kumpul,
										'id_mengajar'=>$id_mengajar[$id_kelas]
										);
											
						$this->db->insert('ak_harian_det',$insert_detail);
						
						///notifikasi
						$this->load->library('ak_notifikasi');
						$this->ak_notifikasi->set_notifikasi_akademik_per_kelas($id_kelas,$gorup_notif='harian',$_POST['id_pelajaran'],$_POST['judul'],$this->session->userdata['user_authentication']['id_pengguna'],$_POST['keterangan'],$id_harian,'harian');
						//$this->load->model('ad_notifikasi');
						//$this->ad_notifikasi->add_notif_sms_ortu_perkelas($id_kelas,$_POST['id_pelajaran'],$data=array('group'=>'harian'));
						//end notifikasi
						
					}				
				}
				
				echo $id_harian;
				die();
			}else{
			
			$data['harian']=$this->ad_harian->getJustharianById($id);

			}
			
			
			$data['kelaspenerima'] 	=$this->ad_harian->getIdKelasPenerima($id);
			
			foreach($data['kelaspenerima'] as $kelaspenerimadto){
				$kelaspenerima2[$kelaspenerimadto['id']]=$kelaspenerimadto['id'];
			}
			$data['kelaspenerima2']=$kelaspenerima2;

			$data['kelas'] 	=$this->ad_kelas->getKelasByPelajaranMengajar($data['harian']['harian'][0]['id_pelajaran'],$this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['ak_setting']['semester'],$this->session->userdata['user_authentication']['id_pengguna']);
			$data['pelajaran'] 	=$this->ad_pelajaran->getdatabySemesterJenjangJurusanPegawaimengajar($this->session->userdata['ak_setting']['semester']);
			
            $data['main']           = 'akademik/kirimharian/kirimharianutamaedit';
            $this->load->view('layout/ad_blank',$data);
        }      
		
		function makedetail(){
			$query=$this->db->query('SELECT * FROM ak_harian');
			//echo $this->db->last_query();
			$data=$query->result_array();
			foreach($data as $dataharian){
				$insert_detail=array(
								'id_harian'=>$dataharian['id'],
								'id_kelas'=>$dataharian['id_kelass'],
								'tanggal'=>$dataharian['tanggal_buat'],
								'tanggal_kumpul'=>$dataharian['tanggal_kumpul'],
								'id_mengajar'=>$dataharian['id_mengajar']
				);
				//$this->db->insert('ak_harian_det',$insert_detail);
			}
		}
    }
?>