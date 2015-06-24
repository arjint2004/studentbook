<?php
Class Ad_notifikasi extends CI_Model{
	
	function get_notifByIdPengguna($id_pengguna=0){
		$datapeg0=array();
		$datapeg=array();
		$datapeg2=array();
		$fotosender=array();
		//$queryf=$this->db->query('SELECT ap.foto FROM ak_pegawai ap JOIN ak_notifikasi an ON  an.id_pengirim =ap.id WHERE an.id_pengguna ="'.$id_pengguna.'"');
		//$datapegf=$queryf->result_array();
		//pr($datapegf);
		
		if($this->session->userdata['user_authentication']['otoritas']!='ortu' && $this->session->userdata['user_authentication']['otoritas']!='siswa'){
		$query0=$this->db->query('SELECT an.* FROM 
									ak_notifikasi an JOIN ak_pegawai ap
									ON an.id_pengguna =ap.id
									WHERE an.id_pengguna ="'.$id_pengguna.'" AND date(waktu) > "'.date("Y-m-d", mktime(0, 0, 0,  date("m")  , date("d")-14, date("Y"))).'" ORDER BY an.id DESC');
		$datapeg0=$query0->result_array();
		//echo $this->db->last_query().'<br />';
		}							
		if($this->session->userdata['user_authentication']['otoritas']=='ortu'){
		$query=$this->db->query('SELECT an.* FROM 
									ak_notifikasi an JOIN ak_siswa ap 
									JOIN ak_pegawai peg  
									ON an.id_pengguna =ap.id 
									AND peg.id_siswa=ap.id 
									WHERE peg.id ="'.$id_pengguna.'" AND date(waktu) > "'.date("Y-m-d", mktime(0, 0, 0,  date("m")  , date("d")-14, date("Y"))).'" ORDER BY an.id DESC');//echo $this->db->last_query();
		$datapeg=$query->result_array();
		//echo $this->db->last_query().'<br />';
		}
		if($this->session->userdata['user_authentication']['otoritas']=='siswa'){
		$query2=$this->db->query('SELECT an.* FROM 
									ak_notifikasi an JOIN ak_siswa ap
									ON an.id_pengguna =ap.id 
									WHERE an.id_pengguna ="'.$id_pengguna.'" AND date(waktu) > "'.date("Y-m-d", mktime(0, 0, 0,  date("m")  , date("d")-14, date("Y"))).'" ORDER BY an.id DESC');//echo $this->db->last_query();
		$datapeg2=$query2->result_array();
		//echo $this->db->last_query().'<br />';
		}
		$mrger0 = array_merge($datapeg,$datapeg2);
		$mrger = array_merge($mrger0,$datapeg0);
		//pr($mrger);
		
		usort($mrger, function($a, $b) {
		  $ad = new DateTime($a['waktu']);
		  $bd = new DateTime($b['waktu']);

		  if ($ad == $bd) {
			return 0;
		  }

		  return $ad < $bd ? 1 : -1;
		});
		return $mrger;
	}
	
	
	function setnotifreaded($id_pengguna=0){
		$query=$this->db->query('UPDATE ak_notifikasi SET `read`=1 WHERE id_pengguna="'.$id_pengguna.'"');
	}
	function get_notifAktif($id_pengguna=0){
		$query=$this->db->query('SELECT count(*) as jml FROM 
									ak_notifikasi an
									WHERE an.id_pengguna ="'.$id_pengguna.'" AND an.read=0');//echo $this->db->last_query();
		$datapeg=$query->result_array();
		
		return $datapeg[0]['jml'];
	}
	function get_notifByIdPengirim($id_pengirim=0){
		$query=$this->db->query('SELECT * FROM 
									ak_notifikasi an JOIN ak_pegawai ap
									ON an.id_pengirim=ap.id
									WHERE an.id_pengirim="'.$id_pengirim.'" GROUP BY an.waktu');//echo $this->db->last_query();
		$datapeg=$query->result_array();
		$query2=$this->db->query('SELECT * FROM 
									ak_notifikasi an JOIN ak_siswa ap
									ON an.id_pengirim=ap.id
									WHERE an.id_pengirim="'.$id_pengirim.'" GROUP BY an.waktu');//echo $this->db->last_query();
		$datapeg2=$query->result_array();
		
		return array_merge($datapeg,$datapeg2);
	}
	function add_notif($id_sekolah=null,$id_pengguna=null,$id_group=null,$gorup_notif='',$notif=''){
					
					$insert=array(
							'id_sekolah'=>$id_sekolah,
							'id_pengirim'=>$this->session->userdata['user_authentication']['id_pengguna'],
							'id_pengguna'=>$id_pengguna,
							'id_group'=>$id_group,
							'gorup_notif'=>$gorup_notif,
							'notifikasi'=>$notif,
							'ta'=>$this->session->userdata['ak_setting']['ta'],
							'semester'=>$this->session->userdata['ak_setting']['semester'],
							'read'=>0,
							'waktu'=>date("Y-m-d H:i:s")
			);
		$this->db->insert('ak_notifikasi',$insert);
	}
	function get_notif_tmp($gorup_notif=''){
		$query=$this->db->query('SELECT * FROM ak_notifikasi_temp WHERE gorup_notif="'.$gorup_notif.'"');//echo $this->db->last_query();
		return $query->result_array();
	}
	function add_notif_sms_ortu_per_siswa_detjenjang($id_siswa_det_jenjang=null,$id_mapel=null,$data=array()){
		// !!!!!!........sudah tidak di pakai
		$this->load->model('ad_akun');
		$this->load->model('ad_pelajaran');
		$siswa=$this->ad_akun->getdataSiswaByDetjenjang($id_siswa_det_jenjang);
		if($id_mapel=='penghubung'){
			$mapelarray[0]['alias']='Ada, cek akun STUDENTBOOK anda';
		}else{
			$mapelarray=$this->ad_pelajaran->getdataById($id_mapel);
		}
			$data=array(
						'id_sekolah'=>$siswa[0]['id_sekolah'],
						'id_siswa'=>$siswa[0]['id'],
						'id_det_jenjang'=>$id_siswa_det_jenjang,
						'nama_siswa'=>$siswa[0]['nama'],
						'notifikasi'=>$mapelarray[0]['alias'],
						'group'=>$data['group'],
						'waktu'=>date("Y-m-d H:i:s")
			);
			
			$this->db->insert('ak_notifikasi_sms',$data);
			//echo $this->db->last_query();
	}
	function add_notif_sms_ortu_perkelas($id_kelas=null,$id_mapel=null,$data=array()){
		// !!!!!!!... sudah tidak di pakai
		$this->load->model('ad_siswa');
		$this->load->model('ad_pelajaran');
		$siswa=$this->ad_siswa->getsiswaByIdKelas($id_kelas);
		$mapelarray=$this->ad_pelajaran->getdataById($id_mapel);
		foreach($siswa as $ky=>$datasiswa){
			$data=array(
						'id_sekolah'=>$datasiswa['id_sekolah'],
						'id_siswa'=>$datasiswa['id'],
						'id_det_jenjang'=>$datasiswa['id_siswa_det_jenjang'],
						'nama_siswa'=>$datasiswa['nama'],
						'notifikasi'=>$mapelarray[0]['alias'],
						'group'=>$data['group'],
						'waktu'=>date("Y-m-d H:i:s")
			);
			$this->db->insert('ak_notifikasi_sms',$data);
		
		}//echo $this->db->last_query();
	}
	function add_notif_sms_ortu_per_siswa_detjenjang_absen($id_siswa_det_jenjang=null,$data2=array()){
		// !!!!!!!... hanya absen yang pakai
		$this->load->model('ad_akun');
		$siswa=$this->ad_akun->getdataSiswaByDetjenjang($id_siswa_det_jenjang);
			$nama=explode(" ",$siswa[0]['nama']);
			//$data2['notifikasi']="Ananda ".strtoupper($nama[0])." hari ini (".date('d-m-Y').") hadir pada pelajaran ke |".$data2['jam_ke']."| ";
			if($data2['absensi']=='masuk'){$data2['absensi']='hadir';}
			$data2['notifikasi']="PRESENSI Ananda ".strtoupper($nama[0])." hari ini ".date('d-m-Y')." |".$_POST['pelajarannyaabsen'].":".$data2['absensi']."|";
			unset($data2['jam_ke']);
			unset($data2['absensi']);
			unset($nama);
			$data=array(
						'id_sekolah'=>$siswa[0]['id_sekolah'],
						'id_siswa'=>$siswa[0]['id'],
						'id_det_jenjang'=>$id_siswa_det_jenjang,
						'nama_siswa'=>$siswa[0]['nama']
			);
			$data3=array_merge($data2,$data);
			//pr($data3);
			if(in_array('sms_absensi',$this->session->userdata['ak_setting']['fitursekolah'])){
				$this->db->insert('ak_notifikasi_sms',$data3);
			}
			//echo $this->db->last_query();
			
	}
	function add_notif_sms_ortu_per_siswa_detjenjang_absenedit($currentsms2,$id_det_jenjang,$databsen){
		// !!!!!!!... hanya absen yang pakai
			if($this->session->userdata['ak_setting']['jenjang'][0]['nama']!='SD'){
				// set notif absen
				$mapelabsenq=$this->db->query('SELECT ab.*,ap.nama as mapel,ap.alias FROM ak_absensi ab
								  JOIN ak_pelajaran ap ON ab.id_pelajaran=ap.id
								  WHERE ab.id_kelas=?  AND ab.tanggal=? AND ab.id_siswa_det_jenjang =? ORDER BY ab.jam_ke',array($_POST['id_kelas'],$_POST['tanggal'],$id_det_jenjang));
				$mapelabsen=$mapelabsenq->result_array();
				//pr($this->db->last_query());
				
				foreach($mapelabsen as $smse){
					if($smse['absensi']=='masuk'){$smse['absensi']='hadir';}
					if($smse['alias']==''){$aliase=$smse['mapel'];}else{$aliase=$smse['alias'];}
					$smse2 .="|".$aliase.":".$smse['absensi']."";
				}
				
				$textsms=explode("|",$currentsms2[$id_det_jenjang]['notifikasi']);
				$dataUpdate['notifikasi']=$textsms[0].''.$smse2;
			}else{
				$textsms=explode("|",$currentsms2[$id_det_jenjang]['notifikasi']);
				$dataUpdate['notifikasi']=$textsms[0].'|'.$databsen.'|';
			}
			$this->db->where('id',$currentsms2[$id_det_jenjang]['id']);
			$this->db->update('ak_notifikasi_sms',$dataUpdate);
			
	}
	
	function add_notif_sms_ortu_nilai_perkelas($id_kelas=null,$id_mapel=null,$data=array(),$nilai){
			// pr($data);
		$this->load->model('ad_siswa');
		$this->load->model('ad_pelajaran');
		$siswa=$this->ad_siswa->getsiswaByIdKelas($id_kelas);
		$mapelarray=$this->ad_pelajaran->getdataById($id_mapel);
		foreach($siswa as $ky=>$datasiswa){
			$data=array(
						'id_sekolah'=>$datasiswa['id_sekolah'],
						'id_siswa'=>$datasiswa['id'],
						'id_det_jenjang'=>$datasiswa['id_siswa_det_jenjang'],
						'nama_siswa'=>$datasiswa['nama'],
						'notifikasi'=>$mapelarray[0]['alias']."(".$nilai.")",
						'group'=>$data['group'],
						'waktu'=>date("Y-m-d H:i:s")
			);
			$this->db->insert('ak_notifikasi_sms',$data);
		
		}//echo $this->db->last_query();
	}
	
	function add_notif_sms_nilai_ortu_per_siswa_detjenjang($id_siswa_det_jenjang=null,$id_mapel=null,$data=array(),$nilai){
		
		$this->load->model('ad_akun');
		$this->load->model('ad_pelajaran');
		$siswa=$this->ad_akun->getdataSiswaByDetjenjang($id_siswa_det_jenjang);
		$mapelarray=$this->ad_pelajaran->getdataById($id_mapel);
			$data=array(
						'id_sekolah'=>$siswa[0]['id_sekolah'],
						'id_siswa'=>$siswa[0]['id'],
						'id_det_jenjang'=>$id_siswa_det_jenjang,
						'nama_siswa'=>$siswa[0]['nama'],
						'notifikasi'=>$mapelarray[0]['alias']."(".$nilai.")",
						'group'=>$data['group'],
						'waktu'=>date("Y-m-d H:i:s")
			);
			
		$this->db->insert('ak_notifikasi_sms',$data);
		//echo $this->db->last_query();
	}
	
	function add_notif_siswa_perkelas($id_kelas=null,$gorup_notif='',$notif=''){
		$this->load->model('ad_siswa');
		$siswa=$this->ad_siswa->getsiswaByIdKelas($id_kelas);
		foreach($siswa as $ky=>$datasiswa){
			$insert=array(
							'id_sekolah'=>$datasiswa['id_sekolah'],
							'id_pengirim'=>$this->session->userdata['user_authentication']['id_pengguna'],
							'id_pengguna'=>$datasiswa['id'],
							'id_group'=>12,
							'gorup_notif'=>$gorup_notif,
							'notifikasi'=>$notif,
							'ta'=>$this->session->userdata['ak_setting']['ta'],
							'semester'=>$this->session->userdata['ak_setting']['semester'],
							'read'=>0,
							'waktu'=>date("Y-m-d H:i:s")
			);
			$this->db->insert('ak_notifikasi',$insert);
		
		}
	}
	function add_notif_siswa_persiswa($id_siswa=null,$gorup_notif='',$notif=''){
		$this->load->model('ad_siswa');
		$siswa=$this->ad_siswa->getsiswaByIdSiswa($id_siswa);
		foreach($siswa as $ky=>$datasiswa){
			$insert=array(
							'id_sekolah'=>$datasiswa['id_sekolah'],
							'id_pengirim'=>$this->session->userdata['user_authentication']['id_pengguna'],
							'id_pengguna'=>$datasiswa['id'],
							'id_group'=>12,
							'gorup_notif'=>$gorup_notif,
							'notifikasi'=>$notif,
							'ta'=>$this->session->userdata['ak_setting']['ta'],
							'semester'=>$this->session->userdata['ak_setting']['semester'],
							'read'=>0,
							'waktu'=>date("Y-m-d H:i:s")
			);
			$this->db->insert('ak_notifikasi',$insert);
		
		}
	}
}
 