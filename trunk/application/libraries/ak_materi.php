<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Ak_materi {

    
    function createOptionFileMateriByIdMateri($id_materi) {
        $CI = & get_instance();
        $CI->load->model('ad_materi');
        $file=$CI->ad_materi->getFileMateriById_materi($id_materi);
		//pr($file);
		$sel='';
		foreach($file as $datafile){
			$sel .='<li><input checked onclick="return false;" type="checkbox" name="file_name_cek[]" value="'.$datafile['file_name'].'" /> '.$datafile['file_name'].'</li>';
		}
		return $sel;
    }
}

