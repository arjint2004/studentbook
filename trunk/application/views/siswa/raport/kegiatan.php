<?//pr($kegiatan);?>
<div id="content" class="raport">
<?=$this->load->view('siswa/raport/header')?>
<table>
                    	<thead>
                        	<tr>  
                            	<th>No</th>
                                <th>Kegiatan</th>
                                <th > Keterangan </th>
                            </tr>                            
                        </thead>
                        <tbody>
							<? 
							$no=1; 
							if(!empty($kegiatan[$id_det_jenjang])){
							foreach($kegiatan[$id_det_jenjang] as $nilaikegiatan){?>
                        	<tr> 
                            	<td> <?=$no++;?> </td>
                                <td class="title"> <?=$nilaikegiatan['nama_kegiatan']?> </td>
                                <td> <?=$nilaikegiatan['nilai']?> </td>
                            </tr>   
							<? }} ?>
                        </tbody>
                    </table>


</div>