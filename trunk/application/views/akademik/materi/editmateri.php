<script>
	$(document).ready(function(){
		$("#materi").each(function(){
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
		$("table.adddata tr th a#cancelmateri").click(function(){
				var obj=$(this);
				$.ajax({
					type: "POST",
					data: 'ajax=1',
					url: '<?=base_url('akademik/materi/daftarmaterilist')?>',
					beforeSend: function() {
						$(obj).after("<img id='wait' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
					},
					success: function(msg) {
						$("#wait").remove();
						$("#wait").remove();
						//$('select#kelas').val($('select#kelas_addeditmateri').val());
						//$('select#pelajaran').html($('select#pelajaran_add').html());
						//$('select#pelajaran').val($('select#pelajaran_add').val());	
						$('#subjectlistmateri').html(msg);
						$('#subject').scrollintoview({ speed:'1100'});
					}
				});
				return false;
		});	
		//Submit Starts		   
		$(".addaccountclose").click(function(){
			$(".addaccount").remove();
		});
		filesize('fileaddmateri',15000000,50);
		$("#materi").submit(function(e){
			$frm = $(this);
			//$id_kelas = $frm.find('*[name=id_kelas]').val();
			$id_pelajaran = $frm.find('*[name=id_pelajaran]').val();
			$bab = $frm.find('*[name=bab]').val();
			$pokok_bahasan = $frm.find('*[name=pokok_bahasan]').val();
			//$keterangan = $frm.find('*[name=keterangan]').val();
			if(/*$frm.find('*[name=id_kelas]').is('.valid') && $frm.find('*[name=id_pelajaran]').is('.valid') && */$frm.find('*[name=bab]').is('.valid') && $frm.find('*[name=pokok_bahasan]').is('.valid')  /*&&  $frm.find('*[name=keterangan]').is('.valid')*/) {
				$.ajax({
					type: "POST",
					data: $(this).serialize()+'&'+$('form#nilai').serialize(),
					url: $(this).attr('action'),
					beforeSend: function() {
						$("#materi").append("<div class=\"error-box\" style='display: block; top: 50%; position: fixed; left: 46%;'></div>");
						$(".error-box").delay(1000).html('Memasukkan Data');
					},
					success: function(msg) {
						$(".error-box").delay(1000).fadeOut("slow",function(){
							$(this).remove();
						});	
						var upload=ajaxuploadnew("<? echo base_url();?>akademik/materi/upload/"+msg,"response","image-list","fileaddmateri");
						
						$.ajax({
							url: "<? echo base_url();?>akademik/materi/upload/"+msg,
							type: "POST",
							data: upload,
							processData: false,
							contentType: false,
							beforeSend: function() {
								$("#materi").append("<div class=\"error-box\" style='display: block; top: 50%; position: fixed; left: 46%;'></div>");
								$(".error-box").delay(1000).html('Proses Upload File');
							},
							error	: function(){
								alert('Materi anda sudah tersimpan. Tetapi lampiran file anda gagal di Upload. Klik OK untuk melengkapi lampiran');
								$('#fileaddmateri').val("");
								return false;
								//$('#subjectlistmateri').load('<?=base_url('akademik/materi/editmateri')?>/'+msg);						
							},
							success: function (res) {
								$(".error-box").delay(1000).fadeOut("slow",function(){
									$(this).remove();
								});	
								if(res=='null'){
									$.ajax({
										type: "POST",
										data: '&ajax=1',
										url: '<?=base_url('akademik/materi/daftarmaterilist')?>',
										beforeSend: function() {
											$("#materi").append("<div class=\"error-box\" style='display: block; top: 50%; position: fixed; left: 46%;'></div>");
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
											$('#subjectlistmateri').html(msg2);
											$('#subject').scrollintoview({ speed:'1100'});
										}
									});
								}else{
									alert(res+'');
									//$('#subjectlistmateri').load('<?=base_url('akademik/materi/editmateri')?>/'+msg);
									$('#fileaddmateri').val("");
									return false;
								}
							}
						});
					}
				});
				return false;
			}
			
			return false;
		});//Submit End	
		//$('#pelajaran_add').load('<?=base_url()?>admin/pelajaran/getMapelByKelasAndPegawai/'+$('#kelas_addeditmateri').val()+'/<?=$materi[0]['id_pelajaran']?>');
		
		/*$.ajax({
				type: "POST",
				data: '',
				url: '<?=base_url()?>akademik/materi/getOptionFileMateriByIdMateri/<?=$materi[0]['id']?>',
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
					data: '',
					url: base_url+'akademik/materi/deletefile/'+$(this).attr('id'),
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
		/*$("select#kelas_addeditmateri").change(function(e){
			$.ajax({
				type: "POST",
				data: '',
				url: '<?=base_url()?>admin/pelajaran/getMapelByKelasAndPegawai/'+$(this).val(),
				beforeSend: function() {
					$('select#kelas_addeditmateri').after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
				},
				success: function(msg) {
					$('#wait').remove();
					$("#pelajaran_add").html(msg);	
				}
			});
		});*///Submit End
		
		
		$('a#selectalleditmateri').click(function() {
			$('#kelas_addeditmateri > option').attr("selected", "selected");
		});   

		$('a#deselectalleditmateri').click(function() {
			$('#kelas_addeditmateri > option').removeAttr("selected");
		});
	});
</script>	


<script type="text/javascript">
function getadd(obj,date) {

}
$(function() {
	$('#datemateri').datepick();
	$('#date2materi').datepick();
});
</script>	
<div class="addaccount">
<? //pr($materi);?>
<form method="post" name="materi" enctype="multipart/form-data" id="materi" action="<? echo base_url();?>akademik/materi/editmateri/<?=@$materi[0]['id']?>">
	<div onclick="$('.addaccount').remove();" class="addaccountclose"></div>
		
		<h3>Edit Materi</h3>
		<div class="hr"></div>
		<table class="adddata">
			<tbody><tr>
				<th style="text-align:right;" colspan="3">
				<a onclick="$('#materi').submit();" id="simpanmateri" class="button small light-grey absenbutton simpanmateri" title=""> Simpan </a>
				<a id="cancelmateri" class="button small light-grey absenbutton" title=""> Cancel </a>
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
						<option <? if(@$materi[0]['id_pelajaran']==$datapelajaran['id']){echo 'selected';}?> value="<?=$datapelajaran['id']?>"><?=$datapelajaran['nama']?> [Kelas <?=$datapelajaran['kelas']?>]</option>
						<? }} ?>
					</select>
					<input type="hidden" name="id_pelajaran" value="<?=@$materi[0]['id_pelajaran']?>" />
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
								<select class="selectfilter" style="width:100px;" id="kelas_addeditmateri" name="id_kelas[]" multiple >
								  
								  <? foreach($kelas as $datakelas){?>
								  <option  <? if(isset($kelaspenerima2[$datakelas['id']])){echo 'style="display:none;"';}?> value="<?=$datakelas['id']?>">
								  <?=$datakelas['kelas']?>
								  <?=$datakelas['nama']?>
								  </option>
								  <? } ?>
								</select>
								<a id="selectalleditmateri" style="cursor:pointer;">Pilih Semua</a> |
								<a id="deselectalleditmateri" style="cursor:pointer;">Kosongkan Pilihan</a>
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
					<input type="text" value="<?=@$materi[0]['pokok_bahasan']?>" size="30" name="pokok_bahasan">				
				</td>
			</tr>
			<tr>
				<td class="title">Bab</td>
				<td>:</td>
				<td>
					<input type="text" value="<?=@$materi[0]['bab']?>" size="30" name="bab">				
				</td>
			</tr>
			<tr>
				<td width="30%" class="title">Lampiran File</td>
				<td width="1">:</td>
				<td>
					<input type="file" name="file" id="fileaddmateri" multiple />
					<div id="response" style="font-size:11px;">Anda bisa memilih banyak file dengan memencet tombol "Ctrl", kemudian klik file yang dipilih lebih dari satu</div>
					<form id="remidialfile" method="post" action="">
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
					<ul class="file" id="addmatericontbljr"></ul>
					<a class="button small light-grey zoom-icon modal" title="" href="<?=base_url('akademik/bahanajar/guru/908786')?>" style="margin-left:0;"> <span> Pilih materi dari content belajar </span> </a>
				</td>
			</tr>
			<!--<tr>
				<td width="30%" class="title">Diberikan Tanggal</td>
				<td width="1">:</td>
				<td>
					<input type="text" name="tanggal_diberikan" style="width:100px;" value="<?=@$materi[0]['tanggal_buat']?>" id="datemateri">
				</td>
			</tr>
			<tr>
				<td width="30%" class="title">Tanggal Diajarkan</td>
				<td width="1">:</td>
				<td>
					<input type="text" name="tanggal_diajarkan" style="width:100px;" value="<?=@$materi[0]['tanggal_diberikan']?>" id="date2materi">
				</td>
			</tr>-->
			<tr>
				<td width="30%" class="title">Keterangan</td>
				<td width="1">:</td>
				<td>
					<textarea name="keterangan"><?=@$materi[0]['keterangan']?></textarea>
				</td>
			</tr>
			<tr>
				<td width="30%" class="title">Berbagi</td>
				<td width="1">:</td>
				<td>
					<input type="checkbox" <? if(@$materi[0]['share']==1){echo "checked";}?> name="share" value="1" />
					<input type="hidden" name="id" value="<?=@$materi[0]['id']?>" />
				</td>
			</tr>
			<tr>
				<th style="text-align:right;" colspan="3">
				<a onclick="$('#materi').submit();" id="simpanmateri" class="button small light-grey absenbutton simpanmateri" title=""> Simpan </a>
				<a id="cancelmateri" class="button small light-grey absenbutton" title=""> Cancel </a>
				</th>
			</tr>
			
		</tbody></table>



	<input type="hidden" value="1" name="ajax"> 

	<div style="display:none;" class="error-container"> Semua field yang merah harus di isi atau dipilih!  </div>
	</form>
</div>