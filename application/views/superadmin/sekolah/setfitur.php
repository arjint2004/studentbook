<script>
	$(function() {
		$('div.full h3 i#nama<?=$id_sekolah?>').html($('table#akunsekolah tr#<?=$id_sekolah?> td.title').html());
		
		$("input.setfitur[type='checkbox']").live("click",function(e){
			//alert();
			e.stopImmediatePropagation();
			var thisobj= $(this);
			$.ajax({
				  type: "POST",
					 data: "<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&aktif="+$(thisobj).val()+"&id_sekolah="+$(this).attr('id_sekolah')+"&fitur="+$(this).attr('fitur'),
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
		
		$("select#sms_modem").live("change",function(e){
			//alert();
			e.stopImmediatePropagation();
			var thisobj= $(this);
			$.ajax({
				  type: "POST",
					 data: "<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&sms_modem="+$(thisobj).val(),
					 url: '<?=base_url()?>superadmin/sekolah/aktifasifitur/'+$(this).attr('id_sekolah')+'/'+$(this).attr('fitur'),
					beforeSend: function() {
						$(thisobj).after("<img id='wait' style='margin:0;'  src='<?=$this->config->item('images').'loading.png';?>' />");
						//$(thisobj).hide();
					},
					success: function(msg) {
						$("#wait").remove();
							
						//$(thisobj).show();
						//applyPagination();
				  }
			});
		});
	});
</script>
<div class="full file" style="margin-top:0;">
	<h3 style="margin-bottom:0;">Fitur "<i id="nama<?=$id_sekolah?>"></i>"</h3>
	<div class="hr"></div>

	<div class="full file" style="margin:0;min-height:50px;max-height:250px;overflow:auto;border:none;">
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
					<td class="title">SMS Absensi</td>
					<td><input class="setfitur" type="checkbox" fitur="sms_absensi" id_sekolah="<?=$id_sekolah?>" <? if(@$fitur[$id_sekolah]['sms_absensi']['aktif']==1){echo 'checked';}?> name="fitur[<?=$id_sekolah?>][sms_absensi]" value="<?=@$fitur[$id_sekolah]['sms_absensi']['aktif']?>"/></td>
				</tr>
				<tr>
					<td>2</td>
					<td class="title">SMS Notifikasi</td>
					<td><input class="setfitur" type="checkbox" fitur="sms_notifikasi" id_sekolah="<?=$id_sekolah?>" <? if(@$fitur[$id_sekolah]['sms_notifikasi']['aktif']==1){echo 'checked';}?> name="fitur[<?=$id_sekolah?>][sms_notifikasi]" value="<?=@$fitur[$id_sekolah]['sms_notifikasi']['aktif']?>"/></td>
				</tr>
				<tr>
					<td>3</td>
					<td class="title">SMS Blasting</td>
					<td><input class="setfitur" type="checkbox" fitur="sms_blasting" id_sekolah="<?=$id_sekolah?>" <? if(@$fitur[$id_sekolah]['sms_blasting']['aktif']==1){echo 'checked';}?> name="fitur[<?=$id_sekolah?>][sms_blasting]" value="<?=@$fitur[$id_sekolah]['sms_blasting']['aktif']?>"/></td>
				</tr>
				<tr>
					<td>3</td>
					<td class="title">Modem SMS</td>
					<td>
						<select id="sms_modem" name="sms_modem" fitur="sms_modem" id_sekolah="<?=$id_sekolah?>" style="margin:0;padding:6px;">
							<option <? if($modem==""){echo "selected";}?> value="">random</option>
							<option <? if($modem=="modem_1"){echo "selected";}?> value="modem_1">modem_1</option>
							<option <? if($modem=="modem_2"){echo "selected";}?> value="modem_2">modem_2</option>
							<option <? if($modem=="modem_3"){echo "selected";}?> value="modem_3">modem_3</option>
							<option <? if($modem=="modem_4"){echo "selected";}?> value="modem_4">modem_4</option>
							<option <? if($modem=="modem_5"){echo "selected";}?> value="modem_5">modem_5</option>
							<option <? if($modem=="modem_6"){echo "selected";}?> value="modem_6">modem_6</option>
							<option <? if($modem=="modem_7"){echo "selected";}?> value="modem_7">modem_7</option>
							<option <? if($modem=="modem_8"){echo "selected";}?> value="modem_8">modem_8</option>
							<option <? if($modem=="modem_9"){echo "selected";}?> value="modem_9">modem_9</option>
							<option <? if($modem=="modem_10"){echo "selected";}?> value="modem_10">modem_10</option>
						</select>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
							