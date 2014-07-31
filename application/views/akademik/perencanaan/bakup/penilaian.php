								<script>
									$(document).ready(function(){
										//Submit Start

										
										$("table tr td a.readmore").click(function(){
											var tr='<tr>'+$("table tr#master").html()+'</tr>';
											$("table tr#beforeadd").before(tr);
											return false;
										});
										
										$("#catatangurudataform").submit(function(e){
											$.ajax({
												type: "POST",
												data: $(this).serialize()+'&simpan=true'+'&'+$('form#catatanguruform').serialize()+'&tanggal='+$('input#datekirimcatatanguru').val(),
												url: $(this).attr('action'),
												beforeSend: function() {
													$("#simpancatatan").after("<img id='wait' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
												},
												success: function(msg) {
													$("#wait").remove();	
													//$('#subject').load('<? echo base_url();?>akademik/materi/index');
												}
											});
											return false;
										});
									});

									function up(thisobj){
										var poin=$(thisobj).prev().val();
										poin=parseInt(poin)+1;
										if(poin<10){
											$(thisobj).prev().val(poin);
										}
									}
									function down(thisobj){
										var poin=$($(thisobj).prev()).prev().val();
										poin=poin-1;
										if(poin>=1){
											$($(thisobj).prev()).prev().val(poin);
										}
									}
									
									function hapus(thisobj){
										$(thisobj).parent('td').parent('tr').remove();
										return false;
									}
									function hapusdata(thisobj,id){
										if(confirm('Data catatan guru akan dihapus. klik "OK" untuk menghapus. Klik cancel untuk batal. ')){
											$.ajax({
													type: "POST",
													data: '',
													url: base_url+'akademik/catatanguru/delete/'+id,
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
										<td>
											<select name="data[penilaian][]">
												<option value="">Pilih Penilaian</option>
												<option value="kognitif">Kognitif</option>
												<option value="afektif">Afektif</option>
												<option value="psikomotorik">Psikomotorik</option>
											</select>
										</td>
										<td ><textarea style="height:30px;" cols="30" name="data[apresiasi][]" ></textarea></td>
										<td >
											
													<div style="position:relative;">
														<input class="poin" type="text" id="poin" style="border-radius:0;" name="data[poin][]" value="5">
														<span class="arrow-n2 up" onclick="up(this)"></span>
														<span class="arrow-s2 down" onclick="down(this)"></span>
													</div>
										</td>
										<td ><a class="button small light-grey" onclick="hapus(this);" title="Hapus baris ini"> <span> Hapus </span> </a></td>
									</tr>
								</table>
								
								<form action="<?=base_url()?>akademik/perencanaan/penilaian" method="post" id="catatangurudataform" style="width:768px;height:100%;">
								<table>
									<tbody>
										<tr>
											<td>
												<b>PENILAIAN DAN PENGAMATAN ASPEK YANG DIAMATI</b>
											</td>
										</tr>
									</tbody>
								</table>
								<table id="data">
										<thead>
											<tr>
												<th  colspan="4" style="text-align:right;">
													<a title="" class="button small light-grey absenbutton" id="simpancatatan" onclick="$('#catatangurudataform').submit();"> Simpan </a>
												</th>
											</tr>
											<tr>     
												<th>Penilaian</th>
												<th>Aspek yang diamati</th>
												<th style="width:70px;">Nilai</th>
												<th class="action">Action</th>
											</tr>                         
										</thead>
										<tbody>
											<tr >
											<td>
												<select name="data[penilaian][]">
													<option value="">Pilih Penilaian</option>
													<option selected value="kognitif">Kognitif</option>
													<option value="afektif">Afektif</option>
													<option value="psikomotorik">Psikomotorik</option>
												</select>
											</td>
											<td ><textarea style="height:30px;" cols="30" name="data[apresiasi][]" ></textarea></td>
											<td >
												
														<div style="position:relative;">
															<input class="poin" type="text" id="poin" style="border-radius:0;" name="data[poin][]" value="5">
															<span class="arrow-n2 up" onclick="up(this)"></span>
															<span class="arrow-s2 down" onclick="down(this)"></span>
														</div>
											</td>
											<td ><a class="button small light-grey" onclick="hapus(this);" title="Hapus baris ini"> <span> Hapus </span> </a></td>
											</tr>
											<tr >
											<td>
												<select name="data[penilaian][]">
													<option value="">Pilih Penilaian</option>
													<option value="kognitif">Kognitif</option>
													<option  selected value="afektif">Afektif</option>
													<option value="psikomotorik">Psikomotorik</option>
												</select>
											</td>
											<td ><textarea style="height:30px;" cols="30" name="data[apresiasi][]" ></textarea></td>
											<td >
												
														<div style="position:relative;">
															<input class="poin" type="text" id="poin" style="border-radius:0;" name="data[poin][]" value="5">
															<span class="arrow-n2 up" onclick="up(this)"></span>
															<span class="arrow-s2 down" onclick="down(this)"></span>
														</div>
											</td>
											<td ><a class="button small light-grey" onclick="hapus(this);" title="Hapus baris ini"> <span> Hapus </span> </a></td>
											</tr>
											<tr >
											<td>
												<select name="data[penilaian][]">
													<option value="">Pilih Penilaian</option>
													<option value="kognitif">Kognitif</option>
													<option value="afektif">Afektif</option>
													<option  selected value="psikomotorik">Psikomotorik</option>
												</select>
											</td>
											<td ><textarea style="height:30px;" cols="30" name="data[apresiasi][]" ></textarea></td>
											<td >
												
														<div style="position:relative;">
															<input class="poin" type="text" id="poin" style="border-radius:0;" name="data[poin][]" value="5">
															<span class="arrow-n2 up" onclick="up(this)"></span>
															<span class="arrow-s2 down" onclick="down(this)"></span>
														</div>
											</td>
											<td ><a class="button small light-grey" onclick="hapus(this);" title="Hapus baris ini"> <span> Hapus </span> </a></td>
											</tr>
											<tr id="beforeadd">
												<td align="right" colspan="4"><a href="" style="float:right;" title="" id="catatanguru" class="readmore"> Tambah Catatan</a></td>
											</tr>
										</tbody>
								</table>
								</form>