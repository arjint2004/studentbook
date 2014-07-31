			<script>
				/*js for kegiatan start*/
				jQuery(document).ready(function($){	
					function loaddatakelas(){
						$.ajax({
							type: "POST",
							data: "ajax=1",
							url: base_url+'admin/kegiatan/listData',
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
				});
				
				/*js for kegiatan end*/
			</script>
			
			<h1 class="with-subtitle"> Data Pengembangan Diri </h1>
				<h6 class="subtitle"> Pengaturan Pengembangan Diri </h6>
                <div class="styled-elements">
					<a id="addguru" onclick="$('#listkelasloading').load('<?=base_url()?>admin/kegiatan/adddata')" title="guru" class="readmore readmoreasb"> <span> Tambah Pengembangan Diri </span></a>
					<div id="listkelasloading"></div>
					<div id="listkelas"></div>
                    <div class="hr"> </div>
                    <div class="clear"> </div>
                </div> <!-- **Styled Elements - End** -->  