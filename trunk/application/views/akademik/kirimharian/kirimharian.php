<script>
	$(document).ready(function(){
		$("#harian").each(function(){
			$container = $(this).next("div.error-container");
			//Validate Starts
			$(this).validate({
				onfocusout: function(element) {	$(element).valid();	},
				errorContainer: $container,
				rules:{
				  id_kelas:{required:true,notEqual:'Pilih Kelas'},
				  id_pelajaran:{required:true,notEqual:'Pilih Pelajaran'},
				  id_harian:{required:true,notEqual:'Pilih harian'},
				  tanggal_kumpul:{required:true,notEqual:''}
				  /*,message:{required:true,minlength:10}*/
				}
			});//Validate End

		});
		$("table.adddata tr th a.cancelharian").click(function(){
				var obj=$(this);
				$.ajax({
					type: "POST",
					data: 'id_kelas='+$('select#kelasharian').val()+'&pelajaran='+$('select#pelajaranharian').val()+'&ajax=1',
					url: '<?=base_url('akademik/kirimharian/daftarharianlist')?>',
					beforeSend: function() {
						$('table.adddata tr th a.cancelharian').after("<img class='waitharian37' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
					},
					success: function(msg) {
						$(".waitharian37").remove();
						//$('select#kelas').val($('select#kelas_addharian').val());
						//$('select#pelajaran').html($('select#pelajaran_addharian').html());
						//$('select#pelajaran').val($('select#pelajaran_addharian').val());	
						$('#subjectlistharian').html(msg);
						$('#subject').scrollintoview({ speed:'1100'});
					}
				});
				return false;
		});
		//Submit Starts		   
		$(".addaccountclose").click(function(){
			$(".addaccount").remove();
		});
		$("#harian").submit(function(e){
			if($('select#kelas_addharian').val()==null){
				$('select#kelas_addharian').css('border','1px solid red');
				return false;
			}
			$frm = $(this);
			$id_pelajaran = $frm.find('*[name=id_pelajaran]').val();
			$id_harian = $frm.find('*[name=id_harian]').val();
			$tanggal_kumpul = $frm.find('*[name=tanggal_kumpul]').val();
			
			if($frm.find('*[name=id_pelajaran]').is('.valid') && $frm.find('*[name=id_harian]').is('.valid') && $frm.find('*[name=tanggal_kumpul]').is('.valid')) {
				$.ajax({
					type: "POST",
					data: $(this).serialize()+'&'+$('form#nilai').serialize(),
					url: $(this).attr('action'),
					beforeSend: function() {
						$("#simpanharian").after("<img id='wait' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
					},
					success: function(msg) {
						$("#wait").remove();	
						
					
						$.ajax({
							type: "POST",
							data: 'id_kelas='+$('select#kelas_addharian').val()+'&pelajaran='+$('select#pelajaran_addharian').val()+'&ajax=1',
							url: '<?=base_url('akademik/kirimharian/daftarharianlist')?>',
							beforeSend: function() {
								$("#simpanharian").after("<img class='waitharian37' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
								$("#simpanharianbottom").after("<img class='waitharian37' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
							},
							success: function(msg) {
								$(".waitharian37").remove();
								$.ajax({
										type: "POST",
										data: 'id_kelas='+$('select#kelasharian').val()+'&pelajaran='+$('select#pelajaranharian').val()+'&ajax=1',
										url: '<?=base_url()?>akademik/kirimharian/daftarharianlist',
										beforeSend: function() {
											$("#simpanharian").after("<img class='waitharian37' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
											$("#simpanharianbottom").after("<img class='waitharian37' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
										},
										success: function(msg) {
											$(".waitharian37").remove();
											$("#subjectlistharian").html(msg);	
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
		
		/*$("select#kelas_addharian").change(function(e){
			$.ajax({
				type: "POST",
				data: '',
				url: '<?=base_url()?>admin/pelajaran/getMapelByKelasAndPegawai/'+$(this).val(),
				beforeSend: function() {
					$('select#kelas_addharian').after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
				},
				success: function(msg) {
					$('#wait').remove();
					$("#pelajaran_addharian").html(msg);	
				}
			});
		});*///Submit End
		
		$("select#kelas_addharian").change(function(e){
			$("input.id_mengajarappear").remove();
			$("select#kelas_addharian option:selected").each(function(e){
				if($(this).attr('id_mengajar')!=undefined){
					$("select#kelas_addharian").parent('td').append('<input class="id_mengajarappear" type="hidden" name="id_mengajar[]" value="'+$(this).attr('id_mengajar')+'" />');
				}
			});
		});
		$("select#pelajaran_addharian").change(function(e){
			var obj=$(this);
			$.ajax({
				type: "POST",
				data: '',
				url: '<?=base_url()?>admin/pelajaran/getKelasByPelajaranAndPegawai/'+$(this).val(),
				beforeSend: function() {
					$('select#kelas_addharian').after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
				},
				success: function(msg) {
					$('#wait').remove();
					$("#kelas_addharian").html(msg);
					$.ajax({
						type: "POST",
						data: '',
						url: '<?=base_url()?>akademik/kirimharian/getharianStok/'+$(obj).val(),
						beforeSend: function() {
							$('select#kelas_addharian').after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
						},
						success: function(msg2) {
							$('#wait').remove();
							$("#harian_add").html(msg2);	
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
	$('#datekirimharianutama').datepick();
});
</script>	
<div class="addaccount">
<form method="post" name="harian" enctype="multipart/form-data" id="harian" action="<? echo base_url();?>akademik/kirimharian/kirimhariannya">
	<div onclick="$('.addaccount').remove();" class="addaccountclose"></div>
		
		<h3>Kirim harian</h3>
		<div class="hr"></div>
		<table class="adddata">
			<tbody>
			<tr>
				<th style="text-align:right;" colspan="3">
				<a onclick="$('#harian').submit();" id="simpanharian" class="button small light-grey absenbutton" title=""> Kirim </a>
				<a id="cancelharian" class="cancelharian button small light-grey absenbutton" title=""> Cancel </a>
				</th>
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
						<option <? //if(@$_POST['pelajaran']==$datapelajaran['id']){echo 'selected';}?> value="<?=$datapelajaran['id']?>"><?=$datapelajaran['nama']?> [Kelas <?=$datapelajaran['kelas']?>]</option>
						<? }} ?>
					</select>
				</td>
			</tr>
			<tr>
				<td class="title">Di Kirim ke Kelas</td>
				<td>:</td>
				<td>
					<select class="selectfilter" id="kelas_addharian" name="id_kelas[]" multiple>
						<option value="">Pilih Kelas</option>
						<? foreach($kelas as $datakelas){?>
						<option <? //if(@$_POST['kelas']==$datakelas['id']){echo 'selected';}?> value="<?=$datakelas['id']?>"><?=$datakelas['kelas']?><?=$datakelas['nama']?></option>
						<? } ?>
					</select>
				</td>
			</tr>
			<tr>
				<td class="title">harian</td>
				<td>:</td>
				<td>
					<select class="selectfilter" id="harian_add" name="id_harian">
						<option value="">Pilih harian</option>
						<? foreach($harian as $dataharian){?>
						<option <? //if(@$_POST['kelas']==$dataharian['id']){echo 'selected';}?> value="<?=$dataharian['id']?>"><?=$dataharian['kelas']?><?=$dataharian['nama']?></option>
						<? } ?>
					</select>
				</td>
			</tr>
			<tr>
				<td width="30%" class="title">Tanggal Dikumpulkan</td>
				<td width="1">:</td>
				<td colspan="2">
					<input type="text" name="tanggal_kumpul" style="width:100px;" value="" id="datekirimharianutama">
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
				<a onclick="$('#harian').submit();" id="simpanharianbottom" class="button small light-grey absenbutton" title=""> Kirim </a>
				<a id="cancelharian" class="cancelharian button small light-grey absenbutton" title=""> Cancel </a>
				</th>
			</tr>
		</tbody></table>

	<input type="hidden" value="1" name="ajax"> 

	<div style="display:none;" class="error-container"> Semua field yang merah harus di isi atau dipilih!  </div>
	</form>
</div>