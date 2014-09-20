								<script>
								$(document).ready(function(){
									
								});
								function getdetail(id,obj){
									$('#detailpr'+id).toggle('fade');
									$('table.prsiswalist div.comment').remove();
									$(obj).prev('tr').hide();
									$(obj).next('tr').next('tr').next('tr').hide();
									$.ajax({
										type: "GET",
										data: '',
										url: '<?=base_url()?>akademik/comment/index/'+id+'/first/pr',
										beforeSend: function() {
											//$("#filterpelajaranharian select#kelas").after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
											
										},
										success: function(msg) {
											//$("#wait").remove();
											$('#komentar'+id).html(msg);	
										}
									});
									return false;
								}
								</script>
							   <table class="prsiswalist">
										<thead>
											<tr> 
												<th>No</th>      
												<th>Judul</th>
												<th>Bab</th>
												<th>Jenis</th>
												<th>Waktu Dikumpulkan</th>
											</tr>                         
										</thead>
										<tbody>
											<? $nox=array();$no=1;foreach($pr as $kt=>$datapr){?>
											<tr style="cursor:pointer;" title="klik untuk menampilkan / menyembunyikan detail" onclick="getdetail(<?=$datapr['id']?>,this);">
												<td><?=$no++;?></td>
												<td class="title" ><?=$datapr['judul']?></td>
												<td class="title" ><?=$datapr['bab']?></td>
												<td ><?=$datapr['jenis']?></td>
												<td ><? $tg=tanggal($datapr['tanggal_kumpul']." 00:00:00"); echo $tg[2];?></td>
											</tr>
											<tr id="detailpr<?=$datapr['id']?>" style="display:none;">
												<td colspan="6" class="innercolspan">
													<div class="file" style="margin-top:0;">
													<h3 >File PR</h3>
													<div class="hr"></div>
													<table class="noborder">
														<?foreach($datapr['file'] as $file){?>
														<tr>
															<td class="title"><a title="<?=$file['file_name']?>" href="<?=base_url('homepage/send_download/'.base64_encode($file['file_name']).'');?>" target="_self"><?=substr($file['file_name'],-30)?></a></td>
														</tr>
														<? } ?>
													</table>
													</div>
													<div class="siswa">
													<h3 >Detail PR</h3>
													<div class="hr"></div>
													<table class="noborder">
														<tr>
															<td class="title">Judul PR</td>
															<td class="title">:</td>
															<td class="title"><?=$datapr['judul']?></td>
														</tr>
														<tr>
															<td class="title">Mata Pelajaran</td>
															<td class="title">:</td>
															<td class="title"><?=$datapr['nama_pelajaran']?></td>
														</tr>
														<tr>
															<td class="title">Kelas</td>
															<td class="title">:</td>
															<td class="title"><?=$datapr['kelas']?><?=$datapr['nama_kelas']?></td>
														</tr>
														<tr>
															<td class="title">BAB</td>
															<td class="title">:</td>
															<td class="title"><?=$datapr['bab']?></td>
														</tr>
														<tr>
															<td class="title">Guru</td>
															<td class="title">:</td>
															<td class="title"><?=$datapr['nama_guru']?></td>
														</tr>
														<tr>
															<td class="title">Jenis</td>
															<td class="title">:</td>
															<td class="title"><?=$datapr['jenis']?></td>
														</tr>
														<tr>
															<td class="title">Dikumpulkan Tanggal</td>
															<td class="title">:</td>
															<td class="title"><? $tg=tanggal($datapr['tanggal_kumpul']." 00:00:00"); echo $tg[2];?></td>
														</tr>
														<tr>
															<td class="title">Keterangan</td>
															<td class="title">:</td>
															<td class="title"><?=$datapr['keterangan']?></td>
														</tr>
													</table>
													</div>
													<? pengumpulan_akademik_siswa($datapr['id'],'pr',$datapr['id_kelas']);?>
																										
													<br class="clear" />
													<div id="komentar<?=$datapr['id']?>"></div>
													</div>
												</td>
											</tr>
											<? } ?>
										</tbody>
								</table>
