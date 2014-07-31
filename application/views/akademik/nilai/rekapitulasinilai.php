		<? //pr($nilai_tugas);?>
		<table>
			<thead>
				<tr>
				  <th>Pelajaran</th>
				  <th colspan="<?=count($nilai_pr);?>">PR</th>
				  <th colspan="<?=count($nilai_tugas);?>">Tugas</th>
				  <th colspan="<?=count($nilai_uh);?>">U.Harian</th>
				  <th colspan="<?=count($nilai_uts);?>">UTS</th>
				  <th colspan="<?=count($nilai_uas);?>">UAS</th>
				  <th>Nilai</th>
			  </tr>
				<tr> 
					<th>&nbsp;</th>
					
					<? foreach($nilai_pr as $id_pr=>$datapr){?>
					<th><?=$id_pr+1?></th>
					<? } ?>
					<? foreach($nilai_tugas as $id_tugas=>$datatugas){?>
					<th><?=$id_tugas+1?></th>
					<? } ?>
					
					<? foreach($nilai_uh as $id_uh=>$datauh){?>
					<th><?=$id_uh+1?></th>
					<? } ?>
					<? foreach($nilai_uts as $id_uts=>$datauts){?>
					<th><?=$id_uts+1?></th>
					<? } ?>
					<? foreach($nilai_uas as $id_uas=>$datauas){?>
					<th><?=$id_uas+1?></th>
					<? } ?>
					<th>Rata2</th>
				</tr>                         
			</thead>
			<tbody>
				<? foreach($pelajaran as $id=>$datapelajaran){?>
				<tr>
					<td class="title"><?=$datapelajaran['nama']?></td>
					<?
					foreach($nilai_pr as $id_pr=>$datapr){
					?>
					<td><? if($datapelajaran['id']==$datapr['id_pelajaran']){ echo $datapr['nilai']; @$jmlpr[$id]=$jmlpr[$id]+$datapr['nilai'];} ?></td>
					<? } ?>
					<?
					foreach($nilai_tugas as $id_tugas=>$datatugas){
					?>
					<td><? if($datapelajaran['id']==$datatugas['id_pelajaran']){ echo $datatugas['nilai']; @$jmltugas[$id]=$jmltugas[$id]+$datatugas['nilai'];} ?></td>
					<? } ?>
					
					<?
					foreach($nilai_uh as $id_uh=>$datauh){
					?>
					<td><? if($datapelajaran['id']==$datauh['id_pelajaran']){ echo $datauh['nilai']; @$jmluh[$id]=$jmluh[$id]+$datauh['nilai'];} ?></td>
					<? } ?>
					<?
					foreach($nilai_uts as $id_uts=>$datauts){
					?>
					<td><? 
						if($datapelajaran['id']==$datauts['id_pelajaran']){ 
						echo $datauts['nilai']; 
						$maxuts[$id][]=$datauts['nilai'];
						} 
					?>
					</td>
					<? } 
					@$jmluts[$id]=max($maxuts[$id]);
					?>
					
					<?
					foreach($nilai_uas as $id_uas=>$datauas){
					?>
					<td>
					<? 
					if($datapelajaran['id']==$datauas['id_pelajaran']){
						echo $datauas['nilai']; 
						$maxuas[$id][]=$datauas['nilai'];
					} 
					
					?>
					</td>
					<? }
					@$jmluas[$id]=max($maxuas[$id]);
					?>
					
					<td class="title">
					<?
					//pr($jmluas[$id]);
					//pr($jmluts[$id]);
					$pembagi[$id]=count($nilai_pr)+count($nilai_tugas)+count($nilai_uh)+2;
					$jml[$id]=(@$jmlpr[$id]+@$jmltugas[$id]+@$jmluh[$id]+@$jmluts[$id]+@$jmluas[$id])/$pembagi[$id];
					//echo @$jmlpr[$id]."+".@$jmltugas[$id]."+".@$jmluh[$id]."+".@$jmluts[$id]."+".@$jmluas[$id];
					//echo (@$jmlpr[$id]+@$jmltugas[$id]+@$jmluh[$id]+@$jmluts[$id]+@$jmluas[$id])."/".@$pembagi[$id];
					echo round($jml[$id],2);
					unset($jmluas[$id]);
					unset($jmluts[$id]);
					?>
					</td>

				</tr>	
				<? } ?>				
			</tbody>
		</table>