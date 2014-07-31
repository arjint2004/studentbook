						<script>
							function loaddata(listtype){
								if(listtype=='siswa'){
									$.ajax({
										type: "POST",
										data: "ajax=1&id_kelas="+$('select#filterkelassiswa').val(),
										url: '<?php echo base_url(); ?>admin/schooladmin/dataakun/'+listtype+'/0',
										beforeSend: function() {
											$("#ajax"+listtype+"").html("<img src='<?=$this->config->item('images').'loading.png';?>' />");
										},
										success: function(msg) {
											$("#ajax"+listtype+"").html(msg);			
										}
									});										
								}else{
									$.ajax({
										type: "POST",
										data: "ajax=1",
										url: '<?php echo base_url(); ?>admin/schooladmin/dataakun/'+listtype+'/0',
										beforeSend: function() {
											$("#ajax"+listtype+"").html("<img src='<?=$this->config->item('images').'loading.png';?>' />");
										},
										success: function(msg) {
											$("#ajax"+listtype+"").html(msg);			
										}
									});
								}
							}
							$(document).ready(function(){
								$('table#akunguru tr td a').click(function(){
									var obj=$(this);
									if($(obj).attr('class')=='delete'){
										if(confirm('Anda akan menghapus akun "'+$(obj).parent('td').prev().prev().prev().prev().html()+'". Yakin data di hapus?')){
											$.ajax({
											  type: "POST",
											  data: "ajax=1&id_pegawai="+$(obj).attr('id'),
											  url: $(obj).attr('href'),
											  beforeSend: function() {
												$(obj).append("<img id='waitguru' src='<?=$this->config->item('images').'loading.png';?>' />");
											  },
											  success: function(msg) {
												$("#waitguru").remove();
												if(msg>0){
													alert('Data Pegawai ini tidak bisa di hapus karena kemungkinan masih digunakan.');
												}else{
													//loaddata('guru');	
													$(obj).parent('td').parent('tr').remove();
												}
											  }
											});	
										}
										return false;
									}else if($(obj).attr('class')=='aktifasi'){
										if(confirm('Apakah anda akan non aktifkan guru ini...')){
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
												//loaddata('guru');
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
							  $(function() {
								applyPagination();
								function applyPagination() {
								  $("#ajax_paging a").click(function() {
									var url = $(this).attr("href");
									var thisobj= $(this);
									$.ajax({
									  type: "POST",
									  data: "ajax=1",
									  url: url,
									  beforeSend: function() {
										$('#ajax_paging').before("<img id='waitguru' src='<?=$this->config->item('images').'loading.png';?>' />");
									  },
									  success: function(msg) {
										$("#waitguru").remove();
										$("#contentpage").html(msg);
										//applyPagination();
									  }
									});
									return false;
								  });
								}
							  });
							  </script>
							<div id="contentpage">
							
							<table id="akunguru">
								<thead>
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
								foreach($dataguru as $xx=>$guru){ $i++;?>
									<tr> 
										<td> <?=$i?> </td>
										<td class="title"> <?=$guru['nama']?> </td>
										<!--<td> <?=substr($guru['tgl_daftar'],0,10)?> </td>-->
										<td class="title"> <?=$guru['username']?> </td>
										<td> <?=$guru['password']?> </td>
										<td> 
										<?
											$otor['id_user']=$guru['id_user'];
											$otor['id']=$guru['id'];
											$otor['nama']=$guru['nama'];
											$otor['otoritas']='guru';
											$otor['id_pengguna']=$guru['id_pengguna'];
											$otoren=base64_encode(serialize($otor));
										?>
										<a href="<?=base_url()?>admin/otoritas/setotoritas/" value="<?=$otoren?>">Atur</a> </td>
										<td> 
										<? if($guru['aktif']){?>
										<a href="<?=base_url()?>admin/otoritas/disableakun/<?=$otoren?>" class="aktifasi">Non Aktifkan</a> 
										<? }else{?>
										<a href="<?=base_url()?>admin/otoritas/enableakun/<?=$otoren?>" class="aktifasi">Aktifkan</a> 
										<? } ?>
										|
										<a href="<?=base_url()?>admin/schooladmin/deletepegawai" id="<?=$guru['id']?>" class="delete">Delete</a> 
										</td>
									</tr> 
								<? } ?>
								</tbody>
							</table>
							  <div id="ajax_paging">
								<?php echo $pagination; ?>
							  </div>
							
							</div>
