<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Schooladmin extends CI_Controller {
	 function __construct()
	 {
		  parent::__construct();
		  $this->load->library('encrypt');
		  $this->load->library('auth');
		  $this->load->library('ak_akademik');
		  $this->load->helper('akademik');
		  $this->auth->logged_in();
	 }
	 
	 public function ubahpassword() {
		
		//pr($_POST);
		if(isset($_POST['password'])){
			//cek password lama
			$datalama=$this->db->query('SELECT * FROM users WHERE id_sekolah='.$this->session->userdata['user_authentication']['id_sekolah'].' AND password="'.md5($_POST['password_lama']).'"')->result_array();
			if(!empty($datalama)){
				if($_POST['password']==$_POST['passwordc']){
					$this->db->query('UPDATE users SET password="'.md5($_POST['password']).'" WHERE  id_sekolah='.$this->session->userdata['user_authentication']['id_sekolah'].' AND password="'.md5($_POST['password_lama']).'"');
					echo "<script>alert('Password anda berhasil di ubah. Password baru anda adalah ".$_POST['password']." ');</script>";
				}else{
					echo "<script>alert('Konfirmasi Password baru tidak valid. masukkan konfirmasi password dengan benar');</script>";
				}
			}else{
				echo "<script>alert('Konfirmasi password lama salah. Masukkan password lama dengan benar.');</script>";
			}
		}
		$data['main'] 	= 'schooladmin/ubahpassword';
		$data['page_title'] 	= 'Admin Sekolah';
		$this->load->view('layout/ad_adminsekolah',$data);
	 }
	 public function ceksis() {

		$query=$this->db->query('SELECT * FROM ak_siswa WHERE id_sekolah=59');
		$sis= $query->result_array();	
		foreach($sis as $datasis){
			$query1=$this->db->query('SELECT * FROM ak_pegawai ap WHERE   ap.id_sekolah=59 AND ap.id_siswa='.$datasis['id'].'');
			$sis1= $query1->result_array();	
			if(!empty($sis1)){
				//echo '1 <br />';
			}else{
				echo '0==>'.$datasis['id'].$datasis['nama'].'=='.$datasis['NmOrtu'].'==>idsek('.$datasis['id_sekolah'].') <br />'; 
			}
		}
	 }
	 public function index() {
		  $this->load->model('ad_setting');
		  $this->load->model('ad_sekolah');
		  $cekcompletereg=$this->ad_setting->getDataStepRegistrasi($this->session->userdata['user_authentication']['id_sekolah']);
			
		  if($cekcompletereg[0]['set_tahun_ajaran']==0 || $cekcompletereg[0]['set_semester']==0 || $cekcompletereg[0]['set_kelas']==0 || $cekcompletereg[0]['set_jurusan']==0 || $cekcompletereg[0]['set_pelajaran']==0 || $cekcompletereg[0]['finish']==0 ){
				  redirect('admin/schooladmin/completereg');
				  die();
		  }
		  
		  $data['fitur']=$this->ad_sekolah->getFitur($this->session->userdata['user_authentication']['id_sekolah']);
		  $data['id_sekolah'] 	= $this->session->userdata['user_authentication']['id_sekolah'];
		  $data['main'] 	= 'schooladmin/datanilai';
		  $data['page_title'] 	= 'Admin Sekolah';
		  $this->load->view('layout/ad_adminsekolah',$data);
	 }
	 
	 public function completereg(){
		$data['main'] 	= 'schooladmin/cekcompletereg';
		$data['page_title'] 	= 'Admin Sekolah';
		$this->load->view('layout/ad_detail',$data);
	 }
	 
	 function deletepegawai($id_pegawai=null)
	 {
		if($id_pegawai==null){
		$id_pegawai=$_POST['id_pegawai'];
		}
		$this->load->model('ad_akun');
		$freepegawai=$this->ad_akun->getFreePegawai($id_pegawai,$this->session->userdata['user_authentication']['id_sekolah']);
		if($freepegawai==0){
			$this->db->query('DELETE FROM ak_pegawai WHERE id='.$id_pegawai.'');
			$this->db->query('DELETE FROM users WHERE id_pengguna='.$id_pegawai.'');
			$this->db->query('DELETE FROM det_group WHERE id_user='.$id_pegawai.'');
		}
		echo $freepegawai;
		//return $freepegawai;
	 }
	 function deletesiswa($id_siswa=null)
	 {
		if($id_siswa==null){
			$id_siswa=$_POST['id_siswa'];
		}
		$this->load->model('ad_akun');
		$this->load->model('ad_siswa');
		$detjenjang=$this->ad_siswa->getDetjenjang($id_siswa,$this->session->userdata['user_authentication']['id_sekolah']);
		//pr($detjenjang);
		$freesiswa=$this->ad_akun->getFreesiswa($detjenjang,$this->session->userdata['user_authentication']['id_sekolah']);
		if($freesiswa==0){
			$this->db->query('DELETE FROM ak_siswa WHERE id='.$id_siswa.'');
			$this->db->query('DELETE FROM users WHERE id_pengguna='.$id_siswa.'');
			$this->db->query('DELETE FROM ak_det_jenjang WHERE id_siswa='.$id_siswa.' ');
			$this->db->query('DELETE FROM det_group WHERE id_user='.$id_siswa.'');
		}
		echo $freesiswa;
		//return $freesiswa;
	 }
	 public function completeregoption(){
		$this->load->model('ad_setting');
		$this->load->model('ad_jurusan');
		$this->load->model('ad_kelas');
		$jenjang=$this->ad_kelas->thisjenjang($this->session->userdata['user_authentication']['id']);
		$jurusan=$this->ad_jurusan->getdata($this->session->userdata['user_authentication']['id_sekolah']);
		
		$cekcompletereg=$this->ad_setting->getDataStepRegistrasi($this->session->userdata['user_authentication']['id_sekolah']);
		
		if($cekcompletereg[0]['set_tahun_ajaran']==1 && $cekcompletereg[0]['set_semester']==1 && $cekcompletereg[0]['set_kelas']==1 && @$cekcompletereg[0]['set_jurusan']==1 && $cekcompletereg[0]['set_pelajaran']==1 && $cekcompletereg[0]['finish']==1 ){
				  echo "<script>window.location = '".base_url()."admin/schooladmin';</script>";
				  die();
		}
		if($jenjang[0]['nama']=='SD' || $jenjang[0]['nama']=='SMP'){
			if(empty($jurusan)){
				$this->db->insert('ak_jurusan',array('id_sekolah'=>$this->session->userdata['user_authentication']['id_sekolah'],'nama'=>'Jurusan Dasar'));
			}
			$this->db->where('id_sekolah',$this->session->userdata['user_authentication']['id_sekolah']);
			
			unset($cekcompletereg[0]['set_jurusan']);	
		}
		if($jenjang[0]['nama']=='SMA'){
			if(empty($jurusan)){
				$this->db->insert('ak_jurusan',array('id_sekolah'=>$this->session->userdata['user_authentication']['id_sekolah'],'nama'=>'Jurusan Dasar'));
				$this->db->insert('ak_jurusan',array('id_sekolah'=>$this->session->userdata['user_authentication']['id_sekolah'],'nama'=>'IPA'));
				$this->db->insert('ak_jurusan',array('id_sekolah'=>$this->session->userdata['user_authentication']['id_sekolah'],'nama'=>'IPS'));			
			}
			$this->db->where('id_sekolah',$this->session->userdata['user_authentication']['id_sekolah']);

			unset($cekcompletereg[0]['set_jurusan']);
		}
		
			
		$data['jenjang'] 	= $jenjang;
		$data['cekcompletereg'] 	= $cekcompletereg;
		$data['main'] 	= 'schooladmin/cekcompleteregoption';
		$data['page_title'] 	= 'Admin Sekolah';
		$this->load->view('layout/ad_blank',$data);
	 }
	 public function importform(){
			$data['main'] 		= 'schooladmin/importform';
			$data['listtype'] 		= $_GET['akun'];
			$data['page_title'] 	= 'Admin Sekolah';
			$this->load->model('ad_kelas');
			$data['kelas']=$this->ad_kelas->getkelas($this->session->userdata['user_authentication']['id_sekolah']);
			$this->load->view('layout/ad_blank',$data);
	 }
	private function getpass($length=6){
		$chars =  'abcdefghijklmnopqrstuvwxyz'.'0123456789';
		$str = '';
		$max = strlen($chars) - 1;

		for ($i=0; $i < $length; $i++)
		$str .= $chars[rand(0, $max)];
		
		return $str; 
	}
	private function getusername($name=''){
		$namexpl=explode(" ",$name);
		$name=$namexpl[0];
		$length=4;
		$this->load->model('ad_akun');
		$chars = '0123456789';
		$str = '';
		$max = strlen($chars) - 1;

		for ($i=0; $i < $length; $i++)
		$str .= $chars[rand(0, $max)];
		if($this->ad_akun->cekAvailabelUsername($name.$str)==true){
			return $name.$str;
		}else{
			$this->getusername($name);
		}

	}

	public function importexcell($file=null){
		$data=$this->getdataexcell();
		if($_POST){
			switch($_POST['akun']){
				case "guru":
					if($this->ak_akademik->checkFileXLS($_FILES['userfile']['name'])){
						foreach($data['cells'] as $baris=>$nama){
							if($baris>=11){
								//$pass=$this->getpass();
								$pass=$this->getusername($nama[1]);
								$datausers = array(
								   'id_group' => 13,
								   'id_sekolah' => $this->session->userdata['user_authentication']['id_sekolah'],
								   'username' => "".$pass."",
								   'password' => "".md5($pass)."",
								   'aktif' => 1
								);
								$this->db->insert('users', $datausers); 
								$id_user=mysql_insert_id();
								$dataguru = array(
								   'id' => $id_user,
								   'tgl_daftar' => date('Y-m-d H:i:s'),
								   'id_sekolah' => $this->session->userdata['user_authentication']['id_sekolah'],
								   'nama' => "".$nama[1]."",
								   'nip' => "".$nama[2]."",
								   'hp' => "".$nama[3]."",
								   'password' => "".$pass.""
								);
								$this->db->insert('ak_pegawai', $dataguru); 
								$this->db->where('id', $id_user); 
								$this->db->update('users', array('id_pengguna'=>$id_user));
								$this->db->insert('det_group', array('id_user'=>$id_user,'id_group'=>13)); 
								
							}
						}
						redirect('admin/schooladmin/dataakun');
					}else{
						exit("<script>window.alert('File type salah! Anda Harus memasukkan file Excell dengan extensi .xls');
					window.history.go(-1);</script>");
					}
					
				break;
				case "siswa":
					if($this->ak_akademik->checkFileXLS($_FILES['userfile']['name'])){
						
						foreach($data['cells'] as $baris=>$nama){
							if($baris>=11){
									$this->load->model('ad_akun');
									if($this->ad_akun->cekAvailabelNIS($nama[1])){
										//$pass=$this->getpass();
										$pass=$this->getusername($nama[2]);
										$datausers = array(
										   'id_group' => 12,
										   'id_sekolah' => $this->session->userdata['user_authentication']['id_sekolah'],
										   'username' => "".$pass."",
										   'password' => "".md5($pass)."",
										   'aktif' => 1
										);
										$this->db->insert('users', $datausers);
										$id_user=mysql_insert_id();
										
										$datasiswa = array(
										   'id' => $id_user,
										   'tgl_daftar' => date('Y-m-d H:i:s'),
										   'id_sekolah' => $this->session->userdata['user_authentication']['id_sekolah'],
										   'IDkel' => $_POST['kelas'],
										   'nis' => "".$nama[1]."",
										   'nama' => "".$nama[2]."",
										   'NmOrtu' => "".$nama[3]."",
										   'hp' => "".$nama[5]."",
										   'password' => "".$pass.""
										);
										$this->db->insert('ak_siswa', $datasiswa); 
										$this->db->where('id', $id_user); 
										$this->db->update('users', array('id_pengguna'=>$id_user));
										$this->db->insert('det_group', array('id_user'=>$id_user,'id_group'=>12)); 
										
										$data_det_jenjang = array(
										   'id_sekolah' => $this->session->userdata['user_authentication']['id_sekolah'],
										   'id_ta' => $this->session->userdata['ak_setting']['ta'],
										   'id_siswa' => $id_user,
										   'id_kelas' => $_POST['kelas'],
										   'parent_kelas' => 0,
										   'kelulusan' => 0,
										);
										$this->db->insert('ak_det_jenjang', $data_det_jenjang);
										
										//insert portu
										$passortu=$this->getusername($nama[3]);
										$datausersortu = array(
										   'id_group' => 14,
										   'id_sekolah' => $this->session->userdata['user_authentication']['id_sekolah'],
										   'aktif' => 1,
										   'username' => "".$passortu."",
										   'password' => "".md5($passortu).""
										);
										$this->db->insert('users', $datausersortu);
										$id_userortu=mysql_insert_id();
										
										$dataortu = array(
										   'id' => $id_userortu,
										   'id_siswa' => $id_user,
										   'tgl_daftar' => date('Y-m-d H:i:s'),
										   'id_sekolah' => $this->session->userdata['user_authentication']['id_sekolah'],
										   'nama' => "".$nama[3]."",
										   'hp' => "".$nama[4]."",
										   'password' => "".$passortu.""
										);
										//pr($dataortu);
										$this->db->insert('ak_pegawai', $dataortu);  
										$this->db->where('id', $id_userortu); 
										$this->db->update('users', array('id_pengguna'=>$id_userortu));
										$this->db->insert('det_group', array('id_user'=>$id_userortu,'id_group'=>14)); 
									}else{ 
										$data['not_import'][$baris]['nis']=$nama[1];
										$data['not_import'][$baris]['nama']=$nama[2];
										$data['not_import'][$baris]['namaortu']=$nama[3];
									}
							}
						}
						if(empty($data['not_import'])){
							redirect('admin/schooladmin/dataakun');
						}
						
					}else{
						exit("<script>window.alert('File type salah! Anda Harus memasukkan file Excell dengan extensi .xls');
					window.history.go(-1);</script>");
					}
				break;
				case "ortu":
				
				break;
				case "karyawan":
					if($this->ak_akademik->checkFileXLS($_FILES['userfile']['name'])){
						foreach($data['cells'] as $baris=>$nama){
							if($baris>=11){
								//$pass=$this->getpass();
								$pass=$this->getusername($nama[1]);
								$datausers = array(
								   'id_group' => 15,
								   'id_sekolah' => $this->session->userdata['user_authentication']['id_sekolah'],
								   'username' => $pass,
								   'password' => md5($pass),
								   'id_pengguna' => mysql_insert_id(),
								   'aktif' => 1
								);
								$this->db->insert('users', $datausers);
								$id_user=mysql_insert_id();
								
								$dataguru = array(
								   'id' => $id_user,
								   'tgl_daftar' => date('Y-m-d H:i:s'),
								   'id_sekolah' => $this->session->userdata['user_authentication']['id_sekolah'],
								   'nama' => "".$nama[1]."",
								   'nip' => "".$nama[2]."",
								   'password' => "".$pass.""
								);
								$this->db->insert('ak_pegawai', $dataguru); 
								$this->db->where('id', $id_user); 
								$this->db->update('users', array('id_pengguna'=>$id_user));
								$this->db->insert('det_group', array('id_user'=>$id_user,'id_group'=>15)); 
							}
						}
						redirect('admin/schooladmin/dataakun');
					}else{
						exit("<script>window.alert('File type salah! Anda Harus memasukkan file Excell dengan extensi .xls');
					window.history.go(-1);</script>");
					}
				break;
				
			}
		}
		
		$data['main'] 		= 'schooladmin/importexcell';
		$data['page_title'] 	= 'Admin Sekolah';
		$this->load->view('layout/ad_adminsekolah',$data);	 
	 }
	 
	 private function getdataexcell($file=null){
		if($_FILES){
			// Load the spreadsheet reader library
			$this->load->library('excel_reader');
			// Set output Encoding.
			$this->excel_reader->setOutputEncoding('CP1251');
			$file =  $_FILES['userfile']['tmp_name'] ;
			$this->excel_reader->read($file);
			error_reporting(E_ALL ^ E_NOTICE);
			// Sheet 1
			$data = $this->excel_reader->sheets[0] ;
			return $data;
		}
		return false;
	 }
	 function editpegawai($id_pegawai=null)
	 {
		if(isset($_POST['save'])){
			$update_peg=array(
								'nama'=>$_POST['nama'],
								'alamat'=>$_POST['alamat'],
								'hp'=>$_POST['hp'],
								'password'=>$_POST['password']
			);
			$this->db->where('id',$_POST['id_pegawai']);
			$this->db->update('ak_pegawai',$update_peg);
			
			$update_user=array(
								'username'=>$_POST['username'],
								'password'=>md5($_POST['password'])
			);
			$this->db->where('id_pengguna',$_POST['id_pegawai']);
			$this->db->update('users',$update_user);
		}
		$dataeditq=$this->db->query('SELECT p.*,u.username FROM ak_pegawai p JOIN users u ON p.id=u.id_pengguna WHERE p.id='.$_POST['id_pegawai'].'');
		$dataedit=$dataeditq->result_array();
		//pr($dataedit);
		$data['dataedit']=$dataedit;
		$data['otoritas']='pegawai';
		$data['main'] 		= 'schooladmin/editpegawai';
		$data['page_title'] 	= 'Edit Pegawai';
		$this->load->view('layout/ad_blank',$data);
	 }
	 public function editsiswa($id_siswa=0,$otoritas='siswa')
	 {  
		if(isset($_POST['id_siswa'])){$id_siswa=$_POST['id_siswa'];}
		if(isset($_POST['id_siswa_det_jenjang'])){
			$dataupdate=array(
								'nama'=>$_POST['nama'],
								'nis'=>$_POST['nis'],
								'NmOrtu'=>$_POST['NmOrtu'],
								'IDkel'=>$_POST['kelas']
			);
			
			$this->db->where('id',$_POST['id_siswa']);
			$this->db->update('ak_siswa',$dataupdate);
			
			$dataupdatejenjang=array(
								'id_kelas'=>$_POST['kelas']
			);
			$this->db->where('id',$_POST['id_siswa_det_jenjang']);
			$this->db->update('ak_det_jenjang',$dataupdatejenjang);
			
			$dataupdateortu=array(
								'hp'=>$_POST['hp']
			);
			$this->db->where('id_siswa',$_POST['id_siswa']);
			$this->db->update('ak_pegawai',$dataupdateortu);
		}
		$this->load->model('ad_kelas');
		$this->load->model('ad_siswa');
		$data['otoritas']=$otoritas;
		$data['siswa']=$this->ad_siswa->getsiswaByIdSiswaTa($id_siswa); 
		$data['kelas']=$this->ad_kelas->getkelas($this->session->userdata['user_authentication']['id_sekolah']);
		 
		$data['main'] 		= 'schooladmin/editsiswa';
		$data['page_title'] 	= 'Edit Siswa';
		$this->load->view('layout/ad_blank',$data);	
	 }
	 public function adduser($otoritas='')
	 {  	
			if(isset($_POST['nama'])){
				
				switch($_POST['listtype']){
					case "guru":
								//$pass=$this->getpass();
								$pass=$this->getusername($_POST['nama']);
								$datausers = array(
								   'id_group' => 13,
								   'id_sekolah' => $this->session->userdata['user_authentication']['id_sekolah'],
								   'aktif' => 1,
								   'username' => $pass,
								   'password' => md5($pass)
								);
								$this->db->insert('users', $datausers);
								$id_user=mysql_insert_id();
								
								$dataguru = array(
								   'id' => $id_user,
								   'tgl_daftar' => date('Y-m-d H:i:s'),
								   'id_sekolah' => $this->session->userdata['user_authentication']['id_sekolah'],
								   'nama' => $_POST['nama'],
								   'password' => $pass
								);
								$this->db->insert('ak_pegawai', $dataguru);  
								$this->db->where('id', $id_user); 
								$this->db->update('users', array('id_pengguna'=>$id_user));
								//echo $this->db->last_query();
					break;
					case "siswa":
								//$pass=$this->getpass();
								$pass=$this->getusername($_POST['nama']);
								$datausers = array(
								   'id_group' => 12,
								   'id_sekolah' => $this->session->userdata['user_authentication']['id_sekolah'],
								   'aktif' => 1,
								   'username' => $pass,
								   'password' => md5($pass)
								);
								$this->db->insert('users', $datausers);
								$id_user=mysql_insert_id();
								$datasiswa = array(
								   'id' => $id_user,
								   'tgl_daftar' => date('Y-m-d H:i:s'),
								   'id_sekolah' => $this->session->userdata['user_authentication']['id_sekolah'],
								   'nama' => $_POST['nama'],
								   'nis' => $_POST['nis'],
								   'NmOrtu' => $_POST['NmOrtu'],
								   'IDkel' => $_POST['kelas'],
								   'password' => $pass
								);
								$this->db->insert('ak_siswa', $datasiswa); 
								$this->db->where('id', $id_user); 
								$this->db->update('users', array('id_pengguna'=>$id_user));
	 	 	 
								$data_det_jenjang = array(
								   'id_sekolah' => $this->session->userdata['user_authentication']['id_sekolah'],
								   'id_ta' => $this->session->userdata['ak_setting']['ta'],
								   'id_siswa' => $id_user,
								   'id_kelas' => $_POST['kelas'],
								   'parent_kelas' => 0,
								   'kelulusan' => 0,
								);
								$this->db->insert('ak_det_jenjang', $data_det_jenjang); 
								//echo $this->db->last_query();
								
								//insert portu
								$pass=$this->getusername($_POST['NmOrtu']);
								$datausersortu = array(
								   'id_group' => 14,
								   'id_sekolah' => $this->session->userdata['user_authentication']['id_sekolah'],
								   'aktif' => 1,
								   'username' => $pass,
								   'password' => md5($pass)
								);
								$this->db->insert('users', $datausersortu);
								$id_userortu=mysql_insert_id();
								
								$dataortu = array(
								   'id' => $id_userortu,
								   'id_siswa' => $id_user,
								   'tgl_daftar' => date('Y-m-d H:i:s'),
								   'id_sekolah' => $this->session->userdata['user_authentication']['id_sekolah'],
								   'nama' => $_POST['NmOrtu'],
								   'hp' => $_POST['hp'],
								   'password' => $pass
								);
								//pr($dataortu);
								$this->db->insert('ak_pegawai', $dataortu);  
								$this->db->where('id', $id_userortu); 
								$this->db->update('users', array('id_pengguna'=>$id_userortu));
					break;
					case "karyawan":
								//$pass=$this->getpass();
								$pass=$this->getusername($_POST['nama']);
								$datausers = array(
								   'id_group' => 11,
								   'id_sekolah' => $this->session->userdata['user_authentication']['id_sekolah'],
								   'aktif' => 1,
								   'username' => $pass,
								   'password' => md5($pass)
								);
								$this->db->insert('users', $datausers); 
								$id_user=mysql_insert_id();
								$dataguru = array(
								   'id' => $id_user,
								   'tgl_daftar' => date('Y-m-d H:i:s'),
								   'id_sekolah' => $this->session->userdata['user_authentication']['id_sekolah'],
								   'nama' => $_POST['nama'],
								   'password' => $pass
								);
								$this->db->insert('ak_pegawai', $dataguru); 
								$this->db->where('id', $id_user); 
								$this->db->update('users', array('id_pengguna'=>$id_user));
								
								//echo $this->db->last_query();
					break;
				
				}
			}
		   
		   $this->load->model('ad_kelas');
		   $data['kelas']=$this->ad_kelas->getkelas($this->session->userdata['user_authentication']['id_sekolah']);
		 
		   $data['main']		= 'schooladmin/adduser'; // memilih view
		   $data['otoritas'] 	= $otoritas; 
		   $this->load->view('layout/ad_blank',$data);
	 }
	 public function dataakun($listtype=null,$start=0,$page=0)
	 {  
		
		//if($page==null || $page==0){$page=1;}
		$this->load->model('ad_akun');
		$this->load->helper('url');
		$this->load->library('pagination');

		$config['base_url']   = site_url('admin/schooladmin/dataakun/'.$listtype.'');
		
		$config['per_page']   = 15;
		//$config['uri_segment']   = 5;
		$config['cur_page']   = $start;
		$data['start'] = $start;
		$data['listtype'] = $listtype;
		$this->load->model('ad_kelas');

		if($listtype=='siswa'){
			if(isset($_POST['id_kelas'])){
				$cond="AND ak_det_jenjang.id_kelas=".$_POST['id_kelas']."";
				$config['per_page']=25;
				$data['kelasselected']=$_POST['id_kelas'];
			}else{
				$cond="";
			}
			$data['dataguru']==array();
			if(isset($_POST['id_kelas'])){
				$data['dataguru']=$this->ad_akun->getdataSiswaOrtu(''.$start.','.$config['per_page'].'',12,$cond);
			} 
			$config['total_rows'] = $this->ad_akun->getsiswacountall(12,$_POST['id_kelas']);
			
			$data['kelas']=$this->ad_kelas->getkelas($this->session->userdata['user_authentication']['id_sekolah']);
		}elseif($listtype=='karyawan'){
			$data['dataguru']=$this->ad_akun->getdata(''.$start.','.$config['per_page'].'',15);
			$config['total_rows'] = $this->ad_akun->getgurucountall(15);			
		}elseif( $listtype=='ortu'){
			//$data['dataguru']=$this->ad_akun->getdata(''.$start.','.$config['per_page'].'',14);
			if(isset($_POST['id_kelas'])){
				$cond="AND ak_det_jenjang.id_kelas=".$_POST['id_kelas']."";
				$config['per_page']=25;
				$data['kelasselected']=$_POST['id_kelas'];
			}else{
				$cond="";
			}
			$data['dataguru']==array();
			if(isset($_POST['id_kelas'])){
				$data['dataguru']=$this->ad_akun->getdataortu(''.$start.','.$config['per_page'].'',14,$cond);
			}

			$config['total_rows'] = $this->ad_akun->getortucountall(14,$_POST['id_kelas']);	
			$data['kelas']=$this->ad_kelas->getkelas($this->session->userdata['user_authentication']['id_sekolah']);
		}else{
			$data['dataguru']=$this->ad_akun->getdata(''.$start.','.$config['per_page'].'',13);
			$config['total_rows'] = $this->ad_akun->getgurucountall(13);			
		}
		
		//pr($config);
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();

		if ($this->input->post('ajax')) {
		   $data['main']	= 'schooladmin/dataakun'.$listtype.''; // memilih view
		   $this->load->view('layout/ad_blank',$data); // memilih layout
		} else {
		   $data['main']	= 'schooladmin/dataakun'; // memilih view
		   $this->load->view('layout/ad_adminsekolah',$data);
		}
	 }
	 
	 function formulasinilaiakhir($redirectajax=null){
		$this->load->model('ad_nilai');
		$bobotserial='a:5:{s:8:"nilai pr";a:3:{s:10:"id_sekolah";s:1:"1";s:9:"penilaian";s:8:"nilai pr";s:10:"prosentase";s:2:"15";}s:11:"nilai tugas";a:3:{s:10:"id_sekolah";s:1:"1";s:9:"penilaian";s:11:"nilai tugas";s:10:"prosentase";s:2:"15";}s:20:"nilai ulangan harian";a:3:{s:10:"id_sekolah";s:1:"1";s:9:"penilaian";s:20:"nilai ulangan harian";s:10:"prosentase";s:2:"20";}s:9:"nilai uts";a:3:{s:10:"id_sekolah";s:1:"1";s:9:"penilaian";s:9:"nilai uts";s:10:"prosentase";s:2:"25";}s:9:"nilai uas";a:3:{s:10:"id_sekolah";s:1:"1";s:9:"penilaian";s:9:"nilai uas";s:10:"prosentase";s:2:"25";}}';
		
		$bobot=$this->ad_nilai->getBobotNilai($this->session->userdata['user_authentication']['id_sekolah']);
		foreach($bobot as $databobot){
			//unset($databobot['id']);
			@$databobot2[$databobot['penilaian']]=$databobot;
		}
		$data['bobot']=@$databobot2;
		
		if(empty($bobot)){
			$bobotunserial=unserialize($bobotserial);
			foreach($bobotunserial as $penilaian=>$databb){
				$insert=array(
							'id_sekolah'=>$this->session->userdata['user_authentication']['id_sekolah'],
							'penilaian'=>str_replace("_"," ",$penilaian),
							'prosentase'=>$databb['prosentase']
				);
				$this->db->insert('ak_nilai_formulasi',$insert);
			}
		}else{
			//pr($_POST);
			if(isset($_POST['formulasi']) && !empty($_POST['formulasi']) ){
				foreach($_POST['formulasi'] as $penilaian=>$databb){
					$insert=array(
								'id_sekolah'=>$this->session->userdata['user_authentication']['id_sekolah'],
								'penilaian'=>str_replace("_"," ",$penilaian),
								'prosentase'=>$databb
					);
					$this->db->insert('ak_nilai_formulasi',$insert);
				}
				redirect('admin/schooladmin/formulasinilaiakhir/redirectajax');
				
			}
		}
		if ($this->input->post('ajax') || $redirectajax!=null) {
		   $data['main']	= 'schooladmin/formulasinilai/formulasinilaiakhir'; // memilih view
		   $this->load->view('layout/ad_blank',$data); // memilih layout
		} else {
		   $data['main']	= 'schooladmin/formulasinilai/formulasinilaiakhir'; // memilih view
		   $this->load->view('layout/ad_adminsekolah',$data);
		}
	 }
	 function send_download($filename=null)
     {
			$filename=base64_decode($filename);
			$this->load->library('ak_file');
			$this->ak_file->send_download('',$filename);	
	}
	
	/*function fixnis(){
		$q=$this->db->query('SELECT * FROM ak_pegawai WHERE id_sekolah=59 AND id_siswa=""');
		$data=$q->result_array();
		foreach($data as $datane){
			echo $datane['nama'].'<br />';
			echo 'UPDATE ak_pegawai SET hp="" WHERE id='.$datane['id'].' AND id_sekolah=59; </br /></br />';
		}
	}*/
	
	function hp_guru(){
		
		if(isset($_POST['hp'])){
			foreach($_POST['hp'] as $id=>$hp){ 
				$this->db->query('UPDATE ak_pegawai SET hp="'.$hp.'" WHERE id='.$id.'');
			}
		}
		$q=$this->db->query('SELECT p.hp,p.id,p.nama FROM ak_pegawai p JOIN users u ON p.id=u.id_pengguna WHERE p.id_sekolah='.$this->session->userdata['user_authentication']['id_sekolah'].' AND u.id_group=13 ORDER BY p.nama ASC');
		$data['dataguru']=$q->result_array();
		
		
		$data['main']	= 'schooladmin/hp_guru'; // memilih view
		$this->load->view('layout/ad_adminsekolah',$data);
	}
	function smsguru(){
		$q=$this->db->query('SELECT *, p.password as oripass FROM ak_pegawai p JOIN users u ON p.id=u.id_pengguna WHERE p.id_sekolah='.$this->session->userdata['user_authentication']['id_sekolah'].' AND u.id_group=13');
		$data=$q->result_array();
		$this->load->library('smsprivate');
		
		
		//pr($data);
		foreach($data as $datane){
			if(strlen($datane['hp'])>8 AND strlen($datane['hp'])<13){
				$pesan="Assalamualaikum, Bp/Ibu ".$datane['nama'].". info login studentbook anda adalah username: ".$datane['username']." Password: ".$datane['oripass']."  Untuk login ke http://studentbook.co ,Sukses selalu dan tetap semangat. Terima kasih. Wassalamualaikum. (Asbin Arjinto S.Kom)";
				pr($datane['hp']);
				pr($pesan);
				//$this->smsprivate->setTo($datane['hp']);
				//$this->smsprivate->setText($pesan);
				//$this->smsprivate->send();	
			}
		}
	}
}
?>
