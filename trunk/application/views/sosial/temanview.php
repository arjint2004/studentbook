<?php $this->load->view('sosial/function_pegawai'); ?>
<script>
    $(function(){
        $(".deskripsi_group").live('click change focus',function(){
            alert('oke');
            $(this).val(''); 
        });
    })
</script>
<div class="portfolio column-one-half-with-sidebar">
<?=print_iklan();?>
<h2 class="float-left">JEJARING SOSIAL</h2>
<div class="tabs-container">
    <ul class="tabs-frame-asbin">
        <li><a onclick="$('form#statusa').submit();" onclick="#" class="<?if($statusload=='block'){echo'current';}elseif(!isset($_POST['pertload'])){echo'current';}?>">Status</a><form action="" id="statusa" method="post"><input type="hidden" name="pertload" value="statusload" /></form></li>
        <li><a class="<?if($temanload=='block'){echo'current';}?>" onclick="$('form#temana').submit();">Teman</a><form action="" id="temana" method="post"><input type="hidden" name="pertload" value="temanload" /></form></li>
        <li><a class="<?if($groupload=='block'){echo'current';}?>" onclick="$('form#groupa').submit();" href="#">Group</a><form action="" id="groupa" method="post"><input type="hidden" name="pertload" value="groupload" /></form></li>
        <li><a class="<?if($acaraload=='block'){echo'current';}?>" onclick="$('form#acaraa').submit();" href="#">Acara</a><form action="" id="acaraa" method="post"><input type="hidden" name="pertload" value="acaraload" /></form></li>
        <li><a class="<?if($catatanload=='block'){echo'current';}?>" onclick="$('form#catatana').submit();" href="#">Catatan</a><form action="" id="catatana" method="post"><input type="hidden" name="pertload" value="catatanload" /></form></li>
    </ul>
    <div class="tabs-frame-content" style="display: <?=$statusload?>;background: #f2f2f2;">
                <div class="status_style">
                    <div class="workplace">     
                        <div class="row-fluid">
                            <div class="span12">
                                <div class="head clearfix">
                                    <div class="isw-chats"></div>
                                    <h1>Status Terbaru Anda</h1>
                                </div>
                                <div class="block messaging">
                                    <form method="post" id="update_status" action="<?=site_url('sos/pegawai/set_status')?>" enctype='multipart/form-data'>
                                    <input type="hidden" name="id_pegawai" value="<?=$pegawai->id_user?>" id="id_pegawai"/>
                                    <div class="controls">
                                        <div class="control">
                                            <textarea name="textarea" placeholder="Tulis Status..." name="status_text" id="status_text" style="height: 70px; width: 100%;background: white;"></textarea>
                                            <input type="hidden" name="gambar" id="gambar"/>
                                            <input type="hidden" name="profilrpoto" id="profilrpoto" value="<?=$pegawai->foto?>"/>
                                            <div id="file_upload" class="left"></div>
                                            <div class="left">
                                                <img src="<?=$this->config->item('images').'upload.ico';?>" id="icon_upload" title="Upload Your Image" class="tooltip" width="20" style="margin: 0px;cursor: pointer;" />    
                                                <input type="file" id="image_upload" name="images" style="opacity: 0"/>
                                                <img id="loading" src="<?=$this->config->item('images').'loading.gif';?>" style="display:none;">
                                            </div>
                                        </div>
                                    </div>
                                    </form>
                                </div>
                            </div>                                                
                        </div>        
                    </div>
                </div>
                
                <div class="status_style">
                    <div class="workplace">     
                        <div class="row-fluid">
                            <div class="span12">
                                <div class="head clearfix">
                                    <div class="isw-chats"></div>
                                    <h1>Status Terbaru</h1>
                                </div>
                                <div class="block messaging blok_message scrollbar" id="style-6">
                                    <div class="show_status">
                   
                                    </div>                     
                                    <?php if(!empty($status_pegawai)) {
                                        foreach($status_pegawai['status'] as $stat_item){
                                            
                                            if(empty($stat_item->foto)) {
                                                $stat_item->foto = 'asset/default/images/no_profile.jpg';
                                            }
                                        ?>
                                            <div class="itemOut status_parent" id="hapusstatus_<?=$stat_item->id_status?>">
                                                <a href="<?=base_url($stat_item->foto)?>" class="prev_image image"><img src="<?=base_url($stat_item->foto)?>" alt="" title="" width="50" class="img-polaroid"/></a>
                                                <div class="text">
                                                    <?php
                                                        if($stat_item->id_foto==0) {
                                                            if($stat_item->id==$pegawai->id_user) {
                                                                $hps_link = '<span class="delete_status tooltip" title="Delete" id="status_'.$stat_item->id_status.'">x</span>';
                                                            }else{
                                                                $hps_link = '';
                                                            }
                                                            echo '<div class="info clearfix">
                                                                        <span class="name"><a href="'.site_url('sos/user/view_profile/'.$stat_item->id).'">'.(!empty($stat_item->nama_pegawai) ? $stat_item->nama_pegawai : $stat_item->nama_siswa).'</a></span>
                                                                        <span class="date">'.CheckTime($stat_item->tgl_status).$hps_link.'</span>
                                                                    </div>';
                                                            echo '<p>'.MessageCheck($stat_item->pesan).'</p>';
                                                        }
                                                        else
                                                        {
                                                            if($stat_item->id==$pegawai->id_user) {
                                                                $hps_link = '<span class="delete_status tooltip" title="Delete" id="status_'.$stat_item->id_status.'">x</span>';
                                                            }else{
                                                                $hps_link = '';
                                                            }
                                                            echo '<div class="info clearfix">
                                                                <span class="name"><a href="'.site_url('sos/user/view_profile/'.$stat_item->id).'">'.(!empty($stat_item->nama_pegawai) ? $stat_item->nama_pegawai : $stat_item->nama_siswa).'</a></span>
                                                                <span class="date">'.CheckTime($stat_item->tgl_status).$hps_link.'</span>
                                                            </div>';
                                                            echo '<p>'.MessageCheck($stat_item->pesan).'</p>
                                                            <a href="'.base_url($stat_item->large).'" class="prev_image"><img src="'.base_url($stat_item->small).'"/></a>';
                                                        }
                                                    ?>
                                                </div>
                                                <!-- komentar -->
                                                <?php
                                                    $status_cek = false;
                                                    if(!empty($status_pegawai['komentar'])){
                                                        foreach($status_pegawai['komentar'] as $idx=>$kom_item) {
                                                            if($idx==$stat_item->id_status) {
                                                                foreach($kom_item as $val){
                                                                $status_cek = true;
                                                                if($val->id==$pegawai->id_user) {
                                                                    $hps_link = '<span class="delete_status tooltip" title="Delete" id="komentar_'.$val->id_komen.'">x</span>';
                                                                }else{
                                                                    $hps_link = '';
                                                                }
                                                                if(empty($val->foto)) {
                                                                    $val->foto = 'asset/default/images/no_profile.jpg';
                                                                }
                                                                ?>
                                                                    <div class="row-fluid komentar_user" id="hapuskomentar_<?=$val->id_komen?>">
                                                                        <div class="span2"></div>
                                                                        <div class="span10">
                                                                            <div class="itemOut">
                                                                                <a href="<?=base_url($val->foto)?>" class="prev_image image"><img src="<?=base_url($val->foto)?>" width="50" class="img-polaroid"/></a>
                                                                                <div class="text">
                                                                                    <div class="info clearfix">
                                                                                        <span class="name"><a href="<?=site_url('sos/user/view_profile/'.$val->id)?>"><?=(!empty($val->nama_pegawai) ? $val->nama_pegawai : $val->nama_siswa)?></a></span>
                                                                                        <span class="date"><?=CheckTime($val->tgl_komen)?><?=$hps_link?></span>
                                                                                    </div>                                
                                                                                    <p><?=MessageCheck($val->komentar)?></p>
                                                                                </div>
                                                                            </div>                                        
                                                                        </div>
                                                                    </div>
                                                                <?php
                                                                }
                                                                echo '<div id="'.$stat_item->id_status.'"></div>';
                                                            }
                                                        }
                                                    }
                                                ?>
                                
                                                <?php
                                                if($status_cek)
                                                {
                                                ?>
                                                    <div class="komentar_user" id="hapusstatus_<?=$stat_item->id_status?>">                            
                                                        <div class="span2"></div>
                                                        <div class="span10">
                                                            <form method="POST" id="komentar" action="<?=site_url('sos/pegawai/set_komentar')?>">
                                                                <div class="itemOut">
                                                                    <div class="controls">
                                                                        <div class="control">
                                                                            <textarea name="komentar" class="komentar_teks" placeholder="Komentar anda <?=(!empty($pegawai->nama) ? $pegawai->nama : '')?>" style="height: 50px; width: 100%;background: white;"></textarea>
                                                                            <input type="hidden" name="id_pegawai" value="<?=$pegawai->id_user?>"/>
                                                                            <input type="hidden" name="id_status" value="<?=$stat_item->id_status?>"/>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <div class="hr"></div>
                                                    </div>
                                                <?php
                                                }
                                                ?>
                                                
                                                <?php
                                                if($status_cek==FALSE)
                                                {
                                    
                                                ?>
                                                    <div id="<?=$stat_item->id_status?>" id="hapusstatus_<?=$stat_item->id_status?>"></div>
                                                    <div class="komentar_user">                            
                                                        <div class="span2">
                                                        </div>
                                                        <div class="span10">
                                                            <form method="POST" id="komentar" action="<?=site_url('sos/pegawai/set_komentar')?>">
                                                                <div class="itemOut">
                                                                    <div class="controls">
                                                                        <div class="control">
                                                                            <textarea name="komentar" class="komentar_teks" placeholder="Komentar anda <?=(!empty($pegawai->nama) ? $pegawai->nama : '')?>" style="height: 50px; width: 100%;background: white;"></textarea>
                                                                            <input type="hidden" name="id_pegawai" value="<?=$pegawai->id_user?>"/>
                                                                            <input type="hidden" name="id_status" value="<?=$stat_item->id_status?>"/>
                                                                        </div>
                                                                    </div>
                                                                </div>    
                                                            </form>
                                                        </div>
                                                        <div class="hr"></div>
                                                    </div>
                                                <?php
                                                }
                                                ?>
                                               
                                                <!-- end komentar-->
                                            </div>
                                        <?php
                                        }
                                        echo ' <div id="last_message"></div>';
                                    }
                                ?>
                                </div>
                            </div>
                        </div>        
                    </div>
                </div>
                
    </div>
    <div class="tabs-frame-content" style="display: <?=$temanload?>;">
        <div class="row-fluid">
            <?php
                if(isset($_POST['pertload']) && $_POST['pertload']=='temanload') {
                if(!empty($ultah)) {
                    
                      echo '<div class="status_style">
                                <div class="workplace">
                                    <div class="head clearfix">
                                        <div class="isw-users"></div>
                                        <h1>Teman Yang Berulang Tahun Hari Ini</h1>
                                    </div>
                                </div>
                            </div>
                            <div id="slides_ultah">
                                <div class="slides_container">';
                                $no=0;
                                foreach($ultah as $ul){
                                    if($no==0){
                                        echo '<div class="span12 teman" style="width: 150%;margin-bottom:10px;">';
                                    }
                                    if(empty($ul->foto)) {
                                        $ul->foto = 'no_profile.jpg';
                                    }
                                    ?>
                                        <div class="span4 left prev_image">
                                            <img src="<?=base_url($ul->foto)?>" width="50" class="float-left"/>
                                            <span class="title_user">
                                                <a href="<?=site_url('sos/user/view_profile/'.$ul->id)?>" class="span7 nama"><?=$ul->nama?></a>
                                                <a class="span7 ucapan">Tulis Ucapan</a>
                                            </span>
                                        </div>
                                    <?php
                                    $no++;
                                    if($no==3){
                                        echo '</div>';
                                        $no=0;
                                    }    
                                }
                                if($no<3 and $no!=0){
                                    echo '</div>';
                                }
                        echo '</div>
                        </div>';
                }
            ?>
        </div>
        <div class="row-fluid">
            <div class="span12" id="style-6" style="height:auto;">
                <div class="status_style">
					<div class="workplace">
						<div class="head clearfix">
							<div class="isw-users"></div>
							<h1>Daftar Teman</h1>
						</div>
					</div>
				</div>
            </div>
			<div class="span12 teman" style="margin:7px;margin-left:0px;">
				<?php   
					if(!empty($teman)) {

						$no=0;
						foreach($teman as $tmn) {
							if(empty($tmn->images)) {
								$tmn->images = 'asset/default/images/no_profile.jpg';
							}
							?>
								<div class="span4 datalist_user no_margin">
									<div class="span4">
										<img src="<?=base_url($tmn->images)?>" width="50" class="img-polaroid"/>
									</div>
									<div class="span8 left">
										<a style="font-size:smaller;" href="<?=site_url('sos/user/view_profile/'.$tmn->id_teman)?>" class="span12"><?=ucfirst(strtolower((!empty($tmn->nama_pegawai) ? $tmn->nama_pegawai : $tmn->nama_siswa)))?></a>
										<span>
											<a href="<?=site_url('sos/pegawai/hapus_pertemanan/'.$tmn->id_teman)?>">Hapus |</a>
											<a href="<?=site_url('sos/pegawai/blokir_pertemanan/'.$tmn->id_teman)?>">Blokir</a>
										</span>
									</div>
								</div>
							<?php
						}
					}
				?>
			</div>
        </div>
        <div class="row-fluid">
            <?php
                if(!empty($permintaan)){
                    echo '<div class="status_style">
                                <div class="workplace">
                                    <div class="head clearfix">
                                        <div class="isw-users"></div>
                                        <h1>Permintaan Teman</h1>
                                    </div>
                                </div>
                            </div>';
                    $no=0;
                    
                    foreach($permintaan as $pr){
                        if($no==0){
                            echo '<div class="span12 permintaan" style="margin:10px 0;">';
                        }
                        if(empty($pr->images)) {
                            $pr->images = 'asset/default/images/no_profile.jpg';
                        }
                        ?>
                            <div class="span4 datalist_user no_margin">
                                <div class="span4">
                                    <img width="50" class="img-polaroid" src="<?=base_url($pr->images)?>">
                                </div>
                                <div class="span8 left">
                                    <a href="<?=site_url('sos/user/view_profile/'.$pr->id_user)?>" class="span12 nama"><?=(!empty($pr->nama_pegawai) ? $pr->nama_pegawai : $pr->nama_siswa)?></a>
                                    <span>
                                        <a href="<?=site_url('sos/pegawai/terima_permintaan/'.$pr->id_user)?>" class="span5 ucapan confirm">Terima |</a> 
                                        <a href="<?=site_url('sos/pegawai/tolak/'.$pr->id_user)?>" class="span5 ucapan confirm">Tolak</a>
                                    </span>
                                </div>
                            </div>
                        <?php
                        $no++;
                        if($no==3){
                            echo '</div>';
                            $no=0;
                        }
                    }
                    if($no<3 and $no!=0){
                        echo '</div>';
                    }
                }
            ?>
        </div>
        <div class="row-fluid">
            <form method="POST" id="form_add_all_user" action="<?=site_url('sos/pegawai/add_all_friend')?>">
            <?php
                if(!empty($orang_dikenal['pegawai_dikenal']) or !empty($orang_dikenal['siswa_dikenal']))
                {
                    
                    echo '<div class="scrollbar_upload span12" id="style-6">';
                    echo '<div class="status_style">
                            <div class="workplace">
                                <div class="head clearfix">
                                    <div class="isw-users"></div>
                                    <h1><input type="checkbox" class="check_all_user"/> Orang mungkin anda dikenal </h1>
                                </div>
                            </div>
                        </div>';
                }else{
                    echo '<div>';
                }
				?>
				
				<div class="styled-elements">
				<h2></h2>
				<div class="tabs-container">
				<script>
					$(document).ready(function(){
									$("ul.tabs-frame li#temanlainsek").click(function(){
												var obj=$(this);
												$.ajax({
													type: "POST",
													data: '',
													url: base_url+'sos/pegawai/temanlainsekolah',
													beforeSend: function() {
														$(obj).append("<img id='wait' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
													},
													success: function(msg) {
														$("#wait").remove();	
														
													}
												});
									});	
					});
				</script>
					<ul class="tabs-frame">
                        <li><a style="cursor:pointer;">Satu Sekolah</a></li>
                        <li id="temanlainsek"><a style="cursor:pointer">Sekolah Lain</a></li>
                    </ul>
					<div class="tabs-frame-content">
						<?
						$no=0;
						$master_teman = '';
						$friend = '';
						echo '<ul class="teman">';
						if(!empty($orang_dikenal['pegawai_dikenal'])) {
							$cek = false;
							foreach($orang_dikenal['pegawai_dikenal'] as $od){
								if(!empty($pending)) {
									if(in_array($od->id,$pending)){
									   $cek = true; 
									}else{
										$cek = false;
									}
								}
								if(empty($od->foto)){$od->foto='asset/default/images/no_profile.jpg';}
								$friend .= '<li>
												<img src="'.base_url($od->foto).'" width="32" class="img-polaroid">
											
												<div><a href="'.site_url('sos/user/view_profile/'.$od->id).'" target="_blank" class="user">'.$od->nama.'</a></div>';
												if($cek){
													$friend.='<div>Menunggu Konfirmasi</div>';
												}else{
													$friend.='<div><input type="checkbox" name="id_undangan[]" class="id_user_undangan float-left" value="'.$od->id.'"/>&nbsp;<a class="add" id="'.$od->id.'" style="cursor:pointer;">+ Tambahkan Teman</a></div>';
												}    
								$friend .= '</li>';    
								$no++;
								if($no==3){
									$master_teman.='<tr>'.$friend.'</tr>';
									$friend = '';
									$no=0;
								}
							}

						}
						
						if(!empty($orang_dikenal['siswa_dikenal'])) {
							$cek_siswa = false;
							foreach($orang_dikenal['siswa_dikenal'] as $od){
								if(!empty($pending)) {
									if(in_array($od->id,$pending)){
									   $pegawai_cek = true; 
									}else{
										$pegawai_cek = false;
									}
								}
								if(empty($od->foto)){$od->foto='asset/default/images/no_profile.jpg';}
								$friend .= '<li>
												<a href="#"><img src="'.base_url($od->foto).'" width="32" class="img-polaroid"></a>
										   
												<div><a href="'.site_url('sos/user/view_profile/'.$od->id).'" target="_blank" class="user">'.$od->nama.'</a></div>';
												if($cek_siswa){
													$friend.='<div>Menunggu Konfirmasi</div>';
												}else{
													$friend.='<div><input type="checkbox" name="id_undangan[]" class="id_user_undangan float-left" value="'.$od->id.'"/>&nbsp;<a class="add" id="'.$od->id.'">+ Tambahkan Teman</a></div>';
												}    
								$friend .= '</li>';    
								$no++;
								if($no==3){
									$master_teman.=''.$friend.'';
									$friend = '';
									$no=0;
								}          
							}
						}

						if($no==1){
							echo $master_teman;
							echo ''.$friend.'';
						}elseif($no==2){
							echo $master_teman;
							echo ''.$friend.'';
						}else{
							echo $master_teman;
						}
						echo '</ul>';
					?>
					</div>
                    <div class="tabs-frame-content">
                            
                    </div>
            </div>
            </div>
             <?php
                //if($no>0) {
                    //echo '<button class="button small lightblue float-right" id="add_all_friend">+ Tambahkan Semua</button>';
                //}
            ?>
            </form>
            </div>
			<? } ?>
            </div>

    </div>
    <div class="tabs-frame-content" style="display: <?=$groupload?>;">
        <? if(isset($_POST['pertload']) && $_POST['pertload']=='groupload') {?>
		<div class="row-fluid">
            <div class="span12 right">
                <a class="button small lightgrey" id="buat_group">Buat Group</a>
                <a class="button small lightgrey" id="back_group" style="display: none;">Kembali</a>
				
            </div>
        </div>
        <div class="row-fluid form_group" style="display: none;">
            <div class="span12">
                <form class="sosial" method="POST" action="<?=site_url('sos/pegawai/simpan_group')?>" enctype="multipart/form-data">
                    <div class="row-fluid">
                        <div class="status_style">
                            <div class="workplace">
                                <div class="head clearfix">
                                    <div class="isw-users"></div>
                                    <h1>Inputkan Data Group</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                    <label>Nama Group</label>
                    <input type="text" name="group" class="text-field">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi" style="min-height: 200px;" class="text-field"></textarea>
                    <label>Logo Group</label>
                    <input type="file" name="logo" class="text-field">
                    <div class="row-fluid">
                        <div class="status_style">
                            <div class="workplace">
                                <div class="head clearfix">
                                    <div class="isw-users"></div>
                                    <h1><input type="checkbox" name="check_all_group" id="check_all_group"/> | Undang Teman Anda Dalam Group</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row-fluid">
                    <?php
                        if(!empty($teman)) {
                            $no=0;
                            foreach($teman as $tmn) {
                                if($no==0){
                                    echo '<div class="span12 teman" style="margin-bottom:10px;">';
                                }
                                if(empty($tmn->foto)) {
                                    $tmn->foto = 'asset/default/images/no_profile.jpg';
                                }
                                ?>
                                     <div class="span4 datalist_user no_margin">
                                        <div class="span4">
                                            <div class="span2"><input type="checkbox" name="undang_group[<?=$tmn->id_teman?>]" class="float-left group_check" style="margin: 0px;padding-right: 10px;" value="<?=(!empty($tmn->nama_pegawai) ? $tmn->nama_pegawai : $tmn->nama_siswa)?>"/></div>
                                            <div class="span10"><img width="80" style="margin-left:10px;" class="img-polaroid" src="<?=base_url($tmn->foto)?>"></div>
                                        </div>
                                        <div class="span8 left">
                                            <a href="<?=site_url('sos/user/view_profile/'.$tmn->id)?>" class="span12 nama" style="padding-left: 25px;font-size: small;"><?=(!empty($tmn->nama_pegawai) ? $tmn->nama_pegawai : $tmn->nama_siswa)?></a>
                                        </div>
                                    </div>
                                <?php
                                $no++;
                                if($no==3){
                                    echo '</div>';
                                    $no=0;
                                }
                            }
                            if($no<3 and $no!=0){
                                echo '</div>';
                            }
                        }
                    ?>
                    </div>
                    <input type="submit" name="submit" value="Simpan Group" class="button small lightblue" style="margin-left: 30px;"/>                
                </form>
            </div>
        </div>
        <div class="row-fluid list_group">
            <?php
                if(!empty($group_anda)) {
                    echo '<div class="status_style">
                            <div class="workplace">
                                <div class="head clearfix">
                                    <div class="isw-users"></div>
                                    <h1>Daftar Group Yang Anda Buat</h1>
                                </div>
                            </div>
                        </div>';
                    $master_group   = '';
                    $gr_group       = '';
                    $no = 0;
                    foreach($group_anda as $gr) {
                        if(empty($gr->logo)) {
                            $gr->logo = 'asset/default/images/no_profile.jpg';
                        }
                        $gr_group .= '<div class="span4 datalist_user no_margin">
                                        <div class="span4">
                                            <img src="'.base_url($gr->logo).'" width="50" class="img-polaroid"/>
                                        </div>
                                        <div class="span8 left">
                                            <a href="'.site_url('sos/group/view/'.$gr->id_group).'" class="span12">'.ucfirst(strtolower($gr->nama_group)).'</a>
                                            <span style="font-size:smaller;">';
                                                $kt = explode(' ',$gr->deskripsi);
                                                if(!empty($kt) and count($kt)>5) {
                                                    for($i=0;$i<count($kt);$i++) {
                                                        if($i<=5) {
                                                            $gr_group .= $kt[$i]." ";
                                                        }
                                                    }
                                                    $gr_group.=" ...";
                                                }else{
                                                    $gr_group .= $gr->deskripsi;
                                                }
                                            $gr_group.='</span>
                                        </div>
                                    </div>';
                        $no++;
                        if($no==3) {
                            $master_group .= '<div class="span12" style="margin:0px;margin-top:10px;margin-bottom:5px;">'.$gr_group.'</div>';
                            $gr_group = '';
                            $no=0;
                        }
                    }
                    if($no<3) {
                        echo $master_group;
                        echo '<div class="span12" style="margin:0px;margin-top:10px;margin-bottom:5px;">'.$gr_group.'</div>';
                    }else{
                        echo $master_group;
                    }
                }else{
                    //echo '<p style="text-align:center;">Anda Belum Memiliki Group</p>';
                }
            ?>
        </div>
        <div class="row-fluid list_group">
            <?php
                if(!empty($group_diikuti)) {
                    echo '<div class="status_style">
                            <div class="workplace">
                                <div class="head clearfix">
                                    <div class="isw-users"></div>
                                    <h1>Group Yang Anda Ikuti</h1>
                                </div>
                            </div>
                        </div>';
                    $master_group   = '';
                    $gr_group       = '';
                    $no = 0;
                    foreach($group_diikuti as $ug) {
                        if(empty($ug->logo)) {
                            $ug->logo = 'asset/default/images/no_profile.jpg';
                        }
                        $gr_group .= '<div class="span4 datalist_user no_margin">
                                        <div class="span4">
                                            <img src="'.base_url($ug->logo).'" width="50" class="img-polaroid"/>
                                        </div>
                                        <div class="span8 left">
                                            <a href="'.site_url('sos/group/view/'.$ug->id_group).'" class="span12 no_margin">'.ucfirst(strtolower($ug->nama_group)).'</a>
                                            <span class="span12">';
                                                $kt = explode(' ',$ug->deskripsi);
                                                for($i=0;$i<count($kt);$i++) {
                                                    if($i<=20) {
                                                        $gr_group .= $kt[$i]." ";
                                                    }
                                                }                
                                            $gr_group.='</span>
                                            <span class="span12">
                                                <a href="'.site_url('sos/pegawai/keluar_group/'.$ug->id_group).'" class="button small lightblue" style="margin-left:0px;margin-top:5px;">Keluar Group</a>
                                            </span>
                                        </div>
                                    </div>';
                        $no++;
                        if($no==3) {
                            $master_group .= '<div class="span12" style="margin:0px;">'.$gr_group.'</div>';
                            $gr_group = '';
                            $no=0;
                        }
                    }
                    if($no<3) {
                        echo $master_group;
                        echo '<div class="span12" style="margin:0px;">'.$gr_group.'</div>';
                    }else{
                        echo $master_group;
                    }
                }else{
                    //echo '<p style="text-align:center;">Anda Belum Memiliki Group</p>';
                }
            ?>
        </div>
        
        <div class="row-fluid">
            <?php
                if(!empty($undangan_group)) {
                    echo '<div class="status_style">
                            <div class="workplace">
                                <div class="head clearfix">
                                    <div class="isw-users"></div>
                                    <h1>Anda Diundang Dalam Group</h1>
                                </div>
                            </div>
                        </div>';
                    $master_group   = '';
                    $gr_group       = '';
                    $no = 0;
                    foreach($undangan_group as $ug) {
                        if(empty($ug->logo)) {
                            $ug->logo = 'asset/default/images/no_profile.jpg';
                        }
                        $gr_group .= '<div class="span4 datalist_user no_margin">
                                        <div class="span4">
                                            <img src="'.base_url($ug->logo).'" width="50" class="img-polaroid"/>
                                        </div>
                                        <div class="span8 left">
                                            <a href="#" class="span12">'.ucfirst(strtolower($ug->nama_group)).'</a>
                                            <span class="span12" style="font-size:small;">';
                                                $kt = explode(' ',$ug->deskripsi);
                                                if(!empty($kt) and count($kt)>5) {
                                                    for($i=0;$i<count($kt);$i++) {
                                                        if($i<=5) {
                                                            $gr_group .= $kt[$i]." ";
                                                        }
                                                    }
                                                }else{
                                                    $gr_group.= $ug->deskripsi;
                                                }
                                            $gr_group.='</span>
                                            <span class="span12">
                                                <a href="'.site_url('sos/pegawai/terima_group/'.$ug->id_group).'"> Terima </a>
                                                 | <a href="'.site_url('sos/pegawai/tolak_group/'.$ug->id_group).'"> Tolak </a>
                                            </span>
                                        </div>
                                    </div>';
                        $no++;
                        if($no==3) {
                            $master_group .= '<div class="span12" style="margin:0px;">'.$gr_group.'</div>';
                            $gr_group = '';
                            $no=0;
                        }
                    }
                    if($no<3) {
                        echo $master_group;
                        echo '<div class="span12" style="margin:0px;">'.$gr_group.'</div>';
                    }else{
                        echo $master_group;
                    }
                }else{
                    //echo '<p style="text-align:center;">Anda Belum Memiliki Group</p>';
                }
            ?>
        </div>

	<? } ?>
    </div>

    <div class="tabs-frame-content" style="display: <?=$acaraload?>;">
		<? if(isset($_POST['pertload']) && $_POST['pertload']=='acaraload') {?>
        <div class="row-fluid button_acara right">
            <div class="span12">
                <input type="submit" name="submit" value="Buat Acara" id="button_acara" class="button small lightblue"/>
            </div>
        </div>
        <?php
            if(empty($acara_user) and empty($reminder_acara) and empty($undangan_acara)) {
                echo '<div class="row-fluid button_acara">
                    <div class="span12">Anda Belum Memiliki Data Acara</div>
                </div>';
            }
        ?>
        <div class="form_acara" style="display: none;">   
            <form class="sosial" method="POST" action="<?=site_url('sos/pegawai/simpan_acara')?>">
                <div class="row-fluid">
                    <div class="status_style">
                        <div class="workplace">
                            <div class="head clearfix">
                                <div class="isw-users"></div>
                                <h1>Inputkan Data Acara</h1>
                            </div>
                        </div>
                    </div>
                </div>
                <label>Nama Acara</label>
                <input type="text" name="acara" class="text-field">
                <label>Hari</label>
                <input type="text" name="hari" class="text-field">
                <label>Tanggal</label>
                <input type="text" name="tgl" class="text-field datepicker">
                <label>Jam</label>
                <input type="text" name="jam" class="text-field">
                <label>Tempat</label>
                <input type="text" name="tempat" class="text-field">
                <label>Keterangan</label>
                <input type="text" name="keterangan" class="text-field">
            <div class="row-fluid">
                <?php
                    if(!empty($teman)) {
                        echo '<div class="status_style">
                                <div class="workplace">
                                    <div class="head clearfix">
                                        <div class="isw-users"></div>
                                        <h1><input type="checkbox" class="check_all_user"/> Semua | Orang Yang Akan Diundang</h1>
                                    </div>
                                </div>
                            </div>';
                        $no=0;
                        $master_teman = '';
                        $friend = '';
                        foreach($teman as $tmn) {
                            if(empty($tmn->foto)) {
                                $tmn->foto = 'no_profile.jpg';
                            }
                            
                            $friend= '<div class="span4 left prev_image">
                                    <input type="checkbox" name="id_undangan[]" class="id_user_undangan float-left" value="'.$tmn->id_teman.'"/>
                                    <img src="'.base_url($tmn->foto).'" width="50" class="float-left"/>
                                    <span class="title_user">
                                        <a href="'.site_url('sos/user/view_profile/'.$tmn->id).'" class="span7 nama">'.$tmn->nama.'</a>
                                        <a class="span3 ucapan">Hapus |</a> 
                                        <a class="span3 ucapan">Blokir</a>
                                    </span>
                                </div>';
                            $no++;
                            if($no==3){
                                $master_teman.='<div class="span12 teman" style="margin-bottom:10px;">'.$friend.'</div>';
                                $friend = '';
                                $no=0;
                            }
                        }
                        if($no==1 or $no==2){
                            echo '<div class="span12 teman" style="margin-bottom:10px;">'.$friend.'</div>';
                        }else{
                            echo $master_teman;
                        }
                    }
                ?>
            </div>
            <input type="submit" name="submit" value="Buat Acara" class="button small lightblue"/>
            </form>
        </div>
            
        <div class="list_acara">
            <div class="row-fluid">
                <?php
                    if(!empty($acara_user)) {
                        echo '<div class="status_style">
                                <div class="workplace">
                                    <div class="head clearfix">
                                        <div class="isw-users"></div>
                                        <h1>Daftar Acara Yang Anda Buat</h1>
                                    </div>
                                </div>
                            </div>';
                        $no=0;
                        $df_acara = '';
                        $master = '';
                        foreach($acara_user as $au) {
                            $df_acara .= '<div class="span6 datalist_user no_margin">
                                                <div class="span3">
                                                    <img src="'.base_url('asset/default/images/acara_user.png').'" width="50" class="img-polaroid"/>
                                                </div>
                                                <div class="span9 left">
                                                    <a href="#" class="span12">'.ucfirst(strtolower($au->nama_acara)).'</a>
                                                    <span>
                                                        <dl style="padding:0px;" class="float-left">
                                                            <dt class="left">Tanggal</dt><dd>: '.$au->tgl_acara.'</dd>
                                                            <dt class="left">Waktu</dt><dd>: '.$au->waktu.'</dd>
                                                            <dt class="left">Tempat</dt><dd>: '.$au->tempat.'</dd>
                                                        </dl>
                                                    </span>
                                                </div>
                                            </div>';
                            $no++;
                            if($no==2){
                                $master .= '<div class="span12 no_margin" style="margin:5px;margin-left:0px;">'.$df_acara.'</div>';
                                $df_acara = '';
                                $no=0;
                            }
                        }
                        if($no==1){
                            echo '<div class="span12 no_margin" style="margin:5px;margin-left:0px;">'.$df_acara.'</div>';
                        }else{
                            echo $master;    
                        }
                    }
                ?>
            </div>
            
            <div class="row-fluid">
                <?php
                    if(!empty($undangan_acara)) {
                        echo '<div class="status_style">
                                <div class="workplace">
                                    <div class="head clearfix">
                                        <div class="isw-users"></div>
                                        <h1>Anda Diundang Dalam Acara</h1>
                                    </div>
                                </div>
                            </div>';
                        $no=0;
                        $undang         = '';
                        $master_undang  = '';
                        foreach($undangan_acara as $und) {
                            $undang .= '<div class="span6 datalist_user no_margin">
                                        <div class="span3">
                                            <img src="'.base_url('asset/default/images/acara_user.png').'" width="50" class="img-polaroid"/>
                                        </div>
                                        <div class="span9 left">
                                            <a href="#" class="span12">'.ucfirst(strtolower($au->nama_acara)).'</a>
                                            <span>
                                                <dl class="float-left">
                                                    <dt class="left">Tanggal</dt><dd>: '.$und->tgl_acara.'</dd>
                                                    <dt class="left">Waktu</dt><dd>: '.$und->waktu.'</dd>
                                                    <dt class="left">Tempat</dt><dd>: '.$und->tempat.'</dd>
                                                    <dt class="left">Pengundang</dt><dd>: '.$und->pengundang.'</dd>
                                                    <dt class="left"><a href="#" class="button small lightblue">Hadir</a></dt><dd><a href="#" class="button small lightblue" style="padding: 3px;font-weight: bold;">Tidak Hadir</a></dd>
                                                </dl>
                                            </span>
                                        </div>
                                    </div>';
                            $no++;
                            if($no==2) {
                                $master_undang .= '<div class="span12" style="margin:10px;margin-left:0px;">'.$undang.'</div>';
                                $undang = '';
                                $no=0;
                            }    
                        }
                        if($no==1){
                            echo '<div class="span12" style="margin:10px;margin-left:0px;">'.$undang.'</div>';
                        }else{
                            echo $master_undang;    
                        }
                    }
                ?>
            </div>
            
            <div class="row-fluid">
                <?php
                    if(!empty($reminder_acara)) {
                         echo '<div class="status_style">
                                <div class="workplace">
                                    <div class="head clearfix">
                                        <div class="isw-users"></div>
                                        <h1>Reminder Acara</h1>
                                    </div>
                                </div>
                            </div>';
                        $no=0;
                        $master_reminder = '';
                        $reminder = '';
                        foreach($reminder_acara as $remin) {
                            $reminder .= '<div class="span6">
                                        <div class="span2">
                                            <img src="'.base_url('asset/default/images/acara_user.png').'" width="50" class="float-left"/>
                                        </div>
                                        <div class="span10 float-left">
                                            <a href="#">
                                                <span class="title_acara float-left">
                                                    '.$remin->nama_acara.'
                                                </span>
                                            </a>
                                            <dl class="float-left">
                                                <dt class="left">Hari/Tanggal</dt><dd>: '.$remin->tgl_acara.'</dd>
                                                <dt class="left">Waktu</dt><dd>: '.$remin->waktu.'</dd>
                                                <dt class="left">Tempat</dt><dd>: '.$remin->tempat.'</dd>
                                                <dt class="left">Pengundang</dt><dd>: '.$remin->pengundang.'</dd>
                                            </dl>
                                        </div>
                                    </div>';
                            $no++;
                            if($no==2) {
                                $master_reminder .= '<div class="span12">'.$reminder.'</div>';
                                $reminder = '';
                                $no=0;
                            }
                        }
                        if($no==1){
                            echo '<div class="span12">'.$reminder.'</div>';    
                        }else{
                            echo $master_reminder;
                        }
                        
                    }
                ?>
            </div>
        </div>
    
	<? } ?>
    </div>

    <div class="tabs-frame-content" style="display: <?=$catatanload?>;">
		<? if(isset($_POST['pertload']) && $_POST['pertload']=='acaraload') {?>
        <div class="row-fluid no_margin">
            <div class="status_style">
                <div class="workplace">
                    <div class="head clearfix">
                        <div class="isw-users"></div>
                        <h1>Buat Catatan</h1>
                    </div>
                </div>
            </div>
            <div class="span12 block messaging" style="margin: 0px;">
                <form method="POST" action="#" class="sosial">
                        <label>Judul Catatan</label><input type="text" name="judul" class="text-field"/>
                        <label>Catatan</label><textarea name="catatan" style="min-height: 200px;" class="text-field"></textarea>
                        <input type="submit" class="button small lightblue" value="Simpan Catatan"/>
                    </dl>
                </form>
            </div>
        </div>
		<? } ?>
    </div>
</div>
<div class="hr"></div>
</div>