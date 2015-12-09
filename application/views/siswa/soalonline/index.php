<script>
				$(document).ready(function(){
					//Submit Start
					$(".editdatasoalonline").click(function(e){
						$('#ajaxside').load('<?=base_url()?>admin/pelajaran/editdatasoalonline/'+$(this).attr('id'));
					});
					
						$.ajax({
							type: "POST",
							data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&'+$("form#filterpelajaransoalonline").serialize()+'&id_kelas=<?=$siswa[0]['id_kelas_siswa_det_jenjang']?>',
							url: '<?=base_url()?>admin/pelajaran/getmapelByKelas/<?=$siswa[0]['id_kelas_siswa_det_jenjang']?>',
							beforeSend: function() {
								$("#filterpelajaransoalonline select#kelas").after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
								$("#subjectlist table.tabelkelas tbody").html("");
							},
							success: function(msg) {
								$("#wait").remove();
								$("#pelajaran").html(msg);	
							}
						});
					$("#filterpelajaransoalonline select#pelajaran").change(function(e){
						$.ajax({
							type: "POST",
							data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&'+$("form#filterpelajaransoalonline").serialize()+'&id_kelas=<?=$siswa[0]['id_kelas_siswa_det_jenjang']?>',
							url: '<?=base_url()?>siswa/soalonline/daftarsoalonlinelist',
							beforeSend: function() {
								$("#filterpelajaransoalonline select#pelajaran").after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
							},
							success: function(msg) {
								$("#wait").remove();
								$("#subjectlist").html(msg);	
							}
						});
						return false;
					});//Submit End
					$.ajax({
							type: "POST",
							data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&'+$("form#filterpelajaransoalonline").serialize()+'&id_kelas=<?=$siswa[0]['id_kelas_siswa_det_jenjang']?>',
							url: '<?=base_url()?>siswa/soalonline/daftarsoalonlinelist',
							beforeSend: function() {
								$("#filterpelajaransoalonline select#pelajaran").after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
							},
							success: function(msg) {
								$("#wait").remove();
								$("#subjectlist").html(msg);	
							}
						});
				
				});

				</script>
<h3>Soalonline Pelajaran</h3>
				<div class="hr"></div>
				
				<div id="contentpage">
							<form action="" method="post" id="filterpelajaransoalonline" >
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
							<table class="tabelfilter">
								<tr>
								<td>
									Pelajaran :
										<select class="selectfilter" id="pelajaran" name="pelajaran">
											<option value="">Pilih Pelajaran</option>
											<? foreach($pelajaran as $datapelajaran){?>
											<option <? if(@$_POST['pelajaran']==$datapelajaran['id']){echo 'selected';}?> value="<?=$datapelajaran['id']?>"><?=$datapelajaran['nama']?></option>
											<? } ?>
										</select>
									</td>
								</tr>
							</table>
							<input type="hidden" name="ajax" value="1" />
							</form>
							<div id="subjectlist">
								<?php //$this->load->view('siswa/soalonline/daftarsoalonlinelist'); ?>
							</div>
					</div>