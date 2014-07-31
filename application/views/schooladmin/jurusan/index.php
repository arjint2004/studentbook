			<script>
				/*js for jurusan start*/
				jQuery(document).ready(function($){	
				
					$("a#addguru").click(function() {
						var thisobj=$(this);
						$.ajax({
							type: "POST",
							data: "ajax=1",
							url: base_url+'admin/jurusan/adddata',
							beforeSend: function() {
								$(thisobj).append("<img id='wait' src='"+config_images+"loaderhover.gif' />");
							},
							success: function(msg) {
								$("#wait").remove();			
								$("#ajaxside").html(msg);			
							}
						});					
					});
					function loaddatakelas(){
						$.ajax({
							type: "POST",
							data: "ajax=1",
							url: base_url+'admin/jurusan/listData',
							beforeSend: function() {
								$("#listkelasloading").html("<img src='"+config_images+"loading.png' />");
							},
							success: function(msg) {
								$("#listkelas").html(msg);			
							}
						});
					}
					loaddatakelas();
				});
				
				/*js for jurusan end*/
			</script>
			
			<h1 class="with-subtitle"> Data Jurusan </h1>
				<h6 class="subtitle"> Pengaturan Jurusan </h6>
                <div class="styled-elements">
					<a id="addguru"  title="guru" class="readmore readmoreasb"> <span> Tambah Jurusan </span></a>
					<div id="ajaxside"></div>
					<div id="listkelas"></div>
                    <div class="hr"> </div>
                    <div class="clear"> </div>
                </div> <!-- **Styled Elements - End** -->  