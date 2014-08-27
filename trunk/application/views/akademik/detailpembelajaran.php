								<?=$this->load->view('akademik/mainakademik/topindex')?>	
								<div class="clear"></div>
								<h3><?=$title?></h3>
								<div class="hr"></div>
								<script>
								$(document).ready(function(){
									$.ajax({
										type: "GET",
										data: '',
										url: '<?=base_url()?>akademik/comment/index/<?=$out['id']?>/first/<?=$jenis?>',
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
									<? if(isset($out['id'])){?>
									<table>
										<tbody>
											
											<tr id="detailpr<?=$out['id']?>">
												<td colspan="6" class="innercolspan">
													<div class="">

													<? 
													if($out['jenis']=='remidial'){
														ikut_remidi($out['id_kelas'],$out['id'],$jenis);
													}
													?>
													<div class="full file">
													<h3 > <?=$title?></h3>
													<div class="hr"></div>
													<table class="noborder">
														<tr>
															<td class="title">Judul <?=$jenis?></td>
															<td class="titikdua">:</td>
															<td class="value"><?=$out['judul']?></td>
														</tr>
														<tr>
															<td class="title">Mata Pelajaran</td>
															<td class="titikdua">:</td>
															<td class="value"><?=$out['nama_pelajaran']?></td>
														</tr>
														<tr>
															<td class="title">BAB</td>
															<td class="titikdua">:</td>
															<td class="value"><?=$out['bab']?></td>
														</tr>
														<? 
															if($jenis!='materi'){
														?>
														<tr>
															<td class="title">Jenis</td>
															<td class="titikdua">:</td>
															<td class="value"><?=$out['jenis']?></td>
														</tr>
														<tr>
															<td class="title">Dikumpulkan Tanggal</td>
															<td class="titikdua">:</td>
															<td class="value"><? $tg=tanggal($out['tanggal_kumpul']." 00:00:00"); echo $tg[2];?></td>
														</tr>
														<? } ?>  
													</table>
													</div>
													
													<div class="full file">
													<h3 >Lampiran</h3>
													<div class="hr"></div>
													<table class="noborder">
														<?foreach($out['file'] as $file){?>
														<tr>
															<td class="title"><a title="<?=$file['file_name']?>" href="<?=base_url('homepage/send_download/'.base64_encode('upload/akademik/'.$jenis.'/').'/'.base64_encode($file['file_name']).'');?>" target="_self"><?=substr($file['file_name'],-30)?> Download</a>
															| <a target="file"  href="<?=base_url()?>akademik/nilai/view_document/null/null/null/null/null/<?=base64_encode(base_url('upload/akademik/'.$jenis.'/'.$file['file_name']).'')?>">Lihat</a>
															</td>
														</tr>
														<? } ?>
													</table>
													</div>
													
													<div class="full file">
													<h3 >Keterangan</h3>
													<div class="hr"></div>
													<ul>
														<li><?=$out['keterangan']?></li>
													</ul>
													</div>
													<? 
													if($this->session->userdata['user_authentication']['id_group']==12){
														if($jenis!='materi'){
														pengumpulan_akademik_siswa($out['id'],$jenis,$out['id_kelas']);
														}
													}else{
														if($jenis!='materi'){
															pengumpulan_akademik($out['id_kelas'],$out['id_sekolah'],$jenis,$out['id'],$out['id_pelajaran']); 
														}
													}
													?>
													<br class="clear" />
													<div id="komentar<?=$out['id']?>"></div>
													</div>
												</td>
											</tr>
											
										</tbody>
								</table>	
								<?}else{?>
								<h1 style="text-align:center;">Data sudah dihapus</h1>
								<? } ?>
								</div>