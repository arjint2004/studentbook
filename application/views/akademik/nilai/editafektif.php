<script>
	$(document).ready(function(){

	});
</script>
<?// pr($nilai);?>
<form action="<? echo base_url();?>admin/nilaiulharian/addSubjectUlHarian" id="nilai" name="nilai" method="post" >
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
<table  class="adddata">
    <thead>
        <tr> 
            <th> No </th>
            <th> NIS </th>
            <th> Nama </th>
            <th> Nilai </th>
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
            <td class="nilai"> 
			<select name="nilai[<?=$nilai[$id_siswa_det_jenjang]['id']?>]" >
				<option <? if($nilai[$id_siswa_det_jenjang]['nilai']=='A'){echo 'selected';}?>  value="A">A</option>
				<option <? if($nilai[$id_siswa_det_jenjang]['nilai']=='B'){echo 'selected';}?>  value="B">B</option>
				<option <? if($nilai[$id_siswa_det_jenjang]['nilai']=='C'){echo 'selected';}?>  value="C">C</option>
				<option <? if($nilai[$id_siswa_det_jenjang]['nilai']=='D'){echo 'selected';}?>  value="D">D</option>
				<option <? if($nilai[$id_siswa_det_jenjang]['nilai']=='E'){echo 'selected';}?>  value="E">E</option>
			</select>
			</td>
        </tr>
	<? } ?>
    </tbody>
</table>
</form>