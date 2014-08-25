           	<script>
			$(function() {
				$('input.kirimsms').click(function () {
					$("#smsnotifikasi").append("<div class=\"error-box\" style='display: block; top: 50%; position: fixed; left: 46%;'></div>");
					$(".error-box").html("Memproses Data").fadeIn("slow");
					var obj=$(this);
					$.ajax({
							type: "POST",
							data: $('form#smsnotif').serialize()+'&kirim='+$(obj).val(),
							url: $('form#smsnotif').attr('action'),
							beforeSend: function() {
								$('.kirimsms').after("<img id='waitsmsnot' style='margin:0;'  src='<?=$this->config->item('images').'loading.png';?>' />");
							},
							error	: function(){
								$(".error-box").delay(1000).html('Pemrosesan data gagal');
								$(".error-box").delay(1000).fadeOut("slow",function(){
									$(this).remove();
								});
														
							},
							success: function(msg) {
								$("#waitsmsnot").remove();
								$('#smsnotifikasi').html(msg);
								$(".error-box").delay(1000).html('SMS berhasil di kirim');
								$(".error-box").delay(1000).fadeOut("slow",function(){
									$(this).remove();
								});
							}
					});
					return false;
				});
				$('#paginationsmsnotif a').click(function () {
					var obj=$(this);
					$.ajax({
							type: "POST",
							data: '',
							url: $(obj).attr('href'),
							beforeSend: function() {
								$(obj).after("<img id='waitsmsnot' style='margin:0;'  src='<?=$this->config->item('images').'loading.png';?>' />");
							},
							success: function(msg) {
								$("#waitsmsnot").remove();
								$('#smsnotifikasi').html(msg);
							}
					});
					return false;
				});
				$('#kirimcekall').click(function () {    
					$(':checkbox.smskirim').prop('checked', this.checked);    
				});
			});
			</script>
			<form action="<?=base_url()?>akademik/sms/index" method="post" id="smsnotif">
			<table>
				<tr>
					<th>No</th>
					<th>Siswa</th>
					<th>Pelajaran</th>
					<th>Pesan</th>
					<th>Kelas</th>
					<th>Tanggal</th>
					<th><input id="kirimcekall" type="checkbox" name="cekall" value="1"/></th>
				</tr>
				<? 
				$no=$start;
				foreach($smsakademik as $datasms){ 
					$psn=explode('#',$datasms['pesan']);
					$no++;
				?>
				<tr>
					<td><?=$no?></td>
					<td style="text-align:left;"><?=$datasms['nama_siswa']?></td>
					<td style="text-align:left;"><?=$psn[0]?></td>
					<td style="text-align:left;"><?=$psn[1]?></td>
					<td><?=$datasms['kelas']?></td>
					<td style="text-align:left;"><? $tg=tanggal($datasms['waktu'].""); echo $tg[1];?></td>
					<td>
					<input type="checkbox" class="smskirim" name="id_sms[<?=$datasms['id']?>]" value="<?=$datasms['id']?>"/>
					<input type="hidden" name="no_hp[<?=$datasms['id']?>]" value="<?=$datasms['no_hp']?>"/>
					<input type="hidden" name="pesan[<?=$datasms['id']?>]" value="<?=$datasms['pesan']?>"/>
					
					</td>
				</tr>
				<? } ?>
				<tr>
					<td style="text-align:right;" colspan="6" >
					<div style="float:left;" id="paginationsmsnotif" >
					<?=$pagination?>
					</div>
					<div style="font-size:11px;">*) Data diatas adalah data antri. Akan dikirim setiap 1 jam secara otomatis</div>
					<!--<input type="submit" name="kirim" value="Kirim Yang dipilih" class="kirimsms" />
					<input style="margin-left:10px;" type="submit" name="kirimsemua" class="kirimsms" value="Kirim Semua" />--></td>
				</tr>
			</table>
			<form>