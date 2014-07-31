				<script>
				$(document).ready(function(){
					//Submit Start
					$(".editdatauts").click(function(e){
						$('#ajaxside').load('<?=base_url()?>admin/pelajaran/editdatauts/'+$(this).attr('id'));
					});
					
						$.ajax({
							type: "POST",
							data: $("form#filterpelajaranuts").serialize()+'&id_kelas=<?=$siswa[0]['id_kelas_siswa_det_jenjang']?>',
							url: '<?=base_url()?>admin/pelajaran/getmapelByKelas/<?=$siswa[0]['id_kelas_siswa_det_jenjang']?>',
							beforeSend: function() {
								$("#filterpelajaranuts select#kelas").after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
								$("#subjectlist table.tabelkelas tbody").html("");
							},
							success: function(msg) {
								$("#wait").remove();
								$("#pelajaran").html(msg);	
							}
						});
					$("#filterpelajaranuts select#pelajaran").change(function(e){
						$.ajax({
							type: "POST",
							data: $("form#filterpelajaranuts").serialize()+'&id_kelas=<?=$siswa[0]['id_kelas_siswa_det_jenjang']?>',
							url: '<?=base_url()?>siswa/kirimuts/daftarutslist',
							beforeSend: function() {
								$("#filterpelajaranuts select#pelajaran").after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
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
							data: $("form#filterpelajaranuts").serialize()+'&id_kelas=<?=$siswa[0]['id_kelas_siswa_det_jenjang']?>',
							url: '<?=base_url()?>siswa/kirimuts/daftarutslist',
							beforeSend: function() {
								$("#filterpelajaranuts select#pelajaran").after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
							},
							success: function(msg) {
								$("#wait").remove();
								$("#subjectlist").html(msg);	
							}
						});
				
				});

				</script>
				<h3>Daftar uts</h3>
				<div class="hr"></div>
				
				<div id="contentpage">
							<form action="" method="post" id="filterpelajaranuts" >
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
								<?php $this->load->view('siswa/kirimuts/daftarutslist'); ?>
							</div>
					</div>
