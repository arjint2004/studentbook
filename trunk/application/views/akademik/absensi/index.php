<script>
	$('#simpanabsensi').bind('click', function() {
		if($('#kelasabsen').val()==''){
			$('#kelasabsen').css('border','1px solid red'); 
			return false;
		}else{
			$('#kelasabsen').css('border','1px solid #D8D8D8');
		}
		if($('#pelajaranabsen').val()=='0' || $('#pelajaranabsen').val()==''){$('#pelajaranabsen').css('border','1px solid red'); return false;}else{$('#pelajaranabsen').css('border','1px solid #D8D8D8');}
		if($('#jamabsen').val()==''){$('#jamabsen').css('border','1px solid red'); return false;}else{$('#jamabsen').css('border','1px solid #D8D8D8');}
		if($('#popupDatepicker').val()==''){$('#popupDatepicker').css('border','1px solid red'); return false;}else{$('#popupDatepicker').css('border','1px solid #D8D8D8');}
		
		$.ajax({
			type: 'POST',
			url: $('#absensiform').attr('action'),
			data: $('#absensiform').serialize()+'&id_kelas='+$('#kelasabsen').val()+'&jamabsen='+$('#jamabsen').val()+'&pelajaranabsen='+$('#pelajaranabsen').val()+"&pelajarannyaabsen="+$('#hiddenmapel').val()+'&tanggal='+$('#popupDatepicker').val()+'&nama_kelas='+$('#kelasabsen').find(":selected").text(),
			beforeSend: function() {
				$('#simpanabsensi').after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
			},
			success: function(data) {
				$('#wait').remove();
				$('#simpanabsensi').after('<div id="berhasil" ><b>Simpan Berhasil</b></div>');
				$('#berhasil').delay(10).fadeIn(1000).delay(2000).fadeOut(1000);
			}
		})
		return false;
	})
	
	
	function getadd(obj,date) {
		if($('#kelasabsen').val()==''){$('#kelasabsen').css('border','1px solid red'); return false;}else{$('#kelasabsen').css('border','1px solid #D8D8D8');}
		$.ajax({
			type: "POST",
			data: "id_kelas="+$('#kelasabsen').val()+"&jamabsen="+$('#jamabsen').val()+"&id_pelajaran="+$('#pelajaranabsen').val()+"&pelajarannyaabsen="+$('#hiddenmapel').val()+"&tanggal="+date,
			url: '<?=base_url()?>akademik/absensi/add',
			beforeSend: function() {
				$('#popupDatepicker').after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
			},
			success: function(msg) {
				$("#wait").remove();			
				$("#absenarea").html(msg);			
			}
		});	
	}
	
	$('#jamabsen').bind('change', function() {
		$('#hiddenjamke').remove();
		$(this).after('<input type="hidden" name="jamkenya" id="hiddenjamke" value="'+$(this).find(":selected").text()+'"/>');
		getadd($(this),$('#popupDatepicker').val());
	});
	$('#pelajaranabsen').bind('change', function() {
		$('#hiddenmapel').remove();
		var alias;
		if($(this).find(":selected").attr('alias')==''){alias=$(this).find(":selected").text();}else{alias=$(this).find(":selected").attr('alias');}
		$(this).after('<input type="hidden" name="pelajarannyaabsen" id="hiddenmapel" value="'+alias+'"/>');
		getadd($(this),$('#popupDatepicker').val());
	});
	$('#kelasabsen').bind('change', function() {
		$('#hiddenkelas').remove();
		$(this).after('<input type="hidden" name="kelasnyaabsesnsi" id="hiddenkelas" value="'+$(this).find(":selected").text()+'"/>');
		$.ajax({
			type: "POST",
			data: "id_kelas="+$('#kelasabsen').val()+"&jamabsen="+$('#jamabsen').val()+"&tanggal="+$('#popupDatepicker').val(),
			url: '<?=base_url()?>akademik/absensi/add',
			beforeSend: function() {
				$('#kelasabsen').after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
			},
			success: function(msg) {
				$("#wait").remove();			
				$("#absenarea").html(msg);			
			}
		});
		$.ajax({
			type: "POST",
			url: '<?=base_url()?>admin/pelajaran/getMapelByKelasAndPegawai/'+$(this).val(),
			beforeSend: function() {
				$("#pelajaranabsen").after("<img id='waitabsen1' src='<?=$this->config->item('images').'loading.png';?>' />");
			},
			success: function(msg) {
				$("#waitabsen1").remove();
				$("#pelajaranabsen").html(msg);	
			}
		});
		
		return false;
	});
</script>


<script type="text/javascript">
$(function() {
	$('#popupDatepicker').datepick();
		
					$(".exportexcellabsensi").click(function(){
						if($('select#kelasabsen').val()==''){
							$('select#kelasabsen').css('border','1px solid red');
						return false;
							
						}
						$('form#absensi').attr('action','<?=base_url()?>akademik/export');
						$('form#absensi').attr('target', '__blank');  
						$('form#absensi').submit();
					});
});

</script>

<table >
	<tbody>
		<tr>
			<td>
				<form action="" method="post" id="absensi" >
				<!--<div style="">Kelas</div>
				<div style="">Pelajaran</div>
				<div style="">Jam Ke</div>
				<div style="">Tanggal</div>-->
				<select  id="kelasabsen" name="kelas">
					<option value="">Pilih Kelas</option>
					<? foreach($kelas as $datakelas){?>
					<option <? if(@$_POST['kelas']==$datakelas['id']){echo 'selected';}?> value="<?=$datakelas['id']?>"><?=$datakelas['kelas']?><?=$datakelas['nama']?></option>
					<? } ?>
				</select>
				<? //pr($this->session->userdata['ak_setting']['jenjang'][0]['nama']);?>
				<? if($this->session->userdata['ak_setting']['jenjang'][0]['nama']!='SD'){?>
				<select  id="pelajaranabsen" name="pelajaranabsen">
					<option value="">Pilih Pelajaran</option>
				</select>
				<select  id="jamabsen" name="jamabsen">
					<option value="">Jam Pelajaran ke</option>
					<? for($xx=1;$xx<=24;$xx++){?>
					<option value="<?=$xx?>"> <?=$xx?> </option>
					<? } ?>
				</select>
				<? }else{ ?>
				<input type="hidden" name="pelajaranabsen" value="" />
				<input type="hidden" name="jamabsen" value="0" />
				<? } ?>
				<input type="text" placeholder="Pilih Tanggal"  name="tanggalnyaabsensi" id="popupDatepicker" style="height:28px;">
				<a id="simpanabsensi" class="button medium light-grey absenbutton" style="height:28px;" title="" > Simpan </a>
				<a  style="padding:5px;float:right;" class="readmore exportexcellabsensi"><img height="30" src="<?=$this->config->item('images')?>/Excel-icon.png" style="margin:0;" /> Export</a>
				<input type="hidden" name="jenis" value="absensi" />
				<input type="hidden" name="fileName" value="Absensi" />
				</form>
				<!--<h3>Export</h3>
				<div class="hr"></div>
				<input type="text" placeholder="Pilih Tanggal"  name="tanggalnyaabsensi" id="popupDatepicker" style="height:28px;"> 
				S/D &nbsp;<input type="text" placeholder="Pilih Tanggal"  name="tanggalnyaabsensi" id="popupDatepicker" style="height:28px;">
				<a  style="padding: 5px; position: relative; float: left; bottom: 16px; margin-right: 15px;" class="readmore exportexcellabsensi"><img height="30" src="<?=$this->config->item('images')?>/Excel-icon.png" style="margin:0;" /> Export</a>-->
			</td>
		</tr>
	</tbody>
</table>
<div id="absenarea">
<form name="absensi" id="absensiform" method="post" action="<?=base_url()?>akademik/absensi/add" >
<table>
    <thead>
        <tr> 
            <th> No </th>
            <th> No Induk </th>
            <th> Nama </th>
            <th> Masuk </th>
            <th> Sakit </th>
            <th> Izin </th>
            <th> Alpha </th>
            <th> Keterangan </th>
        </tr>                            
    </thead>
    <tbody>
        <tr> 
            <td> </td>
            <td> </td>
            <td> </td>
            <td> </td>
            <td> </td>
            <td> </td>
            <td> </td>
            <td> </td>
        </tr>
                         
    </tbody>
</table>
</form>
</div>