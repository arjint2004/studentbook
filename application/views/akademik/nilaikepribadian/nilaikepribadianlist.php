<? //pr($siswakepribadian);?>
				<script>
				$(document).ready(function(){
					$("select.nilaikepribadianselect").change(function(e){
						var obtextarea=$(this).parent('td').next('td').children('textarea');
						//alert($(obtextarea).attr('name'));
						//alert($(this).val());
						if($(this).val()=='A'){ 
							$(obtextarea).html('Sangat Baik');
						}
						if($(this).val()=='B'){ 
							$(obtextarea).html('Baik');
						}
						if($(this).val()=='C'){ 
							$(obtextarea).html('Cukup');
						}
						if($(this).val()=='D'){ 
							$(obtextarea).html('Kurang');
						}
						if($(this).val()=='E'){ 
							$(obtextarea).html('Sangat Kurang');
						}
					});
				});//Submit End

				</script>
	<table>
        <thead>
            
			<tr>
				<th colspan="6" style="text-align:right;">
					<a title="" class="button small light-grey absenbutton" id="simpannilaiekstra" onclick="$('#nilaikepribadianform').submit();"> Simpan </a>
				</th>
			</tr>
            <tr> 
                <th>No</th>
                <th>NIS</th>
                <th >Nama</th>  
                <th > Pengembangan Diri </th>
                <th > Nilai </th>
                <th > Keterangan </th>
            </tr>                            
        </thead>
        <tbody>
			<? 
			//pr($nilai);
			//pr($siswakepribadian);
			$no=1; 
			foreach($siswakepribadian as $siswa=>$siswaextra){
			?>
		 			<tr>
					  <td class="nilaiextra" rowspan="<?=count($datakepribadian)+1;?>"> <?=$no++;?> </td>
					  <td class="nilaiextra" rowspan="<?=count($datakepribadian)+1;?>" class="title"> <?=$siswaextra['nis']?> </td>
					  <td class="nilaiextra" rowspan="<?=count($datakepribadian)+1;?>"> <?=$siswaextra['nama']?> </td>
		  			</tr>
					<? 
					$maxr=@max($datakepribadian);
					foreach($datakepribadian as $idm=>$dtex){?>
						<tr style="border-bottom:1px solid #000000;"> 
							<td style="text-align:left;" <? if($maxr['id']==$idm){?> class="nilaiextrain" <? } ?>> <?=$dtex['nama'];?> </td>
							<td style="text-align:left;"  <? if($maxr['id']==$idm){?> class="nilaiextrain" <? } ?>>
							<select name="nilai[<?=$siswaextra['id']?>][<?=$dtex['id']?>]" class="nilaikepribadianselect">
								<option <?if($nilai[$siswaextra['id']][$dtex['id']]['nilai']=='A'){echo"selected";}?> value="A">A</option>
								<option <?if($nilai[$siswaextra['id']][$dtex['id']]['nilai']=='B' || $nilai[$siswaextra['id']][$dtex['id']]['nilai']==''){echo"selected";}?>  value="B" >B</option>
								<option <?if($nilai[$siswaextra['id']][$dtex['id']]['nilai']=='C'){echo"selected";}?>  value="C">C</option>
								<option <?if($nilai[$siswaextra['id']][$dtex['id']]['nilai']=='D'){echo"selected";}?>  value="D">D</option>
							</select>
							</td>
							<td  <? if($maxr['id']==$idm){?> class="nilaiextrain" <? } ?>> <textarea  class="textnilaikepribadian" style="height:50px; width:200px; margin:0;"  name="keterangan[<?=$siswaextra['id']?>][<?=$dtex['id']?>]"><?=@$nilai[$siswaextra['id']][$dtex['id']]['keterangan']?></textarea> </td>
						</tr>  
					<? } ?>
			<? } ?>
			
			<tr>
				<th colspan="6" style="text-align:right;">
					<a title="" class="button small light-grey absenbutton" id="simpannilaiekstra2" onclick="$('#nilaikepribadianform').submit();"> Simpan </a>
				</th>
			</tr>
        </tbody>
    </table>
	