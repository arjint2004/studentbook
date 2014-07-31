<script>
	$(document).ready(function(){
		$("#uts").each(function(){
			$container = $(this).next("div.error-container");
			//Validate Starts
			$(this).validate({
				onfocusout: function(element) {	$(element).valid();	},
				errorContainer: $container,
				rules:{
				  id_kelas:{required:true,notEqual:'Pilih Kelas'},
				  id_pelajaran:{required:true,notEqual:'Pilih Pelajaran'},
				  id_uts:{required:true,notEqual:'Pilih uts'},
				  tanggal_kumpul:{required:true,notEqual:''}
				  /*,message:{required:true,minlength:10}*/
				}
			});//Validate End

		});
		$("table.adddata tr th a.canceluts").click(function(){
				var obj=$(this);
				$.ajax({
					type: "POST",
					data: 'id_kelas='+$('select#kelasuts').val()+'&pelajaran='+$('select#pelajaranuts').val()+'&ajax=1',
					url: '<?=base_url('akademik/kirimuts/daftarutslist')?>',
					beforeSend: function() {
						$('table.adddata tr th a.canceluts').after("<img class='waituts37' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
					},
					success: function(msg) {
						$(".waituts37").remove();
						//$('select#kelas').val($('select#kelas_adduts').val());
						//$('select#pelajaran').html($('select#pelajaran_adduts').html());
						//$('select#pelajaran').val($('select#pelajaran_adduts').val());	
						$('#subjectlistuts').html(msg);
						$('#subject').scrollintoview({ speed:'1100'});
					}
				});
				return false;
		});
		//Submit Starts		   
		$(".addaccountclose").click(function(){
			$(".addaccount").remove();
		});
		$("#uts").submit(function(e){
			if($('select#kelas_adduts').val()==null){
				$('select#kelas_adduts').css('border','1px solid red');
				return false;
			}
			$frm = $(this);
			$id_pelajaran = $frm.find('*[name=id_pelajaran]').val();
			$id_uts = $frm.find('*[name=id_uts]').val();
			$tanggal_kumpul = $frm.find('*[name=tanggal_kumpul]').val();
			
			if($frm.find('*[name=id_pelajaran]').is('.valid') && $frm.find('*[name=id_uts]').is('.valid') && $frm.find('*[name=tanggal_kumpul]').is('.valid')) {
				$.ajax({
					type: "POST",
					data: $(this).serialize()+'&'+$('form#nilai').serialize(),
					url: $(this).attr('action'),
					beforeSend: function() {
						$("#simpanuts").after("<img id='wait' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
					},
					success: function(msg) {
						$("#wait").remove();	
						
					
						$.ajax({
							type: "POST",
							data: 'id_kelas='+$('select#kelas_adduts').val()+'&pelajaran='+$('select#pelajaran_adduts').val()+'&ajax=1',
							url: '<?=base_url('akademik/kirimuts/daftarutslist')?>',
							beforeSend: function() {
								$("#simpanuts").after("<img class='waituts37' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
								$("#simpanutsbottom").after("<img class='waituts37' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
							},
							success: function(msg) {
								$(".waituts37").remove();
								$.ajax({
										type: "POST",
										data: 'id_kelas='+$('select#kelasuts').val()+'&pelajaran='+$('select#pelajaranuts').val()+'&ajax=1',
										url: '<?=base_url()?>akademik/kirimuts/daftarutslist',
										beforeSend: function() {
											$("#simpanuts").after("<img class='waituts37' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
											$("#simpanutsbottom").after("<img class='waituts37' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
										},
										success: function(msg) {
											$(".waituts37").remove();
											$("#subjectlistuts").html(msg);	
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
		
		/*$("select#kelas_adduts").change(function(e){
			$.ajax({
				type: "POST",
				data: '',
				url: '<?=base_url()?>admin/pelajaran/getMapelByKelasAndPegawai/'+$(this).val(),
				beforeSend: function() {
					$('select#kelas_adduts').after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
				},
				success: function(msg) {
					$('#wait').remove();
					$("#pelajaran_adduts").html(msg);	
				}
			});
		});*///Submit End
		
		$("select#kelas_adduts").change(function(e){
			$("input.id_mengajarappear").remove();
			$("select#kelas_adduts option:selected").each(function(e){
				if($(this).attr('id_mengajar')!=undefined){
					$("select#kelas_adduts").parent('td').append('<input class="id_mengajarappear" type="hidden" name="id_mengajar[]" value="'+$(this).attr('id_mengajar')+'" />');
				}
			});
		});
		$("select#pelajaran_adduts").change(function(e){
			var obj=$(this);
			$.ajax({
				type: "POST",
				data: '',
				url: '<?=base_url()?>admin/pelajaran/getKelasByPelajaranAndPegawai/'+$(this).val(),
				beforeSend: function() {
					$('select#kelas_adduts').after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
				},
				success: function(msg) {
					$('#wait').remove();
					$("#kelas_adduts").html(msg);
					$.ajax({
						type: "POST",
						data: '',
						url: '<?=base_url()?>akademik/kirimuts/getutsStok/'+$(obj).val(),
						beforeSend: function() {
							$('select#kelas_adduts').after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
						},
						success: function(msg2) {
							$('#wait').remove();
							$("#uts_add").html(msg2);	
						}
					});					
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
	$('#datekirimutsutama').datepick();
});
</script>	
<div class="addaccount">
<form method="post" name="uts" enctype="multipart/form-data" id="uts" action="<? echo base_url();?>akademik/kirimuts/kirimutsnya">
	<div onclick="$('.addaccount').remove();" class="addaccountclose"></div>
		
		<h3>Kirim uts</h3>
		<div class="hr"></div>
		<table class="adddata">
			<tbody>
			<tr>
				<th style="text-align:right;" colspan="3">
				<a onclick="$('#uts').submit();" id="simpanuts" class="button small light-grey absenbutton" title=""> Kirim </a>
				<a id="canceluts" class="canceluts button small light-grey absenbutton" title=""> Cancel </a>
				</th>
			</tr>
			<tr>
				<td class="title">Pelajaran</td>
				<td>:</td>
				<td>
					<select class="selectfilter" id="pelajaran_adduts" name="id_pelajaran">
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
					<select class="selectfilter" id="kelas_adduts" name="id_kelas[]" multiple>
						<option value="">Pilih Kelas</option>
						<? foreach($kelas as $datakelas){?>
						<option <? //if(@$_POST['kelas']==$datakelas['id']){echo 'selected';}?> value="<?=$datakelas['id']?>"><?=$datakelas['kelas']?><?=$datakelas['nama']?></option>
						<? } ?>
					</select>
				</td>
			</tr>
			<tr>
				<td class="title">uts</td>
				<td>:</td>
				<td>
					<select class="selectfilter" id="uts_add" name="id_uts">
						<option value="">Pilih uts</option>
						<? foreach($uts as $datauts){?>
						<option <? //if(@$_POST['kelas']==$datauts['id']){echo 'selected';}?> value="<?=$datauts['id']?>"><?=$datauts['kelas']?><?=$datauts['nama']?></option>
						<? } ?>
					</select>
				</td>
			</tr>
			<tr>
				<td width="30%" class="title">Tanggal Dikumpulkan</td>
				<td width="1">:</td>
				<td colspan="2">
					<input type="text" name="tanggal_kumpul" style="width:100px;" value="" id="datekirimutsutama">
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
				<a onclick="$('#uts').submit();" id="simpanutsbottom" class="button small light-grey absenbutton" title=""> Kirim </a>
				<a id="canceluts" class="canceluts button small light-grey absenbutton" title=""> Cancel </a>
				</th>
			</tr>
		</tbody></table>

	<input type="hidden" value="1" name="ajax"> 

	<div style="display:none;" class="error-container"> Semua field yang merah harus di isi atau dipilih!  </div>
	</form>
</div>