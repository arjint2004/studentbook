<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Auth {

    function logged_in() {
        $CI = & get_instance();
        $CI->load->library('session');
        if ($CI->session->userdata('user_authentication') || $CI->session->userdata('user')) {
            $session_data = $CI->session->userdata('user_authentication');
        } else {
           echo "<script>window.location = '".base_url()."';</script>";
        }
    }
    
    function get_det_group($id_user=0)
    {
		$CI = & get_instance();
        $CI->load->model('auth_user');		
		return $CI->auth_user->get_det_group($id_user);
	}
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
    function user_logged_in()
    {
        $CI = & get_instance();
        $CI->load->library('session');
		$CI->load->library('ak_facebook');
		$CI->ak_facebook->ceklogin();
		//pr($CI->session->userdata('user'));die();
        if ($CI->session->userdata('user') && $CI->session->userdata('user_authentication')) {
            $session_data = $CI->session->userdata('user');
            $uri = $CI->uri->rsegment(1);
            if($session_data['otoritas']=='guru' AND $uri=='siswa') {
                redirect('sos/pegawai/');
            }elseif($session_data['otoritas']=='siswa' AND $uri=='guru') {
                redirect('sos/pegawai/');
            }
        }else{
            echo "<script>window.location = '".base_url()."';</script>";
        }
    }
    function send_mail_verifikasi($email,$username,$password,$nama_pendaftar)
    {
		//email verifikasi
			// multiple recipients
			$to  = $email. ', '; // note the comma
			//$to .= 'wez@example.com';

			// subject
			$subject = 'Studentbook verifikasi';
			$l['unm']=$username;
			$l['pwd']=$password;
			$link=serialize($l);
			// message
			for($i=0;$i<5;$i++){
				$link= base64_encode($link);
			}
			
			$message = '
			<html>
			<head>
			  <title>Selamat datang '.$nama_pendaftar.' di STUDENTBOOK</title>
			</head>
			<body>
			  <p><b>Selamat Bergabung dalam Komunitas Sekolah Digital Indonesia</b></p>
			  <p>Untuk Mengaktifkan akun STUDENTBOOK anda silahkan klik link dibawah ini</p>
			  <table>
				<tr>
				  <td>
					<a href="'.base_url().'sos/sekolah/verifikasi/'.$link.'" >'.base_url().'sos/sekolah/verifikasi/'.$link.'</a>
				  </td>
				</tr>
				<tr>
				  <td>
					username: '.$email.'<br />
					password: '.$password.'
				  </td>
				</tr>
				<tr>
				  <td>contact: mail@studentbook.co</td>
				</tr>
			  </table>
			</body>
			</html>
			';
			//echo $message;
			// To send HTML mail, the Content-type header must be set
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

			// Additional headers
			$headers .= 'To: '.$nama_pendaftar.' <'.$email_pendaftar.'>' . "\r\n";
			$headers .= 'From: Studentbook <mail@studentbook.co>' . "\r\n";
			//$headers .= 'Cc: birthdayarchive@example.com' . "\r\n";
			//$headers .= 'Bcc: birthdaycheck@example.com' . "\r\n";

			// Mail it
			mail($to, $subject, $message, $headers);
	}
	


function tanggal($tanggalin=null){
		
		
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

