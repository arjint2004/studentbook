				<script>
				$(document).ready(function(){
				$("#filteraccount select.selectgroup").change(function(e){
						var thisobj=$(this);
						$.ajax({
							type: "POST",
							data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&'+$("form#filteraccount").serialize(),
							url: $("form#filteraccount").attr('action'),
							beforeSend: function() {
								$(thisobj).after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
							},
							success: function(msg) {
								$("#wait").remove();
								$("#listaccount").html(msg);	
							}
						});
						return false;
					});//Submit End
				
				});
				
				
				
				
				</script>
				
				<div id="contentpage">
							<form action="<?=base_url()?>/superadmin/super/accountlist" method="post" id="filteraccount" >
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
							<table class="tabelfilter">
								<tr>
									<td>
										Otoritas
										<select class="selectgroup selectfilter" id="id_group" name="id_group">
											<option value="0">Pilih Group Otoritas</option>
											<? foreach($group as $id_group=>$groupdata){?>
											<option <? if(@$_POST['id_group']==$id_group){echo 'selected';}?> value="<?=$id_group?>"><?=$groupdata?></option>
											<? } ?>
										</select>
									</td>
								</tr>
							</table>
							<input type="hidden" name="ajax" value="1" />
							</form>
							<table  id="tableusers">
								<thead>
									<tr> 
										<th>No</th>
										<th>Otoritas</th>
										<th>Username</th>
										<th>Aktif</th>
										<!--<th>Action</th>-->
									</tr>                            
								</thead>
								<tbody>
								<? 
								if(isset($users)){
								$i=1;
								foreach($users as $datausers){?>
									<tr  style="cursor:pointer;" title="Klik untuk menampilkan / menyembunyikan sub mata users" onclick="getdetail(<?=$datausers['id']?>,this);">
										<td><?=$i++?></td>
										<td class="title"><?=$datausers['otoritas']?></td>
										<td class="title"><?=$datausers['username']?></td>
										<td class="title"><?=$datausers['aktif']?></td>										
										
										<!--<a class="editdata" style="cursor:pointer;" id="<?=$datausers['id']?>">Edit</a> |
										<a class="delete"  style="cursor:pointer;" id="<?=$datausers['id']?>">Disable</a>
										</td>-->
									</tr>
									
									<tr id="sub<?=$datausers['id']?>" style="display:none;" class="submapel">
										<td colspan="5" id="subload<?=$datausers['id']?>">
										
										</td>
									</tr>
								<? } } ?>
								</tbody>
							</table>
							  <div id="ajax_paging">
								<?php //echo $pagination; ?>
							  </div>
							
					</div>
