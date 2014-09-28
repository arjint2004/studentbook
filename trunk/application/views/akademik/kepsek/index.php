<?php
$cek = session_data();
if(empty($cek)) {
	$cek = '';
}
$user = DataUser();
                    
if(empty($user->foto)) {
    $user->foto = 'asset/default/images/no_profile.jpg';
}
                        
if($cek['otoritas']=='siswa') {
     $url_redirect = site_url('sos/siswa/');
}else{
	$url_redirect = site_url('sos/pegawai/');
}
						
?>
<script>
	function ajax(self,url,load,jenis){
		if($(self).parent('h5').attr('class')=='toggle active'){
			$("#"+load).html('');
		}else{
			$.ajax({
					type: "POST",
					data: 'kepsek=true&jenis='+jenis+'&idload='+load,
					url: url,
					beforeSend: function() {
						$(self).after("<img id='wait' style='margin: 0px; position: relative; right: 260px; bottom: 21px;'  src='<?=$this->config->item('images').'loading.png';?>' />");
					},
					success: function(msg) {
						$("#wait").remove();
						$("#"+load).html(msg);
					}
			});	
		}
	}
	
    $(function(){
		$('ul.tabs-framestatistik li').click( function() {
			var self=$(this);
			$.ajax({
					type: "POST",
					data: 'kepsek=true&jenis='+$(this).attr('id'),
					url: '<?=base_url('akademik/kepsek/statistik')?>',
					beforeSend: function() {
						$(self).children('a').append("<img id='wait' style='position: relative; bottom: 0px; margin: 0px 5px;  top: 2px;'  src='<?=$this->config->item('images').'loading.png';?>' />");
					},
					success: function(msg) {
						$("#wait").remove();
						$("#cnt"+$(self).attr('id')).html(msg);
					}
			});		
		});
		if($('ul.tabs-framestatistik').length > 0) $('ul.tabs-framestatistik').tabs('> .tabs-frame-content6');
		$.ajax({
					type: "POST",
					data: 'kepsek=true&jenis=absen',
					url: '<?=base_url('akademik/kepsek/statistik')?>',
					beforeSend: function() {
						$('ul.tabs-framestatistik li#absen').children('a').append("<img id='wait' style='position: relative; bottom: 0px; margin: 0px 5px;  top: 2px;'  src='<?=$this->config->item('images').'loading.png';?>' />");
					},
					success: function(msg) {
						$("#wait").remove();
						$("#cntabsen").html(msg);
					}
			});	
    });
</script>
<div class="one-full">
                    <!-- **Team** -->
                    <div class="team">          
                        <div class="image"> <img title="" alt="" src="<?=base_url($user->foto)?>"> </div>
                        <h5> <?=$user->nama?> (Kepala Sekolah) </h5>
                        <h6 class="role"> <?=$user->nama_sekolah?> </h6>
                       <?php
							$status = status_akhir_user();
							if(!empty($status)) {
							echo $status;	
							}
						?>
						<!-- **Share Links** -->                   
                        <div class="share-links"> 
                            <div class="column one-half"> 
                                <!--Email: <a title="" href=""> j.doe@domain.com </a> -->
                                 
                            </div>
                            <div class="column one-half last"> 
                                <div class="social">
                                   <!-- <a title="" href=""> <img title="" alt="" src="<?=$this->config->item('images');?>team-facebook.png"> </a>
                                    <a title="" href=""> <img title="" alt="" src="<?=$this->config->item('images');?>team-flickr.png"> </a>
                                    <a title="" href=""> <img title="" alt="" src="<?=$this->config->item('images');?>team-skype.png"> </a>
                                    <a title="" href=""> <img title="" alt="" src="images/team-twitter.png"> </a>-->
                                    <a title="" href=""><a href="<?=site_url('sos/siswa/edit_siswa')?>" style="float:right; margin-right:5px;background:none;"> Ubah Biodata </a> <img title="" width="20" height="20" alt="" src="<?=$this->config->item('images');?>edit_icon.gif"> </a>
                                </div>
                            </div>                    
                        </div> <!-- **Share Links - End** -->                 
                    </div> <!-- **Team - End** -->               
</div>

<div class="hr toputsofile"></div>
<div class="column one-half">
    <div class="buttons">
        <a  href="<?=base_url('akademik/mainakademik/index')?>" class="tombol_parent button medium light-grey">AKADEMIK</a>
    </div>
</div>

		
<div class="column one-half last">
    <div class="buttons">
        <a  href="<?=base_url('sos/pegawai/pertemanan')?>" class="button medium tombol_parent light-grey">JEJARING SOSIAL</a>
    </div>
</div>
<div class="portfolio column-one-half-with-sidebar">	
    <!--<div class="hr "></div>
    <div class="content content-full-width" style="color: white;background: #CDCDCD;padding-top:40px;padding-bottom: 40px;">
        <div class="text_iklan">SPACE IKLAN</div>
         <p>Mengenang Iklan Sepanjang Masa</p>
    </div>
	-->
	<div class="clear"></div>
	<h3></h3>
	<div class="hr"></div>
	<div id="buttonasbin" class="buttonasbin tabs-frame-content back_berita fixed">
			<div style="width:158px;" class="readmorenoplus" title="" onclick="window.location='<?=base_url('akademik/mainakademik/index')?>'">Akademik</div>
			<div style="width:158px;" class="readmorenoplus" title="" onclick="window.location='<?=base_url('sos/pegawai/pertemanan')?>'">Jejaring Sosial</div>
			<div style="width:158px;" class="readmorenoplus" title="" onclick="$('#absensikepsek').scrollintoview({ speed:'1100'});">Absensi</div>
			<div style="width:158px;" class="readmorenoplus" title="" onclick="$('#materikepsek').scrollintoview({ speed:'1100'});">Materi</div>
			<div style="width:158px;" class="readmorenoplus" title="" onclick="$('#prkepsek').scrollintoview({ speed:'1100'});">PR</div>
			<div style="width:158px;" class="readmorenoplus" title="" onclick="$('#tugaskepsek').scrollintoview({ speed:'1100'});">Tugas</div>
			<div style="width:158px;" class="readmorenoplus" title="" onclick="$('#uhkepsek').scrollintoview({ speed:'1100'});">Ulangan Harian</div>
			<div style="width:158px;" class="readmorenoplus" title="" onclick="$('#utskepsek').scrollintoview({ speed:'1100'});">UTS</div>
			<div style="width:158px;" class="readmorenoplus" title="" onclick="$('#uaskepsek').scrollintoview({ speed:'1100'});">UAS</div>
			<div style="width:158px;" class="readmorenoplus" title="" onclick="$('#nilaikepsek').scrollintoview({ speed:'1100'});">Nilai</div>
			<div style="width:158px;" class="readmorenoplus" title="" onclick="$('#raportkepsek').scrollintoview({ speed:'1100'});">Raport</div>
			<div style="width:158px;" class="readmorenoplus" title="" onclick="$('#naiklllskepsek').scrollintoview({ speed:'1100'});">Kenaikan/Kelulusan</div>
			<div style="width:158px;" class="readmorenoplus" title="" onclick="$('#catatankepsek').scrollintoview({ speed:'1100'});">Catatan Guru</div>
			<div style="width:158px;" class="readmorenoplus" title="" onclick="$('#pribadikepsek').scrollintoview({ speed:'1100'});">Kepribadian Siswa</div>
			<div style="width:158px;" class="readmorenoplus" title="" onclick="$('#pengembangankepsek').scrollintoview({ speed:'1100'});">Pengembangan Diri Siswa</div>
			<div style="width:158px;" class="readmorenoplus" title="" onclick="$('#ekstrakepsek').scrollintoview({ speed:'1100'});">Ekstrakurikuler</div>
			<div style="width:158px;" class="readmorenoplus" title="" onclick="$('#lainkepsek').scrollintoview({ speed:'1100'});">Lain-Lain</div>
	</div>

	<!-- iklan batas -->
	<!-- end iklan batas -->	
	
	<div class="clear"></div>
	<h3> Statistik Guru </h3>
	<div class="hr"></div>
	<div class="tabs-container">
		<ul class="tabs-frame tabs-framestatistik">
			<!--<li id="rpp"><a href="#">RPP</a></li>-->
			<li id="absen"><a href="#">Absensi</a></li>
			<li id="materi"><a href="#">Materi</a></li>
			<li id="pr"><a href="#">PR</a></li>
			<li id="tugas"><a href="#">Tugas</a></li>
			<li id="harian"><a href="#">UL Harian</a></li>
			<li id="uts"><a href="#">UTS</a></li>
			<li id="uas"><a href="#">UAS</a></li>
			<!--<li id="catatan"><a href="#">Catatan</a></li>-->
			<li id="penghortu"><a href="#">Penghubung Ortu</a></li>
		</ul>
		<!--<div id="cntrpp" class="tabs-frame-content tabs-frame-content6">
			
		</div>-->
		<div id="cntabsen" class="tabs-frame-content tabs-frame-content6">
			
		</div>
		<div id="cntmateri" class="tabs-frame-content tabs-frame-content6">
			
		</div>
		<div id="cntpr" class="tabs-frame-content tabs-frame-content6">
			
		</div>
		<div id="cnttugas" class="tabs-frame-content tabs-frame-content6">
			
		</div>
		<div id="cntharian" class="tabs-frame-content tabs-frame-content6">
			
		</div>
		<div id="cntuts" class="tabs-frame-content tabs-frame-content6">
			
		</div>
		<div id="cntuas" class="tabs-frame-content tabs-frame-content6">
			
		</div>
		<!--<div id="cntcatatan" class="tabs-frame-content tabs-frame-content6">
			
		</div>-->
		<div id="cntpenghortu" class="tabs-frame-content tabs-frame-content6">
			
		</div>
	</div>	
	
</div>
        