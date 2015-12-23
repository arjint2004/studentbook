<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Absensi extends CI_Controller
    {
        public function __construct()
        {
            parent::__construct();
            $this->load->helper('global');
            $this->load->library('session');
            $this->load->library('auth');
            $this->auth->user_logged_in();
            $this->load->library('image_moo');
        }
		private function get_data_program_peasantren(){
				$this->load->model('ad_penghubungortutk');
				$contentprogram=$this->ad_penghubungortutk->getdataByIdSekolah($this->session->userdata['user_authentication']['id_sekolah'],'perkembangan_tk',$this->session->userdata['ak_setting']['semester']);
				$contentprograms[0]['contarr']=unserialize($contentprogram[0]['content']);
				foreach($contentprograms[0]['contarr'] as $ftlr){
					if($ftlr['nama']=='KLASIKAL' || $ftlr['nama']=='PEMBIASAAN'){
						$datause[$ftlr['nama']]=$ftlr['child'];
						foreach($datause[$ftlr['nama']] as $idd=>$vbg){
							unset($datause[$ftlr['nama']][$idd]);
							$datause[$ftlr['nama']][]=$vbg['nama'];
						}
					}
				}
				return $datause;
		}
        public function index(){//phpinfo();die();
			$this->load->model('ad_kelas');
            $data['kelas'] 	=$this->ad_kelas->getkelasByPengajar($this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['user_authentication']['id_pengguna']);
            
			if($this->session->userdata['ak_setting']['jenjang'][0]['bentuk']=="PESANTREN"){
				$data['program']=$this->get_data_program_peasantren();
			}
			
			
            $data['main']= 'akademik/absensi/index';
            $this->load->view('layout/ad_blank',$data);
        }
        public function tanggalcek(){
			echo date("Y-m-d H:i:s");
			echo phpinfo();
        }
        public function rekapabsensi(){
			
			$this->load->model('ad_kelas');
            $data['kelas'] 	=$this->ad_kelas->getkelasByPengajar($this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['user_authentication']['id_pengguna']);
           	
			//khusus pesanteren
			if($this->session->userdata['ak_setting']['jenjang'][0]['bentuk']=="PESANTREN"){
				$data['program']=$this->get_data_program_peasantren();
			}
			
            $data['main']= 'akademik/absensi/rekapabsensi';
            $this->load->view('layout/ad_blank',$data);
        }
        public function hapusabsensi(){
			$par=unserialize(base64_decode($_POST['params']));
			if($this->db->query("DELETE FROM ak_absensi WHERE tanggal='".$par['tglabs']."' AND id_kelas=".$par['klsabs']." AND jam_ke=".$par['jamkeabs']."")){
				echo 1;
			}else{
				echo 0;
			}
			
		}
        public function rekapabsensidata(){
			$this->load->model('ad_siswa');
			$this->load->model('ad_absen');	
			
			//khusus pesanteren
 			if($this->session->userdata['ak_setting']['jenjang'][0]['bentuk']=="PESANTREN"){
				$data['absensi']=$this->ad_absen->getAbsensiPesantrenByMonthByKelasPel($_POST['month'],$_POST['id_kelas']);
			}else{
				$data['absensi']=$this->ad_absen->getAbsensiByMonthByKelasPel($_POST['month'],$_POST['id_kelas']);
			}     
			$data['id_kelas']=$_POST['id_kelas'];
            $data['siswa']= $this->ad_siswa->getsiswaByIdKelas($_POST['id_kelas']);
            $data['main']= 'akademik/absensi/rekapabsensidata';
            $this->load->view('layout/ad_blank',$data);
        }
        public function printrekapabsensidata(){
			$this->load->model('ad_siswa');
			$this->load->model('ad_absen');	
			$this->load->model('ad_kelas');	
           // pr($_POST);
			$data['walikelas']=$this->ad_kelas->getWaliKelasByIdKelas($_POST['kelas']);
			$data['kelas']=$this->ad_kelas->getkelasById($this->session->userdata['user_authentication']['id_sekolah'],$_POST['kelas']);
			if($this->session->userdata['ak_setting']['jenjang'][0]['bentuk']=="PESANTREN"){
				$data['absensi']=$this->ad_absen->getAbsensiPesantrenByMonthByKelasPel($_POST['month'],$_POST['kelas']);
			}else{
				$data['absensi']=$this->ad_absen->getAbsensiByMonthByKelasPel($_POST['month'],$_POST['kelas']);
			}   
            $data['siswa']= $this->ad_siswa->getsiswaByIdKelas($_POST['kelas']);
			//pr($_POST);
			//pr($data['absensi']);
            $data['main']= 'akademik/absensi/printrekapabsensidata';
            $this->load->view('layout/ad_blank',$data);
        }
        public function add(){
			$this->load->model('ad_absen');			
			$this->load->model('ad_sms');			
			$this->load->model('ad_notifikasi');		
			$this->load->library('ak_notifikasi');
			if(isset($_POST['tanggal'])){
				$currentabsen=$this->ad_absen->getCurrentAbsensi($_POST['tanggal'],$_POST['jamabsen']);
			}else{
				$currentabsen=$this->ad_absen->getCurrentAbsensi(date('Y-m-d'),$_POST['jamabsen']);
			}
			
			$currentabsen2=array();
			foreach($currentabsen as $ky=>$dt){
				$currentabsen2[$dt['id_siswa_det_jenjang']]=$dt;
			}
			

			//pr($currentabsen2);
			if(isset($_POST['absen'])){
				$currentsms=$this->ad_sms->getCurrentSms($_POST['tanggal']);
				//pr($currentsms);
				$currentsms2=array();
				foreach($currentsms as $kysms=>$dtsms){
					$currentsms2[$dtsms['id_det_jenjang']]=$dtsms;
				}
				unset($currentsms);
				//pr($_POST['absen']);
				if($this->session->userdata['ak_setting']['jenjang'][0]['nama']=='SD'){
					$_POST['jamabsen']='';
					$_POST['pelajaranabsen']='';
					$_POST['pelajarannyaabsen']='';
				}
				$datasisfornotif=$this->db->query('SELECT adj.id as id_siswa_det_jenjang,adj.id_siswa,p.id as id_ortu FROM ak_det_jenjang adj JOIN ak_pegawai p ON adj.id_siswa=p.id_siswa WHERE adj.id_kelas=?',array($_POST['id_kelas']))->result_array();
				$datasisfornotif2=array();
				foreach($datasisfornotif as $arrsiswanotif){
					$datasisfornotif2[$arrsiswanotif['id_siswa_det_jenjang']]=$arrsiswanotif;
				}
				unset($datasisfornotif);
				//pr($datasisfornotif2);die();
				if(empty($currentabsen)){
					foreach($_POST['absen'] as $id_siswa_det_jenjang=>$databsen){
						$datainsert=array(
									'id_siswa_det_jenjang'=>$id_siswa_det_jenjang,
									'id_sekolah'=>$this->session->userdata['user_authentication']['id_sekolah'],
									'id_kelas'=>$_POST['id_kelas'],
									'id_semester'=>$this->session->userdata['ak_setting']['semester'],
									'id_pelajaran'=>$_POST['pelajaranabsen'],
									'id_pegawai'=>$this->session->userdata['user_authentication']['id_pengguna'],
									'absensi'=>$databsen,
									'jam'=>date("H:i:s"),
									'jam_ke'=>$_POST['jamabsen'],
									'tanggal'=>$_POST['tanggal'],
									'id_ta'=>$this->session->userdata['ak_setting']['ta'],
									'keterangan'=>$_POST['keterangan'][$id_siswa_det_jenjang],
									'aktifitas'=>$_POST['aktifitas'],
									'kegiatan'=>$_POST['kegiatan']
						);
						$this->db->insert('ak_absensi',$datainsert);
						
						//notifikasi
						$this->ak_notifikasi->set_notifikasi($datasisfornotif2[$id_siswa_det_jenjang]['id_siswa'],'absensi',12,$this->session->userdata['user_authentication']['nama'],'ke kelas '.$_POST['nama_kelas'].' Ananda <b>'.strtoupper($_POST['nama'][$id_siswa_det_jenjang]).'</b> Absensi <b>'.$databsen.'</b> Keterangan : '.$_POST['keterangan'][$id_siswa_det_jenjang].' ',$id_information=0,$jenis_information='');
						$this->ak_notifikasi->set_notifikasi($datasisfornotif2[$id_siswa_det_jenjang]['id_ortu'],'absensi',14,$this->session->userdata['user_authentication']['nama'],'ke kelas '.$_POST['nama_kelas'].' Ananda <b>'.strtoupper($_POST['nama'][$id_siswa_det_jenjang]).'</b> Absensi <b>'.$databsen.'</b> Keterangan : '.$_POST['keterangan'][$id_siswa_det_jenjang].' ',$id_information=0,$jenis_information='');
						
						//save sms dinonaktifkan
						/*$data=array(
									'absensi'=>$databsen,
									'jam_ke'=>$_POST['jamabsen'],
									'group'=>'absensi',
									'waktu'=>''.$_POST['tanggal'].' '.date("H:i:s").''
						);
						
						if(empty($currentsms2)){
							$this->ad_notifikasi->add_notif_sms_ortu_per_siswa_detjenjang_absen($id_siswa_det_jenjang,$data);
						}else{
							$this->ad_notifikasi->add_notif_sms_ortu_per_siswa_detjenjang_absenedit($currentsms2,$id_siswa_det_jenjang,$databsen);
						}*/
						
					}
					
					
					$this->ak_notifikasi->set_notifikasi($this->session->userdata['ak_setting']['id_kepsek'],'absensi',16,$this->session->userdata['user_authentication']['nama'],'<b>ke kelas '.$_POST['nama_kelas'].'</b>',$id_information=0,$jenis_information='');
				
				}else{
					foreach($_POST['absen'] as $id_siswa_det_jenjang=>$databsen){
						
						

						$datainsert=array(
									'id_siswa_det_jenjang'=>$id_siswa_det_jenjang,
									'id_sekolah'=>$this->session->userdata['user_authentication']['id_sekolah'],
									'id_kelas'=>$_POST['id_kelas'],
									'id_semester'=>$this->session->userdata['ak_setting']['semester'],
									'id_pelajaran'=>$_POST['pelajaranabsen'],
									'absensi'=>$databsen,
									'jam'=>date("H:i:s"),
									'jam_ke'=>$_POST['jamabsen'],
									'tanggal'=>$_POST['tanggal'],
									'id_ta'=>$this->session->userdata['ak_setting']['ta'],
									'keterangan'=>$_POST['keterangan'][$id_siswa_det_jenjang]
						);
						$this->db->where('id',$currentabsen2[$id_siswa_det_jenjang]['id']);				
						$this->db->update('ak_absensi',$datainsert);
						
						//penyambungan text sms
						/*if (strpos($textsms[1],$_POST['jamabsen']) !== false) {

						}else{
							if($databsen=='masuk'){
								$textsms=explode("|",$currentsms2[$id_siswa_det_jenjang]['notifikasi']);
								$sambungsms=$textsms[1].','.$_POST['jamabsen'].$textsms[1];				
							}
						}*/
						$this->ad_notifikasi->add_notif_sms_ortu_per_siswa_detjenjang_absenedit($currentsms2,$id_siswa_det_jenjang,$databsen);
						//echo $this->db->last_query().'<br />';
						
					}
				}
				
			}

			if(!empty($currentabsen2)){
				$data['siswacek']=$currentabsen2;
			}
			
			//pr($currentabsen2);
			$this->load->model('ad_siswa');
            
            $data['siswa']= $this->ad_siswa->getsiswaByIdKelas($_POST['id_kelas']);
			
            $data['main']= 'akademik/absensi/add';
            $this->load->view('layout/ad_blank',$data);
        }        
        
        
        
    }
?>