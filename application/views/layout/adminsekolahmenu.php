					<?
					$fitur=fitur_sekolah();
					?>
					<ul class="side-nav">						
                    	<li <? if($this->router->class=='schooladmin' && $this->router->method=='ubahpassword'){echo 'class="current_page_item"';}?>> <a href="<?=site_url()?>admin/schooladmin/ubahpassword" title=""> Ubah Password Admin <span> </span> </a> </li>
                    	<li <? if($this->router->class=='schooladmin' && $this->router->method=='dataakun'){echo 'class="current_page_item"';}?>> <a href="<?=site_url()?>admin/schooladmin/dataakun" title="">Data Akun<span> </span> </a> </li>
                    	<li <? if($this->router->class=='kepsek' && $this->router->method=='index'){echo 'class="current_page_item"';}?>> <a target="__blank" href="<?=site_url()?>akademik/kepsek/index" title=""> Data Monitor Guru<span> </span> </a> </li>
                    	<li <? if($this->router->class=='schooladmin' && $this->router->method=='hp_guru'){echo 'class="current_page_item"';}?>> <a href="<?=site_url()?>admin/schooladmin/hp_guru" title=""> Guru <span> </span> </a> </li>
						<? if($this->session->userdata['ak_setting']['jenjang'][0]['bentuk']=='TK'){?>
                    	<li <? if($this->router->class=='penghubungortutk' && $this->router->method=='addcontent'){echo 'class="current_page_item"';}?>> <a href="<?=site_url()?>admin/penghubungortutk/addcontent" title=""> Setting Laporan Penilaian TK<span> </span> </a> </li>
                    	<li <? if($this->router->class=='penghubungortutk' && $this->router->method=='addcontenttpa'){echo 'class="current_page_item"';}?>> <a href="<?=site_url()?>admin/penghubungortutk/addcontenttpa" title=""> Setting Laporan Penilaian TPA<span> </span> </a> </li>
                    	<li <? if($this->router->class=='penghubungortutk' && $this->router->method=='addcontentmenu'){echo 'class="current_page_item"';}?>> <a href="<?=site_url()?>admin/penghubungortutk/addcontentmenu" title=""> Setting Menu Makanan<span> </span> </a> </li>
						<? } ?>
                        <li <? if($this->router->class=='sekolah' && $this->router->method=='editprofil'){echo 'class="current_page_item"';}?>> <a href="<?=site_url()?>admin/sekolah/editprofil" title="" id="ta"> Profil Sekolah <span> </span> </a> </li>
                        <li <? if($this->router->class=='content' && $this->router->method=='index'){echo 'class="current_page_item"';}?>> <a href="<?=site_url()?>admin/content/index" title="" id="ta"> Content Sekolah <span> </span> </a> </li>
						<? if($fitur[$this->session->userdata['user_authentication']['id_sekolah']]['sms_blasting']['aktif']==1){?>
                        <li <? if($this->router->class=='sms' && $this->router->method=='sms'){echo 'class="current_page_item"';}?>> <a href="<?=site_url()?>admin/sms/sms" title="" id="ta"> SMS Blasting <span> </span> </a> </li>
						<? } ?>
                        <li <? if($this->router->class=='setting' && $this->router->method=='tahunAjaran'){echo 'class="current_page_item"';}?>> <a href="<?=site_url()?>admin/setting/tahunAjaran" title="" id="ta"> Tahun Ajaran <span> </span> </a> </li>
                        <li <? if($this->router->class=='setting' && $this->router->method=='semester'){echo 'class="current_page_item"';}?>> <a href="<?=site_url()?>admin/setting/semester" title="" id="semester"> Semester <span> </span> </a> </li>
                        <li <? if($this->router->class=='kelas' && $this->router->method=='index'){echo 'class="current_page_item"';}?>> <a href="<?=site_url()?>admin/kelas/index" title="" id="kelas"> Kelas  <span> </span> </a> </li>
                        <li <? if($this->router->class=='kelas' && $this->router->method=='walikelas'){echo 'class="current_page_item"';}?>> <a href="<?=site_url()?>admin/kelas/walikelas" title="" id="walikelas"> Wali Kelas  <span> </span> </a> </li>
						<? if($this->session->userdata['ak_setting']['jenjang'][0]['nama']!='SD' && $this->session->userdata['ak_setting']['jenjang'][0]['nama']!='SMP'){?>
                        <li <? if($this->router->class=='jurusan' && $this->router->method=='index'){echo 'class="current_page_item"';}?>> <a href="<?=site_url()?>admin/jurusan/index" title="" id="jurusanmenu"> Jurusan <span> </span> </a> </li>
						<? } ?>
                        <li <? if($this->router->class=='pelajaran' && $this->router->method=='index'){echo 'class="current_page_item"';}?>> <a href="<?=site_url()?>admin/pelajaran/index" title="" id="pelajaranmenu"> Pelajaran <span> </span> </a> </li>
                        <li <? if($this->router->class=='pengajaran' && $this->router->method=='index'){echo 'class="current_page_item"';}?>> <a href="<?=site_url()?>admin/pengajaran/index" title=""> Tugas Pengajaran <span> </span> </a> </li>
                        <li <? if($this->router->class=='jadwal' && $this->router->method=='index'){echo 'class="current_page_item"';}?>> <a href="<?=site_url()?>admin/jadwal/index" title=""> Jadwal Pelajaran <span> </span> </a> </li>
                        <li <? if($this->router->class=='extrakurikuler' && $this->router->method=='index'){echo 'class="current_page_item"';}?>> <a href="<?=site_url()?>admin/extrakurikuler/index" title=""> Ekstrakurikuler <span> </span> </a> </li>
                        <li <? if($this->router->class=='extrakurikuler' && $this->router->method=='daftar'){echo 'class="current_page_item"';}?>> <a href="<?=site_url()?>admin/extrakurikuler/daftar" title=""> Pendaftaran Ekstrakurikuler<span> </span> </a> </li>
                        <li <? if($this->router->class=='calender' && $this->router->method=='index'){echo 'class="current_page_item"';}?>> <a href="<?=site_url()?>admin/calender/index" title=""> Kalender Akademik <span> </span> </a> </li>
                        <li <? if($this->router->class=='kegiatan' && $this->router->method=='index'){echo 'class="current_page_item"';}?>> <a href="<?=site_url()?>admin/kegiatan/index" title=""> Pengembangan Diri <span> </span> </a> </li>
                        <!--<li <? if($this->router->class=='schooladmin' && $this->router->method=='formulasinilaiakhir'){echo 'class="current_page_item"';}?>> <a href="<?=site_url()?>admin/schooladmin/formulasinilaiakhir" title=""> Formulasi Nilai <span> </span> </a> </li>-->
                        <li <? if($this->router->class=='nilaikkm' && $this->router->method=='index'){echo 'class="current_page_item"';}?>> <a href="<?=site_url()?>admin/nilaikkm/index" title=""> Nilai KKM <span> </span> </a> </li>
                        <li <? if($this->router->class=='raport' && $this->router->method=='setting'){echo 'class="current_page_item"';}?>> <a href="<?=site_url()?>admin/raport/setting" title=""> Setting Raport <span> </span> </a> </li>
                        <li <? if($this->router->class=='setting' && $this->router->method=='aspekkepribadian'){echo 'class="current_page_item"';}?>> <a href="<?=site_url()?>admin/setting/aspekkepribadian" title=""> Aspek Kepribadian <span> </span> </a> </li>
                        <li <? if($this->router->class=='raport' && $this->router->method=='setkenaikanindex'){echo 'class="current_page_item"';}?>> <a href="<?=site_url()?>admin/raport/setkenaikanindex" title=""> Kenaikan & Kelulusan <span> </span> </a> </li>
                        <!--<li <? if($this->router->class=='schooladmin' && $this->router->method=='kelulusan'){echo 'class="current_page_item"';}?>> <a href="<?=site_url()?>admin/schooladmin/kelulusan" title=""> Kelulusan  <span> </span> </a> </li>-->
                    </ul>