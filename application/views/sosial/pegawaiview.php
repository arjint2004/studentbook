<?php
    $this->load->view('sosial/function_pegawai');
   // $this->load->view('akademik/mainakademik/js');
?>
<script>
    $(function(){
        $(".delete_item").live('click',function(e){
            e.preventDefault();
            var id = $(this).attr('id');
            var jwb=confirm('Yakin Menghapus Foto Ini ? ');
            if(jwb) {
                window.location.href = '<?=site_url('sos/pegawai/hapus_foto_pribadi/')?>/'+id;
            }
        });
    });
</script>
<div class="portfolio column-one-half-with-sidebar">
    <?//=print_iklan(); ?>
	<? $guru=$this->auth->array_searchRecursive( 13, $group, $strict=false, $path=array() );
		if(!empty($guru)){
	?>
	<!--<h3 id="guru"> Menu Akademik Guru </h3>

	<div class="hr"></div>
	<div class="tabs-container">
		<div class="tabs-frame-content" style="display: block;">
			<a class="readmore" tab="pembelajaran" id="materi_pelajaran" title="" >Kirim Materi<br />Pelajaran </a>
			<a class="readmore" tab="pembelajaran" id="daftar_pr"  title=""> Kirim<br />PR</a>
			<a class="readmore" tab="pembelajaran"   id="daftar_tugas" title=""  > Kirim<br />Tugas </a>
			<br id="brsubject"  tab="pembelajaran"  class="clear" />
            <div id="subject"></div>
		</div>
	</div>-->
	<? } ?>	
	
	<div class="notifak column content content-full-width">
        <h2 class="float-left"> NOTIFIKASI AKADEMIK </h2>   
        <div class="toggle-frame">
            <h5 class="toggle-accordion"><a >Pemberitahuan terahir dari sekolah</a></h5>
            <div style="display: block; max-height:400px;" class="toggle-content">
				<? timelineakademik();?>
			</div>
        </div>                  
    </div>
	
	<? aktifitasakademik($this->session->userdata['user_authentication']['id_pengguna'],'guru',5);?>
		
    <h2 class="float-left">SURAT</h2> 
	<script> 
	$(function(){
		function getAllKelas(){
			$.ajax({
						type: "POST",
						data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&',
						url: base_url+'sos/pegawai/getAllKelas',
						beforeSend: function() {
							$('div#tagsinputnotmn').after("<img id='wait' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
						},
						success: function(datanya) {
							$("#wait").remove();
							$('div#tagsinputnotmn').html('<div  id="kelassuratdiv" style="width: 30%; display: inline-block; vertical-align: middle; float: left;"> Kelas : <select name="id_kelas" onchange="$(\'select#siswasurat\').load(\'<?=base_url()?>sos/pegawai/getSiswaByKelas/\'+$(this).val())" id="kelassurat"  required>'+datanya+'</select></div>');
							$('div#kelassuratdiv').after('<div id="kelassuratdivsiswa" style="display: inline-block; float: left; vertical-align: middle;  width: 66%;"> <select name="untuk[]" id="siswasurat" multiple required ><option id="title">Pilih Siswa</option></select></div>');
						}
			});
		}
		function getAllGuru(){
			$.ajax({
						type: "POST",
						data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&',
						url: base_url+'sos/pegawai/getAllGuru',
						beforeSend: function() {
							$('div#tagsinputnotmn').after("<img id='wait' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
						},
						success: function(datanya) {
							$("#wait").remove();
							$('div#tagsinputnotmn').html('<div   style="width: 100%; display: inline-block; vertical-align: middle; float: left;"> <select name="untuk[]" multiple id="kelassurat"  style="width:100%;" required>'+datanya+'</select></div>');
							
						}
			});
		}
		
		
		$('form#form_dialog input[type=radio]').click(function(){
			$('div#id_pesan').html('');
			var box='<div id="tagsinputnotmn" class="tagsinputnotmn" style="width: auto;margin-top:10px;"></div>';
			if($(this).val()=='teman'){
				$('div.tagsinput').show();
				$('div.tagsinputnotmn').remove();
			}else if($(this).val()=='siswa'){
				$('div.tagsinputnotmn').remove();
				$('div#id_pesan').before(box);
				$('input#hiddenjenis').remove();
				$('div.tagsinputnotmn').after('<input type="hidden" id="hiddenjenis" name="siswa" value="siswa" />');
				getAllKelas();
				$('div.tagsinput').hide();
			}else if($(this).val()=='orangtua'){
				$('div.tagsinputnotmn').remove();
				$('div#id_pesan').before(box);
				$('input#hiddenjenis').remove();
				$('div.tagsinputnotmn').after('<input type="hidden" id="hiddenjenis" name="orangtua" value="orangtua" />');
				getAllKelas();
				$('div.tagsinput').hide();
			}else if($(this).val()=='siswadanorangtua'){
				$('div.tagsinputnotmn').remove();
				$('div#id_pesan').before(box);
				$('input#hiddenjenis').remove();
				$('div.tagsinputnotmn').after('<input type="hidden" id="hiddenjenis" name="siswadanorangtua" value="siswadanorangtua" />');
				getAllKelas();
				$('div.tagsinput').hide();
			}else if($(this).val()=='guru'){
				$('div.tagsinputnotmn').remove();
				$('div#id_pesan').before(box);
				$('input#hiddenjenis').remove();
				$('div.tagsinputnotmn').after('<input type="hidden" id="hiddenjenis" name="siswadanorangtua" value="guru" />');
				getAllGuru();
				$('div.tagsinput').hide();
			}
			
		});
		
	});
	</script>
    <div class="tabs-container">
        <ul class="tabs-frame">
            <li><a href="#" class="current">Pesan Masuk</a></li>
            <li><a href="#">Pesan Keluar</a></li>
        </ul>
        <div class="tabs-frame-content" style="display: block;">
            <div class="row-fluid">
                <div class="span12">
                    <div style="display: none;">
                        <form id="form_dialog" class="span6" method="post" action="<?=site_url('sos/pegawai/pesan_user')?>" enctype="multipart/form-data">
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                            <input type="file" name="lampiran" id="lampiran" style="opacity: 0;">
                            <label style="float:left;"><b>Kepada :</b></label><br />
                            
							<input type="radio" class="kepada" checked name="kepada" value="teman" />Teman
                            <input type="radio" class="kepada" name="kepada" value="guru" />Guru
                            <input type="radio" class="kepada" name="kepada" value="siswa" />Siswa
                            <input type="radio" class="kepada" name="kepada" value="orangtua" />Orang Tua
                            <input type="radio" class="kepada" name="kepada" value="siswadanorangtua" />Siswa dan Orang Tua<br /><br />
                            <input type="text" name="nama" style="width: 95%;display:none;" id="tags_3"/>
                            <div class="id_pesan" id="id_pesan" ></div>
                            <br /><label><b>Pesan :</b></label>
                            <textarea name="pesan" style="width: 96%;background:white;min-height: 100px;"></textarea>
                            <input type="text" name="upload_lampiran" id="name_lampiran" readonly="readonly" style="background: white;margin: 0px;min-height: 25px;">
                            <a class="lampir_file readmorenoplus" href="#" style="margin:10px 0 0 0;width:60px;">Lampiran</a>
							<br class="clear">
							<input class="button small grey" type="submit" value="Kirim Pesan" id="kirimsurat" name="kirim">
                        </form>    
                    </div>
                    <div class="span12" style="margin: 0px;">
                        <p id="tulis_pesan">
                            <a href="#form_dialog" class="modal_dialog button small grey">Tulis Pesan</a>
                        </p>
                    </div>
                    <table class="pesan">
                        <thead>
                            <tr>
                                <th>Pilih</th>
                                <th>Pengirim</th>
                                <th>Pesan</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                            <?php
                                if(!empty($pesan)) {
                                    echo '<tbody>';
                                    foreach($pesan as $psn){
										if($psn->nama_pegawai!=''){$psn->nama=$psn->nama_pegawai;}elseif($psn->nama_siswa!=''){$psn->nama=$psn->nama_siswa;}
                                        echo '<div style="display: none;" class="row-fluid">
                                                <div class="span6 tinggi_pesan" id="view_pesan_'.$psn->id_pesan.'">
                                                    <div class="status_style">
                                                        <div class="workplace">
                                                            <div class="head clearfix">
                                                                <div class="ibw-archive"></div>
                                                                <h1>Dari : '.$psn->nama.'</h1>
                                                            </div>
                                                        </div>
                                                    </div><br>
                                                    <p>'.$psn->pesan.'</p><br>
                                                    <form method="POST" action="'.site_url('sos/pegawai/balas_pesan').'">
														<input type="hidden" name="'.$this->security->get_csrf_token_name().'" value="'.$this->security->get_csrf_hash().'">
                                                        <input type="hidden" name="id_balas" value="'.$psn->penulis.'">
                                                        <textarea name="pesan" style="background:white;min-height:100px;width:550px;" placeholder="Balas Pesan Anda" class="span6"></textarea>
                                                        <input type="submit" name="balas_pesan" value="Balas Pesan" class="button small light-grey"> 
                                                    </form>
                                                </div>
                                            </div>';
                                        if($psn->status=='belum'){
                                        ?>
                                            <tr>
                                                <td class="bold_teks"><input type="checkbox" name="pilih[]" value="<?=$psn->id_pesan?>" /></td>
                                                <td class="bold_teks"><a href="<?=site_url('sos/user/view_profile/'.$psn->id)?>"><?=$psn->nama?></a></td>
                                                <td class="bold_teks"><a class="modal_dialog lihat_pesan" href="#view_pesan_<?=$psn->id_pesan?>" id="<?=$psn->status."_".$psn->id_pesan?>"><?=substr($psn->pesan,0,50)?></a></td>
                                                <td class="bold_teks"><?=$psn->tgl_pesan?></td>
                                                <td class="bold_teks"><?=$psn->status?></td>
                                            </tr>
                                        <?php
                                        }else{
                                            ?>
                                            <tr>
                                                <td><input type="checkbox" name="pilih[]" value="<?=$psn->id_pesan?>" /></td>
                                                <td><a href="<?=site_url('sos/user/view_profile/'.$psn->id)?>"><?=$psn->nama?></a></td>
                                                <td><a class="modal_dialog lihat_pesan" href="#view_pesan_<?=$psn->id_pesan?>" id="<?=$psn->status." ".$psn->pesan?>"><?=substr($psn->pesan,0,50)?></a></td>
                                                <td><? $tg=tanggal($psn->tgl_pesan); echo $tg[1];?></td>
                                                <td><?=$psn->status?></td>
                                            </tr>                            
                                            <?php
                                        }
                                    }
                                    echo '</tbody>';
                                }else{
                                    echo '<tbody><tr>
                                        <td colspan="5">Belum Ada Pesan</td>
                                    </tr></tbody>';
                                }
                            ?>
                                            
                    </table>
                </div>
            </div>    
        </div>
        <div class="tabs-frame-content" style="display: none;">
            <div class="row-fluid">
                <div class="span12">
                    <div style="display: none;">
                        <form id="form_dialog" class="span6" method="post" action="<?=site_url('sos/pegawai/pesan_user')?>">
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                            <label>Untuk :</label>
                            <input type="text" name="nama" style="width: 95%" id="tags_3"/>
                            <div class="id_pesan"></div>
                            <label>Pesan :</label>
                            <textarea name="pesan" style="width: 96%;background:white;min-height: 100px;"></textarea>
                            <input type="submit" name="kirim" value="Kirim Pesan" class="button small grey"/>
                        </form>    
                    </div>
                    <div class="span12" style="margin: 0px;">
                        <p id="tulis_pesan">
                            <a href="#form_dialog" class="modal_dialog button small grey">Tulis Pesan</a>
                        </p>
                    </div>
					<?//pr($pesan_keluar);?>
                    <table class="pesan">
                        <thead>
                            <tr>
                                <th>Pilih</th>
                                <th>Tujuan</th>
                                <th>Pesan</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                            <?php
                                if(!empty($pesan_keluar)) {
                                    echo '<tbody>';
                                    foreach($pesan_keluar as $psn){
									if($psn->nama_pegawai!=''){$psn->username=$psn->nama_pegawai;}elseif($psn->nama_siswa!=''){$psn->username=$psn->nama_siswa;}
                                        echo '<div style="display: none;" class="row-fluid">
                                                <div class="span6 tinggi_pesan" id="view_pesan_'.$psn->id_pesan.'">
                                                    <div class="status_style">
                                                        <div class="workplace">
                                                            <div class="head clearfix">
                                                                <div class="ibw-archive"></div>
                                                                <h1>Untuk : '.$psn->username.'</h1>
                                                            </div>
                                                        </div>
                                                    </div><br>
                                                    <p>'.$psn->pesan.'</p><br>
                                                </div>
                                            </div>';
                                            ?>
                                            <tr>
                                                <td><input type="checkbox" name="pilih[]" value="<?=$psn->id_pesan?>" /></td>
                                                <td class="left"><a href="<?=site_url('sos/user/view_profile/'.$psn->id_user)?>"><?=$psn->username?></a></td>
                                                <td><a class="modal_dialog lihat_pesan" href="#view_pesan_<?=$psn->id_pesan?>" id="<?=$psn->status." ".$psn->pesan?>"><?=substr($psn->pesan,0,10)?></a></td>
                                                <td><? $tg=tanggal($psn->tgl_pesan); echo $tg[1];?></td>
                                                <td><?=$psn->status?></td>
                                            </tr>                            
                                            <?php
                                    }
                                    echo '</tbody>';
                                }else{
                                    echo '<tbody><tr>
                                        <td colspan="5">Belum Ada Pesan</td>
                                    </tr></tbody>';
                                }
                            ?>
                                            
                    </table>
                </div>
            </div> 
        </div>
    </div>
			
    <h2 class="float-left">GALLERI FOTO</h2>
   <div class="tabs-container">
        <ul class="tabs-frame">
            <li><a href="#">Foto Gallery</a></li>
            <li><a href="#">Upload</a></li>
        </ul>
        <div class="tabs-frame-content">
             <div class="row-fluid">
                <div class="span12">
                    <div id="slides">
                        <div class="span1 previous">
                            <a href="#" class="prev"><img src="<?=$this->config->item('images')?>/prev_foto.png" alt="Arrow Prev"></a>
                        </div>
                        <?php
                            if(!empty($galleri)) {
                        ?>
                        <div class="span10">
                            <div class="slides_container" style="margin: 0px;">
                            <?php
                                $no=0;
                                $master_foto = '';
                                $ft = '';
                                foreach($galleri as $gl) {
                                    $ft .='<div class="item"><a rel="group_image" href="'.base_url().$gl->large.'"><div style="position:absolute;width:17px;" class="delete_item" id="'.$gl->id_foto.'"><img src="'.base_url('asset/default/images/button-ico-delete.png').'" style="clear:both;height:17px;border:none;"></div><img src="'.base_url().$gl->small.'"/></a></div>';              
                                    $no++;
                                    if($no==6)
                                    {                        
                                        $master_foto .= '<div class="slide">'.$ft.'</div>';
                                        $ft = '';
                                        $no=0;
                                    }
                                }
                                if($no<6){
                                    echo $master_foto;
                                    echo '<div class="slide">'.$ft.'</div>';
                                }else{
                                    echo $master_foto;
                                }
                            ?>
                            </div>
                        </div>
                        <?php
                        }
                        else{ 
                            echo '<div class="span10">
                                Belum Ada Foto Galleri
                            </div>';
                        }
                        ?>
                        <div class="span1 next_image">
                            <a href="#" class="next"><img src="<?=$this->config->item('images')?>/next_foto.png"  alt="Arrow Next"></a>
                        </div>
                    </div>
                </div>
            </div>              
        </div>
        <div class="tabs-frame-content scrollbar_upload" id="style-6">
            <div class="row-fluid">
                <div class="span12">
                    <div class="span6 left">
                        Pilih Album Foto :
                        <select name="album" style="width: auto; margin:0 0 15px 0;" id="album">
                            <option value="">--Pilih Album--</option>
                            <?php
                                if(!empty($album_foto)) {
                                    foreach($album_foto as $album) {
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
                               <form method="POST" action="<?=site_url('sos/pegawai/buat_album')?>">
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                                    <input type="text" name="nama_album" placeholder="Nama Album" style="background:white;"/>
                                    <textarea name="deskripsi" style="background:white;min-height:100px;width:550px;" placeholder="Deskripsi Album" class="span6"></textarea>
                                    <input type="submit" name="buat_album" value="Buat Album" class="button small lightgrey"> 
                               </form>
                           </div>
                       </div>
                        <a class="modal_dialog button small lightgrey" href="#album_foto">Buat Album</a>
                    </div>
                </div>
                <div class="span12" style="margin: 0px;">
                    <div id="dropzone">
                        <form action="<?=site_url('sos/pegawai/multiple_upload')?>" class="dropzone" id="demo-upload">
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                        </form>
                    </div>
                    
                    <form method="POST" action="<?=site_url('sos/pegawai/simpan_multiple_foto')?>" class="right" id="form_upload">
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                        <input type="submit" class="lightgrey multi_foto" value="Simpan Foto"/>
                    </form>
                </div>
                <!--<div id="dropzone">
                    <form action="" enctype="multipart/form-data" method="POST" class="dropzone">
                        <div class="fallback">
                          <input name="file" type="file" multiple />
                        </div>
                        <input type="submit" class="button small lightgrey" value="Simpan Foto"/>
                    </form>
                    </div>
                <div>-->
        </div>               
        </div>
     </div>
    <?//=print_iklan();?>
    <h2 class="float-left">BERITA SEKOLAH</h2>
    <div class="tabs-container">
        <ul class="tabs-frame">
            <li><a href="#" class="current">Terkini</a></li>
            <li><a href="#">Indeks</a></li>
        </ul>
        <div class="tabs-frame-content" >
			
			<? 
			$last=count($berita_terbaru)-1;
			if(!empty($berita_terbaru)){
			foreach($berita_terbaru as $ky=>$brt){
				$tg=tanggal($brt->tgl_berita."");
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
                                    <div class="row-fluid">
                                        <div class="span12">
                                            <br>
                                            <img src="'.base_url('upload/images/thumb/'.$brt->foto.'').'" alt="" title="" style="float:left;margin-right:15px;" class="img-polaroid">
                                            <h3>'.$brt->judul.'</h3>
                                            <p >'.$tg[2].'</p>
                                            <p >'.$brt->berita.'</p>
                                        </div>
                                    </div> 
                                </div>    
                            </div>';
			?>
            <!-- **Column One Half** -->   	
                <div class="column one-half  <?if($last=$ky){echo "last";}else{echo "brthome";}?>">
                    <!-- **Team** -->
                    <div class="team">          
                        <div class="image"> <img src="<?=base_url('upload/images/thumb/'.$brt->foto.'')?>" alt="" title="" /> </div>
                        <h5> <a href="#view_detail_berita_<?=$brt->id_berita?>" class="modal_dialog"><?=$brt->judul?> </a></h5>
                        <h6 class="role"><? $tg=tanggal($brt->tgl_berita.""); echo $tg[2];?></h6>
                        <p>  <?=$brt->berita?> </p>             
                    </div> <!-- **Team - End** -->               
                </div><!-- **Column One Half - End** --> 
				<? }  } ?>
        </div>
        <div class="tabs-frame-content">
           <div class="row-fluid">
                <?php
                    $jurnalis = session_jurnalis();
                    if(!empty($jurnalis))
                    {
                        echo '<div style="display: none;" class="row-fluid">
                                <div class="span6 tinggi_pesan" id="form_berita_baru">
                                    <div class="status_style">
                                        <div class="workplace">
                                            <div class="head clearfix">
                                                <div class="ibw-archive"></div>
                                                <h1>Tambah Berita Baru</h1>
                                            </div>
                                        </div>
                                    </div><br>
                                    <form method="POST" action="'.site_url('sos/siswa/berita_simpan').'" enctype="multipart/form-data">
							<input type="hidden" name="'.$this->security->get_csrf_token_name().'" value="'.$this->security->get_csrf_hash().'">';
                                           
                                        echo '<input type="hidden" name="sekolah" value="'.$this->session->userdata['user_authentication']['id_sekolah'].'"/>';
                                               
                                        echo '<label>Judul</label>
                                        <input type="text" name="judul" style="background:white;width:95%;"/>
                                        <label>Berita</label>
                                        <textarea name="berita" style="background:white;width:95%;min-height:70px;">
                                            
                                        </textarea>
                                        <label>Foto</label>
                                        <input type="file" name="foto"/><br>
                                        <input type="submit" name="Tambah Siswa" class="button small lightblue" value="Save Data"/>
                                    </form>
                                </div>
                            </div>';
                        echo '<div class="span12 right">
                                <a href="#form_berita_baru" class="modal_dialog button small blue" style="margin-right:20px;">Tambah Berita</a>
                            </div>';      
                    }
                ?>
				
				<?
				if(!empty($berita['data'])) {
					$last=count($berita['data'])-1;
                    foreach($berita['data'] as $brt) {
				?>
				 <!-- **Column One Half** -->   	
                <div class="column one-half  <?if($last=$ky){echo "last";}else{echo "brthome";}?>">
                    <!-- **Team** -->
                    <div class="team">          
                        <div class="image"> <img src="<?=base_url('upload/images/thumb/'.$brt->foto.'')?>" alt="" title="" /> </div>
                        <h5> <a href="#view_detail_berita_<?=$brt->id_berita?>" class="modal_dialog"><?=$brt->judul?> </a></h5>
                        <h6 class="role"> <? $tg=tanggal($brt->tgl_berita.""); echo $tg[2];?> </h6>
                        <p>  <?=$brt->berita?> </p>             
                    </div> <!-- **Team - End** -->               
                </div><!-- **Column One Half - End** --> 
				<? } } ?>
            </div>
        </div>
    </div>
    <div class="hr no_top"></div>
    <h2 class="float-left">KEGIATAN SEKOLAH</h2>
    <div class="tabs-container">
        <ul class="tabs-frame">
            <li><a href="#" class="current">Terkini</a></li>
            <li><a href="#">Indeks</a></li>
        </ul>
        <div class="tabs-frame-content">
            <?php
                if(!empty($kegiatan_terbaru)){
					$last=count($kegiatan_terbaru)-1;
                    foreach($kegiatan_terbaru as $ky=>$kgt){
							$tg=tanggal($kgt->tgl_keg." 00:00:00");
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
                                                <p style="color:#287cca;">Tanggal : '.$tg[2].'</p>
                                                <p style="line-height:120%;padding-top:10px;text-align:justify;">'.$kgt->keterangan.'</p>
                                            </div>
                                        </div> 
                                    </div>    
                                </div>';
					?>
						<!-- **Column One Half** -->   	
						<div class="column one-half  <?if($last=$ky){echo "last";}else{echo "brthome";}?>">
							<!-- **Team** -->
							<div class="team">          
								<div class="image"> <img src="<?=base_url('upload/images/thumb/'.$kgt->foto.'')?>" alt="" title="" /> </div>
								<h5> <a href="#view_detail_kegiatan_<?=$kgt->id_kegiatan?>" class="modal_dialog"><?=$kgt->judul?> </a></h5>
								<h6 class="role"> <? $tg=tanggal($kgt->tgl_keg." 00:00:00"); echo $tg[2];?> </h6>
								<p>  <?
								$keterangan = explode(' ',$kgt->keterangan);
                                                
                                                for($i=0;$i<count($keterangan);$i++) {
                                                    if($keterangan[$i]!='' and $i<=15) {
                                                        echo $keterangan[$i].' ';
                                                    }
                                                }
								?> </p>             
							</div> <!-- **Team - End** -->               
						</div><!-- **Column One Half - End** --> 
					<?
                }
                }
            ?>    
        </div>
        <div class="tabs-frame-content" style="display: none;">
            <div class="row-fluid">
                <?php
                    $jurnalis = session_jurnalis();
                    if(!empty($jurnalis))
                    {
                        echo '<div style="display: none;" class="row-fluid">
                                <div class="span6 tinggi_pesan" id="form_kegiatan_baru">
                                    <div class="status_style">
                                        <div class="workplace">
                                            <div class="head clearfix">
                                                <div class="ibw-archive"></div>
                                                <h1>Tambah Kegiatan Baru</h1>
                                            </div>
                                        </div>
                                    </div><br>
                                    <form method="POST" action="'.site_url('sos/siswa/kegiatan_simpan').'" enctype="multipart/form-data">
							<input type="hidden" name="'.$this->security->get_csrf_token_name().'" value="'.$this->security->get_csrf_hash().'">';
                                        echo '<input type="hidden" name="sekolah" value="'.$this->session->userdata['user_authentication']['id_sekolah'].'"/>';
                                        echo '<label>Judul</label>
                                        <input type="text" name="judul" style="background:white;width:95%;"/>
                                        <label>Tanggal Kegiatan</label>
                                        <input type="text" name="tgl_kegiatan" style="background:white;width:95%;"/>
                                        <label>Jam</label>
                                        <input type="text" name="jam" style="background:white;width:95%;"/>
                                        <label>Tempat</label>
                                        <input type="text" name="tempat" style="background:white;width:95%;"/>
                                        <label>Kegiatan</label>
                                        <textarea name="kegiatan" style="background:white;width:95%;min-height:70px;">
                                            
                                        </textarea>
                                        <label>Foto</label>
                                        <input type="file" name="foto"/><br>
                                        <input type="submit" name="Tambah Siswa" class="button small lightgrey" value="Save Data"/>
                                    </form>
                                </div>
                            </div>';
                        echo '<div class="span12 right">
                                <a href="#form_kegiatan_baru" class="modal_dialog button small blue" style="margin-right:20px;">Tambah Kegiatan</a>
                            </div>';      
                    }
                ?>
            </div>
            <?php
                $no=0;
                $master_dtl  = '';
                $dtl         = '';
                if(!empty($kegiatan['data'])) {
				$last=count($kegiatan['data'])-1;
                    foreach($kegiatan['data'] as $ky=>$kgt) {
						$tg=tanggal($kgt->tgl_keg." 00:00:00"); 
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
                                            <img src="'.base_url(!empty($kgt->foto) ? 'upload/images/thumb/'.$kgt->foto : 'asset/default/images/no_profile.jpg').'" alt="" title="" style="float:left;margin-right:15px;" class="img-polaroid">
                                            <h3>'.$kgt->judul.'</h3>
                                            <p style="color:#287cca;">Tanggal : '.$tg[2].'</p>
                                            <p style="line-height:120%;padding-top:10px;text-align:justify;">'.$kgt->keterangan.'</p>
                                        </div>
                                    </div> 
                                </div>    
                            </div>';
							
                        ?>
						<!-- **Column One Half** -->   	
						<div class="column one-half  <?if($last=$ky){echo "last";}else{echo "brthome";}?>">
							<!-- **Team** -->
							<div class="team">          
								<div class="image"> <img src="<?=base_url('upload/images/thumb/'.$kgt->foto.'')?>" alt="" title="" /> </div>
								<h5> <a href="#view_detail_kegiatan_<?=$kgt->id_kegiatan?>" class="modal_dialog"><?=$kgt->judul?> </a></h5>
								<h6 class="role"> <? $tg=tanggal($kgt->tgl_keg." 00:00:00"); echo $tg[2];?> </h6>
								<p>  <?
								$keterangan = explode(' ',$kgt->keterangan);
                                                
                                                for($i=0;$i<count($keterangan);$i++) {
                                                    if($keterangan[$i]!='' and $i<=15) {
                                                        echo $keterangan[$i].' ';
                                                    }
                                                }
								?> </p>             
							</div> <!-- **Team - End** -->               
						</div><!-- **Column One Half - End** --> 
						<?
                    
                    if(!empty($kegiatan['pagination'])) {
                        echo '<div class="pagination">
                            <ul>'.
                                $kegiatan['pagination'].'
                            </ul>                    	
                        </div>';
                    }
                    
                }
                }
            ?>
        </div>
    </div>
    <?//=print_iklan()?>
    </div>
</div>


