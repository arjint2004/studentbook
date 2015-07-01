								<script>
								$(document).ready(function(){
									if($('ul.tabs-frametugas').length > 0) $('ul.tabs-frametugas').tabs('> .tabs-frame-contenttugas');
									$("div#actdelltugas").click(function(){
											var objdell=$(this);
											if(confirm('Data dan File akan di hapus secara permanen, untuk menggunakannya kembali anda harus upload ulang..')){
												$.ajax({
													type: "POST",
													data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&',
													url: base_url+'akademik/kirimtugas/delete/'+$(this).attr('id_tugas'),
													beforeSend: function() {
														$(objdell).after("<img id='waittugas7' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
													},
													success: function(msg) {
														$("#waittugas7").remove();	
														if(msg==1){
															//$(objdell).parent('td').parent('tr').next().remove();
															//$(objdell).parent('td').parent('tr').remove();
															$.ajax({
																	type: "POST",
																	data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&id_kelas='+$('select#kelastugas').val()+'&pelajaran='+$('select#pelajarantugas').val()+'&ajax=1',
																	url: '<?=base_url()?>akademik/kirimtugas/daftartugaslist',
																	beforeSend: function() {
																		$(objdell).after("<img id='waittugas8' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
																	},
																	success: function(msg) {
																		$("#waittugas8").remove();
																		//$('select#kelastugas').val('');
																		//$('select#pelajarantugas').html($('select#pelajaran_addtugas').html());
																		//$('select#pelajarantugas').val('');
																		$('#subjectlisttugas').html(msg);
																	}
															});
														}
													}
												});
												return false;
											}
									});	
									
									$("div.actedittugas").click(function(){
											var objdell=$(this);
											$.ajax({
													type: "POST",
													data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&',
													url: $(objdell).attr('href'),
													beforeSend: function() {
														$(objdell).after("<img id='waittugas9' style='margin:0;'  src='<?=$this->config->item('images').'loading.png';?>' />");
													},
													success: function(msg) {
														$("#waittugas9").remove();
														$('#subjectlisttugas').html(msg);
													}
											});
									});
										
										

									$("div#paginationtugasilist a").click(function(){
										var objdell=$(this);
										$.ajax({
											type: "POST",
											data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&id_pengguna=<?=@$id_pengguna?>&kepsek=<?=@$kepsek?>',
											url: $(objdell).attr('href'),
											beforeSend: function() {
												$(objdell).after("<img class='wait' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
											},
											success: function(msg) {
												$(".wait").remove();	
												$("#subjectlisttugas").html(msg);
												//$('#subjectpembelajaran').scrollintoview({ speed:'1100'});
											}
										});
										return false;
									});			
								});
								function getdetail(id,obj,ident){
									$('#'+ident+id).toggle('fade');
									$('table.tugaslist div.comment').remove();
									$(obj).prev('tr').hide();
									$(obj).next('tr').next('tr').next('tr').hide();
									$.ajax({
										type: "GET",
										data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&',
										url: '<?=base_url()?>akademik/comment/index/'+id+'/first/tugas',
										beforeSend: function() {
											//$("#filterpelajarantugas select#kelas").after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
											
										},
										success: function(msg) {
											//$("#wait").remove();
											$('#komentartugas'+id).html(msg);	
										}
									});
									return false;
								}
								</script>
								<? //tugas($tugas);?>
								<? if($kepsek=='kepsek' && $page==0){?>
								<div id="subjectlisttugas" style="min-width:700px;">	
								<? } ?>	
								<div class="tabs-container">
									<ul class="tabs-frame tabs-frametugas">
										<li><a href="#">Semua arsip TUGAS</a></li>
										<li><a href="#">TUGAS Terkirim</a></li>
										<li><a href="#">Download</a></li>
									</ul>
									<div class="tabs-frame-content tabs-frame-contenttugas ">
									<div style="float:left;" id="paginationtugasilist" >
									<?=$link?>
									</div>										
									<table class="tugaslist">
											<thead>
												<tr> 
													<th>No</th>
													<th>Jenis</th>      
													<th>Judul</th>
													<th>Dikirim Ke</th>
													<th>Tgl Upload</th>
													<th style="width:37px;">Detail</th>
													<? if($kepsek!='kepsek'){?>
													<th style="width:75px;">Ubah|Hapus</th>
													<? } ?>
												</tr>                         
											</thead>
											<tbody>
												<? 
												$cur_page2=$cur_page;
												$per_page2=$per_page;
												if(@$cur_page==0){@$cur_page=1;}
												$no=(@$cur_page*@$per_page)-@$per_page+1;
												if(!empty($tugas)){
												foreach($tugas as $kt=>$datatugas){
													if($datatugas['jenis']!='remidial'){$bordettop="bordettop";}else{$bordettop="";}
												?>
												<tr style="cursor:pointer;<? if($datatugas['jenis']!='remidial'){?>border-top:1px solid #ccc;<?}?>" title="klik untuk menampilkan / menyembunyikan detail" onclick="getdetail(<?=$datatugas['id']?>,this,'detailtugassemua');">
													<td class="<?=$bordettop?>" ><? if($datatugas['jenis']!='remidial'){?><?=$no++;?><? } ?></td>
													<td class="<?=$bordettop?> title"><? if($datatugas['jenis']=='non_remidial'){echo "TUGAS Utama";}else{ echo "remidial";}?></td>
													<td class="<?=$bordettop?> title" ><?=$datatugas['judul']?></td>
													<td class="<?=$bordettop?> title" ><? 
													if(!empty($datatugas['dikirim'])){
														foreach($datatugas['dikirim'] as $dtdkrm){echo $dtdkrm['kelas'].$dtdkrm['nama_kelas']." &nbsp; ";}
													}else{
														echo 'Belum dikirim';
													}
													?></td>
													<td class="<?=$bordettop?>"><? $tg=tanggal($datatugas['tanggal_buat']." 00:00:00"); echo $tg[2];?></td>
													<td class="<?=$bordettop?>"><a style="cursor:pointer;">Lihat</a></td>
													<? if($kepsek!='kepsek'){?>
													<td class="<?=$bordettop?>" >
														<? if($datatugas['jenis']=='non_remidial'){?>
														<div class="actedittugas actedit" id_tugas="<?=$datatugas['id']?>" title="ubah" href="<?=base_url('akademik/kirimtugas/kirimtugasutamaedit/'.$datatugas['id'])?>"></div>
														<? }else{ ?>
														<div class="actedittugas actedit" id_tugas="<?=$datatugas['id']?>" title="ubah" href="<?=base_url('akademik/kirimtugas/kirimtugasremidialedit/'.$datatugas['id'])?>"></div> 
														<? } ?>
														<div class="actdell" id="actdelltugas" id_tugas="<?=$datatugas['id']?>"></div>
													</td>
													<?}?>
												</tr>
												<tr id="detailtugassemua<?=$datatugas['id']?>" style="display:none;">
													<td colspan="7" class="innercolspan">
														<div class="">
														<? 
														if(!empty($datatugas['dikirim'])){
															foreach($datatugas['dikirim'] as $dtdkrm){
																pengumpulan_akademik($dtdkrm['id_kelas'],$datatugas['id_sekolah'],$jenis='tugas',$datatugas['id'],$datatugas['id_pelajaran'],$dtdkrm['kelas'].$dtdkrm['nama_kelas']);
															}
														}
														?>
														<? 
														if($datatugas['jenis']=='remidial'){
															ikut_remidi($datatugas['id_kelas'],$datatugas['id'],$jenis='tugas');
														}
														?>
														<div class="full file">
														<h3 >Detail TUGAS</h3>
														<div class="hr"></div>
														<table class="noborder">
															<tr>
																<td class="title">Judul TUGAS</td>
																<td class="titikdua">:</td>
																<td class="value"><?=$datatugas['judul']?></td>
															</tr>
															<tr>
																<td class="title">Mata Pelajaran</td>
																<td class="titikdua">:</td>
																<td class="value"><?=$datatugas['nama_pelajaran']?></td>
															</tr>
															<tr>
																<td class="title">BAB</td>
																<td class="titikdua">:</td>
																<td class="value"><?=$datatugas['bab']?></td>
															</tr>
															<tr>
																<td class="title">Jenis</td>
																<td class="titikdua">:</td>
																<td class="value"><?=$datatugas['jenis']?></td>
															</tr>
															
														</table>
														</div>
														
														<div class="full file">
														<h3 >Lampiran</h3>
														<div class="hr"></div>
														<table class="noborder">
															<?
															if(!empty($datatugas['file'])){
															foreach($datatugas['file'] as $file){?>
															<tr>
																<td class="title"><a title="<?=$file['file_name']?>" href="<?=base_url('homepage/send_download/'.base64_encode('upload/akademik/tugas/').'/'.base64_encode($file['file_name']).'');?>" target="_self"><?=substr($file['file_name'],-30)?> Download</a>
																| <a target="file"  href="<?=base_url()?>akademik/nilai/view_document/null/null/null/null/null/<?=base64_encode(base_url('upload/akademik/tugas/'.$file['file_name']).'')?>">Lihat</a>
																</td>
															</tr>
															<? }} ?>
														</table>
														</div>
														
														<!--<div class="full file">
														<h3 >Keterangan</h3>
														<div class="hr"></div>
														<ul>
															<li><?=$datatugas['keterangan']?></li>
														</ul>
														</div>-->
														<br class="clear" />
														<!--<div id="komentartugas<?=$datatugas['id']?>"></div>-->
														</div>
													</td>
												</tr>
												<? } } ?>
											</tbody>
										</table>
										<div style="float:left;" id="paginationtugasilist" >
										<?=$link?>
										</div>										
										
									</div>
									<div class="tabs-frame-content tabs-frame-contenttugas">
										<div style="float:left;" id="paginationtugasilist" >
										<?=$link?>
										</div>											
										<table class="tugaslist">
											<thead>
												<tr> 
													<th>No</th>
													<th>Jenis</th>      
													<th>Judul</th>
													<th>Ke Kelas</th>
													<th>Waktu Upload</th>
													<? if($kepsek!='kepsek'){?>
													<th>Ubah | Hapus</th>
													<? } ?>
												</tr>                         
											</thead>
											<tbody>
												<? 
												//if(@$cur_page2==0){@$cur_page2=1;}
												//$noc=(@$cur_page2*@$per_page2)-@$per_page2+1;
												$noc=1;
												if(!empty($terkirim)){
												foreach($terkirim as $kt=>$datatugas){
													if($datatugas['jenis']!='remidial'){$bordettop="bordettop";}else{$bordettop="";}
												?>
												<tr style="cursor:pointer;<? if($datatugas['jenis']!='remidial'){?>border-top:1px solid #ccc;<?}?>" title="klik untuk menampilkan / menyembunyikan detail" onclick="getdetail(<?=$datatugas['id']?>,this,'detailtugasterkirim');">
													<td class="<?=$bordettop?>" ><? if($datatugas['jenis']!='remidial'){?><?=$noc++;?><? } ?></td>
													<td class="<?=$bordettop?> title"><? if($datatugas['jenis']=='non_remidial'){echo "TUGAS Utama";}else{ echo "remidial";}?></td>
													<td class="<?=$bordettop?> title" ><?=$datatugas['judul']?></td>
													<td class="<?=$bordettop?> title" ><? foreach($datatugas['dikirim'] as $dtdkrm){echo $dtdkrm['kelas'].$dtdkrm['nama_kelas']." &nbsp; ";}?></td>
													<td class="<?=$bordettop?>"><? $tg=tanggal($datatugas['tanggal_buat']." 00:00:00"); echo $tg[2];?></td>
													<? if($kepsek!='kepsek'){?>
													<td class="<?=$bordettop?>" >
														<? if($datatugas['jenis']=='non_remidial'){?>
														<div class="actedittugas actedit" id_tugas="<?=$datatugas['id']?>" title="ubah" href="<?=base_url('akademik/kirimtugas/kirimtugasutamaedit/'.$datatugas['id'])?>"></div>
														<? }else{ ?>
														<div class="actedittugas actedit" id_tugas="<?=$datatugas['id']?>" title="ubah" href="<?=base_url('akademik/kirimtugas/kirimtugasremidialedit/'.$datatugas['id'])?>"></div> 
														<? } ?>
														<div class="actdell" id="actdelltugas" id_tugas="<?=$datatugas['id']?>"></div>
													</td>
													<? } ?>
												</tr>
												<tr id="detailtugasterkirim<?=$datatugas['id']?>" style="display:none;">
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
																<? foreach($datatugas['dikirim'] as $dtdkrm){ $noo++;?>
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
														foreach($datatugas['dikirim'] as $dtdkrm){
															pengumpulan_akademik($dtdkrm['id_kelas'],$datatugas['id_sekolah'],$jenis='tugas',$datatugas['id'],$datatugas['id_pelajaran'],$dtdkrm['kelas'].$dtdkrm['nama_kelas']);
														}
														?>
														<? 
														if($datatugas['jenis']=='remidial'){
															ikut_remidi($datatugas['id_kelas'],$datatugas['id'],$jenis='tugas');
														}
														?>
														<div class="full file">
														<h3 >Detail TUGAS</h3>
														<div class="hr"></div>
														<table class="noborder">
															<tr>
																<td class="title">Judul TUGAS</td>
																<td class="titikdua">:</td>
																<td class="value"><?=$datatugas['judul']?></td>
															</tr>
															<tr>
																<td class="title">Mata Pelajaran</td>
																<td class="titikdua">:</td>
																<td class="value"><?=$datatugas['nama_pelajaran']?></td>
															</tr>
															<tr>
																<td class="title">BAB</td>
																<td class="titikdua">:</td>
																<td class="value"><?=$datatugas['bab']?></td>
															</tr>
															<tr>
																<td class="title">Jenis</td>
																<td class="titikdua">:</td>
																<td class="value"><?=$datatugas['jenis']?></td>
															</tr>
														</table>
														</div>
														
														<div class="full file">
														<h3 >Lampiran</h3>
														<div class="hr"></div>
														<table class="noborder">
															<?
															if(!empty($datatugas['file'])){
															foreach($datatugas['file'] as $file){?>
															<tr>
																<td class="title"><a title="<?=$file['file_name']?>" href="<?=base_url('homepage/send_download/'.base64_encode('upload/akademik/tugas/').'/'.base64_encode($file['file_name']).'');?>" target="_self"><?=substr($file['file_name'],-30)?> Download</a>
																| <a target="file"  href="<?=base_url()?>akademik/nilai/view_document/null/null/null/null/null/<?=base64_encode(base_url('upload/akademik/tugas/'.$file['file_name']).'')?>">Lihat</a>
																</td>
															</tr>
															<? } } ?>
														</table>
														</div>
														
														<!--<div class="full file">
														<h3 >Keterangan</h3>
														<div class="hr"></div>
														<ul>
															<li><?=$datatugas['keterangan']?></li>
														</ul>
														</div>-->
														<br class="clear" />
														<div id="komentartugas<?=$datatugas['id']?>"></div>
														</div>
													</td>
												</tr>
												<? } } ?>
											</tbody>
										</table>	
										<div style="float:left;" id="paginationtugasilist" >
										<?=$link?>
										</div>										
									</div>
									<div class="tabs-frame-content tabs-frame-contenttugas">
										<table>
											<thead>
													<tr>
														<th>No</th>
														<th>Nama</th>
														<th>Link</th>
													</tr>
											</thead>
											<tbody>
												<tr>
													<td style="text-align:left;width:1%;">1</td>
													<td style="text-align:left;">Template  Soal</td>
													<td><a href="<?=base_url('upload/akademik/template/TemplateTugas.docx')?>">Download</a></td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
								<? if($kepsek=='kepsek'){?>
								</div>
								<? } ?>