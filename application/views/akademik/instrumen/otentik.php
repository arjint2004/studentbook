								<script>
									$(document).ready(function(){
										//Submit Start
										<? if(empty($otentik)){?>
										var tr='<tr  class="otentiktrx identy1" idnya="1">'+$("table tr#master").html()+'</tr>';
										$("table tr#beforeadd").before(tr);
										$("table tr.identy1 td.radio").html('1<input type="radio" name="point[1][1]" value="1" /><br />2<input type="radio" name="point[1][1]" value="2" /><br />3<input type="radio" name="point[1][1]" checked value="3" /><br />4<input type="radio" name="point[1][1]" value="4" /><br />5<input type="radio" name="point[1][1]" value="5" />');
										<? } ?>
										$("table tr td a.readmore").click(function(){
											var last_id=$("table#dataotentik tr.otentiktrx").last().attr('idnya');
											if(last_id==null){
											last_id=1;
											}
											var no;
											if(no==null){
											no=0;
											}
											var last_id=parseInt(last_id)+1;
											var tr='<tr class="otentiktrx identy'+last_id+'" idnya="'+last_id+'">'+$("table tr#master").html()+'</tr>';
											no=parseInt($("table#dataotentik tr.otentiktrx td.no").last().html())+1;
											$("table tr#beforeadd").before(tr);
											$("table tr.identy"+last_id+" td.no").html(no);
											$("table tr.identy"+last_id+" td.radio").html('1<input type="radio" name="point['+last_id+'][0]" value="1" /><br />2<input type="radio" name="point['+last_id+'][0]" value="2" /><br />3<input type="radio" name="point['+last_id+'][0]" checked value="3" /><br />4<input type="radio" name="point['+last_id+'][0]" value="4" /><br />5<input type="radio" name="point['+last_id+'][0]" value="5" />');
											return false;
										});
										
										$("#formindikator").submit(function(e){
											e.stopImmediatePropagation();
											
											var error=false;
											var error2=false;
											$("table tr td textarea.otentik").each(function(e){
												if($(this).val()==''){
													$(this).css('border','1px solid red');
													error=true;
												}else{
													$(this).css('border','1px solid #bdbdbd');
													error=false;
												}
											});
											$("table tr td select#otentiksiswa").each(function(e){
												if($(this).val()==0){
													$(this).css('border','1px solid red');
													error2=true;
													$('#formindikator').scrollintoview({ speed:'1100'});
												}else{
													$(this).css('border','1px solid #bdbdbd');
													error2=false;
												}
											});
											
											
											if(error==true){return false}
											if(error2==true){return false}
											$("#otentikindikatorload").append("<div class=\"error-box\" style='display: block; top: 50%; position: fixed; left: 46%;'></div>");
											$(".error-box").html("Memproses Data").fadeIn("slow");
											$.ajax({
												type: "POST",
												data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&'+$(this).serialize()+'&simpan=true&id_pembelajaran=<?=$id_pembelajaran?>',
												url: $(this).attr('action'),
												beforeSend: function() {
													$(".simpancatatan").after("<img class='wait' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
												},
												error	: function(){
													$(".error-box").delay(1000).html('Pemrosesan data gagal');
													$(".error-box").delay(1000).fadeOut("slow",function(){
														$(this).remove();
													});
													
												},
												success: function(msg) {
													$("img.wait").remove();	
														$(".error-box").delay(1000).html('Data berhasil di simpan');
														$(".error-box").delay(1000).fadeOut("slow",function(){
															$(this).remove();
														});
														$objrata=JSON.parse(msg);
														$ratascor=$objrata.ratascor+' / '+$objrata.jmlscor;
														$("table tr td#rataotentik").html($ratascor);
														$.ajax({
																	type: "POST",
																	data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&id_det_jenjang='+$('select#otentiksiswa').val()+'&nama_siswa='+$('select#otentiksiswa').find(":selected").text(),
																	url: '<?=site_url('akademik/instrumen/otentik/'.$param.'')?>',
																	beforeSend: function() {
																	$("select#otentiksiswa").after("<img id='wait' style='margin: 0px; float: right; position: relative; top: 24px;'  src='<?=$this->config->item('images').'loading.png';?>' />");
																	},
																	success: function(msg) {
																		$('img#wait').remove();
																		$('div#otentikindikatorload').html(msg);
																		//$('table tr td#rataotentik').html($('div#ratajml').html());
																	}
														});
														
												}
											});
											return false;
										});
									});
									
									function hapus(thisobj){
										$(thisobj).parent('td').parent('tr').remove();
										return false;
									}
									
									function hapusdata(thisobj,id){
										if(confirm('Data indikator otentik akan dihapus. klik "OK" untuk menghapus. Klik cancel untuk batal. ')){
											$.ajax({
													type: "POST",
													data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&',
													url: base_url+'akademik/instrumen/hapusindikator/'+id,
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
								<? //pr($otentik);?>
								<div style="display:none;" id="ratajml"><?//=$ratapoint.' / '.$jmlpoint?></div>
								<table style="display:none;">
									<tr id="master"  class="otentiktrx" >
										<td class="no">1</td>
										<td >
										<div style="color:#ababab; float:left;"><?=$_POST['nama_siswa']?></div>
										<textarea class="otentik" style="height:61px;" cols="30" name="otentik[]" ></textarea>
										</td>
										<td class="radio">
										
										</td>
										<td ><a class="button small light-grey" onclick="hapus(this);" title="Hapus baris ini"> <span> Hapus </span> </a></td>
									</tr>
								</table>
								
								<table id="dataotentik">
										<thead>
											<tr>
												<td align="right" colspan="5">
												<a title="" style="float:right;" class="readmorenoplus2 simpancatatan"  onclick="$('#formindikator').submit();"> Simpan </a>
												</td>
											</tr>
											<tr>     
												<th>No</th>
												<th>Indikator <?=$jenis?></th>
												<th>Scoring</th>
												<th class="action">Action</th>
											</tr>                         
										</thead>
										<tbody>
											
											<? $no=1;
											if(!empty($otentik)){
											foreach($otentik as $ky=>$dataaff){?>
											<tr class="otentiktrx identy<?=$dataaff['id']?>" idnya="<?=$dataaff['id']?>" >
												<td class="no"><?=$no++?></td>
												<td >
												<div style="color:#ababab; float:left;"><?=$_POST['nama_siswa']?></div>
												<textarea style="height:61px; margin:5px 0;" cols="30" name="otentik[<?=$dataaff['id']?>]" class="otentik" ><?=$dataaff['indikator']?></textarea>
												</td>
												<td >
													<? if(!isset($dataaff['point'][0]['id'])){$dataaff['point'][0]['id']=0;}?>
													1<input type="radio" name="point[<?=$dataaff['id']?>][<?=$dataaff['point'][0]['id']?>]" <? if($dataaff['point'][0]['point']==1 && $dataaff['point'][0]['id']!=0){echo'checked';}?> value="1" /><br />
													2<input type="radio" name="point[<?=$dataaff['id']?>][<?=$dataaff['point'][0]['id']?>]" <? if($dataaff['point'][0]['point']==2 && $dataaff['point'][0]['id']!=0){echo'checked';}?> value="2" /><br />
													3<input type="radio" name="point[<?=$dataaff['id']?>][<?=$dataaff['point'][0]['id']?>]" <? if($dataaff['point'][0]['point']==3 && $dataaff['point'][0]['id']!=0){echo'checked';}elseif($dataaff['point'][0]['id']==0){echo'checked';}?>  value="3" /><br />
													4<input type="radio" name="point[<?=$dataaff['id']?>][<?=$dataaff['point'][0]['id']?>]" <? if($dataaff['point'][0]['point']==4 && $dataaff['point'][0]['id']!=0){echo'checked';}?> value="4" /><br />
													<!--5<input type="radio" name="point[<?=$dataaff['id']?>][<?=$dataaff['point'][0]['id']?>]" <? if($dataaff['point'][0]['point']==5 && $dataaff['point'][0]['id']!=0){echo'checked';}?> value="5" /><br />-->
													
												</td>
												<td >
												<a class="button small light-grey" onclick="hapusdata(this,<?=@$dataaff['id']?>);" title="Hapus baris ini"> <span> Hapus </span> </a>
												<input type="hidden" name="id[<?=$dataaff['id']?>]" value="<?=$dataaff['id']?>" />
												</td>
											</tr>
											<? }  } ?>
											
											<tr id="beforeadd">
												<td align="right" colspan="5">
												<a title="" style="float:right;" class="readmorenoplus2 simpancatatan"  onclick="$('#formindikator').submit();"> Simpan </a>
												<a href="" style="float:right;" title="" id="catatanguru" class="readmore"> Tambah Indikator</a>
												</td>
											</tr>
										</tbody>
								</table>