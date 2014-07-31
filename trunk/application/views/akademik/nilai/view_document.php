<script>
	$(document).ready(function(){
		$("#previewkumpul").each(function(){
			$container = $(this).next("div.error-container");
			//Validate Starts
			$(this).validate({
				onfocusout: function(element) {	$(element).valid();	},
				errorContainer: $container,
				rules:{
				  nilai:{required:true,notEqual:''},
				  benar:{required:true,notEqual:''},
				  salah:{required:true,notEqual:''},
				  keterangan:{required:true,notEqual:''}
				  /*,message:{required:true,minlength:10}*/
				}
			});//Validate End

		});
	
		//Submit Starts		   
		$("input.isNumber").keyup(function(){
			if($(this).val()>100){
				alert('Maximal nilai hanya 100');
				$(this).val(0);
				$(this).focus();
			}
		});
		$("#previewkumpul").submit(function(e){
			$frm = $(this);
			$nilai = $frm.find('*[name=nilai]').val();
			$benar = $frm.find('*[name=benar]').val();
			$salah = $frm.find('*[name=salah]').val();
			$keterangan = $frm.find('*[name=keterangan]').val();
			if($frm.find('*[name=nilai]').is('.valid') && $frm.find('*[name=benar]').is('.valid') && $frm.find('*[name=salah]').is('.valid') && $frm.find('*[name=keterangan]').is('.valid')) {
				$.ajax({
					type: "POST",
					data: $(this).serialize(),
					url: $(this).attr('action'),
					beforeSend: function() {
						$("#simpankumpul").after("<img id='wait' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
					},
					success: function(msg) {
						$("#wait").remove();
					}
				});
				return false;
			}
			
			return false;
		});//Submit End	
	});
</script>
<form method="post" name="previewkumpul" enctype="multipart/form-data" id="previewkumpul" action="<? echo base_url();?>akademik/nilai/view_document/<?=$id_pengumpulan?>/<?=$id_siswa_det_jenjang?>/<?=$id_kelas?>/<?=$id_sekolah?>/<?=$jenis?>/<?=$id_referensi?>/<?=$id_pelajaran?>/<?=$urlfilepure?>">
<table style="width:50%;margin:0 auto 30px;">
	<tr>
		<th width="10">Nilai</th>
		<th width="10">Benar</th>
		<th width="10">Salah</th>
		<th style="padding:0;">
		Keterangan
		<a style="margin: 0px; position: relative; bottom: 5px; right: 5px;" class="button small light-grey absenbutton" id="simpankumpul" onclick="$('#previewkumpul').submit();"> Simpan </a>
		</th>
	</tr>
	
	<tr>
		<td style="vertical-align:top;"><input type="text" name="nilai" class="isNumber" value="<?=@$nilai?>" style="margin:0;width:30px;" /></td>
		<td style="vertical-align:top;"><input type="text" name="benar" class="isNumber" value="<?=@$pengumpulan[0]['benar']?>" style="margin:0;width:30px;" /></td>
		<td style="vertical-align:top;"><input type="text" name="salah" class="isNumber" value="<?=@$pengumpulan[0]['salah']?>" style="margin:0;width:30px;"/></td>
		<td style="vertical-align:top;"><textarea name="keterangan" style="margin:0;width:98%;"><?=@$pengumpulan[0]['keterangan']?></textarea></td>
	</tr>
</table>
<input type="hidden" name="id_kelas" value="<?=$id_kelas?>" />
<input type="hidden" name="id_sekolah" value="<?=$id_sekolah?>"/>
<input type="hidden" name="jenis" value="<?=$jenis?>"/>
<input type="hidden" name="id_referensi" value="<?=$id_referensi?>"/>
<input type="hidden" name="id_pelajaran" value="<?=$id_pelajaran?>"/>
</form>

<?

$dirup=str_replace("https://studentbook.co","",base64_decode($urlfilepure));
if(is_image('/home/studoid1/public_html/studentbook.co'.$dirup)){
?>
<div style="text-align:center;">
<img src="<?=base64_decode($urlfilepure)?>" />
</div>
<?
}else{
?>
<iframe src="https://docs.google.com/viewer?url=<?=$urlfile?>" width="100%" height="780" style="border: none;"></iframe>
<? } ?>
