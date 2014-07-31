<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Ak_tugas {

    function createOptiontugasByKelasPelajaranIdPegawai($id_pelajaran,$id_kelas) {
        $CI = & get_instance();
        $CI->load->model('ad_tugas');
        $tugas=$CI->ad_tugas->gettugasByKelasPelajaranIdPegawaiNotParent($id_pelajaran,$id_kelas);
		//tugas($tugas);
		$sel='<option value="">Pilih tugas</option>';
		foreach($tugas as $datatugas){
			$sel .='<option  bab="'.$datatugas['bab'].'" judul="'.$datatugas['judul'].'" value="'.$datatugas['id'].'">'.$datatugas['judul'].' [BAB '.$datatugas['bab'].']</option>';
		}
		return $sel;
    }
    function createOptiontugasRemidiEditByKelasPelajaranIdPegawai($id_pelajaran,$id_kelas,$id_parent_tugas) {
        $CI = & get_instance();
        $CI->load->model('ad_tugas');
        $tugas=$CI->ad_tugas->gettugasByKelasPelajaranIdPegawaiNotParent($id_pelajaran,$id_kelas);
		//tugas($tugas);
		$sel='<option value="">Pilih tugas</option>';
		$selected='';
		foreach($tugas as $datatugas){
			if($datatugas['id']==$id_parent_tugas){$selected='selected';}else{$selected='';}
			$sel .='<option '.$selected.'  bab="'.$dataharian['bab'].'" judul="'.$dataharian['judul'].'"  value="'.$datatugas['id'].'">'.$datatugas['judul'].' [BAB '.$datatugas['bab'].']</option>';
		}
		return $sel;
    }
    function createOptionFiletugasByIdtugas($id_tugas) {
        $CI = & get_instance();
        $CI->load->model('ad_tugas');
        $file=$CI->ad_tugas->getFiletugasById_tugas($id_tugas);
		//tugas($file);
		$sel='';
		foreach($file as $datafile){
			$sel .='<li><input checked onclick="return false;" type="checkbox" name="file_name_cek[]" value="'.$datafile['file_name'].'" /> '.$datafile['file_name'].'</li>';
		}
		return $sel;
    }
	function createOptionSiswaRemidiByIdKelas($id_kelas,$id_tugas) {
        $CI = & get_instance();
        $CI->load->model('ad_tugas');
        $CI->load->model('ad_siswa');
        $siswaremidi=$CI->ad_tugas->getsiswaRemidiByIdKelasIdtugas($id_kelas,$id_tugas);
		$siswa=$CI->ad_siswa->getsiswaByIdKelas($id_kelas);
		foreach($siswaremidi as $datasiswaremidi){
			$siswa3[$datasiswaremidi['id_siswa_det_jenjang']]=$datasiswaremidi;
		}
		//tugas($siswa3);
		$sel='<option value="">Pilih Siswa</option>';
		foreach($siswa as $datasiswa){
			if(@$siswa3[$datasiswa['id_siswa_det_jenjang']]['id_siswa_det_jenjang']==$datasiswa['id_siswa_det_jenjang']){$slctd='selected';}else{ $slctd='';}
			$sel .='<option '.$slctd.' value="'.$datasiswa['id_siswa_det_jenjang'].'">('.$datasiswa['nis'].') '.$datasiswa['nama'].'</option>';
		}
		return $sel;
    }
}

