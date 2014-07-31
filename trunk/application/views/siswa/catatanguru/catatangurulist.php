<? //pr($absenpbymonth);?>
<table class="absensi">
    <thead>
        <tr> 
            <th> No </th>
            <th> Tanggal</th>
            <th> Catatan Apresiasi </th>
            <th> Catatan Pelanggaran </th>
        </tr>                            
    </thead>
    <tbody>
	<? $i=1;foreach($absenpbymonth as $dataabsen){?>
        <tr> 
            <td><?=$i++;?></td>
            <td><?=$dataabsen['tanggal']?></td>
            <td><?=$dataabsen['apresiasi']?></td>
            <td><?=$dataabsen['pelanggaran']?></td>
        </tr>
        <? }?>                 
    </tbody>
</table>
