<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Ak_uas {

    function createOptionuasByKelasPelajaranIdPegawai($id_pelajaran,$id_kelas) {
        $CI = & get_instance();
        $CI->load->model('ad_uas');
        $uas=$CI->ad_uas->getuasByKelasPelajaranIdPegawaiNotParent($id_pelajaran,$id_kelas);
		//uas($uas);
		$sel='<option value="">Pilih uas</option>';
		foreach($uas as $datauas){
			$sel .='<option  bab="'.$datauas['bab'].'" judul="'.$datauas['judul'].'"   value="'.$datauas['id'].'">'.$datauas['judul'].' [BAB '.$datauas['bab'].']</option>';
		}
		return $sel;
    }
    function createOptionuasRemidiEditByKelasPelajaranIdPegawai($id_pelajaran,$id_kelas,$id_parent_uas) {
        $CI = & get_instance();
        $CI->load->model('ad_uas');
        $uas=$CI->ad_uas->getuasByKelasPelajaranIdPegawaiNotParent($id_pelajaran,$id_kelas);
		//uas($uas);
		$sel='<option value="">Pilih uas</option>';
		$selected='';
		foreach($uas as $datauas){
			if($datauas['id']==$id_parent_uas){$selected='selected';}else{$selected='';}
			$sel .='<option '.$selected.'  bab="'.$dataharian['bab'].'" judul="'.$dataharian['judul'].'"  value="'.$datauas['id'].'">'.$datauas['judul'].' [BAB '.$datauas['bab'].']</option>';
		}
		return $sel;
    }
    function createOptionFileuasByIduas($id_uas) {
        $CI = & get_instance();
        $CI->load->model('ad_uas');
        $file=$CI->ad_uas->getFileuasById_uas($id_uas);
		//uas($file);
		$sel='';
		foreach($file as $datafile){
			$sel .='<li><input checked onclick="return false;" type="checkbox" name="file_name_cek[]" value="'.$datafile['file_name'].'" /> '.$datafile['file_name'].'</li>';
		}
		return $sel;
    }
	function createOptionSiswaRemidiByIdKelas($id_kelas,$id_uas) {
        $CI = & get_instance();
        $CI->load->model('ad_uas');
        $CI->load->model('ad_siswa');
        $siswaremidi=$CI->ad_uas->getsiswaRemidiByIdKelasIduas($id_kelas,$id_uas);
		$siswa=$CI->ad_siswa->getsiswaByIdKelas($id_kelas);
		foreach($siswaremidi as $datasiswaremidi){
			$siswa3[$datasiswaremidi['id_siswa_det_jenjang']]=$datasiswaremidi;
		}
		//uas($siswa3);
		$sel='<option value="">Pilih Siswa</option>';
		foreach($siswa as $datasiswa){
			if(@$siswa3[$datasiswa['id_siswa_det_jenjang']]['id_siswa_det_jenjang']==$datasiswa['id_siswa_det_jenjang']){$slctd='selected';}else{ $slctd='';}
			$sel .='<option '.$slctd.' value="'.$datasiswa['id_siswa_det_jenjang'].'">('.$datasiswa['nis'].') '.$datasiswa['nama'].'</option>';
		}
		return $sel;
    }
}

