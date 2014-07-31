			<script>
				/*js for tahunAjaran start*/
				jQuery(document).ready(function($){	
					
				});
				function loaddatatahunAjaran(){
					$.ajax({
						type: "POST",
						data: "ajax=1",
						url: base_url+'admin/setting/tahunAjaran',
						beforeSend: function() {
							$("#ajaxside").html("<img src='"+config_images+"loading.png' />");
						},
						success: function(msg) {
							$("#main-content").html(msg);			
						}
					});
				}
				function aktifasi(obj,id,aktif){
						//alert();
						if($(obj).html()==' AKTIF '){return false;}
						$.ajax({
							type: "POST",
							data: "ajax=1&id="+id+"&aktif="+aktif,
							url: base_url+'admin/setting/aktifasitahunAjaran',
							beforeSend: function() {
								$(obj).append("<img id='wait'style='margin: 0px; float: right; position: absolute;right:35px;' src='"+config_images+"loading.png' />");
							},
							success: function(msg) {
								$("#wait").remove();
								$.ajax({
									type: "POST",
									data: "ajax=1",
									url: base_url+'admin/setting/tahunAjaran',
									beforeSend: function() {
										$(obj).append("<img id='wait'style='margin: 0px; float: right; position: absolute;right:35px;' src='"+config_images+"loading.png' />");
									},
									success: function(msg) {
										$("#wait").remove();
										$(".main-content").html(msg);			
									}
								});		
							}
						});
				}
				/*js for tahunAjaran end*/
			</script>
			<h1 class="with-subtitle"> Data Tahun Ajaran </h1>
				<h6 class="subtitle"> Pengaturan tahun Ajaran untuk identifikasi data pada tahun Ajaran yang aktif, pilihlah tahun ajaran yang sesuai </h6>
                <div class="styled-elements">
					<!--<a id="addguru" onclick="$('#ajaxside').load('<?=base_url()?>admin/tahunAjaran/adddata')" title="guru" class="readmore readmoreasb"> <span> Tambah tahunAjaran </span></a>-->
					<div id="ajaxside"></div>
					<div id="listtahunAjaran">
						<div id="contentpage">
							<table class="tabelkelas">
								<thead>
									<tr> 
										<th>Tahun Ajaran</th>
										<th>Action</th>
									</tr>                            
								</thead>
								<tbody>
									<? foreach($tahunAjaran as $datatahunAjaran){?>
									<tr >
										<td ><?=$datatahunAjaran['nama']?></td>
										
										<td title="klik untuk mengaktifkan tahunAjaran" style="cursor:pointer;<?if($datatahunAjaran['aktif']==1){echo 'font-weight:bold;background-color: #CCCCCC;color: #000000;cursor: pointer;';}?>" onclick="aktifasi(this,'<?=$datatahunAjaran['id']?>',<?=$datatahunAjaran['aktif']?>)" title="klik untuk mengedit data"><? if($datatahunAjaran['aktif']==0){?>Aktifkan<?}?><? if($datatahunAjaran['aktif']==1){?> AKTIF <?}?></td>
									</tr>
									<? }?>
								</tbody>
							</table>
							  <div id="ajax_paging">
								<?php //echo $pagination; ?>
							  </div>
							
						</div>
					</div>
                    <div class="hr"> </div>
                    <div class="clear"> </div>
                </div> <!-- **Styled Elements - End** -->  