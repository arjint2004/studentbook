<script>
	$(document).ready(function(){
		
			var tr2='<tr baris="1" sub_baris="1" class="sub_2 ncls">1<td>&nbsp;</td><td style="width: 1%; border-right: medium none; " >1.1</td><td style="border-right: medium none;"><input type="text" name2 ></td><td><div class="add_sub_2" baris="11"></div></td><td><a class="button small light-grey hapustkx" title="" style="float:none;" baris="11" href="#">Hapus</a></td></tr>';
			
			var tr1='<tr baris="1" class="sub_1 ncls"><td>noxx</td><td colspan="2" style="width: 1%; border-right: medium none;"><input type="text" name1 ></td><td style="width:1%;"><div class="add_sub_1" baris="1"></div></td><td><a class="button small light-grey hapustkx" title="" style="float:none;" baris="1" href="#"> Hapus </a></td></tr>'+tr2;

			var tr3='<tr baris="111" class="sub_3 ncls"><td>&nbsp;</td><td style="width: 1%; border-right: medium none; padding: 2px ! important;" ></td><td style="border-right: medium none;"><input type="text" name3 style="margin-left: 20px; width: 91%;"></td><td>&nbsp;</td><td><a class="button small light-grey hapustkx" title="" baris="111" style="float:none;" href="#"> Hapus </a></td></tr>';
			

		$("a.addbaristk").live('click', function() {
			tr1=tr1.replace("hapustkx", "hapustk");
			//jumlah baris sub_1
			var baris=$("table.penghubungortutk tr.sub_1").length;
			baris++;
			tr2=tr2.replace("ncls", "");
			$("table.penghubungortutk tbody").append(tr1);
			$("table.penghubungortutk tr.sub_1").last().children('td').first().html(baris);
			$("table.penghubungortutk tr.sub_1").last().attr('baris',baris);
			$("table.penghubungortutk tr.sub_2").last().children('td').first().next().html(baris+'.1');
			$("table.penghubungortutk tr.sub_2").last().attr('baris',baris);
			$("table.penghubungortutk tr.sub_2").last().attr('sub_baris',1);
			
			haps();
			return false;
		});			
		$("table.penghubungortutk tr td div.add_sub_1").live('click', function() {
			//buat name
			tr2=tr2.replace('name1', 'name="name1[][]"');
			tr2=tr2.replace("hapustkx", "hapustk");
			$(this).parent('td').parent('tr').after(tr2);
			haps();
			return false;

		});
		$("table.penghubungortutk tr td div.add_sub_2").live('click', function() {
			tr3=tr3.replace("hapustkx", "hapustk");
			$(this).parent('td').parent('tr').after(tr3);
			haps();
			return false;
		});
		haps();
		function haps(){
			$("table.penghubungortutk tbody tr td a.hapustk").live('click', function() {
				$(this).parent('td').parent('tr').remove();
				return false;
			});		
		}

	});
</script>
<h1 class="with-subtitle">  Setting Buku Penghubung orang Tua </h1>
<h6 class="subtitle"> Data ini nanti akan muncul di akun guru untuk digunakan mencatat kegiatan siswa </h6>
<div class="styled-elements">
		<div id="ajaxside"></div>
		<div id="listpenghubungortutk">
			<form action="<? echo base_url();?>admin/penghubungortutk/addcontent" id="penghubungortutkform" name="penghubungortutkform" method="post" >
                            <!--<table class="tableprofil penghubungortutkh" border="1">

								  <tr>
									<td>
									<input placeholder="TEMA" type="text" name="textfield"></td>
									<td>
									<input placeholder="SUB TEMA" type="text" name="textfield"></td>
								  </tr>
							</table>-->
							<table class="tableprofil penghubungortutk" border="1">
								  <tbody>
								  <tr>
								    <th style="width:1%;" >No</th>
									<th colspan="3">PROGRAM PENGEMBANGAN </th>
									<th>Hapus</th>
								  </tr>

								  </tbody>
							</table>
							<a class="button small grey addbaristk" title="" href=""> Tambah Program </a>
							<a class="button small light-grey" title="" style="float:none;" href=""> Simpan </a>

				<input type="hidden" name="ajax" value="1"/> 
			</form>					
			<div class="error-container" style="display:none;"> Semua field harus di isi atau dipilih!  </div>
		</div>
    <div class="clear"> </div>
</div> <!-- **Styled Elements - End** -->  