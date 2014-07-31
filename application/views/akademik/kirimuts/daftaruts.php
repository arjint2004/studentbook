				<script>
				$(document).ready(function(){
					
					$("#filterpelajaranuts select#kelasuts").change(function(e){
					$(this).after('<input type="hidden" name="kelasnya" value="'+$(this).find(":selected").text()+'"/>');
						$.ajax({
							type: "POST",
							data: $("form#filterpelajaranuts").serialize(),
							url: '<?=base_url()?>admin/pelajaran/getMapelByKelasAndPegawai/'+$(this).val(),
							beforeSend: function() {
								$("#filterpelajaranuts select#kelasuts").after("<img id='waituts1' src='<?=$this->config->item('images').'loading.png';?>' />");
								$("#subjectlistuts table.tabelkelas tbody").html("");
							},
							success: function(msg) {
								$("#waituts1").remove();
								$("#pelajaranuts").html(msg);	
							}
						});
						return false;
					});//Submit End
					$("#filterpelajaranuts select#pelajaranuts").change(function(e){
					$(this).after('<input type="hidden" name="pelajarannya" value="'+$(this).find(":selected").text()+'"/>');
						$.ajax({
							type: "POST",
							data: $("form#filterpelajaranuts").serialize(),
							url: '<?=base_url()?>akademik/kirimuts/daftarutslist',
							beforeSend: function() {
								$("#filterpelajaranuts select#pelajaranuts").after("<img id='waituts2' src='<?=$this->config->item('images').'loading.png';?>' />");
							},
							success: function(msg) {
								$("#waituts2").remove();
								$("#subjectlistuts").html(msg);	
							}
						});
						return false;
					});//Submit End
					$("#kirimutsadd").click(function(){
						$.ajax({
							type: "POST",
							data: '',
							url: '<?=base_url()?>akademik/kirimuts/kirimutsutama',
							beforeSend: function() {
								$("#kirimutsadd").append("<img style='float: right; position: absolute; top: -5px; right: 3px;' id='waituts3' src='<?=$this->config->item('images').'loaderhover.gif';?>' />");
							},
							success: function(msg) {
								$("#waituts3").remove();
								$("#subjectlistuts").html(msg);	
							}
						});
						return false;
					});//Submit End
					$("#kirimutsremidiadd").click(function(){
						$.ajax({
							type: "POST",
							data: '',
							url: '<?=base_url()?>akademik/kirimuts/kirimutsremidial',
							beforeSend: function() {
								$("#kirimutsremidiadd").append("<img style='float: right; position: absolute; top: -5px; right: 3px;' id='waituts4' src='<?=$this->config->item('images').'loaderhover.gif';?>' />");
							},
							success: function(msg) {
								$("#waituts4").remove();
								$("#subjectlistuts").html(msg);	
							}
						});
						return false;
					});//Submit End
					$("#kirimuts").click(function(){
						$.ajax({
							type: "POST",
							data: '',
							url: '<?=base_url()?>akademik/kirimuts/kirimutsnya',
							beforeSend: function() {
								$("#kirimuts").append("<img style='float: right; position: absolute; top: -5px; right: 3px;' id='waituts5' src='<?=$this->config->item('images').'loaderhover.gif';?>' />");
							},
							success: function(msg) {
								$("#waituts5").remove();
								$("#subjectlistuts").html(msg);	
							}
						});
						return false;
					});//Submit End
					$.ajax({
							type: "POST",
							data: 'ajax=1',
							url: '<?=base_url()?>akademik/kirimuts/daftarutslist',
							beforeSend: function() {
								$("#daftar_uts").append("<img style='float: right; position: absolute; top: -5px; right: 3px;' id='waituts6' src='<?=$this->config->item('images').'loaderhover.gif';?>' />");
							},
							success: function(msg) {
								$("#waituts6").remove();
								$("#subjectlistuts").html(msg);	
							}
						});
							
					$(".exportexcelluts").click(function(){
						$('form#filterpelajaranuts').attr('action','<?=base_url()?>akademik/export');
						$('form#filterpelajaranuts').submit();
					});
				});

				</script>
				<h3>Daftar UTS</h3>
				<div class="hr"></div>
				
				<div id="contentpage">
							<form action="" method="post" id="filterpelajaranuts" >
							<table class="tabelfilter">
								<tr>
								<td>
									Kelas :
										<select class="selectfilter" id="kelasuts" name="id_kelas">
											<option value="">Pilih Kelas</option>
											<? foreach($kelas as $datakelas){?>
											<option <? if(@$_POST['kelas']==$datakelas['id']){echo 'selected';}?> value="<?=$datakelas['id']?>"><?=$datakelas['kelas']?><?=$datakelas['nama']?></option>
											<? } ?>
										</select>

									
									Pelajaran :
										<select class="selectfilter" id="pelajaranuts" name="pelajaran">
											<option value="">Pilih Pelajaran</option>
											<? foreach($pelajaran as $datapelajaran){?>
											<option <? if(@$_POST['pelajaran']==$datapelajaran['id']){echo 'selected';}?> value="<?=$datapelajaran['id']?>"><?=$datapelajaran['nama']?></option>
											<? } ?>
										</select>
										<a id="kirimutsadd" title="" class="readmore"> Tambah <br /> uts </a>
										<a id="kirimutsremidiadd" title="" class="readmore"> Tambah uts <br /> Remidi</a>
										<a id="kirimuts" title="" class="readmore"> Kirim <br /> uts </a>
										<a  style="padding:5px;" class="readmore exportexcelluts"><img height="30" src="<?=$this->config->item('images')?>/Excel-icon.png" style="margin:0;" /> Export</a>
										<input type="hidden" name="jenis" value="UTS" />
										<input type="hidden" name="fileName" value="UTS" />
										
									</td>
								</tr>
							</table>
							<input type="hidden" name="ajax" value="1" />
							</form>
							<div id="subjectlistuts">
								<?php $this->load->view('akademik/kirimuts/daftarutslist'); ?>
							</div>
					</div>
