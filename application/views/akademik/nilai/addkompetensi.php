<script>
	$(document).ready(function(){

	});
</script>
<? //pr($nilaiapraktik);?>
<form action="<? echo base_url();?>admin/nilaiulharian/addSubjectUlHarian" id="nilai" name="nilai" method="post" >
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
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
        <tr> 
            <td class="nilai"> <?=$i++;?> </td>
            <td> <?=$datasiswa['nis']?> </td>
            <td> <?=$datasiswa['nama']?> </td>
            <td class="nilai"> <?=$uts[$id_siswa_det_jenjang][0]['nilai']?> </td>
            <td class="nilai"> <?=$uas[$id_siswa_det_jenjang][0]['nilai']?> </td>
            <td class="nilai"> <?=round($nilaikognitif[$id_siswa_det_jenjang]['kognitif'],2)?> </td>
            <td class="nilai">
			<select name="nilai[<?=$id_siswa_det_jenjang?>]">
				<option value="Terlampaui" >Terlampaui</option>
				<option value="Tidak Terlampaui" >Tidak Terlampaui</option>
			</select>
			<!--<textarea rows="1" type="text" name="nilai[<?=$id_siswa_det_jenjang?>]" class="nilai"></textarea>-->
			</td>
        </tr>
	<? } ?>
    </tbody>
</table>
</form>