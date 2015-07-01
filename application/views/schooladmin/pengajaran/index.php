			<script>
				/*js for pengajaran start*/
				jQuery(document).ready(function($){	
					function loaddatapengajaran(){
						$.ajax({
							type: "POST",
							data: "<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&ajax=1",
							url: base_url+'admin/pengajaran/listData',
							beforeSend: function() {
								$("#listpengajaranloading").html("<img src='"+config_images+"loading.png' />");
							},
							success: function(msg) {
								$("#listpengajaranloading").html("");
								$("#listpengajaran").html(msg);			
							}
						});
					}
					loaddatapengajaran();
				});
				
				/*js for pengajaran end*/
			</script>
			
			<h1 class="with-subtitle"> Data pengajaran </h1>
				<h6 class="subtitle"> Pengaturan pengajaran </h6>
                <div class="styled-elements">
					<a id="addguru" onclick="$('#ajaxside').load('<?=base_url()?>admin/pengajaran/adddataSimple')" title="guru" class="readmore readmoreasb"> <span> Tambah pengajaran </span></a>
					<div id="listpengajaranloading"></div>
					<div id="ajaxside"></div>
					<div id="listpengajaran"></div>
                    <div class="hr"> </div>
                    <div class="clear"> </div>
                </div> <!-- **Styled Elements - End** -->  