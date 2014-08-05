								<script>
								$(document).ready(function(){
									//$('div#afektifindikatorload').load('<?=site_url('akademik/instrumen/afektif/'.$param.'')?>');
									$.ajax({
												type: "POST",
												data: 'id_det_jenjang='+$('select#afektifsiswa').val()+'&nama_siswa='+$('select#afektifsiswa').find(":selected").text(),
												url: '<?=site_url('akademik/instrumen/afektif/'.$param.'')?>',
												beforeSend: function() {
												$("select#afektifsiswa").after("<img id='wait' style='margin: 0px; float: right; position: relative; top: 24px;'  src='<?=$this->config->item('images').'loading.png';?>' />");
												},
												success: function(msg) {
													$('img#wait').remove();
													$('div#afektifindikatorload').html(msg);
													$('table tr td#rataafektif').html($('div#ratajml').html());
												}
									});
									$("#afektifsiswa").change(function(e){
										$.ajax({
													type: "POST",
													data: 'id_det_jenjang='+$(this).val()+'&nama_siswa='+$(this).find(":selected").text(),
													url: '<?=site_url('akademik/instrumen/afektif/'.$param.'')?>',
													beforeSend: function() {
													$("select#afektifsiswa").after("<img id='wait' style='margin: 0px; float: right; position: relative; top: 24px;'  src='<?=$this->config->item('images').'loading.png';?>' />");
													},
													success: function(msg) {
														$('img#wait').remove();
														$('div#afektifindikatorload').html(msg);
														$('table tr td#rataafektif').html($('div#ratajml').html());
														
													}
										});
									});
								});
								</script>	
								<form action="<?=base_url()?>akademik/instrumen/afektif/<?=$param?>" method="post" id="formindikator" style="width:700px;height:100%;">
								<table class="left">
									<tbody>
										<tr>
											<th colspan="2" style="text-align:center;">
												<b>INDIKATOR PENILAIAN AFEKTIF<br />
											</th>
										</tr>
										<tr>
											<td width="20%"><b>NAMA SISWA</b></td>
											<td>
												<select name="id_det_jenjang" id="afektifsiswa" style="width:95%;">
													<? foreach($siswa as $datasis){?>
													<option value="<?=$datasis['id_siswa_det_jenjang']?>"><?=$datasis['nama']?></option>
													<? } ?>
												</select>
											</td>
										</tr>
										<tr>
											<td width="20%"><b>KELAS</b></td>
											<td><input type="hidden" name="id_kelas" value="<?=$id_kelas?>" /><?=$kelas?></td>
										</tr>
										<tr>
											<td><b>MATA PELAJARAN</b></td>
											<td><input type="hidden" name="id_pelajaran" value="<?=$id_pelajaran?>" /><input type="hidden" name="id_mengjar" value="<?=$id_mengjar?>" />
												<? if(isset($_POST['id_pelajaran'])){echo '<input type="hidden" name="id_pelajaranx" value="'.$_POST['id_pelajaran'].'" />';}?>
												<?=$pelajaran[0]['nama']?>
											</td>
										</tr>
										<tr>
											<td><b>EVALUASI</b></td>
											<td>Ke <?=$evaluasi_ke?></td>
										</tr>
										<tr>
											<td><b>GURU PENGAJAR</b></td>
											<td>Bpk/Ibu Guru<?=$this->session->userdata['user_authentication']['nama']?></td>
										</tr>
										<tr>
											<td><b>RATA-RATA / SCOR</b></td>
											<td id="rataafektif"></td>
										</tr>
									</tbody>
								</table>
								<div id="afektifindikatorload"></div>
								</form>