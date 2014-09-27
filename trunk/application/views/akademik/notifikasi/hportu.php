<script>
$(document).ready(function(){
		$("form#simpanhportuform").submit(function(){
			$("form#simpanhportuform").append("<div class=\"error-box\" style='display: block; top: 50%; position: fixed; left: 46%;'></div>");
			var obj=$(this);
			$.ajax({
				type: "POST",
				data: $(this).serialize(),
				url: $(this).attr('action'),
				beforeSend: function() {
					$(".error-box").delay(1000).html('Menyimpan Data');
				},
				error	: function(){		
					$(".error-box").css('background-color','red');
					$(".error-box").delay(1000).html('Gagal menyimpan data');	
					$(".error-box").delay(1000).fadeOut("slow",function(){
						$(this).remove();
					});
				},
				success: function(msg) {
					$(".error-box").delay(100).html('Berhasil menyimpan data');	
					$(".error-box").delay(100).fadeOut("slow",function(){
						$(this).remove();
						$('#hportu').html(msg);
					});
				}
			});
			return false;
		});	
});
</script>
<?php echo form_open('akademik/notifikasi/hportu',array('id'=>'simpanhportuform'));?>
<table>
	<thead>
		<tr>
			<th colspan="4" style="text-align:right;">
			</th>
			<th>
				<a title="" class="button small light-grey absenbutton" id="simpanhportu" onclick="$('#simpanhportuform').submit();"> Simpan </a>
			</th>
		</tr>
		<tr>
			<th>No</th>
			<th>Nama Siswa</th>
			<th>Nama Ortu</th>
			<th>Kelas</th>
			<th>Hp Ortu</th>
		</tr>	
	</thead>
	<tbody>
		<? 
		$no=1;
		foreach($siswa as $datasiswa){?>
		<tr>
			<td ><?=$no++?></td>
			<td class="left"><?=$datasiswa['nama']?></td>
			<td class="left"><?=$datasiswa['nama_ortu']?></td>
			<td ><?=$datasiswa['kelas']?><?=$datasiswa['nama_kelas']?></td>
			<td ><input style="width:150px;" type="text" name="hp[<?=$datasiswa['id_ortu']?>]" value="<?=$datasiswa['hp']?>" /></td>
		</tr>
		<? } ?>
		<tr>
			<th colspan="4" style="text-align:right;">
			</th>
			<th>
				<a title="" class="button small light-grey absenbutton" id="simpanhportu" onclick="$('#simpanhportuform').submit();"> Simpan </a>
			</th>
		</tr>
	</tbody>
</table>
<?php echo form_close(); ?>