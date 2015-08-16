<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Kirimuas extends CI_Controller
    {
		var $upload_dir='upload/akademik/uas/';
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
		public function getUasStok($id_pelajaran)
        { 
			
			$this->load->model('ad_uas');
			$uas =$this->ad_uas->getUasStok($id_pelajaran);
			if(empty($uas)){
				echo '<option value="">PR TIDAK TERSEDIA</option>';
			}else{
				echo '<option value="">Pilih PR</option>';
				foreach($uas as $duas){
					echo '<option value="'.$duas['id'].'">'.$duas['judul'].'</option>';
				}
			}
			
		}
		public function kirimuasnya()
        { 
			//$this->load->model('ad_kelas');
			$this->load->model('ad_pelajaran');
			//$data['kelas'] 	=$this->ad_kelas->getkelasByPengajar($this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['user_authentication']['id_pengguna']);
			$data['pelajaran'] 	=$this->ad_pelajaran->getdatabySemesterJenjangJurusanPegawaimengajar();
			if($_POST['id_kelas']){
				$this->load->library('smsprivate');
				foreach($_POST['id_kelas'] as $idm => $id_kelas){
						$insert_detail=array('id_uas'=>$_POST['id_uas'],
											 'id_kelas'=>$id_kelas,
											 'id_mengajar'=>$_POST['id_mengajar'][$idm],
											 'tanggal_kumpul'=>$_POST['tanggal_kumpul'],
											 'keterangan'=>$_POST['keterangan'],
											 'tanggal'=>date('Y-m-d H:i:s')
											);
											
						$this->db->insert('ak_uas_det',$insert_detail);
						
						//notifikasi
						$this->load->library('ak_notifikasi');
						$this->ak_notifikasi->set_notifikasi_akademik_per_kelas($id_kelas,$gorup_notif='uas',$_POST['id_pelajaran'],$_POST['judul'],$this->session->userdata['user_authentication']['id_pengguna'],$_POST['keterangan'],$_POST['id_uas'],'uas');
						
						$this->smsprivate->send_by_kelas($id_kelas,$_POST['keterangan'],'uas',$_POST['id_uas']);
				}
			}

		    $data['main']= 'akademik/kirimuas/kirimuas';
            $this->load->view('layout/ad_blank',$data);
		}
       	public function delete($id_uas=null)
        {	
			$this->load->model('ad_uas');
			$datafile=$this->ad_uas->getFileUasById_uas($id_uas);
			
			//delete file
			foreach($datafile as $datainfile){
				$this->deletefile($datainfile['id']);
			}
			
			//delete data
			//$this->db->query('DELETE FROM ak_uas_kirim WHERE id_uas='.$id_uas.'');
			if(
			$this->db->query('DELETE FROM ak_uas WHERE id='.$id_uas.'') && 
			$this->db->query('DELETE FROM ak_uas_file WHERE id_uas='.$id_uas.'') && 
			$this->db->query('DELETE FROM ak_uas_det WHERE id_uas='.$id_uas.'') &&
			$this->db->query('DELETE FROM ak_uas_det_remidial WHERE id_uas='.$id_uas.'') &&
			$this->db->query('DELETE FROM ak_pengumpulan_uas WHERE id_uas='.$id_uas.'') 
			){
				echo 1;
			}else{
				echo 0;
			}
		}
        public function uploadfileuas($id_uas)
        {
			
			if(isset($_FILES)){
				if(!empty($_FILES["file"]["error"])){
					foreach ($_FILES["file"]["error"] as $key => $error) {
						if ($error == UPLOAD_ERR_OK) {
							$name = date('Ymdhis').str_replace(" ","",$_FILES["file"]["name"][$key]);
							if(!in_array($_FILES["file"]["type"][$key], $this->denied_mime_types)){
								if(move_uploaded_file($_FILES["file"]["tmp_name"][$key], $this->upload_dir . $name)){
									$this->db->insert('ak_uas_file', array('id_uas'=>$id_uas,'file_name'=>''.$name.''));
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
        public function daftaruaslist($pelajaran=0,$id_kelas=0,$start=0,$page=0,$id_pengguna=0,$kepsek='')
        {
			
			if($start==1){$start=0;}
			if(isset($_POST['kepsek'])){$kepsek=$_POST['kepsek'];}
			if(isset($_POST['id_pengguna'])){$id_pengguna=$_POST['id_pengguna'];}
			$data['kepsek']   = $kepsek;
			$data['page']   = $page;
			$data['id_pengguna']   = $id_pengguna;
			
			$this->load->model('ad_uas');
			
			if(isset($_POST['pelajaran'])){$pelajaran=$_POST['pelajaran'];}
			if(isset($_POST['id_kelas'])){$id_kelas=$_POST['id_kelas'];}
			
			$this->load->library('pagination');
			$config['base_url']   = site_url('akademik/kirimuas/daftaruaslist/'.$pelajaran.'/'.$id_kelas.'');
			$config['per_page'] = $data['per_page'] = 10;
			//$config['uri_segment']   = 5;
			$config['cur_page']   = $start;
			$data['cur_page']   = $page;
			$data['start'] = $start;
			
			$config['total_rows'] = $this->ad_uas->getUasByKelasPelajaranIdPegawaiAllCount($pelajaran,$id_kelas,$id_pengguna);
			//pr($config['total_rows']);
			//uas($config['total_rows']);

			$uas=$this->ad_uas->getUasByKelasPelajaranIdPegawaiAll($pelajaran,$id_kelas,$start,$config['per_page'],$id_pengguna);

			$id_uassemua = @array_map(function($var){ return $var['id']; }, $uas);
			$terkirim=$this->ad_uas->getuasByKelasPelajaranIdPegawaiKirim($pelajaran,$id_kelas,$id_uassemua,$start,$config['per_page'],$id_pengguna);
			$this->pagination->initialize($config);
			$data['link'] = $this->pagination->create_links();
			$telahdikirim=array();
			$uas2=array();

			if(!empty($uas)){
				
				//file uas
				$fileuas=$this->ad_uas->getFileUasInId($id_uassemua);
				foreach($uas as $ky=>$datauas){
					if(isset($terkirim[$datauas['id']])){
						$telahdikirim[$datauas['id']]=$datauas;
						foreach($fileuas as $dtfile){
							if($dtfile['id_uas']==$datauas['id']){
								$telahdikirim[$datauas['id']]['file'][]=$dtfile;
							}
						}
						$telahdikirim[$datauas['id']]['dikirim']=$terkirim[$datauas['id']];
					}else{
						$uas2[$ky]=$datauas;
						foreach($fileuas as $dtfile){
							if($dtfile['id_uas']==$datauas['id']){
								$uas2[$ky]['file'][]=$dtfile;
							}
						}
					}
					
					
				}
				$uas=array_merge($telahdikirim,$uas2);
			}
			unset($uas2);
			
			$data['uas']=$uas;
			//uas($uas);
			$data['terkirim']=$telahdikirim;
			$data['id_kelas']=$_POST['id_kelas'];
			$data['main']= 'akademik/kirimuas/daftaruaslist';
            $this->load->view('layout/ad_blank',$data);	
		}
        public function daftaruas()
        {	
			$this->load->model('ad_kelas');
			$data['uas']=array();
			$data['kelas'] 	=$this->ad_kelas->getkelasByPengajar($this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['user_authentication']['id_pengguna']);
			$data['main']= 'akademik/kirimuas/daftaruas';
            $this->load->view('layout/ad_blank',$data);		
		}
        public function kirimuasutama()
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
				unset($_POST['simpanarsipuas']);
				unset($_POST['tanggal_kumpul']);
				unset($_POST['keterangan']);
				$save=$_POST;
				unset($save[$this->config->item('csrf_token_name')]);			
				$this->db->insert('ak_uas',$save);
				
				$id_uas=mysql_insert_id();
				
				if(isset($postkelas) && !empty($postkelas)){
				$this->load->library('smsprivate');
				foreach($postkelas as $id_kelas){
					$insert_detail=array('id_uas'=>$id_uas,
										'id_kelas'=>$id_kelas,
										'tanggal'=>date('Y-m-d H:i:s'),
										'tanggal_kumpul'=>$tanggal_kumpul,
										'keterangan'=>$keterangan,
										'id_mengajar'=>$id_mengajar[$id_kelas]
										);
										
					$this->db->insert('ak_uas_det',$insert_detail);
					$this->smsprivate->send_by_kelas($id_kelas,$keterangan,'uas',$id_uas);
					//notifikasi
					$this->load->library('ak_notifikasi');
					$this->ak_notifikasi->set_notifikasi_akademik_per_kelas($id_kelas,$gorup_notif='uas',$_POST['id_pelajaran'],$_POST['judul'],$_POST['id_pegawai'],$keterangan,$id_uas,'uas');
					//$this->load->model('ad_notifikasi');
					//$this->ad_notifikasi->add_notif_sms_ortu_perkelas($id_kelas,$_POST['id_pelajaran'],$data=array('group'=>'uas'));
					//end notifikasi
				}
				}
				echo $id_uas;
				die();
			}
			
			$this->load->model('ad_pelajaran');
			$data['pelajaran'] 	=$this->ad_pelajaran->getdatabySemesterJenjangJurusanPegawaimengajar();
            $data['main']           = 'akademik/kirimuas/kirimuasutama';
            $this->load->view('layout/ad_blank',$data);
        }
        public function kirimuasremidial()
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
				unset($save[$this->config->item('csrf_token_name')]);					
				$this->db->insert('ak_uas',$save);
				
				$id_uas=mysql_insert_id();
				if(!empty($filenamecurrent)){
					foreach($filenamecurrent as $namafile){
						$this->db->insert('ak_uas_file', array('id_uas'=>$id_uas,'file_name'=>''.$namafile.''));
					}
				}
				
					//notifikasi
					$this->load->model('ad_notifikasi');
					$this->load->library('ak_notifikasi');
					//notifikasi
				
				$insert_detailuas=array('id_uas'=>$id_uas,
										'id_kelas'=>$id_kelas,
										'tanggal'=>date('Y-m-d H:i:s'),
										'tanggal_kumpul'=>$tanggal_kumpul,
										'id_mengajar'=>$_POST['id_mengajar']
										);
										
				$this->db->insert('ak_uas_det',$insert_detailuas);
				
				foreach($siswa as $id_siswa_det_jenjang){
				$insert_detail=array('id_uas'=>$id_uas,
									'id_kelas'=>$id_kelas,
									'id_siswa_det_jenjang'=>$id_siswa_det_jenjang,
									'tanggal'=>date('Y-m-d H:i:s'),
									'tanggal_kumpul'=>$tanggal_kumpul
									);
									
				$this->db->insert('ak_uas_det_remidial',$insert_detail);
				
					//notifikasi
					//$this->ak_notifikasi->set_notifikasi_akademik_per_siswa($id_siswa,$gorup_notif='uas',$_POST['id_pelajaran'],$_POST['judul'],$_POST['id_pegawai'],$_POST['keterangan']);
					$this->ak_notifikasi->set_notifikasi_akademik_per_siswa_detjenjang($id_siswa_det_jenjang,$gorup_notif='uas',$_POST['id_pelajaran'],$_POST['judul'],$_POST['id_pegawai'],$_POST['keterangan'],$id_uas,'uas');
					//$this->ad_notifikasi->add_notif_sms_ortu_per_siswa_detjenjang($id_siswa_det_jenjang,$_POST['id_pelajaran'],$data=array('group'=>'uas'));
					//end notifikasi
				
				}
				
				echo $id_uas;
				die();
			}
			
            $data['main']           = 'akademik/kirimuas/kirimuasremidial';
            $this->load->view('layout/ad_blank',$data);
        }
        public function kirimuasremidialedit($id)
        { 
			$this->load->model('ad_uas');
			if(isset($_POST['id_pelajaran'])){
				$id_uas=$_POST['id'];
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
				unset($save[$this->config->item('csrf_token_name')]);					
				$this->db->where('id',$_POST['id']);
				$this->db->update('ak_uas',$save);
				$this->db->query('DELETE FROM ak_uas_det_remidial WHERE id_uas='.$id_uas.'');
				
				if(!empty($filenamecurrent)){
					foreach($filenamecurrent as $namafile){
						$this->db->insert('ak_uas_file', array('id_uas'=>$id_uas,'file_name'=>''.$namafile.''));
					}
				}
				if(!empty($siswa)){
					foreach($siswa as $id_siswa_det_jenjang){
					$insert_detail=array('id_uas'=>$id_uas,
										'id_kelas'=>$id_kelas,
										'id_siswa_det_jenjang'=>$id_siswa_det_jenjang,
										'tanggal'=>date('Y-m-d H:i:s'),
										'tanggal_kumpul'=>$tanggal_kumpul
										);
										
					$this->db->insert('ak_uas_det_remidial',$insert_detail);
					}
				}
				echo $id_uas;
				die();
			}
			$data['uas']=$this->ad_uas->getUasByIdForRemidi($id);
			$this->load->model('ad_kelas');
			$data['kelas'] 	=$this->ad_kelas->getkelasByPengajar($this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['user_authentication']['id_pengguna']);
            $data['main']           = 'akademik/kirimuas/kirimuasremidialedit';
            $this->load->view('layout/ad_blank',$data);
        } 
		
        public function deletefile($id=null)
        {	
		
			$this->load->model('ad_uas');
			$datafile=$this->ad_uas->getFileById($id);
			if(file_exists($this->upload_dir.$datafile[0]['file_name'])){
			unlink($this->upload_dir.$datafile[0]['file_name']);
			}
			$this->db->query('DELETE FROM ak_uas_file WHERE id='.$id.'');
		}
        public function getOptionFileUasByIdUas($id_uas=null)
        {
			$this->load->library('ak_uas');
			echo $this->ak_uas->createOptionFileUasByIdUas($id_uas);
		}
        public function getOptionSiswaRemidiByIdKelas($id_kelas=null,$id_uas=null)
        {
			$this->load->library('ak_uas');
			echo $this->ak_uas->createOptionSiswaRemidiByIdKelas($id_kelas,$id_uas);
		}
        public function getOptionSiswaByIdKelas($id_kelas=null)
        {
			$this->load->library('ak_siswa');
			echo $this->ak_siswa->createOptionSiswaByIdKelas($id_kelas);
		}
        public function createOptionUasByKelasPelajaranIdPegawai($id_pelajaran=null,$id_kelas=null)
        {
			$this->load->library('ak_uas');
			echo $this->ak_uas->createOptionUasByKelasPelajaranIdPegawai($id_pelajaran,$id_kelas);
		}
        public function createOptionUasRemidiEditByKelasPelajaranIdPegawai($id_pelajaran=null,$id_kelas=null,$id_parent_uas)
        {
			$this->load->library('ak_uas');
			echo $this->ak_uas->createOptionUasRemidiEditByKelasPelajaranIdPegawai($id_pelajaran,$id_kelas,$id_parent_uas);
		}
		
        public function kirimuasutamaedit($id=null)
        {
			$this->load->model('ad_kelas');
			$this->load->model('ad_pelajaran');
			$this->load->model('ad_uas');
			
			
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
				unset($save[$this->config->item('csrf_token_name')]);							
				$this->db->where('id',$_POST['id']);
				$this->db->update('ak_uas',$save);
				
				$id_uas=$_POST['id'];
				/*
									
				$this->db->insert('ak_uas_det',$insert_detail);*/
				
				if(isset($id_kelasarray) AND !empty($id_kelasarray)){
					foreach($id_kelasarray as $id_kelas){
						$insert_detail=array('id_uas'=>$id_uas,
										'id_kelas'=>$id_kelas,
										'tanggal'=>date('Y-m-d H:i:s'),
										'tanggal_kumpul'=>$tanggal_kumpul,
										'id_mengajar'=>$id_mengajar[$id_kelas]
										);
											
						$this->db->insert('ak_uas_det',$insert_detail);
						
						///notifikasi
						$this->load->library('ak_notifikasi');
						$this->ak_notifikasi->set_notifikasi_akademik_per_kelas($id_kelas,$gorup_notif='uas',$_POST['id_pelajaran'],$_POST['judul'],$this->session->userdata['user_authentication']['id_pengguna'],$_POST['keterangan'],$id_uas,'uas');
						//$this->load->model('ad_notifikasi');
						//$this->ad_notifikasi->add_notif_sms_ortu_perkelas($id_kelas,$_POST['id_pelajaran'],$data=array('group'=>'uas'));
						//end notifikasi
						
					}				
				}
				
				echo $id_uas;
				die();
			}else{
			
			$data['uas']=$this->ad_uas->getJustUasById($id);

			}
			
			
			$data['kelaspenerima'] 	=$this->ad_uas->getIdKelasPenerima($id);
			
			foreach($data['kelaspenerima'] as $kelaspenerimadto){
				$kelaspenerima2[$kelaspenerimadto['id']]=$kelaspenerimadto['id'];
			}
			$data['kelaspenerima2']=$kelaspenerima2;

			$data['kelas'] 	=$this->ad_kelas->getKelasByPelajaranMengajar($data['uas']['uas'][0]['id_pelajaran'],$this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['ak_setting']['semester'],$this->session->userdata['user_authentication']['id_pengguna']);
			$data['pelajaran'] 	=$this->ad_pelajaran->getdatabySemesterJenjangJurusanPegawaimengajar($this->session->userdata['ak_setting']['semester']);
			
            $data['main']           = 'akademik/kirimuas/kirimuasutamaedit';
            $this->load->view('layout/ad_blank',$data);
        }      
		
		function makedetail(){
			$query=$this->db->query('SELECT * FROM ak_uas');
			//echo $this->db->last_query();
			$data=$query->result_array();
			foreach($data as $datauas){
				$insert_detail=array(
								'id_uas'=>$datauas['id'],
								'id_kelas'=>$datauas['id_kelass'],
								'tanggal'=>$datauas['tanggal_buat'],
								'tanggal_kumpul'=>$datauas['tanggal_kumpul'],
								'id_mengajar'=>$datauas['id_mengajar']
				);
				//$this->db->insert('ak_uas_det',$insert_detail);
			}
		}
    }
?>