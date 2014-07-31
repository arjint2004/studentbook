<script>
	$(document).ready(function(){

	});
</script>
<? //pr($nilaiapraktik);?>
<form action="<? echo base_url();?>admin/nilaiulharian/addSubjectUlHarian" id="nilai" name="nilai" method="post" >
<table  class="adddata">
    <thead>
        <tr> 
            <th> No </th>
            <th> NIS </th>
            <th> Nama </th>
            <th> Kognitif </th>
            <th> Afektif </th>
            <th> Praktik </th>
            <th> Kompetensi </th>
        </tr>                            
    </thead>
    <tbody>
	<?
	$i=1;
	foreach($siswa as $id_siswa_det_jenjang=>$datasiswa){?>
        <tr> 
            <td class="nilai"> <?=$i++;?> </td>
            <td> <?=$datasiswa['nis']?> </td>
            <td> <?=$datasiswa['nama']?> </td>
            <td class="nilai"> <?=$nilaikognitif[$id_siswa_det_jenjang]['kognitif']?> </td>
            <td class="nilai"> <?=$nilaiafektif[$id_siswa_det_jenjang][0]['nilai']?> </td>
            <td class="nilai"> <?=$nilaiapraktik[$id_siswa_det_jenjang][0]['nilai']?> </td>
            <td class="nilai"> <textarea rows="1" type="text" name="nilai[<?=$id_siswa_det_jenjang?>]" class="nilai"><?=$nilai[$id_siswa_det_jenjang]['nilai']?></textarea> </td>
        </tr>
	<? } ?>
    </tbody>
</table>
</form>