								<script>
										function getdetail(id,obj,all){
											if(all=='all'){
												$('#detailmateriall'+id).toggle('fade');
											}else{
												$('#detailmateri'+id).toggle('fade');
											}
											//$('table.materilist div.comment').remove();
											$(obj).prev('tr').hide();
											$(obj).next('tr').next('tr').next('tr').hide();
											$.ajax({
												type: "GET",
												data: '',
												url: '<?=base_url()?>akademik/comment/index/'+id+'/first/materi',
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
										$("div.acteditmateri").click(function(){
											var objdell=$(this);
											$.ajax({
													type: "POST",
													data: '',
													url: '<?=base_url('akademik/materi/editmateri')?>/'+$(this).attr('id_materi'),
													beforeSend: function() {
														$(objdell).after("<img class='wait' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
													},
													success: function(msg) {
														$(".wait").remove();
														$('#subjectlistmateri').html(msg);
													}
											});
										});	
										$("ul.file div.actdell").click(function(){
											var objdell=$(this);
											if(confirm('File akan di hapus secara permanen, untuk menggunakannya kembali anda harus upload ulang..')){
												$.ajax({
													type: "POST",
													data: '',
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
										$("div#paginationmaterilist a").click(function(){
											var objdell=$(this);
											
												$.ajax({
													type: "POST",
													data: 'id_pengguna=<?=@$id_pengguna?>&kepsek=<?=@$kepsek?>',
													url: $(objdell).attr('href'),
													beforeSend: function() {
														$(objdell).after("<img class='wait' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
													},
													success: function(msg) {
														$("#subjectlistmateri").html(msg);
														//$("#fancybox-content").html(msg);
														$(".wait").remove();	
													}
												});
												return false;
										});	
										$("div#paginationmaterilistk a").click(function(){
											var objdell=$(this);
											
												$.ajax({
													type: "POST",
													data: '',
													url: $(objdell).attr('href'),
													beforeSend: function() {
														$(objdell).after("<img class='wait' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
													},
													success: function(msg) {
														$(".wait").remove();	
														$("#subjectlistmateri").html(msg);
													}
												});
												return false;
										});	
										
										$("div.actdellmateri").click(function(){
											var objdell=$(this);
											if(confirm('Data dan File akan di hapus secara permanen, untuk menggunakannya kembali anda harus upload ulang..')){
												$.ajax({
													type: "POST",
													data: '',
													url: base_url+'akademik/materi/delete/'+$(this).attr('id_materi'),
													beforeSend: function() {
														$(objdell).after("<img id='wait' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
													},
													success: function(msg) {
														$("#wait").remove();	
														if(msg==1){
															$(objdell).parent('td').parent('tr').remove();
															$('table tr#detailmateriall'+$(objdell).attr('id_materi')).remove();
														}
													}
												});
												return false;
											}
										});	
									});
								</script>
								<? //pr($materi);?>
							   

<? //pr($materi);?>		
<? if($kepsek=='kepsek'){?>
<div id="subjectlistmateri">	
<? } ?>			
<div class="tabs-container">
    <ul class="tabs-frame tabs-frame2">
        <li><a href="#">Semua Materi</a></li>
        <li><a href="#">Terkirim</a></li>
    </ul>
    <div class="tabs-frame-content tabs-frame-content2 ">
		
								<div style="float:left;" id="paginationmaterilist" >
								<?=$link?>
								</div>
									<table class="materilist" style="margin:0;">
										<thead>
											<tr> 
												<th>No</th>      
												<th>Pokok Bahasan</th>
												<th>Pelajaran</th>
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
											if(@$cur_page==0){@$cur_page=1;}
											$no=(@$cur_page*@$per_page)-@$per_page+1;
											foreach($materi as $kt=>$datamateri){?>
											<tr style="cursor:pointer;" title="klik untuk menampilkan / menyembunyikan detail"  onclick="getdetail(<?=$datamateri['id']?>,this,'all');">
												<td><?=$no++;?></td>
												<td class="title" ><?=$datamateri['pokok_bahasan']?></td>
												<td class="title" ><?=$datamateri['pelajaran']?></td>
												<td class="title" ><? 
													if(!empty($datamateri['dikirim'])){
														foreach($datamateri['dikirim'] as $dtdkrm){echo $dtdkrm['kelas'].$dtdkrm['nama_kelas']." &nbsp; ";}
													}else{
														echo 'Belum dikirim';
													}
													?></td>
												<td ><? $tg=tanggal($datamateri['tanggal_buat']." 00:00:00"); echo $tg[2];?></td>
												<td ><a style="cursor:pointer;">Lihat</a></td>
												<? if($kepsek!='kepsek'){?>
												<td >
													<div class="actedit acteditmateri" id_materi="<?=$datamateri['id']?>"></div> 
													<div class="actdell actdellmateri" id_materi="<?=$datamateri['id']?>"></div>
												
												</td>
												<? } ?>
											</tr>
											
											<tr id="detailmateriall<?=$datamateri['id']?>" style="display:none;">
												<td colspan="7" class="innercolspan">
													<div class="">
													<div class="full file">
													<h3 >Detail MATERI</h3>
													<div class="hr"></div>
													<table class="noborder">
														
														<tr>
															<td class="title">Pokok Bahasan</td>
															<td class="titikdua">:</td>
															<td class="value"><?=$datamateri['pokok_bahasan']?></td>
														</tr>
														<tr>
															<td class="title">Bab</td>
															<td class="titikdua">:</td>
															<td class="value"><?=$datamateri['bab']?></td>
														</tr>
														<? if(isset($datamateri['dikirim'])){?>
														<tr>
															<td class="title">Telah dikirim ke kelas</td>
															<td class="titikdua">:</td>
															<td class="value"><? foreach($datamateri['dikirim'] as $dtdkrm){echo $dtdkrm['kelas'].$dtdkrm['nama_kelas']." &nbsp; ";}?></td>
														</tr>
														<? } ?>
														<!--<tr>
															<td class="title">Tanggal Diberikan</td>
															<td class="titikdua">:</td>
															<td class="value"><?=$datamateri['tanggal_diberikan']?></td>
														</tr>
														<tr>
															<td class="title">Tanggal Diajarkan</td>
															<td class="titikdua">:</td>
															<td class="value"><?=$datamateri['tanggal_buat']?></td>
														</tr>-->
													</table>
													</div>
													
													<div class="full file">
													<h3 >Lampiran</h3>
													<div class="hr"></div>
													<table class="noborder">
														<?
														if(!empty($datamateri['file'])){
														foreach($datamateri['file'] as $file){?>
														<tr>
															<td class="title"><a title="<?=$file['file_name']?>" href="<?=base_url('homepage/send_download/'.base64_encode('upload/akademik/materi/').'/'.base64_encode($file['file_name']).'');?>" target="_self"><?=substr($file['file_name'],-30)?> Download</a>
															| <a target="file"  href="<?=base_url()?>akademik/nilai/view_document/null/null/null/null/null/<?=base64_encode(base_url('upload/akademik/materi/'.$file['file_name']).'')?>">Lihat</a>
															</td>
														</tr>
														<? } } ?>
													</table>
													</div>
													
													<!--<div class="full file">
													<h3 >Keterangan</h3>
													<div class="hr"></div>
													<ul>
														<li><?//=$datamateri['keterangan']?></li>
													</ul>
													</div>-->
													<br class="clear" />
													<!--<div id="komentarall<?=$datamateri['id']?>"></div>-->
													</div>
												</td>
											</tr>
											<? } ?>
										</tbody>
								</table>
									
								<div style="float:left;" id="paginationmaterilist" >
								<?=$link?>
								</div>
    </div>
    <div class="tabs-frame-content tabs-frame-content2">
		
								<div style="float:left;" id="paginationmaterilist" >
								<?=$link?>
								</div>
								<table class="materilist"  style="margin:0;">
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
											foreach($terkirim as $kt=>$datamateri){?>
											<tr style="cursor:pointer;" title="klik untuk menampilkan / menyembunyikan detail"  onclick="getdetail(<?=$datamateri['id']?>,this);">
												<td><?=$noq++;?></td>
												<td class="title" ><?=$datamateri['pokok_bahasan']?></td>
												<td class="title" ><?=$datamateri['pelajaran']?></td>
												<td class="title" ><? foreach($datamateri['dikirim'] as $dtdkrm){echo $dtdkrm['kelas'].$dtdkrm['nama_kelas']." &nbsp; ";}?></td>
												<td ><? $tg=tanggal($datamateri['tanggal_buat']." 00:00:00"); echo $tg[2];?></td>
												<td ><a style="cursor:pointer;">Lihat</a></td>
												<? if($kepsek!='kepsek'){?>
												<td >
													<div class="actedit acteditmateri" id_materi="<?=$datamateri['id']?>"></div> 
													<div class="actdell actdellmateri" id_materi="<?=$datamateri['id']?>"></div>
												</td>
												<? } ?>
											</tr>
											
											<tr id="detailmateri<?=$datamateri['id']?>" style="display:none;">
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
														if(!empty($datamateri['dikirim'])){
														foreach($datamateri['dikirim'] as $dtdkrm){ $noo++;?>
														<tr>
															<td ><?=$noo?></td>
															<td class="title"><?=$dtdkrm['kelas'].$dtdkrm['nama_kelas']?></td>
															<td class="title"><? $tg=tanggal($dtdkrm['tanggal_diajarkan']." 00:00:00"); echo $tg[2];?></td>
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
															<td class="value"><?=$datamateri['pokok_bahasan']?></td>
														</tr>
														<tr>
															<td class="title">Bab</td>
															<td class="titikdua">:</td>
															<td class="value"><?=$datamateri['bab']?></td>
														</tr>
														<tr>
															<td class="title">Telah dikirim ke kelas</td>
															<td class="titikdua">:</td>
															<td class="value"><? foreach($datamateri['dikirim'] as $dtdkrm){echo $dtdkrm['kelas'].$dtdkrm['nama_kelas']." &nbsp; ";}?></td>
														</tr>
														<!--<tr>
															<td class="title">Tanggal Diberikan</td>
															<td class="titikdua">:</td>
															<td class="value"><?=$datamateri['tanggal_diberikan']?></td>
														</tr>
														<tr>
															<td class="title">Tanggal Diajarkan</td>
															<td class="titikdua">:</td>
															<td class="value"><?=$datamateri['tanggal_buat']?></td>
														</tr>-->
													</table>
													</div>
													
													<div class="full file">
													<h3 >Lampiran</h3>
													<div class="hr"></div>
													<table class="noborder">
														<?
														if(!empty($datamateri['file'])){
														foreach($datamateri['file'] as $file){?>
														<tr>
															<td class="title"><a title="<?=$file['file_name']?>" href="<?=base_url('homepage/send_download/'.base64_encode('upload/akademik/materi/').'/'.base64_encode($file['file_name']).'');?>" target="_self"><?=substr($file['file_name'],-30)?> Download</a>
															| <a target="file"  href="<?=base_url()?>akademik/nilai/view_document/null/null/null/null/null/<?=base64_encode(base_url('upload/akademik/materi/'.$file['file_name']).'')?>">Lihat</a>
															</td>
														</tr>
														<? } } ?>
													</table>
													</div>
													
													<!--<div class="full file">
													<h3 >Keterangan</h3>
													<div class="hr"></div>
													<ul>
														<li><?=$datamateri['keterangan']?></li>
													</ul>
													</div>-->
													<br class="clear" />
													<div id="komentar<?=$datamateri['id']?>"></div>
													</div>
												</td>
											</tr>
											<? } ?>
										</tbody>
								</table>
									
								<div style="float:left;" id="paginationmaterilist" >
								<?=$link?>
								</div>
    </div>

</div>
<? if($kepsek=='kepsek'){?>
</div>
<? } ?>