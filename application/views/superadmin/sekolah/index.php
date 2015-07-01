							 <script>
							  $(function() {
									function getlist(thisobj){
										$.ajax({
										  type: "POST",
										  data: "<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&ajax=1&propinsi="+$('select#provinsi').val()+"&kabupaten="+$('select#kabupaten').val()+"&jenjang="+$('select#jenjang').val(),
										  url: '<?=$url?>',
										  beforeSend: function() {
											$(thisobj).after("<img id='wait' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
										  },
										  success: function(msg) {
											$("#wait").remove();
											$("#contentpagess").html(msg);
											//applyPagination();
										  }
										});
									}
								   $("select#provinsi").live("change",function(e){
										e.stopImmediatePropagation();
										var thisobj = $(this);
										$.post("<?=site_url('sos/sekolah/get_kota')?>",{ id : $(this).val()  },
										 function(data){
											var select ="";
											  select = select + '<option value="0">Pilih Kabupaten/Kota</option>';
											$.each( data, function(i, n){
											  select = select + '<option value="' + n.IDkota + '">' + n.NmKota + '</option>';
										  })
											$("#kabupaten").html(select);
											if(kabupaten) $("#kabupaten select").val(kabupaten);
										}, "json"
										);
										
										getlist(thisobj);
								  }); 
								   $("select#kabupaten,select#jenjang").live("change",function(e){
										e.stopImmediatePropagation();
										getlist($(this));
								  });
								  
							  });
							  </script>
				<link id="responsive-css" href="<?=$this->config->item('css');?>ad_style_front.css" rel="stylesheet" type="text/css" media="all" />			  
				<h1 class="with-subtitle"> <?=$page_title?> </h1>
				<h6 class="subtitle"> <?=$page_sub_title?> </h6>
                <div class="styled-elements">
					
					<table id="akunsiswa">
								<tbody>
									<tr> 
										<td colspan="4" style="padding:5px; text-align:left;"> 
											                             		
											<?php
											if(!empty($provinsi)) {
												echo '<select name="prop" id="provinsi" class="filterkelas">';
												echo '<option value="0">Pilih Provinsi</option>';
												foreach($provinsi as $pro) {
													if($sekolah[0]['prop']==$pro->IDprov){$sl='selected';}else{$sl='';}
													echo '<option '.$sl.' value="'.$pro->IDprov.'">'.$pro->NmProv.'</option>';
												}
												echo '</select>';
											}
										?>
										
										<select name="kec" id="kabupaten" class="filterkelas">
											<option value="0">Pilih Kabupaten/Kota</option>
										</select>
										
										<select name="jenjang" id="jenjang" class="filterkelas">
											<option value="0">Pilih Jenjang</option>
											<? foreach($jenjang as $dataj){?>
											<option value="<?=$dataj['id']?>"><?=$dataj['nama']?></option>
											<? } ?>
										</select>
										
										</td>
									</tr>
								</tbody>
							</table>
							<div id="contentpagess"></div>
                    <div class="hr"> </div>
                    <div class="clear"> </div>
                </div> <!-- **Styled Elements - End** -->  
							