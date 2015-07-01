<script src="<?=$this->config->item('js');?>jquery.validate.pack.js"> </script>
<style type="text/css">
input.error, select.error { border: 1px solid red !important; }
div.error { color:red; margin-left: 0px; font-size:10px !important; font-weight:normal !important; display:none !important;}
</style>
<script>
	$(document).ready(function(){
		//$("#setkenaikan").submit(function(e){
			$('#setkenaikan').validate({
				submitHandler: function(form) {
					$.ajax({
							type: "POST",
							data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&'+$('#setkenaikan').serialize()+'&id_kelas='+$('#kelaskenaikan').val(),
							url: $('#setkenaikan').attr('action'),
							beforeSend: function() {
								$("#simpankenaikan").after("<img id='wait' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
							},
							success: function(msg) {
								$("#wait").remove();
								$.ajax({
									type: "POST",
									data:'id_kelas='+$('#kelaskenaikan').val(),
									url: $('#setkenaikan').attr('action')+'/'+$('#kelaskenaikan').val(),
									beforeSend: function() {
										$("#simpankenaikan").after("<img id='wait' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
									},
									success: function(msg) {
										$("#wait").remove();
										//$("#kenaikankelulusanload").load(msg);
										$("#kenaikankelulusanload").html(msg);
										return false;
									}
								});
								//$("#kenaikankelulusanload").html(msg);
							}
						});
						return false;
					}
			});
		//});							
	});
</script>
<div class="column one-full" style="width:98%;">
                    <!-- **Team** -->
                    <div class="team">                           
                        <div class="share-links"> 
                            <div class="column one-half"> 
                                <h5><?=$set?></h5>
                            </div>            
                        </div> <!-- **Share Links - End** -->                 
                    </div> <!-- **Team - End** -->               
</div>

<form action="<? echo base_url();?>siswa/raport/setkenaikan" id="setkenaikan" name="nilai" method="post" >
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
<table  class="adddata" id="tablenaik">
    <thead>
		<tr>
			<th colspan="4" style="text-align:right;">
				<a title="" class="button small light-grey absenbutton" id="simpankenaikan" onclick="$('#setkenaikan').submit();"> Simpan </a>
			</th>
		</tr>
        <tr> 
            <th> No </th>
            <th> NIS </th>
            <th> Nama </th>
            <th> <?=$set?> </th>
        </tr>                            
    </thead>
    <tbody>
	<?
	$i=1;
	foreach($siswa as $id_siswa=>$datasiswa){?>
        <tr> 
            <td class="nilai"> <?=$i++;?> </td>
            <td> <?=$datasiswa['nis']?> </td>
            <td> <?=$datasiswa['nama']?> </td>
            <td class="naikkelas"> Naik ke kelas 
				<? if($set=='kenaikan'){?>
				<select name="kelasuntuknaik[<?=$id_siswa?>]" class="kenaikan required">
					<option value="">Pilih Kelas</option>
					<? foreach($kelasuntuknaik as $kelas=>$datakelas){?>
						<option <? if($datakelas['id']==@$siswasudahnaik[$id_siswa]['id_kelas_siswa_det_jenjang']){ echo "selected";}?> value="<?=$datakelas['id']?>"><?=$datakelas['kelas']?><?=$datakelas['nama']?></option>
					<? } ?>
				</select>
				<? }else{ ?>
				<select name="kelulusan[<?=$id_siswa?>]">
						<option <? if($datakelulusan[$id_siswa]['kelulusan']==1){ echo "selected";}?> value="1">Lulus</option>
						<option <? if($datakelulusan[$id_siswa]['kelulusan']==0){ echo "selected";}?> value="0">Tidak Lulus</option>
				</select>				
				<? } ?>
			</td>
        </tr>
	<? } ?>
    </tbody>
</table>
</form>