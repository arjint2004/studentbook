				<script>
					function deletedata(obj){
						$.ajax({
							type: "POST",
							data: '',
							url: $(obj).attr('url'),
							beforeSend: function() {
								$("#ajaxside").html("<img src='<?=$this->config->item('images').'loading.png';?>' />");
							},
							success: function(msg) {
								if(msg>0){
									alert('Data Pengajaran ini tidak bisa di hapus karena masih mempunyai data akademik yang berelasi dengan(PR,TUGAS,ULANGAN HARIAN, UTS, UAS).');
								}else{
									$.ajax({
										type: "POST",
										data: $("form#filterpengajaran").serialize(),
										url: $("form#filterpengajaran").attr('action'),
										beforeSend: function() {
											$("#ajaxside").html("<img src='<?=$this->config->item('images').'loading.png';?>' />");
										},
										success: function(msg) {
											$("#ajaxside").html("");
											$("#listpengajaran").html(msg);	
										}
									});
									return false;									
								}
							}
						});
						return false;
					}
				$(document).ready(function(){
					//Submit Start

					
					
					$(".editdata").click(function(e){
						//$('#ajaxside').load('<?=base_url()?>/admin/pengajaran/editData/'+$(this).attr('id'));
					});
					
					$("#filterpengajaran select.selectfilter").change(function(e){
						$.ajax({
							type: "POST",
							data: $("form#filterpengajaran").serialize(),
							url: $("form#filterpengajaran").attr('action'),
							beforeSend: function() {
								$("#ajaxside").html("<img src='<?=$this->config->item('images').'loading.png';?>' />");
							},
							success: function(msg) {
								$("#ajaxside").html("");
								$("#listpengajaran").html(msg);	
							}
						});
						return false;
					});//Submit End
					$("a#operpengajar").click(function(e){
						$.ajax({
							type: "POST",
							data: 'ajax=1&id_pengajar='+$(this).attr('id_pengajar')+'&id_pegawai='+$(this).attr('id_pegawai'),
							url: $(this).attr('url'),
							beforeSend: function() {
								$(this).after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
							},
							success: function(msg) {
								$("#wait").remove();
								$("#ajaxside").html(msg);	
							}
						});
						return false;
					});//Submit End
				
				});

				</script>
				<?//pr($pengajaran);?>
				<div id="contentpage">
							<form action="<?=base_url()?>admin/pengajaran/listData" method="post" id="filterpengajaran" >
							<table class="tabelfilter">
								<tr>
									<td>Filter Guru
										<select class="selectfilter" name="id_pegawai">
											<option value="">Pilih Guru</option>
											<? foreach($pegawai as $datapeg){?>
											<option <? if(@$_POST['id_pegawai']==$datapeg['id']){echo 'selected';}?> value="<?=$datapeg['id']?>"><?=$datapeg['nama']?></option>
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
										<th>Guru</th>
										<th>Kelas</th>
										<th>Semester</th>
										<th>Jurusan</th>
										<th>Pelajaran</th>
										<th>Action</th>
									</tr>                            
								</thead>
								<tbody>
								<? 
								$i=1;
								foreach($pengajaran as $datapel){?>
									<tr>
										<td><?=$i++?></td>
										<td class="title"><?=$datapel['nama_guru']?></td>
										<td class=""><?=$datapel['kelas']?><?=$datapel['nama']?></td>
										<td class=""><?=$datapel['semester']?></td>
										<td class="title"><?=$datapel['nama_jurusan']?></td>
										<td class="title"><?=$datapel['nama_pelajaran']?></td>
										<td><a class="editdata" style="cursor:pointer;" id="<?=$datapel['id_pengajaran']?>"  onclick="$('#ajaxside').load('<?=base_url()?>admin/pengajaran/editdata/<?=$datapel['id_pengajaran']?>')">Edit</a> | 
										<a style="cursor:pointer;" onclick="if(confirm ('Anda yakin menghapus data ini?')){ deletedata(this);}" url="<?=base_url()?>admin/pengajaran/deletedata/<?=$datapel['id_pengajaran']?>">Delete</a> <!--| 
										<a style="cursor:pointer;" id="operpengajar" id_pengajar="<?=$datapel['id_pengajaran']?>" id_pegawai="<?=$datapel['id_pegawai']?>" url="<?=base_url()?>admin/pengajaran/oper/<?=$datapel['id_pengajaran']?>/<?=$datapel['id_pegawai']?>">Oper Pengajar</a>--></td>
									</tr>
								<? } ?>
								</tbody>
							</table>
							  <div id="ajax_paging">
								<?php //echo $pagination; ?>
							  </div>
							
					</div>
