<? //pr($prestasi);?>
<div id="content" class="raport">
<?=$this->load->view('akademik/raport/header')?>
<table>
                    	<thead>
                        	<tr>  
                            	<th>No</th>
                                <th>Kejuaraan</th>
                                <th > Tahun </th>
                                <th > Keterangan </th>
                            </tr>                            
                        </thead>
                        <tbody>
							<? 
							$no=1; 
							if(!empty($prestasi[$id_det_jenjang])){
							foreach($prestasi[$id_det_jenjang] as $nilaiprestasi){?>
                        	<tr> 
                            	<td> <?=$no++;?> </td>
                                <td class="title"> <?=$nilaiprestasi['kejuaraan']?> </td>
                                <td> <?=$nilaiprestasi['tahun']?> </td>
                                <td> <?=$nilaiprestasi['prestasi']?> </td>
                            </tr>   
							<? }} ?>
                        </tbody>
                    </table>


</div>