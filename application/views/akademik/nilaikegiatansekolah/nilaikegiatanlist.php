<? //pr($siswakegiatan);?>
	<table>
        <thead>
            
			<tr>
				<th colspan="6" style="text-align:right;">
					<a title="" class="button small light-grey absenbutton" id="simpannilaiekstra" onclick="$('#nilaikegiatanform').submit();"> Simpan </a>
				</th>
			</tr>
            <tr> 
                <th>No</th>
                <th>NIS</th>
                <th >Nama</th>  
                <th > Pengembangan Diri </th>
                <th > Nilai </th>
            </tr>                            
        </thead>
        <tbody>
			<? 
			//pr($nilai);
			//pr($siswakegiatan);
			$no=1; 
			foreach($siswakegiatan as $siswa=>$siswaextra){
			?>
		 			<tr>
					  <td class="nilaiextra" rowspan="<?=count($datakegiatan)+1;?>"> <?=$no++;?> </td>
					  <td class="nilaiextra" rowspan="<?=count($datakegiatan)+1;?>" class="title"> <?=$siswaextra['nis']?> </td>
					  <td class="nilaiextra" rowspan="<?=count($datakegiatan)+1;?>"> <?=$siswaextra['nama']?> </td>
		  			</tr>
					<? 
					$maxr=@max($datakegiatan);
					foreach($datakegiatan as $idm=>$dtex){?>
						<tr style="border-bottom:1px solid #000000;"> 
							<td style="text-align:left;" <? if($maxr['id']==$idm){?> class="nilaiextrain" <? } ?>> <?=$dtex['nama'];?> </td>
							<td  <? if($maxr['id']==$idm){?> class="nilaiextrain" <? } ?>> <textarea  class="textnilaikegiatan" style="height:50px; width:200px; margin:0;"  name="keterangan[<?=$siswaextra['id']?>][<?=$dtex['id']?>]"><?=@$nilai[$siswaextra['id']][$dtex['id']]['nilai']?></textarea> </td>
						</tr>  
					<? } ?>
			<? } ?>
			
			<tr>
				<th colspan="6" style="text-align:right;">
					<a title="" class="button small light-grey absenbutton" id="simpannilaiekstra2" onclick="$('#nilaikegiatanform').submit();"> Simpan </a>
				</th>
			</tr>
        </tbody>
    </table>
	