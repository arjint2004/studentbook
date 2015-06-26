						<?
						$notshowmenubutton=array('bk','guruekstra');
						if($menuak==1){
							if(!in_array($CI->router->fetch_class(),$notshowmenubutton)){
								foreach($group as $dtgroup){
								if($dtgroup['home_url']!=''){
								?>
									<li><a  target="__<?=str_replace(" ","",$dtgroup['otoritas'])?>"title="" href="<?=base_url().$dtgroup['home_url']?>/menubottom"> <?=$dtgroup['otoritas']?> </a></li>
								<? }else{ ?>
									<li><a onclick="$('#<?=str_replace(" ","",$dtgroup['otoritas'])?>').scrollintoview({ speed:'1100'});"> <?=$dtgroup['otoritas']?> </a></li>
								<? } } ?>
								
								<li><a onclick="$('#jadwalpelajaran').scrollintoview({ speed:'1100'});">Jadwal Pelajaran</a></li>
								<? 
							} 
						} ?>