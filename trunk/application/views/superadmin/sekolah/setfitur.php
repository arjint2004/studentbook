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
	});
</script>
<div class="full file" style="margin-top:0;">
	<h3 style="margin-bottom:0;">Fitur "<i id="nama<?=$id_sekolah?>"></i>"</h3>
	<div class="hr"></div>
				
	<div class="full file" style="margin:0;min-height:50px;max-height:200px;overflow:auto;border:none;">
		<table class="noborder">
			<thead>
				<tr> 
				<th> No </th>
				<th> Fitur </th>
				<th> Aktifasi </th>
				</tr>                            
			</thead>
			<tbody>
				<tr>
					<td>1</td>
					<td class="title">SMS Notifikasi</td>
					<td><input class="setfitur" type="checkbox" fitur="sms_notifikasi" id_sekolah="<?=$id_sekolah?>" <? if(@$fitur[$id_sekolah]['sms_notifikasi']['aktif']==1){echo 'checked';}?> name="fitur[<?=$id_sekolah?>][sms_notifikasi]" value="<?=@$fitur[$id_sekolah]['sms_notifikasi']['aktif']?>"/></td>
				</tr>
				<tr>
					<td>2</td>
					<td class="title">SMS Blasting</td>
					<td><input class="setfitur" type="checkbox" fitur="sms_blasting" id_sekolah="<?=$id_sekolah?>" <? if(@$fitur[$id_sekolah]['sms_blasting']['aktif']==1){echo 'checked';}?> name="fitur[<?=$id_sekolah?>][sms_blasting]" value="<?=@$fitur[$id_sekolah]['sms_blasting']['aktif']?>"/></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
							