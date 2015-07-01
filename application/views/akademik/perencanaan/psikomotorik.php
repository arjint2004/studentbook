								<script>
									$(document).ready(function(){
										//Submit Start

										<? if(empty($psikomotorik)){?>
										var tr='<tr>'+$("table tr#master").html()+'</tr>';
										$("table tr#beforeadd").before(tr);
										<? } ?>
										$("table tr td a.readmore").click(function(){
											var tr='<tr>'+$("table tr#master").html()+'</tr>';
											$("table tr#beforeadd").before(tr);
											return false;
										});
										
										$("#catatangurudataform").submit(function(e){
											var error=false;
											$("table tr td textarea.psikomotorik").each(function(e){
												if($(this).val()==''){
													$(this).css('border','1px solid red');
													error=true;
												}else{
													$(this).css('border','1px solid #bdbdbd');
													error=false;
												}
											});
											<? if(isset($_POST['id_pelajarans']) || $id_pelajaran!=0){}else{?>
											$("table tr td select.psikomotorik").each(function(e){
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
												data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&'+$(this).serialize()+'&simpan=true&id_pembelajaran=<?=$id_pembelajaran?>',
												url: $(this).attr('action'),
												beforeSend: function() {
													$("#simpancatatan").after("<img id='wait' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
												},
												success: function(msg) {
													$("#wait").remove();	
														$.ajax({
															type: "POST",
															data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&ajax=1&id_pembelajaran=<?=$id_pembelajaran?>&id_pelajaran=<?=$_POST['id_pelajaran']?>',
															<? if(empty($psikomotorik)){?>
															url: '<?=base_url('akademik/perencanaan/sukses/RPP')?>',
															<? }else{ ?>
															url: '<?=base_url('akademik/perencanaan/sukses/PSIKOMOTORIK')?>',
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
										if(confirm('Data indikator psikomotorik akan dihapus. klik "OK" untuk menghapus. Klik cancel untuk batal. ')){
											$.ajax({
													type: "POST",
													data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&',
													url: base_url+'akademik/perencanaan/hapusindikator/'+id,
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
										<td></td>
										<td >
											<select <? if(isset($_POST['id_pelajaran'])){echo'disabled';}?> style="float:left;width:100%;" class="selectfilter psikomotorik" id="pelajaran_addafktf" name="id_pelajaranx[]">
												<option value="">Pilih Pelajaran</option>
												<?
												if(!empty($pelajaran)){			
												foreach($pelajaran as $datapelajaran){?>
												<option <? if(@$_POST['id_pelajaran']==$datapelajaran['id']){echo 'selected';}?> value="<?=$datapelajaran['id']?>"><?=$datapelajaran['nama']?> [Kelas <?=$datapelajaran['kelas']?>]</option>
												<? }} ?>
											</select>	
											<? if(isset($_POST['id_pelajaran'])){echo '<input type="hidden" name="id_pelajaranx[]" value="'.$_POST['id_pelajaran'].'" />';}?>
										</td>
										<td ><textarea class="psikomotorik" style="height:30px;" cols="30" name="psikomotorik[]" ></textarea></td>
										<td ><a class="button small light-grey" onclick="hapus(this);" title="Hapus baris ini"> <span> Hapus </span> </a></td>
									</tr>
								</table>
								
								<form action="<?=base_url()?>akademik/perencanaan/psikomotorik" method="post" id="catatangurudataform" style="width:700px;height:100%;">
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
								<table>
									<tbody>
										<tr>
											<td>
												<b>INDIKATOR PENILAIAN PSIKOMOTORIK</b>
											</td>
										</tr>
									</tbody>
								</table>
												
								<table id="data">
										<thead>
											<tr>     
												<th>No</th>
												<th>Pelajaran</th>
												<th>Indikator Afektif</th>
												<th class="action">Action</th>
											</tr>                         
										</thead>
										<tbody>
											<? $no=1;foreach($psikomotorik as $ky=>$dataaff){?>
											<tr >
												<td><?=$no++?></td>
												<td >
													<select <? if(isset($_POST['id_pelajaran'])){echo'disabled';}?> style="float:left;width:100%;" class="selectfilter psikomotorik" id="pelajaran_addafktf" name="id_pelajaranx[]">
														<option value="">Pilih Pelajaran</option>
														<?
														if(!empty($pelajaran)){			
														foreach($pelajaran as $datapelajaran){?>
														<option <? if($dataaff['id_pelajaran']==$datapelajaran['id']){echo 'selected';}?> value="<?=$datapelajaran['id']?>"><?=$datapelajaran['nama']?> [Kelas <?=$datapelajaran['kelas']?>]</option>
														<? }} ?>
													</select>
													<? if(isset($_POST['id_pelajaran'])){echo '<input type="hidden" name="id_pelajaranx['.$dataaff['id'].']" value="'.$_POST['id_pelajaran'].'" />';}?>
												</td>
												<td ><textarea style="height:30px;" cols="30" name="psikomotorik[<?=$dataaff['id']?>]" class="psikomotorik" ><?=$dataaff['indikator']?></textarea></td>
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