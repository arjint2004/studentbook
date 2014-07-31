			<script>
				/*js for kelas start*/
				jQuery(document).ready(function($){	
					function loaddatakelas(){
						$.ajax({
							type: "POST",
							data: "ajax=1",
							url: base_url+'admin/kelas/listData',
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
				
				/*js for kelas end*/
			</script>
			
			<h1 class="with-subtitle"> Data Kelas </h1>
				<h6 class="subtitle"> Pengaturan Kelas </h6>
                <div class="styled-elements">
					<a id="addguru" onclick="$('#ajaxside').load('<?=base_url()?>admin/kelas/adddata')" title="guru" class="readmore readmoreasb"> <span> Tambah Kelas </span></a>
					<div id="kelasloading"></div>
					<div id="ajaxside"></div>
					<div id="listkelas"></div>
                    <div class="hr"> </div>
                    <div class="clear"> </div>
                </div> <!-- **Styled Elements - End** -->  