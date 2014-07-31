<script>
$(document).ready(function(){
		$("#kelasform").submit(function(e){
				$.ajax({
					type: "POST",
					data: $(this).serialize(),
					url: $(this).attr('action'),
					beforeSend: function() {
						$("#kelasloading").html("<img src='<?=$this->config->item('images').'loading.png';?>' />");
					},
					success: function(msg) {
						$(".addaccount").remove();	
							$.ajax({
								type: "POST",
								data: "ajax=1",
								url: '<?php echo base_url(); ?>admin/kelas/listData',
								beforeSend: function() {
									$("#kelasloading").html("<img src='<?=$this->config->item('images').'loading.png';?>' />");
								},
								success: function(msg) {
									$("#kelasloading").html("");
									$("#listkelas").html(msg);			
								}
							});			
					}
				});
				return false;
			
			return false;
		});//Submit End
});
</script>
<div class="addaccount">
<form action="<? echo base_url();?>admin/kelas/editdata" id="kelasform" name="kelasform" method="post" >
	<div class="addaccountclose" onclick="$('.addaccount').remove();"></div>
	<div class="headadd"><h3> Edit data kelas </h3>
		<input type="hidden" name="id_kelas" value="<?=$id_kelas?>" />
		<input class="editkelas" type="text" name="kelas" value="<?=$kelas?>" />
		<? if($this->session->userdata['ak_setting']['jenjang'][0]['nama']=='SD' || $this->session->userdata['ak_setting']['jenjang'][0]['nama']=='SMP'){?>
		<input type="hidden" name="id_jurusan" value="<?=$jurusan[0]['id']?>">
		<? }elseif($this->session->userdata['ak_setting']['jenjang'][0]['nama']=='SMA'){ ?>
					<?if($datakelas[0]['kelas']==10){?>
						<input type="hidden" name="id_jurusan" value="<?=$id_jurusan?>" />
					<?}else{?>
						<select name="id_jurusan" class="jurusanaddkelas">
							<option value="">Pilih Jurusan</option>
							<? foreach($jurusan as $datajurusan){?>
							<option <? if($datajurusan['id']==$id_jurusan){ echo "selected";}?> value="<?=$datajurusan['id']?>"><?=$datajurusan['nama']?></option>
							<? } ?>
						</select>		
					<? } ?>	
		<? }else{ ?>
		<select name="id_jurusan" class="jurusanaddkelas">
			<option value="">Pilih Jurusan</option>
			<? foreach($jurusan as $datajurusan){?>
			<option <? if($datajurusan['id']==$id_jurusan){ echo "selected";}?> value="<?=$datajurusan['id']?>"><?=$datajurusan['nama']?></option>
			<? } ?>
		</select>
		<? } ?>
		<div class="error-container" style="display:none;position:absolute;left:482px;top:183px;"> Jurusan harus di pilih!  </div>
		<a class="button small light-grey simpankelas" title="" onclick="$('#kelasform').submit()"> Simpan </a>
	</div>

	<input type="hidden" name="editkelas" value="1"/> 
	<input type="hidden" name="ajax" value="1"/> 
	</form>
</div>



