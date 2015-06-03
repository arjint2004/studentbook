<script>
	$(document).ready(function(){
		$("#tugas").each(function(){
			$container = $(this).next("div.error-container");
			//Validate Starts
			$(this).validate({
				onfocusout: function(element) {	$(element).valid();	},
				errorContainer: $container,
				rules:{
				  id_kelas:{required:true,notEqual:'Pilih Kelas'},
				  id_pelajaran:{required:true,notEqual:'Pilih Pelajaran'},
				  id_tugas:{required:true,notEqual:'Pilih tugas'},
				  tanggal_kumpul:{required:true,notEqual:''}
				  /*,message:{required:true,minlength:10}*/
				}
			});//Validate End

		});
		$("table.adddata tr th a.canceltugas").click(function(){
				var obj=$(this);
				$.ajax({
					type: "POST",
					data: 'id_kelas='+$('select#kelastugas').val()+'&pelajaran='+$('select#pelajarantugas').val()+'&ajax=1',
					url: '<?=base_url('akademik/kirimtugas/daftartugaslist')?>',
					beforeSend: function() {
						$('table.adddata tr th a.canceltugas').after("<img class='waittugas37' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
					},
					success: function(msg) {
						$(".waittugas37").remove();
						//$('select#kelas').val($('select#kelas_addtugas').val());
						//$('select#pelajaran').html($('select#pelajaran_addtugas').html());
						//$('select#pelajaran').val($('select#pelajaran_addtugas').val());	
						$('#subjectlisttugas').html(msg);
						$('#subject').scrollintoview({ speed:'1100'});
					}
				});
				return false;
		});
		//Submit Starts		   
		$(".addaccountclose").click(function(){
			$(".addaccount").remove();
		});
		$("#tugas").submit(function(e){
			if($('select#kelas_addtugas').val()==null){
				$('select#kelas_addtugas').css('border','1px solid red');
				return false;
			}
			$frm = $(this);
			$id_pelajaran = $frm.find('*[name=id_pelajaran]').val();
			$id_tugas = $frm.find('*[name=id_tugas]').val();
			$tanggal_kumpul = $frm.find('*[name=tanggal_kumpul]').val();
			
			if($frm.find('*[name=id_pelajaran]').is('.valid') && $frm.find('*[name=id_tugas]').is('.valid') && $frm.find('*[name=tanggal_kumpul]').is('.valid')) {
				$.ajax({
					type: "POST",
					data: $(this).serialize()+'&judul='+$("select#tugas_add :selected").text(),
					url: $(this).attr('action'),
					beforeSend: function() {
						$("#simpantugas").after("<img id='wait' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
					},
					success: function(msg) {
						$("#wait").remove();	
						
					
						$.ajax({
							type: "POST",
							data: 'id_kelas='+$('select#kelas_addtugas').val()+'&pelajaran='+$('select#pelajaran_addtugas').val()+'&ajax=1',
							url: '<?=base_url('akademik/kirimtugas/daftartugaslist')?>',
							beforeSend: function() {
								$("#simpantugas").after("<img class='waittugas37' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
								$("#simpantugasbottom").after("<img class='waittugas37' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
							},
							success: function(msg) {
								$(".waittugas37").remove();
								/*$.ajax({
										type: "POST",
										data: 'id_kelas='+$('select#kelastugas').val()+'&pelajaran='+$('select#pelajarantugas').val()+'&ajax=1',
										url: '<?=base_url()?>akademik/kirimtugas/daftartugaslist',
										beforeSend: function() {
											$("#simpantugas").after("<img class='waittugas37' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
											$("#simpantugasbottom").after("<img class='waittugas37' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
										},
										success: function(msg) {
											$(".waittugas37").remove();
											
										}
								});*/
								$("#subjectlisttugas").html(msg);	
								$('#subjectpembelajaran').scrollintoview({ speed:'1100'});
							}
						});
					}
				});
				return false;
			}
			
			return false;
		});//Submit End	
		
		/*$("select#kelas_addtugas").change(function(e){
			$.ajax({
				type: "POST",
				data: '',
				url: '<?=base_url()?>admin/pelajaran/getMapelByKelasAndPegawai/'+$(this).val(),
				beforeSend: function() {
					$('select#kelas_addtugas').after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
				},
				success: function(msg) {
					$('#wait').remove();
					$("#pelajaran_addtugas").html(msg);	
				}
			});
		});*///Submit End
		
		$("select#kelas_addtugas").change(function(e){
			$("input.id_mengajarappear").remove();
			$("select#kelas_addtugas option:selected").each(function(e){
				if($(this).attr('id_mengajar')!=undefined){
					$("select#kelas_addtugas").parent('td').append('<input class="id_mengajarappear" type="hidden" name="id_mengajar[]" value="'+$(this).attr('id_mengajar')+'" />');
				}
			});
		});
		$("select#pelajaran_addtugas").change(function(e){
			var obj=$(this);
			$.ajax({
				type: "POST",
				data: '',
				url: '<?=base_url()?>admin/pelajaran/getKelasByPelajaranAndPegawai/'+$(this).val(),
				beforeSend: function() {
					$('select#kelas_addtugas').after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
				},
				success: function(msg) {
					$('#wait').remove();
					$("#kelas_addtugas").html(msg);
					$.ajax({
						type: "POST",
						data: '',
						url: '<?=base_url()?>akademik/kirimtugas/gettugasStok/'+$(obj).val(),
						beforeSend: function() {
							$('select#kelas_addtugas').after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
						},
						success: function(msg2) {
							$('#wait').remove();
							$("#tugas_add").html(msg2);	
						}
					});					
				}
			});

		});//Submit End
	});
</script>	


<script type="text/javascript">
function getadd(obj,date) {

}
$(function() {
	$('#datekirimtugasutama').datepick();
});
</script>	
<div class="addaccount">
<form method="post" name="tugas" enctype="multipart/form-data" id="tugas" action="<? echo base_url();?>akademik/kirimtugas/kirimtugasnya">
	<div onclick="$('.addaccount').remove();" class="addaccountclose"></div>
		
		<h3>Kirim tugas</h3>
		<div class="hr"></div>
		<table class="adddata">
			<tbody>
			<tr>
				<th style="text-align:right;" colspan="3">
				<a onclick="$('#tugas').submit();" id="simpantugas" class="button small light-grey absenbutton" title=""> Kirim </a>
				<a id="canceltugas" class="canceltugas button small light-grey absenbutton" title=""> Cancel </a>
				</th>
			</tr>
			<tr>
				<td class="title">Pelajaran</td>
				<td>:</td>
				<td>
					<select class="selectfilter" id="pelajaran_addtugas" name="id_pelajaran">
						<option value="">Pilih Pelajaran</option>
						<?
						if(!empty($pelajaran)){			
						foreach($pelajaran as $datapelajaran){?>
						<option <? //if(@$_POST['pelajaran']==$datapelajaran['id']){echo 'selected';}?> value="<?=$datapelajaran['id']?>"><?=$datapelajaran['nama']?> [Kelas <?=$datapelajaran['kelas']?>]</option>
						<? }} ?>
					</select>
				</td>
			</tr>
			<tr>
				<td class="title">Di Kirim ke Kelas</td>
				<td>:</td>
				<td>
					<select class="selectfilter" id="kelas_addtugas" name="id_kelas[]" multiple>
						<option value="">Pilih Kelas</option>
						<? foreach($kelas as $datakelas){?>
						<option <? //if(@$_POST['kelas']==$datakelas['id']){echo 'selected';}?> value="<?=$datakelas['id']?>"><?//=$datakelas['kelas']?><?=$datakelas['nama']?></option>
						<? } ?>
					</select>
				</td>
			</tr>
			<tr>
				<td class="title">TUGAS</td>
				<td>:</td>
				<td>
					<select class="selectfilter" id="tugas_add" name="id_tugas">
						<option value="">Pilih tugas</option>
						<? foreach($tugas as $datatugas){?>
						<option <? //if(@$_POST['kelas']==$datatugas['id']){echo 'selected';}?> value="<?=$datatugas['id']?>"><?=$datatugas['kelas']?><?=$datatugas['nama']?></option>
						<? } ?>
					</select>
				</td>
			</tr>
			<tr>
				<td width="30%" class="title">Tanggal Dikumpulkan</td>
				<td width="1">:</td>
				<td colspan="2">
					<input type="text" name="tanggal_kumpul" style="width:100px;" value="" id="datekirimtugasutama">
				</td>
			</tr>
			<tr>
				<td width="30%" class="title">Keterangan</td>
				<td width="1">:</td>
				<td colspan="2">
					<textarea name="keterangan" maxlength="200" placeholder="Keterangan akan dikirim ke Orang Tua / Wali Siswa melalui SMS"></textarea>
				</td>
			</tr>
			<tr>
				<th style="text-align:right;" colspan="3">
				<a onclick="$('#tugas').submit();" id="simpantugasbottom" class="button small light-grey absenbutton" title=""> Kirim </a>
				<a id="canceltugas" class="canceltugas button small light-grey absenbutton" title=""> Cancel </a>
				</th>
			</tr>
		</tbody></table>

	<input type="hidden" value="1" name="ajax"> 

	<div style="display:none;" class="error-container"> Semua field yang merah harus di isi atau dipilih!  </div>
	</form>
</div>