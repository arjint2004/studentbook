
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
						$(document).ready(function(){
							$(".actexcell").click(function(){
								$('form#formexp'+$(this).attr('id_subject')).attr('action','<?=base_url()?>akademik/export');
								$('form#formexp'+$(this).attr('id_subject')).append('<input type="hidden" name="kelasnya" value="'+$('select#kelasListdubject').find(":selected").text()+'"/>');
								$('form#formexp'+$(this).attr('id_subject')).append('<input type="hidden" name="pelajarannya" value="'+$('select#pelajaranlistsubject').find(":selected").text()+'"/>');
								$('form#formexp'+$(this).attr('id_subject')).append('<input type="hidden" name="namanilai" value="'+$('h3#namanilai').html()+'"/>');
								if($('select#kelasListdubject').val()==''){
									$('select#kelasListdubject').css('border','1px solid red');
									return false;
								}
								if($('select#pelajaranlistsubject').val()==0){
									$('select#pelajaranlistsubject').css('border','1px solid red');
									return false;
								}
								$('form#formexp'+$(this).attr('id_subject')).submit();
							});
						});
						
					</script>
					<? //pr($subject);?>
					<script type="text/javascript" src="<?=$this->config->item('js').'jquery.tabs.min.js';?>"></script>					
                    <div class="tabs-vertical-container">
                        <ul class="tabs-vertical-frame nilai_tab tabnilai" >
							<? foreach($subject as $datasubject){?>
                            <li id="tab<?=$datasubject['id']?>" ><a href="#"><h5><?=@$datasubject['pelajaran']?></h5>
							<h6><?=$datasubject['subject']?></h6><span></span><?if(@$datasubject['remidial']=='remidial'){?><h6><?=@$datasubject['remidial']?></h6><span></span><?}?></a></li>
							<? } ?>
                        </ul>
						<? foreach($subject as $datasubject){?>
							<div id="cnttab<?=$datasubject['id']?>" class="tabs-vertical-frame-content vcontnilai">
							<div class="actedit" title="Edit" onclick="editsubjnilai(this,<?=$datasubject['id']?>,<?=$datasubject['id_kelas']?>,<?=$datasubject['id_pelajaran']?>,'<?=$datasubject['remidial']?>','<?=$datasubject['subject']?>')" ></div> 
							<div class="actdell" title="Delete" onclick="deletesubjnilai(this,<?=$datasubject['id']?>,'<?=$jenis?>')"></div>
							<div class="actexcell" id_subject="<?=$datasubject['id']?>" title="Export Excell" ></div>
							   <form id="formexp<?=$datasubject['id']?>" action="" method="post">
							   <input type="hidden" name="jenis" value="Nilai" />
							   <input type="hidden" name="fileName" value="Nilai" />
							   <table class="tabelkelas">
										<thead>
											<tr> 
												<th>Nama</th>
												<th>NIS</th>
												<th>Kelas</th>
												<th><? if(@$jenis=='nilai lain_lain'){?>Keterangan<?}else{?>Nilai<?}?></th>
											</tr>                         
										</thead>
										<tbody>
											<? foreach($datasubject['datanilai'] as $datanilai){?>
											<tr>
												<td class="title"><input type="hidden" name="nama[]" value="<?=$datanilai['nama']?>" /><?=$datanilai['nama']?></td>
												<td ><input type="hidden" name="nis[]" value="<?=$datanilai['nis']?>" /><?=$datanilai['nis']?></td>
												<td ><input type="hidden" name="kelas[]" value="<?=$datanilai['kelas']?><?=$datanilai['nama_kelas']?>" /><?=$datanilai['kelas']?><?=$datanilai['nama_kelas']?></td>
												<td ><input type="hidden" name="nilai[]" value="<?=$datanilai['nilai']?>" /><?=$datanilai['nilai']?></td>
											</tr>
											<? } ?>	
										</tbody>
								</table>
								</form>
							</div>
                        <? } ?>	
                    </div>