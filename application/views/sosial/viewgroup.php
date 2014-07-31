<?php
    $this->load->view('sosial/function_group');
?>
<div class="portfolio column-one-half-with-sidebar" id="awal_group">
    <?=print_iklan()?>
    <div class="tabs-container">
        <ul class="tabs-frame">
            <li><a href="#" class="current">Diskusi</a></li>
            <li><a href="#">Deskripsi</a></li>
            <li><a href="#">Acara</a></li>
            <li><a href="#">Album</a></li>
            <li><a href="#">Dokumen</a></li>
        </ul>
        <div class="tabs-frame-content" style="display: block;">
            <?php
                if(!empty($member_or_not)){
            ?>
            <div class="status_style">
                <div class="workplace">     
                    <div class="row-fluid">
                        <div class="span12">
                            <div class="head clearfix">
                                <div class="isw-chats"></div>
                                <h1>Kirim Tulisan</h1>
                            </div>
                            <div class="block messaging">
                                <form method="post" id="update_status" action="<?=site_url('sos/group/set_status')?>" enctype='multipart/form-data'>
                                <input type="hidden" name="id_group" id="id_group" value="<?=$data_group->id_group?>"/>
                                <div class="controls">
                                    <div class="control">
                                        <textarea name="textarea" placeholder="Kirim Tulisan Anda..." name="status_text" id="status_text" style="height: 70px; width: 100%;background: white;"></textarea>
                                       
                                        <input type="hidden" name="gambar" id="gambar"/>
                                        <div id="file_upload" class="left"></div>
                                        <div class="left">
                                            <div class="row-fluid">
                                                <div class="span1">
                                                    <img src="<?=$this->config->item('images').'upload.ico';?>" id="icon_upload" title="Upload Your Image" class="tooltip" width="20" style="margin: 0px;cursor: pointer;" />            
                                                </div>
                                                <div class="span2" style="margin: 0px;margin-top:5px;">
                                                    <a href="#" style="float: left;color: blue;font-size: smaller;font-weight: bold;">|Polling Group</a>
                                                </div>
                                                <div class="span9">
                                                    
                                                </div>
                                            </div>
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
            <?php
                }
            ?>
            <br>
            <div class="status_style">
                <div class="workplace">     
                    <div class="row-fluid">
                        <div class="span12">
                            <div class="head clearfix">
                                <div class="isw-chats"></div>
                                <h1>Tulisan Terbaru</h1>
                            </div>
                            <div class="block messaging blok_message">
                                <div class="show_status">
                                    
                                </div>
                                <?php if(!empty($status_group)) {
                                    foreach($status_group['status'] as $stat_item){
                                        if(empty($stat_item->foto_member)) {
                                            $stat_item->foto_member = 'asset/default/images/no_profile.jpg';
                                        }
                                    ?>
                                        <div class="itemOut status_parent" id="hapusstatus_<?=$stat_item->id_stat_group?>">
                                            <a href="<?=base_url($stat_item->foto_member)?>" class="prev_image image"><img src="<?=base_url($stat_item->foto_member)?>" alt="" title="" width="50" class="img-polaroid"/></a>
                                            <div class="text">
                                                <?php
                                                    if($stat_item->id_foto==0) {
                                                        if($stat_item->id_user==$user) {
                                                            $hps_link = '<span class="delete_status tooltip" title="Delete" id="status_'.$stat_item->id_stat_group.'">x</span>';
                                                        }else{
                                                            $hps_link = '';
                                                        }
                                                        echo '<div class="info clearfix">
                                                                    <span class="name">'.$stat_item->nama.'</span>
                                                                    <span class="date">'.CheckTime($stat_item->tgl_status).$hps_link.'</span>
                                                                </div>';
                                                        echo '<p>'.MessageCheck($stat_item->status).'</p>';
                                                    }
                                                    else
                                                    {
                                                        if($stat_item->id_user==$user) {
                                                            $hps_link = '<span class="delete_status tooltip" title="Delete" id="status_'.$stat_item->id_stat_group.'">x</span>';
                                                        }else{
                                                            $hps_link = '';
                                                        }
                                                        echo '<div class="info clearfix">
                                                            <span class="name">'.$stat_item->nama.'</span>
                                                            <span class="date">'.CheckTime($stat_item->tgl_status).$hps_link.'</span>
                                                        </div>';
                                                        echo '<p>'.MessageCheck($stat_item->status).'</p>
                                                        <a href="'.base_url($stat_item->large).'" class="prev_image"><img src="'.base_url($stat_item->small).'"></a>';
                                                    }
                                                ?>
                                            </div>

                                            <!-- komentar -->
                                            <?php
                                                $status_cek = false;
                                                if(!empty($status_group['komentar'])){
                                                    foreach($status_group['komentar'] as $idx=>$kom_item) {
                                                        if($idx==$stat_item->id_stat_group) {
                                                            foreach($kom_item as $val){
                                                            $status_cek = true;
                                                            if($val->id_user==$user) {
                                                                $hps_link = '<span class="delete_status tooltip" title="Delete" id="komentar_'.$val->id_komen_status.'">x</span>';
                                                            }else{
                                                                $hps_link = '';
                                                            }
                                                            if(empty($val->foto)) {
                                                                $val->foto_member = 'asset/default/images/no_profile.jpg';
                                                            }
                                                            ?>
                                                                <div class="row-fluid komentar_user" id="hapuskomentar_<?=$val->id_komen_status?>">
                                                                    <div class="span2"></div>
                                                                    <div class="span10">
                                                                        <div class="itemOut">
                                                                            <a href="<?=base_url($val->foto_member)?>" class="prev_image image"><img src="<?=base_url($val->foto_member)?>" width="50" class="img-polaroid"/></a>
                                                                            <div class="text">
                                                                                <div class="info clearfix">
                                                                                    <span class="name"><?=$val->nama_komentar?></span>
                                                                                    <span class="date"><?=CheckTime($val->tgl_komen)?><?=$hps_link?></span>
                                                                                </div>                                
                                                                                <p><?=MessageCheck($val->komentar)?></p>
                                                                            </div>
                                                                        </div>                                        
                                                                    </div>
                                                                </div>
                                                            <?php
                                                            }
                                                            echo '<div id="'.$stat_item->id_stat_group.'"></div>';
                                                        }
                                                    }
                                                }
                                            ?>
                            
                                            <?php
                                            if($status_cek)
                                            {
                                            ?>
                                                <div class="komentar_user" id="hapusstatus_<?=$stat_item->id_stat_group?>">                            
                                                    <div class="span2"></div>
                                                    <div class="span10">
                                                        <form method="POST" id="komentar" action="<?=site_url('sos/group/set_komentar')?>">
                                                            <div class="itemOut">
                                                                <div class="controls">
                                                                    <div class="control">
                                                                        <textarea name="komentar" class="komentar_teks" placeholder="Komentar anda" style="height: 50px; width: 100%;background: white;"></textarea>
                                                                        <input type="hidden" name="id_group" value="<?=$data_group->id_group?>"/>
                                                                        <input type="hidden" name="id_status" value="<?=$stat_item->id_stat_group?>"/>
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
                                                <div id="<?=$stat_item->id_stat_group?>" id="hapusstatus_<?=$stat_item->id_stat_group?>"></div>
                                                <div class="komentar_user">                            
                                                    <div class="span2">
                                                    </div>
                                                    <div class="span10">
                                                        <form method="POST" id="komentar" action="<?=site_url('sos/group/set_komentar')?>">
                                                            <div class="itemOut">
                                                                <div class="controls">
                                                                    <div class="control">
                                                                        <textarea name="komentar" class="komentar_teks" placeholder="Komentar anda" style="height: 50px; width: 100%;background: white;"></textarea>
                                                                        <input type="hidden" name="id_group" value="<?=$data_group->id_group?>"/>
                                                                        <input type="hidden" name="id_status" value="<?=$stat_item->id_stat_group?>"/>
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
        </div><!--tab 1 tutup-->
        <div class="tabs-frame-content" style="display: none;">
            <div class="row-fluid">
                <div style="display: none;" class="row-fluid">
                    <div class="span6" id="ubah_data_group">
                        <div class="status_style">
                            <div class="workplace">
                                <div class="head clearfix">
                                    <div class="ibw-archive"></div>
                                    <h1>Ubah Data Group</h1>
                                </div>
                            </div>
                        </div><br>
                        <form method="POST" action="<?=site_url('sos/group/ubah_data_group')?>" enctype="multipart/form-data">
                            <input type="hidden" name="id_group" value="<?=$data_group->id_group?>"/>
                            <label>Nama Group</label><input type="text" name="nama_group" class="row-fluid span12" value="<?=$data_group->nama_group?>" style="background:white;width: 95%;"/>
                            <label>Deskripsi Group</label><textarea name="deskripsi" class="row-fluid span12" style="background:white;width: 95%;"><?=$data_group->deskripsi?></textarea>
                            <label>Logo</label><input type="file" name="logo" class="span12">
                            <br>
                            <span>
                                <input type="submit" name="buat_album" value="Upload Document" class="button small lightblue"> 
                            </span>
                        </form>
                    </div>
                </div>
            </div>
            <div class="status_style">
                <div class="workplace">     
                    <div class="row-fluid">
                        <div class="span12">                    
                            <div class="head clearfix">
                                <div class="isw-users"></div>
                                <h1>Data Group</h1>
                                <?php
                                if($user==$data_group->pendiri) {
                                    ?>
                                        <div class="right">
                                            <a href="#ubah_data_group" style="margin-top: 4px;" title="" class="button modal_dialog small green">Ubah Data</a>
                                        </div>
                                    <?php
                                    }
                                ?>
                            </div>
                            <br>
                            <div class="row-fluid">                                
                                <div class="span3 no_margin">
                                    <?php
                                        if(!empty($data_group)) {
                                            echo '<a href="#"><img src="'.base_url($data_group->logo).'" width="100" class="img-polaroid"></a>';
                                        }
                                    ?>
                                </div>
                                <div class="span8 left">
                                    <?php
                                        if(!empty($data_group)) {
                                            echo '<dl>
                                                    <dt>Nama Group </dt><dd>: '.$data_group->nama_group.'</dd>
                                                    <dt>Deskripsi </dt><dd>: '.$data_group->deskripsi.'</dd>
                                                    <dt>Tanggal Daftar </dt><dd>: '.$data_group->tgl_daftar.'</dd>
                                                </dl>';      
                                        }
                                    ?>
                                </div>
                            </div>
                            <br>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="status_style">
                <div class="workplace">     
                    <div class="row-fluid">
                        <div class="span12">                    
                            <div class="head clearfix">
                                <?php
                                    if($this->uri->segment(3)!='tambah_anggota_group') {
                                ?>
                                    <div class="isw-users"></div>
                                    <h1>Daftar Anggota Group</h1>      
                                    <div class="right">
                                        <a href="<?=site_url('sos/group/tambah_anggota_group/'.$data_group->id_group)?>" style="margin-top: 4px;" title="" class="button small green">Tambah Anggota</a>
                                    </div>
                                <?php
                                    }else{
                                    ?>
                                        <h1><input type="checkbox" name="anggota_group" class="check_all_group" id="check_all_group" style="margin: 0px;"/> Semua | Daftar Anggota Group</h1>      
                                        <div class="right">
                                            <a href="<?=site_url('sos/group/view/'.$data_group->id_group)?>" style="margin-top: 4px;" title="" class="button small green">Kembali</a>
                                        </div>
                                    <?php
                                    }
                                ?>
                            </div>
                            <div class="block-fluid">
                                <?php
                                    $cek_member_ada = '';
                                    $jml = 0;
                                    if(!empty($member_group)) {
                                        echo '<table cellpadding="0" cellspacing="0" width="100%" class="table listUsers" style="overflow:auto;">';
                                        echo '<tbody>';
                                        foreach($member_group as $mg) {
                                            $cek_member_ada=$mg->id_user;
                                            $jml++;
                                            if(empty($mg->foto_member)) {
                                                $mg->foto_member = 'asset/default/images/no_profile.jpg';
                                            }
                                            ?>
                                                <tr>                                    
                                                    <td width="40">
                                                        <a href="#"><img src="<?=base_url($mg->foto_member)?>" width="32" class="img-polaroid"></a>
                                                    </td>
                                                    <td>
                                                        <a href="<?=site_url('sos/user/view_profile/'.$mg->id_user)?>" target="_blank" class="user"><?=$mg->nama?></a>
                                                        <p class="about">
                                                            <span class="icon-envelope"></span>
                                                            <?php if($mg->jenis_member=='user') {
                                                                echo 'anggota';
                                                            }
                                                            else {
                                                                echo $mg->jenis_member;
                                                            }
                                                            ?>
                                                            <br>
                                                        </p>
                                                    </td>
                                                    <td>
                                                        <p class="about">
                                                            <a href="<?=site_url('sos/user/view_profile/'.$mg->id_user)?>" target="_blank"><span class="isb-user"></span></a> 
                                                            <?php
                                                                if($user==$data_group->pendiri AND $mg->id_user!=$user) {
                                                            ?>
                                                                <a href="<?=site_url('sos/group/hapus_member/'.$data_group->id_group.'/'.$mg->id_member)?>"><span class="isb-delete"></span></a>                                                                                       
                                                            <?php
                                                                }
                                                            ?>
                                                        </p>
                                                    </td>
                                                </tr>                                 
                                            <?php
                                            
                                        }
                                        echo '</tbody>';
                                        echo '</table>';
                                    }else{
                                        if(!empty($teman)) {
                                            echo '<table cellpadding="0" cellspacing="0" width="100%" class="table listUsers" style="overflow:auto;">';
                                            echo '<tbody>';
                                            echo '<form method="POST" action="'.site_url('sos/group/anggota_baru').'">';
                                            $bk_teman       = '';
                                            $master_teman   = '';
                                            $no=0;
                                            foreach($teman as $tmn) {
                                                if(empty($tmn->images)) {
                                                    $tmn->images = 'asset/default/images/no_profile.jpg';
                                                }
                                                $bk_teman .= '<td width="40">
                                                        <a href="#"><img src="'.base_url($tmn->images).'" width="32" class="img-polaroid"></a>
                                                    </td>
                                                    <td>
                                                        <input type="hidden" name="id_group" value="'.$data_group->id_group.'">
                                                        <input type="hidden" name="foto[]" value="'.$tmn->images.'"/>
                                                        <input type="hidden" name="nama[]" value="'.(!empty($tmn->nama_pegawai) ? $tmn->nama_pegawai : $tmn->nama_siswa).'"/>
                                                        <input type="hidden" name="group[]" value="'.$tmn->otoritas.'"/>
                                                        <a href="'.site_url('sos/user/view_profile/'.$tmn->id).'" target="_blank" class="user">'.(!empty($tmn->nama_pegawai) ? $tmn->nama_pegawai : $tmn->nama_siswa).'</a><br>
                                                        <span><input type="checkbox" class="group_check" style="margin:0px;" name="anggota_baru[]" value="'.$tmn->id.'"/> Tambahkan Ke Group</span>
                                                    </td>';
                                                $no++;
                                                if($no==3) {
                                                    $master_teman .= '<tr>'.$bk_teman.'</tr>';
                                                    $bk_teman = '';
                                                    $no=0;
                                                }
                                            }
                                            if($no==1) {
                                                echo $master_teman;
                                                echo '<tr>'.$bk_teman.'<td></td><td></td><td></td><td></td></tr>';
                                            }elseif($no==2){
                                                echo $master_teman;
                                                echo '<tr>'.$bk_teman.'<td></td></tr>';
                                            }else{
                                                echo $master_teman;
                                            }
                                            echo '<tr><td colspan="6"><input type="submit" name="simpan" class="button small lightblue float-right" value="Tambahkan Anggota Ke Group"/></td></tr>';
                                            echo '<tr><td colspan="6"><div class="pagination"><ul>'.(!empty($pagination) ? $pagination : '').'</ul></div></td></tr>';
                                            echo '</form>';
                                            echo '</tbody>';
                                            echo '</table>';
                                        }else{
                                            echo '<br>';
                                            echo '<h3>Anda belum Memiliki Teman atau semua teman telah terdaftar</h3>';
                                        }
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- tab 2 tutup-->
        <div class="tabs-frame-content" style="display: none;">
        <div class="row-fluid button_acara right">
            <div class="span12">
                <button id="button_acara" class="button small lightblue">Buat Acara</button>
                <button id="back_acara" style="display: none;" class="button small lightblue">Kembali</button>
            </div>
        </div>
        <br>
        <div class="form_acara" style="display: none;">   
            <form class="sosial" method="POST" action="<?=site_url('sos/group/create_acara')?>">
                <div class="row-fluid">
                    <div class="status_style">
                        <div class="workplace">
                            <div class="head clearfix">
                                <div class="isw-users"></div>
                                <h1>Inputkan Data Acara</h1>
                            </div>
                        </div>
                    </div><br>
                </div>
                <input type="hidden" name="id_group" value="<?=$data_group->id_group?>"/>
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
                        if(!empty($member_group)) {
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
                            echo '<table cellpadding="0" cellspacing="0" width="100%" class="table listUsers" style="overflow:auto;">';
                            echo '<tbody>';                
                            foreach($member_group as $tmn) {
                                if(empty($tmn->foto_member)) {
                                    $tmn->foto_member = 'asset/default/images/no_profile.jpg';
                                }
                                $friend .= '<td width="40">
                                                <a href="#"><img src="'.base_url($tmn->foto_member).'" width="32" class="img-polaroid"></a>
                                            </td>
                                            <td>
                                                <input type="hidden" name="id_group" value="'.$data_group->id_group.'">
                                                <a href="'.site_url('sos/user/view_profile/'.$tmn->id_user).'" target="_blank" class="user">'.$tmn->nama.'</a><br>
                                                <span><input type="checkbox" name="id_undangan[]" class="id_user_undangan float-left" value="'.$tmn->id_member.'"/>&nbsp;Tambahkan Ke Group</span>
                                            </td>';
                                $no++;
                                if($no==3){
                                    $master_teman.='<tr>'.$friend.'</tr>';
                                    $friend = '';
                                    $no=0;
                                }
                            }
                            if($no==1){
                                echo $master_teman;
                                echo '<tr>'.$friend.'<td></td><td></td><td></td><td></td></tr>';
                            }elseif($no==2){
                                echo $master_teman;
                                echo '<tr>'.$friend.'<td></td></tr>';
                            }else{
                                echo $master_teman;
                            }
                            echo '</tbody>';
                            echo '</table>';
                        }
                    ?>
                </div>
                <input type="submit" name="submit" value="Buat Acara" class="button small lightblue"/>
                </form>     
            </div>
            <div class="list_acara">
                    <div class="row-fluid">
                        <?php
                            if(!empty($acara_group)) {
                                echo '<div class="status_style">
                                        <div class="workplace">
                                            <div class="head clearfix">
                                                <div class="isw-users"></div>
                                                <h1>Daftar Acara Yang Anda Buat</h1>
                                            </div>
                                        </div>
                                    </div>';
                                $no=0;
                                $jml_data=0;
                                $df_acara = '';
                                $master = '';
                                echo '<table cellpadding="0" cellspacing="0" width="100%" class="table listUsers" style="overflow:auto;">';
                                echo '<tbody>';            
                                foreach($acara_group as $au) {                 
                                    $df_acara .= '<td width="50">
                                                    <a href="#" class="user" style="padding-left:5px;">'.$au->nama_acara.'</a>        
                                                    <dl>
                                                        <dt class="left">Hari/Tanggal</dt><dd>: '.$au->tgl_acara.'</dd>
                                                        <dt class="left">Waktu</dt><dd>: '.$au->jam.'</dd>
                                                        <dt class="left">Tempat</dt><dd>: '.$au->tempat.'</dd>
                                                        <dt class="left">Aksi</dt><dd>: <a href="'.site_url('sos/group/hapus_acara/'.$data_group->id_group.'/'.$au->id_acara).'">Hapus Acara</a></dd>
                                                    </dl>
                                                </td>';
                                    //$df_acara .= '<div class="span6">
                                    //        <div class="span2">
                                    //            <img src="'.base_url('asset/default/images/acara_user.png').'" width="50" class="float-left"/>
                                    //        </div>
                                    //        <div class="span10 float-left">
                                    //            <span class="title_acara float-left left">
                                    //                <a href="#">'.$au->nama_acara.'</a>
                                    //            </span>
                                    //
                                    //        </div>
                                    //    </div>';
                                    $no++;
                                    $jml_data++;
                                    if($no==2){
                                        $master .= '<tr>'.$df_acara.'</tr>';
                                        $df_acara = '';
                                        $no=0;
                                    }
                                }
                                if($jml_data==1){
                                    echo $master;
                                    echo '<tr>'.$df_acara.'</tr>';
                                }
                                if($jml_data>1 and $no==1){
                                    echo $master;
                                    echo '<tr>'.$df_acara.'<td></td></tr>';
                                }
                                else{
                                    echo $master;    
                                }
                                echo '</tbody>';
                                echo '</table>';
                            }
                        ?>
                    </div>
                    
                </div>
        </div><!-- tab 3 tutup -->
        <div class="tabs-frame-content" style="display: none;">    
            <!-- image galleri -->
            <div class="row-fluid">
                <div class="tabs-container">
                    <ul class="tabs-frame">
                        <li><a href="#" class="current">Foto Tanpa Album</a></li>
                        <li><a href="#">Album Foto</a></li>
                        <li><a href="#">Upload Foto dan Album</a></li>
                    </ul>
                    <div class="tabs-frame-content" style="display: block;width: 95%">
                        <div class="row-fluid">
                            <?php
                                if(!empty($foto_group['data'])) {
                                    foreach($foto_group['data'] as $ft_group) {
                                        echo '<div class="stack twisted">	
                                            <a href="'.base_url($ft_group->large).'" title="'.$ft_group->keterangan.'" rel="group_image"><img src="'.base_url($ft_group->small).'" /></a>
                                        </div>';          
                                    }
                                }
                            ?>
                        </div>
                        <div class="row-fluid">
                            <?php
                                if(!empty($foto_group['pagination'])) {
                                    echo '<div class="pagination">
                                        <ul>'.
                                            $foto_group['pagination'].'
                                        </ul>                    	
                                    </div>';
                                }
                            ?>
                        </div>
                    </div>
                    <div class="tabs-frame-content" style="display: none;width: 95%;">
                        <div class="row-fluid button_back" style="display: none;">
                            <div class="span12 left"><a class="button small lightblue kembali_list_foto">Kembali</a></div>
                        </div>
                        <div class="row-fluid show_foto_group">
                            
                        </div>
                        <div class="row-fluid list_foto_group">
                            <?php
                                $master_album = '';
                                $album_gr_foto = '';
                                $no=0;
                                if(!empty($get_foto_album)) {
                                    foreach($get_foto_album as $foto_album) {
                                        $album_gr_foto .= '<div style="display: none;" class="row-fluid">
                                                                <div class="span6 tinggi_pesan" id="edit_album_'.$foto_album->id_album.'">
                                                                    <div class="status_style">
                                                                        <div class="workplace">
                                                                            <div class="head clearfix">
                                                                                <div class="ibw-archive"></div>
                                                                                <h1>Buat Album Baru</h1>
                                                                            </div>
                                                                        </div>
                                                                    </div><br>
                                                                    <form method="POST" action="'.site_url('sos/group/edit_album').'">
                                                                         <input type="hidden" name="id_group" value="'.$foto_album->id_group.'"/>
                                                                         <input type="hidden" name="id_album" value="'.$foto_album->id_album.'"/>
                                                                         <input type="text" name="nama_album" maxlength="30" value="'.$foto_album->nama_album.'" placeholder="Nama Album" style="background:white;"/>
                                                                         <textarea name="deskripsi" maxlength="110" style="background:white;min-height:100px;width:550px;" placeholder="Deskripsi Album" class="span6">'.$foto_album->deskripsi.'</textarea>
                                                                         <input type="submit" name="buat_album" value="Ubah Data" class="button small lightblue"> 
                                                                    </form>
                                                                </div>
                                                            </div>
                                                            <div class="span6">
                                                                <div class="span4 no_margin"><a href="#"><img src="'.base_url($foto_album->small).'" class="img-polaroid"></a></div>
                                                                <div class="span8">
                                                                    <h5 class="no_margin float-left"><a class="view_detail_foto" id="'.$foto_album->id_album.'_'.$data_group->id_group.'" style="color: #287cca;text-align: left;margin-left: 10px;">'.$foto_album->nama_album.'</a></h5>
                                                                    <span class="span12" style="font-size: smaller;text-align: left;margin-left: 10px;min-height:50px;">'
                                                                        .$foto_album->deskripsi.'</span>
                                                                    <span class="span12 tgl_album">
                                                                        <p class="left">
                                                                            <a href="#edit_album_'.$foto_album->id_album.'" class="modal_dialog">Edit Album</a>
                                                                            <a href="'.site_url('sos/group/hapus_album/'.$data_group->id_group.'/'.$foto_album->id_album).'">Hapus Album</a>
                                                                        </p>
                                                                    </span>
                                                                </div>
                                                            </div>';
                                        $no++;
                                        if($no==2) {
                                            $master_album .= '<div class="row-fluid">'.$album_gr_foto.'</div><br>';
                                            $album_gr_foto = '';
                                            $no=0;
                                        }
                                    }
                                    if($no<2) {
                                        echo $master_album;
                                        echo '<div class="row-fluid">'.$album_gr_foto.'</div><br>';
                                    }else{
                                        echo $master_album;
                                    }
                                }else{
                                    echo "Group Ini Belum Memiliki Album foto";
                                }
                            ?>
                        </div>
                    </div>
                    <div class="tabs-frame-content" style="display: none;">    
                        <div class="row-fluid">
                            <div class="span12">
                                <div class="span6 left">
                                    Pilih Album Foto :
                                    <select name="album" style="width: auto;" id="album">
                                        <option value="">--Pilih Album--</option>
                                        <?php
                                            if(!empty($album_group)) {
                                                foreach($album_group as $album) {
                                                    echo '<option value="'.$album->id_album.'">'.$album->nama_album.'</option>';
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="span6 right">
                                    <div style="display: none;" class="row-fluid">
                                       <div class="span6 tinggi_pesan" id="album_foto">
                                           <div class="status_style">
                                               <div class="workplace">
                                                   <div class="head clearfix">
                                                       <div class="ibw-archive"></div>
                                                       <h1>Buat Album Baru</h1>
                                                   </div>
                                               </div>
                                           </div><br>
                                           <form method="POST" action="<?=site_url('sos/group/create_album')?>">
                                                <input type="hidden" name="id_group" value="<?=$data_group->id_group?>"/>
                                                <input type="text" name="nama_album" maxlength="30" placeholder="Nama Album" style="background:white;"/>
                                                <textarea name="deskripsi" maxlength="110" style="background:white;min-height:100px;width:550px;" placeholder="Deskripsi Album" class="span6"></textarea>
                                                <input type="submit" name="buat_album" value="Buat Album" class="button small lightblue"> 
                                           </form>
                                       </div>
                                    </div>
                                    <a class="modal_dialog button small lightblue" href="#album_foto">Buat Album</a>
                                </div>
                            </div>
                            <div class="span12" style="margin: 0px;">
                                <div id="dropzone">
                                    <form action="<?=site_url('sos/group/multiple_upload')?>" class="dropzone" id="demo-upload">
                                    </form>
                                </div>
                                
                                <form method="POST" action="<?=site_url('sos/group/simpan_multiple_foto')?>" class="right" id="form_upload">
                                    <input type="hidden" name="id_group" value="<?=$data_group->id_group?>">
                                    <input type="submit" class="button small lightblue multi_foto" value="Simpan Foto"/>
                                </form>
                            </div>
                        </div>
                        <br>
                    </div>
                </div>           
            </div>
            <!-- end image galleri -->
        </div><!-- tab 4 tutup -->
        <div class="tabs-frame-content" style="display: none;">
            <div class="row-fluid">
                <div style="display: none;" class="row-fluid">
                    <div class="span6" id="upload_dokumen_group">
                        <div class="status_style">
                            <div class="workplace">
                                <div class="head clearfix">
                                    <div class="ibw-archive"></div>
                                    <h1>Upload Document</h1>
                                </div>
                            </div>
                        </div><br>
                        <form method="POST" action="<?=site_url('sos/group/upload_dokumen')?>" enctype="multipart/form-data">
                            <input type="hidden" name="id_group" value="<?=$data_group->id_group?>"/>
                            <label>Nama File</label><input type="text" name="nama_dokumen" class="row-fluid span12" placeholder="Nama Dokumen" style="background:white;width: 95%;"/>
                            <label>File Upload</label><input type="file" name="dokumen" class="span12">
                            <br>
                            <span>
                                <input type="submit" name="buat_album" value="Upload Document" class="button small lightblue"> 
                            </span>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="row-fluid">
                <div class="span12 upload_dokumen">
                    <a href="#upload_dokumen_group" class="modal_dialog button small green float-right">Upload Document</a> 
                </div>
            </div>
            <br>
            <div class="row-fluid">
                <?php
                    if(!empty($dokumen_group['data'])) {
                        echo '<div class="status_style">
                                <div class="workplace">
                                    <div class="head clearfix">
                                        <div class="isw-users"></div>
                                        <h1>Daftar Dokumen</h1>
                                    </div>
                                </div>
                            </div>';
                            $no=0;
                            $df_dokumen = '';
                            $master_dokumen = '';
                            echo '<table cellpadding="0" cellspacing="0" width="100%" class="table listUsers" style="overflow:auto;">';
                            echo '<tbody>';            
                            foreach($dokumen_group['data'] as $dg) {                 
                                $df_dokumen .= '<td width="50">
                                                <a href="#" class="user" style="padding-left:5px;">'.$dg->nama_dokumen.'</a>        
                                                <dl>
                                                    <dt class="left">Tanggal Upload</dt><dd>: '.$dg->tgl_dokumen.'</dd>
                                                    <dt class="left">Ukuran</dt><dd>: '.$dg->size.' Kb</dd>
                                                    <dt class="left">Aksi</dt><dd>: <a href="'.base_url($dg->path).'">Unduh Document</a></dd>
                                                </dl>
                                            </td>';
                                $no++;
                                if($no==2){
                                    $master_dokumen .= '<tr>'.$df_dokumen.'</tr>';
                                    $df_dokumen = '';
                                    $no=0;
                                }
                            }
                            if($no==1){
                                echo $master_dokumen;
                                echo '<tr>'.$df_dokumen.'<td width="50"></td></tr>';
                            }else{
                                echo $master_dokumen;    
                            }
                            echo '</tbody>';
                            echo '</table>';
                            
                            if(!empty($dokumen_group['pagination'])) {
                                 echo '<div class="pagination">
                                        <ul>'.
                                            $dokumen_group['pagination'].'
                                        </ul>                    	
                                    </div>';
                            }
                    }
                ?>
            </div>
        </div><!-- tab 5 tutup-->
        
    </div>
</div> <!--div tutup portofolio-->