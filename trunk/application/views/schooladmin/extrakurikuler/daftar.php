							  <script>
							  $(document).ready(function(){
							  
								
								$('#formaddextra').submit(function() {
									var listtype='siswa';
									$.ajax({
									type: "POST",
									data: $(this).serialize(),
									url: '<?php echo base_url(); ?>admin/extrakurikuler/daftar/',
									beforeSend: function() {
										$("select#id_kelas").after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
									},
									success: function(msg) {
										$('img#wait').remove();
										$("#contentpagess").html(msg);			
									}
									});
									return false;
									
								});
								
								 
								 
								 $('#selectall').click(function() {
								 
									if($(this).is(":checked")){
										$('#selectall').prop('checked', true);
										$( 'input.tf' ).each(function( index ) {
											$(this).prop('checked', true);
											setextraall($(this),$(this).attr('id_det_jenjang'));
										});
										
									}else{
										$('#selectall').prop('checked', false);
										$( 'input.tf' ).each(function( index ) {
											$(this).prop('checked', false);
											setextraall($(this),$(this).attr('id_det_jenjang'));
										});
										
									}
								 });
								 
							  });
							  function setextra(obj,id_siswa_det_jenjang){
									//alert($('#id_extrakurikuler').val());
									if($('#id_extrakurikuler').val()==''){
										$(obj).attr('checked', false);
										$('#id_extrakurikuler').css('border','1px solid red');
										return false;
									}
									if($(obj).is(':checked')){
										var isdel=1;
									}else{
										var isdel=0;
									}
									$.ajax({
									type: "POST",
									data: 'isdel='+isdel+'&simpan=1&id_siswa_det_jenjang='+id_siswa_det_jenjang+"&"+$('#formaddextra').serialize(),
									url: '<?php echo base_url(); ?>admin/extrakurikuler/daftar/',
									beforeSend: function() {
										$(obj).parent().html("<img src='<?=$this->config->item('images').'loading.png';?>' />");
									},
									success: function(msg) {
										$("#contentpagess").html(msg);			
									}
									});									
							  }
							  function setextraall(obj,id_siswa_det_jenjang){
									//alert($('#id_extrakurikuler').val());
									if($('#id_extrakurikuler').val()==''){
										$(obj).attr('checked', false);
										$('#id_extrakurikuler').css('border','1px solid red');
										return false;
									}
									if($('#selectall').is(":checked")){
										var isdel=1;
										//alert(isdel);
									}else{
										var isdel=0;
										//alert(isdel);
									}
									$.ajax({
									type: "POST",
									data: 'isdel='+isdel+'&simpan=1&id_siswa_det_jenjang='+id_siswa_det_jenjang+"&"+$('#formaddextra').serialize(),
									url: '<?php echo base_url(); ?>admin/extrakurikuler/daftar/',
									beforeSend: function() {
										$(obj).parent().html("<img src='<?=$this->config->item('images').'loading.png';?>' />");
									},
									success: function(msg) {
										$("#contentpagess").html(msg);		
										
										if(isdel==1){
											$('#selectall').prop('checked', true);
										}else{
											$('#selectall').prop('checked', false);
										}		
									}
									});									
							  }
							  </script>
							<div id="contentpagess">
							<h1 class="with-subtitle"> Pendaftaran extrakurikuler </h1>
							<h6 class="subtitle"> Pengaturan data siswa yang ikut extrakurikuler </h6>
							<div class="styled-elements">
								<div id="listkelasloading"></div>
								<div id="listkelas">
									<form action="" method="post" id="formaddextra" name="formaddextra" >
										Pilih Kelas                             		
										<select onchange=" $('#formaddextra').submit(); return false;" name="id_kelas" id="id_kelas" >
											<option value="" >Pilih Kelas</option>
											<? foreach($kelas as $datakelas){?>
											<option <?if(isset($kelasselected) && $kelasselected==$datakelas['id']){echo 'selected';}?> value="<?=$datakelas['id']?>" ><?=$datakelas['kelas'].$datakelas['nama']?></option>
											<? } ?>
										</select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										Pilih Ekstrakurikuler                           		
										<select onchange="  $('#formaddextra').submit(); return false;" id="id_extrakurikuler" name="id_extrakurikuler">
											<option value="" >Pilih Ekstrakurikuler</option>
											<? foreach($extra as $dataextra){?>
											<option <?if(isset($extraselected) && $extraselected==$dataextra['id']){echo 'selected';}?> value="<?=$dataextra['id']?>" ><?=$dataextra['nama']?></option>
											<? } ?>
										</select>
										<input type='hidden' value='1' name='ajax' />
									</form>
									<? //pr($datajumpcur);?>
									<table >
										<thead>
											<tr> 
												<th> No </th>
												<th> Nis </th>
												<th> Nama </th>
												<th> Daftarkan <input  type="checkbox" id="selectall" name="selectall" /></th>
											</tr>                            
										</thead>
										<tbody>
										<? 
										//if($halaman==0){$halaman=1;}
										$i=0;
										foreach($datasiswa as $xx=>$siswa){ $i++;?>
											<tr> 
												<td> <?=$i?> </td>
												<td> <?=$siswa['nis']?> </td>
												<td class="title"> <?=$siswa['nama']?> </td>
												<td> <input class="tf" type="checkbox" id_det_jenjang="<?=$siswa['id_siswa_det_jenjang']?>" <? if(isset($datajumpcur[$siswa['id_siswa_det_jenjang']])){echo "checked value='1'";}else{echo "value='0'";}?> name="cek[<?=$siswa['id']?>]" onclick="setextra(this,<?=$siswa['id_siswa_det_jenjang']?>);" /></td>
												
											</tr> 
										<? } ?>
										</tbody>
									</table>
									
								</div>
								<div class="hr"> </div>
								<div class="clear"> </div>
							</div>
							</div> <!-- **Styled Elements - End** -->  
							
