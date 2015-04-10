
					<style>
					ul.tabrencana li a {
					  width: 88.5%;
					}
					</style>					
					<script>
									/**
									 * Tabs Shortcodes
									 */
									
									if($('ul.tabs-frame').length > 0) $('ul.tabs-frame').tabs('> .tabs-frame-content');
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
										/* 
										 * Toggle shortcode
										 */
										$('.toggle').toggle(function(){
											$(this).addClass('active');
										}, function () {
											$(this).removeClass('active');
										});

										$('.toggle').click(function(){
											$(this).next('.toggle-content').slideToggle();
										});
										
										$('.toggle-frame-set').each(function(i) {
											var $this = $(this),
												$toggle = $this.find('.toggle-accordion');
											
											$toggle.click(function(){
												if( $(this).next().is(':hidden') ) {
													$this.find('.toggle-accordion').removeClass('active').next().slideUp();
													$(this).toggleClass('active').next().slideDown();
												}
												return false;
											});
										});
									/*Tabs Shortcode Ends*/

									$(document).ready(function(){
										<? 
										if(isset($id) && $id!=''){
											?>
												$("a.<?=$id?>").click(function(){
													var ob=$(this);
													$("#contentbelajarid").append("<div class=\"error-box\" style='width:300px;display: block; top: 50%; position: fixed; left: 46%;'></div>");
													$(".error-box").delay(500).html('BERHASIL DITAMBAHKAN');
													
													$(".error-box").delay(500).fadeOut("slow",function(){
														$(this).remove();
													});	
													
													var data=JSON.parse($(this).attr('idcntbljr'));
													
													$("ul#addmatericontbljr").append('<li class="actdellcnt">'+data.kelasdir+'|'+data.pelajaran+'|'+$(this).attr('filename')+'<input type="hidden" name="cnrbljr[]" value="'+$(this).attr('idcntbljrphp')+'" /><div class="actdell"></div></li>');
														$("ul.file li div.actdell").click(function(){
															//if(confirm('File akan di hapus ?')){
																$(this).parent('li').remove();
															//}
														});
														
													return false;
												});											
											<?											
										}
										?>

									});
								</script>
				<!--<h3 style="margin-top:0px;">SMP Kelas 7 </h3>
				<br />		-->	
		                <!-- **Toggle Frame Set** -->  
                        <div class="toggle-frame-set" <?=$additional?>>
						<? //pr();?>
						<? if($jenjang=='SD'){?>
                            <div  class="toggle-frame" style="margin: 0px; border-radius: 5px 5px 0px 0px;padding-bottom:0px;">
                                <h5 class="toggle-accordion"><a href="#">Kurikulum 2013</a></h5>
                                <div class="toggle-content" style="display: none;">
									<ul class="tabs-frame">
										<? foreach($filek13 as $Kelasi=>$mapeli){?>
										<li>
											<a><?=$Kelasi?></a>
										</li>
										<? } ?>
									</ul>
									<? foreach($filek13 as $Kelas=>$mapel){?>
									<div class="tabs-frame-content contentbelajar" style="display: block; width:928px;" >
											<div class="tabs-vertical-container">
													<? foreach($mapel as $pelajaran=>$namafilex){?>
														
														<?
														   $th=explode("_",$namafilex);
														   $th=substr(end($th),0,-4);
														   //echo $th;
														   ?>
															<div>          
																<h6 style="margin:0;text-transform:capitalize;" class="role"><b>TAHUN <?=$th?></b></h6>
																<p> <a filename="<?=$namafilex?>" idcntbljrphp="<?=base64_encode(serialize(array('jenjang'=>$jenjang,'kelasdir'=>$Kelas,'pelajaran'=>$pelajaran,'filename'=>$namafilex)))?>"  idcntbljr='<?=json_encode(array('jenjang'=>$jenjang,'kelasdir'=>$Kelas,'pelajaran'=>$pelajaran,'filename'=>$namafilex))?>'  target="__blank" href="<?=base_url()?>upload/contentsekolah/k13/<?=$jenjang?>/<?=$Kelas?>/<?=$namafilex?>" class="notif <?=$id?>"><?=str_replace("_"," ",$namafilex)?></a> </p>
															</div>

													<? } ?>
											</div>		
									</div>
									<? } ?>
                                </div>
                            </div>
                            <?}else{?>
								<div  class="toggle-frame" style="margin: 0px; border-radius:0px 0px 5px 5px;padding-bottom:0px;">
									<h5 class="toggle-accordion"><a href="#">Kurikulum 2013</a></h5>
									<div class="toggle-content style" style="display: none;">

										<ul class="tabs-frame">
											<? foreach($filek13 as $Kelasi=>$mapeli){?>
											<li>
												<a><?=$Kelasi?></a>
											</li>
											<? } ?>
										</ul>
										<? foreach($filek13 as $Kelas=>$mapel){?>
										<div class="tabs-frame-content contentbelajar" style="display: block; width:928px;padding-bottom:0px;" >
												<div class="tabs-vertical-container">
														<ul class="tabs-vertical-frame nilai_tab tabnilai tabrencana ">
															<? foreach($mapel as $pelajaran=>$namafile){?>
																<li  class="first current"><a href="#" class="current"><h5 style="text-align:left;"><?=$pelajaran?></h5><span></span></a></li>
															<? } ?>
														</ul>
														<? foreach($mapel as $pelajaran=>$namafile){?>
														<div class="tabs-vertical-frame-content vcontnilai" style="display: block;">
															
															<?
															   foreach($namafile as $namafilex){
															   $th=explode("_",$namafilex);
															   $th=substr(end($th),0,-4);
															   //echo $th;
															   ?>
																<div>          
																	<h6 style="margin:0;text-transform:capitalize;" class="role"><b>TAHUN <?=$th?></b></h6>
																	<p> <a filename="<?=$namafilex?>" idcntbljrphp="<?=base64_encode(serialize(array('jenjang'=>$jenjang,'kelasdir'=>$Kelas,'pelajaran'=>$pelajaran,'filename'=>$namafilex)))?>"  idcntbljr='<?=json_encode(array('jenjang'=>$jenjang,'kelasdir'=>$Kelas,'pelajaran'=>$pelajaran,'filename'=>$namafilex))?>'  target="__blank" href="<?=base_url()?>upload/contentsekolah/k13/<?=$jenjang?>/<?=$Kelas?>/<?=$pelajaran?>/<?=$namafilex?>" class="notif <?=$id?>"><?=str_replace("_"," ",$namafilex)?></a> </p>
																</div>
															<? } ?>
														</div>
														<? } ?>
												</div>		
										</div>
										<? } ?>									
									</div>
								</div>
							<? } ?>
                            <div  class="toggle-frame" style="margin: 0px; border-radius:0px 0px 5px 5px;padding-bottom:0px;">
                                <h5 class="toggle-accordion"><a href="#">Kurikulum KTSP 2006</a></h5>
                                <div class="toggle-content style" style="display: block;">

									<ul class="tabs-frame">
										<? foreach($file as $Kelasi=>$mapeli){?>
										<li>
											<a><?=$Kelasi?></a>
										</li>
										<? } ?>
									</ul>
									<? foreach($file as $Kelas=>$mapel){?>
									<div class="tabs-frame-content contentbelajar" style="display: block; width:928px;padding-bottom:0px;" >
											<div class="tabs-vertical-container">
													<ul class="tabs-vertical-frame nilai_tab tabnilai tabrencana ">
														<? foreach($mapel as $pelajaran=>$namafile){?>
															<li  class="first current"><a href="#" class="current"><h5 style="text-align:left;"><?=$pelajaran?></h5><span></span></a></li>
														<? } ?>
													</ul>
													<? foreach($mapel as $pelajaran=>$namafile){?>
													<div class="tabs-vertical-frame-content vcontnilai" style="display: block;">
														
														<?
														   foreach($namafile as $namafilex){
														   $th=explode("_",$namafilex);
														   $th=substr(end($th),0,-4);
														   //echo $th;
														   ?>
															<div>          
																<h6 style="margin:0;text-transform:capitalize;" class="role"><b>TAHUN <?=$th?></b></h6>
																<p> <a filename="<?=$namafilex?>" idcntbljrphp="<?=base64_encode(serialize(array('jenjang'=>$jenjang,'kelasdir'=>$Kelas,'pelajaran'=>$pelajaran,'filename'=>$namafilex)))?>"  idcntbljr='<?=json_encode(array('jenjang'=>$jenjang,'kelasdir'=>$Kelas,'pelajaran'=>$pelajaran,'filename'=>$namafilex))?>'  target="__blank" href="<?=base_url()?>upload/contentsekolah/<?=$jenjang?>/<?=$Kelas?>/<?=$pelajaran?>/<?=$namafilex?>" class="notif <?=$id?>"><?=str_replace("_"," ",$namafilex)?></a> </p>
															</div>
														<? } ?>
													</div>
													<? } ?>
											</div>		
									</div>
									<? } ?>									
                                </div>
                            </div>
                        </div> <!-- **Toggle Frame Set - End** -->  
						
						

						