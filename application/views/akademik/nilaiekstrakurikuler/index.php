			<script>
				$(document).ready(function(){
					$("#nilaiextraform select#kelas").change(function(e){
						$.ajax({
							type: "POST",
							data: 'id_ekstra='+$('select#ekstra').val()+'&id_kelas='+$(this).val(),
							url: '<?=base_url()?>akademik/nilaiekstrakurikuler/nilaiekstralist/'+$('select#ekstra').val()+'/'+$(this).val(),
							beforeSend: function() {
								$("#nilaiextraform select#kelas").after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
								//$("#subjectlistextrax table.tabelekstra tbody").html("");
							},
							success: function(msg) {
								$("#wait").remove();
								$("#subjectlistextrax").html(msg);	
							}
						});
						return false;
					});//Submit End
					
					$("#nilaiextraform").submit(function(e){
						$.ajax({
								type: "POST",
								data: $(this).serialize(),
								url: $(this).attr('action'),
								beforeSend: function() {
									$("#simpannilaiekstra").after("<img id='wait' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
								},
								success: function(msg) {
									$("#wait").remove();	
									$.ajax({
										type: "POST",
										data: 'id_ekstra='+$('select#ekstra').val()+'&id_kelas='+$('select#kelas').val(),
										url: '<?=base_url()?>akademik/nilaiekstrakurikuler/nilaiekstralist/'+$('select#ekstra').val()+'/'+$('select#kelas').val(),
										beforeSend: function() {
											$("#nilaiextraform select#ekstra").after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
											//$("#subjectlistextrax table.tabelekstra tbody").html("");
										},
										success: function(msg) {
											$("#wait").remove();
											$("#subjectlistextrax").html(msg);	
										}
									});
									return false;
								}
						});
							return false;
						});
					});

				</script>
				<h3 id="namanilai">nilai pengembangan diri</h3>
				<div class="hr"></div>
				<div id="contentpage">
							<form  method="post" action="<?=base_url()?>akademik/nilaiekstrakurikuler/nilaiekstralist" id="nilaiextraform" >
							<table class="tabelfilter">
								<tr>
								<td>
									Pilih Kegiatan :
										<select class="selectfilter" id="ekstra" name="id_ekstra">
											<option value="0">Pilih Kegiatan</option>
											<? foreach($ekstra as $dataekstra){?>
											<option <? if(@$_POST['ekstra']==$dataekstra['id']){echo 'selected';}?> value="<?=$dataekstra['id']?>"><?=$dataekstra['ekstra']?><?=$dataekstra['nama']?></option>
											<? } ?>
										</select>
										
									Pilih Kelas :
										<select class="selectfilter" id="kelas" name="id_kelas">
											<option value="0">Pilih Kelas</option>
											<? foreach($kelas as $datakelas){?>
											<option <? if(@$_POST['kelas']==$datakelas['id']){echo 'selected';}?> value="<?=$datakelas['id']?>"><?=$datakelas['kelas']?><?=$datakelas['nama']?></option>
											<? } ?>
										</select>
									</td>
								</tr>
							</table>
							<input type="hidden" name="ajax" value="1" />
							<div id="subjectlistextrax">
								
							</div>
							</form>
					</div>