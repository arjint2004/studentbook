<script>
	$(document).ready(function(){
		$("#kirimharianremidial").each(function(){
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
		
		$("table.adddata tr th a#cancelharianremidi").click(function(){
				var obj=$(this);
				$.ajax({
					type: "POST",
					data: 'id_kelas='+$('select#kelasharian').val()+'&pelajaran='+$('select#pelajaranharian').val()+'&ajax=1',
					url: '<?=base_url('akademik/kirimharian/daftarharianlist')?>',
					beforeSend: function() {
						$("table.adddata tr th a#cancelharianremidi").after("<img id='waitharian9' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
					},
					success: function(msg) {
						$("#waitharian9").remove();
						//$('select#kelasharian').val('');
						//$('select#pelajaranharian').html($('select#pelajaran_addharian').html());
						//$('select#pelajaranharian').val('');	
						$('#subjectlistharian').html(msg);
						$('#subjectujian').scrollintoview({ speed:'1100'});
					}
				});
				return false;
		});
		//Submit Starts		   
		$(".addaccountclose").click(function(){
			$(".addaccount").remove();
		});
		filesize('fileaddharianremidi',15000000,50);
		$("#kirimharianremidial").submit(function(e){
			$frm = $(this);
			$id_kelas = $frm.find('*[name=id_kelas]').val();
			//$siswa = $frm.find('*[name=siswa]').val();
			$id_pelajaran = $frm.find('*[name=id_pelajaran]').val();
			//$bab = $frm.find('*[name=bab]').val();
			$id_parent = $frm.find('*[name=id_parent]').val();
			//$file = $frm.find('*[name=file]').val();
			$tanggal_kumpul = $frm.find('*[name=tanggal_kumpul]').val();
			$keterangan = $frm.find('*[name=keterangan]').val();
			//alert($('select#siswa_addharian').val());
			if($('select#siswa_addharian').val()=='' || $('select#siswa_addharian').val()==null){$('select#siswa_addharian').css('border','1px solid red');return false;}else{$('select#siswa_addharian').css('border','');}
			if($frm.find('*[name=id_kelas]').is('.valid') /*&& $frm.find('*[name=siswa]').is('.valid')*/ && $frm.find('*[name=id_pelajaran]').is('.valid') /*&& $frm.find('*[name=bab]').is('.valid') */ && $frm.find('*[name=id_parent]').is('.valid') /*&& $frm.find('*[name=file]').is('.valid') && $frm.find('*[name=tanggal_kumpul]').is('.valid') */&& $frm.find('*[name=keterangan]').is('.valid')) {
				
				$.ajax({
					type: "POST",
					data: $(this).serialize()+'&judul='+$("select#judul_addharian").attr('title'),
					url: $(this).attr('action'),
					beforeSend: function() {
						$("#kirimharianremidial").append("<div class=\"error-box\" style='display: block; top: 50%; position: fixed; left: 46%;'></div>");
						$(".error-box").delay(1000).html('Inserting Data');
					},
					success: function(msg) {
					
						$(".error-box").delay(1000).fadeOut("slow",function(){
							$(this).remove();
						});
						var upload=ajaxuploadnew("<? echo base_url();?>akademik/kirimharian/uploadfileharian/"+msg,"response","image-list","fileaddharianremidi");
						$.ajax({
							url: "<? echo base_url();?>akademik/kirimharian/uploadfileharian/"+msg,
							type: "POST",
							data: upload,
							processData: false,
							contentType: false,
							beforeSend: function() {
								$("#kirimharianremidial").append("<div class=\"error-box\" style='display: block; top: 50%; position: fixed; left: 46%;'></div>");
								$(".error-box").delay(1000).html('Proses Upload File');
							},
							error	: function(){
								alert('HARIAN anda sudah tersimpan. Tetapi lampiran file anda gagal di Upload. Klik OK untuk melengkapi lampiran');
								$('#subjectlistharian').load('<?=base_url('akademik/kirimharian/kirimharianremidialedit')?>/'+msg);						
							},
							success: function (res) {
								$(".error-box").delay(1000).fadeOut("slow",function(){
									$(this).remove();
								});	
								if(res=='null'){
									$.ajax({
										type: "POST",
										data: 'id_kelas='+$('select#kelas_addharian').val()+'&pelajaran='+$('select#pelajaran_addharian').val()+'&ajax=1',
										url: '<?=base_url('akademik/kirimharian/daftarharianlist')?>',
										beforeSend: function() {
											$("#kirimharianremidial").append("<div class=\"error-box\" style='display: block; top: 50%; position: fixed; left: 46%;'></div>");
											$(".error-box").delay(1000).html('Load data');
											$(".error-box").delay(1000).fadeOut("slow",function(){
												$(this).remove();
											});
										},
										success: function(msg) {
											$('#subjectlistharian').html(msg);
											$('#subjectujian').scrollintoview({ speed:'1100'});
										}
									});
								}else{
									alert(res+'');
									$('#subjectlistharian').load('<?=base_url('akademik/kirimharian/kirimharianremidialedit')?>/'+msg);
								}
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
				url: '<?=base_url()?>akademik/kirimharian/getOptionFileHarianByIdHarian/'+$(this).val(),
				beforeSend: function() {
					$('select#judul_addharian').after("<img id='waitharian11' src='<?=$this->config->item('images').'loading.png';?>' />");
				},
				success: function(msg) {
					$('#waitharian11').remove();
					$(obj).attr('title',$(obj).find(":selected").attr('judul'));
					$('.babremidi').val($(obj).find(":selected").attr('bab'));
					$("#filecekharian").html(msg);	
				}
			});
		});
		$("select#pelajaran_addharian").change(function(e){
			$.ajax({
				type: "POST",
				data: '',
				url: '<?=base_url()?>akademik/kirimharian/createOptionHarianByKelasPelajaranIdPegawai/'+$(this).val()+'/'+$('select#kelas_addharian').val(),
				beforeSend: function() {
					$('select#judul_addharian').after("<img id='waitharian12' src='<?=$this->config->item('images').'loading.png';?>' />");
				},
				success: function(msg) {
					$('#waitharian12').remove();
					$("#judul_addharian").html(msg);	
				}
			});
		});
		$("select#kelas_addharian").change(function(e){
			$.ajax({
				type: "POST",
				data: '',
				url: '<?=base_url()?>akademik/kirimharian/getOptionSiswaByIdKelas/'+$(this).val(),
				beforeSend: function() {
					$('select#siswa_addharian').after("<img id='waitharian13' src='<?=$this->config->item('images').'loading.png';?>' />");
				},
				success: function(msg) {
					$('#waitharian13').remove();
					$("#siswa_addharian").html(msg);	
				}
			});
			$.ajax({
				type: "POST",
				data: '',
				url: '<?=base_url()?>admin/pelajaran/getMapelByKelasAndPegawai/'+$(this).val(),
				beforeSend: function() {
					$('select#pelajaran_addharian').after("<img id='waitharian14' src='<?=$this->config->item('images').'loading.png';?>' />");
				},
				success: function(msg) {
					$('#waitharian14').remove();
					$("#pelajaran_addharian").html(msg);	
				}
			});
		});//Submit End
	});
</script>	


<script type="text/javascript">
function getadd(obj,date) {

}
$(function() {
	$('#datekirimharianremidial').datepick();
});
</script>	
<div class="addaccount">
<form method="post" name="kirimharianremidial" enctype="multipart/form-data" id="kirimharianremidial" action="<? echo base_url();?>akademik/kirimharian/kirimharianremidial">
	<div onclick="$('.addaccount').remove();" class="addaccountclose"></div>
		
		<h3>Tambah HARIAN Remidial</h3>
		<div class="hr"></div>
		<table class="adddata">
			<tbody>
			<tr>
				<th style="text-align:right;" colspan="3">
				<a onclick="$('#kirimharianremidial').submit();" id="simpanharian" class="button small light-grey absenbutton" title=""> Simpan </a>
				<a id="cancelharianremidi" class="button small light-grey absenbutton" title=""> Cancel </a>
				</th>
			</tr>
			<tr>
				<td class="title">Di Kirim ke Kelas</td>
				<td>:</td>
				<td>
					<select class="selectfilter" id="kelas_addharian" name="id_kelas">
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
					<select class="selectfilter" id="siswa_addharian" multiple name="siswa[]">
						<option value="">Pilih Siswa</option>
					</select>
					<div  style="font-size:11px;">jika pilihan lebih dari satu siswa, maka gunakan ctrl+klik</div>
				</td>
			</tr>
			<tr>
				<td class="title">Pelajaran</td>
				<td>:</td>
				<td>
					<select class="selectfilter" id="pelajaran_addharian" name="id_pelajaran">
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
				<td class="title">Judul HARIAN</td>
				<td>:</td>
				<td>
					<select class="selectfilter" id="judul_addharian" name="id_parent">
						<option value="">Pilih HARIAN</option>
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
					<input type="file" name="file" id="fileaddharianremidi" multiple />
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
					<input type="text" name="tanggal_kumpul" style="width:100px;" value="<?=date('Y-m-d')?>" id="datekirimharianremidial">
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
				<a onclick="$('#kirimharianremidial').submit();" id="simpanharianbottom" class="button small light-grey absenbutton" title=""> Simpan </a>
				<a id="cancelharianremidi" class="button small light-grey absenbutton" title=""> Cancel </a>
				</th>
			</tr>
			
		</tbody></table>

	<input type="hidden" value="1" name="ajax"> 

	<div style="display:none;" class="error-container"> Semua field harus di isi atau dipilih!  </div>
	</form>
</div>