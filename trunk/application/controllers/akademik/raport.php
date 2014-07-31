<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Raport extends CI_Controller
    {
		public function __construct()
        {
            parent::__construct();
            $this->load->helper('akademik');
            $this->load->library('session');
            $this->load->library('auth');
            $this->auth->user_logged_in();
        }
		function makehavechild(){
			$query=$this->db->query('SELECT * FROM ak_pelajaran WHERE id_parent=0 ');
			$pel=$query->result_array();
			foreach($pel as $datapl){
				$chld=$this->db->query('SELECT * FROM ak_pelajaran WHERE id_parent='.$datapl['id'].'')->result_array();
				if(!empty($chld)){
					//pr($datapl['id'].$datapl['nama']);
					//pr($chld);
					$this->db->query('UPDATE ak_pelajaran SET havechild=1 WHERE id='.$datapl['id'].'');
				}
				
			}
		    
		}
        public function index($id_det_jenjang=null)
        {
            $this->load->library('ak_akademik');
			$raport=$this->ak_akademik->nilaiRaportPerSiswa($id_det_jenjang);
			//pr($raport);
			$this->load->model('ad_kelas');
			$data['raport'] =$raport;
			$data['siswadata']= $this->getdatasiswa($id_det_jenjang);
			$data['Nilaititle'] ='Nilai Akademik';
			$data['kelas'] 	=$this->ad_kelas->getkelas($this->session->userdata['user_authentication']['id_sekolah']);
			$data['main']= 'akademik/raport/index';
            $this->load->view('layout/ad_blank',$data);	
		}
        public function raportlist()
        {
			$data['main']= 'akademik/raport/raportlist';
            $this->load->view('layout/ad_blank',$data);	
		}
		function getdatasiswa($id_det_jenjang){
			$this->load->model('ad_siswa');
			return $this->ad_siswa->getsiswaByIdDetJenjang($id_det_jenjang);
		}
        public function ekstrakurikuler($id_det_jenjang=null)
        {
			$this->load->model('ad_extrakurikuler');
			$nilai=$this->ad_extrakurikuler->getNilaiByidDetJenjang($id_det_jenjang);
			$data['id_det_jenjang']= $id_det_jenjang;
			$data['ekstrakurikuler']= $nilai;
			$data['siswadata']= $this->getdatasiswa($id_det_jenjang);
			$data['Nilaititle'] ='Nilai Ekstrakurikuler';
			$data['main']= 'akademik/raport/ekstrakurikuler';
            $this->load->view('layout/ad_blank',$data);	
		} 
        public function kegiatan($id_det_jenjang=null)
        {
			$this->load->model('ad_kegiatan');
			$nilai=$this->ad_kegiatan->getNilaiByidDetJenjang($id_det_jenjang);
			$data['id_det_jenjang']= $id_det_jenjang;
			$data['kegiatan']= $nilai;
			$data['siswadata']= $this->getdatasiswa($id_det_jenjang);
			$data['Nilaititle'] ='Nilai Kegiatan Sekolah';
			$data['main']= 'akademik/raport/kegiatan';
            $this->load->view('layout/ad_blank',$data);	
		} 
        public function kepribadian($id_det_jenjang=null)
        {
			$this->load->model('ad_kepribadian');
			$nilai=$this->ad_kepribadian->getNilaiByidDetJenjang($id_det_jenjang);
			$data['id_det_jenjang']= $id_det_jenjang;
			$data['kepribadian']= $nilai;
			$data['siswadata']= $this->getdatasiswa($id_det_jenjang);
			$data['Nilaititle'] ='Nilai Kepribadian';
			$data['main']= 'akademik/raport/kepribadian';
            $this->load->view('layout/ad_blank',$data);	
		}
        public function prestasi($id_det_jenjang=null)
        {
			$this->load->model('ad_prestasi');
			$nilai=$this->ad_prestasi->getNilaiByidDetJenjang($id_det_jenjang);
			$data['id_det_jenjang']= $id_det_jenjang;
			$data['prestasi']= $nilai;
			$data['siswadata']= $this->getdatasiswa($id_det_jenjang);
			$data['Nilaititle'] ='Prestasi';
			$data['main']= 'akademik/raport/prestasi';
            $this->load->view('layout/ad_blank',$data);	
		}
        public function absensi($id_det_jenjang=null)
        {
			$this->load->model('ad_absen');
			$nilai=$this->ad_absen->getKetidakhadiranByIdDetjenjang($id_det_jenjang);
			$data['id_det_jenjang']= $id_det_jenjang;
			$data['absensi']= $nilai;
			$data['siswadata']= $this->getdatasiswa($id_det_jenjang);
			$data['Nilaititle'] ='Absensi';
			$data['main']= 'akademik/raport/absensi';
            $this->load->view('layout/ad_blank',$data);	
		}
        public function catatan($id_det_jenjang=null)
        {
			$this->load->model('ad_nilai');
			$catatan=$this->ad_nilai->getCatatanRaportByIdDetjenjangTaSm($id_det_jenjang);
			//pr($catatan);
			if(isset($_POST['catatan'])){
				$insert=array(	 	 	 	 	 
							'id_sekolah'=>$this->session->userdata['user_authentication']['id_sekolah'],
							'id_det_jenjang'=>$id_det_jenjang,
							'ta'=>$this->session->userdata['ak_setting']['ta'],
							'semester'=>$this->session->userdata['ak_setting']['semester'],
							'catatan'=>$_POST['catatan'][$id_det_jenjang],
							'tanggal'=>date("Y-m-d")
				);
				if(empty($catatan)){
					$this->db->insert('ak_catatan_raport',$insert);
				}else{
					$this->db->where('id',$catatan[0]['id']);
					$this->db->update('ak_catatan_raport',$insert);
				}
				
			}
			if(!empty($catatan)){
				$data['catatan']=$catatan;
			}
			$data['id_det_jenjang']= $id_det_jenjang;
			$data['siswadata']= $this->getdatasiswa($id_det_jenjang);
			$data['Nilaititle'] ='Catatn Wali Kelas';
			$data['main']= 'akademik/raport/catatan';
            $this->load->view('layout/ad_blank',$data);	
		}
        public function keterangan($id_det_jenjang=null,$id_kelas=null){
			//get kenaikan
			$this->load->model('ad_setting');
			$this->load->model('ad_kelas');
			$this->load->model('ad_sekolah');
			$this->load->model('ad_siswa');
			$nextTa=$this->ad_setting->getNextTa($this->session->userdata['ak_setting']['ta']);
			$siswa=$this->ad_siswa->getsiswaByIdDetJenjang($id_det_jenjang);
			$data['wali']=$this->ad_kelas->getWaliByIdKelas($this->session->userdata['user_authentication']['id_sekolah'],$id_kelas);
			$data['kepsek']=$this->ad_sekolah->getKepsek($this->session->userdata['user_authentication']['id_sekolah']);
			$kenaikan=$this->ad_siswa->naikOrTinggalkelas($siswa[0]['id'],$id_kelas,$nextTa[0]['id']);
			//pr($kenaikan);
		
		
		
			$this->load->model('ad_nilai');
			$catatan=$this->ad_nilai->getCatatanRaportByIdDetjenjangTaSm($id_det_jenjang);
			//pr($catatan);
			if(isset($_POST['catatan'])){
				$insert=array(	 	 	 	 	 
							'id_sekolah'=>$this->session->userdata['user_authentication']['id_sekolah'],
							'id_det_jenjang'=>$id_det_jenjang,
							'ta'=>$this->session->userdata['ak_setting']['ta'],
							'semester'=>$this->session->userdata['ak_setting']['semester'],
							'catatan'=>$_POST['catatan'][$id_det_jenjang]
				);
				if(empty($catatan)){
					$this->db->insert('ak_catatan_raport',$insert);
				}else{
					$this->db->where('id',$catatan[0]['id']);
					$this->db->update('ak_catatan_raport',$insert);
				}
				
			}
			if(!empty($catatan)){
				$data['catatan']=$catatan;
			}
		
		
		
			$data['kenaikan']= $kenaikan;
			$data['id_det_jenjang']= $id_det_jenjang;
			$data['siswadata']= $this->getdatasiswa($id_det_jenjang);
			$data['Nilaititle'] ='Catatan Wali Kelas';
			$data['main']= 'akademik/raport/keterangan';
            $this->load->view('layout/ad_blank',$data);	
		}
        public function setkenaikan($id_kelas=null)
        {
			$siswa2=array();
			$this->load->model('ad_siswa');
			$this->load->model('ad_kelas');
			


			$jenjangbykelas=$this->ad_kelas->getJenjangByIdKelas(@$_POST['id_kelas']);
			$siswa=$this->ad_siswa->getsiswaByIdKelas(@$_POST['id_kelas']);
			foreach($siswa as $siswadata){
				$siswa2[$siswadata['id']]=$siswadata;
			}
			
			//indentify naik atau lulus
			switch($this->session->userdata['ak_setting']['jenjang'][0]['nama']){
				case"SD":
					
					if($jenjangbykelas[0]['kelas']==6){
						$set="kelulusan";
					}else{
						$set="kenaikan";
					}
					
				break;
				case"SMP":
					if($jenjangbykelas[0]['kelas']==9){
						$set="kelulusan";
					}else{
						$set="kenaikan";
					}
				
				break;
				case"SMA":
					if($jenjangbykelas[0]['kelas']==12){
						$set="kelulusan";
					}else{
						$set="kenaikan";
					}
				
				break;
				case"SMK":
					if($jenjangbykelas[0]['kelas']==12){
						$set="kelulusan";
					}else{
						$set="kenaikan";
					}
				break;
			}
			

			if($set=='kelulusan'){
				$datakelulusan2=array();
				$datakelulusan=$this->ad_siswa->getKelulusanByIdKelasTa(@$_POST['id_kelas']);
				foreach($datakelulusan as $datakelulusanrow){
					$datakelulusan2[$datakelulusanrow['id_siswa']]=$datakelulusanrow;
				}
				//pr($datakelulusan2);
				$data['datakelulusan']= $datakelulusan2;
			}elseif($set=='kenaikan'){
				$this->load->model('ad_setting');
				$nextTa=$this->ad_setting->getNextTa($this->session->userdata['ak_setting']['ta']);
				$kls2=$this->ad_kelas->getnextkelaswali($this->session->userdata['user_authentication']['id_sekolah'],@$_POST['id_kelas']);
				//pr($kls2);
				$siswasudahnaik=$this->ad_siswa->getSiswaTaBerikut($nextTa[0]['id'],@$_POST['id_kelas']);
				$siswasudahnaik2=array();
				foreach($siswasudahnaik as $siswadatanaik){
					$siswasudahnaik2[$siswadatanaik['id']]=$siswadatanaik;
				}	
				$data['kelasuntuknaik']= $kls2;
				$data['siswasudahnaik']= $siswasudahnaik2;				
			}
			
			//kenaikan proses
			if(isset($_POST['kelasuntuknaik'])){
				
				foreach($_POST['kelasuntuknaik'] as $id_siswa=>$id_kelasNaik){	 	 	 	 	 	
					$detjenjangInsert=array(
										'id_sekolah'=>$this->session->userdata['user_authentication']['id_sekolah'],
										'id_ta'=>$nextTa[0]['id'],
										'id_siswa'=>$id_siswa,
										'id_kelas'=>$id_kelasNaik,
										'parent_kelas'=>$_POST['id_kelas'],
										'kelulusan'=>0
					);
					if(isset($siswasudahnaik2[$id_siswa])){
						$this->db->where('id',$siswasudahnaik2[$id_siswa]['id_siswa_det_jenjang']);
						$this->db->update('ak_det_jenjang',$detjenjangInsert);
					}else{
						$this->db->insert('ak_det_jenjang',$detjenjangInsert);
					}
					//echo $this->db->last_query()."<br />";
					
				}
			//kelulusan proses
			}elseif(isset($_POST['kelulusan'])){
				foreach($_POST['kelulusan'] as $id_siswa=>$kelulusan){
					$this->db->query('UPDATE ak_det_jenjang SET kelulusan='.$kelulusan.' WHERE id_siswa='.$id_siswa.' AND id_ta='.$this->session->userdata['ak_setting']['ta'].'');
				}
				
			}
			

			$data['set']= $set;
			$data['siswa']= $siswa2;
			$data['main']= 'akademik/raport/setkenaikan';
            $this->load->view('layout/ad_blank',$data);	
		} 
		public function settingshow(){
			
		}
		public function getOptionSiswaByIdKelas($id_kelas){
			$this->load->library('ak_siswa');
			$optionsiswa=$this->ak_siswa->createOptionSiswaByIdKelas($id_kelas);
			echo $optionsiswa;
        }
    }
?>