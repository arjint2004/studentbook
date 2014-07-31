
<div id="content" class="raport">
<?=$this->load->view('akademik/raport/header')?>
<table>
                    	<thead>
                        	<tr>  
                            	<th>No</th>
                                <th>Ekstrakurikuler</th>
                                <th >Nilai</th>
                                <th > Keterangan </th>
                            </tr>                            
                        </thead>
                        <tbody>
							<? 
							$no=1; 
							if(!empty($ekstrakurikuler[$id_det_jenjang])){
							foreach($ekstrakurikuler[$id_det_jenjang] as $nilaiekstra){?>
                        	<tr> 
                            	<td> <?=$no++;?> </td>
                                <td class="title"> <?=$nilaiekstra['nama_ekstra']?> </td>
                                <td> <?=$nilaiekstra['nilai']?> </td>
                                <td> <?=$nilaiekstra['keterangan']?> </td>
                            </tr>   
							<? }} ?>
                        </tbody>
                    </table>


</div>