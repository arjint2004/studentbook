								<script>
									$(document).ready(function(){
										//Submit Start

										
										$("table tr td a.readmore").click(function(){
											var tr='<tr>'+$("table tr#master").html()+'</tr>';
											$("table tr#beforeadd").before(tr);
											return false;
										});
										
										$("#catatangurudataform").submit(function(e){
											$.ajax({
												type: "POST",
												data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&'+$(this).serialize()+'&simpan=true'+'&'+$('form#catatanguruform').serialize()+'&tanggal='+$('input#datekirimcatatanguru').val(),
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
								<table style="display:none;">
									<tr id="master">
										<td>
											<select name="data[id_aspek_kepribadian][]">
												<option value="">Pilih Aspek</option>
												<? foreach($aspek as $dataaspek){?>
												<option value="<?=$dataaspek['id']?>"><?=$dataaspek['nama']?></option>
												<? } ?>
											</select>
										</td>
										<td ><textarea style="height:30px;" cols="30" name="data[apresiasi][]" ></textarea></td>
										<td ><textarea style="height:30px;" cols="30" name="data[pelanggaran][]"></textarea></td>
										<td ><a class="button small light-grey" onclick="hapus(this);" title="Hapus baris ini"> <span> Hapus </span> </a></td>
									</tr>
								</table>
								
								<form action="<?=base_url()?>akademik/catatanguru/catatangurulist" method="post" id="catatangurudataform" >
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
								<table id="data">
										<thead>
											<tr>
												<th colspan="4" style="text-align:right;">
													<a title="" class="button small light-grey absenbutton" id="simpancatatan" onclick="$('#catatangurudataform').submit();"> Simpan </a>
												</th>
											</tr>
											<tr>     
												<th>Aspek</th>
												<th>Catatan Apresiasi</th>
												<th>Catatan Pelanggaran</th>
												<th class="action">Action</th>
											</tr>                         
										</thead>
										<tbody>
											<? 
												$no=1;
												if(!empty($catatanguru)){
												foreach($catatanguru as $kt=>$datacatatanguru){
											?>
											<tr>
												<td >
												<select class="aspek" name="data[id_aspek_kepribadian][]">
													<option value="">Pilih Aspek</option>
													<? foreach($aspek as $dataaspek){?>
														<option <? if($dataaspek['id']==$datacatatanguru['id_aspek_kepribadian']){echo 'selected';}?> value="<?=$dataaspek['id']?>"><?=$dataaspek['nama']?></option>
													<? } ?>
												</select>
												</td>
												<td ><textarea style="height:30px;" cols="30" name="data[apresiasi][]" ><?=$datacatatanguru['apresiasi']?></textarea></td>
												<td >
													<textarea style="height:30px;" cols="30" name="data[pelanggaran][]"><?=$datacatatanguru['pelanggaran']?></textarea>
													<input type="hidden" name="data[id][]" value="<?=@$datacatatanguru['id']?>">
												</td>
												<td class="action"><a class="button small light-grey" title="Hapus baris ini" onclick="hapusdata(this,<?=@$datacatatanguru['id']?>);" > <span> Hapus </span> </a></td>
											</tr>
											<? }  } ?>
											
											<tr id="beforeadd">
												<td align="right" colspan="4"><a href="" style="float:right;" title="" id="catatanguru" class="readmore"> Tambah Catatan</a></td>
											</tr>
										</tbody>
								</table>
								</form>