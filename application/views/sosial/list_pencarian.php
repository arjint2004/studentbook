<?php
    if(!empty($result)) {
        $no=1;
        foreach($result as $cr) {
            if($no%2==1) {
                echo '<div class="column one-half">';
            }else{
                echo '<div class="column one-half last">';
            }
			if(file_exists('upload/akademik/sekolah/'.$cr->foto_profil) && !empty($cr->foto_profil)){
				$imgurl=site_url('upload/akademik/sekolah/'.$cr->foto_profil);
			}else{
				$imgurl=site_url('upload/akademik/sekolah/no_image.jpg');
			}
            ?>
                <!-- **Team** -->
                <div class="team">
                    <div class="image"> <img src="<?=$imgurl?>" style="min-width: 130px;max-height:150px;"  alt="" title=""> </div>
                    <h5><a href="<?=site_url('sos/sekolah/detail_sekolah/'.$cr->id)?>"><?=$cr->nama_sekolah?></a></h5>
                    <h6 class="role"><?=$cr->alamat_sekolah?></h6>
                    <p><?=$cr->deskripsi?></p>   
                    <!-- **Share Links** -->                   
                    <div class="share-links"> 
                        <div class="column one-half"> 
                            Email : <a href="" title=""> <?=$cr->email_pendaftar?></a> 
                        </div>
                        <div class="column one-half last"> 
                            <div class="social">
                            
                            </div>
                        </div>                    
                    </div> <!-- **Share Links - End** -->                 
                </div> <!-- **Team - End** -->               
            </div>
            <?php
            $no++;
        }
    }
    if(!empty($pagination)) {
        echo '<div class="row-fluid">';
            echo '<div class="span12">';
                echo '<div class="pagination">';
                    echo '<ul>';
                        echo $pagination;
                    echo '</ul>';
                echo '</div>';
            echo '</div>';
        echo '</div>';
    }
?>