<script>
	$(document).ready(function(){

	});
</script>
<? //pr($siswa);?>
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
            <td class="nilai"> 
			<select name="nilai[<?=$id_siswa_det_jenjang?>]" >
				<option value="A">A</option>
				<option value="B" selected>B</option>
				<option value="C">C</option>
				<option value="D">D</option>
				<option value="E">E</option>
			</select>
			</td>
        </tr>
	<? } ?>
    </tbody>
</table>
</form>