<script>
	$(document).ready(function(){

	});
</script>
<?// pr($nilai);?>
<form action="<? echo base_url();?>admin/nilaiulharian/addSubjectUlHarian" id="nilai" name="nilai" method="post" >
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
            <td class="nilai"> <input type="text" name="nilai[<?=$nilai[$id_siswa_det_jenjang]['id']?>]" class="nilai" value="<?=$nilai[$id_siswa_det_jenjang]['nilai']?>" maxlength="3"/> </td>
        </tr>
	<? } ?>
    </tbody>
</table>
</form>