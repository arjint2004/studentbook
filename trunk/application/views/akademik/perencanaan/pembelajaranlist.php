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
													url: base_url+'akademik/perencanaan/deletefilepemb/'+$(this).attr('id'),
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
													url: base_url+'akademik/perencanaan/deletepemb/'+$(this).attr('id_pemb'),
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
				<div class="tabs-vertical-container">
                        <ul class="tabs-vertical-frame nilai_tab tabnilai tabrencana">
							
							<? 
							$nox=array();$no=1;
							if(!empty($pembelajaran['pembelajaran'])){
								foreach($pembelajaran['pembelajaran'] as $kt=>$datapembelajaran){?>
									<li id="tab<?=$datapembelajaran['id']?>" class="first current"><a href="#" class="current"><h5><?=$datapembelajaran['judul']?></h5><h6>Pertemuan <? echo 'Ke '.$datapembelajaran['pertemuan_ke'].' | Kelas '.$datapembelajaran['kelas'].''.$datapembelajaran['nama_kelas'].' | '.$datapembelajaran['nama_pelajaran'].'';?></h6><span></span></a></li>
								<? } ?>
							<? } ?>
						</ul>
						
						<? 
						//pr($pembelajaran['pembelajaran']);
						$nox=array();$no=1;
						if(!empty($pembelajaran['pembelajaran'])){
						foreach($pembelajaran['pembelajaran'] as $kt=>$datapembelajaran){?>
						<div class="tabs-vertical-frame-content vcontnilai" id="cnttab<?=$datapembelajaran['id']?>" style="display: block;">
							<div class="actedit" onclick="$('#subjectlist').load('<?=base_url('akademik/perencanaan/editpembelajaran/'.$datapembelajaran['id'])?>');"></div> <div id="actdellpemp" id_pemb="<?=$datapembelajaran['id']?>" class="actdell"></div>
													<div style="width:99%;" class="file">
													<h3 ><?=$datapembelajaran['judul']?></h3>
													<br />
													<h5 >Indikator Pencapaian Kompetensi</h5>
													<div class="hr"></div>
													<ul class="file">
														<li>
															<a href="<?=site_url('akademik/perencanaan/kognitif/'.$datapembelajaran['id'].'/'.$datapembelajaran['id_pelajaran'].'')?>" id="penilaianklik" class="modal">Indikator Kognitif</a>
															<!--<div  href="<?=site_url('akademik/perencanaan/penilaian/kognitif/'.$datapembelajaran['id'].'/'.$datapembelajaran['id_pelajaran'].'')?>" class="modal addasb"></div>-->
															<div  href="#nilaitab" class="modal_dialog addasb"></div>
														</li>
														<li>
															<a href="<?=site_url('akademik/perencanaan/afektif/'.$datapembelajaran['id'].'/'.$datapembelajaran['id_pelajaran'].'')?>" id="penilaianklik" class="modal">Indikator Afektif</a>
															<div  href="<?=site_url('akademik/perencanaan/penilaian/afektif/'.$datapembelajaran['id'].'/'.$datapembelajaran['id_pelajaran'].'/'.$datapembelajaran['id_kelas'].'/'.$datapembelajaran['kelas'].''.$datapembelajaran['nama_kelas'].'/'.base64_encode($datapembelajaran['judul']))?>" class="modal addasb"></div>
														</li>
														<li>
															<a href="<?=site_url('akademik/perencanaan/psikomotorik/'.$datapembelajaran['id'].'/'.$datapembelajaran['id_pelajaran'].'')?>" id="penilaianklik" class="modal">Indikator Psikomototik</a>
															<div href="<?=site_url('akademik/perencanaan/penilaian/psikomotorik/'.$datapembelajaran['id'].'/'.$datapembelajaran['id_pelajaran'].'/'.$datapembelajaran['id_kelas'].'/'.$datapembelajaran['kelas'].''.$datapembelajaran['nama_kelas'].'/'.base64_encode($datapembelajaran['judul']))?>"  class="modal addasb"></div>
														</li>
													</ul>
													</div>
													<div style="width:99%;" class="file">
													<h5 >Materi</h5>
													<div class="hr"></div>
													<ul class="file">
														<li><a href="<?=site_url('akademik/perencanaan/materi/'.$datapembelajaran['id'].'/'.$datapembelajaran['id_pelajaran'].'')?>" id="penilaianklik" class="modal">Tambah Materi</a></li>
														<li><a href="<?=site_url('akademik/materi')?>" id="penilaianklik" class="modal">Lihat Materi</a></li>
													</ul>
													</div>
													<div style="width:99%;" class="file">
													<h5 >Kompetensi Inti</h5>
													<div class="hr"></div>
													<ul class="file">
														<? foreach($datapembelajaran['file'] as $file){ ?>
															<li id="li<?=$file['id']?>"><a title="<?=$file['file_name']?>" href="<?=base_url('homepage/send_download/'.base64_encode("upload/akademik/rencana_pembelajaran/").'/'.base64_encode($file['file_name']).'');?>" target="_self"><?=substr($file['file_name'],-30)?></a> <div style="float:right;" id="<?=$file['id']?>" class="actdell"></div></li>
															
														<? } ?>
													</ul>
													</div>
													
													<div class="full file">
													<h5>Detail Pembelajaran</h5>
													<div class="hr"></div>
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
													<tr>
													  <td colspan="2" class="title">Tema / Judul pertemuan</td>
														<td width="1">:</td>
														<td class="title">
															<?=@$datapembelajaran['judul']?>
														</td>
													</tr>
													<tr>
													  <td colspan="2" class="title">Kompetensi Inti</td>
														<td width="1">:</td>
														<td class="title">
															<?=@$datapembelajaran['kompetensi_inti']?>
														</td>
													</tr>
													<tr>
													  <td colspan="2" class="title">Kompetensi Dasar </td>
														<td width="1">:</td>
														<td class="title">
															<?=@$datapembelajaran['kompetensi_dasar']?>
														</td>
													</tr>
													<tr>
													  <td colspan="2" class="title">Indikator Pencapaian Kompetensi</td>
														<td width="1">:</td>
														<td class="title">
															<?=@$datapembelajaran['indikator_ketercapaian']?>
														</td>
													</tr>
													<tr>
													  <td colspan="2" class="title">Tujuan Pembelajaran</td>
														<td width="1">:</td>
														<td class="title">
															<?=@$datapembelajaran['tujuan_pemb']?>
														</td>
													</tr>
													<!--<tr>
													  <td colspan="2" class="title">Materi</td>
														<td width="1">:</td>
														<td class="title">
															<a href="<?//=site_url('akademik/perencanaan/materi/'.$datapembelajaran['id'].'/'.$datapembelajaran['id_pelajaran'].'')?>" id="penilaianklik" class="modal">Materi Pembelajaran</a>
														</td>
													</tr>-->
													<tr>
													  <td colspan="2" class="title">Model/Metode Pembelajaran</td>
														<td width="1">:</td>
														<td class="title">
															<?=@$datapembelajaran['model_pembelajaran']?>
														</td>
													</tr>
													
													<tr>
													  <td  rowspan="3" class="title"><b>Kegiatan</b></td>
														<td  class="title">Pendahuluan</td> 
														<td width="1">:</td>
														<td class="title">
															<?=@$datapembelajaran['pendahuluan']?>
														</td>
													</tr>
													<tr>
													  <td  class="title">Inti</td>
														<td width="1">:</td>
														<td class="title">
															<?=@$datapembelajaran['inti']?>
														</td>
													</tr>
													<tr>
													  <td  class="title">Penutup</td>
														<td width="1">:</td>
														<td class="title">
															<?=@$datapembelajaran['penutup']?>
														</td>
													</tr>
													<tr>
													  <td colspan="2" class="title">Alat/Media/Sumber Pembelajaran</td>
														<td width="1">:</td>
														<td class="title">
															<?=@$datapembelajaran['media_sumber']?>
														</td>
													</tr>
													<tr>
													  <td colspan="2" class="title">Referensi Buku</td>
														<td width="1">:</td>
														<td class="title">
															<?=@$datapembelajaran['referensi']?>
														</td>
													</tr>
													<tr>
													  <td colspan="2" class="title">Keterangan</td>
														<td width="1">:</td>
														<td class="title">
															<?=@$datapembelajaran['keterangan']?>
														</td>
													</tr>
													
												</tbody></table>
													</div>
						</div>
                        <? } ?>	
                        <? } ?>	
                    </div>
								
								
								
							  <!-- <table >
										<thead>
											<tr>
												<th>No</th>   
												<th>Komp Inti</th>  
												<th>Kelas</th>
												<th>Input</th>
												<th>Action</th>
											</tr>                         
										</thead>
										<tbody>
											<? 
											$nox=array();$no=1;
											if(!empty($pembelajaran['pembelajaran'])){
											foreach($pembelajaran['pembelajaran'] as $kt=>$datapembelajaran){?>
											<tr style="cursor:pointer;" title="klik untuk menampilkan / menyembunyikan detail" onclick="$('#detailpembelajaran<?=$datapembelajaran['id']?>').toggle('fade')">
												<td><?=$no++;?></td>
												<td class="title" ><?=$datapembelajaran['kompetensi_inti']?></td>
												<td class="title" ><?=$datapembelajaran['kelas']?><?=$datapembelajaran['nama_kelas']?></td>
												<td > <a href="<?=site_url('akademik/perencanaan/materi/'.$datapembelajaran['id'].'/'.$datapembelajaran['id_pelajaran'].'')?>" id="penilaianklik" class="modal">Materi</a> | 
												<a href="<?=site_url('akademik/perencanaan/kognitif/'.$datapembelajaran['id'].'/'.$datapembelajaran['id_pelajaran'].'')?>" id="penilaianklik" class="modal">Tugas</a> | 
												<a href="<?=site_url('akademik/perencanaan/kognitifs/'.$datapembelajaran['id'].'/'.$datapembelajaran['id_pelajaran'].'')?>" id="penilaianklik" class="modal">Kogn</a> |
												<a href="<?=site_url('akademik/perencanaan/afektif/'.$datapembelajaran['id'].'/'.$datapembelajaran['id_pelajaran'].'')?>" id="penilaianklik" class="modal">Afek</a> |
												<a href="<?=site_url('akademik/perencanaan/psikomotorik/'.$datapembelajaran['id'].'/'.$datapembelajaran['id_pelajaran'].'')?>" id="penilaianklik" class="modal">Psik</a> | 
												</td>
												<td >
													<div class="actedit" onclick="$('#subjectlist').load('<?=base_url('akademik/perencanaan/editpembelajaran/'.$datapembelajaran['id'])?>');"></div> 
													<div id="actdellpemp" id_pemb="<?=$datapembelajaran['id']?>" class="actdell"></div>
												</td>
											</tr>
											<tr id="detailpembelajaran<?=$datapembelajaran['id']?>" style="display:none;">
												<td colspan="7" class="innercolspan">
													<div style="width:99%;" class="file">
													<h3 >File Data Pembelajaran</h3>
													<div class="hr"></div>
													<ul class="file">
														<? foreach($datapembelajaran['file'] as $file){ ?>
															<li id="li<?=$file['id']?>"><a title="<?=$file['file_name']?>" href="<?=base_url('homepage/send_download/'.base64_encode("upload/akademik/rencana_pembelajaran/").'/'.base64_encode($file['file_name']).'');?>" target="_self"><?=substr($file['file_name'],-30)?></a> <div style="float:right;" id="<?=$file['id']?>" class="actdell"></div></li>
															
														<? } ?>
													</ul>
													
													</div>
													<div class="full file">
													<h3>Detail Pembelajaran</h3>
													<div class="hr"></div>
													<table class="noborder">
													<tbody>
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
													
													<tr>
													  <td colspan="2" class="title">Kompetensi Inti</td>
														<td width="1">:</td>
														<td class="title">
															<?=@$datapembelajaran['kompetensi_inti']?>
														</td>
													</tr>
													<tr>
													  <td colspan="2" class="title">Kompetensi Dasar </td>
														<td width="1">:</td>
														<td class="title">
															<?=@$datapembelajaran['kompetensi_dasar']?>
														</td>
													</tr>
													<tr>
													  <td colspan="2" class="title">Indikator Pencapaian Kompetensi</td>
														<td width="1">:</td>
														<td class="title">
															<?=@$datapembelajaran['indikator_ketercapaian']?>
														</td>
													</tr>
													<tr>
													  <td colspan="2" class="title">Tujuan Pembelajaran</td>
														<td width="1">:</td>
														<td class="title">
															<?=@$datapembelajaran['tujuan_pemb']?>
														</td>
													</tr>
													<tr>
													  <td colspan="2" class="title">Materi</td>
														<td width="1">:</td>
														<td class="title">
															<?=@$datapembelajaran['materi']?>
														</td>
													</tr>
													<tr>
													  <td colspan="2" class="title">Model/Metode Pembelajaran</td>
														<td width="1">:</td>
														<td class="title">
															<?=@$datapembelajaran['model_pembelajaran']?>
														</td>
													</tr>
													
													<tr>
													  <td  rowspan="3" class="title"><b>Kegiatan</b></td>
														<td  class="title">Pendahuluan</td> 
														<td width="1">:</td>
														<td class="title">
															<?=@$datapembelajaran['pendahuluan']?>
														</td>
													</tr>
													<tr>
													  <td  class="title">Inti</td>
														<td width="1">:</td>
														<td class="title">
															<?=@$datapembelajaran['inti']?>
														</td>
													</tr>
													<tr>
													  <td  class="title">Penutup</td>
														<td width="1">:</td>
														<td class="title">
															<?=@$datapembelajaran['penutup']?>
														</td>
													</tr>
													<tr>
													  <td colspan="2" class="title">Alat/Media/Sumber Pembelajaran</td>
														<td width="1">:</td>
														<td class="title">
															<?=@$datapembelajaran['media_sumber']?>
														</td>
													</tr>
													<tr>
													  <td colspan="2" class="title">Referensi Buku</td>
														<td width="1">:</td>
														<td class="title">
															<?=@$datapembelajaran['referensi']?>
														</td>
													</tr>
													<tr>
													  <td colspan="2" class="title">Keterangan</td>
														<td width="1">:</td>
														<td class="title">
															<?=@$datapembelajaran['keterangan']?>
														</td>
													</tr>
													
												</tbody></table>
													</div>
												</td>
											</tr>
											<? }  } ?>
										</tbody>
								</table>-->
								