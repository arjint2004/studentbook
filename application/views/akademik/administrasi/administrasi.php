<script>
				$(document).ready(function(){
					//Submit Start
					$(".editdataadministrasi").click(function(e){
						$('#ajaxside').load('<?=base_url()?>admin/pelajaran/editdataadministrasi/'+$(this).attr('id'));
					});
					
					$("#filterpelajaranadministrasi select#kelas").change(function(e){
						$.ajax({
							type: "POST",
							data: $("form#filterpelajaranadministrasi").serialize(),
							url: '<?=base_url()?>admin/pelajaran/getMapelByKelasAndPegawai/'+$(this).val(),
							beforeSend: function() {
								$("#filterpelajaranadministrasi select#kelas").after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
								$("#subjectlist table.tabelkelas tbody").html("");
							},
							success: function(msg) {
								$("#wait").remove();
								$("#pelajaran").html(msg);	
							}
						});
						return false;
					});//Submit End
					$("#filterpelajaranadministrasi select#pelajaran").change(function(e){
						$.ajax({
							type: "POST",
							data: $("form#filterpelajaranadministrasi").serialize(),
							url: '<?=base_url()?>akademik/administrasi/administrasilist',
							beforeSend: function() {
								$("#filterpelajaranadministrasi select#pelajaran").after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
							},
							success: function(msg) {
								$("#wait").remove();
								$("#subjectlist").html(msg);	
							}
						});
						return false;
					});//Submit End
					$("#administrasiaddtmbh").click(function(){
						$.ajax({
							type: "POST",
							data: $('form#filterpelajaranadministrasi').serialize(),
							url: '<?=base_url()?>akademik/administrasi/addadministrasi',
							beforeSend: function() {
								$("#administrasiaddtmbh").append("<img id='wait' src='<?=$this->config->item('images').'loaderhover.gif';?>' />");
							},
							success: function(msg) {
								$("#wait").remove();
								$("#subjectlist").html(msg);	
							}
						});
						return false;
					});//Submit End
					
				$.ajax({
					type: "POST",
					data: $("form#filterpelajaranadministrasi").serialize(),
					url: '<?=base_url()?>akademik/administrasi/administrasilist',
					beforeSend: function() {
						$("#filterpelajaranadministrasi select#pelajaran").after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
					},
					success: function(msg) {
						$("#wait").remove();
						$("#subjectlist").html(msg);	
					}
				});
				});

				</script>
				<h3><?=$jenis?></h3>
				<div class="hr"></div>
				
				<div id="contentpage">
							<form action="" method="post" id="filterpelajaranadministrasi" >
							<table class="tabelfilter">
								<tr>
								<td>
									Kelas :
										<select class="selectfilter" id="kelas" name="id_kelas">
											<option value="">Pilih Kelas</option>
											<? foreach($kelas as $datakelas){?>
											<option <? if(@$_POST['kelas']==$datakelas['id']){echo 'selected';}?> value="<?=$datakelas['id']?>"><?=$datakelas['kelas']?><?=$datakelas['nama']?></option>
											<? } ?>
										</select>

									
									Pelajaran :
										<select class="selectfilter" id="pelajaran" name="pelajaran">
											<option value="">Pilih Pelajaran</option>
											<? foreach($pelajaran as $datapelajaran){?>
											<option <? if(@$_POST['pelajaran']==$datapelajaran['id']){echo 'selected';}?> value="<?=$datapelajaran['id']?>"><?=$datapelajaran['nama']?></option>
											<? } ?>
										</select>
										<a id="administrasiaddtmbh" title="" class="readmore"> <i><b>Tambahkan Data</b></i> <br />  </a>
										<a id="downloadtemp" title="" class="readmore"> <i><b>Download Template</b></i> <br />  </a>
									</td>
								</tr>
							</table>
							<input type="hidden" name="jenis" value="<?=$jenis?>" />
							<input type="hidden" name="ajax" value="1" />
							</form>
							<div id="subjectlist">
								<?php //$this->load->view('akademik/administrasi/daftaradministrasilist'); ?>
							</div>
					</div>