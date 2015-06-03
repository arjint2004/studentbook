				<script>
				$(document).ready(function(){
					//Submit Start
					$(".editdata").click(function(e){
						$('#ajaxside').load('<?=base_url()?>admin/pelajaran/editData/'+$(this).attr('id'));
					});
					
					$("#filterpelajaranlistSubject select#kelasListdubject").change(function(e){
						$.ajax({
							type: "POST",
							data: $("form#filterpelajaranlistSubject").serialize(),
							url: '<?=base_url()?>admin/pelajaran/getMapelByKelasAndPegawai/'+$(this).val(),
							beforeSend: function() {
								$("#filterpelajaranlistSubject select#kelasListdubject").after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
								$("#subjectnilailist table.tabelkelas tbody").html("");
							},
							success: function(msg) {
								$("#wait").remove();
								$("#pelajaranlistsubject").html(msg);	
							}
						});
						return false;
					});//Submit End
					$("#filterpelajaranlistSubject select#pelajaranlistsubject").change(function(e){
						$.ajax({
							type: "POST",
							data: $("form#filterpelajaranlistSubject").serialize(),
							url: '<?=base_url()?>akademik/nilai/getsubject',
							beforeSend: function() {
								$("#filterpelajaranlistSubject select#pelajaranlistsubject").after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
							},
							success: function(msg) {
								$("#wait").remove();
								$("#subjectnilailist").html(msg);	
							}
						});
						return false;
					});//Submit End
					$("#masukbuttonlistSubject").click(function(){
						$.ajax({
							type: "POST",
							data: '',
							url: '<?=base_url()?>akademik/nilai/addnilai/<?=base64_encode($jenis);?>',
							beforeSend: function() {
								$("#masukbuttonlistSubject").after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
							},
							success: function(msg) {
								$("#wait").remove();
								$("#subjectnilailist").html(msg);	
							}
						});
						return false;
					});//Submit End
				
				});
					function deletesubjnilai(obj,idsubject,jenis){
						if(confirm('Jika subject di hapus maka nilai juga akan terhapus')){
							$.ajax({
								type: "POST",
								data: 'id='+idsubject+'&jenis='+jenis,
								url: '<?=base_url()?>akademik/nilai/deletesubjectnilai',
								beforeSend: function() {
									$(obj).after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
								},
								success: function(msg) {
									$("#wait").remove();
									$("#tab"+idsubject).remove();
									$("#cnttab"+idsubject).remove();
									$('div#subjectnilailist .tabs-vertical-frame-content').first().attr('style','display:block;');
									$('div#subjectnilailist ul.tabs-vertical-frame li').first().addClass('current');
									$('div#subjectnilailist ul.tabs-vertical-frame li').first().children('a').addClass('current');
								}
							});
							return false;						
						}
	
					}
					function editsubjnilai(obj,idsubject,id_kelas,id_pelajaran,remidial,subject){
						
							$.ajax({
								type: "POST",
								data: 'id_subject='+idsubject+'&kelas='+id_kelas+'&pelajaran='+id_pelajaran+'&remidial='+remidial+'&subject='+subject,
								url: '<?=base_url()?>akademik/nilai/editnilai/<?=base64_encode($jenis)?>',
								beforeSend: function() {
									$(obj).after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
								},
								success: function(msg) {
									$("#wait").remove();
									$("#subjectnilailist").html(msg);
									
								}
							});
							return false;						
						
	
					}
				</script>
				<h3 id="namanilai"><? if($jenis=='NILAI KOMPETENSI'){echo "DESKRIPSI KEMAJUAN BELAJAR";}else{echo $jenis;}?></h3>
				<div class="hr"></div>
				
				<div id="contentpage">
							<form action="" method="post" id="filterpelajaranlistSubject" >
							<table class="tabelfilter">
								<tr>
								<td>
									Kelas :
										<select class="selectfilter" id="kelasListdubject" name="id_kelas">
											<option value="">Pilih Kelas</option>
											<? foreach($kelas as $datakelas){?>
											<option <? if(@$_POST['kelas']==$datakelas['id']){echo 'selected';}?> value="<?=$datakelas['id']?>"><?//=$datakelas['kelas']?><?=$datakelas['nama']?></option>
											<? } ?>
										</select>

									
									Pelajaran :
										<select class="selectfilter" id="pelajaranlistsubject" name="pelajaran">
											<option value="">Pilih Pelajaran</option>
											<? foreach($pelajaran as $datapelajaran){?>
											<option <? if(@$_POST['pelajaran']==$datapelajaran['id']){echo 'selected';}?> value="<?=$datapelajaran['id']?>"><?=$datapelajaran['nama']?></option>
											<? } ?>
										</select>
										<input type="hidden" name="jenis" value="<?=$jenis?>" />
										<a id="masukbuttonlistSubject" title="" class="readmore"> Masukkan <br /> Nilai </a>
									</td>
								</tr>
							</table>
							<input type="hidden" name="ajax" value="1" />
							</form>
							<div id="subjectnilailist">
								<?php $this->load->view('akademik/nilai/getsubject'); ?>
							</div>
					</div>
