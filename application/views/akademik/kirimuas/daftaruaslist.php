								<script>
								$(document).ready(function(){
									if($('ul.tabs-frameuas').length > 0) $('ul.tabs-frameuas').tabs('> .tabs-frame-contentuas');
									$("div#actdelluas").click(function(){
											var objdell=$(this);
											if(confirm('Data dan File akan di hapus secara permanen, untuk menggunakannya kembali anda harus upload ulang..')){
												$.ajax({
													type: "POST",
													data: '',
													url: base_url+'akademik/kirimuas/delete/'+$(this).attr('id_uas'),
													beforeSend: function() {
														$(objdell).after("<img id='waituas7' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
													},
													success: function(msg) {
														$("#waituas7").remove();	
														if(msg==1){
															//$(objdell).parent('td').parent('tr').next().remove();
															//$(objdell).parent('td').parent('tr').remove();
															$.ajax({
																	type: "POST",
																	data: 'id_kelas='+$('select#kelasuas').val()+'&pelajaran='+$('select#pelajaranuas').val()+'&ajax=1',
																	url: '<?=base_url()?>akademik/kirimuas/daftaruaslist',
																	beforeSend: function() {
																		$(objdell).after("<img id='waituas8' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
																	},
																	success: function(msg) {
																		$("#waituas8").remove();
																		//$('select#kelasuas').val('');
																		//$('select#pelajaranuas').html($('select#pelajaran_adduas').html());
																		//$('select#pelajaranuas').val('');
																		$('#subjectlistuas').html(msg);
																	}
															});
														}
													}
												});
												return false;
											}
									});	
									
									$("div.actedituas").click(function(){
											var objdell=$(this);
											$.ajax({
													type: "POST",
													data: '',
													url: $(objdell).attr('href'),
													beforeSend: function() {
														$(objdell).after("<img id='waituas9' style='margin:0;'  src='<?=$this->config->item('images').'loading.png';?>' />");
													},
													success: function(msg) {
														$("#waituas9").remove();
														$('#subjectlistuas').html(msg);
													}
											});
										});
								});
								function getdetail(id,obj,ident){
									$('#'+ident+id).toggle('fade');
									$('table.uaslist div.comment').remove();
									$(obj).prev('tr').hide();
									$(obj).next('tr').next('tr').next('tr').hide();
									$.ajax({
										type: "GET",
										data: '',
										url: '<?=base_url()?>akademik/comment/index/'+id+'/first/uas',
										beforeSend: function() {
											//$("#filterpelajaranuas select#kelas").after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
											
										},
										success: function(msg) {
											//$("#wait").remove();
											$('#komentaruas'+id).html(msg);	
										}
									});
									return false;
								}
								</script>
								<? //uas($uas);?>
							   

								
								<div class="tabs-container">
									<ul class="tabs-frame tabs-frameuas">
										<li><a href="#">Semua arsip uas</a></li>
										<li><a href="#">uas Terkirim</a></li>
									</ul>
									<div class="tabs-frame-content tabs-frame-contentuas ">
									<table class="uaslist">
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
												if(!empty($uas)){
												foreach($uas as $kt=>$datauas){
													if($datauas['jenis']!='remidial'){$bordettop="bordettop";}else{$bordettop="";}
												?>
												<tr style="cursor:pointer;<? if($datauas['jenis']!='remidial'){?>border-top:1px solid #ccc;<?}?>" title="klik untuk menampilkan / menyembunyikan detail" onclick="getdetail(<?=$datauas['id']?>,this,'detailuassemua');">
													<td class="<?=$bordettop?>" ><? if($datauas['jenis']!='remidial'){?><?=$no++;?><? } ?></td>
													<td class="<?=$bordettop?> title"><? if($datauas['jenis']=='non_remidial'){echo "uas Utama";}else{ echo "remidial";}?></td>
													<td class="<?=$bordettop?> title" ><?=$datauas['judul']?></td>
													<td class="<?=$bordettop?> title" ><? 
													if(!empty($datauas['dikirim'])){
														foreach($datauas['dikirim'] as $dtdkrm){echo $dtdkrm['kelas'].$dtdkrm['nama_kelas']." &nbsp; ";}
													}else{
														echo 'Belum dikirim';
													}
													?></td>
													<td class="<?=$bordettop?>"><? $tg=tanggal($datauas['tanggal_buat']." 00:00:00"); echo $tg[2];?></td>
													<td class="<?=$bordettop?>" >
														<? if($datauas['jenis']=='non_remidial'){?>
														<div class="actedituas actedit" id_uas="<?=$datauas['id']?>" title="ubah" href="<?=base_url('akademik/kirimuas/kirimuasutamaedit/'.$datauas['id'])?>"></div>
														<? }else{ ?>
														<div class="actedituas actedit" id_uas="<?=$datauas['id']?>" title="ubah" href="<?=base_url('akademik/kirimuas/kirimuasremidialedit/'.$datauas['id'])?>"></div> 
														<? } ?>
														<div class="actdell" id="actdelluas" id_uas="<?=$datauas['id']?>"></div>
													</td>
												</tr>
												<tr id="detailuassemua<?=$datauas['id']?>" style="display:none;">
													<td colspan="6" class="innercolspan">
														<div class="">
														<? 
														if(!empty($datauas['dikirim'])){
															foreach($datauas['dikirim'] as $dtdkrm){
																pengumpulan_akademik($dtdkrm['id_kelas'],$datauas['id_sekolah'],$jenis='uas',$datauas['id'],$datauas['id_pelajaran'],$dtdkrm['kelas'].$dtdkrm['nama_kelas']);
															}
														}
														?>
														<? 
														if($datauas['jenis']=='remidial'){
															ikut_remidi($datauas['id_kelas'],$datauas['id'],$jenis='uas');
														}
														?>
														<div class="full file">
														<h3 >Detail uas</h3>
														<div class="hr"></div>
														<table class="noborder">
															<tr>
																<td class="title">Judul uas</td>
																<td class="titikdua">:</td>
																<td class="value"><?=$datauas['judul']?></td>
															</tr>
															<tr>
																<td class="title">Mata Pelajaran</td>
																<td class="titikdua">:</td>
																<td class="value"><?=$datauas['nama_pelajaran']?></td>
															</tr>
															<tr>
																<td class="title">BAB</td>
																<td class="titikdua">:</td>
																<td class="value"><?=$datauas['bab']?></td>
															</tr>
															<tr>
																<td class="title">Jenis</td>
																<td class="titikdua">:</td>
																<td class="value"><?=$datauas['jenis']?></td>
															</tr>
															
														</table>
														</div>
														
														<div class="full file">
														<h3 >Lampiran</h3>
														<div class="hr"></div>
														<table class="noborder">
															<?foreach($datauas['file'] as $file){?>
															<tr>
																<td class="title"><a title="<?=$file['file_name']?>" href="<?=base_url('homepage/send_download/'.base64_encode('upload/akademik/uas/').'/'.base64_encode($file['file_name']).'');?>" target="_self"><?=substr($file['file_name'],-30)?> Download</a>
																| <a target="file"  href="<?=base_url()?>akademik/nilai/view_document/null/null/null/null/null/<?=base64_encode(base_url('upload/akademik/uas/'.$file['file_name']).'')?>">Lihat</a>
																</td>
															</tr>
															<? } ?>
														</table>
														</div>
														
														<!--<div class="full file">
														<h3 >Keterangan</h3>
														<div class="hr"></div>
														<ul>
															<li><?=$datauas['keterangan']?></li>
														</ul>
														</div>-->
														<br class="clear" />
														<!--<div id="komentaruas<?=$datauas['id']?>"></div>-->
														</div>
													</td>
												</tr>
												<? } } ?>
											</tbody>
										</table>			
									</div>
									<div class="tabs-frame-content tabs-frame-contentuas">
										<table class="uaslist">
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
												foreach($terkirim as $kt=>$datauas){
													if($datauas['jenis']!='remidial'){$bordettop="bordettop";}else{$bordettop="";}
												?>
												<tr style="cursor:pointer;<? if($datauas['jenis']!='remidial'){?>border-top:1px solid #ccc;<?}?>" title="klik untuk menampilkan / menyembunyikan detail" onclick="getdetail(<?=$datauas['id']?>,this,'detailuasterkirim');">
													<td class="<?=$bordettop?>" ><? if($datauas['jenis']!='remidial'){?><?=$no++;?><? } ?></td>
													<td class="<?=$bordettop?> title"><? if($datauas['jenis']=='non_remidial'){echo "uas Utama";}else{ echo "remidial";}?></td>
													<td class="<?=$bordettop?> title" ><?=$datauas['judul']?></td>
													<td class="<?=$bordettop?> title" ><? foreach($datauas['dikirim'] as $dtdkrm){echo $dtdkrm['kelas'].$dtdkrm['nama_kelas']." &nbsp; ";}?></td>
													<td class="<?=$bordettop?>"><? $tg=tanggal($datauas['tanggal_buat']." 00:00:00"); echo $tg[2];?></td>
													<td class="<?=$bordettop?>" >
														<? if($datauas['jenis']=='non_remidial'){?>
														<div class="actedituas actedit" id_uas="<?=$datauas['id']?>" title="ubah" href="<?=base_url('akademik/kirimuas/kirimuasutamaedit/'.$datauas['id'])?>"></div>
														<? }else{ ?>
														<div class="actedituas actedit" id_uas="<?=$datauas['id']?>" title="ubah" href="<?=base_url('akademik/kirimuas/kirimuasremidialedit/'.$datauas['id'])?>"></div> 
														<? } ?>
														<div class="actdell" id="actdelluas" id_uas="<?=$datauas['id']?>"></div>
													</td>
												</tr>
												<tr id="detailuasterkirim<?=$datauas['id']?>" style="display:none;">
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
																<? foreach($datauas['dikirim'] as $dtdkrm){ $noo++;?>
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
														foreach($datauas['dikirim'] as $dtdkrm){
															pengumpulan_akademik($dtdkrm['id_kelas'],$datauas['id_sekolah'],$jenis='uas',$datauas['id'],$datauas['id_pelajaran'],$dtdkrm['kelas'].$dtdkrm['nama_kelas']);
														}
														?>
														<? 
														if($datauas['jenis']=='remidial'){
															ikut_remidi($datauas['id_kelas'],$datauas['id'],$jenis='uas');
														}
														?>
														<div class="full file">
														<h3 >Detail uas</h3>
														<div class="hr"></div>
														<table class="noborder">
															<tr>
																<td class="title">Judul uas</td>
																<td class="titikdua">:</td>
																<td class="value"><?=$datauas['judul']?></td>
															</tr>
															<tr>
																<td class="title">Mata Pelajaran</td>
																<td class="titikdua">:</td>
																<td class="value"><?=$datauas['nama_pelajaran']?></td>
															</tr>
															<tr>
																<td class="title">BAB</td>
																<td class="titikdua">:</td>
																<td class="value"><?=$datauas['bab']?></td>
															</tr>
															<tr>
																<td class="title">Jenis</td>
																<td class="titikdua">:</td>
																<td class="value"><?=$datauas['jenis']?></td>
															</tr>
														</table>
														</div>
														
														<div class="full file">
														<h3 >Lampiran</h3>
														<div class="hr"></div>
														<table class="noborder">
															<?foreach($datauas['file'] as $file){?>
															<tr>
																<td class="title"><a title="<?=$file['file_name']?>" href="<?=base_url('homepage/send_download/'.base64_encode('upload/akademik/uas/').'/'.base64_encode($file['file_name']).'');?>" target="_self"><?=substr($file['file_name'],-30)?> Download</a>
																| <a target="file"  href="<?=base_url()?>akademik/nilai/view_document/null/null/null/null/null/<?=base64_encode(base_url('upload/akademik/uas/'.$file['file_name']).'')?>">Lihat</a>
																</td>
															</tr>
															<? } ?>
														</table>
														</div>
														
														<!--<div class="full file">
														<h3 >Keterangan</h3>
														<div class="hr"></div>
														<ul>
															<li><?=$datauas['keterangan']?></li>
														</ul>
														</div>-->
														<br class="clear" />
														<div id="komentaruas<?=$datauas['id']?>"></div>
														</div>
													</td>
												</tr>
												<? } } ?>
											</tbody>
										</table>									
									</div>
								</div>