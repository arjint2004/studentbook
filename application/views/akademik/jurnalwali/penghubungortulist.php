
							<script>
							$(document).ready(function(){
								  $("#ajax_pagingss a").click(function() {
									var url = $(this).attr("href");
									var thisobj= $(this);
									$.ajax({
									  type: "POST",
									  data: "ajax=1&id_kelas="+$('select#idkelasp').val(),
									  url: url,
									  beforeSend: function() {
										$(thisobj).append("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
									  },
									  success: function(msg) {
										$("#wait").remove();
										$("#listpenghub").html(msg);
										$('#penghubungortu').scrollintoview({ speed:'1100'});
										//applyPagination();
									  }
									});
									return false;
								  });
								  
								  $(".actdellpeng").click(function() {
									var thisobj= $(this);
									if(confirm('anda yakin akan menghapus data ini ?')){
										$.ajax({
										  type: "POST",
										  data: "ajax=1&id="+$(thisobj).attr('id_peng'),
										  url: '<?=base_url()?>akademik/jurnalwali/deletepeng',
										  beforeSend: function() {
											$(thisobj).append("<img id='wait' class='waitpenghub' src='<?=$this->config->item('images').'loading.png';?>' />");
										  },
										  success: function(msg) {
											$.ajax({
												type: "POST",
												data: 'id_kelas='+$('select#idkelasp').val(),
												url: '<?=base_url('akademik/jurnalwali/penghubungortulist/0')?>',
												beforeSend: function() {
													$(".simpanlaporan").after("<img id='wait' class='waitpenghub' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
												},
												success: function(msg) {
													$(".waitpenghub").remove();
													$('select#idkelasp').val($('select#idkelasp').val());
													$('#listpenghub').html(msg);
													
													$('.listlap').show();
													$(this).children('a').addClass('current');
													$('#sendlap').children('a').removeClass('current');
													$('.sendlap').hide();
													$('#subject').scrollintoview({ speed:'1100'});
												}
											});
											//applyPagination();
										  }
										});
									}
									return false;
								  });
							
								$('#acteditpeng').click(function(e){
									$('#listpenghub').load('<?=base_url()?>akademik/jurnalwali/penghubungortuedit/'+$('#acteditpeng').attr('id_peng'));	
								});
							});
							
								function getdetailpeng(id,obj){
									$('#detailpengh'+id).toggle('fade');
									$('table.lap div.comment').remove();
									$(obj).prev('tr').hide();
									$(obj).next('tr').next('tr').next('tr').hide();
									$.ajax({
										type: "GET",
										data: '',
										url: '<?=base_url()?>akademik/comment/index/'+id+'/first/penghubung',
										beforeSend: function() {
											//$("#filterpelajaranpr select#kelas").after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
											
										},
										success: function(msg) {
											//$("#wait").remove();
											$('#komentarpengh'+id).html(msg);	
										}
									});
									return false;
								}
							</script>
							<? //pr($datahubung);?>
							<div id="ajax_pagingss">
								<?php echo $pagination; ?>
							</div>
                            <table class="adddata lap">
									<tbody>
										<thead>
										<tr>
											<th>No</th>
											<th>Subject</th>
											<th>Kelas</th>
											<th>Action</th>
										</tr>
										</thead>
										<? $i=0; foreach($datahubung as $datapengh){ $i++;?>
										<tr onclick="getdetailpeng(<?=$datapengh['id']?>,this);" style="cursor:pointer;" title="Klik untuk melihat selengkapnya">
											<td class="bordettop  center"><?=$i+$start?></td>
											<td class="bordettop  title" ><?=$datapengh['subject']?></td>
											<td class="bordettop  center" ><?=$datapengh['kelas']?><?=$datapengh['nama']?></td>
											<td class="bordettop center" >
												<!--<div title="ubah" id_peng="<?=$datapengh['id']?>" id="acteditpeng" class="acteditpeng actedit"></div>-->
												<div id_peng="<?=$datapengh['id']?>" id="actdellpeng" class="actdellpeng actdell"></div>
											</td>
										</tr>
										<tr  id="detailpengh<?=$datapengh['id']?>" style="display:none;">
											<td class="innercolspan" colspan="4">
													<div>
													<div class="full file">
														<h3>Dikirim Ke</h3>
														<div class="hr"></div>
														
														<div style="margin:0;min-height:50px;max-height:200px;overflow:auto;border:none;" class="full file">
														<table class="noborder">
														<thead>
															<tr>
																<th>No</th>
																<th>Nama</th>
																<th>Kepada</th>
															</tr>
														</thead>
														<tbody>
														<?$ii=1; foreach($datapengh['siswa'] as $sis){?>
															<tr>
																<td><?=$ii++?></td>
																<td><?=$sis['nama']?></td>
																<td><? if($sis['siswaortu']=='siswaortu'){echo 'Siswa & Ortu';}else{ echo $sis['siswaortu'];}?></td>
															</tr>
														<? } ?>
														</tbody>
														</table>
													</div>
													</div>
													
													<div class="full file">
													<h3 >Lampiran</h3>
													<div class="hr"></div>
													<table class="noborder">
														<?foreach($datapengh['file'] as $file){?>
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
														<li><?=$datapengh['keterangan']?></li>
													</ul>
													</div>
													<br class="clear" />
													<div id="komentarpengh<?=$datapengh['id']?>"></div>
													</div>
											</td>
										</tr>
										<? } ?>
									</tbody>
							</table>
							
							<div id="ajax_pagingss">
								<?php echo $pagination; ?>
							</div>