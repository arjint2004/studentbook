								<script>
									$(document).ready(function(){
										//Submit Start

										
										$("table tr td a.readmore").click(function(){
											var tr='<tr>'+$("table tr#master").html()+'</tr>';
											$("table tr#beforeadd").before(tr);
											return false;
										});
										$("select#id_indikator").change(function(){
											$.ajax({
												type: "POST",
												data: 'id_indikator='+$(this).val(),
												url: '<?=base_url("akademik/instrumen/penilaian/".$param['indikatore']."/".$param['id_pembelajarane']."/".$param['id_pelajarane']."/".$param['id_kelase']."/".$param['nama_kelase']."/".$subject."")?>',
												beforeSend: function() {
													$("#simpanpr").after("<img id='wait' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
												},
												success: function(msg) {
													$("#wait").remove();
													$('#fancybox-content div').html(msg);
												}
											});
										});
										
										$("#catatangurudataform").submit(function(e){
											if($('select#selrppiddetjenjangsiswa').val()==0){
												$('select#selrppiddetjenjangsiswa').css('border','1px solid red');
												return false;
											}else{
												$('select#selrppiddetjenjangsiswa').css('border','1px solid #D8D8D8');
											}
											$.ajax({
												type: "POST",
												data: $(this).serialize()+'&simpan=true',
												url: $(this).attr('action'),
												beforeSend: function() {
													$("#simpancatatan").after("<img id='wait' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
												},
												success: function(msg) {
													$("#wait").remove();	
													$.ajax({
															type: "POST",
															data: 'ajax=1&id_pembelajaran=<?=$id_pembelajaran?>&id_pelajaran=<?=$_POST['id_pelajaran']?>',
															url: '<?=base_url('akademik/instrumen/sukses/PENILAIAN')?>',
															beforeSend: function() {
																$("#simpanpr").after("<img id='wait' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
															},
															success: function(msg) {
																$("#wait").remove();
																$('#fancybox-content div').html(msg);
															}
														});
												}
											});
											return false;
										});
									});

									function up(thisobj){
										var poin=$(thisobj).prev().val();
										poin=parseInt(poin)+1;
										if(poin<6){
											$(thisobj).prev().val(poin);
										}
									}
									function down(thisobj){
										var poin=$($(thisobj).prev()).prev().val();
										poin=poin-1;
										if(poin>=1){
											$($(thisobj).prev()).prev().val(poin);
										}
									}
									
									
								</script>


								<?// pr($siswa);?>
								<form action="<?=base_url()?>akademik/instrumen/penilaian/<?=$indikatore?>" method="post" id="catatangurudataform" style="width:768px;height:100%;">
								<table>
									<tbody>
										<tr>
											<td>
												<b>PENILAIAN DAN PENGAMATAN PEMBELAJARAN "<?=$subjectnoen?>"</b>
											</td>
										</tr>
									</tbody>
								</table>
								<table id="data" class="adddata">
										<thead>
											<tr>
												<th  colspan="4" style="padding: 0px; text-align: center; background: none repeat scroll 0% 0% transparent;">
													<input type="hidden" name="subject" value="<?=$subject?>" />
													<input type="hidden" name="id_kelas" value="<?=$id_kelas?>" />
													<input type="hidden" name="id_pelajaran" value="<?=$id_pelajaran?>" />
													<select name="id_indikator" id="id_indikator" >
														<option value="0" >Pilih Indikator</option>
														<? foreach($indikator as $dataindikator){?>
														<option <? if($_POST['id_indikator']==$dataindikator['id']){echo 'selected';}?> value="<?=$dataindikator['id']?>" ><?=$dataindikator['indikator']?></option>
														<? } ?>
													</select>
												</th>
											</tr>
											<tr >
												<td align="right" colspan="3">
												<a title="" style="float:right;" class="readmorenoplus2" id="simpancatatan" onclick="$('#catatangurudataform').submit();"> Simpan </a>
												</td>
											</tr>
											<tr>     
												<th>Aspek yang diamati</th>
												<th style="width:70px;">Nilai</th>
											</tr>                         
										</thead>
										<tbody>
										<? foreach($siswa as $datasiswa){?>
											<tr >
												<td class="left"><?=$datasiswa['nama']?></td>
												<td >
													
															<div style="position:relative;">
																<input class="poin" type="text" id="poin" style="border-radius:0;" name="poin[<?=$datasiswa['id_siswa_det_jenjang']?>]" value="<? if(isset($point[$datasiswa['id_siswa_det_jenjang']]['point'])){echo $point[$datasiswa['id_siswa_det_jenjang']]['point'];}else{echo 1;}?>">
																<span class="arrow-n2 up" onclick="up(this)"></span>
																<span class="arrow-s2 down" onclick="down(this)"></span>
															</div>
												</td>
												
											</tr>
											<? } ?>
											<tr id="beforeadd">
												<td align="right" colspan="3">
												<a title="" style="float:right;" class="readmorenoplus2" id="simpancatatan" onclick="$('#catatangurudataform').submit();"> Simpan </a>

												</td>
											</tr>
										</tbody>
								</table>
								</form>