								<script>
								$(document).ready(function(){
									
								});
								function getdetail(id,obj){
									$('#detailtugas'+id).toggle('fade');
									$('table.siswatugaslist div.comment').remove();
									$(obj).prev('tr').hide();
									$(obj).next('tr').next('tr').next('tr').hide();
									$.ajax({
										type: "GET",
										data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&',
										url: '<?=base_url()?>akademik/comment/index/'+id+'/first/tugas',
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
							   <table class="siswatugaslist">
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
											<? $nox=array();$no=1;foreach($tugas as $kt=>$datatugas){?>
											<tr style="cursor:pointer;" title="klik untuk menampilkan / menyembunyikan detail"  onclick="getdetail(<?=$datatugas['id']?>,this);">
												<td><?=$no++;?></td>
												<td class="title" ><?=$datatugas['judul']?></td>
												<td class="title" ><?=$datatugas['bab']?></td>
												<td ><?=$datatugas['jenis']?></td>
												<td ><? $tg=tanggal($datatugas['tanggal_kumpul']." 00:00:00"); echo $tg[2];?></td>
											</tr>
											<tr id="detailtugas<?=$datatugas['id']?>" style="display:none;">
												<td colspan="6" class="innercolspan">
													<div class="file">
													<h3 >Detail Data Tugas</h3>
													<div class="hr"></div>
													<table class="noborder">
														<?foreach($datatugas['file'] as $file){?>
														<tr>
															<td class="title"><a title="<?=$file['file_name']?>" href="<?=base_url('siswa/kirimtugas/send_download/'.base64_encode($file['file_name']).'');?>" target="_self"><?=substr($file['file_name'],-30)?></a></td>
														</tr>
														<? } ?>
													</table>
													</div>
													<div class="siswa">
													<h3 >Detail Tugas</h3>
													<div class="hr"></div>
													<table class="noborder">
														<tr>
															<td class="title">Judul Tugas</td>
															<td class="title">:</td>
															<td class="title"><?=$datatugas['judul']?></td>
														</tr>
														<tr>
															<td class="title">Mata Pelajaran</td>
															<td class="title">:</td>
															<td class="title"><?=$datatugas['nama_pelajaran']?></td>
														</tr>
														<tr>
															<td class="title">Kelas</td>
															<td class="title">:</td>
															<td class="title"><?=$datatugas['kelas']?><?=$datatugas['nama_kelas']?></td>
														</tr>
														<tr>
															<td class="title">BAB</td>
															<td class="title">:</td>
															<td class="title"><?=$datatugas['bab']?></td>
														</tr>
														<tr>
															<td class="title">Guru</td>
															<td class="title">:</td>
															<td class="title"><?=$datatugas['nama_guru']?></td>
														</tr>
														<tr>
															<td class="title">Jenis</td>
															<td class="title">:</td>
															<td class="title"><?=$datatugas['jenis']?></td>
														</tr>
														<tr>
															<td class="title">Dikumpulkan Tanggal</td>
															<td class="title">:</td>
															<td class="title"><? $tg=tanggal($datatugas['tanggal_kumpul']." 00:00:00"); echo $tg[2];?></td>
														</tr>
														<tr>
															<td class="title">Keterangan</td>
															<td class="title">:</td>
															<td class="title"><?=$datatugas['keterangan']?></td>
														</tr>
													</table>
													</div>
													<? pengumpulan_akademik_siswa($datatugas['id'],'tugas',$datatugas['id_kelas']);?>
																																							
													<br class="clear" />
													<div id="komentar<?=$datatugas['id']?>"></div>
													</div>
												</td>
											</tr>
											<? } ?>
										</tbody>
								</table>
