<script>
	$(document).ready(function(){
		$("#kirimutsremidialedit").each(function(){
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
				url: '<?=base_url()?>akademik/kirimuts/getOptionSiswaByIdKelas/'+$(this).val(),
				beforeSend: function() {
					$('select#siswa_adduts').after("<img id='waituts15' src='<?=$this->config->item('images').'loading.png';?>' />");
				},
				success: function(msg) {
					$('#waituts15').remove();
					$("#siswa_adduts").html(msg);	
				}
		});
		
		$('#pelajaran_adduts').load('<?=base_url()?>admin/pelajaran/getMapelByKelasAndPegawai/'+$('#kelas_adduts').val()+'/<?=$uts['uts'][0]['id_pelajaran']?>');
		$('#siswa_adduts').load('<?=base_url()?>akademik/kirimuts/getOptionSiswaRemidiByIdKelas/'+$('#kelas_adduts').val()+'/<?=$uts['uts'][0]['id']?>');
		$('#judul_adduts').load('<?=base_url()?>akademik/kirimuts/createOptionutsRemidiEditByKelasPelajaranIdPegawai/<?=$uts['uts'][0]['id_pelajaran']?>/'+$('#kelas_adduts').val()+'/<?=$uts['uts'][0]['id_parent']?>');
		
		$.ajax({
				type: "POST",
				data: '',
				url: '<?=base_url()?>akademik/kirimuts/getOptionFileutsByIduts/<?=$uts['uts'][0]['id_parent']?>',
				beforeSend: function() {
					$('select#judul_adduts').after("<img id='waituts16' src='<?=$this->config->item('images').'loading.png';?>' />");
				},
				success: function(msg) {
					$('#waituts16').remove();
					$("#filecekuts").html(msg);	
				}
		});
		
		//end selected area
		
		
		$("table.adddata tr th a.cancelutsremidi").click(function(){
				var obj=$(this);
				$.ajax({
					type: "POST",
					data: 'id_kelas='+$('select#kelasuts').val()+'&pelajaran='+$('select#pelajaranuts').val()+'&ajax=1',
					url: '<?=base_url('akademik/kirimuts/daftarutslist')?>',
					beforeSend: function() {
						$("table.adddata tr th a.cancelutsremidi").after("<img id='waituts17' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
					},
					success: function(msg) {
						$("#waituts17").remove();
						//$('select#kelasuts').val($('select#kelas_adduts').val());
						//$('select#pelajaranuts').html($('select#pelajaran_adduts').html());
						//$('select#pelajaranuts').val($('select#pelajaran_adduts').val());	
						$('#subjectlistuts').html(msg);
						$('#subjectpembelajaran').scrollintoview({ speed:'1100'});
					}
				});
				return false;
		});
		$("#kirimutsremidialedit").submit(function(e){
			$frm = $(this);
			//$id_kelas = $frm.find('*[name=id_kelas]').val();
			//$siswa = $frm.find('*[name=siswa]').val();
			//$id_pelajaran = $frm.find('*[name=id_pelajaran]').val();
			//$bab = $frm.find('*[name=bab]').val();
			$id_parent = $frm.find('*[name=id_parent]').val();
			//$file = $frm.find('*[name=file]').val();
			$tanggal_kumpul = $frm.find('*[name=tanggal_kumpul]').val();
			$keterangan = $frm.find('*[name=keterangan]').val();
			//alert($('select#siswa_adduts').val());
			if($('select#siswa_adduts').val()=='' || $('select#siswa_adduts').val()==null){$('select#siswa_adduts').css('border','1px solid red');return false;}else{$('select#siswa_adduts').css('border','');}
			if(/*$frm.find('*[name=id_kelas]').is('.valid') && $frm.find('*[name=siswa]').is('.valid') && $frm.find('*[name=id_pelajaran]').is('.valid')*/ /*&& $frm.find('*[name=bab]').is('.valid') && */ $frm.find('*[name=id_parent]').is('.valid') /*&& $frm.find('*[name=file]').is('.valid') && $frm.find('*[name=tanggal_kumpul]').is('.valid') */&& $frm.find('*[name=keterangan]').is('.valid')) {
				
				$.ajax({
					type: "POST",
					data: $(this).serialize()+'&judul='+$("select#judul_adduts").attr('title'),
					url: $(this).attr('action'),
					beforeSend: function() {
						$("#simpanuts").after("<img class='waituts18' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
						$("#simpanutsbottom").after("<img class='waituts18' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
					},
					success: function(msg) {
						$(".waituts18").remove();	
						ajaxupload("<? echo base_url();?>akademik/kirimuts/uploadfileuts/"+msg,"response","image-list","file");
						$.ajax({
							type: "POST",
							data: 'id_kelas='+$('select#kelasuts').val()+'&pelajaran='+$('select#pelajaranuts').val()+'&ajax=1',
							url: '<?=base_url('akademik/kirimuts/daftarutslist')?>',
							beforeSend: function() {
								$("#simpanuts").after("<img class='waituts19' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
								$("#simpanutsbottom").after("<img class='waituts19' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
							},
							success: function(msg) {
								$(".waituts19").remove();
								//$('select#kelasuts').val($('select#kelas_adduts').val());
								//$('select#pelajaranuts').html($('select#pelajaran_adduts').html());
								//$('select#pelajaranuts').val($('select#pelajaran_adduts').val());
								$('#subjectlistuts').html(msg);
								$('#subjectpembelajaran').scrollintoview({ speed:'1100'});
							}
						});
					}
				});
				return false;
			}
			
			return false;
		});//Submit End	
		
		$("select#judul_adduts").change(function(e){
			var obj=$(this);
			$.ajax({
				type: "POST",
				data: '',
				url: '<?=base_url()?>akademik/kirimuts/getOptionFileutsByIduts/'+$(this).val(),
				beforeSend: function() {
					$('select#judul_adduts').after("<img id='waituts20' src='<?=$this->config->item('images').'loading.png';?>' />");
				},
				success: function(msg) {
					$('#waituts20').remove();
					$(obj).attr('title',$(obj).find(":selected").attr('judul'));
					$('#babremidiuts').val($(obj).find(":selected").attr('bab'));
					$("#filecekuts").html(msg);	
				}
			});
		});
		$("select#pelajaran_adduts").change(function(e){
			$.ajax({
				type: "POST",
				data: '',
				url: '<?=base_url()?>akademik/kirimuts/createOptionutsByKelasPelajaranIdPegawai/'+$(this).val()+'/'+$('select#kelas_adduts').val(),
				beforeSend: function() {
					$('select#judul_adduts').after("<img id='waituts21' src='<?=$this->config->item('images').'loading.png';?>' />");
				},
				success: function(msg) {
					$('#waituts21').remove();
					$("#judul_adduts").html(msg);	
				}
			});
		});
		$("select#kelas_adduts").change(function(e){
			$.ajax({
				type: "POST",
				data: '',
				url: '<?=base_url()?>akademik/kirimuts/getOptionSiswaRemidiByIdKelas/'+$(this).val()+'/'+<?=$uts['uts'][0]['id']?>,
				beforeSend: function() {
					$('select#siswa_adduts').after("<img id='waituts22' src='<?=$this->config->item('images').'loading.png';?>' />");
				},
				success: function(msg) {
					$('#waituts22').remove();
					$("#siswa_adduts").html(msg);	
				}
			});
			$.ajax({
				type: "POST",
				data: '',
				url: '<?=base_url()?>admin/pelajaran/getMapelByKelasAndPegawai/'+$(this).val(),
				beforeSend: function() {
					$('select#pelajaran_adduts').after("<img id='waituts23' src='<?=$this->config->item('images').'loading.png';?>' />");
				},
				success: function(msg) {
					$('#waituts23').remove();
					$("#pelajaran_adduts").html(msg);	
				}
			});
		});//Submit End
	});
</script>	
<link type="text/css" href="<?=$this->config->item('css');?>datepick.css" rel="stylesheet">
<script type="text/javascript" src="<?=$this->config->item('js');?>jquery.datepick.js"></script>
<script type="text/javascript" src="<?=$this->config->item('js');?>jquery.datepick-id.js"></script>
<script type="text/javascript" src="<?=$this->config->item('js');?>upload.js"></script>

<script type="text/javascript">
function getadd(obj,date) {

}
$(function() {
	$('#datekirimutsremidialedit').datepick();
});
</script>	
<div class="addaccount">
<form method="post" name="kirimutsremidialedit" enctype="multipart/form-data" id="kirimutsremidialedit" action="<? echo base_url();?>akademik/kirimuts/kirimutsremidialedit/<?=@$uts['uts'][0]['id']?>">
	<div onclick="$('.addaccount').remove();" class="addaccountclose"></div>
		
		<h3>Edit uts Remidial</h3>
		<div class="hr"></div>
		<table class="adddata">
			<tbody>
			<tr>
				<th style="text-align:right;" colspan="3">
				<a onclick="$('#kirimutsremidialedit').submit();" id="simpanuts" class="button small light-grey absenbutton" title=""> Simpan </a>
				<a  class="button small light-grey absenbutton cancelutsremidi" title=""> Cancel </a>
				</th>
			</tr>
			<tr>
				<td class="title">Di Kirim ke Kelas</td>
				<td>:</td>
				<td>
					<select class="selectfilter" disabled id="kelas_adduts" name="id_kelas">
						<option value="">Pilih Kelas</option>
						<? foreach($kelas as $datakelas){?>
						<option <? if(@$uts['uts'][0]['id_kelas']==$datakelas['id']){echo 'selected';}?> value="<?=$datakelas['id']?>"><?=$datakelas['kelas']?><?=$datakelas['nama']?></option>
						<? } ?>
					</select>
					<input type="hidden" name="id_kelas" id="kelas_adduts" value="<?=@$uts['uts'][0]['id_kelas']?>" />
				</td>
			</tr>
			<tr>
				<td class="title">Untuk Siswa</td>
				<td>:</td>
				<td>
					<select class="selectfilter" id="siswa_adduts" multiple name="siswa[]">
						<option value="">Pilih Siswa</option>
					</select>
					<div  style="font-size:11px;">jika pilihan lebih dari satu siswa, maka gunakan ctrl+klik-kanan</div>
				</td>
			</tr>
			<tr>
				<td class="title">Pelajaran</td>
				<td>:</td>
				<td>
					<select class="selectfilter" id="pelajaran_adduts" disabled name="id_pelajaran">
						<option value="">Pilih Pelajaran</option>
						<?
						if(!empty($pelajaran)){			
						foreach($pelajaran as $datapelajaran){?>
						<option <? if(@$_POST['pelajaran']==$datapelajaran['id']){echo 'selected';}?> value="<?=$datapelajaran['id']?>"><?=$datapelajaran['nama']?></option>
						<? }} ?>
					</select>
					<input type="hidden" name="id_pelajaran" id="pelajaran_adduts" value="<?=@$uts['uts'][0]['id_pelajaran']?>" />
				</td>
			</tr>
			<tr>
				<td class="title">Judul uts</td>
				<td>:</td>
				<td>
					<select class="selectfilter" id="judul_adduts" title="<?=@$uts['uts'][0]['judul']?>" name="id_parent">
						<option value="">Pilih uts</option>
					</select>				
				</td>
			</tr>
			<tr>
				<td class="title">Bab</td>
				<td>:</td>
				<td>
					<input type="text" readonly value="<?=@$uts['uts'][0]['bab']?>" id="babremidiuts" size="30" name="bab" >				
				</td>
			</tr>
			<tr>
				<td width="30%" class="title">Lampiran Soal</td>
				<td width="1">:</td>
				<td>
					<input type="file" name="file" id="file" multiple />
					<div id="response" style="font-size:11px;">Masukkan file baru jika dibutuhkan. Anda bisa memilih banyak file dengan memencet tombol "Ctrl", kemudian klik file yang dipilih lebih dari satu <br /> Atau pakai file asli di bawah</div>
					<form id="remidialfile" method="post" action="">
					<ul class="file" id="filecekuts">
						<li></li>
					</ul>
					</form>
				</td>
			</tr>
			<tr>
				<td width="30%" class="title">Tanggal Dikumpulkan</td>
				<td width="1">:</td>
				<td>
					<input type="text" name="tanggal_kumpul" style="width:100px;" value="<?=@$uts['uts'][0]['tanggal_kumpul']?>" id="datekirimutsremidialedit">
				</td>
			</tr>
			<tr>
				<td width="30%" class="title">Keterangan</td>
				<td width="1">:</td>
				<td>
					<textarea name="keterangan"><?=@$uts['uts'][0]['keterangan']?></textarea>
				</td>
			</tr>
			<tr>
				<td width="30%" class="title">Berbagi</td>
				<td width="1">:</td>
				<td>
					<input type="checkbox" <? if(@$uts['uts'][0]['share']){echo 'checked';}?> name="share" value="1" />
				</td>
			</tr>
			<tr>
				<th style="text-align:right;" colspan="3">
				<a onclick="$('#kirimutsremidialedit').submit();" id="simpanutsbottom" class="button small light-grey absenbutton" title=""> Simpan </a>
				<a  class="button small light-grey absenbutton cancelutsremidi" title=""> Cancel </a>
				</th>
			</tr>
			
		</tbody></table>

	<input type="hidden" value="1" name="ajax"> 
	<input type="hidden" value="<?=@$uts['uts'][0]['id']?>" name="id"> 

	<div style="display:none;" class="error-container"> Semua field harus di isi atau dipilih!  </div>
	</form>
</div>