			<script>
				/*js for kelas start*/
				function isNumber(value) {
					if ((undefined === value) || (null === value)) {
						return false;
					}
					if (typeof value == 'number') {
						return true;
					}
					return !isNaN(value - 0);
				}

				function isInteger(value) {
					if ((undefined === value) || (null === value)) {
						return false;
					}
					return value % 1 == 0;
				}
				$(document).ready(function(){
					$('table#formulasi input[type="text"]').keyup(function(){
						var totpersen=parseInt($('table#formulasi input#pr[type="text"]').val())+parseInt($('table#formulasi input#tugas[type="text"]').val())+parseInt($('table#formulasi input#harian[type="text"]').val())+parseInt($('table#formulasi input#uas[type="text"]').val())+parseInt($('table#formulasi input#uts[type="text"]').val());
						var maxthis=100-(totpersen-parseInt($(this).val()));
						//$('div#rumus').html(maxthis);
						if($(this).val()>maxthis){
							alert('Maximal prosentase harus '+maxthis);
							$(this).val(maxthis);
							//return false;
						}
						var thisobj=$(this);
						//alert($(this).val());
						if($(this).val()==''){
							alert('Harus di isi');
							return false;
						}
						if($(this).val()>100){
							alert('Tidak boleh lebih dari 100');
							$(this).val('');
							return false;
						}
						if($(this).val()<0){
							alert('Tidak boleh kurang dari 0');
							$(this).val('');
							return false;
						}
						//if(!isNumber($(this).val())){
							//alert('Harus angka');
						//}
						if(!isInteger($(this).val())){
							alert('Harus angka Positif');
							$(this).val('');
							return false;
						}
						$(this).focus();
						$.ajax({
							type: "POST",
							data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&'+$('form#formulasiform').serialize()+'&ajax=1',
							url: base_url+'admin/schooladmin/formulasinilaiakhir',
							beforeSend: function() {
								$('img#wait').remove();
								$(thisobj).next().append("<img  id='wait' src='"+config_images+"loading.png' />");
							},
							success: function(msg) {
								$('img#wait').remove();
								//$('div#contentpage').html(msg);
								$(thisobj).focus()
							}
					});
					})
				});
				
				/*js for kelas end*/
			</script>	  	 	 		

				<div id="contentpage">
				<form id="formulasiform">
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
							<div id="rumus"></div>
							<table class="tabelkelas" id="formulasi">
								<thead>
									<tr> 
										<th colspan="3">  <strong>Prosentase Formulasi Nilai (%)</strong></th>
									</tr>                            
								</thead>
								<tbody>
								
									<tr>
										<td class="title" width="30%">Pr (Pekerjaan Rumah)</td>
										<td width="1%">:</td>
										<td>
											<input type="text" id="pr" style="width:50px; float:left;" name="formulasi[nilai_pr]" value="<?=$bobot['nilai pr']['prosentase']?>"/><div style='float: left; position: relative; top: 16px; font-weight: bold; margin-left: 5px;'>%</div>
										</td>
									</tr>
									<tr>
										<td class="title" width="30%">Tugas</td>
										<td width="1%">:</td>
										<td>
											<input type="text" id="tugas" style="width:50px; float:left;" name="formulasi[nilai_tugas]" value="<?=$bobot['nilai tugas']['prosentase']?>"/><div style='float: left; position: relative; top: 16px; font-weight: bold; margin-left: 5px;'>%</div>
										</td>
									</tr>
									<tr>
										<td class="title" width="30%">Ulangan Harian</td>
										<td width="1%">:</td>
										<td>
											<input type="text" id="harian" style="width:50px; float:left;" name="formulasi[nilai_ulangan_harian]" value="<?=$bobot['nilai ulangan harian']['prosentase']?>"/><div style='float: left; position: relative; top: 16px; font-weight: bold; margin-left: 5px;'>%</div>
										</td>
									</tr>
									<tr>
										<td class="title" width="30%">Ujian Tengah Semester</td>
										<td width="1%">:</td>
										<td>
											<input type="text" id="uts" style="width:50px; float:left;" name="formulasi[nilai_uts]" value="<?=$bobot['nilai uts']['prosentase']?>"/><div style='float: left; position: relative; top: 16px; font-weight: bold; margin-left: 5px;'>%</div>
										</td>
									</tr>
									<tr>
										<td class="title" width="30%">Ujian Akhir Semester</td>
										<td width="1%">:</td>
										<td>
											<input type="text" id="uas" style="width:50px; float:left;" name="formulasi[nilai_uas]" value="<?=$bobot['nilai uas']['prosentase']?>"/><div style='float: left; position: relative; top: 16px; font-weight: bold; margin-left: 5px;'>%</div>
										</td>
									</tr>
								</tbody>
							</table>
							</form>
					</div>