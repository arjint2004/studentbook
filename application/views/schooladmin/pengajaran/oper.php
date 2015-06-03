<script>
$(document).ready(function(){


		$("#mengajarform").each(function(){
			$container = $(this).next("div.error-container");
			//Validate Starts
			$(this).validate({
				onfocusout: function(element) {	$(element).valid();	},
				errorContainer: $container,
				rules:{
				  id_pegawai2:{required:true,notEqual:'Pilih Guru Baru'},
				  /*,message:{required:true,minlength:10}*/
				}
			});//Validate End

		});

		
	
	function loaddatamengajar(){
		$.ajax({
			type: "POST",
			data: "ajax=1",
			url: base_url+'admin/pengajaran/listData',
			beforeSend: function() {
				$("#listmengajarloading").html("<img src='"+config_images+"loading.png' />");
			},
			success: function(msg) {
				$("#listmengajar").html(msg);			
			}
		});
	}
	
//Submit Starts	
	   
		$("select#pelajaran").change(function(){
			$('#id_pelajaranselsel').val($(this).val());
		});
		$("select#kelas,select#id_jurusan,select#semester").change(function(){
			var obj=$(this); 
			$.ajax({
				type: "POST",
				data: $('#mengajarform').serialize(),
				url: base_url+'admin/pengajaran/getPelajaran',
				beforeSend: function() {
					$("#listpengajaranloading").html("<img src='"+config_images+"loading.png' />");
				},
				success: function(msg) {
					$("#listpengajaranloading").html("");
					$("#pelajaran").html(msg);			
				}
			});			
			if($(obj).attr('name')=='kelas'){
				$.ajax({
					type: "POST",
					data: $('#mengajarform').serialize(),
					url: base_url+'admin/pengajaran/getKelas',
					beforeSend: function() {
						$('img#wait').remove();	
						$(obj).after("<img id='wait' src='"+config_images+"loading.png' />");
					},
					success: function(msg) {
						$('img#wait').remove();	
						$("#id_kelas").html(msg);
					}
				});
			}
		});
		$.ajax({
				type: "POST",
				data: $('#mengajarform').serialize()+'&kelas='+$('select#kelas').val(),
				url: base_url+'admin/pengajaran/getPelajaran',
				beforeSend: function() {
					$("#listpengajaranloading").html("<img src='"+config_images+"loading.png' />");
				},
				success: function(msg) {
					$("#listpengajaranloading").html("");
					$("#pelajaran").html(msg);		
					$("input#pelajaranhide").val($("#pelajaran").val());		
					
				}
			});
		$(".addaccountclose").click(function(){
			$(".addaccount").remove();
		});
		$("#mengajarform").submit(function(e){
		
			$frm = $(this);
			$id_pegawai2 = $frm.find('*[name=id_pegawai2]').val();
			if($frm.find('*[name=id_pegawai2]').is('.valid')) {
				$.ajax({
					type: "POST",
					data: $(this).serialize(),
					url: $(this).attr('action'),
					beforeSend: function() {
						$("#adduser").html("<img src='<?=$this->config->item('images').'loading.png';?>' />");
					},
					success: function(msg) {
						$(".addaccount").remove();	
							$.ajax({
								type: "POST",
								data: "ajax=1&id_pegawai="+$id_pegawai2,
								url: '<?php echo base_url(); ?>admin/pengajaran/listData',
								beforeSend: function() {
									$("#listmengajarloading").html("<img src='<?=$this->config->item('images').'loading.png';?>' />");
								},
								success: function(msg) {
									$("#listpengajaran").html(msg);			
								}
							});			
					}
				});
				return false;
			}
			
			return false;
		});//Submit End
});
</script>
<div class="addaccount">
<? //pr($pengajaranedit);?>
<form action="<? echo base_url();?>admin/pengajaran/oper" id="mengajarform" name="mengajarform" method="post" >
	<div class="addaccountclose" onclick="$('.addaccount').remove();"></div>
	<h3> Oper data Pengajaran </h3>
		<table class="adddata">

			<tr>
				<td class="title">Jenjang Kelas</td>
				<td>:</td>
				<td>
				<select id="kelas" name="kelas"  class="selectadddata" disabled >
					<option value="">Pilih Jenjang Kelas</option>
						<? foreach($grade as $datagrade){?>
						<option <?if($pengajaranedit[0]['kelas']==$datagrade){echo 'selected';}?> value="<?=$datagrade?>"><?=$datagrade?></option>
						<? } ?>
					</select>
					<input type="hidden"  name="kelas" value="<?=$pengajaranedit[0]['kelas']?>" />
				</td>
			</tr>
			<tr>
				<td class="title">Kelas</td>
				<td>:</td>
				<td>
					<select id="id_kelas" name="id_kelas"  class="selectadddata" disabled>
						<option value="<?=$no_kelas[0]['id']?>">Pilih Kelas</option>
						<? foreach($kelas as $datakelas){?>
						<option <?if($pengajaranedit[0]['id_kelas']==$datakelas['id']){echo 'selected';}?> value="<?=$datakelas['id']?>"><?//=$datakelas['kelas']?> <?=$datakelas['nama']?></option>
						<? } ?>
					</select>
					<input type="hidden"  name="id_kelas" value="<?=$pengajaranedit[0]['id_kelas']?>" />
				</td>
			</tr>
			<tr>
				<td class="title">Semester</td>
				<td>:</td>
				<td>
					<select id="semester" name="semester"  class="selectadddata" disabled>
						<option value="">Pilih Semester</option>
						<? foreach($semester as $datasemester){?>
						<option <? if(@$pengajaranedit[0]['semester']==$datasemester['id']){echo 'selected';}?> value="<?=$datasemester['id']?>"><?=$datasemester['nama']?></option>
						<? } ?>
					</select>
					<input type="hidden"  name="semester" value="<?=@$pengajaranedit[0]['semester']?>" />
				</td>
			</tr>
			<tr>
				<td class="title">Jurusan</td>
				<td>:</td>
				<td>
					<select id="id_jurusan" name="" class="selectadddata" disabled>
						<option value="">Pilih Jurusan</option>
						<? foreach($jurusan as $datajur){?>
						<option <?if(@$pengajaranedit[0]['id_jurusan']==$datajur['id']){echo 'selected';}?> value="<?=$datajur['id']?>"><?=$datajur['nama']?></option>
						<? } ?>
					</select>
					<input type="hidden"  name="id_jurusan" value="<?=@$pengajaranedit[0]['id_jurusan']?>" />
				</td>
			</tr>
			<tr>
				<td class="title">Pelajaran</td>
				<td>:</td>
				<td>
					<select name="id_pelajaran" id="pelajaran"  class="selectadddata" disabled >
						<option value="">Pilih Pelajaran</option>
					</select>
					<input type="hidden"  id="pelajaranhide" name="id_pelajaran" value="" />
				</td>
			</tr>
			<tr>
				<td class="title">Guru Lama</td>
				<td>:</td>
				<td>
				
					<select name="id_pegawai" id="id_pegawai"  class="selectadddata" disabled>
						<option value="">Pilih Guru</option>
						<? foreach($pegawai as $oppeg){?>
						<option <?if($pengajaranedit[0]['id_pegawai']==$oppeg['id']){echo 'selected';}?> value="<?=$oppeg['id']?>"><?=$oppeg['nama']?></option>
						<? } ?>
					</select>
					<input type="hidden"  name="id_pegawai" value="<?=$pengajaranedit[0]['id_pegawai']?>" />
				</td>
			</tr>
			<tr>
				<td class="title">Guru Baru</td>
				<td>:</td>
				<td>
				
					<select name="id_pegawai2" id="id_pegawai2"  class="selectadddata">
						<option value="">Pilih Guru Baru</option>
						<? foreach($pegawai as $oppeg){?>
						<option value="<?=$oppeg['id']?>"><?=$oppeg['nama']?></option>
						<? } ?>
					</select>
					
				</td>
			</tr>
			<tr>
				<td class="title" colspan="3"><input type="submit" name="simpan" value="Simpan"/></td>
			</tr>
		</table>

	<input type="hidden" name="id_pengajaran" value="<?=$pengajaranedit[0]['id']?>"/> 
	<input type="hidden" name="id_pelajaran" id="id_pelajaranselsel" value="<?=$pengajaranedit[0]['id_pelajaran']?>"/> 
	<input type="hidden" name="addpengajaran" value="1"/> 
	<input type="hidden" name="ajax" value="1"/> 
	</form>
	<div class="error-container" style="display:none;"> Semua field harus di isi atau dipilih!  </div>
</div>