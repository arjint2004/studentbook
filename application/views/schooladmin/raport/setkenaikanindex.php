			<script>
				/*js for tahunAjaran start*/
			jQuery(document).ready(function($){	
				$('#kelaskenaikanadmin').bind('change', function() {
					var obj=$(this);
					$.ajax({
						type: "POST",
						data: 'id_kelas='+$(obj).val(),
						url: '<?=base_url('admin/raport/setkenaikan')?>/'+$(obj).val(),
						beforeSend: function() {
							$('#kelaskenaikanadmin').after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
						},
						success: function(msg) {
							$("#wait").remove();			
							$("#listkenaikankelas").html(msg);			
						}
					});
				});
			});
			</script>
			<h1 class="with-subtitle"> Kenaikan Kelas </h1>
				<h6 class="subtitle"> Pengaturan kenaikan kelas </h6>
                <div class="styled-elements">
					<!--<a id="addguru" onclick="$('#ajaxside').load('<?=base_url()?>admin/tahunAjaran/adddata')" title="guru" class="readmore readmoreasb"> <span> Tambah tahunAjaran </span></a>-->
					<div id="ajaxside"></div>
					<div id="listtahunAjaran">
						<div id="contentpage">				
							<table class="tabelfilter">
								<tbody>
									<tr>
										<td>
											Kelas :
											<select class="selectfilter" id="kelaskenaikanadmin" name="id_kelaskenaikanadmin">
												<option value="">Pilih Kelas</option>
												<? foreach($kelas as $datakelas){?>
													<option <? if(@$_POST['kelas']==$datakelas['id']){echo 'selected';}?> value="<?=$datakelas['id']?>"><?//=$datakelas['kelas']?><?=$datakelas['nama']?></option>
												<? } ?>
											</select>					
										</td>
									</tr>
								</tbody>
							</table>
							</form>
						</div>
					</div>
					<div id="listkenaikankelas"></div>
                </div> <!-- **Styled Elements - End** -->  