								<script>
									$(document).ready(function(){
										//Submit Start
										$("span.up").click(function(e){
											var poin=$(this).prev().val();
											poin=parseInt(poin)+1;
											//if(poin<101){
												$(this).prev().val(poin);
											//}
											
										});
										$("span.down").click(function(e){//alert();
											var poin=$($(this).prev()).prev().val();
											poin=poin-1;
											if(poin>=0){
												$($(this).prev()).prev().val(poin);
											}
										});
										$("#kepribadiandataform").submit(function(e){
											$.ajax({
												type: "POST",
												data: $(this).serialize()+'&simpan=true'+'&'+$('form#kepribadianform').serialize(),
												url: $(this).attr('action'),
												beforeSend: function() {
													$("#simpancatatan").after("<img id='wait' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
												},
												success: function(msg) {
													$("#wait").remove();
												}
											});
											return false;
										});
									});
									function hapusdata(thisobj,id){
										if(confirm('Data akan dihapus. klik "OK" untuk menghapus. Klik "Cancel" untuk batal. ')){
											$.ajax({
													type: "POST",
													data: '',
													url: base_url+'akademik/catatanguru/delete/'+id,
													beforeSend: function() {
														$(thisobj).after("<img id='wait' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
													},
													success: function(msg) {
														$("#wait").remove();	
														$(thisobj).parent('td').parent('tr').remove();
													}
											});
											return false;
										}
									}
								</script>
								<form action="<?=base_url()?>akademik/kepribadian/kepribadianlist" method="post" id="kepribadiandataform" >
								
								<table id="data">
										<thead>
											<tr>
												<th colspan="6" style="text-align:right;">
													<a title="" class="button small light-grey absenbutton" id="simpancatatan" onclick="$('#kepribadiandataform').submit();"> Simpan </a>
												</th>
											</tr>
											<tr>     
												<th>Aspek</th>
												<th>Apresiasi</th>
												<th>Pelanggaran</th>
												<!--<th style="width:70px;">Poin</th>-->
												<th>Keterangan</th>
												<th class="action">Action</th>
											</tr>                         
										</thead>
										<tbody>
											<? 
												$no=1;
												if(!empty($kepribadian)){
												foreach($kepribadian as $kt=>$datakepribadian){
											?>
											<tr>
												<td >
													<? foreach($aspek as $dataaspek){?>
														<? if($dataaspek['id']==$datakepribadian['id_aspek_kepribadian']){echo $dataaspek['nama'];}?>
													<? } ?>
												</td>
												<td class="title" ><?=$datakepribadian['apresiasi']?></td>
												<td class="title" >
													<?=$datakepribadian['pelanggaran']?>
													<input type="hidden" name="data[id][]" value="<?=@$datakepribadian['id']?>">
												</td>
												<!--<td >
													<div style="position:relative;">
													<input type="text" id="poin" style="border-radius:0;" name="data[poin][]" value="<?=@$datakepribadian['poin']?>">
													<span class="arrow-n up" ></span>
													<span class="arrow-s down" ></span>
													</div>
												</td>-->
												<td ><textarea name="data[keterangan][]" class="kepribadianket" cols="30" style="height:30px;"><?=@$datakepribadian['keterangan']?></textarea></td>
												<td  class="action"><a class="button small light-grey" title="Hapus baris ini" onclick="hapusdata(this,<?=@$datakepribadian['id']?>);" > <span> Hapus </span> </a></td>
											</tr>
											<? }  } ?>
										</tbody>
								</table>
								
								<table id="point">
										<thead>
											<tr>     
												<th width="2">No</th>
												<th >Aspek</th>
												<th style="width:70px;">Point</th>
											</tr>                         
										</thead>
										<tbody>
										<? foreach($aspek as $dataaspek){ $iaspek++;?>
											<tr>
												<td><?=$iaspek?></td>
												<td class="title"><?=$dataaspek['nama']?></td>
												<td>
													<div style="position:relative;">
														<?
														if(isset($nilai[$dataaspek['id']])){$id_nilai=$nilai[$dataaspek['id']]['id'];}else{$id_nilai='null';}
														if(isset($nilai[$dataaspek['id']]['point'])){$nl=$nilai[$dataaspek['id']]['point'];}else{$nl=100;}
														?>
														<input class="poin" type="text" id="poin" style="border-radius:0;" name="data[poin][<?=$dataaspek['id']?>][<?=$id_nilai?>]" value="<?=$nl?>">
														<span class="arrow-n up" ></span>
														<span class="arrow-s down" ></span>
													</div>
												</td>
											</tr>
										<? } ?>
										</tbody>
								</table>
								</form>