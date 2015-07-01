			<script>
				/*js for sms start*/
				jQuery(document).ready(function($){	
					$('a.readmore').click(function(){
						var url=$(this).attr('href');
						var self=$(this);
						$.ajax({
							type: "POST",
							data: "<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&ajax=1",
							url: url,
							beforeSend: function() {
								$(self).append("<img class='wait' src='"+config_images+"loaderhover.gif' />");
							},
							success: function(msg) {
								$(".wait").remove();	
								$("#listsms").html(msg);	
								
							}
						});
						return false;
					});
				});
				
				/*js for sms end*/
			</script>
			
			<h1 class="with-subtitle"> SMS </h1>
				<h6 class="subtitle"> Pengaturan sms </h6>
                <div class="styled-elements">
					<a id="addguru" href="<?=base_url()?>admin/sms/index" title="guru" class="readmore readmoreasb contentsek"> <span> SMS Broadcast </span></a>
					<a id="addguru" href="<?=base_url()?>admin/sms/sendername" title="guru" class="readmore readmoreasb contentsek"> <span> Nama Pengirim </span></a>
					<div id="smsloading"></div>
					<div id="ajaxside"></div>
					<div id="listsms"></div>
                    <div class="hr"> </div>
                    <div class="clear"> </div>
                </div> <!-- **Styled Elements - End** -->  