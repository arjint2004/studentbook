				<script>
				$(document).ready(function(){
								$("#ajax_pagingart a").click(function() {
									var url = $(this).attr("href");
									var thisobj= $(this);
									$.ajax({
									  type: "POST",
									  data: "<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&ajax=1&id_kategori="+$('select#id_kategori').val(),
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
								data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&'+$("form#filterartikel").serialize(),
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
					$("a.editdata").click(function(e){
						var thisobj=$(this);
						$.ajax({
							type: "POST",
							data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&'+$("form#filterartikel").serialize(),
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
					$("a.delete").click(function(e){
						if(confirm('Data artikel akan di hapus..?')){
							var thisobj=$(this);
							$.ajax({
								type: "POST",
								data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&'+$("form#filterartikel").serialize(),
								url: '<?=base_url()?>/adminsb/artikel/delete/'+$(thisobj).attr('id'),
								beforeSend: function() {
									$(thisobj).after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
								},
								success: function(msg) {
									
									$("#wait").remove();
									if(msg==1){
										$(thisobj).parent('td').parent('tr').remove();
									}
								}
							});
						}
						return false;
					});//Submit End
				
				});
					
				
				
				
				
				</script>
				
				<div id="contentpage">
							<br  class="clear"/>
							<br  />
							<h3>Daftar Artikel</h3>
							<form action="<?=base_url()?>/adminsb/artikel/artikellist" method="post" id="filterartikel" >
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
							<table class="tabelfilter">
								<tr>
									<td>
										Kategori
										<select class="selectgroup selectfilter" id="id_kategori" name="id_kategori">
											<option value="0">Pilih Kategori</option>
											<? foreach($kategori as $kategoridata){?>
											<option <? if(@$_POST['id_kategori']==$kategoridata['id_kategori']){echo 'selected';}?> value="<?=$kategoridata['id_kategori']?>"><?=$kategoridata['nama_kategori']?></option>
											<? } ?>
										</select>
									</td>
								</tr>
							</table>
							<input type="hidden" name="ajax" value="1" />
							</form>
							<table  id="tableartikeldata">
								<thead>
									<tr> 
										<th>No</th>
										<th>Judul</th>
										<th>Subdesc</th>
										<th>Foto</th>
										<th>Action</th>
									</tr>                            
								</thead>
								<tbody>
								<? 
								if(isset($artikeldata)){
								$i=0;
								foreach($artikeldata as $dataartikeldata){$i++;?>
									<tr  style="cursor:pointer;" title="" onclick="getdetail(<?=$dataartikeldata['id_artikel']?>,this);">
										<td><?=$i+$start?></td>
										<td class="title"><?=$dataartikeldata['judul']?></td>
										<td class="title"><?=$dataartikeldata['sub_desc']?></td>										
										<td class="title"><img src="<?=base_url()?>view.php?image=upload/images/artikel/<?=$dataartikeldata['foto']?>&amp;mode=crop&amp;size=100x100" alt=""></td>										
										<td class="title">
										<a class="editdata" style="cursor:pointer;" href="<?=base_url()?>adminsb/artikel/edit/<?=$dataartikeldata['id_artikel']?>" id="<?=$dataartikeldata['id_artikel']?>">Edit</a> |
										<a class="delete"  style="cursor:pointer;" id="<?=$dataartikeldata['id_artikel']?>">Delete</a>
										</td>
									</tr>
									
									<tr id="sub<?=$dataartikeldata['id']?>" style="display:none;" class="submapel">
										<td colspan="5" id="subload<?=$dataartikeldata['id']?>">
										
										</td>
									</tr>
								<? } } ?>
								</tbody>
							</table>
							  <div id="ajax_pagingart">
								<?php echo $pagination; ?>
							  </div>
							
					</div>
