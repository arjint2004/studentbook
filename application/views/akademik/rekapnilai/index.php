				<script>
				$(document).ready(function(){

					
					$("#filterpelajaran select#kelas").change(function(e){
						$.ajax({
							type: "POST",
							data: $("form#filterpelajaran").serialize(),
							url: '<?=base_url()?>admin/pelajaran/getMapelByKelasAndPegawai/'+$(this).val(),
							beforeSend: function() {
								$("#filterpelajaran select#kelas").after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
								$("#subjectlistrekapnilai table.tabelkelas tbody").html("");
							},
							success: function(msg) {
								$("#wait").remove();
								$("#pelajaranrekapnilai").html(msg);	
							}
						});
						return false;
					});//Submit End
					$("#filterpelajaran select#pelajaranrekapnilai").change(function(e){
						$.ajax({
							type: "POST",
							data: $("form#filterpelajaran").serialize(),
							url: '<?=base_url()?>akademik/rekapnilai/rekapnilailist',
							beforeSend: function() {
								$("#filterpelajaran select#pelajaranrekapnilai").after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
							},
							success: function(msg) {
								$("#wait").remove();
								$("#subjectlistrekapnilai").html(msg);	
							}
						});
						return false;
					});//Submit End

				
				});

				</script>
				<h3>Rekapitulasi Nilai</h3>
				<div class="hr"></div>
				
				<div id="contentpage">
							<form action="" method="post" id="filterpelajaran" >
							<table class="tabelfilter">
								<tr>
								<td>
									Kelas :
										<select class="selectfilter" id="kelas" name="id_kelas">
											<option value="0">Pilih Kelas</option>
											<? foreach($kelas as $datakelas){?>
											<option <? if(@$_POST['kelas']==$datakelas['id']){echo 'selected';}?> value="<?=$datakelas['id']?>"><?=$datakelas['kelas']?><?=$datakelas['nama']?></option>
											<? } ?>
										</select>

									
									Pelajaran :
										<select class="selectfilter" id="pelajaranrekapnilai" name="pelajaran">
											<option value="0">Pilih Pelajaran</option> 
											<? foreach($pelajaran as $datapelajaran){?>
											<option <? if(@$_POST['pelajaran']==$datapelajaran['id']){echo 'selected';}?> value="<?=$datapelajaran['id']?>"><?=$datapelajaran['nama']?></option>
											<? } ?>
										</select>
									</td>
								</tr>
							</table>
							<input type="hidden" name="ajax" value="1" />
							</form>
							<div id="subjectlistrekapnilai">
								
							</div>
					</div>