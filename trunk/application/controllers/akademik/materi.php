<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Materi extends CI_Controller
    {
		var $upload_dir='upload/akademik/materi/';
        public $denied_mime_types = array('application/x-php','application/x-httpd-php', 'text/html', 'text/css', 'text/javascript'); //array of denied mime types used when check_file_type is set to denied
        public function __construct()
        {
            parent::__construct();
            $this->load->helper('global');
            $this->load->library('auth');
            $this->auth->user_logged_in();
        }
        
        public function index(){
			$this->load->model('ad_kelas');
			$data['materi']=array();
			$data['kelas'] 	=$this->ad_kelas->getkelasByPengajar($this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['user_authentication']['id_pengguna']);
            $data['main']= 'akademik/materi/index';
            $this->load->view('layout/ad_blank',$data);
        }
		public function upload($id_materi)
        {
			if(isset($_FILES)){
			if(!empty($_FILES)){
				//pr($_FILES);
				foreach ($_FILES["file"]["error"] as $key => $error) {
					if ($error == UPLOAD_ERR_OK) {
						$name = date('Ymdhis').str_replace(" ","",$_FILES["file"]["name"][$key]);
						if(!in_array($_FILES["file"]["type"][$key], $this->denied_mime_types)){
							if(move_uploaded_file( $_FILES["file"]["tmp_name"][$key], $this->upload_dir . $name)){
								$this->db->insert('ak_materi_file', array('id_materi'=>$id_materi,'file_name'=>''.$name.''));
							}
							//$out= 'allowed';
							
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
        public function getMateriStok($id_pelajaran)
        { 
			
			$this->load->model('ad_materi');
			$materi =$this->ad_materi->getMateriStok($id_pelajaran);
			if(empty($materi)){
				echo '<option value="">MATERI TIDAK TERSEDIA</option>';
			}else{
				echo '<option value="">Pilih Materi</option>';
				foreach($materi as $dmateri){
					echo '<option value="'.$dmateri['id'].'">'.$dmateri['pokok_bahasan'].'</option>';
				}
			}
			
		}
        public function kirimmateri()
        { 
			//$this->load->model('ad_kelas');
			$this->load->library('smsprivate');
			//$this->smsprivate->send_by_kelas(525,'gfhfh');
			$this->load->model('ad_pelajaran');
			//$data['kelas'] 	=$this->ad_kelas->getkelasByPengajar($this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['user_authentication']['id_pengguna']);
			$data['pelajaran'] 	=$this->ad_pelajaran->getdatabySemesterJenjangJurusanPegawaimengajar();
			if($_POST['id_kelas']){
				foreach($_POST['id_kelas'] as $id_kelas){
						$insert_detail=array('id_materi'=>$_POST['id_materi'],
											 'id_kelas'=>$id_kelas,
											 'tanggal'=>date('Y-m-d H:i:s'),
											 'tanggal_diajarkan'=>$_POST['tanggal_diajarkan'],
											 'keterangan'=>$_POST['keterangan'],
											);
						//notifikasi
						$this->load->library('ak_notifikasi');
						$this->ak_notifikasi->set_notifikasi_akademik_per_kelas($id_kelas,$gorup_notif='materi',$_POST['id_pelajaran'],$_POST['pokok_bahasan'],$this->session->userdata['user_authentication']['id_pengguna'],$_POST['keterangan'],$_POST['id_materi'],'materi');
						
						$this->db->insert('ak_materi_kirim',$insert_detail);
						$this->smsprivate->send_by_kelas($id_kelas,$_POST['keterangan'],'materi',$_POST['id_materi']);
						
				}
				
				
			}
			//pr($data['pelajaran']);
		    $data['main']= 'akademik/materi/kirimmateri';
            $this->load->view('layout/ad_blank',$data);
		}
        public function addmateri()
        {
			if(isset($_POST['id_pelajaran'])){ 	 
				$datainsert=array(
					'id_sekolah'=>$this->session->userdata['user_authentication']['id_sekolah'],
					'id_pegawai'=>$this->session->userdata['user_authentication']['id_pengguna'],
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
				if(isset($_POST['id_kelas'])){
					$this->load->library('smsprivate');
					foreach($_POST['id_kelas'] as $id_kelas){
						$insert_detail=array('id_materi'=>$id_materi,
											 'id_kelas'=>$id_kelas,
											 'tanggal'=>date('Y-m-d H:i:s'),
											// 'tanggal_diajarkan'=>$_POST['tanggal_diajarkan'],
											 'keterangan'=>$_POST['keterangan'],
											);
											
						$this->db->insert('ak_materi_kirim',$insert_detail);
						$this->smsprivate->send_by_kelas($id_kelas,$_POST['keterangan'],'materi',$id_materi);
						//notifikasi
						$this->load->library('ak_notifikasi');
						$this->ak_notifikasi->set_notifikasi_akademik_per_kelas($id_kelas,$gorup_notif='materi',$_POST['id_pelajaran'],$_POST['pokok_bahasan'],$datainsert['id_pegawai'],$_POST['keterangan'],$id_materi,'materi');
						//$this->load->model('ad_notifikasi');
						//$this->ad_notifikasi->add_notif_sms_ortu_perkelas($id_kelas,$_POST['id_pelajaran'],$data=array('group'=>'materi'));
						//end notifikasi
						
					}
				}
				
				echo $id_materi;
				die();
			}
			
			//$this->load->model('ad_kelas');
			$this->load->model('ad_pelajaran');
			//$data['kelas'] 	=$this->ad_kelas->getkelasByPengajar($this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['user_authentication']['id_pengguna']);
			$data['pelajaran'] 	=$this->ad_pelajaran->getdatabySemesterJenjangJurusanPegawaimengajar();
			//pr($data['pelajaran']);
			$data['main']= 'akademik/materi/addmateri';
            $this->load->view('layout/ad_blank',$data);				
		}
		
        public function editmateri($id)
        {   
			if(isset($_POST['keterangan'])){ 
				
				$id_materi=$_POST['id']; 	 	 	 	 	 	 	 	 	 	 	 	 	 
				$datainsert=array(
									'id_sekolah'=>$this->session->userdata['user_authentication']['id_sekolah'],
									'id_pegawai'=>$this->session->userdata['user_authentication']['id_pengguna'],
									'semester'=>$this->session->userdata['ak_setting']['semester'],
									//'id_pelajaran'=>$_POST['id_pelajaran'],
									'pokok_bahasan'=>$_POST['pokok_bahasan'],
									'bab'=>$_POST['bab'],
									'keterangan'=>$_POST['keterangan'],
									'tanggal_diberikan'=>$_POST['tanggal_diberikan'],
									'tanggal_buat'=>date("Y-m-d H:i:s"),
									'share'=>$_POST['share'],
				);
				$this->db->where('id',$_POST['id']);
				$this->db->update('ak_materi_pelajaran',$datainsert);
				
				if(isset($_POST['id_kelas']) AND !empty($_POST['id_kelas'])){
					foreach($_POST['id_kelas'] as $id_kelas){
						$insert_detail=array('id_materi'=>$id_materi,
											 'id_kelas'=>$id_kelas,
											 'tanggal'=>date('Y-m-d H:i:s')
											);
											
						$this->db->insert('ak_materi_kirim',$insert_detail);
						
						//notifikasi
						$this->load->library('ak_notifikasi');
						$this->ak_notifikasi->set_notifikasi_akademik_per_kelas($id_kelas,$gorup_notif='materi',$_POST['id_pelajaran'],$_POST['pokok_bahasan'],$datainsert['id_pegawai'],$_POST['keterangan'],$id_materi,'materi');
						//$this->load->model('ad_notifikasi');
						//$this->ad_notifikasi->add_notif_sms_ortu_perkelas($id_kelas,$_POST['id_pelajaran'],$data=array('group'=>'materi'));
						//end notifikasi
						
					}				
				}
				
				echo $id_materi;
				die();
			}
			
			$this->load->model('ad_materi');
			$this->load->model('ad_kelas');
			$this->load->model('ad_pelajaran');
			$data['materi'] 	=$this->ad_materi->getMateriById($id);
			$data['files'] 	=$this->ad_materi->getFileMateriById_materi($id);
			$data['kelaspenerima'] 	=$this->ad_materi->getIdKelasPenerima($id);
			
			foreach($data['kelaspenerima'] as $kelaspenerimadto){
				$kelaspenerima2[$kelaspenerimadto['id']]=$kelaspenerimadto['id'];
			}
			$data['kelaspenerima2']=$kelaspenerima2;

			$data['kelas'] 	=$this->ad_kelas->getKelasByPelajaranMengajar($data['materi'][0]['id_pelajaran'],$this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['ak_setting']['semester'],$this->session->userdata['user_authentication']['id_pengguna']);
			$data['pelajaran'] 	=$this->ad_pelajaran->getdatabySemesterJenjangJurusanPegawaimengajar($this->session->userdata['ak_setting']['semester']);
			
			$data['main']= 'akademik/materi/editmateri';
            $this->load->view('layout/ad_blank',$data);				
		}
		public function getOptionFileMateriByIdMateri($id_materi=null)
        {
			$this->load->library('ak_materi');
			echo $this->ak_materi->createOptionFileMateriByIdMateri($id_materi);
		}
		public function deletefile($id=null)
        {	
		
			$this->load->model('ad_materi');
			$datafile=$this->ad_materi->getFileMateriById($id);
			//pr($datafile);
			
			if($this->db->query('DELETE FROM ak_materi_file WHERE id='.$id.'')){
				if(file_exists($this->upload_dir.$datafile[0]['file_name'])){
					unlink($this->upload_dir.$datafile[0]['file_name']);
				}
			}
		}
		public function delete($id_materi=null)
        {	
			$this->load->model('ad_materi');
			$datafile=$this->ad_materi->getFileMatById_mat($id_materi);
			
			//delete file
			foreach($datafile as $datainfile){
				$this->deletefile($datainfile['id']);
			}
			
			//delete data
			//$this->db->query('DELETE FROM ak_materi_kirim WHERE id_materi='.$id_materi.'');
			if($this->db->query('DELETE FROM ak_materi_pelajaran WHERE id='.$id_materi.'') && $this->db->query('DELETE FROM ak_materi_kirim WHERE id_materi='.$id_materi.'')){
				echo 1;
			}else{
				echo 0;
			}
		}
		
        public function daftarmaterilist($pelajaran=0,$id_kelas=0,$start=0,$page=0)
        {
			if(isset($_POST['pelajaran'])){$pelajaran=$_POST['pelajaran'];}
			if(isset($_POST['id_kelas'])){$id_kelas=$_POST['id_kelas'];}
			$this->load->model('ad_materi');
			//$materi=$this->ad_materi->getmateriByKelasPelajaranIdPegawaiAll($_POST['pelajaran'],$_POST['id_kelas']);
			
			$this->load->library('pagination');
			
			$config['base_url']   = site_url('akademik/materi/daftarmaterilist/'.$pelajaran.'/'.$id_kelas.'');
			$config['per_page'] = $data['per_page'] = 10;
			
			//$config['uri_segment']   = 5;
			$config['cur_page']   = $start;
			$data['cur_page']   = $page;
			$data['start'] = $start;
			$config['total_rows'] = $this->ad_materi->getmateriByKelasPelajaranIdPegawaiAllCount($pelajaran,$id_kelas);
			//pr($config['total_rows']);
            $materi =$this->ad_materi->getmateriByKelasPelajaranIdPegawaiAll($pelajaran,$id_kelas,$start,$config['per_page']);
			$id_materisemua = @array_map(function($var){ return $var['id']; }, $materi);
			$terkirim=$this->ad_materi->getmateriByKelasPelajaranIdPegawaiKirim($pelajaran,$id_kelas,$id_materisemua,$start,$config['per_page']);
			$this->pagination->initialize($config);
			$data['link'] = $this->pagination->create_links();
			//$data['pagination'] = $this->pagination->create_links();
			//$data['paginationob'] = $this->pagination;
			
			/*$configk['base_url']   = site_url('akademik/materi/daftarmaterilist/'.$pelajaran.'/'.$id_kelas.'');
			$configk['per_page']   = 3;
			//$config['uri_segment']   = 5;
			$configk['cur_page']   = $start;
			$data['start'] = $start;
			$configk['total_rows'] = $this->ad_materi->getmateriByKelasPelajaranIdPegawaiKirimCount($pelajaran,$id_kelas);
            $terkirim =$this->ad_materi->getmateriByKelasPelajaranIdPegawaiKirim($pelajaran,$id_kelas,$start,$configk['per_page']);
			$this->pagination->initialize($configk);
			$data['paginationk'] = $this->pagination->create_links();*/
			
			
			$telahdikirim=array();
			$materi2=array();
		
			if(!empty($materi)){
				$filemateri=$this->ad_materi->getFileMateriInId($id_materisemua);
				foreach($materi as $ky=>$datamateri){

					if(isset($terkirim[$datamateri['id']])){
						$telahdikirim[$datamateri['id']]=$datamateri;
						foreach($filemateri as $dtfile){
							if($dtfile['id_materi']==$datamateri['id']){
								$telahdikirim[$datamateri['id']]['file'][]=$dtfile;
							}
						}
						$telahdikirim[$datamateri['id']]['dikirim']=$terkirim[$datamateri['id']];
					}else{
						$materi2[$ky]=$datamateri;
						foreach($filemateri as $dtfile){
							if($dtfile['id_materi']==$datamateri['id']){
								$materi2[$ky]['file'][]=$dtfile;
							}
						}
					}
				}
				//pr($materi2);
				$materi=array_merge($telahdikirim,$materi2);
			}
			unset($materi2);
			$data['materi']=$materi;
			$data['terkirim']=$telahdikirim;
			$data['main']= 'akademik/materi/daftarmaterilist';
            $this->load->view('layout/ad_blank',$data);	
		}
        
    public function getKelasByPelajaranAndPegawai($id_pelajaran=0,$id_kelas=0)
    {
       $this->load->model('ad_materi');
	   $kelas=$this->ad_materi->getKelasByPelajaranMengajar($id_pelajaran,$this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['ak_setting']['semester'],$this->session->userdata['user_authentication']['id_pengguna']);
		//echo $this->db->last_query();
	   $select ='';
	   $select ="<option value='0'>Pilih Kelas</option>";
	   foreach($kelas as $datakelas){
			if($id_kelas==$datakelas['id']){
				$slct="selected";
			}else{
				$slct="";
			}
			$select .="<option ".@$slct." id_mengajar='".$datakelas['id_mengajar']."' value='".$datakelas['id']."'>".$datakelas['kelas'].$datakelas['nama']."</option>";
	   }
	   echo $select;
	   die();
    }
    }
?>