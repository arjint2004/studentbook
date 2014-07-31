<? //pr($absensi);?>
<div id="content" class="raport">
<?=$this->load->view('siswa/raport/header')?>
<table>
                    	<thead>
                        	<tr>  
                            	<th> No </th>
                            	<th> Tanggal </th>
                                <th> Ketidakhadiran </th>
                                <th> Keterangan </th>
                            </tr>                            
                        </thead>
                        <tbody>
						<? $no=1; foreach($absensi as $databsensi){?>
                        	<tr> 
                            	<td> <?=$no?> </td>
                                <td class="title"> <?=$databsensi['tanggal']?> </td>
                                <td> <?=$databsensi['absensi']?> </td>
                                <td> <?=$databsensi['keterangan']?> </td>
                            </tr>
						<? } ?>
                        </tbody>
                    </table>


</div>