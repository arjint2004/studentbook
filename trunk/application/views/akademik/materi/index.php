<script>
				$(document).ready(function(){
					//Submit Start
					$(".editdatamateri").click(function(e){
						$('#ajaxside').load('<?=base_url()?>admin/pelajaran/editdatamateri/'+$(this).attr('id'));
					});
					
					$("#filterpelajaranmateri select#kelas").change(function(e){
						$(this).after('<input type="hidden" name="kelasnya" value="'+$(this).find(":selected").text()+'"/>');
						$.ajax({
							type: "POST",
							data: $("form#filterpelajaranmateri").serialize(),
							url: '<?=base_url()?>admin/pelajaran/getMapelByKelasAndPegawai/'+$(this).val(),
							beforeSend: function() {
								$("#filterpelajaranmateri select#kelas").after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
								$("#subjectlistmateri table.tabelkelas tbody").html("");
							},
							success: function(msg) {
								$("#wait").remove();
								$("div#subjectlistmateri table tbody").html('');
								$("#pelajaran").html(msg);	
							}
						});
						return false;
					});//Submit End
					$("#filterpelajaranmateri select#pelajaran").change(function(e){
					$(this).after('<input type="hidden" name="pelajarannya" value="'+$(this).find(":selected").text()+'"/>');
						$.ajax({
							type: "POST",
							data: $("form#filterpelajaranmateri").serialize(),
							url: '<?=base_url()?>akademik/materi/daftarmaterilist',
							beforeSend: function() {
								$("#filterpelajaranmateri select#pelajaran").after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
							},
							success: function(msg) {
								$("#wait").remove();
								$("#subjectlistmateri").html(msg);	
							}
						});
						return false;
					});//Submit End
					$("#materiadd").click(function(){
						$.ajax({
							type: "POST",
							data: '',
							url: '<?=base_url()?>akademik/materi/addmateri',
							beforeSend: function() {
								$("#materiadd").append("<img style='float: right; position: absolute; top: -5px; right: 3px;' id='wait' src='<?=$this->config->item('images').'loaderhover.gif';?>' />");
							},
							success: function(msg) {
								$("#wait").remove();
								$("#subjectlistmateri").html(msg);	
							}
						});
						return false;
					});//Submit End
					$("#kirimmateri").click(function(){
						$.ajax({
							type: "POST",
							data: '',
							url: '<?=base_url()?>akademik/materi/kirimmateri',
							beforeSend: function() {
								$("#kirimmateri").append("<img style='float: right; position: absolute; top: -5px; right: 3px;' id='wait' src='<?=$this->config->item('images').'loaderhover.gif';?>' />");
							},
							success: function(msg) {
								$("#wait").remove();
								$("#subjectlistmateri").html(msg);	
							}
						});
						return false;
					});//Submit End
					
					$.ajax({
							type: "POST",
							data: 'ajax=1',
							url: '<?=base_url()?>akademik/materi/daftarmaterilist',
							beforeSend: function() {
								$("#materi_pelajaran").append("<img id='wait' style='float: right; position: absolute; top: -5px; right: 3px;' id='wait' src='<?=$this->config->item('images').'loaderhover.gif';?>' />");
							},
							success: function(msg) {
								$("#wait").remove();
								$("#subjectlistmateri").html(msg);	
							}
					});
					
					$(".exportexcellmateri").click(function(){
						$('form#filterpelajaranmateri').attr('action','<?=base_url()?>akademik/export');
						$('form#filterpelajaranmateri').submit();
					});
				});

				</script>
<h3>Materi Pelajaran</h3>
				<div class="hr"></div>
				
				<div id="contentpage" style="min-width:768px;">
							<form action="" method="post" id="filterpelajaranmateri" >
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
										<a id="materiadd" title="" class="readmore"> Tambah Materi <br /> Prlajaran </a>
										<a id="kirimmateri" title="" class="readmore"> Kirim Materi <br /> Prlajaran </a>
										<a  style="padding:5px;" class="readmore exportexcellmateri"><img height="30" src="<?=$this->config->item('images')?>/Excel-icon.png" style="margin:0;" /> Export</a>
										<input type="hidden" name="jenis" value="Materi" />
										<input type="hidden" name="fileName" value="Materi" />
									</td>
								</tr>
							</table>
							<input type="hidden" name="ajax" value="1" />
							</form>
							<div id="subjectlistmateri">
								<?php //$this->load->view('akademik/materi/daftarmaterilist'); ?>
							</div>
					</div>