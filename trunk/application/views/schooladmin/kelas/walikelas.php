					<script>
					jQuery(document).ready(function($){	
						$('select.wali').change(function(){
							var obj=$(this);
							$.ajax({
							type: "POST",
							data: "ajax=1&id_pegawai="+$(obj).val(),
							url: '<?php echo base_url(); ?>admin/kelas/setwali',
							beforeSend: function() {
								$(obj).after("<img class='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
							},
							success: function(msg) {
								$('.wait').remove();
								//$("").html(msg);	
							}
							});
						});
					});	
						
					</script>
					<h1 class="with-subtitle"> Wali Kelas </h1>
					<h6 class="subtitle"> Pengaturan Wali Kelas </h6>
					<div class="styled-elements">
							<table class="tabelkelas">
								<thead>
									<tr> 
										<th style="width:20px;">No</th>
										<th>Kelas</th>
										<th>Wali</th>
									</tr>                            
								</thead>
								<tbody>
								<? $no=1; foreach($kelas as $datawalikelas){?>
									<tr>
										<td><?=$no++?></td>
										<td><?=$datawalikelas['kelas']?><?=$datawalikelas['nama']?></td>
										<td>
											<select name="id_pegawai"  class="wali" style="margin:0;" >
												<option value="0">Pilih Wali Kelas</option>
												<? foreach($wali as $datawali){
												   $val=json_encode(array('id_pegawai'=>$datawali['id'],'id_kelas'=>$datawalikelas['id']));
												?>
												<option value='<?=$val?>'  <? if($datawali['id']==$datawalikelas['id_pegawai']){ echo 'selected';}?>><?=$datawali['nama']?></option>
												<? } ?>
											</select>
										</td>
									</tr>
									<? } ?>
								</tbody>
							</table>
                    </div>
                    <div class="hr"> </div>
                    <div class="clear"> </div> 
                    
                </div> <!-- **Styled Elements - End** -->
							