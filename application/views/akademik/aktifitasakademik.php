<?//pr($pr);?>
<div class="aktifitasakademik" >
<h3 class="float-left" class="aktifitasakademik">Aktifitas Akademik</h3>
<div class="hr"></div>
				<br style="clear:both;" />
					<div class="column one-half last halfsidebar" >
                        <!-- **Toggle Frame Set** -->  
                        <div class="toggle-frame-set" style="margin:0;">
                            <div class="toggle-frame">
                                <h5 class="toggle-accordion"><a href="#"><?=$limit?> PR Terakhir</a></h5>
                                <div class="toggle-content" style="display: block;">
								<? foreach($pr as $datapr){?>
                                    <div class="team">          
										<h6 class="role" style="margin:0"> <? $tg=tanggal($datapr['tanggal_kirim'].""); echo $tg[2];?> | Kelas <?=$datapr['kelas'].$datapr['nama_kelas']?> | <?=$datapr['guru']?></h6>
										<p> <a class="notif" href="<?=base_url()?>akademik/detailpembelajaran/detail/<?=base64_encode(serialize(array('id'=>$datapr['id'],'jenis'=>'pr')))?>"><b><?=$datapr['nama_pelajaran']?></b> | <?=$datapr['judul']?> </a> </p>
									</div>
								<? } ?>
                                </div>
                            </div>
                        </div> <!-- **Toggle Frame Set - End** -->                         
                    </div>
					
					<div class="column one-half last halfsidebar" style="float:right;" >
                        <!-- **Toggle Frame Set** -->  
                        <div class="toggle-frame-set" style="margin:0;">
                            <div class="toggle-frame">
                                <h5 class="toggle-accordion"><a href="#"><?=$limit?> Tugas Terakhir</a></h5>
                                <div class="toggle-content" style="display: block;">
								<? foreach($tugas as $datatugas){?>
                                    <div class="team">          
										<h6 class="role" style="margin:0"> <? $tg=tanggal($datatugas['tanggal_buat']." 00:00:00"); echo $tg[2];?> | Kelas <?=$datatugas['kelas'].$datatugas['nama_kelas']?> | <?=$datatugas['guru']?></h6>
										<p> <a class="notif" href="<?=base_url()?>akademik/detailpembelajaran/detail/<?=base64_encode(serialize(array('id'=>$datatugas['id'],'jenis'=>'tugas')))?>"><b><?=$datatugas['nama_pelajaran']?></b> | <?=$datatugas['judul']?> </a> </p>
									</div>
								<? } ?>
                                </div>
                            </div>
                        </div> <!-- **Toggle Frame Set - End** -->                         
                    </div>
					<br style="clear:both;" />
					<div class="tabs-container">
                        <ul class="tabs-frame">
                            <li><a href="#">Materi Terkini</a></li>
                        </ul>
                        <div class="tabs-frame-content toggle-content ">
                            <? foreach($materi as $datamateri){?>
                                    <div class="team">          
										<h6 class="role" style="margin:0"> <? $tg=tanggal($datamateri['tanggal_buat']." 00:00:00"); echo $tg[2];?> | Kelas <?=$datamateri['kelas'].$datamateri['nama_kelas']?> | <?=$datamateri['nama_guru']?></h6>
										<p> <a class="notif" href="<?=base_url()?>akademik/detailpembelajaran/detail/<?=base64_encode(serialize(array('id'=>$datamateri['id'],'jenis'=>'materi')))?>"><b><?=$datamateri['nama_pelajaran']?></b> | <?=$datamateri['pokok_bahasan']?> </a> </p>
									</div>
								<? } ?>
                        </div>
                    </div>	
</div>	
                    
                    <div class="clear"> </div>