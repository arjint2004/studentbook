<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Kirimpr extends CI_Controller
    {
		var $upload_dir='upload/akademik/pr/';
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
		public function getPrStok($id_pelajaran)
        { 
			
			$this->load->model('ad_pr');
			$pr =$this->ad_pr->getPrStok($id_pelajaran);
			if(empty($pr)){
				echo '<option value="">PR TIDAK TERSEDIA</option>';
			}else{
				echo '<option value="">Pilih PR</option>';
				foreach($pr as $dpr){
					echo '<option value="'.$dpr['id'].'">'.$dpr['judul'].'</option>';
				}
			}
			
		}
		public function kirimprnya()
        { 
			//$this->load->model('ad_kelas');
			$this->load->model('ad_pelajaran');
			//$data['kelas'] 	=$this->ad_kelas->getkelasByPengajar($this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['user_authentication']['id_pengguna']);
			$data['pelajaran'] 	=$this->ad_pelajaran->getdatabySemesterJenjangJurusanPegawaimengajar();
			if($_POST['id_kelas']){
				$this->load->library('smsprivate');
				foreach($_POST['id_kelas'] as $idm => $id_kelas){
						$insert_detail=array('id_pr'=>$_POST['id_pr'],
											 'id_kelas'=>$id_kelas,
											 'id_mengajar'=>$_POST['id_mengajar'][$idm],
											 'tanggal_kumpul'=>$_POST['tanggal_kumpul'],
											 'keterangan'=>$_POST['keterangan'],
											 'tanggal'=>date('Y-m-d H:i:s')
											);
											
						$this->db->insert('ak_pr_det',$insert_detail);
						
						//notifikasi
						$this->load->library('ak_notifikasi');
						$this->ak_notifikasi->set_notifikasi_akademik_per_kelas($id_kelas,$gorup_notif='pr',$_POST['id_pelajaran'],$_POST['judul'],$this->session->userdata['user_authentication']['id_pengguna'],$_POST['keterangan'],$_POST['id_pr'],'pr');
						
						$this->smsprivate->send_by_kelas($id_kelas,$_POST['keterangan'],'pr',$_POST['id_pr']);
				}
			}

		    $data['main']= 'akademik/kirimpr/kirimpr';
            $this->load->view('layout/ad_blank',$data);
		}
       	public function delete($id_pr=null)
        {	
			$this->load->model('ad_pr');
			$datafile=$this->ad_pr->getFilePrById_pr($id_pr);
			
			//delete file
			foreach($datafile as $datainfile){
				$this->deletefile($datainfile['id']);
			}
			
			//delete data
			//$this->db->query('DELETE FROM ak_pr_kirim WHERE id_pr='.$id_pr.'');
			if(
			$this->db->query('DELETE FROM ak_pr WHERE id='.$id_pr.'') && 
			$this->db->query('DELETE FROM ak_pr_file WHERE id_pr='.$id_pr.'') && 
			$this->db->query('DELETE FROM ak_pr_det WHERE id_pr='.$id_pr.'') &&
			$this->db->query('DELETE FROM ak_pr_det_remidial WHERE id_pr='.$id_pr.'') &&
			$this->db->query('DELETE FROM ak_pengumpulan_pr WHERE id_pr='.$id_pr.'') 
			){
				echo 1;
			}else{
				echo 0;
			}
		}
        public function uploadfilepr($id_pr)
        {
			
			if(isset($_FILES)){
				if(!empty($_FILES["file"]["error"])){
					foreach ($_FILES["file"]["error"] as $key => $error) {
						if ($error == UPLOAD_ERR_OK) {
							$name = date('Ymdhis').str_replace(" ","",$_FILES["file"]["name"][$key]);
							if(!in_array($_FILES["file"]["type"][$key], $this->denied_mime_types)){
								if(move_uploaded_file($_FILES["file"]["tmp_name"][$key], $this->upload_dir . $name)){
									$this->db->insert('ak_pr_file', array('id_pr'=>$id_pr,'file_name'=>''.$name.''));
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
        public function daftarprlist($pelajaran=0,$id_kelas=0,$start=0,$page=0,$id_pengguna=0,$kepsek='')
        {
			
			if($start==1){$start=0;}
			if(isset($_POST['kepsek'])){$kepsek=$_POST['kepsek'];}
			if(isset($_POST['id_pengguna'])){$id_pengguna=$_POST['id_pengguna'];}
			$data['kepsek']   = $kepsek;
			$data['page']   = $page;
			$data['id_pengguna']   = $id_pengguna;
			
			$this->load->model('ad_pr');
			
			if(isset($_POST['pelajaran'])){$pelajaran=$_POST['pelajaran'];}
			if(isset($_POST['id_kelas'])){$id_kelas=$_POST['id_kelas'];}
			
			$this->load->library('pagination');
			$config['base_url']   = site_url('akademik/kirimpr/daftarprlist/'.$pelajaran.'/'.$id_kelas.'');
			$config['per_page'] = $data['per_page'] = 10;
			//$config['uri_segment']   = 5;
			$config['cur_page']   = $start;
			$data['cur_page']   = $page;
			$data['start'] = $start;
			
			$config['total_rows'] = $this->ad_pr->getPrByKelasPelajaranIdPegawaiAllCount($pelajaran,$id_kelas,$id_pengguna);
			//pr($config['total_rows']);
			//pr($config['total_rows']);

			$pr=$this->ad_pr->getPrByKelasPelajaranIdPegawaiAll($pelajaran,$id_kelas,$start,$config['per_page'],$id_pengguna);

			$id_prsemua = @array_map(function($var){ return $var['id']; }, $pr);
			$terkirim=$this->ad_pr->getprByKelasPelajaranIdPegawaiKirim($pelajaran,$id_kelas,$id_prsemua,$start,$config['per_page'],$id_pengguna);
			$this->pagination->initialize($config);
			$data['link'] = $this->pagination->create_links();
			$telahdikirim=array();
			$pr2=array();

			if(!empty($pr)){
				
				//file pr
				$filepr=$this->ad_pr->getFilePrInId($id_prsemua);
				foreach($pr as $ky=>$datapr){
					if(isset($terkirim[$datapr['id']])){
						$telahdikirim[$datapr['id']]=$datapr;
						foreach($filepr as $dtfile){
							if($dtfile['id_pr']==$datapr['id']){
								$telahdikirim[$datapr['id']]['file'][]=$dtfile;
							}
						}
						$telahdikirim[$datapr['id']]['dikirim']=$terkirim[$datapr['id']];
					}else{
						$pr2[$ky]=$datapr;
						foreach($filepr as $dtfile){
							if($dtfile['id_pr']==$datapr['id']){
								$pr2[$ky]['file'][]=$dtfile;
							}
						}
					}
					
					
				}
				$pr=array_merge($telahdikirim,$pr2);
			}
			unset($pr2);
			
			$data['pr']=$pr;
			//pr($pr);
			$data['terkirim']=$telahdikirim;
			$data['id_kelas']=$_POST['id_kelas'];
			$data['main']= 'akademik/kirimpr/daftarprlist';
            $this->load->view('layout/ad_blank',$data);	
		}
        public function daftarpr()
        {	
			$this->load->model('ad_kelas');
			$data['pr']=array();
			$data['kelas'] 	=$this->ad_kelas->getkelasByPengajar($this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['user_authentication']['id_pengguna']);
			$data['main']= 'akademik/kirimpr/daftarpr';
            $this->load->view('layout/ad_blank',$data);		
		}
        public function kirimprutama()
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
				unset($_POST['simpanarsippr']);
				unset($_POST['tanggal_kumpul']);
				unset($_POST['keterangan']);

				$this->db->insert('ak_pr',$_POST);
				
				$id_pr=mysql_insert_id();
				
				if(isset($postkelas) && !empty($postkelas)){
				$this->load->library('smsprivate');
				foreach($postkelas as $id_kelas){
					$insert_detail=array('id_pr'=>$id_pr,
										'id_kelas'=>$id_kelas,
										'tanggal'=>date('Y-m-d H:i:s'),
										'tanggal_kumpul'=>$tanggal_kumpul,
										'keterangan'=>$keterangan,
										'id_mengajar'=>$id_mengajar[$id_kelas]
										);
										
					$this->db->insert('ak_pr_det',$insert_detail);
					$this->smsprivate->send_by_kelas($id_kelas,$keterangan,'pr',$id_pr);
					//notifikasi
					$this->load->library('ak_notifikasi');
					$this->ak_notifikasi->set_notifikasi_akademik_per_kelas($id_kelas,$gorup_notif='pr',$_POST['id_pelajaran'],$_POST['judul'],$_POST['id_pegawai'],$keterangan,$id_pr,'pr');
					//$this->load->model('ad_notifikasi');
					//$this->ad_notifikasi->add_notif_sms_ortu_perkelas($id_kelas,$_POST['id_pelajaran'],$data=array('group'=>'pr'));
					//end notifikasi
				}
				}
				echo $id_pr;
				die();
			}
			
			$this->load->model('ad_pelajaran');
			$data['pelajaran'] 	=$this->ad_pelajaran->getdatabySemesterJenjangJurusanPegawaimengajar();
            $data['main']           = 'akademik/kirimpr/kirimprutama';
            $this->load->view('layout/ad_blank',$data);
        }
        public function kirimprremidial()
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
				
				$this->db->insert('ak_pr',$_POST);
				
				$id_pr=mysql_insert_id();
				if(!empty($filenamecurrent)){
					foreach($filenamecurrent as $namafile){
						$this->db->insert('ak_pr_file', array('id_pr'=>$id_pr,'file_name'=>''.$namafile.''));
					}
				}
				
					//notifikasi
					$this->load->model('ad_notifikasi');
					$this->load->library('ak_notifikasi');
					//notifikasi
				
				$insert_detailpr=array('id_pr'=>$id_pr,
										'id_kelas'=>$id_kelas,
										'tanggal'=>date('Y-m-d H:i:s'),
										'tanggal_kumpul'=>$tanggal_kumpul,
										'id_mengajar'=>$_POST['id_mengajar']
										);
										
				$this->db->insert('ak_pr_det',$insert_detailpr);
				
				foreach($siswa as $id_siswa_det_jenjang){
				$insert_detail=array('id_pr'=>$id_pr,
									'id_kelas'=>$id_kelas,
									'id_siswa_det_jenjang'=>$id_siswa_det_jenjang,
									'tanggal'=>date('Y-m-d H:i:s'),
									'tanggal_kumpul'=>$tanggal_kumpul
									);
									
				$this->db->insert('ak_pr_det_remidial',$insert_detail);
				
					//notifikasi
					//$this->ak_notifikasi->set_notifikasi_akademik_per_siswa($id_siswa,$gorup_notif='pr',$_POST['id_pelajaran'],$_POST['judul'],$_POST['id_pegawai'],$_POST['keterangan']);
					$this->ak_notifikasi->set_notifikasi_akademik_per_siswa_detjenjang($id_siswa_det_jenjang,$gorup_notif='pr',$_POST['id_pelajaran'],$_POST['judul'],$_POST['id_pegawai'],$_POST['keterangan'],$id_pr,'pr');
					//$this->ad_notifikasi->add_notif_sms_ortu_per_siswa_detjenjang($id_siswa_det_jenjang,$_POST['id_pelajaran'],$data=array('group'=>'pr'));
					//end notifikasi
				
				}
				
				echo $id_pr;
				die();
			}
			
            $data['main']           = 'akademik/kirimpr/kirimprremidial';
            $this->load->view('layout/ad_blank',$data);
        }
        public function kirimprremidialedit($id)
        { 
			$this->load->model('ad_pr');
			if(isset($_POST['id_pelajaran'])){
				$id_pr=$_POST['id'];
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
				$this->db->update('ak_pr',$_POST);
				$this->db->query('DELETE FROM ak_pr_det_remidial WHERE id_pr='.$id_pr.'');
				
				if(!empty($filenamecurrent)){
					foreach($filenamecurrent as $namafile){
						$this->db->insert('ak_pr_file', array('id_pr'=>$id_pr,'file_name'=>''.$namafile.''));
					}
				}
				if(!empty($siswa)){
					foreach($siswa as $id_siswa_det_jenjang){
					$insert_detail=array('id_pr'=>$id_pr,
										'id_kelas'=>$id_kelas,
										'id_siswa_det_jenjang'=>$id_siswa_det_jenjang,
										'tanggal'=>date('Y-m-d H:i:s'),
										'tanggal_kumpul'=>$tanggal_kumpul
										);
										
					$this->db->insert('ak_pr_det_remidial',$insert_detail);
					}
				}
				echo $id_pr;
				die();
			}
			$data['pr']=$this->ad_pr->getPrByIdForRemidi($id);
			$this->load->model('ad_kelas');
			$data['kelas'] 	=$this->ad_kelas->getkelasByPengajar($this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['user_authentication']['id_pengguna']);
            $data['main']           = 'akademik/kirimpr/kirimprremidialedit';
            $this->load->view('layout/ad_blank',$data);
        } 
		
        public function deletefile($id=null)
        {	
		
			$this->load->model('ad_pr');
			$datafile=$this->ad_pr->getFileById($id);
			if(file_exists($this->upload_dir.$datafile[0]['file_name'])){
			unlink($this->upload_dir.$datafile[0]['file_name']);
			}
			$this->db->query('DELETE FROM ak_pr_file WHERE id='.$id.'');
		}
        public function getOptionFilePrByIdPr($id_pr=null)
        {
			$this->load->library('ak_pr');
			echo $this->ak_pr->createOptionFilePrByIdPr($id_pr);
		}
        public function getOptionSiswaRemidiByIdKelas($id_kelas=null,$id_pr=null)
        {
			$this->load->library('ak_pr');
			echo $this->ak_pr->createOptionSiswaRemidiByIdKelas($id_kelas,$id_pr);
		}
        public function getOptionSiswaByIdKelas($id_kelas=null)
        {
			$this->load->library('ak_siswa');
			echo $this->ak_siswa->createOptionSiswaByIdKelas($id_kelas);
		}
        public function createOptionPrByKelasPelajaranIdPegawai($id_pelajaran=null,$id_kelas=null)
        {
			$this->load->library('ak_pr');
			echo $this->ak_pr->createOptionPrByKelasPelajaranIdPegawai($id_pelajaran,$id_kelas);
		}
        public function createOptionPrRemidiEditByKelasPelajaranIdPegawai($id_pelajaran=null,$id_kelas=null,$id_parent_pr)
        {
			$this->load->library('ak_pr');
			echo $this->ak_pr->createOptionPrRemidiEditByKelasPelajaranIdPegawai($id_pelajaran,$id_kelas,$id_parent_pr);
		}
		
        public function kirimprutamaedit($id=null)
        {
			$this->load->model('ad_kelas');
			$this->load->model('ad_pelajaran');
			$this->load->model('ad_pr');
			
			
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
				$this->db->update('ak_pr',$_POST);
				
				$id_pr=$_POST['id'];
				/*
									
				$this->db->insert('ak_pr_det',$insert_detail);*/
				
				if(isset($id_kelasarray) AND !empty($id_kelasarray)){
					foreach($id_kelasarray as $id_kelas){
						$insert_detail=array('id_pr'=>$id_pr,
										'id_kelas'=>$id_kelas,
										'tanggal'=>date('Y-m-d H:i:s'),
										'tanggal_kumpul'=>$tanggal_kumpul,
										'id_mengajar'=>$id_mengajar[$id_kelas]
										);
											
						$this->db->insert('ak_pr_det',$insert_detail);
						
						///notifikasi
						$this->load->library('ak_notifikasi');
						$this->ak_notifikasi->set_notifikasi_akademik_per_kelas($id_kelas,$gorup_notif='pr',$_POST['id_pelajaran'],$_POST['judul'],$this->session->userdata['user_authentication']['id_pengguna'],$_POST['keterangan'],$id_pr,'pr');
						//$this->load->model('ad_notifikasi');
						//$this->ad_notifikasi->add_notif_sms_ortu_perkelas($id_kelas,$_POST['id_pelajaran'],$data=array('group'=>'pr'));
						//end notifikasi
						
					}				
				}
				
				echo $id_pr;
				die();
			}else{
			
			$data['pr']=$this->ad_pr->getJustPrById($id);

			}
			
			
			$data['kelaspenerima'] 	=$this->ad_pr->getIdKelasPenerima($id);
			
			foreach($data['kelaspenerima'] as $kelaspenerimadto){
				$kelaspenerima2[$kelaspenerimadto['id']]=$kelaspenerimadto['id'];
			}
			$data['kelaspenerima2']=$kelaspenerima2;

			$data['kelas'] 	=$this->ad_kelas->getKelasByPelajaranMengajar($data['pr']['pr'][0]['id_pelajaran'],$this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['ak_setting']['semester'],$this->session->userdata['user_authentication']['id_pengguna']);
			$data['pelajaran'] 	=$this->ad_pelajaran->getdatabySemesterJenjangJurusanPegawaimengajar($this->session->userdata['ak_setting']['semester']);
			
            $data['main']           = 'akademik/kirimpr/kirimprutamaedit';
            $this->load->view('layout/ad_blank',$data);
        }      
		
		function makedetail(){
			$query=$this->db->query('SELECT * FROM ak_pr');
			//echo $this->db->last_query();
			$data=$query->result_array();
			foreach($data as $datapr){
				$insert_detail=array(
								'id_pr'=>$datapr['id'],
								'id_kelas'=>$datapr['id_kelass'],
								'tanggal'=>$datapr['tanggal_buat'],
								'tanggal_kumpul'=>$datapr['tanggal_kumpul'],
								'id_mengajar'=>$datapr['id_mengajar']
				);
				//$this->db->insert('ak_pr_det',$insert_detail);
			}
		}
    }
?>