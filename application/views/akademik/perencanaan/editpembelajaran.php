<script>
	$(document).ready(function(){
	    $('table.adddatapemb textarea').attr('style','height:50px;');
		$("#pembelajaranadd").each(function(){
			$container = $(this).next("div.error-container");
			//Validate Starts
			$(this).validate({
				onfocusout: function(element) {	$(element).valid();	},
				errorContainer: $container,
				rules:{
				  id_pertemuan:{required:true,notEqual:'Pilih Pertemuan'},  
				  judul:{required:true,notEqual:''},
				  /*kompetensi_inti:{required:true,notEqual:''},
				  kompetensi_dasar:{required:true,notEqual:''},
				  indikator_ketercapaian:{required:true,notEqual:''},
				  tujuan_pemb:{required:true,notEqual:''},
				  materi:{required:true,notEqual:''},
				  model_pembelajaran:{required:true,notEqual:''},
				  pendahuluan:{required:true,notEqual:''},
				  inti:{required:true,notEqual:''},
				  penutup:{required:true,notEqual:''},
				  media_sumber:{required:true,notEqual:''},
				  ,message:{required:true,minlength:10}*/
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
			$id_pertemuan = $frm.find('*[name=id_pertemuan]').val();   
			$judul = $frm.find('*[name=judul]').val();
			/*$kompetensi_inti = $frm.find('*[name=kompetensi_inti]').val();
			$kompetensi_dasar = $frm.find('*[name=kompetensi_dasar]').val();
			$indikator_ketercapaian = $frm.find('*[name=indikator_ketercapaian]').val();
			$tujuan_pemb = $frm.find('*[name=tujuan_pemb]').val();
			$materi = $frm.find('*[name=materi]').val();
			$model_pembelajaran = $frm.find('*[name=model_pembelajaran]').val();
			$pendahuluan = $frm.find('*[name=pendahuluan]').val();
			$inti = $frm.find('*[name=inti]').val();
			$penutup = $frm.find('*[name=penutup]').val();
			$media_sumber = $frm.find('*[name=media_sumber]').val();*/
			
			if($frm.find('*[name=judul]').is('.valid') && $frm.find('*[name=id_pertemuan]').is('.valid') /*&&   $frm.find('*[name=kompetensi_inti]').is('.valid') && $frm.find('*[name=kompetensi_dasar]').is('.valid') && $frm.find('*[name=indikator_ketercapaian]').is('.valid') && $frm.find('*[name=tujuan_pemb]').is('.valid') && $frm.find('*[name=materi]').is('.valid') && $frm.find('*[name=model_pembelajaran]').is('.valid') && $frm.find('*[name=pendahuluan]').is('.valid') && $frm.find('*[name=inti]').is('.valid') && $frm.find('*[name=penutup]').is('.valid') && $frm.find('*[name=media_sumber]').is('.valid')*/) {
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
		<table class="adddata adddatapemb">
			<tbody><tr>
				<th style="text-align:right;" colspan="4">
				<a onclick="$('#pembelajaranadd').submit();" id="simpanpr" class="button small light-grey absenbutton" title=""> Simpan </a>
				<a id="cancelpemb" class="button small light-grey absenbutton" title=""> Cancel </a>
				</th>
			</tr>
			<tr>
			  <td colspan="2" class="title">Pertemuan</td>
				<td>:</td>
				<td>
					<select class="selectfilter" id="pertemuan"  name="id_pertemuan">
						<option value="">Pilih Pertemuan</option>
						<? foreach($pertemuan as $datapertemuan){?>
						<option <? if($pembelajaran[0]['id_pertemuan']==$datapertemuan['id']){echo 'selected';}?> id_kelas="<?=$datapertemuan['id_kelas']?>" id_pelajaran="<?=$datapertemuan['id_pelajaran']?>" value="<?=$datapertemuan['id']?>">Ke <?=$datapertemuan['pertemuan_ke']?> | Kelas <?=$datapertemuan['kelas']?><?=$datapertemuan['nama_kelas']?> | <?=$datapertemuan['nama_pelajaran']?> | <?=$datapertemuan['topik']?></option>
						<? } ?>
					</select>
				</td>
			</tr>
			<tr>
			  <td colspan="2" class="title">Lampiran File</td>
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
			  <td colspan="2" class="title">Tema / Judul</td>
				<td width="1">:</td>
				<td>
					<textarea name="judul"><?=@$pembelajaran[0]['judul']?></textarea>
				</td>
			</tr>
			<tr>
			  <td colspan="2" class="title">Kompetensi Inti</td>
				<td width="1">:</td>
				<td>
					<textarea name="kompetensi_inti"><?=@$pembelajaran[0]['kompetensi_inti']?></textarea>
				</td>
			</tr>
			<tr>
			  <td colspan="2" class="title">Kompetensi Dasar </td>
				<td width="1">:</td>
				<td>
					<textarea name="kompetensi_dasar"><?=@$pembelajaran[0]['kompetensi_dasar']?></textarea>
				</td>
			</tr>
			<tr>
			  <td colspan="2" class="title">Indikator Pencapaian Kompetensi</td>
				<td width="1">:</td>
				<td>
					<textarea name="indikator_ketercapaian"><?=@$pembelajaran[0]['indikator_ketercapaian']?></textarea>
				</td>
			</tr>
			<tr>
			  <td colspan="2" class="title">Tujuan Pembelajaran</td>
				<td width="1">:</td>
				<td>
					<textarea name="tujuan_pemb"><?=@$pembelajaran[0]['tujuan_pemb']?></textarea>
				</td>
			</tr>
			<!--<tr>
			  <td colspan="2" class="title">Materi</td>
				<td width="1">:</td>
				<td>
					<textarea name="materi"><?=@$pembelajaran[0]['materi']?></textarea>
				</td>
			</tr>-->
			<tr>
			  <td colspan="2" class="title">Model/Metode Pembelajaran</td>
				<td width="1">:</td>
				<td>
					<textarea name="model_pembelajaran"><?=@$pembelajaran[0]['model_pembelajaran']?></textarea>
				</td>
			</tr>
			
			<tr>
			  <td  rowspan="3" class="title"><b>Kegiatan</b></td>
				<td  class="title">Pendahuluan</td> 
				<td width="1">:</td>
				<td>
					<textarea name="pendahuluan"><?=@$pembelajaran[0]['pendahuluan']?></textarea>
				</td>
			</tr>
			<tr>
			  <td  class="title">Inti</td>
				<td width="1">:</td>
				<td>
					<textarea name="inti"><?=@$pembelajaran[0]['inti']?></textarea>
				</td>
			</tr>
			<tr>
			  <td  class="title">Penutup</td>
				<td width="1">:</td>
				<td>
					<textarea name="penutup"><?=@$pembelajaran[0]['penutup']?></textarea>
				</td>
			</tr>
			<tr>
			  <td colspan="2" class="title">Alat/Media/Sumber Pembelajaran</td>
				<td width="1">:</td>
				<td>
					<textarea name="media_sumber"><?=@$pembelajaran[0]['media_sumber']?></textarea>
				</td>
			</tr>
			<tr>
			  <td colspan="2" class="title">Referensi Buku</td>
				<td width="1">:</td>
				<td>
					<textarea name="referensi"><?=@$pembelajaran[0]['referensi']?></textarea>
				</td>
			</tr>
			<tr>
			  <td colspan="2" class="title">Keterangan</td>
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