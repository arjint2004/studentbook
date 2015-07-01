<?php $this->load->view('sosial/function_view_user'); ?>
<div class="portfolio column-one-half-with-sidebar">
    <?=print_iklan();?>
    <?php
        if(!empty($cek_pertemanan)) {
            if($cek_pertemanan->stat_confirm=='Teman Anda') {    
    ?>
    <div class="status_style">
        <div class="workplace">     
            <div class="row-fluid">
                <div class="span12">
                    <div class="head clearfix">
                        <div class="isw-chats"></div>
                        <h1>Tulisan Terbaru</h1>
                    </div>
                    <div class="block messaging blok_message">
                        <form method="post" id="update_status" action="<?=site_url('sos/user/set_status')?>" enctype='multipart/form-data'>
				<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                            <input type="hidden" name="id_user" value="<?=$profile_user->id?>" id="id_user"/>
                            <input type="hidden" name="user" value="<?=$jenis_user?>" id="user"/>
                            <div class="controls">
                                <div class="control">
                                    <textarea name="textarea" placeholder="Tulis Status Untuk <?=$profile_user->nama?>" name="status_text" id="status_text" style="height: 70px; width: 100%;background: white;"></textarea>
                                    <input type="hidden" name="gambar" id="gambar"/>
                                    <div id="file_upload" class="left"></div>
                                    <div class="left">
                                        <img src="<?=$this->config->item('images').'upload.ico';?>" id="icon_upload" title="Upload Your Image" class="tooltip" width="20" style="margin: 0px;cursor: pointer;" />    
                                        <input type="file" id="image_upload" name="images" style="opacity: 0"/>
                                        <img id="loading" src="<?=$this->config->item('images').'loading.gif';?>" style="display:none;">
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="show_status">
                            
                        </div>
                        <?php if(!empty($status_pribadi['status'])) {
                            $user = Datauser();
                            foreach($status_pribadi['status'] as $stat_item){
                                if(empty($stat_item->images)) {
                                    $stat_item->images = 'asset/default/images/no_profile.jpg';
                                }
                            ?>
                                <div class="itemOut status_parent" id="hapusstatus_<?=$stat_item->id_status?>">
                                    <a href="<?=base_url($stat_item->images)?>" class="prev_image image"><img src="<?=base_url($stat_item->images)?>" alt="" title="" width="50" class="img-polaroid"/></a>
                                    <div class="text">
                                        <?php
                                            if($stat_item->id_foto==0) {
                                                if($stat_item->id==$user->id) {
                                                    $hps_link = '<span class="delete_status tooltip" title="Delete" id="status_'.$stat_item->id_status.'">x</span>';
                                                }else{;
                                                    $hps_link = '';
                                                }
                                                echo '<div class="info clearfix">
                                                            <span class="name"><a href="'.site_url('sos/user/view_profile/'.$stat_item->id).'">'.$stat_item->username.' > </a>'.$profile_user->nama.'</span>
                                                            <span class="date">'.CheckTime($stat_item->tgl_status).$hps_link.'</span>
                                                        </div>';
                                                echo '<p>'.MessageCheck($stat_item->pesan).'</p>';
                                            }
                                            else
                                            {
                                                if($stat_item->id==$profile_user->id) {
                                                    $hps_link = '<span class="delete_status tooltip" title="Delete" id="status_'.$stat_item->id_status.'">Hapus</span>';
                                                }else{
                                                    $hps_link = '';
                                                }
                                                echo '<div class="info clearfix">
                                                    <span class="name"><a href="'.site_url('sos/user/view_profile/'.$stat_item->id).'">'.$stat_item->username.'</a></span>
                                                    <span class="date">'.CheckTime($stat_item->tgl_status).$hps_link.'</span>
                                                </div>';
                                                echo '<p>'.MessageCheck($stat_item->pesan).'</p>
                                                <a href="#" class="prev_image"><img src="#"/></a>';
                                            }
                                        ?>
                                    </div>  
                                    <!-- komentar -->
                                    <?php
                                        $status_cek = false;
                                        $user   = Datauser();
                                        if(!empty($status_pribadi['komentar'])){
                                            foreach($status_pribadi['komentar'] as $idx=>$kom_item) {
                                                if($idx==$stat_item->id_status) {
                                                    foreach($kom_item as $val){
                                                    $status_cek = true;
                                                    if($val->id==$user->id) {
                                                        $hps_link = '<span class="delete_status tooltip" title="Delete" id="komentar_'.$val->id_komen.'">x</span>';
                                                    }else{
                                                        $hps_link = '';
                                                    }
                                                    if(empty($val->images)) {
                                                        $val->images = 'asset/default/images/no_profile.jpg';
                                                    }
                                                    ?>
                                                        <div class="row-fluid komentar_user" id="hapuskomentar_<?=$val->id_komen?>">
                                                            <div class="span2"></div>
                                                            <div class="span10">
                                                                <div class="itemOut">
                                                                    <a href="<?=base_url($val->images)?>" class="prev_image image"><img src="<?=base_url($val->images)?>" width="50" class="img-polaroid"/></a>
                                                                    <div class="text">
                                                                        <div class="info clearfix">
                                                                            <span class="name"><a href="<?=site_url('sos/user/view_profile/'.$val->id)?>"><?=$val->username?></a></span>
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
                                                <form method="POST" id="komentar" action="<?=site_url('sos/user/set_komentar')?>">
				<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                                                    <div class="itemOut">
                                                        <div class="controls">
                                                            <div class="control">
                                                                <textarea name="komentar" class="komentar_teks" placeholder="Komentar anda <?=$profile_user->nama?>" style="height: 50px; width: 100%;background: white;"></textarea>
                                                                <input type="hidden" name="id_user" value="<?=$profile_user->id?>"/>
                                                                <input type="hidden" name="user" value="<?=$jenis_user?>"/>
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
                                                <form method="POST" id="komentar" action="<?=site_url('sos/user/set_komentar')?>">
				<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                                                    <div class="itemOut">
                                                        <div class="controls">
                                                            <div class="control">
                                                                <textarea name="komentar" class="komentar_teks" placeholder="Komentar anda <?=$profile_user->nama?>" style="height: 50px; width: 100%;background: white;"></textarea>
                                                                <input type="hidden" name="user" value="<?=$jenis_user?>"/>
                                                                <input type="hidden" name="id_user" value="<?=$profile_user->id?>"/>
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
    
    <div class="hr"></div>
    <h2 class="float-left">TULIS SURAT</h2>
    <div class="tabs-frame-content" style="display: block;">
        <form method="POST" id="form_kirim_pesan" action="<?=site_url('sos/user/tulis_pesan_pribadi')?>" enctype="multipart/form-data">
				<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
            <input type="file" name="lampiran" id="lampiran" style="opacity: 0;display: none;">
            <div class="row-fluid">
                <textarea name="pesan" style="background: white;width: 97%;font-size: small;min-height: 100px;" placeholder="Tulis Pesan Anda Disini"></textarea>
                <div class="span6 left upload_dokumen" style="margin: 0px;">
                    <a href="#">Arsip Surat Antara Anda dan Teman Ini</a>
                </div>
                <div class="span6 right">
                    <input type="hidden" name="id_user" value="<?=$profile_user->id?>"/>
                    <input type="text" name="upload_lampiran" id="name_lampiran" readonly="readonly" style="background: white;margin: 0px;min-height: 25px;">
                    <a href="#" class="upload_dokumen lampir_file">Lampiran</a>
                </div>
            </div>
            <br>
            <div class="row-fluid right">
                <div class="span8">
                    
                </div>
                <div class="span4">
                    <a href="#" class="kirim_pesan cancel_pesan">Cancel</a>            
                    <a href="#" class="kirim_pesan send_pesan">Kirim Pesan</a>        
                </div>
            </div>
            <input type="submit" name="kirim_pesan" id="send_pesan" style="opacity: 0"/>
        </form>
    </div>
    <div class="hr"></div>
    <?php
            }
        }
    ?>
    <h2 class="float-left">BERITA SEKOLAH</h2>
    <div class="tabs-container">
        <ul class="tabs-frame">
            <li><a href="#" class="current">Terkini</a></li>
            <li><a href="#">Indeks</a></li>
        </ul>
        <div class="tabs-frame-content" style="display: block;height: 230px;">
            <?php
                if(!empty($berita_terbaru)){
                    $no=0;
                    $master_berita = '';
                    $bk_berita = '';
                    foreach($berita_terbaru as $brt){
                        echo '<div style="display: none;">
                                <div id="view_detail_berita_'.$brt->id_berita.'" class="span9">
                                    <div class="status_style">
                                        <div class="workplace">
                                            <div class="head clearfix">
                                                <div class="ibw-archive"></div>
                                                <h1>Detail Berita</h1>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row-fluid" style="min-height:400px;">
                                        <div class="span12">
                                            <br>
                                            <img src="'.base_url('upload/images/thumb/'.$brt->foto.'').'" alt="" title="" style="float:left;margin-right:15px;" class="img-polaroid">
                                            <h3>'.$brt->judul.'</h3>
                                            <p style="color:#287cca;">Tanggal : '.$brt->tgl_berita.'</p>
                                            <p style="line-height:120%;padding-top:10px;text-align:justify;">'.$brt->berita.'</p>
                                        </div>
                                    </div> 
                                </div>    
                            </div>';
                        $bk_berita .= '<div class="span6 back_berita">
                            <div class="row-fluid">
                                <div class="span3">
                                    <img src="'.base_url('upload/images/thumb/'.$brt->foto.'').'" alt="" title="" class="img-polaroid">
                                </div>
                                <div class="span9 left">
                                    <a href="#view_detail_berita_'.$brt->id_berita.'" class="modal_dialog span12 judul_berita">'.$brt->judul.'</a>
                                    <span class="span12 tgl_berita">'.$brt->tgl_berita.'</span>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span12 berita_teks">';
                                        $keterangan = explode(' ',$brt->berita);
                                        $bk_berita.='<p>';
                                        for($i=0;$i<count($keterangan);$i++) {
                                            if($keterangan[$i]!='' and $i<=30) {
                                                $bk_berita.= $keterangan[$i]." ";
                                            }
                                        }
                                        $bk_berita .= '<a href="#view_detail_berita_'.$brt->id_berita.'" class="modal_dialog">Lanjut...</a>';
                                        $bk_berita.='</p>';
                                $bk_berita.='</div>
                            </div>
                        </div>';
                        $no++;
                        if($no==2) {
                            $bk_berita = '<div class="row-fluid">'.$bk_berita.'</div>';
                            $master_berita .= $bk_berita;
                            $bk_berita = '';
                            $no=0;
                            break;
                        }
                    }
                    if($no==1){
                        echo $master_berita;
                        echo '<div class="row-fluid">'.$bk_berita.'</div>';
                    }else{
                        echo $master_berita;
                    }
                }
            ?>
        </div>
        <div class="tabs-frame-content" style="display: none;">
            <?php
                $no=0;
                $master_berita  = '';
                $bk_berita      = '';
                if(!empty($berita['data'])) {
                    foreach($berita['data'] as $brt) {
                        echo '<div style="display: none;">
                                <div id="view_detail_berita_'.$brt->id_berita.'" class="span9">
                                    <div class="status_style">
                                        <div class="workplace">
                                            <div class="head clearfix">
                                                <div class="ibw-archive"></div>
                                                <h1>Detail Berita</h1>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row-fluid" style="min-height:400px;">
                                        <div class="span12">
                                            <br>
                                            <img src="'.base_url('upload/images/thumb/'.$brt->foto.'').'" alt="" title="" style="float:left;margin-right:15px;" class="img-polaroid">
                                            <h3>'.$brt->judul.'</h3>
                                            <p style="color:#287cca;">Tanggal : '.$brt->tgl_berita.'</p>
                                            <p style="line-height:120%;padding-top:10px;text-align:justify;">'.$brt->berita.'</p>
                                        </div>
                                    </div> 
                                </div>    
                            </div>';
                        $bk_berita .= ' <div class="span6">
                                    <div class="span2 no_margin" style="padding-right:5px;">
                                        <img src="'.base_url('upload/images/thumb/'.$brt->foto.'').'" width="70px" class="img-polaroid">
                                    </div>
                                    <div class="span10"><h5 class="no_margin" style="color: #287cca;">
                                    <a href="#view_detail_berita_'.$brt->id_berita.'" class="modal_dialog">';
                                        $jdl = explode(' ',$brt->judul);
                                            for($i=0;$i<count($jdl);$i++) {
                                                if($jdl[$i]!='' and $i<=3) {
                                                    $bk_berita.= $jdl[$i]." ";
                                                }
                                            }
                                        $bk_berita.=' ...</a></h5>
                                         <span style="font-size: small;color: #287cca;">';
                                         $keterangan = explode(' ',$brt->berita);
                                            for($i=0;$i<count($keterangan);$i++) {
                                                if($keterangan[$i]!='' and $i<=10) {
                                                    $bk_berita.= $keterangan[$i]." ";
                                                }
                                            }
                                        
                                        $bk_berita .= '<a href="#view_detail_berita_'.$brt->id_berita.'" class="modal_dialog">Lanjut...</a>
                                        </span>
                                    </div>
                                </div>';
                        $no++;
                        if($no==2) {
                            $master_berita .= '<div class="row-fluid span12 left">'.$bk_berita.'</div><br>';
                            $bk_berita = '';
                            $no=0;
                        }
                    }
                    if($no<2) {
                        echo $master_berita;
                        echo '<div class="row-fluid span12 left">'.$bk_berita.'</div><br>';
                    }else{
                        echo $master_berita;
                    }
                    
                    if(!empty($berita['pagination'])) {
                        echo '<div class="pagination">
                            <ul>'.
                                $berita['pagination'].'
                            </ul>                    	
                        </div>';
                    }
                    
                }
            ?>
        </div>
    </div>
    
    <div class="hr no_top"></div>
    <h2 class="float-left">KEGIATAN SEKOLAH</h2>
    <div class="tabs-container">
        <ul class="tabs-frame">
            <li><a href="#" class="current">Terkini</a></li>
            <li><a href="#">Indeks</a></li>
        </ul>
        <div class="tabs-frame-content" style="display: block;height: 220px;">
            <?php
                if(!empty($kegiatan_terbaru)){
                    $jk=0;
                    $master_kegiatan = '';
                    $bk_kegiatan = '';
                    foreach($kegiatan_terbaru as $kgt){
                            echo '<div style="display: none;">
                                    <div id="view_detail_kegiatan_'.$kgt->id_kegiatan.'" class="span9">
                                        <div class="status_style">
                                            <div class="workplace">
                                                <div class="head clearfix">
                                                    <div class="ibw-archive"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row-fluid" style="min-height:400px;">
                                            <div class="span12">
                                                <br>
                                                <img src="'.base_url('upload/images/thumb/'.$kgt->foto.'').'" alt="" title="" style="float:left;margin-right:15px;" class="img-polaroid">
                                                <h3>'.$kgt->judul.'</h3>
                                                <p style="color:#287cca;">Tanggal : '.$kgt->tgl_keg.'</p>
                                                <p style="line-height:120%;padding-top:10px;text-align:justify;">'.$kgt->keterangan.'</p>
                                            </div>
                                        </div> 
                                    </div>    
                                </div>';
                            $bk_kegiatan .= '<div class="span6 back_berita">
                                <div class="row-fluid">
                                    <div class="span3">
                                        <img src="'.base_url('upload/images/thumb/'.$kgt->foto.'').'" alt="" title="">
                                    </div>
                                    <div class="span9 left">
                                        <a href="#view_detail_kegiatan_'.$kgt->id_kegiatan.'" class="modal_dialog span12 judul_berita">'.$kgt->judul.'</a>
                                        <span class="span12 tgl_berita">'.$kgt->tgl_keg.'</span>
                                    </div>
                                </div>
                                <div class="row-fluid">
                                    <div class="span12" style="padding: 3px;text-align: left;min-height: 120px;">';
                                            $keterangan = explode(' ',$kgt->keterangan);
                                            for($i=0;$i<count($keterangan);$i++) {
                                                if($keterangan[$i]!='' and $i<=30) {
                                                    $bk_kegiatan.= $keterangan[$i]." ";
                                                }
                                            }
                                        
                                        $bk_kegiatan .= '<a href="#view_detail_kegiatan_'.$kgt->id_kegiatan.'" class="modal_dialog">Lanjut...</a>
                                    </div>
                                </div>
                            </div>';
                        $jk++;
                        if($jk==2) {
                            $bk_kegiatan = '<div class="row-fluid">'.$bk_kegiatan.'</div>';
                            $master_kegiatan .= $bk_kegiatan;
                            $bk_kegiatan = '';
                            $jk=0;
                            break;
                        }
                    }
                    
                    if($no==1){
                        echo $master_kegiatan;
                        echo '<div class="row-fluid">'.$bk_kegiatan.'</div>';
                    }else{
                        echo $master_kegiatan;
                    }
                }
            ?>    
        </div>
        <div class="tabs-frame-content" style="display: none;">
            <?php
                $no=0;
                $master_dtl  = '';
                $dtl         = '';
                if(!empty($kegiatan['data'])) {
                    foreach($kegiatan['data'] as $kgt) {
                        echo '<div style="display: none;">
                                <div id="view_detail_kegiatan_'.$kgt->id_kegiatan.'" class="span9">
                                    <div class="status_style">
                                        <div class="workplace">
                                            <div class="head clearfix">
                                                <div class="ibw-archive"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row-fluid" style="min-height:400px;">
                                        <div class="span12">
                                            <br>
                                            <img src="'.base_url('upload/images/thumb/'.$kgt->foto.'').'" alt="" title="" style="float:left;margin-right:15px;" class="img-polaroid">
                                            <h3>'.$kgt->judul.'</h3>
                                            <p style="color:#287cca;">Tanggal : '.$kgt->tgl_keg.'</p>
                                            <p style="line-height:120%;padding-top:10px;text-align:justify;">'.$kgt->keterangan.'</p>
                                        </div>
                                    </div> 
                                </div>    
                            </div>';
                        $dtl .= ' <div class="span6">
                                    <div class="span2 no_margin" style="padding-right:5px;">
                                        <img src="'.base_url('upload/images/thumb/'.$kgt->foto.'').'" width="70px" class="img-polaroid">
                                    </div>
                                    <div class="span10"><h5 class="no_margin" style="color: #287cca;"><a class="modal_dialog"  href="#view_detail_kegiatan_'.$kgt->id_kegiatan.'">';
                                        $jdl = explode(' ',$kgt->judul);
                                            for($i=0;$i<count($jdl);$i++) {
                                                if($jdl[$i]!='' and $i<=3) {
                                                    $dtl.= $jdl[$i]." ";
                                                }
                                            }
                                        $dtl.=' ...</a></h5>
                                         <span style="font-size: small;color: #287cca;">';
                                         $keterangan = explode(' ',$kgt->keterangan);
                                            for($i=0;$i<count($keterangan);$i++) {
                                                if($keterangan[$i]!='' and $i<=10) {
                                                    $dtl.= $keterangan[$i]." ";
                                                }
                                            }
                                        
                                        $dtl .= '<a class="modal_dialog" href="#view_detail_kegiatan_'.$kgt->id_kegiatan.'">Lanjut...</a>
                                        </span>
                                    </div>
                                </div>';
                        $no++;
                        if($no==2) {
                            $master_dtl .= '<div class="row-fluid span12 left">'.$dtl.'</div><br>';
                            $dtl = '';
                            $no=0;
                        }
                    }
                    if($no<2) {
                        echo $master_dtl;
                        echo '<div class="row-fluid span12 left">'.$dtl.'</div><br>';
                    }else{
                        echo $master_dtl;
                    }
                    
                    if(!empty($kegiatan['pagination'])) {
                        echo '<div class="pagination">
                            <ul>'.
                                $kegiatan['pagination'].'
                            </ul>                    	
                        </div>';
                    }
                    
                }
            ?>
        </div>
    </div>
    <?=print_iklan()?>
</div>