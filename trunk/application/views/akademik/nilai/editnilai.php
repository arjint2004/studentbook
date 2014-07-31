<script>
$(document).ready(function(){


		$("#subjectnilaieditaddnilai").each(function(){
			$container = $(this).next("div.error-container");
			//Validate Starts
			$(this).validate({
				onfocusout: function(element) {	$(element).valid();	},
				errorContainer: $container,
				rules:{
				  subject:{required:true,notEqual:''},
				  id_kelas:{required:true,notEqual:'Pilih Kelas'},
				  id_pelajaran:{required:true,notEqual:'Pilih Pelajaran'}
				  /*,message:{required:true,minlength:10}*/
				}
			});//Validate End

		});
	
//Submit Starts		   
		$(".addaccountclose").click(function(){
			$(".addaccount").remove();
		});
		$("#subjectnilaieditaddnilai").submit(function(e){
			$frm = $(this);
			$subject = $frm.find('*[name=subject]').val();
			$id_kelas = $frm.find('*[name=id_kelas]').val();
			$id_pelajaran = $frm.find('*[name=id_pelajaran]').val();
			if($frm.find('*[name=subject]').is('.valid') && $frm.find('*[name=id_kelas]').is('.valid') && $frm.find('*[name=id_pelajaran]').is('.valid')) {
				$.ajax({
					type: "POST",
					data: $(this).serialize()+'&'+$('form#nilai').serialize(),
					url: $(this).attr('action'),
					beforeSend: function() {
						$("#simpanabsensi").after("<img id='wait' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
					},
					success: function(msg) {
						$("#wait").remove();	
						$('#subjectnilai').load('<? echo base_url();?>akademik/nilai/listSubject/<?=base64_encode($jenis);?>');
						//$('#simpanabsensi').before('<div id="berhasil" style="float:left;">Simpan Berhasil</div>');
						//$('#berhasil').delay(10).fadeIn(500).delay(1000).fadeOut(500);
						//$('#berhasil').remove();
						//$("#simpanabsensi").show();	
					}
				});
				return false;
			}
			
			return false;
		});//Submit End
		$("#pelajaran_add").load('<?=base_url()?>admin/pelajaran/getMapelByKelasAndPegawai/<?=$_POST['kelas']?>/<?=$_POST['pelajaran']?>');	
		$.ajax({
				type: "POST",
				data: 'id_kelas=<?=$_POST['kelas']?>&id_pelajaran=<?=$_POST['pelajaran']?>&id_subject=<?=$_POST['id_subject']?>&jenis=<?=base64_encode($jenis);?>',
				url: '<?=base_url()?>akademik/nilai/edit',
				beforeSend: function() {
					$(this).after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
				},
				success: function(msg) {
					$('#wait').remove();
					$("#nilai").html(msg);	
				}
		});
		$("select#kelas_add").change(function(e){
			$.ajax({
				type: "POST",
				data: $("form#filterpelajaran").serialize(),
				url: '<?=base_url()?>admin/pelajaran/getMapelByKelasAndPegawai/'+$(this).val(),
				beforeSend: function() {
					$('select#kelas_add').after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
				},
				success: function(msg) {
					$('#wait').remove();
					$("#pelajaran_add").html(msg);	
				}
			});
			$.ajax({
				type: "POST",
				data: 'id_kelas='+$(this).val(),
				url: '<?=base_url()?>akademik/nilai/add',
				beforeSend: function() {
					$(this).after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
				},
				success: function(msg) {
					$('#wait').remove();
					$("#nilai").html(msg);	
				}
			});
			return false;
		});//Submit End
});
</script>
<div class="addaccount">
<form action="<? echo base_url();?>akademik/nilai/editnilai" id="subjectnilaieditaddnilai" name="subjectnilaieditaddnilai" method="post" >
	<div class="addaccountclose" onclick="$('.addaccount').remove();"></div>
		
		<h3>Tambah <?=$jenis?></h3>
		<div class="hr"></div>
		<table class="adddata">
			<tr>
				<th colspan="3" style="text-align:right;"><a title="" class="button small light-grey absenbutton" id="simpanabsensi" onclick="$('#subjectnilaieditaddnilai').submit();"> Simpan </a></th>
			</tr>
			<tr>
				<td class="title">Kelas</td>
				<td>:</td>
				<td>
					<select class="selectfilter" id="kelas_add" name="id_kelas">
						<option value="">Pilih Kelas</option>
						<? foreach($kelas as $datakelas){?>
						<option <? if(@$_POST['kelas']==$datakelas['id']){echo 'selected';}?> value="<?=$datakelas['id']?>"><?=$datakelas['kelas']?><?=$datakelas['nama']?></option>
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
						<? foreach($pelajaran as $datapelajaran){?>
						<option <? if(@$_POST['pelajaran']==$datapelajaran['id']){echo 'selected';}?> value="<?=$datapelajaran['id']?>"><?=$datapelajaran['nama']?></option>
						<? } ?>
						</select>
				</td>
			</tr>
			<tr>
				<td class="title">Remidial</td>
				<td>:</td>
				<td>
					<select class="selectfilter" id="remidial_add" name="remidial">
						<option <? if(@$_POST['remidial']=='non_remidial'){echo 'selected';}?> value="non_remidial">Non Remidial</option>
						<option <? if(@$_POST['remidial']=='remidial'){echo 'selected';}?> value="remidial">Remidial</option>
						
						</select>
				</td>
			</tr>
			<tr>
				<td width="30%" class='title'>Subject</td>
				<td width="1">:</td>
				<td><input <? if($subject[0]['id_referensi']!=0){echo "readonly";}?> type="text" name="subject" size="50" value="<?=$_POST['subject']?>"/></td>
			</tr>
			
		</table>

	<input type="hidden" name="jenis" value="<?=$jenis?>"/> 
	<input type="hidden" name="id_subject" value="<?=$_POST['id_subject']?>"/> 
	<input type="hidden" name="ajax" value="1"/> 

	<div class="error-container" style="display:none;"> Semua field harus di isi atau dipilih!  </div>
	</form>
</div>
<div id="nilai"></div>