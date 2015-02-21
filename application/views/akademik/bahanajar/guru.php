
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
									/*Tabs Shortcode Ends*/

									$(document).ready(function(){
										<? 
										if(isset($id) && $id!=''){
											?>
												$("a.<?=$id?>").click(function(){
													//alert($(this).attr('filename'));
													var data=JSON.parse($(this).attr('idcntbljr'));
													
													$("ul#addmatericontbljr").append('<li class="actdellcnt">'+data.kelasdir+'|'+data.pelajaran+'|'+$(this).attr('filename')+'<input type="hidden" name="cnrbljr[]" value="'+$(this).attr('idcntbljrphp')+'" /><div class="actdell"></div></li>');
													$("ul.file li div.actdell").click(function(){
														$(this).parent('li').remove();
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
				<? $jenjang="SMP";?>
		<ul class="tabs-frame">
			<? foreach($file as $Kelasi=>$mapeli){?>
			<li>
				<a><?=$Kelasi?></a>
			</li>
			<? } ?>
		</ul>
		<? foreach($file as $Kelas=>$mapel){?>
		<div class="tabs-frame-content contentbelajar" style="display: block; width:928px; >
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
									<p> <a filename="<?=$namafilex?>" idcntbljrphp="<?=base64_encode(serialize(array('jenjang'=>$jenjang,'kelasdir'=>$kelasdir,'pelajaran'=>$pelajaran,'filename'=>$namafilex)))?>"  idcntbljr='<?=json_encode(array('jenjang'=>$jenjang,'kelasdir'=>$kelasdir,'pelajaran'=>$pelajaran,'filename'=>$namafilex))?>'  href="<?=base_url()?>upload/contentsekolah/<?=$jenjang?>/<?=$kelasdir?>/<?=$pelajaran?>/<?=$namafilex?>" class="notif <?=$id?>"><?=str_replace("_"," ",$namafilex)?></a> </p>
								</div>
							<? } ?>
						</div>
						<? } ?>
                </div>		
		</div>
		<? } ?>
						