				<script>
				$(document).ready(function(){
					//Submit Start
					$(".editdata").click(function(e){
						$('#ajaxside').load('<?=base_url()?>/admin/pelajaran/editData/'+$(this).attr('id'));
					});
					
					$("#filterpelajaran select#kelas").change(function(e){
						$.ajax({
							type: "POST",
							data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&'+$("form#filterpelajaran").serialize(),
							url: '<?=base_url()?>/admin/pelajaran/getmapelByKelas/'+$(this).val(),
							beforeSend: function() {
								$("#ajaxside").html("<img src='<?=$this->config->item('images').'loading.png';?>' />");
							},
							success: function(msg) {
								$("#ajaxside").html("");
								$("#pelajaran").html(msg);	
							}
						});
						return false;
					});//Submit End
				
				});

				</script>
				<div id="contentpage">
							<form action="" method="post" id="filterpelajaran" >
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

									</td>
								</tr>
							</table>
							<input type="hidden" name="ajax" value="1" />
							</form>
							<table class="tabelkelas">
								<thead>
									<!--<tr> 
										<th colspan='7'><b>Daftar Ulangan Harian</b></th>
									</tr>  --> 
									<tr> 
										<th>No</th>
										<th>Subject</th>
										<th>Semester</th>
										<th>Action</th>
									</tr>                         
								</thead>
								<tbody>
								<? 
								$i=1;
								foreach($subject as $datasubject){?>
									<tr>
										<td><?=$i++?></td>
										<td><?=$datasubject['nama']?></td>
										<td><?=$datasubject['nama_jurusan']?></td>
										<td><a class="editdata" style="cursor:pointer;" id="<?=$datasubject['id']?>">Edit</a> | <a href="">Delete</a></td>
									</tr>
								<? } ?>
								</tbody>
							</table>
							  <div id="ajax_paging">
								<?php //echo $pagination; ?>
							  </div>
							
					</div>
