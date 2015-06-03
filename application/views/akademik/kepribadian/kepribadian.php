<script>
				$(document).ready(function(){
					//Submit Start
					$(".editdatakepribadian").click(function(e){
						$('#ajaxside').load('<?=base_url()?>admin/siswa/editdatakepribadian/'+$(this).attr('id'));
					});
					
					$("#kepribadianform select#kelas").change(function(e){
						$.ajax({
							type: "POST",
							data: $("form#kepribadianform").serialize(),
							url: '<?=base_url()?>akademik/kepribadian/getOptionSiswaByIdKelas/'+$(this).val(),
							beforeSend: function() {
								$("#kepribadianform select#kelas").after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
								//$("#subjectlistkepribadian table.tabelkelas tbody").html("");
							},
							success: function(msg) {
								$("#wait").remove();
								$("#siswakepribadian").html(msg);	
							}
						});
						return false;
					});//Submit End
					$("#kepribadianform select#siswakepribadian").change(function(e){
						$.ajax({
							type: "POST",
							data: $("form#kepribadianform").serialize(),
							url: '<?=base_url()?>akademik/kepribadian/kepribadianlist',
							beforeSend: function() {
								$("#kepribadianform select#siswakepribadian").after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
							},
							success: function(msg) {
								$("#wait").remove();
								$("#subjectlistkepribadian").html(msg);	
							}
						});
						return false;
					});//Submit End

				});

				</script>
			
				<h3>kepribadian</h3>
				<div class="hr"></div>
				
				<div id="contentpage">
							<form action="" method="post" id="kepribadianform" >
							<table class="tabelfilter">
								<tr>
								<td>
									Kelas :
										<select class="selectfilter" id="kelas" name="id_kelas">
											<option value="">Pilih Kelas</option>
											<? foreach($kelas as $datakelas){?>
											<option <? if(@$_POST['kelas']==$datakelas['id']){echo 'selected';}?> value="<?=$datakelas['id']?>"><?//=$datakelas['kelas']?><?=$datakelas['nama']?></option>
											<? } ?>
										</select>

									
									Siswa :
										<select class="selectfilter" id="siswakepribadian" name="id_siswa_det_jenjang">
											<option value="">Pilih Siswa</option>
										</select>
									
									</td>
								</tr>
							</table>
							<input type="hidden" name="ajax" value="1" />
							</form>
							<div id="subjectlistkepribadian">
								<?php //$this->load->view('akademik/kepribadian/daftarkepribadianlist'); ?>
							</div>
					</div>