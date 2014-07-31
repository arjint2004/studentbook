
		<table>
			<thead>
				<tr>
				  <th>Nama Siswa</th>
				  <th colspan="<?=count(@$cpr[0]);?>">PR</th>
				  <th colspan="<?=count(@$ctugas[0]);?>">Tugas</th>
				  <th colspan="<?=count(@$cuh[0]);?>">U.Harian</th>
				  <th colspan="2">UTS</th>
				  <th colspan="2">UAS</th>
				  <th>Nilai Akhir </th>
			    </tr>
				<tr> 
					<th>&nbsp;</th>
					<? 
					if(!empty($cpr[0])){
					foreach($cpr[0] as $id_pr=>$datapr){?>
					<th><?=$id_pr+1?></th>
					<? } } ?>
					<? 
					if(!empty($ctugas[0])){
					foreach($ctugas[0] as $id_tugas=>$datatugas){?>
					<th><?=$id_tugas+1?></th>
					<? } } ?>
					
					<? 
					if(!empty($cuh[0])){
					foreach($cuh[0] as $id_uh=>$datauh){?>
					<th><?=$id_uh+1?></th>
					<? }} ?>
					<th>U</th>
					<th>R</th>
					<th>U</th>
					<th>R</th>
					<th>Jumlah Rata</th>
				</tr>                         
			</thead>
			<tbody>
				<? 
				
				foreach($siswa as $id=>$datasiswa){?>
				<tr>
					<td class="title"><?=$datasiswa['nama']?></td>
					
					<? 
					if(!empty($cpr[0])){
					foreach($cpr[0] as $id_pr=>$datapr){?>
					<td><?=$nilai_pr[$datasiswa['id_siswa_det_jenjang']][$id_pr]['nilai']?></td>
					<? 
					@$jmlpr[$id]=$jmlpr[$id]+$nilai_pr[$datasiswa['id_siswa_det_jenjang']][$id_pr]['nilai'];
					}} ?>
					
					<? 
					if(!empty($ctugas[0])){
					foreach($ctugas[0] as $id_tugas=>$datatugas){?>
					<td><?=$nilai_tugas[$datasiswa['id_siswa_det_jenjang']][$id_tugas]['nilai']?></td>
					<? 
					@$jmltugas[$id]=$jmltugas[$id]+$nilai_tugas[$datasiswa['id_siswa_det_jenjang']][$id_tugas]['nilai'];
					}} ?>
					
					<? 
					if(!empty($cuh[0])){
					foreach($cuh[0] as $id_uh=>$datauh){?>
					<td><?=$nilai_uh[$datasiswa['id_siswa_det_jenjang']][$id_uh]['nilai']?></td>
					<? 
					@$jmluh[$id]=$jmluh[$id]+$nilai_uh[$datasiswa['id_siswa_det_jenjang']][$id_uh]['nilai'];
					}} ?>
										
					<td><?if(isset($nilai_uts2[$datasiswa['id_siswa_det_jenjang']][0])){echo $nilai_uts2[$datasiswa['id_siswa_det_jenjang']][0];}?></td>
					<td><?if(isset($nilai_uts2[$datasiswa['id_siswa_det_jenjang']][1])){echo $nilai_uts2[$datasiswa['id_siswa_det_jenjang']][1];}?></td>		
					
					<td><?if(isset($nilai_uas2[$datasiswa['id_siswa_det_jenjang']][0])){echo $nilai_uas2[$datasiswa['id_siswa_det_jenjang']][0];}?></td>
					<td><?if(isset($nilai_uas2[$datasiswa['id_siswa_det_jenjang']][1])){echo $nilai_uas2[$datasiswa['id_siswa_det_jenjang']][1];}?></td>
					
					<td>
					<?
					if(!empty($nilai_uts2[$datasiswa['id_siswa_det_jenjang']]) && !empty($nilai_uas2[$datasiswa['id_siswa_det_jenjang']])){
						$uts=max(@$nilai_uts2[$datasiswa['id_siswa_det_jenjang']]);
						$uas=max(@$nilai_uas2[$datasiswa['id_siswa_det_jenjang']]);
						
						$pembagi=count(@$cpr[0])+count(@$ctugas[0])+count(@$cuh[0])+2;
						//echo '('.$jmlpr[$id].'+'.$jmltugas[$id].'+'.$jmluh[$id].'+'.$uts.'+'.$uas.')/'.$pembagi;
						echo round((@$jmlpr[$id]+@$jmltugas[$id]+@$jmluh[$id]+@$uts+@$uas)/@$pembagi,2);
					}	
						
					?>
					</td>
				</tr>	
				<? } ?>				
			</tbody>
		</table>