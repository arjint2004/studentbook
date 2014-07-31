								
							   <table>
										<thead>
											<tr> 
												<th>No</th>      
												<th>Jurnal</th>
												<th>Tanggal</th>
												<th>Lampiran</th>
												
											</tr>                         
										</thead>
										<tbody>
											<? $no=1;foreach($jurnal as $kt=>$datajurnal){?>
											<tr style="cursor:pointer;" title="klik untuk menampilkan / menyembunyikan detail" onclick="$('#detailjurnal<?=$datajurnal['id']?>').toggle('fade')">
												<td><?=$no++;?></td>
												<td class="title" >Jurnal <?=$no?></td>
												<td class="title" ><?=$datajurnal['tanggal']?></td>
												<td >Klik untuk detail lampiran</td>
												
											</tr>
											<tr id="detailjurnal<?=$datajurnal['id']?>" style="display:none;">
												<td colspan="6" class="innercolspan">
													<div class="file" style="width:98%;min-height:50px;">
													<h3 >Detail File Jurnal Wali Kelas</h3>
													<div class="hr"></div>
													<table class="noborder">
														<?foreach($datajurnal['file'] as $file){?>
														<tr>
															<td class="title"><a title="<?=$file['file_name']?>" href="<?=base_url('siswa/kirimpr/send_download/'.base64_encode($file['file_name']).'');?>" target="_self"><?=$file['file_name']?></a></td>
														</tr>
														<? } ?>
													</table>
													</div>
													<div class="siswa" style="width:98%;min-height:50px; margin-top:20px;">
													<h3 >Detail Jurnal Wali Kelas</h3>
													<div class="hr"></div>
													<table class="noborder">
														<tr>
															<td class="title"><?=$datajurnal['jurnalwali']?></td>
														</tr>
														
													</table>
													</div>
												</td>
											</tr>
											<? } ?>
										</tbody>
								</table>
