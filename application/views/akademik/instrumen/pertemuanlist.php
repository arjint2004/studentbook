								<script>
									$(document).ready(function(){
										//Submit Start

										
										$("ul.file div.actdell").click(function(){
											var objdell=$(this);
											if(confirm('File akan di hapus secara permanen, untuk menggunakannya kembali anda harus upload ulang..')){
												$.ajax({
													type: "POST",
													data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&',
													url: base_url+'akademik/instrumen/deletefilepemb/'+$(this).attr('id'),
													beforeSend: function() {
														$(objdell).after("<img id='wait' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
													},
													success: function(msg) {
														$("#wait").remove();	
														$(objdell).parent().remove();
													}
												});
												return false;
											}
										});
										
										$("div#actdellpemp").click(function(){
											var objdell=$(this);
											if(confirm('Data dan File akan di hapus secara permanen, untuk menggunakannya kembali anda harus upload ulang..')){
												$.ajax({
													type: "POST",
													data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&',
													url: base_url+'akademik/instrumen/deletepert/'+$(this).attr('id_pemb'),
													beforeSend: function() {
														$(objdell).after("<img id='wait' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
													},
													success: function(msg) {
														$("#wait").remove();	
														if(msg==1){
															$(objdell).parent('td').parent('tr').remove();
															$(objdell).parent('td').parent('tr').next().remove();
														}
													}
												});
												return false;
											}
										});
										
										
									});
								</script>
								<? //pr($pertemuan);?>
							   <table>
										<thead>
											<tr>
												<th>No</th>      
												<th>Pelajaran</th>
												<th>Kelas</th>
												<th>Topik</th>
												<th>Pembelajaran</th>
												<th>Ke</th>
												<th>Action</th>
											</tr>                         
										</thead>
										<tbody>
											<? 
											$nox=array();$no=1;
											if(!empty($pertemuan)){
											foreach($pertemuan as $kt=>$datapertemuan){?>
											<tr style="cursor:pointer;" title="klik untuk menampilkan / menyembunyikan detail" onclick="$('#detailpertemuan<?=$datapertemuan['id']?>').toggle('fade')">
												<td><?=$no++;?></td>
												<td class="title" ><?=$datapertemuan['nama_pelajaran']?></td>
												<td  ><?=$datapertemuan['kelas']?><?=$datapertemuan['nama_kelas']?></td>
												<td class="title"><?=$datapertemuan['topik']?></td>
												<td ><a href="<?=site_url('akademik/instrumen/addpembelajaran/'.$datapertemuan['id'].'')?>" id="penilaianklik" class="modal">Tambah</a>|<a href="<?=site_url('akademik/instrumen/pembelajaranlist/'.$datapertemuan['id'].'')?>" id="penilaianklik" class="modal">Lihat</a></td>
												<td ><?=$datapertemuan['pertemuan_ke']?></td>
												<td >
													<div class="actedit modal" href="<?=base_url('akademik/instrumen/editpertemuan/'.$datapertemuan['id'])?>"></div> 
													<div id="actdellpemp" id_pemb="<?=$datapertemuan['id']?>" class="actdell"></div>
												</td>
											</tr>
											<tr id="detailpertemuan<?=$datapertemuan['id']?>" style="display:none;">
												<td colspan="7" class="innercolspan">
													<div class="full file">
													<h3>Detail Pertemuan</h3>
													<div class="hr"></div>
													<table class="noborder">
														<tbody>
														<tr>
															<td class="title">Guru</td>
															<td class="titikdua">:</td>
															<td class="value"><?=$datapertemuan['pegawai']?></td>
														</tr>
														<tr>
															<td class="title">Mata Pelajaran</td>
															<td class="titikdua">:</td>
															<td class="value"><?=$datapertemuan['nama_pelajaran']?></td>
														</tr>
														<tr>
															<td class="title">Kelas</td>
															<td class="titikdua">:</td>
															<td class="value"><?=$datapertemuan['kelas']?><?=$datapertemuan['nama_kelas']?></td>
														</tr>
														<tr>
															<td class="title">Semester</td>
															<td class="titikdua">:</td>
															<td class="value"><?=$datapertemuan['semester']?></td>
														</tr>
														<tr>
															<td class="title">Topik</td>
															<td class="titikdua">:</td>
															<td class="value"><?=$datapertemuan['topik']?></td>
														</tr>
														<tr>
															<td class="title">Waktu</td>
															<td class="titikdua">:</td>
															<td class="value"><?=$datapertemuan['waktu']?></td>
														</tr>
														<tr>
															<td class="title">Pertemuan Ke</td>
															<td class="titikdua">:</td>
															<td class="value"><?=$datapertemuan['pertemuan_ke']?></td>
														</tr>
														<tr>
															<td class="title">Tambah RPP</td>
															<td class="titikdua">:</td>
															<td class="value"><a href="<?=site_url('akademik/instrumen/addpembelajaran/')?>" id="penilaianklik" class="modal">Tambah Rpp</a></td>
														</tr>
													</tbody></table>
													</div>
												</td>
											</tr>
											<? }  } ?>
										</tbody>
								</table>
								