<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Ak_harian {

    function createOptionharianByKelasPelajaranIdPegawai($id_pelajaran,$id_kelas) {
        $CI = & get_instance();
        $CI->load->model('ad_harian');
        $harian=$CI->ad_harian->getharianByKelasPelajaranIdPegawaiNotParent($id_pelajaran,$id_kelas);
		
		$sel='<option value="">Pilih harian</option>';
		foreach($harian as $dataharian){
			$sel .='<option  bab="'.$dataharian['bab'].'" judul="'.$dataharian['judul'].'" value="'.$dataharian['id'].'">'.$dataharian['judul'].' [BAB '.$dataharian['bab'].']</option>';
		}
		return $sel;
    }
    function createOptionharianRemidiEditByKelasPelajaranIdPegawai($id_pelajaran,$id_kelas,$id_parent_harian) {
        $CI = & get_instance();
        $CI->load->model('ad_harian');
        $harian=$CI->ad_harian->getharianByKelasPelajaranIdPegawaiNotParent($id_pelajaran,$id_kelas);
		$sel='<option value="">Pilih harian</option>';
		$selected='';
		foreach($harian as $dataharian){
			if($dataharian['id']==$id_parent_harian){$selected='selected';}else{$selected='';}
			$sel .='<option '.$selected.'  bab="'.$dataharian['bab'].'" judul="'.$dataharian['judul'].'"  value="'.$dataharian['id'].'">'.$dataharian['judul'].' [BAB '.$dataharian['bab'].']</option>';
		}
		return $sel;
    }
    function createOptionFileharianByIdharian($id_harian) {
        $CI = & get_instance();
        $CI->load->model('ad_harian');
        $file=$CI->ad_harian->getFileharianById_harian($id_harian);
		
		$sel='';
		foreach($file as $datafile){
			$sel .='<li><input checked onclick="return false;" type="checkbox" name="file_name_cek[]" value="'.$datafile['file_name'].'" /> '.$datafile['file_name'].'</li>';
		}
		return $sel;
    }
	function createOptionSiswaRemidiByIdKelas($id_kelas,$id_harian) {
        $CI = & get_instance();
        $CI->load->model('ad_harian');
        $CI->load->model('ad_siswa');
        $siswaremidi=$CI->ad_harian->getsiswaRemidiByIdKelasIdharian($id_kelas,$id_harian);
		$siswa=$CI->ad_siswa->getsiswaByIdKelas($id_kelas);
		foreach($siswaremidi as $datasiswaremidi){
			$siswa3[$datasiswaremidi['id_siswa_det_jenjang']]=$datasiswaremidi;
		}
		
		$sel='<option value="">Pilih Siswa</option>';
		foreach($siswa as $datasiswa){
			if(@$siswa3[$datasiswa['id_siswa_det_jenjang']]['id_siswa_det_jenjang']==$datasiswa['id_siswa_det_jenjang']){$slctd='selected';}else{ $slctd='';}
			$sel .='<option '.$slctd.' value="'.$datasiswa['id_siswa_det_jenjang'].'">('.$datasiswa['nis'].') '.$datasiswa['nama'].'</option>';
		}
		return $sel;
    }
}

