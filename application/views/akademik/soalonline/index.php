<script>
				$(document).ready(function(){
					//Submit Start
					$(".editdatasoalonline").click(function(e){
						$('#ajaxside').load('<?=base_url()?>admin/pelajaran/editdatasoalonline/'+$(this).attr('id'));
					});
					
					$("#filterpelajaransoalonline select#kelas").change(function(e){
						$(this).after('<input type="hidden" name="kelasnya" value="'+$(this).find(":selected").text()+'"/>');
						$.ajax({
							type: "POST",
							data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&'+$("form#filterpelajaransoalonline").serialize(),
							url: '<?=base_url()?>admin/pelajaran/getMapelByKelasAndPegawai/'+$(this).val(),
							beforeSend: function() {
								$("#filterpelajaransoalonline select#kelas").after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
								$("#subjectlistsoalonline table.tabelkelas tbody").html("");
							},
							success: function(msg) {
								$("#wait").remove();
								$("div#subjectlistsoalonline table tbody").html('');
								$("#pelajaran").html(msg);	
							}
						});
						return false;
					});//Submit End
					$("#filterpelajaransoalonline select#pelajaran").change(function(e){
					$(this).after('<input type="hidden" name="pelajarannya" value="'+$(this).find(":selected").text()+'"/>');
						$.ajax({
							type: "POST",
							data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&'+$("form#filterpelajaransoalonline").serialize(),
							url: '<?=base_url()?>akademik/soalonline/daftarsoalonlinelist',
							beforeSend: function() {
								$("#filterpelajaransoalonline select#pelajaran").after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
							},
							success: function(msg) {
								$("#wait").remove();
								$("#subjectlistsoalonline").html(msg);	
							}
						});
						return false;
					});//Submit End
					$("#soalonlineadd").click(function(){
						$.ajax({
							type: "POST",
							data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&',
							url: '<?=base_url()?>akademik/soalonline/addsoalonline',
							beforeSend: function() {
								$("#soalonlineadd").append("<img style='float: right; position: absolute; top: -5px; right: 3px;' id='wait' src='<?=$this->config->item('images').'loaderhover.gif';?>' />");
							},
							success: function(msg) {
								$("#wait").remove();
								$("#subjectlistsoalonline").html(msg);	
							}
						});
						return false;
					});//Submit End
					$("#kirimsoalonline").click(function(){
						$.ajax({
							type: "POST",
							data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&',
							url: '<?=base_url()?>akademik/soalonline/kirimsoalonline',
							beforeSend: function() {
								$("#kirimsoalonline").append("<img style='float: right; position: absolute; top: -5px; right: 3px;' id='wait' src='<?=$this->config->item('images').'loaderhover.gif';?>' />");
							},
							success: function(msg) {
								$("#wait").remove();
								$("#subjectlistsoalonline").html(msg);	
							}
						});
						return false;
					});//Submit End
					
					$.ajax({
							type: "POST",
							data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&ajax=1',
							url: '<?=base_url()?>akademik/soalonline/daftarsoalonlinelist',
							beforeSend: function() {
								$("#soalonline_pelajaran").append("<img id='wait' style='float: right; position: absolute; top: -5px; right: 3px;' id='wait' src='<?=$this->config->item('images').'loaderhover.gif';?>' />");
							},
							success: function(msg) {
								$("#wait").remove();
								$("#subjectlistsoalonline").html(msg);	
							}
					});
					
					$(".exportexcellsoalonline").click(function(){
						$('form#filterpelajaransoalonline').attr('action','<?=base_url()?>akademik/export');
						$('form#filterpelajaransoalonline').submit();
					});
				});

				</script>
<h3>Soalonline Pelajaran</h3>
				<div class="hr"></div>
				
				<div id="contentpage" style="min-width:768px;">
							<form action="" method="post" id="filterpelajaransoalonline" >
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
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
										<a id="soalonlineadd" title="" class="readmore"> Tambah Soalonline <br /> Pelajaran </a>
										<a id="kirimsoalonline" title="" class="readmore"> Kirim Soalonline <br /> Prlajaran </a>
										<a  style="padding:5px;" class="readmore exportexcellsoalonline"><img height="30" src="<?=$this->config->item('images')?>/Excel-icon.png" style="margin:0;" /> Export</a>
										<input type="hidden" name="jenis" value="Soalonline" />
										<input type="hidden" name="fileName" value="Soalonline" />
									</td>
								</tr>
							</table>
							<input type="hidden" name="ajax" value="1" />
							</form>
							<div id="subjectlistsoalonline">
								<?php //$this->load->view('akademik/soalonline/daftarsoalonlinelist'); ?>
							</div>
					</div>