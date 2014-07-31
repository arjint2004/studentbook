<? //pr($siswaekstra);?>
	<table class="adddata">
        <thead>
            
			<tr>
				<th colspan="6" style="text-align:right;">
					<a title="" class="button small light-grey absenbutton" id="simpannilaiekstra" onclick="$('#nilaiextraform').submit();$('#subjectlistextrax').scrollintoview({ speed:'1100'});"> Simpan </a>
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
			//pr($nilai);
			//pr($siswaekstra);
			$no=1; 
			foreach($siswaekstra as $siswa=>$siswaextra){
			?>
				<tr> 
					<td class="nilaiextra"> <?=$no++;?> </td>
					<td class="nilaiextra title"  class="title"> <?=$siswaextra['nis']?> </td>
					<td class="nilaiextra title" > <?=$siswaextra['nama']?> </td>
					<td class="nilaiextra title" > <?=$siswaextra['kelas'];?><?=$siswaextra['nama_kelas'];?> </td>
					<td class="nilaiextra title" > 
					<select name="nilai[<?=$siswaextra['id']?>][<?=$siswaextra['id_ekstrakurikuler']?>]">
						<option <? if(@$nilai[$siswaextra['id']][$siswaextra['id_ekstrakurikuler']]['nilai']=="A"){echo "selected";}?>>A</option>
						<option <? if(@$nilai[$siswaextra['id']][$siswaextra['id_ekstrakurikuler']]['nilai']=="B"){echo "selected";}?>>B</option>
						<option <? if(@$nilai[$siswaextra['id']][$siswaextra['id_ekstrakurikuler']]['nilai']=="C"){echo "selected";}?>>C</option>
						<option <? if(@$nilai[$siswaextra['id']][$siswaextra['id_ekstrakurikuler']]['nilai']=="D"){echo "selected";}?>>D</option>
						<option <? if(@$nilai[$siswaextra['id']][$siswaextra['id_ekstrakurikuler']]['nilai']=="E"){echo "selected";}?>>E</option>
					</select>
					<!--<input type="text" value="<?=@$nilai[$siswaextra['id']][$siswaextra['id_ekstrakurikuler']]['nilai']?>" name="nilai[<?=$siswaextra['id']?>][<?=$siswaextra['id_ekstrakurikuler']?>]" /> -->
							
					</td>
					<td class="nilaiextra title"  <? if($maxr['id']==$idm){?> class="nilaiextrain"<? } ?>> <textarea style="height:50px; width:200px; margin:0;"  name="keterangan[<?=$siswaextra['id']?>][<?=$siswaextra['id_ekstrakurikuler']?>]"><?=@$nilai[$siswaextra['id']][$siswaextra['id_ekstrakurikuler']]['keterangan']?></textarea> </td>
				</tr>   
			<? } ?>
			<tr>
				<th colspan="6" style="text-align:right;">
					<a title="" class="button small light-grey absenbutton" id="simpannilaiekstra" onclick="$('#nilaiextraform').submit();$('#subjectlistextrax').scrollintoview({ speed:'1100'});"> Simpan </a>
				</th>
			</tr>
        </tbody>
    </table>
	