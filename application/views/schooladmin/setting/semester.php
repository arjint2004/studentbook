			<script>
				/*js for semester start*/
				jQuery(document).ready(function($){	
					
				});
				function loaddatasemester(){
					$.ajax({
						type: "POST",
						data: "<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&ajax=1",
						url: base_url+'admin/setting/semester',
						beforeSend: function() {
							$("#ajaxside").html("<img src='"+config_images+"loading.png' />");
						},
						success: function(msg) {
							$("#main-content").html(msg);			
						}
					});
				}
				function aktifasi(obj,id,aktif){
						$.ajax({
							type: "POST",
							data: "<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&ajax=1&id="+id+"&aktif="+aktif,
							url: base_url+'admin/setting/aktifasiSemester',
							beforeSend: function() {
								$(obj).append("<img id='wait'style='margin: 0px; float: right; position: absolute;right:35px;' src='"+config_images+"loading.png' />");
							},
							success: function(msg) {
								$("#ajaxside").html("");
								$.ajax({
									type: "POST",
									data: "<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&ajax=1",
									url: base_url+'admin/setting/semester',
									beforeSend: function() {
										$("#ajaxside").html("<img src='"+config_images+"loading.png' />");
									},
									success: function(msg) {
										$("#ajaxside").html("");
										$(".main-content").html(msg);			
									}
								});		
							}
						});
				}
				/*js for semester end*/
			</script>
			<h1 class="with-subtitle"> Data Semester </h1>
				<h6 class="subtitle"> Pengaturan semester untuk identifikasi data pada semester yang aktif </h6>
                <div class="styled-elements">
					<!--<a id="addguru" onclick="$('#ajaxside').load('<?=base_url()?>admin/semester/adddata')" title="guru" class="readmore readmoreasb"> <span> Tambah semester </span></a>-->
					<div id="ajaxside"></div>
					<div id="listsemester">
						<div id="contentpage">
							<table class="tabelkelas">
								<thead>
									<tr> 
										<th>Semester</th>
										<th>Action</th>
									</tr>                            
								</thead>
								<tbody>
									<? foreach($semester as $datasemester){?>
									<tr>
										<td ><?=$datasemester['nama']?></td>
										<td <? if($datasemester['aktif']==1){?>style="cursor:pointer;font-weight:bold;background-color: #CCCCCC;color: #000000;cursor: pointer;" <? } ?> title="klik untuk mengaktifkan semester" style="cursor:pointer;" onclick="aktifasi(this,'<?=$datasemester['id']?>',<?=$datasemester['aktif']?>)" title="klik untuk mengedit data"><? if($datasemester['aktif']==0){?>Aktifkan<?}?><? if($datasemester['aktif']==1){?>AKTIF<?}?></td>
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