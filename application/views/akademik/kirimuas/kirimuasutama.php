<script>
	$(document).ready(function(){
		$("#kirimuasutama").each(function(){
			$container = $(this).next("div.error-container");
			//Validate Starts
			$(this).validate({
				onfocusout: function(element) {	$(element).valid();	},
				errorContainer: $container,
				rules:{
				  //id_kelas:{required:true,notEqual:'Pilih Kelas'},
				  id_pelajaran:{required:true,notEqual:'Pilih Pelajaran'},
				  bab:{required:true,notEqual:''},
				  judul:{required:true,notEqual:''},
				  //file:{required:true,notEqual:''},
				  //keterangan:{required:true,notEqual:''}
				  /*,message:{required:true,minlength:10}*/
				}
			});//Validate End

		});
		
		$("table.adddata tr th a.canceluas").click(function(){
				var obj=$(this);
				$.ajax({
					type: "POST",
					data: 'id_kelas='+$('select#kelasuas').val()+'&pelajaran='+$('select#pelajaranuas').val()+'&ajax=1',
					url: '<?=base_url('akademik/kirimuas/daftaruaslist')?>',
					beforeSend: function() {
						$("table.adddata tr th a.canceluas").after("<img id='waituas24' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
					},
					success: function(msg) {
						$("#waituas24").remove();
						//$('select#kelasuas').val('');
						//$('select#pelajaranuas').html($('select#pelajaran_adduas').html());
						//$('select#pelajaranuas').val('');	
						$('#subjectlistuas').html(msg);
						
					}
				});
				return false;
		});
		//Submit Starts		   
		$(".addaccountclose").click(function(){
			$(".addaccount").remove();
		});
		$("#kirimuasutama").submit(function(e){
			$frm = $(this);
			
			if($('input#datekirimuasutama').val()==''  && !$('input#simpanarsipuas').is(':checked')){
				$('input#datekirimuasutama').css('border','1px solid red');
				
			}else{
				$('input#datekirimuasutama').css('border','1px solid #D8D8D8');
			}
			
			if($('select#kelas_adduas').val()==null  && !$('input#simpanarsipuas').is(':checked')){
				$('select#kelas_adduas').css('border','1px solid red');
				return false;
			}else{
				$('select#kelas_adduas').css('border','1px solid #D8D8D8');
			}
			
			if($('input#datekirimuasutama').val()==''  && !$('input#simpanarsipuas').is(':checked')){
				$('input#datekirimuasutama').css('border','1px solid red');
				return false;
			}else{
				$('input#datekirimuasutama').css('border','1px solid #D8D8D8');
			}
			
			//$id_kelas = $frm.find('*[name=id_kelas]').val();
			$id_pelajaran = $frm.find('*[name=id_pelajaran]').val();
			$bab = $frm.find('*[name=bab]').val();
			$judul = $frm.find('*[name=judul]').val();
			//$file = $frm.find('*[name=file]').val();
			$keterangan = $frm.find('*[name=keterangan]').val();
			if($frm.find('*[name=id_pelajaran]').is('.valid') && $frm.find('*[name=bab]').is('.valid') && $frm.find('*[name=judul]').is('.valid') /*&& $frm.find('*[name=file]').is('.valid') && $frm.find('*[name=keterangan]').is('.valid')*/) {
				$.ajax({
					type: "POST",
					data: $(this).serialize(),
					url: $(this).attr('action'),
					beforeSend: function() {
						$("#simpanuas").after("<img id='waituas27' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
						$("#simpanuasbottom").after("<img id='waituas227' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
					},
					success: function(msg) {
							$("#waituas27").remove();
							$("#waituas227").remove();	
						
						ajaxupload("<? echo base_url();?>akademik/kirimuas/uploadfileuas/"+msg,"response","image-list","file");
						
						$.ajax({
							type: "POST",
							data: '&ajax=1',
							url: '<?=base_url('akademik/kirimuas/daftaruaslist')?>',
							beforeSend: function() {
								$("#simpanuas").after("<img id='waituas27' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
								$("#simpanuasbottom").after("<img id='waituas227' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
							},
							success: function(msg) {
								$("#waituas27").remove();
								$("#waituas227").remove();
								//$('select#kelasuas').val('');
								//$('select#pelajaranuas').html($('select#pelajaran_adduas').html());
								//$('select#pelajaranuas').val('');
								$('#subjectlistuas').html(msg);
								$('#subjectpembelajaran').scrollintoview({ speed:'1100'});
							}
						});	
					}
				});
				return false;
			}
			
			return false;
		});//Submit End	
		
		/*$("select#kelas_adduas").change(function(e){
			$.ajax({
				type: "POST",
				data: '',
				url: '<?=base_url()?>admin/pelajaran/getMapelByKelasAndPegawai/'+$(this).val(),
				beforeSend: function() {
					$('select#kelas_adduas').after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
				},
				success: function(msg) {
					$('#wait').remove();
					$("#pelajaran_adduas").html(msg);	
				}
			});
		});*///Submit End
		
		$("#keteranganuas").hide(500);
		$("#tanggaluas").hide(500);
		$("input#simpanarsipuas").change(function(e){
			if($(this).is(':checked')){
				$("select#kelas_adduas").prop('disabled', true);
				//$("input#datekirimuasutama").prop('disabled', true);
				$("#keteranganadduas").val('');
				$("#datekirimuasutama").val('');
				$("#keteranganuas").hide(500);
				$("#tanggaluas").hide(500);
			}else{
				$("select#kelas_adduas").prop('disabled', false);
				//$("input#datekirimuasutama").prop('disabled', false);
				$("#keteranganuas").show(500);
				$("#tanggaluas").show(500);
			}
		});//Submit End
		$("select#pelajaran_adduas").change(function(e){
			$.ajax({
				type: "POST",
				data: '',
				url: '<?=base_url()?>admin/pelajaran/getKelasByPelajaranAndPegawai/'+$(this).val(),
				beforeSend: function() {
					$('select#kelas_adduas').after("<img id='waituas27' src='<?=$this->config->item('images').'loading.png';?>' />");
				},
				success: function(msg) {
					$('#waituas27').remove();
					$("#kelas_adduas").html(msg);	
					$("select#kelas_adduas").parent('td').children('input[type="hidden"]').remove();
					$("select#kelas_adduas option").each(function(e){
						var val=$(this).attr('id_mengajar');
						var id_kelas=$(this).attr('value');
						
						if(e==0){
							$(this).remove();
						}
						if(val!=undefined){
							$("select#kelas_adduas").parent('td').append('<input  type="hidden" name="id_mengajar['+id_kelas+']" value="'+val+'" />');
						}
					});
				}
			});
		});//Submit End
	});
</script>	


<script type="text/javascript">
function getadd(obj,date) {

}
$(function() {
	$('#datekirimuasutama').datepick();
});
</script>	
<div class="addaccount">
<form method="post" name="kirimuasutama" enctype="multipart/form-data" id="kirimuasutama" action="<? echo base_url();?>akademik/kirimuas/kirimuasutama">
	<div onclick="$('.addaccount').remove();" class="addaccountclose"></div>
		
		<h3>Tambah uas</h3>
		<div class="hr"></div>
		<table class="adddata">
			<tbody>
			<tr>
				<th style="text-align:right;" colspan="4">
				<a onclick="$('#kirimuasutama').submit();" id="simpanuas" class="button small light-grey absenbutton" title=""> Simpan </a>
				<a class="button small light-grey absenbutton canceluas" title=""> Cancel </a>
				</th>
			</tr>
			<tr>
				<td class="title">Pelajaran</td>
				<td>:</td>
				<td colspan="2">
					<select class="selectfilter" id="pelajaran_adduas" name="id_pelajaran">
						<option value="">Pilih Pelajaran</option>
						<?
						if(!empty($pelajaran)){			
						foreach($pelajaran as $datapelajaran){?>
						<option <? //if(@$_POST['pelajaran']==$datapelajaran['id']){echo 'selected';}?> value="<?=$datapelajaran['id']?>"><?=$datapelajaran['nama']?> [Kelas <?=$datapelajaran['kelas']?>]</option>
						<? }} ?>
					</select>
				</td>
			</tr>
			<tr>
				<td class="title">Di Kirim ke Kelas</td>
				<td>:</td>
				<td>
					<select class="selectfilter" id="kelas_adduas" disabled name="id_kelas[]" multiple>
						<option value="">Pilih Kelas</option>
						<? foreach($kelas as $datakelas){?>
						<option <? //if(@$_POST['kelas']==$datakelas['id']){echo 'selected';}?> value="<?=$datakelas['id']?>"><?=$datakelas['kelas']?><?=$datakelas['nama']?></option>
						<? } ?>
					</select>
				</td>

			    <td><input type="checkbox" checked id="simpanarsipuas" name="simpanarsipuas" />
&nbsp; Jangan Kirim, Simpan saja sebagai arsip</td>
			</tr>
			<tr id="tanggaluas">
				<td width="30%" class="title">Tanggal Dikumpulkan</td>
				<td width="1">:</td>
				<td colspan="2">
					<input type="text" name="tanggal_kumpul" style="width:100px;" value="" id="datekirimuasutama">
				</td>
			</tr>
			<tr>
				<td class="title">Bab</td>
				<td>:</td>
				<td colspan="2">
					<input type="text" value="" size="30" name="bab">				
				</td>
			</tr>
			<tr>
				<td class="title">Judul uas</td>
				<td>:</td>
				<td colspan="2">
					<input type="text" value="" size="30" name="judul">				
				</td>
			</tr>
			<tr>
				<td width="30%" class="title">Lampiran Soal</td>
				<td width="1">:</td>
				<td colspan="2">
					<input type="file" name="file" id="file" multiple />
					<div id="response" style="font-size:11px;">Anda bisa memilih banyak file dengan memencet tombol "Ctrl", kemudian klik file yang dipilih lebih dari satu</div>
				</td>
			</tr>
			<tr id="keteranganuas">
				<td width="30%" class="title">SMS ke ORTU</td>
				<td width="1">:</td>
				<td colspan="2">
					<textarea name="keterangan" maxlength="200" placeholder="Keterangan akan dikirim ke Orang Tua / Wali Siswa melalui SMS" id="keteranganadduas"></textarea>
				</td>
			</tr>
			<tr>
				<td width="30%" class="title">Berbagi</td>
				<td width="1">:</td>
				<td colspan="2">
					<input type="checkbox" name="share" value="1" checked />
				</td>
			</tr>
			<tr>
				<th style="text-align:right;" colspan="4">
				<a onclick="$('#kirimuasutama').submit();" id="simpanuasbottom" class="button small light-grey absenbutton" title=""> Simpan </a>
				<a class="button small light-grey absenbutton canceluas" title=""> Cancel </a>
				</th>
			</tr>
			
		</tbody></table>

	<input type="hidden" value="1" name="ajax"> 

	<div style="display:none;" class="error-container"> Semua field harus di isi atau dipilih!  </div>
  </form>
</div>