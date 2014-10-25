<script>
    $(function(){
	<? if(isset($sekolah[0]['kec'])){?>
	    $.post("<?=site_url('sos/sekolah/get_kota')?>",{ id : $('select#provinsi').val()  },
             function(data){
                var select ="<option value=''>Pilih Kabupaten</option>";
                var selected ="";
				var idkab=parseInt(<?=$sekolah[0]['kota']?>);
                $.each( data, function(i, n){
					//alert(n.IDkota);
					if(idkab==n.IDkota){ selected='selected';}else{selected='';}
					select = select + '<option '+selected+' value="' + n.IDkota + '">' + n.NmKota + '</option>';
				})
                $("#kabupaten").html(select);
				
            }, "json");
		<? } ?>
		
        $("#provinsi").live("change",function(){
          var provinsi = $("#provinsi option:selected").val();
          $.post("<?=site_url('sos/sekolah/get_kota')?>",{ id : $(this).val()  },
             function(data){
                var select ="";
                $.each( data, function(i, n){
                  select = select + '<option value="' + n.IDkota + '">' + n.NmKota + '</option>';
              })
                $("#kabupaten").html(select);
                if(kabupaten) $("#kabupaten select").val(kabupaten);
            }, "json"
            );
      })
	  
        $("#email_sk").live("blur",function(){
			var self = $(this);
			$.ajax({
					type: "POST",
					data: 'username='+$(self).val(),
					url: '<?=base_url()?>admin/sekolah/cekusername',
					beforeSend: function() {
						$(self).after("<img id='wait' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
					},
					success: function(msg) {
						$("#wait").remove();
						if(msg>0){
							$(self).after('<span style="color:red;">Email sudah terdaftar</span>');
							$(self).val('');
							$(self).focus();
						}
						
					}
			});
			return false;
        })
		
        $("select#jenjang").live("change",function(){
			$("input#bentuk").val($(this).find(":selected").text());
        })  
    });
</script>		
<link type="text/css" href="<?=$this->config->item('css');?>datepick.css" rel="stylesheet">
<script type="text/javascript" src="<?=$this->config->item('js');?>jquery.datepick.js"></script>
<script type="text/javascript" src="<?=$this->config->item('js');?>jquery.datepick-id.js"></script>

<script type="text/javascript">
$(function() {
	$('#popupDatepicker').datepick();
});
function getadd(){

}
</script>	
			<? //pr($sekolah);?>
			<h1 class="with-subtitle"> Ubah Data Profile Sekolah </h1>
				<h6 class="subtitle"> Pengaturan profile dan data identitas sekolah </h6>
                <div class="styled-elements">
					<!--<a id="addguru" onclick="$('#ajaxside').load('<?=base_url()?>admin/semester/adddata')" title="guru" class="readmore readmoreasb"> <span> Tambah semester </span></a>-->
					<div id="ajaxside"></div>
					<div id="listsemester">
						<div id="contentpage">
						<form action="" method="post" id="formprofilesek" />
							<input type="hidden"  value="1" name="ajax">
							<table class="tableprofil">
								<thead>
									<tr> 
										<th colspan="3">Profil Sekolah</th>
									</tr>                            
								</thead>
								<tbody>	
									<tr>
										<td class="title" colspan="3"><input type="submit" class="simpanprofilr" name="simpan" value="Simpan"></td>
									</tr>
									<tr>
										<td width="150" class="title">Nama Sekolah</td>
										<td width="1">:</td>
										<td class="title"><input id="namaSekolah" type="text" size="40" value="<?=$sekolah[0]['nama_sekolah']?>" name="nama_sekolah"></td>
									</tr>
									<tr>
										<td width="150" class="title">NSS</td>
										<td width="1">:</td>
										<td class="title"><input id="nss" type="text" size="40" value="<?=$sekolah[0]['nss']?>" name="nss"></td>
									</tr>
									<tr>
										<td width="150" class="title">Foto Profil</td>
										<td width="1">:</td>
										<td class="title">
											<input type="file" name="images" class="images" id="foto_profil" img="<?=base64_encode($sekolah[0]['foto_profil'])?>"/>
											<div class="response"></div>
											<div class="responseimg"><img width="120" src="<?=base_url()?>upload/akademik/sekolah/<?=$sekolah[0]['foto_profil']?>" /></div>
											</div>
										</td>
									</tr>
									<tr>
										<td width="150" class="title">Logo</td>
										<td width="1">:</td>
										<td class="title">
											<input type="file" style="float:none;margin:0;" name="images" class="images" id="logo"  img="<?=base64_encode($sekolah[0]['logo'])?>"/>
											<div class="response"></div>
											<div class="responseimg"><img width="120" src="<?=base_url()?>upload/akademik/sekolah/<?=$sekolah[0]['logo']?>" /></div>
											</div>
										</td>
									</tr>
									<tr>
										<td class="title">Status Sekolah</td>
										<td width="1">:</td>
										<td class="title">
										<select name="status">
											<option <? if($sekolah[0]['status']=='Negeri'){echo"selected";}?>>Negeri</option>
											<option <? if($sekolah[0]['status']=='Swasta'){echo"selected";}?>>Swasta</option>
										</select>
										
										</td>
									</tr>
									<tr>
										<td class="title">Kepala Sekolah</td>
										<td width="1">:</td>
										<td class="title">
											<select name="id_kepala_sekolah"  id="selectkepsek" class="adddata">
												<option value="">Pilih Kepala Sekolah</option>
												<? foreach($pegawai as $oppeg){?>
												<option <? if($kepsek[0]['id']==$oppeg['id']){echo "selected";}?> value="<?=$oppeg['id']?>"><?=$oppeg['nama']?></option>
												<? } ?>
											</select>
										</td>
									</tr>
									<tr>
										<td class="title">Propinsi</td>
										<td width="1">:</td>
										<td class="title">
										<!--<input type="text" size="30" value="<?=$sekolah[0]['prop']?>" name="prop">-->
										<?php
											if(!empty($provinsi)) {
												echo '<select name="prop" id="provinsi">';
												echo '<option value="">Pilih Provinsi</option>';
												foreach($provinsi as $pro) {
													if($sekolah[0]['prop']==$pro->IDprov){$sl='selected';}else{$sl='';}
													echo '<option '.$sl.' value="'.$pro->IDprov.'">'.$pro->NmProv.'</option>';
												}
												echo '</select>';
											}
										?>
										</td>
									</tr>
									<tr>
										<td class="title">Kabupaten/Kota</td>
										<td width="1">:</td>
										<td class="title">
										<!--<input type="text" size="30" value="<?=$sekolah[0]['kec']?>" name="kec">-->
										
										<select name="kota" id="kabupaten">
											<option value="">Pilih Kabupaten</option>
										</select>
										</td>
									</tr>
									<tr>
										<td class="title">Kecamatan</td>
										<td width="1">:</td>
										<td class="title"><input type="text" size="20" value="<?=$sekolah[0]['kec']?>" name="kec"></td>
									</tr>
									<tr>
										<td class="title">Kelurahan/Desa</td>
										<td width="1">:</td>
										<td class="title"><input type="text" size="20" value="<?=$sekolah[0]['desa']?>" name="desa"></td>
									</tr>
									<tr>
										<td class="title">Alamat Sekolah</td>
										<td width="1">:</td>
										<td class="title"><input type="text" size="50" value="<?=$sekolah[0]['alamat_sekolah']?>" name="alamat_sekolah"></td>
									</tr>
									<tr>
										<td class="title">Kodepos</td>
										<td width="1">:</td>
										<td class="title"><input type="text" size="10" class="kodePos" value="<?=$sekolah[0]['kodepos']?>" name="kodepos"></td>
									</tr>
									<tr>
										<td class="title">Fax</td>
										<td width="1">:</td>
										<td class="title"><input type="text" size="20" value="<?=$sekolah[0]['fax']?>" name="fax"></td>
									</tr>
									<tr>
										<td class="title">email</td>
										<td width="1">:</td>
										<td class="title"><input type="text" class="email" size="30" value="<?=$sekolah[0]['email']?>" readonly name="email"></td>
									</tr>
									<tr>
										<td class="title">Website</td>
										<td width="1">:</td>
										<td class="title"><input class="url" type="text" size="50" value="<?=$sekolah[0]['web']?>" name="web"></td>
									</tr>
								</tbody>
							</table>
							<table class="tableprofil">
								<thead>
									<tr> 
										<th colspan="3">Akreditasi</th>
									</tr>                            
								</thead>
								<tbody>	
									<!--<tr>
										<td width="150" class="title">Jenjang Sekolah</td>
										<td width="1">:</td>
										<td class="title">
										<select class="required" name="id_jenjang">
											<option value="<?=$this->session->userdata['ak_setting']['jenjang'][0]['id']?>"><?=$this->session->userdata['ak_setting']['jenjang'][0]['nama']?></option>
										</select>
										</td>
									</tr>	
									<tr>
										<td width="150" class="title">Bentuk Sekolah</td>
										<td width="1">:</td>
										<td class="title">
										<?//=$sekolah[0]['bentuk']?>
										<select id="bentuk" name="bentuk">
											<option value="">Pilih Bentuk Sekolah</option>
											<option <? if($sekolah[0]['bentuk']=='SD'){echo "selected";}?> value="SD">SD</option>
											<option <? if($sekolah[0]['bentuk']=='SMP'){echo "selected";}?> value="SMP">SMP</option>
											<option <? if($sekolah[0]['bentuk']=='SMA'){echo "selected";}?> value="3">SMA</option>
											<option <? if($sekolah[0]['bentuk']=='SMK'){echo "selected";}?> value="SMK">SMK</option>
											<option <? if($sekolah[0]['bentuk']=='MI'){echo "selected";}?> value="MI">MI</option>
											<option <? if($sekolah[0]['bentuk']=='MTs'){echo "selected";}?> value="MTs">MTs</option>
											<option <? if($sekolah[0]['bentuk']=='MA'){echo "selected";}?> value="MA">MA</option>
										</select>
										</td>
									</tr>-->
									<tr>
										<td class="title">SK Akreditasi</td>
										<td width="1">:</td>
										<td class="title"><input type="text" size="50" value="<?=$sekolah[0]['sk_akreditasi']?>" name="sk_akreditasi"></td>
									</tr>
									<tr>
										<td class="title">Tanggal Akreditasi</td>
										<td width="1">:</td>
										<td class="title"><input type="text" size="20" value="<?=$sekolah[0]['tgl_sk_akreditasi']?>" class="two " id="popupDatepicker" readonly="readonly" name="tgl_sk_akreditasi"></td>
									</tr>
									<tr>
										<td class="title">Terakreditasi</td>
										<td width="1">:</td>
										<td class="title">
											<select class="required" name="terakreditasi">
												<option value="A" selected="">A</option>
												<option value="B">B</option>
												<option value="C">C</option>
											</select>
										</td>
									</tr>
								</tbody>
							</table>
							
							<table class="tableprofil">
								<thead>
									<tr> 
										<th colspan="3">Yayasan Penyelenggara Sekolah</th>
									</tr>                            
								</thead>

								<tbody>	
									<tr>
										<td width="150" class="title">Nama Yayasan</td>
										<td width="1">:</td>
										<td class="title"><input type="text" size="40" value="<?=$sekolah[0]['yayasan']?>" name="yayasan"></td>
									</tr>
									<tr>
										<td class="title">Alamat Yayasan</td>
										<td width="1">:</td>
										<td class="title"><input type="text" size="50" value="<?=$sekolah[0]['alamat_yys']?>" name="alamat_yys"></td>
									</tr>
									<tr>
										<td class="title">Kecamatan</td>
										<td width="1">:</td>
										<td class="title"><input type="text" size="30" value="<?=$sekolah[0]['kec_yys']?>" name="kec_yys"></td>
									</tr>
									<tr>
										<td class="title">Kota</td>
										<td width="1">:</td>
										<td class="title"><input type="text" size="30" value="<?=$sekolah[0]['kota_yys']?>" name="kota_yys"></td>
									</tr>
									<tr>
										<td class="title">Propinsi</td>
										<td width="1">:</td>
										<td class="title"><input type="text" size="30" value="<?=$sekolah[0]['prop_yys']?>" name="prop_yys"></td>
									</tr>
									<tr>
										<td class="title">Telpon Yayasan</td>
										<td width="1">:</td>
										<td class="title"><input type="text" size="30" value="<?=$sekolah[0]['telp_yys']?>"  name="telp_yys"></td>
									</tr>
									<tr>
										<td class="title">Akta Pendirian Yayasan</td>
										<td width="1">:</td>
										<td class="title"><input style="margin:0;" type="text" size="30" value="<?=$sekolah[0]['akte_yys']?>" name="akte_yys"></td>
									</tr>
									<!--<tr>
										<td class="title">Kelompok Yayasan</td>
										<td width="1">:</td>
										<td class="title">
										<select style="margin:0;" name="kel_yys">
											<option value="Aisyiah">Aisyiah</option>
											<option value="MPK Muhammadiyah">MPK Muhammadiyah</option>
											<option value="LP Maarif">LP Maarif</option>
											<option value="ML Taman Siswa">ML Taman Siswa</option>
											<option value="MPPK">MPPK</option>
											<option value="MNPK">MNPK</option>
											<option value="Perwari">Perwari</option>
											<option value="Dharma Pertiwi">Dharma Pertiwi</option>
											<option value="YPLP PGRI">YPLP PGRI</option>
											<option value="Lainnya" selected="">Lainnya</option>
										</select>
										</td>
									</tr>-->
								</tbody>
							</table>
							<table class="tableprofil">
								<thead>
									<tr> 
										<th colspan="3">Data Pendaftar</th>
									</tr>                            
								</thead>

								<tbody>	
									<tr>
										<td width="150" class="title">Nama Pendaftar</td>
										<td width="1">:</td>
										<td class="title"><input type="text" size="40" value="<?=$sekolah[0]['nama_pendaftar']?>" name="nama_pendaftar"></td>
									</tr>
									<tr>
										<td class="title">Email Pendaftar</td>
										<td width="1">:</td>
										<td class="title"><input type="text" size="50" value="<?=$sekolah[0]['email_pendaftar']?>" name="email_pendaftar"></td>
									</tr>
									<tr>
										<td class="title">Telp Pendaftar</td>
										<td width="1">:</td>
										<td class="title"><input type="text" size="30" value="<?=$sekolah[0]['telp_pendaftar']?>" name="telp_pendaftar"></td>
									</tr>
									
									<tr>
										<td colspan="3" class="title"><input type="submit" value="Simpan" name="simpan" class="simpanprofilr"></td>
									</tr>
								</tbody>
							</table>
							</form>
						</div>
                    <div class="hr"> </div>
                    <div class="clear"> </div>
                </div> <!-- **Styled Elements - End** --> 
				<script>
				jQuery(document).ready(function($){	
					
					

					$('select#selectkepsek').change(function(){
						var self=$(this);
						$.ajax({
							type: "POST",
							data: '&id_user='+$(self).val()+'&id_det_group=<?=$kepsek[0]['id_det_group']?>',
							url: base_url+'admin/sekolah/setkepsek',
							beforeSend: function() {
								$(self).after("<img id='wait' src='"+config_images+"loading.png' />");
							},
							success: function(msg) {
								$('#wait').remove();
							}
						});
						return false;					
					});
					$('input.simpanprofilr').click(function(){
						var self=$(this);
						$('span#fotoProfile').html($('input#namaSekolah').val());
						$.ajax({
							type: "POST",
							data: $('form#formprofilesek').serialize()+'&submit=1',
							url: base_url+'admin/sekolah/editprofil',
							beforeSend: function() {
								$(self).after("<img id='wait' src='"+config_images+"loading.png' />");
							},
							success: function(msg) {
								$('#wait').remove();
								$.ajax({
									type: "POST",
									data: 'ajax=1',
									url: base_url+'admin/sekolah/editprofil',
									beforeSend: function() {
										$(self).after("<img id='wait' src='"+config_images+"loading.png' />");
									},
									success: function(msg) {
										$('#wait').remove();
									}
								});
							}
						});
						return false;
					});
				
					$('input.images[type="file"]').change(function(){
						var input = $(this), 
							formdata = false;

						function showUploadedItem (source) {
							var list = document.getElementById("image-list"),
								li   = document.createElement("li"),
								img  = document.createElement("img");
							img.src = source;
							//li.appendChild(img);
							//list.appendChild(li);
							$(input).next('div.response').next('div.responseimg').html('<img src="'+source+'" />');
						}   

						if (window.FormData) {
							formdata = new FormData();
							//document.getElementById("btn").style.display = "none";
						}
						
						
							
							var i = 0, len = this.files.length, img, reader, file, size;
							
							for ( ; i < len; i++ ) {
								file = this.files[i];
								size=file.size;
								if(size>50000){
									alert('Ukuran file maximal 50KB');
									return false;
								}
								if (!!file.type.match(/image.*/)) {
									if ( window.FileReader ) {
										reader = new FileReader();
										reader.onloadend = function (e) { 
											showUploadedItem(e.target.result, file.fileName);
										};
										reader.readAsDataURL(file);
									}
									if (formdata) {
										formdata.append("images[]", file);
									}
								}	
							}
						
							if (formdata) {
								$.ajax({
									url: "<?=base_url('admin/sekolah/uploadimage')?>/"+$(input).attr('id')+"/"+$(input).attr('img'),
									type: "POST",
									data: formdata,
									processData: false,
									contentType: false,
									beforeSend: function() {
										$(input).next('div.response').append('Uploading...');
									},
									success: function (res) {
										$(input).attr('img',res)
										$(input).next('div.response').html($(input).attr('id')+' berhasil diperbarui');
									}
								});
							}
					});
					
				
				});
				
				
				
				

			</script>