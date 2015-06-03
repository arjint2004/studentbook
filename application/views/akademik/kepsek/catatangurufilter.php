<script>		function getdisabled(){
						//$("table#data tr td select.aspek").each(function() {
							$("table#data tr td select.aspek").attr('disabled', 'disabled');
							$("table#data tr td textarea").attr('disabled', 'disabled');
							$("table#data tr th.action").remove();
							$("table#data tr td.action").remove();
							$("a#simpancatatan").parent('th').parent('tr').remove();
							$("a#catatanguru").remove();
						//});
				}
				$(document).ready(function(){
					//Submit Start
					$(".editdatacatatanguru").click(function(e){
						$('#ajaxside').load('<?=base_url()?>admin/siswa/editdatacatatanguru/'+$(this).attr('id'));
					});

					$("#catatanguruform select#kelas").change(function(e){
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
								$("#siswa").html(msg);	
							}
						});
						return false;
					});//Submit End
					$("#catatanguruform select#siswa").change(function(e){
						$.ajax({
							type: "POST",
							data: $("form#catatanguruform").serialize(),
							url: '<?=base_url()?>akademik/catatanguru/catatangurulist',
							beforeSend: function() {
								$("#catatanguruform select#siswa").after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
							},
							success: function(msg) {
								$("#wait").remove();
								$("#subjectlist").html(msg);		
								
								getdisabled();
							}
						});
						return false;
					});//Submit End

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
								$("#catatanguruform select#siswa").after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
							},
							success: function(msg) {
								$("#wait").remove();
								$("#subjectlist").html(msg);			
								$("a#simpancatatan").parent('th').parent('tr').remove();
								$("a#catatanguru").remove();	
								getdisabled();
							}
						});
						return false;	
					}
				$(function() {
					$('#datekirimcatatanguru').datepick();
				});
				</script>
				
				<div id="contentpage">
							<form action="" method="post" id="catatanguruform" >
							<table class="tabelfilter">
								<tr>
								<td>
									Kelas :
										<select class="selectfilter" id="kelas" name="id_kelas">
											<option value="">Pilih Kelas</option>
											<? foreach($kelas as $datakelas){?>
											<option <? if(@$_POST['kelas']==$datakelas['id']){echo 'selected';}?> value="<?=$datakelas['id']?>"><?//=$datakelas['kelas']?><?=$datakelas['nama']?></option>
											<? } ?>
										</select>
									Siswa :
										<select class="selectfilter" id="siswa" style="width:240px;" name="id_siswa_det_jenjang">
											<option value="">Pilih Siswa</option>
										</select>
									Tanggal :
										<input type="text" style="width:100px; float:right;height:25px;" value="<? if(isset($timelinepembelajaran[0]['tanggal'])){echo $timelinepembelajaran[0]['tanggal'];}else{ echo date("Y-m-d");}?>" id="datekirimcatatanguru">
									</td>
								</tr>
							</table>
							<input type="hidden" name="ajax" value="1" />
							</form>
							<div id="subjectlist">
								<?php //$this->load->view('akademik/catatanguru/daftarcatatangurulist'); ?>
							</div>
					</div>