<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Nilai extends CI_Controller {
	 function __construct()
	 {
		parent::__construct();
		$this->load->library('auth');
		$this->load->helper('global');
		$this->auth->logged_in();
		$this->load->model('ad_pelajaran');
	 }
	function index(){
		$data['main'] 	= 'akademik/nilai/index';
		$data['page_title'] 	= 'Nilai';
		$this->load->view('layout/ad_adminsekolah',$data);
	}

	public function view_document($id_pengumpulan=0,$id_siswa_det_jenjang=0,$id_kelas=0,$id_sekolah=0,$jenis='',$id_referensi=0,$id_pelajaran=null,$urlfile=''){
			$this->load->model('ad_nilai');
			
			
			if($id_pengumpulan!='null' && $id_siswa_det_jenjang!='null' && $id_kelas!='null' && $id_sekolah!='null' && $jenis!='null'){
				$urlembed=str_replace(":","%3A",str_replace("/","%2F",base64_decode($urlfile).'&amp;embedded=true'));
				$this->load->model('ad_pengumpulan');
				$nilai=$this->ad_nilai->getNilaiByIddetjenjangIdkelasIdPelajaranPersubject($id_siswa_det_jenjang,$id_pelajaran,'nilai_'.$jenis,$id_referensi);
				$pengumpulan=$this->ad_pengumpulan->getdataById($id_pengumpulan,$jenis);
				if(isset($_POST['nilai'])){
					if(empty($nilai)){
						$referensi=$this->ad_pengumpulan->getdataReferensiById($id_referensi,$jenis);
						if($_POST['jenis']=='harian'){$jns='nilai ulangan harian';}else{$jns='nilai '.$_POST['jenis'];}
						
						//cek subject
						$subject=$this->ad_pengumpulan->getdataSubjectByIdReferensi($id_referensi);
						if(empty($subject)){
							$insert=array(
										'id_sekolah'=>$this->session->userdata['user_authentication']['id_sekolah'],
										'id_pegawai'=>$this->session->userdata['user_authentication']['id_pengguna'],
										'id_kelas'=>@$_POST['id_kelas'],
										'id_referensi'=>@$_POST['id_referensi'],
										'id_pelajaran'=>@$_POST['id_pelajaran'],
										'ta'=>$this->session->userdata['ak_setting']['ta'],
										'semester'=>$this->session->userdata['ak_setting']['semester'],
										'jenis'=>$jns,
										'subject'=>@$referensi[0]['judul'],
										'remidial'=>@$referensi[0]['jenis']
							);
							$this->db->insert('ak_subject_nilai',$insert);
							$id_subject=mysql_insert_id();
						}else{
							$id_subject=$subject[0]['id'];
						}
						
						$insertnilai=array( 	 	 	 	 	 	 	 	 	 
										'id_subject'=>$id_subject,
										'id_sekolah'=>$this->session->userdata['user_authentication']['id_sekolah'],
										'id_siswa_det_jenjang'=>$id_siswa_det_jenjang,
										'id_pelajaran'=>$_POST['id_pelajaran'],
										'ta'=>$this->session->userdata['ak_setting']['ta'],
										'semester'=>$this->session->userdata['ak_setting']['semester'],
										'nilai'=>$_POST['nilai']
						);
						
						$this->db->insert('ak_nilai_'.$_POST['jenis'],$insertnilai);
					}else{
					$update=array(
						'nilai'=>$_POST['nilai']
					);
						$this->db->where('id',$nilai[0]['id_nilai']);	
						$this->db->update('ak_nilai_'.$_POST['jenis'],$update);
					}
					
					$updatekumpul=array(
						'benar'=>$_POST['benar'],
						'salah'=>$_POST['salah'],
						'keterangan'=>$_POST['keterangan']
					);
					$this->db->where('id',$id_pengumpulan);	
					$this->db->update('ak_pengumpulan_'.$jenis,$updatekumpul);
				}
				$data['pengumpulan'] 	= $pengumpulan;
				$data['id_siswa_det_jenjang'] 	= $id_siswa_det_jenjang;
				$data['nilai'] 	= $nilai[0]['nilai'];
				$data['id_kelas'] 	= $id_kelas;
				$data['id_sekolah'] 	= $id_sekolah;
				$data['jenis'] 	= $jenis;
				$data['id_referensi'] 	= $id_referensi;
				$data['id_pengumpulan'] 	= $id_pengumpulan;
				$data['id_pelajaran'] 	= $id_pelajaran;
				$data['urlfilepure'] 	= $urlfile;
				$data['urlfile'] 	= $urlembed;
				if(isset($_POST['nilai'])){die(json_encode($_POST));}
				$data['main'] 	= 'akademik/nilai/view_document';
		}else{
			//echo base64_decode($id_referensi);
			$urlembed=str_replace(":","%3A",str_replace("/","%2F",base64_decode($id_referensi).'&amp;embedded=true'));
			$data['urlfile'] 	= $urlembed;
			$data['uploadeddir'] 	= $id_referensi;
			$data['main'] 	= 'akademik/nilai/view_document2';
		}
        
		$data['page_title'] 	= 'View Document';
		$this->load->view('layout/ad_fullwidth',$data);
	}
	function editnilai($jenis=''){
	
		$this->load->model('ad_kelas');
		$this->load->model('ad_nilai');
		
		if(isset($_POST['subject']) && isset($_POST['id_kelas']) && isset($_POST['id_pelajaran'])){
			$update=array(
							'id_kelas'=>$_POST['id_kelas'],
							'id_pelajaran'=>$_POST['id_pelajaran'],
							'subject'=>$_POST['subject'],
							'remidial'=>@$_POST['remidial']
			);
			
			$this->db->where('id',$_POST['id_subject']);	
			$this->db->update('ak_subject_nilai',$update);
						
			foreach($_POST['nilai'] as $id_nilai=>$nilai){
				$updatenilai=array( 	 	 	 	 	 	 	 	 	 
								
								'id_pelajaran'=>$_POST['id_pelajaran'],
								'nilai'=>$nilai
				);
				$this->db->where('id',$id_nilai);		
				$this->db->update('ak_'.str_replace(' ','_',$_POST['jenis']),$updatenilai);
			}
			
		}
		$data['subject']= $this->ad_nilai->getSubjectNilaiById($_POST['id_subject']);
		$data['jenis'] 	=base64_decode($jenis);
		$data['kelas'] 	=$this->ad_kelas->getkelas($this->session->userdata['user_authentication']['id_sekolah']);

		if(base64_decode($jenis)=="nilai kompetensi"){
			$data['main'] 	= 'akademik/nilai/editnilaikompetensi'; // memilih view
		}elseif(base64_decode($jenis)=="nilai lain_lain"){
			$data['main'] 	= 'akademik/nilai/editnilailainlain'; // memilih view
		}else{
			$data['main'] 	= 'akademik/nilai/editnilai'; // memilih view
		}
		$this->load->view('layout/ad_blank',$data); // memilih layout
		
	}
	function getpsikoafektif($jenis=''){
			$this->load->model('ad_nilai');
			
			
			if(isset($_POST['id_kelas'])){
				$this->load->model('ad_pelajaran');
				$pelajaran=$this->ad_pelajaran->getdatabySemesterJenjangJurusanKelasPegawaimengajar($this->session->userdata['ak_setting']['semester'],$_POST['nama_kelas'],$_POST['id_jurusan'],$_POST['id_kelas']);
				//pr($data['pelajaran']);
			}
			
			foreach($pelajaran as $xx=> $datapel){
				$pelajaran[$xx]['nilai'] 	=  $this->ad_nilai->getNilaiPsikoAfektif($_POST['id_kelas'],$datapel['id'],$_POST['jenis']);
			}
			//pr($pelajaran);
			$data['pelajaran']=$pelajaran;
			if(isset($_POST['jenis'])){
				$data['jenis']           = $_POST['jenis'];
			}else{
				$data['jenis']           = base64_decode($jenis);			
			}

            $data['main']           = 'akademik/nilai/getpsikoafektif';
            $this->load->view('layout/ad_blank',$data);	
	}
	function psikoafektif($jenis=''){
		$this->load->model('ad_kelas');
		$this->load->model('ad_nilai');
		$data['subject'] 	= array();	
		$data['jenis'] 	=$jenis;
		$data['pelajaran']=array();
		$data['kelas'] 	=$this->ad_kelas->getkelasByPengajar($this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['user_authentication']['id_pengguna']);
		
		$data['main'] 	= 'akademik/nilai/psikoafektif'; // memilih view
		$this->load->view('layout/ad_blank',$data); // memilih layout
	}
	function addnilai($jenis=''){
	
		$this->load->model('ad_kelas');
		$this->load->model('ad_nilai');
		if(isset($_POST['subject']) && isset($_POST['id_kelas']) && isset($_POST['id_pelajaran'])){
			$insert=array(
							'id_sekolah'=>$this->session->userdata['user_authentication']['id_sekolah'],
							'id_pegawai'=>$this->session->userdata['user_authentication']['id_pengguna'],
							'id_kelas'=>@$_POST['id_kelas'],
							'id_referensi'=>@$_POST['id_referensi'],
							'id_pelajaran'=>@$_POST['id_pelajaran'],
							'ta'=>$this->session->userdata['ak_setting']['ta'],
							'semester'=>$this->session->userdata['ak_setting']['semester'],
							'jenis'=>$_POST['jenis'],
							'subject'=>@$_POST['subject'],
							'remidial'=>@$_POST['remidial']
			);
			//if($_POST['jenis']!='nilai kompetensi' && $_POST['jenis']!='nilai uts' && $_POST['jenis']!='nilai uas'){
				$this->db->insert('ak_subject_nilai',$insert);
				$id_subject=mysql_insert_id();
			//}else{
				//$id_subject=0;
			//}
			if($_POST['jenis']!='nilai lain_lain'){
			//notifikasi
				$this->load->model('ad_notifikasi');
				$this->load->library('ak_notifikasi');
			//notifikasi
			}
			foreach($_POST['nilai'] as $id_siswa_det_jenjag=>$nilai){
				$insertnilai=array( 	 	 	 	 	 	 	 	 	 
								'id_subject'=>$id_subject,
								'id_sekolah'=>$this->session->userdata['user_authentication']['id_sekolah'],
								'id_siswa_det_jenjang'=>$id_siswa_det_jenjag,
								'id_pelajaran'=>$_POST['id_pelajaran'],
								'ta'=>$this->session->userdata['ak_setting']['ta'],
								'semester'=>$this->session->userdata['ak_setting']['semester'],
								'nilai'=>$nilai
				);
				
				$this->db->insert('ak_'.str_replace(' ','_',$_POST['jenis']),$insertnilai);
				if($_POST['jenis']!='nilai lain_lain'){
				//notifikasi
				//$this->ak_notifikasi->set_notifikasi_akademik_per_siswa($id_siswa,$gorup_notif='pr',$_POST['id_pelajaran'],$_POST['judul'],$_POST['id_pegawai'],$_POST['keterangan']);
				$this->ak_notifikasi->set_notifikasi_akademik_per_siswa_detjenjang($id_siswa_det_jenjag,$gorup_notif='nilai',$_POST['id_pelajaran'],$nilai,$this->session->userdata['user_authentication']['id_pengguna'],'Nilai '.$_POST['jenis'].' Tahun Ajaran '.$this->session->userdata['ak_setting']['ta_nama'].', Semester '.$this->session->userdata['ak_setting']['semester_nama'].'');
				$this->ad_notifikasi->add_notif_sms_nilai_ortu_per_siswa_detjenjang($id_siswa_det_jenjag,$_POST['id_pelajaran'],$data=array('group'=>$_POST['jenis']),$nilai);
				//end notifikasi
				}
			}
			
		}
		$data['jenis'] 	=base64_decode($jenis);
		$data['kelas'] 	=$this->ad_kelas->getkelasByPengajar($this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['user_authentication']['id_pengguna']);
		if($data['jenis']=='nilai uas'){
			$data['inserted']=$this->ad_nilai->ifinsertedUAS();
		}
		$jns=base64_decode($jenis);
		if($data['jenis']=='nilai uts'){
			$data['inserted']=$this->ad_nilai->ifinsertedUTS();;
		}
		if(base64_decode($jenis)=="nilai kompetensi"){
			$data['main'] 	= 'akademik/nilai/addnilaikompetensi'; // memilih view
		}elseif(base64_decode($jenis)=="nilai lain_lain"){
			$data['kelas'] 	=$this->ad_kelas->getKelasByWali($this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['user_authentication']['id_pengguna']);
			$data['main'] 	= 'akademik/nilai/addnilailain'; // memilih view
		}elseif($jns=='nilai uan' ||$jns=='nilai praktik' || $jns=='nilai afektif'){
			$data['main'] 	= 'akademik/nilai/addnilai'; // memilih view
		}else{
			$data['main'] 	= 'akademik/nilai/addnilairef'; // memilih view
		}
		
		$this->load->view('layout/ad_blank',$data); // memilih layout
		
	}
	public function deletesubjectnilai(){ 
		$this->db->query('DELETE FROM ak_subject_nilai WHERE id='.$_POST['id'].'');
		$this->db->query('DELETE FROM ak_nilai_pr WHERE id_subject='.$_POST['id'].'');
	}
	public function getsubject($jenis=null){ 
			$this->load->model('ad_nilai');
			$data['subject']= $this->ad_nilai->getSubjectNilaiListNilai($_POST['id_kelas'],$_POST['pelajaran'],$_POST['jenis']);
           
            $data['jenis']           = base64_decode($jenis);
            $data['main']           = 'akademik/nilai/getsubject';
            $this->load->view('layout/ad_blank',$data);			
	}
	function listSubject($jenis=null){
		$this->load->model('ad_kelas');
		$this->load->model('ad_nilai');
		$data['subject'] 	= array();	
		$data['jenis'] 	=base64_decode($jenis);
		
		if(isset($_POST['kelas'])){
			$data['subject'] 	=  $this->ad_nilai->getSubjectNilaiListNilai($_POST['kelas'],$_POST['pelajaran'],$data['jenis']);		
		}else{
			$data['subject'] 	=  $this->ad_nilai->getSubjectNilaiListNilai(null,null,$data['jenis']);
		}
		
		
		$data['kelas'] 	=$this->ad_kelas->getkelasByPengajar($this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['user_authentication']['id_pengguna']);
		
		if($data['jenis']=='nilai lain_lain'){
			$data['kelas'] 	=$this->ad_kelas->getKelasByWali($this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['user_authentication']['id_pengguna']);
			$data['main'] 	= 'akademik/nilai/listSubjectLain'; // memilih view
		}else{
			$data['main'] 	= 'akademik/nilai/listSubject'; // memilih view		
		}
		
		$this->load->view('layout/ad_blank',$data); // memilih layout
		
	}
	
	function inputDataUlanganHarian(){
		$this->load->model('ad_kelas');
		$this->load->model('ad_siswa');
		$data['siswa'] 	= array();	
		if(isset($_POST['kelas'])){
			$data['siswa'] 	=  $this->ad_siswa->getsiswaByIdKelas($_POST['kelas']);		
		}

		$data['kelas'] 	=$this->ad_kelas->getkelas($this->session->userdata['user_authentication']['id_sekolah']);
		if ($this->input->post('ajax')) {
		   $data['main'] 	= 'akademik/nilai/listdataulanganharian'; // memilih view
		   $this->load->view('layout/ad_blank',$data); // memilih layout
		} else {
		   $data['main'] 	= 'akademik/nilai/listdataulanganharian';// memilih view
		   $this->load->view('layout/ad_adminsekolah',$data);
		}
	}
	public function add()
        {
			$siswa2=array();
			$this->load->model('ad_siswa');
			
			$siswa=$this->ad_siswa->getsiswaByIdKelas(@$_POST['id_kelas']);
			foreach($siswa as $siswadata){
				$siswa2[$siswadata['id_siswa_det_jenjang']]=$siswadata;
			}
			$data['siswa']= $siswa2;
			
			//area kompetensi
			if(base64_decode(@$_POST['jenis'])=="nilai kompetensi"){
				$this->load->library('ak_akademik');
				//$nilairumus=$this->ak_akademik->getRata2_Nilai_perKelas($_POST['id_kelas'],$_POST['id_pelajaran'],'nilai ulangan harian');
				//$nilairumus=$this->ak_akademik->getAllRata2_Nilai_perKelas($_POST['id_kelas'],$_POST['id_pelajaran']);
				//$nilairumus=$this->ak_akademik->getAllRata2_Nilai_perSiswa(1,$_POST['id_pelajaran']);
				
				//ambil setting bobot nilai
				//$nilairumus=$this->ak_akademik->getAllSettingBobotPerkelas();
				
				//ambil bobot nilai per kelas
				//$nilairumus=$this->ak_akademik->getAllBobotPerKelas($_POST['id_kelas'],$_POST['id_pelajaran']);
				//ambil bobot nilai per siswa
				//$nilairumus=$this->ak_akademik->getAllBobotPerSiswa(1,$_POST['id_pelajaran']);
				
				$data['nilaikognitif']=$this->ak_akademik->nilaiKognitifPerKelas($_POST['id_kelas'],$_POST['id_pelajaran']);
				$data['nilaiafektif']=$this->ak_akademik->getNilai_Perkelas($_POST['id_kelas'],$_POST['id_pelajaran'], 'nilai afektif');
				$data['nilaiapraktik']=$this->ak_akademik->getNilai_Perkelas($_POST['id_kelas'],$_POST['id_pelajaran'], 'nilai praktik');
				
				$data['main'] = 'akademik/nilai/addkompetensi';
			}elseif(base64_decode(@$_POST['jenis'])=="nilai afektif" || @$_POST['jenis']=="nilai afektif"){
				$data['main'] = 'akademik/nilai/addafektif';
			}elseif(base64_decode(@$_POST['jenis'])=="nilai lain_lain" || @$_POST['jenis']=="nilai lain_lain"){
				$data['main'] = 'akademik/nilai/addlainlain';
			}else{
				$data['main'] = 'akademik/nilai/add';
			}

            
            $this->load->view('layout/ad_blank',$data);
        }
    public function edit()
        {
			$siswa2=array();
			$this->load->model('ad_siswa');
			$this->load->model('ad_nilai');
			//ambil nilai berdasarkan subject
			$jenis=base64_decode($_POST['jenis']);
			$nilai= $this->ad_nilai->getNilaiBySubjectTaSm($_POST['id_subject'],$jenis);
			$nilai2=array();
			foreach($nilai as $nilaidata){
				$nilai2[$nilaidata['id_siswa_det_jenjang']]=$nilaidata;
			}
			
			$siswa=$this->ad_siswa->getsiswaByIdKelas(@$_POST['id_kelas']);
			foreach($siswa as $siswadata){
				$siswa2[$siswadata['id_siswa_det_jenjang']]=$siswadata;
			}
			
			$data['id_subject']= $_POST['id_subject'];
			$data['nilai']= $nilai2;
			$data['siswa']= $siswa2;
			
            if(base64_decode(@$_POST['jenis'])=="nilai kompetensi"){
				$this->load->library('ak_akademik');
				//$nilairumus=$this->ak_akademik->getRata2_Nilai_perKelas($_POST['id_kelas'],$_POST['id_pelajaran'],'nilai ulangan harian');
				//$nilairumus=$this->ak_akademik->getAllRata2_Nilai_perKelas($_POST['id_kelas'],$_POST['id_pelajaran']);
				//$nilairumus=$this->ak_akademik->getAllRata2_Nilai_perSiswa(1,$_POST['id_pelajaran']);
				
				//ambil setting bobot nilai
				//$nilairumus=$this->ak_akademik->getAllSettingBobotPerkelas();
				
				//ambil bobot nilai per kelas
				//$nilairumus=$this->ak_akademik->getAllBobotPerKelas($_POST['id_kelas'],$_POST['id_pelajaran']);
				//ambil bobot nilai per siswa
				//$nilairumus=$this->ak_akademik->getAllBobotPerSiswa(1,$_POST['id_pelajaran']);
				
				$data['nilaikognitif']=$this->ak_akademik->nilaiKognitifPerKelas($_POST['id_kelas'],$_POST['id_pelajaran']);
				$data['nilaiafektif']=$this->ak_akademik->getNilai_Perkelas($_POST['id_kelas'],$_POST['id_pelajaran'], 'nilai afektif');
				$data['nilaiapraktik']=$this->ak_akademik->getNilai_Perkelas($_POST['id_kelas'],$_POST['id_pelajaran'], 'nilai praktik');
				
				$data['main'] = 'akademik/nilai/editkompetensi';
			}elseif(base64_decode(@$_POST['jenis'])=="nilai afektif" || @$_POST['jenis']=="nilai afektif"){
				$data['main'] = 'akademik/nilai/editafektif';
			}elseif(base64_decode(@$_POST['jenis'])=="nilai lain_lain" || @$_POST['jenis']=="nilai lain_lain"){
				$data['main'] = 'akademik/nilai/editlainlain';
			}else{
				$data['main'] = 'akademik/nilai/edit';
			}
            $this->load->view('layout/ad_blank',$data);
        }
	    public function getSubjectDrop($jenis='',$remidijenis='')
		{	//echo $jenis;
			if(base64_decode($jenis)=='ulangan harian'){
				$jenis=base64_encode('harian');
			}
			$this->load->model('ad_nilai');
			$datasubject=$this->ad_nilai->getJenisForSubject($jenis,$remidijenis);
			echo '<select name="subject" id="subjecton">';
			echo '<option value="">Pilih Data '.base64_decode($jenis).'</option>';
			foreach($datasubject as $subj){
			echo '<option id_ref="'.$subj['id'].'" value="'.$subj['judul'].'">'.strtoupper($subj['judul']).'. BAB ['.$subj['bab'].']</option>';
			}
			echo '</select>';
		}
}
?>