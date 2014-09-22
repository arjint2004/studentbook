				<script>
				$(document).ready(function(){
					
					$("#filterpelajaranuas select#kelasuas").change(function(e){
						$(this).after('<input type="hidden" name="kelasnya" value="'+$(this).find(":selected").text()+'"/>');
						$.ajax({
							type: "POST",
							data: $("form#filterpelajaranuas").serialize(),
							url: '<?=base_url()?>admin/pelajaran/getMapelByKelasAndPegawai/'+$(this).val(),
							beforeSend: function() {
								$("#filterpelajaranuas select#kelasuas").after("<img id='waituas1' src='<?=$this->config->item('images').'loading.png';?>' />");
								$("#subjectlistuas table.tabelkelas tbody").html("");
							},
							success: function(msg) {
								$("#waituas1").remove();
								$("#pelajaranuas").html(msg);	
							}
						});
						return false;
					});//Submit End
					$("#filterpelajaranuas select#pelajaranuas").change(function(e){
						$(this).after('<input type="hidden" name="pelajarannya" value="'+$(this).find(":selected").text()+'"/>');
						$.ajax({
							type: "POST",
							data: $("form#filterpelajaranuas").serialize(),
							url: '<?=base_url()?>akademik/kirimuas/daftaruaslist',
							beforeSend: function() {
								$("#filterpelajaranuas select#pelajaranuas").after("<img id='waituas2' src='<?=$this->config->item('images').'loading.png';?>' />");
							},
							success: function(msg) {
								$("#waituas2").remove();
								$("#subjectlistuas").html(msg);	
							}
						});
						return false;
					});//Submit End
					$("#kirimuasadd").click(function(){
						$.ajax({
							type: "POST",
							data: '',
							url: '<?=base_url()?>akademik/kirimuas/kirimuasutama',
							beforeSend: function() {
								$("#kirimuasadd").append("<img style='float: right; position: absolute; top: -5px; right: 3px;' id='waituas3' src='<?=$this->config->item('images').'loaderhover.gif';?>' />");
							},
							success: function(msg) {
								$("#waituas3").remove();
								$("#subjectlistuas").html(msg);	
							}
						});
						return false;
					});//Submit End
					$("#kirimuasremidiadd").click(function(){
						$.ajax({
							type: "POST",
							data: '',
							url: '<?=base_url()?>akademik/kirimuas/kirimuasremidial',
							beforeSend: function() {
								$("#kirimuasremidiadd").append("<img style='float: right; position: absolute; top: -5px; right: 3px;' id='waituas4' src='<?=$this->config->item('images').'loaderhover.gif';?>' />");
							},
							success: function(msg) {
								$("#waituas4").remove();
								$("#subjectlistuas").html(msg);	
							}
						});
						return false;
					});//Submit End
					$("#kirimuas").click(function(){
						$.ajax({
							type: "POST",
							data: '',
							url: '<?=base_url()?>akademik/kirimuas/kirimuasnya',
							beforeSend: function() {
								$("#kirimuas").append("<img style='float: right; position: absolute; top: -5px; right: 3px;' id='waituas5' src='<?=$this->config->item('images').'loaderhover.gif';?>' />");
							},
							success: function(msg) {
								$("#waituas5").remove();
								$("#subjectlistuas").html(msg);	
							}
						});
						return false;
					});//Submit End
					$.ajax({
							type: "POST",
							data: 'ajax=1',
							url: '<?=base_url()?>akademik/kirimuas/daftaruaslist',
							beforeSend: function() {
								$("#daftar_uas").append("<img style='float: right; position: absolute; top: -5px; right: 3px;' id='waituas6' src='<?=$this->config->item('images').'loaderhover.gif';?>' />");
							},
							success: function(msg) {
								$("#waituas6").remove();
								$("#subjectlistuas").html(msg);	
							}
						});
					
					$(".exportexcelluas").click(function(){
						$('form#filterpelajaranuas').attr('action','<?=base_url()?>akademik/export');
						$('form#filterpelajaranuas').submit();
					});	
				});

				</script>
				<h3>Daftar UAS</h3>
				<div class="hr"></div>
				
				<div id="contentpage">
							<form action="" method="post" id="filterpelajaranuas" >
							<table class="tabelfilter">
								<tr>
								<td>
									Kelas :
										<select class="selectfilter" id="kelasuas" name="id_kelas">
											<option value="">Pilih Kelas</option>
											<? foreach($kelas as $datakelas){?>
											<option <? if(@$_POST['kelas']==$datakelas['id']){echo 'selected';}?> value="<?=$datakelas['id']?>"><?=$datakelas['kelas']?><?=$datakelas['nama']?></option>
											<? } ?>
										</select>

									
									Pelajaran :
										<select class="selectfilter" id="pelajaranuas" name="pelajaran">
											<option value="">Pilih Pelajaran</option>
											<? foreach($pelajaran as $datapelajaran){?>
											<option <? if(@$_POST['pelajaran']==$datapelajaran['id']){echo 'selected';}?> value="<?=$datapelajaran['id']?>"><?=$datapelajaran['nama']?></option>
											<? } ?>
										</select>
										<a id="kirimuasadd" title="" class="readmore"> Tambah <br /> UAS </a>
										<a id="kirimuasremidiadd" title="" class="readmore"> Tambah UAS <br /> Remidi</a>
										<a id="kirimuas" title="" class="readmore"> Kirim <br /> UAS </a>
										<a  style="padding:5px;" class="readmore exportexcelluas"><img height="30" src="<?=$this->config->item('images')?>/Excel-icon.png" style="margin:0;" /> Export</a>
										<input type="hidden" name="jenis" value="UAS" />
										<input type="hidden" name="fileName" value="UAS" />
										
									</td>
								</tr>
							</table>
							<input type="hidden" name="ajax" value="1" />
							</form>
							<div id="subjectlistuas">
								<?php $this->load->view('akademik/kirimuas/daftaruaslist'); ?>
							</div>
					</div>
