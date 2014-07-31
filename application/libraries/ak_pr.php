<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Ak_pr {

    function createOptionPrByKelasPelajaranIdPegawai($id_pelajaran,$id_kelas) {
        $CI = & get_instance();
        $CI->load->model('ad_pr');
        $pr=$CI->ad_pr->getPrByKelasPelajaranIdPegawaiNotParent($id_pelajaran,$id_kelas);
		//pr($pr);
		$sel='<option value="">Pilih PR</option>';
		foreach($pr as $datapr){
			$sel .='<option bab="'.$datapr['bab'].'" judul="'.$datapr['judul'].'"  value="'.$datapr['id'].'">'.$datapr['judul'].' [BAB '.$datapr['bab'].']</option>';
		}
		return $sel;
    }
    function createOptionPrRemidiEditByKelasPelajaranIdPegawai($id_pelajaran,$id_kelas,$id_parent_pr) {
        $CI = & get_instance();
        $CI->load->model('ad_pr');
        $pr=$CI->ad_pr->getPrByKelasPelajaranIdPegawaiNotParent($id_pelajaran,$id_kelas);
		//pr($pr);
		$sel='<option value="">Pilih PR</option>';
		$selected='';
		foreach($pr as $datapr){
			if($datapr['id']==$id_parent_pr){$selected='selected';}else{$selected='';}
			$sel .='<option '.$selected.'  bab="'.$datapr['bab'].'" judul="'.$datapr['judul'].'"  value="'.$datapr['id'].'">'.$datapr['judul'].' [BAB '.$datapr['bab'].']</option>';
		}
		return $sel;
    }
    function createOptionFilePrByIdPr($id_pr) {
        $CI = & get_instance();
        $CI->load->model('ad_pr');
        $file=$CI->ad_pr->getFilePrById_pr($id_pr);
		//pr($file);
		$sel='';
		foreach($file as $datafile){
			$sel .='<li><input onclick="return false;" type="hidden" name="file_name_cek[]" value="'.$datafile['file_name'].'" /> '.$datafile['file_name'].'</li>';
		}
		return $sel;
    }
	function createOptionSiswaRemidiByIdKelas($id_kelas,$id_pr) {
        $CI = & get_instance();
        $CI->load->model('ad_pr');
        $CI->load->model('ad_siswa');
        $siswaremidi=$CI->ad_pr->getsiswaRemidiByIdKelasIdPr($id_kelas,$id_pr);
		$siswa=$CI->ad_siswa->getsiswaByIdKelas($id_kelas);
		foreach($siswaremidi as $datasiswaremidi){
			$siswa3[$datasiswaremidi['id_siswa_det_jenjang']]=$datasiswaremidi;
		}
		//pr($siswa3);
		$sel='<option value="">Pilih Siswa</option>';
		foreach($siswa as $datasiswa){
			if(@$siswa3[$datasiswa['id_siswa_det_jenjang']]['id_siswa_det_jenjang']==$datasiswa['id_siswa_det_jenjang']){$slctd='selected';}else{ $slctd='';}
			$sel .='<option '.$slctd.' value="'.$datasiswa['id_siswa_det_jenjang'].'">('.$datasiswa['nis'].') '.$datasiswa['nama'].'</option>';
		}
		return $sel;
    }
}

