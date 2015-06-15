<?php 

/**
 * Global Helper Create By jefrisugiarto@yahoo.com
 * programer PHP, codeigniter, HTML, javascript,css 
 * @param array 
 * @return string
 */


if (!function_exists('romanic_number')) {
	function romanic_number($integer, $upcase = true) 
	{ 
		$table = array('M'=>1000, 'CM'=>900, 'D'=>500, 'CD'=>400, 'C'=>100, 'XC'=>90, 'L'=>50, 'XL'=>40, 'X'=>10, 'IX'=>9, 'V'=>5, 'IV'=>4, 'I'=>1); 
		$return = ''; 
		while($integer > 0) 
		{ 
			foreach($table as $rom=>$arb) 
			{ 
				if($integer >= $arb) 
				{ 
					$integer -= $arb; 
					$return .= $rom; 
					break; 
				} 
			} 
		} 

		return $return; 
	} 
}
if (!function_exists('Terbilang')) {

	function Terbilang($x) {
		$exp=explode(".",$x);
		//echo kekata($exp[0]);
		if (count($exp)==1){return kekata($exp[0]);}elseif(count($exp)==2){return kekata($exp[0]).' Koma '.kekata($exp[1]);}
		
	}
	function kekata($x) {
			$abil = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
			if ($x < 12)
				$rx= " ".$abil[$x];
			elseif ($x < 20)
				$rx =  kekata($x - 10) . "Belas";
			elseif ($x < 100)
				$rx =  kekata($x / 10) . " Puluh" . kekata($x % 10);
			elseif ($x < 200)
				$rx =  " seratus" . kekata($x - 100);
			elseif ($x < 1000)
				$rx =  kekata($x / 100) . " Ratus" . kekata($x % 100);
			elseif ($x < 2000)
				$rx =  " seribu" . kekata($x - 1000);
			elseif ($x < 1000000)
				$rx =  kekata($x / 1000) . " Ribu" . kekata($x % 1000);
			elseif ($x < 1000000000)
				$rx =  kekata($x / 1000000) . " Juta" . kekata($x % 1000000);
		return $rx;
	}
}
 //cek login fb
if (!function_exists('cekloginfb')) {
    function cekloginfb() {
		$CI = get_instance();
		//pr($CI->session->userdata['user_authentication']);
        //$CI->load->library('ak_facebook');
		if($CI->session->userdata['user_authentication']['fb_id']!=''){
			return true;
		}else{
			return false;
		}
		
    }
}

 //print iklan
if (!function_exists('print_iklan')) {
    function print_iklan() {
        $iklan = '<div class="hr" style="margin-top: 10px;"></div>
                <div class="content content-full-width" style="color: white;background: #CDCDCD;padding-top:10px;padding-bottom: 10px;">
                    <div class="text_iklan">SPACE IKLAN</div>
                    <p>Mengenang Iklan Sepanjang Masa</p>
                </div>
                <div class="hr"></div>';
	return $iklan;
    }
}

if (!function_exists('fitur_sekolah')) {
    function fitur_sekolah()
	{
		$CI = get_instance();
		// You may need to load the model if it hasn't been pre-loaded
		$CI->load->model('ad_sekolah');
		$fitur=$CI->ad_sekolah->getFitur($CI->session->userdata['user_authentication']['id_sekolah']);
		return $fitur;
	}
}
if (!function_exists('month')) {
    function month($name="month", $selected=null,$ttr="")
{
        $dd = '<select name="'.$name.'" '.$ttr.'>';

        /*** the current month ***/
        $selected = is_null($selected) ? date('n', time()) : $selected;

        for ($i = 1; $i <= 12; $i++)
        {
                $dd .= '<option value="'.$i.'"';
                if ($i == $selected)
                {
                        $dd .= ' selected';
                }
                /*** get the month ***/
                $mon = @date("F", mktime(0, 0, 0, $i+1, 0, 0, 0));
                $dd .= '>'.$mon.'</option>';
        }
        $dd .= '</select>';
        return $dd;
}
}

if (!function_exists('array_searchRecursive')) {
    function array_searchRecursive( $needle, $haystack, $strict=false, $path=array() )
	{
		if( !is_array($haystack) ) {
			return false;
		}
	 
		foreach( $haystack as $key => $val ) {
			if( is_array($val) && $subPath = $this->array_searchRecursive($needle, $val, $strict, $path) ) {
				$path = array_merge($path, array($key), $subPath);
				return $path;
			} elseif( (!$strict && $val == $needle) || ($strict && $val === $needle) ) {
				$path[] = $key;
				return $path;
			}
		}
		return false;
	}
}

if (!function_exists('ikut_remidi')) {
    function ikut_remidi($id_kelas=0,$id=0,$jenis='') {
		// Get a reference to the controller object
		$CI = get_instance();

		// You may need to load the model if it hasn't been pre-loaded
		$CI->load->model('ad_pengumpulan');
		$data=$CI->ad_pengumpulan->getsiswaRemidi($id_kelas,$id,$jenis);
		// Call a function of the model
		
		//hari ini
		//pr($data);
		echo '
			<div class="full file">
				<h3 >Data Siswa Ikut Remidi '.strtoupper($jenis).'</h3>
				<div class="hr"></div>
				
				<div class="full file" style="margin:0;height:200px;overflow:auto;border:none;">
				<table class="noborder">
				<thead>
					<tr>
						<th>No</th>
						<th>Nama</th>
						<th>NIS</th>
					</tr>
				</thead>
				<tbody>
			';
			$i=1;
			foreach($data as $datax){
			echo '
					<tr>
						<td >'.$i++.'</td>
						<td class="title">'.$datax['nama'].'</td>
						<td class="title">'.$datax['nis'].'</td>
					</tr>
			';
			}
		echo '
				</tbody>
				</table>
			</div>
			</div>
		';
    }
}
if (!function_exists('pengumpulan_akademik')) {
    function pengumpulan_akademik($id_kelas=0,$id_sekolah,$jenis='',$id,$id_pelajaran=null,$nama_kelas='') {
		// Get a reference to the controller object
		$CI = get_instance();

		// You may need to load the model if it hasn't been pre-loaded
		$CI->load->model('ad_pengumpulan');
		$data=$CI->ad_pengumpulan->getdataByIdkelas($id_kelas,$id_sekolah,$jenis,$id,$id_pelajaran);
		// Call a function of the model
		
		//hari ini
		//pr($data);
		echo '
			<div class="full file">
				<h3 >Pengumpulan '.strtoupper($jenis).' "KELAS '.$nama_kelas.'"</h3>
				<div class="hr"></div>
				
				<div class="full file" style="margin:0;min-height:50px;max-height:200px;overflow:auto;border:none;">
				<table class="noborder">
				<thead>
					<tr>
						<th>No</th>
						<th>Nama</th>
						<th>Waktu</th>
						<th>File</th>
					</tr>
				</thead>
				<tbody>
			';
			$i=1;
			foreach($data as $datax){
			echo '
					<tr>
						<td >'.$i++.'</td>
						<td class="title">'.$datax['nama'].'</td>
						<td class="title">'.$datax['waktu'].'</td>
						<td class="title"><a href="'.base_url('homepage/send_download/'.base64_encode("upload/akademik/kumpul/".$CI->session->userdata['user_authentication']['id_sekolah']."/".$jenis."/").'/'.base64_encode(str_replace("upload/akademik/kumpul/".$CI->session->userdata['user_authentication']['id_sekolah']."/".$jenis."/","",$datax['file'])).'').'" >Download</a>
						| <a target="file" href="'.base_url().'akademik/nilai/view_document/'.$datax['id'].'/'.$datax['id_siswa_det_jenjang'].'/'.$id_kelas.'/'.$id_sekolah.'/'.$jenis.'/'.$id.'/'.$id_pelajaran.'/'.base64_encode(base_url(''.$datax['file'].'')).'">Lihat</a>
						</td>
					</tr>
			';
			}
		echo '
				</tbody>
				</table>
			</div>
			</div>
		';
    }
}
if (!function_exists('pengumpulan_akademik_siswa')) {
    function pengumpulan_akademik_siswa($id=0,$jenis='',$id_kelas=0) {
		$CI = get_instance();
		$CI->load->model('ad_pengumpulan');
		$datadikumpul=$CI->ad_pengumpulan->getdataByIdJenis($id,$CI->session->userdata['user_authentication']['id_sekolah'],$jenis);
		//pr($datadikumpul);
		$CI->xx=$CI->xx+1;
		if($CI->xx==1){
		echo '
		<script>
			$(document).ready(function(){
				$(\'input.kumpulpr\').change(function(){
					if(confirm(\'Kamu yakin file sudah benar..?\')){
						ajaxupload("'.base_url().'siswa/pengumpulan/kumpulkanfile/"+$(this).attr(\'idnya\')+"/"+$(this).attr(\'jenis\')+"/"+$(this).attr(\'id_kelas\'),"response"+$(this).attr(\'id\'),"image-list",$(this).attr(\'id\'));
						alert(\'PR Kamu telah dikumpulkan\');
						$("table#tableid"+$(this).attr(\'idnya\')).load("'.base_url().'siswa/pengumpulan/getDataDikumpul/"+$(this).attr(\'idnya\')+"/"+$(this).attr(\'jenis\'));
					}
				});
			});
		</script>
		<script type="text/javascript" src="'.$CI->config->item('js').'upload.js"></script>
		';
		}
		echo'		
		<div class="file">
			<h3>Kumpulkan '.strtoupper($jenis).'</h3>
			<input type="file" name="file" size="29" id="idfile'.$id.'" class="kumpulpr" multiple idnya="'.$id.'" jenis="'.$jenis.'" id_kelas="'.$id_kelas.'"/>
			<span id="responseidfile'.$id.'">*) Klik Browse. Jika file lebih dari satu, pencet ctrl+klik untuk memilih banyak file</span>
													
			<div class="hr"></div>
			<table class="noborder"  id="tableid'.$id.'">
			';
			foreach($datadikumpul as $datadikumpulkan){
			echo'
				<tr>
					<td class="title"><a>'.str_replace("upload/akademik/kumpul/".$CI->session->userdata['user_authentication']['id_sekolah']."/".$jenis."/","",$datadikumpulkan['file']).'</a></td>
				</tr>
			';
			}
			echo'
			</table>
		</div>';
		
    }
}
if(!function_exists('session_data')) {
	function session_data() {
		$CI = & get_instance();
		$CI->load->library('session');
		$data = $CI->session->userdata('user');
		return $data;
	}
}

if(!function_exists('messageCheck')) {
	function MessageCheck($message) {
            $message=htmlspecialchars(stripslashes($message));
            $message=preg_replace('/((?:http|https|ftp):\/\/(?:[A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?[^\s\"\']+)/i','<a href="$1" rel="nofollow" target="blank">$1</a>',$message);
	    return $message;
	}
}


if(!function_exists('side_bar')) {
	function side_bar($title,$file) {
		$side = '<div class="widget widget_recent_entries">
                	<h2 class="widgettitle">'.$title.'</h2><ul>';
		foreach($file as $fl) {
                    $side .= '<li>
                        <a href="#" title="" class="thumb">
                            <img src="'.$this->config->item('images').'post-images/recent-post1.jpg" alt="" title="" />
                        </a>
			<h6> <a href="blog-single.html" title="">'.$fl->title.'</a> </h6>
			<p>'.$fl->keterangan.'</p>
                    </li>';
		}
		$side .= '</ul></div>';
	}
}

if(!function_exists('DataUser')) {
	function DataUser() {
		$CI = & get_instance();
		$CI->load->library('session');
		$data = session_data();
		if(!empty($data)) {
			if($data['otoritas']=='siswa') {
				$CI->load->model('siswamodel');
				$result = $CI->siswamodel->get_siswa($data['id']);
				return $result;
			}else{
				$CI->load->model('pegawaimodel');
				$result = $CI->pegawaimodel->get_pegawai($data['id']);
				return $result;
			}
		}
	}
}

if(!function_exists('status_akhir_user')) {
    function status_akhir_user() {
	$CI = & get_instance();
	$CI->load->library('session');
	$CI->load->database();
	$data = session_data();
	$CI->db->from('sc_status');
	$CI->db->where('id_untuk','0');
	$CI->db->where('id_user',$data['id']);
	$CI->db->order_by('id_status','desc');
	$sql = $CI->db->get();
	if($sql->num_rows()>0) {
	    return $sql->row()->pesan;
	}else{
	    
	}
    
    }
}

if(!function_exists('session_jurnalis')) {
	function session_jurnalis() {
		$CI = & get_instance();
		$CI->load->library('session');
		$CI->load->database();
		$data = session_data();
		if(!empty($data)){
		    $CI->db->from('det_group a');
		    $CI->db->where('a.id_user',$data['id']);
		    $CI->db->where('a.id_group','22');
		    $CI->db->or_where('a.id_group','28');
		    $sql = $CI->db->get();
		    if($sql->num_rows()>0){
			return $sql->row();
		    }
		    else{
			return '';
		    }
		}else{
		    return '';
		}
	}
}

if(!function_exists('CheckTime')) {
	function CheckTime($dt,$precision=2)
	{
        if(is_string($dt)) $dt=strtotime($dt);
	$times=array(	365*24*60*60	=> "year",
					30*24*60*60	=> "month",
					7*24*60*60	=> "week",
					24*60*60	=> "day",
					60*60		=> "hour",
					60		=> "minute",
					1		=> "second");
	
	$passed=time()-$dt;	
	if($passed<5)
	{
            $output='less than 5 seconds ago';
	}
	else
	{
            $output=array();
            $exit=0;
            foreach($times as $period=>$name)
            {
                    if($exit>=$precision || ($exit>0 && $period<60)) break;	
                    $result = floor($passed/$period);
                    if($result>0)
                    {
                            $output[]=$result.' '.$name.($result==1?'':'s');
                            $passed-=$result*$period;
                            $exit++;
                    }
                    else if($exit>0) $exit++;
            }			
            $output=implode(' and ',$output).' ago';
	}
	return $output;
    }
}


if (!function_exists('set_red_notification')) {
    function set_red_notification($message="") {
        $CI = & get_instance();
        $CI->session->set_flashdata('notification', true);
        $CI->session->set_flashdata('red-notification', $message);
    }

}

if (!function_exists('set_blue_notification')) {

    function set_blue_notification($message="") {
        $CI = & get_instance();
        $CI->session->set_flashdata('notification', true);
        $CI->session->set_flashdata('blue-notification', $message);
    }

}

if (!function_exists('monthoption')) {

    function monthoption($curr_month=null) {
        if($curr_month==null){
			$curr_month = date("m");
		}
		
		$month = array (1=>"Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Augustus", "September", "Oktober", "November", "Desember");
		
		foreach ($month as $key => $val) {
			$select .= "\t<option value=\"".$key."\"";
			if ($key == $curr_month) {
				$select .= " selected=\"selected\">".$val."</option>\n";
			} else {
				$select .= ">".$val."</option>\n";
			}
		}
		return $select;
    }

}
if (!function_exists('set_green_notification')) {

    function set_green_notification($message="") {
        $CI = & get_instance();
        $CI->session->set_flashdata('notification', true);
        $CI->session->set_flashdata('green-notification', $message);
    }

}

/*if (!function_exists('userphoto')) {

    function userphoto($id_user=null) {
		$CI = & get_instance();
		$CI->load->model('user');
		$userdata=$CI->user->getuserByIdUser($id_user);
		//pr();
	}
}*/
if (!function_exists('print_notification')) {

    function print_notification() {
        $CI = & get_instance();
        $hasil = '';
        if ($CI->session->flashdata('notification')) {
            if ($CI->session->flashdata('red-notification')) {
                $hasil = '<div class="errorlogin message" id="notification">
			    <p>' . $CI->session->flashdata('red-notification') . '</p></div>';
            };
            if ($CI->session->flashdata('blue-notification')) {
		$hasil = '<div class="success message" id="notification">
				<p>' . $CI->session->flashdata('blue-notification') . '</p>
			   </div>';
            };
            if ($CI->session->flashdata('green-notification')) {
                $hasil = '<div class="info_noty message" id="notification">
			    <p>' . $CI->session->flashdata('green-notification') . '</p>
		       </div>';
            };
        }
        return $hasil;
    }
}
if (!function_exists('countcommentberita')) {

    function countcommentberita($id=0) {
        $CI = & get_instance();
        $CI->load->model('ad_berita');
		$hasil=$CI->ad_berita->countcomment($id);
        return $hasil[0]['cnt'];
    }
}
if (!function_exists('berita')) {

    function berita($limit=4) {
        $CI = & get_instance();
        $CI->load->model('ad_berita');
		$hasil=$CI->ad_berita->get_berita_sc_terkini($limit);
        return $hasil;
    }
}
if (!function_exists('artikel_sponsor')) {

    function artikel_sponsor($limit=4) {
        $CI = & get_instance();
        $CI->load->model('ad_artikel');
		$hasil=$CI->ad_artikel->getdataSponsor($limit);
        return $hasil;
    }
}
if (!function_exists('artikel_populer')) {

    function artikel_populer($limit=4) {
        $CI = & get_instance();
        $CI->load->model('ad_artikel');
		$hasil=$CI->ad_artikel->getdataPopuler($limit);
        return $hasil;
    }
}
if (!function_exists('tanggal')) {

function tanggal($tanggalin=null){
		//pr($tanggalin);
		if($tanggalin=="0000-00-00 00:00:00" || $tanggalin=="0000-00-00 00:00:00 00:00:00" || $tanggalin=="0000-00-00"){
			return array('Tanggal Tidak tersedia','Tanggal Tidak tersedia','Tanggal Tidak tersedia');
		} 
		$tglin=explode(' ',$tanggalin);
		$tglin1=explode('-',$tglin[0]);
		$waktuin1=explode(':',$tglin[1]);
		$tanggal=@date("D-d-m-Y-H:i:s", mktime($waktuin1[0], $waktuin1[1], $waktuin1[2], $tglin1[1], $tglin1[2], $tglin1[0]));
		//$tanggal=date("D-d-m-Y-H:i:s");
		//echo $tanggal;
		$arrtanggal=explode("-",$tanggal);
		//print_r($arrtanggal);
		switch($arrtanggal[0]){
			case"Sun":
				$hari="Minggu";
			break;
			case"Mon":
				$hari="Senin";
			break;
			case"Tue":
				$hari="Selasa";
			break;
			case"Wed":
				$hari="Rabu";
			break;
			case"Thu":
				$hari="Kamis";
			break;
			case"Fri":
				$hari="Jum'at";
			break;
			case"Sat":
				$hari="Sabtu";
			break;	
		}
		switch($arrtanggal[2]){
			case"01":
				$bulan="Januari";
			break;
			case"02":
				$bulan="Februari";
			break;
			case"03":
				$bulan="Maret";
			break;
			case"04":
				$bulan="April";
			break;
			case"05":
				$bulan="Mei";
			break;
			case"06":
				$bulan="Juni";
			break;
			case"07":
				$bulan="Juli";
			break;
			case"08":
				$bulan="Agustus";
			break;
			case"09":
				$bulan="September";
			break;
			case"10":
				$bulan="Oktober";
			break;
			case"11":
				$bulan="November";
			break;
			case"12":
				$bulan="Desember";
			break;
			
		}
		
		$tanggalind="".$hari.", ".$arrtanggal[1]." ".$bulan." ".$arrtanggal[3]."";
		$tanggalindnjam="".$hari.", ".$arrtanggal[1]." ".$bulan." ".$arrtanggal[3]." ".$arrtanggal[4]."";
		$tanggal="".$arrtanggal[1]." ".$bulan." ".$arrtanggal[3]." ";
		if($tanggalin=='00:00:00'){
			$arrtanggalind=array('','','');
		}else{
			$arrtanggalind=array($tanggalind,$tanggalindnjam,$tanggal);
		}
		return $arrtanggalind;
	}
}
if (!function_exists('akademiknotif')) {
    function akademiknotif($menuak=1) {
		// Get a reference to the controller object
		$CI = get_instance();
		$CI->load->model('ad_notifikasi');
		$CI->load->library('auth');
		$notif=$CI->ad_notifikasi->get_notifByIdPengguna($CI->session->userdata['user_authentication']['id_pengguna']);
		//$notifp=$CI->ad_notifikasi->get_notifByIdPengirim($CI->session->userdata['user_authentication']['id_pengguna']);
		if($menuak==1){
		$group=$CI->auth->get_det_group($CI->session->userdata['user_authentication']['id']);
		}
		//pr($notifp);
		include('application/views/akademik/notifikasi/notif.php');
    }
}
if (!function_exists('aktifitasakademik')) {
    function aktifitasakademik($id_user=0,$guruorsiswa='',$limit=0) {
		// Get a reference to the controller object
		$CI = get_instance();
		$CI->load->model('ad_pr');
		$CI->load->model('ad_materi');
		$CI->load->model('ad_tugas');
		$pr=$CI->ad_pr->getDataByIdPegawaiGuru($limit,$id_user,$guruorsiswa);
		$tugas=$CI->ad_tugas->getDataByIdPegawaiGuru($limit,$id_user,$guruorsiswa);
		$materi=$CI->ad_materi->getDataByIdPegawaiGuru($limit,$id_user,$guruorsiswa);
		
		//$materi=
		//$tugas=
		include('application/views/akademik/aktifitasakademik.php');
    }
}
if (!function_exists('timelineakademik')) {
    function timelineakademik() {
		$CI = get_instance();
			if($CI->session->userdata['user_authentication']['otoritas']=='siswa'){
				$id_pengguna=$CI->session->userdata['user_authentication']['id_siswa'];
			}else{
				$id_pengguna=$CI->session->userdata['user_authentication']['id_pengguna'];
			}
			$data['notif']=$CI->ad_notifikasi->get_notifByIdPengguna($id_pengguna);
			$CI->ad_notifikasi->setnotifreaded($CI->session->userdata['user_authentication']['id_pengguna']);
			//$data['notifp']=$CI->ad_notifikasi->get_notifByIdPengirim($CI->session->userdata['user_authentication']['id_pengguna']);
			
			if ($CI->input->post('ajax')) {
			   $data['main'] 	= 'akademik/notifikasi/notiflist'; // memilih view
			   $CI->load->view('layout/ad_blank',$data); // memilih layout
			} else {
			   $data['main'] 	= 'akademik/notifikasi/notiflist';// memilih view
			   $CI->load->view('layout/ad_blank',$data);
		} 
		//include('application/views/akademik/timelineakademik.php');
    }
}
if (!function_exists('laporanakademik')) {
    function laporanakademik($id_user=0) {
		// Get a reference to the controller object
		$CI = get_instance();
		$CI->load->model('ad_kelas');
		$kelaslaporan=$CI->ad_kelas->getKelasByWali($CI->session->userdata['user_authentication']['id_sekolah'],$CI->session->userdata['user_authentication']['id_pengguna']);
		
		//$materi=
		//$tugas=
		include('application/views/akademik/laporanakademik.php');
    }
}
if (!function_exists('is_image')) {
    function is_image($path)
	{
		$a = getimagesize($path);
		$image_type = $a[2];
		 
		if(in_array($image_type , array(IMAGETYPE_GIF , IMAGETYPE_JPEG ,IMAGETYPE_PNG , IMAGETYPE_BMP)))
		{
			return true;
		}
		return false;
	}
}
if (!function_exists('coverttoabjad')) {
    function coverttoabjad($nilai=0)
	{
		if($nilai>=0 && $nilai<=1){
			$nilainya='D';
		}elseif($nilai>1 && $nilai<=1.33){
			$nilainya='D+';
		}elseif($nilai>1.33 && $nilai<=1.66){
			$nilainya='C-';
		}elseif($nilai>1.66 && $nilai<=2){
			$nilainya='C';
		}elseif($nilai>2 && $nilai<=2.33){
			$nilainya='C+';
		}elseif($nilai>2.33 && $nilai<=2.66){
			$nilainya='B-';
		}elseif($nilai>2.66 && $nilai<=3){
			$nilainya='B';
		}elseif($nilai>3 && $nilai<=3.33){
			$nilainya='B+';
		}elseif($nilai>3.33 && $nilai<=3.66){
			$nilainya='A';
		}elseif($nilai>3.66 && $nilai<=4){
			$nilainya='A';
		}
		
		return $nilainya;
	}
}
if (!function_exists('download_panduan')) {

     function download_panduan($filename='')
	{  	 
		 $CI = get_instance();
		 if($CI->session->userdata['user_authentication']['otoritas']=='guru'){
			$file='PanduanStudentbookUntukGuru.ppsx';
		 }elseif($CI->session->userdata['user_authentication']['otoritas']=='siswa'){
			$file='PanduanStudentbookUntukSiswa.ppsx';
		 }elseif($CI->session->userdata['user_authentication']['otoritas']=='ortu'){
			$file='PanduanStudentbookUntukOrangtua.ppsx';
		 }
		 echo '| <a title="" href="'.base_url("homepage/send_download/".base64_encode("upload/akademik/template/")."/".base64_encode($file)."").'">DOWNLOAD PANDUAN</a> |';
	}
	if (!function_exists('gawehuruf')) {
		function gawehuruf($angka){
			switch($angka){
				case"1":
					return "E" ;				
				break;
				case"2":
					return "D" ;				
				break;
				case"3":
					return "C" ;				
				break;
				case"4":
					return "B" ;				
				break;
				case"5":
					return "A" ;
				break;
			}
		}
	}
	if (!function_exists('graph')) {
		function graph($value=0,$total=0){
			$width=0;
			if($total>0){
				//$persen=($value/$total) * 100 ;
				$persen=$value ;
				$width=$persen*5;
			}else{
				$persen=0;
			}
			echo '
				<div class="meter animate">
					<span style="width: '.$width.'px">'.$persen.' POST</span>
				</div>
			';
		}
	}
}