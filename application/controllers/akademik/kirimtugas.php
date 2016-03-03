<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Kirimtugas extends CI_Controller
    {
		var $upload_dir='upload/akademik/tugas/';
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
		public function getTugasStok($id_pelajaran)
        { 
			
			$this->load->model('ad_tugas');
			$tugas =$this->ad_tugas->getTugasStok($id_pelajaran);
			if(empty($tugas)){
				echo '<option value="">PR TIDAK TERSEDIA</option>';
			}else{
				echo '<option value="">Pilih PR</option>';
				foreach($tugas as $dtugas){
					echo '<option value="'.$dtugas['id'].'">'.$dtugas['judul'].'</option>';
				}
			}
			
		}
		public function kirimtugasnya()
        { 
			//$this->load->model('ad_kelas');
			$this->load->model('ad_pelajaran');
			//$data['kelas'] 	=$this->ad_kelas->getkelasByPengajar($this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['user_authentication']['id_pengguna']);
			$data['pelajaran'] 	=$this->ad_pelajaran->getdatabySemesterJenjangJurusanPegawaimengajar();
			if($_POST['id_kelas']){
				$this->load->library('smsprivate');
				foreach($_POST['id_kelas'] as $idm => $id_kelas){
						$insert_detail=array('id_tugas'=>$_POST['id_tugas'],
											 'id_kelas'=>$id_kelas,
											 'id_mengajar'=>$_POST['id_mengajar'][$idm],
											 'tanggal_kumpul'=>$_POST['tanggal_kumpul'],
											 'keterangan'=>$_POST['keterangan'],
											 'tanggal'=>date('Y-m-d H:i:s')
											);
											
						$this->db->insert('ak_tugas_det',$insert_detail);
						
						//notifikasi
						$this->load->library('ak_notifikasi');
						$this->ak_notifikasi->set_notifikasi_akademik_per_kelas($id_kelas,$gorup_notif='tugas',$_POST['id_pelajaran'],$_POST['judul'],$this->session->userdata['user_authentication']['id_pengguna'],$_POST['keterangan'],$_POST['id_tugas'],'tugas');
						
						$this->smsprivate->send_by_kelas($id_kelas,$_POST['keterangan'],'tugas',$_POST['id_tugas']);
				}
			}

		    $data['main']= 'akademik/kirimtugas/kirimtugas';
            $this->load->view('layout/ad_blank',$data);
		}
       	public function delete($id_tugas=null)
        {	
			$this->load->model('ad_tugas');
			$datafile=$this->ad_tugas->getFileTugasById_tugas($id_tugas);
			
			//delete file
			foreach($datafile as $datainfile){
				$this->deletefile($datainfile['id']);
			}
			
			//delete data
			//$this->db->query('DELETE FROM ak_tugas_kirim WHERE id_tugas='.$id_tugas.'');
			if(
			$this->db->query('DELETE FROM ak_tugas WHERE id='.$id_tugas.'') && 
			$this->db->query('DELETE FROM ak_tugas_file WHERE id_tugas='.$id_tugas.'') && 
			$this->db->query('DELETE FROM ak_tugas_det WHERE id_tugas='.$id_tugas.'') &&
			$this->db->query('DELETE FROM ak_tugas_det_remidial WHERE id_tugas='.$id_tugas.'') &&
			$this->db->query('DELETE FROM ak_pengumpulan_tugas WHERE id_tugas='.$id_tugas.'') 
			){
				echo 1;
			}else{
				echo 0;
			}
		}
		public function upload($id_tugas=0)
        {
			if(isset($_POST['id_tugas']) && isset($_POST['fileName'])){
				if($this->db->insert('ak_tugas_file', array('id_tugas'=>$_POST['id_tugas'],'file_name'=>''.$_POST['fileName'].''))){
					echo 'null';
				}else{
					echo 'Gagal menyimpan data';
				}
			}
		}
        public function uploadfiletugas($id_tugas)
        {
			
			if(isset($_FILES)){
				if(!empty($_FILES["file"]["error"])){
					foreach ($_FILES["file"]["error"] as $key => $error) {
						if ($error == UPLOAD_ERR_OK) {
							$name = date('Ymdhis').str_replace(" ","",$_FILES["file"]["name"][$key]);
							if(!in_array($_FILES["file"]["type"][$key], $this->denied_mime_types)){
								if(move_uploaded_file($_FILES["file"]["tmp_name"][$key], $this->upload_dir . $name)){
									$this->db->insert('ak_tugas_file', array('id_tugas'=>$id_tugas,'file_name'=>''.$name.''));
								}
							}else{
								echo "Anda tidak diperbolehkan mengunggah file type ini. Silahkan edit data anda dan masukkan file yang benar.";
								die();
							}
						}
					}				
				}
				echo 'null';
			}

        }
        public function daftartugaslist($pelajaran=0,$id_kelas=0,$start=0,$page=0,$id_pengguna=0,$kepsek='')
        {
			
			if($start==1){$start=0;}
			if(isset($_POST['kepsek'])){$kepsek=$_POST['kepsek'];}
			if(isset($_POST['id_pengguna'])){$id_pengguna=$_POST['id_pengguna'];}
			$data['kepsek']   = $kepsek;
			$data['page']   = $page;
			$data['id_pengguna']   = $id_pengguna;
			
			$this->load->model('ad_tugas');
			
			if(isset($_POST['pelajaran'])){$pelajaran=$_POST['pelajaran'];}
			if(isset($_POST['id_kelas'])){$id_kelas=$_POST['id_kelas'];}
			
			$this->load->library('pagination');
			$config['base_url']   = site_url('akademik/kirimtugas/daftartugaslist/'.$pelajaran.'/'.$id_kelas.'');
			$config['per_page'] = $data['per_page'] = 10;
			//$config['uri_segment']   = 5;
			$config['cur_page']   = $start;
			$data['cur_page']   = $page;
			$data['start'] = $start;
			
			$config['total_rows'] = $this->ad_tugas->getTugasByKelasPelajaranIdPegawaiAllCount($pelajaran,$id_kelas,$id_pengguna);
			//pr($config['total_rows']);
			//tugas($config['total_rows']);

			$tugas=$this->ad_tugas->getTugasByKelasPelajaranIdPegawaiAll($pelajaran,$id_kelas,$start,$config['per_page'],$id_pengguna);

			$id_tugassemua = @array_map(function($var){ return $var['id']; }, $tugas);
			$terkirim=$this->ad_tugas->gettugasByKelasPelajaranIdPegawaiKirim($pelajaran,$id_kelas,$id_tugassemua,$start,$config['per_page'],$id_pengguna);
			$this->pagination->initialize($config);
			$data['link'] = $this->pagination->create_links();
			$telahdikirim=array();
			$tugas2=array();

			if(!empty($tugas)){
				
				//file tugas
				$filetugas=$this->ad_tugas->getFileTugasInId($id_tugassemua);
				foreach($tugas as $ky=>$datatugas){
					if(isset($terkirim[$datatugas['id']])){
						$telahdikirim[$datatugas['id']]=$datatugas;
						foreach($filetugas as $dtfile){
							if($dtfile['id_tugas']==$datatugas['id']){
								$telahdikirim[$datatugas['id']]['file'][]=$dtfile;
							}
						}
						$telahdikirim[$datatugas['id']]['dikirim']=$terkirim[$datatugas['id']];
					}else{
						$tugas2[$ky]=$datatugas;
						foreach($filetugas as $dtfile){
							if($dtfile['id_tugas']==$datatugas['id']){
								$tugas2[$ky]['file'][]=$dtfile;
							}
						}
					}
					
					
				}
				$tugas=array_merge($telahdikirim,$tugas2);
			}
			unset($tugas2);
			
			$data['tugas']=$tugas;
			//tugas($tugas);
			$data['terkirim']=$telahdikirim;
			$data['id_kelas']=$_POST['id_kelas'];
			$data['main']= 'akademik/kirimtugas/daftartugaslist';
            $this->load->view('layout/ad_blank',$data);	
		}
        public function daftartugas()
        {	
			$this->load->model('ad_kelas');
			$data['tugas']=array();
			$data['kelas'] 	=$this->ad_kelas->getkelasByPengajar($this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['user_authentication']['id_pengguna']);
			$data['main']= 'akademik/kirimtugas/daftartugas';
            $this->load->view('layout/ad_blank',$data);		
		}
        public function kirimtugasutama()
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
				unset($_POST['simpanarsiptugas']);
				unset($_POST['tanggal_kumpul']);
				unset($_POST['keterangan']);
				$save=$_POST;
				unset($save[$this->config->item('csrf_token_name')]);unset($save[$this->security->get_csrf_token_name()]);
				$this->db->insert('ak_tugas',$save);
				
				$id_tugas=mysql_insert_id();
				
				if(isset($postkelas) && !empty($postkelas)){
				$this->load->library('smsprivate');
				foreach($postkelas as $id_kelas){
					$insert_detail=array('id_tugas'=>$id_tugas,
										'id_kelas'=>$id_kelas,
										'tanggal'=>date('Y-m-d H:i:s'),
										'tanggal_kumpul'=>$tanggal_kumpul,
										'keterangan'=>$keterangan,
										'id_mengajar'=>$id_mengajar[$id_kelas]
										);
										
					$this->db->insert('ak_tugas_det',$insert_detail);
					$this->smsprivate->send_by_kelas($id_kelas,$keterangan,'tugas',$id_tugas);
					//notifikasi
					$this->load->library('ak_notifikasi');
					$this->ak_notifikasi->set_notifikasi_akademik_per_kelas($id_kelas,$gorup_notif='tugas',$_POST['id_pelajaran'],$_POST['judul'],$_POST['id_pegawai'],$keterangan,$id_tugas,'tugas');
					//$this->load->model('ad_notifikasi');
					//$this->ad_notifikasi->add_notif_sms_ortu_perkelas($id_kelas,$_POST['id_pelajaran'],$data=array('group'=>'tugas'));
					//end notifikasi
				}
				}
				echo $id_tugas;
				die();
			}
			
			$this->load->model('ad_pelajaran');
			$data['upload_dir'] 	=base64_encode('../../../../upload/akademik/tugas/');
			$data['pelajaran'] 	=$this->ad_pelajaran->getdatabySemesterJenjangJurusanPegawaimengajar();
            $data['main']           = 'akademik/kirimtugas/kirimtugasutama';
            $this->load->view('layout/ad_blank',$data);
        }
        public function kirimtugasremidial()
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
				$save=$_POST;
				unset($save[$this->config->item('csrf_token_name')]);unset($save[$this->security->get_csrf_token_name()]);				
				$this->db->insert('ak_tugas',$save);
				
				$id_tugas=mysql_insert_id();
				if(!empty($filenamecurrent)){
					foreach($filenamecurrent as $namafile){
						$this->db->insert('ak_tugas_file', array('id_tugas'=>$id_tugas,'file_name'=>''.$namafile.''));
					}
				}
				
					//notifikasi
					$this->load->model('ad_notifikasi');
					$this->load->library('ak_notifikasi');
					//notifikasi
				
				$insert_detailtugas=array('id_tugas'=>$id_tugas,
										'id_kelas'=>$id_kelas,
										'tanggal'=>date('Y-m-d H:i:s'),
										'tanggal_kumpul'=>$tanggal_kumpul,
										'id_mengajar'=>$_POST['id_mengajar']
										);
										
				$this->db->insert('ak_tugas_det',$insert_detailtugas);
				
				foreach($siswa as $id_siswa_det_jenjang){
				$insert_detail=array('id_tugas'=>$id_tugas,
									'id_kelas'=>$id_kelas,
									'id_siswa_det_jenjang'=>$id_siswa_det_jenjang,
									'tanggal'=>date('Y-m-d H:i:s'),
									'tanggal_kumpul'=>$tanggal_kumpul
									);
									
				$this->db->insert('ak_tugas_det_remidial',$insert_detail);
				
					//notifikasi
					//$this->ak_notifikasi->set_notifikasi_akademik_per_siswa($id_siswa,$gorup_notif='tugas',$_POST['id_pelajaran'],$_POST['judul'],$_POST['id_pegawai'],$_POST['keterangan']);
					$this->ak_notifikasi->set_notifikasi_akademik_per_siswa_detjenjang($id_siswa_det_jenjang,$gorup_notif='tugas',$_POST['id_pelajaran'],$_POST['judul'],$_POST['id_pegawai'],$_POST['keterangan'],$id_tugas,'tugas');
					//$this->ad_notifikasi->add_notif_sms_ortu_per_siswa_detjenjang($id_siswa_det_jenjang,$_POST['id_pelajaran'],$data=array('group'=>'tugas'));
					//end notifikasi
				
				}
				
				echo $id_tugas;
				die();
			}
			
            $data['main']           = 'akademik/kirimtugas/kirimtugasremidial';
            $this->load->view('layout/ad_blank',$data);
        }
        public function kirimtugasremidialedit($id)
        { 
			$this->load->model('ad_tugas');
			if(isset($_POST['id_pelajaran'])){
				$id_tugas=$_POST['id'];
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
				$save=$_POST;
				unset($save[$this->config->item('csrf_token_name')]);unset($save[$this->security->get_csrf_token_name()]);					
				$this->db->where('id',$_POST['id']);
				$this->db->update('ak_tugas',$save);
				$this->db->query('DELETE FROM ak_tugas_det_remidial WHERE id_tugas='.$id_tugas.'');
				
				if(!empty($filenamecurrent)){
					foreach($filenamecurrent as $namafile){
						$this->db->insert('ak_tugas_file', array('id_tugas'=>$id_tugas,'file_name'=>''.$namafile.''));
					}
				}
				if(!empty($siswa)){
					foreach($siswa as $id_siswa_det_jenjang){
					$insert_detail=array('id_tugas'=>$id_tugas,
										'id_kelas'=>$id_kelas,
										'id_siswa_det_jenjang'=>$id_siswa_det_jenjang,
										'tanggal'=>date('Y-m-d H:i:s'),
										'tanggal_kumpul'=>$tanggal_kumpul
										);
										
					$this->db->insert('ak_tugas_det_remidial',$insert_detail);
					}
				}
				echo $id_tugas;
				die();
			}
			$data['tugas']=$this->ad_tugas->getTugasByIdForRemidi($id);
			$this->load->model('ad_kelas');
			$data['kelas'] 	=$this->ad_kelas->getkelasByPengajar($this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['user_authentication']['id_pengguna']);
            $data['main']           = 'akademik/kirimtugas/kirimtugasremidialedit';
            $this->load->view('layout/ad_blank',$data);
        } 
		
        public function deletefile($id=null)
        {	
		
			$this->load->model('ad_tugas');
			$datafile=$this->ad_tugas->getFileById($id);
			if(file_exists($this->upload_dir.$datafile[0]['file_name'])){
			unlink($this->upload_dir.$datafile[0]['file_name']);
			}
			$this->db->query('DELETE FROM ak_tugas_file WHERE id='.$id.'');
		}
        public function getOptionFileTugasByIdTugas($id_tugas=null)
        {
			$this->load->library('ak_tugas');
			echo $this->ak_tugas->createOptionFileTugasByIdTugas($id_tugas);
		}
        public function getOptionSiswaRemidiByIdKelas($id_kelas=null,$id_tugas=null)
        {
			$this->load->library('ak_tugas');
			echo $this->ak_tugas->createOptionSiswaRemidiByIdKelas($id_kelas,$id_tugas);
		}
        public function getOptionSiswaByIdKelas($id_kelas=null)
        {
			$this->load->library('ak_siswa');
			echo $this->ak_siswa->createOptionSiswaByIdKelas($id_kelas);
		}
        public function createOptionTugasByKelasPelajaranIdPegawai($id_pelajaran=null,$id_kelas=null)
        {
			$this->load->library('ak_tugas');
			echo $this->ak_tugas->createOptionTugasByKelasPelajaranIdPegawai($id_pelajaran,$id_kelas);
		}
        public function createOptionTugasRemidiEditByKelasPelajaranIdPegawai($id_pelajaran=null,$id_kelas=null,$id_parent_tugas)
        {
			$this->load->library('ak_tugas');
			echo $this->ak_tugas->createOptionTugasRemidiEditByKelasPelajaranIdPegawai($id_pelajaran,$id_kelas,$id_parent_tugas);
		}
		
        public function kirimtugasutamaedit($id=null)
        {
			$this->load->model('ad_kelas');
			$this->load->model('ad_pelajaran');
			$this->load->model('ad_tugas');
			
			
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
				$save=$_POST;
				unset($save[$this->config->item('csrf_token_name')]);unset($save[$this->security->get_csrf_token_name()]);				
				$this->db->where('id',$_POST['id']);
				$this->db->update('ak_tugas',$save);
				
				$id_tugas=$_POST['id'];
				/*
									
				$this->db->insert('ak_tugas_det',$insert_detail);*/
				
				if(isset($id_kelasarray) AND !empty($id_kelasarray)){
					foreach($id_kelasarray as $id_kelas){
						$insert_detail=array('id_tugas'=>$id_tugas,
										'id_kelas'=>$id_kelas,
										'tanggal'=>date('Y-m-d H:i:s'),
										'tanggal_kumpul'=>$tanggal_kumpul,
										'id_mengajar'=>$id_mengajar[$id_kelas]
										);
											
						$this->db->insert('ak_tugas_det',$insert_detail);
						
						///notifikasi
						$this->load->library('ak_notifikasi');
						$this->ak_notifikasi->set_notifikasi_akademik_per_kelas($id_kelas,$gorup_notif='tugas',$_POST['id_pelajaran'],$_POST['judul'],$this->session->userdata['user_authentication']['id_pengguna'],$_POST['keterangan'],$id_tugas,'tugas');
						//$this->load->model('ad_notifikasi');
						//$this->ad_notifikasi->add_notif_sms_ortu_perkelas($id_kelas,$_POST['id_pelajaran'],$data=array('group'=>'tugas'));
						//end notifikasi
						
					}				
				}
				
				echo $id_tugas;
				die();
			}else{
			
			$data['tugas']=$this->ad_tugas->getJustTugasById($id);

			}
			
			
			$data['kelaspenerima'] 	=$this->ad_tugas->getIdKelasPenerima($id);
			
			foreach($data['kelaspenerima'] as $kelaspenerimadto){
				$kelaspenerima2[$kelaspenerimadto['id']]=$kelaspenerimadto['id'];
			}
			$data['kelaspenerima2']=$kelaspenerima2;

			$data['kelas'] 	=$this->ad_kelas->getKelasByPelajaranMengajar($data['tugas']['tugas'][0]['id_pelajaran'],$this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['ak_setting']['semester'],$this->session->userdata['user_authentication']['id_pengguna']);
			$data['pelajaran'] 	=$this->ad_pelajaran->getdatabySemesterJenjangJurusanPegawaimengajar($this->session->userdata['ak_setting']['semester']);
			
            $data['main']           = 'akademik/kirimtugas/kirimtugasutamaedit';
            $this->load->view('layout/ad_blank',$data);
        }      
		
		function makedetail(){
			$query=$this->db->query('SELECT * FROM ak_tugas');
			//echo $this->db->last_query();
			$data=$query->result_array();
			foreach($data as $datatugas){
				$insert_detail=array(
								'id_tugas'=>$datatugas['id'],
								'id_kelas'=>$datatugas['id_kelass'],
								'tanggal'=>$datatugas['tanggal_buat'],
								'tanggal_kumpul'=>$datatugas['tanggal_kumpul'],
								'id_mengajar'=>$datatugas['id_mengajar']
				);
				//$this->db->insert('ak_tugas_det',$insert_detail);
			}
		}
    }
?>