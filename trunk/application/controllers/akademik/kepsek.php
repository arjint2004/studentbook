<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Kepsek extends CI_Controller
    {
        public function __construct()
        {
            parent::__construct();
            $this->load->helper('global');
            $this->load->library('session');
            $this->load->library('auth');
            $this->auth->user_logged_in();
        }
		
        public function index()
        {
			$this->load->model('ad_kelas');
			$data['kelas'] 	=$this->ad_kelas->getkelas($this->session->userdata['user_authentication']['id_sekolah']);

			
			$data['main']           = 'akademik/kepsek/index';
            $this->load->view('layout/ak_default',$data);
        }

        public function statistik($jenis='')
        {
			$data['jenis']=$jenis;
			if(isset($_POST['jenis'])){$jenis=$_POST['jenis'];}
			$this->load->model('ad_akun');
			$data['guru'] 	=$this->ad_akun->getGuruBySekolah();
			$data['filter'] 	=$_POST['filter'];
			switch($jenis){
				
				case "rpp":
					$this->load->model('ad_pembelajaran');
					$datarpp	=$this->ad_pembelajaran->getPembelajaranByIdSekolah($this->session->userdata['user_authentication']['id_sekolah']);
					foreach($datarpp as $ky=>$dtrpp){
						$datarpp2[$dtrpp['id_pegawai']][]=$dtrpp;
					}
					$data['rpp']=$datarpp2;
					$data['totrpp']=count($datarpp);
					
					$data['main']           = 'akademik/kepsek/statistik';
					
				break;
				
				case "absen":
					$this->load->model('ad_absen');
					$datarpp	=$this->ad_absen->getAbsensiByIdSekolah($this->session->userdata['user_authentication']['id_sekolah']);
					
					foreach($datarpp as $ky=>$dtrpp){
						$datarpp2[$dtrpp['id_pegawai']][]=$dtrpp;
					}
					$data['rpp']=$datarpp2;
					$data['totrpp']=count($datarpp);
					
					$data['main']           = 'akademik/kepsek/statistik';
				break;
				case "penghortu":
					$this->load->model('ad_jurnal');
					$datarpp	=$this->ad_jurnal->getPenghByIdSekolah($this->session->userdata['user_authentication']['id_sekolah']);
					foreach($datarpp as $ky=>$dtrpp){
						$datarpp2[$dtrpp['id_pegawai']][]=$dtrpp;
					}
					$data['rpp']=$datarpp2;
					$data['totrpp']=count($datarpp);
					
					$data['main']           = 'akademik/kepsek/statistik';
				break;
				case "materi":
					$this->load->model('ad_materi');
					$datarpp	=$this->ad_materi->getMateriByIdSekolah($this->session->userdata['user_authentication']['id_sekolah']);
					foreach($datarpp as $ky=>$dtrpp){
						$datarpp2[$dtrpp['id_pegawai']][]=$dtrpp;
					}
					$data['rpp']=$datarpp2;
					$data['totrpp']=count($datarpp);
					
					$data['main']           = 'akademik/kepsek/statistik';
				break;
				case "pr":
					$this->load->model('ad_pr');
					$datarpp	=$this->ad_pr->getPrByIdSekolah($this->session->userdata['user_authentication']['id_sekolah'],array('ap.id','ap.id_pegawai,ap.judul'));
					foreach($datarpp as $ky=>$dtrpp){
						$datarpp2[$dtrpp['id_pegawai']][]=$dtrpp;
					}
					$data['rpp']=$datarpp2;
					$data['totrpp']=count($datarpp);
					$data['main']           = 'akademik/kepsek/statistik';
				
				break;
				case "tugas":
					$this->load->model('ad_tugas');
					$datarpp	=$this->ad_tugas->getTugasByIdSekolah($this->session->userdata['user_authentication']['id_sekolah']);
					foreach($datarpp as $ky=>$dtrpp){
						$datarpp2[$dtrpp['id_pegawai']][]=$dtrpp;
					}
					$data['rpp']=$datarpp2;
					$data['totrpp']=count($datarpp);
					
					$data['main']           = 'akademik/kepsek/statistik';
				
				break;
				case "harian":
					$this->load->model('ad_harian');
					$datarpp	=$this->ad_harian->getHarianByIdSekolah($this->session->userdata['user_authentication']['id_sekolah']);
					foreach($datarpp as $ky=>$dtrpp){
						$datarpp2[$dtrpp['id_pegawai']][]=$dtrpp;
					}
					$data['rpp']=$datarpp2;
					$data['totrpp']=count($datarpp);
					
					$data['main']           = 'akademik/kepsek/statistik';
				
				break;
				case "uts":
					$this->load->model('ad_uts');
					$datarpp	=$this->ad_uts->getUtsByIdSekolah($this->session->userdata['user_authentication']['id_sekolah']);
					foreach($datarpp as $ky=>$dtrpp){
						$datarpp2[$dtrpp['id_pegawai']][]=$dtrpp;
					}
					$data['rpp']=$datarpp2;
					$data['totrpp']=count($datarpp);
					
					$data['main']           = 'akademik/kepsek/statistik';
				
				break;
				case "uas":
					$this->load->model('ad_uas');
					$datarpp	=$this->ad_uas->getUasByIdSekolah($this->session->userdata['user_authentication']['id_sekolah']);
					foreach($datarpp as $ky=>$dtrpp){
						$datarpp2[$dtrpp['id_pegawai']][]=$dtrpp;
					}
					$data['rpp']=$datarpp2;
					$data['totrpp']=count($datarpp);
					
					$data['main']           = 'akademik/kepsek/statistik';
				
				break;
				case "catatan":
					$this->load->model('ad_catatanguru');
					$datarpp	=$this->ad_catatanguru->getCatatanByIdSekolah($this->session->userdata['user_authentication']['id_sekolah']);
					foreach($datarpp as $ky=>$dtrpp){
						$datarpp2[$dtrpp['id_pegawai']][]=$dtrpp;
					}
					$data['rpp']=$datarpp2;
					$data['totrpp']=count($datarpp);
					
					$data['main']           = 'akademik/kepsek/statistik';
				break;
			}
			$this->load->view('layout/ad_blank',$data);
		}
       /* public function filterrpp()
        {
			$this->load->model('ad_akun');
			$this->load->model('ad_pembelajaran');
			$data['pembelajaran']=array();
			$data['url']=base_url().base64_decode($_POST['jenis']);
			$data['guru'] 	=$this->ad_akun->getGuruBySekolah();
			/*$datarpp	=$this->ad_pembelajaran->getPembelajaranByIdSekolah($this->session->userdata['user_authentication']['id_sekolah']);
			foreach($datarpp as $ky=>$dtrpp){
				$datarpp2[$dtrpp['id_pegawai']][]=$dtrpp;
			}
			$data['rpp']=$datarpp2;
			$data['totrpp']=count($datarpp);*/
        /*    $data['main']= 'akademik/kepsek/filterrpp';
            $this->load->view('layout/ad_blank',$data);
		}
		
        public function filter()
        {
			$this->load->model('ad_kelas');
			$data['pembelajaran']=array();
			$data['url']=base_url().base64_decode($_POST['jenis']);
			$data['kelas'] 	=$this->ad_kelas->getkelas($this->session->userdata['user_authentication']['id_sekolah']);
            $data['main']= 'akademik/kepsek/filter';
            $this->load->view('layout/ad_blank',$data);
		}
        public function filterbysiswa()
        {
			$this->load->model('ad_kelas');
			$data['pembelajaran']=array();
			$data['url']=base_url().base64_decode($_POST['jenis']);
			$data['kelas'] 	=$this->ad_kelas->getkelas($this->session->userdata['user_authentication']['id_sekolah']);
            $data['main']= 'akademik/kepsek/filterbysiswa';
            $this->load->view('layout/ad_blank',$data);
		}
        public function filterbykelas()
        {
			$this->load->model('ad_kelas');
			$data['pembelajaran']=array();
			$data['url']=base_url().base64_decode($_POST['jenis']);
			$data['kelas'] 	=$this->ad_kelas->getkelas($this->session->userdata['user_authentication']['id_sekolah']);
            $data['main']= 'akademik/kepsek/filterbykelas';
            $this->load->view('layout/ad_blank',$data);
		}
        public function filterbyekstrakurikuler()
        {
			$this->load->model('ad_extrakurikuler');
			$data['ekstra'] 	=$this->ad_extrakurikuler->getdata($this->session->userdata['user_authentication']['id_sekolah']);
			$data['main'] 	= 'akademik/kepsek/filterbyekstrakurikuler';
			$data['page_title'] 	= 'Data Ekstrakurikuler';
			$this->load->view('layout/ad_blank',$data);
		}
        public function filterbykelaskegiatan()
        {
			$this->load->model('ad_kelas');
			$data['pembelajaran']=array();
			$data['url']=base_url().base64_decode($_POST['jenis']);
			$data['kelas'] 	=$this->ad_kelas->getkelas($this->session->userdata['user_authentication']['id_sekolah']);
            $data['main']= 'akademik/kepsek/filterbykelaskegiatan';
            $this->load->view('layout/ad_blank',$data);
		}
        public function absensifilter()
        {
			$this->load->model('ad_kelas');
            $data['kelas'] 	=$this->ad_kelas->getkelas($this->session->userdata['user_authentication']['id_sekolah']);
           
            $data['main']= 'akademik/kepsek/absensifilter';
            $this->load->view('layout/ad_blank',$data);
		}
        public function catatangurufilter()
        {
			$this->load->model('ad_kelas');
            $data['kelas'] 	=$this->ad_kelas->getkelas($this->session->userdata['user_authentication']['id_sekolah']);
           
            $data['main']= 'akademik/kepsek/catatangurufilter';
            $this->load->view('layout/ad_blank',$data);
		}
        public function chart()
        {

            $data['main']= 'akademik/kepsek/chart';
            $this->load->view('layout/ad_blank',$data);
		}*/
		
		
		
		//LIHAT DETAIL
		
		function lihat($jenis='',$params=''){
			$params=unserialize($this->myencrypt->decode($params));
			//pr($params);
			$data['jenis']=$jenis;
			if(isset($_POST['jenis'])){$jenis=$_POST['jenis'];}
			switch($jenis){
				
				case "rpp":
					
				break;
				
				case "absen":
					$this->load->model('ad_kelas');
					$data['kelas'] 	=$this->ad_kelas->getkelasByPengajar($this->session->userdata['user_authentication']['id_sekolah'],$params['id_peg']);
					$data['id_pegawai']=$params['id_peg'];
					//pr($data['kelas']);
				    $data['popup']='';
					$data['main']= 'akademik/absensi/rekapabsensi';
				break;
				case "penghortu":
				
					redirect('akademik/jurnalwali/penghubungortulist/0/0/'.$params['id_peg'].'/kepsek');
					die();
				break;
				case "materi":
					redirect('akademik/materi/daftarmaterilist/0/0/0/0/'.$params['id_peg'].'/kepsek');
					die();
				break;
				case "pr":
					redirect('akademik/kirimpr/daftarprlist/0/0/0/0/'.$params['id_peg'].'/kepsek');
					die();
				break;
				case "tugas":
					redirect('akademik/kirimtugas/daftartugaslist/0/0/0/0/'.$params['id_peg'].'/kepsek');
					die();
				
				break;
				case "harian":
					redirect('akademik/kirimharian/daftarharianlist/0/0/0/0/'.$params['id_peg'].'/kepsek');
					die();
				
				break;
				case "uts":
					redirect('akademik/kirimuts/daftarutslist/0/0/0/0/'.$params['id_peg'].'/kepsek');
					die();
				
				break;
				case "uas":
					redirect('akademik/kirimuas/daftaruaslist/0/0/0/0/'.$params['id_peg'].'/kepsek');
					die();
				
				break;
				case "catatan":
					//redirect('akademik/kirimuas/daftartugaslist/0/0/0/0/'.$params['id_peg'].'/kepsek');
					//die();
				
				break;
			}
			$this->load->view('layout/ad_blank',$data);
		}
		
    }
?>