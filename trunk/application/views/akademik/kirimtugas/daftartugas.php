				<script>
				$(document).ready(function(){
					
					$("#filterpelajarantugas select#kelastugas").change(function(e){
					$(this).after('<input type="hidden" name="kelasnya" value="'+$(this).find(":selected").text()+'"/>');
						$.ajax({
							type: "POST",
							data: $("form#filterpelajarantugas").serialize(),
							url: '<?=base_url()?>admin/pelajaran/getMapelByKelasAndPegawai/'+$(this).val(),
							beforeSend: function() {
								$("#filterpelajarantugas select#kelastugas").after("<img id='waittugas1' src='<?=$this->config->item('images').'loading.png';?>' />");
								$("#subjectlisttugas table.tabelkelas tbody").html("");
							},
							success: function(msg) {
								$("#waittugas1").remove();
								$("#pelajarantugas").html(msg);	
							}
						});
						return false;
					});//Submit End
					$("#filterpelajarantugas select#pelajarantugas").change(function(e){
					$(this).after('<input type="hidden" name="pelajarannya" value="'+$(this).find(":selected").text()+'"/>');
						$.ajax({
							type: "POST",
							data: $("form#filterpelajarantugas").serialize(),
							url: '<?=base_url()?>akademik/kirimtugas/daftartugaslist',
							beforeSend: function() {
								$("#filterpelajarantugas select#pelajarantugas").after("<img id='waittugas2' src='<?=$this->config->item('images').'loading.png';?>' />");
							},
							success: function(msg) {
								$("#waittugas2").remove();
								$("#subjectlisttugas").html(msg);	
							}
						});
						return false;
					});//Submit End
					$("#kirimtugasadd").click(function(){
						$.ajax({
							type: "POST",
							data: '',
							url: '<?=base_url()?>akademik/kirimtugas/kirimtugasutama',
							beforeSend: function() {
								$("#kirimtugasadd").append("<img style='float: right; position: absolute; top: -5px; right: 3px;' id='waittugas3' src='<?=$this->config->item('images').'loaderhover.gif';?>' />");
							},
							success: function(msg) {
								$("#waittugas3").remove();
								$("#subjectlisttugas").html(msg);	
							}
						});
						return false;
					});//Submit End
					$("#kirimtugasremidiadd").click(function(){
						$.ajax({
							type: "POST",
							data: '',
							url: '<?=base_url()?>akademik/kirimtugas/kirimtugasremidial',
							beforeSend: function() {
								$("#kirimtugasremidiadd").append("<img style='float: right; position: absolute; top: -5px; right: 3px;' id='waittugas4' src='<?=$this->config->item('images').'loaderhover.gif';?>' />");
							},
							success: function(msg) {
								$("#waittugas4").remove();
								$("#subjectlisttugas").html(msg);	
							}
						});
						return false;
					});//Submit End
					$("#kirimtugas").click(function(){
						$.ajax({
							type: "POST",
							data: '',
							url: '<?=base_url()?>akademik/kirimtugas/kirimtugasnya',
							beforeSend: function() {
								$("#kirimtugas").append("<img style='float: right; position: absolute; top: -5px; right: 3px;' id='waittugas5' src='<?=$this->config->item('images').'loaderhover.gif';?>' />");
							},
							success: function(msg) {
								$("#waittugas5").remove();
								$("#subjectlisttugas").html(msg);	
							}
						});
						return false;
					});//Submit End
					$.ajax({
							type: "POST",
							data: 'ajax=1',
							url: '<?=base_url()?>akademik/kirimtugas/daftartugaslist',
							beforeSend: function() {
								$("#daftar_tugas").append("<img style='float: right; position: absolute; top: -5px; right: 3px;' id='waittugas6' src='<?=$this->config->item('images').'loaderhover.gif';?>' />");
							},
							success: function(msg) {
								$("#waittugas6").remove();
								$("#subjectlisttugas").html(msg);	
							}
						});
						
					$(".exportexcelltugas").click(function(){
						$('form#filterpelajarantugas').attr('action','<?=base_url()?>akademik/export');
						$('form#filterpelajarantugas').submit();
					});	
				});

				</script>
				<h3>Daftar Tugas</h3>
				<div class="hr"></div>
				
				<div id="contentpage">
							<form action="" method="post" id="filterpelajarantugas" >
							<table class="tabelfilter">
								<tr>
								<td>
									Kelas :
										<select class="selectfilter" id="kelastugas" name="id_kelas">
											<option value="">Pilih Kelas</option>
											<? foreach($kelas as $datakelas){?>
											<option <? if(@$_POST['kelas']==$datakelas['id']){echo 'selected';}?> value="<?=$datakelas['id']?>"><?=$datakelas['kelas']?><?=$datakelas['nama']?></option>
											<? } ?>
										</select>

									
									Pelajaran :
										<select class="selectfilter" id="pelajarantugas" name="pelajaran">
											<option value="">Pilih Pelajaran</option>
											<? foreach($pelajaran as $datapelajaran){?>
											<option <? if(@$_POST['pelajaran']==$datapelajaran['id']){echo 'selected';}?> value="<?=$datapelajaran['id']?>"><?=$datapelajaran['nama']?></option>
											<? } ?>
										</select>
										<a id="kirimtugasadd" title="" class="readmore"> Tambah <br /> tugas </a>
										<a id="kirimtugasremidiadd" title="" class="readmore"> Tambah tugas <br /> Remidi</a>
										<a id="kirimtugas" title="" class="readmore"> Kirim <br /> tugas </a>
										<a  style="padding:5px;" class="readmore exportexcelltugas"><img height="30" src="<?=$this->config->item('images')?>/Excel-icon.png" style="margin:0;" /> Export</a>
										<input type="hidden" name="jenis" value="Tugas" />
										<input type="hidden" name="fileName" value="Tugas" />
										
									</td>
								</tr>
							</table>
							<input type="hidden" name="ajax" value="1" />
							</form>
							<div id="subjectlisttugas">
								<?php $this->load->view('akademik/kirimtugas/daftartugaslist'); ?>
							</div>
					</div>
