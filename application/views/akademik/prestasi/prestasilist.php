								<script>
									$(document).ready(function(){
										//Submit Start

										
										$("table tr td a.readmore").click(function(){
											var tr='<tr>'+$("table tr#master").html()+'</tr>';
											$("table tr#beforeadd").before(tr);
											return false;
										});
										
										$("#prestasidataform").submit(function(e){
											$.ajax({
												type: "POST",
												data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&'+$(this).serialize()+'&simpan=true'+'&'+$('form#prestasiform').serialize(),
												url: $(this).attr('action'),
												beforeSend: function() {
													$("#simpancatatan").after("<img id='wait' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
												},
												success: function(msg) {
													$("#wait").remove();	
													//$('#subject').load('<? echo base_url();?>akademik/materi/index');
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
										if(confirm('Data catatan guru akan dihapus. klik "OK" untuk menghapus. Klik cancel untuk batal. ')){
											$.ajax({
													type: "POST",
													data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&',
													url: base_url+'akademik/prestasi/delete/'+id,
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
									<tr id="master">
										<td>
											<input type="text" name="data[kejuaraan][]" value="">
										</td>
										<td >
											<select  name="data[tahun][]">
												<? for($tahun=date('Y');$tahun>date('Y')-12;$tahun--){?>
													<option  value="<?=$tahun?>"><?=$tahun?></option>
												<? } ?>
											</select>
										</td>
										<td ><textarea name="data[prestasi][]" cols="30" style="height:30px;"></textarea></td>
										<td ><a class="button small light-grey" onclick="hapus(this);" title="Hapus baris ini"> <span> Hapus </span> </a></td>
									</tr>
								</table>
								
								<form action="<?=base_url()?>akademik/prestasi/prestasilist" method="post" id="prestasidataform" >
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
								<table id="data">
										<thead>
											<tr>
												<th colspan="4" style="text-align:right;">
													<a title="" class="button small light-grey absenbutton" id="simpancatatan" onclick="$('#prestasidataform').submit();"> Simpan </a>
												</th>
											</tr>
											<tr>     
												<th>Kejuaraan</th>
												<th>Tahun</th>
												<th>Prestasi</th>
												<th>Action</th>
											</tr>                         
										</thead>
										<tbody>
											<? 
												$no=1;
												if(!empty($prestasi)){
												foreach($prestasi as $kt=>$dataprestasi){
											?>
											<tr>
												<td >
													<input type="text"  name="data[kejuaraan][]" value="<?=@$dataprestasi['kejuaraan']?>">
												</td>
												<td >
													<select  name="data[tahun][]">
													<? for($tahun=date('Y');$tahun>date('Y')-12;$tahun--){?>
														<option <? if($tahun==$dataprestasi['tahun']){echo "selected";}?> value="<?=$tahun?>"><?=$tahun?></option>
														<? } ?>
													</select>
												</td>
												<td >
													<textarea name="data[prestasi][]" cols="30" style="height:30px;"><?=@$dataprestasi['prestasi']?></textarea>
													<input type="hidden" name="data[id][]" value="<?=@$dataprestasi['id']?>">
												</td>
												<td ><a class="button small light-grey" title="Hapus baris ini" onclick="hapusdata(this,<?=@$dataprestasi['id']?>);" > <span> Hapus </span> </a></td>
											</tr>
											<? }  } ?>
											
											<tr id="beforeadd">
												<td align="right" colspan="4"><a href="" style="float:right;" title="" id="prestasi" class="readmore"> Tambah Catatan</a></td>
											</tr>
										</tbody>
								</table>
								</form>