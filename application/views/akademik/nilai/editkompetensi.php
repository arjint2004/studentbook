<script>
	$(document).ready(function(){

	});
</script>
<? //pr($nilai);?>
<form action="<? echo base_url();?>admin/nilaiulharian/addSubjectUlHarian" id="nilai" name="nilai" method="post" >
<table  class="adddata">
    <thead>
        <tr> 
			<th> No </th>
            <th> NIS </th>
            <th> Nama </th>
            <th> UTS </th>
            <th> UAS </th>
            <th> Kognitif </th>
            <th> Deskripsi Kemajuan </th>
        </tr>                            
    </thead>
    <tbody>
	<?
	$i=1;
	foreach($siswa as $id_siswa_det_jenjang=>$datasiswa){?>
        <!--<tr> 
            <td class="nilai"> <?=$i++;?> </td>
            <td> <?=$datasiswa['nis']?> </td>
            <td> <?=$datasiswa['nama']?> </td>
            <td class="nilai"> <?=$nilaikognitif[$id_siswa_det_jenjang]['kognitif']?> </td>
            <td class="nilai"> <?=$nilaiafektif[$id_siswa_det_jenjang][0]['nilai']?> </td>
            <td class="nilai"> <?=$nilaiapraktik[$id_siswa_det_jenjang][0]['nilai']?> </td>
            <td class="nilai"> <textarea rows="1" type="text" name="nilai[<?=$id_siswa_det_jenjang?>]" class="nilai"><?=$nilai[$id_siswa_det_jenjang]['nilai']?></textarea> </td>
        </tr>-->
		<tr> 
            <td class="nilai"> <?=$i++;?> </td>
            <td> <?=$datasiswa['nis']?> </td>
            <td> <?=$datasiswa['nama']?> </td>
            <td class="nilai"> <?=$uts[$id_siswa_det_jenjang][0]['nilai']?> </td>
            <td class="nilai"> <?=$uas[$id_siswa_det_jenjang][0]['nilai']?> </td>
            <td class="nilai"> <?=round($nilaikognitif[$id_siswa_det_jenjang]['kognitif'],2)?> </td>
            <td class="nilai">
			<select <?if($nilai[$id_siswa_det_jenjang]['nilai']=="Tidak Terlampaui"){echo " style='color:red;' ";}?> name="nilai[<?=$nilai[$id_siswa_det_jenjang]['id']?>]">
				<option value="Terlampaui" <?if($nilai[$id_siswa_det_jenjang]['nilai']=="Terlampaui"){echo "selected";}?> >Terlampaui</option>
				<option value="Tidak Terlampaui" <?if($nilai[$id_siswa_det_jenjang]['nilai']=="Tidak Terlampaui"){echo "selected style='color:red;' ";}?> >Tidak Terlampaui</option>
			</select>
			<!--<textarea rows="1" type="text" name="nilai[<?=$id_siswa_det_jenjang?>]" class="nilai"></textarea>-->
			</td>
        </tr>
	<? } ?>
    </tbody>
</table>
</form>