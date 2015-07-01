<script>
$(document).ready(function(){
		$(".addaccountclose").click(function(){
			$(".addaccount").remove();
		});
		$("#simpanaspek").click(function(){
			var obj=$(this);
			$.ajax({
				type: "POST",
				data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&'+$('form#mapelform').serialize(),
				url: base_url+'admin/setting/addaspek',
				beforeSend: function() {
					$(obj).after("<img id='wait1' src='"+config_images+"loading.png' />");
				},
				success: function(msg) {
					$(".addaccount").remove();
					$("#wait1").remove();
					$.ajax({
						type: "POST",
						data: "<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&ajax=1",
						url: base_url+'admin/setting/aspekkepribadian',
						beforeSend: function() {
							$(obj).after("<img id='wait2' src='"+config_images+"loading.png' />");
						},
						success: function(msg) {
							$("#wait2").remove();
							$(".main-content").html(msg);			
						}
					});
				}
			});
			return false;
		});
});
</script>
<div class="addaccount">
<form action="<? echo base_url();?>admin/setting/addaspek" id="mapelform" name="aspekform" method="post" >
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
	<div class="addaccountclose" onclick="$('.addaccount').remove();"></div>
	<h3> Tambah Aspek Kepribadian </h3>
		<table class="adddata">
		
			<tr>
				<td width="30%" class='title'>Aspek Kepribadian</td>
				<td width="1">:</td>
				<td><input type="text" name="nama" size="30" /></td>
			</tr>
			
			<tr>
				<td class="title" colspan="3"><input id="simpanaspek" type="submit" name="simpan" value="Simpan"/></td>
			</tr>
		</table>

	<input type="hidden" name="addaspek" value="1"/> 
	<input type="hidden" name="ajax" value="1"/> 
	</form>
	<div class="error-container" style="display:none;"> Semua field harus di isi atau dipilih!  </div>
</div>