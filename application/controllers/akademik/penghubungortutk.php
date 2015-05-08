<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class penghubungortutk extends CI_Controller
    {
        var $upload_dir='upload/akademik/jurnalwali/';
        var $upload_dirpeng='upload/akademik/penghubungortutk/';
		public $denied_mime_types = array('application/x-php','application/x-asp','application/x-httpd-php', 'text/html', 'text/css', 'text/javascript'); //array of denied mime types used when check_file_type is set to denied
        
		public function __construct()
        {
            parent::__construct();
            $this->load->library('session');
            $this->load->library('auth');
            $this->auth->user_logged_in();
        }
		
        public function index(){
		
			$this->load->model('ad_kelas');
			$data['kelas'] 	=$this->ad_kelas->getkelas($this->session->userdata['user_authentication']['id_sekolah']);
            $data['main']= 'akademik/penghubungortutk/index';
            $this->load->view('layout/ad_blank',$data);
        }

		public function getOptionSiswaByIdKelas($id_kelas){
			$this->load->library('ak_siswa');
			$optionsiswa=$this->ak_siswa->createOptionSiswaByIdKelasId_sis($id_kelas);
			echo $optionsiswa;
        }
        public function upload($id_jurnal)
        {
			if(isset($_FILES)){
			if(!empty($_FILES)){
				foreach ($_FILES["file"]["error"] as $key => $error) {
					if ($error == UPLOAD_ERR_OK) {
						$name = date('Ymdhis').str_replace(" ","",$_FILES["file"]["name"][$key]);
						if(!in_array($_FILES["file"]["type"][$key], $this->denied_mime_types)){
							if(move_uploaded_file($_FILES["file"]["tmp_name"][$key], $this->upload_dir . $name)){
								$this->db->insert('ak_jurnal_wali_file', array('id_jurnal'=>$id_jurnal,'file_name'=>''.$name.''));
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
        public function uploadfilepenghubung($id_peng)
        {
			if(isset($_FILES)){
			if(!empty($_FILES)){
				foreach ($_FILES["file"]["error"] as $key => $error) {
					if ($error == UPLOAD_ERR_OK) {
						$name = date('Ymdhis').str_replace(" ","",$_FILES["file"]["name"][$key]);
						if(!in_array($_FILES["file"]["type"][$key], $this->denied_mime_types)){
							if(move_uploaded_file($_FILES["file"]["tmp_name"][$key], $this->upload_dirpeng . $name)){
								$this->db->insert('ak_penghubung_file', array('id_penghubung'=>$id_peng,'file_name'=>''.$name.''));
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
		
		//penghubung ortu
		
        public function penghubungortulist($start=0,$page=0,$id_pengguna=0,$kepsek=0)
        {
			if($start==1){$start=0;}
			if(isset($_POST['kepsek'])){$kepsek=$_POST['kepsek'];}
			if(isset($_POST['id_pengguna'])){$id_pengguna=$_POST['id_pengguna'];}
			$data['kepsek']   = $kepsek;
			$data['id_pengguna']   = $id_pengguna;
			
			//data
			$this->load->model('ad_jurnal');
			$this->load->library('pagination');
			
			$config['base_url']   = site_url('akademik/penghubungortutk/penghubungortulist');
			$config['per_page']   = 15;

			$config['cur_page']   = $start;
			$config['total_rows'] = $this->ad_jurnal->getCountPenghubung($_POST['id_kelas'],$id_pengguna);
			$data['start'] = $start;
			
			$data['datahubung']=array();
			if(isset($_POST['id_kelas'])){
				$data['datahubung']=$this->ad_jurnal->getDataPenghubung($this->session->userdata['user_authentication']['id_sekolah'],$_POST['id_kelas'],''.$start.','.$config['per_page'].'');
				if(!empty($data['datahubung'])){
					foreach($data['datahubung'] as $ky=>$datapeng){
						$data['datahubung'][$ky]['file']=$this->ad_jurnal->getFilePengByIdPeng($datapeng['id']);
						$data['datahubung'][$ky]['siswa']=$this->ad_jurnal->getPengDikirim($datapeng['id']);
					}
				}
			}elseif($kepsek=='kepsek'){
				$data['datahubung']=$this->ad_jurnal->getDataPenghubung($this->session->userdata['user_authentication']['id_sekolah'],$_POST['id_kelas'],''.$start.','.$config['per_page'].'',$id_pengguna);
				if(!empty($data['datahubung'])){
					foreach($data['datahubung'] as $ky=>$datapeng){
						$data['datahubung'][$ky]['file']=$this->ad_jurnal->getFilePengByIdPeng($datapeng['id']);
						$data['datahubung'][$ky]['siswa']=$this->ad_jurnal->getPengDikirim($datapeng['id']);
					}
				}				
			}
			
			$this->pagination->initialize($config);
			$data['pagination'] = $this->pagination->create_links();
			//pr($config);
			$data['main']= 'akademik/penghubungortutk/penghubungortulist';
            $this->load->view('layout/ad_blank',$data);
		}
		
        public function penghubungortuedit(){
			$this->load->model('ad_kelas');
			$this->load->model('ad_jurnal');
			//pr($_POST);
			if($id_peng!=0){
				$data['dataedit']=$this->ad_jurnal->getdataPengById($id_peng);
				//pr($data['dataedit']);
			}
			
			$data['main']= 'akademik/penghubungortutk/penghubungortuedit';
            $this->load->view('layout/ad_blank',$data);
		}
        public function deletepeng()
        {
			$this->load->model('ad_jurnal');
			$file=$this->ad_jurnal->getFilePengByIdPeng($_POST['id']);
			foreach($file as $datap){
				if(file_exists($this->upload_dirpeng.$datap['file_name'])){
					unlink($this->upload_dirpeng.$datap['file_name']);
				}
			}
		//	pr($file);
			$this->db->query('DELETE FROM ak_penghubung WHERE id='.$_POST['id'].'');
			$this->db->query('DELETE FROM ak_penghubung_file WHERE id_penghubung='.$_POST['id'].'');
			$this->db->query('DELETE FROM ak_penghubung_kirim WHERE id_penghubung='.$_POST['id'].'');
			
		}
        public function penghubungortu()
        {
			//content perkembngan
			$this->load->model('ad_penghubungortutk');
			if(isset($_POST['program'])){
				pr($_POST);die();
			}
			$content=$this->ad_penghubungortutk->getdataByIdSekolah($this->session->userdata['user_authentication']['id_sekolah']);
			//$contentsiswa=$this->ad_penghubungortutk->getdataPengByIdSiswa($_POST['id_siswa']);
			$content[0]['contarr']=unserialize($content[0]['content']);
			$data['content']=$content;			
			//content perkembngan end
			
			$this->load->model('ad_kelas');
			
			$data1=$this->ad_kelas->getkelasByPengajar($this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['user_authentication']['id_pengguna']);
			$data2=$this->ad_kelas->getKelasByWali($this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['user_authentication']['id_pengguna']);
			$data['kelaslaporan']=array_merge($data1,$data2);
			if(isset($_POST['kepada'])){
					$this->load->library('smsprivate');
					if(in_array('siswa',$_POST['kepada'])){
						$siswaortu="siswa";
					}
					if(in_array('ortu',$_POST['kepada']) || in_array('siswaortu',$_POST['kepada'])){
						$siswaortu .="ortu";
					}else{
						
						if(in_array('ortu',$_POST['kepada'])){
							$siswaortu ="ortu";
						}
					}
				$insert=array(
						'id_ta'=>$this->session->userdata['ak_setting']['ta'],
						'semester'=>$this->session->userdata['ak_setting']['semester'],
						'id_sekolah'=>$this->session->userdata['user_authentication']['id_sekolah'],
						'id_pegawai'=>$this->session->userdata['user_authentication']['id_pengguna'],
						'subject'=>$_POST['subject'],
						'keterangan'=>$_POST['keterangan'],
						'kepada'=>$siswaortu,
						'tanggal'=>date('Y-m-d H:i:s'),
						'id_kelas'=>$_POST['id_kelas']
				);
				//pr($siswaortu);
				$this->db->insert('ak_penghubung',$insert);
				$id_peng=mysql_insert_id();
				$this->smsprivate->send_by_kelas($_POST['id_kelas'],$_POST['pesan'],'penghubungortu',$id_peng);
				//unset($_POST['id_siswa'][0]);
				$this->load->library('ak_notifikasi');
				$this->load->model('ad_notifikasi');
				
				foreach($_POST['id_siswa'] as $ky=>$id_siswax){
					$id_siswa=json_decode(base64_decode($id_siswax),true);
					if($id_siswa!=''){
						$this->db->insert('ak_penghubung_kirim',array('id_penghubung'=>$id_peng,'id_siswa'=>$id_siswa['id'],'siswaortu'=>$siswaortu));
						if($siswaortu=='siswa'){
							$this->ak_notifikasi->set_notifikasi($id_siswa['id'],'penghubung',12,$this->session->userdata['user_authentication']['nama'],$_POST['subject'],$id_information=0,$jenis_information='');
						}elseif($siswaortu=='ortu'){
							$this->ak_notifikasi->set_notifikasi($id_siswa['id_ortu'][$id_siswa['id']],'penghubung',14,$this->session->userdata['user_authentication']['nama'],$_POST['subject'],$id_information=0,$jenis_information='');
						}elseif($siswaortu=='siswaortu'){
							$this->ak_notifikasi->set_notifikasi($id_siswa['id'],'penghubung',12,$this->session->userdata['user_authentication']['nama'],$_POST['subject'],$id_information=0,$jenis_information='');
							$this->ak_notifikasi->set_notifikasi($id_siswa['id_ortu'][$id_siswa['id']],'penghubung',14,$this->session->userdata['user_authentication']['nama'],$_POST['subject'],$id_information=0,$jenis_information='');
						}
						
					}
					//$this->ad_notifikasi->add_notif_sms_ortu_per_siswa_detjenjang($id_siswa['id_siswa_det_jenjang'],0,$data=array('group'=>'penghubung'));
				}
				echo $id_peng;
				die();
			}

			
            $data['main']= 'akademik/penghubungortutk/penghubungortu';
            $this->load->view('layout/ad_blank',$data);
		}
		
    }
?>