			<script>
				$(document).ready(function(){
					//Submit Start
					$(".editdataprestasi").click(function(e){
						$('#ajaxside').load('<?=base_url()?>admin/siswa/editdataprestasi/'+$(this).attr('id'));
					});
					
					$("#prestasiform select#kelas").change(function(e){
						$.ajax({
							type: "POST",
							data: $("form#prestasiform").serialize(),
							url: '<?=base_url()?>akademik/prestasi/getOptionSiswaByIdKelas/'+$(this).val(),
							beforeSend: function() {
								$("#prestasiform select#kelas").after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
								//$("#subjectlist table.tabelkelas tbody").html("");
							},
							success: function(msg) {
								$("#wait").remove();
								$("#siswa").html(msg);	
							}
						});
						return false;
					});//Submit End
					$("#prestasiform select#siswa").change(function(e){
						$.ajax({
							type: "POST",
							data: $("form#prestasiform").serialize(),
							url: '<?=base_url()?>akademik/prestasi/prestasilist',
							beforeSend: function() {
								$("#prestasiform select#siswa").after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
							},
							success: function(msg) {
								$("#wait").remove();
								$("#subjectlist").html(msg);	
							}
						});
						return false;
					});//Submit End

				});

				</script>
				<h3>prestasi prestasi</h3>
				<div class="hr"></div>
				
				<div id="contentpage">
							<form action="" method="post" id="prestasiform" >
							<table class="tabelfilter">
								<tr>
								<td>
									Kelas :
										<select class="selectfilter" id="kelas" name="id_kelas">
											<option value="">Pilih Kelas</option>
											<? foreach($kelas as $datakelas){?>
											<option <? if(@$_POST['kelas']==$datakelas['id']){echo 'selected';}?> value="<?=$datakelas['id']?>"><?=$datakelas['kelas']?><?=$datakelas['nama']?></option>
											<? } ?>
										</select>

									
									Siswa :
										<select class="selectfilter" id="siswa" name="id_siswa_det_jenjang">
											<option value="">Pilih Siswa</option>
										</select>
									</td>
								</tr>
							</table>
							<input type="hidden" name="ajax" value="1" />
							</form>
							<div id="subjectlist">
								<?php //$this->load->view('akademik/prestasi/daftarprestasilist'); ?>
							</div>
					</div>