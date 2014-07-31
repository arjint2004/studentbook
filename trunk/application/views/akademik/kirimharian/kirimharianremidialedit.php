<script>
	$(document).ready(function(){
		$("#kirimharianremidialedit").each(function(){
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
				url: '<?=base_url()?>akademik/kirimharian/getOptionSiswaByIdKelas/'+$(this).val(),
				beforeSend: function() {
					$('select#siswa_addharian').after("<img id='waitharian15' src='<?=$this->config->item('images').'loading.png';?>' />");
				},
				success: function(msg) {
					$('#waitharian15').remove();
					$("#siswa_addharian").html(msg);	
				}
		});
		
		$('#pelajaran_addharian').load('<?=base_url()?>admin/pelajaran/getMapelByKelasAndPegawai/'+$('#kelas_addharian').val()+'/<?=$harian['harian'][0]['id_pelajaran']?>');
		$('#siswa_addharian').load('<?=base_url()?>akademik/kirimharian/getOptionSiswaRemidiByIdKelas/'+$('#kelas_addharian').val()+'/<?=$harian['harian'][0]['id']?>');
		$('#judul_addharian').load('<?=base_url()?>akademik/kirimharian/createOptionharianRemidiEditByKelasPelajaranIdPegawai/<?=$harian['harian'][0]['id_pelajaran']?>/'+$('#kelas_addharian').val()+'/<?=$harian['harian'][0]['id_parent']?>');
		
		$.ajax({
				type: "POST",
				data: '',
				url: '<?=base_url()?>akademik/kirimharian/getOptionFileharianByIdharian/<?=$harian['harian'][0]['id_parent']?>',
				beforeSend: function() {
					$('select#judul_addharian').after("<img id='waitharian16' src='<?=$this->config->item('images').'loading.png';?>' />");
				},
				success: function(msg) {
					$('#waitharian16').remove();
					$("#filecekharian").html(msg);	
				}
		});
		
		//end selected area
		
		
		$("table.adddata tr th a.cancelharianremidi").click(function(){
				var obj=$(this);
				$.ajax({
					type: "POST",
					data: 'id_kelas='+$('select#kelasharian').val()+'&pelajaran='+$('select#pelajaranharian').val()+'&ajax=1',
					url: '<?=base_url('akademik/kirimharian/daftarharianlist')?>',
					beforeSend: function() {
						$("table.adddata tr th a.cancelharianremidi").after("<img id='waitharian17' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
					},
					success: function(msg) {
						$("#waitharian17").remove();
						//$('select#kelasharian').val($('select#kelas_addharian').val());
						//$('select#pelajaranharian').html($('select#pelajaran_addharian').html());
						//$('select#pelajaranharian').val($('select#pelajaran_addharian').val());	
						$('#subjectlistharian').html(msg);
						$('#subjectpembelajaran').scrollintoview({ speed:'1100'});
					}
				});
				return false;
		});
		$("#kirimharianremidialedit").submit(function(e){
			$frm = $(this);
			//$id_kelas = $frm.find('*[name=id_kelas]').val();
			//$siswa = $frm.find('*[name=siswa]').val();
			//$id_pelajaran = $frm.find('*[name=id_pelajaran]').val();
			//$bab = $frm.find('*[name=bab]').val();
			$id_parent = $frm.find('*[name=id_parent]').val();
			//$file = $frm.find('*[name=file]').val();
			$tanggal_kumpul = $frm.find('*[name=tanggal_kumpul]').val();
			$keterangan = $frm.find('*[name=keterangan]').val();
			//alert($('select#siswa_addharian').val());
			if($('select#siswa_addharian').val()=='' || $('select#siswa_addharian').val()==null){$('select#siswa_addharian').css('border','1px solid red');return false;}else{$('select#siswa_addharian').css('border','');}
			if(/*$frm.find('*[name=id_kelas]').is('.valid') && $frm.find('*[name=siswa]').is('.valid') && $frm.find('*[name=id_pelajaran]').is('.valid')*/ /*&& $frm.find('*[name=bab]').is('.valid') && */ $frm.find('*[name=id_parent]').is('.valid') /*&& $frm.find('*[name=file]').is('.valid') && $frm.find('*[name=tanggal_kumpul]').is('.valid') */&& $frm.find('*[name=keterangan]').is('.valid')) {
				
				$.ajax({
					type: "POST",
					data: $(this).serialize()+'&judul='+$("select#judul_addharian").attr('title'),
					url: $(this).attr('action'),
					beforeSend: function() {
						$("#simpanharian").after("<img class='waitharian18' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
						$("#simpanharianbottom").after("<img class='waitharian18' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
					},
					success: function(msg) {
						$(".waitharian18").remove();	
						ajaxupload("<? echo base_url();?>akademik/kirimharian/uploadfileharian/"+msg,"response","image-list","file");
						$.ajax({
							type: "POST",
							data: 'id_kelas='+$('select#kelasharian').val()+'&pelajaran='+$('select#pelajaranharian').val()+'&ajax=1',
							url: '<?=base_url('akademik/kirimharian/daftarharianlist')?>',
							beforeSend: function() {
								$("#simpanharian").after("<img class='waitharian19' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
								$("#simpanharianbottom").after("<img class='waitharian19' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
							},
							success: function(msg) {
								$(".waitharian19").remove();
								//$('select#kelasharian').val($('select#kelas_addharian').val());
								//$('select#pelajaranharian').html($('select#pelajaran_addharian').html());
								//$('select#pelajaranharian').val($('select#pelajaran_addharian').val());
								$('#subjectlistharian').html(msg);
								$('#subjectpembelajaran').scrollintoview({ speed:'1100'});
							}
						});
					}
				});
				return false;
			}
			
			return false;
		});//Submit End	
		
		$("select#judul_addharian").change(function(e){
			var obj=$(this);
			$.ajax({
				type: "POST",
				data: '',
				url: '<?=base_url()?>akademik/kirimharian/getOptionFileharianByIdharian/'+$(this).val(),
				beforeSend: function() {
					$('select#judul_addharian').after("<img id='waitharian20' src='<?=$this->config->item('images').'loading.png';?>' />");
				},
				success: function(msg) {
					$('#waitharian20').remove();
					$(obj).attr('title',$(obj).find(":selected").attr('judul'));
					$('#babremidiharian').val($(obj).find(":selected").attr('bab'));
					$("#filecekharian").html(msg);	
				}
			});
		});
		$("select#pelajaran_addharian").change(function(e){
			$.ajax({
				type: "POST",
				data: '',
				url: '<?=base_url()?>akademik/kirimharian/createOptionharianByKelasPelajaranIdPegawai/'+$(this).val()+'/'+$('select#kelas_addharian').val(),
				beforeSend: function() {
					$('select#judul_addharian').after("<img id='waitharian21' src='<?=$this->config->item('images').'loading.png';?>' />");
				},
				success: function(msg) {
					$('#waitharian21').remove();
					$("#judul_addharian").html(msg);	
				}
			});
		});
		$("select#kelas_addharian").change(function(e){
			$.ajax({
				type: "POST",
				data: '',
				url: '<?=base_url()?>akademik/kirimharian/getOptionSiswaRemidiByIdKelas/'+$(this).val()+'/'+<?=$harian['harian'][0]['id']?>,
				beforeSend: function() {
					$('select#siswa_addharian').after("<img id='waitharian22' src='<?=$this->config->item('images').'loading.png';?>' />");
				},
				success: function(msg) {
					$('#waitharian22').remove();
					$("#siswa_addharian").html(msg);	
				}
			});
			$.ajax({
				type: "POST",
				data: '',
				url: '<?=base_url()?>admin/pelajaran/getMapelByKelasAndPegawai/'+$(this).val(),
				beforeSend: function() {
					$('select#pelajaran_addharian').after("<img id='waitharian23' src='<?=$this->config->item('images').'loading.png';?>' />");
				},
				success: function(msg) {
					$('#waitharian23').remove();
					$("#pelajaran_addharian").html(msg);	
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
	$('#datekirimharianremidialedit').datepick();
});
</script>	
<div class="addaccount">
<form method="post" name="kirimharianremidialedit" enctype="multipart/form-data" id="kirimharianremidialedit" action="<? echo base_url();?>akademik/kirimharian/kirimharianremidialedit/<?=@$harian['harian'][0]['id']?>">
	<div onclick="$('.addaccount').remove();" class="addaccountclose"></div>
		
		<h3>Edit harian Remidial</h3>
		<div class="hr"></div>
		<table class="adddata">
			<tbody>
			<tr>
				<th style="text-align:right;" colspan="3">
				<a onclick="$('#kirimharianremidialedit').submit();" id="simpanharian" class="button small light-grey absenbutton" title=""> Simpan </a>
				<a  class="button small light-grey absenbutton cancelharianremidi" title=""> Cancel </a>
				</th>
			</tr>
			<tr>
				<td class="title">Di Kirim ke Kelas</td>
				<td>:</td>
				<td>
					<select class="selectfilter" disabled id="kelas_addharian" name="id_kelas">
						<option value="">Pilih Kelas</option>
						<? foreach($kelas as $datakelas){?>
						<option <? if(@$harian['harian'][0]['id_kelas']==$datakelas['id']){echo 'selected';}?> value="<?=$datakelas['id']?>"><?=$datakelas['kelas']?><?=$datakelas['nama']?></option>
						<? } ?>
					</select>
					<input type="hidden" name="id_kelas" id="kelas_addharian" value="<?=@$harian['harian'][0]['id_kelas']?>" />
				</td>
			</tr>
			<tr>
				<td class="title">Untuk Siswa</td>
				<td>:</td>
				<td>
					<select class="selectfilter" id="siswa_addharian" multiple name="siswa[]">
						<option value="">Pilih Siswa</option>
					</select>
					<div  style="font-size:11px;">jika pilihan lebih dari satu siswa, maka gunakan ctrl+klik-kanan</div>
				</td>
			</tr>
			<tr>
				<td class="title">Pelajaran</td>
				<td>:</td>
				<td>
					<select class="selectfilter" id="pelajaran_addharian" disabled name="id_pelajaran">
						<option value="">Pilih Pelajaran</option>
						<?
						if(!empty($pelajaran)){			
						foreach($pelajaran as $datapelajaran){?>
						<option <? if(@$_POST['pelajaran']==$datapelajaran['id']){echo 'selected';}?> value="<?=$datapelajaran['id']?>"><?=$datapelajaran['nama']?></option>
						<? }} ?>
					</select>
					<input type="hidden" name="id_pelajaran" id="pelajaran_addharian" value="<?=@$harian['harian'][0]['id_pelajaran']?>" />
				</td>
			</tr>
			<tr>
				<td class="title">Judul harian</td>
				<td>:</td>
				<td>
					<select class="selectfilter" id="judul_addharian" title="<?=@$harian['harian'][0]['judul']?>" name="id_parent">
						<option value="">Pilih harian</option>
					</select>				
				</td>
			</tr>
			<tr>
				<td class="title">Bab</td>
				<td>:</td>
				<td>
					<input type="text" readonly value="<?=@$harian['harian'][0]['bab']?>" id="babremidiharian" size="30" name="bab" >				
				</td>
			</tr>
			<tr>
				<td width="30%" class="title">Lampiran Soal</td>
				<td width="1">:</td>
				<td>
					<input type="file" name="file" id="file" multiple />
					<div id="response" style="font-size:11px;">Masukkan file baru jika dibutuhkan. Anda bisa memilih banyak file dengan memencet tombol "Ctrl", kemudian klik file yang dipilih lebih dari satu <br /> Atau pakai file asli di bawah</div>
					<form id="remidialfile" method="post" action="">
					<ul class="file" id="filecekharian">
						<li></li>
					</ul>
					</form>
				</td>
			</tr>
			<tr>
				<td width="30%" class="title">Tanggal Dikumpulkan</td>
				<td width="1">:</td>
				<td>
					<input type="text" name="tanggal_kumpul" style="width:100px;" value="<?=@$harian['harian'][0]['tanggal_kumpul']?>" id="datekirimharianremidialedit">
				</td>
			</tr>
			<tr>
				<td width="30%" class="title">Keterangan</td>
				<td width="1">:</td>
				<td>
					<textarea name="keterangan"><?=@$harian['harian'][0]['keterangan']?></textarea>
				</td>
			</tr>
			<tr>
				<td width="30%" class="title">Berbagi</td>
				<td width="1">:</td>
				<td>
					<input type="checkbox" <? if(@$harian['harian'][0]['share']){echo 'checked';}?> name="share" value="1" />
				</td>
			</tr>
			<tr>
				<th style="text-align:right;" colspan="3">
				<a onclick="$('#kirimharianremidialedit').submit();" id="simpanharianbottom" class="button small light-grey absenbutton" title=""> Simpan </a>
				<a  class="button small light-grey absenbutton cancelharianremidi" title=""> Cancel </a>
				</th>
			</tr>
			
		</tbody></table>

	<input type="hidden" value="1" name="ajax"> 
	<input type="hidden" value="<?=@$harian['harian'][0]['id']?>" name="id"> 

	<div style="display:none;" class="error-container"> Semua field harus di isi atau dipilih!  </div>
	</form>
</div>