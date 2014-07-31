<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Detailpembelajaran extends CI_Controller
    {
		var $upload_dir='upload/akademik/pr/';
		public $denied_mime_types = array('application/x-php','application/x-httpd-php', 'text/html', 'text/css', 'text/javascript'); //array of denied mime types used when check_file_type is set to denied
        public function __construct()
        {
            parent::__construct();
            $this->load->helper('global');
            $this->load->helper('akademik');
            $this->load->library('session');
            $this->load->library('auth');
            $this->auth->user_logged_in();
        }
       	public function detail($param=null)
        {	
			$datain=unserialize(base64_decode($param));
			//echo base64_encode(serialize(array('id'=>45,'jenis'=>'materi')));
			//pr($datain);
			switch($datain['jenis']){
				case "pr":
					$out=$this->pr($datain['id']);
					$data['title']="Detail PR";
					$data['jenis']="pr";
					//pr($out);
				break;
				case "tugas":
					$out=$this->tugas($datain['id']);
					$data['title']="Detail Tugas";
					$data['jenis']="tugas";
					//pr($out);
				break;
				case "harian":
					$out=$this->uh($datain['id']);
					$data['title']="Detail Ulangan Harian";
					$data['jenis']="harian";
					//pr($out);
				break;
				case "uts":
					$out=$this->uts($datain['id']);
					$data['title']="Detail Ujian Tengah Semester";
					$data['jenis']="uts";
					//pr($out);
				break;
				case "uas":
					$out=$this->uas($datain['id']);
					$data['title']="Detail Ujian Akhir Semester";
					$data['jenis']="uas";
					//pr($out);
				break;
				case "materi":
					$out=$this->materi($datain['id']);
					$data['title']="Detail Materi Pelajaran";
					$data['jenis']="materi";
					//pr($out);
				break;
				case "penghubung":
					$datahubung=$this->penghubungortu($datain['id']);
					$out['id']=$datain['id'];
					$data['title']="Penghubung Ortu";
					$data['jenis']="penghubung";
					//pr($out);
				break;
			}
			
			$data['out']=$out;
			if($datain['jenis']=="penghubung"){
				$data['datapengh']=$datahubung;
				$data['main'] = 'akademik/detailpenghubungortu';
			}else{
				
				$data['main'] = 'akademik/detailpembelajaran';
			}
            $this->load->view('layout/ak_default',$data);
		}
        private function penghubungortu($id=0){
			$this->load->model('ad_jurnal');
			$data['datahubung']=$this->ad_jurnal->getdataPengById($id);
				if(!empty($data['datahubung'])){
					foreach($data['datahubung'] as $ky=>$datapeng){
						$data['datahubung'][$ky]['file']=$this->ad_jurnal->getFilePengByIdPeng($id);
						$data['datahubung'][$ky]['siswa']=$this->ad_jurnal->getPengDikirim($id);
					}
				}
			return $data;
		}
        private function pr($id=0){
			$this->load->model('ad_pr');
			$pr=$this->ad_pr->getPrByIdFordetail($id);
			
			return $pr[0];
		}
        private function tugas($id=0){
			$this->load->model('ad_tugas');
			$tugas=$this->ad_tugas->getTugasByIdFordetail($id);
			
			return $tugas[0];		
		}
        private function uh($id=0){
			$this->load->model('ad_harian');
			$tugas=$this->ad_harian->getHarianByIdFordetail($id);
			
			return $tugas[0];
		
		}
        private function uts($id=0){
			$this->load->model('ad_uts');
			$tugas=$this->ad_uts->getUtsByIdFordetail($id);
			
			return $tugas[0];
		
		}
        private function uas($id=0){
			$this->load->model('ad_uas');
			$tugas=$this->ad_uas->getUasByIdFordetail($id);
			
			return $tugas[0];
		
		}
        private function materi($id=0){
		
			$this->load->model('ad_materi');
			$tugas=$this->ad_materi->getMateriByIdFordetail($id);
			
			return $tugas[0];
		}
    }
?>