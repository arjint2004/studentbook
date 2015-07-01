<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
            $('#foto_edit')
            .attr('src', e.target.result)
            .width(142)
            .height(155);
            };
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    $(function(){
        $("#cari_foto").live('click',function(){
            $("#foto_pegawai").click();
        });
        
    });
</script>
<div class="portfolio column-one-half-with-sidebar">
    <?=print_iklan(); ?>
    
    <div class="row-fluid edit_data" style="text-align: left;">
        <div class="span12">
            <form class="sosial" id="sosialeditp" enctype="multipart/form-data" method="post" action="<?=site_url('sos/pegawai/ubah_data')?>">
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
            <input type="file" name="foto_pegawai" onchange="readURL(this)" id="foto_pegawai" style="opacity: 0;display: none;">
                <div class="tabs-container">
                    <ul class="tabs-frame">
                        <li><a href="#" class="current">Data Diri</a></li>
                        <li><a href="#">Password</a></li>
                    </ul>
                    <div class="tabs-frame-content" style="display: block;width: 95%;">
                        <div class="span3">
							<? if($pegawai_edit->foto==''){$pegawai_edit->foto='asset/default/images/no_profile.jpg';}?>
                            <img src="<?=base_url($pegawai_edit->foto);?>" style="border: #e8e5de solid 5px;" width="142" height="155" id="foto_edit" class="img-pollaroid"><br>  
                            <a class="upload_dokumen  button small light-grey absenbutton" style="margin-left:20px;cursor: pointer;" id="cari_foto">Ubah Foto</a>
                        </div>
                        <div class="span9">
                            <dl>
                                <dt>Nama</dt>
                                <dd>
                                    <input type="text" class="text-field" name="nama" value="<?=$pegawai_edit->nama?>" required />
                                    <?=form_error('nama','<br><span class="konfirm_error">','</span>')?>
                                </dd>
                            </dl>
                            <dl>
                                <dt>Alamat</dt>
                                <dd>
                                    <textarea class="text-field" style="height:70px;"name="alamat" rows="5"><?=$pegawai_edit->alamat?></textarea>
                                    <?=form_error('alamat','<br><span class="konfirm_error">','</span>')?>
                                </dd>
                            </dl>
                            <dl>
                                <dt>Hp/Telp</dt>
                                <dd>
                                    <input type="text" class="text-field" name="hp" value="<?=$pegawai_edit->hp?>">
                                    <?=form_error('hp','<br><span class="konfirm_error">','</span>')?>
                                </dd>
                            </dl>
                            <dl>
                                <dt>Email</dt>
                                <dd>
                                    <input type="text" class="text-field" name="email" value="<?=$pegawai_edit->email?>" required />
                                    <?=form_error('email','<br><span class="konfirm_error">','</span>')?>
                                </dd>
                            </dl>
                            <dl>
                                <dt>Kota</dt>
                                <dd>
                                    <input type="text" class="text-field" name="kota" value="<?=$pegawai_edit->kota?>" required />
                                    <?=form_error('kota','<br><span class="konfirm_error">','</span>')?>
                                </dd>
                            </dl>
                        </div> 
                    </div>
                    <div class="tabs-frame-content" style="display: none;">
                        <dl>
                            <dt>Password Lama</dt>
                            <dd>
                                <input type="password" class="text-field" name="pwd_lama" style="margin: 0px;" required />
                            </dd>
                        </dl>
                        <dl>
                            <dt>Password Baru</dt>
                            <dd>
                                <input type="password" class="text-field" name="pwd_baru" style="margin: 0px;" required />
                                <?=form_error('pwd_baru','<br><span class="konfirm_error">','</span>')?>
                            </dd>
                        </dl>
                        <dl>
                            <dt>Konfirmasi Password</dt>
                            <dd>
                                <input type="password" class="text-field" name="konfirm" style="margin: 0px;" required />
                                <?=form_error('konfirm','<br><span class="konfirm_error">','</span>')?>
                            </dd>
                        </dl>
                    </div>
                </div>
                <input type="hidden" name="edit_data" value="oke"/>
				<a title="" class=" button small light-grey absenbutton"  onclick="$('#sosialeditp').submit();"> Simpan </a>
				<a title="" class=" button small light-grey absenbutton"  onclick="window.location.href='<?=site_url('sos/pegawai/')?>';"> Kembali </a>
            </form>
        </div>
    </div>
    <?=print_iklan()?>
</div>