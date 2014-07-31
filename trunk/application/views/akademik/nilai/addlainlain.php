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
            <th> Keterangan </th>
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
				<textarea style="height:30px;" cols="30" name="nilai[<?=$id_siswa_det_jenjang?>]"></textarea>
			</td>
        </tr>
	<? } ?>
    </tbody>
</table>
</form>