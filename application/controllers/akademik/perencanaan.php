<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Perencanaan extends CI_Controller
    {
		var $upload_dirpembelajaran='upload/akademik/rencana_pembelajaran/';
		var $upload_dirtimelinepembelajaran='upload/akademik/timeline_pembelajaran/';
		public $denied_mime_types = array('application/x-php','application/x-httpd-php', 'text/html', 'text/css', 'text/javascript'); //array of denied mime types used when check_file_type is set to denied
        public function __construct()
        {
            parent::__construct();
            $this->load->helper('global');
            $this->load->library('session');
            $this->load->library('auth');
            $this->auth->user_logged_in();
        }
		
        //AREA PERENCANAAN PEMBELAJARAN 
        public function pembelajaran(){
			$this->load->model('ad_kelas');
			$data['pembelajaran']=array();
			$data['kelas'] 	=$this->ad_kelas->getkelasByPengajar($this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['user_authentication']['id_pengguna']);
            $data['main']= 'akademik/perencanaan/pembelajaran';
            $this->load->view('layout/ad_blank',$data);
        }
        
        public function pertemuan(){
			$this->load->model('ad_kelas');
			$data['pembelajaran']=array();
			$data['kelas'] 	=$this->ad_kelas->getkelasByPengajar($this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['user_authentication']['id_pengguna']);
            $data['main']= 'akademik/perencanaan/pertemuan';
            $this->load->view('layout/ad_blank',$data);
        }
		
        public function pertemuanlist(){

			$this->load->model('ad_pembelajaran');
			$data['pertemuan']=$this->ad_pembelajaran->getWaktuPembelajaranByKelasPelajaranIdPegawai($_POST['pelajaran'],$_POST['id_kelas']);
            $data['main']= 'akademik/perencanaan/pertemuanlist';
            $this->load->view('layout/ad_blank',$data);
        }
		public function pembelajaranlist($id_pertemuan=0,$id_pegawai=0){
			$this->load->model('ad_pembelajaran');
			if($id_pertemuan!=0){
				$data['pembelajaran']=$this->ad_pembelajaran->getPembelajaranByKelasPelajaranIdPegawaiIdPertemuan($_POST['pelajaran'],$_POST['id_kelas'],$id_pertemuan);
			}else{
				$data['pembelajaran']=$this->ad_pembelajaran->getPembelajaranByKelasPelajaranIdPegawai($_POST['pelajaran'],$_POST['id_kelas'],$id_pegawai);
			}
            $data['main']= 'akademik/perencanaan/pembelajaranlist';
			
            $this->load->view('layout/ad_blank',$data);
        }
		public function deletepert($id=null)
        {	
			$this->load->model('ad_pembelajaran');
			$pembelajarandata=$this->ad_pembelajaran->getFilePembById_pertemuan($id);
			if($this->db->query('DELETE FROM ak_rencana_pertemuan WHERE id='.$id.'')){
				foreach($pembelajarandata as $pembdata){
					$this->deletepemb($pembdata['id']);
				}
				echo 1;
			}else{
				echo 0;
			}
		}
		public function deletefilepemb($id=null)
        {	
		
			$this->load->model('ad_pembelajaran');
			$datafile=$this->ad_pembelajaran->getFilePembById($id);
			//pr($datafile);
			if($this->db->query('DELETE FROM ak_rencana_pembelajaran_file WHERE id='.$id.'')){
				if(file_exists($this->upload_dirpembelajaran.$datafile[0]['file_name'])){
					unlink($this->upload_dirpembelajaran.$datafile[0]['file_name']);
				}
			}
		}
		public function deletetime($id_time=null)
        {	
			$this->load->model('ad_timelinepembelajaran');
			$datafile=$this->ad_timelinepembelajaran->getFileTimeById_time($id_time);
			
			//delete file
			foreach($datafile as $datainfile){
				$this->deletefiletimelinepemb($datainfile['id']);
			}
			
			//delete data
			
			if($this->db->query('DELETE FROM ak_timeline_pembelajaran_file WHERE id='.$id_time.'')){
				echo 1;
			}else{
				echo 0;
			}
		}
		public function deletepemb($id_pemb=null)
        {	
			$this->load->model('ad_pembelajaran');
			$datafile=$this->ad_pembelajaran->getFilePembById_pemb($id_pemb);
			
			//delete file
			foreach($datafile as $datainfile){
				$this->deletefilepemb($datainfile['id']);
			}
			
			//delete data
			
			if($this->db->query('DELETE FROM ak_rencana_pembelajaran WHERE id='.$id_pemb.'')){
				echo 1;
			}else{
				echo 0;
			}
		}
		public function uploadpembelajaran($id_pembelajaran)
        {
			
			
			if(isset($_FILES)){
			if(!empty($_FILES)){
				//pr($_FILES);
				foreach ($_FILES["file"]["error"] as $key => $error) {
					if ($error == UPLOAD_ERR_OK) {
						$name = date('Ymdhis').str_replace(" ","",$_FILES["file"]["name"][$key]);
						if(!in_array($_FILES["file"]["type"][$key], $this->denied_mime_types)){
							if(move_uploaded_file( $_FILES["file"]["tmp_name"][$key], $this->upload_dirpembelajaran . $name)){
								$this->db->insert('ak_rencana_pembelajaran_file', array('id_rencana_pembelajaran'=>$id_pembelajaran,'file_name'=>''.$name.''));
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
        public function getPertemuanByKelas($id_kelas){
			$this->load->model('ad_pembelajaran');
			$pertemuan=$this->ad_pembelajaran->getPertemuanByIdkelas($id_kelas);
			echo '<option id_kelas="0" id_pelajaran="0" value="0">Pilih Pertemuan</option>';
			foreach($pertemuan as $datapert){
				echo '<option id_kelas="'.$datapert['id_kelas'].'" id_pelajaran="'.$datapert['id_pelajaran'].'" value="'.$datapert['id'].'">Ke '.$datapert['pertemuan_ke'].' | Kelas '.$datapert['kelas'].''.$datapert['nama_kelas'].' | '.$datapert['nama_pelajaran'].' | '.$datapert['topik'].'</option>"';
			}
		}
        public function addpertemuan(){

			//$this->load->model('ad_pembelajaran');
			$this->load->model('ad_pelajaran');
			
			if(isset($_POST['id_pelajaran'])){
				 	 	 	 	 	 	 	 	 	 	 	 	 	 
				foreach($_POST['id_kelas'] as $id_kelas){
					$datainsert=array(
										'id_sekolah'=>$this->session->userdata['user_authentication']['id_sekolah'],
										'id_pelajaran'=>$_POST['id_pelajaran'],
										'id_pegawai'=>$this->session->userdata['user_authentication']['id_pengguna'],
										'id_kelas'=>$id_kelas,
										'ta'=>$this->session->userdata['ak_setting']['ta'],
										'semester'=>$this->session->userdata['ak_setting']['semester'],
										'topik'=>$_POST['topik'],
										'waktu'=>$_POST['waktu'],
										'pertemuan_ke'=>$_POST['pertemuan_ke']
					);
					
					$this->db->insert('ak_rencana_pertemuan',$datainsert);
					$id_pertemuan=mysql_insert_id();
					$id_pertemuanarray[$id_pertemuan]=$id_pertemuan;
					//$this->db->insert('ak_rencana_detail',array('id_kelas'=>$id_kelas,'id_pertemuan'=>$id_pertemuan));
				}
				echo json_encode($id_pertemuanarray);
				die();
			}
			
			$data['pelajaran'] 	=$this->ad_pelajaran->getdatabySemesterJenjangJurusanPegawaimengajar();
            $data['main']= 'akademik/perencanaan/addpertemuan';
            $this->load->view('layout/ad_blank',$data);
        }
        public function addpembelajaran($id_pertemuan=0){

			$this->load->model('ad_pembelajaran');
			
			if(isset($_POST['id_pertemuan'])){
				foreach($_POST['id_pertemuan'] as $id_pertemuan){ 	 	 	 	 	 	 	 	 	 	 	 	 	 
					$datainsert=array(
										'id_pertemuan'=>$id_pertemuan,
										'judul'=>$_POST['judul'],     
										'kompetensi_inti'=>$_POST['kompetensi_inti'],     
										'kompetensi_dasar'=>$_POST['kompetensi_dasar'],
										'indikator_ketercapaian'=>$_POST['indikator_ketercapaian'],
										'tujuan_pemb'=>$_POST['tujuan_pemb'],
										'model_pembelajaran'=>$_POST['model_pembelajaran'],
										'pendahuluan'=>$_POST['pendahuluan'],
										'inti'=>$_POST['inti'],
										'penutup'=>$_POST['penutup'],
										'media_sumber'=>$_POST['media_sumber'],
										'referensi'=>$_POST['referensi'],
										'keterangan'=>$_POST['keterangan'],
										'share'=>"".@$_POST['share']."",
					);
					$this->db->insert('ak_rencana_pembelajaran',$datainsert);
					$id_pembelajaran=mysql_insert_id();
					$id_pembelajaranarray[$id_pembelajaran]=$id_pembelajaran;
				}
				
				echo json_encode($id_pembelajaranarray);
				die();
			}
			if(!isset($_POST['id_pertemuanarray']) && $id_pertemuan!=0){
				$pertemuan=$this->ad_pembelajaran->getPertemuanById($id_pertemuan);
				foreach($pertemuan as $drptm){
					$id_pertemuanarray[$drptm['id']]=$drptm['id'];
					$id_pelajaran=$drptm['id_pelajaran'];
				}
				$_POST['id_pertemuanarray']=json_encode((object)$id_pertemuanarray);
				$_POST['id_pelajaran']=$id_pelajaran;
				
			}
			$data['id_pertemuan']=json_decode($_POST['id_pertemuanarray']);
			$data['pertemuan']=$this->ad_pembelajaran->getPertemuanByIdPegSemTaIdSek($this->session->userdata['user_authentication']['id_pengguna'],$this->session->userdata['ak_setting']['semester'],$this->session->userdata['ak_setting']['ta'],$this->session->userdata['user_authentication']['id_sekolah']);
            $data['main']= 'akademik/perencanaan/addpembelajaran';
            $this->load->view('layout/ad_blank',$data);
        }   
        public function editpertemuan($id=0){

			$this->load->model('ad_pembelajaran');
			$this->load->model('ad_kelas');
			$this->load->model('ad_pelajaran');
			
			if(isset($_POST['id_pelajaran'])){
				 	 	 	 	 	 	 	 	 	 	 	 	 	 
				$datainsert=array(
									'id_sekolah'=>$this->session->userdata['user_authentication']['id_sekolah'],
									'id_pelajaran'=>$_POST['id_pelajaran'],
									'id_pegawai'=>$this->session->userdata['user_authentication']['id_pengguna'],
									'id_kelas'=>$_POST['id_kelas'],
									'ta'=>$this->session->userdata['ak_setting']['ta'],
									'semester'=>$this->session->userdata['ak_setting']['semester'],
									'topik'=>$_POST['topik'],
									'waktu'=>$_POST['waktu'],
									'pertemuan_ke'=>$_POST['pertemuan_ke']
				);
				
				$this->db->where('id',$_POST['id']);
				$this->db->update('ak_rencana_pertemuan',$datainsert);
				
				echo $_POST['id'];
				die();
			}
			
			$data['pertemuan'] 	=$this->ad_pembelajaran->getPertemuanById($id);
		    $jurusankelasnya=$this->ad_kelas->getkelasById($this->session->userdata['user_authentication']['id_sekolah'],$data['pertemuan'][0]['id_kelas']);
			//pr($jurusankelasnya);
		    $data['pelajaran']=$this->ad_pelajaran->getdatabySemesterJenjangJurusanKelasPegawaimengajar($this->session->userdata['ak_setting']['semester'],$jurusankelasnya[0]['kelas'],$jurusankelasnya[0]['id_jurusan'],$data['pertemuan'][0]['id_kelas']);
			
			$data['kelas'] 	=$this->ad_kelas->getkelasByPengajar($this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['user_authentication']['id_pengguna']);
            $data['main']= 'akademik/perencanaan/editpertemuan';
            $this->load->view('layout/ad_blank',$data);
        }   
        public function editpembelajaran($id){

			$this->load->model('ad_pembelajaran');
			$this->load->model('ad_kelas');
			
			if(isset($_POST['id_pertemuan'])){
				 	 	 	 	 	 	 	 	 	 	 	 	 	 
				$datainsert=array(
									'id_pertemuan'=>$_POST['id_pertemuan'],
									'judul'=>$_POST['judul'],     
									'kompetensi_inti'=>$_POST['kompetensi_inti'],     
									'kompetensi_dasar'=>$_POST['kompetensi_dasar'],
									'indikator_ketercapaian'=>$_POST['indikator_ketercapaian'],
									'tujuan_pemb'=>$_POST['tujuan_pemb'],
									'model_pembelajaran'=>$_POST['model_pembelajaran'],
									'pendahuluan'=>$_POST['pendahuluan'],
									'inti'=>$_POST['inti'],
									'penutup'=>$_POST['penutup'],
									'media_sumber'=>$_POST['media_sumber'],
									'referensi'=>$_POST['referensi'],
									'keterangan'=>$_POST['keterangan'],
									'share'=>"".@$_POST['share']."",
				);
				
				$this->db->where('id',$_POST['id']);
				$this->db->update('ak_rencana_pembelajaran',$datainsert);
				
				echo $_POST['id'];
				die();
			}
			
			$data['pembelajaran'] 	=$this->ad_pembelajaran->getPembelajaranById($id);//pr($data['pembelajaran']);
			$data['files'] 	=$this->ad_pembelajaran->getFilePembById_pemb($id);
			$data['pertemuan']=$this->ad_pembelajaran->getPertemuanByIdPegSemTaIdSek($this->session->userdata['user_authentication']['id_pengguna'],$this->session->userdata['ak_setting']['semester'],$this->session->userdata['ak_setting']['ta'],$this->session->userdata['user_authentication']['id_sekolah']);
            $data['main']= 'akademik/perencanaan/editpembelajaran';
            $this->load->view('layout/ad_blank',$data);
        }        
        
		
        //AREA TIMELINE PEMBELAJARAN 
        public function timelinepembelajaran(){
			$this->load->model('ad_kelas');
			$data['timelinepembelajaran']=array();
			$data['kelas'] 	=$this->ad_kelas->getkelasByPengajar($this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['user_authentication']['id_pengguna']);
            $data['main']= 'akademik/perencanaan/timelinepembelajaran';
            $this->load->view('layout/ad_blank',$data);
        }
		
        public function timelinepembelajaranlist(){

			$this->load->model('ad_timelinepembelajaran');
			$data['timelinepembelajaran']=$this->ad_timelinepembelajaran->gettimelinepembelajaranByKelasPelajaranIdPegawai($_POST['pelajaran'],$_POST['id_kelas']);
            $data['main']= 'akademik/perencanaan/timelinepembelajaranlist';
            $this->load->view('layout/ad_blank',$data);
        }
		public function deletefiletimelinepemb($id=null)
        {	
		
			$this->load->model('ad_timelinepembelajaran');
			$datafile=$this->ad_timelinepembelajaran->getFilePembById($id);
			//pr($datafile);
			
			if($this->db->query('DELETE FROM ak_timeline_pembelajaran_file WHERE id='.$id.'')){
				if(file_exists($this->upload_dirtimelinepembelajaran.$datafile[0]['file_name'])){
					unlink($this->upload_dirtimelinepembelajaran.$datafile[0]['file_name']);
				}
			}
		}
		public function uploadtimelinepembelajaran($id_timelinepembelajaran)
        {
			
			
			if(isset($_FILES)){
			if(!empty($_FILES)){
				//pr($_FILES);
				foreach ($_FILES["file"]["error"] as $key => $error) {
					if ($error == UPLOAD_ERR_OK) {
						$name = date('Ymdhis').str_replace(" ","",$_FILES["file"]["name"][$key]);
						if(!in_array($_FILES["file"]["type"][$key], $this->denied_mime_types)){
							if(move_uploaded_file( $_FILES["file"]["tmp_name"][$key], $this->upload_dirtimelinepembelajaran . $name)){
								$this->db->insert('ak_timeline_pembelajaran_file', array('id_timeline_pembelajaran'=>$id_timelinepembelajaran,'file_name'=>''.$name.''));
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
        public function addtimelinepembelajaran(){

			$this->load->model('ad_timelinepembelajaran');
			$this->load->model('ad_kelas');
			
			if(isset($_POST['id_pelajaran'])){
				 	 	 	 	 	 	 	 	 	 	 	 	 	 
				$datainsert=array(
									'id_sekolah'=>$this->session->userdata['user_authentication']['id_sekolah'],
									'id_pelajaran'=>$_POST['id_pelajaran'],
									'id_pegawai'=>$this->session->userdata['user_authentication']['id_pengguna'],
									'id_kelas'=>$_POST['id_kelas'],
									'pertemuan'=>$_POST['pertemuan'],
									'tanggal'=>$_POST['tanggal'],
									'ta'=>$this->session->userdata['ak_setting']['ta'],
									'semester'=>$this->session->userdata['ak_setting']['semester'],
									'keterangan'=>$_POST['keterangan'],
									'share'=>"".@$_POST['share']."",
				);
				
				$this->db->insert('ak_timeline_pembelajaran',$datainsert);
				$id_timelinepembelajaran=mysql_insert_id();
				echo $id_timelinepembelajaran;
				die();
			}
			
			$data['kelas'] 	=$this->ad_kelas->getkelasByPengajar($this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['user_authentication']['id_pengguna']);
            $data['main']= 'akademik/perencanaan/addtimelinepembelajaran';
            $this->load->view('layout/ad_blank',$data);
        }   
        public function edittimelinepembelajaran($id){

			$this->load->model('ad_timelinepembelajaran');
			$this->load->model('ad_kelas');
			
			if(isset($_POST['id_pelajaran'])){
				 	 	 	 	 	 	 	 	 	 	 	 	 	 
				$datainsert=array(
									'id_sekolah'=>$this->session->userdata['user_authentication']['id_sekolah'],
									'id_pelajaran'=>$_POST['id_pelajaran'],
									'id_pegawai'=>$this->session->userdata['user_authentication']['id_pengguna'],
									'id_kelas'=>$_POST['id_kelas'],
									'pertemuan'=>$_POST['pertemuan'],
									'tanggal'=>$_POST['tanggal'],
									'ta'=>$this->session->userdata['ak_setting']['ta'],
									'semester'=>$this->session->userdata['ak_setting']['semester'],
									'keterangan'=>$_POST['keterangan'],
									'share'=>"".@$_POST['share']."",
				);
				
				$this->db->where('id',$_POST['id']);
				$this->db->update('ak_timeline_pembelajaran',$datainsert);
				
				echo $_POST['id'];
				die();
			}
			
			$data['timelinepembelajaran'] 	=$this->ad_timelinepembelajaran->gettimelinepembelajaranById($id);//pr($data['timelinepembelajaran']);
			$data['files'] 	=$this->ad_timelinepembelajaran->getFilePembById_pemb($id);
			$data['kelas'] 	=$this->ad_kelas->getkelasByPengajar($this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['user_authentication']['id_pengguna']);
            $data['main']= 'akademik/perencanaan/edittimelinepembelajaran';
            $this->load->view('layout/ad_blank',$data);
        }        

        public function penilaian($indikator='',$id_pembelajaran=0,$id_pelajaran=0,$id_kelas=0,$nama_kelas='',$subject=''){
			$subjectnoen=base64_decode($subject);
			$this->load->library('ak_akademik');
			$this->load->model('ad_pembelajaran');
			$this->load->model('ad_siswa');
			$data['param']=array('indikatore'=>$indikator,'id_pembelajarane'=>$id_pembelajaran,'id_pelajarane'=>$id_pelajaran,'id_kelase'=>$id_kelas,'nama_kelase'=>$nama_kelas);
            $data['id_kelas']= $id_kelas;
            $data['id_pelajaran']= $id_pelajaran;
            $data['nama_kelas']= $nama_kelas;
            $data['subject']= $subject;
            $data['subjectnoen']= $subjectnoen;
			$data['siswa']=array();

			if(isset($_POST['id_indikator']) && !isset($_POST['poin'])){
				$point= $this->ad_pembelajaran->getPointIndikatorByPegSk($_POST['id_indikator'],$id_kelas);
				$data['siswa']= $this->ad_siswa->getsiswaByIdKelas($id_kelas);
				foreach($point as $datapoint){
					$point2[$datapoint['id_siswa_det_jenjang']]=$datapoint;
				}
				unset($point);
				$data['point']= $point2;
			}
			if(isset($_POST['poin']) && isset($_POST['id_indikator'])){
				$pointcurrent= $this->ad_pembelajaran->getPointIndikatorByPegSk($_POST['id_indikator'],$_POST['id_kelas']);
				foreach($pointcurrent as $datapointcurrent){
					$pointcurrent2[$datapointcurrent['id_siswa_det_jenjang']]=$datapointcurrent;
				}
				unset($pointcurrent);
				//pr($pointcurrent2);
				foreach($_POST['poin'] as $id_det_jenjang=>$datap){
					$arr_insert=array(
									'id_sekolah'=>$this->session->userdata['user_authentication']['id_sekolah'],
									'id_indikator'=>$_POST['id_indikator'],
									'id_siswa_det_jenjang'=>$id_det_jenjang,
									'id_kelas'=>$_POST['id_kelas'],
									'point'=>$datap
					);
					if(isset($pointcurrent2[$id_det_jenjang])){
						if($datap!=$pointcurrent2[$id_det_jenjang]['point']){
							$this->db->where('id',$pointcurrent2[$id_det_jenjang]['id']);
							$this->db->update('ak_rencana_point_indikator',$arr_insert);
							//pr($this->db->last_query());
							$this->ak_akademik->makerataafektif($id_det_jenjang,$_POST['id_kelas'],$_POST['id_pelajaran'],$indikator);
						}
					}else{
						$this->db->insert('ak_rencana_point_indikator',$arr_insert);
						//pr($this->db->last_query());
						$this->ak_akademik->makerataafektif($id_det_jenjang,$_POST['id_kelas'],$_POST['id_pelajaran'],$indikator);
					}
				}
				
			}
            $data['indikator']= $this->ad_pembelajaran->getIndikatorByPegSmTaSk($indikator,$id_pembelajaran);
            $data['indikatore']= $indikator;
            $data['main']= 'akademik/perencanaan/penilaian';
            $this->load->view('layout/ad_blank',$data);
		}
		
        public function materi($id_pembelajaran=0,$id_pelajaran=0){
			if(isset($_POST['id_pelajaran']) && isset($_POST['id_pembelajaran'])){
				$id_pembelajaran=implode(",",json_decode(base64_decode($_POST['id_pembelajaran']),true));
					$datainsert=array(
						'id_sekolah'=>$this->session->userdata['user_authentication']['id_sekolah'],
						'id_pegawai'=>$this->session->userdata['user_authentication']['id_pengguna'],
						'id_pembelajaran'=>$id_pembelajaran,
						'semester'=>$this->session->userdata['ak_setting']['semester'],
						'id_pelajaran'=>$_POST['id_pelajaran'],
						'pokok_bahasan'=>$_POST['pokok_bahasan'],
						'bab'=>$_POST['bab'],
						'keterangan'=>$_POST['keterangan'],
						'tanggal_buat'=>date("Y-m-d H:i:s"),
						'share'=>"".@$_POST['share']."",
					);
						
					$this->db->insert('ak_materi_pelajaran',$datainsert);
					$id_materi=mysql_insert_id();

				echo $id_materi;
				die();
			}
			
			//kondisi bukan dari awal
			if(!isset($_POST['id_pembelajaran']) && $id_pembelajaran!=0){
				$data['id_pembelajaran'] =base64_encode(json_encode(array($id_pembelajaran)));
				$_POST['id_pembelajaran']=$id_pembelajaran;
			}else{
				$data['id_pembelajaran'] =base64_encode($_POST['id_pembelajaran']);
			}
			$this->load->model('ad_pelajaran');
			$data['id_pelajaran']=$id_pelajaran;
			$data['pelajaran'] 	=$this->ad_pelajaran->getdatabySemesterJenjangJurusanPegawaimengajar();
            $data['main']= 'akademik/perencanaan/materi';
            $this->load->view('layout/ad_blank',$data);
		}
		public function uploadfile($type)
        {
			$typearray=json_decode(base64_decode($type));
			
			foreach($typearray as $typenya=>$id_type){
				$upload_dir='upload/akademik/'.$typenya.'/';
				if(isset($_FILES)){
					if(!empty($_FILES["file"]["error"])){
						foreach ($_FILES["file"]["error"] as $key => $error) {
							if ($error == UPLOAD_ERR_OK) {
								$name = date('Ymdhis').str_replace(" ","",$_FILES["file"]["name"][$key]);
								if(!in_array($_FILES["file"]["type"][$key], $this->denied_mime_types)){
									if(move_uploaded_file($_FILES["file"]["tmp_name"][$key], $upload_dir . $name)){
										$this->db->insert('ak_'.$typenya.'_file', array('id_'.$typenya.''=>$id_type,'file_name'=>''.$name.''));
										$dir_source=$upload_dir;
										$filename[]=$name;
										$typefirstup=$typenya;
									}
								}else{
									echo "Anda tidak diperbolehkan mengunggah file ".$_FILES["file"]["name"][$key].". File ini gagal di unggah. <br />";
								}						
							}
						}
						if($typefirstup!=$typenya){
							foreach($filename as $namef){
								copy($dir_source.$namef, $upload_dir.$namef);
								$this->db->insert('ak_'.$typenya.'_file', array('id_'.$typenya.''=>$id_type,'file_name'=>''.$namef.''));
							}
							
						}
					}
				}
			}

        }
        public function kognitif($id_pembelajaran=0,$id_pelajaran=0){
			
			if(isset($_POST['type'])){
				$id_pembelajaran=implode(",",json_decode(base64_decode($_POST['id_pembelajaran']),true));
				foreach($_POST['type'] as $type){
					@$_POST['id_sekolah']=$this->session->userdata['user_authentication']['id_sekolah'];
					@$_POST['id_pegawai']=$this->session->userdata['user_authentication']['id_pengguna'];
					@$_POST['semester']=$this->session->userdata['ak_setting']['semester'];
					@$_POST['ta']=$this->session->userdata['ak_setting']['ta'];
					@$_POST['tanggal_buat']=date('Y-m-d H:i:s');
					@$_POST['jenis']='non_remidial';
					@$_POST['id_pembelajaran']=",$id_pembelajaran,";

					$id_kelas=$_POST['id_kelas'];
					$tanggal_kumpul=$_POST['tanggal_kumpul'];
					
					$postkelas=$_POST['id_kelas'];
					$id_mengajar=$_POST['id_mengajar'];
					unset($_POST['ajax']);
					unset($_POST['id_kelas']);
					unset($_POST['id_mengajar']);
					unset($_POST['type']);
					$save=$_POST;
					unset($save[$this->config->item('csrf_token_name')]);	
					$this->db->insert('ak_'.$type.'',$save);
					
					$id_insert[$type]=mysql_insert_id();
				}
				echo base64_encode(json_encode($id_insert));
				die();
			}
			
						
			//kondisi bukan dari awal
			if(!isset($_POST['id_pembelajaran']) && $id_pembelajaran!=0){
				$data['id_pembelajaran'] =base64_encode(json_encode(array($id_pembelajaran)));
				$_POST['id_pembelajaran']=$id_pembelajaran;
			}else{
				$data['id_pembelajaran'] =$_POST['id_pembelajaran'];
			}
			$data['id_pelajaran']=$id_pelajaran;
			if(!isset($_POST['id_pelajaran']) && $id_pelajaran!=0){$_POST['id_pelajaran']=$id_pelajaran;}
			$this->load->model('ad_pelajaran');
			$data['pelajaran'] 	=$this->ad_pelajaran->getdatabySemesterJenjangJurusanPegawaimengajar();
            
            $data['main']= 'akademik/perencanaan/kognitif';
            $this->load->view('layout/ad_blank',$data);
		}
        public function kognitifs($id_pembelajaran=0,$id_pelajaran=0){
			
			if(isset($_POST['kognitifs'])){
				$id_pembelajaran=implode(",",json_decode(base64_decode($_POST['id_pembelajaran']),true));
				$id_pelajaranx=$_POST['id_pelajaranx'];
				//$nilaix=$_POST['nilai'];

				foreach($_POST['kognitifs'] as $idx=>$kognitifs){
					@$in['id_sekolah']=$this->session->userdata['user_authentication']['id_sekolah'];
					@$in['id_pegawai']=$this->session->userdata['user_authentication']['id_pengguna'];
					@$in['semester']=$this->session->userdata['ak_setting']['semester'];
					@$in['ta']=$this->session->userdata['ak_setting']['ta'];
					@$in['penilaian']='kognitif';
					@$in['indikator']=$kognitifs;
					@$in['id_pembelajaran']=$id_pembelajaran;
					@$in['id_pelajaran']=$id_pelajaranx[$idx];
					//@$in['nilai']=$nilaix[$idx];
					
					if(isset($_POST['id'][$idx])){
						$this->db->where('id',$_POST['id'][$idx]);
						$this->db->update('ak_rencana_indikator',$in);
						$id_insert[]=$idx;
					}else{
						$this->db->insert('ak_rencana_indikator',$in);	
						$id_insert[]=mysql_insert_id();
					}
					

				}
				echo base64_encode(json_encode($id_insert));
				die();
			}
			
			if(!isset($_POST['id_pelajaran']) && $id_pelajaran!=0){$_POST['id_pelajaran']=$id_pelajaran;}
			$this->load->model('ad_pelajaran');
			$this->load->model('ad_pembelajaran');
			
			if(isset($_POST['id_pembelajaran'])){
				$data['kognitifs'] 	=array();
			}else{
				$data['kognitifs'] 	=$this->ad_pembelajaran->getIndikatorByPegSmTaSk('kognitif',$id_pembelajaran);				
			}
			//kondisi bukan dari awal
			if(!isset($_POST['id_pembelajaran']) && $id_pembelajaran!=0){
				$data['id_pembelajaran'] =base64_encode(json_encode(array($id_pembelajaran)));
				$_POST['id_pembelajaran']=$id_pembelajaran;
			}else{
				$data['id_pembelajaran'] =$_POST['id_pembelajaran'];
			}
			$data['pelajaran'] 	=$this->ad_pelajaran->getdatabySemesterJenjangJurusanPegawaimengajar();
            $data['main']= 'akademik/perencanaan/kognitifs';
            $this->load->view('layout/ad_blank',$data);
		}
        public function afektif($id_pembelajaran=0,$id_pelajaran=0){
			
			if(isset($_POST['afektif'])){
				$id_pembelajaranarr=json_decode(base64_decode($_POST['id_pembelajaran']));
				$id_pembelajaran=implode(",",$id_pembelajaranarr,true);
				$id_pelajaranx=$_POST['id_pelajaranx'];
				//$nilaix=$_POST['nilai'];

				foreach($id_pembelajaranarr as $id_pemb){
				foreach($_POST['afektif'] as $idx=>$afektif){
					@$in['id_sekolah']=$this->session->userdata['user_authentication']['id_sekolah'];
					@$in['id_pegawai']=$this->session->userdata['user_authentication']['id_pengguna'];
					@$in['semester']=$this->session->userdata['ak_setting']['semester'];
					@$in['ta']=$this->session->userdata['ak_setting']['ta'];
					@$in['penilaian']='afektif';
					@$in['indikator']=$afektif;
					@$in['id_pembelajaran']=$id_pemb;
					@$in['id_pelajaran']=$id_pelajaranx[$idx];
					//@$in['nilai']=$nilaix[$idx];

					if(isset($_POST['id'][$idx])){echo 'update'; 
						$this->db->where('id',$_POST['id'][$idx]);
						$this->db->update('ak_rencana_indikator',$in);
						$id_insert[]=$idx;
					}else{
						$this->db->insert('ak_rencana_indikator',$in);	
						$id_insert[]=mysql_insert_id();
					}
					

				}
				}
				echo base64_encode(json_encode($id_insert));
				die();
			}
			
			if(!isset($_POST['id_pelajaran']) && $id_pelajaran!=0){$_POST['id_pelajaran']=$id_pelajaran;}
			$this->load->model('ad_pelajaran');
			$this->load->model('ad_pembelajaran');
			
			if(isset($_POST['id_pembelajaran'])){
				$data['afektif'] 	=array();
			}else{
				$data['afektif'] 	=$this->ad_pembelajaran->getIndikatorByPegSmTaSk('afektif',$id_pembelajaran);			
			}
			//kondisi bukan dari awal
			if(!isset($_POST['id_pembelajaran']) && $id_pembelajaran!=0){
				$data['id_pembelajaran'] =base64_encode(json_encode(array($id_pembelajaran)));
				$_POST['id_pembelajaran']=$id_pembelajaran;
			}else{
				$data['id_pembelajaran'] =$_POST['id_pembelajaran'];
			}
			$data['pelajaran'] 	=$this->ad_pelajaran->getdatabySemesterJenjangJurusanPegawaimengajar();
            $data['main']= 'akademik/perencanaan/afektif';
            $this->load->view('layout/ad_blank',$data);
		}
        public function psikomotorik($id_pembelajaran=0,$id_pelajaran=0){
			
			if(isset($_POST['psikomotorik'])){
				$id_pembelajaranarr=json_decode(base64_decode($_POST['id_pembelajaran']));
				$id_pembelajaran=implode(",",$id_pembelajaranarr,true);
				$id_pelajaranx=$_POST['id_pelajaranx'];
				//$nilaix=$_POST['nilai'];

				foreach($id_pembelajaranarr as $id_pemb){
				foreach($_POST['psikomotorik'] as $idx=>$psikomotorik){
					@$in['id_sekolah']=$this->session->userdata['user_authentication']['id_sekolah'];
					@$in['id_pegawai']=$this->session->userdata['user_authentication']['id_pengguna'];
					@$in['semester']=$this->session->userdata['ak_setting']['semester'];
					@$in['ta']=$this->session->userdata['ak_setting']['ta'];
					@$in['penilaian']='psikomotorik';
					@$in['indikator']=$psikomotorik;
					@$in['id_pembelajaran']=$id_pemb;
					@$in['id_pelajaran']=$id_pelajaranx[$idx];
					//@$in['nilai']=$nilaix[$idx];
					
					if(isset($_POST['id'][$idx])){
						$this->db->where('id',$_POST['id'][$idx]);
						$this->db->update('ak_rencana_indikator',$in);
						$id_insert[]=$idx;
					}else{
						$this->db->insert('ak_rencana_indikator',$in);	
						$id_insert[]=mysql_insert_id();
					}
					

				}
				echo base64_encode(json_encode($id_insert));
				die();
			}
			}
			
			if(!isset($_POST['id_pelajaran']) && $id_pelajaran!=0){$_POST['id_pelajaran']=$id_pelajaran;}
			$this->load->model('ad_pelajaran');
			$this->load->model('ad_pembelajaran');
			
			if(isset($_POST['id_pembelajaran'])){
				$data['psikomotorik'] 	=array();
			}else{
				$data['psikomotorik'] 	=$this->ad_pembelajaran->getIndikatorByPegSmTaSk('psikomotorik',$id_pembelajaran);			
			}
			//kondisi bukan dari awal
			if(!isset($_POST['id_pembelajaran']) && $id_pembelajaran!=0){
				$data['id_pembelajaran'] =base64_encode(json_encode(array($id_pembelajaran)));
				$_POST['id_pembelajaran']=$id_pembelajaran;
			}else{
				$data['id_pembelajaran'] =$_POST['id_pembelajaran'];
			}
			$data['pelajaran'] 	=$this->ad_pelajaran->getdatabySemesterJenjangJurusanPegawaimengajar();
            $data['main']= 'akademik/perencanaan/psikomotorik';
            $this->load->view('layout/ad_blank',$data);
		}
		
        
        public function hapusindikator($id=0){
			$this->db->query('DELETE FROM ak_rencana_indikator WHERE id=?',array($id));
			$data['main']= 'akademik/perencanaan/sukses';
            $this->load->view('layout/ad_blank',$data);
		}
        public function sukses($inikator){
			$data['indikator']=$inikator;
			$data['main']= 'akademik/perencanaan/sukses';
            $this->load->view('layout/ad_blank',$data);
		}
    }
?>