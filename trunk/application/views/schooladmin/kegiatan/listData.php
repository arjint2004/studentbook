				<script>
				$(document).ready(function(){
					$("a.delete").click(function() {
						var thisobj=$(this);
						if(confirm('Yakin anda menghapus data.?')){
							$.ajax({
							type: "POST",
							data: "ajax=1&id="+$(thisobj).attr('id'),
							url: base_url+'admin/kegiatan/delete',
							beforeSend: function() {
								$(thisobj).append("<img id='wait' src='"+config_images+"loaderhover.gif' />");
							},
							success: function(msg) {
								$("#wait").remove();			
								$.ajax({
									type: "POST",
									data: "ajax=1",
									url: base_url+'admin/kegiatan/listData',
									beforeSend: function() {
										$("#listkelasloading").html("<img src='"+config_images+"loading.png' />");
									},
									success: function(msg) {
										$("#listkelasloading").html("");
										$("#listkelas").html(msg);			
									}
								});			
							}
						});
							return false;
						}else{
							return false;
						}
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
							data: "simpleupdate=1&ajax=1&id_kegiatan="+idjur+"&"+field+"="+value,
							url: base_url+'admin/kegiatan/listData',
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
				function editfield(obj,id_kegiatan,field){
					var value=$(obj).html();
					var childval=$(obj).children('input[type["text"]]').attr('type');
					if(childval!='text'){
						$(obj).html('<input maxlength="100" field="'+field+'" size="1" id="'+value+''+id_kegiatan+'" idjur="'+id_kegiatan+'" class="editintd"   onblur="update(this)" type="text" value="'+value+'" name="edit['+id_kegiatan+']" />');	
						$('#'+value+''+id_kegiatan+'').select();
					}
					
					$(obj).children('input[type["text"]]').focus();				

				}
				</script>
				<div id="contentpage">
							<table class="tabelkelas">
								<thead>
									<tr> 
										<th>No</th>
										<th>Nama</th>
										<th>Action</th>
									</tr>                            
								</thead>
								<tbody>
									<? 
									$i=1;
									foreach($kegiatan as $datakegiatan){?>
									<tr style="cursor:pointer;">
										<td><?=$i++?></td>
										<td class="title" onclick="editfield(this,'<?=$datakegiatan['id']?>','nama')" title="klik untuk mengedit data"><?=$datakegiatan['nama']?></td>
										<td><a href="" class="delete" id="<?=$datakegiatan['id']?>">Delete</a></td>
									</tr>
									<? } ?>
								</tbody>
							</table>
							  <div id="ajax_paging">
								<?php //echo $pagination; ?>
							  </div>
							
				</div>
