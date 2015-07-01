				<script>
				$(document).ready(function(){
					//Submit Start
					$(".editdata").click(function(e){
						$('#ajaxside').load('<?=base_url()?>/admin/pelajaran/editData/'+$(this).attr('id'));
					});
					
					$("#filterpelajaran select.selectfilter").change(function(e){
						$.ajax({
							type: "POST",
							data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&'+$("form#filterpelajaran").serialize(),
							url: $("form#filterpelajaran").attr('action'),
							beforeSend: function() {
								$("#ajaxside").html("<img src='<?=$this->config->item('images').'loading.png';?>' />");
							},
							success: function(msg) {
								$("#ajaxside").html("");
								$("#listpelajaran").html(msg);	
							}
						});
						return false;
					});//Submit End
				
				});

				</script>
				<div id="contentpage">
							<form action="<?=base_url()?>/admin/pelajaran/listData" method="post" id="filterpelajaran" >
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
							<table class="tabelfilter">
								<tr>
									<td>
										<select class="selectfilter" name="jenjang">
											<option value="">Pilih Jenjang</option>
											<? foreach($grade as $jenjang){?>
											<option <? if(@$_POST['jenjang']==$jenjang){echo 'selected';}?> value="<?=$jenjang?>"><?=$jenjang?></option>
											<? } ?>
										</select>
									
										<select class="selectfilter" name="id_jurusan">
											<option value="">Pilih Jurusan</option>
										<? foreach($jurusan as $jurusandata){ ?>
											<option <? if(@$_POST['id_jurusan']==$jurusandata['id']){echo 'selected';}?> value="<?=$jurusandata['id']?>"><?=$jurusandata['nama']?></option>
										<? } ?>
										</select>
									
										<select class="selectfilter" name="semester">
											<option value="">Pilih Semester</option>
											<? foreach($semester as $datasemester){?>
											<option <? if(@$_POST['semester']==$datasemester['id']){echo 'selected';}?> value="<?=$datasemester['id']?>"><?=$datasemester['nama']?></option>
											<? } ?>
										</select>
									</td>
								</tr>
							</table>
							<input type="hidden" name="ajax" value="1" />
							</form>
							<table class="tabelkelas">
								<thead>
									<tr> 
										<th>No</th>
										<th>Pelajaran</th>
										<th>Jurusan</th>
										<th>Semester</th>
										<th>Jenjang Kelas</th>
										<th>Kelompok</th>
										<th>Action</th>
									</tr>                            
								</thead>
								<tbody>
								<? 
								$i=1;
								foreach($pelajaran as $datapel){?>
									<tr>
										<td><?=$i++?></td>
										<td><?=$datapel['nama']?></td>
										<td><?=$datapel['nama_jurusan']?></td>
										<td><?=$datapel['semester']?></td>
										<td><?=$datapel['kelas']?></td>
										<td><?=$datapel['kelompok']?></td>
										<td><a class="editdata" style="cursor:pointer;" id="<?=$datapel['id']?>">Edit</a> | <a href="">Delete</a></td>
									</tr>
								<? } ?>
								</tbody>
							</table>
							  <div id="ajax_paging">
								<?php //echo $pagination; ?>
							  </div>
							
					</div>
