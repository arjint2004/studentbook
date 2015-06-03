<script>
				$(document).ready(function(){
					
					$("#filterpelajaranpembelajaran select#kelas<?=$_POST['idload']?>").change(function(e){
						<?if($_POST['idload']=='lainlain'){?>
							var untuknilai='&jenis=nilai+lain_lain&ajax=1&pelajaran=0';
						<? } ?>
						$.ajax({
							type: "POST",
							data: $("form#filterpelajaranpembelajaran").serialize()<?if($_POST['idload']=='lainlain'){?>+untuknilai<?}?>,
							url: '<?=$url?>',
							beforeSend: function() {
								$("#filterpelajaranpembelajaran select#kelas<?=$_POST['idload']?>").after("<img id='wait<?=$_POST['idload']?>' src='<?=$this->config->item('images').'loading.png';?>' />");
							},
							success: function(msg) {
								$("#wait<?=$_POST['idload']?>").remove();
								$("#subjectlist<?=$_POST['idload']?>").html(msg);	
								<?if($_POST['idload']=='lainlain'){?>
									$('div.actedit,div.actdell').remove();
								<? } ?>
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
											<option <? if(@$_POST['kelas']==$datakelas['id']){echo 'selected';}?> value="<?=$datakelas['id']?>"><?//=$datakelas['kelas']?><?=$datakelas['nama']?></option>
											<? } ?>
										</select>
									</td>
								</tr>
							</table>
							<input type="hidden" name="ajax" value="1" />
							</form>
							<div id="subjectlist<?=$_POST['idload']?>">
								<?php //$this->load->view('akademik/pembelajaran/daftarpembelajaranlist'); ?>
							</div>
					</div>