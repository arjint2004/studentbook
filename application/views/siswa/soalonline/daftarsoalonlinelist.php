								<? //pr($soalonline);?>
								<script>
								$(document).ready(function(){
									
								});
								function getdetail(id,obj){
									$('#detailsoalonline'+id).toggle('fade');
									$('table.siswasoalonlinelist div.comment').remove();
									$(obj).prev('tr').hide();
									$(obj).next('tr').next('tr').next('tr').hide();
									$.ajax({
										type: "GET",
										data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&',
										url: '<?=base_url()?>akademik/comment/index/'+id+'/first/soalonline',
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
							   <table class="siswasoalonlinelist">
										<thead>
											<tr> 
												<th>No</th>      
												<th>Pokok Bahasan</th>
												<th>Bab</th>
												<th>Tanggal Diajarkan</th>
											</tr>                         
										</thead>
										<tbody>
											<? $nox=array();$no=1;foreach($soalonline as $kt=>$datasoalonline){?>
											<tr style="cursor:pointer;" title="klik untuk menampilkan / menyembunyikan detail" onclick="getdetail(<?=$datasoalonline['id']?>,this);">
												<td><?=$no++;?></td>
												<td class="title" ><?=$datasoalonline['pokok_bahasan']?></td>
												<td class="title" ><?=$datasoalonline['bab']?></td>
												<td ><? $tg=tanggal($datasoalonline['tanggal_diajarkan'].""); echo $tg[2];?></td>
												
											</tr>
											<tr id="detailsoalonline<?=$datasoalonline['id']?>" style="display:none;">
												<td colspan="6" class="innercolspan">
													<div class="file">
													<h3 >File Lampiran</h3>
													<div class="hr"></div>
													<table class="noborder">
														<?
														if(!empty($datasoalonline['file'])){
														foreach($datasoalonline['file'] as $file){?>
														<tr>
															<td class="title">

															<? //if($file['source']=='upload'){?>
															<a title="<?=$file['file_name']?>" href="<?=base_url('homepage/send_download/'.base64_encode('upload/akademik/soalonline/').'/'.base64_encode($file['file_name']).'');?>" target="_self"><?=substr($file['file_name'],-30)?> Download</a>
															| 
															<?
																$urlembed=str_replace(":","%3A",str_replace("/","%2F",base_url('upload/akademik/soalonline/'.$file['file_name']).'&amp;embedded=true'));
																$params=base64_encode(serialize(array(
																		'file'=>$urlembed,
																		'id'=>$datasoalonline['id']
																)));
																
															?>
															<a target="file"  href="<?=base_url()?>siswa/soalonline/take/<?=$params?>">Lihat</a>
															<? //} ?>
															</td>
														</tr>
														<? } } ?>
													</table>
													</div>
													<div class="siswa">
													<h3 >Detail Soalonline</h3>
													<div class="hr"></div>
													<table class="noborder">
														<tr>
															<td class="title">Pokok Bahasan</td>
															<td>:</td>
															<td class="title"><?=$datasoalonline['pokok_bahasan']?></td>
														</tr>
														<tr>
															<td class="title">Kelas</td>
															<td>:</td>
															<td class="title"><?=$datasoalonline['kelas']?><?=$datasoalonline['nama_kelas']?></td>
														</tr>
														<tr>
															<td class="title">Pelajaran</td>
															<td>:</td>
															<td class="title"><?=$datasoalonline['nama_pelajaran']?></td>
														</tr>
														<tr>
															<td class="title">Bab</td>
															<td>:</td>
															<td class="title"><?=$datasoalonline['bab']?></td>
														</tr>
														<tr>
															<td class="title">Guru</td>
															<td>:</td>
															<td class="title"><?=$datasoalonline['nama_guru']?></td>
														</tr>
														<tr>
															<td class="title">Tanggal Diajarkan</td>
															<td>:</td>
															<td class="title"><? $tg=tanggal($datasoalonline['tanggal_diajarkan'].""); echo $tg[2];?></td>
														</tr>
														<tr>
															<td class="title">Keterangan</td>
															<td>:</td>
															<td class="title"><?=$datasoalonline['keterangan']?></td>
														</tr>
														
													</table>

													</div>
																										<br class="clear" />
													<div id="komentar<?=$datasoalonline['id']?>"></div>
													</div>
												</td>
											</tr>
											<? } ?>
										</tbody>
								</table>
