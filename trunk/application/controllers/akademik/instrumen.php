<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Instrumen extends CI_Controller
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
		
        //AREA instrumen PEMBELAJARAN 
        public function submenu($jenis=''){
			$this->load->model('ad_kelas');
			$data['jenis']=$jenis;
			$data['kelas'] 	=$this->ad_kelas->getkelasByPengajar($this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['user_authentication']['id_pengguna']);
            $data['main']= 'akademik/instrumen/submenu';
            $this->load->view('layout/ad_blank',$data);
        }
        public function pembelajaran(){
			$this->load->model('ad_kelas');
			$data['pembelajaran']=array();
			$data['kelas'] 	=$this->ad_kelas->getkelasByPengajar($this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['user_authentication']['id_pengguna']);
            $data['main']= 'akademik/instrumen/pembelajaran';
            $this->load->view('layout/ad_blank',$data);
        }
        
        public function pertemuan(){
			$this->load->model('ad_kelas');
			$data['pembelajaran']=array();
			$data['kelas'] 	=$this->ad_kelas->getkelasByPengajar($this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['user_authentication']['id_pengguna']);
            $data['main']= 'akademik/instrumen/pertemuan';
            $this->load->view('layout/ad_blank',$data);
        }
		
        public function pertemuanlist(){

			$this->load->model('ad_instrumen');
			$data['pertemuan']=$this->ad_instrumen->getWaktuPembelajaranByKelasPelajaranIdPegawai($_POST['pelajaran'],$_POST['id_kelas']);
            $data['main']= 'akademik/instrumen/pertemuanlist';
            $this->load->view('layout/ad_blank',$data);
        }
		public function pembelajaranlist($id_pertemuan=0,$id_pegawai=0){
			$this->load->model('ad_instrumen');
			if($id_pertemuan!=0){
				$data['pertemuan']=$this->ad_instrumen->getPembelajaranByKelasPelajaranIdPegawaiIdPertemuan($_POST['pelajaran'],$_POST['id_kelas'],$id_pertemuan);
			}else{
				$data['pertemuan']=$this->ad_instrumen->getPembelajaranByKelasPelajaranIdPegawai($_POST['pelajaran'],$_POST['id_kelas'],$id_pegawai);
			}
            $data['main']= 'akademik/instrumen/pembelajaranlist';
			
            $this->load->view('layout/ad_blank',$data);
        }
		public function deletepert($id=null)
        {	
			if($this->db->query('DELETE FROM ak_rencana_pertemuan WHERE id='.$id.'')){
				$this->db->query('DELETE FROM ak_rencana_point_indikator WHERE id_pertemuan='.$id.'');
				echo 1;
			}else{
				echo 0;
			}
		}


		public function deletepemb($id_pemb=null)
        {	
			$this->load->model('ad_instrumen');
			$datafile=$this->ad_instrumen->getFilePembById_pemb($id_pemb);
			
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
			$this->load->model('ad_instrumen');
			$pertemuan=$this->ad_instrumen->getPertemuanByIdkelas($id_kelas);
			echo '<option id_kelas="0" id_pelajaran="0" value="0">Pilih Pertemuan</option>';
			foreach($pertemuan as $datapert){
				echo '<option id_kelas="'.$datapert['id_kelas'].'" id_pelajaran="'.$datapert['id_pelajaran'].'" value="'.$datapert['id'].'">Ke '.$datapert['pertemuan_ke'].' | Kelas '.$datapert['kelas'].''.$datapert['nama_kelas'].' | '.$datapert['nama_pelajaran'].' | '.$datapert['topik'].'</option>"';
			}
		}
        public function addpertemuan(){

			//$this->load->model('ad_instrumen');
			$this->load->model('ad_pelajaran');
			
			if(isset($_POST['id_pelajaran'])){
				$this->load->library('smsprivate'); 	 
				
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
										'tanggal'=>$_POST['tanggal'],
										'pertemuan_ke'=>$_POST['pertemuan_ke']
					);
					
					$this->db->insert('ak_rencana_pertemuan',$datainsert);
					$id_pertemuan=mysql_insert_id();
					//$id_pertemuanarray[$id_pertemuan]=$id_pertemuan;
					$this->smsprivate->send_by_kelas($id_kelas,$_POST['sms'],'pertemuanevaluasi',$id_pertemuan);
					//$this->db->insert('ak_rencana_detail',array('id_kelas'=>$id_kelas,'id_pertemuan'=>$id_pertemuan));
				}
				//echo json_encode($id_pertemuanarray);
				die();
			}
			
			$data['pelajaran'] 	=$this->ad_pelajaran->getdatabySemesterJenjangJurusanPegawaimengajar();
            $data['main']= 'akademik/instrumen/addpertemuan';
            $this->load->view('layout/ad_blank',$data);
        }
        public function addpembelajaran($id_pertemuan=0){

			$this->load->model('ad_instrumen');
			
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
				$pertemuan=$this->ad_instrumen->getPertemuanById($id_pertemuan);
				foreach($pertemuan as $drptm){
					$id_pertemuanarray[$drptm['id']]=$drptm['id'];
					$id_pelajaran=$drptm['id_pelajaran'];
				}
				$_POST['id_pertemuanarray']=json_encode((object)$id_pertemuanarray);
				$_POST['id_pelajaran']=$id_pelajaran;
				
			}
			$data['id_pertemuan']=json_decode($_POST['id_pertemuanarray']);
			$data['pertemuan']=$this->ad_instrumen->getPertemuanByIdPegSemTaIdSek($this->session->userdata['user_authentication']['id_pengguna'],$this->session->userdata['ak_setting']['semester'],$this->session->userdata['ak_setting']['ta'],$this->session->userdata['user_authentication']['id_sekolah']);
            $data['main']= 'akademik/instrumen/addpembelajaran';
            $this->load->view('layout/ad_blank',$data);
        }   
        public function editpertemuan($id=0){

			$this->load->model('ad_instrumen');
			$this->load->model('ad_kelas');
			$this->load->model('ad_pelajaran');
			
			if(isset($_POST['id'])){
				 	 	 	 	 	 	 	 	 	 	 	 	 	 
				$datainsert=array(
									'id_sekolah'=>$this->session->userdata['user_authentication']['id_sekolah'],
									'topik'=>$_POST['topik'],
									'waktu'=>$_POST['waktu'],
									'tanggal'=>$_POST['tanggal'],
									'pertemuan_ke'=>$_POST['pertemuan_ke']
				);
				
				$this->db->where('id',$_POST['id']);
				$this->db->update('ak_rencana_pertemuan',$datainsert);
				pr($this->db->last_query());
				echo $_POST['id'];
				die();
			}
			
			$data['pertemuan'] 	=$this->ad_instrumen->getPertemuanById($id);
		    $jurusankelasnya=$this->ad_kelas->getkelasById($this->session->userdata['user_authentication']['id_sekolah'],$data['pertemuan'][0]['id_kelas']);
			//pr($jurusankelasnya);
		    $data['pelajaran']=$this->ad_pelajaran->getdatabySemesterJenjangJurusanKelasPegawaimengajar($this->session->userdata['ak_setting']['semester'],$jurusankelasnya[0]['kelas'],$jurusankelasnya[0]['id_jurusan'],$data['pertemuan'][0]['id_kelas']);
			
			$data['kelas'] 	=$this->ad_kelas->getkelasByPengajar($this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['user_authentication']['id_pengguna']);
            $data['main']= 'akademik/instrumen/editpertemuan';
            $this->load->view('layout/ad_blank',$data);
        }   
        public function editpembelajaran($id){

			$this->load->model('ad_instrumen');
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
			
			$data['pembelajaran'] 	=$this->ad_instrumen->getPembelajaranById($id);//pr($data['pembelajaran']);
			$data['files'] 	=$this->ad_instrumen->getFilePembById_pemb($id);
			$data['pertemuan']=$this->ad_instrumen->getPertemuanByIdPegSemTaIdSek($this->session->userdata['user_authentication']['id_pengguna'],$this->session->userdata['ak_setting']['semester'],$this->session->userdata['ak_setting']['ta'],$this->session->userdata['user_authentication']['id_sekolah']);
            $data['main']= 'akademik/instrumen/editpembelajaran';
            $this->load->view('layout/ad_blank',$data);
        }        

        public function penilaian($indikator='',$id_pembelajaran=0,$id_pelajaran=0,$id_kelas=0,$nama_kelas='',$subject=''){
			$subjectnoen=base64_decode($subject);
			$this->load->library('ak_akademik');
			$this->load->model('ad_instrumen');
			$this->load->model('ad_siswa');
			$data['param']=array('indikatore'=>$indikator,'id_pembelajarane'=>$id_pembelajaran,'id_pelajarane'=>$id_pelajaran,'id_kelase'=>$id_kelas,'nama_kelase'=>$nama_kelas);
            $data['id_kelas']= $id_kelas;
            $data['id_pelajaran']= $id_pelajaran;
            $data['nama_kelas']= $nama_kelas;
            $data['subject']= $subject;
            $data['subjectnoen']= $subjectnoen;
			$data['siswa']=array();

			if(isset($_POST['id_indikator']) && !isset($_POST['poin'])){
				$point= $this->ad_instrumen->getPointIndikatorByPegSk($_POST['id_indikator'],$id_kelas);
				$data['siswa']= $this->ad_siswa->getsiswaByIdKelas($id_kelas);
				foreach($point as $datapoint){
					$point2[$datapoint['id_siswa_det_jenjang']]=$datapoint;
				}
				unset($point);
				$data['point']= $point2;
			}
			if(isset($_POST['poin']) && isset($_POST['id_indikator'])){
				$pointcurrent= $this->ad_instrumen->getPointIndikatorByPegSk($_POST['id_indikator'],$_POST['id_kelas']);
				foreach($pointcurrent as $datapointcurrent){
					$pointcurrent2[$datapointcurrent['id_siswa_det_jenjang']]=$datapointcurrent;
				}
				//pr($pointcurrent);
				unset($pointcurrent);
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
            $data['indikator']= $this->ad_instrumen->getIndikatorByPegSmTaSk($indikator,$id_pembelajaran);
            $data['indikatore']= $indikator;
            $data['main']= 'akademik/instrumen/penilaian';
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
            $data['main']= 'akademik/instrumen/materi';
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

					$this->db->insert('ak_'.$type.'',$_POST);
					
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
            
            $data['main']= 'akademik/instrumen/kognitif';
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
					@$in['id_pertemuan']=$id_pembelajaran;
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
			$this->load->model('ad_instrumen');
			
			if(isset($_POST['id_pembelajaran'])){
				$data['kognitifs'] 	=array();
			}else{
				$data['kognitifs'] 	=$this->ad_instrumen->getIndikatorByPegSmTaSk('kognitif',$id_pembelajaran);				
			}
			//kondisi bukan dari awal
			if(!isset($_POST['id_pembelajaran']) && $id_pembelajaran!=0){
				$data['id_pembelajaran'] =base64_encode(json_encode(array($id_pembelajaran)));
				$_POST['id_pembelajaran']=$id_pembelajaran;
			}else{
				$data['id_pembelajaran'] =$_POST['id_pembelajaran'];
			}
			$data['pelajaran'] 	=$this->ad_pelajaran->getdatabySemesterJenjangJurusanPegawaimengajar();
            $data['main']= 'akademik/instrumen/kognitifs';
            $this->load->view('layout/ad_blank',$data);
		}
        public function praotentik($param){
			$data['param']=$param;
			$param=unserialize($this->myencrypt->decode($param));
			
			$data['jenis'] 	=$jenis=$param['jenis'];
			$data['evaluasi_ke'] 	=$evaluasi_ke=$param['evaluasi_ke'];
			$data['kelas'] 	=$kelas=$param['kelas'];
			$data['id_mengjar'] 	=$id_mengjar=$param['id_mengjar'];
			$data['id_kelas'] 	=$id_kelas=$param['id_kelas'];
			$data['id_pelajaran'] 	=$id_pelajaran=$param['id_pelajaran'];
			$data['id_pembelajaran'] 	=$id_pembelajaran=$param['id_pembelajaran'];
			//$id_pembelajaran=0,$id_pelajaran=0,$id_mengjar=0,$evaluasi_ke=0,$kelas='',$id_kelas=0
			$this->load->model('ad_pelajaran');
			$this->load->model("ad_siswa");
			$data['pelajaran'] 	=$this->ad_pelajaran->getdataById($id_pelajaran);
			$data['siswa']= $this->ad_siswa->getsiswaByIdKelas($id_kelas,'s.id,s.nama, adj.id as id_siswa_det_jenjang');
            $data['main']= 'akademik/instrumen/praotentik';
            $this->load->view('layout/ad_blank',$data);
		}
        public function otentik($param){
			$this->load->model('ad_pelajaran');
			$this->load->model('ad_instrumen');
			$data['param']=$param;
			$param=unserialize($this->myencrypt->decode($param));
			$this->load->model("ad_siswa");
			$data['siswa']= $this->ad_siswa->getsiswaByIdKelas($id_kelas,'s.id,s.nama, adj.id as id_siswa_det_jenjang');
			$data['jenis'] 	=$jenis=$param['jenis'];
			$data['evaluasi_ke'] 	=$evaluasi_ke=$param['evaluasi_ke'];
			$data['kelas'] 	=$kelas=$param['kelas'];
			$data['id_mengjar'] 	=$id_mengjar=$param['id_mengjar'];
			$data['id_kelas'] 	=$id_kelas=$param['id_kelas'];
			$data['id_pelajaran'] 	=$id_pelajaran=$param['id_pelajaran'];
			$data['id_pertemuan'] 	=$id_pertemuan=$param['id_pertemuan'];
			
			if(!isset($_POST['id_pelajaran']) && $id_pelajaran!=0){$_POST['id_pelajaran']=$id_pelajaran;}
			$data['otentik'] 	=$this->ad_instrumen->getIndikatorByPegSmTaSkEv($jenis,$_POST['id_pelajaran'],$id_mengjar,$id_kelas,$_POST['id_det_jenjang'],$id_pertemuan);
			//pr($data['otentik']);
			if(isset($_POST['otentik'])){
				//$nilaix=$_POST['nilai'];
					unset($_POST['otentik'][0]);
					foreach($_POST['otentik'] as $idx=>$otentik){
						@$in['id_sekolah']=$this->session->userdata['user_authentication']['id_sekolah'];
						@$in['id_pegawai']=$this->session->userdata['user_authentication']['id_pengguna'];
						@$in['semester']=$this->session->userdata['ak_setting']['semester'];
						@$in['penilaian']=$jenis;
						@$in['indikator']=$otentik;
						@$in['id_mengajar']=$_POST['id_mengjar'];
						//@$in['id_pertemuan']=$id_pemb;
						@$in['id_pelajaran']=$id_pelajaran;
						//@$in['nilai']=$nilaix[$idx];
						//pr($in);
						if(isset($_POST['id'][$idx])){
							$this->db->where('id',$_POST['id'][$idx]);
							$this->db->update('ak_rencana_indikator',$in);
							//pr($this->db->last_query());
						}else{
							$this->db->insert('ak_rencana_indikator',$in);	
							$id_indik=mysql_insert_id();
							//pr($this->db->last_query());
						}
						
						$point['id_sekolah']=$this->session->userdata['user_authentication']['id_sekolah'];
						$point['id_pelajaran']=$_POST['id_pelajaran'];
						$point['id_pertemuan']=$id_pertemuan;
						$point['id_indikator']=$idx;
						$point['id_siswa_det_jenjang']=$_POST['id_det_jenjang'];
						$point['id_kelas']=$_POST['id_kelas'];
						
						foreach($_POST['point'][$idx] as $id_point=>$pointnya){}
						$jmlpoint=$jmlpoint+$pointnya;
						if($id_point==0){
							if(isset($id_indik)){
								$point['id_indikator']=$id_indik;
							}
							if(!isset($_POST['point'][$idx][0])){
								$point['point']=$_POST['point'][$idx][1];
							}else{
								$point['point']=$_POST['point'][$idx][0];
							}
							$this->db->insert('ak_rencana_point_indikator',$point);
							//echo $this->db->last_query();
						}else{
							$point['point']=$_POST['point'][$idx][$id_point];
							$this->db->where(array('id_sekolah'=>$this->session->userdata['user_authentication']['id_sekolah'],'id_indikator'=>$_POST['id'][$idx],'id_siswa_det_jenjang'=>$_POST['id_det_jenjang'],'id_kelas'=>$_POST['id_kelas'],'id_pertemuan'=>$id_pertemuan));
							$this->db->update('ak_rencana_point_indikator',$point);
							//echo $this->db->last_query();
						}
						
					}
					$data['jmlscor']=$jmlpoint;
					$data['ratascor']=round($jmlpoint/count($_POST['otentik']),2);
					echo json_encode($data);
				die();
			}
			
			

			
			$data['pelajaran'] 	=$this->ad_pelajaran->getdataById($id_pelajaran);
			
			
			if(!empty($data['otentik'])){
			foreach($data['otentik'] as $dtaff){
				$jmlpoint=$jmlpoint+$dtaff['point'][0]['point'];
			}
			}
			$data['jmlpoint']=$jmlpoint;
			$data['ratapoint']=@round($jmlpoint/count($data['otentik']),2);
			$data['pelajaran'] 	=$this->ad_pelajaran->getdataById($_POST['id_pelajaran']);
            $data['main']= 'akademik/instrumen/otentik';
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
					@$in['id_pertemuan']=$id_pemb;
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
			$this->load->model('ad_instrumen');
			
			if(isset($_POST['id_pembelajaran'])){
				$data['psikomotorik'] 	=array();
			}else{
				$data['psikomotorik'] 	=$this->ad_instrumen->getIndikatorByPegSmTaSk('psikomotorik',$id_pembelajaran);			
			}
			//kondisi bukan dari awal
			if(!isset($_POST['id_pembelajaran']) && $id_pembelajaran!=0){
				$data['id_pembelajaran'] =base64_encode(json_encode(array($id_pembelajaran)));
				$_POST['id_pembelajaran']=$id_pembelajaran;
			}else{
				$data['id_pembelajaran'] =$_POST['id_pembelajaran'];
			}
			$data['pelajaran'] 	=$this->ad_pelajaran->getdatabySemesterJenjangJurusanPegawaimengajar();
            $data['main']= 'akademik/instrumen/psikomotorik';
            $this->load->view('layout/ad_blank',$data);
		}
		
        
        public function hapusindikator($id=0){
			$this->db->query('DELETE FROM ak_rencana_indikator WHERE id=?',array($id));
			$data['main']= 'akademik/instrumen/sukses';
            $this->load->view('layout/ad_blank',$data);
		}
        public function sukses($inikator){
			$data['indikator']=$inikator;
			$data['main']= 'akademik/instrumen/sukses';
            $this->load->view('layout/ad_blank',$data);
		}
    }
?>