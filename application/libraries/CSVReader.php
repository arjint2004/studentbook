<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class csvreader {

    var $separator = ',';

    var $max_row_size = 4096;    /** maximum row size to be used for decoding */

    function parse_file($csv_dir) {
		$row = 0;
		if (($handle = fopen($csv_dir, "r")) !== FALSE) {
			while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
				$num = count($data);
				$row++;
				for ($c=0; $c < $num; $c++) {
					$result[$row][]= $data[$c];
				}
			}
			fclose($handle);
		}
		return $result;
    }
	function saveindikator($csv_dir){
		$CI = & get_instance();
		$CI->load->model('ad_pengajaran');
		
		$pengajaran=$CI->ad_pengajaran->getdata(array());
		$result=$this->parse_file($csv_dir);
		foreach($result as $datapenilaian){
			foreach($pengajaran as $datapengajaran){
				$q=$CI->db->query('SELECT COUNT(*) as jml FROM ak_rencana_indikator WHERE id_pelajaran=? AND id_mengajar=? AND id_sekolah=? AND penilaian=? AND indikator=?',array($datapengajaran['id_pelajaran'],$datapengajaran['id_mengajar'],$CI->session->userdata['user_authentication']['id_sekolah'],$datapenilaian[0],$datapenilaian[1]));
				$cek=$q->result_array();
				
				if($cek[0]['jml']==0){
					$insert_indikator=array(
										'id_sekolah'=>$CI->session->userdata['user_authentication']['id_sekolah'],
										'id_pelajaran'=>$datapengajaran['id_pelajaran'],
										'id_mengajar'=>$datapengajaran['id_mengajar'],
										'id_pegawai'=>$datapengajaran['id_pegawai'],
										'semester'=>$datapengajaran['id_semester'],
										'ta'=>0,
										'penilaian'=>$datapenilaian[0],
										'indikator'=>$datapenilaian[1]
					);
					//pr($insert_indikator);
					$CI->db->insert('ak_rencana_indikator',$insert_indikator);
					//pr($CI->db->last_query());
				}
			}
		}

	}
  
}

?>