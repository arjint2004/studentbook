				<script>
				$(document).ready(function(){
					
						$.ajax({
							type: "POST",
							data: '&id_kelas=<?=$siswa[0]['id_kelas_siswa_det_jenjang']?>',
							url: '<?=base_url()?>siswa/jurnalwalikelas/jurnalwalikelaslist',
							beforeSend: function() {
								$("a#jurnalwalikelas").append("<img style='float: right; position: absolute; top: -5px; right: 3px;' id='wait' src='<?=$this->config->item('images').'loaderhover.gif';?>' />");
							},
							success: function(msg) {
								$("#wait").remove();
								$("#subjectlist").html(msg);	
							}
						});
						
					
				
				});

				</script>
				<h3>Daftar Jurnal</h3>
				<div class="hr"></div>
				
				<div id="contentpage">
					<div id="subjectlist"></div>
				</div>
