<script>
	$(document).ready(function(){
			$.ajax({
				type: "POST",
				data: 'id_kategori=<?=$id_kat?>',
				url: '<? echo base_url();?>adminsb/admin/getselectartikelbykat',
				beforeSend: function() {
					$('select#id_kategoriaddother').after("<img id='wait' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
				},
				success: function(msg) {
					$("#wait").remove();
					
					$('select#id_artikelother').html(msg);
				}
			});
		$('select#id_kategoriaddother').change(function(e){
			var obj=$(this);
			$.ajax({
				type: "POST",
				data: 'id_kategori='+$('select#id_kategoriaddother').val(),
				url: '<? echo base_url();?>adminsb/admin/getselectartikelbykat',
				beforeSend: function() {
					$(obj).after("<img id='wait' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
				},
				success: function(msg) {
					$("#wait").remove();
					
					$('select#id_artikelother').html(msg);
				}
			});
			return false;
		});
	});
</script>
<form action="<? echo base_url();?>adminsb/admin/addslideother" enctype="multipart/form-data" id="mapelform" name="mapelform" method="post" >
<table class="adddata">
			<tr>
				<td width="30%" colspan="3" class='title'>Rubrik</td>
				</td>
			</tr>
			<tr>
				<td colspan="3">
					<select name="id_kategori" id="id_kategoriaddother" disabled>
						<? foreach($kategori as $datakat){?>
						<option <? if($id_kat==$datakat['id_kategori']){echo "selected";}?> value="<?=$datakat['id_kategori']?>"><?=$datakat['nama_kategori']?></option>
						<? } ?>
					</select>
					<input type="hidden" value="<?=$id_kat?>" name="id_kategori" />
				</td>
			</tr>
			<tr>
				<td width="30%" colspan="3" class='title'>Artikel</td>
				</td>
			</tr>
			<tr>
				<td colspan="3">
					<select name="id_artikel" id="id_artikelother">
						<option value="0">Pilih Artikel</option>
					</select>
				</td>
			</tr>
			
			<tr>
				<td class="title" colspan="3"><input id="simpanpelajaran" type="submit" name="simpan" value="Simpan"/></td>
			</tr>
</table>
<input type="hidden" name="ajax" value="1"/>
<input type="hidden" name="position" value="<?=$position?>"/>
</form>