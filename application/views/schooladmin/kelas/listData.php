				<script>
				$(document).ready(function(){
					$('table.tabelkelas ul li div.remove').click(function(){
						if(confirm('Anda Yakin data kelas di hapus?.. Jika anda menghapus kelas maka semua data yang berhubungan dengan kelas ini akan hilang')){
							var obj=$(this);
							$.ajax({
								type: "POST",
								data: "ajax=1&delete=1&id_kelas="+$(this).attr('id'),
								url: base_url+'admin/kelas/delete/'+$(this).attr('id'),
								beforeSend: function() {
									$(obj).after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
								},
								success: function(msg) {
									$('#wait').remove();
									parseInt(msg);
									if(msg>0){
										alert('Data kelas ini tidak bisa di hapus karena kemungkinan masih digunakan.');
									}else{
										$.ajax({
												type: "POST",
												data: "ajax=1",
												url: base_url+'admin/kelas/index',
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
					var id_kelas=$(obj).attr('idkelas');
					$(obj).parent().html(value);
					$.ajax({
							type: "POST",
							data: "simpleupdate=1&ajax=1&id_kelas="+id_kelas+"&kelas="+value,
							url: base_url+'admin/kelas/listData',
							beforeSend: function() {
								$(obj).after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
							},
							success: function(msg) {
								$('#wait').remove();
							}
					});
				}
				function editfield(obj,id_kelas,jurusan){
				var value=$(obj).attr('name');
				if(jurusan==0){
					var childval=$(obj).children('input[type["text"]]').attr('type');
					if(childval!='text'){
						$(obj).html('<input maxlength="50" id="'+value+''+id_kelas+'" idkelas="'+id_kelas+'" class="editkelas" onblur="update(this)" type="text" value="'+value+'" name="edit['+id_kelas+']" />');	
						$('#'+value+''+id_kelas+'').select();
					}
					
					$(obj).children('input[type["text"]]').focus();				
				}else{
					//$('#ajaxside').load(base_url+'admin/kelas/editdata/'+id_kelas+'/'+jurusan+'/'+value+'')
					$.ajax({
							type: "POST",
							data: "value="+value,
							url: base_url+'admin/kelas/editdata/'+id_kelas+'/'+jurusan+'/'+value+'',
							beforeSend: function() {
								$(obj).append("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
							},
							success: function(msg) {
								$('#wait').remove();
								$('#ajaxside').html(msg);
							}
					});
				}

				}
				</script>
				<div id="contentpage">
							<? //pr($gradeout);?>
							<?	foreach($gradeout as $idky=> $jenjangtingkat){?>
							<table class="tabelkelas">
								<thead>
									<tr> 
										<th> KELAS <strong><?=$jenjangtingkat['grade'];?></strong></th>
									</tr>                            
								</thead>
								<tbody>
								
									<tr>
										<td>
											<ul>
												<? foreach($jenjangtingkat['kelas'] as $kls){?>
												<li title="klik untuk mengedit data" onclick="editfield(this,'<?=$kls['id']?>',<?=$kls['id_jurusan'];?>);" id="<?=$jenjangtingkat['grade'];?><?=$kls['nama']?>" name="<?=$kls['nama']?>">
												<div class="value"><?=$kls['nama']?></div>
												<div title="klik untuk menghapus data" class="remove" id="<?=$kls['id']?>"></div>
												</li>
												<? } ?>
												
											</ul>
										</td>
									</tr>
								</tbody>
							</table>
							<? } ?>
							  <div id="ajax_paging">
								<?php //echo $pagination; ?>
							  </div>
							
					</div>
