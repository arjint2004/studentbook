<script>
				$(document).ready(function(){

					$("#filterpelajaranpembelajaran select#filterrpp").change(function(e){
						$.ajax({
							type: "POST",
							data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&filter='+$(this).val(),
							url: '<?=base_url()?>akademik/kepsek/filterrpp',
							beforeSend: function() {
								$("#filterpelajaranpembelajaran select#filterrpp").after("<img id='waitfrpp' src='<?=$this->config->item('images').'loading.png';?>' />");
								$("#subjectlist table.tabelkelas tbody").html("");
							},
							success: function(msg) {
								$("#waitfrpp").remove();
								$("#pelajaran").html(msg);	
							}
						});
						return false;
					});//Submit End
					$("#filterpelajaranpembelajaran select#id_pegawai<?=$_POST['idload']?>").change(function(e){
						var obj=$(this);
						$.ajax({
							type: "POST",
							data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&'+$("form#filterpelajaranpembelajaran").serialize(),
							url: '<?=$url?>/0/'+$(obj).val(),
							beforeSend: function() {
								$("#filterpelajaranpembelajaran select#pelajaran<?=$_POST['idload']?>").after("<img id='wait<?=$_POST['idload']?>' src='<?=$this->config->item('images').'loading.png';?>' />");
							},
							success: function(msg) {
								$("#wait<?=$_POST['idload']?>").remove();
								$("#subjectlist<?=$_POST['idload']?>").html(msg);	
								$("div.actedit").remove();	
								$("div.actdell").remove();
								$(".vcontnilai div.file").each(function(msg) {
										if($(this).attr('class')=='file'){$(this).remove();}
										
								});
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
									$(".vcontnilai div.file").each(function(msg) {
										if($(this).attr('class')=='file'){$(this).remove();}
										
									});
								$( ".profile .toggle-frame table.noborder tr td.title a" ).each(function() {
									var list = $(this).attr('href').split('/');
									if($(this).html()=='Lihat'){
										//alert(list.toSource());
										var urlx=list[0]+"/"+list[1]+"/"+list[2]+"/"+list[3]+"/"+list[4]+"/"+list[5]+"/"+list[6]+"/null/null/null/null/null/null/"+list[14];
										$(this).attr('href',urlx);
										$("div#").remove();	
									}
									//$(this).addClass( "foo" );
								});
								
							}
					});
					if($('ul.tabs-framerpp').length > 0) $('ul.tabs-framerpp').tabs('> .tabs-frame-content2');
				});

				</script>

				<div id="contentpage">
				
					<div class="tabs-container">
						<ul class="tabs-frame tabs-framerpp">
							<li><a href="#">Statistik</a></li>
							<li><a href="#">Data RPP</a></li>
						</ul>
						<div class="tabs-frame-content tabs-frame-content2">

						</div>
						<div class="tabs-frame-content tabs-frame-content2 ">
							<form action="" method="post" id="filterpelajaranpembelajaran" >
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
							<table class="tabelfilter">
								<tr>
								<td>
									Guru :
										<select class="selectfilter" id="id_pegawai<?=$_POST['idload']?>" name="id_pegawai">
											<option value="">Pilih Guru</option>
											<? foreach($guru as $dataguru){?>
											<option  value="<?=$dataguru['id_peg']?>"><?=$dataguru['nama']?></option>
											<? } ?>
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
					</div>	
					
				</div>