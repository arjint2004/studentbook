				<script>
				$(document).ready(function(){
				});
				function update(obj){
					var value=$(obj).val();
					var id_nilai=$(obj).attr('idnilai');
					$(obj).parent().html(value);
					$.ajax({
							type: "POST",
							data: "<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&simpleupdate=1&ajax=1&id_nilai="+id_nilai+"&nilai="+value,
							url: base_url+'admin/nilai/listData',
							beforeSend: function() {
								
							},
							success: function(msg) {
									
							}
					});
				}
				function editfield(obj,id_nilai,jurusan){
				var value=$(obj).html();
				if(jurusan==0){
					var childval=$(obj).children('input[type["text"]]').attr('type');
					if(childval!='text'){
						$(obj).html('<input maxlength="50" id="'+value+''+id_nilai+'" idnilai="'+id_nilai+'" class="editnilai" onblur="update(this)" type="text" value="'+value+'" name="edit['+id_nilai+']" />');	
						$('#'+value+''+id_nilai+'').select();
					}
					
					$(obj).children('input[type["text"]]').focus();				
				}else{
					$('#ajaxside').load(base_url+'admin/nilai/editdata/'+id_nilai+'/'+jurusan+'/'+value+'')
				}

				}
				</script>
				<div id="contentpage">
							<? //pr($gradeout);?>
							<?	foreach($gradeout as $idky=> $jenjangtingkat){?>
							<table class="tabelnilai">
								<thead>
									<tr> 
										<th> nilai <strong><?=$jenjangtingkat['grade'];?></strong></th>
									</tr>                            
								</thead>
								<tbody>
								
									<tr>
										<td>
											<ul>
												<? foreach($jenjangtingkat['nilai'] as $kls){?>
												<li title="klik untuk mengedit data" onclick="editfield(this,'<?=$kls['id']?>',<?=$kls['id_jurusan'];?>);" id="<?=$jenjangtingkat['grade'];?><?=$kls['nama']?>"><?=$kls['nama']?></li>
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
