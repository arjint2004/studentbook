				<script>
				$(document).ready(function(){
					//Submit Start
					$(".editdata").click(function(e){
						$('#ajaxside').load('<?=base_url()?>admin/pelajaran/editData/'+$(this).attr('id'));
					});
					
					$("#filterpelajarandpsikoAfektif select#kelasPsikoafektif").change(function(e){
						$.ajax({
							type: "POST",
							data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&'+$("form#filterpelajarandpsikoAfektif").serialize()+'&nama_kelas='+$('#filterpelajarandpsikoAfektif select#kelasPsikoafektif :selected').attr('nama_kelas')+'&id_jurusan='+$('#filterpelajarandpsikoAfektif select#kelasPsikoafektif :selected').attr('id_jurusan'),
							url: '<?=base_url()?>akademik/nilai/getpsikoafektif',
							beforeSend: function() {
								$("#filterpelajarandpsikoAfektif select#kelasPsikoafektif").after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
							},
							success: function(msg) {
								$("#wait").remove();
								$("#subjecPsikoafektif").html(msg);	
							}
						});
						return false;
					});//Submit End
						$.ajax({
							type: "POST",
							data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&'+$("form#filterpelajarandpsikoAfektif").serialize()+'&nama_kelas='+$('#filterpelajarandpsikoAfektif select#kelasPsikoafektif :selected').attr('nama_kelas')+'&id_jurusan='+$('#filterpelajarandpsikoAfektif select#kelasPsikoafektif :selected').attr('id_jurusan'),
							url: '<?=base_url()?>akademik/nilai/getpsikoafektif',
							beforeSend: function() {
								$("#filterpelajarandpsikoAfektif select#kelasPsikoafektif").after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
							},
							success: function(msg) {
								$("#wait").remove();
								$("#subjecPsikoafektif").html(msg);	
							}
						});
					$("#masukbuttonPsikoafektif").click(function(){
						$.ajax({
							type: "POST",
							data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&',
							url: '<?=base_url()?>akademik/nilai/addnilai/<?=base64_encode($jenis);?>',
							beforeSend: function() {
								$("#masukbuttonPsikoafektif").after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
							},
							success: function(msg) {
								$("#wait").remove();
								$("#subjecPsikoafektif").html(msg);	
							}
						});
						return false;
					});//Submit End
				
				});
					function deletesubjnilai(obj,idsubject){
						if(confirm('Jika subject di hapus maka nilai juga akan terhapus')){
							$.ajax({
								type: "POST",
								data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&id='+idsubject,
								url: '<?=base_url()?>akademik/nilai/deletesubjectnilai',
								beforeSend: function() {
									$(obj).after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
								},
								success: function(msg) {
									$("#wait").remove();
									$("#tab"+idsubject).remove();
									$("#cnttab"+idsubject).remove();
									$('div#subjecPsikoafektif .tabs-vertical-frame-content').first().attr('style','display:block;');
									$('div#subjecPsikoafektif ul.tabs-vertical-frame li').first().addClass('current');
									$('div#subjecPsikoafektif ul.tabs-vertical-frame li').first().children('a').addClass('current');
								}
							});
							return false;						
						}
	
					}
					function editsubjnilai(obj,idsubject,id_kelas,id_pelajaran,remidial,subject){
						
							$.ajax({
								type: "POST",
								data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&id_subject='+idsubject+'&kelas='+id_kelas+'&pelajaran='+id_pelajaran+'&remidial='+remidial+'&subject='+subject,
								url: '<?=base_url()?>akademik/nilai/editnilai/<?=base64_encode($jenis)?>',
								beforeSend: function() {
									$(obj).after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
								},
								success: function(msg) {
									$("#wait").remove();
									$("#subjecPsikoafektif").html(msg);
									
								}
							});
							return false;						
						
	
					}
				</script>
				<h3><?=$jenis?></h3>
				<div class="hr"></div>
				
				<div id="contentpage">
							<form action="" method="post" id="filterpelajarandpsikoAfektif" >
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
							<table class="tabelfilter">
								<tr>
								<td>
									Kelas :
										<select class="selectfilter" id="kelasPsikoafektif" name="id_kelas">
											<? foreach($kelas as $datakelas){?>
											<option <? if(@$_POST['kelas']==$datakelas['id']){echo 'selected';}?> value="<?=$datakelas['id']?>" id_jurusan="<?=$datakelas['id_jurusan']?>" nama_kelas="<?=$datakelas['kelas']?>"><?=$datakelas['kelas']?><?=$datakelas['nama']?></option>
											<? } ?>
										</select>
										<input type="hidden" name="jenis" value="<?=$jenis?>" />
										<!--<a id="masukbuttonPsikoafektif" title="" class="readmore"> Masukkan <br /> Nilai </a>-->
									</td>
								</tr>
							</table>
							<input type="hidden" name="ajax" value="1" />
							</form>
							<div id="subjecPsikoafektif">
								<?php $this->load->view('akademik/nilai/getpsikoafektif'); ?>
							</div>
					</div>
