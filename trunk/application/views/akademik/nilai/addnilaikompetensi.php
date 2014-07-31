<script>
$(document).ready(function(){


		$("#subjectnilaikompetensi").each(function(){
			$container = $(this).next("div.error-container");
			//Validate Starts
			$(this).validate({
				onfocusout: function(element) {	$(element).valid();	},
				errorContainer: $container,
				rules:{
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
		$("#subjectnilaikompetensi").submit(function(e){
			$frm = $(this);
			$id_kelas = $frm.find('*[name=id_kelas]').val();
			$id_pelajaran = $frm.find('*[name=id_pelajaran]').val();
			if($frm.find('*[name=id_kelas]').is('.valid') && $frm.find('*[name=id_pelajaran]').is('.valid')) {
				$.ajax({
					type: "POST",
					data: $(this).serialize()+'&'+$('form#nilai').serialize()+'&id_referensi=0',
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
		
		$("select#pelajaran_add").change(function(e){
			$.ajax({
				type: "POST",
				data: $('#subjectnilaikompetensi').serialize()+'&jenis=<?=base64_encode($jenis);?>',
				url: '<?=base_url()?>akademik/nilai/add',
				beforeSend: function() {
					$("select#pelajaran_add").after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
				},
				success: function(msg) {
					$('#wait').remove();
					$("#nilai").html(msg);	
				}
			});
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
			return false;
		});//Submit End
});
</script>
<div class="addaccount">
<form action="<? echo base_url();?>akademik/nilai/addnilai" id="subjectnilaikompetensi" name="subjectnilaikompetensi" method="post" >
	<div class="addaccountclose" onclick="$('.addaccount').remove();"></div>
		
		<h3>Tambah <?=$jenis?></h3>
		<div class="hr"></div>
		<table class="adddata">
			<tr>
				<th colspan="3" style="text-align:right;"><a title="" class="button small light-grey absenbutton" id="simpanabsensi" onclick="$('#subjectnilaikompetensi').submit();"> Simpan </a></th>
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
			
			
		</table>

	<input type="hidden" name="jenis" value="<?=$jenis?>"/> 
	<input type="hidden" name="ajax" value="1"/> 
	<input type="hidden" name="subject" value="nilai kompetensi"/> 
	<input type="hidden" name="remidial" value=""/> 

	<div class="error-container" style="display:none;"> Semua field harus di isi atau dipilih!  </div>
	</form>
</div>
<div id="nilai"></div>