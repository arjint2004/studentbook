<script>
				$(document).ready(function(){
					$("#inspertemuanadd").click(function(){
						$.ajax({
							type: "POST",
							data: '',
							url: '<?=base_url()?>akademik/instrumen/addpertemuan',
							beforeSend: function() {
								$("#inspertemuanadd").append("<img style='float: right; position: absolute; top: -5px; right: 3px;' id='waitins4' src='<?=$this->config->item('images').'loaderhover.gif';?>' />");
							},
							success: function(msg) {
								$("#waitins4").remove();
								$("#subjectlistins").html(msg);	
							}
						});
						return false;
					});//Submit End
				});

				</script>
				<h3>Evaluasi <?=$jenis?></h3>
				<div class="hr"></div>
				
				<div id="contentpage">
							<form action="" method="post" id="catatanguruform" >
							<table class="tabelfilter">
								<tr>
								<td>
									<a class="readmore" title="" id="inspertemuanadd"> Buat <br> Pertemuan </a>
									<a class="readmore" title="" id="materiadd"> Buat <br> Instrumen </a>
									<a class="readmore" title="" id="materiadd"> Scoring <br> Evaluasi </a>
									</td>
								</tr>
							</table>
							<input type="hidden" name="ajax" value="1" />
							</form>
							<div id="subjectlistins">
								<?php //$this->load->view('akademik/catatanguru/daftarcatatangurulist'); ?>
							</div>
					</div>