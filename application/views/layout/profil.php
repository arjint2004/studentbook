<?=$this->load->view('layout/ad_header')?>
<!-- **Breadcrumb** 
<div class="breadcrumb">
    <div class="breadcrumb-bg">
        <div class="container">
        <br>
        </div> 
    </div>
</div>  **Breadcrumb - End** -->


    <!-- **Content** -->
    <div class="content content-full-width">
		<?=$this->load->view('layout/sekolahhead')?>
            <!--<div class="share-links" style="height: 100px;border: 1px solid #C9C1C1;"> 
            <div class="span12">
                <br><br>
                <span style="font-size: 80px;padding: 10px;color: #CECCCC;">
                    SPACE IKLAN
                </span>
            </div>
			</div>
        <div class="hr"></div>-->
        <h2> PENGANTAR </h2>
        <div class="tabs-frame-content" style="display: block;">
            <p><?=$pengantar[0]['content']?></p>
        </div>
        <div class="hr"></div>
        <!--<div class="share-links" style="height: 100px;border: 1px solid #C9C1C1;"> 
            <div class="span12">
                <br><br>
                <span style="font-size: 80px;padding: 10px;color: #CECCCC;">
                    SPACE IKLAN
                </span>
            </div>
        </div>
        <div class="hr"></div>-->
		<? //pr($content);?>
        <h2> PROFILE </h2>
        <div class="tabs-container">
            <ul class="tabs-frame">
                <li><a href="#" class="current">Visi & Misi</a></li>
                <li><a href="#">Tujuan</a></li>
                <li><a href="#">Sejarah</a></li>
                <li><a href="#">Program</a></li>
                <li><a href="#">Fasilitas</a></li>
                <!--<li><a href="#">Kirim Surat Ke Sekolah</a></li>-->
            </ul>
            <div class="tabs-frame-content" style="display: block;">
                <?=$content['Visi Misi']['content']?>
            </div>
            <div class="tabs-frame-content" style="display: block;">
                <?=$content['Tujuan']['content']?>
            </div>
            <div class="tabs-frame-content" style="display: block;">
                <?=$content['Sejarah']['content']?>
            </div>
            <div class="tabs-frame-content" style="display: none;">
                <?=$content['Program']['content']?>
            </div>
            <div class="tabs-frame-content" style="display: none;">
                <?=$content['Fasilitas']['content']?>
            </div>
            <!--<div class="tabs-frame-content" style="display: none;">
                <div class="row-fluid">
                    <div class="span12">
                        <div class="ajax_message"></div>
                        <form action="<?=site_url('sos/sekolah/kirim_pesan')?>" method="POST">
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                           <input type="hidden" name="id_sekolah" value="<?=$data->id?>"/>
                           <input type="hidden" name="email_sekolah" value="<?=$data->email_pendaftar?>"/>
                           <p class="column one-third">
                               <input name="nama" type="text" value="<?=set_value('nama');?>" placeholder="Nama Anda" />
                               <?php echo form_error('nama','<span class="error">', '</span>'); ?>
                           </p>
                           <p class="column one-third">
                               <input name="email" type="text" value="<?=set_value('email');?>" placeholder="email"/>
                                <?php echo form_error('email', '<span class="error">', '</span>'); ?>
                           </p>
                           <p class="column one-third last">
                               <input name="subject" type="text" value="<?=set_value('subject');?>" placeholder="judul"/>
                                <?php echo form_error('subject', '<span class="error">', '</span>'); ?>
                           </p>
                           <p>
                            <textarea rows="" cols="" name="pesan" style="width: 96%;" placeholder="Pesan Anda"><?=set_value('pesan');?></textarea>   
                            <?php echo form_error('pesan', '<span class="error">', '</span>'); ?>
                           </p>
                           <p>
                               <input name="submit" type="submit" value="Kirim Pesan" class="button small grey" />
                           </p>
                       </form>
                    </div>
                </div>
            </div>-->
        </div>
		
        <h2> AKADEMIK </h2>
        <div class="tabs-container">
            <ul class="tabs-frame">
                <li><a href="#" class="current">Kurikulum</a></li>
                <li><a href="#">Metode</a></li>
                <li><a href="#">Target</a></li>
                <li><a href="#">Ekstrakurikuler</a></li>
            </ul>
            <div class="tabs-frame-content" style="display: block;">
                <?=$content['Kurikulum']['content']?>
            </div>
            <div class="tabs-frame-content" style="display: block;">
                <?=$content['Metode']['content']?>
            </div>
            <div class="tabs-frame-content" style="display: block;">
                <?=$content['Target']['content']?>
            </div>
            <div class="tabs-frame-content" style="display: none;">
                <?=$content['Ekstrakurikuler']['content']?>
            </div>
        </div>
        <h2> STAFF </h2>
        <div class="tabs-container">
            <ul class="tabs-frame">
                <li><a href="#" class="current">Guru</a></li>
                <li><a href="#">Karyawan</a></li>
            </ul>
            <div class="tabs-frame-content" style="display: block;">
                <?=$content['Guru']?>
            </div>
            <div class="tabs-frame-content" style="display: block;">
                <?=$content['Karyawan']?>
            </div>
        </div>
        <!--<div class="share-links" style="height: 100px;border: 1px solid #C9C1C1;"> 
            <div class="span12">
                <br><br>
                <span style="font-size: 80px;padding: 10px;color: #CECCCC;">
                    SPACE IKLAN
                </span>
            </div>
        </div>-->
        <h2> BERITA</h2>
        <div class="tabs-container">
            <ul class="tabs-frame">
                <li><a href="#" class="current">Terkini</a></li>
                <li><a href="#">Index</a></li>
            </ul>
            <div class="tabs-frame-content" style="display: block;">
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
                    }else{
                        echo 'Belum Ada Berita Baru';
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
                    
                }else{
                    echo 'Belum Ada Index Berita';
                }
            ?>
            </div>
        </div>
        <div class="hr">
            
        </div>
        <h2> KEGIATAN SEKOLAH </h2>
        <div class="tabs-container">
            <ul class="tabs-frame">
                <li><a href="#" class="current">Terkini</a></li>
                <li><a href="#">Index</a></li>
            </ul>
            <div class="tabs-frame-content" style="display: block;">
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
                }else{
                    echo 'Belum Ada Kegiatan Baru';
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
                    
                    }else{
                        echo 'Belum Ada Index Kegiatan Baru';
                    }
                ?>
            </div>
        </div>
    </div> <!-- **Content - End** -->   	
    
    <?//=$this->load->view('layout/sidebar');?>
    

    
    
<?=$this->load->view('layout/ad_footer')?>