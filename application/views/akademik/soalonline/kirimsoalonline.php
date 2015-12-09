<script>
	$(document).ready(function(){
		$("#soalonline").each(function(){
			$container = $(this).next("div.error-container");
			//Validate Starts
			$(this).validate({
				onfocusout: function(element) {	$(element).valid();	},
				errorContainer: $container,
				rules:{
				  id_kelas:{required:true,notEqual:'Pilih Kelas'},
				  id_pelajaran:{required:true,notEqual:'Pilih Pelajaran'},
				  id_soalonline:{required:true,notEqual:'Pilih Soalonline'},
				  bab:{required:true,notEqual:''},
				  pokok_bahasan:{required:true,notEqual:''},
				 /* file:{required:true,notEqual:''},*/
				  tanggal_diajarkan:{required:true,notEqual:''}
				  /*,message:{required:true,minlength:10}*/
				}
			});//Validate End

		});
		$("table.adddata tr th a#cancelsoalonline").click(function(){
				var obj=$(this);
				$.ajax({
					type: "POST",
					data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&id_kelas='+$('select#kelas').val()+'&pelajaran='+$('select#pelajaran').val()+'&ajax=1',
					url: '<?=base_url('akademik/soalonline/daftarsoalonlinelist')?>',
					beforeSend: function() {
						$(obj).after("<img id='wait' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
					},
					success: function(msg) {
						$("#wait").remove();
						$("#wait").remove();
						$('select#kelas').val($('select#kelas_add').val());
						$('select#pelajaran').html($('select#pelajaran_add').html());
						$('select#pelajaran').val($('select#pelajaran_add').val());	
						$('#subjectlistsoalonline').html(msg);
						$('#subject').scrollintoview({ speed:'1100'});
					}
				});
				return false;
		});
		//Submit Starts		   
		$(".addaccountclose").click(function(){
			$(".addaccount").remove();
		});
		$("#soalonline").submit(function(e){
			if($('select#kelas_add').val()==null){
				$('select#kelas_add').css('border','1px solid red');
				return false;
			}
			$frm = $(this);
			$id_pelajaran = $frm.find('*[name=id_pelajaran]').val();
			$id_soalonline = $frm.find('*[name=id_soalonline]').val();
			$tanggal_diajarkan = $frm.find('*[name=id_soalonline]').val();
		
			
			if($frm.find('*[name=id_pelajaran]').is('.valid') && $frm.find('*[name=tanggal_diajarkan]').is('.valid') && $frm.find('*[name=id_soalonline]').is('.valid')) {
				$.ajax({
					type: "POST",
					data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&'+$(this).serialize()+'&pokok_bahasan='+$("select#soalonline_add :selected").text(),
					url: $(this).attr('action'),
					beforeSend: function() {
						$("#simpanpr").after("<img id='wait' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
					},
					success: function(msg) {
						$("#wait").remove();	
						
					
						$.ajax({
							type: "POST",
							//data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&id_kelas='+$('select#kelas_add').val()+'&pelajaran='+$('select#pelajaran_add').val()+'&ajax=1',
							data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&&ajax=1',
							url: '<?=base_url('akademik/soalonline/daftarsoalonlinelist')?>',
							beforeSend: function() {
								$("#simpanpr").after("<img id='wait' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
							},
							success: function(msg) {
								$("#wait").remove();
								/*$.ajax({
										type: "POST",
										data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&ajax=1',
										url: '<?=base_url()?>akademik/soalonline/daftarsoalonlinelist',
										beforeSend: function() {
											$("#filterpelajaransoalonline select#pelajaran").after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
										},
										success: function(msg) {
											$("#wait").remove();
											
										}
								});*/
								$("#subjectlistsoalonline").html(msg);	
								$('#subjectlistsoalonline').scrollintoview({ speed:'1100'});
							}
						});
					}
				});
				return false;
			}
			
			return false;
		});//Submit End	
		
		/*$("select#kelas_add").change(function(e){
			$.ajax({
				type: "POST",
				data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&',
				url: '<?=base_url()?>admin/pelajaran/getMapelByKelasAndPegawai/'+$(this).val(),
				beforeSend: function() {
					$('select#kelas_add').after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
				},
				success: function(msg) {
					$('#wait').remove();
					$("#pelajaran_add").html(msg);	
				}
			});
		});*///Submit End
		
		$("select#pelajaran_add").change(function(e){
			$.ajax({
				type: "POST",
				data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&',
				url: '<?=base_url()?>admin/pelajaran/getKelasByPelajaranAndPegawai/'+$(this).val(),
				beforeSend: function() {
					$('select#kelas_add').after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
				},
				success: function(msg) {
					$('#wait').remove();
					$("#kelas_add").html(msg);	
				}
			});
			
			$.ajax({
				type: "POST",
				data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&',
				url: '<?=base_url()?>akademik/soalonline/getSoalonlineStok/'+$(this).val(),
				beforeSend: function() {
					$('select#kelas_add').after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
				},
				success: function(msg) {
					$('#wait').remove();
					$("#soalonline_add").html(msg);	
				}
			});
		});//Submit End
	});
</script>	


<script type="text/javascript">
function getadd(obj,date) {

}
$(function() {
	$('#datesoalonline').datepick();
	$('#date2soalonline').datepick();
});
</script>	
<div class="addaccount">
<form method="post" name="soalonline" enctype="multipart/form-data" id="soalonline" action="<? echo base_url();?>akademik/soalonline/kirimsoalonline">
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
	<div onclick="$('.addaccount').remove();" class="addaccountclose"></div>
		
		<h3>Kirim Soalonline</h3>
		<div class="hr"></div>
		<table class="adddata">
			<tbody>
			<tr>
				<th style="text-align:right;" colspan="3">
				<a onclick="$('#soalonline').submit();" id="simpanpr" class="button small light-grey absenbutton" title=""> Kirim </a>
				<a id="cancelsoalonline" class="button small light-grey absenbutton" title=""> Cancel </a>
				</th>
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
						<option <? //if(@$_POST['pelajaran']==$datapelajaran['id']){echo 'selected';}?> value="<?=$datapelajaran['id']?>"><?=$datapelajaran['nama']?> [Kelas <?=$datapelajaran['kelas']?>]</option>
						<? }} ?>
					</select>
				</td>
			</tr>
			<tr>
				<td class="title">Di Kirim ke Kelas</td>
				<td>:</td>
				<td>
					<select class="selectfilter" id="kelas_add" name="id_kelas[]" multiple>
						<option value="">Pilih Kelas</option>
						<? foreach($kelas as $datakelas){?>
						<option <? //if(@$_POST['kelas']==$datakelas['id']){echo 'selected';}?> value="<?=$datakelas['id']?>"><?=$datakelas['kelas']?><?=$datakelas['nama']?></option>
						<? } ?>
					</select>
				</td>
			</tr>
			<tr>
				<td class="title">Soalonline</td>
				<td>:</td>
				<td>
					<select class="selectfilter" id="soalonline_add" name="id_soalonline">
						<option value="">Pilih Soalonline</option>
						<? //foreach($soalonline as $datasoalonline){?>
						<option <? //if(@$_POST['kelas']==$datasoalonline['id']){echo 'selected';}?> value="<?//=$datasoalonline['id']?>"><?//=$datasoalonline['kelas']?><?//=$datasoalonline['nama']?></option>
						<? //} ?>
					</select>
				</td>
			</tr>
			<!--<tr>
				<td width="30%" class="title">Diberikan Tanggal</td>
				<td width="1">:</td>
				<td>
					<input type="text" name="tanggal_diberikan" style="width:100px;" value="<?=date('Y-m-d')?>" id="datesoalonline">
				</td>
			</tr>-->
			<tr>
				<td width="30%" class="title">Tanggal Diajarkan</td>
				<td width="1">:</td>
				<td>
					<input type="text" name="tanggal_diajarkan" style="width:100px;" value="" id="date2soalonline">
				</td>
			</tr>
			<tr>
				<td width="30%" class="title">Keterangan</td>
				<td width="1">:</td>
				<td colspan="2">
					<textarea name="keterangan" placeholder="Keterangan akan dikirim ke Orang Tua / Wali Siswa melalui SMS"></textarea>
				</td>
			</tr>
			<tr>
				<th style="text-align:right;" colspan="3">
				<a onclick="$('#soalonline').submit();" id="simpanpr" class="button small light-grey absenbutton" title=""> Kirim </a>
				<a id="cancelsoalonline" class="button small light-grey absenbutton" title=""> Cancel </a>
				</th>
			</tr>
		</tbody></table>

	<input type="hidden" value="1" name="ajax"> 

	<div style="display:none;" class="error-container"> Semua field yang merah harus di isi atau dipilih!  </div>
	</form>
</div>