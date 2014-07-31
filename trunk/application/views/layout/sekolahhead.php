<style>
    .error {
        background: none;
        font-size: smaller;
        color: red;
        margin: 0px;
        border: none;
    }
    dl {
        width: 100%;
        margin-left:0px;
    }
    
    dt {
        color: #7D7D7D;
		float: left;
		font-family: 'Droid Sans',serif;
		font-size: 14px;
		font-weight: 700;
		line-height: 15px;
		margin: 0;
		width: 20%;
    }
    
    dd {
        margin: 0px;
    }
    
    .link_profil a{
        width: 25%;
        float: left;
    }
</style>
		<div class="one-full">
                    <!-- **Team** -->
                    <div class="team">  
						<? 
						if(file_exists('upload/akademik/sekolah/'.$data->foto_profil) && !empty($data->foto_profil)){
							$imgurl='upload/akademik/sekolah/'.$data->foto_profil;
						}else{
							$imgurl='upload/akademik/sekolah/no_image.jpg';
						}
						?>
                        <div class="image"> <img title="" alt="" src="<?=base_url()?>view.php?image=<?=$imgurl?>&amp;mode=crop&amp;size=204x204"> </div>
                        <h5> <?=$data->nama_sekolah?> </h5>
                        <h6 class="role"> <?=$data->kota?> </h6>
						
                        <dl style="padding:0px;">
							<dt class="left">Alamat</dt><dd>: <?=$data->alamat_sekolah?></dd>
							<dt class="left">Telepon</dt><dd>: <?=$data->telepon?></dd>
							<dt class="left">Akreditasi</dt><dd>: <?=$data->terakreditasi?></dd>
							<dt class="left">Kota</dt><dd>: <?=$data->kota?></dd>
						</dl>
						
						<!-- **Share Links** -->                   
                        <div class="share-links"> 
                            <div class="column one-half"> 
								Email: <a href="" title=""> <?=$data->email_pendaftar?> </a> 
							</div>                    
                        </div> <!-- **Share Links - End** -->                 
                    </div> <!-- **Team - End** -->               
		</div>