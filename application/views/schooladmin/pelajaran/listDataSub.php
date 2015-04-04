				<script>
				$(document).ready(function(){
					$(".editdata").click(function(e){
						$('#ajaxside').load('<?=base_url()?>admin/pelajaran/editData/'+$(this).attr('id'));
						$("#ajaxside").scrollintoview({ duration: "slow", direction: "y", complete: function(){ }}); 
					});
					
					$("table#tablepelajaran tr td a.delete").click(function(e){
						var thisobj=$(this);
						if(confirm('Data akan di hapus!')){
							$.ajax({
								type: "POST",
								data: 'ajax=1&id_pelajaran='+$(thisobj).attr('id'),
								url: '<?=base_url()?>/admin/pelajaran/delete/'+$(thisobj).attr('id'),
								beforeSend: function() {
									$(thisobj).append("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
								},
								success: function(msg) {
									$("#wait").remove();
									parseInt(msg);
									if(msg>0){
										alert('Data pelajaran ini tidak bisa di hapus karena kemungkinan masih digunakan.');
									}else{
										$.ajax({
											type: "POST",
											data: "ajax=1",
											url: base_url+'admin/pelajaran/listData',
											beforeSend: function() {
												$("#listpelajaranloading").html("<img src='"+config_images+"loading.png' />");
											},
											success: function(msg) {
												$("#listpelajaran").html(msg);			
											}
										});									
									}
									
								}
							});
						}
						
						return false;
					});
				});

				</script>
				<div id="contentpage">
							<table  id="tablepelajaran">
								<thead>
									<tr> 
										<th>No</th>
										<th>Pelajaran</th>
										<? if($this->session->userdata['ak_setting']['jenjang'][0]['nama']!='SD' && $this->session->userdata['ak_setting']['jenjang'][0]['nama']!='SMP'){?>
										<th>Jurusan</th>
										<? }?>
										<th>Semester</th>
										<th>Jenjang Kelas</th>
										<? if($this->session->userdata['ak_setting']['jenjang'][0]['nama']!='SD' && $this->session->userdata['ak_setting']['jenjang'][0]['nama']!='SMP'){?>
										<th>Kelompok</th>
										<? }?>
										<th>Action</th>
									</tr>                            
								</thead>
								<tbody>
								<? 
								if(isset($pelajaran)){
								$i=1;
								foreach($pelajaran as $datapel){?>
									<tr  style="cursor:pointer;" title="Klik untuk menampilkan / menyembunyikan sub mata pelajaran">
										<td><?=$i++?></td>
										<td class="title"><?=$datapel['nama']?></td>
										<? if($this->session->userdata['ak_setting']['jenjang'][0]['nama']!='SD' && $this->session->userdata['ak_setting']['jenjang'][0]['nama']!='SMP'){?>
										<td><?=$datapel['nama_jurusan']?></td>
										<? }?>
										<td><?=$datapel['nama_semester']?></td>
										<td><?=$datapel['kelas']?></td>
										<? if($this->session->userdata['ak_setting']['jenjang'][0]['nama']!='SD' && $this->session->userdata['ak_setting']['jenjang'][0]['nama']!='SMP'){?>
										<td><?=$datapel['kelompok']?></td>
										<? }?>
										<td>
										<a class="editdata" style="cursor:pointer;" id="<?=$datapel['id']?>">Edit</a> |
										<a class="delete"  style="cursor:pointer;" id="<?=$datapel['id']?>">Delete</a>
										</td>
									</tr>
								<? if($sub!=true){?>	
									<tr  id="sub<?=$datapel['id']?>" style="display:none;">
										<td id="subload<?=$datapel['id']?>">
										
										</td>
									</tr>
								<? } } } ?>
								</tbody>
							</table>
							  <div id="ajax_paging">
								<?php //echo $pagination; ?>
							  </div>
							
					</div>
