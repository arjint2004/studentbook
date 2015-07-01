
							<form action="<?=base_url()?>admin/content/edit/<?=$title?>" method="post" id="contentsekolah">
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
							<table class="tabelkelas">
								<thead>
									<tr> 
										<th> <?=base64_decode($title)?> </th>
									</tr>                            
								</thead>
								<tbody>
								
									<tr>
										<td>
											<textarea id="<?=str_replace(" ","",base64_decode($title))?>" name="content" rows="50" cols="80"><?=$content[0]['content']?></textarea>
											<input type="hidden" value="<?=base64_decode($title)?>" name="title">
											<input type="submit" value="Simpan" name="simpan" id="simpancontentsekolah">
										</td>
									</tr>
								</tbody>
							</table>
							</form>
							<script type="text/javascript">
							jQuery(document).ready(function($){	
									/*$('form#contentsekolah').submit(function(){
										var ins = CKEDITOR.instances.<?=str_replace(" ","",base64_decode($title))?>;
										var content=ins.getData();
										$.ajax({
											type: "POST",
											data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&'+$('form#contentsekolah').serialize()+"&ajax=1&simpan=1&content="+content,
											url: $(this).attr('action'),
											beforeSend: function() {
												$("#listcontentloading").html("<img src='"+config_images+"loading.png' />");
											},
											success: function(msg) {
												$("#listcontent").html(msg);	
												//loadEditor($(obj).attr('id'))
											}
										});
										return false;
									});*/
							});
								
							var instance = CKEDITOR.instances['<?=str_replace(" ","",base64_decode($title))?>'];
								if(instance)
								{
									CKEDITOR.remove(instance);
								}
							//<![CDATA[
								var editor =CKEDITOR.replace('<?=str_replace(" ","",base64_decode($title))?>');
								editor.resize( '100%', '800' )
								CKFinder.setupCKEditor( editor, '/studentbookrepo/asset/default/js/ckfinder/' ) ;
							    //CKFinder.SetupCKEditor( editor, { BasePath : "/studentbookrepo/asset/default/js/ckfinder/", RememberLastFolder : false } ) ;
							//]]>
							</script>