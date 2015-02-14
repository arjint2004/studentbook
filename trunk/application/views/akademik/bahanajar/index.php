					<script>
						/**
						 * Tabs Shortcodes
						 */
						
						
						if($('.tabs-vertical-frame').length > 0){
							$('.tabs-vertical-frame').tabs('> .tabs-vertical-frame-content');
							
							$('.tabs-vertical-frame').each(function(){
								$(this).find("li:first").addClass('first').addClass('current');
								$(this).find("li:last").addClass('last');
							});

							$('.tabs-vertical-frame li').click(function(){ 
								$(this).parent().children().removeClass('current');
								$(this).addClass('current');
							});
						}
						/*Tabs Shortcode Ends*/
					</script>
					<style>
					ul.tabrencana li a {
					  width: 88.5%;
					}
					</style>
					
								<script>
									$(document).ready(function(){
										//Submit Start

										
										$("ul.file div.actdell").click(function(){
											var objdell=$(this);
											if(confirm('File akan di hapus secara permanen, untuk menggunakannya kembali anda harus upload ulang..')){
												$.ajax({
													type: "POST",
													data: '',
													url: base_url+'akademik/instrumen/deletefilepemb/'+$(this).attr('id'),
													beforeSend: function() {
														$(objdell).after("<img id='wait' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
													},
													success: function(msg) {
														$("#wait").remove();	
														$(objdell).parent().remove();
													}
												});
												return false;
											}
										});
										
										$("div#actdellpemp").click(function(){
											var objdell=$(this);
											if(confirm('Data dan File akan di hapus secara permanen, untuk menggunakannya kembali anda harus upload ulang..')){
												$("#subjectevaluasi").append("<div class=\"error-box\" style='display: block; top: 50%; position: fixed; left: 46%;'></div>");
												$(".error-box").html("Memproses Data").fadeIn("slow");
												$.ajax({
													type: "POST",
													data: '',
													url: base_url+'akademik/instrumen/deletepert/'+$(this).attr('id_pemb'),
													beforeSend: function() {
														$(objdell).after("<img id='wait' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
													},
													error	: function(){
														$(".error-box").delay(1000).html('Pemrosesan data gagal');
														$(".error-box").delay(1000).fadeOut("slow",function(){
															$(this).remove();
														});
														
													},
													success: function(msg) {
														$("#wait").remove();	
														if(msg==1){
															$('ul.tabs-vertical-frame li#tab'+$(objdell).attr('id_pemb')).remove();
															$('div#cnttab'+$(objdell).attr('id_pemb')).remove();
															$('div.tabs-vertical-frame-content').first().attr('style','display:block;');
															$('ul.tabs-vertical-frame li').first().addClass('current');
															$('ul.tabs-vertical-frame li').first().children('a').addClass('current');
															$(".error-box").delay(1000).html('Data berhasil di hapus');
															$(".error-box").delay(1000).fadeOut("slow",function(){
																$(this).remove();
															});
														}
														
													}
												});
												return false;
											}
										});
										
										
									});
								</script>
				<!--<h3 style="margin-top:0px;">SMP Kelas 7 </h3>
				<br />		-->	
				<? $jenjang="SMP";?>
				<div class="tabs-vertical-container">
						<ul class="tabs-vertical-frame tabnilai ">
							<? foreach($file as $kelas=>$namafile){?>
								<li  class="first current"><a href="#" class="current"><h5 style="text-align:left;"><?=$kelas?></h5><span></span></a></li>
							<? } ?>
						</ul>
						<? foreach($file as $kelas=>$namafile){?>
						<div class="tabs-vertical-frame-content vcontnilai" style="display: block;">
							
							<?
							   foreach($namafile as $namafilex){?>
								<div>          
									<h6 style="margin:0;text-transform:capitalize;" class="role"><b>tahun 2011</b></h6>
									<p> <a target="__blank" href="<?=base_url()?>upload/contentsekolah/<?=$jenjang?>/<?=$kelasdir?>/<?=$kelas?>/<?=$namafilex?>" class="notif"><?=str_replace("_"," ",$namafilex)?></a> </p>
								</div>
							<? } ?>
						</div>
						<? } ?>
                </div>
						