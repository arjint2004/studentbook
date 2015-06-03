<script>
				$(document).ready(function(){
					//Submit Start
					$(".editdatatimelinepembelajaran").click(function(e){
						$('#ajaxside').load('<?=base_url()?>admin/pelajaran/editdatatimelinepembelajaran/'+$(this).attr('id'));
					});
					
					$("#filterpelajarantimelinepembelajaran select#kelas").change(function(e){
						$.ajax({
							type: "POST",
							data: $("form#filterpelajarantimelinepembelajaran").serialize(),
							url: '<?=base_url()?>admin/pelajaran/getMapelByKelasAndPegawai/'+$(this).val(),
							beforeSend: function() {
								$("#filterpelajarantimelinepembelajaran select#kelas").after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
								$("#subjectlist table.tabelkelas tbody").html("");
							},
							success: function(msg) {
								$("#wait").remove();
								$("#pelajaran").html(msg);	
							}
						});
						return false;
					});//Submit End
					$("#filterpelajarantimelinepembelajaran select#pelajaran").change(function(e){
						$.ajax({
							type: "POST",
							data: $("form#filterpelajarantimelinepembelajaran").serialize(),
							url: '<?=base_url()?>akademik/perencanaan/timelinepembelajaranlist',
							beforeSend: function() {
								$("#filterpelajarantimelinepembelajaran select#pelajaran").after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
							},
							success: function(msg) {
								$("#wait").remove();
								$("#subjectlist").html(msg);	
							}
						});
						return false;
					});//Submit End
					$("#timelinepembelajaranaddtbh").click(function(){
						$.ajax({
							type: "POST",
							data: '',
							url: '<?=base_url()?>akademik/perencanaan/addtimelinepembelajaran',
							beforeSend: function() {
								$("#timelinepembelajaranaddtbh").append("<img id='wait' src='<?=$this->config->item('images').'loaderhover.gif';?>' />");
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
							url: '<?=base_url()?>akademik/perencanaan/timelinepembelajaranlist',
							beforeSend: function() {
								$("#filterpelajaranpembelajaran select#pelajaran").after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
							},
							success: function(msg) {
								$("#wait").remove();
								$("#subjectlist").html(msg);	
							}
					});
				});

				</script>
<h3>Timeline Pembelajaran</h3>
				<div class="hr"></div>
				
				<div id="contentpage">
							<form action="" method="post" id="filterpelajarantimelinepembelajaran" >
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
										<a id="timelinepembelajaranaddtbh" title="" style="margin-top:6px;" class="readmore">Tambah Timeline Pembelajaran</a>
									</td>
								</tr>
							</table>
							<input type="hidden" name="ajax" value="1" />
							</form>
							<div id="subjectlist">
								<?php //$this->load->view('akademik/timelinepembelajaran/daftartimelinepembelajaranlist'); ?>
							</div>
					</div>