														<? //pr($content);?>
														<input type="hidden"  value="save" name="save">
														<table class="tableprofil penghubungortutk" border="1">
															  <tbody>
															  <tr>
																<th style="width:1%;" >No</th>
																<th colspan="2">PROGRAM PENGEMBANGAN</th>
																<th colspan="4">Aspek Penilaian </th>
																</tr>

															  <? if(!empty($content[0]['contarr'])){foreach($content[0]['contarr'] as $baris => $data){?>
															  
															  <tr class="sub_1 " baris="<?=$baris?>">
																  <td colspan="3" style="text-align:left; "><?//=$baris?><input type="hidden"  value="<?=$data['nama']?>" name="program[<?=$baris?>][nama]"><?=$data['nama']?></td>
																  <td class="aspekpenilai"><input type="hidden" name="program[<?=$baris?>][aspek][]" value="<?=$data['aspek'][0]?>"><?=$data['aspek'][0]?></td>
																  <td class="aspekpenilai"><input type="hidden" name="program[<?=$baris?>][aspek][]" value="<?=$data['aspek'][1]?>"><?=$data['aspek'][1]?></td>
																  <td class="aspekpenilai"><input type="hidden" name="program[<?=$baris?>][aspek][]" value="<?=$data['aspek'][2]?>"><?=$data['aspek'][2]?></td>
																  <td class="aspekpenilai"><input type="hidden" name="program[<?=$baris?>][aspek][]" value="<?=$data['aspek'][3]?>"><?=$data['aspek'][3]?></td>
																  </td>
															  </tr>
																	<? if(!empty($data['child'])){foreach($data['child'] as $baris_2 => $data_2){
																		$sub2=explode("_",$baris_2);
																		$nilai_2=$contentsiswa[0]['contarr'][$baris]['child'][$baris_2]['nilai'];
																	?>
																	  <tr class="sub_2 ncls aspek ncsub2 par_<?=$sub2[0]?> par0_<?=$sub2[0]?>" sub_baris="<?=$sub2[0]?>" baris="<?=$sub2[1]?>">
																		  <td><?//=$nilai_2?></td>
																		  <td style="width: 1%; border-right: medium none; "><?//=$sub2[1]?><?//=$sub2[1]?></td>
																		  <td ><input type="hidden"  value="<?=$data_2['nama']?>" name="program[<?=$sub2[0]?>][child][<?=$sub2[0]?>_<?=$sub2[1]?>][nama]"><?=$data_2['nama']?></td>
																		  <td class="nilai"><input type="hidden" name="program[<?=$sub2[0]?>][child][<?=$sub2[0]?>_<?=$sub2[1]?>][nilai]" value="<?=$data_2['aspek'][0]?>" /><?=$data_2['aspek'][0]?></td>
																		  <td class="nilai"><input type="hidden" name="program[<?=$sub2[0]?>][child][<?=$sub2[0]?>_<?=$sub2[1]?>][nilai]" value="<?=$data_2['aspek'][1]?>" ><?=$data_2['aspek'][1]?></td>
																		  <td class="nilai"><input type="hidden" name="program[<?=$sub2[0]?>][child][<?=$sub2[0]?>_<?=$sub2[1]?>][nilai]" value="<?=$data_2['aspek'][2]?>"  ><?=$data_2['aspek'][2]?></td>
																		  <td class="nilai"><input type="hidden" name="program[<?=$sub2[0]?>][child][<?=$sub2[0]?>_<?=$sub2[1]?>][nilai]" value="<?=$data_2['aspek'][3]?>" ><?=$data_2['aspek'][3]?></td>
																	  </tr>
																			<? if(!empty($data_2['child'])){foreach($data_2['child'] as $baris_3 => $data_3){
																				$sub3=explode("_",$baris_3);
																				$nilai_3=$contentsiswa[0]['contarr'][$baris]['child'][$baris_2]['child'][$baris_3]['nilai'];
																			?> 
																				<tr class="sub_3 ncsub3 par_<?=$sub3[0]?> par_<?=$sub3[0]?>_<?=$sub3[1]?> ncls" sub_baris="<?=$sub3[0]?>" baris="<?=$sub3[1]?>" baris_sub="<?=$sub3[2]?>">
																						<td><?//=$nilai_3?></td>
																						<td style="width: 1%; border-right: medium none; padding: 2px ! important;"></td>
																						<td style="padding-left: 20px;" ><?//=$sub3[1]?><?//=$sub3[2]?> &nbsp;&nbsp;<input type="hidden" style="margin-left: 20px; width: 91%;" name3="" value="<?=$data_3['nama']?>" name="program[<?=$sub3[0]?>][child][<?=$sub3[0]?>_<?=$sub3[1]?>][child][<?=$sub3[0]?>_<?=$sub3[1]?>_<?=$sub3[2]?>][nama]"><?=$data_3['nama']?></td>
																					  <td class="nilai"><input type="radio" name="program[<?=$sub3[0]?>][child][<?=$sub3[0]?>_<?=$sub3[1]?>][child][<?=$sub3[0]?>_<?=$sub3[1]?>_<?=$sub3[2]?>][nilai]" value="<?=$data_2['aspek'][0]?>"  <? if($nilai_3==$data_2['aspek'][0]){echo 'checked';}?>></td>
																					  <td class="nilai"><input type="radio" name="program[<?=$sub3[0]?>][child][<?=$sub3[0]?>_<?=$sub3[1]?>][child][<?=$sub3[0]?>_<?=$sub3[1]?>_<?=$sub3[2]?>][nilai]" value="<?=$data_2['aspek'][1]?>" <? if($nilai_3==$data_2['aspek'][1]){echo 'checked';}?>></td>
																					  <td class="nilai"><input type="radio" name="program[<?=$sub3[0]?>][child][<?=$sub3[0]?>_<?=$sub3[1]?>][child][<?=$sub3[0]?>_<?=$sub3[1]?>_<?=$sub3[2]?>][nilai]" value="<?=$data_2['aspek'][2]?>" <? if($nilai_3==$data_2['aspek'][2]){echo 'checked';}?>></td>
																					  <td class="nilai"><input type="radio" name="program[<?=$sub3[0]?>][child][<?=$sub3[0]?>_<?=$sub3[1]?>][child][<?=$sub3[0]?>_<?=$sub3[1]?>_<?=$sub3[2]?>][nilai]" value="<?=$data_2['aspek'][3]?>" <? if($nilai_3==$data_2['aspek'][3]){echo 'checked';}?>></td>
																				</tr>	
																						<? if(!empty($data_3['child'])){foreach($data_3['child'] as $baris_4 => $data_4){
																							$sub4=explode("_",$baris_4);
																							$nilai_4=$contentsiswa[0]['contarr'][$baris]['child'][$baris_2]['child'][$baris_3]['child'][$baris_4]['nilai'];
																						?> 
																							<tr class="sub_4 ncsub4 par_<?=$sub4[0]?> parsub2_<?=$sub4[0]?>_<?=$sub4[1]?> par_<?=$sub4[0]?>_<?=$sub4[1]?> par_<?=$sub4[0]?>_<?=$sub4[1]?>_<?=$sub4[2]?> ncls" sub_baris="<?=$sub4[0]?>" baris="<?=$sub4[1]?>" baris_sub="<?=$sub4[2]?>">
																								<td><?//=$nilai_4?></td>
																								<td style="width: 1%; border-right: medium none; padding: 2px ! important;"></td>
																								<td  style="padding-left: 40px;"><input type="hidden" name3="" value="<?=$data_4['nama']?>" name="program[<?=$sub4[0]?>][child][<?=$sub4[0]?>_<?=$sub4[1]?>][child][<?=$sub4[0]?>_<?=$sub4[1]?>_<?=$sub4[2]?>][child][<?=$sub4[0]?>_<?=$sub4[1]?>_<?=$sub4[2]?>_<?=$sub4[3]?>][nama]"><?=$data_4['nama']?></td>
																							    <td class="nilai"><input type="radio" name="program[<?=$sub4[0]?>][child][<?=$sub4[0]?>_<?=$sub4[1]?>][child][<?=$sub4[0]?>_<?=$sub4[1]?>_<?=$sub4[2]?>][child][<?=$sub4[0]?>_<?=$sub4[1]?>_<?=$sub4[2]?>_<?=$sub4[3]?>][nilai]" value="<?=$data_2['aspek'][0]?>"  <? if($nilai_4==$data_2['aspek'][0]){echo 'checked';}?>></td>
																							    <td class="nilai"><input type="radio" name="program[<?=$sub4[0]?>][child][<?=$sub4[0]?>_<?=$sub4[1]?>][child][<?=$sub4[0]?>_<?=$sub4[1]?>_<?=$sub4[2]?>][child][<?=$sub4[0]?>_<?=$sub4[1]?>_<?=$sub4[2]?>_<?=$sub4[3]?>][nilai]" value="<?=$data_2['aspek'][1]?>" <? if($nilai_4==$data_2['aspek'][1]){echo 'checked';}?>></td>
																							    <td class="nilai"><input type="radio" name="program[<?=$sub4[0]?>][child][<?=$sub4[0]?>_<?=$sub4[1]?>][child][<?=$sub4[0]?>_<?=$sub4[1]?>_<?=$sub4[2]?>][child][<?=$sub4[0]?>_<?=$sub4[1]?>_<?=$sub4[2]?>_<?=$sub4[3]?>][nilai]" value="<?=$data_2['aspek'][2]?>" <? if($nilai_4==$data_2['aspek'][2]){echo 'checked';}?>></td>
																							    <td class="nilai"><input type="radio" name="program[<?=$sub4[0]?>][child][<?=$sub4[0]?>_<?=$sub4[1]?>][child][<?=$sub4[0]?>_<?=$sub4[1]?>_<?=$sub4[2]?>][child][<?=$sub4[0]?>_<?=$sub4[1]?>_<?=$sub4[2]?>_<?=$sub4[3]?>][nilai]" value="<?=$data_2['aspek'][3]?>" <? if($nilai_4==$data_2['aspek'][3]){echo 'checked';}?>></td>
																							</tr>
																							
																						<? }  } ?> 																				
																			<? }  } ?> 
																	<? } } ?> 
															  <? } }?> 
															  </tbody>
														</table>
														<?if(isset($contentsiswa[0]['id'])){?>
														<script>
														$(document).ready(function(){
															$.ajax({
																type: "GET",
																data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&',
																url: '<?=base_url()?>akademik/comment/index/<?=$contentsiswa[0]['id']?>/first/penghubung_tk',
																beforeSend: function() {
																	//$("#filterpelajaranpr select#kelas").after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
																	
																},
																success: function(msg) {
																	//$("#wait").remove();
																	$('#komentarpenghperkemb<?=$contentsiswa[0]['id']?>').html(msg);	
																}
															});
														});
														</script>
														
														<div id="komentarpenghperkemb<?=$contentsiswa[0]['id']?>"></div>
														<? } ?>