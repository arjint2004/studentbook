				<script>
				$(document).ready(function(){
				});
				function update(obj){
					var value=$(obj).val();
					var idjur=$(obj).attr('idjur');
					var field=$(obj).attr('field');
					$(obj).parent().html(value);
					$.ajax({
							type: "POST",
							data: "simpleupdate=1&ajax=1&id_jurusan="+idjur+"&"+field+"="+value,
							url: base_url+'admin/jurusan/listData',
							beforeSend: function() {
								
							},
							success: function(msg) {
									
							}
					});
				}
				function editfield(obj,id_jurusan,field){//alert();
					var value=$(obj).html();
					var childval=$(obj).children('input[type["text"]]').attr('type');
					if(childval!='text'){
						$(obj).html('<input maxlength="100" field="'+field+'" size="1" id="'+value+''+id_jurusan+'" idjur="'+id_jurusan+'" class="editintd"   onblur="update(this)" type="text" value="'+value+'" name="edit['+id_jurusan+']" />');	
						$('#'+value+''+id_jurusan+'').select();
					}
					
					$(obj).children('input[type["text"]]').focus();				

				}
				</script>
				<div id="contentpage">
							<table class="tabelkelas">
								<thead>
									<tr> 
										<th>No</th>
										<th>Jurusan</th>
										<th>Keterangan</th>
									</tr>                            
								</thead>
								<tbody>
									<? 
									$i=1;
									foreach($jurusan as $datajurusan){?>
									<tr>
										<td><?=$i++?></td>
										<td onclick="editfield(this,'<?=$datajurusan['id']?>','nama')" title="klik untuk mengedit data"><?=$datajurusan['nama']?></td>
										<td onclick="editfield(this,'<?=$datajurusan['id']?>','keterangan')" title="klik untuk mengedit data"><?=$datajurusan['keterangan']?></td>
									</tr>
									<? } ?>
								</tbody>
							</table>
							  <div id="ajax_paging">
								<?php //echo $pagination; ?>
							  </div>
							
					</div>
