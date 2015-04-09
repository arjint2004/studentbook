			<script>
				/*js for tahunAjaran start*/
				jQuery(document).ready(function($){	
					
					$('#select_all').change(function() {
						var obj=$(this);
						var checkboxes = $(this).closest('form').find(':checkbox');
						if($(this).is(':checked')) {
							checkboxes.attr('checked', 'checked');
						} else {
							checkboxes.removeAttr('checked');
						}
						sendcek(obj);
					});
					
					function sendcek(obj){
						$.ajax({
							type: "POST",
							data: $('form#settingraport').serialize()+"&ajax=1&show_all=1",
							url: $('form#settingraport').attr('action'),
							beforeSend: function() {
								$(obj).hide();
								$(obj).after("<img id='wait'  src='"+config_images+"loading.png' />");
							},
							success: function(msg) {
								$("#wait").remove();
								$(obj).show();
								$(".main-content").html(msg);	
								if($('#select_all').val()==1){
									$('#select_all').prop('checked', false);
								}else{
									$('#select_all').prop('checked', true);
								}
							}
						});					
					}
					
					$('form#settingraport table tr td input[type="checkbox"]').change(function() {
						var obj=$(this);
						$.ajax({
							type: "POST",
							data: "&ajax=1&val="+$(obj).val()+'&name='+$(obj).attr('name'),
							url: $('form#settingraport').attr('action'),
							beforeSend: function() {
								$(obj).hide();
								$(obj).after("<img id='wait'  src='"+config_images+"loading.png' />");
							},
							success: function(msg) {
								$("#wait").remove();
								$(obj).show();
								$(".main-content").html(msg);			
							}
						});
					});
					
				});
				

			</script>
			<style>
				table tr td.bordersetraport{
					border-bottom:1px solid #D7D7D7;
				}
			</style>
			
			<h1 class="with-subtitle"> Setting Raport </h1>
				<h6 class="subtitle"> Pengaturan untuk merubah format raport </h6>
                <div class="styled-elements">
					<!--<a id="addguru" onclick="$('#ajaxside').load('<?=base_url()?>admin/tahunAjaran/adddata')" title="guru" class="readmore readmoreasb"> <span> Tambah tahunAjaran </span></a>-->
					<div id="ajaxside"></div>
					<div id="listtahunAjaran">
						<div id="contentpage">
							<br />
							<br />
							<form action="<?=base_url('admin/raport/setting');?>" name="settingraport" id="settingraport" method="post">
							<h3>RUMUS NILAI RAPORT</h3>
							<table class="tabelkelas">
								<tbody>
								  <tr>
									  <td><input style="width:90%" type="text" name="rumus_raport" value="<?=$rumus_raport['rumus_raport']?>"></td>
								  </tr>
								  <tr>
									  <td colspan="3"><input type="submit" name="simpanrumus" value="Simpan"></td>
								  </tr>
									
								</tbody>
							</table>
							</form>
							<br />
							<br />
							<form action="<?=base_url('admin/raport/tanggal');?>" name="settingraport" id="settingraport" method="post">
							<h3>Tanggal Penerimaan Raport</h3>
							<? //pr($setting_tanggal);?>
							<table class="tabelkelas">
								<tbody>
								  <tr>
								    <th>Semester</th>
								    <th>Penanggalan Nasional</th>
								    <th>Penanggalan Islam </th>
							      </tr>
								  <tr>
								    <td>Semester 1</td>
								    <td><input style="width:150px" type="text" id="datepickraport" name="tanggal_raport[<?=$this->session->userdata['ak_setting']['ta']?>][sm1][nasional]" value="<?=$setting_tanggal[0][$this->session->userdata['ak_setting']['ta']]['sm1']['nasional']?>"></td>
								    <td><input style="width:150px" type="text" id="datepickraport" name="tanggal_raport[<?=$this->session->userdata['ak_setting']['ta']?>][sm1][islam]" value="<?=$setting_tanggal[0][$this->session->userdata['ak_setting']['ta']]['sm1']['islam']?>"></td>
							      </tr>
								  <tr>
								    <td>Semester 2</td>
									  <td><input style="width:150px" type="text" id="datepickraport" name="tanggal_raport[<?=$this->session->userdata['ak_setting']['ta']?>][sm2][nasional]" value="<?=$setting_tanggal[0][$this->session->userdata['ak_setting']['ta']]['sm2']['nasional']?>"></td>
									  <td><input style="width:150px" type="text" id="datepickraport" name="tanggal_raport[<?=$this->session->userdata['ak_setting']['ta']?>][sm2][islam]" value="<?=$setting_tanggal[0][$this->session->userdata['ak_setting']['ta']]['sm2']['islam']?>"></td>
								  </tr>
								  <tr>
									  <td colspan="5"><input type="submit" name="simpantglraport" value="Simpan"></td>
								  </tr>
									
								</tbody>
							</table>
							</form>
							<br />
							<br />
							<form action="<?=base_url('admin/raport/setting');?>" name="settingraport" id="settingraport" method="post">
							
							<h3>Penampilan Elemen raport</h3>
							<table class="tabelkelas">
								<thead>
									<tr> 
										<th colspan="2">Element</th>
									    <th><input type="checkbox" id="select_all" name="select_all" value="<? if(isset($_POST['select_all'])){ echo 0;}else{echo 1;}?>"></th>
									</tr>                            
								</thead>
								<tbody>
								  <tr>
									  <td rowspan="5" class="bordersetraport"><strong>Nilai Akademik </strong></td>
									  <td class="title">KKM</td>
									  <td><input type="checkbox" name="akademik_kkm" <? if($setting['akademik_kkm']==1){echo 'checked';}?> value="<?=$setting['akademik_kkm']?>"></td>
								  </tr>
									<tr>
									  <td class="title">Pengetahuan</td>
									  <td><input type="checkbox" name="akademik_pengetahuan" <? if($setting['akademik_pengetahuan']==1){echo 'checked';}?> value="<?=$setting['akademik_pengetahuan']?>"></td>
								  </tr>
									<tr>
									  <td class="title">Praktik</td>
									  <td><input type="checkbox" name="akademik_praktik" <? if($setting['akademik_praktik']==1){echo 'checked';}?> value="<?=$setting['akademik_praktik']?>"></td>
								  </tr>
									<tr>
									  <td class="title">Afektif</td>
									  <td><input type="checkbox" name="akademik_afektif" <? if($setting['akademik_afektif']==1){echo 'checked';}?>  value="<?=$setting['akademik_afektif']?>"></td>
								  </tr>
									<tr>
									  <td class="title bordersetraport" >Ketercapaian Kompetensi</td>
									  <td class="bordersetraport"><input type="checkbox" name="akademik_ketercapaian" <? if($setting['akademik_ketercapaian']==1){echo 'checked';}?> value="<?=$setting['akademik_ketercapaian']?>"></td>
								  </tr>
									<tr>
									  <td rowspan="2" class="bordersetraport"><strong>Kepribadian</strong></td>
									  <td class="title">Poin</td>
									  <td><input type="checkbox" name="kepribadian_poin" <? if($setting['kepribadian_poin']==1){echo 'checked';}?> value="<?=$setting['kepribadian_poin']?>"></td>
								  </tr>
									<tr>
									  <td class="title bordersetraport">Keterangan</td>
									  <td class="bordersetraport"><input type="checkbox"  name="kepribadian_keterangan" <? if($setting['kepribadian_keterangan']==1){echo 'checked';}?> value="<?=$setting['kepribadian_keterangan']?>"></td>
								  </tr>
									<tr>
									  <td class="bordersetraport" rowspan="2"><strong>Ekstrakurikuler</strong></td>
									  <td class="title">Nilai</td>
									  <td><input type="checkbox" <? if($setting['ekstrakurikuler_nilai']==1){echo 'checked';}?> name="ekstrakurikuler_nilai" value="<?=$setting['ekstrakurikuler_nilai']?>"></td>
								  </tr>
									<tr>
									  <td class="title bordersetraport">Keterangan</td>
									  <td class="bordersetraport"><input type="checkbox" name="ekstrakurikuler_keterangan" <? if($setting['ekstrakurikuler_keterangan']==1){echo 'checked';}?>  value="<?=$setting['ekstrakurikuler_keterangan']?>"></td>
								  </tr>
								</tbody>
							</table>
							</form>



						</div>
					</div>
                    <div class="hr"> </div>
                    <div class="clear"> </div>
                </div> <!-- **Styled Elements - End** -->  