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
					data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&id_kelas='+$('select#kelas').val()+'&pelajaran='+$('select#pelajaran').val()+'&ajax=1',
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
			
			<? if(!isset($id_pertemuan)){?>
				if($('select#pertemuan').val()==null ){
					$('select#pertemuan').css('border','1px solid red');
					return false;
				}else{
					$('select#pertemuan').css('border','1px solid #D7D7D7');
				}
			<? } ?>
			
			$frm = $(this);
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
			
			if(  $frm.find('*[name=judul]').is('.valid') /*&&  $frm.find('*[name=kompetensi_inti]').is('.valid') && $frm.find('*[name=kompetensi_dasar]').is('.valid') && $frm.find('*[name=indikator_ketercapaian]').is('.valid') && $frm.find('*[name=tujuan_pemb]').is('.valid') && $frm.find('*[name=materi]').is('.valid') && $frm.find('*[name=model_pembelajaran]').is('.valid') && $frm.find('*[name=pendahuluan]').is('.valid') && $frm.find('*[name=inti]').is('.valid') && $frm.find('*[name=penutup]').is('.valid') && $frm.find('*[name=media_sumber]').is('.valid')*/) {
				$.ajax({
					type: "POST",
					data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&'+$(this).serialize()+'&'+$('form#nilai').serialize(),
					url: $(this).attr('action'),
					beforeSend: function() {
						$("#simpanpr").after("<img id='wait' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
					},
					success: function(msg) {
						$("#wait").remove();
						//ajaxupload("<? echo base_url();?>akademik/perencanaan/uploadpembelajaran/"+msg,"response","image-list","filepemb");
						$.ajax({
							type: "POST",
							data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&ajax=1&id_pembelajaran='+msg+'&id_pelajarans=<?=$_POST['id_pelajaran']?>',
							url: '<?=base_url('akademik/perencanaan/materi/')?>',
							beforeSend: function() {
								$("#simpanpr").after("<img id='wait' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
							},
							success: function(msg) {
								$("#wait").remove();
								$.ajax({
									type: "POST",
									data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&ajax=1',
									url: '<?=base_url()?>akademik/perencanaan/pembelajaranlist',
									beforeSend: function() {
										$("#filterpelajaranpembelajaran select#pertemuanselect").after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
									},
									success: function(msg) {
										$("#wait").remove();
										$("#subjectlist").html(msg);	
									}
								});
								$('#fancybox-content div').html(msg);
							}
						});

					}
				});
				return false;
			}
			
			return false;
		});//Submit End	
		$("select#pertemuan").change(function(e){
			$('input#id_kelas,input#id_pelajaran').remove();
			$(this).parent('td').append('<input id="id_kelas" type="hidden" name="id_kelas" value="'+$(this).find(":selected").attr("id_kelas")+'" /><input id="id_pelajaran" type="hidden" name="id_pelajaran" value="'+$(this).find(":selected").attr("id_pelajaran")+'" />');
		});//Submit End
	});
</script>	

<script type="text/javascript" src="<?=$this->config->item('js');?>upload.js"></script>
	
<div class="addaccount" style="width:700px;">
<form method="post" name="pembelajaran" enctype="multipart/form-data" id="pembelajaranadd" action="<? echo base_url();?>akademik/perencanaan/addpembelajaran">
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
	<div onclick="$('.addaccount').remove();" class="addaccountclose"></div>
		
		<h3>Tambah Perencanaan Pembelajaran</h3>
		<div class="hr"></div>
		<table class="adddata adddatapemb">
			<tbody><tr>
				<th style="text-align:right;" colspan="4">
				<a onclick="$('#pembelajaranadd').submit();" id="simpanpr" class="button small light-grey absenbutton" title=""> Simpan </a>
				<!--<a id="cancelpemb" class="button small light-grey absenbutton" title=""> Cancel </a>-->
				</th>
			</tr>
			<tr>
			  <td colspan="2" class="title">Pertemuan</td>
				<td>:</td>
				<td>
					<? if(isset($id_pertemuan)){?>
						<? foreach($pertemuan as $datapertemuan){?>
							<? if($id_pertemuan->$datapertemuan['id']==$datapertemuan['id']){?>
								Ke <?=$datapertemuan['pertemuan_ke']?> | Kelas <?=$datapertemuan['kelas']?><?=$datapertemuan['nama_kelas']?> | <?=$datapertemuan['nama_pelajaran']?> | <?=$datapertemuan['topik']?> <br />
								<input type="hidden" name="id_pertemuan[<?=$datapertemuan['id']?>]" value="<?=$datapertemuan['id']?>" />
								<input type="hidden" name="id_kelas[<?=$datapertemuan['id']?>]" value="<?=$datapertemuan['id_kelas']?>" />
								<input type="hidden" name="id_pelajaran[<?=$datapertemuan['id']?>]" value="<?=$datapertemuan['id_pelajaran']?>" />
							<? } ?>
						<? } ?>
					<? }else{ ?>
						<select class="selectfilter" id="pertemuan" style="max-width:100%;"  name="id_pertemuan[]" multiple>
							<option value="">Pilih Pertemuan</option>
							<? foreach($pertemuan as $datapertemuan){?>
								<option <? if($id_pertemuan->$datapertemuan['id']==$datapertemuan['id']){echo 'selected';}?> id_kelas="<?=$datapertemuan['id_kelas']?>" id_pelajaran="<?=$datapertemuan['id_pelajaran']?>" value="<?=$datapertemuan['id']?>">Ke <?=$datapertemuan['pertemuan_ke']?> | Kelas <?=$datapertemuan['kelas']?><?=$datapertemuan['nama_kelas']?> | <?=$datapertemuan['nama_pelajaran']?> | <?=$datapertemuan['topik']?></option>
							<? } ?>
						</select>
					<? } ?>

				</td>
			</tr>
			<tr>
			  <td colspan="2" class="title">Judul Pembelajaran</td>
				<td width="1">:</td>
				<td>
					<textarea name="judul"></textarea>
				</td>
			</tr>
			<tr>
			  <td colspan="2" class="title">Kompetensi Inti</td>
				<td width="1">:</td>
				<td>
					<textarea name="kompetensi_inti"></textarea>
				</td>
			</tr>
			<tr>
			  <td colspan="2" class="title">Kompetensi Dasar </td>
				<td width="1">:</td>
				<td>
					<textarea name="kompetensi_dasar"></textarea>
				</td>
			</tr>
			<tr>
			  <td colspan="2" class="title">Indikator Pencapaian Kompetensi</td>
				<td width="1">:</td>
				<td>
					<textarea name="indikator_ketercapaian"></textarea>
				</td>
			</tr>
			<tr>
			  <td colspan="2" class="title">Tujuan Pembelajaran</td>
				<td width="1">:</td>
				<td>
					<textarea name="tujuan_pemb"></textarea>
				</td>
			</tr>
			<!--<tr>
			  <td colspan="2" class="title">Materi</td>
				<td width="1">:</td>
				<td>
					<textarea name="materi"></textarea>
				</td>
			</tr>-->
			<tr>
			  <td colspan="2" class="title">Model/Metode Pembelajaran</td>
				<td width="1">:</td>
				<td>
					<textarea name="model_pembelajaran"></textarea>
				</td>
			</tr>
			
			<tr>
			  <td  rowspan="3" class="title"><b>Kegiatan</b></td>
				<td  class="title">Pendahuluan</td> 
				<td width="1">:</td>
				<td>
					<textarea name="pendahuluan"></textarea>
				</td>
			</tr>
			<tr>
			  <td  class="title">Inti</td>
				<td width="1">:</td>
				<td>
					<textarea name="inti"></textarea>
				</td>
			</tr>
			<tr>
			  <td  class="title">Penutup</td>
				<td width="1">:</td>
				<td>
					<textarea name="penutup"></textarea>
				</td>
			</tr>
			<tr>
			  <td colspan="2" class="title">Alat/Media/Sumber Pembelajaran</td>
				<td width="1">:</td>
				<td>
					<textarea name="media_sumber"></textarea>
				</td>
			</tr>
			<tr>
			  <td colspan="2" class="title">Referensi Buku</td>
				<td width="1">:</td>
				<td>
					<textarea name="referensi"></textarea>
				</td>
			</tr>
			<tr>
			  <td colspan="2" class="title">Keterangan</td>
				<td width="1">:</td>
				<td>
					<textarea name="keterangan"></textarea>
				</td>
			</tr>
			<tr>
				<th style="text-align:right;" colspan="4">
				<a onclick="$('#pembelajaranadd').submit();" id="simpanpr" class="button small light-grey absenbutton" title=""> Simpan </a>
				<!--<a id="cancelpemb" class="button small light-grey absenbutton" title=""> Cancel </a>-->
				</th>
			</tr>
		</tbody></table>

	<input type="hidden" value="1" name="ajax"> 

	<div style="display:none;" class="error-container"> Semua field yang merah harus di isi atau dipilih!  </div>
  </form>
</div>