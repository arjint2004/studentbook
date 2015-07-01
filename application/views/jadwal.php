	<div id="jadwalhelper">
	<? //pr($jadwal);?>
	<script>
	$(document).ready(function(){
			$("form#selectklsjadwal select").change(function(e){
				$("form#selectklsjadwal").submit();
				/*$.ajax({
					type: "POST",
					data: '<?php echo $CI->security->get_csrf_token_name();?>=<?php echo $CI->security->get_csrf_hash(); ?>&id_kelas='+$(this).val(),
					url: '<?=base_url()?>akademik/jadwal/index',
					beforeSend: function() {
						$('select#kelas_addjadwal').after("<img id='wait' src='<?=$CI->config->item('images').'loading.png';?>' />");
					},
					success: function(msg) {
						$('#wait').remove();
						$("#jadwalhelper").html(msg);	
					}
				});
			*///Submit End
			});
			<?if(isset($_POST['postjadwal'])){?>
				$('div#jadwalhelper div#contentpage').scrollintoview({ speed:'1100'});
				$('b.klsjdwl').html($('form#selectklsjadwal table tr td select#kelas_addjadwal :selected').text());
			<? } ?>
	});
	</script>
	<h3 id="jadwalpelajaran"> Jadwal </h3>
	<div class="hr"></div>
		<? //pr($CI->session->userdata['user_authentication']);?>
	<div id="contentpage">
		<form id="selectklsjadwal" action="<?=base_url()?>akademik/mainakademik/index" method="post">
		<input type="hidden" name="<?php echo $CI->security->get_csrf_token_name(); ?>" value="<?php echo $CI->security->get_csrf_hash(); ?>">
		<table class="tabelfilter">
			<tbody><tr>
				<td><?
				if($CI->session->userdata['user_authentication']['otoritas']=='ortu' || $CI->session->userdata['user_authentication']['otoritas']=='siswa'){
					echo selectkelasbyIdDetJenjang('jadwal');
				}else{
					echo selectkelasbyIdpegawai('jadwal');
				}
				
				?></td>
				</tr>
			</tbody>
		</table>
		<input type="hidden" name="postjadwal" value="1" />
		</form>
		
	</div>	
	<div class="tabs-container">
		<ul class="tabs-frame">
			<li>
				<a class="current">Hari Ini</a>
			</li>
			<!--<li>
				<a class="current">Semua</a>
			</li>-->
			<?if(isset($_POST['postjadwal'])){?>
			<li>
				<a class="current">Hari Ini Kelas <b class="klsjdwl"></b></a>
			</li>
			<li>
				<a class="">Kelas <b class="klsjdwl"></b></a>
			</li>
			<? } ?>
		</ul>
		<div style="display: block;" class="tabs-frame-content back_berita">    
			<h5> <?=$tglx[0]?> </h5>
			<div class="hr"></div>
			<table>
                <thead>
                    <tr> 
                        <th> Pelajaran </th>
                        <th> Jam </th>
                        <th> Kelas </th>
                    </tr>                            
                </thead>
                <tbody>
                    <? foreach($jadwal['semuahariini'] as $datanow){
						$startime=explode(" ",$datanow['StartTime']);
						$endtime=explode(" ",$datanow['EndTime']);
						
					?>
					<tr> 
                        <td class="title"> <?=$datanow['Subject']?> </td>
                        <td> <?=$startime[1]?> - <?=$endtime[1]?> </td>
                        <td> <?=$datanow['kelas']?><?=$datanow['nama_kelas']?> </td>
                    </tr>
                    <? } ?>
                </tbody>
            </table>
		</div>
		<!--<div style="display: none;" class="tabs-frame-content back_berita">
            
			<? //foreach($jadwal['semuamingguan'] as $hari=>$datamingguan){
			?>
			<h5> <?//=$hari?> </h5>
			<div class="hr"></div>
            <table>
                <thead>
                    <tr> 
                        <th> Pelajaran </th>
                        <th> Jam </th>
                        <th> Kelas </th>
                    </tr>                            
                </thead>
                <tbody>
                    <? //foreach($datamingguan as $datajadwalm){
						//pr($datajadwalm);
						//$startime=explode(" ",$datajadwalm['StartTime']);
						//$endtime=explode(" ",$datajadwalm['EndTime']);					
					?>
					<tr> 
                        <td class="title"> <?//=$datajadwalm['Subject']?> </td>
                        <td> <?//=$startime[1]?> - <?//=$endtime[1]?> </td>
                        <td> <?//=$datajadwalm['kelas']?><?//=$datajadwalm['nama_kelas']?> </td>
                    </tr> 
					<? //} ?>
                </tbody>
            </table>
			
			<? //} ?>	
		</div>-->
		<?if(isset($_POST['postjadwal'])){?>
		<div style="display: none;" class="tabs-frame-content back_berita">
            
			<h5> <?=$tglx[0]?> </h5>
			<div class="hr"></div>
			<table>
                <thead>
                    <tr> 
                        <th> Pelajaran </th>
                        <th> Jam </th>
                        <th> Kelas </th>
                    </tr>                            
                </thead>
                <tbody>
                    <? foreach($jadwal['now'] as $datanow){
						$startime=explode(" ",$datanow['StartTime']);
						$endtime=explode(" ",$datanow['EndTime']);
						
					?>
					<tr> 
                        <td class="title"> <?=$datanow['Subject']?> </td>
                        <td> <?=$startime[1]?> - <?=$endtime[1]?> </td>
                        <td> <?=$datanow['kelas']?><?=$datanow['nama_kelas']?> </td>
                    </tr>
                    <? } ?>
                </tbody>
            </table>
		</div>
		<div style="display: none;" class="tabs-frame-content">
			
			
            <? foreach($jadwal['mingguan'] as $hari=>$datamingguan){
			?>
			<h5> <?=$hari?> </h5>
			<div class="hr"></div>
            <table>
                <thead>
                    <tr> 
                        <th> Pelajaran </th>
                        <th> Jam </th>
                        <th> Kelas </th>
                    </tr>                            
                </thead>
                <tbody>
                    <? foreach($datamingguan as $datajadwalm){
						//pr($datajadwalm);
						$startime=explode(" ",$datajadwalm['StartTime']);
						$endtime=explode(" ",$datajadwalm['EndTime']);					
					?>
					<tr> 
                        <td class="title"> <?=$datajadwalm['Subject']?> </td>
                        <td> <?=$startime[1]?> - <?=$endtime[1]?> </td>
                        <td> <?=$datajadwalm['kelas']?><?=$datajadwalm['nama_kelas']?> </td>
                    </tr> 
					<? } ?>
                </tbody>
            </table>
			
			<? } ?>			
		</div>
		<? } ?>		
	</div>
	</div>