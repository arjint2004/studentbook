<script>
				$(document).ready(function(){
					//Submit Start
					$(".editdatapembelajaran").click(function(e){
						$('#ajaxside').load('<?=base_url()?>admin/pelajaran/editdatapembelajaran/'+$(this).attr('id'));
					});
					
					$("#filterpelajaranpembelajaran select#kelas").change(function(e){
						$(this).after('<input type="hidden" name="pertkelasnya" value="'+$(this).find(":selected").text()+'"/>');
						$.ajax({
							type: "POST",
							data: $("form#filterpelajaranpembelajaran").serialize(),
							url: '<?=base_url()?>admin/pelajaran/getMapelByKelasAndPegawai/'+$(this).val(),
							beforeSend: function() {
								$("#filterpelajaranpembelajaran select#kelas").after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
								$("#subjectlist table.tabelkelas tbody").html("");
							},
							success: function(msg) {
								$("#wait").remove();
								$("#pelajaran").html(msg);	
							}
						});
						return false;
					});//Submit End
					$("#filterpelajaranpembelajaran select#pelajaran").change(function(e){
						$(this).after('<input type="hidden" name="pertpelajarannya" value="'+$(this).find(":selected").text()+'"/>');
						$.ajax({
							type: "POST",
							data: $("form#filterpelajaranpembelajaran").serialize(),
							url: '<?=base_url()?>akademik/instrumen/pertemuanlist',
							beforeSend: function() {
								$("#filterpelajaranpembelajaran select#pelajaran").after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
							},
							success: function(msg) {
								$("#wait").remove();
								$("#subjectlist").html(msg);	
							}
						});
						return false;
					});//Submit End
					$("#pembelajaranaddtmbh").click(function(){
						$('#fancybox-content').scrollintoview({ speed:'1100'});
						/*$.ajax({
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
						return false;*/
					});//Submit End
					
						$.ajax({
							type: "POST",
							data: 'ajax=1',
							url: '<?=base_url()?>akademik/instrumen/pertemuanlist',
							beforeSend: function() {
								$("#filterpelajaranpembelajaran select#pelajaran").after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
							},
							success: function(msg) {
								$("#wait").remove();
								$("#subjectlist").html(msg);	
							}
						});
						
					$(".exportexcellpert").click(function(){
						$('form#filterpelajaranpembelajaran').attr('action','<?=base_url()?>akademik/export');
						$('form#filterpelajaranpembelajaran').submit();
					});
				});

				</script>
				<h3>Pertemuan Pembelajaran</h3>
				<div class="hr"></div>
				
				<div id="contentpage">
							<form action="" method="post" id="filterpelajaranpembelajaran" >
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

									
									Pelajaran :
										<select class="selectfilter" id="pelajaran" name="pelajaran">
											<option value="">Pilih Pelajaran</option>
											<? foreach($pelajaran as $datapelajaran){?>
											<option <? if(@$_POST['pelajaran']==$datapelajaran['id']){echo 'selected';}?> value="<?=$datapelajaran['id']?>"><?=$datapelajaran['nama']?></option>
											<? } ?>
										</select>
										<a id="pembelajaranaddtmbh" title="" href="<?=base_url()?>akademik/instrumen/addpertemuan" class="readmore modal"> Tambah <br /> Pertemuan <br />  </a>
										<a  style="padding:5px;" class="readmore exportexcellpert"><img height="30" src="<?=$this->config->item('images')?>/Excel-icon.png" style="margin:0;" /> Export</a>
										<input type="hidden" name="jenis" value="Pertemuan_Pembelajaran" />
										<input type="hidden" name="fileName" value="Pertemuan_Pembelajaran" />
									</td>
								</tr>
							</table>
							<input type="hidden" name="ajax" value="1" />
							</form>
							<div id="subjectlist">
								<?php //$this->load->view('akademik/pembelajaran/daftarpembelajaranlist'); ?>
							</div>
					</div>