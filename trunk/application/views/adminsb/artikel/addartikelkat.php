<script>
				$(document).ready(function(){

					$("form#artikelkatform").submit(function(e){
						var thisobj=$(this);
						$.ajax({
							type: "POST",
							data: $("form#artikelkatform").serialize(),
							url: $(thisobj).attr('action'),
							beforeSend: function() {
								$(thisobj).after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
							},
							success: function(msg) {
								$("#wait").remove();
								//if(msg==1){
									$('#listartikel').load('<? echo base_url();?>adminsb/artikel/listartikelkat');
								//}
								
								$('#listartikel').scrollintoview({ speed:'1100'});
							}
						});
						return false;
					});//Submit End
					
				
				});
				</script>
<div class="addaccount">
<? if(isset($data)){$action="editkat";}else{$action="addartikelkat";}?>
<form action="<? echo base_url();?>adminsb/artikel/<?=$action?>" enctype="multipart/form-data" id="artikelkatform" name="artikelkatform" method="post" >
	<div class="addaccountclose" onclick="$('.addaccount').remove();"></div>
	<h3> <?=$page_title?> </h3><?// pr($pelajaran);?>
		<table class="adddata">
			
			<tr>
				<td width="30%" colspan="3" class='title' >Nama Kategori</td>
				</td>
			</tr>
			<tr>
				<td colspan="3">
					<input type="text" style="width:240px;" required value="<?=$data[0]['nama_kategori']?>" name="nama_kategori" size="30" />
				</td>
			</tr>
			
			<tr>
				<td width="30%" class='title'>Tampilkan di Homepage</td>
				<td width="1">:</td>
				<td>
					<input type="checkbox" name="is_slide_home" value="1" <? if($data[0]['is_slide_home']==1){echo 'checked';}?>/>
					<input type="hidden" name="is_slide_home" value="0" />
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