<script>
				$(document).ready(function(){
					
					$("#filterpelajaranpembelajaran select#kelas<?=$_POST['idload']?>").change(function(e){

						$.ajax({
							type: "POST",
							data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&'+$("form#filterpelajaranpembelajaran").serialize(),
							url: '<?=$url?>',
							beforeSend: function() {
								$("#filterpelajaranpembelajaran select#kelas<?=$_POST['idload']?>").after("<img id='wait<?=$_POST['idload']?>' src='<?=$this->config->item('images').'loading.png';?>' />");
							},
							success: function(msg) {
								$("#wait<?=$_POST['idload']?>").remove();
								$("#subjectlist<?=$_POST['idload']?>").html(msg);
								$("div#subjectlistkegiatanx table tr th a#simpannilaiekstra").parent('th').parent('tr').remove();
								$("textarea.textnilaikegiatan").attr('disabled', 'disabled');
							}
						});
						return false;
					});//Submit End
				});

				</script>

				<div id="contentpage">
							<form action="" method="post" id="filterpelajaranpembelajaran" >
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
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
									</td>
								</tr>
							</table>
							<input type="hidden" name="ajax" value="1" />
							</form>
							<div id="subjectlist<?=$_POST['idload']?>">
								<?php //$this->load->view('akademik/pembelajaran/daftarpembelajaranlist'); ?>
							</div>
					</div>