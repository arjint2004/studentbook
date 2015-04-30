<style>
table.colspan tr th{vertical-align:middle; background:#eeeeee;}
table.colspan tr td div.judul{width: 100%; background: none repeat scroll 0% 0% rgb(204, 204, 204); position: relative; right: 10px; bottom: 10px; padding: 10px; text-transform: uppercase; font-weight: bold;}
</style>
<script>
$(document).ready(function(){
	$('table.colspan tr td#tdraratot').html($('input#ratatt').val());
	
	$("input#des_kogn").click(function(e){
		$("form#filterpelajaranlistOtentik").append("<div class=\"error-box\" style='display: block; top: 50%; position: fixed; left: 46%;'></div>");
		$(".error-box").html("Memproses Data").fadeIn("slow");
		var ob=$(this);
		$.ajax({
			type: "POST",
			data: $("form#filterpelajaranlistOtentik").serialize()+'&nilai='+$('textarea#des_kogn').val(),
			url: '<?=base_url()?>akademik/nilaiotentik/nilai',
			beforeSend: function() {
				//$(ob).after("<img id='wait213' style='float:left;' src='<?=$this->config->item('images').'loading.png';?>' />");
			},
			error	: function(){
				$(".error-box").delay(1000).html('Simpan data gagal');
				$(".error-box").delay(1000).fadeOut("slow",function(){
					$(this).remove();
				});
													
			},
			success: function(msg) {
				$("#wait213").remove();	
				$(".error-box").delay(1000).html('Data berhasil di simpan');
				$(".error-box").delay(1000).fadeOut("slow",function(){
					$(this).remove();
				});
				//$("#pelajaranlistotentik").html(msg);	
			}
		});
	});
});
</script>
<? //pr($indikator);?>
<table width="100%" border="1" class="colspan">
  <tr>
    <th rowspan="2" style="width:30%;">INDIKATOR</th>
    <th colspan="<?=count($indikator[0]['point'])?>">NILAI EVALUASI</th>
    <th rowspan="2">RATA</th>
    <th rowspan="2">RATA TOTAL</th>
	<?if($this->session->userdata['ak_setting']['jenjang'][0]['bentuk']!='TK'){?>
    <th rowspan="2">NILAI <?=strtoupper($_POST['jenis'])?></th>
	<? } ?>
    <th rowspan="2">DESKRIPSI KOGN</th>
  </tr>
  
  <tr>
  <? 
  $noev=1;
  if(!empty($indikator[0]['point'])){
  foreach($indikator[0]['point'] as $pnt){?>
    <th style="width:10px;"><?=$noev++?></th>
  <? } ?>
  </tr>
  <?
   $no=1;
  foreach($indikator as $kk=>$dataindikator){?>
  <tr>
    <td style="text-align:left;">
		<? 
		if($_POST['jenis']=='psikomotorik'){
		$ic[$dataindikator['penilaian']]++;
		//pr($ic[$dataindikator['penilaian']]);
		if($ic[$dataindikator['penilaian']]==1){
		?>
		<div class="judul"><?=$dataindikator['penilaian']?></div>
		<? }  } ?>
		<?=$dataindikator['indikator']?>
	
	</td>

    <? 
	if(empty($dataindikator['point'])){$dataindikator['point']=array(0=>array('point'=>0,'id_pertemuan'=>0));}
	foreach($dataindikator['point'] as $pntt){ $jmlp=$jmlp+$pntt['point']; $rata=$jmlp/count($dataindikator['point']);?>
		<td><?=$pntt['point']?></td>
	<? } ?>
	<td><? echo $rata; $jmlp=0; $jmlrt=$jmlrt+$rata;?></td>
    <? if($kk==0){ ?>
    <td rowspan="<?=count($indikator);?>" style="font-size:20px;" id="tdraratot"></td>
	<?if($this->session->userdata['ak_setting']['jenjang'][0]['bentuk']!='TK'){?>
    <td rowspan="<?=count($indikator);?>" style="font-size:20px;"><?=$kogn?></td>
	<? } ?>
    <td rowspan="<?=count($indikator);?>">
		<textarea name="deskripsi_kogn[<?=$_POST['id_det_jenjang']?>][<?=$_POST['pelajaran']?>]" id="des_kogn"><?=$desc_kogn[0]['nilai']?></textarea>
		<input type="submit" name="des_kogn" value="Simpan" id="des_kogn"/>
	</td>
	<? }?>
  </tr>
  <? } } ?>
</table>
<input type="hidden" name="ratatt" id="ratatt" value="<? echo round($jmlrt/count($indikator),2);?>" />
