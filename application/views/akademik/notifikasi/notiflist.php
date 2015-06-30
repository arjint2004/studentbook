
                    <? 
					//pr($notif);
					//for($i=10;$i>=0;$i--){
					foreach($notif as $datan){
					echo $datan['foto'];
					if(file_exists($datan['foto'])){$ft=$datan['foto'];}else{$ft='asset/default/images/no_profile.jpg';}
					?>
					<!-- **Team** -->
                    <div class="team" style="text-align:left;">          
                        <div class="image"> <img title="" style="margin:0;" width="50" alt="" src="<?=base_url();?>view.php?image=<?=$ft?>&mode=crop&size=130x150"> </div>
                        <h5> <?=$datan['gorup_notif']?>  </h5>
                        <h6 class="role"> 
						<? $tgx1=explode(" ",$datan['waktu']);?>
							<? $tg=tanggal($tgx1[0]." $tgx1[1]"); echo $tg[2];echo $tgx1[1];?>
						</h6>
                        <p> <?=$datan['notifikasi']?> </p>
                    </div> <!-- **Team - End** -->  
					<div class="hr-border" style="margin:5px 0;"> </div>
                   <? } // } ?>              
