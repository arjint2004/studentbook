				
				<script>
					$(document).ready(function(){

					$('.unsellall').click( function() {
						$('#idsiswalaporan option').attr('selected', false);
						//add_id_ortu();
					});
					
					$('#listlap').click( function() {
						$('.listlap').show();
						$(this).children('a').addClass('current');
						$('#sendlap').children('a').removeClass('current');
						$('.sendlap').hide();
					});
					$('#sendlap').click( function() {
						$('.listlap').hide();
						$(this).children('a').addClass('current');
						$('#listlap').children('a').removeClass('current');
						$('.sendlap').show();
					});
					
					$('.selall').click( function() {
						$('#idsiswalaporan option').attr('selected', 'selected');
						//add_id_ortu();
					});
					$("select#kelaslaporan,select#idkelasp").change(function(e){
						if($(this).attr('name')=='idkelasp'){
							var urll='<?=base_url()?>akademik/jurnalwali/penghubungortulist/0';
							var append='#listpenghub';
						}else{
							var urll='<?=base_url()?>akademik/jurnalwali/getOptionSiswaByIdKelas/'+$(this).val();
							var append='#idsiswalaporan';
						}
						var obj=$(this);
						$.ajax({
							type: "POST",
							data: 'id_kelas='+$(this).val(),
							url: urll,
							beforeSend: function() {
								$(obj).after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
								//$("#subjectlist table.tabelkelas tbody").html("");
							},
							success: function(msg) {
								$("#wait").remove();
								$(append).html(msg);
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
						  id_kelas:{required:true,notEqual:'Pilih Kelas'},
						  subject:{required:true,notEqual:'Pilih Kelas'},
						  keterangan:{required:true,notEqual:''}
						  /*,message:{required:true,minlength:10}*/
						}
					});//Validate End

				});
				
				$("select#idsiswalaporan").change(function(e){
					//add_id_ortu()
				});
				
				function add_id_ortu(){
					$('input.id_ortu').remove();
					$("select#idsiswalaporan option").each(function(e){
						if($(this).prop("selected") && $(this).attr("value")!=''){ 
							$('select#idsiswalaporan').parent('td').append('<input id="id_ortu'+$(this).val()+'" class="id_ortu" type="hidden" name="id_ortu['+$(this).val()+']" value="'+$(this).attr("id_ortu")+'" />');
						}
					});
				}
				
				$("#kirimlaporan").submit(function(e){
					$frm = $(this);
					$id_kelas = $frm.find('*[name=id_kelas]').val();
					$subject = $frm.find('*[name=subject]').val();
					$keterangan = $frm.find('*[name=keterangan]').val();
					if($('select#idsiswalaporan').val()=='' || $('select#idsiswalaporan').val()==null){$('select#idsiswalaporan').css('border','1px solid red');return false;}else{$('select#idsiswalaporan').css('border','');}
					if($frm.find('*[name=id_kelas]').is('.valid') && $frm.find('*[name=keterangan]').is('.valid') && $frm.find('*[name=subject]').is('.valid')) {
						$.ajax({
							type: "POST",
							data: $(this).serialize(),
							url: $(this).attr('action'),
							beforeSend: function() {
								$(".simpanlaporan").after("<img id='wait' class='waitpenghub' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
							},
							success: function(msg) {
								$("#wait").remove();	
								
								ajaxupload("<? echo base_url();?>akademik/jurnalwali/uploadfilepenghubung/"+msg,"response","image-list","file");
								
								$.ajax({
									type: "POST",
									data: 'id_kelas='+$('select#kelaslaporan').val(),
									url: '<?=base_url('akademik/jurnalwali/penghubungortulist/0')?>',
									beforeSend: function() {
										$(".simpanlaporan").after("<img id='wait' class='waitpenghub' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
									},
									success: function(msg) {
										$(".waitpenghub").remove();
										$('select#idkelasp').val($('select#kelaslaporan').val());
										$('#listpenghub').html(msg);
										
										$('.listlap').show();
										$(this).children('a').addClass('current');
										$('#sendlap').children('a').removeClass('current');
										$('.sendlap').hide();
										
										$('#penghubungortu').scrollintoview({ speed:'1100'});
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
				<script type="text/javascript" src="<?=$this->config->item('js');?>upload.js"></script>
				<script type="text/javascript">
				function getadd(obj,date) {

				}
				</script>
				    <div class="hr"> </div>
                    <div class="clear"> </div>
					<h2 class="float-left" class="aktifitasakademik"> Buku Penghubung Ortu </h2>
                    
                    <div class="tabs-container">
                        <ul class="tabs-frame">
                            <li id="listlap"><a style="cursor:pointer;" class="current">Daftar Laporan</a></li>
                            <li id="sendlap"><a style="cursor:pointer;" >Kirim Laporan</a></li>
                            
                        </ul>
                        <div class="tabs-frame-content listlap">
							<form id="penghubunglist" method="post" action="">
							<table class="tabelfilter">
								<tbody>
									<tr>
										<td>
										Kelas :
											<select name="idkelasp" id="idkelasp">
												<option value="0">Pilih Kelas</option>
												<? foreach($kelaslaporan as $datakelas){?>
												<option <? if(@$_POST['kelas']==$datakelas['id']){echo 'selected';}?> value="<?=$datakelas['id']?>"><?//=$datakelas['kelas']?><?=$datakelas['nama']?></option>
												<? } ?>
											</select>
										</td>
									</tr>
								</tbody>
							</table>
							
							<input type="hidden" value="1" name="ajax">
							</form>
							<div id="listpenghub">
                            <table class="adddata lap">
									<tbody>
										<tr>
											<th>No</th>
											<th>Subject</th>
											<th>Keterangan</th>
											<th>Tindakan</th>
										</tr>
										<tr>
											<td width="1"></td>
											<td class="title" ></td>
											<td ></td>
											<td ></td>
										</tr>
									</tbody>
							</table>
							</div>
                        </div>
                        <div class="tabs-frame-content sendlap" style="display:none;">
                            <!-- **Respond Form** -->                      
							<div class="respond">
								<form method="post" name="kirimlaporan" enctype="multipart/form-data" id="kirimlaporan" action="<? echo base_url();?>akademik/jurnalwali/penghubungortu">
									<table class="adddata lap">
										<tbody>
										<tr>
											<th style="text-align:right;" colspan="4">
											<a onclick="$('#kirimlaporan').submit();" id="simpanlaporan" class=" simpanlaporan button small light-grey absenbutton" title=""> Kirim </a>
											</th>
										</tr>
										<tr>
											<td class="title" width="10">Kepada</td>
											<td>:</td>
											<td colspan="2">
												
												<select name="kepada[]" id="kepada" multiple>
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
													<option <? if(@$_POST['kelas']==$datakelas['id']){echo 'selected';}?> value="<?=$datakelas['id']?>"><?//=$datakelas['kelas']?><?=$datakelas['nama']?></option>
													<? } ?>
												</select>
											</td>
										</tr>
										<tr>
											<td class="title">Siswa</td>
											<td>:</td>
											<td>		
												
												<select multiple name="id_siswa[]" id="idsiswalaporan" style="max-width:250px;">
													<option value="">Pilih Siswa</option>
												</select>
											</td>
										    <td>
											<a style="cursor:pointer;" class="selall">Pilih Semua</a> |  
											<a style="cursor:pointer;" class="unsellall">Kosongkan</a>
											</td>
										</tr>
										<tr>
											<td class="title">Subject</td>
											<td>:</td>
											<td colspan="2">		
												<textarea style="width:98%; height:40px;" name="subject" cols="" rows=""></textarea>
											</td>
										</tr>
										<tr>
											<td class="title">Pesan SMS ke ortu</td>
											<td>:</td>
											<td colspan="2">		
												<textarea style="width:98%; height:100px;" maxlength="200" name="pesan" cols="" rows="" placeholder="Pesan ini akan dikirim ke Orang Tua / Wali Siswa melalui SMS. Max 200 Char"></textarea>
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
											<a onclick="$('#kirimlaporan').submit();" id="simpanlaporan" class="simpanlaporan button small light-grey absenbutton" title=""> Kirim </a>
											<a class="button small light-grey absenbutton cancellaporan" title=""> Cancel </a>
											</th>
										</tr>
										
									</tbody></table>


								<input type="hidden" value="1" name="ajax"> 

								<div style="display:none;" class="error-container"> Semua field harus di isi atau dipilih!  </div>
								</form>
								
							</div><!-- **Respond Form - End** --> 
                        </div>
                    </div>    