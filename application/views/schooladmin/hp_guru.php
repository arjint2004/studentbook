							<div id="contentpage">
							<form action="" method="post">
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
							<table id="akunguru">
								<thead>
									<tr> 
										<th> No </th>
										<th> Nama </th>
										<th> HP </th>
										<th> LOGIN </th>
									</tr>                            
								</thead>
								<tbody>
									<tr> 
										<td colspan="4"> <input type="submit" name="simpan" value="Simpan" /> </td>
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
										<td>
											<a target="_login" href="<?=base_url('u/'.base64_encode($guru['id']).'')?>">LOGIN</a>
										</td>				
									</tr> 
								<? } ?>
									<tr> 
										<td colspan="4"> <input type="submit" name="simpan" value="Simpan" /> </td>
									</tr>
								</tbody>
							</table>
							</form>
							</div>