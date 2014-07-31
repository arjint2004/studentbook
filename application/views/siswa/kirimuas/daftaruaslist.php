								<script>
								$(document).ready(function(){
									
								});
								function getdetail(id,obj){
									$('#detailuas'+id).toggle('fade');
									$('table.siswauaslist div.comment').remove();
									$(obj).prev('tr').hide();
									$(obj).next('tr').next('tr').next('tr').hide();
									$.ajax({
										type: "GET",
										data: '',
										url: '<?=base_url()?>akademik/comment/index/'+id+'/first/uas',
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
							   <table class="siswauaslist">
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
											<? $nox=array();$no=1;foreach($uas as $kt=>$datauas){?>
											<tr style="cursor:pointer;" title="klik untuk menampilkan / menyembunyikan detail" onclick="getdetail(<?=$datauas['id']?>,this);">
												<td><?=$no++;?></td>
												<td class="title" ><?=$datauas['judul']?></td>
												<td class="title" ><?=$datauas['bab']?></td>
												<td ><?=$datauas['jenis']?></td>
												<td ><? $tg=tanggal($datauas['tanggal_kumpul']." 00:00:00"); echo $tg[2];?></td>
											</tr>
											<tr id="detailuas<?=$datauas['id']?>" style="display:none;">
												<td colspan="6" class="innercolspan">
													<div class="file">
													<h3 >Detail Data UAS</h3> 
													<div class="hr"></div>
													<table class="noborder">
														<?foreach($datauas['file'] as $file){?>
														<tr>
															<td class="title"><a title="<?=$file['file_name']?>" href="<?=base_url('siswa/kirimuas/send_download/'.base64_encode($file['file_name']).'');?>" target="_self"><?=substr($file['file_name'],-30)?></a></td>
														</tr>
														<? } ?>
													</table>
													</div>
													<div class="siswa">
													<h3 >Detail UAS</h3>
													<div class="hr"></div>
													<table class="noborder">
														<tr>
															<td class="title">Judul UAS</td>
															<td class="title">:</td>
															<td class="title"><?=$datauas['judul']?></td>
														</tr>
														<tr>
															<td class="title">Mata Pelajaran</td>
															<td class="title">:</td>
															<td class="title"><?=$datauas['nama_pelajaran']?></td>
														</tr>
														<tr>
															<td class="title">Kelas</td>
															<td class="title">:</td>
															<td class="title"><?=$datauas['nama_kelas']?><?=$datauas['kelas']?></td>
														</tr>
														<tr>
															<td class="title">BAB</td>
															<td class="title">:</td>
															<td class="title"><?=$datauas['bab']?></td>
														</tr>
														<tr>
															<td class="title">Guru</td>
															<td class="title">:</td>
															<td class="title"><?=$datauas['nama_guru']?></td>
														</tr>
														<tr>
															<td class="title">Jenis</td>
															<td class="title">:</td>
															<td class="title"><?=$datauas['jenis']?></td>
														</tr>
														<tr>
															<td class="title">Dikumpulkan Tanggal</td>
															<td class="title">:</td>
															<td class="title"><? $tg=tanggal($datauas['tanggal_kumpul']." 00:00:00"); echo $tg[2];?></td>
														</tr> 
														<tr>
															<td class="title">Keterangan</td>
															<td class="title">:</td>
															<td class="title"><?=$datauas['keterangan']?></td>
														</tr>
													</table>
													</div>
													<? pengumpulan_akademik_siswa($datauas['id'],'uas',$datauas['id_kelas']);?>																																							
													<br class="clear" />
													<div id="komentar<?=$datauas['id']?>"></div>
													</div>
												</td>
											</tr>
											<? } ?>
										</tbody>
								</table>
