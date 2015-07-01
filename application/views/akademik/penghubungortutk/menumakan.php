														<? //pr($contentmenusiswa);?>
														<input type="hidden"  value="save" name="save">
														<table class="tableprofil penghubungortutk" border="1">
															  <tbody>
															  <tr>
																<th style="width:1%;" >No</th>
																<th colspan="2">PROGRAM PENGEMBANGAN</th>
																<th >Ceklist</th>
																</tr>

															  <? if(!empty($contentmenu[0]['contmenuarr'])){foreach($contentmenu[0]['contmenuarr'] as $baris => $data){?>
															  
															  <tr class="sub_1 " baris="<?=$baris?>">
																  <td style="text-align:center; "><?=$baris?></td>
																  <td style="width: 1%;text-align:left; " colspan="2"><input type="hidden"  value="<?=$data['nama']?>" name="programmenu[<?=$baris?>][nama]"><?=$data['nama']?></td>
																  <td class="aspekpenilai"></td>
															  </tr>
																	<? if(!empty($data['child'])){foreach($data['child'] as $baris_2 => $data_2){
																		$sub2=explode("_",$baris_2);
																		$nilai_2=$contentmenusiswa[0]['conmenutarr'][$baris]['child'][$baris_2]['nilai'];
																	?>
																	  <tr class="sub_2 ncls ncsub2 par_<?=$sub2[0]?> par0_<?=$sub2[0]?>" sub_baris="<?=$sub2[0]?>" baris="<?=$sub2[1]?>">
																		  <td><?//=$nilai_2?></td>
																		  <td style="width: 1%; border-right: medium none; "><?=$sub2[0]?>.<?=$sub2[1]?></td>
																		  <td ><input type="hidden"  value="<?=$data_2['nama']?>" name="programmenu[<?=$sub2[0]?>][child][<?=$sub2[0]?>_<?=$sub2[1]?>][nama]"><?=$data_2['nama']?></td>
																		  <td class="nilai">
																		  <input type="hidden" name="programmenu[<?=$sub2[0]?>][child][<?=$sub2[0]?>_<?=$sub2[1]?>][nilai]" value="0">
																		  <input type="checkbox" name="programmenu[<?=$sub2[0]?>][child][<?=$sub2[0]?>_<?=$sub2[1]?>][nilai]" value="1" <? if($nilai_2==1 && $nilai_2!=''){echo 'checked';}?>></td>
																	  </tr>
																	<? } } ?> 
															  <? } }?> 
															  </tbody>
														</table>
														<?if(isset($contentmenusiswa[0]['id'])){?>
														<script>
														$(document).ready(function(){
															$.ajax({
																type: "GET",
																data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&',
																url: '<?=base_url()?>akademik/comment/index/<?=$contentmenusiswa[0]['id']?>/first/penghubung_tk',
																beforeSend: function() {
																	//$("#filterpelajaranpr select#kelas").after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
																	
																},
																success: function(msg) {
																	//$("#wait").remove();
																	$('#komentarmenumakan<?=$contentmenusiswa[0]['id']?>').html(msg);	
																}
															});
														});
														</script>
														
														<div id="komentarmenumakan<?=$contentmenusiswa[0]['id']?>"></div>
														<? } ?>