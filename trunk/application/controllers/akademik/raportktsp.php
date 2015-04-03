<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Raportktsp extends CI_Controller
    {
		public function __construct()
        {
            parent::__construct();
            $this->load->helper('akademik');
            $this->load->library('session');
            $this->load->library('auth');
            $this->auth->user_logged_in();
        }
        public function index($id_det_jenjang=null)
        {
			$this->load->model('ad_siswa');
			$data['siswa']=$this->ad_siswa->getsiswaByIdKelas(@$_POST['id_kelas']);
			$data['main']= 'akademik/raport2013/index';
            $this->load->view('layout/ad_blank',$data);	
		}
		function getdatasiswa($id_det_jenjang){
			$this->load->model('ad_siswa');
			return $this->ad_siswa->getsiswaByIdDetJenjang($id_det_jenjang);
		}		
        public function lihat($param='')
        {
			$datasiswa=unserialize($this->myencrypt->decode($param));
			$this->load->library('ak_akademik');
			$this->load->model('ad_siswa');
			$this->load->model('ad_sekolah');
			$this->load->model('ad_kelas');
			$data['id_det_jenjang']=$datasiswa['id_siswa_det_jenjang'];
			$data['kelas']=$this->ad_kelas->getWaliByIdKelas($this->session->userdata['user_authentication']['id_sekolah'],$datasiswa['id_kelas']);
			
			//kepribadian
			$this->load->model('ad_kepribadian');
			$data['kepribadian']=$this->ad_kepribadian->getNilaiByidDetJenjangktsp($datasiswa['id_siswa_det_jenjang']);
			
			//pengembangan diri
			$this->load->model('ad_extrakurikuler');
			$data['pengembangandiri']=$this->ad_extrakurikuler->getNilaiByidDetJenjang($datasiswa['id_siswa_det_jenjang']);
			
			//absensi
			$this->load->model('ad_absen');
			$absensi=$this->ad_absen->getKetidakhadiranByIdDetjenjang($datasiswa['id_siswa_det_jenjang']);
			$data['absensi']['alpha']=0;$data['absensi']['sakit']=0;$data['absensi']['izin']=0;
			foreach($absensi as $databsen){
				if($databsen['absensi']=='alpha'){
					$data['absensi']['alpha']++;
				}
				if($databsen['absensi']=='sakit'){
					$data['absensi']['sakit']++;
				}
				if($databsen['absensi']=='izin'){
					$data['absensi']['izin']++;
				}
			}
			
			
			//raport
			$data['raport']=$this->ak_akademik->nilaiRaportPerSiswa($datasiswa['id_siswa_det_jenjang']);
			//unset($data['raport']['submapel']);
			//pr($data['nilai_kompt']);die();
			$data['siswa']=$this->ad_siswa->getsiswaByIdSiswa($datasiswa['id']);
			$data['sekolah']=$this->ad_sekolah->getSekolahdata($this->session->userdata['user_authentication']['id_sekolah']);
			$data['kepsek']=$this->ad_sekolah->getKepsek($this->session->userdata['user_authentication']['id_sekolah']);
			//pr($data['sekolah']);die();
			$data['main']= 'akademik/raportktsp/raport';
            $this->load->view('layout/ad_blank',$data);	
		}
        public function savemanual($param='')
        {
			$datasiswa=unserialize($this->myencrypt->decode($param));
			
			$this->load->model('ad_siswa');
			$raportmanual=$this->ad_siswa->getraportmanuaal($datasiswa['id_siswa_det_jenjang']);
			
			if(empty($raportmanual)){
				//insert
				$raportmanualinsert=array(
									'id_siswa_detjenjang'=>$datasiswa['id_siswa_det_jenjang'],
									'id_sekolah'=>$this->session->userdata['user_authentication']['id_sekolah'],
									'id_ta'=>$this->session->userdata['ak_setting']['ta'],
									'semester'=>$this->session->userdata['ak_setting']['semester'],
									'raport'=>serialize($_POST)
				);
				$this->db->insert('raportmanual',$raportmanualinsert);
				
			}else{
				//update
				$raportcurrent=unserialize($raportmanual[0]['raport']);
				$raportsave=array_merge($raportcurrent,$_POST);
				//pr($raportsave);
				$raportmanualinsert=array(
									'id_siswa_detjenjang'=>$datasiswa['id_siswa_det_jenjang'],
									'id_sekolah'=>$this->session->userdata['user_authentication']['id_sekolah'],
									'id_ta'=>$this->session->userdata['ak_setting']['ta'],
									'semester'=>$this->session->userdata['ak_setting']['semester'],
									'raport'=>serialize($raportsave)
				);
				$this->db->where('id',$raportmanual[0]['id']);
				$this->db->update('raportmanual',$raportmanualinsert);
			}
			//echo $this->db->last_query();
		}
        public function lihatmanual($param='')
        {
			$datasiswa=unserialize($this->myencrypt->decode($param));
			$this->load->library('ak_akademik');
			$this->load->model('ad_siswa');
			$this->load->model('ad_sekolah');
			$this->load->model('ad_extrakurikuler');
			$this->load->model('ad_kelas');
			$data['param']=$param;
			$data['kelas']=$this->ad_kelas->getWaliByIdKelas($this->session->userdata['user_authentication']['id_sekolah'],$datasiswa['id_kelas']);
			$data['ekstra']=$this->ad_extrakurikuler->getEkstrakurikulerByIdDetjenjang($datasiswa['id_siswa_det_jenjang']);
			$data['nilaiekstra']=$this->ad_extrakurikuler->getNilaiByidDetJenjang($datasiswa['id_siswa_det_jenjang']);
			$data['raport']=$this->ak_akademik->nilaiRaportPerSiswa2013($datasiswa['id_siswa_det_jenjang']);
			$rpman=$this->ad_siswa->getraportmanuaal($datasiswa['id_siswa_det_jenjang']);
			//pr(unserialize($rpman[0]['raport']));
			$data['raportmanual']=unserialize($rpman[0]['raport']);
			unset($data['raport']['submapel']);
			$data['siswa']=$this->ad_siswa->getsiswaByIdSiswa($datasiswa['id']);
			$data['sekolah']=$this->ad_sekolah->getSekolahdata($this->session->userdata['user_authentication']['id_sekolah']);
			$data['kepsek']=$this->ad_sekolah->getKepsek($this->session->userdata['user_authentication']['id_sekolah']);
			//pr($data['sekolah']);die();
			$data['main']= 'akademik/raport2013/raportmanual';
            $this->load->view('layout/ad_blank',$data);	
		}		
    }
?>