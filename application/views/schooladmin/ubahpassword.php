<? //pr($sekolah);?>
			<h1 class="with-subtitle"> Ubah Password </h1>
				<h6 class="subtitle"> Mengubah password untuk admin sekolah</h6>
                <div class="styled-elements">
					<!--<a id="addguru" onclick="$('#ajaxside').load('<?=base_url()?>admin/semester/adddata')" title="guru" class="readmore readmoreasb"> <span> Tambah semester </span></a>-->
					<div id="ajaxside"></div>
					<div id="listsemester">
						<div id="contentpage">
						<form action="" method="post" id="ubahpassword" />
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
							<input type="hidden"  value="1" name="ajax">
							<table class="tableprofil">
								<thead>
									<tr> 
										<th colspan="3">Edit Password</th>
									</tr>                            
								</thead>
								<tbody>	
									<tr>
										<td width="150" class="title">Masukkan password lama</td>
										<td width="1">:</td>
										<td class="title"><input  type="password" size="40" placeholder="Masukkan Password lama" value="<?=@$_POST['password_lama']?>" name="password_lama"></td>
									</tr>
									<tr>
										<td class="title">Password baru</td>
										<td width="1">:</td>
										<td class="title"><input  type="password" size="50" placeholder="Masukkan Password baru" value="<?=@$_POST['password']?>"   name="password"></td>
									</tr>
									<tr>
										<td class="title">Masukkan konfirmasi password baru</td>
										<td width="1">:</td>
										<td class="title"><input  type="password" size="50" placeholder="Ulangi Password baru" value="<?=@$_POST['passwordc']?>"   name="passwordc"></td>
									</tr>
									<tr>
										<td class="title" colspan="3"><input type="submit" class="simpanprofilr" name="simpan" value="Simpan"></td>
									</tr>
								</tbody>
							</table>
							</form>
						</div>
                    <div class="hr"> </div>
                    <div class="clear"> </div>
                </div> <!-- **Styled Elements - End** --> 