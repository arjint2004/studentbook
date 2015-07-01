				<script>
				$(document).ready(function(){
					//Submit Start
					$(".editdata").click(function(e){
						e.stopImmediatePropagation();
						$('#ajaxside').load('<?=base_url()?>admin/pelajaran/editData/'+$(this).attr('id'));
						$("#ajaxside").scrollintoview({ speed:'1100'});
					});
					$(".addsub").click(function(e){
						var thisobj=$(this);
						if($('select#jenjangselect').val()==''){
							$('select#jenjangselect').css('border','1px solid red');
							$("select#semesterselect").scrollintoview({ speed:'1100'}); 
							return false;
						}
						if($('select#semesterselect').val()==''){
							$('select#semesterselect').css('border','1px solid red');
							$("select#semesterselect").scrollintoview({ speed:'1100'}); 
							return false;
						}
						$.ajax({
								type: "POST",
								data: "<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&ajax=1&id_pelajaran="+$(thisobj).attr('id')+"&jenjang="+$('select#jenjangselect').val()+"&jurusan="+$('input#id_jurusan').val()+"&semester="+$('select#semesterselect').val(),
								url: base_url+'admin/pelajaran/adddatasub',
								beforeSend: function() {
									$(thisobj).append("<img id='wait' src='"+config_images+"loaderhover.gif' />");
								},
								success: function(msg) {
									$("#wait").remove();			
									$("#ajaxside").html(msg);	
									$("#ajaxside").scrollintoview({ speed:'1100'}); 
								}
						});
						
					});
					$("table#tablepelajaran tr td a.delete").click(function(e){
						var thisobj=$(this);
						if(confirm('Data akan di hapus!')){
							$.ajax({
								type: "POST",
								data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&ajax=1&id_pelajaran='+$(thisobj).attr('id'),
								url: '<?=base_url()?>admin/pelajaran/delete/'+$(thisobj).attr('id'),
								beforeSend: function() {
									$(thisobj).append("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
								},
								success: function(msg) {
									$("#wait").remove();
									parseInt(msg);
									if(msg>0){
										alert('Data pelajaran ini tidak bisa di hapus karena kemungkinan masih digunakan.');
									}else{
										$.ajax({
											type: "POST",
											data: "<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&ajax=1",
											url: base_url+'admin/pelajaran/listData',
											beforeSend: function() {
												$("#listpelajaranloading").html("<img src='"+config_images+"loading.png' />");
											},
											success: function(msg) {
												$("#listpelajaran").html(msg);			
											}
										});									
									}
									
								}
							});
						}
						
						return false;
					});
					
					$("#filterpelajaran select.selectfilter").change(function(e){
						var thisobj=$(this);
						$.ajax({
							type: "POST",
							data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&'+$("form#filterpelajaran").serialize(),
							url: $("form#filterpelajaran").attr('action'),
							beforeSend: function() {
								$(thisobj).after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
							},
							success: function(msg) {
								$("#wait").remove();
								$("#listpelajaran").html(msg);	
							}
						});
						return false;
					});//Submit End
				
				});
				
				function getdetail(id,obj){
					$('#sub'+id).toggle('fade');
					$.ajax({
						type: "POST",
						data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&ajax=1',
						url: '<?=base_url()?>admin/pelajaran/listDataSub/'+id+'',
						beforeSend: function() {
							//$("#filterpelajaranharian select#kelas").after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
											
						},
						success: function(msg) {
							//$("#wait").remove();
							$('#subload'+id).html(msg);	
						}
					});
					return false;
				}
				
				</script>
				<div id="contentpage">
							<form action="<?=base_url()?>admin/pelajaran/listData" method="post" id="filterpelajaran" >
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
							<table class="tabelfilter">
								<tr>
									<td>
										Jenjang
										<select class="selectfilter" id="jenjangselect" name="jenjang">
											<option value="">Pilih Jenjang</option>
											<? foreach($grade as $jenjang){?>
											<option <? if(@$_POST['jenjang']==$jenjang){echo 'selected';}?> value="<?=$jenjang?>"><?=$jenjang?></option>
											<? } ?>
										</select>
										
										<? if($this->session->userdata['ak_setting']['jenjang'][0]['nama']!='SD' && $this->session->userdata['ak_setting']['jenjang'][0]['nama']!='SMP'){?>
										Jurusan
										<select class="selectfilter" id="jurusanselect" name="id_jurusan">
											<option value="">Pilih Jurusan</option>
										<? foreach($jurusan as $jurusandata){ ?>
											<option <? if(@$_POST['id_jurusan']==$jurusandata['id']){echo 'selected';}?> value="<?=$jurusandata['id']?>"><?=$jurusandata['nama']?></option>
										<? } ?>
										</select>
										<? }else{ ?>
										<input type="hidden" name="id_jurusan" id="id_jurusan" value="<?=$jurusan[0]['id']?>">
										<? } ?>
										Semester
										<select class="selectfilter" id="semesterselect" name="semester">
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
							<table  id="tablepelajaran">
								<thead>
									<tr> 
										<th>No</th>
										<th>Pelajaran</th>
										<? if($this->session->userdata['ak_setting']['jenjang'][0]['nama']!='SD' && $this->session->userdata['ak_setting']['jenjang'][0]['nama']!='SMP'){?>
										<th>Jurusan</th>
										<? }?>
										<th>Semester</th>
										<th>Jenjang Kelas</th>
										<? if($this->session->userdata['ak_setting']['jenjang'][0]['nama']!='SD' && $this->session->userdata['ak_setting']['jenjang'][0]['nama']!='SMP'){?>
										<th>Kelompok</th>
										<? }?>
										<th>Action</th>
									</tr>                            
								</thead>
								<tbody>
								<? 
								if(isset($pelajaran)){
								$i=1;
								foreach($pelajaran as $datapel){?>
									<tr  style="cursor:pointer;" title="Klik untuk menampilkan / menyembunyikan sub mata pelajaran" onclick="getdetail(<?=$datapel['id']?>,this);">
										<td><?=$i++?></td>
										<td class="title"><?=$datapel['nama']?></td>
										<? if($this->session->userdata['ak_setting']['jenjang'][0]['nama']!='SD' && $this->session->userdata['ak_setting']['jenjang'][0]['nama']!='SMP'){?>
										<td><?=$datapel['nama_jurusan']?></td>
										<? }?>
										<td><?=$datapel['nama_semester']?></td>
										<td><?=$datapel['kelas']?></td>
										<? if($this->session->userdata['ak_setting']['jenjang'][0]['nama']!='SD' && $this->session->userdata['ak_setting']['jenjang'][0]['nama']!='SMP'){?>
										<td><?=$datapel['kelompok']?></td>
										<? }?>
										<td>
										<a class="addsub" style="cursor:pointer;" id="<?=$datapel['id']?>">Add Sub Mapel</a> |
										<a class="editdata" style="cursor:pointer;" id="<?=$datapel['id']?>">Edit</a> |
										<a class="delete"  style="cursor:pointer;" id="<?=$datapel['id']?>">Delete</a>
										</td>
									</tr>
									
									<tr id="sub<?=$datapel['id']?>" style="display:none;" class="submapel">
										<td colspan="<? if($this->session->userdata['ak_setting']['jenjang'][0]['nama']!='SD' && $this->session->userdata['ak_setting']['jenjang'][0]['nama']!='SMP'){echo 7;}else{echo 5;}?>" id="subload<?=$datapel['id']?>">
										
										</td>
									</tr>
								<? } } ?>
								</tbody>
							</table>
							  <div id="ajax_paging">
								<?php //echo $pagination; ?>
							  </div>
							
					</div>
