				<script>
				$(document).ready(function(){
					$('form#formotoritas').submit(function(){
						if($("#wali_kelas").is(':checked')){
							if($('select#id_kelasotoritas').val()==''){
								$('select#id_kelasotoritas').css('border','1px solid red');
								alert('Kelas harus di pilih.');
								return false;
							}
						}

					});
					$("#wali_kelas").click(function(){
						if($(this).is(':checked')){
							$('select#id_kelasotoritas option.pilih').attr('value','');
						}else{
							$('select#id_kelasotoritas option.pilih').attr('value',0);
						}
					})
				});

				</script>
		<!-- **Column One Half** -->   	
                <h3> Set otoritas Akun </h3>
				<div class="column fullotoritas">
                    <!-- **Team** -->
			<form action="<?=base_url()?>admin/otoritas/setotoritas/<?=$dataId?>" method="post" id="formotoritas">                    
						<div class="team">          
                        <div class="image"> 
						
						<? if($pegawai[0]['foto']==''){?>
						<img width="130" height="150" src="<?=$this->config->item('images').'profil.jpg';?>" alt="" title="" /> 
						<?}else{?>
						<img width="130" height="150" src="<?=base_url().$pegawai[0]['foto'];?>" alt="" title="" /> 
						<? } ?>
						</div>
                        <h5> <?=$pegawai[0]['nama']?> </h5>
                        <!--<h6 class="role"> <?=$otoritas?> </h6>-->
<?//pr($kepsek);?>
<? //pr(unserialize(base64_decode($dataId)));?>
								<ul class="setotoritas">
									<? 
									
									switch($otoritas){
									 case 'guru':
									?>
									<li>
										<ul>
											<? if($kepsek[0]['id_user']==$dataIdArray['id_user'] || empty($kepsek)){?>
											<li> <input type="checkbox" name="otoritas[16]" <?if(isset($currentotoritas[16])){echo 'checked';}?> value="Kepala Sekolah" />Kepala Sekolah</li>
											<? } ?>
											<li> <input type="checkbox" name="otoritas[13]" <?if(isset($currentotoritas[13])){echo 'checked';}?> value="Guru" />Guru</li>
											<li> <input type="checkbox" name="otoritas[19]" <?if(isset($currentotoritas[19])){echo 'checked';}?> value="Guru Bimbingan dan Konseling" />Guru Bimbingan dan Konseling</li>
											<li> <input type="checkbox" name="otoritas[20]" <?if(isset($currentotoritas[20])){echo 'checked';}?> value="Guru/Pembina Ekstrakurikuler" />Guru/Pembina Ekstrakurikuler</li>
											<li> <input type="checkbox" name="otoritas[21]" <?if(isset($currentotoritas[21])){echo 'checked';}?> value="Pembina Kesiswaan" />Pembina Kesiswaan</li>
											<li> <input type="checkbox" name="otoritas[22]" <?if(isset($currentotoritas[22])){echo 'checked';}?> value="Tim Jurnalis Sekolah" />Tim Jurnalis Sekolah</li>
											<li> <input type="checkbox" name="otoritas[23]" <?if(isset($currentotoritas[23])){echo 'checked';}?> value="Komite Sekolah" />Komite Sekolah</li>
											<li> <input type="checkbox" id="wali_kelas" name="otoritas[17]" <?if(isset($currentotoritas[17])){echo 'checked';}?> value="Wali Kelas" />Wali Kelas <?=getkelaswali($atribut='style="margin: 0px; padding: 5px;" id="id_kelasotoritas"',$dataIdArray['id_pengguna'])?></li>
											
										</ul>
									</li>
									<? break; ?>
									<? case 'karyawan':?>
									<li>
										<ul>
											<li> <input type="checkbox" name="otoritas[24]" <?if(isset($currentotoritas[24])){echo 'checked';}?> value="Tata Usaha" />Tata Usaha</li>
											<li> <input type="checkbox" name="otoritas[25]" <?if(isset($currentotoritas[25])){echo 'checked';}?> value="Keuangan" />Keuangan</li>
											<li> <input type="checkbox" name="otoritas[26]" <?if(isset($currentotoritas[26])){echo 'checked';}?> value="Perpustakaan" />Perpustakaan</li>
											<li> <input type="checkbox" name="otoritas[27]" <?if(isset($currentotoritas[27])){echo 'checked';}?> value="Laboratorium" />Laboratorium</li>
											<li> <input type="checkbox" name="otoritas[22]" <?if(isset($currentotoritas[22])){echo 'checked';}?> value="Tim Jurnalis Sekolah" />Tim Jurnalis Sekolah</li>
										</ul>
									</li>
									<? break; ?>
									<? case 'siswa':?>
									<li>
										<ul>
											<li> <input type="checkbox" name="otoritas[22]" <?if(isset($currentotoritas[22])){echo 'checked';}?> value="Tim Jurnalis Sekolah" />Tim Jurnalis Sekolah</li>
										</ul>
									</li>
									<? break; ?>
									<? case 'ortu':?>
									<li>
										<ul>
											<li> <input type="checkbox" name="otoritas[23]" <?if(isset($currentotoritas[23])){echo 'checked';}?> value="Komite Sekolah" />Komite Sekolah</li>
											<li> <input type="checkbox" name="otoritas[22]" <?if(isset($currentotoritas[22])){echo 'checked';}?> value="Tim Jurnalis Sekolah" />Tim Jurnalis Sekolah</li>
										</ul>
									</li>
									<? break; ?>
									<? case 'lain':?>
									<li>
										<ul>
											<li> <input type="checkbox" name="otoritas[23]" <?if(isset($currentotoritas[23])){echo 'checked';}?> value="Komite Sekolah" />Komite Sekolah</li>
											<li> <input type="checkbox" name="otoritas[22]" <?if(isset($currentotoritas[22])){echo 'checked';}?> value="Tim Jurnalis Sekolah" />Tim Jurnalis Sekolah</li>
										</ul>
									</li>
									<? break; ?>
									<? } ?>
								</ul>
							
                        <!-- **Share Links** -->                   
                        <div class="share-links"> 
                            <div class="column one-half">
								<input type="hidden" value="<?=$dataId?>" name="dataId">
								<input type="submit" value="Simpan" id="buttonimport" name="submit" class="button small light-grey left">
                            </div>
                            <div class="column one-half last"> 
                                <div class="social">
                                    <a href="" title=""> <img src="images/team-facebook.png" alt="" title="" /> </a>
                                    <a href="" title=""> <img src="images/team-flickr.png" alt="" title="" /> </a>
                                    <a href="" title=""> <img src="images/team-skype.png" alt="" title="" /> </a>
                                    <a href="" title=""> <img src="images/team-twitter.png" alt="" title="" /> </a>
                                </div>
                            </div>                    
                        </div> <!-- **Share Links - End** -->                 
                    </div> <!-- **Team - End** -->               
                </div><!-- **Column One Half - End** -->   
	</form>	