<!-- **Top-Menu** -->
            <div id="top-menu">
                <div class="container">

                <ul class="menu">
                <li class="home">  <span class="hoverL"> <span class="hoverR"> </span> </span> <a href="<?=site_url()?>" title=""> Home </a></li> 
                <?if(!$this->session->userdata('user_authentication')){?>
				 
				<li class="current_page_item rightf"> <span class="hoverL"> <span class="hoverR"> </span> </span> <a style="cursor:pointer;" title=""> Log In </a></li> 
				<? }else{
								$cek = session_data();
								if(empty($cek)) {
									$cek = '';
								}
								$user = DataUser();
								
									if(empty($user->foto)) {
										$user->foto = 'asset/default/images/no_profile.jpg';
									}
									
									if($cek['otoritas']=='siswa') {
										$url_redirect = site_url('siswa');
									}elseif($cek['otoritas']=='ortu') {
										$url_redirect = site_url('ortu');
									}elseif($cek['otoritas']=='guru'){
										$url_redirect = site_url('sos/pegawai/');
									}elseif($cek['otoritas']=='superadmin'){
										$url_redirect = site_url('superadmin/super/');
									}elseif($cek['otoritas']=='admin sekolah'){
										$url_redirect = site_url('admin/schooladmin');
									}elseif($cek['otoritas']=='admin'){
										$url_redirect = site_url('/adminsb/admin');
									}
									//pr($url_redirect);
								?>
								<li class="current_page_item rightf"> <span class="hoverL"> <span class="hoverR"> </span> </span> <a style="cursor:pointer;" href="<?=$url_redirect?>" title=""> Dashboard </a></li>
								<li class="current_page_item rightf"> <span class="hoverL"> <span class="hoverR"> </span> </span> <a style="cursor:pointer;" href="<?php echo base_url();?>admin/login/logout" title=""> Keluar </a></li>
				<? } ?>

						
						<li class="current-menu-item"><a href="<?=site_url('sos/sekolah/detail_sekolah/'.$id_sekolah.'')?>">Home</a>
						<li class="current-menu-item"><a href="<?=site_url('contentsekolah/'.$id_sekolah.'')?>">Profile</a>
							<ul>
								<li> <a href="<?=site_url('contentsekolah/'.$id_sekolah.'/Visi_Misi')?>" title=""> Visi & Misi </a> </li>
								<li> <a href="<?=site_url('contentsekolah/'.$id_sekolah.'/Tujuan')?>" title=""> Tujuan </a> </li>
								<li> <a href="<?=site_url('contentsekolah/'.$id_sekolah.'/Motto')?>" title=""> Motto </a> </li>
								<li> <a href="<?=site_url('contentsekolah/'.$id_sekolah.'/Sejarah')?>" title=""> Sejarah </a> </li>
								<li> <a href="<?=site_url('contentsekolah/'.$id_sekolah.'/Komite')?>" title=""> Komite Sekolah </a> </li>
						<li class="current-menu-item"><a href="<?=site_url('contentsekolah/'.$id_sekolah.'/Fasilitas')?>">Fasilitas</a></li>
						<li class="current-menu-item"><a href="<?=site_url('contentsekolah/'.$id_sekolah.'/Program')?>">Program</a></li>
							</ul>  
						</li>
						<li class="current-menu-item"><a href="<?=site_url('contentsekolah/'.$id_sekolah.'/Kurikulum')?>">Akadmik</a>
							<ul>
								<li> <a href="<?=site_url('contentsekolah/'.$id_sekolah.'/Kurikulum')?>" title=""> Kurikulum </a> </li>
								<li> <a href="<?=site_url('contentsekolah/'.$id_sekolah.'/Metode')?>" title=""> Metode </a> </li>
								<li> <a href="<?=site_url('contentsekolah/'.$id_sekolah.'/Target')?>" title=""> Target </a> </li>
								<li> <a href="<?=site_url('contentsekolah/'.$id_sekolah.'/Ekstrakurikuler')?>" title=""> Ekstrakurikuler </a> </li>
							</ul> </li>
						<li class="current-menu-item"><a href="<?=site_url('contentsekolah/'.$id_sekolah.'/Guru')?>">Staff</a>
							<ul>
								<li> <a href="<?=site_url('contentsekolah/'.$id_sekolah.'/Guru')?>" title=""> Guru </a> </li>
								<li> <a href="<?=site_url('contentsekolah/'.$id_sekolah.'/Karyawan')?>" title=""> Karyawan </a> </li>
							</ul>  
						</li>
						<li class="current-menu-item"><a href="<?=site_url('contentsekolah/'.$id_sekolah.'/Prestasi')?>">Prestasi</a></li>
						<li class="current-menu-item"><a href="<?=site_url('contentsekolah/'.$id_sekolah.'/Kepala_Sekolah')?>">Kepsek</a></li>
                
				
            </ul>
                </div>
            </div>
	<?=print_notification();?>
        <!-- **Top-Menu - End** -->