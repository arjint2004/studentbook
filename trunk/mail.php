#!/usr/bin/php
<?/*
$system_path = 'system';
define('BASEPATH', str_replace("\\", "/", $system_path));
include('application/config/database.php');	

		mysql_connect($db['default']['hostname'],$db['default']['username'],$db['default']['password']) or
         die("Could not connect: " . mysql_error());
    //change to your database name
		mysql_select_db($db['default']['database']) or 
		     die("Could not select database: " . mysql_error());
			 
	$q=mysql_query('SELECT *
	FROM `ak_sms_report`
	WHERE status="" AND id>1831');
	
	while($hsl=mysql_fetch_assoc($q)){
		
		$rep=unserialize($hsl['id_notif_sms']);
		//echo "<pre>";
		//print_r($rep);
		$imp=implode(",",$rep);
		$ssql= 'update ak_notifikasi_sms SET status=0 WHERE id IN('.$imp.')';
		mysql_query($ssql);
		//echo "<pre>";
		//mysql_query('update ak_notifikasi_sms SET status=0 WHERE id IN('.implode(",",unserialize($hsl['id_notif_sms'])).'');
		//$vv++;
	}
	//echo $vv;
	//echo "<pre>";
	//print_r(unserialize('a:2:{s:8:"response";O:8:"stdClass":2:{s:13:"message-count";s:1:"1";s:8:"messages";a:1:{i:0;O:8:"stdClass":6:{s:2:"to";s:13:"6283867139945";s:10:"error-text";s:25:"Quota Exceeded - rejected";s:13:"message-price";s:10:"0.00700000";s:6:"status";s:1:"9";s:17:"remaining-balance";s:10:"0.00100000";s:7:"network";s:5:"51008";}}}s:13:"response_code";i:200;}'));
*/
?>

#!/usr/bin/php
<?php
$system_path = 'system';
define('BASEPATH', str_replace("\\", "/", $system_path));
class sms{

	function __construct(){
		
		error_reporting(E_ALL);
		$this->getConnection();
		
            include('nexmo.php');
			$this->nexmo=new nexmo();
			
			require_once('rajasmsreguler.php'); // panggil class rajasmsreuler
			$this->sms = new smsreguler();
	}
	function getConnection(){
	  //change to your database server/user name/password
		//define('BASEPATH', '');
		include('application/config/database.php');	

		mysql_connect($db['default']['hostname'],$db['default']['username'],$db['default']['password']) or
         die("Could not connect: " . mysql_error());
    //change to your database name
		mysql_select_db($db['default']['database']) or 
		     die("Could not select database: " . mysql_error());
	}
	
	function execute_sms(){
		$data=$this->get_notif();
		$groups=array();
		foreach($data as $datasms){
			if($datasms['aktifasisendername']==0 || $datasms['sendername']==''){
					$sendername='STUDENTBOOK';
				}else{
					$sendername=$datasms['sendername'];
			}
			$groups[$datasms['id_siswa']]['nama_kelas'] = $datasms['nama_kelas'];
			$groups[$datasms['id_siswa']]['kelas'] = $datasms['kelas'];
			$groups[$datasms['id_siswa']]['id_siswa'] = $datasms['id_siswa'];
			$groups[$datasms['id_siswa']]['id_det_jenjang'] = $datasms['id_det_jenjang'];
			$groups[$datasms['id_siswa']]['nama_siswa'] = $datasms['nama_siswa'];
			$groups[$datasms['id_siswa']]['no_hp'] = $datasms['no_hp'];
			$groups[$datasms['id_siswa']]['sendername'] = $sendername;
			$groups[$datasms['id_siswa']]['nama_sekolah'] = $datasms['nama_sekolah'];
			$groups[$datasms['id_siswa']][$datasms['group']][] = $datasms;
		}	
		$this->make_pesan($groups);
		//echo "<pre>";
		//print_r($groups);
		//echo "</pre>"; 

	}
	function make_pesan($groups=array()){
	// Ananda NAWAL [hanya nama depan saja] (17-5-12): hadir; PR: BIN,MTK,PKN; Materi: BIG,KES,IPA; Nilai: BIN(9),BIG(9),IPS(9). Mhn dicek di studentbook.co
		//get notif
		//$notalloeedno=array('+62811','+62812','+62813','+62828','+62831','+62852','+62853','+62881','+62882','+62883','+62884','+62885','+62886','+62887','+62888','+62889','+62274','+62821');
		//$notalloeedno=array(1,2,3); 
		foreach($groups as $id_siswa=>$datasms){
			$explnama=explode(" ",$datasms['nama_siswa']);
			$tmp=''.$datasms['nama_siswa'].' ';
			$no_hp=$datasms['no_hp'];
			$sendername=$datasms['sendername'];
			$id_siswa=$datasms['id_siswa'];
			$id_det_jenjang=$datasms['id_det_jenjang'];
			$nama_kelas=$datasms['nama_kelas'];
			$kelas=$datasms['kelas'];
			$sekolah=$datasms['nama_sekolah'];

			unset($datasms['nama_siswa']);
			unset($datasms['no_hp']);
			unset($datasms['sendername']);
			unset($datasms['id_siswa']);
			unset($datasms['id_det_jenjang']);
			unset($datasms['nama_sekolah']);
			unset($datasms['nama_kelas']);
			unset($datasms['kelas']);
			$id_notif=array();
			foreach($datasms as $group=>$dataNotif){
				$tmp .=' '.$group.': ';
				
				foreach($dataNotif as $dataNotif2){
					if($dataNotif2['notifikasi']!=''){
					$tmp2 .=''.$dataNotif2['notifikasi'].',';
					}else{
						$tmp=str_replace(''.$group.': ','',$tmp);
					}
					$id_notif[]=$dataNotif2['id'];
				}
				
				$tmp .=$tmp2;
				$tmp2='';
			}
			//echo $no_hp."=>".$tmp."<br />";
			
			if($no_hp!='' && strlen($no_hp)>=10){
				//if(substr($no_hp,0,4)=='+628' || substr($no_hp,0,4)=='+622'){
					if(in_array(substr($no_hp,0,6), $notalloeedno)){
						echo $sekolah." | ".$kelas." | ".$nama_kelas." ".$no_hp." For Nexmo ".$sendername." ".$tmp."<br>";
						//$response=$this->send_sms($no_hp,$sendername,$tmp);
						$nexmo++;
						$error_report=array(
												0=>'Delivered',
												1=>'Unknown',
												2=>'Absent Subscriber - Temporary',
												3=>'Absent Subscriber - Permanent',
												4=>'Call barred by user',
												5=>'Portability Error',
												6=>'Anti-Spam Rejection',
												7=>'Handset Busy',
												8=>'Network Error',
												9=>'Illegal Number',
												10=>'Invalid Message',
												11=>'Unroutable',
												99=>'General Error'
						);
						//echo "<pre>";
						//print_r($id_notif);
						$sql="INSERT INTO  ak_sms_report SET 
										`id_siswa`=$id_siswa,
										`id_det_jenjang`=$id_det_jenjang,
										`id_notif_sms`='".serialize($id_notif)."',
										`no_hp`='".$no_hp."',
										`status`='".$error_report[$response['response']->messages[0]->status]."',
										`error-report`='".serialize($response)."',
										`sms`='$tmp'
							";
						//echo $sql.'<br />';
						//mysql_query($sql);
						if($error_report[$response['response']->messages[0]->status]=='Delivered'){
							$sql2='UPDATE ak_notifikasi_sms SET status=1 WHERE id IN ('.implode(",",$id_notif).')';
							//echo $sql2.'<br>';
							//mysql_query($sql2);
						}//$jmll++;
					}else{
						echo $sekolah." | ".$kelas."".$nama_kelas." ".$no_hp." For Raja ".$sendername." ".$tmp."<br>";
						$raja++;
						//ob_start();
						// api key , ambil di raja-sms.com 
								$apikey='81f6cf2706d2302a33782a6126b16469';
								$nohp  = '+6283867139945';
								$pesan = 'cek api';
								
								$this->sms->key = $apikey;
								$this->sms->setTo($no_hp);
								$this->sms->setText($tmp);
								//$sts=$this->sms->send(); 
									//echo "<pre>";
									//print_r($sts);
									//echo "</pre>";
									//echo "<pre>";
									
						//print_r($id_notif);
						$sql3="INSERT INTO  ak_sms_report SET 
										`id_siswa`=$id_siswa,
										`id_det_jenjang`=$id_det_jenjang,
										`id_notif_sms`='".serialize($id_notif)."',
										`no_hp`='".$no_hp."',
										`status`='".$sts."',
										`error-report`='".$sts."',
										`sms`='$tmp'
							";
						//echo $sql.'<br />';
						//mysql_query($sql3);
						if(substr($sts,0,1)=='0'){
							$sql24='UPDATE ak_notifikasi_sms SET status=1 WHERE id IN ('.implode(",",$id_notif).')';
							//echo $sql2.'<br>';
							//mysql_query($sql24);
						}
					}$jmll++;
				//}else{
					//$error++;
					//echo $kelas."".$nama_kelas." ".$no_hp." Error Number ".$sendername." ".$tmp."<br>";
				//}
			}else{
			echo $sekolah." | ".$kelas."".$nama_kelas." ".$no_hp." sisa ".$sendername." ".$tmp."<br>";
			$all++;
			}
		}
		
		echo $nexmo.'nexmo<br>';
		echo $raja.'raja<br>';
		echo $jmll.' jml sms<br>';
		echo $all.' SISa sms<br>';
		echo $error.' Error<br>';
		echo __FILE__;
		//$pesan='Ananda '.$nama_siswa.'';
	}
	function send_sms($to=null,$from=null,$pesan=''){
			//echo 'pos ada';exit;
            // load library

            // set response format: xml or json, default json
            $this->nexmo->set_format('json');
             $message = array(
                        'text' => $pesan
						);
            $response = $this->nexmo->send_message($from, $to, $message);
             //echo "<h1>Text Message</h1>";
            //$this->nexmo->d_print($response);
            //echo "<h3>Response Code: " . $this->nexmo->get_http_status() . "</h3>";
			$out['response']=$response;
			$out['response_code']=$this->nexmo->get_http_status();
			return  $out;
	}
	
	function get_notif(){
		if($_GET['id_sekolah']=='all'){
			$id_s="";
		}else{
			$id_s="AND sek.email='".$_GET['id_sekolah']."'";
		}
		$jamdua=date("Y-m-d 23:59:59");
		$sql="SELECT ans.*,sek.sendername,sek.nama_sekolah,sek.aktifasisendername,ap.hp as no_hp,ak.nama as nama_kelas, ak.kelas FROM ak_notifikasi_sms ans
							JOIN ak_sekolah sek
							JOIN ak_fitur_sekolah afs
							JOIN ak_pegawai ap
							JOIN ak_det_jenjang adj
							JOIN ak_kelas ak
							ON ans.id_sekolah=sek.id
							AND afs.id_sekolah=sek.id
							AND ap.id_siswa=ans.id_siswa
							AND ans.id_det_jenjang=adj.id
							AND ak.id=adj.id_kelas
							WHERE 
							ans.waktu BETWEEN '".date("Y-m-d 00:00:00")."' AND '".$jamdua."'
							AND 
							afs.aktif=1
							AND
							afs.fitur='sms_notifikasi'
							AND ans.status=0
							".$id_s."
							ORDER BY ans.id_siswa";
							//echo $sql;
		$query=mysql_query($sql);
		//echo $sql."<br />";					
		$rows = array(); 
		while ($result = mysql_fetch_assoc($query)) {       
			$rows[] = $result;
		}
		echo count($rows)." allnotif<br />";
		return $rows;
	}
}

$dom=new sms();
$dom->execute_sms();
?>