<script>
	
	<? if(isset($id_pegawai)){$id_peg=$id_pegawai;}else{$id_peg=0;}?>
	function getaddrekap(obj,date) {
		$("#rekapabsensiform").append("<div class=\"error-box\" style='display: block; top: 50%; position: fixed; left: 46%;'></div>");
			$(".error-box").html("Memproses Data").fadeIn("slow");
		if($('#kelasabsenrekap').val()==''){$('#kelasabsenrekap').css('border','1px solid red'); return false;}else{$('#kelasabsenrekap').css('border','1px solid #D8D8D8');}
		$.ajax({
			type: "POST",
			data: "id_kelas="+$('#kelasabsenrekap').val()+"&id_pelajaran="+$('#pelajaranabsenrekap').val()+"&month="+date,
			url: '<?=base_url()?>akademik/absensi/rekapabsensidata',
			beforeSend: function() {
				$(".error-box").delay(1000).html('Loading Data');
				$(".error-box").delay(1000).fadeOut("slow",function(){
					$(this).remove();
				});
			},
			error	: function(){
								$(".error-box").delay(1000).html('Pengambilan data gagal');
								$(".error-box").delay(1000).fadeOut("slow",function(){
									$(this).remove();
								});
													
			},
			success: function(msg) {
				$("#wait").remove();			
				$("#absenarearekap").html(msg);					
			}
		});	
	}
	
	$('#jamabsen').bind('change', function() {
		$('#hiddenjamke').remove();
		$(this).after('<input type="hidden" name="jamkenya" id="hiddenjamke" value="'+$(this).find(":selected").text()+'"/>');
		getaddrekap($(this),$('#bulanrekapabsen').val());
	});
	$('#pelajaranabsenrekap').bind('change', function() {
		$('#hiddenmapel').remove();
		var alias;
		if($(this).find(":selected").attr('alias')==''){alias=$(this).find(":selected").text();}else{alias=$(this).find(":selected").attr('alias');}
		$(this).after('<input type="hidden" name="pelajarannyaabsen" id="hiddenmapel" value="'+alias+'"/>');
		getaddrekap($(this),$('#bulanrekapabsen').val());
	});
	$('#kelasabsenrekap').bind('change', function() {
		$('#hiddenkelas').remove();
		$(this).after('<input type="hidden" name="kelasnyaabsesnsi" id="hiddenkelas" value="'+$(this).find(":selected").text()+'"/>');
		
		$.ajax({
			type: "POST",
			url: '<?=base_url()?>admin/pelajaran/getMapelByKelasAndPegawai/'+$(this).val()+'/0/1/<?=$id_peg?>',
			beforeSend: function() {
				$("#pelajaranabsenrekap").after("<img id='waitabsen1' src='<?=$this->config->item('images').'loading.png';?>' />");
			},
			success: function(msg) {
				$("#waitabsen1").remove();
				$("#pelajaranabsenrekap").html(msg);	
				getaddrekap($(this),$('select#bulanrekapabsen').val());
			}
		});
		
		return false;
	});
	$('#bulanrekapabsen').bind('change', function() {
		getaddrekap($(this),$(this).val());
		return false;
	});
	
	
		$.ajax({
			type: "POST",
			url: '<?=base_url()?>admin/pelajaran/getMapelByKelasAndPegawai/'+$('select#kelasabsenrekap').val()+'/0/1/<?=$id_peg?>',
			beforeSend: function() {
				$("#pelajaranabsenrekap").after("<img id='waitabsen1' src='<?=$this->config->item('images').'loading.png';?>' />");
			},
			success: function(msg) {
				$("#waitabsen1").remove();
				$("#pelajaranabsenrekap").html(msg);	
				getaddrekap('',$('select#bulanrekapabsen').val());
			}
		});
		<? if(isset($popup)){?>
		var winwidth=(90/100)*parseInt($(window).width());
		$('form#rekapabsensiform').css('width',winwidth+'px');
		<? } ?>
</script>


<script type="text/javascript">
$(function() {
	
		
					$(".printrekapabsensi").click(function(){
						if($('select#kelasabsenrekap').val()==''){
							$('select#kelasabsenrekap').css('border','1px solid red');
						return false;
							
						}
						$('form#rekapabsensiform').attr('action','<?=base_url()?>akademik/absensi/printrekapabsensidata');
						$('form#rekapabsensiform').attr('target', '__blank');
						$('form#rekapabsensiform').submit();
					});
					var winwidth=(92/100)*parseInt($(window).width());
					//$('div#widthabsensi').css('width',winwidth+'px');
});

</script>
<div id="widthabsensi">
<? //pr($kelas);?>
<form action="" method="post" id="rekapabsensiform" >
				<table class="adddata">
					<tr>
						<td style="text-align:left;">Kelas</td>
						<td style="text-align:left;">
							<select  id="kelasabsenrekap" name="kelas">
								<? foreach($kelas as $datakelas){?>
								<option <? if(@$_POST['kelas']==$datakelas['id']){echo 'selected';}?> value="<?=$datakelas['id']?>"><?//=$datakelas['kelas']?><?=$datakelas['nama']?></option>
								<? } ?>
							</select>
						</td>
					</tr>
					<? if($this->session->userdata['ak_setting']['jenjang'][0]['nama']!='SD'){?>
					<tr>
						<td style="text-align:left;">Pelajaran</td>
						<td style="text-align:left;">
							<select  id="pelajaranabsenrekap" name="id_pelajaran">
								<option value="">Pilih Pelajaran</option>
							</select>
						</td>
					</tr>
					<? }else{ ?>
						<input type="hidden" name="pelajaranabsenrekap" value="" />
					<? } ?>
					<tr>
						<td style="text-align:left;">Bulan</td>
						<td style="text-align:left;">
							<? echo month('month', date('m'),'id="bulanrekapabsen"');?>
						</td>
					</tr>
					<tr>
						<td style="text-align:left;">Output</td>
						<td style="text-align:left;">
							<a  style="padding:5px;float:left;" class="readmore printrekapabsensi"><img height="50" src="<?=$this->config->item('images')?>/Print-icon.png" style="margin:0;" />Print</a>
							<input type="hidden" name="jenis" value="absensi" />
							<input type="hidden" name="fileName" value="Absensi" />
						</td>
					</tr>
				</table>
				</form>
<div id="absenarearekap">
<form name="absensi" id="absensiform" method="post" action="<?=base_url()?>akademik/absensi/rekapabsensidata" >
<table width="100%">
  <tr>
    <th>No</th>
    <th>Nama</th>
    <th colspan="3">Tanggal Pertemuan </th>
    <th colspan="4">Jumlah</th>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>Hadir</td>
    <td>Alpha</td>
    <td>Izin</td>
    <td>Sakit</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

</form>
</div>