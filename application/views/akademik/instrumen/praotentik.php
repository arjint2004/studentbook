								<script>
								$(document).ready(function(){
									//$('div#otentikindikatorload').load('<?=site_url('akademik/instrumen/otentik/'.$param.'')?>');
									$.ajax({
												type: "POST",
												data: 'id_det_jenjang='+$('select#otentiksiswa').val()+'&nama_siswa='+$('select#otentiksiswa').find(":selected").text(),
												url: '<?=site_url('akademik/instrumen/otentik/'.$param.'')?>',
												beforeSend: function() {
												$("select#otentiksiswa").after("<img id='wait' style='margin: 0px; float: right; position: relative; top: 24px;'  src='<?=$this->config->item('images').'loading.png';?>' />");
												},
												success: function(msg) {
													$('img#wait').remove();
													$('div#otentikindikatorload').html(msg);
													//$('table tr td#rataotentik').html($('div#ratajml').html());
												}
									});
									$("#otentiksiswa").change(function(e){
										$.ajax({
													type: "POST",
													data: 'id_det_jenjang='+$(this).val()+'&nama_siswa='+$(this).find(":selected").text(),
													url: '<?=site_url('akademik/instrumen/otentik/'.$param.'')?>',
													beforeSend: function() {
													$("select#otentiksiswa").after("<img id='wait' style='margin: 0px; float: right; position: relative; top: 24px;'  src='<?=$this->config->item('images').'loading.png';?>' />");
													},
													success: function(msg) {
														$('img#wait').remove();
														$('div#otentikindikatorload').html(msg);
														//$('table tr td#rataotentik').html($('div#ratajml').html());
														
													}
										});
									});
									var winwidth=(90/100)*parseInt($(window).width());
									$('form#formindikator').css('width',winwidth+'px');
								});
								</script>	
								<form action="<?=base_url()?>akademik/instrumen/otentik/<?=$param?>" method="post" id="formindikator" style="width:900px;height:100%;">
								<table class="left">
									<tbody>
										<tr>
											<th colspan="2" style="text-align:center;">
												<b>INDIKATOR PENILAIAN <?=strtoupper($jenis)?><br />
											</th>
										</tr>
										<tr>
											<td width="20%"><b>NAMA SISWA</b></td>
											<td>
												<select name="id_det_jenjang" id="otentiksiswa" style="width:95%;">
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
											<td><?=$this->session->userdata['user_authentication']['nama']?></td>
										</tr>
										<!--<tr>
											<td><b>RATA-RATA / SCOR</b></td>
											<td id="rataotentik"></td>
										</tr>-->
									</tbody>
								</table>
								<div id="otentikindikatorload"></div>
								</form>