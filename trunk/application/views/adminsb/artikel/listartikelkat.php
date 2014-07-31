				<script>
				$(document).ready(function(){
								$("#ajax_pagingartkat a").click(function() {
									var url = $(this).attr("href");
									var thisobj= $(this);
									$.ajax({
									  type: "POST",
									  data: 'ajax=1',
									  url: url,
									  beforeSend: function() {
										$(thisobj).append("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
									  },
									  success: function(msg) {
										$("#wait").remove();
										$("#listartikel").html(msg);
										//applyPagination();
									  }
									});
									return false;
								  });
								  
					$("#filterartikel select.selectgroup").change(function(e){
							var thisobj=$(this);
							$.ajax({
								type: "POST",
								data: $("form#filterartikel").serialize(),
								url: $("form#filterartikel").attr('action'),
								beforeSend: function() {
									$(thisobj).after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
								},
								success: function(msg) {
									$("#wait").remove();
									$("#listartikel").html(msg);	
								}
							});
							return false;
					});//Submit End
					$("a.delete").click(function(e){
						if(confirm('Jika anda menghapus kategori ini, maka artikel yang masuk dalam kategori ini akan ikut terhapus. Untuk mengatasinya pindahkan dulu semua artikel ke kategori lain, kemudian hapus.')){
						var thisobj=$(this);
							$.ajax({
								type: "POST",
								data: 'id_kategori='+$(thisobj).attr('id'),
								url: '<? echo base_url();?>adminsb/artikel/deletekat',
								beforeSend: function() {
									$(thisobj).after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
								},
								success: function(msg) {
									$("#wait").remove();
									$('#listartikel').load('<? echo base_url();?>adminsb/artikel/listartikelkat');
								}
							});
							return false;
						}
					});
					$("a.editdata").click(function(e){
						var thisobj=$(this);
						$.ajax({
							type: "POST",
							data: $("form#filterartikel").serialize(),
							url: $(thisobj).attr('href'),
							beforeSend: function() {
								$(thisobj).after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
							},
							success: function(msg) {
								$("#wait").remove();
								$("#addartikelok").html(msg);
								$('#addartikelok').scrollintoview({ speed:'1100'});
							}
						});
						return false;
					});//Submit End
					
					$('input.is_slide_home').change(function() {
						var thisobj=$(this);
							if($(this).is(':checked')) {
								var cek=1;
							} else {
								var cek=0;
							}
							$.ajax({
								type: "POST",
								data: 'id_kategori='+$(thisobj).attr('id')+'&cek='+cek,
								url: '<? echo base_url();?>adminsb/artikel/updateslide/'+cek,
								beforeSend: function() {
									$(thisobj).hide();
									$(thisobj).after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
								},
								success: function(msg) {
									$("#wait").remove();
									$(thisobj).show();
								}
							});
							return false;
					});
				});

				function update(obj){
					var value=$(obj).val();
					var id_kategori=$(obj).attr('id_kategori');
					var field=$(obj).attr('field');
					$(obj).parent().html(value);
					$.ajax({
							type: "POST",
							data: "simpleupdate=1&ajax=1&id_kategori="+id_kategori+"&"+field+"="+value,
							url: '<?=base_url()?>/adminsb/artikel/editartikelkat',
							beforeSend: function() {
								
							},
							success: function(msg) {
									
							}
					});
				}
				function editfield(obj,id_kategori,field){
					var value=$(obj).html();
					var childval=$(obj).children('input[type["text"]]').attr('type');
					if(childval!='text'){
						$(obj).html('<input maxlength="100" field="'+field+'" size="1" id="'+value+''+id_kategori+'" id_kategori="'+id_kategori+'" class="editintd"   onblur="update(this)" type="text" value="'+value+'" name="edit['+id_kategori+']" />');	
						$('#'+value+''+id_kategori+'').select();
					}
					
					$(obj).children('input[type["text"]]').focus();				

				}
				</script>
				<? //pr($artikelkatdata);?>
				<div id="contentpage">
							<br  class="clear"/>
							<br  />
							<h3>Daftar Kategori Artikel</h3>
							<table  id="tableartikelkatdata">
								<thead>
									<tr> 
										<th>No</th>
										<th>Nama Kategori</th>
										<th>Home Slide</th>
										<th>Action</th>
									</tr>                            
								</thead>
								<tbody>
								<? 
								if(isset($artikelkatdata)){
								$i=1;
								foreach($artikelkatdata as $dataartikelkatdata){?>
									<tr  style="cursor:pointer;" title="">
										<td><?=$i++?></td>
										<td class="title" title="klik untuk mengubah data" onclick="editfield(this,'<?=$dataartikelkatdata['id_kategori']?>','nama')"><?=$dataartikelkatdata['nama_kategori']?></td>
										<td class="title"><input type="checkbox" value="1" class="is_slide_home"  id="<?=$dataartikelkatdata['id_kategori']?>" <? if($dataartikelkatdata['is_slide_home']==1){echo 'checked';}?> name="is_slide_home" /></td>																			
										<td class="title">
										<!--<a class="editdata" style="cursor:pointer;"  onclick="editfield(this,'<?=$dataartikelkatdata['id_kategori']?>','nama')" >Edit</a> |-->
										<a class="delete"  style="cursor:pointer;" id="<?=$dataartikelkatdata['id_kategori']?>">Delete</a>
										</td>
									</tr>
									
									<tr id="sub<?=$dataartikelkatdata['id']?>" style="display:none;" class="submapel">
										<td colspan="5" id="subload<?=$dataartikelkatdata['id']?>">
										
										</td>
									</tr>
								<? } } ?>
								</tbody>
							</table>
							  <div id="ajax_pagingartkat">
								<?php echo $pagination; ?>
							  </div>
							
					</div>
