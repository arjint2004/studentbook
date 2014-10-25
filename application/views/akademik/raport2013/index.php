<? //pr($siswa);?>
<table class="tabelfilter">
	<thead>
		<tr>
			<th>No</th>
			<th>NIS</th>
			<th>Nama</th>
			<th>Lihat Raport</th>
		</tr>
	</thead>
	<tbody>
		<? $no=1;foreach($siswa as $datasiswa){
			$url=array('nis'=>$datasiswa['nis'],'nama'=>$datasiswa['nama'],'id_siswa_det_jenjang'=>$datasiswa['id_siswa_det_jenjang'],'id'=>$datasiswa['id'],'id_kelas'=>$datasiswa['id_kelas']);
		?>
		<tr>
			<td><?=$no++?></td>
			<td style="text-align:left;"><?=$datasiswa['nis']?></td>
			<td style="text-align:left;"><?=$datasiswa['nama']?></td>
			<td><a class="lihatraport fancyboxIframe" href="<?=base_url('akademik/raport2013/lihat/'.$this->myencrypt->encode(serialize($url)).'');?>">Lihat Raport</a></td>
		</tr>
		<? } ?>
	</tbody>
</table>