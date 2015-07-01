<div class="addaccount">
<? if(isset($data)){$action="edit";}else{$action="addartikel";}?>
<form action="<? echo base_url();?>adminsb/artikel/<?=$action?>" enctype="multipart/form-data" id="mapelform" name="mapelform" method="post" >
<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
	<div class="addaccountclose" onclick="$('.addaccount').remove();"></div>
	<h3> <?=$page_title?> </h3><?// pr($pelajaran);?>
		<table class="adddata">
			
			<tr>
				<td width="30%" colspan="3" class='title' >Judul</td>
				</td>
			</tr>
			<tr>
				<td colspan="3">
					<input type="text" style="width:99%;" value="<?=$data[0]['judul']?>" name="judul" size="30" />
				</td>
			</tr>
			<tr>
				<td width="30%" colspan="3" class='title'>Kategori</td>
				</td>
			</tr>
			<tr>
				<td colspan="3">
					<select name="id_kategori">
						<option value="0">Pilih Kategori</option>
						<? foreach($kategori as $datakat){?>
						<option <? if($data[0]['id_kategori']==$datakat['id_kategori']){echo "selected";}?> value="<?=$datakat['id_kategori']?>"><?=$datakat['nama_kategori']?></option>
						<? } ?>
					</select>
				</td>
			</tr>
			<tr>
				<td width="30%" colspan="3" class='title'>Sub Desc</td>
				</td>
			</tr>
			<tr>
				<td width="30%" colspan="3" class='title'>
				<textarea name="sub_desc" style="width:99%;height:100px;" ><?=$data[0]['sub_desc']?></textarea>
				</td>
			</tr>
			<tr>
				<td width="30%" colspan="3" class='title'>Tag</td>
				</td>
			</tr>
			<tr>
				<td width="30%" colspan="3" class='title'>
				<textarea name="tagline" style="width:99%;height:100px;" ><?=$data[0]['tagline']?></textarea>
				</td>
			</tr>
			<tr>
				<td width="30%" colspan="3" class='title'>Foto Utama</td>
				</td>
			</tr>
			<tr>
				<td width="30%" colspan="3" class='title'>
				<input type="file" name="images" />
				<? if(isset($data[0]['foto'])){?>
				<img src="<?=base_url()?>upload/images/artikel/<?=$data[0]['foto']?>" width="70" />
				<input type="hidden" style="width:99%;" value="<?=$data[0]['id_artikel']?>" name="id_artikel" />
				<? } ?>
				</td>
			</tr>
			<tr>
				<td width="30%" colspan="3" class='title'>Content</td>
				</td>
			</tr>
			<tr>
				<td width="30%" colspan="3" class='title'>
				<textarea name="content" id="content" ><?=$data[0]['content']?></textarea>
				</td>
			</tr>
			<tr>
				<td width="30%" class='title'>Publish</td>
				<td width="1">:</td>
				<td>
					<input type="hidden" name="status" value="0" />
					<input type="checkbox" name="status" value="1" <? if($data[0]['status']==1){echo 'checked';}?>/>
				</td>
			</tr>
			
			<tr>
				<td class="title" colspan="3"><input id="simpanpelajaran" type="submit" name="simpan" value="Simpan"/></td>
			</tr>
		</table>
	<input type="hidden" name="ajax" value="1"/> 
	</form>
	<div class="error-container" style="display:none;"> Semua field harus di isi atau dipilih!  </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	/*$('#mapelform').submit(function(e){
		var obj=$(this);
		//e.stopImmediatePropagation();
		$.ajax({
			type: "POST",
			data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&'+$(obj).serialize()+"&ajax=1",
			url: $(obj).attr('action'),
			beforeSend: function() {
				$('#simpanpelajaran').append("<img id='wait' src='"+config_images+"loaderhover.gif' />");
			},
			success: function(msg) {
				$("#wait").remove();			
				$("#ajaxside").html(msg);	
				$("#ajaxside").scrollintoview({ speed:'1100'}); 
			}
		});
		
		return false;
	});*/
						/**/
});
				
				
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
								
							var instance = CKEDITOR.instances['content'];
								if(instance)
								{
									CKEDITOR.remove(instance);
								}
							//<![CDATA[
								var editor =CKEDITOR.replace('content');
								editor.resize( '100%', '800' )
								CKFinder.setupCKEditor( editor, '/studentbookrepo/asset/default/js/ckfinder/' ) ;
							    //CKFinder.SetupCKEditor( editor, { BasePath : "/studentbookrepo/asset/default/js/ckfinder/", RememberLastFolder : false } ) ;
							//]]>
							</script>