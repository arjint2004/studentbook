
 <!-- **Respond Form** -->                      
							<div class="respond">
								<form method="post" name="kirimlaporan" enctype="multipart/form-data" id="kirimlaporan" action="<? echo base_url();?>akademik/jurnalwali/penghubungortu">
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