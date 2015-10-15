<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Export extends CI_Controller
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
            //$this->load->library('Phpexcel');
            $this->auth->user_logged_in();
        }
		
		public function index()
        {
			switch($_POST['jenis']){
				case "Pertemuan_Pembelajaran":
					$header=array(
							array('Data','Pertemuan Pembelajaran'),
							array('Kelas',$_POST['pertkelasnya']),
							array('Pelajaran',$_POST['pertpelajarannya']),
							array('Tahun Ajaran',$this->session->userdata['ak_setting']['ta_nama']),
							array('Semester',$this->session->userdata['ak_setting']['semester_nama']),
					);
					$this->load->model('ad_pembelajaran');
					$arrayfirst=$this->ad_pembelajaran->getWaktuPembelajaranByKelasPelajaranIdPegawai($_POST['pelajaran'],$_POST['id_kelas']);
					
					
					foreach($arrayfirst as $id=>$data){
						unset($data['id']);
						unset($data['id_sekolah']);
						unset($data['id_pelajaran']);
						unset($data['id_pegawai']);
						unset($data['id_kelas']);
						unset($data['semester']);
						unset($data['ta']);
						$array[]=$data;
					}
					
						unset($arrayfirst);
					//pr($array);
				break;
				case "Rencana_Pembelajaran":
					
					$header=array(
							array('Data','Pembelajaran'),
							array('Kelas',$_POST['kelasnya']),
							array('Pertemuan',$_POST['pertemuannya']),
							array('Tahun Ajaran',$this->session->userdata['ak_setting']['ta_nama']),
							array('Semester',$this->session->userdata['ak_setting']['semester_nama']),
					);
					
					$this->load->model('ad_pembelajaran');
					if($_POST['id_pertemuan']!=0){
						$arrayfirst=$this->ad_pembelajaran->getPembelajaranByKelasPelajaranIdPegawaiIdPertemuan($_POST['pelajaran'],$_POST['id_kelas'],$_POST['id_pertemuan']);
					}else{
						$arrayfirst=$this->ad_pembelajaran->getPembelajaranByKelasPelajaranIdPegawai($_POST['pelajaran'],$_POST['id_kelas'],$this->session->userdata['user_authentication']['id_pengguna']);
					}
					foreach($arrayfirst['pembelajaran'] as $id=>$data){
						unset($data['id']);
						unset($data['file']);
						unset($data['id_kelas']);
						unset($data['id_pertemuan']);
						unset($data['id_pelajaran']);
						$array[]=$data;
					}
						unset($arrayfirst);
				break;
				case "absensi":
					$tgl= $this->auth->tanggal($_POST['tanggalnyaabsensi']." 00:00:00");
					
					$header=array(
							array('Data','Abseni'),
							array('Kelas',$_POST['kelasnyaabsesnsi']),
							array('Guru Pengajar',$this->session->userdata['user_authentication']['nama']),
							array('Pelajaran',$_POST['pelajarannyaabsen']),
							array('Jam Pelajaran ke',$_POST['jamkenya']),
							array('Tanggal',$tgl[2]),
							array('Tahun Ajaran',$this->session->userdata['ak_setting']['ta_nama']),
							array('Semester',$this->session->userdata['ak_setting']['semester_nama']),
							array('Aktifitas',$_POST['aktivitas']),
							array('Kegiatan',$_POST['pembiasaan'])
					);
					
					$_POST['id_kelas']=$_POST['kelas'];
					$this->load->model('ad_absen');
					$currentabsen=$this->ad_absen->getCurrentAbsensiExport($_POST['tanggalnyaabsensi'],$_POST['jamabsen']);
					
					if($this->session->userdata['ak_setting']['jenjang'][0]['nama']=='SD'){
						unset($header[3]);
						unset($header[4]);
					}
					if($this->session->userdata['ak_setting']['jenjang'][0]['bentuk']=="PESANTREN"){
						unset($header[3]);
						unset($header[4]);						
						unset($header[7]); 
					}else{
						unset($header[8]);
						unset($header[9]);					
					}
					//pr($header);die();
					//pr($currentabsen);
					foreach($currentabsen as $id=>$data){
						if($this->session->userdata['ak_setting']['jenjang'][0]['nama']=='SD'){
							unset($data['jam_ke']);
						}
						unset($data['id']);
						unset($data['id_siswa_det_jenjang']);
						unset($data['id_sekolah']);
						unset($data['id_pegawai']);
						unset($data['id_semester']);
						unset($data['id_pelajaran']);
						unset($data['id_semester']);
						unset($data['id_kelas']);
						unset($data['id_ta']);
						unset($data['jam']);
						unset($data['tanggal']);
						if($this->session->userdata['ak_setting']['jenjang'][0]['bentuk']=="PESANTREN"){
							unset($data['nis']);
							unset($data['aktifitas']);
							unset($data['kegiatan']);
						}
						$array[]=$data;
					}
					//pr($data);die();
					unset($arrayfirst);
				break;
				case "Materi":
					
					$header=array(
							array('Data','Materi'),
							array('Guru Pengajar',$this->session->userdata['user_authentication']['nama']),
							array('Pelajaran',$_POST['pelajarannya']),
							array('Kelas',$_POST['kelasnya']),
							array('Tahun Ajaran',$this->session->userdata['ak_setting']['ta_nama']),
							array('Semester',$this->session->userdata['ak_setting']['semester_nama']),
					);
					$this->load->model('ad_materi');
					$materi=$this->ad_materi->getmateriByKelasPelajaranIdPegawaiAll($_POST['pelajaran'],$_POST['id_kelas']);
					
					//pr($_POST);
					//pr($materi);die();
					foreach($materi as $id=>$data){
						unset($data['id']);
						unset($data['id_sekolah']);
						unset($data['id_pegawai']);
						unset($data['id_pembelajaran']);
						unset($data['id_pelajaran']);
						unset($data['semester']);
						unset($data['tanggal_diberikan']);
						//$tgl= $this->auth->tanggal($data['tanggal_diberikan']." 00:00:00");
						$tglx= $this->auth->tanggal($data['tanggal_buat']." 00:00:00");
						//$data['tanggal_diberikan']=$tgl[2];
						$data['tanggal_buat']=$tglx[2];
						$array[]=$data;
					}
					
					unset($arrayfirst);
				break;
				case "Catatan_Guru":
					$tgl= $this->auth->tanggal($_POST['tanggal']." 00:00:00");
					
					$header=array(
							array('Data','Catatan Guru'),
							array('Nama Siswa',$_POST['siswanya']),
							array('Kelas',$_POST['kelasnya']),
							array('Tanggal',$tgl[2]),
							array('Tahun Ajaran',$this->session->userdata['ak_setting']['ta_nama']),
							array('Semester',$this->session->userdata['ak_setting']['semester_nama']),
					);
					$this->load->model('ad_catatanguru');
					$catatanguru=$this->ad_catatanguru->getCatatanguruByKelasTanggalIdPegawai($_POST['id_kelas'],$_POST['id_siswa_det_jenjang'],$_POST['tanggal']);
					
					//pr($_POST);
					//pr($catatanguru);die();
					foreach($catatanguru as $id=>$data){
						unset($data['id']);
						unset($data['semester']);
						unset($data['id_sekolah']);
						unset($data['id_siswa_det_jenjang']);
						unset($data['id_pegawai']);
						unset($data['id_kelas']);
						unset($data['id_aspek_kepribadian']);
						unset($data['ta']);
						$tgl= $this->auth->tanggal($data['tanggal']." 00:00:00");
						$data['tanggal']=$tgl[2];
						$array[]=$data;
					}
					
					unset($arrayfirst);
				break;
				case "PR":
					$header=array(
							array('Data','Pekerjaan Rumah (PR)'),
							array('Guru Pengajar',$this->session->userdata['user_authentication']['nama']),
							array('Pelajaran',$_POST['pelajarannya']),
							array('Kelas',$_POST['kelasnya']),
							array('Tahun Ajaran',$this->session->userdata['ak_setting']['ta_nama']),
							array('Semester',$this->session->userdata['ak_setting']['semester_nama']),
					);
					$this->load->model('ad_pr');
					$materi=$this->ad_pr->getPrByKelasPelajaran($_POST['pelajaran'],$_POST['id_kelas']);
					
					//pr($_POST);
					//pr($materi);die();
					foreach($materi as $id=>$data){
						unset($data['id']);
						unset($data['id_sekolah']);
						unset($data['id_pegawai']);
						unset($data['id_parent']);
						unset($data['id_pelajaran']);
						unset($data['semester']);
						unset($data['id_mengajar']);
						unset($data['id_kelas']);
						unset($data['id_pembelajaran']);
						unset($data['ta']);
						//$tgl= $this->auth->tanggal($data['tanggal_diberikan']." 00:00:00");
						$tglx= $this->auth->tanggal($data['tanggal_buat']." 00:00:00");
						//$data['tanggal_diberikan']=$tgl[2];
						$data['tanggal_buat']=$tglx[2];
						$array[]=$data;
					}
					
					unset($arrayfirst);
				break;
				case "Tugas":
					$header=array(
							array('Data','Tugas'),
							array('Guru Pengajar',$this->session->userdata['user_authentication']['nama']),
							array('Pelajaran',$_POST['pelajarannya']),
							array('Kelas',$_POST['kelasnya']),
							array('Tahun Ajaran',$this->session->userdata['ak_setting']['ta_nama']),
							array('Semester',$this->session->userdata['ak_setting']['semester_nama']),
					);
					$this->load->model('ad_tugas');
					$materi=$this->ad_tugas->getTugasByKelasPelajaran($_POST['pelajaran'],$_POST['id_kelas']);
					
					//pr($_POST);
					//pr($materi);die();
					foreach($materi as $id=>$data){
						unset($data['id']);
						unset($data['id_sekolah']);
						unset($data['id_pegawai']);
						unset($data['id_parent']);
						unset($data['id_pelajaran']);
						unset($data['semester']);
						unset($data['id_mengajar']);
						unset($data['id_kelas']);
						unset($data['id_pembelajaran']);
						unset($data['ta']);
						unset($data['tanggal_kumpul']);
						//$tgl= $this->auth->tanggal($data['tanggal_diberikan']." 00:00:00");
						$tglx= $this->auth->tanggal($data['tanggal_buat']." 00:00:00");
						//$data['tanggal_diberikan']=$tgl[2];
						$data['tanggal_buat']=$tglx[2];
						$array[]=$data;
					}
					
					unset($arrayfirst);
				break;
				case "Ulangan_harian":
					$header=array(
							array('Data','Ulangan Harian'),
							array('Guru Pengajar',$this->session->userdata['user_authentication']['nama']),
							array('Pelajaran',$_POST['pelajarannya']),
							array('Kelas',$_POST['kelasnya']),
							array('Tahun Ajaran',$this->session->userdata['ak_setting']['ta_nama']),
							array('Semester',$this->session->userdata['ak_setting']['semester_nama']),
					);
					$this->load->model('ad_harian');
					$materi=$this->ad_harian->getHarianByKelasPelajaran($_POST['pelajaran'],$_POST['id_kelas']);
					
					//pr($_POST);
					//pr($materi);die();
					foreach($materi as $id=>$data){
						unset($data['id']);
						unset($data['id_sekolah']);
						unset($data['id_pegawai']);
						unset($data['id_parent']);
						unset($data['id_pelajaran']);
						unset($data['semester']);
						unset($data['id_mengajar']);
						unset($data['id_kelas']);
						unset($data['id_pembelajaran']);
						unset($data['ta']);
						unset($data['tanggal_kumpul']);
						//$tgl= $this->auth->tanggal($data['tanggal_diberikan']." 00:00:00");
						$tglx= $this->auth->tanggal($data['tanggal_buat']." 00:00:00");
						//$data['tanggal_diberikan']=$tgl[2];
						$data['tanggal_buat']=$tglx[2];
						$array[]=$data;
					}
					
					unset($arrayfirst);
				break;
				case "UTS":
					$header=array(
							array('Data','UTS'),
							array('Guru Pengajar',$this->session->userdata['user_authentication']['nama']),
							array('Pelajaran',$_POST['pelajarannya']),
							array('Kelas',$_POST['kelasnya']),
							array('Tahun Ajaran',$this->session->userdata['ak_setting']['ta_nama']),
							array('Semester',$this->session->userdata['ak_setting']['semester_nama']),
					);
					$this->load->model('ad_uts');
					$uts=$this->ad_uts->getUtsByKelasPelajaran($_POST['pelajaran'],$_POST['id_kelas']);
					
					//pr($_POST);
					//pr($uts);die();
					foreach($uts as $id=>$data){
						unset($data['id']);
						unset($data['id_sekolah']);
						unset($data['id_pegawai']);
						unset($data['id_parent']);
						unset($data['id_pelajaran']);
						unset($data['semester']);
						unset($data['id_mengajar']);
						unset($data['id_kelas']);
						unset($data['id_pembelajaran']);
						unset($data['ta']);
						unset($data['tanggal_kumpul']);
						//$tgl= $this->auth->tanggal($data['tanggal_diberikan']." 00:00:00");
						$tglx= $this->auth->tanggal($data['tanggal_buat']." 00:00:00");
						//$data['tanggal_diberikan']=$tgl[2];
						$data['tanggal_buat']=$tglx[2];
						$array[]=$data;
					}
					
					unset($arrayfirst);
				break;
				case "UAS":
					$header=array(
							array('Data','UAS'),
							array('Guru Pengajar',$this->session->userdata['user_authentication']['nama']),
							array('Pelajaran',$_POST['pelajarannya']),
							array('Kelas',$_POST['kelasnya']),
							array('Tahun Ajaran',$this->session->userdata['ak_setting']['ta_nama']),
							array('Semester',$this->session->userdata['ak_setting']['semester_nama']),
					);
					$this->load->model('ad_uas');
					$uts=$this->ad_uas->getUasByKelasPelajaran($_POST['pelajaran'],$_POST['id_kelas']);
					
					//pr($_POST);
					//pr($uts);die();
					foreach($uts as $id=>$data){
						unset($data['id']);
						unset($data['id_sekolah']);
						unset($data['id_pegawai']);
						unset($data['id_parent']);
						unset($data['id_pelajaran']);
						unset($data['semester']);
						unset($data['id_mengajar']);
						unset($data['id_kelas']);
						unset($data['id_pembelajaran']);
						unset($data['ta']);
						unset($data['tanggal_kumpul']);
						//$tgl= $this->auth->tanggal($data['tanggal_diberikan']." 00:00:00");
						$tglx= $this->auth->tanggal($data['tanggal_buat']." 00:00:00");
						//$data['tanggal_diberikan']=$tgl[2];
						$data['tanggal_buat']=$tglx[2];
						$array[]=$data;
					}
					
					unset($arrayfirst);
				break;
				case "Nilai":
					$header=array(
							array('Data',$_POST['namanilai']),
							array('Guru Pengajar',$this->session->userdata['user_authentication']['nama']),
							array('Pelajaran',$_POST['pelajarannya']),
							array('Kelas',$_POST['kelasnya']),
							array('Tahun Ajaran',$this->session->userdata['ak_setting']['ta_nama']),
							array('Semester',$this->session->userdata['ak_setting']['semester_nama']),
					);
					foreach($_POST['nama'] as $id=>$datax){
						$data[$id]['nama']=$datax;
						$data[$id]['nis']=$_POST['nis'][$id];
						$data[$id]['kelas']=$_POST['kelas'][$id];
						$data[$id]['nilai']=$_POST['nilai'][$id];
						$array=$data;
					}
					//pr($array);die();
				break;
			}
			/** Include PHPExcel */
			require_once 'application/libraries/PHPExcel.php';

			// Create new PHPExcel object
			$objPHPExcel = new PHPExcel;
			if(!empty($array) && !empty($header)){
				$objPHPExcel->exports('pertemuan rpp',$array,'PertemuanPembelajaran',$header);
			}else{
				echo '<script>
				alert("Data kosong");
				window.location="'.base_url().'akademik/mainakademik/index";
				window.close();
				</script>';
			}
		}
    }
?>