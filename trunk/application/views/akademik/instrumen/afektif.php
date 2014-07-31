								<script>
									$(document).ready(function(){
										//Submit Start
										<? if(empty($afektif)){?>
										var tr='<tr>'+$("table tr#master").html()+'</tr>';
										$("table tr#beforeadd").before(tr);
										<? } ?>
										$("table tr td a.readmore").click(function(){
											var last_id=$("table#data tr.afektiftrx").last().attr('idnya');
											var last_id=parseInt(last_id)+1;
											var tr='<tr class="afektiftrx identy'+last_id+'" idnya="'+last_id+'">'+$("table tr#master").html()+'</tr>';
											var no=parseInt($("table#data tr.afektiftrx td.no").last().html())+1;
											$("table tr#beforeadd").before(tr);
											$("table tr.identy"+last_id+" td.no").html(no);
											$("table tr.identy"+last_id+" td.radio").html('1<input type="radio" name="point['+last_id+']" value="1" /><br />2<input type="radio" name="point['+last_id+']" value="2" /><br />3<input type="radio" name="point['+last_id+']" checked value="3" /><br />4<input type="radio" name="point['+last_id+']" value="4" /><br />5<input type="radio" name="point['+last_id+']" value="5" />');
											return false;
										});
										
										$("#catatangurudataform").submit(function(e){
											var error=false;
											$("table tr td textarea.afektif").each(function(e){
												if($(this).val()==''){
													$(this).css('border','1px solid red');
													error=true;
												}else{
													$(this).css('border','1px solid #bdbdbd');
													error=false;
												}
											});
											<? if(isset($_POST['id_pelajarans']) || $id_pelajaran!=0){}else{?>
											$("table tr td select.afektif").each(function(e){
												if($(this).val()==''){
													$(this).css('border','1px solid red');
													error2=true;
												}else{
													$(this).css('border','1px solid #bdbdbd');
													error2=false;
												}
											});
											<? } ?>
											
											
											if(error==true){return false}
											if(error2==true){return false}
											
											$.ajax({
												type: "POST",
												data: $(this).serialize()+'&simpan=true&id_pembelajaran=<?=$id_pembelajaran?>',
												url: $(this).attr('action'),
												beforeSend: function() {
													$("#simpancatatan").after("<img id='wait' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
												},
												success: function(msg) {
													$("#wait").remove();	
														$.ajax({
															type: "POST",
															data: 'ajax=1&id_pembelajaran=<?=$id_pembelajaran?>&id_pelajaran=<?=$_POST['id_pelajaran']?>',
															
															<? if(empty($afektif)){?>
															url: '<?=base_url('akademik/instrumen/psikomotorik')?>',
															<? }else{ ?>
															url: '<?=base_url('akademik/instrumen/sukses/AFEKTIF')?>',
															<? } ?>
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
									
									function hapus(thisobj){
										$(thisobj).parent('td').parent('tr').remove();
										return false;
									}
									
									function hapusdata(thisobj,id){
										if(confirm('Data indikator afektif akan dihapus. klik "OK" untuk menghapus. Klik cancel untuk batal. ')){
											$.ajax({
													type: "POST",
													data: '',
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
								<table style="display:none;">
									<tr id="master"  class="afektiftrx" >
										<td class="no"></td>
										<td >
										<textarea class="afektif" style="height:61px;" cols="30" name="afektif[]" ></textarea>
										</td>
										<td class="radio"></td>
										<td ><a class="button small light-grey" onclick="hapus(this);" title="Hapus baris ini"> <span> Hapus </span> </a></td>
									</tr>
								</table>
								
								<form action="<?=base_url()?>akademik/instrumen/afektif" method="post" id="catatangurudataform" style="width:700px;height:100%;">
								<table>
									<tbody>
										<tr>
											<td>
												<b>INDIKATOR PENILAIAN AFEKTIF <select <? if(isset($_POST['id_pelajaran'])){echo'disabled';}?> style="float:left;width:100%;" class="selectfilter afektif" id="pelajaran_addafktf" name="id_pelajaranx[]">
												<option value="">Pilih Pelajaran</option>
												<?
												if(!empty($pelajaran)){			
												foreach($pelajaran as $datapelajaran){?>
												<option <? if(@$_POST['id_pelajaran']==$datapelajaran['id']){echo 'selected';}?> value="<?=$datapelajaran['id']?>"><?=$datapelajaran['nama']?> [Kelas <?=$datapelajaran['kelas']?>]</option>
												<? }} ?>
											</select>	
											<? if(isset($_POST['id_pelajaran'])){echo '<input type="hidden" name="id_pelajaranx[]" value="'.$_POST['id_pelajaran'].'" />';}?></b>
											</td>
										</tr>
									</tbody>
								</table>
												
								<table id="data">
										<thead>
											<tr>     
												<th>No</th>
												<th>Indikator Afektif</th>
												<th>Scoring</th>
												<th class="action">Action</th>
											</tr>                         
										</thead>
										<tbody>
											<? $no=1;foreach($afektif as $ky=>$dataaff){?>
											<tr class="afektiftrx identy<?=$dataaff['id']?>" idnya="<?=$dataaff['id']?>" >
												<td class="no"><?=$no++?></td>
												<td ><textarea style="height:61px;" cols="30" name="afektif[<?=$dataaff['id']?>]" class="afektif" ><?=$dataaff['indikator']?></textarea>
												</td>
												<td >
													1<input type="radio" name="point[<?=$dataaff['id']?>]" value="1" /><br />
													2<input type="radio" name="point[<?=$dataaff['id']?>]" value="2" /><br />
													3<input type="radio" name="point[<?=$dataaff['id']?>]" checked value="3" /><br />
													4<input type="radio" name="point[<?=$dataaff['id']?>]" value="4" /><br />
													5<input type="radio" name="point[<?=$dataaff['id']?>]" value="5" /><br />
												</td>
												<td >
												<a class="button small light-grey" onclick="hapusdata(this,<?=@$dataaff['id']?>);" title="Hapus baris ini"> <span> Hapus </span> </a>
												<input type="hidden" name="id[<?=$dataaff['id']?>]" value="<?=$dataaff['id']?>" />
												</td>
											</tr>
											<? } ?>
											
											<tr id="beforeadd">
												<td align="right" colspan="5">
												<a title="" style="float:right;" class="readmorenoplus2" id="simpancatatan" onclick="$('#catatangurudataform').submit();"> Simpan </a>
												<a href="" style="float:right;" title="" id="catatanguru" class="readmore"> Tambah Indikator</a>
												</td>
											</tr>
										</tbody>
								</table>
								</form>