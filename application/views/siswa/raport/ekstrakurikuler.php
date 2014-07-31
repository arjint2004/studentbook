
<div id="content" class="raport">
<?=$this->load->view('siswa/raport/header')?>

<table>
                    	<thead>
                        	<tr>  
                            	<th>No</th>
                                <th>Ekstrakurikuler</th>
                                <? if($this->session->userdata['setting_raport'][0]['value']['ekstrakurikuler_nilai']==1){?>
								<th >Nilai</th>
								<? } ?>
								 <? if($this->session->userdata['setting_raport'][0]['value']['ekstrakurikuler_keterangan']==1){?>
                                <th > Keterangan </th>
								<? } ?>
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
								
								 <? if($this->session->userdata['setting_raport'][0]['value']['ekstrakurikuler_nilai']==1){?>
                                <td> <?=$nilaiekstra['nilai']?> </td>
								<? } ?>
								<? if($this->session->userdata['setting_raport'][0]['value']['ekstrakurikuler_keterangan']==1){?>
                                <td> <?=$nilaiekstra['keterangan']?> </td>
								<? } ?>
                            </tr>   
							<? }} ?>
                        </tbody>
                    </table>


</div>