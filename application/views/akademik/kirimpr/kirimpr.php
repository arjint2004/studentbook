<script>
	$(document).ready(function(){
		$("#pr").each(function(){
			$container = $(this).next("div.error-container");
			//Validate Starts
			$(this).validate({
				onfocusout: function(element) {	$(element).valid();	},
				errorContainer: $container,
				rules:{
				  id_kelas:{required:true,notEqual:'Pilih Kelas'},
				  id_pelajaran:{required:true,notEqual:'Pilih Pelajaran'},
				  id_pr:{required:true,notEqual:'Pilih pr'},
				  tanggal_kumpul:{required:true,notEqual:''}
				  /*,message:{required:true,minlength:10}*/
				}
			});//Validate End

		});
		$("table.adddata tr th a.cancelpr").click(function(){
				var obj=$(this);
				$.ajax({
					type: "POST",
					data: 'id_kelas='+$('select#kelaspr').val()+'&pelajaran='+$('select#pelajaranpr').val()+'&ajax=1',
					url: '<?=base_url('akademik/kirimpr/daftarprlist')?>',
					beforeSend: function() {
						$('table.adddata tr th a.cancelpr').after("<img class='waitpr37' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
					},
					success: function(msg) {
						$(".waitpr37").remove();
						//$('select#kelas').val($('select#kelas_addpr').val());
						//$('select#pelajaran').html($('select#pelajaran_addpr').html());
						//$('select#pelajaran').val($('select#pelajaran_addpr').val());	
						$('#subjectlistpr').html(msg);
						$('#subject').scrollintoview({ speed:'1100'});
					}
				});
				return false;
		});
		//Submit Starts		   
		$(".addaccountclose").click(function(){
			$(".addaccount").remove();
		});
		$("#pr").submit(function(e){
			if($('select#kelas_addpr').val()==null){
				$('select#kelas_addpr').css('border','1px solid red');
				return false;
			}
			$frm = $(this);
			$id_pelajaran = $frm.find('*[name=id_pelajaran]').val();
			$id_pr = $frm.find('*[name=id_pr]').val();
			$tanggal_kumpul = $frm.find('*[name=tanggal_kumpul]').val();
			
			if($frm.find('*[name=id_pelajaran]').is('.valid') && $frm.find('*[name=id_pr]').is('.valid') && $frm.find('*[name=tanggal_kumpul]').is('.valid')) {
				$.ajax({
					type: "POST",
					data: $(this).serialize()+'&'+$('form#nilai').serialize(),
					url: $(this).attr('action'),
					beforeSend: function() {
						$("#simpanpr").after("<img id='wait' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
					},
					success: function(msg) {
						$("#wait").remove();	
						
					
						$.ajax({
							type: "POST",
							data: 'id_kelas='+$('select#kelas_addpr').val()+'&pelajaran='+$('select#pelajaran_addpr').val()+'&ajax=1',
							url: '<?=base_url('akademik/kirimpr/daftarprlist')?>',
							beforeSend: function() {
								$("#simpanpr").after("<img class='waitpr37' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
								$("#simpanprbottom").after("<img class='waitpr37' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
							},
							success: function(msg) {
								$(".waitpr37").remove();
								$.ajax({
										type: "POST",
										data: 'id_kelas='+$('select#kelaspr').val()+'&pelajaran='+$('select#pelajaranpr').val()+'&ajax=1',
										url: '<?=base_url()?>akademik/kirimpr/daftarprlist',
										beforeSend: function() {
											$("#simpanpr").after("<img class='waitpr37' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
											$("#simpanprbottom").after("<img class='waitpr37' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
										},
										success: function(msg) {
											$(".waitpr37").remove();
											$("#subjectlistpr").html(msg);	
										}
								});
								$('#subjectpembelajaran').scrollintoview({ speed:'1100'});
							}
						});
					}
				});
				return false;
			}
			
			return false;
		});//Submit End	
		
		/*$("select#kelas_addpr").change(function(e){
			$.ajax({
				type: "POST",
				data: '',
				url: '<?=base_url()?>admin/pelajaran/getMapelByKelasAndPegawai/'+$(this).val(),
				beforeSend: function() {
					$('select#kelas_addpr').after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
				},
				success: function(msg) {
					$('#wait').remove();
					$("#pelajaran_addpr").html(msg);	
				}
			});
		});*///Submit End
		
		$("select#kelas_addpr").change(function(e){
			$("input.id_mengajarappear").remove();
			$("select#kelas_addpr option:selected").each(function(e){
				if($(this).attr('id_mengajar')!=undefined){
					$("select#kelas_addpr").parent('td').append('<input class="id_mengajarappear" type="hidden" name="id_mengajar[]" value="'+$(this).attr('id_mengajar')+'" />');
				}
			});
		});
		$("select#pelajaran_addpr").change(function(e){
			var obj=$(this);
			$.ajax({
				type: "POST",
				data: '',
				url: '<?=base_url()?>admin/pelajaran/getKelasByPelajaranAndPegawai/'+$(this).val(),
				beforeSend: function() {
					$('select#kelas_addpr').after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
				},
				success: function(msg) {
					$('#wait').remove();
					$("#kelas_addpr").html(msg);
					$.ajax({
						type: "POST",
						data: '',
						url: '<?=base_url()?>akademik/kirimpr/getprStok/'+$(obj).val(),
						beforeSend: function() {
							$('select#kelas_addpr').after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
						},
						success: function(msg2) {
							$('#wait').remove();
							$("#pr_add").html(msg2);	
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
	$('#datekirimprutama').datepick();
});
</script>	
<div class="addaccount">
<form method="post" name="pr" enctype="multipart/form-data" id="pr" action="<? echo base_url();?>akademik/kirimpr/kirimprnya">
	<div onclick="$('.addaccount').remove();" class="addaccountclose"></div>
		
		<h3>Kirim pr</h3>
		<div class="hr"></div>
		<table class="adddata">
			<tbody>
			<tr>
				<th style="text-align:right;" colspan="3">
				<a onclick="$('#pr').submit();" id="simpanpr" class="button small light-grey absenbutton" title=""> Kirim </a>
				<a id="cancelpr" class="cancelpr button small light-grey absenbutton" title=""> Cancel </a>
				</th>
			</tr>
			<tr>
				<td class="title">Pelajaran</td>
				<td>:</td>
				<td>
					<select class="selectfilter" id="pelajaran_addpr" name="id_pelajaran">
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
					<select class="selectfilter" id="kelas_addpr" name="id_kelas[]" multiple>
						<option value="">Pilih Kelas</option>
						<? foreach($kelas as $datakelas){?>
						<option <? //if(@$_POST['kelas']==$datakelas['id']){echo 'selected';}?> value="<?=$datakelas['id']?>"><?=$datakelas['kelas']?><?=$datakelas['nama']?></option>
						<? } ?>
					</select>
				</td>
			</tr>
			<tr>
				<td class="title">PR</td>
				<td>:</td>
				<td>
					<select class="selectfilter" id="pr_add" name="id_pr">
						<option value="">Pilih pr</option>
						<? foreach($pr as $datapr){?>
						<option <? //if(@$_POST['kelas']==$datapr['id']){echo 'selected';}?> value="<?=$datapr['id']?>"><?=$datapr['kelas']?><?=$datapr['nama']?></option>
						<? } ?>
					</select>
				</td>
			</tr>
			<tr>
				<td width="30%" class="title">Tanggal Dikumpulkan</td>
				<td width="1">:</td>
				<td colspan="2">
					<input type="text" name="tanggal_kumpul" style="width:100px;" value="" id="datekirimprutama">
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
				<a onclick="$('#pr').submit();" id="simpanprbottom" class="button small light-grey absenbutton" title=""> Kirim </a>
				<a id="cancelpr" class="cancelpr button small light-grey absenbutton" title=""> Cancel </a>
				</th>
			</tr>
		</tbody></table>

	<input type="hidden" value="1" name="ajax"> 

	<div style="display:none;" class="error-container"> Semua field yang merah harus di isi atau dipilih!  </div>
	</form>
</div>