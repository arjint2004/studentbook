<html>
	<head>
		<title> Cetak Absensi </title>
		<link href="print.css" type="text/css" rel="stylesheet"  media="all"/>
		<script language="JavaScript">
		function varitext(text){
			text= document
			print(text)
		}
		</script>
	<link id="default-css" href="<?=$this->config->item('css');?>print.css" rel="stylesheet" type="text/css" media="all" />
	</head>

	<body onLoad="javascript:varitext()">
	
		<table  class="noborder" id="allset" border="1">
			<tbody>
				<tr>
					<td align="center">
						<p style="text-align: center;">
							<img alt="" src="<?=base_url('upload/akademik/sekolah/').'/'.$this->session->userdata['ak_setting']['logo_sekolah']?>"  /></p>
						<p style="text-align: center;">
							<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;"><strong>DEPARTEMEN PENDIDIKAN NASIONAL REPUBLIK INDONESIA</strong></span></span></p>
						<p style="text-align: center;">
							<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;"><strong><?=strtoupper($this->session->userdata['ak_setting']['nama_sekolah'])?></strong></span></span></p>
						
					</td>
				</tr>
			</tbody>
		</table>
		<? if($this->session->userdata['ak_setting']['jenjang'][0]['bentuk']=="PESANTREN"){?>
		<table  class="noborder" id="allset" border="1">
			<tbody>
					<tr align="left">
						<td colspan="3" align="center" class="title"  height="30" style="border-bottom:2px solid #000;"><font size="3"><strong>LEMBAR ABSENSI SISWA</strong></font><br /><br /></td>						
					</tr>
					<tr align="left">
						<td colspan="3" align="center" class="title"  height="30" ></td>
					</tr>
					<tr align="left">
						<td>Aktitas</td>
						<td>:</td>
						<td><?=$_POST['aktifitas']?></td>
					</tr>
					<tr align="left">
						<td>Kegiatan</td>
						<td>:</td>
						<td><?=$_POST['kegiatan']?></td>
					</tr>
					<tr align="left">
						<td>Absensi Bulan</td>
						<td>:</td>
						<td><? 
								$monthNum = sprintf("%02s", $_POST['month']);
								echo date("F", mktime(null, null, null, $monthNum));
						?></td>
					</tr>
					<tr align="left">
						<td width="100px">Kelas</td>
						<td width="4px">:</td>
						<td><?=$kelas[0]['nama']?></td>									
					</tr>
					<tr align="left">
						<td>Semester</td>
						<td>:</td>
						<td><?=strtoupper($this->session->userdata['ak_setting']['semester_nama'])?></td>
					</tr>
					<tr align="left">
						<td>Tahun Pelajaran</td>
						<td>:</td>
						<td ><?=strtoupper($this->session->userdata['ak_setting']['ta_nama'])?></td>
					</tr>
			</tbody>
		</table>
		<? }else{?>
		<table  class="noborder" id="allset" border="1">
			<tbody>
					<tr align="left">
						<td colspan="3" align="center" class="title"  height="30" style="border-bottom:2px solid #000;"><font size="3"><strong>LEMBAR ABSENSI SISWA</strong></font><br /><br /></td>						
					</tr>
					<tr align="left">
						<td colspan="3" align="center" class="title"  height="30" ></td>
					</tr>
					<tr align="left">
						<td>Nama Sekolah</td>
						<td>:</td>
						<td><?=strtoupper($this->session->userdata['ak_setting']['nama_sekolah'])?></td>
					</tr>
					<tr align="left">
						<td>Absensi Bulan</td>
						<td>:</td>
						<td><? 
								$monthNum = sprintf("%02s", $_POST['month']);
								echo date("F", mktime(null, null, null, $monthNum));
						?></td>
					</tr>
					<tr align="left">
						<td width="100px">Kelas</td>
						<td width="4px">:</td>
						<td><?=$kelas[0]['kelas'].$kelas[0]['nama']?></td>									
					</tr>
					<tr align="left">
						<td>Semester</td>
						<td>:</td>
						<td><?=strtoupper($this->session->userdata['ak_setting']['semester_nama'])?></td>
					</tr>
					<tr align="left">
						<td>Tahun Pelajaran</td>
						<td>:</td>
						<td ><?=strtoupper($this->session->userdata['ak_setting']['ta_nama'])?></td>
					</tr>
			</tbody>
		</table>
		<? } ?>
		<br>
		<form name="absensi" id="absensiform" method="post" action="<?=base_url()?>akademik/absensi/add" >
		<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
		<? //pr($absensi);?>
		<table width="90%" id="rekapabsensi"class="asbin" id="allset"  border="1">
		  <tr>
			<th rowspan="2" style="width:10px;vertical-align: middle;">No</th>
			<th rowspan="2" style="vertical-align: middle;">Nama</th>
			<th colspan="<?=count($absensi)?>" >Tanggal Pertemuan </th>
			<th colspan="4">Jumlah</th>
		  </tr>
		  <tr>
			<? if(!empty($absensi)){foreach($absensi as $colaps){?>
			<th>Tgl <?=$colaps['tanggal']?><? if($this->session->userdata['ak_setting']['jenjang'][0]['bentuk']!="SD" AND $this->session->userdata['ak_setting']['jenjang'][0]['bentuk']!="PESANTREN"){ echo "<br />Jm ke ".$colaps['jam_ke'];}?></th>
			<? }  } ?>
			<th>Hadir</th>
			<th>Izin</th>
			<th>Sakit</th>
			<th>Alpha</th>
		  </tr>
		  <? $no=1;foreach($siswa as $datasiswa){ ?>
		  <tr>
			<td  style="text-align:center;"><?=$no++?></td>
			<td style="text-align:left;"><?=$datasiswa['nama']?></td>
			<? 
			$hadir[$datasiswa['id_siswa_det_jenjang']]=0;
			$izin[$datasiswa['id_siswa_det_jenjang']]=0;
			$sakit[$datasiswa['id_siswa_det_jenjang']]=0;
			$alpha[$datasiswa['id_siswa_det_jenjang']]=0;
			if(!empty($absensi)){
			foreach($absensi as $datajamnya){ $i++;?>
				<td style="text-align:center;">
				<?=$datajamnya['data'][$datasiswa['id_siswa_det_jenjang']]['absensi']?>
				<?
					
					if($datajamnya['data'][$datasiswa['id_siswa_det_jenjang']]['absensi']=='masuk'){
						$hadir[$datasiswa['id_siswa_det_jenjang']]=$hadir[$datasiswa['id_siswa_det_jenjang']]+1;
					}
					if($datajamnya['data'][$datasiswa['id_siswa_det_jenjang']]['absensi']=='izin'){
						$izin[$datasiswa['id_siswa_det_jenjang']]=$izin[$datasiswa['id_siswa_det_jenjang']]+1;
					}
					if($datajamnya['data'][$datasiswa['id_siswa_det_jenjang']]['absensi']=='sakit'){
						$sakit[$datasiswa['id_siswa_det_jenjang']]=$sakit[$datasiswa['id_siswa_det_jenjang']]+1;
					}
					if($datajamnya['data'][$datasiswa['id_siswa_det_jenjang']]['absensi']=='alpha'){
						$alpha[$datasiswa['id_siswa_det_jenjang']]=$alpha[$datasiswa['id_siswa_det_jenjang']]+1;
					}
					
					
				?>
				</td>
			<? }} ?>
			<td style="text-align:center;"><?=$hadir[$datasiswa['id_siswa_det_jenjang']]?></td>
			<td style="text-align:center;"><?=$izin[$datasiswa['id_siswa_det_jenjang']]?></td>
			<td style="text-align:center;"><?=$sakit[$datasiswa['id_siswa_det_jenjang']]?></td>
			<td style="text-align:center;"><?=$alpha[$datasiswa['id_siswa_det_jenjang']]?></td>
		  </tr>
		  <?}?>
		</table>
		</form>				
		<table id="allset" align="center">
            <tbody>
                <tr>
                    <td width="200" align="center"><br> </td>
                    <td width="350" align="center"><br>  </td>
                    <td width="379" align="center"><br>  Wali Kelas</td>
                </tr>
                <tr>
                    <td height="50" colspan="5"></td>
                </tr>
                <tr>
                        <td align="center"></td>
                        <td align="center">

						</td>
                        <td align="center">
							<u>
							   <?=$walikelas[0]['nama']?>                          
							</u><br>
							   NIP:
							   <?=$walikelas[0]['nip']?>    						
						</td>
                </tr>
            </tbody>
		</table>
		<br /><br /><br /><br /><br />
		<!-- GANTI HALAMAN -->
		<DIV style="page-break-after:always"></DIV>
		<DIV style="page-break-after:always"></DIV>
	</body>
</html><!-- 0.8326s -->