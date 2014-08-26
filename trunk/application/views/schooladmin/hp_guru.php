							<div id="contentpage">
							<form action="" method="post">
							<table id="akunguru">
								<thead>
									<tr> 
										<th> No </th>
										<th> Nama </th>
										<th> HP </th>
									</tr>                            
								</thead>
								<tbody>
									<tr> 
										<td colspan="3"> <input type="submit" name="simpan" value="Simpan" /> </td>
									</tr>
								<? 
								$i=$start;
								foreach($dataguru as $xx=>$guru){ $i++;?>
									<tr> 
										<td> <?=$i?> </td>
										<td class="title"> <?=$guru['nama']?> </td>
										<td>
											<input type="text" name="hp[<?=$guru['id']?>]" value="<?=$guru['hp']?>" />
										</td>				
									</tr> 
								<? } ?>
									<tr> 
										<td colspan="3"> <input type="submit" name="simpan" value="Simpan" /> </td>
									</tr>
								</tbody>
							</table>
							</form>
							</div>