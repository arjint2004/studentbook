				<script>
				$(document).ready(function(){

				});

				</script>
				<? //pr($kkm);?>
				<div id="contentpage">
							
							<form action="<?=base_url()?>admin/nilaikkm/listData" method="post" id="filterpelajaranadd" >
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
							<table class="tabelkelas">
								<thead>
									<tr> 
										<th>No</th>
										<th>Pelajaran</th>
										<th>Jenjang</th>
										<th>Jurusan</th>
										<th>Semester</th>
										<th>Kelompok</th>
										<th>Nilai</th>
									</tr>                            
								</thead>
								<tbody>
								<? 
								$i=1;
								foreach($pelajaran as $datapel){
								if(@$kkm[$datapel['id']]['nilai']==''){@$kkm[$datapel['id']]['nilai']=0;} 
								?>
									<tr>
										<td><?=$i++?></td>
										<td class="title"><?=$datapel['nama']?></td>
										<td><?=$datapel['kelas']?></td>
										<td><?=$datapel['nama_jurusan']?></td>
										<td><?=$datapel['nama_semester']?></td>
										<td><?=$datapel['kelompok']?></td>
										<td>
										<input style="margin:0; padding:5px;" type="text" name="nilaikkm[<?=$datapel['id']?>]" value="<?=@$kkm[$datapel['id']]['nilai']?>" />
										<input type="hidden" name="idkkm[<?=$datapel['id']?>]" value="<?=@$kkm[$datapel['id']]['id']?>" />
										</td>
									</tr>
								<? } ?>
								</tbody>
							</table>
							
							<input type="hidden" name="ajax" value="1" />
							<input type="hidden" name="addkkm" value="1" />
							</form>
							  <div id="ajax_paging">
								<?php //echo $pagination; ?>
							  </div>
							
					</div>
