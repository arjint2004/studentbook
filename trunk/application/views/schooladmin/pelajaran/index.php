			<script>
				/*js for pelajaran start*/
				jQuery(document).ready(function($){	
					$("a#addpelajaran").click(function() {
						var thisobj=$(this);
						$.ajax({
							type: "POST",
							data: "ajax=1",
							url: base_url+'admin/pelajaran/adddata',
							beforeSend: function() {
								$(thisobj).append("<img id='wait' src='"+config_images+"loaderhover.gif' />");
							},
							success: function(msg) {
								$("#wait").remove();			
								$("#ajaxside").html(msg);			
							}
						});					
					});
					
					function loaddatapelajaran(){
						$.ajax({
							type: "POST",
							data: "ajax=1",
							url: base_url+'admin/pelajaran/listData',
							beforeSend: function() {
								$("#listpelajaranloading").html("<img src='"+config_images+"loading.png' />");
							},
							success: function(msg) {
								$("#listpelajaran").html(msg);			
							}
						});
					}
					loaddatapelajaran();
				});
				
				/*js for pelajaran end*/
			</script>
			
			<h1 class="with-subtitle"> Data Pelajaran </h1>
				<h6 class="subtitle"> Pengaturan Pelajaran </h6>
                <div class="styled-elements">
					<a id="addpelajaran"  title="Pelajaran" class="readmore readmoreasb"> <span> Tambah Pelajaran </span></a>
					<div id="ajaxside"></div>
					<div id="listpelajaran"></div>
                    <div class="hr"> </div>
                    <div class="clear"> </div>
                </div> <!-- **Styled Elements - End** -->  