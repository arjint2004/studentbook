				<script>
					$(document).ready(function(){
					$('.unsellall').click( function() {
						$('#idsiswalaporan option').attr('selected', false);
					});
					$('.selall').click( function() {
						$('#idsiswalaporan option').attr('selected', 'selected');
					});
					$("select#kelaslaporan").change(function(e){
						$.ajax({
							type: "POST",
							data: $("form#jurnalwaliformcontent").serialize(),
							url: '<?=base_url()?>akademik/jurnalwali/getOptionSiswaByIdKelas/'+$(this).val(),
							beforeSend: function() {
								$("select#kelaslaporan").after("<img id='wait' src='<?=$CI->config->item('images').'loading.png';?>' />");
								//$("#subjectlist table.tabelkelas tbody").html("");
							},
							success: function(msg) {
								$("#wait").remove();
								$("#idsiswalaporan").html(msg);	
							}
						});
						return false;
					});//Submit End
				
				
				$("#kirimlaporan").each(function(){
					$container = $(this).next("div.error-container");
					//Validate Starts
					$(this).validate({
						onfocusout: function(element) {	$(element).valid();	},
						errorContainer: $container,
						rules:{
						  kepada:{required:true,notEqual:''},
						  id_kelas:{required:true,notEqual:'Pilih Kelas'},
						  id_siswa:{required:true,notEqual:'Pilih Siswa'},
						  keterangan:{required:true,notEqual:''}
						  /*,message:{required:true,minlength:10}*/
						}
					});//Validate End

				});
				
				$("table.adddata tr th a.cancellaporan").click(function(){
						var obj=$(this);
						$.ajax({
							type: "POST",
							data: 'id_kelas='+$('select#kelas').val()+'&pelajaran='+$('select#pelajaran').val()+'&ajax=1',
							url: '<?=base_url('akademik/kirimlaporan/daftarlaporanlist')?>',
							beforeSend: function() {
								$(obj).after("<img id='wait' style='margin:0;float:right;'  src='<?=$CI->config->item('images').'loading.png';?>' />");
							},
							success: function(msg) {
								$("#wait").remove();
								$('select#kelas').val($('select#kelas_add').val());
								$('select#pelajaran').html($('select#pelajaran_add').html());
								$('select#pelajaran').val($('select#pelajaran_add').val());	
								$('#subjectlist').html(msg);
								
							}
						});
						return false;
				});
				
				$("#kirimlaporan").submit(function(e){
					$frm = $(this);
					$id_kelas = $frm.find('*[name=id_kelas]').val();
					$id_siswa = $frm.find('*[name=id_siswa]').val();
					$kepada = $frm.find('*[name=kepada]').val();
					$keterangan = $frm.find('*[name=keterangan]').val();
					if($frm.find('*[name=id_kelas]').is('.valid') && $frm.find('*[name=id_siswa]').is('.valid') && $frm.find('*[name=kepada]').is('.valid') && $frm.find('*[name=keterangan]').is('.valid')) {
						$.ajax({
							type: "POST",
							data: $(this).serialize()+'&'+$('form#nilai').serialize(),
							url: $(this).attr('action'),
							beforeSend: function() {
								$("#simpanlaporan").after("<img id='wait' style='margin:0;float:right;'  src='<?=$CI->config->item('images').'loading.png';?>' />");
							},
							success: function(msg) {
								$("#wait").remove();	
								
								ajaxupload("<? echo base_url();?>akademik/kirimlaporan/uploadfilelaporan/"+msg,"response","image-list","file");
								
								$.ajax({
									type: "POST",
									data: 'id_kelas='+$('select#kelas_add').val()+'&pelajaran='+$('select#pelajaran_add').val()+'&ajax=1',
									url: '<?=base_url('akademik/kirimlaporan/daftarlaporanlist')?>',
									beforeSend: function() {
										$("#simpanlaporan").after("<img id='wait' style='margin:0;float:right;'  src='<?=$CI->config->item('images').'loading.png';?>' />");
									},
									success: function(msg) {
										$("#wait").remove();
										$('select#kelas').val($('select#kelas_add').val());
										$('select#pelajaran').html($('select#pelajaran_add').html());
										$('select#pelajaran').val($('select#pelajaran_add').val());
										$('#subjectlist').html(msg);
										$('#subject').scrollintoview({ speed:'1100'});
									}
								});	
							}
						});
						return false;
					}
					
					return false;
				});//Submit End	
				});
				</script>
				                    <div class="hr"> </div>
                    <div class="clear"> </div>
<h2 class="float-left" class="aktifitasakademik"> Buku Penghubung Ortu </h2>
                    
                    <div class="tabs-container">
                        <ul class="tabs-frame">
                            <li><a href="#">Daftar Laporan</a></li>
                            <li><a href="#">Kirim Laporan</a></li>
                            
                        </ul>
                        <div class="tabs-frame-content">
                            <!-- **Respond Form** -->                      
							<div class="respond">
								<form method="post" name="kirimlaporan" enctype="multipart/form-data" id="kirimlaporan" action="<? echo base_url();?>akademik/kirimlaporan/kirimlaporanutama">
									<table class="adddata lap">
										<tbody>
										<tr>
											<th style="text-align:right;" colspan="4">
											<a onclick="$('#kirimlaporan').submit();" id="simpanlaporan" class="button small light-grey absenbutton" title=""> Kirim </a>
											</th>
										</tr>
										<tr>
											<td class="title" width="10">Kepada</td>
											<td>:</td>
											<td colspan="2">
												
												<select name="kepada" id="kepada" multiple>
													<option value="ortu" selected>Wali / Orang Tua</option>
													<option value="siswa">Siswa</option>
												</select>
											</td>
										</tr>
										<tr>
											<td class="title">Kelas</td>
											<td>:</td>
											<td colspan="2">
												<select name="id_kelas" id="kelaslaporan">
													<option value="">Pilih Kelas</option>
													<? foreach($kelaslaporan as $datakelas){?>
													<option <? if(@$_POST['kelas']==$datakelas['id']){echo 'selected';}?> value="<?=$datakelas['id']?>"><?=$datakelas['kelas']?><?=$datakelas['nama']?></option>
													<? } ?>
												</select>
											</td>
										</tr>
										<tr>
											<td class="title">Siswa</td>
											<td>:</td>
											<td>		
												
												<select multiple name="id_siswa" id="idsiswalaporan" style="max-width:250px;">
													<option value="">Pilih Siswa</option>
												</select>
											</td>
										    <td>
											<a style="cursor:pointer;" class="selall">Pilih Semua</a> |  
											<a style="cursor:pointer;" class="unsellall">Kosongkan</a>
											</td>
										</tr>
										<tr>
											<td class="title">Keterangan</td>
											<td>:</td>
											<td colspan="2">		
												<textarea style="width:98%; height:500px;" name="keterangan" cols="" rows=""></textarea>
											</td>
										</tr>
										
										<tr>
											<td width="30%" class="title">Lampiran</td>
											<td width="1">:</td>
											<td colspan="2">
												<input type="file" name="file" id="file" multiple />
												<div id="response" style="font-size:11px;">Anda bisa memilih banyak file dengan memencet tombol "Ctrl", kemudian klik file yang dipilih lebih dari satu</div>
											</td>
										</tr>
										
										<tr>
											<th style="text-align:right;" colspan="4">
											<a onclick="$('#kirimlaporan').submit();" id="simpanlaporan" class="button small light-grey absenbutton" title=""> Kirim </a>
											<a class="button small light-grey absenbutton cancellaporan" title=""> Cancel </a>
											</th>
										</tr>
										
									</tbody></table>


								<input type="hidden" value="1" name="ajax"> 

								<div style="display:none;" class="error-container"> Semua field harus di isi atau dipilih!  </div>
								</form>
								
							</div><!-- **Respond Form - End** --> 
                        </div>
                        <div class="tabs-frame-content">
                            <!-- **Respond Form** -->                      
							<div class="respond">
								<form action="#" method="get">
									
									<label> Kepada <span> * </span> </label>
									<p>
										<input name="siswaortu" type="checkbox" class="radio" /> SISWA
										<input name="siswaortu" type="checkbox" class="radio" /> ORANG TUA
									</p>
									
									<p>
										<input name="name" type="text" class="textbox" />
										<label> Email <span> * </span> </label>
									</p>
									
									<p>
										<input name="name" type="text" class="textbox" />
										<label> Website </label>
									</p>
									
									<p>
										<textarea name="comment" cols="" rows=""></textarea>
									</p>
									
									<p>
										<input name="submit" type="button" value="Submit Comment" class="button small grey" />
									</p>
								
								</form>
							</div><!-- **Respond Form - End** -->    
                        </div>
                    </div>    