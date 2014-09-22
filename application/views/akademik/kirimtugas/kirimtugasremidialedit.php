<script>
	$(document).ready(function(){
		$("#kirimtugasremidialedit").each(function(){
			$container = $(this).next("div.error-container");
			//Validate Starts
			$(this).validate({
				onfocusout: function(element) {	$(element).valid();	},
				errorContainer: $container,
				rules:{
				 // id_kelas:{required:true,notEqual:''},
				  //siswa:{required:true,notEqual:'Pilih Siswa'},
				  //id_pelajaran:{required:true,notEqual:''},
				  //bab:{required:true,notEqual:''},
				  id_parent:{required:true,notEqual:''},
				  //file:{required:true,notEqual:''},
				  tanggal_kumpul:{required:true,notEqual:''},
				  keterangan:{required:true,notEqual:''}
				  /*,message:{required:true,minlength:10}*/
				}
			});//Validate End

		});
	
		//Submit Starts		   
		$(".addaccountclose").click(function(){
			$(".addaccount").remove();
		});
		
		// selected area	
		$.ajax({
				type: "POST",
				data: '',
				url: '<?=base_url()?>akademik/kirimtugas/getOptionSiswaByIdKelas/'+$(this).val(),
				beforeSend: function() {
					$('select#siswa_addtugas').after("<img id='waittugas15' src='<?=$this->config->item('images').'loading.png';?>' />");
				},
				success: function(msg) {
					$('#waittugas15').remove();
					$("#siswa_addtugas").html(msg);	
				}
		});
		
		$('#pelajaran_addtugas').load('<?=base_url()?>admin/pelajaran/getMapelByKelasAndPegawai/'+$('#kelas_addtugas').val()+'/<?=$tugas['tugas'][0]['id_pelajaran']?>');
		$('#siswa_addtugas').load('<?=base_url()?>akademik/kirimtugas/getOptionSiswaRemidiByIdKelas/'+$('#kelas_addtugas').val()+'/<?=$tugas['tugas'][0]['id']?>');
		$('#judul_addtugas').load('<?=base_url()?>akademik/kirimtugas/createOptionTugasRemidiEditByKelasPelajaranIdPegawai/<?=$tugas['tugas'][0]['id_pelajaran']?>/'+$('#kelas_addtugas').val()+'/<?=$tugas['tugas'][0]['id_parent']?>');
		
		$.ajax({
				type: "POST",
				data: '',
				url: '<?=base_url()?>akademik/kirimtugas/getOptionFileTugasByIdTugas/<?=$tugas['tugas'][0]['id_parent']?>',
				beforeSend: function() {
					$('select#judul_addtugas').after("<img id='waittugas16' src='<?=$this->config->item('images').'loading.png';?>' />");
				},
				success: function(msg) {
					$('#waittugas16').remove();
					$("#filecektugas").html(msg);	
				}
		});
		
		//end selected area
		
		
		$("table.adddata tr th a.canceltugasremidi").click(function(){
				var obj=$(this);
				$.ajax({
					type: "POST",
					data: 'id_kelas='+$('select#kelastugas').val()+'&pelajaran='+$('select#pelajarantugas').val()+'&ajax=1',
					url: '<?=base_url('akademik/kirimtugas/daftartugaslist')?>',
					beforeSend: function() {
						$("table.adddata tr th a.canceltugasremidi").after("<img id='waittugas17' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
					},
					success: function(msg) {
						$("#waittugas17").remove();
						//$('select#kelastugas').val($('select#kelas_addtugas').val());
						//$('select#pelajarantugas').html($('select#pelajaran_addtugas').html());
						//$('select#pelajarantugas').val($('select#pelajaran_addtugas').val());	
						$('#subjectlisttugas').html(msg);
						$('#subjectpembelajaran').scrollintoview({ speed:'1100'});
					}
				});
				return false;
		});
		$("#kirimtugasremidialedit").submit(function(e){
			$frm = $(this);
			//$id_kelas = $frm.find('*[name=id_kelas]').val();
			//$siswa = $frm.find('*[name=siswa]').val();
			//$id_pelajaran = $frm.find('*[name=id_pelajaran]').val();
			//$bab = $frm.find('*[name=bab]').val();
			$id_parent = $frm.find('*[name=id_parent]').val();
			//$file = $frm.find('*[name=file]').val();
			$tanggal_kumpul = $frm.find('*[name=tanggal_kumpul]').val();
			$keterangan = $frm.find('*[name=keterangan]').val();
			//alert($('select#siswa_addtugas').val());
			if($('select#siswa_addtugas').val()=='' || $('select#siswa_addtugas').val()==null){$('select#siswa_addtugas').css('border','1px solid red');return false;}else{$('select#siswa_addtugas').css('border','');}
			if(/*$frm.find('*[name=id_kelas]').is('.valid') && $frm.find('*[name=siswa]').is('.valid') && $frm.find('*[name=id_pelajaran]').is('.valid')*/ /*&& $frm.find('*[name=bab]').is('.valid') && */ $frm.find('*[name=id_parent]').is('.valid') /*&& $frm.find('*[name=file]').is('.valid') && $frm.find('*[name=tanggal_kumpul]').is('.valid') */&& $frm.find('*[name=keterangan]').is('.valid')) {
				
				$.ajax({
					type: "POST",
					data: $(this).serialize()+'&judul='+$("select#judul_addtugas").attr('title'),
					url: $(this).attr('action'),
					beforeSend: function() {
						$("#kirimtugasremidialedit").append("<div class=\"error-box\" style='display: block; top: 50%; position: fixed; left: 46%;'></div>");
						$(".error-box").delay(1000).html('Inserting Data');
					},
					success: function(msg) {
						$(".error-box").delay(1000).fadeOut("slow",function(){
							$(this).remove();
						});
						var upload=ajaxuploadnew("<? echo base_url();?>akademik/kirimtugas/uploadfiletugas/"+msg,"response","image-list","filetugasremidial");
						
						
						$.ajax({
							url: "<? echo base_url();?>akademik/kirimtugas/uploadfiletugas/"+msg,
							type: "POST",
							data: upload,
							processData: false,
							contentType: false,
							beforeSend: function() {
								$("#kirimtugasremidialedit").append("<div class=\"error-box\" style='display: block; top: 50%; position: fixed; left: 46%;'></div>");
								$(".error-box").delay(1000).html('Proses Upload File');
							},
							error	: function(){
								alert('TUGAS anda sudah tersimpan. Tetapi lampiran file anda gagal di Upload. Klik OK untuk melengkapi lampiran');
								//$('#subjectlisttugas').load('<?=base_url('akademik/kirimtugas/kirimtugasutamaedit')?>/'+msg);	
								$('#filetugasremidial').val("");
								return false;
							},
							success: function (res) {
								$(".error-box").delay(1000).fadeOut("slow",function(){
									$(this).remove();
								});	
								if(res=='null'){
									$.ajax({
										type: "POST",
										data: 'id_kelas='+$('select#kelas_addtugas').val()+'&pelajaran='+$('select#pelajaran_addtugas').val()+'&ajax=1',
										url: '<?=base_url('akademik/kirimtugas/daftartugaslist')?>',
										beforeSend: function() {
											$("#kirimtugasremidial").append("<div class=\"error-box\" style='display: block; top: 50%; position: fixed; left: 46%;'></div>");
											$(".error-box").delay(1000).html('Load data');
											$(".error-box").delay(1000).fadeOut("slow",function(){
												$(this).remove();
											});
										},
										success: function(msg) {
											$(".waittugas19").remove();
											$('select#kelastugas').val($('select#kelas_addtugas').val());
											$('select#pelajarantugas').html($('select#pelajaran_addtugas').html());
											$('select#pelajarantugas').val($('select#pelajaran_addtugas').val());
											$('#subjectlisttugas').html(msg);
											$('#subjectpembelajaran').scrollintoview({ speed:'1100'});
										}
									});
								}else{
									alert(res+'');
									//$('#subjectlisttugas').load('<?=base_url('akademik/kirimtugas/kirimtugasutamaedit')?>/'+msg);
									$('#filetugasremidial').val("");
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
		$("select#judul_addtugas").change(function(e){
			var obj=$(this);
			$.ajax({
				type: "POST",
				data: '',
				url: '<?=base_url()?>akademik/kirimtugas/getOptionFileTugasByIdTugas/'+$(this).val(),
				beforeSend: function() {
					$('select#judul_addtugas').after("<img id='waittugas20' src='<?=$this->config->item('images').'loading.png';?>' />");
				},
				success: function(msg) {
					$('#waittugas20').remove();
					$(obj).attr('title',$(obj).find(":selected").attr('judul'));
					$('#babremiditugas').val($(obj).find(":selected").attr('bab'));
					$("#filecektugas").html(msg);	
				}
			});
		});
		$("select#pelajaran_addtugas").change(function(e){
			$.ajax({
				type: "POST",
				data: '',
				url: '<?=base_url()?>akademik/kirimtugas/createOptionTugasByKelasPelajaranIdPegawai/'+$(this).val()+'/'+$('select#kelas_addtugas').val(),
				beforeSend: function() {
					$('select#judul_addtugas').after("<img id='waittugas21' src='<?=$this->config->item('images').'loading.png';?>' />");
				},
				success: function(msg) {
					$('#waittugas21').remove();
					$("#judul_addtugas").html(msg);	
				}
			});
		});
		$("select#kelas_addtugas").change(function(e){
			$.ajax({
				type: "POST",
				data: '',
				url: '<?=base_url()?>akademik/kirimtugas/getOptionSiswaRemidiByIdKelas/'+$(this).val()+'/'+<?=$tugas['tugas'][0]['id']?>,
				beforeSend: function() {
					$('select#siswa_addtugas').after("<img id='waittugas22' src='<?=$this->config->item('images').'loading.png';?>' />");
				},
				success: function(msg) {
					$('#waittugas22').remove();
					$("#siswa_addtugas").html(msg);	
				}
			});
			$.ajax({
				type: "POST",
				data: '',
				url: '<?=base_url()?>admin/pelajaran/getMapelByKelasAndPegawai/'+$(this).val(),
				beforeSend: function() {
					$('select#pelajaran_addtugas').after("<img id='waittugas23' src='<?=$this->config->item('images').'loading.png';?>' />");
				},
				success: function(msg) {
					$('#waittugas23').remove();
					$("#pelajaran_addtugas").html(msg);	
				}
			});
		});//Submit End
	});
</script>	


<script type="text/javascript">
function getadd(obj,date) {

}
$(function() {
	$('#datekirimtugasremidialedit').datepick();
});
</script>	
<div class="addaccount">
<form method="post" name="kirimtugasremidialedit" enctype="multipart/form-data" id="kirimtugasremidialedit" action="<? echo base_url();?>akademik/kirimtugas/kirimtugasremidialedit/<?=@$tugas['tugas'][0]['id']?>">
	<div onclick="$('.addaccount').remove();" class="addaccountclose"></div>
		
		<h3>Edit TUGAS Remidial</h3>
		<div class="hr"></div>
		<table class="adddata">
			<tbody>
			<tr>
				<th style="text-align:right;" colspan="3">
				<a onclick="$('#kirimtugasremidialedit').submit();" id="simpantugas" class="button small light-grey absenbutton" title=""> Simpan </a>
				<a  class="button small light-grey absenbutton canceltugasremidi" title=""> Cancel </a>
				</th>
			</tr>
			<tr>
				<td class="title">Di Kirim ke Kelas</td>
				<td>:</td>
				<td>
					<select class="selectfilter" disabled id="kelas_addtugas" name="id_kelas">
						<option value="">Pilih Kelas</option>
						<? foreach($kelas as $datakelas){?>
						<option <? if(@$tugas['tugas'][0]['id_kelas']==$datakelas['id']){echo 'selected';}?> value="<?=$datakelas['id']?>"><?=$datakelas['kelas']?><?=$datakelas['nama']?></option>
						<? } ?>
					</select>
					<input type="hidden" name="id_kelas" id="kelas_addtugas" value="<?=@$tugas['tugas'][0]['id_kelas']?>" />
				</td>
			</tr>
			<tr>
				<td class="title">Untuk Siswa</td>
				<td>:</td>
				<td>
					<select class="selectfilter" id="siswa_addtugas" multiple name="siswa[]">
						<option value="">Pilih Siswa</option>
					</select>
					<div  style="font-size:11px;">jika pilihan lebih dari satu siswa, maka gunakan ctrl+klik-kanan</div>
				</td>
			</tr>
			<tr>
				<td class="title">Pelajaran</td>
				<td>:</td>
				<td>
					<select class="selectfilter" id="pelajaran_addtugas" disabled name="id_pelajaran">
						<option value="">Pilih Pelajaran</option>
						<?
						if(!empty($pelajaran)){			
						foreach($pelajaran as $datapelajaran){?>
						<option <? if(@$_POST['pelajaran']==$datapelajaran['id']){echo 'selected';}?> value="<?=$datapelajaran['id']?>"><?=$datapelajaran['nama']?></option>
						<? }} ?>
					</select>
					<input type="hidden" name="id_pelajaran" id="pelajaran_addtugas" value="<?=@$tugas['tugas'][0]['id_pelajaran']?>" />
				</td>
			</tr>
			<tr>
				<td class="title">Judul TUGAS</td>
				<td>:</td>
				<td>
					<select class="selectfilter" id="judul_addtugas" title="<?=@$tugas['tugas'][0]['judul']?>" name="id_parent">
						<option value="">Pilih TUGAS</option>
					</select>				
				</td>
			</tr>
			<tr>
				<td class="title">Bab</td>
				<td>:</td>
				<td>
					<input type="text" readonly value="<?=@$tugas['tugas'][0]['bab']?>" id="babremiditugas" size="30" name="bab" >				
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
					<input type="file" name="file" id="filetugasremidial" multiple />
					<div id="response" style="font-size:11px;">Masukkan file baru jika dibutuhkan. Anda bisa memilih banyak file dengan memencet tombol "Ctrl", kemudian klik file yang dipilih lebih dari satu <br /> Atau pakai file asli di bawah</div>
					<form id="remidialfile" method="post" action="">
					<ul class="file" id="filecektugas">
						<li></li>
					</ul>
					</form>
				</td>
			</tr>
			<tr>
				<td width="30%" class="title">Tanggal Dikumpulkan</td>
				<td width="1">:</td>
				<td>
					<input type="text" name="tanggal_kumpul" style="width:100px;" value="<?=@$tugas['tugas'][0]['tanggal_kumpul']?>" id="datekirimtugasremidialedit">
				</td>
			</tr>
			<tr>
				<td width="30%" class="title">Keterangan</td>
				<td width="1">:</td>
				<td>
					<textarea name="keterangan"><?=@$tugas['tugas'][0]['keterangan']?></textarea>
				</td>
			</tr>
			<tr>
				<td width="30%" class="title">Berbagi</td>
				<td width="1">:</td>
				<td>
					<input type="checkbox" <? if(@$tugas['tugas'][0]['share']){echo 'checked';}?> name="share" value="1" />
				</td>
			</tr>
			<tr>
				<th style="text-align:right;" colspan="3">
				<a onclick="$('#kirimtugasremidialedit').submit();" id="simpantugasbottom" class="button small light-grey absenbutton" title=""> Simpan </a>
				<a  class="button small light-grey absenbutton canceltugasremidi" title=""> Cancel </a>
				</th>
			</tr>
			
		</tbody></table>

	<input type="hidden" value="1" name="ajax"> 
	<input type="hidden" value="<?=@$tugas['tugas'][0]['id']?>" name="id"> 

	<div style="display:none;" class="error-container"> Semua field harus di isi atau dipilih!  </div>
	</form>
</div>