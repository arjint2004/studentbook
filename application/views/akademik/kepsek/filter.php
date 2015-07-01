<script>
				$(document).ready(function(){

					$("#filterpelajaranpembelajaran select#kelas<?=$_POST['idload']?>").change(function(e){
						$.ajax({
							type: "POST",
							data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&'+$("form#filterpelajaranpembelajaran").serialize(),
							url: '<?=base_url()?>admin/pelajaran/getMapelByKelas/'+$(this).val(),
							beforeSend: function() {
								$("#filterpelajaranpembelajaran select#kelas<?=$_POST['idload']?>").after("<img id='wait<?=$_POST['idload']?>' src='<?=$this->config->item('images').'loading.png';?>' />");
								$("#subjectlist table.tabelkelas tbody").html("");
							},
							success: function(msg) {
								$("#wait<?=$_POST['idload']?>").remove();
								$("#pelajaran<?=$_POST['idload']?>").html(msg);	
							}
						});
						return false;
					});//Submit End
					$("#filterpelajaranpembelajaran select#pelajaran<?=$_POST['idload']?>").change(function(e){
						$.ajax({
							type: "POST",
							data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&'+$("form#filterpelajaranpembelajaran").serialize(),
							url: '<?=$url?>',
							beforeSend: function() {
								$("#filterpelajaranpembelajaran select#pelajaran<?=$_POST['idload']?>").after("<img id='wait<?=$_POST['idload']?>' src='<?=$this->config->item('images').'loading.png';?>' />");
							},
							success: function(msg) {
								$("#wait<?=$_POST['idload']?>").remove();
								$("#subjectlist<?=$_POST['idload']?>").html(msg);	
								$("div.actedit").remove();	
								$("div.actdell").remove();	
								$( ".profile .toggle-frame table.noborder tr td.title a" ).each(function() {
									var list = $(this).attr('href').split('/');
									if($(this).html()=='Lihat'){
										//alert(list.toSource());
										var urlx=list[0]+"/"+list[1]+"/"+list[2]+"/"+list[3]+"/"+list[4]+"/"+list[5]+"/"+list[6]+"/null/null/null/null/null/null/"+list[14];
										$(this).attr('href',urlx);
									}
									//$(this).addClass( "foo" );
								});
								
							}
						});
						return false;
					});//Submit End
					
					$.ajax({
							type: "POST",
							data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&ajax=1&kepsek=1',
							url: '<?=$url?>',
							beforeSend: function() {
								$("#filterpelajaranpembelajaran select#pelajaran<?=$_POST['idload']?>").after("<img id='wait<?=$_POST['idload']?>' src='<?=$this->config->item('images').'loading.png';?>' />");
							},
							success: function(msg) {
								$("#wait<?=$_POST['idload']?>").remove();
								$("#subjectlist<?=$_POST['idload']?>").html(msg);	
								$("div.actedit").remove();	
								$("div.actdell").remove();	
								$( ".profile .toggle-frame table.noborder tr td.title a" ).each(function() {
									var list = $(this).attr('href').split('/');
									if($(this).html()=='Lihat'){
										//alert(list.toSource());
										var urlx=list[0]+"/"+list[1]+"/"+list[2]+"/"+list[3]+"/"+list[4]+"/"+list[5]+"/"+list[6]+"/null/null/null/null/null/null/"+list[14];
										$(this).attr('href',urlx);
									}
									//$(this).addClass( "foo" );
								});
								
							}
						});
				});

				</script>

				<div id="contentpage">
							<form action="" method="post" id="filterpelajaranpembelajaran" >
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
							<table class="tabelfilter">
								<tr>
								<td>
									Kelas :
										<select class="selectfilter" id="kelas<?=$_POST['idload']?>" name="id_kelas">
											<option value="">Pilih Kelas</option>
											<? foreach($kelas as $datakelas){?>
											<option <? if(@$_POST['kelas']==$datakelas['id']){echo 'selected';}?> value="<?=$datakelas['id']?>"><?=$datakelas['kelas']?><?=$datakelas['nama']?></option>
											<? } ?>
										</select>

									
									Pelajaran :
										<select class="selectfilter" id="pelajaran<?=$_POST['idload']?>" name="pelajaran">
											<option value="">Pilih Pelajaran</option>
											<? if(!empty($pelajaran)){foreach($pelajaran as $datapelajaran){?>
											<option <? if(@$_POST['pelajaran']==$datapelajaran['id']){echo 'selected';}?> value="<?=$datapelajaran['id']?>"><?=$datapelajaran['nama']?></option>
											<? } } ?>
										</select>
										
									</td>
								</tr>
							</table>
							<input type="hidden" name="ajax" value="1" />
							</form>
							<div id="subjectlist<?=$_POST['idload']?>">
								<?php //$this->load->view('akademik/pembelajaran/daftarpembelajaranlist'); ?>
							</div>
					</div>