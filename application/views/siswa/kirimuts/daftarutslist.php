								<script>
								$(document).ready(function(){
									
								});
								function getdetail(id,obj){
									$('#detailuts'+id).toggle('fade');
									$('table.siswautslist div.comment').remove();
									$(obj).prev('tr').hide();
									$(obj).next('tr').next('tr').next('tr').hide();
									$.ajax({
										type: "GET",
										data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&',
										url: '<?=base_url()?>akademik/comment/index/'+id+'/first/uts',
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
							   <table class="siswautslist">
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
											<? $nox=array();$no=1;foreach($uts as $kt=>$datauts){?>
											<tr style="cursor:pointer;" title="klik untuk menampilkan / menyembunyikan detail" onclick="getdetail(<?=$datauts['id']?>,this);">
												<td><?=$no++;?></td>
												<td class="title" ><?=$datauts['judul']?></td>
												<td class="title" ><?=$datauts['bab']?></td>
												<td ><?=$datauts['jenis']?></td>
												<td ><? $tg=tanggal($datauts['tanggal_kumpul']." 00:00:00"); echo $tg[2];?></td>
											</tr>
											<tr id="detailuts<?=$datauts['id']?>" style="display:none;">
												<td colspan="6" class="innercolspan">
													<div class="file">
													<h3 >Detail Data UTS</h3>
													<div class="hr"></div>
													<table class="noborder">
														<?foreach($datauts['file'] as $file){?>
														<tr>
															<td class="title"><a title="<?=$file['file_name']?>" href="<?=base_url('siswa/kirimuts/send_download/'.base64_encode($file['file_name']).'');?>" target="_self"><?=substr($file['file_name'],-30)?></a></td>
														</tr>
														<? } ?>
													</table>
													</div>
													<div class="siswa">
													<h3 >Detail UTS</h3>
													<div class="hr"></div>
													<table class="noborder">
														<tr>
															<td class="title">Judul UTS</td>
															<td class="title">:</td>
															<td class="title"><?=$datauts['judul']?></td>
														</tr>
														<tr>
															<td class="title">Mata Pelajaran</td>
															<td class="title">:</td>
															<td class="title"><?=$datauts['nama_pelajaran']?></td>
														</tr>
														<tr>
															<td class="title">Kelas</td>
															<td class="title">:</td>
															<td class="title"><?=$datauts['nama_kelas']?><?=$datauts['kelas']?></td>
														</tr>
														<tr>
															<td class="title">BAB</td>
															<td class="title">:</td>
															<td class="title"><?=$datauts['bab']?></td>
														</tr>
														<tr>
															<td class="title">Guru</td>
															<td class="title">:</td>
															<td class="title"><?=$datauts['nama_guru']?></td>
														</tr>
														<tr>
															<td class="title">Jenis</td>
															<td class="title">:</td>
															<td class="title"><?=$datauts['jenis']?></td>
														</tr>
														<tr>
															<td class="title">Dikumpulkan Tanggal</td>
															<td class="title">:</td>
															<td class="title"><? $tg=tanggal($datauts['tanggal_kumpul']." 00:00:00"); echo $tg[2];?></td>
														</tr>
														<tr>
															<td class="title">Keterangan</td>
															<td class="title">:</td>
															<td class="title"><?=$datauts['keterangan']?></td>
														</tr>
													</table>
													</div>
													<? pengumpulan_akademik_siswa($datauts['id'],'uts',$datauts['id_kelas']);?>							
													<br class="clear" />
													<div id="komentar<?=$datauts['id']?>"></div>
													</div>
												</td>
											</tr>
											<? } ?>
										</tbody>
								</table>
