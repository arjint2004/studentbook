<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Bahanajar extends CI_Controller
    {
	
	    var $roots = array(
        'test' => '/home'
		);
		
        public function __construct()
        {
            parent::__construct();
            $this->load->helper('global');
            $this->load->library('session');
            $this->load->library('auth'); 
            $this->auth->user_logged_in();
            $this->load->library('ak_file');
        }
        
        public function siswa(){

			/*$data['file']=Array
				(

					'SMP - Kelas 7 - Bahasa Indonesia' => Array
						(
							'0' => 'Aktif_Berbahasa_Indonesia_Kelas_7_Dewi_Indrawati_Didik_Durianto_2008.pdf',
							'1' => 'Bahasa_Indonesia_Bahasa_Bangsaku_Kelas_7_Sarwiji_Suwandi_Sutarmo_2008.pdf',
							'2' => 'Bahasa_Indonesia_Indonesia_Kelas_VII_Kelas_7_Endah_Tri_Priyatni_Yuni_Pratiwi_Syamsul_Sodiq_2008.pdf',
							'3' => 'Bahasa_Indonesia_Jendela_Ilmu_Pengetahuan_Kelas_7_Romiyatun_dan_Siswoyo_2008.pdf',
							'4' => 'Bahasa_Indonesia_Memperkaya_Wawasanku_Kelas_7_Agus_Supriyatna_Siti_Maryam_2009.pdf',
							'5' => 'Bahasa_dan_Sastra_Indonesia_1_Kelas_7_Dwi_Harningsih_Bambang_Wisnu_dan_Septi_Lestari_2008.pdf',
							'6' => 'Bahasa_dan_Sastra_Indonesia_1_Kelas_7_Maryati_dan_Sutopo_2008.pdf',
							'7' => 'Bahasa_dan_Sastra_Indonesia_Kelas_7_F_X_Mudjiharjo_V_Sugiyono_D_Silalahi_dan_E_2010.pdf',
							'8' => 'Bahasa_dan_Sastra_Indonesia_Kelas_7_Sawali_Ch_Susanto_2010.pdf',
							'9' => 'Bahasa_dan_Sastra_Indonesia_Kelas_7_Sawali_Ch_Susanto_2011.pdf',
							'10' => 'Berbahasa_dan_Bersastra_Indonesia_Kelas_7_Asep_Yudha_Wirajaya_dan_Sudarmawarti_2010.pdf',
							'11' => 'Cakap_Berbahasa_Indonesia_Kelas_7_RR_Novi_Kussuji_Indrastuti_dan_Diah_Ema_Trinings_2010.pdf',
							'12' => 'Cakap_Berkomunikasi_dalam_bahasa_Indonesia_Kelas_7_Erwan_Juhara_Eriyandi_Budiman_dan_Rita_Rochayati_2010.pdf',
							'13' => 'Cerdas_Berbahasa_Indonesia_Kelas_7_Nok_Mujiati_Parjopo_2009.pdf',
							'14' => 'Kompetensi_Berbahasa_Indonesia_1_Kelas_7_Ratna_Susanti_2008.pdf',
							'15' => 'Kompetensi_Berbahasa_Indonesia_Kelas_7_Nia_Kurniati_Sapari_2008.pdf',
						),

					'SMP - Kelas 7 - Bahasa Inggris' => Array
						(
							'0' => 'Bahasa_Inggris_Kelas_7_Th_Kumalarini_Achmad_Munir_Slamet_Setiawan_2008.pdf',
							'1' => 'English_in_Focus_Kelas_7_Artono_Wardiman_Masduki_B_Jahur_M_Sukiman_2008.pdf',
							'2' => 'Scaffolding_Grade_VII_Kelas_7_Joko_Priyana_Riandi_Anita_P_Mumpuni_2008.pdf',
						),

					'SMP - Kelas 7 - IPA' => Array
						(
							'0' => 'Alam_Sekitar_IPA_Terpadu_Kelas_7_Iip_Rohima_Diana_Puspita_2009.pdf',
							'1' => 'Belajar_IPA_Membuka_Cakrawala_Alam_Sekitar_Kelas_7_Saeful_Karim_Ida_Nurul_Fauziah_Wahyu_Sopandi_2009.pdf',
							'2' => 'Cerdas_Belajar_IPA_VII_Kelas_1_Agung_Wijaya_Budi_Suryatin_Das_Salirawati_2009.pdf',
							'3' => 'IPA_Terpadu_Kelas_7_Sudjino_Waldjinah_Endang_Purwanti_2008.pdf',
							'4' => 'IPA_Terpadu_VII_Kelas_7_Anni_Winarsih_Agung_Nugroho_Sulistyoso_HP_2008.pdf',
							'5' => 'Ilmu_Pengetahuan_Alam_(Terpadu)_Kelas_7_Setya_Nurachmandani_dan_Samson_Samsulhadi_2010.pdf',
							'6' => 'Ilmu_Pengetahuan_Alam_Kelas_7_Asep_Suryatna_Enjah_Takari_R_2009.pdf',
							'7' => 'Ilmu_Pengetahuan_Alam_Kelas_7_Zaipudin_Arahim_Purwosutanto_Purwo_Dasihanto_Pu_2009.pdf',
							'8' => 'Ilmu_Pengetahuan_Alam_Kelas_VII_Kelas_7_Wasis_Sukarmin_Elok_Sudibyo_Utiya_Azizah_2008.pdf',
							'9' => 'Ilmu_Pengetahuan_Alam_VII_Kelas_7_Teguh_Sugiyarto_Eni_Ismawati_2008.pdf',
							'10' => 'Ilmu_Pengetahuan_Alam_VII_Kelas_7_Wasis_Sugeng_Yuli_Irianto_2008.pdf',
							'11' => 'Mari_Belajar_Ilmu_Alam_Sekitar_1_Kelas_7_Sukis_Wariyono_Yani_Muharomah_2009.pdf',
							'12' => 'Pembelajaran_IPA_Terpadu_dan_Kontekstual_Kelas_7_Suhardi_Suratno_Pera_Hastuti_2009.pdf',
						),

					'SMP - Kelas 7 - IPS' => Array
						(
							'0' => 'IPS_1_Kelas_7_Nanang_Herjunanto_Penny_Rahmawati_Sutarto_Sunar_2009.pdf',
							'1' => 'IPS_7_Kelas_7_Rogers_Pakpahan_Losina_Purnastuti_Aman_dan_Igna_2010.pdf',
							'2' => 'IPS_Kelas_7_Budi_Sanjaya_Farida_Sarimaya_Iyus_Andi_Nugraha_2010.pdf',
							'3' => 'IPS_Kelas_8_Budi_Sanjaya_Farida_Sarimaya_Iyus_Andi_Nugraha_2010.pdf',
							'4' => 'Ilmu_Pengetahuan_Sosial_1_Kelas_7_Didang_Setiawan_2008.pdf',
							'5' => 'Ilmu_Pengetahuan_Sosial_1_Kelas_7_Herlan_Firmansyah_Dani_Ramdani_2009.pdf',
							'6' => 'Ilmu_Pengetahuan_Sosial_1_Kelas_7_Suprihartoyo_Djuminah_Esti_Dwy_Wardayati_2009.pdf',
							'7' => 'Ilmu_Pengetahuan_Sosial_IPS_1_Kelas_7_Atang_Husein_C_Suprijadi_CH_Supatmiyarsih_M_2008.pdf',
							'8' => 'Ilmu_Pengetahuan_Sosial_Kelas_7_I_Wayan_Legawa_Sugiharsono_Teguh_Dalyono_2008.pdf',
							'9' => 'Ilmu_Pengetahuan_Sosial_Kelas_7_Waluyo_Suwardi_Agung_Feryanto_Triharyanto_2008.pdf',
							'10' => 'Jelajah_Cakrawala_Sosial_Kelas_7_Nurhadi_Budi_A_Saleh_Diding_A_Badri_Paula_S_2009.pdf',
							'11' => 'Mari_Belajar_IPS_Untuk_SMP_MTs_Kelas_7_Muh_Nurdin_SW_Warsito_Muh_Nur_Syaban_2008.pdf',
							'12' => 'Sudut_Bumi_IPS_Terpadu_Kelas_7_Kurtubi_2009.pdf',
							'13' => 'Wawasan_Sosial_Ilmu_Pengetahuan_Sosial_SMP_MTs_Kelas_7_Iwan_Setiawan_Suciawati_Lina_Hasanah_Edi_2008.pdf',
						),

					'SMP - Kelas 7 - Matematika' => Array
						(
							'0' => 'MATEMATIKA_Kelas_7_J_Dris_Tasari_2011.pdf',
							'1' => 'Matematika_Kelas_7_Atik_Wintarti_Endah_Budi_Rahaju_R_Sulaiman_2008.pdf',
							'2' => 'Matematika_Konsep_dan_Aplikasinya_Kelas_7_Dewi_Nuharini_Tri_Wahyuni_2008.pdf',
							'3' => 'Pegangan_Belajar_Matematika_1_Kelas_7_A_Wagiyo_F_Surati_Irene_Supradiarini_2008.pdf',
							'4' => 'Penunjang_Belajar_Matematika_Kelas_7_Dame_Rosida_Manik_2009.pdf',
						),

					'SMP - Kelas 7 - PKN' => Array
						(
							'0' => 'Aku_Warga_Negara_Indonesia_PKn_2_Kelas_7_Dasim_Budimansyah_2009.pdf',
							'1' => 'PKn_Kecakapan_Berbangsa_dan_Bernegara_Kelas_7_AA_Nurdiaman_2009.pdf',
							'2' => 'PKn_Menumbuhkan_Nasionalisme_dan_Patriotisme_Kelas_7_Lukman_Surya_Saputra_2009.pdf',
							'3' => 'Pendidikan_Kewarganegaraan_1_Kelas_7_Dewi_Aniaty_Aviani_Santi_2009.pdf',
							'4' => 'Pendidikan_Kewarganegaraan_1_Kelas_7_Parsono_2009.pdf',
							'5' => 'Pendidikan_Kewarganegaraan_1_Kelas_7_Slamet_Santosa_2009.pdf',
							'6' => 'Pendidikan_Kewarganegaraan_1_Kelas_7_Sugiharso_Sugiyono_Gunawan_Karsono_2009.pdf',
							'7' => 'Pendidikan_Kewarganegaraan_Kelas_7_AT_Sugeng_Priyanto_Djaenudin_Harun_2008.pdf',
							'8' => 'Pendidikan_Kewarganegaraan_Kelas_7_MS_Faridy_2009.pdf',
							'9' => 'Pendidikan_Kewarganegaraan_Kelas_7_Wahyu_Nugroho_2009.pdf',
						),

					'SMP - Kelas 7 - Pendidikan Agama' => Array
						(
							'0' => 'Pendidikan_Agama_Islam_1_Kelas_7_Siti_Nuryaningsih_dan_Noor_Imanah_2011.pdf',
							'1' => 'Pendidikan_Agama_Islam_Kelas_7_Ani_Istiani_dan_Bakrun_2011.pdf',
							'2' => 'Pendidikan_Agama_Islam_Kelas_7_Husni_Thoyar_2011.pdf',
							'3' => 'Pendidikan_Agama_Islam_Kelas_7_Karwadi_Umi_Baroroh_Sukiman_Sutrisno_2011.pdf',
							'4' => 'Pendidikan_Agama_Islam_Kelas_7_Rachmat_Hidayat_dan_Budi_Hendriyana_2011.pdf',
						),

					'SMP - Kelas 7 - Penjasorkes' => Array
						(
							'0' => 'Pendidikan_Jasmani_Olahraga_dan_Kesehatan_1_Kelas_7_Sri_Wahyuni_Sutarmin_dan_Pramono_2010.pdf',
							'1' => 'Pendidikan_Jasmani_Olahraga_dan_Kesehatan_Kelas_7_Sodikin_Chandra_dan_Achmad_Esnoe_Sanoesi_2010.pdf',
							'2' => 'Pendidikan_Jasmani_Olahraga_dan_Kesehatan_Kelas_7_Sujarwadi_dan_Dwi_Sarjiyanto_2010.pdf',
						),

					'SMP - Kelas 7 - SBK' => Array
						(
							'0' => 'Mari_Belajar_Seni_Rupa_Kelas_7_Tri_Edy_Margono_dan_Abdul_Aziz_2010.pdf',
							'1' => 'Pendidikan_Seni_Tari_Kelas_7_Atang_Supriatna_dan_Rama_Sastra_Negara_2010.pdf',
							'2' => 'Seni_Rupa_Kelas_7_Rachmat_Suhernawan_dan_Rizal_Ardhya_NUgraha_2010.pdf',
							'3' => 'Seni_Tari_Kelas_7_Ari_Subekti_Budiawan_2010.pdf',
							'4' => 'Seni_Tari_Kelas_7__Alien_Wiriatunnisa_Yulia_Hendrilianti_2010.pdf',
							'5' => 'Seni_Teater_Kelas_7_Trisno_Santoso_Retno_Sayekti_Wisik_Lawu_Purbo_Uta_2010.pdf',
							'6' => 'Terampil_Bermusik_Kelas_7_Wahyu_Purnomo_dan_Fasih_Subagyo_2010.pdf',
						),

					'SMP - Kelas 7 - TIK' => Array
						(
							'0' => 'Cerdas_dan_Terampil_Teknologi_Informasi_dan_Komunikasi_1_Kelas_7_Reynold_dan_Djuharis_Rasul_2010.pdf',
							'1' => 'Dunia_Teknologi_Informasi_dan_Komunikasi_Kelas_7_Kismiantini_RIna_Dyah_Rahmawati_dan_Evi_Rine_2010.pdf',
							'2' => 'Membuka_Cakrawala_Teknologi_Informasi_dan_Komunikasi_1_Kelas_7_Iwan_Sofana_dan_Epsi_Budihardjo_2010.pdf',
							'3' => 'Mengenal_Teknologi_Informasi_dan_Komunikasi_Kelas_7_Ida_Bagus_Budiyanto_dan_RR_Phitsa_Mauliana_2010.pdf',
							'4' => 'Satelit_TIK_Kelas_7_Novyan_Siswanto_dan_Akfen_Efendi_2010.pdf',
							'5' => 'Teknologi_Informasi_dan_Komunikasi_Kelas_7_Joko_Pramono_dan_Pris_Priyanto_2010.pdf',
							'6' => 'Terampil_Berkomputer_Kelas_7_Rohmat_Nur_Ibrahim_dan_Hendi_Hudaya_2010.pdf',
						)

				);*/
            //pr($this->session->userdata('ak_setting'));
		    //pr($this->session->userdata('user_authentication'));
			//$arrdir=$this->ak_file->dirToArray('D:/webdevel/studentbookgit/upload/contentsekolah/'.$this->session->userdata('ak_setting')['jenjang'][0]['nama'].'/Kelas '.$this->session->userdata('user_authentication')['kelas'].'');
			#$arrdir=$this->ak_file->dirToArray('/home/studoid1/public_html/studentbookgit/upload/contentsekolah/'.$this->session->userdata('ak_setting')['jenjang'][0]['nama'].'/Kelas '.$this->session->userdata('user_authentication')['kelas'].'');
			
			//$data['kelasdir']='Kelas '.$this->session->userdata('user_authentication')['kelas'].'';
			//$data['file']=$arrdir;
			//$data['jenjang']=$this->session->userdata('ak_setting')['jenjang'][0]['nama'];
			
			
			
			$arrdir=$this->ak_file->dirToArray('D:/webdevel/studentbookgit/upload/contentsekolah/'.$this->session->userdata('ak_setting')['jenjang'][0]['nama'].'/Kelas '.$this->session->userdata('user_authentication')['kelas'].'');
			$arrdirk13=$this->ak_file->dirToArray('D:/webdevel/studentbookgit/upload/contentsekolah/k13/'.$this->session->userdata('ak_setting')['jenjang'][0]['nama'].'/Kelas '.$this->session->userdata('user_authentication')['kelas'].'');
			#$arrdir=$this->ak_file->dirToArray('/home/studoid1/public_html/studentbook/trunk/upload/contentsekolah/'.$this->session->userdata('ak_setting')['jenjang'][0]['nama'].'/Kelas '.$this->session->userdata('user_authentication')['kelas'].'');
			#$arrdirk13=$this->ak_file->dirToArray('/home/studoid1/public_html/studentbook/trunk/upload/contentsekolah/k13/'.$this->session->userdata('ak_setting')['jenjang'][0]['nama'].'/Kelas '.$this->session->userdata('user_authentication')['kelas'].'');
			
			$data['id']=$id;
			$data['Kelas']='Kelas '.$this->session->userdata('user_authentication')['kelas'].'';
			$data['file']=$arrdir;
			$data['filek13']=$arrdirk13;
			$data['jenjang']=$this->session->userdata('ak_setting')['jenjang'][0]['nama'];
			//pr($arrdir);
			//pr($arrdirk13);
			
			//die();
			$data['main']= 'akademik/bahanajar/index';
            $this->load->view('layout/ad_blank',$data);			
        }    

        public function guru($id='',$additional=''){

            //pr($this->session->userdata('ak_setting'));
		    //pr($this->session->userdata('user_authentication'));
			
			$arrdir=$this->ak_file->dirToArray('D:/webdevel/studentbookgit/upload/contentsekolah/'.$this->session->userdata('ak_setting')['jenjang'][0]['nama'].'');
			$arrdirk13=$this->ak_file->dirToArray('D:/webdevel/studentbookgit/upload/contentsekolah/k13/'.$this->session->userdata('ak_setting')['jenjang'][0]['nama'].'');
			#$arrdir=$this->ak_file->dirToArray('/home/studoid1/public_html/studentbook/trunk/upload/contentsekolah/'.$this->session->userdata('ak_setting')['jenjang'][0]['nama'].'');
			#$arrdirk13=$this->ak_file->dirToArray('/home/studoid1/public_html/studentbook/trunk/upload/contentsekolah/k13/'.$this->session->userdata('ak_setting')['jenjang'][0]['nama'].'');
			
			if($additional!=''){$data['additional']='id="contentbelajarid"';}else{$data['additional']='';}
			
			$data['id']=$id;
			//$data['kelasdir']="Kelas 7";
			$data['file']=$arrdir;
			$data['filek13']=$arrdirk13;
			$data['jenjang']=$this->session->userdata('ak_setting')['jenjang'][0]['nama'];
			//pr($arrdir);die('/home/studoid1/public_html/studentbookgit/upload/contentsekolah/'.$this->session->userdata('ak_setting')['jenjang'][0]['nama'].'');
			$data['main']= 'akademik/bahanajar/guru';
            $this->load->view('layout/ad_blank',$data);			
        }    

    }
?>