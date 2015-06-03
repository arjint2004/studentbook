<script>
				$(document).ready(function(){
					//Submit Start
					$(".editdatapembelajaran").click(function(e){
						$('#ajaxside').load('<?=base_url()?>admin/pelajaran/editdatapembelajaran/'+$(this).attr('id'));
					});
					
					$("#filterpelajaranpembelajaran select#kelas").change(function(e){
						$(this).after('<input type="hidden" name="kelasnya" value="'+$(this).find(":selected").text()+'"/>');
						$.ajax({
							type: "POST",
							data: $("form#filterpelajaranpembelajaran").serialize(),
							url: '<?=base_url()?>akademik/instrumen/getPertemuanByKelas/'+$(this).val(),
							beforeSend: function() {
								$("#filterpelajaranpembelajaran select#kelas").after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
								$("#subjectlist table.tabelkelas tbody").html("");
							},
							success: function(msg) {
								$("#wait").remove();
								$("#pertemuanselect").html(msg);	
							}
						});
						return false;
					});//Submit End
					$("#filterpelajaranpembelajaran select#pertemuanselect").change(function(e){
						$(this).after('<input type="hidden" name="pertemuannya" value="'+$(this).find(":selected").text()+'"/>');
						$.ajax({
							type: "POST",
							data: $("form#filterpelajaranpembelajaran").serialize()+'&id_pelajaran='+$('#filterpelajaranpembelajaran select#pertemuanselect :selected').attr('id_pelajaran'),
							url: '<?=base_url()?>akademik/instrumen/pembelajaranlist/'+$(this).val(),
							beforeSend: function() {
								$("#filterpelajaranpembelajaran select#pertemuanselect").after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
							},
							success: function(msg) {
								$("#wait").remove();
								$("#subjectlist").html(msg);	
							}
						});
						return false;
					});//Submit End
					$("#pembelajaranaddtmbh").click(function(){
						$.ajax({
							type: "POST",
							data: '',
							url: '<?=base_url()?>akademik/instrumen/addpembelajaran',
							beforeSend: function() {
								$("#pembelajaranaddtmbh").append("<img id='wait' src='<?=$this->config->item('images').'loaderhover.gif';?>' />");
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
							data: 'ajax=1',
							url: '<?=base_url()?>akademik/instrumen/pembelajaranlist',
							beforeSend: function() {
								$("#filterpelajaranpembelajaran select#pertemuanselect").after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
							},
							success: function(msg) {
								$("#wait").remove();
								$("#subjectlist").html(msg);	
							}
						});
						
						
					$(".exportexcellpemb").click(function(){
						$('form#filterpelajaranpembelajaran').attr('action','<?=base_url()?>akademik/export');
						$('form#filterpelajaranpembelajaran').submit();
					});
				});

				</script>
				<h3>Rencana Pembelajaran</h3>
				<div class="hr"></div>
				
				<div id="contentpage">
							<form action="" method="post" id="filterpelajaranpembelajaran" >
							<table class="tabelfilter">
								<tr>
								<td>
									Kelas :
										<select class="selectfilter" id="kelas" name="id_kelas">
											<option value="0">Pilih Kelas</option>
											<? foreach($kelas as $datakelas){?>
											<option <? if(@$_POST['kelas']==$datakelas['id']){echo 'selected';}?> value="<?=$datakelas['id']?>"><?//=$datakelas['kelas']?><?=$datakelas['nama']?></option>
											<? } ?>
										</select>

									
									Pertemuan :
										<select class="selectfilter" id="pertemuanselect" name="id_pertemuan">
										<option value="0">Pilih Pertemuan</option>
										</select>
										<a id="pembelajaranaddtmbh" title="" class="readmore"> Tambah Pembelajaran <br /></a>
										<a  style="padding:5px;" class="readmore exportexcellpemb"><img height="30" src="<?=$this->config->item('images')?>/Excel-icon.png" style="margin:0;" /> Export</a>
										<input type="hidden" name="jenis" value="Rencana_Pembelajaran" />
										<input type="hidden" name="fileName" value="Rencana_Pembelajaran" />
									</td>
								</tr>
							</table>
							<input type="hidden" name="ajax" value="1" />
							</form>
							<div id="subjectlist">
								<?php //$this->load->view('akademik/pembelajaran/daftarpembelajaranlist'); ?>
							</div>
					</div>