<div id="buttonasbin" class="buttonasbin tabs-frame-content fixed">
		<?
		$notshowmenubutton=array('bk','guruekstra');
		if($menuak==1){
			if(!in_array($CI->router->fetch_class(),$notshowmenubutton)){
				foreach($group as $dtgroup){
				if($dtgroup['home_url']!=''){
				?>
					<a style="width:158px;" class="readmorenoplus" target="__<?=str_replace(" ","",$dtgroup['otoritas'])?>"title="" href="<?=base_url().$dtgroup['home_url']?>/menubottom"> <?=$dtgroup['otoritas']?> </a>
				<? }else{ ?>
					<div style="width:158px;" class="readmorenoplus" title="" onclick="$('#<?=str_replace(" ","",$dtgroup['otoritas'])?>').scrollintoview({ speed:'1100'});"> <?=$dtgroup['otoritas']?> </div>
				<? } } ?>
				
				<div style="width:158px;" class="readmorenoplus" title="" onclick="$('#jadwalpelajaran').scrollintoview({ speed:'1100'});">Jadwal Pelajaran</div>
				<? 
			} 
		} ?>
<link id="default-css" href="<?=$CI->config->item('css').'notif.css';?>" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="<?=$CI->config->item('js').'notif.js';?>"></script>
<div class="notifikasiasb togglenotif" id="notifikasiasb" url="<?=base_url('akademik/notifikasi/notifcount')?>"><? if($jmlnotif!=0){echo $jmlnotif;}?></div>
<div class="contrnt-notif"></div>
</div>