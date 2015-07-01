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
		
		$('#dateeditsiswa').datepick();
    });
	
</script>
<div class="portfolio column-one-half-with-sidebar">
    <div class="row-fluid edit_data" style="text-align: left;">
        <div class="span12">
            <form class="sosial" enctype="multipart/form-data" method="post" action="<?=site_url('sos/siswa/ubah_data')?>">
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
            <input type="file" name="foto_siswa" onchange="readURL(this)" id="foto_siswa" style="opacity: 0;display: none;">
                <div class="tabs-container">
                    <ul class="tabs-frame">
                        <li><a href="#" class="current">Data Diri</a></li>
                        <li><a href="#">Password</a></li>
                    </ul>
                    <div class="tabs-frame-content" style="display: block;width: 95%;">
						<?
						$siswa[0]=(array)$siswa_edit;
						?>
                        <table class="noborder">
						 <tbody>
							<tr>
							  <td style="width:215px;text-align:left;">Foto</td>
							  <td width="1">:</td>
							  <td style="text-align:left;">
							    <div class="span3">
									<img src="<?=base_url($siswa_edit->foto);?>" style="border: #e8e5de solid 5px;" width="142" height="155" id="foto_edit" class="img-pollaroid"><br>  
									<a class="upload_dokumen" style="margin-left:20px;cursor: pointer;" id="cari_foto">Ubah Foto</a>
								</div>
							  </td>
							</tr>
							<tr>
							  <td style="width:215px;text-align:left;">Nama Peserta Didik (Lengkap)</td>
							  <td width="1">:</td>
							  <td style="text-align:left;">
							  <input type="text" name="nama" value="<?=$siswa[0]['nama']?>" />
							  <?=form_error('nama','<br><span class="konfirm_error">','</span>')?>
							  </td>
							</tr>
							<tr>
							  <td style="text-align:left;">Nomor Induk</td>
							  <td>:</td>
							  <td style="text-align:left;">
							  <input type="text" name="nis" value="<?=$siswa[0]['nis']?>" />
							  <?=form_error('nis','<br><span class="konfirm_error">','</span>')?>
							  </td>
							</tr>
							<tr>
							  <td style="text-align:left;">Tempat Lahir</td>
							  <td>:</td>
							  <td style="text-align:left;">
							  <input type="text" name="tempat_lahir" value="<?=$siswa[0]['tempat_lahir']?>" />
							  <?=form_error('tempat_lahir','<br><span class="konfirm_error">','</span>')?>
							  </td>
							</tr>
							<tr>
							  <td style="text-align:left;">Tanggal Lahir</td>
							  <td>:</td>
							  <td style="text-align:left;"><input type="text" name="tglahir"  style="width:200px;" class="datepicker" value="<?=$siswa[0]['tglahir']?>" />
							  <?=form_error('tglahir','<br><span class="konfirm_error">','</span>')?>
							  </td>
							</tr>
							<tr>
							  <td style="text-align:left;">jebis Kelamin</td>
							  <td>:</td>
							  <td  style="text-align:left;">
								<select name="gender">
									<option value="">Pilih Gender</option>
									<option <? if($siswa[0]['gender']=='Laki-Laki'){echo 'selected';}?> value="Laki-Laki">Laki-Laki</option>
									<option <? if($siswa[0]['gender']=='Perempuan'){echo 'selected';}?>  value="Perempuan">Perempuan</option>
								</select>
								<?=form_error('gender','<br><span class="konfirm_error">','</span>')?>
							  </td>
							</tr>
							<tr>
							  <td style="text-align:left;">Agama</td>
							  <td>:</td>
							  <td style="text-align:left;"><input type="text" name="agama" value="<?=$siswa[0]['agama']?>" /></td>
							</tr>
							<tr>
							  <td style="text-align:left;">Status Dalam keluarga</td>
							  <td>:</td>
							  <td style="text-align:left;"><input type="text" name="status_kel" value="<?=$siswa[0]['status_kel']?>" /></td>
							</tr>
							<tr>
							  <td style="text-align:left;">Anak Ke</td>
							  <td>:</td>
							  <td style="text-align:left;"><input type="text" name="anak_ke" value="<?=$siswa[0]['anak_ke']?>" /></td>
							</tr>
							<tr>
							  <td style="text-align:left;">Alamat Peserta Didik</td>
							  <td>:</td>
							  <td style="text-align:left;">
								<textarea name="alamat"><?=$siswa[0]['alamat']?></textarea>
								<?=form_error('alamat','<br><span class="konfirm_error">','</span>')?>
							  </td style="text-align:left;">
							</tr>
							<tr>
							  <td style="text-align:left;">Kota</td>
							  <td>:</td>
							  <td style="text-align:left;"><input type="text" name="kota" value="<?=$siswa[0]['kota']?>" /></td>
							</tr>
							<tr>
							  <td style="text-align:left;">No HP Siswa</td>
							  <td>:</td>
							  <td style="text-align:left;"><input type="text" name="hp" value="<?=$siswa[0]['hp']?>" /></td>
							</tr>
							<tr>
							  <td style="text-align:left;">Email Siswa</td>
							  <td>:</td>
							  <td style="text-align:left;"><input type="text" name="email" value="<?=$siswa[0]['email']?>" /></td>
							</tr>
							<tr>
							  <td style="text-align:left;">Nomor Telpon RUmah</td>
							  <td>:</td>
							  <td style="text-align:left;"><input type="text" name="telp" value="<?=$siswa[0]['telp']?>" /></td>
							</tr>
							<tr>
							  <td style="text-align:left;">Sekolah Asal</td>
							  <td>:</td>
							  <td style="text-align:left;"><input type="text" name="sekolah_asal" value="<?=$siswa[0]['sekolah_asal']?>" /></td>
							</tr>
							<tr>
							  <td style="text-align:left;">Diterima di dekolah Ini</td>
							  <td></td>
							  <td ></td>
							</tr>
							<tr>
							  <td style="text-align:left;">&nbsp;&nbsp;&nbsp;&nbsp;Di Kelas</td>
							  <td>:</td>
							  <td style="text-align:left;"><input type="text" name="diterima_dikelas" value="<?=$siswa[0]['diterima_dikelas']?>" /></td>
							</tr>
							<tr>
							  <td style="text-align:left;">&nbsp;&nbsp;&nbsp;&nbsp;Pada Tanggal</td>
							  <td>:</td>
							  <td style="text-align:left;"><input type="text" name="tgl_diterima" class="datepicker" style="width:200px;" value="<?=$siswa[0]['tgl_diterima']?>" /></td>
							</tr>
							<tr>
							  <td style="text-align:left;">&nbsp;&nbsp;&nbsp;&nbsp;Nama Ayah</td>
							  <td>:</td>
							  <td style="text-align:left;"><input type="text" name="NmOrtu" value="<?=$siswa[0]['NmOrtu']?>" /></td>
							</tr>
							<tr>
							  <td style="text-align:left;">&nbsp;&nbsp;&nbsp;&nbsp;Nama Ibu </td>
							  <td>:</td>
							  <td style="text-align:left;"><input type="text" name="NmOrtuIbu" value="<?=$siswa[0]['NmOrtuIbu']?>" /></td>
							</tr>
							<tr>
							  <td style="text-align:left;">Alamat Orang Tua </td>
							  <td>:</td>
							  <td style="text-align:left;">
							  <textarea name="alamat_ortu"><?=$siswa[0]['alamat_ortu']?></textarea>
							  </td>
							</tr>
							<tr>
							  <td style="text-align:left;">&nbsp;&nbsp;&nbsp;&nbsp;Nomor Telp rumah </td>
							  <td>:</td>
							  <td style="text-align:left;"><input type="text" name="telp_rmh_ortu" value="<?=$siswa[0]['telp_rmh_ortu']?>" /></td>
							</tr>
							<tr>
							  <td style="text-align:left;">Pekerjaan Orang Tua </td>
							  <td></td>
							  <td></td>
							</tr>
							<tr>
							  <td style="text-align:left;">&nbsp;&nbsp;&nbsp;&nbsp;a. Ayah </td>
							  <td>:</td>
							  <td style="text-align:left;"><input type="text" name="pekerjaan_ortu_ayah" value="<?=$siswa[0]['pekerjaan_ortu_ayah']?>" /></td>
							</tr>
							<tr>
							  <td style="text-align:left;">&nbsp;&nbsp;&nbsp;&nbsp;b. Ibu </td>
							  <td>:</td>
							  <td style="text-align:left;"><input type="text" name="pekerjaan_ortu_ibu" value="<?=$siswa[0]['pekerjaan_ortu_ibu']?>" /></td>
							</tr>
							<tr>
							  <td style="text-align:left;">Nama Wali Peserta Didik </td>
							  <td>:</td>
							  <td style="text-align:left;"><input type="text" name="nama_wali" value="<?=$siswa[0]['nama_wali']?>" /></td>
							</tr>
							<tr>
							  <td style="text-align:left;">Alamat Wali Peserta Didik </td>
							  <td>:</td>
							  <td style="text-align:left;"><textarea name="alamat_wali"><?=$siswa[0]['alamat_wali']?></textarea></td>
							</tr>
							<tr>
							  <td style="text-align:left;">&nbsp;&nbsp;&nbsp;&nbsp;Nomor Telp Rumah </td>
							  <td>:</td>
							  <td style="text-align:left;"><input type="text" name="telp_rumah_wali" value="<?=$siswa[0]['telp_rumah_wali']?>" /></td>
							</tr>
							<tr>
							  <td style="text-align:left;">Pekerjaan Wali Peserta Didik </td>
							  <td>:</td>
							  <td style="text-align:left;"><input type="text" name="pekerjaan_wali" value="<?=$siswa[0]['pekerjaan_wali']?>" /></td>
							</tr>
						  </tbody>
						</table>
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
                <input type="submit" value="Simpan" class="button small light-grey" />
                <button class="button small light-grey">Kembali</button>
            </form>
        </div>
    </div>
</div>