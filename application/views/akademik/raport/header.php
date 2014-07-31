<?// pr($siswadata);?>
<div class="column one-full">
                    <!-- **Team** -->
                    <div class="team">          
                        <div class="image"> <img src="http://webdevel/studentbookrepo/asset/default/images/team-image1.jpg" alt="" width="103"> </div>
                        <h5> <?=$siswadata[0]['nama']?> </h5>
                        <h6 class="role"> <?=$this->session->userdata['ak_setting']['nama_sekolah']?> </h6>
                        <p> No Induk &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp; <span><?=$siswadata[0]['nis']?></span></p>   
                        <p> Kelas / Semester&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp; <span><?=$siswadata[0]['kelas']?><?=$siswadata[0]['nama_kelas']?> / <?=$this->session->userdata['ak_setting']['semester']?></span></p> 
						<p> Jurusan &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp; <span><?=$siswadata[0]['nama_jurusan']?></span></p>   
                        <p> Tahun Ajaran&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp; <span><?=$this->session->userdata['ak_setting']['ta_nama']?></span></p>   
                        <!-- **Share Links** -->                   
                        <div class="share-links"> 
                            <div class="column one-half"> 
                                <h5><?=$Nilaititle?></h5>
                            </div>            
                        </div> <!-- **Share Links - End** -->                 
                    </div> <!-- **Team - End** -->               
</div>