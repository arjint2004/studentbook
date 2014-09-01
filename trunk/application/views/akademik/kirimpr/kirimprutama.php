<script>
	$(document).ready(function(){
		$("#kirimprutama").each(function(){
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
		
		$("table.adddata tr th a.cancelpr").click(function(){
				var obj=$(this);
				$.ajax({
					type: "POST",
					data: 'id_kelas='+$('select#kelaspr').val()+'&pelajaran='+$('select#pelajaranpr').val()+'&ajax=1',
					url: '<?=base_url('akademik/kirimpr/daftarprlist')?>',
					beforeSend: function() {
						$("table.adddata tr th a.cancelpr").after("<img id='waitpr24' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
					},
					success: function(msg) {
						$("#waitpr24").remove();
						//$('select#kelaspr').val('');
						//$('select#pelajaranpr').html($('select#pelajaran_addpr').html());
						//$('select#pelajaranpr').val('');	
						$('#subjectlistpr').html(msg);
						
					}
				});
				return false;
		});
		//Submit Starts		   
		$(".addaccountclose").click(function(){
			$(".addaccount").remove();
		});
		$("#kirimprutama").submit(function(e){
			$frm = $(this);
			
			if($('input#datekirimprutama').val()==''  && !$('input#simpanarsippr').is(':checked')){
				$('input#datekirimprutama').css('border','1px solid red');
				
			}else{
				$('input#datekirimprutama').css('border','1px solid #D8D8D8');
			}
			
			if($('select#kelas_addpr').val()==null  && !$('input#simpanarsippr').is(':checked')){
				$('select#kelas_addpr').css('border','1px solid red');
				return false;
			}else{
				$('select#kelas_addpr').css('border','1px solid #D8D8D8');
			}
			
			if($('input#datekirimprutama').val()==''  && !$('input#simpanarsippr').is(':checked')){
				$('input#datekirimprutama').css('border','1px solid red');
				return false;
			}else{
				$('input#datekirimprutama').css('border','1px solid #D8D8D8');
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
						$("#simpanpr").after("<img id='waitpr27' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
						$("#simpanprbottom").after("<img id='waitpr227' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
					},
					success: function(msg) {
							$("#waitpr27").remove();
							$("#waitpr227").remove();	
						
						ajaxupload("<? echo base_url();?>akademik/kirimpr/uploadfilepr/"+msg,"response","image-list","file");
						
						$.ajax({
							type: "POST",
							data: '&ajax=1',
							url: '<?=base_url('akademik/kirimpr/daftarprlist')?>',
							beforeSend: function() {
								$("#simpanpr").after("<img id='waitpr27' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
								$("#simpanprbottom").after("<img id='waitpr227' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
							},
							success: function(msg) {
								$("#waitpr27").remove();
								$("#waitpr227").remove();
								//$('select#kelaspr').val('');
								//$('select#pelajaranpr').html($('select#pelajaran_addpr').html());
								//$('select#pelajaranpr').val('');
								$('#subjectlistpr').html(msg);
								$('#subjectpembelajaran').scrollintoview({ speed:'1100'});
							}
						});	
					}
				});
				return false;
			}
			
			return false;
		});//Submit End	
		
		/*$("select#kelas_addpr").change(function(e){
			$.ajax({
				type: "POST",
				data: '',
				url: '<?=base_url()?>admin/pelajaran/getMapelByKelasAndPegawai/'+$(this).val(),
				beforeSend: function() {
					$('select#kelas_addpr').after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
				},
				success: function(msg) {
					$('#wait').remove();
					$("#pelajaran_addpr").html(msg);	
				}
			});
		});*///Submit End
		
		$("#keteranganpr").hide(500);
		$("#tanggalpr").hide(500);
		$("input#simpanarsippr").change(function(e){
			if($(this).is(':checked')){
				$("select#kelas_addpr").prop('disabled', true);
				//$("input#datekirimprutama").prop('disabled', true);
				$("#keteranganaddpr").val('');
				$("#datekirimprutama").val('');
				$("#keteranganpr").hide(500);
				$("#tanggalpr").hide(500);
			}else{
				$("select#kelas_addpr").prop('disabled', false);
				//$("input#datekirimprutama").prop('disabled', false);
				$("#keteranganpr").show(500);
				$("#tanggalpr").show(500);
			}
		});//Submit End
		$("select#pelajaran_addpr").change(function(e){
			$.ajax({
				type: "POST",
				data: '',
				url: '<?=base_url()?>admin/pelajaran/getKelasByPelajaranAndPegawai/'+$(this).val(),
				beforeSend: function() {
					$('select#kelas_addpr').after("<img id='waitpr27' src='<?=$this->config->item('images').'loading.png';?>' />");
				},
				success: function(msg) {
					$('#waitpr27').remove();
					$("#kelas_addpr").html(msg);	
					$("select#kelas_addpr").parent('td').children('input[type="hidden"]').remove();
					$("select#kelas_addpr option").each(function(e){
						var val=$(this).attr('id_mengajar');
						var id_kelas=$(this).attr('value');
						
						if(e==0){
							$(this).remove();
						}
						if(val!=undefined){
							$("select#kelas_addpr").parent('td').append('<input  type="hidden" name="id_mengajar['+id_kelas+']" value="'+val+'" />');
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
	$('#datekirimprutama').datepick();
});
</script>	
<div class="addaccount">
<form method="post" name="kirimprutama" enctype="multipart/form-data" id="kirimprutama" action="<? echo base_url();?>akademik/kirimpr/kirimprutama">
	<div onclick="$('.addaccount').remove();" class="addaccountclose"></div>
		
		<h3>Tambah PR</h3>
		<div class="hr"></div>
		<table class="adddata">
			<tbody>
			<tr>
				<th style="text-align:right;" colspan="4">
				<a onclick="$('#kirimprutama').submit();" id="simpanpr" class="button small light-grey absenbutton" title=""> Simpan </a>
				<a class="button small light-grey absenbutton cancelpr" title=""> Cancel </a>
				</th>
			</tr>
			<tr>
				<td class="title">Pelajaran</td>
				<td>:</td>
				<td colspan="2">
					<select class="selectfilter" id="pelajaran_addpr" name="id_pelajaran">
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
					<select class="selectfilter" id="kelas_addpr" disabled name="id_kelas[]" multiple>
						<option value="">Pilih Kelas</option>
						<? foreach($kelas as $datakelas){?>
						<option <? //if(@$_POST['kelas']==$datakelas['id']){echo 'selected';}?> value="<?=$datakelas['id']?>"><?=$datakelas['kelas']?><?=$datakelas['nama']?></option>
						<? } ?>
					</select>
				</td>

			    <td><input type="checkbox" checked id="simpanarsippr" name="simpanarsippr" />
&nbsp; Jangan Kirim, Simpan saja sebagai arsip</td>
			</tr>
			<tr id="tanggalpr">
				<td width="30%" class="title">Tanggal Dikumpulkan</td>
				<td width="1">:</td>
				<td colspan="2">
					<input type="text" name="tanggal_kumpul" style="width:100px;" value="" id="datekirimprutama">
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
				<td class="title">Judul PR</td>
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
			<tr id="keteranganpr">
				<td width="30%" class="title">SMS ke ORTU</td>
				<td width="1">:</td>
				<td colspan="2">
					<textarea name="keterangan"  maxlength="200" placeholder="Keterangan akan dikirim ke Orang Tua / Wali Siswa melalui SMS" id="keteranganaddpr"></textarea>
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
				<a onclick="$('#kirimprutama').submit();" id="simpanprbottom" class="button small light-grey absenbutton" title=""> Simpan </a>
				<a class="button small light-grey absenbutton cancelpr" title=""> Cancel </a>
				</th>
			</tr>
			
		</tbody></table>

	<input type="hidden" value="1" name="ajax"> 

	<div style="display:none;" class="error-container"> Semua field harus di isi atau dipilih!  </div>
  </form>
</div>