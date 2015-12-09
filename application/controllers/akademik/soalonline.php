<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Soalonline extends CI_Controller
    {
		var $upload_dir='upload/akademik/soalonline/';
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
			$data['soalonline']=array();
			$data['kelas'] 	=$this->ad_kelas->getkelasByPengajar($this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['user_authentication']['id_pengguna']);
            $data['main']= 'akademik/soalonline/index';
            $this->load->view('layout/ad_blank',$data);
        }
		public function upload($id_soalonline=0)
        {
			if(isset($_POST['id_soalonline']) && isset($_POST['fileName'])){
				if($this->db->insert('ak_soalonline_file', array('id_soalonline'=>$_POST['id_soalonline'],'file_name'=>''.$_POST['fileName'].'','source'=>'upload'))){
					echo 'null';
				}else{
					echo 'Gagal menyimpan data';
				}
			}
		}
		/*public function upload($id_soalonline)
        {
			if(isset($_FILES)){
			if(!empty($_FILES)){
				//pr($_FILES);
				foreach ($_FILES["file"]["error"] as $key => $error) {
					if ($error == UPLOAD_ERR_OK) {
						$name = date('Ymdhis').str_replace(" ","",$_FILES["file"]["name"][$key]);
						if(!in_array($_FILES["file"]["type"][$key], $this->denied_mime_types)){
							if(move_uploaded_file( $_FILES["file"]["tmp_name"][$key], $this->upload_dir . $name)){
								$this->db->insert('ak_soalonline_file', array('id_soalonline'=>$id_soalonline,'file_name'=>''.$name.'','source'=>'upload'));
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

        }*/
        public function getSoalonlineStok($id_pelajaran)
        { 
			
			$this->load->model('ad_soalonline');
			$soalonline =$this->ad_soalonline->getSoalonlineStok($id_pelajaran);
			if(empty($soalonline)){
				echo '<option value="">MATERI TIDAK TERSEDIA</option>';
			}else{
				echo '<option value="">Pilih Soalonline</option>';
				foreach($soalonline as $dsoalonline){
					echo '<option value="'.$dsoalonline['id'].'">'.$dsoalonline['pokok_bahasan'].'</option>';
				}
			}
			
		}
        public function kirimsoalonline()
        { 
			//$this->load->model('ad_kelas');
			$this->load->library('smsprivate');
			//$this->smsprivate->send_by_kelas(525,'gfhfh');
			$this->load->model('ad_pelajaran');
			//$data['kelas'] 	=$this->ad_kelas->getkelasByPengajar($this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['user_authentication']['id_pengguna']);
			$data['pelajaran'] 	=$this->ad_pelajaran->getdatabySemesterJenjangJurusanPegawaimengajar();
			if($_POST['id_kelas']){
				foreach($_POST['id_kelas'] as $id_kelas){
						$insert_detail=array('id_soalonline'=>$_POST['id_soalonline'],
											 'id_kelas'=>$id_kelas,
											 'tanggal'=>date('Y-m-d H:i:s'),
											 'tanggal_diajarkan'=>$_POST['tanggal_diajarkan'],
											 'keterangan'=>$_POST['keterangan'],
											);
						//notifikasi
						$this->load->library('ak_notifikasi');
						$this->ak_notifikasi->set_notifikasi_akademik_per_kelas($id_kelas,$gorup_notif='soalonline',$_POST['id_pelajaran'],$_POST['pokok_bahasan'],$this->session->userdata['user_authentication']['id_pengguna'],$_POST['keterangan'],$_POST['id_soalonline'],'soalonline');
						
						$this->db->insert('ak_soalonline_kirim',$insert_detail);
						$this->smsprivate->send_by_kelas($id_kelas,$_POST['keterangan'],'soalonline',$_POST['id_soalonline']);
						
				}
				
				
			}
			//pr($data['pelajaran']);
		    $data['main']= 'akademik/soalonline/kirimsoalonline';
            $this->load->view('layout/ad_blank',$data);
		}
        public function addsoalonline()
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
					
				$this->db->insert('ak_soalonline_pelajaran',$datainsert);
				$id_soalonline=mysql_insert_id();
					if(isset($_POST['cnrbljr']) && !empty($_POST['cnrbljr'])){
							foreach($_POST['cnrbljr'] as $datacntbljr){
								$dtxbn=unserialize(base64_decode($datacntbljr));
								$this->db->insert('ak_soalonline_file', array('id_soalonline'=>$id_soalonline,'file_name'=>'upload/contentsekolah/'.$dtxbn['jenjang'].'/'.$dtxbn['kelasdir'].'/'.$dtxbn['pelajaran'].'/'.$dtxbn['filename'].'','source'=>'content_belajar'));
								//$this->db->insert('ak_soalonline_file', array('id_soalonline'=>$id_soalonline,'file_name'=>$dtxbn['filename'],'source'=>'content_belajar'));
							}
					}
					
				if(isset($_POST['id_kelas'])){
					$this->load->library('smsprivate');
					foreach($_POST['id_kelas'] as $id_kelas){
						$insert_detail=array('id_soalonline'=>$id_soalonline,
											 'id_kelas'=>$id_kelas,
											 'tanggal'=>date('Y-m-d H:i:s'),
											// 'tanggal_diajarkan'=>$_POST['tanggal_diajarkan'],
											 'keterangan'=>$_POST['keterangan'],
											);
											
						$this->db->insert('ak_soalonline_kirim',$insert_detail);
						$this->smsprivate->send_by_kelas($id_kelas,$_POST['keterangan'],'soalonline',$id_soalonline);
						//notifikasi
						$this->load->library('ak_notifikasi');
						$this->ak_notifikasi->set_notifikasi_akademik_per_kelas($id_kelas,$gorup_notif='soalonline',$_POST['id_pelajaran'],$_POST['pokok_bahasan'],$datainsert['id_pegawai'],$_POST['keterangan'],$id_soalonline,'soalonline');
						//$this->load->model('ad_notifikasi');
						//$this->ad_notifikasi->add_notif_sms_ortu_perkelas($id_kelas,$_POST['id_pelajaran'],$data=array('group'=>'soalonline'));
						//end notifikasi
						
					}
					

				}
				
				echo $id_soalonline;
				die();
			}
			
			//$this->load->model('ad_kelas');
			$this->load->model('ad_pelajaran');
			//$data['kelas'] 	=$this->ad_kelas->getkelasByPengajar($this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['user_authentication']['id_pengguna']);
			$data['pelajaran'] 	=$this->ad_pelajaran->getdatabySemesterJenjangJurusanPegawaimengajar();
			//pr($data['pelajaran']);
			$data['upload_dir'] 	=base64_encode('../../../../upload/akademik/soalonline/');
			$data['main']= 'akademik/soalonline/addsoalonline';
            $this->load->view('layout/ad_blank',$data);				
		}
		
        public function editsoalonline($id)
        {   
			if(isset($_POST['keterangan'])){ 
				
				$id_soalonline=$_POST['id']; 	 	 	 	 	 	 	 	 	 	 	 	 	 
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
				$this->db->update('ak_soalonline_pelajaran',$datainsert);
					
					if(isset($_POST['cnrbljr']) && !empty($_POST['cnrbljr'])){
							foreach($_POST['cnrbljr'] as $datacntbljr){
								$dtxbn=unserialize(base64_decode($datacntbljr));
								$this->db->insert('ak_soalonline_file', array('id_soalonline'=>$id_soalonline,'file_name'=>'upload/contentsekolah/'.$dtxbn['jenjang'].'/'.$dtxbn['kelasdir'].'/'.$dtxbn['pelajaran'].'/'.$dtxbn['filename'].'','source'=>'content_belajar'));
								//$this->db->insert('ak_soalonline_file', array('id_soalonline'=>$id_soalonline,'file_name'=>$dtxbn['filename'],'source'=>'content_belajar'));
							}
					}
				if(isset($_POST['id_kelas']) AND !empty($_POST['id_kelas'])){
					foreach($_POST['id_kelas'] as $id_kelas){
						$insert_detail=array('id_soalonline'=>$id_soalonline,
											 'id_kelas'=>$id_kelas,
											 'tanggal'=>date('Y-m-d H:i:s')
											);
											
						$this->db->insert('ak_soalonline_kirim',$insert_detail);
						
						//notifikasi
						$this->load->library('ak_notifikasi');
						$this->ak_notifikasi->set_notifikasi_akademik_per_kelas($id_kelas,$gorup_notif='soalonline',$_POST['id_pelajaran'],$_POST['pokok_bahasan'],$datainsert['id_pegawai'],$_POST['keterangan'],$id_soalonline,'soalonline');
						//$this->load->model('ad_notifikasi');
						//$this->ad_notifikasi->add_notif_sms_ortu_perkelas($id_kelas,$_POST['id_pelajaran'],$data=array('group'=>'soalonline'));
						//end notifikasi
						
					}				
				}
				
				echo $id_soalonline;
				die();
			}
			
			$this->load->model('ad_soalonline');
			$this->load->model('ad_kelas');
			$this->load->model('ad_pelajaran');
			$data['upload_dir'] 	=base64_encode('../../../../upload/akademik/soalonline/');
			$data['soalonline'] 	=$this->ad_soalonline->getSoalonlineById($id);
			$data['files'] 	=$this->ad_soalonline->getFileSoalonlineById_soalonline($id);
			$data['kelaspenerima'] 	=$this->ad_soalonline->getIdKelasPenerima($id);
			
			foreach($data['kelaspenerima'] as $kelaspenerimadto){
				$kelaspenerima2[$kelaspenerimadto['id']]=$kelaspenerimadto['id'];
			}
			$data['kelaspenerima2']=$kelaspenerima2;

			$data['kelas'] 	=$this->ad_kelas->getKelasByPelajaranMengajar($data['soalonline'][0]['id_pelajaran'],$this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['ak_setting']['semester'],$this->session->userdata['user_authentication']['id_pengguna']);
			$data['pelajaran'] 	=$this->ad_pelajaran->getdatabySemesterJenjangJurusanPegawaimengajar($this->session->userdata['ak_setting']['semester']);
			
			$data['main']= 'akademik/soalonline/editsoalonline';
            $this->load->view('layout/ad_blank',$data);				
		}
		public function getOptionFileSoalonlineByIdSoalonline($id_soalonline=null)
        {
			$this->load->library('ak_soalonline');
			echo $this->ak_soalonline->createOptionFileSoalonlineByIdSoalonline($id_soalonline);
		}
		public function deletefile($id=null)
        {	
		
			$this->load->model('ad_soalonline');
			$datafile=$this->ad_soalonline->getFileSoalonlineById($id);
			//pr($datafile);
			
			if($this->db->query('DELETE FROM ak_soalonline_file WHERE id='.$id.'')){
				if(file_exists($this->upload_dir.$datafile[0]['file_name'])){
					unlink($this->upload_dir.$datafile[0]['file_name']);
				}
			}
		}
		public function delete($id_soalonline=null)
        {	
			$this->load->model('ad_soalonline');
			$datafile=$this->ad_soalonline->getFileMatById_mat($id_soalonline);
			
			//delete file
			foreach($datafile as $datainfile){
				$this->deletefile($datainfile['id']);
			}
			
			//delete data
			//$this->db->query('DELETE FROM ak_soalonline_kirim WHERE id_soalonline='.$id_soalonline.'');
			if($this->db->query('DELETE FROM ak_soalonline_pelajaran WHERE id='.$id_soalonline.'') && $this->db->query('DELETE FROM ak_soalonline_kirim WHERE id_soalonline='.$id_soalonline.'')){
				echo 1;
			}else{
				echo 0;
			}
		}
		
        public function daftarsoalonlinelist($pelajaran=0,$id_kelas=0,$start=0,$page=0,$id_pengguna=0,$kepsek='')
        {
			if($start==1){$start=0;}
			if(isset($_POST['kepsek'])){$kepsek=$_POST['kepsek'];}
			if(isset($_POST['id_pengguna'])){$id_pengguna=$_POST['id_pengguna'];}
			$data['kepsek']   = $kepsek;
			$data['id_pengguna']   = $id_pengguna;
			if(isset($_POST['pelajaran'])){$pelajaran=$_POST['pelajaran'];}
			if(isset($_POST['id_kelas'])){$id_kelas=$_POST['id_kelas'];}
			$this->load->model('ad_soalonline');
			//$soalonline=$this->ad_soalonline->getsoalonlineByKelasPelajaranIdPegawaiAll($_POST['pelajaran'],$_POST['id_kelas']);
			
			$this->load->library('pagination');
			
			$config['base_url']   = site_url('akademik/soalonline/daftarsoalonlinelist/'.$pelajaran.'/'.$id_kelas.'');
			$config['per_page'] = $data['per_page'] = 10;
			
			//$config['uri_segment']   = 5;
			$config['cur_page']   = $start;
			$data['cur_page']   = $page;
			$data['start'] = $start;
			$config['total_rows'] = $this->ad_soalonline->getsoalonlineByKelasPelajaranIdPegawaiAllCount($pelajaran,$id_kelas,$id_pengguna);
			//pr($config['total_rows']);
            $soalonline =$this->ad_soalonline->getsoalonlineByKelasPelajaranIdPegawaiAll($pelajaran,$id_kelas,$start,$config['per_page'],$id_pengguna);
			$id_soalonlinesemua = @array_map(function($var){ return $var['id']; }, $soalonline);
			$terkirim=$this->ad_soalonline->getsoalonlineByKelasPelajaranIdPegawaiKirim($pelajaran,$id_kelas,$id_soalonlinesemua,$start,$config['per_page'],$id_pengguna);
			$this->pagination->initialize($config);
			$data['link'] = $this->pagination->create_links();
			//$data['pagination'] = $this->pagination->create_links();
			//$data['paginationob'] = $this->pagination;
			
			/*$configk['base_url']   = site_url('akademik/soalonline/daftarsoalonlinelist/'.$pelajaran.'/'.$id_kelas.'');
			$configk['per_page']   = 3;
			//$config['uri_segment']   = 5;
			$configk['cur_page']   = $start;
			$data['start'] = $start;
			$configk['total_rows'] = $this->ad_soalonline->getsoalonlineByKelasPelajaranIdPegawaiKirimCount($pelajaran,$id_kelas,$id_pengguna);
            $terkirim =$this->ad_soalonline->getsoalonlineByKelasPelajaranIdPegawaiKirim($pelajaran,$id_kelas,$start,$configk['per_page']);
			$this->pagination->initialize($configk);
			$data['paginationk'] = $this->pagination->create_links();*/
			
			
			$telahdikirim=array();
			$soalonline2=array();
		
			if(!empty($soalonline)){
				$filesoalonline=$this->ad_soalonline->getFileSoalonlineInId($id_soalonlinesemua);
				foreach($soalonline as $ky=>$datasoalonline){

					if(isset($terkirim[$datasoalonline['id']])){
						$telahdikirim[$datasoalonline['id']]=$datasoalonline;
						foreach($filesoalonline as $dtfile){
							if($dtfile['id_soalonline']==$datasoalonline['id']){
								$telahdikirim[$datasoalonline['id']]['file'][]=$dtfile;
							}
						}
						$telahdikirim[$datasoalonline['id']]['dikirim']=$terkirim[$datasoalonline['id']];
					}else{
						$soalonline2[$ky]=$datasoalonline;
						foreach($filesoalonline as $dtfile){
							if($dtfile['id_soalonline']==$datasoalonline['id']){
								$soalonline2[$ky]['file'][]=$dtfile;
							}
						}
					}
				}
				//pr($soalonline2);
				$soalonline=array_merge($telahdikirim,$soalonline2);
			}
			unset($soalonline2);
			$data['soalonline']=$soalonline;
			$data['terkirim']=$telahdikirim;
			$data['main']= 'akademik/soalonline/daftarsoalonlinelist';
            $this->load->view('layout/ad_blank',$data);	
		}
        
    public function getKelasByPelajaranAndPegawai($id_pelajaran=0,$id_kelas=0)
    {
       $this->load->model('ad_soalonline');
	   $kelas=$this->ad_soalonline->getKelasByPelajaranMengajar($id_pelajaran,$this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['ak_setting']['semester'],$this->session->userdata['user_authentication']['id_pengguna']);
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