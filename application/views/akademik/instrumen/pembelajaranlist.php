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
													data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&',
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
													data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&',
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
				<h3></h3>
				<div class="hr"></div>
				<div class="tabs-vertical-container">
						<ul class="tabs-vertical-frame nilai_tab tabnilai tabrencana">
							
							<? 
							$nox=array();$no=1;
							if(!empty($pertemuan['pertemuan'])){
								foreach($pertemuan['pertemuan'] as $kt=>$datapertemuan){?>
									<li id="tab<?=$datapertemuan['id']?>" class="first current"><a href="#" class="current"><h5>Evaluasi ke <?=$datapertemuan['pertemuan_ke']?></h5><h6><? echo 'Kelas '.$datapertemuan['kelas'].''.$datapertemuan['nama_kelas'].' | '.$datapertemuan['nama_pelajaran'].'';?></h6><span></span></a></li>
								<? } ?>
							<? } ?>
						</ul>
						
						<? 
						//pr($pertemuan);
						$nox=array();$no=1;
						if(!empty($pertemuan['pertemuan'])){
						foreach($pertemuan['pertemuan'] as $kt=>$datapertemuan){?>
						<div class="tabs-vertical-frame-content vcontnilai" id="cnttab<?=$datapertemuan['id']?>" style="display: block;">
							<div class="actedit modal" href="<?=base_url('akademik/instrumen/editpertemuan/'.$datapertemuan['id'])?>"></div> 
							<div id="actdellpemp" id_pemb="<?=$datapertemuan['id']?>" class="actdell"></div>
													<div style="width:99%;" class="file">
													<br />
													<h6 ><?=$datapertemuan['topik']?></h6>
													<h5 >Penilaian Otentik</h5>
													<div class="hr"></div>
													<?
													$par=array('id_pertemuan'=>$datapertemuan['id'],'id_pelajaran'=>$datapertemuan['id_pelajaran'],'id_mengjar'=>$datapertemuan['id_mengajar'],'evaluasi_ke'=>$datapertemuan['pertemuan_ke'],'kelas'=>$datapertemuan['kelas'],'id_kelas'=>$datapertemuan['id_kelas']);
													?>
													<h5 >Kognitif</h5>
														<ul  class="file">
															<li>
																<?
																$par['jenis']='kognitif';
																$parafektif=$this->myencrypt->encode(serialize($par));
																?>
																<a href="<?=site_url('akademik/instrumen/praotentik/'.$parafektif.'')?>" id="penilaianklik" class="modal">Penilaian Otentik Kognitif</a>
															</li>
														</ul>
													
													<h5 >Afektif</h5>
														<ul  class="file">
															<li>
																<?
																$par['jenis']='afektif';
																$parafektif=$this->myencrypt->encode(serialize($par));
																?>
																<a href="<?=site_url('akademik/instrumen/praotentik/'.$parafektif.'')?>" id="penilaianklik" class="modal">Penilaian Otentik Afektif</a>
															</li>
														</ul>
													
													<h5 >Psikomotorik</h5>
														<ul  class="file">
															<li>
																<?
																$par['jenis']='psikomotorik';
																$parpsikomotorik=$this->myencrypt->encode(serialize($par));
																?>
																<a href="<?=site_url('akademik/instrumen/praotentik/'.$parpsikomotorik.'')?>" id="penilaianklik" class="modal">Penilaian Psikomotorik</a>															
															</li>
															<li>
																<?
																$par['jenis']='kinerja';
																$parkinerja=$this->myencrypt->encode(serialize($par));
																?>
																<a href="<?=site_url('akademik/instrumen/praotentik/'.$parkinerja.'')?>" id="penilaianklik" class="modal">Penilaian Otentik Kinerja</a>															
															</li>
															<li>
																<?
																$par['jenis']='project';
																$parproject=$this->myencrypt->encode(serialize($par));
																?>
																<a href="<?=site_url('akademik/instrumen/praotentik/'.$parproject.'')?>" id="penilaianklik" class="modal">Penilaian Otentik Project</a>																
															</li>
															<li>
																<?
																$par['jenis']='creative';
																$parcreative=$this->myencrypt->encode(serialize($par));
																?>
																<a href="<?=site_url('akademik/instrumen/praotentik/'.$parcreative.'')?>" id="penilaianklik" class="modal">Penilaian Otentik Creative</a>																
															</li>
														</ul>
													
													<!--<h5 >Scoring</h5>
													<ul class="file">
														<li>
															<a href="<?=site_url('akademik/instrumen/penilaian/kognitif/'.$datapertemuan['id'].'/'.$datapertemuan['id_pelajaran'].'/'.$datapertemuan['id_kelas'].'/'.$datapertemuan['kelas'].''.$datapertemuan['nama_kelas'].'/'.base64_encode($datapertemuan['topik']))?>" id="penilaianklik" class="modal">Scoring Evaluasi Kognitif</a>
															<!--<div  href="<?=site_url('akademik/instrumen/penilaian/kognitif/'.$datapertemuan['id'].'/'.$datapertemuan['id_pelajaran'].'/'.$datapertemuan['id_kelas'].'/'.$datapertemuan['kelas'].''.$datapertemuan['nama_kelas'].'/'.base64_encode($datapertemuan['topik']))?>" class="modal addasb"></div>
															<div  href="#nilaitab" class="modal_dialog addasb"></div>
														</li>
														<li>
															<a href="<?=site_url('akademik/instrumen/penilaian/otentik/'.$datapertemuan['id'].'/'.$datapertemuan['id_pelajaran'].'/'.$datapertemuan['id_kelas'].'/'.$datapertemuan['kelas'].''.$datapertemuan['nama_kelas'].'/'.base64_encode($datapertemuan['topik']))?>" id="penilaianklik" class="modal">Scoring Evaluasi otentik</a>
															<!--<div  href="<?=site_url('akademik/instrumen/penilaian/otentik/'.$datapertemuan['id'].'/'.$datapertemuan['id_pelajaran'].'/'.$datapertemuan['id_kelas'].'/'.$datapertemuan['kelas'].''.$datapertemuan['nama_kelas'].'/'.base64_encode($datapertemuan['topik']))?>" class="modal addasb"></div>
														</li>
														<li>
															<a href="<?=site_url('akademik/instrumen/penilaian/psikomotorik/'.$datapertemuan['id'].'/'.$datapertemuan['id_pelajaran'].'/'.$datapertemuan['id_kelas'].'/'.$datapertemuan['kelas'].''.$datapertemuan['nama_kelas'].'/'.base64_encode($datapertemuan['topik']))?>" id="penilaianklik" class="modal">Scoring Evaluasi Psikomotorik</a>
															<!--<div href="<?=site_url('akademik/instrumen/penilaian/psikomotorik/'.$datapertemuan['id'].'/'.$datapertemuan['id_pelajaran'].'/'.$datapertemuan['id_kelas'].'/'.$datapertemuan['kelas'].''.$datapertemuan['nama_kelas'].'/'.base64_encode($datapertemuan['topik']))?>"  class="modal addasb"></div>
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
															<?=$datapertemuan['kelas']?><?=$datapertemuan['nama_kelas']?>
														</td>
													</tr>
													<tr>
													  <td colspan="2" class="title">Pelajaran</td>
														<td>:</td>
														<td class="title">
															<?=$datapertemuan['nama_pelajaran']?>
														</td>
													</tr>
													<tr>
													  <td colspan="2" class="title">Topik Pertemuan</td>
														<td>:</td>
														<td class="title">
															<?=@$datapertemuan['topik']?>
														</td>
													</tr>
													<tr>
													  <td colspan="2" class="title">Waktu Pertemuan</td>
														<td>:</td>
														<td class="title">
															<?=@$datapertemuan['waktu']?>
														</td>
													</tr>
													<tr>
													  <td colspan="2" class="title">Pertemuan ke</td>
														<td>:</td>
														<td class="title">
															<?=@$datapertemuan['pertemuan_ke']?>
														</td>
													</tr>
												</tbody></table>
													</div>
						</div>
                        <? } ?>	
                        <? } ?>	
                    </div>
						