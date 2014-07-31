<script>

	$(document).ready(function(){
		$("#mapelform").each(function(){
			$container = $(this).next("div.error-container");
			//Validate Starts
			$(this).validate({
				onfocusout: function(element) {	$(element).valid();	},
				errorContainer: $container,
				rules:{
				  judul:{required:true,notEqual:''},
				  sub_desc:{required:true,notEqual:''},
				  tagline:{required:true,notEqual:''},
				  <? if(!isset($data)){?>
				  images:{required:true,notEqual:''},
				  <? } ?>
				  content:{required:true,notEqual:''}
				}
			});//Validate End

		});
		
		//Submit Starts		   
		$(".addaccountclose").click(function(){
			$(".addaccount").remove();
		});
		$("#mapelform").submit(function(e){
			CKEDITOR.instances.content.updateElement();
			$frm = $(this);
			if($frm.find('*[name=content]').val()==''){
				$('#cke_content').addClass('error');
				return false;
			}else{
				$('#cke_content').removeClass('error');
			}
			
			$judul = $frm.find('*[name=judul]').val();
			$sub_desc = $frm.find('*[name=sub_desc]').val();
			$tagline = $frm.find('*[name=tagline]').val();
			<? if(isset($data)){?>
			$images = $frm.find('*[name=images]').val();
			<? } ?>
			$content = $frm.find('*[name=content]').val();
			if($frm.find('*[name=judul]').is('.valid') && $frm.find('*[name=sub_desc]').is('.valid') && $frm.find('*[name=tagline]').is('.valid') <? if(!isset($data)){?> && $frm.find('*[name=images]').is('.valid') <? } ?> && $frm.find('*[name=content]').is('.valid')) {
				
				
				
			}
		});//Submit End	
	});
</script>	
<!--<link type="text/css" href="<?=$this->config->item('css');?>datepick.css" rel="stylesheet">
<script type="text/javascript" src="<?=$this->config->item('js');?>jquery.datepick.js"></script>
<script type="text/javascript" src="<?=$this->config->item('js');?>jquery.datepick-id.js"></script>-->
<script type="text/javascript" src="<?=$this->config->item('js');?>upload.js"></script>

<script type="text/javascript">
/*function getadd(obj,date) {

}
$(function() {
	$('#datemapelform').datepick();
});*/
</script>

<? //pr($data);?>
		<br class="clear" />
		<br />
		<h3> <?=$page_title?></h3> 
		<form action="<? echo base_url();?>adminsb/admin/addslide" enctype="multipart/form-data" id="mapelform" name="mapelform" method="post" >
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
					<select name="id_kategori" disabled>
						<option value="0">Pilih Kategori</option>
						<? foreach($kategori as $datakat){?>
						<option <? if($id_kat==$datakat['id_kategori']){echo "selected";}?> value="<?=$datakat['id_kategori']?>"><?=$datakat['nama_kategori']?></option>
						<? } ?>
					</select>
					<input type="hidden" style="width:99%;" value="<?=$id_kat?>" name="id_kategori" />
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
				<input type="hidden" value="<?=$data[0]['foto']?>" name="foto" />
				<? } ?>
				</td>
			</tr>
			<tr>
				<td width="30%" colspan="3" class='title'>Content</td>
				</td>
			</tr>
			<tr>
				<td width="30%" colspan="3" class='title'>
				<textarea name="content" id="content" required><?=$data[0]['content']?></textarea>
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
	<input type="hidden" name="id_artikel" value="<?=$data[0]['id_artikel']?>"/>
	<input type="hidden" name="ajax" value="1"/> 
	<input type="hidden" name="position" value="<?=$position?>"/>
	</form>
	<div class="error-container" style="display:none;"> Semua field harus di isi atau dipilih!  </div>
<script type="text/javascript">
$(document).ready(function(){
	/*$('#mapelform').submit(function(e){
		var obj=$(this);
		//e.stopImmediatePropagation();
		$.ajax({
			type: "POST",
			data: $(obj).serialize()+"&ajax=1",
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
											data: $('form#contentsekolah').serialize()+"&ajax=1&simpan=1&content="+content,
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