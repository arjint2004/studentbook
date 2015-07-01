								<script>
									$(document).ready(function(){
										//Submit Start

										
										$("ul.file div.actdell").click(function(){
											var objdell=$(this);
											if(confirm('File akan di hapus secara permanen, untuk menggunakannya kembali anda harus upload ulang..')){
												$.ajax({
													type: "POST",
													data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&',
													url: base_url+'akademik/perencanaan/deletefiletimelinepemb/'+$(this).attr('id'),
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
										
										$("div#actdelltime").click(function(){
											var objdell=$(this);
											if(confirm('Data dan File akan di hapus secara permanen, untuk menggunakannya kembali anda harus upload ulang..')){
												$.ajax({
													type: "POST",
													data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&',
													url: base_url+'akademik/perencanaan/deletetime/'+$(this).attr('id_time'),
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
							   <table>
										<thead>
											<tr>
												<th>No</th>      
												<th>Pelajaran</th>
												<th>Kelas</th>
												<th>Semester</th>
												<th>Keterangan</th>
												<th>Action</th>
											</tr>                         
										</thead>
										<tbody>
											<? $nox=array();$no=1;foreach($timelinepembelajaran['timelinepembelajaran'] as $kt=>$datatimelinepembelajaran){?>
											<tr style="cursor:pointer;" title="klik untuk menampilkan / menyembunyikan detail" onclick="$('#detailtimelinepembelajaran<?=$datatimelinepembelajaran['id']?>').toggle('fade')">
												<td><?=$no++;?></td>
												<td class="title" ><?=$datatimelinepembelajaran['nama_pelajaran']?></td>
												<td class="title" ><?=$datatimelinepembelajaran['kelas']?><?=$datatimelinepembelajaran['nama_kelas']?></td>
												<td ><?=$datatimelinepembelajaran['semester']?></td>
												<td ><?=$datatimelinepembelajaran['keterangan']?></td>
												<td >
													<div class="actedit" onclick="$('#subjectlist').load('<?=base_url('akademik/perencanaan/edittimelinepembelajaran/'.$datatimelinepembelajaran['id'])?>');"></div> 
													<div class="actdell"  id="actdelltime" id_time="<?=$datatimelinepembelajaran['id']?>" ></div>
												</td>
											</tr>
											<tr id="detailtimelinepembelajaran<?=$datatimelinepembelajaran['id']?>" style="display:none;">
												<td colspan="7" class="innercolspan">
													<div style="width:99%;" class="file">
													<h3 >File Data Timeline Pembelajaran</h3>
													<div class="hr"></div>
													<ul class="file">
														<? foreach($datatimelinepembelajaran['file'] as $file){ ?>
															<li id="li<?=$file['id']?>"><a title="<?=$file['file_name']?>" href="<?=base_url('homepage/send_download/'.base64_encode("upload/akademik/timeline_pembelajaran/").'/'.base64_encode($file['file_name']).'');?>" target="_self"><?=substr($file['file_name'],-30)?></a> <div style="float:right;" id="<?=$file['id']?>" class="actdell"></div></li>
														<? } ?>
													</ul>
													</div>
													
												</td>
											</tr>
											<? } ?>
										</tbody>
								</table>
