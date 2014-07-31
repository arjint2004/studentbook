					<h1 class="with-subtitle"> Gagal Import </h1>
					<h6 class="subtitle"> Data di bawah ini gagal masuk ke dalam database karena NIS tidak unik  </h6><a href="<?php echo base_url(); ?>admin/schooladmin/dataakun"><< Kembali Ke data Akun</a>							
							<table>
								<thead>
									<tr> 
										<th> No </th>
										<th> NIS </th>
										<th> Nama </th>
										<th> Nama Ortu </th>
									</tr>                            
								</thead>
								<tbody>
								<? 
								//if($halaman==0){$halaman=1;}
								$i=$start;
								foreach($not_import as $xx=>$siswa){ $i++;?>
									<tr> 
										<td> <?=$i?> </td>
										<td> <?=$siswa['nis']?> </td>
										<td> <?=$siswa['nama']?> </td>
										<td> <?=$siswa['namaortu']?> </td>
									</tr> 
								<? } ?>
								</tbody>
							</table>