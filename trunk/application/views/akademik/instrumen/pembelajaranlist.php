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
												$.ajax({
													type: "POST",
													data: '',
													url: base_url+'akademik/instrumen/deletepert/'+$(this).attr('id_pemb'),
													beforeSend: function() {
														$(objdell).after("<img id='wait' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
													},
													success: function(msg) {
														$("#wait").remove();	
														if(msg==1){
															$('ul.tabs-vertical-frame li#tab'+$(objdell).attr('id_pemb')).remove();
															$('div#cnttab'+$(objdell).attr('id_pemb')).remove();
															$('div.tabs-vertical-frame-content').first().attr('style','display:block;');
															$('ul.tabs-vertical-frame li').first().addClass('current');
															$('ul.tabs-vertical-frame li').first().children('a').addClass('current');
															
														}
													}
												});
												return false;
											}
										});
										
										
									});
								</script>
				<h3></h3>
				<div class="hr"></div>
				<div class="tabs-vertical-container">
						<ul class="tabs-vertical-frame nilai_tab tabnilai tabrencana">
							
							<? 
							$nox=array();$no=1;
							if(!empty($pembelajaran['pembelajaran'])){
								foreach($pembelajaran['pembelajaran'] as $kt=>$datapembelajaran){?>
									<li id="tab<?=$datapembelajaran['id']?>" class="first current"><a href="#" class="current"><h5>Evaluasi ke <?=$datapembelajaran['pertemuan_ke']?></h5><h6><? echo 'Kelas '.$datapembelajaran['kelas'].''.$datapembelajaran['nama_kelas'].' | '.$datapembelajaran['nama_pelajaran'].'';?></h6><span></span></a></li>
								<? } ?>
							<? } ?>
						</ul>
						
						<? 
						//pr($pembelajaran);
						$nox=array();$no=1;
						if(!empty($pembelajaran['pembelajaran'])){
						foreach($pembelajaran['pembelajaran'] as $kt=>$datapembelajaran){?>
						<div class="tabs-vertical-frame-content vcontnilai" id="cnttab<?=$datapembelajaran['id']?>" style="display: block;">
							<div class="actedit modal" href="<?=base_url('akademik/instrumen/editpertemuan/'.$datapembelajaran['id'])?>"></div> 
							<div id="actdellpemp" id_pemb="<?=$datapembelajaran['id']?>" class="actdell"></div>
													<div style="width:99%;" class="file">
													<br />
													<h6 ><?=$datapembelajaran['topik']?></h6>
													<h5 >Indikator</h5>
													<div class="hr"></div>
													<ul class="file">
														<li>
															<a href="<?=site_url('akademik/instrumen/kognitifs/'.$datapembelajaran['id'].'/'.$datapembelajaran['id_pelajaran'].'')?>" id="penilaianklik" class="modal">Indikator Evaluasi Kognitif</a>
															<!--<div  href="#nilaitab" class="modal_dialog addasb"></div>-->
														</li>
														<li>
															<?
															$par=array('id_pembelajaran'=>$datapembelajaran['id'],'id_pelajaran'=>$datapembelajaran['id_pelajaran'],'id_mengjar'=>$datapembelajaran['id_mengajar'],'evaluasi_ke'=>$datapembelajaran['pertemuan_ke'],'kelas'=>$datapembelajaran['kelas'],'id_kelas'=>$datapembelajaran['id_kelas']);
															$par=$this->myencrypt->encode(serialize($par));
															?>
															<a href="<?=site_url('akademik/instrumen/praafektif/'.$par.'')?>" id="penilaianklik" class="modal">Indikator Evaluasi Afektif</a>
														</li>
														<li>
															<a href="<?=site_url('akademik/instrumen/psikomotorik/'.$datapembelajaran['id'].'/'.$datapembelajaran['id_pelajaran'].'')?>" id="penilaianklik" class="modal">Indikator Evaluasi Psikomototik</a>
														</li>
													</ul>
													<h5 >Kognitif</h5>
														<ul  class="file">
															<li><a href="" class="modal">Penilaian Otentik Kognitif</a></li>
														</ul>
													
													<h5 >Afektif</h5>
														<ul  class="file">
															<li><a href="" class="modal">Penilaian Otentik Afektif</a></li>
														</ul>
													
													<h5 >Psikomotorik</h5>
														<ul  class="file">
															<li><a href="" class="modal">Penilaian Otentik Kinerja</a></li>
															<li><a href="" class="modal">Penilaian Otentik Proyek</a></li>
															<li><a href="" class="modal">Penilaian Otentik Kreatifitas</a></li>
														</ul>
													
													<!--<h5 >Scoring</h5>
													<ul class="file">
														<li>
															<a href="<?=site_url('akademik/instrumen/penilaian/kognitif/'.$datapembelajaran['id'].'/'.$datapembelajaran['id_pelajaran'].'/'.$datapembelajaran['id_kelas'].'/'.$datapembelajaran['kelas'].''.$datapembelajaran['nama_kelas'].'/'.base64_encode($datapembelajaran['topik']))?>" id="penilaianklik" class="modal">Scoring Evaluasi Kognitif</a>
															<!--<div  href="<?=site_url('akademik/instrumen/penilaian/kognitif/'.$datapembelajaran['id'].'/'.$datapembelajaran['id_pelajaran'].'/'.$datapembelajaran['id_kelas'].'/'.$datapembelajaran['kelas'].''.$datapembelajaran['nama_kelas'].'/'.base64_encode($datapembelajaran['topik']))?>" class="modal addasb"></div>
															<div  href="#nilaitab" class="modal_dialog addasb"></div>
														</li>
														<li>
															<a href="<?=site_url('akademik/instrumen/penilaian/afektif/'.$datapembelajaran['id'].'/'.$datapembelajaran['id_pelajaran'].'/'.$datapembelajaran['id_kelas'].'/'.$datapembelajaran['kelas'].''.$datapembelajaran['nama_kelas'].'/'.base64_encode($datapembelajaran['topik']))?>" id="penilaianklik" class="modal">Scoring Evaluasi Afektif</a>
															<!--<div  href="<?=site_url('akademik/instrumen/penilaian/afektif/'.$datapembelajaran['id'].'/'.$datapembelajaran['id_pelajaran'].'/'.$datapembelajaran['id_kelas'].'/'.$datapembelajaran['kelas'].''.$datapembelajaran['nama_kelas'].'/'.base64_encode($datapembelajaran['topik']))?>" class="modal addasb"></div>
														</li>
														<li>
															<a href="<?=site_url('akademik/instrumen/penilaian/psikomotorik/'.$datapembelajaran['id'].'/'.$datapembelajaran['id_pelajaran'].'/'.$datapembelajaran['id_kelas'].'/'.$datapembelajaran['kelas'].''.$datapembelajaran['nama_kelas'].'/'.base64_encode($datapembelajaran['topik']))?>" id="penilaianklik" class="modal">Scoring Evaluasi Psikomotorik</a>
															<!--<div href="<?=site_url('akademik/instrumen/penilaian/psikomotorik/'.$datapembelajaran['id'].'/'.$datapembelajaran['id_pelajaran'].'/'.$datapembelajaran['id_kelas'].'/'.$datapembelajaran['kelas'].''.$datapembelajaran['nama_kelas'].'/'.base64_encode($datapembelajaran['topik']))?>"  class="modal addasb"></div>
														</li>
													</ul>-->
													</div>
													
													<div class="full file">
													<h5>Detail Evaluasi</h5>
													<table class="noborder">
													<tbody>
													<tr>
													  <td colspan="2" class="title">Kelas</td>
														<td>:</td>
														<td class="title">
															<?=$datapembelajaran['kelas']?><?=$datapembelajaran['nama_kelas']?>
														</td>
													</tr>
													<tr>
													  <td colspan="2" class="title">Pelajaran</td>
														<td>:</td>
														<td class="title">
															<?=$datapembelajaran['nama_pelajaran']?>
														</td>
													</tr>
													<tr>
													  <td colspan="2" class="title">Topik Pertemuan</td>
														<td>:</td>
														<td class="title">
															<?=@$datapembelajaran['topik']?>
														</td>
													</tr>
													<tr>
													  <td colspan="2" class="title">Waktu Pertemuan</td>
														<td>:</td>
														<td class="title">
															<?=@$datapembelajaran['waktu']?>
														</td>
													</tr>
													<tr>
													  <td colspan="2" class="title">Pertemuan ke</td>
														<td>:</td>
														<td class="title">
															<?=@$datapembelajaran['pertemuan_ke']?>
														</td>
													</tr>
												</tbody></table>
													</div>
						</div>
                        <? } ?>	
                        <? } ?>	
                    </div>
						