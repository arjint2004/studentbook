<script>
	$(document).ready(function(){
		$("#kirimutsutamaedit").each(function(){
			$container = $(this).next("div.error-container");
			//Validate Starts
			$(this).validate({
				onfocusout: function(element) {	$(element).valid();	},
				errorContainer: $container,
				rules:{
				  //id_kelas:{required:true,notEqual:'Pilih Kelas'},
				  //id_pelajaran:{required:true,notEqual:'Pilih Pelajaran'},
				  bab:{required:true,notEqual:''},
				  judul:{required:true,notEqual:''},
				  //keterangan:{required:true,notEqual:''}
				  /*,message:{required:true,minlength:10}*/
				}
			});//Validate End

		});
	
		$("table.adddata tr th a.cancelutsutama").click(function(){
				var obj=$(this);
				$.ajax({
					type: "POST",
					data: 'id_kelas='+$('select#kelasuts').val()+'&pelajaran='+$('select#pelajaranuts').val()+'&ajax=1',
					url: '<?=base_url('akademik/kirimuts/daftarutslist')?>',
					beforeSend: function() {
						$('table.adddata tr th a.cancelutsutama').after("<img class='waituts30' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
					},
					success: function(msg) {
						$(".waituts30").remove();
						//$('select#kelasuts').val($('select#kelasuts').val());
						//$('select#pelajaranuts').html($('select#pelajaran_adduts').html());
						//$('select#pelajaranuts').val($('select#pelajaranuts').val());	
						$('#subjectlistuts').html(msg);
						$('#subjectujian').scrollintoview({ speed:'1100'});
					}
				});
				return false;
		});	
		
		$("ul.file div.actdell").click(function(){
			var objdell=$(this);
			if(confirm('File akan di hapus secara permanen, untuk menggunakannya kembali anda harus upload ulang..')){
				$('ul.file').load();
				$.ajax({
					type: "POST",
					data: '',
					url: base_url+'akademik/kirimuts/deletefile/'+$(this).attr('id'),
					beforeSend: function() {
						$(objdell).after("<img id='waituts31' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
					},
					success: function(msg) {
						$("#waituts31").remove();	
						$(objdell).parent().remove();
					}
				});
				return false;
			}
		});		   
		$(".addaccountclose").click(function(){
			$(".addaccount").remove();
		});
		//$('#pelajaran_adduts').load('<?=base_url()?>admin/pelajaran/getMapelByKelasAndPegawai/'+$('#kelas_adduts').val()+'/<?=$uts['uts'][0]['id_pelajaran']?>');
		filesize('fileadduts',15000000,50);
		$("#kirimutsutamaedit").submit(function(e){
			
			if($('input#datekirimuts').val()==''  && $('select#kelas_adduts').val()!=null){
				$('input#datekirimuts').css('border','1px solid red');
				
			}else{
				$('input#datekirimuts').css('border','1px solid #D8D8D8');
			}
			
			if($('input#datekirimuts').val()==''  && $('select#kelas_adduts').val()!=null){
				$('input#datekirimuts').css('border','1px solid red');
				//$('input#file').scrollintoview({ speed:'1100'});
				return false;
			}else{
				$('input#datekirimuts').css('border','1px solid #D8D8D8');
			}
			
			$frm = $(this);
			$subject = $frm.find('*[name=subject]').val();
			$id_kelas = $frm.find('*[name=id_kelas]').val();
			$id_pelajaran = $frm.find('*[name=id_pelajaran]').val();
			$bab = $frm.find('*[name=bab]').val();
			$judul = $frm.find('*[name=judul]').val();
			//$keterangan = $frm.find('*[name=keterangan]').val();
			if(/*$frm.find('*[name=id_kelas]').is('.valid') && $frm.find('*[name=id_pelajaran]').is('.valid') &&*/ $frm.find('*[name=bab]').is('.valid') && $frm.find('*[name=judul]').is('.valid')  /*&& $frm.find('*[name=keterangan]').is('.valid')*/) {
				$.ajax({
					type: "POST",
					data: $(this).serialize(),
					url: $(this).attr('action'),
					beforeSend: function() {
						$("#kirimutsutamaedit").append("<div class=\"error-box\" style='display: block; top: 50%; position: fixed; left: 46%;'></div>");
						$(".error-box").delay(1000).html('Inserting Data');
					},
					success: function(msg) {	
						$(".error-box").delay(1000).fadeOut("slow",function(){
							$(this).remove();
						});
						var upload=ajaxuploadnew("<? echo base_url();?>akademik/kirimuts/uploadfileuts/"+msg,"response","image-list","fileadduts");
						
						$.ajax({
							url: "<? echo base_url();?>akademik/kirimuts/uploadfileuts/"+msg,
							type: "POST",
							data: upload,
							processData: false,
							contentType: false,
							beforeSend: function() {
								$("#kirimutsutama").append("<div class=\"error-box\" style='display: block; top: 50%; position: fixed; left: 46%;'></div>");
								$(".error-box").delay(1000).html('Proses Upload File');
							},
							error	: function(){
								alert('UTS anda sudah tersimpan. Tetapi lampiran file anda gagal di Upload. Klik OK untuk melengkapi lampiran');
								//$('#subjectlistuts').load('<?=base_url('akademik/kirimuts/kirimutsutamaedit')?>/'+msg);	
								$('#fileadduts').val("");
								return false;
							},
							success: function (res) {
								$(".error-box").delay(1000).fadeOut("slow",function(){
									$(this).remove();
								});	
								if(res=='null'){
									$.ajax({
										type: "POST",
										data: '&ajax=1',
										url: '<?=base_url('akademik/kirimuts/daftarutslist')?>',
										beforeSend: function() {
											$("#materi").append("<div class=\"error-box\" style='display: block; top: 50%; position: fixed; left: 46%;'></div>");
											$(".error-box").delay(1000).html('Load data');
											$(".error-box").delay(1000).fadeOut("slow",function(){
												$(this).remove();
											});
										},
										success: function(msg) {
											$('#subjectlistuts').html(msg);
											$('#subjectujian').scrollintoview({ speed:'1100'});
										}
									});
								}else{
									alert(res+'');
									//$('#subjectlistuts').load('<?=base_url('akademik/kirimuts/kirimutsutamaedit')?>/'+msg);
									$('#fileadduts').val("");
									return false;
								}
							}
						});
					}
				});
				return false;
			}
			
			return false;
		});	
		
					
		
		$("div#clearklsuts").click(function(e){
			$("select#kelas_adduts option").each(function(){
				$(this).prop("selected",false) ;
			});
			$("#iuntkdateuts").html('');
			$("#datekirimuts").css('border', '1px solid #bdbdbd');
		});
		$("select#kelas_adduts").change(function(e){
			if($(this).is(':checked')){
				$("#iuntkdateuts").html('');
			}else{
				$("#iuntkdateuts").html('<input type="text"  name="tanggal_kumpul" style="width:100px;"  value="<?//=$uts['uts'][0]['tanggal_kumpul']?>" id="datekirimuts">');
				$('#datekirimuts').datepick();
			}
			$("select#kelas_adduts option").each(function(e){
				var val=$(this).attr('id_mengajar');
				var id_kelas=$(this).attr('value');
				if(val!=undefined){
					$("select#kelas_adduts").parent('td').append('<input type="hidden" name="id_mengajar['+id_kelas+']" value="'+val+'" />');
				}
			});
		});//Submit End
	});
</script>	


<script type="text/javascript">
function getadd(obj,date) {

}
$(function() {
	$('#datekirimuts').datepick();
});
</script>	
<div class="addaccount">
<? //uts($uts);?>
<form method="post" name="kirimutsutamaedit" enctype="multipart/form-data" id="kirimutsutamaedit" action="<? echo base_url();?>akademik/kirimuts/kirimutsutamaedit">
	<div onclick="$('.addaccount').remove();" class="addaccountclose"></div>
		
		<h3>Edit UTS</h3>
		<div class="hr"></div>
		<table class="adddata">
			<tbody>
			<tr>
				<th style="text-align:right;" colspan="3">
				<a onclick="$('#kirimutsutamaedit').submit();" id="simpanuts" class="button small light-grey absenbutton" title=""> Simpan </a>
				<a  class="button small light-grey absenbutton cancelutsutama" title=""> Cancel </a>
				</th>
			</tr>
			<tr>
				<td class="title">Pelajaran</td>
				<td>:</td>
				<td>
				<select class="selectfilter" id="pelajaran_adduts" name="id_pelajaran" disabled>
						<option value="">Pilih Pelajaran</option>
						<?
						if(!empty($pelajaran)){			
						foreach($pelajaran as $datapelajaran){?>
						<option <? if(@$uts['uts'][0]['id_pelajaran']==$datapelajaran['id']){echo 'selected';}?> value="<?=$datapelajaran['id']?>"><?=$datapelajaran['nama']?> [Kelas <?=$datapelajaran['kelas']?>]</option>
						<? }} ?>
					</select>
					<input type="hidden" name="id_pelajaran" value="<?=@$uts['uts'][0]['id_pelajaran']?>" />
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
								<select class="selectfilter" style="width:100px;" id="kelas_adduts" name="id_kelas[]" multiple >
								  
								  <? foreach($kelas as $datakelas){?>
								  <option id_mengajar="<?=$datakelas['id_mengajar']?>" <? if(isset($kelaspenerima2[$datakelas['id']])){echo 'style="display:none;"';}?> value="<?=$datakelas['id']?>">
								  <?//=$datakelas['kelas']?>
								  <?=$datakelas['nama']?>
								  </option>
								  <? } ?>
								</select>
								<div id="clearklsuts" style="cursor: pointer; float: right; margin: 11%;"><u>Clear</u></div>
							</td>
						</tr>
						</tbody>
                    </table>
				</td>
			</tr>

			<tr>
				<td width="30%" class="title">Tanggal Dikumpulkan</td>
				<td width="1">:</td>
				<td id="iuntkdateuts">
					
				</td>
			</tr>
			<tr>
				<td class="title">Bab</td>
				<td>:</td>
				<td>
					<input type="text" size="30" name="bab" value="<?=$uts['uts'][0]['bab']?>">				
				</td>
			</tr>
			<tr>
				<td class="title">Judul UTS</td>
				<td>:</td>
				<td>
					<input type="text" size="30" name="judul"  value="<?=$uts['uts'][0]['judul']?>">				
				</td>
			</tr>
			<tr>
				<td width="30%" class="title">Lampiran Soal</td>
				<td width="1">:</td>
				<td>
					<ul class="file">
						<?foreach($uts['file'] as $file){?>
							<li><?=$file['file_name']?><div id="<?=$file['id']?>" class="actdell"></div></li>
						<? } ?>
						
					</ul>
					<input type="file" name="file" id="fileadduts" multiple />
					<div id="response" style="font-size:11px;">Anda bisa memilih banyak file dengan memencet tombol "Ctrl", kemudian klik file yang dipilih lebih dari satu</div>
				</td>
			</tr>
			<tr>
				<td width="30%" class="title">Keterangan</td>
				<td width="1">:</td>
				<td>
					<textarea name="keterangan"><?=$uts['uts'][0]['keterangan']?></textarea>
				</td>
			</tr>
			<tr>
				<td width="30%" class="title">Berbagi</td>
				<td width="1">:</td>
				<td>
					<input type="checkbox" name="share" value="1" <?if($uts['uts'][0]['share']==1){echo 'checked';}?> />
					<input type="hidden" name="id" value="<?=$uts['uts'][0]['id']?>"  />
				</td>
			</tr>
			<tr>
				<th style="text-align:right;" colspan="3">
				<a onclick="$('#kirimutsutamaedit').submit();" id="simpanutsbottom" class="button small light-grey absenbutton" title=""> Simpan </a>
				<a  class="button small light-grey absenbutton cancelutsutama" title=""> Cancel </a>
				</th>
			</tr>
			
		</tbody></table>

	<input type="hidden" value="1" name="ajax"> 

	<div style="display:none;" class="error-container"> Semua field harus di isi atau dipilih!  </div>
	</form>
</div>