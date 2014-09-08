<form name="absensi" id="absensiform" method="post" action="<?=base_url()?>akademik/absensi/add" >
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
    <th colspan="4">Jumlah</th>
  </tr>
  <tr>
	<? if(!empty($absensi)){foreach($absensi as $colaps){?>
    <th><?=$colaps['tanggal']?></th>
	<? }  } ?>
    <th>Hadir</th>
    <th>Izin</th>
    <th>Sakit</th>
    <th>Alpha</th>
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
	foreach($absensi as $datajamnya){ $i++;?>
		<td>
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
  </tr>
  <?}?>
</table>


</form>