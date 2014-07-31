								<script>
									$(document).ready(function(){
										//Submit Start

										
										$("ul.file div.actdell").click(function(){
											var objdell=$(this);
											if(confirm('File akan di hapus secara permanen, untuk menggunakannya kembali anda harus upload ulang..')){
												$.ajax({
													type: "POST",
													data: '',
													url: base_url+'akademik/administrasi/deletefilepemb/'+$(this).attr('id'),
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
													data: '',
													url: base_url+'akademik/administrasi/deletepemb/'+$(this).attr('id_pemb'),
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
											<? 
											$nox=array();$no=1;
											if(!empty($administrasi['administrasi'])){
											foreach($administrasi['administrasi'] as $kt=>$dataadministrasi){?>
											<tr style="cursor:pointer;" title="klik untuk menampilkan / menyembunyikan detail" onclick="$('#detailadministrasi<?=$dataadministrasi['id']?>').toggle('fade')">
												<td><?=$no++;?></td>
												<td class="title" ><?=$dataadministrasi['nama_pelajaran']?></td>
												<td class="title" ><?=$dataadministrasi['kelas']?><?=$dataadministrasi['nama_kelas']?></td>
												<td ><?=$dataadministrasi['semester']?></td>
												<td ><?=$dataadministrasi['keterangan']?></td>
												<td >
													<div class="actedit" onclick="$('#subjectlist').load('<?=base_url('akademik/administrasi/editadministrasi/'.$dataadministrasi['id'])?>');"></div> 
													<div id="actdellpemp" id_pemb="<?=$dataadministrasi['id']?>" class="actdell"></div>
												</td>
											</tr>
											<tr id="detailadministrasi<?=$dataadministrasi['id']?>" style="display:none;">
												<td colspan="7" class="innercolspan">
													<div style="width:99%;" class="file">
													<h3 >File Data administrasi</h3>
													<div class="hr"></div>
													<ul class="file">
														<? foreach($dataadministrasi['file'] as $file){ ?>
															<li id="li<?=$file['id']?>"><a title="<?=$file['file_name']?>" href="<?=base_url('homepage/send_download/'.base64_encode("upload/akademik/rencana_administrasi/").'/'.base64_encode($file['file_name']).'');?>" target="_self"><?=substr($file['file_name'],-30)?></a> <div style="float:right;" id="<?=$file['id']?>" class="actdell"></div></li>
															
														<? } ?>
													</ul>
													</div>
													
												</td>
											</tr>
											<? }  } ?>
										</tbody>
								</table>
