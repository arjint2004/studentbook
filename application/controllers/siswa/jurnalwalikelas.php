<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Jurnalwalikelas extends CI_Controller
    {
		var $upload_dir='upload/akademik/jurnalwali/';
        public $denied_mime_types = array('application/x-php','application/x-httpd-php', 'text/html', 'text/css', 'text/javascript'); //array of denied mime types used when check_file_type is set to denied
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
			$this->load->model('ad_siswa');
			$siswa=$this->ad_siswa->getSiswaTaSekarang();
			$data['siswa']=$siswa;
			$data['main']= 'siswa/jurnalwalikelas/index';
            $this->load->view('layout/ad_blank',$data);	
		} 
        public function jurnalwalikelaslist()
        {
			$this->load->model('ad_jurnal');
			$data['jurnal']=$this->ad_jurnal->getJurnalWaliById_siswa_det_jenjang($this->session->userdata['user_authentication']['id_siswa_det_jenjang']);
			$data['main']= 'siswa/jurnalwalikelas/jurnalwalikelaslist';
            $this->load->view('layout/ad_blank',$data);	
		}        
		public function penghubungortu()
        {
			//pr($_POST);
			$this->load->model('ad_kelas');
			$data['kelaslaporan']=$this->ad_kelas->getKelasByWali($this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['user_authentication']['id_pengguna']);
			
			$data['id_kelas']=$this->session->userdata['user_authentication']['id_kelas_siswa_det_jenjang'];
			

			
            $data['main']= 'siswa/jurnalwalikelas/penghubungortu';
            $this->load->view('layout/ad_blank',$data);
		}	
		public function penghubungortulist($start=0,$page=0)
        {
						
			//data
			$this->load->model('ad_jurnal');
			$this->load->library('pagination');
			
			$config['base_url']   = site_url('siswa/jurnalwalikelas/penghubungortulist');
			$config['per_page']   = 10;

			$config['cur_page']   = $start;
			$config['total_rows'] = $this->ad_jurnal->getCountPenghubung($this->session->userdata['user_authentication']['id_kelas_siswa_det_jenjang']);
			$data['start'] = $start;
			$data['config'] = $config;
			
			$data['datahubung']=array();
			if(isset($this->session->userdata['user_authentication']['id_kelas_siswa_det_jenjang'])){
				$data['datahubung']=$this->ad_jurnal->getDataPenghubung($this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['user_authentication']['id_kelas_siswa_det_jenjang'],''.$start.','.$config['per_page'].'');
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
			$data['main']= 'siswa/jurnalwalikelas/penghubungortulist';
            $this->load->view('layout/ad_blank',$data);
		}
    }
?>