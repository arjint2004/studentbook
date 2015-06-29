<?=$this->load->view('siswa/js')?>		
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
<?=$this->load->view('akademik/mainakademik/topindex')?>	

<div class="portfolio column-one-half-with-sidebar">
	<div class="notifak column content content-full-width">
        <h3 class="float-left"> NOTIFIKASI AKADEMIK </h3>   
		<div class="hr"></div>
		<br style="clear:both;">
        <div class="toggle-frame">
            <h5 class="toggle-accordion"><a >Pemberitahuan terahir dari sekolah</a></h5>
            <div style="display: block; max-height:400px;" class="toggle-content">
				<? timelineakademik();?>
			</div>
        </div>                  
    </div>	
	<? //aktifitasakademik($this->session->userdata['user_authentication']['id_pengguna'],'siswa',5);?>
	<script>
		$(document).ready(function() {
				$('#contentbelajar').load('<?=base_url('akademik/bahanajar/siswa')?>');
				$.ajax({
				type: "GET",
				data: '',
				url: '<?=base_url('siswa/penghubungortutk/penghubungortu')?>',
				beforeSend: function() {
					
				},
				success: function(msg) {
					$('#penghubungortu').html(msg);
					$.ajax({
						type: "POST",
						data: 'id_kelas=<?=$this->session->userdata['user_authentication']['id_kelas_siswa_det_jenjang']?>',
						url: '<?=base_url('siswa/penghubungortutk/penghubungortulist/0')?>',
						beforeSend: function() {
						
						},
						success: function(msg) {
							$("#wait").remove();
							$('#listpenghub').html(msg);
						}
					});
				}
				});
		});
	</script>
	<div id="penghubungortu"></div>	
	
	<div class="clear"></div>
	
	<!-- iklan batas -->
	<!-- end iklan batas -->	
	<div class="clear"></div>
	<?=jadwal();?>
	
    <div class="hr "></div>

</div>


		<!-- END MAIN FRONT END -->
        