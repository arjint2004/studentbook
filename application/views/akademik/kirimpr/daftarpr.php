				<script>
				$(document).ready(function(){
					
					$("#filterpelajaranpr select#kelaspr").change(function(e){
						$(this).after('<input type="hidden" name="kelasnya" value="'+$(this).find(":selected").text()+'"/>');
						$.ajax({
							type: "POST",
							data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&'+$("form#filterpelajaranpr").serialize(),
							url: '<?=base_url()?>admin/pelajaran/getMapelByKelasAndPegawai/'+$(this).val(),
							beforeSend: function() {
								$("#filterpelajaranpr select#kelaspr").after("<img id='waitpr1' src='<?=$this->config->item('images').'loading.png';?>' />");
								$("#subjectlistpr table.tabelkelas tbody").html("");
							},
							success: function(msg) {
								$("#waitpr1").remove();
								$("#pelajaranpr").html(msg);	
							}
						});
						return false;
					});//Submit End
					$("#filterpelajaranpr select#pelajaranpr").change(function(e){
						$(this).after('<input type="hidden" name="pelajarannya" value="'+$(this).find(":selected").text()+'"/>');
						$.ajax({
							type: "POST",
							data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&'+$("form#filterpelajaranpr").serialize(),
							url: '<?=base_url()?>akademik/kirimpr/daftarprlist',
							beforeSend: function() {
								$("#filterpelajaranpr select#pelajaranpr").after("<img id='waitpr2' src='<?=$this->config->item('images').'loading.png';?>' />");
							},
							success: function(msg) {
								$("#waitpr2").remove();
								$("#subjectlistpr").html(msg);	
							}
						});
						return false;
					});//Submit End
					$("#kirimpradd").click(function(){
						$.ajax({
							type: "POST",
							data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&',
							url: '<?=base_url()?>akademik/kirimpr/kirimprutama',
							beforeSend: function() {
								$("#kirimpradd").append("<img style='float: right; position: absolute; top: -5px; right: 3px;' id='waitpr3' src='<?=$this->config->item('images').'loaderhover.gif';?>' />");
							},
							success: function(msg) {
								$("#waitpr3").remove();
								$("#subjectlistpr").html(msg);	
							}
						});
						return false;
					});//Submit End
					$("#kirimprremidiadd").click(function(){
						$.ajax({
							type: "POST",
							data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&',
							url: '<?=base_url()?>akademik/kirimpr/kirimprremidial',
							beforeSend: function() {
								$("#kirimprremidiadd").append("<img style='float: right; position: absolute; top: -5px; right: 3px;' id='waitpr4' src='<?=$this->config->item('images').'loaderhover.gif';?>' />");
							},
							success: function(msg) {
								$("#waitpr4").remove();
								$("#subjectlistpr").html(msg);	
							}
						});
						return false;
					});//Submit End
					$("#kirimpr").click(function(){
						$.ajax({
							type: "POST",
							data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&',
							url: '<?=base_url()?>akademik/kirimpr/kirimprnya',
							beforeSend: function() {
								$("#kirimpr").append("<img style='float: right; position: absolute; top: -5px; right: 3px;' id='waitpr5' src='<?=$this->config->item('images').'loaderhover.gif';?>' />");
							},
							success: function(msg) {
								$("#waitpr5").remove();
								$("#subjectlistpr").html(msg);	
							}
						});
						return false;
					});//Submit End
					$.ajax({
							type: "POST",
							data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&ajax=1',
							url: '<?=base_url()?>akademik/kirimpr/daftarprlist',
							beforeSend: function() {
								$("#daftar_pr").append("<img style='float: right; position: absolute; top: -5px; right: 3px;' id='waitpr6' src='<?=$this->config->item('images').'loaderhover.gif';?>' />");
							},
							success: function(msg) {
								$("#waitpr6").remove();
								$("#subjectlistpr").html(msg);	
							}
						});
					
					$(".exportexcellpr").click(function(){
						$('form#filterpelajaranpr').attr('action','<?=base_url()?>akademik/export');
						$('form#filterpelajaranpr').submit();
					});	
				});

				</script>
				<h3>Daftar PR</h3>
				<div class="hr"></div>
				
				<div id="contentpage">
							<form action="" method="post" id="filterpelajaranpr" >
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
							<table class="tabelfilter">
								<tr>
								<td>
									Kelas :
										<select class="selectfilter" id="kelaspr" name="id_kelas">
											<option value="">Pilih Kelas</option>
											<? foreach($kelas as $datakelas){?>
											<option <? if(@$_POST['kelas']==$datakelas['id']){echo 'selected';}?> value="<?=$datakelas['id']?>"><?=$datakelas['kelas']?><?=$datakelas['nama']?></option>
											<? } ?>
										</select>

									
									Pelajaran :
										<select class="selectfilter" id="pelajaranpr" name="pelajaran">
											<option value="">Pilih Pelajaran</option>
											<? foreach($pelajaran as $datapelajaran){?>
											<option <? if(@$_POST['pelajaran']==$datapelajaran['id']){echo 'selected';}?> value="<?=$datapelajaran['id']?>"><?=$datapelajaran['nama']?></option>
											<? } ?>
										</select>
										<a id="kirimpradd" title="" class="readmore"> Tambah <br /> PR </a>
										<!--<a id="kirimprremidiadd" title="" class="readmore"> Tambah PR <br /> Remidi</a>-->
										<a id="kirimpr" title="" class="readmore"> Kirim <br /> PR </a>
										<a  style="padding:5px;" class="readmore exportexcellpr"><img height="30" src="<?=$this->config->item('images')?>/Excel-icon.png" style="margin:0;" /> Export</a>
										<input type="hidden" name="jenis" value="PR" />
										<input type="hidden" name="fileName" value="PR" />
										
									</td>
								</tr>
							</table>
							<input type="hidden" name="ajax" value="1" />
							</form>
							<div id="subjectlistpr">
								<?php $this->load->view('akademik/kirimpr/daftarprlist'); ?>
							</div>
					</div>
