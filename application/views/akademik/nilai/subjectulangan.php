			<script>
				/*js for pelajaran start*/
				jQuery(document).ready(function($){	
					function loaddataulanganharian(){
						$.ajax({
							type: "POST",
							data: "<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&ajax=1",
							url: base_url+'admin/nilaiulharian/listSubjectUlanganHarian',
							beforeSend: function() {
								$("#listpelajaranloading").html("<img src='"+config_images+"loading.png' />");
							},
							success: function(msg) {
								$("#listpelajaran").html(msg);			
							}
						});
					}
					loaddataulanganharian();
				});
				
				/*js for pelajaran end*/
			</script>
			
			<h1 class="with-subtitle"> Data Ulangan Harian </h1>
				<h6 class="subtitle"> Pengaturan Subject Untuk Ulangan Harian </h6>
                <div class="styled-elements">
					<a id="addguru" onclick="$('#ajaxside').load('<?=base_url()?>admin/nilaiulharian/addSubjectUlHarian/<?=base64_encode('ulangan harian');?>')" title="guru" class="readmore readmoreasb"> <span> Tambah Subject </span></a>
					<div id="ajaxside"></div>
					<div id="listpelajaran"></div>
                    <div class="hr"> </div>
                    <div class="clear"> </div>
                </div> <!-- **Styled Elements - End** -->  