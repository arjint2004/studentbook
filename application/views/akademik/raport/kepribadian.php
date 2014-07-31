<? //pr($kepribadian);?>
<div id="content" class="raport">
<?=$this->load->view('akademik/raport/header')?>
<table>
                    	<thead>
                        	<tr>  
                            	<th>No</th>
                                <th>kepribadian</th>
                                <th > Poin </th>
                                <th > Keterangan </th>
                            </tr>                            
                        </thead>
                        <tbody>
							<? 
							$no=1; 
							if(!empty($kepribadian[$id_det_jenjang])){
							foreach($kepribadian[$id_det_jenjang] as $nilaikepribadian){?>
                        	<tr> 
                            	<td> <?=$no++;?> </td>
                                <td class="title"> <?=$nilaikepribadian['nama']?> </td>
                                <td> <?=$nilaikepribadian['nilai_kepribadian']?> </td>
                                <td> <?=$nilaikepribadian['keterangan']?> </td>
                            </tr>   
							<? }} ?>
                        </tbody>
                    </table>


</div>