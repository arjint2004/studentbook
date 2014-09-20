								<? //pr($materi);?>
								<script>
								$(document).ready(function(){
									
								});
								function getdetail(id,obj){
									$('#detailmateri'+id).toggle('fade');
									$('table.siswamaterilist div.comment').remove();
									$(obj).prev('tr').hide();
									$(obj).next('tr').next('tr').next('tr').hide();
									$.ajax({
										type: "GET",
										data: '',
										url: '<?=base_url()?>akademik/comment/index/'+id+'/first/materi',
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
							   <table class="siswamaterilist">
										<thead>
											<tr> 
												<th>No</th>      
												<th>Pokok Bahasan</th>
												<th>Bab</th>
												<th>Tanggal Diajarkan</th>
											</tr>                         
										</thead>
										<tbody>
											<? $nox=array();$no=1;foreach($materi as $kt=>$datamateri){?>
											<tr style="cursor:pointer;" title="klik untuk menampilkan / menyembunyikan detail" onclick="getdetail(<?=$datamateri['id']?>,this);">
												<td><?=$no++;?></td>
												<td class="title" ><?=$datamateri['pokok_bahasan']?></td>
												<td class="title" ><?=$datamateri['bab']?></td>
												<td ><? $tg=tanggal($datamateri['tanggal_diajarkan']." 00:00:00"); echo $tg[2];?></td>
												
											</tr>
											<tr id="detailmateri<?=$datamateri['id']?>" style="display:none;">
												<td colspan="6" class="innercolspan">
													<div class="file">
													<h3 >File Lampiran</h3>
													<div class="hr"></div>
													<table class="noborder">
														<? foreach($datamateri['file'] as $file){?>
														<tr>
															<td class="title"><a href="<?=base_url('homepage/send_download/'.base64_encode($file['file_name']).'');?>" target="_self"><?=$file['file_name']?></a></td>
														</tr>
														<? } ?>
													</table>
													</div>
													<div class="siswa">
													<h3 >Detail Materi</h3>
													<div class="hr"></div>
													<table class="noborder">
														<tr>
															<td class="title">Pokok Bahasan</td>
															<td>:</td>
															<td class="title"><?=$datamateri['pokok_bahasan']?></td>
														</tr>
														<tr>
															<td class="title">Kelas</td>
															<td>:</td>
															<td class="title"><?=$datamateri['kelas']?><?=$datamateri['nama_kelas']?></td>
														</tr>
														<tr>
															<td class="title">Pelajaran</td>
															<td>:</td>
															<td class="title"><?=$datamateri['nama_pelajaran']?></td>
														</tr>
														<tr>
															<td class="title">Bab</td>
															<td>:</td>
															<td class="title"><?=$datamateri['bab']?></td>
														</tr>
														<tr>
															<td class="title">Guru</td>
															<td>:</td>
															<td class="title"><?=$datamateri['nama_guru']?></td>
														</tr>
														<tr>
															<td class="title">Tanggal Diajarkan</td>
															<td>:</td>
															<td class="title"><? $tg=tanggal($datamateri['tanggal_diberikan']." 00:00:00"); echo $tg[2];?></td>
														</tr>
														<tr>
															<td class="title">Keterangan</td>
															<td>:</td>
															<td class="title"><?=$datamateri['keterangan']?></td>
														</tr>
														
													</table>

													</div>
																										<br class="clear" />
													<div id="komentar<?=$datamateri['id']?>"></div>
													</div>
												</td>
											</tr>
											<? } ?>
										</tbody>
								</table>
