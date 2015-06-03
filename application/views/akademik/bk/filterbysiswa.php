<script>
				function getdisabled(){
							$("table#data tr th.action").remove();
							$("table#data tr td.action").remove();
							$("table#point tr td input.poin[type='text']").prop('disabled', true);
							$("table#data tr td textarea.kepribadianket").prop('disabled', true);
							$("a#simpancatatan").parent('th').parent('tr').remove();
				}
				$(document).ready(function(){

					$("#filterpelajaranpembelajaran select#kelas<?=$_POST['idload']?>").change(function(e){
						$.ajax({
							type: "POST",
							data: $("form#filterpelajaranpembelajaran").serialize(),
							url: '<?=base_url()?>akademik/catatanguru/getOptionSiswaByIdKelas/'+$(this).val(),
							beforeSend: function() {
								$("#filterpelajaranpembelajaran select#kelas<?=$_POST['idload']?>").after("<img id='wait<?=$_POST['idload']?>' src='<?=$this->config->item('images').'loading.png';?>' />");
								$("#subjectlist table.tabelkelas tbody").html("");
							},
							success: function(msg) {
								$("#wait<?=$_POST['idload']?>").remove();
								$("#siswa<?=$_POST['idload']?>").html(msg);	
							}
						});
						
						return false;
					});//Submit End
					$("#filterpelajaranpembelajaran select#siswa<?=$_POST['idload']?>").change(function(e){
						$.ajax({
							type: "POST",
							data: $("form#filterpelajaranpembelajaran").serialize(),
							url: '<?=$url?>',
							beforeSend: function() {
								$("#filterpelajaranpembelajaran select#siswa<?=$_POST['idload']?>").after("<img id='wait<?=$_POST['idload']?>' src='<?=$this->config->item('images').'loading.png';?>' />");
							},
							success: function(msg) {
								$("#wait<?=$_POST['idload']?>").remove();
								$("#subjectlistbysiswabk").html(msg);	
								<? //if($_POST['idload']=='kepribadian'){?>
									//$('span.arrow-n').remove();
									//$('span.arrow-s').remove();
									//getdisabled();
								<?// } ?>
								
							}
						});
						return false;
					});//Submit End
				});

				</script>

				<div id="contentpage">
							<form action="" method="post" id="filterpelajaranpembelajaran" >
							<table class="tabelfilter">
								<tr>
								<td>
									Kelas :
										<select class="selectfilter" id="kelas<?=$_POST['idload']?>" name="id_kelas">
											<option value="">Pilih Kelas</option>
											<? foreach($kelas as $datakelas){?>
											<option <? if(@$_POST['kelas']==$datakelas['id']){echo 'selected';}?> value="<?=$datakelas['id']?>"><?=$datakelas['kelas']?><?=$datakelas['nama']?></option>
											<? } ?>
										</select>

									
									Siswa :
										<select class="selectfilter" id="siswa<?=$_POST['idload']?>" style="width:240px;" name="id_siswa_det_jenjang">
											<option value="">Pilih Siswa</option>
										</select>
										
									</td>
								</tr>
							</table>
							<input type="hidden" name="ajax" value="1" />
							</form>
							<div id="subjectlistbysiswabk">
								<?php //$this->load->view('akademik/pembelajaran/daftarpembelajaranlist'); ?>
							</div>
					</div>