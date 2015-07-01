								<?=$this->load->view('akademik/mainakademik/topindex')?>	
								<div class="clear"></div>
								<h3><?=$title?></h3>
								<div class="hr"></div>
								<script>
								$(document).ready(function(){
									$.ajax({
										type: "GET",
										data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&',
										url: '<?=base_url()?>akademik/comment/index/<?=$out['id']?>/first/penghubung',
										beforeSend: function() {
											//$("#filterpelajaranpr select#kelas").after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
											
										},
										success: function(msg) {
											//$("#wait").remove();
											$('#komentar<?=$out['id']?>').html(msg);	
										}
									});
								});
								
								</script>
									<?//pr($out)?>
									
									<table>
										<tbody>
											
											<tr id="detailpr<?=$out['id']?>">
												<td colspan="6" class="innercolspan">
													<div class="">
													<div class="full file">
													<h3 > <?=$title?></h3>
													<div class="hr"></div>
													<table class="noborder">
														<tr>
															<td class="title">Subject</td>
															<td class="titikdua">:</td>
															<td class="value"><?=$datapengh['datahubung'][0]['subject']?></td>
														</tr>
														<tr>
															<td class="title">Kelas</td>
															<td class="titikdua">:</td>
															<td class="value"><?=$datapengh['datahubung'][0]['kelas'].$datapengh['datahubung'][0]['nama_kelas']?></td>
														</tr>
														
													</table>
													</div>
													
													<div class="full file">
													<h3 >Di Kirim Ke</h3>
													<div class="hr"></div>
													<table class="noborder">
														<thead>
															<tr>
																<th>No</th>
																<th>Nama</th>
																<th>Kepada</th>
															</tr>
														</thead>
														<tbody>
														<?$ii=1; foreach($datapengh['datahubung'][0]['siswa'] as $sis){?>
															<tr>
																<td><?=$ii++?></td>
																<td class="left"><?=$sis['nama']?></td>
																<td><? if($sis['siswaortu']=='siswaortu'){echo 'Siswa & Ortu';}else{ echo $sis['siswaortu'];}?></td>
															</tr>
														<? } ?>
														</tbody>
													</table>
													</div>
													
													<div class="full file">
													<h3 >Lampiran</h3>
													<div class="hr"></div>
													<table class="noborder">
														<?foreach($datapengh['datahubung'][0]['file'] as $file){?>
														<tr>
															<td class="title"><a title="<?=$file['file_name']?>" href="<?=base_url('homepage/send_download/'.base64_encode('upload/akademik/penghubungortu/').'/'.base64_encode($file['file_name']).'');?>" target="_self"><?=substr($file['file_name'],-30)?> Download</a>
															| <a target="file"  href="<?=base_url()?>akademik/nilai/view_document/null/null/null/null/null/<?=base64_encode(base_url('upload/akademik/penghubungortu/'.$file['file_name']).'')?>">Lihat</a>
															</td>
														</tr>
														<? } ?>
													</table>
													</div>
													
													<div class="full file">
													<h3 >Keterangan</h3>
													<div class="hr"></div>
													<ul>
														<li><?=$datapengh['datahubung'][0]['keterangan']?></li>
													</ul>
													</div>
													<br class="clear" />
													<div id="komentar<?=$out['id']?>"></div>
													</div>
												</td>
											</tr>
											
										</tbody>
								</table>	
								</div>