<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Ak_siswa {

    function createOptionSiswaByIdKelas($id_kelas) {
        $CI = & get_instance();
        $CI->load->model('ad_siswa');
        $siswa=$CI->ad_siswa->getsiswaByIdKelas($id_kelas);
		//pr($siswa);
		$sel='<option value="">Pilih Siswa</option>';
		foreach($siswa as $datasiswa){
			$sel .='<option value="'.$datasiswa['id_siswa_det_jenjang'].'">('.$datasiswa['nis'].') '.$datasiswa['nama'].'</option>';
		}
		return $sel;
    }
    function createOptionSiswaByIdKelasId_sis($id_kelas) {
        $CI = & get_instance();
        $CI->load->model('ad_siswa');
        $siswa=$CI->ad_siswa->getsiswaByIdKelas($id_kelas);
		//pr($siswa);
		$sel='<option value="">Pilih Siswa</option>';
		foreach($siswa as $datasiswa){
			$val=json_encode(array('nama'=>$datasiswa['nama'],'id_siswa_det_jenjang'=>$datasiswa['id_siswa_det_jenjang'],'id'=>$datasiswa['id'],'id_ortu'=>$datasiswa['id_ortu'],'hp'=>$datasiswa['hp']));
			$sel .="<option id_ortu='".$datasiswa['id_ortu']."' value='".base64_encode($val)."'>(".$datasiswa['nis'].") ".$datasiswa['nama']."</option>";
		}
		return $sel;
    }
}