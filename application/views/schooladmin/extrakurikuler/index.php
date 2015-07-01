			<script>
				/*js for extrakurikuler start*/
				jQuery(document).ready(function($){	
					function loaddatakelas(){
						$.ajax({
							type: "POST",
							data: "<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&ajax=1",
							url: base_url+'admin/extrakurikuler/listData',
							beforeSend: function() {
								$("#listkelasloading").html("<img src='"+config_images+"loading.png' />");
							},
							success: function(msg) {
								$("#listkelasloading").html("");
								$("#listkelas").html(msg);			
							}
						});
					}
					loaddatakelas();
					$('#addekdtra').click(function(){
						$.ajax({
							type: "GET",
							data: "<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&ajax=1",
							url: base_url+'admin/extrakurikuler/adddata',
							beforeSend: function() {
								$("#addekdtra").after("<img id='wait' style='margin: 9px 0px 0px;' src='"+config_images+"loading.png' />");
							},
							success: function(msg) {
								$("#wait").remove();			
								$("#listkelasloading").html(msg);
							}
						});
					});
				});
				
				/*js for extrakurikuler end*/
			</script>
			
			<h1 class="with-subtitle"> Data extrakurikuler </h1>
				<h6 class="subtitle"> Pengaturan extrakurikuler </h6>
                <div class="styled-elements">
					<a id="addekdtra" title="guru" class="readmore readmoreasb"> <span> Tambah Ekstrakurikuler </span></a>
					<div id="listkelasloading"></div>
					<div id="listkelas"></div>
                    <div class="hr"> </div>
                    <div class="clear"> </div>
                </div> <!-- **Styled Elements - End** -->  