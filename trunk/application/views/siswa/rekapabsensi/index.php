<script>
				$(document).ready(function(){
					send();
					$("#rekapabsensi select#bulan").change(function(e){
						send();
					});
				});
				function send(){
						$.ajax({
							type: "POST",
							data: $("form#bulan").serialize(),
							url: '<?=base_url()?>siswa/rekapabsensi/rekapabsensilist/'+$('#bulan').val(),
							beforeSend: function() {
								$("#rekapabsensi select#bulan").after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
							},
							success: function(msg) {
								$("#wait").remove();
								$("#subjectlist").html(msg);	
							}
						});				
				}
				
				</script>

				<h3>Catatan Guru</h3>
				<div class="hr"></div>
				
				<div id="contentpage">
							<form action="" method="post" id="rekapabsensi" >
							<table class="tabelfilter">
								<tr>
								<td>
									Bulan :
									<select name="bulan" id="bulan" >
										<?=monthoption();?>
									</select>
									</td>
								</tr>
							</table>
							<input type="hidden" name="ajax" value="1" />
							</form>
							<div id="subjectlist">
								
							</div>
					</div>