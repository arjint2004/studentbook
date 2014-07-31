
<script>
	$(document).ready(function(){
		$("#materirpp").each(function(){
			$container = $(this).next("div.error-container");
			//Validate Starts
			$(this).validate({
				onfocusout: function(element) {	$(element).valid();	},
				errorContainer: $container,
				rules:{
				  id_kelas:{required:true,notEqual:'Pilih Kelas'},
				 <? if(isset($_POST['id_pelajarans']) || $id_pelajaran!=0){}else{?> id_pelajaran:{required:true,notEqual:'Pilih Pelajaran'},<? } ?>
				  bab:{required:true,notEqual:''},
				  pokok_bahasan:{required:true,notEqual:''},
				 /* file:{required:true,notEqual:''},*/
				  keterangan:{required:true,notEqual:''}
				  /*,message:{required:true,minlength:10}*/
				}
			});//Validate End

		});

		//Submit Starts		   
		$(".addaccountclose").click(function(){
			$(".addaccount").remove();
		});
		$("#materirpp").submit(function(e){

			$frm = $(this);
			<? if(isset($_POST['id_pelajarans']) || $id_pelajaran!=0){}else{?>$id_pelajaran = $frm.find('*[name=id_pelajaran]').val();<? } ?>
			$bab = $frm.find('*[name=bab]').val();
			$pokok_bahasan = $frm.find('*[name=pokok_bahasan]').val();
			/*$file = $frm.find('*[name=file]').val();*/
			$tanggal_diberikan = $frm.find('*[name=tanggal_diberikan]').val();
			$keterangan = $frm.find('*[name=keterangan]').val();
			if(<? if(isset($_POST['id_pelajarans']) || $id_pelajaran!=0){}else{?>$frm.find('*[name=id_pelajaran]').is('.valid') && <?}?> $frm.find('*[name=bab]').is('.valid') && $frm.find('*[name=pokok_bahasan]').is('.valid') && $frm.find('*[name=keterangan]').is('.valid')) {
				$.ajax({
					type: "POST",
					data: $(this).serialize()+'&'+$('form#nilai').serialize(),
					url: $(this).attr('action'),
					beforeSend: function() {
						$("#simpanpr").after("<img id='wait' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
					},
					success: function(msg) {
						$("#wait").remove();	
						
						ajaxupload("<? echo base_url();?>akademik/materi/upload/"+msg,"response","image-list","filepembmateri");
						$.ajax({
							type: "POST",
							data:'&id_pelajaran='+$('select#pelajaran_add').val()+'&ajax=1&id_pembelajaran=<?=$id_pembelajaran?>',
							url: '<?=base_url('akademik/instrumen/kognitif/'.$id_pembelajaran.'')?>',
							beforeSend: function() {
								$("#simpanpr").after("<img id='wait' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
							},
							success: function(msg) {
								$("#wait").remove();
								$('#fancybox-content div').html(msg);
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

<link type="text/css" href="<?=$this->config->item('css');?>datepick.css" rel="stylesheet">
<script type="text/javascript" src="<?=$this->config->item('js');?>jquery.datepick.js"></script>
<script type="text/javascript" src="<?=$this->config->item('js');?>jquery.datepick-id.js"></script>
<script>
	$(document).ready(function(){
		$('#datemateri').datepick();
		$('#date2materi').datepick();
	});
</script>
<script type="text/javascript" src="<?=$this->config->item('js');?>upload.js"></script>	
<div class="addaccount">
<form method="post" name="materi" enctype="multipart/form-data" id="materirpp"  style="width:700px;" action="<? echo base_url();?>akademik/instrumen/materi">
	<div onclick="$('.addaccount').remove();" class="addaccountclose"></div>
		
		<table>
			<tbody>
				<tr>
					<td>
						<b>MATERI PELAJARAN</b>
					</td>
				</tr>
			</tbody>
		</table>
		<table class="adddata">
			<tbody>
			<tr>
				<th style="text-align:right;" colspan="3">
				<a onclick="$('#materirpp').submit();" id="simpanpr" class="button small light-grey absenbutton" title=""> Simpan </a>
				</th>
			</tr>
			<tr>
				<td class="title">Pelajaran</td>
				<td>:</td>
				<td>
					<? if(isset($_POST['id_pelajarans']) || $id_pelajaran!=0){
						if($id_pelajaran!=0){$_POST['id_pelajarans']=$id_pelajaran;}
					?>
					<select class="selectfilter" id="pelajaran_add" name="id_pelajaran" disabled>
						<option value="">Pilih Pelajaran</option>
						<?
						if(!empty($pelajaran)){			
						foreach($pelajaran as $datapelajaran){?>
						<option <? if(@$_POST['id_pelajarans']==$datapelajaran['id']){echo 'selected';}?> value="<?=$datapelajaran['id']?>"><?=$datapelajaran['nama']?> [Kelas <?=$datapelajaran['kelas']?>]</option>
						<? }} ?>
					</select>
					<input type="hidden" name="id_pelajaran" value="<?=$_POST['id_pelajarans']?>" />
					<? }else{?>
					<select class="selectfilter" id="pelajaran_add" name="id_pelajaran">
						<option value="">Pilih Pelajaran</option>
						<?
						if(!empty($pelajaran)){			
						foreach($pelajaran as $datapelajaran){?>
						<option <? //if(@$_POST['pelajaran']==$datapelajaran['id']){echo 'selected';}?> value="<?=$datapelajaran['id']?>"><?=$datapelajaran['nama']?> [Kelas <?=$datapelajaran['kelas']?>]</option>
						<? }} ?>
					</select>					
					<? }?>
					
				</td>
			</tr>
			<tr>
				<td class="title">Pokok Bahasan</td>
				<td>:</td>
				<td>
					<input type="text" value="" size="30" name="pokok_bahasan">				
				</td>
			</tr>
			<tr>
				<td class="title">Bab</td>
				<td>:</td>
				<td>
					<input type="text" value="" size="30" name="bab">				
				</td>
			</tr>
			<tr>
				<td width="30%" class="title">Lampiran File</td>
				<td width="1">:</td>
				<td>
					<input type="file" name="file" id="filepembmateri" multiple />
					<div id="response" style="font-size:11px;">Anda bisa memilih banyak file dengan memencet tombol "Ctrl", kemudian klik file yang dipilih lebih dari satu</div>
				</td>
			</tr>

			<tr>
				<td width="30%" class="title">Keterangan</td>
				<td width="1">:</td>
				<td>
					<textarea name="keterangan"></textarea>
				</td>
			</tr>
			<tr>
				<td width="30%" class="title">Berbagi</td>
				<td width="1">:</td>
				<td>
					<input type="checkbox" checked name="share" value="1" />
				</td>
			</tr>
			
			<tr>
				<th style="text-align:right;" colspan="3">
				<a onclick="$('#materirpp').submit();" id="simpanpr" class="button small light-grey absenbutton" title=""> Simpan </a>
				</th>
			</tr>
		</tbody></table>

	<input type="hidden" value="1" name="ajax"> 
	<input type="hidden" value="<?=$id_pembelajaran?>" name="id_pembelajaran"> 

	<div style="display:none;" class="error-container"> Semua field yang merah harus di isi atau dipilih!  </div>
	</form>
</div>