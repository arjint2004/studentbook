							  
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
										  data: "aktif="+$(thisobj).val()+"&id_user="+$(this).attr('id_user'),
										  url: '<?=base_url()?>superadmin/sekolah/aktifasi/',
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
								});
								$('table#akunsekolah tr td div.menu').toggle(function(){
									$(this).addClass('active');
								}, function () {
									$(this).removeClass('active');
								});
								 
								$("table#akunsekolah tr td div.menu").click(function () {
									$(this).next('ul.submenu').slideToggle();
								});
								
								$("table#akunsekolah tr td div.hide").click(function () {
									var elm=$(this);
									$(elm).parent('td').parent('tr').hide(500);
								});
								
								$("table#akunsekolah tr td ul.submenu li.mn1").click(function () {
									var el=$(this);
									if($(el).html()=='Hapus Sekolah'){
										if(!confirm('Semua data sekolah akan di hapus secara permanen. Apakah anda yakin?')){
											return false;
										}
									}
									
									$.ajax({
										  type: "POST",
										  data: "ajax=1&id_sekolah="+$(el).attr('id'),
										  url: $(el).attr('href')+$(el).attr('id'),
										  beforeSend: function() {
											$(el).after("<img id='wait' style='margin: 0px; position: relative; left: 2px; bottom: 23px; float: left;'  src='<?=$this->config->item('images').'loading.png';?>' />");
										  },
										  success: function(msg) {
											$("#wait").remove();
											$('table#akunsekolah tr td div.loaddivset'+$(el).attr('id')).html(msg);
										  }
									});
									$('table tr#tr'+$(el).attr('id')).show();
									$('table tr#tr'+$(el).attr('id')).scrollintoview({ speed:'1100'});
								});
							  });
							  </script>
							<? //pr($datasekolah);?>
							<!--<div class="ribbon"></div>-->
							<table id="akunsekolah">
								<thead>
									<tr> 
										<th> No </th>
										<th> Nama </th>
										<th> Email </th>
										<th> Pendaftar </th>
										<th> Aktifasi </th>
										<th width="100"> Menu </th>
									</tr>                            
								</thead>
								<tbody>
								<? 
								//pr($datasekolah);
								//if($halaman==0){$halaman=1;}
								$i=$start;
								if(!empty($datasekolah)){
								foreach($datasekolah as $xx=>$sekolah){ $i++;?>
									<tr id="<?=$sekolah['id']?>"> 
										<td > <?=$i?> </td>
										<td class="title"> <?=$sekolah['nama_sekolah']?> </td>
										<td class="title"> <?=$sekolah['email']?> </td>
										<td class="title"> <?=$sekolah['nama_pendaftar']?> </td>
										<td class="title">
										<input type="checkbox" id_user="<?=$sekolah['id_user']?>" value="<?=$sekolah['aktif']?>" <? if($sekolah['aktif']==1){echo "checked";}?> name="aktif" class="aktifasi"/>
										</td>
										<td> 
										<!--<select name="menu<?=$sekolah['id']?>">
											<option>Atur Fitur</option>
											<option>Atur SMS</option>
										</select>-->
											<div class="menu">Menu</div>
											<ul style="display:none;" class="submenu">
												<li id="<?=$sekolah['id']?>" class="mn1" href="<?=base_url()?>superadmin/sekolah/setfitur/">Set Fitur</li>
												<li id="<?=$sekolah['id']?>" class="mn1" href="<?=base_url()?>superadmin/sekolah/setsms/">Set SMS</li>
												<li id="<?=$sekolah['id']?>" class="mn1" href="<?=base_url()?>superadmin/sekolah/topupsms/">Top Up SMS</li>
												<li id="<?=$sekolah['id']?>" class="mn1" href="<?=base_url()?>superadmin/sekolah/delete/">Hapus Sekolah</li>
											</ul>
										</td>
									</tr> 
									<tr style="display:none;" id="tr<?=$sekolah['id']?>">
										<td colspan="6" class="innercolspan" id="loadset<?=$sekolah['id']?>">
											<div class="hide"></div>
											<div class="loaddivset<?=$sekolah['id']?>"></div>
										</td>
									</tr>
								<? }  } ?>
								</tbody>
							</table>
							  <div id="ajax_pagingss">
								<?php echo $pagination; ?>
							  </div>

