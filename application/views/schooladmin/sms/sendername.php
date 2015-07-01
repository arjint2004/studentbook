<br class="clear" />
<br class="clear" />
<link id="default-css" href="<?=$this->config->item('css');?>sms.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript">
				/*js for content start*/
				jQuery(document).ready(function($){	
					$('form.sendername').submit(function(){
					$("#listcontent").html('');	
						var obj=$(this);
						$.ajax({
							type: "POST",
							data:$(this).serialize()+"&ajax=1",
							url: $(this).attr('action'),
							beforeSend: function() {
								$("input#submit").after("<img id='wait' src='"+config_images+"loading.png' />");
							},
							success: function(msg) {
								$("#wait").remove();	
								$.ajax({
									type: "POST",
									data:"ajax=1",
									url: '<?=base_url()?>admin/sms/sendername',
									beforeSend: function() {
										$("input#submit").after("<img src='"+config_images+"loading.png' />");
									},
									success: function(msg) {
										$("#listsms").html(msg);	
									}
								});
							}
						});
						return false;
					});

					
				});
				
				/*js for content end*/
			</script>
<div class="containersms">
    <form id="signup" class="sendername" action="<?=site_url('admin/sms/sendername')?>" method="POST">
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
        <div class="header">
            <h3>Nama Pengirim</h3> 
        </div>
        <div class="sep"></div>
        <div class="inputs">
            <input type="text" maxlength="11" name="sendername" value="<?=$sendername[0]['sendername']?>" placeholder="isikan nama pengirim"/>
            <input type="submit" id="submit" name="sendername" value="Ubah"/>
        </div>
    </form>
</div>
​
