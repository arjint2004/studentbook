<script>
$(document).ready(function(){


	$("#kelasform").each(function(e){
			//alert(e.toSource());
	});
		
	$('.addkelas').click(function() {
		var idnt=$(this).attr('id');
		$("ul#"+idnt).append('<li id="li'+$(this).attr('value')+'"><input  type="text" size="5" name="nama['+$(this).attr('value')+'][]" /><div onclick=$("#li'+$(this).attr('value')+'").remove(); class="remove"></div></li>');

		return false;
	});

	
	function loaddatakelas(){
		$.ajax({
			type: "POST",
			data: "ajax=1",
			url: base_url+'admin/kelas/listData',
			beforeSend: function() {
				$("#listkelasloading").html("<img src='"+config_images+"loading.png' />");
			},
			success: function(msg) {
				$("#listkelas").html(msg);			
			}
		});
	}
					
						
						
	$('.remove_project_file').live('click', function() {
		$(this).parent().remove();

		return false;
	});
	
	$('#kelasform').submit(function() {
		var jurusanaddkelas=$('select.jurusanaddkelas').val();
		if(jurusanaddkelas==''){
			$('div.error-container').show();
			$('select.jurusanaddkelas').css('border','1px solid red');
			return false;
		}else{
			$('div.error-container').hide();
		}
		$.ajax({
			type: 'POST',
			url: $(this).attr('action'),
			data: $(this).serialize(),
			success: function(data) {
				$('#ajaxside').html('');
				loaddatakelas();
				$('div#step').load('<?=site_url()?>admin/schooladmin/completeregoption');		
			}
		})
		return false;
		
	});
});
</script>
<? 
//pr($datajenjang);
//pr($this->session->userdata['ak_setting']['jenjang'][0]['nama']);
?>
<div class="addaccount">
<form action="<? echo base_url();?>admin/kelas/adddata" id="kelasform" name="kelasform" method="post" >
	<div class="addaccountclose" onclick="$('.addaccount').remove();"></div>
	<div class="headadd"><h3> Tambah data kelas </h3>
		<? if($this->session->userdata['ak_setting']['jenjang'][0]['nama']=='SD' || $this->session->userdata['ak_setting']['jenjang'][0]['nama']=='SMP'){?>
		<input type="hidden" name="id_jurusan" value="<?=$jurusan[0]['id']?>">
		<? }elseif($this->session->userdata['ak_setting']['jenjang'][0]['nama']=='SMK'){ ?>
		<select name="id_jurusan" class="jurusanaddkelas">
			<option value="">Pilih Jurusan</option>
			<? foreach($jurusan as $datajur){?>
			<option value="<?=$datajur['id']?>"><?=$datajur['nama']?></option>
			<? } ?>
		</select>		
		<? } ?>
		<div class="error-container" style="display:none;position:absolute;left:482px;top:183px;"> Jurusan harus di pilih!  </div>
		<a class="button small light-grey simpankelas" title="" onclick="$('#kelasform').submit()"> Simpan </a>
	</div>
	<? if($this->session->userdata['ak_setting']['jenjang'][0]['nama']=='SD' || $this->session->userdata['ak_setting']['jenjang'][0]['nama']=='SMP' ){?>
		<ul class="left">
			
			<?
			foreach($datajenjang[0]['grade'] as $idky=> $jenjang){?>
				<li>
					<div  id="in<?=$jenjang?>" value="<?=$jenjang?>" class="addkelas">
						<?
						if($datajenjang[0]['bentuk']=='TK'){

							switch($jenjang){
								case 1:
									echo 'PENGASUHAN A';
								break;
								case 2:
									echo 'PENGASUHAN B';
								break;
								case 3:
									echo 'PLAY GROUP A';
								break;
								case 4:
									echo 'PLAY GROUP B';
								break;
								case 5:
									echo 'TK A';
								break;
								case 6:
									echo 'TK B';
								break;
							}
						}else{
							echo $jenjang." ".$datajenjang[0]['bentuk'];
						}
						
						?>
					</div>
					<ul id="in<?=$jenjang?>">
						<li id="li<?=$idky?>"><input type="text" size="5" name="nama[<?=$jenjang?>][]"/><div class="remove"></div></li>
					</ul>
				</li>
			<? } ?>
			
		</ul>
	<? }elseif($this->session->userdata['ak_setting']['jenjang'][0]['nama']=='SMA'){?>
		<ul class="left">
		<?
			foreach($datajenjang[0]['grade'] as $idky=> $jenjang){?>
				<li>
					<div  id="in<?=$jenjang?>" value="<?=$jenjang?>" class="addkelas"><?=$jenjang." ".$datajenjang[0]['bentuk']?></div>
					<ul id="in<?=$jenjang?>">
						<li id="li<?=$idky?>"><input type="text" size="5" name="nama[<?=$jenjang?>][]"/><div class="remove"></div></li>
					</ul>
					
				<?if($jenjang<11){?>
				<input type="hidden" name="id_jurusan[<?=$jenjang?>]" value="<?=$jurusan[0]['id']?>">
				<? }else{ unset($jurusan[0]);?>
					Jurusan:
					<select name="id_jurusan[<?=$jenjang?>]" class="jurusanaddkelas" style="clear: both; margin: 0px; left: 5px;">
						
						<? foreach($jurusan as $datajur){?>
						<option value="<?=$datajur['id']?>"><?=$datajur['nama']?></option>
						<? } ?>
					</select>
				<? } ?>
				</li>
			<? } ?>
			
		</ul>
	<? }elseif($this->session->userdata['ak_setting']['jenjang'][0]['nama']=='SMK'){ ?>
		<ul class="left">
		<?
			foreach($datajenjang[0]['grade'] as $idky=> $jenjang){?>
				<li>
					<div  id="in<?=$jenjang?>" value="<?=$jenjang?>" class="addkelas"><?=$jenjang." ".$datajenjang[0]['bentuk']?></div>
					<ul id="in<?=$jenjang?>">
						<li id="li<?=$idky?>"><input type="text" size="5" name="nama[<?=$jenjang?>][]"/><div class="remove"></div></li>
					</ul>
				</li>
			<? } ?>
			
		</ul>	
	<? }?>
	<input type="hidden" name="addkelas" value="1"/> 
	<input type="hidden" name="ajax" value="1"/> 
	</form>
</div>



