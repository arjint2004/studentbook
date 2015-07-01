				<script>
				$(document).ready(function(){
					
					$(".editdata").click(function(e){
						$('#ajaxside').load('<?=base_url()?>admin/pelajaran/editData/'+$(this).attr('id'));
					});
					
					$("#filterpelajaranSubjectlain select#kelasListdubjectlain").change(function(e){
						$.ajax({
							type: "POST",
							data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&'+$("form#filterpelajaranSubjectlain").serialize(),
							url: '<?=base_url()?>akademik/nilai/getsubject/<?=base64_encode($jenis);?>',
							beforeSend: function() {
								$("#filterpelajaranSubjectlain select#kelasListdubjectlain").after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
							},
							success: function(msg) {
								$("#wait").remove();
								$("#subjectlistlain").html(msg);	
							}
						});
						return false;
					});
					
					$("#masukbuttonListlain").click(function(){
						$.ajax({
							type: "POST",
							data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&',
							url: '<?=base_url()?>akademik/nilai/addnilai/<?=base64_encode($jenis);?>',
							beforeSend: function() {
								$("#masukbuttonListlain").after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
							},
							success: function(msg) {
								$("#wait").remove();
								$("#subject").html(msg);	
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
									$("#subject").html(msg);
									
								}
							});
							return false;						
						
	
					}
				</script>
				<h3><?=$jenis?></h3>
				<div class="hr"></div>
				
				<div id="contentpage">
							<form action="" method="post" id="filterpelajaranSubjectlain" >
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
							<table class="tabelfilter">
								<tr>
								<td>
									Kelas :
										<select class="selectfilter" id="kelasListdubjectlain" name="id_kelas">
											<option value="">Pilih Kelas</option>
											<? foreach($kelas as $datakelas){?>
											<option <? if(@$_POST['kelas']==$datakelas['id']){echo 'selected';}?> value="<?=$datakelas['id']?>"><?=$datakelas['kelas']?><?=$datakelas['nama']?></option>
											<? } ?>
										</select>
										<input type="hidden" name="jenis" value="<?=$jenis?>" />
										<a id="masukbuttonListlain" title="" class="readmore"> Masukkan <br /> Nilai </a>
									</td>
								</tr>
							</table>
							<input type="hidden" name="ajax" value="1" />
							<input type="hidden" name="pelajaran" value="0" />
							</form>
							<div id="subjectlistlain">
								<?php $this->load->view('akademik/nilai/getsubject'); ?>
							</div>
					</div>
