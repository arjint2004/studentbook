<? //pr($kepribadian);?>
<div id="content" class="raport">
<?=$this->load->view('siswa/raport/header')?>
<table>
                    	<thead>
                        	<tr>  
                            	<th>No</th>
                                <th>kepribadian</th>
								<? if($this->session->userdata['setting_raport'][0]['value']['kepribadian_poin']==1){?>
                                <th > Poin </th>
								<? } ?>
								<? if($this->session->userdata['setting_raport'][0]['value']['kepribadian_keterangan']==1){?>
                                <th > Keterangan </th>
								<? } ?>
								
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
								<? if($this->session->userdata['setting_raport'][0]['value']['kepribadian_poin']==1){?>
                                <td> <?=$nilaikepribadian['poin']?> </td>
								<? } ?>
								<? if($this->session->userdata['setting_raport'][0]['value']['kepribadian_keterangan']==1){?>
                                <td> <?=$nilaikepribadian['keterangan']?> </td>
								<? } ?>
                            </tr>   
							<? }} ?>
                        </tbody>
                    </table>


</div>