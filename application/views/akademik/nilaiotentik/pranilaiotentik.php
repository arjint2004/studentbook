				<script>
				$(document).ready(function(){
						$("#kelasListotentik option").first().remove();
						$.ajax({
							type: "POST",
							data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&'+$("form#filterpelajaranlistOtentik").serialize(),
							url: '<?=base_url()?>admin/pelajaran/getMapelByKelasAndPegawai/'+$('select#kelasListotentik').val()+'/0/1',
							beforeSend: function() {
								$("#filterpelajaranlistOtentik select#kelasListotentik").after("<img class='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
								$("#subjectnilaiotentiklist table.tabelkelas tbody").html("");
							},
							success: function(msg) {
								$(".wait").remove();
								$("#pelajaranlistotentik").html(msg);
								//$("#pelajaranlistotentik option").first().remove();
								
								$.ajax({
									type: "POST",
									data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&id_kelas='+$('select#kelasListotentik').val(),
									url: '<?=base_url()?>akademik/nilaiotentik/getOptionSiswaByIdKelas',
									beforeSend: function() {
										$("#filterpelajaranlistOtentik select#id_det_jenjang_otentik").after("<img class='wait' style='float:left;' src='<?=$this->config->item('images').'loading.png';?>' />");
									},
									success: function(msg) {
										$(".wait").remove();
										$("#id_det_jenjang_otentik").html(msg);	
										$.ajax({
											type: "POST",
											data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&'+$("form#filterpelajaranlistOtentik").serialize(),
											url: '<?=base_url()?>akademik/nilaiotentik/nilai',
											beforeSend: function() {
												$("#filterpelajaranlistOtentik select#pelajaranlistotentik").after("<img class='wait' style='float:left;' src='<?=$this->config->item('images').'loading.png';?>' />");
											},
											success: function(msg) {
												$(".wait").remove();
												$("#subjectnilaiotentiklist").html(msg);
											}
										});
									
									}
								});

								return false;
							}
						});

					//Submit Start
					$(".editdata").click(function(e){
						$('#ajaxside').load('<?=base_url()?>admin/pelajaran/editData/'+$(this).attr('id'));
					});
					
					$("form#filterpelajaranlistOtentik select#kelasListotentik").change(function(e){
						var ob=$(this);
						$.ajax({
							type: "POST",
							data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&'+$("form#filterpelajaranlistOtentik").serialize(),
							url: '<?=base_url()?>admin/pelajaran/getMapelByKelasAndPegawai/'+$(this).val()+'/0/1',
							beforeSend: function() {
								$("#filterpelajaranlistOtentik select#kelasListotentik").after("<img class='wait' style='float:left;' src='<?=$this->config->item('images').'loading.png';?>' />");
							},
							success: function(msg) {
								$(".wait").remove();
								$("#pelajaranlistotentik").html(msg);
								$.ajax({
									type: "POST",
									data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&id_kelas='+$(ob).val(),
									url: '<?=base_url()?>akademik/nilaiotentik/getOptionSiswaByIdKelas',
									beforeSend: function() {
										$("#filterpelajaranlistOtentik select#id_det_jenjang_otentik").after("<img class='wait' style='float:left;' src='<?=$this->config->item('images').'loading.png';?>' />");
									},
									success: function(msg) {
										$(".wait").remove();
										$("#id_det_jenjang_otentik").html(msg);	
										$.ajax({
											type: "POST",
											data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&'+$("form#filterpelajaranlistOtentik").serialize(),
											url: '<?=base_url()?>akademik/nilaiotentik/nilai',
											beforeSend: function() {
												$("form#filterpelajaranlistOtentik select#id_det_jenjang_otentik").after("<img class='wait' style='float:left;' src='<?=$this->config->item('images').'loading.png';?>' />");
											},
											success: function(msg) {
												$(".wait").remove();
												$("#subjectnilaiotentiklist").html(msg);	
											}
										});
									}
								});								
							}
						});


						return false;
					});//Submit End
					$("#filterpelajaranlistOtentik select#pelajaranlistotentik").change(function(e){
						$.ajax({
							type: "POST",
							data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&'+$("form#filterpelajaranlistOtentik").serialize(),
							url: '<?=base_url()?>akademik/nilaiotentik/nilai',
							beforeSend: function() {
								$("#filterpelajaranlistOtentik select#pelajaranlistotentik").after("<img class='wait' style='float:left;' src='<?=$this->config->item('images').'loading.png';?>' />");
							},
							success: function(msg) {
								$(".wait").remove();
								$("#subjectnilaiotentiklist").html(msg);	
							}
						});
						return false;
					});//Submit End
					$("form#filterpelajaranlistOtentik select#id_det_jenjang_otentik").change(function(e){
						$.ajax({
							type: "POST",
							data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&'+$("form#filterpelajaranlistOtentik").serialize(),
							url: '<?=base_url()?>akademik/nilaiotentik/nilai',
							beforeSend: function() {
								$("form#filterpelajaranlistOtentik select#id_det_jenjang_otentik").after("<img class='wait' style='float:left;' src='<?=$this->config->item('images').'loading.png';?>' />");
							},
							success: function(msg) {
								$(".wait").remove();
								$("#subjectnilaiotentiklist").html(msg);	
							}
						});
						return false;
					});//Submit End
				});
				</script>
				<h3 id="namanilai"><?=$jenis?></h3>
				<div class="hr"></div>
				
				<div id="contentpage">
							<form action="" method="post" id="filterpelajaranlistOtentik" >
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
							<table class="tabelfilter">
								<tr>
								<td style="text-align:left;">KELAS</td>
								<td>
									<select style="margin:0; float:left;" class="selectfilter" id="kelasListotentik" name="id_kelas">
										<option value="">Pilih Kelas</option>
										<? foreach($kelas as $datakelas){?>
											<option <? if(@$_POST['kelas']==$datakelas['id']){echo 'selected';}?> value="<?=$datakelas['id']?>"><?=$datakelas['kelas']?><?=$datakelas['nama']?></option>
										<? } ?>
									</select>
								</td>
								</tr>
								<tr>
								<td style="text-align:left;">PELAJARAN</td>
								<td>
									<select style="margin:0; float:left;" class="selectfilter" id="pelajaranlistotentik" name="pelajaran"></select>
								</td>
								</tr>
								<tr>
								<td style="text-align:left;">SISWA</td>
								<td>
									<select style="margin:0; float:left;" class="selectfilter" id="id_det_jenjang_otentik" name="id_det_jenjang">
										<option value="">Pilih Siswa</option>
									</select>
									<input type="hidden" name="jenis" value="<?=$jenis?>" />
								</td>
								</tr>
							</table>
							<input type="hidden" name="ajax" value="1" />
							</form>
							<div id="subjectnilaiotentiklist"></div>
					</div>