<div id="main">
        <!-- **Container** -->
        <div class="container">
        <!-- **Content Full Width** -->
        <?php
            if(!empty($data_sekolah)) {
                if(empty($data_sekolah->logo)) {
                    $data_sekolah->logo = 'asset/default/images/logo_sekolah.png';
                }
            ?>
                <div class="column one-fourth">
                    <div class="thumb">
                        <a href="<?=base_url($data_sekolah->logo)?>" style="text-align: center;">
                            <img src="<?=base_url($data_sekolah->logo)?>" alt="" title="" />
                        </a>
                    </div>
                </div>
                <div class="column fourth-fourth last left" style="min-height: 190px;">
                    <a href="#">
                        <h2><?=$data_sekolah->nama_sekolah?></h2>
                    </a>
                    <div class="row-fluid">
                        <div class="span12">
                            <dl style="margin: 0px;">
                                <dt>Alamat</dt><dd>: <?=$data_sekolah->alamat_sekolah?></dd>
                                <dt>Desa</dt><dd>: <?=$data_sekolah->desa?></dd>
                                <dt>Kecamatan</dt><dd>: <?=$data_sekolah->kec?></dd>
                                <dt>Provinsi</dt><dd>: <?=$data_sekolah->prop?></dd>
                                <dt>Akreditasi</dt><dd>: <?=$data_sekolah->terakreditasi?></dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="hr no_top"></div>
            <?php
            }
        ?>
        <!-- berita dan kegiatan sekolah -->
        <h2 class="float-left">BERITA SEKOLAH</h2>
            <div class="tabs-container">
                <ul class="tabs-frame">
                    <li><a href="#" class="current">Terkini</a></li>
                </ul>
                <div class="tabs-frame-content" style="display: block;height: 250px;">
                    <div id="slides_berita">
                    <?php
                        if(!empty($berita)){
                            $no=0;
                            $master_berita = '';
                            $bk_berita = '';
                            foreach($berita as $brt){
                                $bk_berita .= '<div class="span6 back_berita">
                                    <div class="row-fluid">
                                        <div class="span3">
                                            <img src="'.base_url('upload/images/thumb/'.$brt->foto.'').'" alt="" title="">
                                        </div>
                                        <div class="span9 left">
                                            <a href="#" class="span12 judul_berita">'.$brt->judul.'</a>
                                            <span class="span12 tgl_berita">'.$brt->tgl_berita.'</span>
                                        </div>
                                    </div>
                                    <div class="row-fluid">
                                        <div class="span12" style="padding: 3px;text-align: left;min-height: 120px;">';
                                                $keterangan = explode(' ',$brt->berita);
                                                for($i=0;$i<count($keterangan);$i++) {
                                                    if($keterangan[$i]!='' and $i<=30) {
                                                        $bk_berita.= $keterangan[$i]." ";
                                                    }
                                                }
                                            $bk_berita .= '<a href="'.site_url('detail_berita/view/'.$brt->id_berita.'').'">Lanjut...</a>
                                        </div>
                                    </div>
                                </div>';
                                $no++;
                                if($no==2) {
                                    $bk_berita = '<div class="slides_container">
                                                    <div class="row-fluid">'.$bk_berita.'</div></div>';
                                    $master_berita .= $bk_berita;
                                    $bk_berita = '';
                                    $no=0;
                                }
                            }
                            if($no==1){
                                echo $master_berita;
                                echo '<div class="slides_container">
                                    <div class="row-fluid">'.$bk_berita.'</div></div>';
                            }else{
                                echo $master_berita;
                            }
                            
                        }else{
                            echo '<div class="span12">Berita Sekolah Tidak Ditemukan</div>';
                        }
                    ?>
                    </div>    
                </div>
            </div>
            <div class="hr no_top"></div>
            <h2 class="float-left">KEGIATAN SEKOLAH</h2>
            <div class="tabs-container">
                <ul class="tabs-frame">
                    <li><a href="#" class="current">Terkini</a></li>
                </ul>
                <div class="tabs-frame-content" style="display: block;height: 220px;">
                    <div id="slides_kegiatan">
                    <?php
                        if(!empty($kegiatan)){
                            $jk=0;
                            $master_kegiatan = '';
                            $bk_kegiatan = '';
                            foreach($kegiatan as $kgt){
                                    $bk_kegiatan .= '<div class="span6 back_berita">
                                        <div class="row-fluid">
                                            <div class="span3">
                                                <img src="'.base_url('upload/images/thumb/'.$kgt->foto.'').'" alt="" title="">
                                            </div>
                                            <div class="span9 left">
                                                <a href="#" class="span12 judul_berita">'.$kgt->judul.'</a>
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
                                                
                                                $bk_kegiatan .= '<a href="'.site_url('detail_kegiatan/view/'.$kgt->id_kegiatan.'').'">Lanjut...</a>
                                            </div>
                                        </div>
                                    </div>';
                                $jk++;
                                if($jk==2) {
                                    $bk_kegiatan = '<div class="slides_container">
                                                    <div class="row-fluid">'.$bk_kegiatan.'</div></div>';
                                    $master_kegiatan .= $bk_kegiatan;
                                    $bk_kegiatan = '';
                                    $jk=0;
                                }
                            }
                            
                            if($no==1){
                                echo $master_kegiatan;
                                echo '<div class="slides_container">
                                    <div class="row-fluid">'.$bk_kegiatan.'</div></div>';
                            }else{
                                echo $master_kegiatan;
                            }
                        }else{
                            echo 'Kegiatan Sekolah Tidak Ditemukan';
                        }
                    ?>
                    </div>    
                </div>
            </div>
    </div><!-- **Container - End** -->
</div>

