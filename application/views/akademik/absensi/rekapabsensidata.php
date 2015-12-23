<script type="text/javascript">
$(function() {
	$("table#rekapabsensi tr th a.hapusabsensi").click(function(){
		if(confirm("Data Absensi akan di hapus.")){
			$("#absensiform").append("<div class=\"error-box\" style='display: block; top: 50%; position: fixed; left: 46%;'></div>");
			$(".error-box").html("Loading Data").fadeIn("slow");			
			$.ajax({
				type: "POST",
				data: "<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&params="+$(this).attr('paramsabsrekap')+"",
				url: '<?=base_url()?>akademik/absensi/hapusabsensi',
				beforeSend: function() {
					$(".error-box").delay(1000).html('Menghapus Data');
					$(".error-box").delay(1000).fadeOut("slow",function(){
						$(this).remove();
					});
				},			
				error	: function(){
					$(".error-box").delay(1000).html('Penghapusan Data Gagal');
					$(".error-box").delay(1000).fadeOut("slow",function(){
						$(this).remove();
					});
													
				},
				success: function(msg) {
					if(msg=1){
						getaddrekap('',$('select#bulanrekapabsen').val());
					}else{
						alert('Penghapusan Data Gagal'); return false;
					}
					
				}
			});
		}
		return false;
	});
});

</script>
<form name="absensi" id="absensiform" method="post" action="<?=base_url()?>akademik/absensi/add" >
<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
<? //pr($absensi);?>
<style>
	table#rekapabsensi tr th{
		background-color:#eee;
		background-image:none;
	}
	table#rekapabsensi tr td{
		padding:5px;
	}
</style>
<table width="100%" id="rekapabsensi">
  <tr>
    <th rowspan="2" style="width:10px;vertical-align: middle;">No</th>
    <th rowspan="2" style="vertical-align: middle;">Nama</th>
    <th colspan="<?=count($absensi)?>" >Tanggal Pertemuan </th>
    <th colspan="5">Jumlah</th>
  </tr>
  <tr>
	<? if(!empty($absensi)){foreach($absensi as $colaps){?>
    <th>Tgl <?=$colaps['tanggal']?><? if($this->session->userdata['ak_setting']['jenjang'][0]['bentuk']!="SD" AND $this->session->userdata['ak_setting']['jenjang'][0]['bentuk']!="PESANTREN"){ echo "<br />Jm ke ".$colaps['jam_ke'];}
	$paramsabs=base64_encode(serialize(array('tglabs'=>$colaps['tgl'],'klsabs'=>$id_kelas,'jamkeabs'=>$colaps['jam_ke'])));
	?>
	<br>
	<a style="float: none; padding: 2px; margin: 0px; font-size: 10px;" href="" class="readmore hapusabsensi" paramsabsrekap="<?=$paramsabs?>" >Hapus</a></th>
	<? }  } ?>
    <th>Hadir</th>
    <th>Izin</th>
    <th>Sakit</th>
    <th>Alpha</th>
    <!--<th>Keterangan</th>-->
  </tr>
  <? $no=1;foreach($siswa as $datasiswa){ ?>
  <tr>
    <td><?=$no++?></td>
    <td style="text-align:left;"><?=$datasiswa['nama']?></td>
	<? 
	$hadir[$datasiswa['id_siswa_det_jenjang']]=0;
	$izin[$datasiswa['id_siswa_det_jenjang']]=0;
	$sakit[$datasiswa['id_siswa_det_jenjang']]=0;
	$alpha[$datasiswa['id_siswa_det_jenjang']]=0;
	if(!empty($absensi)){
	foreach($absensi as $datajamnya){ $i++;
	if($datajamnya['data'][$datasiswa['id_siswa_det_jenjang']]['absensi']=="masuk"){$warna="green";}
	if($datajamnya['data'][$datasiswa['id_siswa_det_jenjang']]['absensi']=="izin"){$warna="blue";}
	if($datajamnya['data'][$datasiswa['id_siswa_det_jenjang']]['absensi']=="sakit"){$warna="brown";}
	if($datajamnya['data'][$datasiswa['id_siswa_det_jenjang']]['absensi']=="alpha"){$warna="red";}
	?>
		<td style="color:<?=$warna?>;">
		<?=$datajamnya['data'][$datasiswa['id_siswa_det_jenjang']]['absensi']?>
		<?
			
			if($datajamnya['data'][$datasiswa['id_siswa_det_jenjang']]['absensi']=='masuk'){
				$hadir[$datasiswa['id_siswa_det_jenjang']]=$hadir[$datasiswa['id_siswa_det_jenjang']]+1;
			}
			if($datajamnya['data'][$datasiswa['id_siswa_det_jenjang']]['absensi']=='izin'){
				$izin[$datasiswa['id_siswa_det_jenjang']]=$izin[$datasiswa['id_siswa_det_jenjang']]+1;
			}
			if($datajamnya['data'][$datasiswa['id_siswa_det_jenjang']]['absensi']=='sakit'){
				$sakit[$datasiswa['id_siswa_det_jenjang']]=$sakit[$datasiswa['id_siswa_det_jenjang']]+1;
			}
			if($datajamnya['data'][$datasiswa['id_siswa_det_jenjang']]['absensi']=='alpha'){
				$alpha[$datasiswa['id_siswa_det_jenjang']]=$alpha[$datasiswa['id_siswa_det_jenjang']]+1;
			}
			
			
		?>
		</td>
	<? } ?>
	<? } ?>
    <td><?=$hadir[$datasiswa['id_siswa_det_jenjang']]?></td>
    <td><?=$izin[$datasiswa['id_siswa_det_jenjang']]?></td>
    <td><?=$sakit[$datasiswa['id_siswa_det_jenjang']]?></td>
    <td><?=$alpha[$datasiswa['id_siswa_det_jenjang']]?></td>
    <!--<td><?//=$datajamnya['data'][$datasiswa['id_siswa_det_jenjang']]['keterangan'];?></td>-->
  </tr>
  <?}?>
</table>


</form>