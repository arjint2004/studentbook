<script>
	$(document).ready(function(){
		$("#kirimprremidialedit").each(function(){
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
				url: '<?=base_url()?>akademik/kirimpr/getOptionSiswaByIdKelas/'+$(this).val(),
				beforeSend: function() {
					$('select#siswa_addpr').after("<img id='waitpr15' src='<?=$this->config->item('images').'loading.png';?>' />");
				},
				success: function(msg) {
					$('#waitpr15').remove();
					$("#siswa_addpr").html(msg);	
				}
		});
		
		$('#pelajaran_addpr').load('<?=base_url()?>admin/pelajaran/getMapelByKelasAndPegawai/'+$('#kelas_addpr').val()+'/<?=$pr['pr'][0]['id_pelajaran']?>');
		$('#siswa_addpr').load('<?=base_url()?>akademik/kirimpr/getOptionSiswaRemidiByIdKelas/'+$('#kelas_addpr').val()+'/<?=$pr['pr'][0]['id']?>');
		$('#judul_addpr').load('<?=base_url()?>akademik/kirimpr/createOptionPrRemidiEditByKelasPelajaranIdPegawai/<?=$pr['pr'][0]['id_pelajaran']?>/'+$('#kelas_addpr').val()+'/<?=$pr['pr'][0]['id_parent']?>');
		
		$.ajax({
				type: "POST",
				data: '',
				url: '<?=base_url()?>akademik/kirimpr/getOptionFilePrByIdPr/<?=$pr['pr'][0]['id_parent']?>',
				beforeSend: function() {
					$('select#judul_addpr').after("<img id='waitpr16' src='<?=$this->config->item('images').'loading.png';?>' />");
				},
				success: function(msg) {
					$('#waitpr16').remove();
					$("#filecekpr").html(msg);	
				}
		});
		
		//end selected area
		
		
		$("table.adddata tr th a.cancelprremidi").click(function(){
				var obj=$(this);
				$.ajax({
					type: "POST",
					data: 'id_kelas='+$('select#kelaspr').val()+'&pelajaran='+$('select#pelajaranpr').val()+'&ajax=1',
					url: '<?=base_url('akademik/kirimpr/daftarprlist')?>',
					beforeSend: function() {
						$("table.adddata tr th a.cancelprremidi").after("<img id='waitpr17' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
					},
					success: function(msg) {
						$("#waitpr17").remove();
						//$('select#kelaspr').val($('select#kelas_addpr').val());
						//$('select#pelajaranpr').html($('select#pelajaran_addpr').html());
						//$('select#pelajaranpr').val($('select#pelajaran_addpr').val());	
						$('#subjectlistpr').html(msg);
						$('#subjectpembelajaran').scrollintoview({ speed:'1100'});
					}
				});
				return false;
		});
		$("#kirimprremidialedit").submit(function(e){
			$frm = $(this);
			//$id_kelas = $frm.find('*[name=id_kelas]').val();
			//$siswa = $frm.find('*[name=siswa]').val();
			//$id_pelajaran = $frm.find('*[name=id_pelajaran]').val();
			//$bab = $frm.find('*[name=bab]').val();
			$id_parent = $frm.find('*[name=id_parent]').val();
			//$file = $frm.find('*[name=file]').val();
			$tanggal_kumpul = $frm.find('*[name=tanggal_kumpul]').val();
			$keterangan = $frm.find('*[name=keterangan]').val();
			//alert($('select#siswa_addpr').val());
			if($('select#siswa_addpr').val()=='' || $('select#siswa_addpr').val()==null){$('select#siswa_addpr').css('border','1px solid red');return false;}else{$('select#siswa_addpr').css('border','');}
			if(/*$frm.find('*[name=id_kelas]').is('.valid') && $frm.find('*[name=siswa]').is('.valid') && $frm.find('*[name=id_pelajaran]').is('.valid')*/ /*&& $frm.find('*[name=bab]').is('.valid') && */ $frm.find('*[name=id_parent]').is('.valid') /*&& $frm.find('*[name=file]').is('.valid') && $frm.find('*[name=tanggal_kumpul]').is('.valid') */&& $frm.find('*[name=keterangan]').is('.valid')) {
				
				$.ajax({
					type: "POST",
					data: $(this).serialize()+'&judul='+$("select#judul_addpr").attr('title'),
					url: $(this).attr('action'),
					beforeSend: function() {
						$("#simpanpr").after("<img class='waitpr18' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
						$("#simpanprbottom").after("<img class='waitpr18' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
					},
					success: function(msg) {
						$(".waitpr18").remove();	
						ajaxupload("<? echo base_url();?>akademik/kirimpr/uploadfilepr/"+msg,"response","image-list","file");
						$.ajax({
							type: "POST",
							data: 'id_kelas='+$('select#kelaspr').val()+'&pelajaran='+$('select#pelajaranpr').val()+'&ajax=1',
							url: '<?=base_url('akademik/kirimpr/daftarprlist')?>',
							beforeSend: function() {
								$("#simpanpr").after("<img class='waitpr19' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
								$("#simpanprbottom").after("<img class='waitpr19' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
							},
							success: function(msg) {
								$(".waitpr19").remove();
								//$('select#kelaspr').val($('select#kelas_addpr').val());
								//$('select#pelajaranpr').html($('select#pelajaran_addpr').html());
								//$('select#pelajaranpr').val($('select#pelajaran_addpr').val());
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
		
		$("select#judul_addpr").change(function(e){
			var obj=$(this);
			$.ajax({
				type: "POST",
				data: '',
				url: '<?=base_url()?>akademik/kirimpr/getOptionFilePrByIdPr/'+$(this).val(),
				beforeSend: function() {
					$('select#judul_addpr').after("<img id='waitpr20' src='<?=$this->config->item('images').'loading.png';?>' />");
				},
				success: function(msg) {
					$('#waitpr20').remove();
					$(obj).attr('title',$(obj).find(":selected").attr('judul'));
					$('#babremidipr').val($(obj).find(":selected").attr('bab'));
					$("#filecekpr").html(msg);	
				}
			});
		});
		$("select#pelajaran_addpr").change(function(e){
			$.ajax({
				type: "POST",
				data: '',
				url: '<?=base_url()?>akademik/kirimpr/createOptionPrByKelasPelajaranIdPegawai/'+$(this).val()+'/'+$('select#kelas_addpr').val(),
				beforeSend: function() {
					$('select#judul_addpr').after("<img id='waitpr21' src='<?=$this->config->item('images').'loading.png';?>' />");
				},
				success: function(msg) {
					$('#waitpr21').remove();
					$("#judul_addpr").html(msg);	
				}
			});
		});
		$("select#kelas_addpr").change(function(e){
			$.ajax({
				type: "POST",
				data: '',
				url: '<?=base_url()?>akademik/kirimpr/getOptionSiswaRemidiByIdKelas/'+$(this).val()+'/'+<?=$pr['pr'][0]['id']?>,
				beforeSend: function() {
					$('select#siswa_addpr').after("<img id='waitpr22' src='<?=$this->config->item('images').'loading.png';?>' />");
				},
				success: function(msg) {
					$('#waitpr22').remove();
					$("#siswa_addpr").html(msg);	
				}
			});
			$.ajax({
				type: "POST",
				data: '',
				url: '<?=base_url()?>admin/pelajaran/getMapelByKelasAndPegawai/'+$(this).val(),
				beforeSend: function() {
					$('select#pelajaran_addpr').after("<img id='waitpr23' src='<?=$this->config->item('images').'loading.png';?>' />");
				},
				success: function(msg) {
					$('#waitpr23').remove();
					$("#pelajaran_addpr").html(msg);	
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
	$('#datekirimprremidialedit').datepick();
});
</script>	
<div class="addaccount">
<form method="post" name="kirimprremidialedit" enctype="multipart/form-data" id="kirimprremidialedit" action="<? echo base_url();?>akademik/kirimpr/kirimprremidialedit/<?=@$pr['pr'][0]['id']?>">
	<div onclick="$('.addaccount').remove();" class="addaccountclose"></div>
		
		<h3>Edit PR Remidial</h3>
		<div class="hr"></div>
		<table class="adddata">
			<tbody>
			<tr>
				<th style="text-align:right;" colspan="3">
				<a onclick="$('#kirimprremidialedit').submit();" id="simpanpr" class="button small light-grey absenbutton" title=""> Simpan </a>
				<a  class="button small light-grey absenbutton cancelprremidi" title=""> Cancel </a>
				</th>
			</tr>
			<tr>
				<td class="title">Di Kirim ke Kelas</td>
				<td>:</td>
				<td>
					<select class="selectfilter" disabled id="kelas_addpr" name="id_kelas">
						<option value="">Pilih Kelas</option>
						<? foreach($kelas as $datakelas){?>
						<option <? if(@$pr['pr'][0]['id_kelas']==$datakelas['id']){echo 'selected';}?> value="<?=$datakelas['id']?>"><?=$datakelas['kelas']?><?=$datakelas['nama']?></option>
						<? } ?>
					</select>
					<input type="hidden" name="id_kelas" id="kelas_addpr" value="<?=@$pr['pr'][0]['id_kelas']?>" />
				</td>
			</tr>
			<tr>
				<td class="title">Untuk Siswa</td>
				<td>:</td>
				<td>
					<select class="selectfilter" id="siswa_addpr" multiple name="siswa[]">
						<option value="">Pilih Siswa</option>
					</select>
					<div  style="font-size:11px;">jika pilihan lebih dari satu siswa, maka gunakan ctrl+klik-kanan</div>
				</td>
			</tr>
			<tr>
				<td class="title">Pelajaran</td>
				<td>:</td>
				<td>
					<select class="selectfilter" id="pelajaran_addpr" disabled name="id_pelajaran">
						<option value="">Pilih Pelajaran</option>
						<?
						if(!empty($pelajaran)){			
						foreach($pelajaran as $datapelajaran){?>
						<option <? if(@$_POST['pelajaran']==$datapelajaran['id']){echo 'selected';}?> value="<?=$datapelajaran['id']?>"><?=$datapelajaran['nama']?></option>
						<? }} ?>
					</select>
					<input type="hidden" name="id_pelajaran" id="pelajaran_addpr" value="<?=@$pr['pr'][0]['id_pelajaran']?>" />
				</td>
			</tr>
			<tr>
				<td class="title">Judul PR</td>
				<td>:</td>
				<td>
					<select class="selectfilter" id="judul_addpr" title="<?=@$pr['pr'][0]['judul']?>" name="id_parent">
						<option value="">Pilih PR</option>
					</select>				
				</td>
			</tr>
			<tr>
				<td class="title">Bab</td>
				<td>:</td>
				<td>
					<input type="text" readonly value="<?=@$pr['pr'][0]['bab']?>" id="babremidipr" size="30" name="bab" >				
				</td>
			</tr>
			<tr>
				<td width="30%" class="title">Lampiran Soal</td>
				<td width="1">:</td>
				<td>
					<input type="file" name="file" id="file" multiple />
					<div id="response" style="font-size:11px;">Masukkan file baru jika dibutuhkan. Anda bisa memilih banyak file dengan memencet tombol "Ctrl", kemudian klik file yang dipilih lebih dari satu <br /> Atau pakai file asli di bawah</div>
					<form id="remidialfile" method="post" action="">
					<ul class="file" id="filecekpr">
						<li></li>
					</ul>
					</form>
				</td>
			</tr>
			<tr>
				<td width="30%" class="title">Tanggal Dikumpulkan</td>
				<td width="1">:</td>
				<td>
					<input type="text" name="tanggal_kumpul" style="width:100px;" value="<?=@$pr['pr'][0]['tanggal_kumpul']?>" id="datekirimprremidialedit">
				</td>
			</tr>
			<tr>
				<td width="30%" class="title">Keterangan</td>
				<td width="1">:</td>
				<td>
					<textarea name="keterangan"><?=@$pr['pr'][0]['keterangan']?></textarea>
				</td>
			</tr>
			<tr>
				<td width="30%" class="title">Berbagi</td>
				<td width="1">:</td>
				<td>
					<input type="checkbox" <? if(@$pr['pr'][0]['share']){echo 'checked';}?> name="share" value="1" />
				</td>
			</tr>
			<tr>
				<th style="text-align:right;" colspan="3">
				<a onclick="$('#kirimprremidialedit').submit();" id="simpanprbottom" class="button small light-grey absenbutton" title=""> Simpan </a>
				<a  class="button small light-grey absenbutton cancelprremidi" title=""> Cancel </a>
				</th>
			</tr>
			
		</tbody></table>

	<input type="hidden" value="1" name="ajax"> 
	<input type="hidden" value="<?=@$pr['pr'][0]['id']?>" name="id"> 

	<div style="display:none;" class="error-container"> Semua field harus di isi atau dipilih!  </div>
	</form>
</div>