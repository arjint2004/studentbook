							  
							  <script>
							  $(function() {
								applyPagination();
								function applyPagination() {
								  $("#ajax_pagingss a").click(function() {
									var url = $(this).attr("href");
									var thisobj= $(this);
									$.ajax({
									  type: "POST",
									  data: "ajax=1&propinsi="+$('select#provinsi').val()+"&kabupaten="+$('select#kabupaten').val()+"&jenjang="+$('select#jenjang').val(),
									  url: url,
									  beforeSend: function() {
										$(thisobj).append("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
									  },
									  success: function(msg) {
										$("#wait").remove();
										$("#contentpagess").html(msg);
										//applyPagination();
									  }
									});
									return false;
								  });
								}
								
								$("input.aktifasi[type='checkbox']").live("click",function(e){
										//alert();
									e.stopImmediatePropagation();
									var thisobj= $(this);
									$.ajax({
										  type: "POST",
										  data: "aktif="+$(thisobj).val()+"&id_sekolah="+$(this).attr('id_sekolah'),
										  url: '<?=base_url()?>superadmin/sekolah/aktifasisendername/',
										  beforeSend: function() {
											$(thisobj).after("<img id='wait' style='margin:0;'  src='<?=$this->config->item('images').'loading.png';?>' />");
											$(thisobj).hide();
										  },
										  success: function(msg) {
											$("#wait").remove();
											if(msg==1){
												$(thisobj).prop('checked', true);
												$(thisobj).val(1);
											}else{
												$(thisobj).prop('checked', false);
												$(thisobj).val(0);
											}
											
										    $(thisobj).show();
											//applyPagination();
										  }
									});
								})
							  });
							  </script>

							
							<? //pr($datasekolah);?>
							<table id="akunsiswa">
								<thead>
									<tr> 
										<th> No </th>
										<th> Nama Sekolah</th>
										<th> Nama Pengirim </th>
										<th> Setujui </th>
									</tr>                            
								</thead>
								<tbody>
								<? 
								//pr($datasekolah);
								//if($halaman==0){$halaman=1;}
								$i=$start;
								if(!empty($datasekolah)){
								foreach($datasekolah as $xx=>$sekolah){ $i++;?>
									<tr> 
										<td> <?=$i?> </td>
										<td class="title"> <?=$sekolah['nama_sekolah']?> </td>
										<td class="title"> <? if($sekolah['sendername']!=''){echo $sekolah['sendername'];}else{echo 'studentbook';}?> </td>
										<td>
										<?if($sekolah['sendername']!=''){?>
										<input type="checkbox" id_sekolah="<?=$sekolah['id']?>" value="<?=$sekolah['aktifasisendername']?>" <? if($sekolah['aktifasisendername']==1){echo "checked";}?> name="aktif" class="aktifasi"/>
										<? } ?>
										</td>
									</tr> 
								<? }  } ?>
								</tbody>
							</table>
							  <div id="ajax_pagingss">
								<?php echo $pagination; ?>
							  </div>

