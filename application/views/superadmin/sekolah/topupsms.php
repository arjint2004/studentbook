<script>
	$(function() {
		var nmsk=$('table#akunsekolah tr#<?=$id_sekolah?> td.title').html();
		$('div.full h3 i#nama<?=$id_sekolah?>').html(nmsk);
		$('table#topupsms<?=$id_sekolah?> tr td#namask').append(nmsk);
		
		$('input.isNumber').keyup(function(){
			if(isNaN($(this).val())){
				alert('harus angka');
				$(this).val('');
				$(this).focus();
			}
		});
		
		$("#topup").each(function(){
			$container = $(this).next("div.error-container");
			//Validate Starts
			$(this).validate({
				onfocusout: function(element) {	$(element).valid();	},
				errorContainer: $container,
				rules:{
				  nominal:{required:true,notEqual:''},
				  keterangan:{required:true,notEqual:''}
				  /*,message:{required:true,minlength:10}*/
				}
			});//Validate End

		});
		
		$("#topup").submit(function(e){
			$frm = $(this);
			$nominal = $frm.find('*[name=nominal]').val();
			$keterangan = $frm.find('*[name=keterangan]').val();
			if($frm.find('*[name=nominal]').is('.valid') &&  $frm.find('*[name=keterangan]').is('.valid')) {
				$.ajax({
					type: "POST",
					data: $(this).serialize(),
					url: $(this).attr('action'),
					beforeSend: function() {
						//$(this).after("<img id='wait' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
						$("form#topup").before("<div style='display: block; top: 0px; left: 0px;' class=\"error-box\"></div>");
						$(".error-box").html("Sending Data").fadeIn("slow");
					},
					success: function(msg) {
						var outjson=JSON.parse(msg);
						//$("#wait").remove();
						$(".error-box").delay(2000).html('Pulsa telah terkirim. Total pulsa saat ini '+outjson.jml_pulsa);
						$(".error-box").delay(2000).fadeOut("slow",function(){
							$(this).remove();
							$('table#akunsekolah tr td div.loaddivset<?=$id_sekolah?>').html('');
							$('table tr#tr<?=$id_sekolah?>').hide();
							$('table tr#<?=$id_sekolah?>').scrollintoview({ speed:'1100'});
							
						});
					}
				});
				return false;
			}
			
			return false;
		});//Submit End	
	});
</script>
<?//pr($sekolah);?>
<div class="full file" style="margin-top:0;">
	<h3 style="margin-bottom:0;">Setting SMS "<i id="nama<?=$id_sekolah?>"></i>"</h3>
	<div class="hr"></div>
				
	<div class="full file" style="margin:0;min-height:50px;overflow:auto;border:none;">
		<form method="post" name="topup" enctype="multipart/form-data" id="topup" action="<? echo base_url();?>superadmin/sekolah/topupsms/<?=$id_sekolah?>">
		<table class="noborder" id="topupsms<?=$id_sekolah?>">
			<tbody>
				<tr>
					<th style="text-align:right;padding:2px;" colspan="2">
						<a onclick="$('#topup').submit();" id="simpanuas" class="button small light-grey absenbutton" title=""> Kirim </a>
					</th>
				</tr>
				<tr>
					<td class="title">Nama Sekolah</td>
					<td class="title" id="namask">
						<input type="hidden" name="ajax" value="1" />
						<input type="hidden" name="id_sekolah" value="<?=$id_sekolah?>" />
						<input type="hidden" name="topupsmslhoyo" value="<?=$id_sekolah?>" />
					</td>
				</tr>
				<tr>
					<td class="title">Jumlah nilai</td>
					<td >
						<input type="text" name="nominal" class="isNumber" />
						<div id="response" style="font-size: 11px; text-align: left;"> *) Harus diisi dengan angka murni. conto: 1000000.</div>
					</td>
				</tr>
				<tr>
					<td class="title">Keterangan</td>
					<td >
						<textarea name="keterangan" ></textarea>
						<div id="response" style="font-size: 11px; text-align: left;"> *) Isi dengan keterangan penting. contoh: "top up pulsa dikirim dari rekening 137 000 xxxx an: studentbook"</div>
					</td>
				</tr>
			</tbody>
		</table>
		<div style="display:none;" class="error-container"> Semua field harus di isi atau dipilih!  </div>
		</form>
	</div>
</div>
							