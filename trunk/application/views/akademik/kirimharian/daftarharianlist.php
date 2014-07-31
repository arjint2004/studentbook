								<script>
								$(document).ready(function(){
									if($('ul.tabs-frameharian').length > 0) $('ul.tabs-frameharian').tabs('> .tabs-frame-contentharian');
									$("div#actdellharian").click(function(){
											var objdell=$(this);
											if(confirm('Data dan File akan di hapus secara permanen, untuk menggunakannya kembali anda harus upload ulang..')){
												$.ajax({
													type: "POST",
													data: '',
													url: base_url+'akademik/kirimharian/delete/'+$(this).attr('id_harian'),
													beforeSend: function() {
														$(objdell).after("<img id='waitharian7' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
													},
													success: function(msg) {
														$("#waitharian7").remove();	
														if(msg==1){
															//$(objdell).parent('td').parent('tr').next().remove();
															//$(objdell).parent('td').parent('tr').remove();
															$.ajax({
																	type: "POST",
																	data: 'id_kelas='+$('select#kelasharian').val()+'&pelajaran='+$('select#pelajaranharian').val()+'&ajax=1',
																	url: '<?=base_url()?>akademik/kirimharian/daftarharianlist',
																	beforeSend: function() {
																		$(objdell).after("<img id='waitharian8' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
																	},
																	success: function(msg) {
																		$("#waitharian8").remove();
																		//$('select#kelasharian').val('');
																		//$('select#pelajaranharian').html($('select#pelajaran_addharian').html());
																		//$('select#pelajaranharian').val('');
																		$('#subjectlistharian').html(msg);
																	}
															});
														}
													}
												});
												return false;
											}
									});	
									
									$("div.acteditharian").click(function(){
											var objdell=$(this);
											$.ajax({
													type: "POST",
													data: '',
													url: $(objdell).attr('href'),
													beforeSend: function() {
														$(objdell).after("<img id='waitharian9' style='margin:0;'  src='<?=$this->config->item('images').'loading.png';?>' />");
													},
													success: function(msg) {
														$("#waitharian9").remove();
														$('#subjectlistharian').html(msg);
													}
											});
										});
								});
								function getdetail(id,obj,ident){
									$('#'+ident+id).toggle('fade');
									$('table.harianlist div.comment').remove();
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
											$('#komentarharian'+id).html(msg);	
										}
									});
									return false;
								}
								</script>
								<? //harian($harian);?>
							   

								
								<div class="tabs-container">
									<ul class="tabs-frame tabs-frameharian">
										<li><a href="#">Semua arsip harian</a></li>
										<li><a href="#">harian Terkirim</a></li>
									</ul>
									<div class="tabs-frame-content tabs-frame-contentharian ">
									<table class="harianlist">
											<thead>
												<tr> 
													<th>No</th>
													<th>Jenis</th>      
													<th>Judul</th>
													<th>Dikirim Ke</th>
													<th>Waktu Upload</th>
													<th>Action</th>
												</tr>                         
											</thead>
											<tbody>
												<? $nox=array();$no=1;
												if(!empty($harian)){
												foreach($harian as $kt=>$dataharian){
													if($dataharian['jenis']!='remidial'){$bordettop="bordettop";}else{$bordettop="";}
												?>
												<tr style="cursor:pointer;<? if($dataharian['jenis']!='remidial'){?>border-top:1px solid #ccc;<?}?>" title="klik untuk menampilkan / menyembunyikan detail" onclick="getdetail(<?=$dataharian['id']?>,this,'detailhariansemua');">
													<td class="<?=$bordettop?>" ><? if($dataharian['jenis']!='remidial'){?><?=$no++;?><? } ?></td>
													<td class="<?=$bordettop?> title"><? if($dataharian['jenis']=='non_remidial'){echo "harian Utama";}else{ echo "remidial";}?></td>
													<td class="<?=$bordettop?> title" ><?=$dataharian['judul']?></td>
													<td class="<?=$bordettop?> title" ><? 
													if(!empty($dataharian['dikirim'])){
														foreach($dataharian['dikirim'] as $dtdkrm){echo $dtdkrm['kelas'].$dtdkrm['nama_kelas']." &nbsp; ";}
													}else{
														echo 'Belum dikirim';
													}
													?></td>
													<td class="<?=$bordettop?>"><? $tg=tanggal($dataharian['tanggal_buat']." 00:00:00"); echo $tg[2];?></td>
													<td class="<?=$bordettop?>" >
														<? if($dataharian['jenis']=='non_remidial'){?>
														<div class="acteditharian actedit" id_harian="<?=$dataharian['id']?>" title="ubah" href="<?=base_url('akademik/kirimharian/kirimharianutamaedit/'.$dataharian['id'])?>"></div>
														<? }else{ ?>
														<div class="acteditharian actedit" id_harian="<?=$dataharian['id']?>" title="ubah" href="<?=base_url('akademik/kirimharian/kirimharianremidialedit/'.$dataharian['id'])?>"></div> 
														<? } ?>
														<div class="actdell" id="actdellharian" id_harian="<?=$dataharian['id']?>"></div>
													</td>
												</tr>
												<tr id="detailhariansemua<?=$dataharian['id']?>" style="display:none;">
													<td colspan="6" class="innercolspan">
														<div class="">
														<? 
														if(!empty($dataharian['dikirim'])){
															foreach($dataharian['dikirim'] as $dtdkrm){
																pengumpulan_akademik($dtdkrm['id_kelas'],$dataharian['id_sekolah'],$jenis='harian',$dataharian['id'],$dataharian['id_pelajaran'],$dtdkrm['kelas'].$dtdkrm['nama_kelas']);
															}
														}
														?>
														<? 
														if($dataharian['jenis']=='remidial'){
															ikut_remidi($dataharian['id_kelas'],$dataharian['id'],$jenis='harian');
														}
														?>
														<div class="full file">
														<h3 >Detail harian</h3>
														<div class="hr"></div>
														<table class="noborder">
															<tr>
																<td class="title">Judul harian</td>
																<td class="titikdua">:</td>
																<td class="value"><?=$dataharian['judul']?></td>
															</tr>
															<tr>
																<td class="title">Mata Pelajaran</td>
																<td class="titikdua">:</td>
																<td class="value"><?=$dataharian['nama_pelajaran']?></td>
															</tr>
															<tr>
																<td class="title">BAB</td>
																<td class="titikdua">:</td>
																<td class="value"><?=$dataharian['bab']?></td>
															</tr>
															<tr>
																<td class="title">Jenis</td>
																<td class="titikdua">:</td>
																<td class="value"><?=$dataharian['jenis']?></td>
															</tr>
															
														</table>
														</div>
														
														<div class="full file">
														<h3 >Lampiran</h3>
														<div class="hr"></div>
														<table class="noborder">
															<?foreach($dataharian['file'] as $file){?>
															<tr>
																<td class="title"><a title="<?=$file['file_name']?>" href="<?=base_url('homepage/send_download/'.base64_encode('upload/akademik/harian/').'/'.base64_encode($file['file_name']).'');?>" target="_self"><?=substr($file['file_name'],-30)?> Download</a>
																| <a target="file"  href="<?=base_url()?>akademik/nilai/view_document/null/null/null/null/null/<?=base64_encode(base_url('upload/akademik/harian/'.$file['file_name']).'')?>">Lihat</a>
																</td>
															</tr>
															<? } ?>
														</table>
														</div>
														
														<!--<div class="full file">
														<h3 >Keterangan</h3>
														<div class="hr"></div>
														<ul>
															<li><?=$dataharian['keterangan']?></li>
														</ul>
														</div>-->
														<br class="clear" />
														<div id="komentarharian<?=$dataharian['id']?>"></div>
														</div>
													</td>
												</tr>
												<? } } ?>
											</tbody>
										</table>			
									</div>
									<div class="tabs-frame-content tabs-frame-contentharian">
										<table class="harianlist">
											<thead>
												<tr> 
													<th>No</th>
													<th>Jenis</th>      
													<th>Judul</th>
													<th>Ke Kelas</th>
													<th>Waktu Upload</th>
													<th>Action</th>
												</tr>                         
											</thead>
											<tbody>
												<? $nox=array();$no=1;
												if(!empty($terkirim)){
												foreach($terkirim as $kt=>$dataharian){
													if($dataharian['jenis']!='remidial'){$bordettop="bordettop";}else{$bordettop="";}
												?>
												<tr style="cursor:pointer;<? if($dataharian['jenis']!='remidial'){?>border-top:1px solid #ccc;<?}?>" title="klik untuk menampilkan / menyembunyikan detail" onclick="getdetail(<?=$dataharian['id']?>,this,'detailharianterkirim');">
													<td class="<?=$bordettop?>" ><? if($dataharian['jenis']!='remidial'){?><?=$no++;?><? } ?></td>
													<td class="<?=$bordettop?> title"><? if($dataharian['jenis']=='non_remidial'){echo "harian Utama";}else{ echo "remidial";}?></td>
													<td class="<?=$bordettop?> title" ><?=$dataharian['judul']?></td>
													<td class="<?=$bordettop?> title" ><? foreach($dataharian['dikirim'] as $dtdkrm){echo $dtdkrm['kelas'].$dtdkrm['nama_kelas']." &nbsp; ";}?></td>
													<td class="<?=$bordettop?>"><? $tg=tanggal($dataharian['tanggal_buat']." 00:00:00"); echo $tg[2];?></td>
													<td class="<?=$bordettop?>" >
														<? if($dataharian['jenis']=='non_remidial'){?>
														<div class="acteditharian actedit" id_harian="<?=$dataharian['id']?>" title="ubah" href="<?=base_url('akademik/kirimharian/kirimharianutamaedit/'.$dataharian['id'])?>"></div>
														<? }else{ ?>
														<div class="acteditharian actedit" id_harian="<?=$dataharian['id']?>" title="ubah" href="<?=base_url('akademik/kirimharian/kirimharianremidialedit/'.$dataharian['id'])?>"></div> 
														<? } ?>
														<div class="actdell" id="actdellharian" id_harian="<?=$dataharian['id']?>"></div>
													</td>
												</tr>
												<tr id="detailharianterkirim<?=$dataharian['id']?>" style="display:none;">
													<td colspan="6" class="innercolspan">
														<div class="">
															<div class="full file">
															<h3 >Di Kirim ke Kelas</h3>
															<div class="hr"></div>
															<table class="noborder">
																
																<tr>
																	<th style="width:10px;">No</th>
																	<th >Kelas</th>
																	<th >Tanggal Dikumpulkan</th>
																	<th >Keterangan</th>
																</tr>
																<? foreach($dataharian['dikirim'] as $dtdkrm){ $noo++;?>
																<tr>
																	<td ><?=$noo?></td>
																	<td class="title"><?=$dtdkrm['kelas'].$dtdkrm['nama_kelas']?></td>
																	<td class="title"><? $tg=tanggal($dtdkrm['tanggal_kumpul']." 00:00:00"); echo $tg[2];?></td>
																	<td class="title"><?=$dtdkrm['keterangan']?></td>
																</tr>
																<? }
																	unset($noo);
																?>
															</table>
															</div>
														<? 
														foreach($dataharian['dikirim'] as $dtdkrm){
															pengumpulan_akademik($dtdkrm['id_kelas'],$dataharian['id_sekolah'],$jenis='harian',$dataharian['id'],$dataharian['id_pelajaran'],$dtdkrm['kelas'].$dtdkrm['nama_kelas']);
														}
														?>
														<? 
														if($dataharian['jenis']=='remidial'){
															ikut_remidi($dataharian['id_kelas'],$dataharian['id'],$jenis='harian');
														}
														?>
														<div class="full file">
														<h3 >Detail harian</h3>
														<div class="hr"></div>
														<table class="noborder">
															<tr>
																<td class="title">Judul harian</td>
																<td class="titikdua">:</td>
																<td class="value"><?=$dataharian['judul']?></td>
															</tr>
															<tr>
																<td class="title">Mata Pelajaran</td>
																<td class="titikdua">:</td>
																<td class="value"><?=$dataharian['nama_pelajaran']?></td>
															</tr>
															<tr>
																<td class="title">BAB</td>
																<td class="titikdua">:</td>
																<td class="value"><?=$dataharian['bab']?></td>
															</tr>
															<tr>
																<td class="title">Jenis</td>
																<td class="titikdua">:</td>
																<td class="value"><?=$dataharian['jenis']?></td>
															</tr>
														</table>
														</div>
														
														<div class="full file">
														<h3 >Lampiran</h3>
														<div class="hr"></div>
														<table class="noborder">
															<?foreach($dataharian['file'] as $file){?>
															<tr>
																<td class="title"><a title="<?=$file['file_name']?>" href="<?=base_url('homepage/send_download/'.base64_encode('upload/akademik/harian/').'/'.base64_encode($file['file_name']).'');?>" target="_self"><?=substr($file['file_name'],-30)?> Download</a>
																| <a target="file"  href="<?=base_url()?>akademik/nilai/view_document/null/null/null/null/null/<?=base64_encode(base_url('upload/akademik/harian/'.$file['file_name']).'')?>">Lihat</a>
																</td>
															</tr>
															<? } ?>
														</table>
														</div>
														
														<!--<div class="full file">
														<h3 >Keterangan</h3>
														<div class="hr"></div>
														<ul>
															<li><?=$dataharian['keterangan']?></li>
														</ul>
														</div>-->
														<br class="clear" />
														<div id="komentarharian<?=$dataharian['id']?>"></div>
														</div>
													</td>
												</tr>
												<? } } ?>
											</tbody>
										</table>									
									</div>
								</div>