			<script>
				/*js for aspekkepribadian start*/
				jQuery(document).ready(function($){	
					$('table.tabelkelas tr td.remove').click(function(){
						if(confirm('Anda Yakin data kelas di hapus?')){
							var obj=$(this);
							$.ajax({
								type: "POST",
								data: "<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&ajax=1&delete=1&id-aspek="+$(this).attr('id'),
								url: base_url+'admin/setting/deleteaspek/'+$(this).attr('id'),
								beforeSend: function() {
									$(obj).after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
								},
								success: function(msg) {
									$('#wait').remove();
									parseInt(msg);
									if(msg>0){
										alert('Data aspek kepribadian ini tidak bisa di hapus karena kemungkinan masih digunakan.');
									}else{
										loaddataaspekkepribadian();								
									}
								}
							});						
						}
						return false;
					});				
					$('#addaspek').click(function(){
						var obj=$(this);
						$.ajax({
							type: "POST",
							data: "<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&ajax=1",
							url: '<?=base_url()?>admin/setting/addaspek',
							beforeSend: function() {
								$(obj).after("<img id='wait' src='"+config_images+"loading.png' />");
							},
							success: function(msg) {
								$("#wait").remove();	
								$("#ajaxside").html(msg);			
							}
						});					
					});

				});
				function loaddataaspekkepribadian(){
					$.ajax({
						type: "POST",
						data: "<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&ajax=1",
						url: base_url+'admin/setting/aspekkepribadian',
						beforeSend: function() {
							$("#ajaxside").html("<img src='"+config_images+"loading.png' />");
						},
						success: function(msg) {
							$("div.main-content").html(msg);			
						}
					});
				}
				function update(obj){
					var value=$(obj).val();
					var idaspek=$(obj).attr('idaspek');
					var field=$(obj).attr('field');
					$(obj).parent().html(value);
					$.ajax({
							type: "POST",
							data: "<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&simpleupdate=1&ajax=1&id_aspek="+idaspek+"&"+field+"="+value,
							url: base_url+'admin/setting/aspekkepribadian',
							beforeSend: function() {
								$(obj).after("<img id='wait' src='"+config_images+"loading.png' />");
							},
							success: function(msg) {
								$('img#wait').remove();
							}
					});
				}
				function editfield(obj,id_aspek,field){
					var value=$(obj).html();
					var childval=$(obj).children('input[type["text"]]').attr('type');
					if(childval!='text'){
						$(obj).html('<input maxlength="100" style="width:300px;" field="'+field+'" size="10" id="'+value+''+id_aspek+'" idaspek="'+id_aspek+'" class="editintd"   onblur="update(this)" type="text" value="'+value+'" name="edit['+id_aspek+']" />');	
						$('#'+value+''+id_aspek+'').select();
					}
					
					$(obj).children('input[type["text"]]').focus();				

				}
				/*js for aspekkepribadian end*/
			</script>
			<? //pr($aspekkepribadian);?>
			<h1 class="with-subtitle"> Data Aspek Kepribadian </h1>
				<h6 class="subtitle"> Pengaturan aspek kepribadian </h6>
                <div class="styled-elements">
					<a id="addaspek" title="guru" class="readmore readmoreasb"> <span> Tambah Aspek Kepribadian </span></a>
					<div id="ajaxside"></div>
					<div id="listaspekkepribadian">
						<div id="contentpage">
							<table class="tabelkelas">
								<thead>
									<tr> 
										<th>Aspek Kepribadian</th>
										<th>Action</th>
									</tr>                            
								</thead>
								<tbody>
									<? 
									if(!empty($aspekkepribadian)){
									foreach($aspekkepribadian as $dataaspekkepribadian){?>
									<tr >
										
										<td style="cursor:pointer;" onclick="editfield(this,'<?=$dataaspekkepribadian['id']?>','nama')" title="klik untuk mengedit data"><?=$dataaspekkepribadian['nama']?></td>
										<td title="klik untuk menghapus data" class="remove" style="cursor:pointer;" id="<?=$dataaspekkepribadian['id']?>">Delete</td>
									</tr>
									<? }}?>
								</tbody>
							</table>
							  <div id="ajax_paging">
								<?php //echo $pagination; ?>
							  </div>
							
						</div>
					</div>
                    <div class="hr"> </div>
                    <div class="clear"> </div>
                </div> <!-- **Styled Elements - End** -->  