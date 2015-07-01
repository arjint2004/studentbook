								<script>
								$(document).ready(function(){
									if($('ul.tabs-framepr').length > 0) $('ul.tabs-framepr').tabs('> .tabs-frame-contentpr');
									$("div#actdellpr").click(function(){
											var objdell=$(this);
											if(confirm('Data dan File akan di hapus secara permanen, untuk menggunakannya kembali anda harus upload ulang..')){
												$.ajax({
													type: "POST",
													data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&',
													url: base_url+'akademik/kirimpr/delete/'+$(this).attr('id_pr'),
													beforeSend: function() {
														$(objdell).after("<img id='waitpr7' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
													},
													success: function(msg) {
														$("#waitpr7").remove();	
														if(msg==1){
															//$(objdell).parent('td').parent('tr').next().remove();
															//$(objdell).parent('td').parent('tr').remove();
															$.ajax({
																	type: "POST",
																	data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&id_kelas='+$('select#kelaspr').val()+'&pelajaran='+$('select#pelajaranpr').val()+'&ajax=1',
																	url: '<?=base_url()?>akademik/kirimpr/daftarprlist',
																	beforeSend: function() {
																		$(objdell).after("<img id='waitpr8' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
																	},
																	success: function(msg) {
																		$("#waitpr8").remove();
																		//$('select#kelaspr').val('');
																		//$('select#pelajaranpr').html($('select#pelajaran_addpr').html());
																		//$('select#pelajaranpr').val('');
																		$('#subjectlistpr').html(msg);
																	}
															});
														}
													}
												});
												return false;
											}
									});	
									
									$("div.acteditpr").click(function(){
											var objdell=$(this);
											$.ajax({
													type: "POST",
													data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&',
													url: $(objdell).attr('href'),
													beforeSend: function() {
														$(objdell).after("<img id='waitpr9' style='margin:0;'  src='<?=$this->config->item('images').'loading.png';?>' />");
													},
													success: function(msg) {
														$("#waitpr9").remove();
														$('#subjectlistpr').html(msg);
													}
											});
									});
										
										

									$("div#paginationprilist a").click(function(){
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
												$("#subjectlistpr").html(msg);
												//$('#subjectpembelajaran').scrollintoview({ speed:'1100'});
											}
										});
										return false;
									});			
								});
								function getdetail(id,obj,ident){
									$('#'+ident+id).toggle('fade');
									$('table.prlist div.comment').remove();
									$(obj).prev('tr').hide();
									$(obj).next('tr').next('tr').next('tr').hide();
									$.ajax({
										type: "GET",
										data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&',
										url: '<?=base_url()?>akademik/comment/index/'+id+'/first/pr',
										beforeSend: function() {
											//$("#filterpelajaranpr select#kelas").after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
											
										},
										success: function(msg) {
											//$("#wait").remove();
											$('#komentarpr'+id).html(msg);	
										}
									});
									return false;
								}
								</script>
								<? //pr($pr);?>
								<? if($kepsek=='kepsek' && $page==0){?>
								<div id="subjectlistpr" style="min-width:700px;">	
								<? } ?>	
								<div class="tabs-container">
									<ul class="tabs-frame tabs-framepr">
										<li><a href="#">Semua arsip PR</a></li>
										<li><a href="#">PR Terkirim</a></li>
										<li><a href="#">Download</a></li>
									</ul>
									<div class="tabs-frame-content tabs-frame-contentpr ">
									<div style="float:left;" id="paginationprilist" >
									<?=$link?>
									</div>										
									<table class="prlist">
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
												if(!empty($pr)){
												foreach($pr as $kt=>$datapr){
													if($datapr['jenis']!='remidial'){$bordettop="bordettop";}else{$bordettop="";}
												?>
												<tr style="cursor:pointer;<? if($datapr['jenis']!='remidial'){?>border-top:1px solid #ccc;<?}?>" title="klik untuk menampilkan / menyembunyikan detail" onclick="getdetail(<?=$datapr['id']?>,this,'detailprsemua');">
													<td class="<?=$bordettop?>" ><? if($datapr['jenis']!='remidial'){?><?=$no++;?><? } ?></td>
													<td class="<?=$bordettop?> title"><? if($datapr['jenis']=='non_remidial'){echo "PR Utama";}else{ echo "remidial";}?></td>
													<td class="<?=$bordettop?> title" ><?=$datapr['judul']?></td>
													<td class="<?=$bordettop?> title" ><? 
													if(!empty($datapr['dikirim'])){
														foreach($datapr['dikirim'] as $dtdkrm){echo $dtdkrm['kelas'].$dtdkrm['nama_kelas']." &nbsp; ";}
													}else{
														echo 'Belum dikirim';
													}
													?></td>
													<td class="<?=$bordettop?>"><? $tg=tanggal($datapr['tanggal_buat']." 00:00:00"); echo $tg[2];?></td>
													<td class="<?=$bordettop?>"><a style="cursor:pointer;">Lihat</a></td>
													<? if($kepsek!='kepsek'){?>
													<td class="<?=$bordettop?>" >
														<? if($datapr['jenis']=='non_remidial'){?>
														<div class="acteditpr actedit" id_pr="<?=$datapr['id']?>" title="ubah" href="<?=base_url('akademik/kirimpr/kirimprutamaedit/'.$datapr['id'])?>"></div>
														<? }else{ ?>
														<div class="acteditpr actedit" id_pr="<?=$datapr['id']?>" title="ubah" href="<?=base_url('akademik/kirimpr/kirimprremidialedit/'.$datapr['id'])?>"></div> 
														<? } ?>
														<div class="actdell" id="actdellpr" id_pr="<?=$datapr['id']?>"></div>
													</td>
													<?}?>
												</tr>
												<tr id="detailprsemua<?=$datapr['id']?>" style="display:none;">
													<td colspan="7" class="innercolspan">
														<div class="">
														<? 
														if(!empty($datapr['dikirim'])){
															foreach($datapr['dikirim'] as $dtdkrm){
																pengumpulan_akademik($dtdkrm['id_kelas'],$datapr['id_sekolah'],$jenis='pr',$datapr['id'],$datapr['id_pelajaran'],$dtdkrm['kelas'].$dtdkrm['nama_kelas']);
															}
														}
														?>
														<? 
														if($datapr['jenis']=='remidial'){
															ikut_remidi($datapr['id_kelas'],$datapr['id'],$jenis='pr');
														}
														?>
														<div class="full file">
														<h3 >Detail PR</h3>
														<div class="hr"></div>
														<table class="noborder">
															<tr>
																<td class="title">Judul PR</td>
																<td class="titikdua">:</td>
																<td class="value"><?=$datapr['judul']?></td>
															</tr>
															<tr>
																<td class="title">Mata Pelajaran</td>
																<td class="titikdua">:</td>
																<td class="value"><?=$datapr['nama_pelajaran']?></td>
															</tr>
															<tr>
																<td class="title">BAB</td>
																<td class="titikdua">:</td>
																<td class="value"><?=$datapr['bab']?></td>
															</tr>
															<tr>
																<td class="title">Jenis</td>
																<td class="titikdua">:</td>
																<td class="value"><?=$datapr['jenis']?></td>
															</tr>
															
														</table>
														</div>
														
														<div class="full file">
														<h3 >Lampiran</h3>
														<div class="hr"></div>
														<table class="noborder">
															<?
															if(!empty($datapr['file'])){
															foreach($datapr['file'] as $file){?>
															<tr>
																<td class="title"><a title="<?=$file['file_name']?>" href="<?=base_url('homepage/send_download/'.base64_encode('upload/akademik/pr/').'/'.base64_encode($file['file_name']).'');?>" target="_self"><?=substr($file['file_name'],-30)?> Download</a>
																| <a target="file"  href="<?=base_url()?>akademik/nilai/view_document/null/null/null/null/null/<?=base64_encode(base_url('upload/akademik/pr/'.$file['file_name']).'')?>">Lihat</a>
																</td>
															</tr>
															<? }} ?>
														</table>
														</div>
														
														<!--<div class="full file">
														<h3 >Keterangan</h3>
														<div class="hr"></div>
														<ul>
															<li><?=$datapr['keterangan']?></li>
														</ul>
														</div>-->
														<br class="clear" />
														<!--<div id="komentarpr<?=$datapr['id']?>"></div>-->
														</div>
													</td>
												</tr>
												<? } } ?>
											</tbody>
										</table>
										<div style="float:left;" id="paginationprilist" >
										<?=$link?>
										</div>										
										
									</div>
									<div class="tabs-frame-content tabs-frame-contentpr">
										<div style="float:left;" id="paginationprilist" >
										<?=$link?>
										</div>											
										<table class="prlist">
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
												foreach($terkirim as $kt=>$datapr){
													if($datapr['jenis']!='remidial'){$bordettop="bordettop";}else{$bordettop="";}
												?>
												<tr style="cursor:pointer;<? if($datapr['jenis']!='remidial'){?>border-top:1px solid #ccc;<?}?>" title="klik untuk menampilkan / menyembunyikan detail" onclick="getdetail(<?=$datapr['id']?>,this,'detailprterkirim');">
													<td class="<?=$bordettop?>" ><? if($datapr['jenis']!='remidial'){?><?=$noc++;?><? } ?></td>
													<td class="<?=$bordettop?> title"><? if($datapr['jenis']=='non_remidial'){echo "PR Utama";}else{ echo "remidial";}?></td>
													<td class="<?=$bordettop?> title" ><?=$datapr['judul']?></td>
													<td class="<?=$bordettop?> title" ><? foreach($datapr['dikirim'] as $dtdkrm){echo $dtdkrm['kelas'].$dtdkrm['nama_kelas']." &nbsp; ";}?></td>
													<td class="<?=$bordettop?>"><? $tg=tanggal($datapr['tanggal_buat']." 00:00:00"); echo $tg[2];?></td>
													<? if($kepsek!='kepsek'){?>
													<td class="<?=$bordettop?>" >
														<? if($datapr['jenis']=='non_remidial'){?>
														<div class="acteditpr actedit" id_pr="<?=$datapr['id']?>" title="ubah" href="<?=base_url('akademik/kirimpr/kirimprutamaedit/'.$datapr['id'])?>"></div>
														<? }else{ ?>
														<div class="acteditpr actedit" id_pr="<?=$datapr['id']?>" title="ubah" href="<?=base_url('akademik/kirimpr/kirimprremidialedit/'.$datapr['id'])?>"></div> 
														<? } ?>
														<div class="actdell" id="actdellpr" id_pr="<?=$datapr['id']?>"></div>
													</td>
													<? } ?>
												</tr>
												<tr id="detailprterkirim<?=$datapr['id']?>" style="display:none;">
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
																<? foreach($datapr['dikirim'] as $dtdkrm){ $noo++;?>
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
														foreach($datapr['dikirim'] as $dtdkrm){
															pengumpulan_akademik($dtdkrm['id_kelas'],$datapr['id_sekolah'],$jenis='pr',$datapr['id'],$datapr['id_pelajaran'],$dtdkrm['kelas'].$dtdkrm['nama_kelas']);
														}
														?>
														<? 
														if($datapr['jenis']=='remidial'){
															ikut_remidi($datapr['id_kelas'],$datapr['id'],$jenis='pr');
														}
														?>
														<div class="full file">
														<h3 >Detail PR</h3>
														<div class="hr"></div>
														<table class="noborder">
															<tr>
																<td class="title">Judul PR</td>
																<td class="titikdua">:</td>
																<td class="value"><?=$datapr['judul']?></td>
															</tr>
															<tr>
																<td class="title">Mata Pelajaran</td>
																<td class="titikdua">:</td>
																<td class="value"><?=$datapr['nama_pelajaran']?></td>
															</tr>
															<tr>
																<td class="title">BAB</td>
																<td class="titikdua">:</td>
																<td class="value"><?=$datapr['bab']?></td>
															</tr>
															<tr>
																<td class="title">Jenis</td>
																<td class="titikdua">:</td>
																<td class="value"><?=$datapr['jenis']?></td>
															</tr>
														</table>
														</div>
														
														<div class="full file">
														<h3 >Lampiran</h3>
														<div class="hr"></div>
														<table class="noborder">
															<?
															if(!empty($datapr['file'])){
															foreach($datapr['file'] as $file){?>
															<tr>
																<td class="title"><a title="<?=$file['file_name']?>" href="<?=base_url('homepage/send_download/'.base64_encode('upload/akademik/pr/').'/'.base64_encode($file['file_name']).'');?>" target="_self"><?=substr($file['file_name'],-30)?> Download</a>
																| <a target="file"  href="<?=base_url()?>akademik/nilai/view_document/null/null/null/null/null/<?=base64_encode(base_url('upload/akademik/pr/'.$file['file_name']).'')?>">Lihat</a>
																</td>
															</tr>
															<? } } ?>
														</table>
														</div>
														
														<!--<div class="full file">
														<h3 >Keterangan</h3>
														<div class="hr"></div>
														<ul>
															<li><?=$datapr['keterangan']?></li>
														</ul>
														</div>-->
														<br class="clear" />
														<div id="komentarpr<?=$datapr['id']?>"></div>
														</div>
													</td>
												</tr>
												<? } } ?>
											</tbody>
										</table>	
										<div style="float:left;" id="paginationprilist" >
										<?=$link?>
										</div>										
									</div>
									<div class="tabs-frame-content tabs-frame-contentpr">
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
													<td><a href="<?=base_url('upload/akademik/template/TemplatePr.docx')?>">Download</a></td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
								<? if($kepsek=='kepsek'){?>
								</div>
								<? } ?>