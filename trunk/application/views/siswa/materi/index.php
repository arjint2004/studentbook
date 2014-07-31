<script>
				$(document).ready(function(){
					//Submit Start
					$(".editdatamateri").click(function(e){
						$('#ajaxside').load('<?=base_url()?>admin/pelajaran/editdatamateri/'+$(this).attr('id'));
					});
					
						$.ajax({
							type: "POST",
							data: $("form#filterpelajaranmateri").serialize()+'&id_kelas=<?=$siswa[0]['id_kelas_siswa_det_jenjang']?>',
							url: '<?=base_url()?>admin/pelajaran/getmapelByKelas/<?=$siswa[0]['id_kelas_siswa_det_jenjang']?>',
							beforeSend: function() {
								$("#filterpelajaranmateri select#kelas").after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
								$("#subjectlist table.tabelkelas tbody").html("");
							},
							success: function(msg) {
								$("#wait").remove();
								$("#pelajaran").html(msg);	
							}
						});
					$("#filterpelajaranmateri select#pelajaran").change(function(e){
						$.ajax({
							type: "POST",
							data: $("form#filterpelajaranmateri").serialize()+'&id_kelas=<?=$siswa[0]['id_kelas_siswa_det_jenjang']?>',
							url: '<?=base_url()?>siswa/materi/daftarmaterilist',
							beforeSend: function() {
								$("#filterpelajaranmateri select#pelajaran").after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
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
							data: $("form#filterpelajaranmateri").serialize()+'&id_kelas=<?=$siswa[0]['id_kelas_siswa_det_jenjang']?>',
							url: '<?=base_url()?>siswa/materi/daftarmaterilist',
							beforeSend: function() {
								$("#filterpelajaranmateri select#pelajaran").after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
							},
							success: function(msg) {
								$("#wait").remove();
								$("#subjectlist").html(msg);	
							}
						});
				
				});

				</script>
<h3>Materi Pelajaran</h3>
				<div class="hr"></div>
				
				<div id="contentpage">
							<form action="" method="post" id="filterpelajaranmateri" >
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
								<?php //$this->load->view('siswa/materi/daftarmaterilist'); ?>
							</div>
					</div>