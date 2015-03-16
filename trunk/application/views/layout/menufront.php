<!-- **Top-Menu** -->
            <div id="top-menu">
                <div class="container">

                <ul class="menu">
                <li class="home">  <span class="hoverL"> <span class="hoverR"> </span> </span> <a href="<?=site_url('homepage/index/1')?>" title=""> Home </a></li> 
                <?if(!$this->session->userdata('user_authentication')){?>
				<li class="current_page_item"> <span class="hoverL"> <span class="hoverR"> </span> </span> <a href="<?=site_url('sos/sekolah/daftar_sekolah')?>" title=""> Daftar Sekolah </a></li> 
				<li class="current_page_item rightf"> <span class="hoverL"> <span class="hoverR"> </span> </span> <a style="cursor:pointer;" title=""> Log In </a></li> 
				<? }else{
								$cek = session_data();
								if(empty($cek)) {
									$cek = '';
								}
								$user = DataUser();
								
									if(empty($user->foto)) {
										@$user->foto = 'asset/default/images/no_profile.jpg';
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
                <!--<li> <span class="hoverL"> <span class="hoverR"> </span> </span> <a href="<?=site_url('homedata/artikel')?>" title=""> Artikel </a></li> -->
						<li class="current-menu-item"><a href="<?=site_url('homedata/artikel/detailmenu/23')?>">TENTANG</a></li>
						<li class="current-menu-item"><a href="<?=site_url('homedata/artikel/detailmenu/24')?>">KEBIJAKAN</a></li>
						<li class="current-menu-item"><a href="<?=site_url('homedata/artikel/detailmenu/25')?>">KETENTUAN</a></li>
						<li class="current-menu-item"><a href="<?=site_url('homedata/artikel/detailmenu/26')?>">STANDART ETIKA</a></li>
                
				
            </ul>
                </div>
            </div>
			<? //print_r($this->session->userdata('user_authentication'))?>
	<?=print_notification();?>
        <!-- **Top-Menu - End** -->