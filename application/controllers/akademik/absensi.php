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
        
        public function index(){
			$this->load->model('ad_kelas');
            $data['kelas'] 	=$this->ad_kelas->getkelasByPengajar($this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['user_authentication']['id_pengguna']);
           
            $data['main']= 'akademik/absensi/index';
            $this->load->view('layout/ad_blank',$data);
        }
        public function add(){
			$this->load->model('ad_absen');			
			$this->load->model('ad_sms');			
			$this->load->model('ad_notifikasi');			
			if(isset($_POST['tanggal'])){
				$currentabsen=$this->ad_absen->getCurrentAbsensi($_POST['tanggal'],$_POST['jamabsen']);
			}else{
				$currentabsen=$this->ad_absen->getCurrentAbsensi(date('Y-m-d'),$_POST['jamabsen']);
			}
			
			$currentabsen2=array();
			foreach($currentabsen as $ky=>$dt){
				$currentabsen2[$dt['id_siswa_det_jenjang']]=$dt;
			}
			

			//pr($currentsms2);
			//pr($currentabsen2);
			if(isset($_POST['absen'])){			
				$currentsms=$this->ad_sms->getCurrentSms($_POST['tanggal']);
				$currentsms2=array();
				foreach($currentsms as $kysms=>$dtsms){
					$currentsms2[$dtsms['id_det_jenjang']]=$dtsms;
				}
				unset($currentsms);
				//pr($_POST['absen']);
				if(empty($currentabsen)){
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
						$this->db->insert('ak_absensi',$datainsert);
						
						$data=array(
									'absensi'=>$databsen,
									'jam_ke'=>$_POST['jamabsen'],
									'group'=>'absensi',
									'waktu'=>''.$_POST['tanggal'].' '.date("H:i:s").''
						);
						if(empty($currentsms2)){
							$this->ad_notifikasi->add_notif_sms_ortu_per_siswa_detjenjang_absen($id_siswa_det_jenjang,$data);
						}
						
					}
					
					$this->load->library('ak_notifikasi');
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
						if($databsen=='masuk'){$databsen='hadir';}
						$textsms=explode("|",$currentsms2[$id_siswa_det_jenjang]['notifikasi']);
						$sambungsms=$textsms[0].'|'.$databsen.'|'.$textsms[2];
						
						$this->db->query('
										UPDATE ak_notifikasi_sms SET
										notifikasi="'.$sambungsms.'"
										WHERE
										id_sekolah='.$this->session->userdata['user_authentication']['id_sekolah'].'
										AND id_det_jenjang='.$id_siswa_det_jenjang.'
										AND `group`="absensi"
										AND date(`waktu`) = "'.$_POST['tanggal'].'"
										
						');
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