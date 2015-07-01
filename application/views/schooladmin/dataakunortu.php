								<script>
							  $(function() {
								applyPagination();
								function applyPagination() {
								  $("#ajax_pagingoo a").click(function() {
									var url = $(this).attr("href");
									$.ajax({
									  type: "POST",
									  data: "<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&ajax=1&id_kelas="+$('select#filterkelasortu').val(),
									  url: url,
									  beforeSend: function() {
										$("#contentpageoo").html("<img src='<?=$this->config->item('images').'loading.png';?>' />");
									  },
									  success: function(msg) {
										$("#contentpageoo").html(msg);
										//applyPagination();
									  }
									});
									return false;
								  });
								}
								$("select#filterkelasortu").change(function() {
									var listtype='ortu';
									var thisobj=$(this);
									$.ajax({
									type: "POST",
									data: "<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&ajax=1&id_kelas="+$(this).val(),
									url: '<?php echo base_url(); ?>admin/schooladmin/dataakun/'+listtype+'/0',
									beforeSend: function() {
										$(thisobj).after("<img id='wait' style='margin:0;' src='<?=$this->config->item('images').'loading.png';?>' />");
									},
									success: function(msg) {
										$('#wait').remove();
										$("#ajax"+listtype+"").html(msg);			
									}
									});
								});
							  });
							  </script>
							<div id="contentpageoo">
							<? //pr($kelas);?>
							<table>
								<thead>
									<tr> 
										<th colspan="7" style="padding:5px; text-align:left;"> 
											Filter Kelas                             		
											<select name="kelas" class="filterkelas" id="filterkelasortu">
												<option value="" >Pilih Kelas</option>
												<? foreach($kelas as $datakelas){?>
												<option <?if(isset($kelasselected) && $kelasselected==$datakelas['id']){echo 'selected';}?> value="<?=$datakelas['id']?>" ><?=$datakelas['kelas'].$datakelas['nama']?></option>
												<? } ?>
											</select>
										</th>
									</tr>
									<tr> 
										<th> No </th>
										<th> Ortu </th>
										<th> Siswa </th>
										<!--<th> Tgl Daftar </th>-->
										<th> Username </th>
										<th> Password </th>
										<th> Akun </th>
										<th> Action </th>
									</tr>                            
								</thead>
								<tbody>
								<? 
								//if($halaman==0){$halaman=1;}
								$i=$start;
								if(!empty($dataguru)){
								foreach($dataguru as $xx=>$guru){ $i++;?>
									<tr> 
										<td> <?=$i?> </td>
										<td class="title"> Bp/Ibu. <?=$guru['nama']?> </td>
										<td class="title"> <?=$guru['nama_siswa']?> </td>
										<!--<td> <?=$guru['tgl_daftar']?> </td>-->
										<td class="title"> <?=$guru['username']?> </td>
										<td class="title"> <?=$guru['password']?> </td>
										<td> 
										<?
											$otor['id_user']=$guru['id_user'];
											$otor['id']=$guru['id'];
											$otor['nama']=$guru['NmOrtu'];
											$otor['otoritas']='ortu';
											
											$otoren=base64_encode(serialize($otor));
										?>
										<a href="<?=base_url()?>admin/otoritas/setotoritas/<?=$otoren?>">Atur</a> </td></td>
										<td> 
										<? if($guru['aktif']){?>
										<a href="<?=base_url()?>admin/otoritas/disableakun/<?=$otoren?>" onclick="return confirm('Apakah anda akan non aktifkan orang tua wali untuk siswa ini...')">Non Aktifkan</a> 
										<? }else{?>
										<a href="<?=base_url()?>admin/otoritas/enableakun/<?=$otoren?>" onclick="return confirm('Apakah anda akan non aktifkan orang tua wali untuk siswa ini')">Aktifkan</a> 
										<? } ?>
										</td>
									</tr> 
								<? } } ?>
								</tbody>
							</table>
							  <div id="ajax_pagingoo">
								<?php echo $pagination; ?>
							  </div>
							
							</div>
