								<script>
								$(document).ready(function(){
									$('form#simpanbiodata').css('width','600px');
									$("form#simpanbiodata").each(function(){
										$container = $(this).next("div.error-container");
										//Validate Starts
										$(this).validate({
											onfocusout: function(element) {	$(element).valid();	},
											errorContainer: $container,
											rules:{
											  nama:{required:true,notEqual:''},
											  nis:{required:true,notEqual:''},
											  gender:{required:true,notEqual:'Pilih Gender'}
											}
										});//Validate End

									});
																
									$('form#simpanbiodata').submit(function(e){
										$frm = $(this);
										$nama = $frm.find('*[name=nama]').val();
										$nis = $frm.find('*[name=nis]').val();
										$gender = $frm.find('*[name=gender]').val();
										
										/*if($('select#kelas_addpert').val()==null){
											$('select#kelas_addpert').css('border','1px solid red');
											return false;
										}else{
											$('select#kelas_addpert').css('border','1px solid #D8D8D8');
										}*/
										
										if($frm.find('*[name=nama]').is('.valid') &&   $frm.find('*[name=nis]').is('.valid') &&   $frm.find('*[name=gender]').is('.valid') ) {
											$("#simpanbiodata").append("<div class=\"error-box\" style='display: block; top: 50%; position: fixed; left: 46%;'></div>");
											$(".error-box").html("Memproses Data").fadeIn("slow");
											$.ajax({
												type: "POST",
												data: $(this).serialize()+'&'+$('form#nilai').serialize(),
												url: $(this).attr('action'),
												beforeSend: function() {
													$("#simpanpr").after("<img id='wait' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
												},
												error	: function(){
															$(".error-box").delay(1000).html('Pemrosesan data gagal');
															$(".error-box").delay(1000).fadeOut("slow",function(){
																$(this).remove();
															});
																				
												},
												success: function(msg) {
															$("#wait").remove();
															$(".error-box").delay(1000).html('Data berhasil di simpan');
															$(".error-box").delay(1000).fadeOut("slow",function(){
																$(this).remove();
															});	
												}
											});
											return false;
										}
										
										return false;
									});//Submit End	
									$('.datepicker').datepick();
								});
								</script>	

<?php echo form_open('akademik/biodatasiswa/edit',array('id'=>'simpanbiodata'));?>
<table border="1" style="width:100%;" id="allset" class="noborder pg1">
 	<thead>
		<tr>
			<th colspan="3" style="text-align:right;">
				<a title="" class="button small light-grey absenbutton" onclick="$('#simpanbiodata').submit();"> Simpan </a>
			</th>
		</tr>

	</thead>
 <tbody>
    <tr>
      <td style="width:215px;text-align:left;">Nama Peserta Didik (Lengkap)</td>
      <td width="1">:</td>
      <td><input type="text" name="nama" value="<?=$siswa[0]['nama']?>" /></td>
    </tr>
    <tr>
      <td style="text-align:left;">Nomor Induk</td>
      <td>:</td>
      <td><input type="text" name="nis" value="<?=$siswa[0]['nis']?>" /></td>
    </tr>
    <tr>
      <td style="text-align:left;">Tempat Lahir</td>
      <td>:</td>
      <td><input type="text" name="tempat_lahir" value="<?=$siswa[0]['tempat_lahir']?>" /></td>
    </tr>
    <tr>
      <td style="text-align:left;">Tanggal Lahir</td>
      <td>:</td>
      <td><input type="text" name="tglahir"  style="width:100px;" class="datepicker" value="<?=$siswa[0]['tglahir']?>" /></td>
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
	  </td>
    </tr>
    <tr>
      <td style="text-align:left;">Agama</td>
      <td>:</td>
      <td><input type="text" name="agama" value="<?=$siswa[0]['agama']?>" /></td>
    </tr>
    <tr>
      <td style="text-align:left;">Status Dalam keluarga</td>
      <td>:</td>
      <td><input type="text" name="status_kel" value="<?=$siswa[0]['status_kel']?>" /></td>
    </tr>
    <tr>
      <td style="text-align:left;">Anak Ke</td>
      <td>:</td>
      <td><input type="text" name="anak_ke" value="<?=$siswa[0]['anak_ke']?>" /></td>
    </tr>
    <tr>
      <td style="text-align:left;">Alamat Peserta Didik</td>
      <td>:</td>
      <td>
		<textarea name="alamat"><?=$siswa[0]['alamat']?></textarea>
	  </td>
    </tr>
    <tr>
      <td style="text-align:left;">Kota</td>
      <td>:</td>
      <td><input type="text" name="kota" value="<?=$siswa[0]['kota']?>" /></td>
    </tr>
    <tr>
      <td style="text-align:left;">No HP Siswa</td>
      <td>:</td>
      <td><input type="text" name="hp" value="<?=$siswa[0]['hp']?>" /></td>
    </tr>
    <tr>
      <td style="text-align:left;">Email Siswa</td>
      <td>:</td>
      <td><input type="text" name="email" value="<?=$siswa[0]['email']?>" /></td>
    </tr>
    <tr>
      <td style="text-align:left;">Nomor Telpon RUmah</td>
      <td>:</td>
      <td><input type="text" name="telp" value="<?=$siswa[0]['telp']?>" /></td>
    </tr>
    <tr>
      <td style="text-align:left;">Sekolah Asal</td>
      <td>:</td>
      <td><input type="text" name="sekolah_asal" value="<?=$siswa[0]['sekolah_asal']?>" /></td>
    </tr>
    <tr>
      <td style="text-align:left;">Diterima di dekolah Ini</td>
      <td></td>
      <td ></td>
    </tr>
    <tr>
      <td style="text-align:left;">&nbsp;&nbsp;&nbsp;&nbsp;Di Kelas</td>
      <td>:</td>
      <td><input type="text" name="diterima_dikelas" value="<?=$siswa[0]['diterima_dikelas']?>" /></td>
    </tr>
    <tr>
      <td style="text-align:left;">&nbsp;&nbsp;&nbsp;&nbsp;Pada Tanggal</td>
      <td>:</td>
      <td><input type="text" name="tgl_diterima" class="datepicker" style="width:100px;" value="<?=$siswa[0]['tgl_diterima']?>" /></td>
    </tr>
    <tr>
      <td style="text-align:left;">&nbsp;&nbsp;&nbsp;&nbsp;Nama Ayah</td>
      <td>:</td>
      <td><input type="text" name="NmOrtu" value="<?=$siswa[0]['NmOrtu']?>" /></td>
    </tr>
    <tr>
      <td style="text-align:left;">&nbsp;&nbsp;&nbsp;&nbsp;Nama Ibu </td>
      <td>:</td>
      <td><input type="text" name="NmOrtuIbu" value="<?=$siswa[0]['NmOrtuIbu']?>" /></td>
    </tr>
    <tr>
      <td style="text-align:left;">Alamat Orang Tua </td>
      <td>:</td>
      <td>
	  <textarea name="alamat_ortu"><?=$siswa[0]['alamat_ortu']?></textarea>
	  </td>
    </tr>
    <tr>
      <td style="text-align:left;">&nbsp;&nbsp;&nbsp;&nbsp;Nomor Telp rumah </td>
      <td>:</td>
      <td><input type="text" name="telp_rmh_ortu" value="<?=$siswa[0]['telp_rmh_ortu']?>" /></td>
    </tr>
    <tr>
      <td style="text-align:left;">Pekerjaan Orang Tua </td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td style="text-align:left;">&nbsp;&nbsp;&nbsp;&nbsp;a. Ayah </td>
      <td>:</td>
      <td><input type="text" name="pekerjaan_ortu_ayah" value="<?=$siswa[0]['pekerjaan_ortu_ayah']?>" /></td>
    </tr>
    <tr>
      <td style="text-align:left;">&nbsp;&nbsp;&nbsp;&nbsp;b. Ibu </td>
      <td>:</td>
      <td><input type="text" name="pekerjaan_ortu_ibu" value="<?=$siswa[0]['pekerjaan_ortu_ibu']?>" /></td>
    </tr>
    <tr>
      <td style="text-align:left;">Nama Wali Peserta Didik </td>
      <td>:</td>
      <td><input type="text" name="nama_wali" value="<?=$siswa[0]['nama_wali']?>" /></td>
    </tr>
    <tr>
      <td style="text-align:left;">Alamat Wali Peserta Didik </td>
      <td>:</td>
      <td><textarea name="alamat_wali"><?=$siswa[0]['alamat_wali']?></textarea></td>
    </tr>
    <tr>
      <td style="text-align:left;">&nbsp;&nbsp;&nbsp;&nbsp;Nomor Telp Rumah </td>
      <td>:</td>
      <td><input type="text" name="telp_rumah_wali" value="<?=$siswa[0]['telp_rumah_wali']?>" /></td>
    </tr>
    <tr>
      <td style="text-align:left;">Pekerjaan Wali Peserta Didik </td>
      <td>:</td>
      <td><input type="text" name="pekerjaan_wali" value="<?=$siswa[0]['pekerjaan_wali']?>" /></td>
    </tr>
  </tbody>
 	<thead>
		<tr>
			<th colspan="3" style="text-align:right;">
				<a title="" class="button small light-grey absenbutton"  onclick="$('#simpanbiodata').submit();"> Simpan </a>
				<input type="hidden" name="param" value="<?=$param?>" />
			</th>
		</tr>

	</thead>
</table>
<?php echo form_close(); ?> 