<script>
	$(document).ready(function(){
		$("#kirimuasremidial").each(function(){
			$container = $(this).next("div.error-container");
			//Validate Starts
			$(this).validate({
				onfocusout: function(element) {	$(element).valid();	},
				errorContainer: $container,
				rules:{
				  id_kelas:{required:true,notEqual:'Pilih Kelas'},
				  //siswa:{required:true,notEqual:'Pilih Siswa'},
				  id_pelajaran:{required:true,notEqual:'Pilih Pelajaran'},
				  //bab:{required:true,notEqual:''},
				  id_parent:{required:true,notEqual:''},
				  //file:{required:true,notEqual:''},
				  tanggal_kumpul:{required:true,notEqual:''},
				  keterangan:{required:true,notEqual:''}
				  /*,message:{required:true,minlength:10}*/
				}
			});//Validate End

		});
		
		$("table.adddata tr th a#canceluasremidi").click(function(){
				var obj=$(this);
				$.ajax({
					type: "POST",
					data: 'id_kelas='+$('select#kelasuas').val()+'&pelajaran='+$('select#pelajaranuas').val()+'&ajax=1',
					url: '<?=base_url('akademik/kirimuas/daftaruaslist')?>',
					beforeSend: function() {
						$("table.adddata tr th a#canceluasremidi").after("<img id='waituas9' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
					},
					success: function(msg) {
						$("#waituas9").remove();
						//$('select#kelasuas').val('');
						//$('select#pelajaranuas').html($('select#pelajaran_adduas').html());
						//$('select#pelajaranuas').val('');	
						$('#subjectlistuas').html(msg);
						$('#subjectpembelajaran').scrollintoview({ speed:'1100'});
					}
				});
				return false;
		});
		//Submit Starts		   
		$(".addaccountclose").click(function(){
			$(".addaccount").remove();
		});
		$("#kirimuasremidial").submit(function(e){
			$frm = $(this);
			$id_kelas = $frm.find('*[name=id_kelas]').val();
			//$siswa = $frm.find('*[name=siswa]').val();
			$id_pelajaran = $frm.find('*[name=id_pelajaran]').val();
			//$bab = $frm.find('*[name=bab]').val();
			$id_parent = $frm.find('*[name=id_parent]').val();
			//$file = $frm.find('*[name=file]').val();
			$tanggal_kumpul = $frm.find('*[name=tanggal_kumpul]').val();
			$keterangan = $frm.find('*[name=keterangan]').val();
			//alert($('select#siswa_adduas').val());
			if($('select#siswa_adduas').val()=='' || $('select#siswa_adduas').val()==null){$('select#siswa_adduas').css('border','1px solid red');return false;}else{$('select#siswa_adduas').css('border','');}
			if($frm.find('*[name=id_kelas]').is('.valid') /*&& $frm.find('*[name=siswa]').is('.valid')*/ && $frm.find('*[name=id_pelajaran]').is('.valid') /*&& $frm.find('*[name=bab]').is('.valid') */ && $frm.find('*[name=id_parent]').is('.valid') /*&& $frm.find('*[name=file]').is('.valid') && $frm.find('*[name=tanggal_kumpul]').is('.valid') */&& $frm.find('*[name=keterangan]').is('.valid')) {
				
				$.ajax({
					type: "POST",
					data: $(this).serialize()+'&judul='+$("select#judul_adduas").attr('title'),
					url: $(this).attr('action'),
					beforeSend: function() {
						$("#simpanuas").after("<img class='waituas10' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
						$("#simpanuasbottom").after("<img class='waituas10' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
					},
					success: function(msg) {
						$(".waituas10").remove();	
						ajaxupload("<? echo base_url();?>akademik/kirimuas/uploadfileuas/"+msg,"response","image-list","file");
						$.ajax({
							type: "POST",
							data: 'id_kelas='+$('select#kelasuas').val()+'&pelajaran='+$('select#pelajaranuas').val()+'&ajax=1',
							url: '<?=base_url('akademik/kirimuas/daftaruaslist')?>',
							beforeSend: function() {
								$("#simpanuas").after("<img class='waituas10' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
								$("#simpanuasbottom").after("<img class='waituas10' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
							},
							success: function(msg) {
								$(".waituas10").remove();
								//$('select#kelas').val($('select#kelas_adduas').val());
								//$('select#pelajaran').html($('select#pelajaran_adduas').html());
								//$('select#pelajaran').val($('select#pelajaran_adduas').val());
								$('#subjectlistuas').html(msg);
								$('#subjectpembelajaran').scrollintoview({ speed:'1100'});
							}
						});
					}
				});
				return false;
			}
			
			return false;
		});//Submit End	
		
		$("select#judul_adduas").change(function(e){
			var obj=$(this);
			$.ajax({
				type: "POST",
				data: '',
				url: '<?=base_url()?>akademik/kirimuas/getOptionFileuasByIduas/'+$(this).val(),
				beforeSend: function() {
					$('select#judul_adduas').after("<img id='waituas11' src='<?=$this->config->item('images').'loading.png';?>' />");
				},
				success: function(msg) {
					$('#waituas11').remove();
					$(obj).attr('title',$(obj).find(":selected").attr('judul'));
					$('.babremidi').val($(obj).find(":selected").attr('bab'));
					$("#filecekuas").html(msg);	
				}
			});
		});
		$("select#pelajaran_adduas").change(function(e){
			$.ajax({
				type: "POST",
				data: '',
				url: '<?=base_url()?>akademik/kirimuas/createOptionuasByKelasPelajaranIdPegawai/'+$(this).val()+'/'+$('select#kelas_adduas').val(),
				beforeSend: function() {
					$('select#judul_adduas').after("<img id='waituas12' src='<?=$this->config->item('images').'loading.png';?>' />");
				},
				success: function(msg) {
					$('#waituas12').remove();
					$("#judul_adduas").html(msg);	
				}
			});
		});
		$("select#kelas_adduas").change(function(e){
			$.ajax({
				type: "POST",
				data: '',
				url: '<?=base_url()?>akademik/kirimuas/getOptionSiswaByIdKelas/'+$(this).val(),
				beforeSend: function() {
					$('select#siswa_adduas').after("<img id='waituas13' src='<?=$this->config->item('images').'loading.png';?>' />");
				},
				success: function(msg) {
					$('#waituas13').remove();
					$("#siswa_adduas").html(msg);	
				}
			});
			$.ajax({
				type: "POST",
				data: '',
				url: '<?=base_url()?>admin/pelajaran/getMapelByKelasAndPegawai/'+$(this).val(),
				beforeSend: function() {
					$('select#pelajaran_adduas').after("<img id='waituas14' src='<?=$this->config->item('images').'loading.png';?>' />");
				},
				success: function(msg) {
					$('#waituas14').remove();
					$("#pelajaran_adduas").html(msg);	
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
	$('#datekirimuasremidial').datepick();
});
</script>	
<div class="addaccount">
<form method="post" name="kirimuasremidial" enctype="multipart/form-data" id="kirimuasremidial" action="<? echo base_url();?>akademik/kirimuas/kirimuasremidial">
	<div onclick="$('.addaccount').remove();" class="addaccountclose"></div>
		
		<h3>Tambah uas Remidial</h3>
		<div class="hr"></div>
		<table class="adddata">
			<tbody>
			<tr>
				<th style="text-align:right;" colspan="3">
				<a onclick="$('#kirimuasremidial').submit();" id="simpanuas" class="button small light-grey absenbutton" title=""> Simpan </a>
				<a id="canceluasremidi" class="button small light-grey absenbutton" title=""> Cancel </a>
				</th>
			</tr>
			<tr>
				<td class="title">Di Kirim ke Kelas</td>
				<td>:</td>
				<td>
					<select class="selectfilter" id="kelas_adduas" name="id_kelas">
						<option value="">Pilih Kelas</option>
						<? foreach($kelas as $datakelas){?>
						<option <? if(@$_POST['kelas']==$datakelas['id']){echo 'selected';}?> value="<?=$datakelas['id']?>"><?=$datakelas['kelas']?><?=$datakelas['nama']?></option>
						<? } ?>
					</select>
				</td>
			</tr>
			<tr>
				<td class="title">Untuk Siswa</td>
				<td>:</td>
				<td>
					<select class="selectfilter" id="siswa_adduas" multiple name="siswa[]">
						<option value="">Pilih Siswa</option>
					</select>
					<div  style="font-size:11px;">jika pilihan lebih dari satu siswa, maka gunakan ctrl+klik</div>
				</td>
			</tr>
			<tr>
				<td class="title">Pelajaran</td>
				<td>:</td>
				<td>
					<select class="selectfilter" id="pelajaran_adduas" name="id_pelajaran">
						<option value="">Pilih Pelajaran</option>
						<?
						if(!empty($pelajaran)){			
						foreach($pelajaran as $datapelajaran){?>
						<option <? if(@$_POST['pelajaran']==$datapelajaran['id']){echo 'selected';}?> value="<?=$datapelajaran['id']?>"><?=$datapelajaran['nama']?></option>
						<? }} ?>
					</select>
				</td>
			</tr>
			<tr>
				<td class="title">Judul uas</td>
				<td>:</td>
				<td>
					<select class="selectfilter" id="judul_adduas" name="id_parent">
						<option value="">Pilih uas</option>
					</select>				
				</td>
			</tr>
			<tr>
				<td class="title">Bab</td>
				<td>:</td>
				<td>
					<input type="text" value="" class="babremidi" size="30" name="bab" readonly>				
				</td>
			</tr>
			<tr>
				<td width="30%" class="title">Lampiran Soal</td>
				<td width="1">:</td>
				<td>
					<input type="file" name="file" id="file" multiple />
					<div id="response" style="font-size:11px;">Masukkan file baru jika dibutuhkan. Anda bisa memilih banyak file dengan memencet tombol "Ctrl", kemudian klik file yang dipilih lebih dari satu <br /> Atau pakai file asli di bawah</div>
					<form id="remidialfile" method="post" action="">
					<ul class="file" id="filecekuas">
						<li></li>
					</ul>
					</form>
				</td>
			</tr>
			<tr>
				<td width="30%" class="title">Tanggal Dikumpulkan</td>
				<td width="1">:</td>
				<td>
					<input type="text" name="tanggal_kumpul" style="width:100px;" value="<?=date('Y-m-d')?>" id="datekirimuasremidial">
				</td>
			</tr>
			<tr>
				<td width="30%" class="title">Keterangan</td>
				<td width="1">:</td>
				<td>
					<textarea name="keterangan"></textarea>
				</td>
			</tr>
			<tr>
				<td width="30%" class="title">Berbagi</td>
				<td width="1">:</td>
				<td>
					<input type="checkbox" name="share" value="1" />
				</td>
			</tr>
			<tr>
				<th style="text-align:right;" colspan="3">
				<a onclick="$('#kirimuasremidial').submit();" id="simpanuasbottom" class="button small light-grey absenbutton" title=""> Simpan </a>
				<a id="canceluasremidi" class="button small light-grey absenbutton" title=""> Cancel </a>
				</th>
			</tr>
			
		</tbody></table>

	<input type="hidden" value="1" name="ajax"> 

	<div style="display:none;" class="error-container"> Semua field harus di isi atau dipilih!  </div>
	</form>
</div>