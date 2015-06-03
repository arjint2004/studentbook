<script>
	$(document).ready(function(){
		$("#kirimtugasutamaedit").each(function(){
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
	
		$("table.adddata tr th a.canceltugasutama").click(function(){
				var obj=$(this);
				$.ajax({
					type: "POST",
					data: 'id_kelas='+$('select#kelastugas').val()+'&pelajaran='+$('select#pelajarantugas').val()+'&ajax=1',
					url: '<?=base_url('akademik/kirimtugas/daftartugaslist')?>',
					beforeSend: function() {
						$('table.adddata tr th a.canceltugasutama').after("<img class='waittugas30' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
					},
					success: function(msg) {
						$(".waittugas30").remove();
						//$('select#kelastugas').val($('select#kelastugas').val());
						//$('select#pelajarantugas').html($('select#pelajaran_addtugas').html());
						//$('select#pelajarantugas').val($('select#pelajarantugas').val());	
						$('#subjectlisttugas').html(msg);
						$('#subjectpembelajaran').scrollintoview({ speed:'1100'});
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
					url: base_url+'akademik/kirimtugas/deletefile/'+$(this).attr('id'),
					beforeSend: function() {
						$(objdell).after("<img id='waittugas31' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
					},
					success: function(msg) {
						$("#waittugas31").remove();	
						$(objdell).parent().remove();
					}
				});
				return false;
			}
		});		   
		$(".addaccountclose").click(function(){
			$(".addaccount").remove();
		});
		//$('#pelajaran_addtugas').load('<?=base_url()?>admin/pelajaran/getMapelByKelasAndPegawai/'+$('#kelas_addtugas').val()+'/<?=$tugas['tugas'][0]['id_pelajaran']?>');
		filesize('fileaddtugas',15000000,50);
		$("#kirimtugasutamaedit").submit(function(e){
			
			if($('input#datekirimtugas').val()==''  && $('select#kelas_addtugas').val()!=null){
				$('input#datekirimtugas').css('border','1px solid red');
				
			}else{
				$('input#datekirimtugas').css('border','1px solid #D8D8D8');
			}
			
			if($('input#datekirimtugas').val()==''  && $('select#kelas_addtugas').val()!=null){
				$('input#datekirimtugas').css('border','1px solid red');
				//$('input#file').scrollintoview({ speed:'1100'});
				return false;
			}else{
				$('input#datekirimtugas').css('border','1px solid #D8D8D8');
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
						$("#kirimtugasutamaedit").append("<div class=\"error-box\" style='display: block; top: 50%; position: fixed; left: 46%;'></div>");
						$(".error-box").delay(1000).html('Inserting Data');
					},
					success: function(msg) {	
						$(".error-box").delay(1000).fadeOut("slow",function(){
							$(this).remove();
						});
						var upload=ajaxuploadnew("<? echo base_url();?>akademik/kirimtugas/uploadfiletugas/"+msg,"response","image-list","fileaddtugas");
						
						$.ajax({
							url: "<? echo base_url();?>akademik/kirimtugas/uploadfiletugas/"+msg,
							type: "POST",
							data: upload,
							processData: false,
							contentType: false,
							beforeSend: function() {
								$("#kirimtugasutama").append("<div class=\"error-box\" style='display: block; top: 50%; position: fixed; left: 46%;'></div>");
								$(".error-box").delay(1000).html('Proses Upload File');
							},
							error	: function(){
								alert('TUGAS anda sudah tersimpan. Tetapi lampiran file anda gagal di Upload. Klik OK untuk melengkapi lampiran');
								//$('#subjectlisttugas').load('<?=base_url('akademik/kirimtugas/kirimtugasutamaedit')?>/'+msg);	
								$('#fileaddtugas').val("");
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
										url: '<?=base_url('akademik/kirimtugas/daftartugaslist')?>',
										beforeSend: function() {
											$("#materi").append("<div class=\"error-box\" style='display: block; top: 50%; position: fixed; left: 46%;'></div>");
											$(".error-box").delay(1000).html('Load data');
											$(".error-box").delay(1000).fadeOut("slow",function(){
												$(this).remove();
											});
										},
										success: function(msg) {
											$('#subjectlisttugas').html(msg);
											$('#subjectpembelajaran').scrollintoview({ speed:'1100'});
										}
									});
								}else{
									alert(res+'');
									//$('#subjectlisttugas').load('<?=base_url('akademik/kirimtugas/kirimtugasutamaedit')?>/'+msg);
									$('#fileaddtugas').val("");
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
		
					
		
		$("div#clearklstugas").click(function(e){
			$("select#kelas_addtugas option").each(function(){
				$(this).prop("selected",false) ;
			});
			$("#iuntkdatetugas").html('');
			$("#datekirimtugas").css('border', '1px solid #bdbdbd');
		});
		$("select#kelas_addtugas").change(function(e){
			if($(this).is(':checked')){
				$("#iuntkdatetugas").html('');
			}else{
				$("#iuntkdatetugas").html('<input type="text"  name="tanggal_kumpul" style="width:100px;"  value="<?//=$tugas['tugas'][0]['tanggal_kumpul']?>" id="datekirimtugas">');
				$('#datekirimtugas').datepick();
			}
			$("select#kelas_addtugas option").each(function(e){
				var val=$(this).attr('id_mengajar');
				var id_kelas=$(this).attr('value');
				if(val!=undefined){
					$("select#kelas_addtugas").parent('td').append('<input type="hidden" name="id_mengajar['+id_kelas+']" value="'+val+'" />');
				}
			});
		});//Submit End
	});
</script>	


<script type="text/javascript">
function getadd(obj,date) {

}
$(function() {
	$('#datekirimtugas').datepick();
});
</script>	
<div class="addaccount">
<? //tugas($tugas);?>
<form method="post" name="kirimtugasutamaedit" enctype="multipart/form-data" id="kirimtugasutamaedit" action="<? echo base_url();?>akademik/kirimtugas/kirimtugasutamaedit">
	<div onclick="$('.addaccount').remove();" class="addaccountclose"></div>
		
		<h3>Edit TUGAS</h3>
		<div class="hr"></div>
		<table class="adddata">
			<tbody>
			<tr>
				<th style="text-align:right;" colspan="3">
				<a onclick="$('#kirimtugasutamaedit').submit();" id="simpantugas" class="button small light-grey absenbutton" title=""> Simpan </a>
				<a  class="button small light-grey absenbutton canceltugasutama" title=""> Cancel </a>
				</th>
			</tr>
			<tr>
				<td class="title">Pelajaran</td>
				<td>:</td>
				<td>
				<select class="selectfilter" id="pelajaran_addtugas" name="id_pelajaran" disabled>
						<option value="">Pilih Pelajaran</option>
						<?
						if(!empty($pelajaran)){			
						foreach($pelajaran as $datapelajaran){?>
						<option <? if(@$tugas['tugas'][0]['id_pelajaran']==$datapelajaran['id']){echo 'selected';}?> value="<?=$datapelajaran['id']?>"><?=$datapelajaran['nama']?> [Kelas <?=$datapelajaran['kelas']?>]</option>
						<? }} ?>
					</select>
					<input type="hidden" name="id_pelajaran" value="<?=@$tugas['tugas'][0]['id_pelajaran']?>" />
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
								<select class="selectfilter" style="width:100px;" id="kelas_addtugas" name="id_kelas[]" multiple >
								  
								  <? foreach($kelas as $datakelas){?>
								  <option id_mengajar="<?=$datakelas['id_mengajar']?>" <? if(isset($kelaspenerima2[$datakelas['id']])){echo 'style="display:none;"';}?> value="<?=$datakelas['id']?>">
								  <?=$datakelas['kelas']?>
								  <?=$datakelas['nama']?>
								  </option>
								  <? } ?>
								</select>
								<div id="clearklstugas" style="cursor: pointer; float: right; margin: 11%;"><u>Clear</u></div>
							</td>
						</tr>
						</tbody>
                    </table>
				</td>
			</tr>

			<tr>
				<td width="30%" class="title">Tanggal Dikumpulkan</td>
				<td width="1">:</td>
				<td id="iuntkdatetugas">
					
				</td>
			</tr>
			<tr>
				<td class="title">Bab</td>
				<td>:</td>
				<td>
					<input type="text" size="30" name="bab" value="<?=$tugas['tugas'][0]['bab']?>">				
				</td>
			</tr>
			<tr>
				<td class="title">Judul TUGAS</td>
				<td>:</td>
				<td>
					<input type="text" size="30" name="judul"  value="<?=$tugas['tugas'][0]['judul']?>">				
				</td>
			</tr>
			<tr>
				<td width="30%" class="title">Lampiran Soal</td>
				<td width="1">:</td>
				<td>
					<ul class="file">
						<?foreach($tugas['file'] as $file){?>
							<li><?=$file['file_name']?><div id="<?=$file['id']?>" class="actdell"></div></li>
						<? } ?>
						
					</ul>
					<input type="file" name="file" id="fileaddtugas" multiple />
					<div id="response" style="font-size:11px;">Anda bisa memilih banyak file dengan memencet tombol "Ctrl", kemudian klik file yang dipilih lebih dari satu</div>
				</td>
			</tr>
			<tr>
				<td width="30%" class="title">Keterangan</td>
				<td width="1">:</td>
				<td>
					<textarea name="keterangan"><?=$tugas['tugas'][0]['keterangan']?></textarea>
				</td>
			</tr>
			<tr>
				<td width="30%" class="title">Berbagi</td>
				<td width="1">:</td>
				<td>
					<input type="checkbox" name="share" value="1" <?if($tugas['tugas'][0]['share']==1){echo 'checked';}?> />
					<input type="hidden" name="id" value="<?=$tugas['tugas'][0]['id']?>"  />
				</td>
			</tr>
			<tr>
				<th style="text-align:right;" colspan="3">
				<a onclick="$('#kirimtugasutamaedit').submit();" id="simpantugasbottom" class="button small light-grey absenbutton" title=""> Simpan </a>
				<a  class="button small light-grey absenbutton canceltugasutama" title=""> Cancel </a>
				</th>
			</tr>
			
		</tbody></table>

	<input type="hidden" value="1" name="ajax"> 

	<div style="display:none;" class="error-container"> Semua field harus di isi atau dipilih!  </div>
	</form>
</div>