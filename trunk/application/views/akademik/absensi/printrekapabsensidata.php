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

	</head>

	<body onLoad="javascript:varitext()"><style>
		table#allset{
			font-size:13px;
			font-family:arial;
		}
		table.asbin tr td{
			padding:3px 5px;
		}
		table.asbin{
			border-collapse: collapse;
			border: 1px solid black;
			width:90%;
			margin:0 auto;
			font-size:11px;
			font-family:arial;
		}
		table.noborder{
			border: 0px solid;
			width:90%;
			margin:0 auto;
			font-size:12px;
			font-family:arial;
		}
		table.noborder td{
			border: 0px solid;
			padding:0 0 0 10px;
		}
		table.noborder td.title{
			text-align:center;
		}
		table.asbin td#td_list_header {
			text-align:center;
			
		}
		</style>
		<table  class="noborder" id="allset" border="1">
			<tbody>
				<tr>
					<td align="center">
						<p style="text-align: center;">
							<img alt="" src="<?=base_url('upload/akademik/sekolah/').'/'.$this->session->userdata['ak_setting']['logo_sekolah']?>" style="width: 49px; height: 49px;" /></p>
						<p style="text-align: center;">
							<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;"><strong>DEPARTEMEN PENDIDIKAN NASIONAL REPUBLIK INDONESIA</strong></span></span></p>
						<p style="text-align: center;">
							<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;"><strong><?=strtoupper($this->session->userdata['ak_setting']['nama_sekolah'])?></strong></span></span></p>
						
					</td>
				</tr>
			</tbody>
		</table>
		<br />
		<?// pr($_POST);?>
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

		<br>
		<form name="absensi" id="absensiform" method="post" action="<?=base_url()?>akademik/absensi/add" >
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
			<th><?=$colaps['tanggal']?></th>
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