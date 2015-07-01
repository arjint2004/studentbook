				<script>
				$(document).ready(function(){
					$('table.tableekstra tr td a').click(function(){
						if(confirm('Anda Yakin data kelas di hapus?')){
							var obj=$(this);
							$.ajax({
								type: "POST",
								data: "<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&ajax=1&delete=1&id_ekstrakurikuler="+$(this).attr('id'),
								url: base_url+'admin/extrakurikuler/delete/'+$(this).attr('id'),
								beforeSend: function() {
									$(obj).after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
								},
								success: function(msg) {
									$('#wait').remove();
									parseInt(msg);
									if(msg>0){
										alert('Data Ekstrakurikuler ini tidak bisa di hapus karena kemungkinan masih digunakan.');
									}else{
										$.ajax({
												type: "POST",
												data: "<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&ajax=1",
												url: base_url+'admin/extrakurikuler/listData',
												beforeSend: function() {
													$(obj).after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
												},
												success: function(msg) {
													$('#wait').remove();
													$('#listkelas').html(msg);
													
												}
										});									
									}
								}
							});						
						}
						return false;
					});	
				});
				function update(obj){
					var value=$(obj).val();
					var idjur=$(obj).attr('idjur');
					var field=$(obj).attr('field');
					
					if($(obj).is("select")){
						$(obj).parent().html($(obj).find(":selected").text());					
					}else{
						$(obj).parent().html(value);
					}

					$.ajax({
							type: "POST",
							data: "<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&simpleupdate=1&ajax=1&id_extrakurikuler="+idjur+"&"+field+"="+value,
							url: base_url+'admin/extrakurikuler/listData',
							beforeSend: function() {
								$("#listkelasloading").html("<img src='"+config_images+"loading.png' />");
							},
							success: function(msg) {
								$("#listkelasloading").html("");
								if($(obj).is("select")){
									$("#listkelas").html(msg);					
								}
								
							}
					});
				}
				function editfield(obj,id_extrakurikuler,field){
					var value=$(obj).html();
					var childval=$(obj).children('input[type["text"]]').attr('type');
					if(childval!='text'){
						$(obj).html('<input maxlength="100" field="'+field+'" size="1" id="'+value+''+id_extrakurikuler+'" idjur="'+id_extrakurikuler+'" class="editintd"   onblur="update(this)" type="text" value="'+value+'" name="edit['+id_extrakurikuler+']" />');	
						$('#'+value+''+id_extrakurikuler+'').select();
					}
					
					$(obj).children('input[type["text"]]').focus();				

				}
				function editfieldguru(obj,id_pegawai,id_extrakurikuler){
					if($(obj).children().is("select")){}else{
						$.ajax({
									type: "POST",
									data: "<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&ajax=1",
									url: base_url+"admin/extrakurikuler/getpegawaiSelect/"+id_pegawai+"/"+id_extrakurikuler,
									beforeSend: function() {
										$("#listkelasloading").html("<img src='"+config_images+"loading.png' />");
									},
									success: function(msg) {
										$(obj).html(msg);
										$(obj).children().focus();	
										$("#listkelasloading").html("");
									}
								});	
					}
				}
				
				function aktifasi(obj,id,aktif){
						$.ajax({
							type: "POST",
							data: "<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&ajax=1&id="+id+"&aktif="+aktif,
							url: base_url+'admin/extrakurikuler/aktifasiExtrakurikuler',
							beforeSend: function() {
								$(obj).html("<img src='"+config_images+"loading.png' />");
							},
							success: function(msg) {
								$("#listkelasloading").html("");
								$.ajax({
									type: "POST",
									data: "<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&ajax=1",
									url: base_url+'admin/extrakurikuler/listData',
									beforeSend: function() {
										$("#listkelasloading").html("<img src='"+config_images+"loading.png' />");
									},
									success: function(msg) {
										$("#listkelas").html(msg);			
									}
								});		
								$("#listkelasloading").html("");
							}
						});
				}
				</script>
				<div id="contentpage">
							<table class="tableekstra">
								<thead>
									<tr> 
										<th>No</th>
										<th>Nama</th>
										<th>Pengajar</th>
										<th>Aktifasi</th>
										<th>Action</th>
									</tr>                            
								</thead>
								<tbody>
									<? 
									$i=1;
									foreach($extrakurikuler as $dataextrakurikuler){?>
									<tr>
										<td><?=$i++?></td>
										<td class="title" style="cursor:pointer;" onclick="editfield(this,'<?=$dataextrakurikuler['id']?>','nama')" title="klik untuk mengedit data"><?=$dataextrakurikuler['nama']?></td>
										<td class="title" style="cursor:pointer;" onclick="editfieldguru(this,'<?=$dataextrakurikuler['id_pegawai']?>','<?=$dataextrakurikuler['id']?>')" title="klik untuk mengedit data"><?=$dataextrakurikuler['nama_pegawai']?></td>
										<td style="cursor:pointer; color:#24668D;" onclick="aktifasi(this,'<?=$dataextrakurikuler['id']?>',<?=$dataextrakurikuler['aktif']?>)" title="klik untuk mengedit data"><? if($dataextrakurikuler['aktif']==1){?>Non Aktifkan<?}?><? if($dataextrakurikuler['aktif']==0){?>Aktifkan<?}?></td>
										<td><a href="" id="<?=$dataextrakurikuler['id']?>">Delete</a></td>
									</tr>
									<? } ?>
								</tbody>
							</table>
							  <div id="ajax_paging">
								<?php //echo $pagination; ?>
							  </div>
							
				</div>
