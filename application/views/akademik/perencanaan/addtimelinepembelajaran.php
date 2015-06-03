<script>
	$(document).ready(function(){
		$("#timelinepembelajaranadd").each(function(){
			$container = $(this).next("div.error-container");
			//Validate Starts
			$(this).validate({
				onfocusout: function(element) {	$(element).valid();	},
				errorContainer: $container,
				rules:{
				  id_kelas:{required:true,notEqual:'Pilih Kelas'},
				  id_pelajaran:{required:true,notEqual:'Pilih Pelajaran'},
				  file:{required:true,notEqual:''},
				  pertemuan:{required:true,notEqual:''},
				  tanggal:{required:true,notEqual:''},
				  keterangan:{required:true,notEqual:''}
				  /*,message:{required:true,minlength:10}*/
				}
			});//Validate End

		});
		$("table.adddata tr th a#canceltime").click(function(){
				var obj=$(this);
				$.ajax({
					type: "POST",
					data: 'id_kelas='+$('select#kelas').val()+'&pelajaran='+$('select#pelajaran').val()+'&ajax=1',
					url: '<?=base_url('akademik/perencanaan/pembelajaranlist')?>',
					beforeSend: function() {
						$(obj).after("<img id='wait' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
					},
					success: function(msg) {
						$("#wait").remove();
						$("#wait").remove();
						$('select#kelas').val($('select#kelas_add').val());
						$('select#pelajaran').html($('select#pelajaran_add').html());
						$('select#pelajaran').val($('select#pelajaran_add').val());	
						$('#subjectlist').html(msg);
					}
				});
				return false;
		});
		//Submit Starts		   
		$(".addaccountclose").click(function(){
			$(".addaccount").remove();
		});
		$("#timelinepembelajaranadd").submit(function(e){
			$frm = $(this);
			$id_kelas = $frm.find('*[name=id_kelas]').val();
			$id_pelajaran = $frm.find('*[name=id_pelajaran]').val();
			$file = $frm.find('*[name=file]').val();
			$pertemuan = $frm.find('*[name=pertemuan]').val();
			$tanggal = $frm.find('*[name=tanggal]').val();
			$keterangan = $frm.find('*[name=keterangan]').val();
			if($frm.find('*[name=id_kelas]').is('.valid') && $frm.find('*[name=id_pelajaran]').is('.valid') && $frm.find('*[name=file]').is('.valid') && $frm.find('*[name=pertemuan]').is('.valid') && $frm.find('*[name=tanggal]').is('.valid') && $frm.find('*[name=keterangan]').is('.valid')) {
				$.ajax({
					type: "POST",
					data: $(this).serialize()+'&'+$('form#nilai').serialize(),
					url: $(this).attr('action'),
					beforeSend: function() {
						$("#simpanpr").after("<img id='wait' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
					},
					success: function(msg) {
						$("#wait").remove();
						ajaxupload("<? echo base_url();?>akademik/perencanaan/uploadtimelinepembelajaran/"+msg,"response","image-list","file");
						$.ajax({
							type: "POST",
							data: 'id_kelas='+$('select#kelas_add').val()+'&pelajaran='+$('select#pelajaran_add').val()+'&ajax=1',
							url: '<?=base_url('akademik/perencanaan/timelinepembelajaranlist')?>',
							beforeSend: function() {
								$("#simpanpr").after("<img id='wait' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
							},
							success: function(msg) {
								$("#wait").remove();
								$('select#kelas').val($('select#kelas_add').val());
								$('select#pelajaran').html($('select#pelajaran_add').html());
								$('select#pelajaran').val($('select#pelajaran_add').val());
								$('#subjectlist').html(msg);
							}
						});
					}
				});
				return false;
			}
			
			return false;
		});//Submit End	
		
		$("select#kelas_add").change(function(e){
			$.ajax({
				type: "POST",
				data: '',
				url: '<?=base_url()?>admin/pelajaran/getMapelByKelasAndPegawai/'+$(this).val(),
				beforeSend: function() {
					$('select#kelas_add').after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
				},
				success: function(msg) {
					$('#wait').remove();
					$("#pelajaran_add").html(msg);	
				}
			});
		});//Submit End
	});
</script>	



<script type="text/javascript">
function getadd(obj,date) {

}
$(function() {
	$('#datekirimpr').datepick();
});
</script>
<div class="addaccount">
<form method="post" name="timelinepembelajaran" enctype="multipart/form-data" id="timelinepembelajaranadd" action="<? echo base_url();?>akademik/perencanaan/addtimelinepembelajaran">
	<div onclick="$('.addaccount').remove();" class="addaccountclose"></div>
		
		<h3>Tambah Perencanaan timelinepembelajaran</h3>
		<div class="hr"></div>
		<table class="adddata">
			<tbody>
			<tr>
				<th style="text-align:right;" colspan="3">
				<a onclick="$('#timelinepembelajaranadd').submit();" id="simpanpr" class="button small light-grey absenbutton" title=""> Simpan </a>
				<a id="canceltime" class="button small light-grey absenbutton" title=""> Cancel </a>
				</th>
			</tr>
			<tr>
				<td class="title">Kelas</td>
				<td>:</td>
				<td>
					<select class="selectfilter" id="kelas_add" name="id_kelas">
						<option value="">Pilih Kelas</option>
						<? foreach($kelas as $datakelas){?>
						<option <? if(@$_POST['kelas']==$datakelas['id']){echo 'selected';}?> value="<?=$datakelas['id']?>"><?//=$datakelas['kelas']?><?=$datakelas['nama']?></option>
						<? } ?>
					</select>
				</td>
			</tr>
			<tr>
				<td class="title">Pelajaran</td>
				<td>:</td>
				<td>
					<select class="selectfilter" id="pelajaran_add" name="id_pelajaran">
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
				<td width="30%" class="title">Lampiran File</td>
				<td width="1">:</td>
				<td>
					<input type="file" name="file" id="file" multiple />
					<div id="response" style="font-size:11px;">Anda bisa memilih banyak file dengan memencet tombol "Ctrl", kemudian klik file yang dipilih lebih dari satu</div>
				</td>
			</tr>
			<tr>
				<td width="30%" class="title">Pertemuan Ke</td>
				<td width="1">:</td>
				<td>
					<input type="text" name="pertemuan" style="width:30px;" value="">
				</td>
			</tr>
			<tr>
				<td width="30%" class="title">Tanggal</td>
				<td width="1">:</td>
				<td>
					<input type="text" name="tanggal" style="width:100px;" value="<?=date('Y-m-d')?>" id="datekirimpr">
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
		</tbody></table>

	<input type="hidden" value="1" name="ajax"> 

	<div style="display:none;" class="error-container"> Semua field yang merah harus di isi atau dipilih!  </div>
	</form>
</div>