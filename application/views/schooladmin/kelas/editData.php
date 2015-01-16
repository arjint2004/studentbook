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
	<h3> Edit data kelas </h3>
		<table>
			<tr>
				<td style="text-align:left;">Nama Kelas</td>
				<td style="text-align:left;">
					<input type="hidden" name="id_kelas" value="<?=$id_kelas?>" />
					<input  type="text" name="kelas" value="<?=$kelas?>" />				
				</td>
			</tr>	
			<tr>	
				<td style="text-align:left;">Jurusan</td>
				<td style="text-align:left;">
					<? if($this->session->userdata['ak_setting']['jenjang'][0]['nama']=='SD' || $this->session->userdata['ak_setting']['jenjang'][0]['nama']=='SMP'){?>
					Dasar <input type="hidden" name="id_jurusan" value="<?=$jurusan[0]['id']?>">
					<? }elseif($this->session->userdata['ak_setting']['jenjang'][0]['nama']=='SMA'){ ?>
								<?if($datakelas[0]['kelas']==10){?>
									<input type="hidden" name="id_jurusan" value="<?=$id_jurusan?>" />
								<?}else{?>
									<select name="id_jurusan" >
										<option value="">Pilih Jurusan</option>
										<? foreach($jurusan as $datajurusan){?>
										<option <? if($datajurusan['id']==$id_jurusan){ echo "selected";}?> value="<?=$datajurusan['id']?>"><?=$datajurusan['nama']?></option>
										<? } ?>
									</select>		
								<? } ?>	
					<? }else{ ?>
					<select name="id_jurusan" >
						<option value="">Pilih Jurusan</option>
						<? foreach($jurusan as $datajurusan){?>
						<option <? if($datajurusan['id']==$id_jurusan){ echo "selected";}?> value="<?=$datajurusan['id']?>"><?=$datajurusan['nama']?></option>
						<? } ?>
					</select>
					<? } ?>									
				</td>
			</tr>
			<tr>
				<td style="text-align:left;">Aktif</td>
				<td style="text-align:left;">
					<input type="hidden" name="publish" value="0" />		
					<input  class="jurusanaddkelas" type="checkbox" <? if($datakelas[0]['publish']==1){echo"checked";}?> name="publish" value="1" />			
				</td>
			</tr>
			<tr>
				<th colspan="3" style="padding:0 0 0 10px; text-align:right;"><a class="button small light-grey simpankelas" title="" onclick="$('#kelasform').submit()" style="top:-4px;"> Simpan </a></th>
			</tr>

		</table>

		<div class="error-container" style="display:none;position:absolute;left:482px;top:183px;"> Jurusan harus di pilih!  </div>
		


	<input type="hidden" name="editkelas" value="1"/> 
	<input type="hidden" name="ajax" value="1"/> 
	</form>
</div>



