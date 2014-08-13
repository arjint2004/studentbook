				<script>
				$(document).ready(function(){
						$("#kelasListotentik option").first().remove();
						$.ajax({
							type: "POST",
							data: $("form#filterpelajaranlistOtentik").serialize(),
							url: '<?=base_url()?>admin/pelajaran/getMapelByKelasAndPegawai/'+$('select#kelasListotentik').val(),
							beforeSend: function() {
								$("#filterpelajaranlistOtentik select#kelasListotentik").after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
								$("#subjectnilaiotentiklist table.tabelkelas tbody").html("");
							},
							success: function(msg) {
								$("#wait").remove();
								$("#pelajaranlistotentik").html(msg);
								$("#pelajaranlistotentik option").first().remove();
								
								$.ajax({
									type: "POST",
									data: $("form#filterpelajaranlistOtentik").serialize(),
									url: '<?=base_url()?>akademik/nilaiotentik/nilai',
									beforeSend: function() {
										$("#filterpelajaranlistOtentik select#pelajaranlistotentik").after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
									},
									success: function(msg) {
										$("#wait").remove();
										$("#subjectnilaiotentiklist").html(msg);	
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
						$.ajax({
							type: "POST",
							data: $("form#filterpelajaranlistOtentik").serialize(),
							url: '<?=base_url()?>admin/pelajaran/getMapelByKelasAndPegawai/'+$(this).val(),
							beforeSend: function() {
								$("#filterpelajaranlistOtentik select#kelasListotentik").after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
								$("#subjectnilaiotentiklist table.tabelkelas tbody").html("");
							},
							success: function(msg) {
								$("#wait").remove();
								$("#pelajaranlistotentik").html(msg);	
							}
						});
						return false;
					});//Submit End
					$("#filterpelajaranlistOtentik select#pelajaranlistotentik").change(function(e){
						$.ajax({
							type: "POST",
							data: $("form#filterpelajaranlistOtentik").serialize(),
							url: '<?=base_url()?>akademik/nilaiotentik/nilai',
							beforeSend: function() {
								$("#filterpelajaranlistOtentik select#pelajaranlistotentik").after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
							},
							success: function(msg) {
								$("#wait").remove();
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
							<table class="tabelfilter">
								<tr>
								<td>
									Kelas :
										<select class="selectfilter" id="kelasListotentik" name="id_kelas">
											<option value="">Pilih Kelas</option>
											<? foreach($kelas as $datakelas){?>
											<option <? if(@$_POST['kelas']==$datakelas['id']){echo 'selected';}?> value="<?=$datakelas['id']?>"><?=$datakelas['kelas']?><?=$datakelas['nama']?></option>
											<? } ?>
										</select>

									
									Pelajaran :
										<select class="selectfilter" id="pelajaranlistotentik" name="pelajaran">
											<? foreach($pelajaran as $datapelajaran){?>
											<option <? if(@$_POST['pelajaran']==$datapelajaran['id']){echo 'selected';}?> value="<?=$datapelajaran['id']?>"><?=$datapelajaran['nama']?></option>
											<? } ?>
										</select>
										<input type="hidden" name="jenis" value="<?=$jenis?>" />
									</td>
								</tr>
							</table>
							<input type="hidden" name="ajax" value="1" />
							</form>
							<div id="subjectnilaiotentiklist"></div>
					</div>