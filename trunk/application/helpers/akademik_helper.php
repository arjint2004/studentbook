<?php 

/**
 * Global Helper Create By jefrisugiarto@yahoo.com
 * programer PHP, codeigniter, HTML, javascript,css 
 * @param array 
 * @return string
 */
 
 
 //JADWAL
if (!function_exists('getdayjadwal')) {
	function getdayjadwal($hari) {
		
		switch($hari){
			case"Mon":
				$hari2='Senin';
			break;
			case"Tue":
				$hari2='Selasa';
			break;
			case"Wed":
				$hari2='Rabu';
			break;
			case"Thu":
				$hari2='Kamis';
			break;
			case"Fri":
				$hari2='Jumat';
			break;
			case"Sat":
				$hari2='Sabtu';
			break;
			case"Sun":
				$hari2='Minggu';
			break;
			default:
				$hari2=$hari;
			break;
		}
		
		switch($hari2){
			case"Senin":
				$tgl='2013-02-11';
			break;
			case"Selasa":
				$tgl='2013-02-12';
			break;
			case"Rabu":
				$tgl='2013-02-13';
			break;
			case"Kamis":
				$tgl='2013-02-14';
			break;
			case"Jumat":
				$tgl='2013-02-15';
			break;
			case"Sabtu":
				$tgl='2013-02-16';
			break;
			case"Minggu":
				$tgl='2013-02-17';
			break;
			
		}
		return array($hari2,$tgl);
	}
}



if (!function_exists('jejnjangoption')) {
    function jejnjangoption($atribut='') {
		$CI = get_instance();
		$CI->load->model('ad_jenjang');
		$select='';
		$jenjang=$CI->ad_jenjang->getjenjang();
		foreach($jenjang as $dtjnj){
			$jenjang2[$dtjnj['nama']]=$dtjnj;
		}
		$jenjang2['TK']=$jenjang2['SD'];
		$jenjang2['MI']=$jenjang2['SD'];
		$jenjang2['MTs']=$jenjang2['SMP'];
		$jenjang2['MA']=$jenjang2['SMA'];
		$jenjang2['KURSUS']=$jenjang2['SD'];
		$jenjang2['SEKOLAH KHUSUS (SK)']=$jenjang2['SD'];
		//pr($jenjang2);
		$select.='<select name="jenjang" '.$atribut.'>';
		$select.='<option value="">Pilih Jenjang</option>';
		foreach($jenjang2 as $jnj=>$datajenjang){
			if(@$_POST['jenjang']==$datajenjang['id']){$sl='selected';}else{$sl='';}
			$select.='<option '.$sl.' value="'.$datajenjang['id'].'">'.$jnj.'</option>';
		}
		$select.='</select>';
		echo $select;
	}
}
if (!function_exists('getkelaswali')) {
    function getkelaswali($atribut='',$id_pengguna=null) {
		$CI = get_instance();
		$CI->load->model('ad_kelas');
		$select='';
		$kelas=$CI->ad_kelas->getkelasWali($CI->session->userdata['user_authentication']['id_sekolah'],$id_pengguna);

		$select.='<select name="id_kelas" '.$atribut.'>';
		$select.='<option class="pilih" value="0">Pilih Kelas</option>';
		foreach($kelas['array'] as $ky=>$datakelas){
			if(@$_POST['id_kelas']==$datakelas['id'] || $kelas['current'][0]['id']==$datakelas['id']){$sl='selected';}else{$sl='';}
			$select.='<option '.$sl.' value="'.$datakelas['id'].'">'.$datakelas['kelas'].''.$datakelas['nama'].'</option>';
		}
		$select.='</select>';
		echo $select;
	}
}
if (!function_exists('totext')) {
    function totext($nilai='') {
		if($nilai=='A'){
			echo 'Sangat Baik';
		}
		if($nilai=='B'){
			echo 'Baik';
		}
		if($nilai=='C'){
			echo 'Cukup';
		}
		if($nilai=='D'){
			echo 'Kurang';
		}
		
	}
}
if (!function_exists('nilaihuruf')) {
    function nilaihuruf($nilai=0) {
		if($nilai>4 AND $nilai<=5){
			echo 'A+';
		}
		if($nilai>3.5 AND $nilai<=4){
			echo 'A';
		}
		if($nilai>3 AND $nilai<=3.5){
			echo 'B+';
		}
		if($nilai>2.5 AND $nilai<=3){
			echo 'B';
		}
		if($nilai>2 AND $nilai<=2.5){
			echo 'C+';
		}
		if($nilai>1.5 AND $nilai<=2){
			echo 'D+';
		}
		if($nilai>1 AND $nilai<=1.5){
			echo 'D';
		}
	}
}
if (!function_exists('getkelas')) {
    function getkelas($atribut='') {
		$CI = get_instance();
		$CI->load->model('ad_kelas');
		$select='';
		$kelas=$CI->ad_kelas->getkelasIdIset($CI->session->userdata['user_authentication']['id_sekolah']);
		
		$select.='<select name="id_kelas" '.$atribut.'>';
		$select.='<option value="">Pilih Kelas</option>';
		foreach($kelas as $ky=>$datakelas){
			if(@$_POST['id_kelas']==$datakelas['id']){$sl='selected';}else{$sl='';}
			$select.='<option '.$sl.' value="'.$datakelas['id'].'">'.$datakelas['kelas'].''.$datakelas['nama'].'</option>';
		}
		$select.='</select>';
		echo $select;
	}
}

if (!function_exists('selectkelasbyIdDetJenjang')) {
	 function selectkelasbyIdDetJenjang($x='') {
		$CI = get_instance();
		$CI->load->model('ad_kelas');
		$kelas=$CI->ad_kelas->getkelasById($CI->session->userdata['user_authentication']['id_sekolah'],$CI->session->userdata['user_authentication']['id_kelas_siswa_det_jenjang']);
		echo '
			<select class="selectfilter" id="kelas_add'.$x.'" name="id_kelas">
				<option value="">Pilih Kelas</option>';
				 foreach($kelas as $datakelas){
					if(@$_POST['id_kelas']==$datakelas['id']){$sel= 'selected';}else{$sel= '';}
					echo '<option  '.$sel.' value="'.$datakelas['id'].'">'.$datakelas['kelas'].''.$datakelas['nama'].'</option>';
				 } 
		echo '
		</select>
		';
	}
}
if (!function_exists('selectkelasbyIdpegawai')) {
	 function selectkelasbyIdpegawai($x='') {
		$CI = get_instance();
		$CI->load->model('ad_kelas');
		$kelas=$CI->ad_kelas->getkelasByPengajar($CI->session->userdata['user_authentication']['id_sekolah'],$CI->session->userdata['user_authentication']['id_pengguna']);
		echo '
			<select class="selectfilter" id="kelas_add'.$x.'" name="id_kelas">
				<option value="">Pilih Kelas</option>';
				 foreach($kelas as $datakelas){
					if(@$_POST['id_kelas']==$datakelas['id']){$sel= 'selected';}else{$sel= '';}
					echo '<option  '.$sel.' value="'.$datakelas['id'].'">'.$datakelas['kelas'].''.$datakelas['nama'].'</option>';
				 } 
		echo '
		</select>
		';
	}
}
if (!function_exists('jadwal')) {
    function jadwal($kelas=0) {
		if(isset($_POST['postjadwal']) && isset($_POST['id_kelas'])){
			$kelas=$_POST['id_kelas'];
		}
		// Get a reference to the controller object
		$CI = get_instance();

		if(isset($CI->session->userdata['user_authentication']['id_kelas_siswa_det_jenjang'])){
			$kelas=$CI->session->userdata['user_authentication']['id_kelas_siswa_det_jenjang'];
		}
		// You may need to load the model if it hasn't been pre-loaded
		$CI->load->model('ad_jadwal');
		
		// Call a function of the model
		
		//hari ini
		$tglx=getdayjadwal(date("D"));
		$tgl=$tglx[1];
		$jadwal['now']=$CI->ad_jadwal->getJadwalByTanggalKelas($tgl,$kelas);
		$jadwal['semuahariini']=$CI->ad_jadwal->getJadwalByTanggalKelasSemuaHariini($tgl,$kelas);
		//mingguan
		$harinya=array('Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu');
		foreach($harinya as $hari){
			$tgl=getdayjadwal($hari);
			//echo $tgl."<br />";
			$jadwal['mingguan'][$hari]=$CI->ad_jadwal->getJadwalByTanggalKelas($tgl[1],$kelas);
			
		}
		
		/*foreach($harinya as $hari){
			$tgl=getdayjadwal($hari);
			//echo $tgl."<br />";
			$jadwal['semuamingguan'][$hari]=$CI->ad_jadwal->getJadwalByTanggalKelasSemuaHariini($tgl[1],$kelas);
			
		}	*/	
		include('application/views/jadwal.php');
    }
}

//REKAP NILAI
if (!function_exists('rekapitulasinilaiByIdSiswaDjenjang')) {
    function rekapitulasinilaiByIdSiswaDjenjang($id_siswa_det_jenjang) {
		// Get a reference to the controller object
		$CI = get_instance();

		// You may need to load the model if it hasn't been pre-loaded
		//Pelajaran
		$CI->load->model('ad_pelajaran');
		$pelajaran=$CI->ad_pelajaran->getdataByIdDetJenjang($id_siswa_det_jenjang);
		
		//PR
		$CI->load->model('ad_nilai');
		$nilai_pr=$CI->ad_nilai->getnilaiByIdSiswaDetjenjang($id_siswa_det_jenjang,'ak_nilai_pr');
		$nilai_tugas=$CI->ad_nilai->getnilaiByIdSiswaDetjenjang($id_siswa_det_jenjang,'ak_nilai_tugas');
		$nilai_uh=$CI->ad_nilai->getnilaiByIdSiswaDetjenjang($id_siswa_det_jenjang,'ak_nilai_ulangan_harian');
		$nilai_uts=$CI->ad_nilai->getnilaiByIdSiswaDetjenjang($id_siswa_det_jenjang,'ak_nilai_uts');
		$nilai_uas=$CI->ad_nilai->getnilaiByIdSiswaDetjenjang($id_siswa_det_jenjang,'ak_nilai_uas');
		
		if(empty($nilai_pr)){$nilai_pr=array(0=>array(0=>0));}
		if(empty($nilai_tugas)){$nilai_tugas=array(0=>array(0=>0));}
		if(empty($nilai_uh)){$nilai_uh=array(0=>array(0=>0));}
		if(empty($nilai_uts)){$nilai_uts=array(0=>array(0=>0));}
		if(empty($nilai_uas)){$nilai_uas=array(0=>array(0=>0));}
		//pr($nilai_uts); 
		include('application/views/akademik/nilai/rekapitulasinilai.php');
    }
}
if (!function_exists('rekapitulasinilaiByKelasMapel')) {
    function rekapitulasinilaiByKelasMapel($kelas,$id_pelajaran) {
		// Get a reference to the controller object
		$CI = get_instance();

		// You may need to load the model if it hasn't been pre-loaded
		//Pelajaran
		$CI->load->model('ad_siswa');
		$siswa=$CI->ad_siswa->getsiswaByIdKelas($kelas);
		
		$CI->load->model('ad_nilai');
		
		$nilai_pr=$CI->ad_nilai->getnilaiByKelasMapelSiswa($kelas,$id_pelajaran,'ak_nilai_pr');
		$nilai_tugas=$CI->ad_nilai->getnilaiByKelasMapelSiswa($kelas,$id_pelajaran,'ak_nilai_tugas');
		$nilai_uh=$CI->ad_nilai->getnilaiByKelasMapelSiswa($kelas,$id_pelajaran,'ak_nilai_ulangan_harian');
		$nilai_uts=$CI->ad_nilai->getnilaiByKelasMapelSiswa($kelas,$id_pelajaran,'ak_nilai_uts');
		$nilai_uas=$CI->ad_nilai->getnilaiByKelasMapelSiswa($kelas,$id_pelajaran,'ak_nilai_uas');
		
		if(empty($nilai_pr)){$nilai_pr=array(0=>array(0=>array(0=>0)));}
		if(empty($nilai_tugas)){$nilai_tugas=array(0=>array(0=>array(0=>0)));}
		if(empty($nilai_uh)){$nilai_uh=array(0=>array(0=>array(0=>0)));}
		if(empty($nilai_uts)){$nilai_uts=array(0=>array(0=>array(0=>0)));}
		if(empty($nilai_uas)){$nilai_uas=array(0=>array(0=>array(0=>0)));}
		
		$cpr=array_slice($nilai_pr, 0, 1);
		$ctugas=array_slice($nilai_tugas, 0, 1);
		$cuh=array_slice($nilai_uh, 0, 1);
		
		if(!empty($nilai_uts)){
		foreach($nilai_uts as $id_siswa_det_jenjang=>$datauts){
			@$nilai_uts2[$id_siswa_det_jenjang][0]=@$datauts[0]['nilai'];
			@$nilai_uts2[$id_siswa_det_jenjang][1]=@$datauts[1]['nilai'];
		}
		}
		
		unset($nilai_uts);
		if(!empty($nilai_uas)){
		foreach($nilai_uas as $id_siswa_det_jenjang=>$datauas){
			@$nilai_uas2[$id_siswa_det_jenjang][0]=@$datauas[0]['nilai'];
			@$nilai_uas2[$id_siswa_det_jenjang][1]=@$datauas[1]['nilai'];
		}
		}
		unset($nilai_uas);
		//pr($nilai_pr);
		include('application/views/akademik/nilai/rekapitulasinilaibykelasmapel.php');
    }

}


