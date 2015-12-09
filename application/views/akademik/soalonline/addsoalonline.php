<script src="<?=$this->config->item('bigupload').'js/bigUpload.js';?>"></script>
<script>
	$(document).ready(function(){
		
		$("#soalonline").each(function(){
			$container = $(this).next("div.error-container");
			//Validate Starts
			$(this).validate({
				onfocusout: function(element) {	$(element).valid();	},
				errorContainer: $container,
				rules:{
				  id_pelajaran:{required:true,notEqual:'Pilih Pelajaran'},
				  bab:{required:true,notEqual:''},
				  pokok_bahasan:{required:true,notEqual:''},
				 /* file:{required:true,notEqual:''},
				  keterangan:{required:true,notEqual:''}
				  /*,message:{required:true,minlength:10}*/
				}
			});//Validate End

		});
		$("table.adddata tr th a#cancelsoalonline").click(function(){
				var obj=$(this);
				$.ajax({
					type: "POST",
					data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&id_kelas='+$('select#kelas').val()+'&pelajaran='+$('select#pelajaran').val()+'&ajax=1',
					url: '<?=base_url('akademik/soalonline/daftarsoalonlinelist')?>',
					beforeSend: function() {
						$(obj).after("<img id='wait' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
					},
					success: function(msg) {
						$("#wait").remove();
						$("#wait").remove();
						$('select#kelas').val($('select#kelas_add').val());
						$('select#pelajaran').html($('select#pelajaran_add').html());
						$('select#pelajaran').val($('select#pelajaran_add').val());	
						$('#subjectlistsoalonline').html(msg);
						$('#subject').scrollintoview({ speed:'1100'});
					}
				});
				return false;
		});
		//Submit Starts		   
		$(".addaccountclose").click(function(){
			$(".addaccount").remove();
		});
		filesize('fileaddsoalonline',15000000,50);
		$("#soalonline").submit(function(e){
			
			if($('select#kelas_add').val()==null && !$('input#simpanarsip').is(':checked')){
				$('select#kelas_add').css('border','1px solid red');
					if($('#date2soalonline').val()==''){
						$('#date2soalonline').css('border','1px solid red');
					}else{
						$('#date2soalonline').css('border','1px solid #D7D7D7');
					}
				return false;
			}else{
				$('select#kelas_add').css('border','1px solid #D7D7D7');
			}

			$frm = $(this);
			$id_pelajaran = $frm.find('*[name=id_pelajaran]').val();
			$bab = $frm.find('*[name=bab]').val();
			$pokok_bahasan = $frm.find('*[name=pokok_bahasan]').val();
			/*$file = $frm.find('*[name=file]').val();
			$keterangan = $frm.find('*[name=keterangan]').val();*/
			if($frm.find('*[name=id_pelajaran]').is('.valid') && $frm.find('*[name=bab]').is('.valid') && $frm.find('*[name=pokok_bahasan]').is('.valid') /*&& $frm.find('*[name=file]').is('.valid')  && $frm.find('*[name=keterangan]').is('.valid')*/) {
				$.ajax({
					type: "POST",
					data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&'+$(this).serialize()+'&'+$('form#nilai').serialize(),
					url: $(this).attr('action'),
					beforeSend: function() {
						$("#soalonline").append("<div class=\"error-box\" style='display: block; top: 50%; position: fixed; left: 46%;'></div>");
						$(".error-box").delay(1000).html('Memasukkan Data');
						//$("#simpanpr").after("<img id='wait' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
					},
					success: function(msg) {
						$(".error-box").delay(1000).fadeOut("slow",function(){
							$(this).remove();
						});		
						
						var settings = {
							'inputField': 'bigUploadFile',
							'formId': 'bigUploadForm',
							'progressBarField': 'bigUploadProgressBarFilled',
							'timeRemainingField': 'bigUploadTimeRemaining',
							'responseField': 'bigUploadResponse',
							'submitButton': 'bigUploadSubmit',
							'progressBarColor': '#5bb75b',
							'progressBarColorError': '#da4f49',
							'scriptPath': '<?=base_url()?>asset/default/ajaxbigupload/inc/bigUpload.php?dr=<?=$upload_dir?>',
							//'scriptPath': '<?=base_url()?>akademik/soalonline/upload',
							'scriptPathParams': '',
							'chunkSize': 1000000,
							'maxFileSize': 25000000
						}
						bigUpload = new bigUpload(settings);
						$("#soalonline").append("<div class=\"error-box\" style='display: block; top: 50%; position: fixed; left: 46%;'></div>");
						$(".error-box").delay(1000).html('Sedang proses UPLOAD');
						
						bigUpload.success = function(response) {
							if(response.errorStatus==0){
								$.ajax({
									url: "<? echo base_url();?>akademik/soalonline/upload/"+msg,
									type: "POST",
									data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&id_soalonline='+msg+'&fileName='+response.fileName,
									beforeSend: function() {
										$("#soalonline").append("<div class=\"error-box\" style='display: block; top: 50%; position: fixed; left: 46%;'></div>");
										$(".error-box").delay(1000).html('Menyimpan data');
									},
									error	: function(){
										alert('Gagal menyimpan data');						
									},
									success: function (res) {
										$(".error-box").delay(1000).fadeOut("slow",function(){
											$(this).remove();
										});	
										if(res=='null'){
											$.ajax({
												type: "POST",
												data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&&ajax=1',
												url: '<?=base_url('akademik/soalonline/daftarsoalonlinelist')?>',
												beforeSend: function() {
													$("#soalonline").append("<div class=\"error-box\" style='display: block; top: 50%; position: fixed; left: 46%;'></div>");
													$(".error-box").delay(1000).html('Load data');
													$(".error-box").delay(1000).fadeOut("slow",function(){
														$(this).remove();
													});
												},
												success: function(msg2) {
													$("#wait").remove();
													$('select#kelas').val($('select#kelas_add').val());
													$('select#pelajaran').html($('select#pelajaran_add').html());
													$('select#pelajaran').val($('select#pelajaran_add').val());
													$('#subjectlistsoalonline').html(msg2);
													$('#subject').scrollintoview({ speed:'1100'});
												}
											});
										}else{
											alert(res+'');
											$('#subjectlistsoalonline').load('<?=base_url('akademik/soalonline/editsoalonline')?>/'+msg);
										}
									}
								});								
							}
						};
						bigUpload.fire();
						


						

						$("#wait").remove();
					}
				});
				return false;
			}
			
			return false;
		});//Submit End	
		
		/*$("select#kelas_add").change(function(e){
			$.ajax({
				type: "POST",
				data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&',
				url: '<?=base_url()?>admin/pelajaran/getMapelByKelasAndPegawai/'+$(this).val(),
				beforeSend: function() {
					$('select#kelas_add').after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
				},
				success: function(msg) {
					$('#wait').remove();
					$("#pelajaran_add").html(msg);	
				}
			});
		});*///Submit End
		
		$("#keterangansoalonline").hide(500);
		$("#tanggalsoalonline").hide(500);
		$("input#simpanarsip").change(function(e){
			if($(this).is(':checked')){
				$("select#kelas_add").prop('disabled', true);
				//$("#keteranganaddsoalonline").prop('disabled', true);
				$("#keteranganaddsoalonline").val('');
				$("#keterangansoalonline").hide(500);
				//$("#date2soalonline").prop('disabled', true);
				$("#date2soalonline").val('');
				$("#tanggalsoalonline").hide(500);
			}else{
				$("select#kelas_add").prop('disabled', false);
				//$("#keteranganaddsoalonline").prop('disabled', false);
				$("#keterangansoalonline").show(500);
				//$("#date2soalonline").prop('disabled', false);
				$("#tanggalsoalonline").show(500);
			}
			
		});//Submit End
		$("select#pelajaran_add").change(function(e){
			$.ajax({
				type: "POST",
				data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&',
				url: '<?=base_url()?>admin/pelajaran/getKelasByPelajaranAndPegawai/'+$(this).val(),
				beforeSend: function() {
					$('select#kelas_add').after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
				},
				success: function(msg) {
					$('#wait').remove();
					$("#kelas_add").html(msg);	
				}
			});
		});//Submit End
	});
</script>	


<script type="text/javascript">
function getadd(obj,date) {

}
$(function() {
	$('#datesoalonline').datepick();
	$('#date2soalonline').datepick();
});
</script>	
<div class="addaccount">
<form method="post" name="soalonline" enctype="multipart/form-data" id="soalonline" action="<? echo base_url();?>akademik/soalonline/addsoalonline">
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
	<div onclick="$('.addaccount').remove();" class="addaccountclose"></div>
		
		<h3>Tambah Soalonline</h3>
		<div class="hr"></div>
		<table class="adddata">
			<tbody>
			<tr>
				<th style="text-align:right;" colspan="4">
				<a onclick="$('#soalonline').submit();" id="simpanpr" class="button small light-grey absenbutton" title=""> Simpan </a>
				<a id="cancelsoalonline" class="button small light-grey absenbutton" title=""> Cancel </a>
				</th>
			</tr>
			<tr>
				<td class="title">Pelajaran</td>
				<td>:</td>
				<td colspan="2">
					<select class="selectfilter" id="pelajaran_add" name="id_pelajaran">
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
				<td class="title">Kirim Soalonline ke Kelas</td>
				<td>:</td>
				<td>
					<select class="selectfilter" id="kelas_add" name="id_kelas[]" disabled multiple>
						<option value="">Pilih Kelas</option>
						<? foreach($kelas as $datakelas){?>
						<option <? //if(@$_POST['kelas']==$datakelas['id']){echo 'selected';}?> value="<?=$datakelas['id']?>"><?=$datakelas['kelas']?><?=$datakelas['nama']?></option>
						<? } ?>
					</select>
				</td>
			    <td>
					<div id="response" style="font-size:11px;"><input type="checkbox" checked id="simpanarsip" name="simpanarsip" /> &nbsp; Jangan Kirim, Simpan saja sebagai arsip</div></td>
			</tr>
			<tr>
				<td class="title">Pokok Bahasan</td>
				<td>:</td>
				<td colspan="2">
					<input type="text" value="" size="30" name="pokok_bahasan">				
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
				<td width="30%" class="title">Lampiran file dengan upload</td>
				<td width="1">:</td>
				<td colspan="2">
					<input type="file" id="bigUploadFile" name="bigUploadFile" />
					<input type="button" class="bigUploadButton" value="Start Upload" id="bigUploadSubmit"  style="display:none" />
					<input type="button" class="bigUploadButton bigUploadAbort" value="Cancel"  style="display:none" />
					<div id="bigUploadProgressBarContainer">
						<div id="bigUploadProgressBarFilled">
						</div>
					</div>
					<div id="bigUploadTimeRemaining"></div>
					<div id="bigUploadResponse"></div>
					<!--<div id="response" style="font-size:11px;">Anda bisa memilih banyak file dengan memencet tombol "Ctrl", kemudian klik file yang dipilih lebih dari satu</div>-->
				</td>
			</tr>
			<tr>
				<td width="30%" class="title">Lampiran file dari content belajar</td>
				<td width="1">:</td>
				<td colspan="2">
					<ul class="file" id="addsoalonlinecontbljr"></ul>
					<a class="button small light-grey zoom-icon modal" title="" href="<?=base_url('akademik/bahanajar/guru/908786/additional')?>" style="margin-left:0;"> <span> Pilih soalonline dari content belajar </span> </a>
					<!--<div id="response" style="font-size:11px;">Anda bisa memilih banyak file dari daftar "Content Belajar", klik tombol diatas kemudian pilih file</div>-->
				</td>
			</tr>
			<!--<tr>
				<td width="30%" class="title">Diberikan Tanggal</td>
				<td width="1">:</td>
				<td>
					<input type="text" name="tanggal_diberikan" style="width:100px;" value="<?=date('Y-m-d')?>" id="datesoalonline">
				</td>
			</tr>--> 
			<tr  id="tanggalsoalonline">
				<td width="30%" class="title">Tanggal Diajarkan</td>
				<td width="1">:</td>
				<td colspan="2">
					<input type="text" name="tanggal_diajarkan" style="width:100px;" value="" id="date2soalonline" />
				</td>
			</tr>
			<tr id="keterangansoalonline">
				<td width="30%" class="title">Keterangan</td>
				<td width="1">:</td>
				<td colspan="2">
					<textarea name="keterangan" id="keteranganaddsoalonline"></textarea>
				</td>
			</tr>
			<!--<tr>
				<td width="30%" class="title">Berbagi</td>
				<td width="1">:</td>
				<td colspan="2">
					<input type="checkbox" checked name="share" value="1" />
				</td>
			</tr>-->
			
			<tr>
				<th style="text-align:right;" colspan="4">
				<a onclick="$('#soalonline').submit();" id="simpanpr" class="button small light-grey absenbutton" title=""> Simpan </a>
				<a id="cancelsoalonline" class="button small light-grey absenbutton" title=""> Cancel </a>
				</th>
			</tr>
		</tbody></table>

	<input type="hidden" value="1" name="ajax"> 

	<div style="display:none;" class="error-container"> Semua field yang merah harus di isi atau dipilih!  </div>
  </form>
</div>