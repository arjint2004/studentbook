								<script>
							  $(function() {
								applyPagination();
								function applyPagination() {
								  $("#ajax_pagingkk a").click(function() {
									var url = $(this).attr("href");
									$.ajax({
									  type: "POST",
									  data: "ajax=1",
									  url: url,
									  beforeSend: function() {
										$("#contentpagekk").html("<img src='<?=$this->config->item('images').'loading.png';?>' />");
									  },
									  success: function(msg) {
										$("#contentpagekk").html(msg);
										applyPagination();
									  }
									});
									return false;
								  });
								}
							  });
							  </script>
							<div id="contentpagekk">
							
							<table>
								<thead>
									<tr> 
										<th> No </th>
										<th> Nama </th>
										<th> Tgl Daftar </th>
										<th> Username </th>
										<th> Password </th>
										<th> Atur Akun </th>
										<th> Action </th>
									</tr>                            
								</thead>
								<tbody>
								<? 
								//if($halaman==0){$halaman=1;}
								$i=$start;
								foreach($dataguru as $xx=>$guru){ $i++;?>
									<tr> 
										<td> <?=$i?> </td>
										<td> <?=$guru['nama']?> </td>
										<td> <?=$guru['tgl_daftar']?> </td>
										<td> <?=$guru['username']?> </td>
										<td> <?=$guru['password']?> </td>
										<td> 
										<?
											$otor['id_user']=$guru['id_user'];
											$otor['id']=$guru['id'];
											$otor['nama']=$guru['nama'];
											$otor['otoritas']='karyawan';
											
											$otoren=base64_encode(serialize($otor));
										?>
										<a href="<?=base_url()?>admin/otoritas/setotoritas/<?=$otoren?>">Atur</a> </td></td>
										<td> 
										<? if($guru['aktif']){?>
										<a href="<?=base_url()?>admin/otoritas/disableakun/<?=$otoren?>" onclick="return confirm('Apakah anda akan non aktifkan pegawai ini...')">Non Aktifkan</a> 
										<? }else{?>
										<a href="<?=base_url()?>admin/otoritas/enableakun/<?=$otoren?>" onclick="return confirm('Apakah anda akan non aktifkan pegawai ini')">Aktifkan</a> 
										<? } ?>
										</td>
									</tr> 
								<? } ?>
								</tbody>
							</table>
							  <div id="ajax_pagingkk">
								<?php echo $pagination; ?>
							  </div>
							
							</div>
