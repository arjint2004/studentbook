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
            $("#foto_siswa").click();
        });
        
        $(".back_edit").live('click',function(event){
            event.preventDefault();
            window.location.href='<?=site_url('sos/siswa/')?>'; 
        });
    });
</script>
<div class="portfolio column-one-half-with-sidebar">
    <?=print_iklan(); ?>
    <div class="row-fluid edit_data" style="text-align: left;">
        <div class="span12">
            <form class="sosial" enctype="multipart/form-data" method="post" action="<?=site_url('sos/siswa/ubah_data')?>">
            <input type="file" name="foto_siswa" onchange="readURL(this)" id="foto_siswa" style="opacity: 0;display: none;">
                <div class="tabs-container">
                    <ul class="tabs-frame">
                        <li><a href="#" class="current">Data Diri</a></li>
                        <li><a href="#">Password</a></li>
                    </ul>
                    <div class="tabs-frame-content" style="display: block;width: 95%;">
                        <div class="span3">
                            <img src="<?=base_url($siswa_edit->foto);?>" style="border: #e8e5de solid 5px;" width="142" height="155" id="foto_edit" class="img-pollaroid"><br>  
                            <a class="upload_dokumen" style="margin-left:20px;cursor: pointer;" id="cari_foto">Ubah Foto</a>
                        </div>
                        <div class="span9">
                            <dl>
                                <dt>Jenis Kelamin</dt>
                                <dd>
                                    <select name="jenis_kelamin">
                                        <option value="L" <?php if($siswa_edit->gender=="L") echo 'selected';?>>L</option>
                                        <option value="W" <?php if($siswa_edit->gender=="W") echo 'selected';?>>W</option>
                                    </select>
                                    <?=form_error('jenis_kelamin','<br><span class="konfirm_error">','</span>')?>
                                </dd>
                            </dl>
                            <dl>
                                <dt>Tanggal Lahir</dt>
                                <dd>
                                    <input type="text" class="text-field datepicker" name="tgl_lahir" style="margin: 0px;" value="<?=$siswa_edit->tglahir?>">                       
                                    <?=form_error('tgl_lahir','<br><span class="konfirm_error">','</span>')?>
                                </dd>
                            </dl>
                            <dl>
                                <dt>Alamat</dt>
                                <dd>
                                    <input type="text" class="text-field" name="alamat" style="margin: 0px;" value="<?=$siswa_edit->alamat?>">
                                    <?=form_error('alamat','<br><span class="konfirm_error">','</span>')?>
                                </dd>
                            </dl>
                            <dl>
                                <dt>Telp/HP</dt>
                                <dd>
                                    <input type="text" class="text-field" name="telp" value="<?=$siswa_edit->telp?>" style="margin: 0px;" />
                                    <?=form_error('telp','<br><span class="konfirm_error">','</span>')?>
                                </dd>
                            </dl>
                            <dl>
                                <dt>Email</dt>
                                <dd>
                                    <input type="text" class="text-field" name="email" value="<?=$siswa_edit->email?>" style="margin: 0px;" />
                                    <?=form_error('email','<br><span class="konfirm_error">','</span>')?>
                                </dd>
                            </dl>
                            <dl>
                                <dt>Nama Orang Tua</dt>
                                <dd>
                                    <input type="text" class="text-field" name="orangtua" value="<?=$siswa_edit->NmOrtu?>" style="margin: 0px;"/>
                                    <?=form_error('orangtua','<br><span class="konfirm_error">','</span>')?>
                                </dd>
                            </dl>
                        </div> 
                    </div>
                    <div class="tabs-frame-content" style="display: none;">
                        <dl>
                            <dt>Password Lama</dt>
                            <dd>
                                <input type="password" class="text-field" name="pwd_lama" style="margin: 0px;"/>
                            </dd>
                        </dl>
                        <dl>
                            <dt>Password Baru</dt>
                            <dd>
                                <input type="password" class="text-field" name="pwd_baru" style="margin: 0px;"/>
                                <?=form_error('pwd_baru','<br><span class="konfirm_error">','</span>')?>
                            </dd>
                        </dl>
                        <dl>
                            <dt>Konfirmasi Password</dt>
                            <dd>
                                <input type="password" class="text-field" name="konfirm" style="margin: 0px;"/>
                                <?=form_error('konfirm','<br><span class="konfirm_error">','</span>')?>
                            </dd>
                        </dl>
                    </div>
                </div>
                <input type="hidden" name="edit_data" value="oke"/>
                <input type="submit" value="Ubah Data" class="button" />
                <button class="button back_edit">Kembali</button>
            </form>
        </div>
    </div>
    <?=print_iklan()?>
</div>