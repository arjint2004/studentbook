<script>
$(document).ready(function(){

	
});
</script>
<?
//if($first=='first'){
	//$this->load->view('akademik/comment/js');
//}
?>

<div class="comment">
<input type="hidden" value="<?=$id?>" name="idcommentar" id="idcommentar"/>
<link id="default-css" href="<?=$this->config->item('css').'comment.css';?>" rel="stylesheet" type="text/css" media="all" />
<br />
<h3>Komentar</h3>
<div class="hr"></div>
	<div class="containcomment">
	<div class="content-box clear"></div>
		<form id="comment" action="<?php echo base_url() ?>index.php/ticker/commentsend" method="post" >		
		<textarea id="comment" name="comment" rows="5"  placeholder="Tulis komentar anda. Kemudian tekan ENTER"  onkeydown="$(this).css('color','#727272');$(this).css('font-size','12px');"></textarea>
		<input type="hidden" name="jenis" id="jensget" value="<?=$jenis?>" />
		<input type="hidden" name="id_information" id="id_information" value="<?=$id?>" />
		</form>
		<div class="post">
			<div class="date"><?=date("F j, Y")?></div>
			<!--<input type="submit" name="submit" id="submitcomment" value="Post" />-->
		</div>
		<? 
		//$user = DataUser();
		//echo $user->foto;
		//pr($comment);
		foreach($comment as $idhis=>$datahis){?>
		<div class="textpost" id="textpost<?=$datahis['id']?>">
			<div class="textpostinner">
			<? if($datahis['id_user']==$this->session->userdata['user_authentication']['id_pengguna']){?>
			<div class="del"  onclick="edit('post','<?=$datahis['id']?>');"></div>
			<div class="edit"  onclick="del('post','<?=$datahis['id']?>');"></div>
			<? } 
			if(!isset($foto[$datahis['id_user']]['foto']) || $foto[$datahis['id_user']]['foto']==''){
				$fotonya="asset/default/images/profil.jpg";
			}else{
				$fotonya=$foto[$datahis['id_user']]['foto'];
			}
			?>
			<div class="photo"><img width="50" height="50"  src="<?=base_url()?>view.php?image=<? echo $fotonya; ?>&amp;mode=crop&amp;size=50x50" alt="My crop car image" /></div>
			<div class="date">
						<b><?=$foto[$datahis['id_user']]['nama']?></b> 
						<?
							//$epldate=explode("-",$datahis['date']);
							//echo date("F j, Y", mktime(0, 0, 0, $epldate[1], $epldate[2], $epldate[0]));
							
							echo $datahis['date'];
						?>
			</div>
				<div class="postedit<?=$datahis['id']?>"><?=$datahis['comment']?></div>
				<!--<div class="reply">
					<div class="date"><?=date("F j, Y")?></div>
					<div class="buttonreply">Reply</div>
				</div>-->
				<div class="clear" ></div>
				<? 
				//pr($foto);
				//pr($datahis['reply']);
				if(!empty($datahis['reply'])){
				foreach($datahis['reply'] as $datacommentreply){?>
				<div class="replyshow" id="replyshow<?=$datacommentreply['id']?>">
					<div class="cucuk"></div>
					<? if($datacommentreply['id_user']==$this->session->userdata['user_authentication']['id_pengguna']){?>
					<div class="del"  onclick="edit('reply','<?=$datacommentreply['id']?>');"></div>
					<div class="edit"  onclick="del('reply','<?=$datacommentreply['id']?>');"></div>
					<? }
					
					if(!isset($foto[$datacommentreply['id_user']]['foto']) || $foto[$datacommentreply['id_user']]['foto']==''){
						$fotonyareply="asset/default/images/profil.jpg";
					}else{
						$fotonyareply=$foto[$datacommentreply['id_user']]['foto'];
					}
					
					?>
					<div class="photo"><img width="50" height="50"  src="<?=base_url()?>view.php?image=<? echo $fotonyareply; ?>&amp;mode=crop&amp;size=50x50" alt="My crop car image" /></div>
					<div class="date">- 
						<b><?=$foto[$datacommentreply['id_user']]['nama']?></b> 
						<?
							//$epldate=explode("-",$datacommentreply['date']);
							//echo date("F j, Y", mktime(0, 0, 0, $epldate[1], $epldate[2], $epldate[0]));
							
							echo $datacommentreply['date'];
						?>
					</div>

					<div class="replyedit<?=$datacommentreply['id']?>"><?=$datacommentreply['comment']?></div>

				</div>
				<? } ?>
				<? } ?>
				<form id="reply<?=$datahis['id']?>" action="<?php echo base_url() ?>index.php/ticker/commentsend" method="post" >
				<textarea id="commentreply" name="commentreply" rows="5" post="<?=$datahis['id']?>" placeholder="Tulis komentar anda. Kemudian tekan ENTER" onkeydown="$(this).css('color','#727272');$(this).css('font-size','12px');"></textarea>
				<input type="hidden" name="jenis" value="<?=$jenis?>" />
				<input type="hidden" name="id_information" id="id_information" value="<?=$id?>" />
				</form>
			</div>
		</div>
	<? } ?>		
	</div>
	</div>


