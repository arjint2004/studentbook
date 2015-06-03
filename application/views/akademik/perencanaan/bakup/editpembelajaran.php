<script>
	$(document).ready(function(){
		$("#pembelajaranadd").each(function(){
			$container = $(this).next("div.error-container");
			//Validate Starts
			$(this).validate({
				onfocusout: function(element) {	$(element).valid();	},
				errorContainer: $container,
				rules:{
				  id_kelas:{required:true,notEqual:'Pilih Kelas'},
				  id_pelajaran:{required:true,notEqual:'Pilih Pelajaran'},
				  pendahuluan:{required:true,notEqual:''},
				  inti:{required:true,notEqual:''},
				  penutup:{required:true,notEqual:''},
				  media_sumber:{required:true,notEqual:''}
				  /*,message:{required:true,minlength:10}*/
				}
			});//Validate End

		});		   
		$("table.adddata tr th a#cancelpemb").click(function(){
				var obj=$(this);
				$.ajax({
					type: "POST",
					data: 'id_kelas='+$('select#kelas').val()+'&pelajaran='+$('select#pelajaran').val()+'&ajax=1',
					url: '<?=base_url('akademik/perencanaan/pembelajaranlist')?>',
					beforeSend: function() {
						$(obj).after("<img id='wait' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
					},
					success: function(msg) {
						$("#wait").remove();
						$("#wait").remove();
						$('select#kelas').val($('select#kelas_add').val());
						$('select#pelajaran').html($('select#pelajaran_add').html());
						$('select#pelajaran').val($('select#pelajaran_add').val());	
						$('#subjectlist').html(msg);
					}
				});
				return false;
		});

		//Submit Starts	   
		$(".addaccountclose").click(function(){
			$(".addaccount").remove();
		});
		$("#pembelajaranadd").submit(function(e){
			$frm = $(this);
			$id_kelas = $frm.find('*[name=id_kelas]').val();
			$id_pelajaran = $frm.find('*[name=id_pelajaran]').val();
			$pendahuluan = $frm.find('*[name=pendahuluan]').val();
			$inti = $frm.find('*[name=inti]').val();
			$penutup = $frm.find('*[name=penutup]').val();
			$media_sumber = $frm.find('*[name=media_sumber]').val();
			if($frm.find('*[name=id_kelas]').is('.valid') && $frm.find('*[name=id_pelajaran]').is('.valid') &&   $frm.find('*[name=pendahuluan]').is('.valid') && $frm.find('*[name=inti]').is('.valid') && $frm.find('*[name=penutup]').is('.valid') && $frm.find('*[name=media_sumber]').is('.valid')) {
				$.ajax({
					type: "POST",
					data: $(this).serialize()+'&'+$('form#nilai').serialize(),
					url: $(this).attr('action'),
					beforeSend: function() {
						$("#simpanpr").after("<img id='wait' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
					},
					success: function(msg) {
						$("#wait").remove();
						ajaxupload("<? echo base_url();?>akademik/perencanaan/uploadpembelajaran/"+msg,"response","image-list","file");
						$.ajax({
							type: "POST",
							data: 'id_kelas='+$('select#kelas_add').val()+'&pelajaran='+$('select#pelajaran_add').val()+'&ajax=1',
							url: '<?=base_url('akademik/perencanaan/pembelajaranlist')?>',
							beforeSend: function() {
								$("#simpanpr").after("<img id='wait' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
							},
							success: function(msg) {
								$("#wait").remove();
								$('select#kelas').val($('select#kelas_add').val());
								$('select#pelajaran').html($('select#pelajaran_add').html());
								$('select#pelajaran').val($('select#pelajaran_add').val());
								$('#subjectlist').html(msg);
							}
						});
					}
				});
				return false;
			}
			
			return false;
		});//Submit End	
		$('#pelajaran_add').load('<?=base_url()?>admin/pelajaran/getMapelByKelasAndPegawai/'+$('#kelas_add').val()+'/<?=$pembelajaran[0]['id_pelajaran']?>');
		$("ul.file div.actdell").click(function(){
			var objdell=$(this);
			if(confirm('File akan di hapus secara permanen, untuk menggunakannya kembali anda harus upload ulang..')){
				$.ajax({
					type: "POST",
					data: '',
					url: base_url+'akademik/perencanaan/deletefilepemb/'+$(this).attr('id'),
					beforeSend: function() {
						$(objdell).after("<img id='wait' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
					},
					success: function(msg) {
						$("#wait").remove();	
						$(objdell).parent().remove();
					}
				});
				return false;
			}
		});	
		$("select#kelas_add").change(function(e){
			$.ajax({
				type: "POST",
				data: '',
				url: '<?=base_url()?>admin/pelajaran/getMapelByKelasAndPegawai/'+$(this).val(),
				beforeSend: function() {
					$('select#kelas_add').after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
				},
				success: function(msg) {
					$('#wait').remove();
					$("#pelajaran_add").html(msg);	
				}
			});
		});//Submit End
	});
</script>	

<script type="text/javascript" src="<?=$this->config->item('js');?>upload.js"></script>
	
<div class="addaccount">
<form method="post" name="pembelajaran" enctype="multipart/form-data" id="pembelajaranadd" action="<? echo base_url();?>akademik/perencanaan/editpembelajaran/<?=@$pembelajaran[0]['id']?>">
	<div onclick="$('.addaccount').remove();" class="addaccountclose"></div>
		
		<h3>Edit Perencanaan Pembelajaran</h3>
		<div class="hr"></div>
		<table class="adddata">
			<tbody><tr>
				<th style="text-align:right;" colspan="3">
				<a onclick="$('#pembelajaranadd').submit();" id="simpanpr" class="button small light-grey absenbutton" title=""> Simpan </a>
				<a id="cancelpemb" class="button small light-grey absenbutton" title=""> Cancel </a>
				</th>
			</tr>
			<tr>
				<td class="title">Kelas</td>
				<td>:</td>
				<td>
					<select class="selectfilter" id="kelas_add" name="id_kelas">
						<option value="">Pilih Kelas</option>
						<? foreach($kelas as $datakelas){?>
						<option <? if(@$pembelajaran[0]['id_kelas']==$datakelas['id']){echo 'selected';}?> value="<?=$datakelas['id']?>"><?=$datakelas['kelas']?><?=$datakelas['nama']?></option>
						<? } ?>
					</select>
				</td>
			</tr>
			<tr>
				<td class="title">Pelajaran</td>
				<td>:</td>
				<td>
					<select class="selectfilter" id="pelajaran_add" name="id_pelajaran">
						<option value="">Pilih Pelajaran</option>
						<?
						if(!empty($pelajaran)){			
						foreach($pelajaran as $datapelajaran){?>
						<option <? if(@$pembelajaran[0]['id_pelajaran']==$datapelajaran['id']){echo 'selected';}?> value="<?=$datapelajaran['id']?>"><?=$datapelajaran['nama']?></option>
						<? }} ?>
					</select>
				</td>
			</tr>
			<tr>
				<td width="30%" class="title">Lampiran File</td>
				<td width="1">:</td>
				<td>
					<input type="file" name="file" id="file" multiple />
					<div id="response" style="font-size:11px;">Anda bisa memilih banyak file dengan memencet tombol "Ctrl", kemudian klik file yang dipilih lebih dari satu</div>
					<form id="remidialfile" method="post" action="">
					<ul class="file">
						<?foreach($files as $file){?>
							<li><?=$file['file_name']?><div id="<?=$file['id']?>" class="actdell"></div></li>
						<? } ?>
					</ul>
					</form>
				</td>
			</tr>
			<tr>
				<td width="30%" class="title">Pendahuluan</td> 
				<td width="1">:</td>
				<td>
					<textarea name="pendahuluan"><?=@$pembelajaran[0]['pendahuluan']?></textarea>
				</td>
			</tr>
			<tr>
				<td width="30%" class="title">Inti</td>
				<td width="1">:</td>
				<td>
					<textarea name="inti"><?=@$pembelajaran[0]['inti']?></textarea>
				</td>
			</tr>
			<tr>
				<td width="30%" class="title">Penutup</td>
				<td width="1">:</td>
				<td>
					<textarea name="penutup"><?=@$pembelajaran[0]['penutup']?></textarea>
				</td>
			</tr>
			<tr>
				<td width="30%" class="title">Alat/Media/Sumber Pembelajaran</td>
				<td width="1">:</td>
				<td>
					<textarea name="media_sumber"><?=@$pembelajaran[0]['media_sumber']?></textarea>
				</td>
			</tr>
			<tr>
				<td width="30%" class="title">Referensi Buku</td>
				<td width="1">:</td>
				<td>
					<textarea name="referensi"><?=@$pembelajaran[0]['referensi']?></textarea>
				</td>
			</tr>
			<tr>
				<td width="30%" class="title">Keterangan</td>
				<td width="1">:</td>
				<td>
					<textarea name="keterangan"><?=@$pembelajaran[0]['keterangan']?></textarea>
				</td>
			</tr>
			
		</tbody></table>

	<input type="hidden" value="<?=@$pembelajaran[0]['id']?>" name="id"> 
	<input type="hidden" value="1" name="ajax"> 

	<div style="display:none;" class="error-container"> Semua field yang merah harus di isi atau dipilih!  </div>
	</form>
</div>