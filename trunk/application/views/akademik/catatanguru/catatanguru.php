<script>
				$(document).ready(function(){
					//Submit Start
					$(".editdatacatatanguru").click(function(e){
						$('#ajaxside').load('<?=base_url()?>admin/siswa/editdatacatatanguru/'+$(this).attr('id'));
					});
					
					$("#catatanguruform select#kelas").change(function(e){
						$(this).after('<input type="hidden" name="kelasnya" value="'+$(this).find(":selected").text()+'"/>');
						$.ajax({
							type: "POST",
							data: $("form#catatanguruform").serialize(),
							url: '<?=base_url()?>akademik/catatanguru/getOptionSiswaByIdKelas/'+$(this).val(),
							beforeSend: function() {
								$("#catatanguruform select#kelas").after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
								//$("#subjectlist table.tabelkelas tbody").html("");
							},
							success: function(msg) {
								$("#wait").remove();
								$("#siswacatatan").html(msg);	
							}
						});
						return false;
					});//Submit End

					$("#catatanguruform select#siswacatatan").change(function(e){
						$(this).after('<input type="hidden" name="siswanya" value="'+$(this).find(":selected").text()+'"/>');
						$.ajax({
							type: "POST",
							data: $("form#catatanguruform").serialize(),
							url: '<?=base_url()?>akademik/catatanguru/catatangurulist',
							beforeSend: function() {
								$("#catatanguruform select#siswacatatan").after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
							},
							success: function(msg) {
								$("#wait").remove();
								$("#subjectlist").html(msg);
								$.ajax({
									type: "POST",
									data: $("form#catatanguruform").serialize(),
									url: '<?=base_url()?>akademik/kepribadian/kepribadianlist',
									beforeSend: function() {
										$("#catatanguruform select#siswacatatan").after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
									},
									success: function(msg) {
										$("#wait").remove();
										$("#subjectlist").append(msg);	
										$("#kepribadiandataform").append('<input type="hidden" name="id_siswa_det_jenjang" value="'+$("#siswacatatan").val()+'" />');	
										$("#kepribadiandataform").before('<h3>Point kepribadian</h3><div class="hr"></div>');	
										
									}
								});	
							}
						});
						
						return false;
					});//Submit End
					$(".exportexcellcatatang").click(function(){
						$('form#catatanguruform').attr('action','<?=base_url()?>akademik/export');
						$('form#catatanguruform').attr('target','_blank');
						$('form#catatanguruform').submit();
					});
				});

				</script>
				<link type="text/css" href="<?=$this->config->item('css');?>datepick.css" rel="stylesheet">
				<script type="text/javascript" src="<?=$this->config->item('js');?>jquery.datepick.js"></script>
				<script type="text/javascript" src="<?=$this->config->item('js');?>jquery.datepick-id.js"></script>

				<script type="text/javascript">
					function getadd(obj,date) {
						$.ajax({
							type: "POST",
							data: $("form#catatanguruform").serialize()+"&tanggal="+date,
							url: '<?=base_url()?>akademik/catatanguru/catatangurulist',
							beforeSend: function() {
								$("#catatanguruform select#siswacatatan").after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
							},
							success: function(msg) {
								$("#wait").remove();
								$("#subjectlist").html(msg);	
							}
						});
						return false;	
					}
				$(function() {
					$('#datekirimcatatanguru').datepick();
				});
				</script>
				<h3>catatan guru</h3>
				<div class="hr"></div>
				
				<div id="contentpage">
							<form action="" method="post" id="catatanguruform" >
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

									
									Siswa :
										<select class="selectfilter" id="siswacatatan" name="id_siswa_det_jenjang">
											<option value="">Pilih Siswa</option>
										</select>
									Tanggal :
										<input type="text" style="width:100px;" value="<? if(isset($timelinepembelajaran[0]['tanggal'])){echo $timelinepembelajaran[0]['tanggal'];}else{ echo date("Y-m-d");}?>" id="datekirimcatatanguru" name="tanggal">
									<a  style="padding:5px;" class="readmore exportexcellcatatang"><img height="30" src="<?=$this->config->item('images')?>/Excel-icon.png" style="margin:0;" /> Export</a>
										<input type="hidden" name="jenis" value="Catatan_Guru" />
										<input type="hidden" name="fileName" value="Catatan_Guru" />
									</td>
								</tr>
							</table>
							<input type="hidden" name="ajax" value="1" />
							</form>
							<div id="subjectlist">
								<?php //$this->load->view('akademik/catatanguru/daftarcatatangurulist'); ?>
							</div>
					</div>