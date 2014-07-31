<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Ak_uts {

    function createOptionutsByKelasPelajaranIdPegawai($id_pelajaran,$id_kelas) {
        $CI = & get_instance();
        $CI->load->model('ad_uts');
        $uts=$CI->ad_uts->getutsByKelasPelajaranIdPegawaiNotParent($id_pelajaran,$id_kelas);
		//uts($uts);
		$sel='<option value="">Pilih uts</option>';
		foreach($uts as $datauts){
			$sel .='<option  bab="'.$datauts['bab'].'" judul="'.$datauts['judul'].'"  value="'.$datauts['id'].'">'.$datauts['judul'].' [BAB '.$datauts['bab'].']</option>';
		}
		return $sel;
    }
    function createOptionutsRemidiEditByKelasPelajaranIdPegawai($id_pelajaran,$id_kelas,$id_parent_uts) {
        $CI = & get_instance();
        $CI->load->model('ad_uts');
        $uts=$CI->ad_uts->getutsByKelasPelajaranIdPegawaiNotParent($id_pelajaran,$id_kelas);
		//uts($uts);
		$sel='<option value="">Pilih uts</option>';
		$selected='';
		foreach($uts as $datauts){
			if($datauts['id']==$id_parent_uts){$selected='selected';}else{$selected='';}
			$sel .='<option '.$selected.'  bab="'.$dataharian['bab'].'" judul="'.$dataharian['judul'].'"  value="'.$datauts['id'].'">'.$datauts['judul'].' [BAB '.$datauts['bab'].']</option>';
		}
		return $sel;
    }
    function createOptionFileutsByIduts($id_uts) {
        $CI = & get_instance();
        $CI->load->model('ad_uts');
        $file=$CI->ad_uts->getFileutsById_uts($id_uts);
		//uts($file);
		$sel='';
		foreach($file as $datafile){
			$sel .='<li><input checked onclick="return false;" type="checkbox" name="file_name_cek[]" value="'.$datafile['file_name'].'" /> '.$datafile['file_name'].'</li>';
		}
		return $sel;
    }
	function createOptionSiswaRemidiByIdKelas($id_kelas,$id_uts) {
        $CI = & get_instance();
        $CI->load->model('ad_uts');
        $CI->load->model('ad_siswa');
        $siswaremidi=$CI->ad_uts->getsiswaRemidiByIdKelasIduts($id_kelas,$id_uts);
		$siswa=$CI->ad_siswa->getsiswaByIdKelas($id_kelas);
		foreach($siswaremidi as $datasiswaremidi){
			$siswa3[$datasiswaremidi['id_siswa_det_jenjang']]=$datasiswaremidi;
		}
		//uts($siswa3);
		$sel='<option value="">Pilih Siswa</option>';
		foreach($siswa as $datasiswa){
			if(@$siswa3[$datasiswa['id_siswa_det_jenjang']]['id_siswa_det_jenjang']==$datasiswa['id_siswa_det_jenjang']){$slctd='selected';}else{ $slctd='';}
			$sel .='<option '.$slctd.' value="'.$datasiswa['id_siswa_det_jenjang'].'">('.$datasiswa['nis'].') '.$datasiswa['nama'].'</option>';
		}
		return $sel;
    }
}

