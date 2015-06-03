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
							data: $('#setkenaikan').serialize()+'&id_kelas='+$('#kelaskenaikanadmin').val(),
							url: $('#setkenaikan').attr('action'),
							beforeSend: function() {
								$("#simpankenaikan").after("<img id='wait' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
							},
							success: function(msg) {
								$("#wait").remove();
								$.ajax({
									type: "POST",
									data:'id_kelas='+$('#kelaskenaikanadmin').val(),
									url: $('#setkenaikan').attr('action')+'/'+$('#kelaskenaikanadmin').val(),
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
<form action="<? echo base_url();?>akademik/raport/setkenaikan" id="setkenaikan" name="nilai" method="post" >
<?
//pr($siswasudahnaik);
//pr($kelasuntuknaik);
?>
<table  class="adddata" id="tablenaik">
    <thead>
		<tr>
			<th colspan="4" style="text-align: right; padding: 4px;">
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
            <td style="text-align:center;"> <?=$i++;?> </td>
            <td> <?=$datasiswa['nis']?> </td>
            <td> <?=$datasiswa['nama']?> </td>
            <td class="naikkelas">
				<? if($set=='kenaikan'){?> 
				Naik ke kelas 
				<select name="kelasuntuknaik[<?=$id_siswa?>]"style="margin:0;" <?if(empty($siswasudahnaik)){echo 'disabled';}?> class="kenaikan required">
					<option value="">Belum Naik</option>
					<? if(!empty($siswasudahnaik)){?>
						<?if($_POST['id_kelas']==@$siswasudahnaik[$id_siswa]['id_kelas_siswa_det_jenjang']){?>
							<? foreach($kelasuntuknaik['current'] as $kelas=>$datakelas){?>
								<option <? if($datakelas['id']==@$siswasudahnaik[$id_siswa]['id_kelas_siswa_det_jenjang']){ echo "selected";}?> value="<?=$datakelas['id']?>"><?//=$datakelas['kelas']?><?=$datakelas['nama']?></option>
							<? } ?>
						<? }else{ ?>
							<? foreach($kelasuntuknaik['next'] as $kelas=>$datakelas){?>
								<option <? if($datakelas['id']==@$siswasudahnaik[$id_siswa]['id_kelas_siswa_det_jenjang']){ echo "selected";}?> value="<?=$datakelas['id']?>"><?//=$datakelas['kelas']?><?=$datakelas['nama']?></option>
							<? } ?>
						<? } ?>
					<? }else{ ?>
							<? foreach($kelasuntuknaik['next'] as $kelas=>$datakelas){?>
								<option <? if($datakelas['id']==@$siswasudahnaik[$id_siswa]['id_kelas_siswa_det_jenjang']){ echo "selected";}?> value="<?=$datakelas['id']?>"><?//=$datakelas['kelas']?><?=$datakelas['nama']?></option>
							<? } ?>
					<? } ?>
				</select>
				<? }else{ ?>
				Kelulusan
				<select name="kelulusan[<?=$id_siswa?>]" disabled >
						<option value="0">Belum Lulus</option>
						<option <? if($datakelulusan[$id_siswa]['kelulusan']==1){ echo "selected";}?> value="1">Lulus</option>
						<option <? if($datakelulusan[$id_siswa]['kelulusan']==2){ echo "selected";}?> value="2">Tidak Lulus</option>
				</select>				
				<? } ?>
			</td>
        </tr>
	<? } ?>
    </tbody>
</table>
</form>