<? //pr($siswaekstra);?>
	<table class="adddata">
        <thead>
            
			<tr>
				<th colspan="6" style="text-align:right;">
					<a title="" class="button small light-grey absenbutton" id="simpannilaiekstra" onclick="$('#nilaiextraform').submit();"> Simpan </a>
				</th>
			</tr>
            <tr> 
                <th>No</th>
                <th>NIS</th>
                <th >Nama</th>  
                <th > Kelas </th>
                <th > Nilai </th>
                <th > Keterangan </th>
            </tr>                            
        </thead>
        <tbody>
			<? 
			pr($nilai);
			pr($siswaekstra);
			$no=1; 
			foreach($siswaekstra as $siswa=>$siswaextra){
			?>
					<? 
					$maxr=max($siswaextra['ekstra']);
					foreach($siswaextra['ekstra'] as $idm=>$dtex){?>
						<tr> 
							<td class="nilaiextra"> <?=$no++;?> </td>
							<td class="nilaiextra title"  class="title"> <?=$siswaextra['siswa']['nis']?> </td>
							<td class="nilaiextra title" > <?=$siswaextra['siswa']['nama']?> </td>
							<td class="nilaiextra title"  <? if($maxr['id']==$idm){?> class="nilaiextrain" <? } ?>> <?=$siswaextra['siswa']['kelas'];?><?=$siswaextra['siswa']['nama_kelas'];?> </td>
							<td class="nilaiextra title"  <? if($maxr['id']==$idm){?> class="nilaiextrain" <? } ?>> 
							<select name="nilai[<?=$siswaextra['siswa']['id']?>][<?=$dtex['id']?>]">
								<option <? if(@$nilai[$siswaextra['siswa']['id']][$dtex['id']]['nilai']=="A"){echo "selected";}?>>A</option>
								<option <? if(@$nilai[$siswaextra['siswa']['id']][$dtex['id']]['nilai']=="B"){echo "selected";}?>>B</option>
								<option <? if(@$nilai[$siswaextra['siswa']['id']][$dtex['id']]['nilai']=="C"){echo "selected";}?>>C</option>
								<option <? if(@$nilai[$siswaextra['siswa']['id']][$dtex['id']]['nilai']=="D"){echo "selected";}?>>D</option>
								<option <? if(@$nilai[$siswaextra['siswa']['id']][$dtex['id']]['nilai']=="E"){echo "selected";}?>>E</option>
							</select>
							<!--<input type="text" value="<?=@$nilai[$siswaextra['siswa']['id']][$dtex['id']]['nilai']?>" name="nilai[<?=$siswaextra['siswa']['id']?>][<?=$dtex['id']?>]" /> -->
							
							</td>
							<td class="nilaiextra title"  <? if($maxr['id']==$idm){?> class="nilaiextrain"<? } ?>> <textarea style="height:50px; width:200px; margin:0;"  name="keterangan[<?=$siswaextra['siswa']['id']?>][<?=$dtex['id']?>]"><?=@$nilai[$siswaextra['siswa']['id']][$dtex['id']]['keterangan']?></textarea> </td>
						</tr>   
					<? } ?>
			<? } ?>
        </tbody>
    </table>
	