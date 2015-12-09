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
				  //id_kelas:{required:true,notEqual:'Pilih Kelas'},
				  id_pelajaran:{required:true,notEqual:'Pilih Pelajaran'},
				  bab:{required:true,notEqual:''},
				  pokok_bahasan:{required:true,notEqual:''},
				  
				  /*keterangan:{required:true,notEqual:''}
				  ,message:{required:true,minlength:10}*/
				}
			});//Validate End

		});
		$("table.adddata tr th a#cancelsoalonline").click(function(){
				var obj=$(this);
				$.ajax({
					type: "POST",
					data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&ajax=1',
					url: '<?=base_url('akademik/soalonline/daftarsoalonlinelist')?>',
					beforeSend: function() {
						$(obj).after("<img id='wait' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
					},
					success: function(msg) {
						$("#wait").remove();
						$("#wait").remove();
						//$('select#kelas').val($('select#kelas_addeditsoalonline').val());
						//$('select#pelajaran').html($('select#pelajaran_add').html());
						//$('select#pelajaran').val($('select#pelajaran_add').val());	
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
		//filesize('fileaddsoalonline',15000000,10);
		$("#soalonline").submit(function(e){
			e.preventDefault();
			$frm = $(this);
			//$id_kelas = $frm.find('*[name=id_kelas]').val();
			$id_pelajaran = $frm.find('*[name=id_pelajaran]').val();
			$bab = $frm.find('*[name=bab]').val();
			$pokok_bahasan = $frm.find('*[name=pokok_bahasan]').val();
			//$keterangan = $frm.find('*[name=keterangan]').val();
			if(/*$frm.find('*[name=id_kelas]').is('.valid') && $frm.find('*[name=id_pelajaran]').is('.valid') && */$frm.find('*[name=bab]').is('.valid') && $frm.find('*[name=pokok_bahasan]').is('.valid')  /*&&  $frm.find('*[name=keterangan]').is('.valid')*/) {
				$.ajax({
					type: "POST",
					data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&'+$(this).serialize()+'&'+$('form#nilai').serialize(),
					url: $(this).attr('action'),
					beforeSend: function() {
						$("#soalonline").append("<div class=\"error-box\" style='display: block; top: 50%; position: fixed; left: 46%;'></div>");
						$(".error-box").delay(1000).html('Memasukkan Data');
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
										type: "POST",
										data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&id_soalonline=<?=@$soalonline[0]['id']?>&fileName='+response.fileName,
										url: '<?=base_url('akademik/soalonline/upload/'.@$soalonline[0]['id'].'')?>',
										beforeSend: function() {
											$("#soalonline").append("<div class=\"error-box\" style='display: block; top: 50%; position: fixed; left: 46%;'></div>");
											$(".error-box").delay(1000).html('Menyimpan Ke database');
											$(".error-box").delay(1000).fadeOut("slow",function(){
												$(this).remove();
												$(".error-box").remove();
											});
										},
										success: function(msg) {
											$.ajax({
												type: "POST",
												data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&ajax=1',
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
													//$('select#kelas').val($('select#kelas_add').val());
													$('select#pelajaran').html($('select#pelajaran_add').html());
													$('select#pelajaran').val($('select#pelajaran_add').val());
													$('#subjectlistsoalonline').html(msg2);
													$('#subject').scrollintoview({ speed:'1100'});
												}
											});
										}
									});
									

								}else{
									alert('error');
									//$('#subjectlistsoalonline').load('<?=base_url('akademik/soalonline/editsoalonline')?>/'+msg);
									$('#fileaddsoalonline').val("");
									return false;
								}
						};
						bigUpload.fire();
						
					}
				});
				return false;
			}
			
			return false;
		});//Submit End	
		//$('#pelajaran_add').load('<?=base_url()?>admin/pelajaran/getMapelByKelasAndPegawai/'+$('#kelas_addeditsoalonline').val()+'/<?=$soalonline[0]['id_pelajaran']?>');
		
		/*$.ajax({
				type: "POST",
				data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&',
				url: '<?=base_url()?>akademik/soalonline/getOptionFileSoalonlineByIdSoalonline/<?=$soalonline[0]['id']?>',
				beforeSend: function() {
					$('select#judul_add').after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
				},
				success: function(msg) {
					$('#wait').remove();
					$("#filecek").html(msg);	
				}
		});*/
		$("ul.file div.actdell").click(function(){
			var objdell=$(this);
			if(confirm('File akan di hapus secara permanen, untuk menggunakannya kembali anda harus upload ulang..')){
				$.ajax({
					type: "POST",
					data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&',
					url: base_url+'akademik/soalonline/deletefile/'+$(this).attr('id'),
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
		/*$("select#kelas_addeditsoalonline").change(function(e){
			$.ajax({
				type: "POST",
				data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&',
				url: '<?=base_url()?>admin/pelajaran/getMapelByKelasAndPegawai/'+$(this).val(),
				beforeSend: function() {
					$('select#kelas_addeditsoalonline').after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
				},
				success: function(msg) {
					$('#wait').remove();
					$("#pelajaran_add").html(msg);	
				}
			});
		});*///Submit End
		
		
		$('a#selectalleditsoalonline').click(function() {
			$('#kelas_addeditsoalonline > option').attr("selected", "selected");
		});   

		$('a#deselectalleditsoalonline').click(function() {
			$('#kelas_addeditsoalonline > option').removeAttr("selected");
		});
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
<? //pr($soalonline);?>
<form method="post" name="soalonline" enctype="multipart/form-data" id="soalonline" action="<? echo base_url();?>akademik/soalonline/editsoalonline/<?=@$soalonline[0]['id']?>">
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
	<div onclick="$('.addaccount').remove();" class="addaccountclose"></div>
		
		<h3>Edit Soalonline</h3>
		<div class="hr"></div>
		<table class="adddata">
			<tbody><tr>
				<th style="text-align:right;" colspan="3">
				<a onclick="$('#soalonline').submit();" id="simpansoalonline" class="button small light-grey absenbutton simpansoalonline" title=""> Simpan </a>
				<a id="cancelsoalonline" class="button small light-grey absenbutton" title=""> Cancel </a>
				</th>
			</tr>
			<tr>
				<td class="title">Pelajaran</td>
				<td>:</td>
				<td>
					<select class="selectfilter" id="pelajaran_add" name="id_pelajaran" disabled>
						<option value="">Pilih Pelajaran</option>
						<?
						if(!empty($pelajaran)){			
						foreach($pelajaran as $datapelajaran){?>
						<option <? if(@$soalonline[0]['id_pelajaran']==$datapelajaran['id']){echo 'selected';}?> value="<?=$datapelajaran['id']?>"><?=$datapelajaran['nama']?> [Kelas <?=$datapelajaran['kelas']?>]</option>
						<? }} ?>
					</select>
					<input type="hidden" name="id_pelajaran" value="<?=@$soalonline[0]['id_pelajaran']?>" />
				</td>
			</tr>
			<tr>
				<td class="title">Di Kirim ke Kelas</td>
				<td>:</td>
			  <td>
					<table class="adddata">
						<thead>
						<tr>
							<th>Telah dikirim ke </th>
							<th>Kirim juga ke kelas </th>
						</tr>
						</thead>
						<tbody>
						<tr>
							<td>
								<?
								foreach($kelaspenerima as $datakelas){
									echo $datakelas['kelas'].$datakelas['nama']."<br />";
								} 
								?>
							</td>
							<td>
								<select class="selectfilter" style="width:100px;" id="kelas_addeditsoalonline" name="id_kelas[]" multiple >
								  
								  <? foreach($kelas as $datakelas){?>
								  <option  <? if(isset($kelaspenerima2[$datakelas['id']])){echo 'style="display:none;"';}?> value="<?=$datakelas['id']?>">
								  <?=$datakelas['kelas']?>
								  <?=$datakelas['nama']?>
								  </option>
								  <? } ?>
								</select>
								<a id="selectalleditsoalonline" style="cursor:pointer;">Pilih Semua</a> |
								<a id="deselectalleditsoalonline" style="cursor:pointer;">Kosongkan Pilihan</a>
							</td>
						</tr>
						</tbody>
                    </table>
				</td>
			</tr>
			<tr>
				<td class="title">Pokok Bahasan</td>
				<td>:</td>
				<td>
					<input type="text" value="<?=@$soalonline[0]['pokok_bahasan']?>" size="30" name="pokok_bahasan">				
				</td>
			</tr>
			<tr>
				<td class="title">Bab</td>
				<td>:</td>
				<td>
					<input type="text" value="<?=@$soalonline[0]['bab']?>" size="30" name="bab">				
				</td>
			</tr>
			<tr>
				<td width="30%" class="title">Lampiran File</td>
				<td width="1">:</td>
				<td>
				
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
					<form id="remidialfile" method="post" action="">
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
					<ul class="file">
						<?foreach($files as $file){
						if($file['source']=='upload'){
						?>
							<li><?=$file['file_name']?><div id="<?=$file['id']?>" class="actdell"></div></li>
						<? }} ?>
					</ul>
					</form>
				</td>
			</tr>
			<tr>
				<td width="30%" class="title">Lampiran file dari content belajar</td>
				<td width="1">:</td>
				<td colspan="2">
					<ul class="file">
						<?foreach($files as $file){
						if($file['source']=='content_belajar'){
						$nmfcnt=explode("/",$file['file_name']);
						?>
							<li><?=$nmfcnt[3]?>|<?=$nmfcnt[4]?>|<?=str_replace("_"," ",$nmfcnt[5])?><div id="<?=$file['id']?>" class="actdell"></div></li>
						<? }} ?>
					</ul>
					<ul class="file" id="addsoalonlinecontbljr"></ul>
					<a class="button small light-grey zoom-icon modal" title="" href="<?=base_url('akademik/bahanajar/guru/908786')?>" style="margin-left:0;"> <span> Pilih soalonline dari content belajar </span> </a>
				</td>
			</tr>
			<!--<tr>
				<td width="30%" class="title">Diberikan Tanggal</td>
				<td width="1">:</td>
				<td>
					<input type="text" name="tanggal_diberikan" style="width:100px;" value="<?=@$soalonline[0]['tanggal_buat']?>" id="datesoalonline">
				</td>
			</tr>
			<tr>
				<td width="30%" class="title">Tanggal Diajarkan</td>
				<td width="1">:</td>
				<td>
					<input type="text" name="tanggal_diajarkan" style="width:100px;" value="<?=@$soalonline[0]['tanggal_diberikan']?>" id="date2soalonline">
				</td>
			</tr>-->
			<tr>
				<td width="30%" class="title">Keterangan</td>
				<td width="1">:</td>
				<td>
					<textarea name="keterangan"><?=@$soalonline[0]['keterangan']?></textarea>
				</td>
			</tr>
			<tr>
				<td width="30%" class="title">Berbagi</td>
				<td width="1">:</td>
				<td>
					<input type="checkbox" <? if(@$soalonline[0]['share']==1){echo "checked";}?> name="share" value="1" />
					<input type="hidden" name="id" value="<?=@$soalonline[0]['id']?>" />
				</td>
			</tr>
			<tr>
				<th style="text-align:right;" colspan="3">
				<a onclick="$('#soalonline').submit();" id="simpansoalonline" class="button small light-grey absenbutton simpansoalonline" title=""> Simpan </a>
				<a id="cancelsoalonline" class="button small light-grey absenbutton" title=""> Cancel </a>
				</th>
			</tr>
			
		</tbody></table>



	<input type="hidden" value="1" name="ajax"> 

	<div style="display:none;" class="error-container"> Semua field yang merah harus di isi atau dipilih!  </div>
	</form>
</div>