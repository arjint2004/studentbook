<style>
	table.penghubungortutkh, table.penghubungortutkh tr td{
		border:none;
	}
	table.penghubungortutk{
		margin-bottom:0px;
	}
	table.penghubungortutkh tr td input{
		width:96%;
	}
	table.penghubungortutk tr td{
		height: 20px;
		padding: 10px;
	}
	table.penghubungortutk tr td input{
		width:96%;
	}
</style>

<script>
	$(document).ready(function(){
		$("a.addbaristk").click(function(){
			var tr=$(this).prev('table').children('tbody').children('tr').last()[0].outerHTML;
			tr=tr.replace("hapustkx", "hapustk"); 
			$(this).prev('table').children('tbody').append(tr);
			haps();
			return false;

		});
		haps();
		function haps(){
			$("table.penghubungortutk tbody tr td a.hapustk").click(function(){
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
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                    <div class="tabs-container">
                        <ul class="tabs-frame">
                            <li><a href="#">Tematik</a></li>
                            <li><a href="#">Semester Ganjil</a></li>
                            <li><a href="#">Semester Genap</a></li>
                            <li><a href="#">Jadwal Menu Harian </a></li>
                        </ul>
                        <div class="tabs-frame-content">
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
									<th>Kegiatan</th>
									<th>Hapus</th>
								  </tr>
								  <tr>
									<td><input type="text" name="textfield"></td>
									<td><a class="button small light-grey hapustkx" title="" style="float:none;" href="#"> Hapus </a></td>
								  </tr>
								  </tbody>
							</table>
							<a class="button small grey addbaristk" title="" href=""> Tambah Baris </a>
							<a class="button small light-grey" title="" style="float:none;" href=""> Simpan </a>
                        </div>
                        <div class="tabs-frame-content">
                            <table class="tableprofil penghubungortutkh" border="1">

								  <tr>
									<td>
									<input placeholder="Judul Kegiatan" type="text" name="textfield"></td>
								  </tr>
							</table>
							<table class="tableprofil penghubungortutk" border="1">
								  <tbody>
								  <tr>
									<th>Kegiatan</th>
									<th>Hapus</th>
								  </tr>
								  <tr>
									<td><input type="text" name="textfield"></td>
									<td><a class="button small light-grey hapustkx" title="" style="float:none;" href="#"> Hapus </a></td>
								  </tr>
								  </tbody>
							</table>
							<a class="button small grey addbaristk" title="" href=""> Tambah Baris </a>
							<a class="button small light-grey" title="" style="float:none;" href=""> Simpan </a>
                        </div>
                        <div class="tabs-frame-content">
                            <table class="tableprofil penghubungortutkh" border="1">

								  <tr>
									<td>
									<input placeholder="Judul Kegiatan" type="text" name="textfield"></td>
								  </tr>
							</table>
							<table class="tableprofil penghubungortutk" border="1">
								  <tbody>
								  <tr>
									<th>Kegiatan</th>
									<th>Hapus</th>
								  </tr>
								  <tr>
									<td><input type="text" name="textfield"></td>
									<td><a class="button small light-grey hapustkx" title="" style="float:none;" href="#"> Hapus </a></td>
								  </tr>
								  </tbody>
							</table>
							<a class="button small grey addbaristk" title="" href=""> Tambah Baris </a>
							<a class="button small light-grey" title="" style="float:none;" href=""> Simpan </a>
                        </div>
                        <div class="tabs-frame-content">
                            <table class="tableprofil penghubungortutkh" border="1">

								  <tr>
									<td>
									<input placeholder="Judul Kegiatan" type="text" name="textfield"></td>
								  </tr>
							</table>
							<table class="tableprofil penghubungortutk" border="1">
								  <tbody>
								  <tr>
									<th>Kegiatan</th>
									<th>Hapus</th>
								  </tr>
								  <tr>
									<td><input type="text" name="textfield"></td>
									<td><a class="button small light-grey hapustkx" title="" style="float:none;" href="#"> Hapus </a></td>
								  </tr>
								  </tbody>
							</table>
							<a class="button small grey addbaristk" title="" href=""> Tambah Baris </a>
							<a class="button small light-grey" title="" style="float:none;" href=""> Simpan </a>
                        </div>
                    </div>					

				<input type="hidden" name="ajax" value="1"/> 
			</form>					
			<div class="error-container" style="display:none;"> Semua field harus di isi atau dipilih!  </div>
		</div>
    <div class="clear"> </div>
</div> <!-- **Styled Elements - End** -->  