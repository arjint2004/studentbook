
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
					<? //pr($pelajaran);?>
					<script type="text/javascript" src="<?=$this->config->item('js').'jquery.tabs.min.js';?>"></script>					
                    <div class="tabs-vertical-container">
                        
						<ul class="tabs-vertical-frame nilai_tab tabnilai" >
							<? foreach($pelajaran as $datapelajaran){?>
								<li id="tab<?=$datapelajaran['id']?>" ><a href="#"><h5><?=$datapelajaran['nama']?></h5>
								<span></span></a></li>
							<? } ?>
                        </ul>
						<? foreach($pelajaran as $datapelajaran){?>
							<div id="cnttab<?=$datapelajaran['id']?>" class="tabs-vertical-frame-content vcontnilai">
							   <table class="tabelkelas">
										<thead>
											<tr> 
												<th>Nama</th>
												<th>NIS</th>
												<th>POIN</th>
												<th>Nilai <?=$jenis?></th>
											</tr>                         
										</thead>
										<tbody>
											<? foreach($datapelajaran['nilai'] as $datanilai){?>
											<tr>
												<td class="title"><?=$datanilai['nama']?></td>
												<td ><?=$datanilai['nis']?></td>
												<td ><?=$datanilai['nilai']?></td>
												<td ><?=gawehuruf($datanilai['nilai'])?></td>
											</tr>
											<? } ?>	
										</tbody>
								</table>
							</div>
                        <? } ?>	
                    </div>