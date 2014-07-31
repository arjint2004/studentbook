


<script>
	$('#simpanabsensi').bind('click', function() {
		if($('#kelasabsen').val()==''){$('#kelasabsen').css('border','1px solid red'); return false;}else{$('#kelasabsen').css('border','1px solid #D8D8D8');}
		if($('#popupDatepicker').val()==''){$('#popupDatepicker').css('border','1px solid red'); return false;}else{$('#popupDatepicker').css('border','1px solid #D8D8D8');}
		
		$.ajax({
			type: 'POST',
			url: $('#absensiform').attr('action'),
			data: $('#absensiform').serialize()+'&id_kelas='+$('#kelasabsen').val()+'&tanggal='+$('#popupDatepicker').val(),
			beforeSend: function() {
				$('#simpanabsensi').after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
			},
			success: function(data) {
				$('#wait').remove();
				$('#simpanabsensi').after('<div id="berhasil" >Simpan Berhasil</div>');
				$('#berhasil').delay(10).fadeIn(1000).delay(2000).fadeOut(1000);
				$("table.absensi input[type='radio'],textarea.keteranganabsen").prop('disabled', true);
			}
		})
		return false;
	})
	
	
	function getadd(obj,date) {
		if($('#kelasabsen').val()==''){$('#kelasabsen').css('border','1px solid red'); return false;}else{$('#kelasabsen').css('border','1px solid #D8D8D8');}
		$.ajax({
			type: "POST",
			data: "id_kelas="+$('#kelasabsen').val()+"&tanggal="+date,
			url: '<?=base_url()?>akademik/absensi/add',
			beforeSend: function() {
				$('#popupDatepicker').after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
			},
			success: function(msg) {
				$("#wait").remove();			
				$("#absenarea").html(msg);
				$("table.absensi input[type='radio'],textarea.keteranganabsen").prop('disabled', true);
			}
		});	
	}
	
	$('#kelasabsen').bind('change', function() {
		$.ajax({
			type: "POST",
			data: "id_kelas="+$(this).val(),
			url: '<?=base_url()?>akademik/absensi/add',
			beforeSend: function() {
				$('#kelasabsen').after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
			},
			success: function(msg) {
				$("#wait").remove();			
				$("#absenarea").html(msg);		
				$("table.absensi input[type='radio'],textarea.keteranganabsen").prop('disabled', true);
			}
		});
	});
</script>
<link type="text/css" href="<?=$this->config->item('css');?>datepick.css" rel="stylesheet">
<script type="text/javascript" src="<?=$this->config->item('js');?>jquery.datepick.js"></script>
<script type="text/javascript" src="<?=$this->config->item('js');?>jquery.datepick-id.js"></script>

<script type="text/javascript">
$(function() {
	$('#popupDatepicker').datepick();
	
});

</script>

<table >
	<tbody>
		<tr>
			<td>
				Pilih Kelas
				<select  id="kelasabsen" name="kelas">
					<option value="">Pilih Kelas</option>
					<? foreach($kelas as $datakelas){?>
					<option <? if(@$_POST['kelas']==$datakelas['id']){echo 'selected';}?> value="<?=$datakelas['id']?>"><?=$datakelas['kelas']?><?=$datakelas['nama']?></option>
					<? } ?>
				</select>
				Pilih Tanggal <input type="text" value="<?=date('Y-m-d')?>" id="popupDatepicker">
				
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