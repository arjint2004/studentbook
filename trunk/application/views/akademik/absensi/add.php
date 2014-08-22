<form name="absensi" id="absensiform" method="post" action="<?=base_url()?>akademik/absensi/add" >
<table class="absensi">
    <thead>
        <tr> 
            <th> No </th>
            <th> NIS</th>
            <th> Nama </th>
            <th> Masuk </th>
            <th> Sakit </th>
            <th> Izin </th>
            <th> Alpha </th>
            <th> Keterangan </th>
        </tr>                            
    </thead>
    <tbody>
	<? $i=1;foreach($siswa as $datasiswa){?>
        <tr> 
            <td> <?=$i++?> </td>
            <td class="title"> <?=$datasiswa['nis']?> </td>
            <td class="title"> <?=$datasiswa['nama']?> </td>
            <td> 
			<input <? if(isset($siswacek)){if($siswacek[$datasiswa['id_siswa_det_jenjang']]['absensi']=='masuk'){echo 'checked';}}else{echo 'checked';}?> type="radio" name="absen[<?=$datasiswa['id_siswa_det_jenjang']?>]" value="masuk"/>  </td>
            <td> <input <? if(isset($siswacek)){if($siswacek[$datasiswa['id_siswa_det_jenjang']]['absensi']=='sakit'){echo 'checked';}}?> type="radio" name="absen[<?=$datasiswa['id_siswa_det_jenjang']?>]" value="sakit"/> </td>
            <td> <input <? if(isset($siswacek)){if($siswacek[$datasiswa['id_siswa_det_jenjang']]['absensi']=='izin'){echo 'checked';}}?> type="radio" name="absen[<?=$datasiswa['id_siswa_det_jenjang']?>]" value="izin"/> </td>
            <td> <input <? if(isset($siswacek)){if($siswacek[$datasiswa['id_siswa_det_jenjang']]['absensi']=='alpha'){echo 'checked';}}?> type="radio" name="absen[<?=$datasiswa['id_siswa_det_jenjang']?>]" value="alpha"/> </td>
            <td> <textarea class="keteranganabsen" rows="1" name="keterangan[<?=$datasiswa['id_siswa_det_jenjang']?>]"><?=@$siswacek[$datasiswa['id_siswa_det_jenjang']]['keterangan']?></textarea> </td>
        </tr>
        <? }?>                 
    </tbody>
</table>
</form>