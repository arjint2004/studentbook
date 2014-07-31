			<script>
				$(document).ready(function(){
					$("#nilaikegiatanform select#kelas").change(function(e){
						$.ajax({
							type: "POST",
							data: 'id_kelas='+$(this).val(),
							url: '<?=base_url()?>akademik/nilaikegiatansekolah/nilaiekstralist/'+$(this).val(),
							beforeSend: function() {
								$("#nilaikegiatanform select#kelas").after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
								//$("#subjectlist table.tabelkelas tbody").html("");
							},
							success: function(msg) {
								$("#wait").remove();
								$("#subjectlistkegiatan").html(msg);	
							}
						});
						return false;
					});//Submit End
					
					$("#nilaikegiatanform").submit(function(e){
						$.ajax({
								type: "POST",
								data: $(this).serialize(),
								url: $(this).attr('action'),
								beforeSend: function() {
									$("#simpannilaiekstra").after("<img id='wait' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
									$("#simpannilaiekstra2").after("<img id='wait2' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
								},
								success: function(msg) {
									$("#wait").remove();	
									$("#wait2").remove();	
									$.ajax({
										type: "POST",
										data: 'id_kelas='+$('select#kelas').val(),
										url: '<?=base_url()?>akademik/nilaikegiatansekolah/nilaiekstralist/'+$('select#kelas').val(),
										beforeSend: function() {
											$("#nilaikegiatanform select#kelas").after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
											//$("#subjectlist table.tabelkelas tbody").html("");
										},
										success: function(msg) {
											$("#wait").remove();
											$("#subjectlist").html(msg);	
										}
									});
									return false;
								}
						});
							return false;
						});
					});

				</script>

				<div id="contentpage">
							<form  method="post" action="<?=base_url()?>akademik/nilaikegiatansekolah/nilaiekstralist" id="nilaikegiatanform" >
							<table class="tabelfilter">
								<tr>
								<td>
									Kelas :
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
							
							<div id="subjectlistkegiatan">
								
							</div>
							</form>
					</div>