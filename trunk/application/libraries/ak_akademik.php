<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Ak_akademik {

	function checkFile($filename=null,$allowed=array()){
		$ext = pathinfo($filename, PATHINFO_EXTENSION);
		if( ! in_array( $ext, $allowed ) ) {
			return false;
		}else{
			return true;
		}	 
	}
	function checkFileXLS($filename=null,$allowed=array('xls')){
		$ext = pathinfo($filename, PATHINFO_EXTENSION);
		if( ! in_array( $ext, $allowed ) ) {
			return false;
		}else{
			return true;
		}	 
	}
	
	function getRata2($data=array()){
		$pembagi=count($data);
		$jumlah=0;
		foreach($data as $ky=>$nilai){
			$jumlah=$jumlah+$nilai;
		}
		$rata2=$jumlah/$pembagi;
		return $rata2;
	}
	
	//menghitung  nilai rata2 pr tugas ulangan per kelas
	function getAllRata2_Nilai_perKelas($id_kelas, $id_pelajaran){
		$nilai['nilai_pr']=$this->getRata2_Nilai_perKelas($id_kelas,$id_pelajaran,'nilai pr');
		$nilai['nilai_tugas']=$this->getRata2_Nilai_perKelas($id_kelas,$id_pelajaran,'nilai tugas');
		$nilai['nilai_ulangan_harian']=$this->getRata2_Nilai_perKelas($id_kelas,$id_pelajaran,'nilai ulangan harian');
		$nilai['nilai_uts']=$this->getRata2_Nilai_perKelas($id_kelas,$id_pelajaran,'nilai uts');
		$nilai['nilai_uas']=$this->getRata2_Nilai_perKelas($id_kelas,$id_pelajaran,'nilai uas');
		
		return $nilai;
	}
	//menghitung  nilai rata2 per kelas  berdasar jenis
	function getRata2_Nilai_perKelas($id_kelas, $id_pelajaran ,$jenis){
		$CI =& get_instance();
		$CI->load->model('ad_nilai'); 
		$CI->load->model('ad_siswa'); 
		$rataarray=array();
		$siswa=$CI->ad_siswa->getsiswaByIdKelas($id_kelas);
		if(!empty($siswa)){
			foreach($siswa as $datasiswa){
				$subjectnilai[$datasiswa['id_siswa_det_jenjang']]=$CI->ad_nilai->getNilaiByIddetjenjangIdkelasIdPelajaran($datasiswa['id_siswa_det_jenjang'],$id_pelajaran ,$jenis);
				if(!empty($subjectnilai[$datasiswa['id_siswa_det_jenjang']])){
					$count=count($subjectnilai[$datasiswa['id_siswa_det_jenjang']]);
					foreach($subjectnilai[$datasiswa['id_siswa_det_jenjang']] as $nilai){
						@$jml=$jml+$nilai['nilai'];
					}
					$rata2=$jml/$count;
					//echo "".$jml."/".$count." <br />";
					unset($subjectnilai[$datasiswa['id_siswa_det_jenjang']]);
					$rataarray[$datasiswa['id_siswa_det_jenjang']]['rata']=$rata2;			
					$rataarray[$datasiswa['id_siswa_det_jenjang']]['count']=$count;
					$rataarray[$datasiswa['id_siswa_det_jenjang']]['jml']=$jml;			
				}
				$jml=0;
			}	
			
		}

		//pr($rataarray);
		return $rataarray;
	}
	
	//*************menghitung  nilai rata2 pr tugas ulangan per siswa
	function getAllRata2_Nilai_perSiswa($id_det_jenjang, $id_pelajaran){
		$nilai['nilai_pr']=$this->getRata2_Nilai_perSiswa($id_det_jenjang,$id_pelajaran,'nilai pr');
		$nilai['nilai_tugas']=$this->getRata2_Nilai_perSiswa($id_det_jenjang,$id_pelajaran,'nilai tugas');
		$nilai['nilai_ulangan_harian']=$this->getRata2_Nilai_perSiswa($id_det_jenjang,$id_pelajaran,'nilai ulangan harian');

		return $nilai;	
	}
	
	//menghitung  nilai rata2 per siswa berdasar jenis
	function getRata2_Nilai_perSiswa($id_det_jenjang, $id_pelajaran ,$jenis){
		$CI =& get_instance();
		$CI->load->model('ad_nilai'); 
		$rataarray=array();
				$subjectnilai[$id_det_jenjang]=$CI->ad_nilai->getNilaiByIddetjenjangIdkelasIdPelajaran($id_det_jenjang,$id_pelajaran ,$jenis);
				if(!empty($subjectnilai[$id_det_jenjang])){
					$count=count($subjectnilai[$id_det_jenjang]);
					foreach($subjectnilai[$id_det_jenjang] as $nilai){
						@$jml=$jml+$nilai['nilai'];
					}
					$rata2=$jml/$count;
					//echo "".$jml."/".$count." <br />";
					unset($subjectnilai[$id_det_jenjang]);
					$rataarray[$id_det_jenjang]['rata']=$rata2;			
					$rataarray[$id_det_jenjang]['count']=$count;
					$rataarray[$id_det_jenjang]['jml']=$jml;
				}
		//pr($rataarray);
		return $rataarray;
	}
	
	//************menghitung nilai bobot perkelas
	function getAllBobotPerSiswa($id_det_jenjang, $id_pelajaran){
		$CI =& get_instance();
		$CI->load->model('ad_nilai');
		$bobot=$this->getAllSettingBobotPerkelas();
				//bobot = prosentase* rata2
				$rata2=$this->getAllRata2_Nilai_perSiswa($id_det_jenjang, $id_pelajaran);
				
				$bobot2[$id_det_jenjang]['nilai_pr']=($bobot['nilai pr']['prosentase']/100) * @$rata2['nilai_pr'][$id_det_jenjang]['rata'];
				$bobot2[$id_det_jenjang]['nilai_pr_rumus']="".($bobot['nilai pr']['prosentase']/100) ."*".@$rata2['nilai_pr'][$id_det_jenjang]['rata']."";
				
				$bobot2[$id_det_jenjang]['nilai_tugas']=($bobot['nilai tugas']['prosentase']/100) * @$rata2['nilai_tugas'][$id_det_jenjang]['rata'];
				$bobot2[$id_det_jenjang]['nilai_tugas_rumus']="".($bobot['nilai tugas']['prosentase']/100) ."*".@$rata2['nilai_tugas'][$id_det_jenjang]['rata']."";
				
				$bobot2[$id_det_jenjang]['nilai_ulangan_harian']=($bobot['nilai ulangan harian']['prosentase']/100) * @$rata2['nilai_ulangan_harian'][$id_det_jenjang]['rata'];
				$bobot2[$id_det_jenjang]['nilai_ulangan_harian_rumus']="".($bobot['nilai ulangan harian']['prosentase']/100) ."*".@$rata2['nilai_ulangan_harian'][$id_det_jenjang]['rata']."";
				
		//pr($bobot2);	   
		return $bobot2;
	}
	//menghitung nilai bobot perkelas
	function getAllBobotPerKelas($id_kelas, $id_pelajaran){
		$CI =& get_instance();
		$CI->load->model('ad_nilai');
		$CI->load->model('ad_siswa');
		$siswa=$CI->ad_siswa->getsiswaByIdKelas($id_kelas);
		$bobot=$this->getAllSettingBobotPerkelas();
		if(!empty($siswa)){
			foreach($siswa as $datasiswa){
				//bobot = prosentase* rata2
				$rata2=$this->getAllRata2_Nilai_perSiswa($datasiswa['id_siswa_det_jenjang'], $id_pelajaran);
				
				$bobot2[$datasiswa['id_siswa_det_jenjang']]['nilai_pr']=($bobot['nilai pr']['prosentase']/100) * @$rata2['nilai_pr'][$datasiswa['id_siswa_det_jenjang']]['rata'];
				$bobot2[$datasiswa['id_siswa_det_jenjang']]['nilai_pr_rumus']="".($bobot['nilai pr']['prosentase']/100) ."*".@$rata2['nilai_pr'][$datasiswa['id_siswa_det_jenjang']]['rata']."";
				
				$bobot2[$datasiswa['id_siswa_det_jenjang']]['nilai_tugas']=($bobot['nilai tugas']['prosentase']/100) * @$rata2['nilai_tugas'][$datasiswa['id_siswa_det_jenjang']]['rata'];
				$bobot2[$datasiswa['id_siswa_det_jenjang']]['nilai_tugas_rumus']="".($bobot['nilai tugas']['prosentase']/100) ."*".@$rata2['nilai_tugas'][$datasiswa['id_siswa_det_jenjang']]['rata']."";
				
				$bobot2[$datasiswa['id_siswa_det_jenjang']]['nilai_ulangan_harian']=($bobot['nilai ulangan harian']['prosentase']/100) * @$rata2['nilai_ulangan_harian'][$datasiswa['id_siswa_det_jenjang']]['rata'];
				$bobot2[$datasiswa['id_siswa_det_jenjang']]['nilai_ulangan_harian_rumus']="".($bobot['nilai ulangan harian']['prosentase']/100) ."*".@$rata2['nilai_ulangan_harian'][$datasiswa['id_siswa_det_jenjang']]['rata']."";
				
			}	
			
		}    
		return $bobot2;
	}
	function getAllSettingBobotPerkelas(){
		$CI =& get_instance();
		$CI->load->model('ad_nilai');
		$CI->load->library('session');
		$bobotnilai=$CI->ad_nilai->getBobotNilai($CI->session->userdata['user_authentication']['id_sekolah']);
		foreach($bobotnilai as $databobot){
			$bobotnilai2[$databobot['penilaian']]=$databobot;
		}
		//pr($bobotnilai2);
		return $bobotnilai2;
	}
	
	//****************ambil nilai  per kelas()remidi tertinggi yang di pakai ()khusus UAS UTS)
	function getNilai_Perkelas($id_kelas, $id_pelajaran, $jenis){
		$CI =& get_instance();
		$CI->load->model('ad_nilai');
		$CI->load->model('ad_siswa');
		$siswa=$CI->ad_siswa->getsiswaByIdKelas($id_kelas);
		if(!empty($siswa)){
			foreach($siswa as $datasiswa){
				$nilai[$datasiswa['id_siswa_det_jenjang']]=$CI->ad_nilai->getNilaiByIddetjenjangIdkelasIdPelajaranRemidi($datasiswa['id_siswa_det_jenjang'],$id_pelajaran ,$jenis);
			}	
			
		}    
		return $nilai;		
	}
	
	function getNilai_PerSiswa($id_siswa_det_jenjang, $id_pelajaran, $jenis){
		$CI =& get_instance();
		$CI->load->model('ad_nilai');
		$CI->load->model('ad_siswa');
				$nilai[$id_siswa_det_jenjang]=$CI->ad_nilai->getNilaiByIddetjenjangIdkelasIdPelajaranRemidi($id_siswa_det_jenjang,$id_pelajaran ,$jenis);
   
		return $nilai;		
	}
	
	//*********** hitung nilai bobot UAS UTS PerSiswa
	function getAllBobotUASUTSPerSiswa($id_det_jenjang,$id_pelajaran){
		$CI =& get_instance();
		$CI->load->model('ad_nilai');
		//$siswa=$CI->ad_siswa->getsiswaByIdDetJenjang($id_det_jenjang);
		$bobot=$this->getAllSettingBobotPerkelas();
		
				//bobot = prosentase* rata2
				$nilaiUAS=$this->getNilai_PerSiswa($id_det_jenjang, $id_pelajaran,'nilai uas');
				$nilaiUTS=$this->getNilai_PerSiswa($id_det_jenjang, $id_pelajaran,'nilai uts');
				
				$bobot2[$id_det_jenjang]['nilai_uas']=($bobot['nilai uas']['prosentase']/100) * $nilaiUAS[$id_det_jenjang][0]['nilai'];
				$bobot2[$id_det_jenjang]['nilai_uas_rumus']="".($bobot['nilai uas']['prosentase']/100) ."*".$nilaiUAS[$id_det_jenjang][0]['nilai']."";
				
				$bobot2[$id_det_jenjang]['nilai_uts']=($bobot['nilai uts']['prosentase']/100) * $nilaiUTS[$id_det_jenjang][0]['nilai'];
				$bobot2[$id_det_jenjang]['nilai_uts_rumus']="".($bobot['nilai uts']['prosentase']/100) ."*".$nilaiUTS[$id_det_jenjang][0]['nilai']."";
			 
		//unset($nilaiUAS);		
		//unset($nilaiUTS);		
		//unset($siswa);		
		//unset($bobot);		
		return $bobot2;
	}
	//*********** hitung nilai bobot UAS UTS PerKelas
	function getAllBobotUASUTSPerKelas($id_kelas,$id_pelajaran){
		$CI =& get_instance();
		$CI->load->model('ad_nilai');
		$CI->load->model('ad_siswa');
		$siswa=$CI->ad_siswa->getsiswaByIdKelas($id_kelas);
		$bobot=$this->getAllSettingBobotPerkelas();
		if(!empty($siswa)){
			foreach($siswa as $datasiswa){
				//bobot = prosentase* rata2
				$nilaiUAS=$this->getNilai_PerSiswa($datasiswa['id_siswa_det_jenjang'], $id_pelajaran,'nilai uas');
				$nilaiUTS=$this->getNilai_PerSiswa($datasiswa['id_siswa_det_jenjang'], $id_pelajaran,'nilai uts');
				
				$bobot2[$datasiswa['id_siswa_det_jenjang']]['nilai_uas']=($bobot['nilai uas']['prosentase']/100) * $nilaiUAS[$datasiswa['id_siswa_det_jenjang']][0]['nilai'];
				$bobot2[$datasiswa['id_siswa_det_jenjang']]['nilai_uas_rumus']="".($bobot['nilai uas']['prosentase']/100) ."*".$nilaiUAS[$datasiswa['id_siswa_det_jenjang']][0]['nilai']."";
				
				$bobot2[$datasiswa['id_siswa_det_jenjang']]['nilai_uts']=($bobot['nilai uts']['prosentase']/100) * $nilaiUTS[$datasiswa['id_siswa_det_jenjang']][0]['nilai'];
				$bobot2[$datasiswa['id_siswa_det_jenjang']]['nilai_uts_rumus']="".($bobot['nilai uts']['prosentase']/100) ."*".$nilaiUTS[$datasiswa['id_siswa_det_jenjang']][0]['nilai']."";
			}	
			
		} 
		//unset($nilaiUAS);		
		//unset($nilaiUTS);		
		//unset($siswa);		$CI->load->model('ad_nilai');
		//unset($bobot);		
		return $bobot2;
	}

	//hitung nilai kognitif perkelas
	function nilaiKognitifPerKelas($id_kelas,$id_pelajaran){
		$bobotPr_Tugas_UlanganHarian=$this->getAllBobotPerKelas($id_kelas,$id_pelajaran);
		$bobotUas_Uts=$this->getAllBobotUASUTSPerKelas($id_kelas,$id_pelajaran);
		
		//hitung nilai kognitif
		foreach($bobotPr_Tugas_UlanganHarian as $id_siswa_det_jenjang => $nilai){
			$kognitif[$id_siswa_det_jenjang]['kognitif']=$nilai['nilai_pr']+$nilai['nilai_tugas']+$nilai['nilai_ulangan_harian']+$bobotUas_Uts[$id_siswa_det_jenjang]['nilai_uas']+$bobotUas_Uts[$id_siswa_det_jenjang]['nilai_uts'];
			$kognitif[$id_siswa_det_jenjang]['nilai_pr']=$nilai['nilai_pr'];
			$kognitif[$id_siswa_det_jenjang]['nilai_tugas']=$nilai['nilai_tugas'];
			$kognitif[$id_siswa_det_jenjang]['nilai_ulangan_harian']=$nilai['nilai_ulangan_harian'];
			$kognitif[$id_siswa_det_jenjang]['nilai_uas']=$bobotUas_Uts[$id_siswa_det_jenjang]['nilai_uas'];
			$kognitif[$id_siswa_det_jenjang]['nilai_uts']=$bobotUas_Uts[$id_siswa_det_jenjang]['nilai_uts'];
		}
		
		//unset($bobotPr_Tugas_UlanganHarian);$CI->load->model('ad_nilai');
		//unset($bobotUas_Uts);
		return $kognitif;
	}
	function nilaiByDetJenjangPelajaran($id_det_jenjang,$pelajaran,$jenis){
		$CI =& get_instance();
		$CI->load->model('ad_nilai');
		foreach($pelajaran as $datapel){
			$nilai[$datapel['id']]=$CI->ad_nilai->getNilaiByIddetjenjangIdkelasIdPelajaran($id_det_jenjang,$datapel['id'],$jenis);
		}
		return $nilai;
	}
	//hitung nilai kognitif perSiswa
	function nilaiRaportPerSiswaxx($id_det_jenjang){
		$CI =& get_instance();
		$CI->load->model('ad_pelajaran');
		$pelajaran=$CI->ad_pelajaran->getdataByIdDetJenjang($id_det_jenjang);
		//pr($pelajaran);die();
		$nilaiAfektif=$this->nilaiByDetJenjangPelajaran($id_det_jenjang,$pelajaran,'nilai_afektif');
		$nilaiPraktik=$this->nilaiByDetJenjangPelajaran($id_det_jenjang,$pelajaran,'nilai_psikomotorik');
		$nilaiKetercapaian=$this->nilaiByDetJenjangPelajaran($id_det_jenjang,$pelajaran,'nilai_kompetensi');
		
		foreach($pelajaran as $datapel){
		//$datapel['id']=1;
		$nilai=$this->getAllBobotPerSiswa($id_det_jenjang, $datapel['id']);
		$bobotUas_Uts=$this->getAllBobotUASUTSPerSiswa($id_det_jenjang,$datapel['id']);
		//pr($nilai);
		
			$kognitif[$datapel['id']]['pelajaran']=$datapel['nama'];
			$kognitif[$datapel['id']]['kkm']=$datapel['nilai'];
			$kognitif[$datapel['id']]['kognitif']=$nilai[$id_det_jenjang]['nilai_pr']+$nilai[$id_det_jenjang]['nilai_tugas']+$nilai[$id_det_jenjang]['nilai_ulangan_harian']+$bobotUas_Uts[$id_det_jenjang]['nilai_uas']+$bobotUas_Uts[$id_det_jenjang]['nilai_uts'];
			$kognitif[$datapel['id']]['praktik']=round(@$nilaiPraktik[$datapel['id']][0]['nilai'],2);
			$kognitif[$datapel['id']]['afektif']=@$nilaiAfektif[$datapel['id']][0]['nilai'];
			$kognitif[$datapel['id']]['ketercapaian']=@$nilaiKetercapaian[$datapel['id']][0]['nilai'];
		}
		//pr($nilaiAfektif);
		return $kognitif;
	}
	
	//DENGAN RUMUS
	function nilaiKognByIdDetJenPelOtentik($id_det_jenjang=0,$id_pel=0){
		$CI =& get_instance();
		$CI->load->model('ad_nilai');
		$CI->load->model('ad_setting');
		$CI->load->model('ad_pelajaran');

		$rumusraport=$CI->ad_setting->getSetting('rumusraport',$CI->session->userdata['user_authentication']['id_sekolah']);
		$rumusraport2=unserialize(@$rumusraport[0]['value']);
		$rumuskognitif=$rumusraport2['rumus_raport'];
		$pelajaran=$CI->ad_pelajaran->getdataById($id_pel);
		
		$Afektif=$CI->ad_nilai->getNilaiByIddetjenjangIdkelasIdPelajaran($id_det_jenjang,$id_pel,'nilai_afektif');
		$Psikomotorik=$CI->ad_nilai->getNilaiByIddetjenjangIdkelasIdPelajaran($id_det_jenjang,$id_pel,'nilai_praktik');

		//foreach($pelajaran as $datapel){

			$kognitif[$id_pel]['pelajaran']=$pelajaran[0]['nama'];
			
			//kognitif
			//Rata2
			$rata2=$this->getAllRata2_Nilai_perSiswa($id_det_jenjang, $id_pel);
			$PR=@$rata2['nilai_pr'][$id_det_jenjang]['rata'];
			$TUGAS=@$rata2['nilai_tugas'][$id_det_jenjang]['rata'];
			$HARIAN=@$rata2['nilai_ulangan_harian'][$id_det_jenjang]['rata'];
			
			$nilaiUAS=$this->getNilai_PerSiswa($id_det_jenjang, $id_pel,'nilai uas');
			$nilaiUTS=$this->getNilai_PerSiswa($id_det_jenjang, $id_pel,'nilai uts');
			$UTS=$nilaiUTS[$id_det_jenjang][0]['nilai'];
			$UAS=$nilaiUAS[$id_det_jenjang][0]['nilai'];
			
			$rumuskognitif2='$hs='.$rumuskognitif.';';
			eval($rumuskognitif2);
			$kognitif[$id_pel]['kognitif']=$hs;
			$kognitif[$id_pel]['afektif']=$Afektif;
			$kognitif[$id_pel]['Psikomotorik']=$Psikomotorik;
				
			//pr($kognitif);
			if($pelajaran[0]['havechild']==1){
				$subnilai=$this->SubnilaiRaportPerSiswa($id_det_jenjang,$id_pel);
				if($subnilai=='nosub'){
				
				}else{
					$kognitif[$id_pel]['kognitif']=$subnilai['kognitif'];
					$kognitif[$id_pel]['praktik']=$subnilai['praktik'];
					$kognitif['submapel'][$id_pel.'-'.$pelajaran[0]['nama']]=$subnilai['datasub'];
					
				}
			}
			
		//}
		return $kognitif;	
	}
	//DENGAN RUMUS
	function nilaiRaportPerSiswa($id_det_jenjang=0){
		$CI =& get_instance();
		$CI->load->model('ad_pelajaran');
		$CI->load->model('ad_setting');

		$rumusraport=$CI->ad_setting->getSetting('rumusraport',$CI->session->userdata['user_authentication']['id_sekolah']);
		$rumusraport2=unserialize(@$rumusraport[0]['value']);
		$rumuskognitif=$rumusraport2['rumus_raport'];
		
		$pelajaran=$CI->ad_pelajaran->getdataByIdDetJenjang($id_det_jenjang);
		//pr($pelajaran);die();
		$nilaiAfektif=$this->nilaiByDetJenjangPelajaran($id_det_jenjang,$pelajaran,'nilai_afektif');
		$nilaiPraktik=$this->nilaiByDetJenjangPelajaran($id_det_jenjang,$pelajaran,'nilai_psikomotorik');
		$nilaiKetercapaian=$this->nilaiByDetJenjangPelajaran($id_det_jenjang,$pelajaran,'nilai_kompetensi');
		
		foreach($pelajaran as $datapel){

			$kognitif[$datapel['id']]['pelajaran']=$datapel['nama'];
			$kognitif[$datapel['id']]['kkm']=$datapel['nilai'];
			
			//kognitif
			//Rata2
			$rata2=$this->getAllRata2_Nilai_perSiswa($id_det_jenjang, $datapel['id']);
			$PR=@$rata2['nilai_pr'][$id_det_jenjang]['rata'];
			$TUGAS=@$rata2['nilai_tugas'][$id_det_jenjang]['rata'];
			$HARIAN=@$rata2['nilai_ulangan_harian'][$id_det_jenjang]['rata'];
			
			$nilaiUAS=$this->getNilai_PerSiswa($id_det_jenjang, $datapel['id'],'nilai uas');
			$nilaiUTS=$this->getNilai_PerSiswa($id_det_jenjang, $datapel['id'],'nilai uts');
			$UTS=$nilaiUTS[$id_det_jenjang][0]['nilai'];
			$UAS=$nilaiUAS[$id_det_jenjang][0]['nilai'];
			
			$kognitif[$datapel['id']]['praktik']=round(@$nilaiPraktik[$datapel['id']][0]['nilai'],2);
			$kognitif[$datapel['id']]['afektif']=@$nilaiAfektif[$datapel['id']][0]['nilai'];
			$kognitif[$datapel['id']]['ketercapaian']=@$nilaiKetercapaian[$datapel['id']][0]['nilai'];
			
			$rumuskognitif2='$hs='.$rumuskognitif.';';
			eval($rumuskognitif2);
			$kognitif[$datapel['id']]['kognitif']=$hs;
				
			if($datapel['havechild']==1){
				$subnilai=$this->SubnilaiRaportPerSiswa($id_det_jenjang,$datapel['id']);
				if($subnilai=='nosub'){
				
				}else{
					$kognitif[$datapel['id']]['kognitif']=$subnilai['kognitif'];
					$kognitif[$datapel['id']]['praktik']=$subnilai['praktik'];
					$kognitif['submapel'][$datapel['id'].'-'.$datapel['nama']]=$subnilai['datasub'];
					
				}
			}
			
		}
		return $kognitif;
	}
	function SubnilaiRaportPerSiswa($id_det_jenjang=0,$id_parentmapel){
		$CI =& get_instance();
		$CI->load->model('ad_pelajaran');
		$CI->load->model('ad_setting');

		$rumusraport=$CI->ad_setting->getSetting('rumusraport',$CI->session->userdata['user_authentication']['id_sekolah']);
		$rumusraport2=unserialize(@$rumusraport[0]['value']);
		$rumuskognitif=$rumusraport2['rumus_raport'];
		
		$pelajaran=$CI->ad_pelajaran->getdataByIdDetJenjangByparentmapel($id_det_jenjang,$id_parentmapel);
		//pr($pelajaran);die();
		$nilaiAfektif=$this->nilaiByDetJenjangPelajaran($id_det_jenjang,$pelajaran,'nilai_afektif');
		$nilaiPraktik=$this->nilaiByDetJenjangPelajaran($id_det_jenjang,$pelajaran,'nilai_psikomotorik');
		$nilaiKetercapaian=$this->nilaiByDetJenjangPelajaran($id_det_jenjang,$pelajaran,'nilai_kompetensi');
		if(empty($pelajaran)){return 'nosub';}
		foreach($pelajaran as $datapel){

			$kognitif[$datapel['id']]['pelajaran']=$datapel['nama'];
			$kognitif[$datapel['id']]['kkm']=$datapel['nilai'];
			
			//kognitif
			//Rata2
			$rata2=$this->getAllRata2_Nilai_perSiswa($id_det_jenjang, $datapel['id']);
			$PR=@$rata2['nilai_pr'][$id_det_jenjang]['rata'];
			$TUGAS=@$rata2['nilai_tugas'][$id_det_jenjang]['rata'];
			$HARIAN=@$rata2['nilai_ulangan_harian'][$id_det_jenjang]['rata'];
			
			$nilaiUAS=$this->getNilai_PerSiswa($id_det_jenjang, $datapel['id'],'nilai uas');
			$nilaiUTS=$this->getNilai_PerSiswa($id_det_jenjang, $datapel['id'],'nilai uts');
			$UTS=$nilaiUTS[$id_det_jenjang][0]['nilai'];
			$UAS=$nilaiUAS[$id_det_jenjang][0]['nilai'];

			$rumuskognitif2='$hs='.$rumuskognitif.';';
			eval($rumuskognitif2);
			$kognitif[$datapel['id']]['kognitif']=$hs;
			
			$kognitif[$datapel['id']]['praktik']=round(@$nilaiPraktik[$datapel['id']][0]['nilai'],2);
			//$kognitif[$datapel['id']]['afektif']=@$nilaiAfektif[$datapel['id']][0]['nilai'];
			//$kognitif[$datapel['id']]['ketercapaian']=@$nilaiKetercapaian[$datapel['id']][0]['nilai'];
			
			$jmlkg=$jmlkg+$hs;
			$jmlprk=$jmlprk+$kognitif[$datapel['id']]['praktik'];
		}
		$out['kognitif']=$jmlkg/count($pelajaran);
		$out['praktik']=$jmlprk/count($pelajaran);
		$out['datasub']=$kognitif;
		//pr($out);
		return $out;
	}
	
	function makerataafektif($id_siswa_det_jenjang=0,$id_kelas=0,$id_pelajaran=0,$jenis=''){
			//select pint indikator
			$CI =& get_instance();
			$CI->load->model('ad_pembelajaran');
			//if($jenis=='psikomotorik'){$jenis='praktik';}
			$point= $CI->ad_pembelajaran->getPointIndikatorByDetjenjangKlsPelSek($id_siswa_det_jenjang,$id_kelas,$id_pelajaran);
			$nilaicurrent=$CI->ad_pembelajaran->getNilaicurrent($id_siswa_det_jenjang,$id_pelajaran,$jenis);
			$pembagi=count($point);
			foreach($point as $datapoint){	
				$jml=$jml+$datapoint['point'];
			}
			$rata=$jml/$pembagi;
			$insertnilai=array(
				'id_sekolah'=>$CI->session->userdata['user_authentication']['id_sekolah'],
				'id_siswa_det_jenjang'=>$id_siswa_det_jenjang,
				'id_pelajaran'=>$_POST['id_pelajaran'],
				'ta'=>$CI->session->userdata['ak_setting']['ta'],
				'semester'=>$CI->session->userdata['ak_setting']['semester'],
				'nilai'=>$rata
			);	
			//pr($nilaicurrent);
			
			if(!empty($nilaicurrent)){
				//update
				foreach($nilaicurrent as $datacurrent){
					$CI->db->where('id',$datacurrent['id']);
					$CI->db->update('ak_nilai_'.$jenis,$insertnilai);	
				}
			}else{
				//insert
				/*$this->sb++;
				if($this->sb==1){
					$insert=array(
								'id_sekolah'=>$CI->session->userdata['user_authentication']['id_sekolah'],
								'id_pegawai'=>$CI->session->userdata['user_authentication']['id_pengguna'],
								'id_kelas'=>@$id_kelas,
								'id_referensi'=>0,
								'id_pelajaran'=>$id_pelajaran,
								'ta'=>$CI->session->userdata['ak_setting']['ta'],
								'semester'=>$CI->session->userdata['ak_setting']['semester'],
								'jenis'=>'nilai '.$jenis,
								'subject'=>@base64_decode($_POST['subject'])
					);
					$CI->db->insert('ak_subject_nilai',$insert);
					$this->id_subject=mysql_insert_id();
				}*/
				//$insertnilai['id_subject']=$this->id_subject;
				//foreach($nilaicurrent as $datacurrent){
					$CI->db->insert('ak_nilai_'.$jenis,$insertnilai);	
				//}	
			}	
			echo $CI->db->last_query();
	}
}

?>