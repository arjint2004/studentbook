				<script>
				$(document).ready(function(){
					
					$("#filterpelajaranharian select#kelasharian").change(function(e){
					$(this).after('<input type="hidden" name="kelasnya" value="'+$(this).find(":selected").text()+'"/>');
						$.ajax({
							type: "POST",
							data: $("form#filterpelajaranharian").serialize(),
							url: '<?=base_url()?>admin/pelajaran/getMapelByKelasAndPegawai/'+$(this).val(),
							beforeSend: function() {
								$("#filterpelajaranharian select#kelasharian").after("<img id='waitharian1' src='<?=$this->config->item('images').'loading.png';?>' />");
								$("#subjectlistharian table.tabelkelas tbody").html("");
							},
							success: function(msg) {
								$("#waitharian1").remove();
								$("#pelajaranharian").html(msg);	
							}
						});
						return false;
					});//Submit End
					$("#filterpelajaranharian select#pelajaranharian").change(function(e){
					$(this).after('<input type="hidden" name="pelajarannya" value="'+$(this).find(":selected").text()+'"/>');
						$.ajax({
							type: "POST",
							data: $("form#filterpelajaranharian").serialize(),
							url: '<?=base_url()?>akademik/kirimharian/daftarharianlist',
							beforeSend: function() {
								$("#filterpelajaranharian select#pelajaranharian").after("<img id='waitharian2' src='<?=$this->config->item('images').'loading.png';?>' />");
							},
							success: function(msg) {
								$("#waitharian2").remove();
								$("#subjectlistharian").html(msg);	
							}
						});
						return false;
					});//Submit End
					$("#kirimharianadd").click(function(){
						$.ajax({
							type: "POST",
							data: '',
							url: '<?=base_url()?>akademik/kirimharian/kirimharianutama',
							beforeSend: function() {
								$("#kirimharianadd").append("<img style='float: right; position: absolute; top: -5px; right: 3px;' id='waitharian3' src='<?=$this->config->item('images').'loaderhover.gif';?>' />");
							},
							success: function(msg) {
								$("#waitharian3").remove();
								$("#subjectlistharian").html(msg);	
							}
						});
						return false;
					});//Submit End
					$("#kirimharianremidiadd").click(function(){
						$.ajax({
							type: "POST",
							data: '',
							url: '<?=base_url()?>akademik/kirimharian/kirimharianremidial',
							beforeSend: function() {
								$("#kirimharianremidiadd").append("<img style='float: right; position: absolute; top: -5px; right: 3px;' id='waitharian4' src='<?=$this->config->item('images').'loaderhover.gif';?>' />");
							},
							success: function(msg) {
								$("#waitharian4").remove();
								$("#subjectlistharian").html(msg);	
							}
						});
						return false;
					});//Submit End
					$("#kirimharian").click(function(){
						$.ajax({
							type: "POST",
							data: '',
							url: '<?=base_url()?>akademik/kirimharian/kirimhariannya',
							beforeSend: function() {
								$("#kirimharian").append("<img style='float: right; position: absolute; top: -5px; right: 3px;' id='waitharian5' src='<?=$this->config->item('images').'loaderhover.gif';?>' />");
							},
							success: function(msg) {
								$("#waitharian5").remove();
								$("#subjectlistharian").html(msg);	
							}
						});
						return false;
					});//Submit End
					$.ajax({
							type: "POST",
							data: 'ajax=1',
							url: '<?=base_url()?>akademik/kirimharian/daftarharianlist',
							beforeSend: function() {
								$("#daftar_harian").append("<img style='float: right; position: absolute; top: -5px; right: 3px;' id='waitharian6' src='<?=$this->config->item('images').'loaderhover.gif';?>' />");
							},
							success: function(msg) {
								$("#waitharian6").remove();
								$("#subjectlistharian").html(msg);	
							}
						});
							
					$(".exportexcellharian").click(function(){
						$('form#filterpelajaranharian').attr('action','<?=base_url()?>akademik/export');
						$('form#filterpelajaranharian').submit();
					});
				});

				</script>
				<h3>Daftar UL Harian</h3>
				<div class="hr"></div>
				
				<div id="contentpage">
							<form action="" method="post" id="filterpelajaranharian" >
							<table class="tabelfilter">
								<tr>
								<td>
									Kelas :
										<select class="selectfilter" id="kelasharian" name="id_kelas">
											<option value="">Pilih Kelas</option>
											<? foreach($kelas as $datakelas){?>
											<option <? if(@$_POST['kelas']==$datakelas['id']){echo 'selected';}?> value="<?=$datakelas['id']?>"><?=$datakelas['kelas']?><?=$datakelas['nama']?></option>
											<? } ?>
										</select>

									
									Pelajaran :
										<select class="selectfilter" id="pelajaranharian" name="pelajaran">
											<option value="">Pilih Pelajaran</option>
											<? foreach($pelajaran as $datapelajaran){?>
											<option <? if(@$_POST['pelajaran']==$datapelajaran['id']){echo 'selected';}?> value="<?=$datapelajaran['id']?>"><?=$datapelajaran['nama']?></option>
											<? } ?>
										</select>
										<a id="kirimharianadd" title="" class="readmore"> Tambah <br /> harian </a>
										<a id="kirimharianremidiadd" title="" class="readmore"> Tambah harian <br /> Remidi</a>
										<a id="kirimharian" title="" class="readmore"> Kirim <br /> harian </a>
										<a  style="padding:5px;" class="readmore exportexcellharian"><img height="30" src="<?=$this->config->item('images')?>/Excel-icon.png" style="margin:0;" /> Export</a>
										<input type="hidden" name="jenis" value="Ulangan_harian" />
										<input type="hidden" name="fileName" value="Ulangan_harian" />
										
									</td>
								</tr>
							</table>
							<input type="hidden" name="ajax" value="1" />
							</form>
							<div id="subjectlistharian">
								<?php $this->load->view('akademik/kirimharian/daftarharianlist'); ?>
							</div>
					</div>
