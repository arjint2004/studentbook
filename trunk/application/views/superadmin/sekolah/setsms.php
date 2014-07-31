<script>
	$(function() {
		$('div.full h3 i#nama<?=$id_sekolah?>').html($('table#akunsekolah tr#<?=$id_sekolah?> td.title').html());
		
		$("input.setfitur[type='checkbox']").live("click",function(e){
			//alert();
			e.stopImmediatePropagation();
			var thisobj= $(this);
			$.ajax({
				  type: "POST",
					 data: "aktif="+$(thisobj).val()+"&id_sekolah="+$(this).attr('id_sekolah')+"&fitur="+$(this).attr('fitur'),
					 url: '<?=base_url()?>superadmin/sekolah/aktifasifitur/'+$(this).attr('id_sekolah')+'/'+$(this).attr('fitur'),
					beforeSend: function() {
						$(thisobj).after("<img id='wait' style='margin:0;'  src='<?=$this->config->item('images').'loading.png';?>' />");
						$(thisobj).hide();
					},
					success: function(msg) {
						$("#wait").remove();
						if(msg==1){
							$(thisobj).prop('checked', true);
							$(thisobj).val(1);
						}else{
							$(thisobj).prop('checked', false);
							$(thisobj).val(0);
						}
												
						$(thisobj).show();
						//applyPagination();
				  }
			});
		});
		
		$("input.aktifasisendername[type='checkbox']").live("click",function(e){
			//alert();
			e.stopImmediatePropagation();
			var thisobj= $(this);
			$.ajax({
				  type: "POST",
					 data: "aktif="+$(thisobj).val()+"&id_sekolah="+$(this).attr('id_sekolah'),
					 url: '<?=base_url()?>superadmin/sekolah/aktifasisendername',
					beforeSend: function() {
						$(thisobj).after("<img id='wait' style='margin:0;'  src='<?=$this->config->item('images').'loading.png';?>' />");
						$(thisobj).hide();
					},
					success: function(msg) {
						$("#wait").remove();
						if(msg==1){
							$(thisobj).prop('checked', true);
							$(thisobj).val(1);
						}else{
							$(thisobj).prop('checked', false);
							$(thisobj).val(0);
						}
												
						$(thisobj).show();
						//applyPagination();
				  }
			});
		});
	});
</script>
<?//pr($sekolah);?>
<div class="full file" style="margin-top:0;">
	<h3 style="margin-bottom:0;">Setting SMS "<i id="nama<?=$id_sekolah?>"></i>"</h3>
	<div class="hr"></div>
				
	<div class="full file" style="margin:0;min-height:50px;overflow:auto;border:none;">
		<table class="noborder">
			<tbody>
				<tr>
					<td class="title">Nama Pengirim SMS</td>
					<td><? if($sekolah[0]['sendername']==''){echo 'STUDENTBOOK';}else{ echo $sekolah[0]['sendername'];}?></td>
				</tr>
				<tr>
					<td class="title">Ijinkan Nama Pengirim SMS</td>
					<td>
					<? if($sekolah[0]['sendername']!=''){?>
					<input type="checkbox" class="aktifasisendername" id_sekolah="<?=$sekolah[0]['id']?>" name="aktifasisendername[<?=$sekolah[0]['id']?>]" <? if($sekolah[0]['aktifasisendername']==1){echo'checked';}?> value="<?=$sekolah[0]['aktifasisendername']?>"/>
					<?}else{?>
					DEFAULT
					<? } ?>
					</td>
				</tr>
				<tr>
					<td class="title">SMS Notifikasi</td>
					<td><?if($aktifasisms_notifikasi[0]['aktif']==1){echo 'AKTIF';}else{echo 'TIDAK AKTIF';}?></td>
				</tr>
				<tr>
					<td class="title">SMS Blasting</td>
					<td><?if($aktifasisms_blasting[0]['aktif']==1){echo 'AKTIF';}else{echo 'TIDAK AKTIF';}?></td>
				</tr>
				<tr>
					<td class="title">Jumlah Pulsa</td>
					<td><?=$sekolah[0]['jml_pulsa']?></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
							