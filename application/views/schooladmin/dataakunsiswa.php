							  <script>
							  $(function() {
								applyPagination();
								function applyPagination() {
								  $("#ajax_pagingss a").click(function() {
									var url = $(this).attr("href");
									var thisobj= $(this);
									$.ajax({
									  type: "POST",
									  data: "ajax=1&id_kelas="+$('select#filterkelassiswa').val(),
									  url: url,
									  beforeSend: function() {
										$(thisobj).append("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
									  },
									  success: function(msg) {
										$("#wait").remove();
										$("#contentpagess").html(msg);
										//applyPagination();
									  }
									});
									return false;
								  });
								}
								
								 $("select#filterkelassiswa").change(function() {
									var listtype='siswa';
									var thisobj=$(this);
									$.ajax({
									type: "POST",
									data: "ajax=1&id_kelas="+$(this).val(),
									url: '<?php echo base_url(); ?>admin/schooladmin/dataakun/'+listtype+'/0',
									beforeSend: function() {
										$(thisobj).after("<img id='wait' style='margin:0;' src='<?=$this->config->item('images').'loading.png';?>' />");
									},
									success: function(msg) {
										$('#wait').remove();
										$("#ajax"+listtype+"").html(msg);			
									}
									});
								});
								
								
								$('table#akunsiswa tr td a').click(function(){
									var obj=$(this);
									if($(obj).attr('class')=='delete'){
										if(confirm('Anda Yakin data di hapus?')){
											$.ajax({
											  type: "POST",
											  data: "ajax=1&id_siswa="+$(obj).attr('id'),
											  url: $(obj).attr('href'),
											  beforeSend: function() {
												$(obj).append("<img id='waitguru' src='<?=$this->config->item('images').'loading.png';?>' />");
											  },
											  success: function(msg) {
												$("#waitguru").remove();
												if(msg>0){
													alert('Data Siswa ini tidak bisa di hapus karena kemungkinan masih digunakan.');
												}else{
													//loaddata('siswa');			
													$(obj).parent('td').parent('tr').remove();
												}
											  }
											});	
										}
										return false;
									}else if($(obj).attr('class')=='aktifasi'){
										if(confirm('Apakah anda akan non aktifkan siswa ini...')){
											$.ajax({
											  type: "POST",
											  data: "ajax=1",
											  url: $(obj).attr('href'),
											  beforeSend: function() {
												$(obj).append("<img id='waitguru' src='<?=$this->config->item('images').'loading.png';?>' />");
											  },
											  success: function(msg) {
												$("#waitguru").remove();
												//$(".main-content").html(msg);
												//loaddata('siswa');
												if(msg=='Non Aktifkan'){
													$(obj).attr('href','<?=base_url()?>admin/otoritas/disableakun/<?=$otoren?>');
												}
												if(msg=='Aktifkan'){
													$(obj).attr('href','<?=base_url()?>admin/otoritas/enableakun/<?=$otoren?>');
												}
												
												$(obj).html(msg);
											  }
											});
										}
									}else if($(obj).attr('class')=='edit'){
										
											$.ajax({
											  type: "POST",
											  data: "ajax=1&id_siswa="+$(obj).attr('id'),
											  url: $(obj).attr('href'),
											  beforeSend: function() {
												$(obj).append("<img id='waitguru' src='<?=$this->config->item('images').'loading.png';?>' />");
											  },
											  success: function(msg) {
												$("#waitguru").remove();
												$("#addusersiswa").html(msg);
											  }
											});
									}else{
										var obj=$(this);
										$.ajax({
										  type: "POST",
										  data: "ajax=1&otoren="+$(obj).attr('value'),
										  url: $(obj).attr('href')+$(obj).attr('value'),
										  beforeSend: function() {
											$(obj).append("<img id='waitguru' src='<?=$this->config->item('images').'loading.png';?>' />");
										  },
										  success: function(msg) {
											$("#waitguru").remove();
											$(".main-content").html(msg);
											//applyPagination();
										  }
										});
									}
									return false
								});	
							});
							  </script>
							<div id="contentpagess">
							<? //pr($kelas);?>
							<table id="akunsiswa">
								<thead>
									<tr> 
										<th colspan="7" style="padding:5px; text-align:left;"> 
											Filter Kelas                             		
											<select name="kelas" class="filterkelas" id="filterkelassiswa">
												<option value="" >Pilih Kelas</option>
												<? foreach($kelas as $datakelas){?>
												<option <?if(isset($kelasselected) && $kelasselected==$datakelas['id']){echo 'selected';}?> value="<?=$datakelas['id']?>" ><?=$datakelas['kelas'].$datakelas['nama']?></option>
												<? } ?>
											</select>
										</th>
									</tr>
									<tr> 
										<th> No </th>
										<th> Nama </th>
										<!--<th> Tgl Daftar </th>-->
										<th> Username </th>
										<th> Password </th>
										<th> Akun </th>
										<th> Action </th>
									</tr>                            
								</thead>
								<tbody>
								<? 
								//if($halaman==0){$halaman=1;}
								$i=$start;
								if(!empty($dataguru)){
								foreach($dataguru as $xx=>$guru){ $i++;?>
									<tr> 
										<td> <?=$i?> </td>
										<td class="title"> <?=$guru['nama']?> </td>
										<!--<td> <?=$guru['tgl_daftar']?> </td>-->
										<td class="title"> <?=$guru['username']?> </td>
										<td class="title"> <?=$guru['password']?> </td>
										<td> 
										<?
											$otor['id_user']=$guru['id_user'];
											$otor['id']=$guru['id'];
											$otor['nama']=$guru['nama'];
											$otor['otoritas']='siswa';
											
											$otoren=base64_encode(serialize($otor));
										?>
										<a href="<?=base_url()?>admin/otoritas/setotoritas/<?=$otoren?>">Atur</a> </td></td>
										<td> 
										<? if($guru['aktif']){?>
										<a href="<?=base_url()?>admin/otoritas/disableakun/<?=$otoren?>" class="aktifasi">Non Aktif</a> 
										<? }else{?>
										<a href="<?=base_url()?>admin/otoritas/enableakun/<?=$otoren?>" class="aktifasi">Aktif</a> 
										<? } ?>
										|
										<a href="<?=base_url()?>admin/schooladmin/editsiswa" id="<?=$guru['id']?>" class="edit">Edit</a> 
										|
										<a href="<?=base_url()?>admin/schooladmin/deletesiswa" id="<?=$guru['id']?>" class="delete">Delete</a> 
										</td>
									</tr> 
								<? }  } ?>
								</tbody>
							</table>
							  <div id="ajax_pagingss">
								<?php echo $pagination; ?>
							  </div>
							
							</div>
