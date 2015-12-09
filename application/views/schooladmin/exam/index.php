
			<h1 class="with-subtitle"> Soal Online </h1>
				<h6 class="subtitle"> Daftar Soal online yang sudah di masukkan </h6>
                <div class="styled-elements">
					
					<div id="ajaxside"></div>
					<div id="listsemester">
						<div id="contentpage">
						<form id="filterpelajaran" method="post" action="http://webdevel/studentbookgit/admin/pelajaran/listData">
							<input type="hidden" value="" name="ci_csrf_token">
							<table class="tabelfilter">
								<tbody>
								<tr>
									<td>
										Jenjang
										<select name="jenjang" id="jenjangselect" class="selectfilter">
											<option value="">Pilih Jenjang</option>
											<option value="1">1</option>
										</select>
										Semester
										<select name="jenjang" id="jenjangselect" class="selectfilter">
											<option value="">Pilih Semester</option>
											<option value="1">1</option>
										</select>
										Pelajaran
										<select name="jenjang" id="jenjangselect" class="selectfilter">
											<option value="">Pilih Pelajaran</option>
											<option value="1">1</option>
										</select>
									</td>
								</tr>
							</tbody>
							</table>
							<input type="hidden" value="1" name="ajax">
							</form>
							<table class="tabelkelas">
								<thead>
									<tr> 
										<th>No</th>
										<th>Judul Soal</th>
										<th>Judul Soal</th>
									</tr>                            
								</thead>
								<tbody>
									
								</tbody>
							</table>
							  <div id="ajax_paging">
							  </div>
							
						</div>
					</div>
                    <div class="hr"> </div>
                    <div class="clear"> </div>
                </div> <!-- **Styled Elements - End** -->  