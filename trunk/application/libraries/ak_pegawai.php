<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Ak_pegawai {

    function createOptionGuruByIdSekolah($id_sekolah) {
        $CI = & get_instance();
        $CI->load->model('pegawaimodel');
        $guru=$CI->pegawaimodel->getGuruByIdKelas($id_sekolah);
		//pr($siswa);
		$sel='<option value="">Pilih Guru</option>';
		foreach($guru as $dataguru){
			$sel .='<option value="'.$dataguru['id'].'">'.$dataguru['nama'].'</option>';
		}
		return $sel;
    }
    function createOptionGuruByIdSekolahHp($id_sekolah) {
        $CI = & get_instance();
        $CI->load->model('pegawaimodel');
        $guru=$CI->pegawaimodel->getGuruByIdKelas($id_sekolah);
		//pr($siswa);
		$sel='<option value="">Pilih Guru</option>';
		foreach($guru as $dataguru){
			$sel .='<option value="'.$dataguru['hp'].'">'.$dataguru['nama'].'</option>';
		}
		return $sel;
    }
	function createOptionGuruByIdSekolahHp2($id_sekolah) {
        $CI = & get_instance();
        $CI->load->model('pegawaimodel');
        $guru=$CI->pegawaimodel->getGuruByIdKelas($id_sekolah);
		//pr($siswa);
		$sel='<option value="">Pilih Guru</option>';
		foreach($guru as $dataguru){
			$val=json_encode(array('nama'=>$dataguru['nama'],'hp'=>$dataguru['hp']));
			$sel .="<option id_ortu='".$dataguru['id_ortu']."' value='".base64_encode($val)."'>".$dataguru['nama']."</option>";
		}
		return $sel;
    }
}