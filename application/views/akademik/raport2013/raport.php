<html>
	<head>
		<title> Cetak Absensi </title>
		<link href="print.css" type="text/css" rel="stylesheet"  media="all"/>
		<script language="JavaScript">
		/*function varitext(text){
			text= document
			print(text)
		}*/
		</script>
	<link id="default-css" href="<?=$this->config->item('css');?>print.css" rel="stylesheet" type="text/css" media="all" />
	</head>
	<body onLoad="javascript:varitext()">
	
		<table  class="noborder" id="allset" border="1">
			<tbody>
				<tr>
					<td align="center">

						<p style="text-align: center;">
							<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 21px; line-height: 30px;"><strong>LAPORAN<BR />HASIL BELAJAR PESERTA DIDIK<BR />SEKOLAH MENENGAH PERTAMA</BR />(SMP)</strong></span></span></p>
						<p style="text-align: center;">
							<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 21px; line-height: 30px;"><strong><?=strtoupper($this->session->userdata['ak_setting']['nama_sekolah'])?></strong></span></span>
						</p>
						<p style="text-align: center; margin-top:100px;">
							<img alt="" src="<?=base_url('asset/default/images/tutwuri.jpg')?>" style="width: 100px; height: 100px;" />
						</p>
						<p style="text-align: center; margin-top:100px;">
							NAMA PESETA DIDIK
							<div style="margin: 30px auto 0px; width: 300px; padding: 10px; border: 1px solid black;">ASBIN ARJINTO M.KOM</div>
						</p>
						<p style="text-align: center; margin-top:80px;">
							<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 21px; line-height: 30px;"><strong>KEMENTRIAN PENDIDIKAN DAN KEBUDAYAAN<BR />REPUBLIK INDONESIA</strong></span></span>
						</p>						
					</td>
				</tr>
			</tbody>
		</table>

		<!-- GANTI HALAMAN -->
		<DIV style="page-break-after:always;"></DIV>
		
		<table  class="noborder" id="allset" border="1">
			<tbody>
				<tr>
					<td align="center">

						<p style="text-align: center;">
							<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 21px; line-height: 30px;"><strong>LAPORAN<BR />HASIL BELAJAR PESERTA DIDIK<BR />SEKOLAH MENENGAH PERTAMA</BR />(SMP)</strong></span></span></p>

					
					</td>
				</tr>
			</tbody>
		</table>

		<table border="1" style="width:600px;" id="allset" class="noborder pg1">
			<tbody>
					<tr align="left">
						<td style="width:142px;">Nama Sekolah</td>
						<td width="1">:</td>
						<td style="border-bottom:1px solid #000;" colspan="2">SMP DIGITAL INDONESIA</td>
					</tr>
					<tr align="left">
						<td>NIS/NSS/NDS</td>
						<td>:</td>
						<td style="border-bottom:1px solid #000;" colspan="2">&nbsp;</td>
					</tr>
					<tr align="left">
						<td>Alamat Sekolah</td>
						<td>:</td>
						<td style="border-bottom:1px solid #000;" colspan="2">&nbsp;</td>
					</tr>
					<tr align="left">
					  <td>&nbsp;</td>
					  <td>&nbsp;</td>
					  <td style="border-bottom:1px solid #000;" colspan="2">&nbsp;</td>
			  </tr>
					<tr align="left">
					  <td>&nbsp;</td>
					  <td>&nbsp;</td>
					  <td width="126" style="border-bottom:1px solid #000;">Kode Pos</td>
			          <td width="145" style="border-bottom:1px solid #000;">Telp</td>
			  </tr>
					<tr align="left">
						<td>Kelurahan</td>
						<td>:</td>
						<td style="border-bottom:1px solid #000;" colspan="2">&nbsp;</td>
					</tr>
					<tr align="left">
						<td>Kecamatan</td>
						<td>:</td>
						<td style="border-bottom:1px solid #000;" colspan="2">&nbsp;</td>
					</tr>
					<tr align="left">
						<td>Kota/Kabupaten</td>
						<td>:</td>
						<td style="border-bottom:1px solid #000;" colspan="2">&nbsp;</td>
					</tr>
					<tr align="left">
						<td>Provinsi</td>
						<td>:</td>
						<td style="border-bottom:1px solid #000;" colspan="2">&nbsp;</td>
					</tr>
					<tr align="left">
						<td>Website</td>
						<td>:</td>
						<td style="border-bottom:1px solid #000;" colspan="2">&nbsp;</td>
					</tr>
					<tr align="left">
						<td>Email</td>
						<td>:</td>
						<td style="border-bottom:1px solid #000;" colspan="2">&nbsp;</td>
					</tr>
			</tbody>
		</table>


		

		<table border="1" style="width:600px;" id="allset" class="noborder pg1">
			<tbody>
					<tr align="left">
					  <td style="width:10px;">1.</td>
						<td style="width:215px;">Nama Peserta Didik (Lengkap)</td>
						<td width="1">:</td>
						<td style="border-bottom:1px dashed #000;" >&nbsp;</td>
					</tr>
					<tr align="left">
					  <td>2.</td>
						<td>Nomor Induk</td>
						<td>:</td>
						<td style="border-bottom:1px dashed #000;" >&nbsp;</td>
					</tr>
					<tr align="left">
					  <td>3.</td>
						<td>Tempat tanggal lahir</td>
						<td>:</td>
						<td style="border-bottom:1px dashed #000;" >&nbsp;</td>
					</tr>
					<tr align="left">
					  <td>4.</td>
						<td>jebis Kelamin</td>
						<td>:</td>
						<td style="border-bottom:1px dashed #000;" >&nbsp;</td>
					</tr>
					<tr align="left">
					  <td>5.</td>
						<td>Agama</td>
						<td>:</td>
						<td style="border-bottom:1px dashed #000;" >&nbsp;</td>
					</tr>
					<tr align="left">
					  <td>6.</td>
						<td>Status Dalam keluarga</td>
						<td>:</td>
						<td style="border-bottom:1px dashed #000;" >&nbsp;</td>
					</tr>
					<tr align="left">
					  <td>7.</td>
						<td>Anak Ke</td>
						<td>:</td>
						<td style="border-bottom:1px dashed #000;" >&nbsp;</td>
					</tr>
					<tr align="left">
					  <td>8.</td>
						<td>Alamat Peserta Didik</td>
						<td>:</td>
						<td style="border-bottom:1px dashed #000;" >&nbsp;</td>
					</tr>
					<tr align="left">
					  <td>9.</td>
						<td>Nomor Telpon RUmah</td>
						<td>:</td>
						<td style="border-bottom:1px dashed #000;" >&nbsp;</td>
					</tr>
					<tr align="left">
					  <td>10.</td>
						<td>Sekolah Asal</td>
						<td>:</td>
						<td style="border-bottom:1px dashed #000;" >&nbsp;</td>
					</tr>
					<tr align="left">
					  <td>11.</td>
						<td>Diterima di dekolah Ini</td>
						<td>:</td>
						<td >&nbsp;</td>
					</tr>
					<tr align="left">
					  <td>&nbsp;</td>
						<td>Di Kelas</td>
						<td>:</td>
						<td style="border-bottom:1px dashed #000;" >&nbsp;</td>
					</tr>
					<tr align="left">
					  <td>&nbsp;</td>
						<td>Pada Tanggal</td>
						<td>:</td>
						<td style="border-bottom:1px dashed #000;" >&nbsp;</td>
					</tr>
					<tr align="left">
					  <td>&nbsp;</td>
						<td>Nama Ayah</td>
						<td>:</td>
						<td style="border-bottom:1px dashed #000;" >&nbsp;</td>
					</tr>
					<tr align="left">
					  <td>&nbsp;</td>
						<td>Nama Ibu </td>
						<td>:</td>
						<td style="border-bottom:1px dashed #000;" >&nbsp;</td>
					</tr>
					<tr align="left">
					  <td>12.</td>
						<td>Alamat Orang Tua </td>
						<td>:</td>
						<td style="border-bottom:1px dashed #000;" >&nbsp;</td>
					</tr>
					<tr align="left">
					  <td>&nbsp;</td>
					  <td>Nomor Telp rumah </td>
					  <td>&nbsp;</td>
					  <td style="border-bottom:1px dashed #000;" >&nbsp;</td>
			  </tr>
					<tr align="left">
					  <td>13.</td>
					  <td>Pekerjaan Orang Tua </td>
					  <td>&nbsp;</td>
					  <td style="border-bottom:1px dashed #000;" >&nbsp;</td>
			  </tr>
					<tr align="left">
					  <td>&nbsp;</td>
					  <td>a. Ayah </td>
					  <td>&nbsp;</td>
					  <td style="border-bottom:1px dashed #000;" >&nbsp;</td>
			  </tr>
					<tr align="left">
					  <td>&nbsp;</td>
					  <td>b. Ibu </td>
					  <td>&nbsp;</td>
					  <td style="border-bottom:1px dashed #000;" >&nbsp;</td>
			  </tr>
					<tr align="left">
					  <td>14.</td>
					  <td>Nama Wali Peserta Didik </td>
					  <td>&nbsp;</td>
					  <td style="border-bottom:1px dashed #000;" >&nbsp;</td>
			  </tr>
					<tr align="left">
					  <td>15.</td>
					  <td>Alamat Wali Peserta Didik </td>
					  <td>&nbsp;</td>
					  <td style="border-bottom:1px dashed #000;" >&nbsp;</td>
			  </tr>
					<tr align="left">
					  <td>&nbsp;</td>
					  <td>Nomor Telp Rumah </td>
					  <td>&nbsp;</td>
					  <td style="border-bottom:1px dashed #000;" >&nbsp;</td>
			  </tr>
					<tr align="left">
					  <td>16.</td>
					  <td>Pekerjaan Wali Peserta Didik </td>
					  <td>&nbsp;</td>
					  <td style="border-bottom:1px dashed #000;" >&nbsp;</td>
			  </tr>
					<tr align="left">
					  <td colspan="4">&nbsp;</td>
			  </tr>
					<tr align="left">
					  <td colspan="4">&nbsp;</td>
			  </tr>
					<tr align="left">
					  <td style="text-align:center;" colspan="3" rowspan="5"><div style="border: 1px solid black; margin: 0px auto; padding-top: 40px; height: 100px; width: 130px;">Pass Foto<br />3x4</div></td>
					  <td style="text-align:left;">...................,.....................,20............</td>
			  </tr>
					<tr align="left">
					  <td style="text-align:left;">Kepala Sekolah , </td>
			  </tr>
					<tr align="left">
					  <td height="64" style="text-align:right;">&nbsp;</td>
			  </tr>
					<tr align="left">
					  <td style="text-align:left;" >_____________________________</td>
			  </tr>
					<tr align="left">
					  <td style="text-align:left;">NIP</td>
			  </tr>
			</tbody>
		</table>
		
		<!-- GANTI HALAMAN -->
		<DIV style="page-break-after:always;"></DIV>
		<br />
		<br />
		<br />
		<br />
		<table style="max-width:1024px;" class="asbin noborder" id="allset"  border="0">
			<tr>
			  <td style="text-align:left; width:170px;">Nama Siswa </td>
			  <td style="text-align:left;">:</td>
			  <td style="text-align:left; border-bottom:1px solid #000;" ></td>
			  <td style="text-align:left;width:20px;" >&nbsp;</td>
			  <td style="text-align:left;width:170px;" >Kelas</td>
			  <td style="text-align:left;">:</td>
			  <td style="text-align:left; border-bottom:1px solid #000;" ></td>
		  </tr>
			<tr>
			  <td style="text-align:left;">Alamat</td>
			  <td style="text-align:left;">:</td>
			  <td style="text-align:left; border-bottom:1px solid #000;" ></td>
			  <td style="text-align:left;" >&nbsp;</td>
			  <td style="text-align:left;" >Semester</td>
			  <td style="text-align:left;">:</td>
			  <td style="text-align:left; border-bottom:1px solid #000;" ></td>
		  </tr>
			<tr>
			  <td style="text-align:left;">Nama</td>
			  <td style="text-align:left;">:</td>
			  <td style="text-align:left; border-bottom:1px solid #000;" ></td>
			  <td style="text-align:left;" >&nbsp;</td>
			  <td style="text-align:left;" >Tahun Pelajaran </td>
			  <td style="text-align:left;">:</td>
			  <td style="text-align:left;border-bottom:1px solid #000;" ></td>
		  </tr>
			<tr>
			  <td style="text-align:left;">Nomor Induk/NISN </td>
			  <td style="text-align:left;" width="5px">:</td>
			  <td style="text-align:left; border-bottom:1px solid #000;" ></td>
			  <td style="text-align:left;" >&nbsp;</td>
			  <td style="text-align:left;" >&nbsp;</td>
			  <td style="text-align:left;" width="5px">:</td>
			  <td style="text-align:left;border-bottom:1px solid #000;" ></td>
		  </tr>
		</table>	
		<br />
		<table style="max-width:1024px;" class="asbin" id="allset"  border="1" >
			<tr>
			  <th colspan="2" rowspan="2" align="left">MATA PELAJARAN </th>
			  <th rowspan="2">Pengetahuan (KI 3) </th>
			  <th rowspan="2">Ketrampilan (KI 4) </th>
			  <th colspan="2">Sikap Spiritual dan Sosial<br />(KI dan KI 2) </th>
		  </tr>
		  <tr>
			  <th>Dalam Mapel </th>
			  <th>Antarmapel </th>
		  </tr>
			<tr>
			  <th colspan="2" align="left">KELOMPOK A </th>
			  <th>&nbsp;</th>
			  <th>&nbsp;</th>
			  <th>SB/B/C/K</th>
			  <th>Deskripsi</th>
		  </tr>
			<tr>
			  <td>1</td>
			  <td  align="left">Pendidikan Pancasila dan Kewarganegaraan </td>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td rowspan="3">&nbsp;</td>
		  </tr>
			<tr>
			  <td colspan="2"  align="left">KELOMPOK B </td>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
		  </tr>
			<tr>
			  <td>1</td>
			  <td align="left">Seni Budaya </td>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
		  </tr>
		</table>	
		<br />
		<table style="max-width:1024px;" class="asbin" id="allset"  border="1" >
			<tr>
			  <th style="width:20px;">No</th>
			  <th>Kegiatan Ekstrakurikuler </th>
			  <th>Nilai</th>
			  <th >Keterangan</th>
		  </tr>
			<tr>
			  <td>1</td>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
		  </tr>
			<tr>
			  <td>2</td>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
		  </tr>
			<tr>
			  <td>3</td>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
		  </tr>
		</table>		
		<br />
		<br />
		<br />
		<table style="max-width:1024px;" class="asbin noborder" id="allset"  border="1" >
			<tr>
				<td style="padding:0;">
						<table style="max-width:1024px;" class="asbin noborder" id="allset"  border="0">
								<tr>
								  <th style="width:25%;">Mengetahui</td>
								  <th style="width:50%;">&nbsp;</td>
								  <th style="width:25%">................,...............20.........</td>
							    </tr>
								<tr>
								  <th>Orangtua/Wali</th>
								  <th>&nbsp;</th>
								  <th>Wali Kelas </th>
							  </tr>
								<tr>
								  <td>&nbsp;</td>
								  <td>&nbsp;</td>
								  <td>&nbsp;</td>
							  </tr>
								<tr>
								  <td>&nbsp;</td>
								  <td>&nbsp;</td>
								  <td>&nbsp;</td>
							  </tr>
								<tr>
								  <th style="border-bottom:1px solid #000;">&nbsp;</td>
								  <td>&nbsp;</td>
								  <th style="border-bottom:1px solid #000;">&nbsp;</td>
							  </tr>
								<tr>
								  <td>&nbsp;</td>
								  <td>&nbsp;</td>
								  <th style="text-align:left;">NIP...............................</td>
							  </tr>
						</table>

				</td>
			</tr>
		</table>	
		<!-- GANTI HALAMAN -->
		<DIV style="page-break-after:always;"></DIV>
		<br />
		<br />
		<br />
		<br />
		<table style="max-width:1024px;" class="asbin noborder" id="allset"  border="0">
			<tr>
			  <td style="text-align:left; width:170px;">Nama Siswa </td>
			  <td style="text-align:left;">:</td>
			  <td style="text-align:left; border-bottom:1px solid #000;" ></td>
			  <td style="text-align:left;width:20px;" >&nbsp;</td>
			  <td style="text-align:left;width:170px;" >Kelas</td>
			  <td style="text-align:left;">:</td>
			  <td style="text-align:left; border-bottom:1px solid #000;" ></td>
		  </tr>
			<tr>
			  <td style="text-align:left;">Alamat</td>
			  <td style="text-align:left;">:</td>
			  <td style="text-align:left; border-bottom:1px solid #000;" ></td>
			  <td style="text-align:left;" >&nbsp;</td>
			  <td style="text-align:left;" >Semester</td>
			  <td style="text-align:left;">:</td>
			  <td style="text-align:left; border-bottom:1px solid #000;" ></td>
		  </tr>
			<tr>
			  <td style="text-align:left;">Nama</td>
			  <td style="text-align:left;">:</td>
			  <td style="text-align:left; border-bottom:1px solid #000;" ></td>
			  <td style="text-align:left;" >&nbsp;</td>
			  <td style="text-align:left;" >Tahun Pelajaran </td>
			  <td style="text-align:left;">:</td>
			  <td style="text-align:left;border-bottom:1px solid #000;" ></td>
		  </tr>
			<tr>
			  <td style="text-align:left;">Nomor Induk/NISN </td>
			  <td style="text-align:left;" width="5px">:</td>
			  <td style="text-align:left; border-bottom:1px solid #000;" ></td>
			  <td style="text-align:left;" >&nbsp;</td>
			  <td style="text-align:left;" >&nbsp;</td>
			  <td style="text-align:left;" width="5px">:</td>
			  <td style="text-align:left;border-bottom:1px solid #000;" ></td>
		  </tr>
		</table>
		<br />
		<br />
		<table style="max-width:1024px;" class="asbin" id="allset"  border="1" >
			<tr>
			  <th colspan="2">MATA PELAJARAN </th>
			  <th>KOMPETENSI</th>
			  <th >CATATAN</th>
			</tr>
			<tr>
			  <th colspan="2" style="text-align:left;">Kelompok A </th>
			  <th>&nbsp;</th>
			  <th >&nbsp;</th>
		  </tr>
			<tr>
			  <td rowspan="3">1</td>
			  <td rowspan="3">Pendidikan Agama dan Budipekerti </td>
			  <td>Pengetahuan</td>
			  <td>Deskripsi KD pada KI 3 </td>
		  </tr>
			<tr>
			  <td>Ketrampilan</td>
			  <td>Deskripsi KD pada KI 4 </td>
		  </tr>
			<tr>
			  <td>Sikap Spiritual dan Sosial </td>
			  <td>Deskripsi KD pada KI 1 dan KI 2 </td>
		  </tr>
		  <tr>
			  <th colspan="2" style="text-align:left;">Kelompok B </th>
			  <th>&nbsp;</th>
			  <th >&nbsp;</th>
		  </tr>
		  			<tr>
			  <td rowspan="3">1</td>
			  <td rowspan="3">Pendidikan Agama dan Budipekerti </td>
			  <td>Pengetahuan</td>
			  <td>Deskripsi KD pada KI 3 </td>
		  </tr>
			<tr>
			  <td>Ketrampilan</td>
			  <td>Deskripsi KD pada KI 4 </td>
		  </tr>
			<tr>
			  <td>Sikap Spiritual dan Sosial </td>
			  <td>Deskripsi KD pada KI 1 dan KI 2 </td>
		  </tr>
		</table>
		<br />
		<table style="max-width:1024px;" class="asbin noborder" id="allset"  border="1" >
			<tr>
				<td style="padding:0;">

						
						
						<table style="width:100%;" class="asbin noborder" id="allset"  border="0">
								<tr>
								  <th style="width:25%;">Orang Tua/Wali</th>
								  <th style="width:40%;">&nbsp;</th>  
								  <th style="padding:20px 20px 0 20px;width:35%;text-align:left;border-top:1px solid #000;border-left:1px solid #000;border-right:1px solid #000;"><strong>Keputusan</strong><br /> Berdasarkan hasil Yang dicapai Semester 1 dan 2, Peserta didik ditetapkan :</th>
								</tr>
								<tr>
								  <th>&nbsp;</th>
								  <th>&nbsp;</th>
								  <th style="padding:0 20px;text-align:left; border-left:1px solid #000;border-right:1px solid #000;">naik ke kelas______(________) </th>
							  </tr>
								<tr>
								  <th>&nbsp;</th>
								  <th>&nbsp;</th>
								  <th style="padding:0 20px;text-align:left; border-left:1px solid #000;border-right:1px solid #000;">tinggal di kelas______(______)</th>
							  </tr>
								<tr>
								  <th>&nbsp;</th>
								  <th>&nbsp;</th>
								  <th style="padding:0 20px;text-align:left; border-left:1px solid #000;border-right:1px solid #000;">___________,__________20___</th>
						  </tr>
								<tr>
								  <th  style="border-bottom:1px solid #000;">&nbsp;</th>
								  <th>&nbsp;</th>
								  <th style="padding:0 20px;text-align:left; border-left:1px solid #000;border-right:1px solid #000;">Kepala Sekolah </th>
						  </tr>
								<tr>
								  <th>&nbsp;</th>
								  <th>&nbsp;</th>
								  <th  style=" border-left:1px solid #000;border-right:1px solid #000;">&nbsp;</th>
							  </tr>
								<tr>
								  <th>&nbsp;</th>
								  <th>&nbsp;</th>
								  <th style=" border-left:1px solid #000;border-right:1px solid #000;">&nbsp;</th>
							  </tr>
								<tr>
								  <th>&nbsp;</th>
								  <th>&nbsp;</th>
								  <th style="padding:0px 20px 20 20px;text-align:left; border-left:1px solid #000;border-right:1px solid #000;border-bottom:1px solid #000;">NIP...............................</th>
							  </tr>
						</table>




				</td>
			</tr>
		</table>	
<br /><br />
		<!-- GANTI HALAMAN -->
		<DIV style="page-break-after:always;"></DIV>
		
		<table  class="noborder" id="allset" border="1">
			<tbody>
				<tr>
					<td align="center">

						<p style="text-align: center;">
							<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 21px; line-height: 30px;"><strong>KETERANGAN PINDAH SEKOLAH</strong></span></span></p>
					</td>
				</tr>
				<tr>
					<td align="center">

						<p style="text-align: center;">
							<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 21px; line-height: 30px;"><strong>NAMA PESERTA DIDIK :.........................</strong></span></span></p>
					</td>
				</tr>
			</tbody>
		</table>
		<table style="max-width:1024px;" class="asbin" id="allset"  border="1" >
			<tr>
			  <th colspan="4" style="width:20px;">KELUAR </th>
		  </tr>
			<tr>
			  <th width="100px">Tanggal</th>
			  <th>Kelas Yang Ditinggalkan </th>
			  <th>Sebab-sebab Keluar atau Atas Permintaan (Tertulis) </th>
			  <th  width="300px">Tanda Tangan Kepala Sekolah, Stempel Sekolah dan Tandatangan Orang Tua / Wali </th>
		  </tr>
			<tr>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td>
				<table style="max-width:1024px;" class="asbin noborder" id="allset"  border="1" >
					<tr>
					  <td>___________________,______________________</td>
				    </tr>
					<tr>
					  <td>Kepala Sekolah </td>
					</tr>
					<tr>
					  <td>&nbsp;</td>
					</tr>
					<tr>
					  <td>&nbsp;</td>
					</tr>
					<tr>
					  <td>_________________________________________</td>
					</tr>
					<tr>
					  <td>NIP</td>
					</tr>
					<tr>
					  <td>&nbsp;</td>
					</tr>
					<tr>
					  <td>Orangtua / Wali </td>
					</tr>
					<tr>
					  <td>&nbsp;</td>
					</tr>
					<tr>
					  <td>&nbsp;</td>
					</tr>
					<tr>
					  <td>_________________________________________</td>
					  </tr>
					<tr>
					  <td>&nbsp;</td>
					</tr>
				</table>
			  </td>
		  </tr>
			<tr>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td>
				<table style="max-width:1024px;" class="asbin noborder" id="allset"  border="1" >
					<tr>
					  <td>___________________,______________________</td>
				    </tr>
					<tr>
					  <td>Kepala Sekolah </td>
					</tr>
					<tr>
					  <td>&nbsp;</td>
					</tr>
					<tr>
					  <td>&nbsp;</td>
					</tr>
					<tr>
					  <td>_________________________________________</td>
					</tr>
					<tr>
					  <td>NIP</td>
					</tr>
					<tr>
					  <td>&nbsp;</td>
					</tr>
					<tr>
					  <td>Orangtua / Wali </td>
					</tr>
					<tr>
					  <td>&nbsp;</td>
					</tr>
					<tr>
					  <td>&nbsp;</td>
					</tr>
					<tr>
					  <td>_________________________________________</td>
					  </tr>
					<tr>
					  <td>&nbsp;</td>
					</tr>
				</table>
			  </td>
		  </tr>
		</table>


			  </td>
		  </tr>
		</table>


		<br /><br /><br />
	</body>
</html><!-- 0.8326s -->