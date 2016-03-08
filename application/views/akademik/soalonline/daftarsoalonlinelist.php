								<script>
										function getdetail(id,objk,all){
											var obj=$(objk).parent('tr');
											if(all=='all'){
												$('#detailsoalonlineall'+id).toggle('fade');
											}else{
												$('#detailsoalonline'+id).toggle('fade');
											}
											//$('table.soalonlinelist div.comment').remove();
											$(obj).prev('tr').hide();
											$(obj).next('tr').next('tr').next('tr').hide();
											$.ajax({
												type: "GET",
												data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&',
												url: '<?=base_url()?>akademik/comment/index/'+id+'/first/soalonline',
												beforeSend: function() {
													//$("#filterpelajaranpr select#kelas").after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
													
												},
												success: function(msg) {
													//$("#wait").remove();
													
													if(all=='all'){
														//$('#komentarall'+id).html(msg);	
													}else{
														$('#komentar'+id).html(msg);	
													}
												}
											});
											return false;
										}
									$(document).ready(function(){
										//Submit Start
										if($('ul.tabs-frame2').length > 0) $('ul.tabs-frame2').tabs('> .tabs-frame-content2');
										$("div.acteditsoalonline").click(function(){
											var objdell=$(this);
											$.ajax({
													type: "POST",
													data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&',
													url: '<?=base_url('akademik/soalonline/editsoalonline')?>/'+$(this).attr('id_soalonline'),
													beforeSend: function() {
														$(objdell).after("<img class='wait' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
													},
													success: function(msg) {
														$(".wait").remove();
														$('#subjectlistsoalonline').html(msg);
													}
											});
										});	
										$("ul.file div.actdell").click(function(){
											var objdell=$(this);
											if(confirm('File akan di hapus secara permanen, untuk menggunakannya kembali anda harus upload ulang..')){
												$.ajax({
													type: "POST",
													data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&',
													url: base_url+'akademik/perencanaan/deletefiletimelinepemb/'+$(this).attr('id'),
													beforeSend: function() {
														$(objdell).after("<img class='wait' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
													},
													success: function(msg) {
														$(".wait").remove();	
														$(objdell).parent().remove();
													}
												});
												return false;
											}
										});
										$("div#paginationsoalonlinelist a").click(function(){
											var objdell=$(this);
											
												$.ajax({
													type: "POST",
													data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&id_pengguna=<?=@$id_pengguna?>&kepsek=<?=@$kepsek?>',
													url: $(objdell).attr('href'),
													beforeSend: function() {
														$(objdell).after("<img class='wait' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
													},
													success: function(msg) {
														$("#subjectlistsoalonline").html(msg);
														//$("#fancybox-content").html(msg);
														$(".wait").remove();	
													}
												});
												return false;
										});	
										$("div#paginationsoalonlinelistk a").click(function(){
											var objdell=$(this);
											
												$.ajax({
													type: "POST",
													data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&',
													url: $(objdell).attr('href'),
													beforeSend: function() {
														$(objdell).after("<img class='wait' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
													},
													success: function(msg) {
														$(".wait").remove();	
														$("#subjectlistsoalonline").html(msg);
													}
												});
												return false;
										});	
										
										$("div.actdellsoalonline").click(function(){
											var objdell=$(this);
											if(confirm('Data dan File akan di hapus secara permanen, untuk menggunakannya kembali anda harus upload ulang..')){
												$.ajax({
													type: "POST",
													data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&',
													url: base_url+'akademik/soalonline/delete/'+$(this).attr('id_soalonline'),
													beforeSend: function() {
														$(objdell).after("<img id='wait' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
													},
													success: function(msg) {
														$("#wait").remove();	
														if(msg==1){
															$(objdell).parent('td').parent('tr').remove();
															$('table tr#detailsoalonlineall'+$(objdell).attr('id_soalonline')).remove();
														}
													}
												});
												return false;
											}
										});	
									});
								</script>
								<? //pr($soalonline);?>
							   

<? //pr($soalonline);?>		
<? if($kepsek=='kepsek'){?>
<div id="subjectlistsoalonline">	
<? } ?>			
<div class="tabs-container">
    <ul class="tabs-frame tabs-frame2">
        <li><a href="#">Semua Soalonline</a></li>
        <li><a href="#">Terkirim</a></li>
    </ul>
    <div class="tabs-frame-content tabs-frame-content2 ">
		
								<div style="float:left;" id="paginationsoalonlinelist" >
								<?=$link?>
								</div>
									<table class="soalonlinelist" style="margin:0;">
										<thead>
											<tr> 
												<th>No</th>      
												<th>Judul</th>
												<th>Pelajaran</th>
												<th>Dikirim Ke</th>
												<th>Tgl Upload</th>
												<th style="width:37px;">Detail</th>
												<th style="width:37px;">Kunci Jawaban</th>
												<? if($kepsek!='kepsek'){?>
												<th style="width:75px;">Ubah|Hapus</th>
												<? } ?>
											</tr>                         
										</thead>
										<tbody>
											<? 
											if(@$cur_page==0){@$cur_page=1;}
											$no=(@$cur_page*@$per_page)-@$per_page+1;
											foreach($soalonline as $kt=>$datasoalonline){?>
											<tr style="cursor:pointer;" title="klik untuk menampilkan / menyembunyikan detail">
												<td><?=$no++;?></td>
												<td class="title" ><?=$datasoalonline['pokok_bahasan']?></td>
												<td class="title" ><?=$datasoalonline['pelajaran']?></td>
												<td class="title" ><? 
													if(!empty($datasoalonline['dikirim'])){
														foreach($datasoalonline['dikirim'] as $dtdkrm){echo $dtdkrm['kelas'].$dtdkrm['nama_kelas']." &nbsp; ";}
													}else{
														echo 'Belum dikirim';
													}
													?></td>
												<td ><? $tg=tanggal($datasoalonline['tanggal_buat']." 00:00:00"); echo $tg[2];?></td>
												<td  onclick="getdetail(<?=$datasoalonline['id']?>,this,'all');" ><a style="cursor:pointer;">Lihat</a></td>
												<td >
												<a title="" href="<?=base_url('akademik/soalonline/kuncijawaban/'.$datasoalonline['id'].'')?>" class="readmore modal" id="buat_kunci_<?=$datasoalonline['id']?>">Kunci</a>
												</td>
												<? if($kepsek!='kepsek'){?>
												<td >
													<div class="actedit acteditsoalonline" id_soalonline="<?=$datasoalonline['id']?>"></div> 
													<div class="actdell actdellsoalonline" id_soalonline="<?=$datasoalonline['id']?>"></div>
												
												</td>
												<? } ?>
											</tr>
											
											<tr id="detailsoalonlineall<?=$datasoalonline['id']?>" style="display:none;">
												<td colspan="8" class="innercolspan">
													<div class="">
													<div class="full file">
													<h3 >Detail MATERI</h3>
													<div class="hr"></div>
													<table class="noborder">
														
														<tr>
															<td class="title">Pokok Bahasan</td>
															<td class="titikdua">:</td>
															<td class="value"><?=$datasoalonline['pokok_bahasan']?></td>
														</tr>
														<tr>
															<td class="title">Bab</td>
															<td class="titikdua">:</td>
															<td class="value"><?=$datasoalonline['bab']?></td>
														</tr>
														<? if(isset($datasoalonline['dikirim'])){?>
														<tr>
															<td class="title">Telah dikirim ke kelas</td>
															<td class="titikdua">:</td>
															<td class="value"><? foreach($datasoalonline['dikirim'] as $dtdkrm){echo $dtdkrm['kelas'].$dtdkrm['nama_kelas']." &nbsp; ";}?></td>
														</tr>
														<? } ?>
														<!--<tr>
															<td class="title">Tanggal Diberikan</td>
															<td class="titikdua">:</td>
															<td class="value"><?=$datasoalonline['tanggal_diberikan']?></td>
														</tr>
														<tr>
															<td class="title">Tanggal Diajarkan</td>
															<td class="titikdua">:</td>
															<td class="value"><?=$datasoalonline['tanggal_buat']?></td>
														</tr>-->
													</table>
													</div>
													
													<div class="full file">
													<h3 >Lampiran</h3>
													<div class="hr"></div>
													<table class="noborder">
														<?
														if(!empty($datasoalonline['file'])){
														foreach($datasoalonline['file'] as $file){?>
														<tr>
															<td class="title">
															<? if($file['source']=='upload'){?>
															<a title="<?=$file['file_name']?>" href="<?=base_url('homepage/send_download/'.base64_encode('upload/akademik/soalonline/').'/'.base64_encode($file['file_name']).'');?>" target="_self"><?=substr($file['file_name'],-30)?> Download</a>
															
															| <a target="file"  href="<?=base_url()?>akademik/nilai/view_document/null/null/null/null/null/<?=base64_encode(base_url('upload/akademik/soalonline/'.$file['file_name']).'')?>">Lihat</a>
															<? } ?>
															
															<? 
															if($file['source']=='content_belajar'){
															$murnifilename=explode("/",$file['file_name']);
															$pathcnt=$murnifilename[0].'/'.$murnifilename[1].'/'.$murnifilename[2].'/'.$murnifilename[3].'/'.$murnifilename[4].'/';
															$murnifilename=end($murnifilename);
															?>
															<a title="<?=$murnifilename?>" href="<?=base_url('homepage/send_download/'.base64_encode($pathcnt).'/'.base64_encode($murnifilename).'');?>" target="file"><?=substr($murnifilename,-30)?> Download</a>
															
															| <a target="file"  href="<?=base_url()?>akademik/nilai/view_document/null/null/null/null/null/<?=base64_encode(base_url($pathcnt.'/'.$murnifilename).'')?>">Lihat</a>
															<? } ?>
															</td>
														</tr>
														<? } } ?>
													</table>
													</div>
													
													<!--<div class="full file">
													<h3 >Keterangan</h3>
													<div class="hr"></div>
													<ul>
														<li><?//=$datasoalonline['keterangan']?></li>
													</ul>
													</div>-->
													<br class="clear" />
													<!--<div id="komentarall<?=$datasoalonline['id']?>"></div>-->
													</div>
												</td>
											</tr>
											<? } ?>
										</tbody>
								</table>
									
								<div style="float:left;" id="paginationsoalonlinelist" >
								<?=$link?>
								</div>
    </div>
    <div class="tabs-frame-content tabs-frame-content2">
		
								<div style="float:left;" id="paginationsoalonlinelist" >
								<?=$link?>
								</div>
								<table class="soalonlinelist"  style="margin:0;">
										<thead>
											<tr> 
												<th>No</th>      
												<th>Pokok Bahasan</th>
												<th>Pelajaran</th>
												<th>Ke Kelas</th>
												<th>Tanggal</th>
												<th style="width:37px;">Detail</th>
												<? if($kepsek!='kepsek'){?>
												<th style="width:75px;">Ubah|Hapus</th>
												<? } ?>
											</tr>                         
										</thead>
										<tbody>
											<? 
											$nox=array();
											//$forno=$this->pagination;
											if(@$cur_page==0){@$cur_page=1;}
											$noq=(@$cur_page*@$per_page)-@$per_page+1;
											foreach($terkirim as $kt=>$datasoalonline){?>
											<tr style="cursor:pointer;" title="klik untuk menampilkan / menyembunyikan detail"  onclick="getdetail(<?=$datasoalonline['id']?>,this);">
												<td><?=$noq++;?></td>
												<td class="title" ><?=$datasoalonline['pokok_bahasan']?></td>
												<td class="title" ><?=$datasoalonline['pelajaran']?></td>
												<td class="title" ><? foreach($datasoalonline['dikirim'] as $dtdkrm){echo $dtdkrm['kelas'].$dtdkrm['nama_kelas']." &nbsp; ";}?></td>
												<td ><? $tg=tanggal($datasoalonline['tanggal_buat']." 00:00:00"); echo $tg[2];?></td>
												<td ><a style="cursor:pointer;">Lihat</a></td>
												<? if($kepsek!='kepsek'){?>
												<td >
													<div class="actedit acteditsoalonline" id_soalonline="<?=$datasoalonline['id']?>"></div> 
													<div class="actdell actdellsoalonline" id_soalonline="<?=$datasoalonline['id']?>"></div>
												</td>
												<? } ?>
											</tr>
											
											<tr id="detailsoalonline<?=$datasoalonline['id']?>" style="display:none;">
												<td colspan="7" class="innercolspan">
													<div class="">
													<div class="full file">
													<h3 >Di Kirim ke Kelas</h3>
													<div class="hr"></div>
													<table class="noborder">
														
														<tr>
															<th style="width:10px;">No</th>
															<th >Kelas</th>
															<th >Tanggal Diajarkan</th>
															<th >Keterangan</th>
														</tr>
														<? 
														if(!empty($datasoalonline['dikirim'])){
														foreach($datasoalonline['dikirim'] as $dtdkrm){ $noo++;?>
														<tr>
															<td ><?=$noo?></td>
															<td class="title"><?=$dtdkrm['kelas'].$dtdkrm['nama_kelas']?></td>
															<td class="title"><? $tg=tanggal($dtdkrm['tanggal_diajarkan'].""); echo $tg[2];?></td>
															<td class="title"><?=$dtdkrm['keterangan']?></td>
														</tr>
														<? }}
															unset($noo);
														?>
													</table>
													</div>
													<div class="full file">
													<h3 >Detail MATERI</h3>
													<div class="hr"></div>
													<table class="noborder">
														
														<tr>
															<td class="title">Pokok Bahasan</td>
															<td class="titikdua">:</td>
															<td class="value"><?=$datasoalonline['pokok_bahasan']?></td>
														</tr>
														<tr>
															<td class="title">Bab</td>
															<td class="titikdua">:</td>
															<td class="value"><?=$datasoalonline['bab']?></td>
														</tr>
														<tr>
															<td class="title">Telah dikirim ke kelas</td>
															<td class="titikdua">:</td>
															<td class="value"><? foreach($datasoalonline['dikirim'] as $dtdkrm){echo $dtdkrm['kelas'].$dtdkrm['nama_kelas']." &nbsp; ";}?></td>
														</tr>
														<!--<tr>
															<td class="title">Tanggal Diberikan</td>
															<td class="titikdua">:</td>
															<td class="value"><?=$datasoalonline['tanggal_diberikan']?></td>
														</tr>
														<tr>
															<td class="title">Tanggal Diajarkan</td>
															<td class="titikdua">:</td>
															<td class="value"><?=$datasoalonline['tanggal_buat']?></td>
														</tr>-->
													</table>
													</div>
													
													<div class="full file">
													<h3 >Lampiran</h3>
													<div class="hr"></div>
													<table class="noborder">
														<?
														if(!empty($datasoalonline['file'])){
														foreach($datasoalonline['file'] as $file){?>
														<tr>
															<td class="title">
															

															
															
															<? if($file['source']=='upload'){?>
															<a title="<?=$file['file_name']?>" href="<?=base_url('homepage/send_download/'.base64_encode('upload/akademik/soalonline/').'/'.base64_encode($file['file_name']).'');?>" target="_self"><?=substr($file['file_name'],-30)?> Download</a>
															| <a target="file"  href="<?=base_url()?>akademik/nilai/view_document/null/null/null/null/null/<?=base64_encode(base_url('upload/akademik/soalonline/'.$file['file_name']).'')?>">Lihat</a>
															<? } ?>
															
															<? 
															if($file['source']=='content_belajar'){
															$murnifilename=explode("/",$file['file_name']);
															$pathcnt=$murnifilename[0].'/'.$murnifilename[1].'/'.$murnifilename[2].'/'.$murnifilename[3].'/'.$murnifilename[4].'/';
															$murnifilename=end($murnifilename);
															?>
															<a title="<?=$murnifilename?>" href="<?=base_url('homepage/send_download/'.base64_encode($pathcnt).'/'.base64_encode($murnifilename).'');?>" target="file"><?=substr($murnifilename,-30)?> Download</a>
															
															| <a target="file"  href="<?=base_url()?>akademik/nilai/view_document/null/null/null/null/null/<?=base64_encode(base_url($pathcnt.'/'.$murnifilename).'')?>">Lihat</a>
															<? } ?>
															</td>
														</tr>
														<? } } ?>
													</table>
													</div>
													
													<!--<div class="full file">
													<h3 >Keterangan</h3>
													<div class="hr"></div>
													<ul>
														<li><?=$datasoalonline['keterangan']?></li>
													</ul>
													</div>-->
													<br class="clear" />
													<div id="komentar<?=$datasoalonline['id']?>"></div>
													</div>
												</td>
											</tr>
											<? } ?>
										</tbody>
								</table>
									
								<div style="float:left;" id="paginationsoalonlinelist" >
								<?=$link?>
								</div>
    </div>

</div>
<? if($kepsek=='kepsek'){?>
</div>
<? } ?>