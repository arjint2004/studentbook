								<script>
								$(document).ready(function(){
									
								});
								function getdetail(id,obj){
									$('#detailharian'+id).toggle('fade');
									$('table.hariansiswalist div.comment').remove();
									$(obj).prev('tr').hide();
									$(obj).next('tr').next('tr').next('tr').hide();
									$.ajax({
										type: "GET",
										data: '',
										url: '<?=base_url()?>akademik/comment/index/'+id+'/first/harian',
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
							   <table class="hariansiswalist">
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
											<? $nox=array();$no=1;foreach($harian as $kt=>$dataharian){?>
											<tr style="cursor:pointer;" title="klik untuk menampilkan / menyembunyikan detail"  onclick="getdetail(<?=$dataharian['id']?>,this);">
												<td><?=$no++;?></td>
												<td class="title" ><?=$dataharian['judul']?></td>
												<td class="title" ><?=$dataharian['bab']?></td>
												<td ><?=$dataharian['jenis']?></td>
												<td ><? $tg=tanggal($dataharian['tanggal_kumpul']." 00:00:00"); echo $tg[2];?></td>
												
											</tr>
											<tr id="detailharian<?=$dataharian['id']?>" style="display:none;">
												<td colspan="6" class="innercolspan">
													<div class="file">
													<h3 >Detail Data Ulangan Harian</h3>
													<div class="hr"></div>
													<table class="noborder">
														<?foreach($dataharian['file'] as $file){?>
														<tr>
															<td class="title"><a title="<?=$file['file_name']?>" href="<?=base_url('siswa/kirimpr/send_download/'.base64_encode($file['file_name']).'');?>" target="_self"><?=substr($file['file_name'],-30)?></a></td>
														</tr>
														<? } ?>
													</table>
													</div>
													<div class="siswa">
													<h3 >Detail Ulangan Harian</h3>
													<div class="hr"></div>
													<table class="noborder">
														<tr>
															<td class="title">Judul Ulangan Harian</td>
															<td class="title">:</td>
															<td class="title"><?=$dataharian['judul']?></td>
														</tr>
														<tr>
															<td class="title">Mata Pelajaran</td>
															<td class="title">:</td>
															<td class="title"><?=$dataharian['nama_pelajaran']?></td>
														</tr>
														<tr>
															<td class="title">Kelas</td>
															<td class="title">:</td>
															<td class="title"><?=$dataharian['nama_kelas']?><?=$dataharian['kelas']?></td>
														</tr>
														<tr>
															<td class="title">BAB</td>
															<td class="title">:</td>
															<td class="title"><?=$dataharian['bab']?></td>
														</tr>
														<tr>
															<td class="title">Guru</td>
															<td class="title">:</td>
															<td class="title"><?=$dataharian['nama_guru']?></td>
														</tr>
														<tr>
															<td class="title">Jenis</td>
															<td class="title">:</td>
															<td class="title"><?=$dataharian['jenis']?></td>
														</tr>
														<tr>
															<td class="title">Dikumpulkan Tanggal</td>
															<td class="title">:</td>
															<td class="title"><? $tg=tanggal($dataharian['tanggal_kumpul']." 00:00:00"); echo $tg[2];?></td>
														</tr>
														<tr>
															<td class="title">Keterangan</td>
															<td class="title">:</td>
															<td class="title"><?=$dataharian['keterangan']?></td>
														</tr>
													</table>
													</div>
													<? pengumpulan_akademik_siswa($dataharian['id'],'harian',$dataharian['id_kelas']);?>
													
													<br class="clear" />
													<div id="komentar<?=$dataharian['id']?>"></div>
													</div>
												</td>
											</tr>
											<? } ?>
										</tbody>
								</table>
