<script>
	$(document).ready(function(){
		$("#uas").each(function(){
			$container = $(this).next("div.error-container");
			//Validate Starts
			$(this).validate({
				onfocusout: function(element) {	$(element).valid();	},
				errorContainer: $container,
				rules:{
				  id_kelas:{required:true,notEqual:'Pilih Kelas'},
				  id_pelajaran:{required:true,notEqual:'Pilih Pelajaran'},
				  id_uas:{required:true,notEqual:'Pilih uas'},
				  tanggal_kumpul:{required:true,notEqual:''}
				  /*,message:{required:true,minlength:10}*/
				}
			});//Validate End

		});
		$("table.adddata tr th a.canceluas").click(function(){
				var obj=$(this);
				$.ajax({
					type: "POST",
					data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&id_kelas='+$('select#kelasuas').val()+'&pelajaran='+$('select#pelajaranuas').val()+'&ajax=1',
					url: '<?=base_url('akademik/kirimuas/daftaruaslist')?>',
					beforeSend: function() {
						$('table.adddata tr th a.canceluas').after("<img class='waituas37' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
					},
					success: function(msg) {
						$(".waituas37").remove();
						//$('select#kelas').val($('select#kelas_adduas').val());
						//$('select#pelajaran').html($('select#pelajaran_adduas').html());
						//$('select#pelajaran').val($('select#pelajaran_adduas').val());	
						$('#subjectlistuas').html(msg);
						$('#subject').scrollintoview({ speed:'1100'});
					}
				});
				return false;
		});
		//Submit Starts		   
		$(".addaccountclose").click(function(){
			$(".addaccount").remove();
		});
		$("#uas").submit(function(e){
			if($('select#kelas_adduas').val()==null){
				$('select#kelas_adduas').css('border','1px solid red');
				return false;
			}
			$frm = $(this);
			$id_pelajaran = $frm.find('*[name=id_pelajaran]').val();
			$id_uas = $frm.find('*[name=id_uas]').val();
			$tanggal_kumpul = $frm.find('*[name=tanggal_kumpul]').val();
			
			if($frm.find('*[name=id_pelajaran]').is('.valid') && $frm.find('*[name=id_uas]').is('.valid') && $frm.find('*[name=tanggal_kumpul]').is('.valid')) {
				$.ajax({
					type: "POST",
					data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&'+$(this).serialize()+'&judul='+$("select#uas_add :selected").text(),
					url: $(this).attr('action'),
					beforeSend: function() {
						$("#simpanuas").after("<img id='wait' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
					},
					success: function(msg) {
						$("#wait").remove();	
						
					
						$.ajax({
							type: "POST",
							data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&id_kelas='+$('select#kelas_adduas').val()+'&pelajaran='+$('select#pelajaran_adduas').val()+'&ajax=1',
							url: '<?=base_url('akademik/kirimuas/daftaruaslist')?>',
							beforeSend: function() {
								$("#simpanuas").after("<img class='waituas37' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
								$("#simpanuasbottom").after("<img class='waituas37' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
							},
							success: function(msg) {
								$(".waituas37").remove();
								/*$.ajax({
										type: "POST",
										data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&id_kelas='+$('select#kelasuas').val()+'&pelajaran='+$('select#pelajaranuas').val()+'&ajax=1',
										url: '<?=base_url()?>akademik/kirimuas/daftaruaslist',
										beforeSend: function() {
											$("#simpanuas").after("<img class='waituas37' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
											$("#simpanuasbottom").after("<img class='waituas37' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
										},
										success: function(msg) {
											$(".waituas37").remove();
											
										}
								});*/
								$("#subjectlistuas").html(msg);	
								$('#subjectujian').scrollintoview({ speed:'1100'});
							}
						});
					}
				});
				return false;
			}
			
			return false;
		});//Submit End	
		
		/*$("select#kelas_adduas").change(function(e){
			$.ajax({
				type: "POST",
				data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&',
				url: '<?=base_url()?>admin/pelajaran/getMapelByKelasAndPegawai/'+$(this).val(),
				beforeSend: function() {
					$('select#kelas_adduas').after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
				},
				success: function(msg) {
					$('#wait').remove();
					$("#pelajaran_adduas").html(msg);	
				}
			});
		});*///Submit End
		
		$("select#kelas_adduas").change(function(e){
			$("input.id_mengajarappear").remove();
			$("select#kelas_adduas option:selected").each(function(e){
				if($(this).attr('id_mengajar')!=undefined){
					$("select#kelas_adduas").parent('td').append('<input class="id_mengajarappear" type="hidden" name="id_mengajar[]" value="'+$(this).attr('id_mengajar')+'" />');
				}
			});
		});
		$("select#pelajaran_adduas").change(function(e){
			var obj=$(this);
			$.ajax({
				type: "POST",
				data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&',
				url: '<?=base_url()?>admin/pelajaran/getKelasByPelajaranAndPegawai/'+$(this).val(),
				beforeSend: function() {
					$('select#kelas_adduas').after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
				},
				success: function(msg) {
					$('#wait').remove();
					$("#kelas_adduas").html(msg);
					$.ajax({
						type: "POST",
						data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&',
						url: '<?=base_url()?>akademik/kirimuas/getuasStok/'+$(obj).val(),
						beforeSend: function() {
							$('select#kelas_adduas').after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
						},
						success: function(msg2) {
							$('#wait').remove();
							$("#uas_add").html(msg2);	
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
	$('#datekirimuasutama').datepick();
});
</script>	
<div class="addaccount">
<form method="post" name="uas" enctype="multipart/form-data" id="uas" action="<? echo base_url();?>akademik/kirimuas/kirimuasnya">
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
	<div onclick="$('.addaccount').remove();" class="addaccountclose"></div>
		
		<h3>Kirim uas</h3>
		<div class="hr"></div>
		<table class="adddata">
			<tbody>
			<tr>
				<th style="text-align:right;" colspan="3">
				<a onclick="$('#uas').submit();" id="simpanuas" class="button small light-grey absenbutton" title=""> Kirim </a>
				<a id="canceluas" class="canceluas button small light-grey absenbutton" title=""> Cancel </a>
				</th>
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
						<option <? //if(@$_POST['pelajaran']==$datapelajaran['id']){echo 'selected';}?> value="<?=$datapelajaran['id']?>"><?=$datapelajaran['nama']?> [Kelas <?=$datapelajaran['kelas']?>]</option>
						<? }} ?>
					</select>
				</td>
			</tr>
			<tr>
				<td class="title">Di Kirim ke Kelas</td>
				<td>:</td>
				<td>
					<select class="selectfilter" id="kelas_adduas" name="id_kelas[]" multiple>
						<option value="">Pilih Kelas</option>
						<? foreach($kelas as $datakelas){?>
						<option <? //if(@$_POST['kelas']==$datakelas['id']){echo 'selected';}?> value="<?=$datakelas['id']?>"><?=$datakelas['kelas']?><?=$datakelas['nama']?></option>
						<? } ?>
					</select>
				</td>
			</tr>
			<tr>
				<td class="title">UAS</td>
				<td>:</td>
				<td>
					<select class="selectfilter" id="uas_add" name="id_uas">
						<option value="">Pilih uas</option>
						<? foreach($uas as $datauas){?>
						<option <? //if(@$_POST['kelas']==$datauas['id']){echo 'selected';}?> value="<?=$datauas['id']?>"><?=$datauas['kelas']?><?=$datauas['nama']?></option>
						<? } ?>
					</select>
				</td>
			</tr>
			<tr>
				<td width="30%" class="title">Tanggal Dikumpulkan</td>
				<td width="1">:</td>
				<td colspan="2">
					<input type="text" name="tanggal_kumpul" style="width:100px;" value="" id="datekirimuasutama">
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
				<a onclick="$('#uas').submit();" id="simpanuasbottom" class="button small light-grey absenbutton" title=""> Kirim </a>
				<a id="canceluas" class="canceluas button small light-grey absenbutton" title=""> Cancel </a>
				</th>
			</tr>
		</tbody></table>

	<input type="hidden" value="1" name="ajax"> 

	<div style="display:none;" class="error-container"> Semua field yang merah harus di isi atau dipilih!  </div>
	</form>
</div>