<? //pr($absenpbymonth);?>
<table class="absensi">
    <thead>
        <tr> 
            <th> No </th>
            <th> Tanggal</th>
            <th> Kehadiran </th>
            <th> Keterangan </th>
        </tr>                            
    </thead>
    <tbody>
	<? $i=1;foreach($absenpbymonth as $dataabsen){?>
        <tr> 
            <td><?=$i++;?></td>
            <td><?=$dataabsen['tanggal']?></td>
            <td><?=$dataabsen['absensi']?></td>
            <td><?=$dataabsen['keterangan']?></td>
        </tr>
        <? }?>                 
    </tbody>
</table>
