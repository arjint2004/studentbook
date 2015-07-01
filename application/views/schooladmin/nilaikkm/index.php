			<script>
				/*js for pelajaran start*/
				jQuery(document).ready(function($){	
					$("#filterpelajaran select.selectfilter").change(function(e){
						var thisobj=$(this);
						$.ajax({
							type: "POST",
							data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&'+$("form#filterpelajaran").serialize(),
							url: $("form#filterpelajaran").attr('action'),
							beforeSend: function() {
								$(thisobj).after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
							},
							success: function(msg) {
								$("#wait").remove();
								$("#listpelajaran").html(msg);	
							}
						});
						return false;
					});//Submit End
										//Submit Start
					$("#addkkm").click(function(e){
						var thisobj=$(this);
						$.ajax({
							type: "POST",
							data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&'+$("form#filterpelajaranadd").serialize(),
							url: $("form#filterpelajaranadd").attr('action'),
							beforeSend: function() {
								$(thisobj).after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
							},
							success: function(msg) {
								$("#wait").remove();
								$("#listpelajaran").html(msg);	
							}
						});
						return false;
					});
					function loaddatapelajaran(){
						$.ajax({
							type: "POST",
							data: "<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&ajax=1",
							url: base_url+'admin/nilaikkm/listData',
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
			
			<h1 class="with-subtitle"> Data Nilai KKM </h1>
				<h6 class="subtitle"> PENENTUAN NILAI KETENTUAN KRITERIA MINIMAL (KKM) </h6>
                <div class="styled-elements">
					<div id="ajaxside"></div>
					<form action="<?=base_url()?>admin/nilaikkm/listData" method="post" id="filterpelajaran" >
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
							<table class="tabelfilter">
								<tr>
									<td>
										<select class="selectfilter" name="jenjang">
											<option value="">Pilih Jenjang</option>
											<? foreach($grade as $jenjang){?>
											<option <? if(@$_POST['jenjang']==$jenjang){echo 'selected';}?> value="<?=$jenjang?>"><?=$jenjang?></option>
											<? } ?>
										</select>
									
										<select class="selectfilter" name="id_jurusan">
											<option value="">Pilih Jurusan</option>
										<? foreach($jurusan as $jurusandata){ ?>
											<option <? if(@$_POST['id_jurusan']==$jurusandata['id']){echo 'selected';}?> value="<?=$jurusandata['id']?>"><?=$jurusandata['nama']?></option>
										<? } ?>
										</select>
									
										<select class="selectfilter" name="semester">
											<option value="">Pilih Semester</option>
												<? foreach($semester as $datasemester){?>
													<option <? if(@$_POST['semester']==$datasemester['id']){echo 'selected';}?> value="<?=$datasemester['id']?>"><?=$datasemester['nama']?></option>
												<? } ?>
										</select>
										<a id="addkkm"  title="simpankkm" class="readmore simpanright readmoreasb"> <span> Simpan </span></a>
									</td>
								</tr>
							</table>
							<input type="hidden" name="ajax" value="1" />
							</form>
					<div id="listpelajaran"></div>
                    <div class="hr"> </div>
                    <div class="clear"> </div>
                </div> <!-- **Styled Elements - End** -->  