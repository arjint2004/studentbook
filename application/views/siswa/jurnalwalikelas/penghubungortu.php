				
				<script>
				$(document).ready(function(){
						$.ajax({
							type: "POST",
							data: 'id_kelas=<?=$id_kelas?>',
							url: '<?=base_url()?>siswa/jurnalwalikelas/penghubungortulist/0',
							beforeSend: function() {
								$('ul.tabs-frame li#listlap a').append("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
								//$("#subjectlist table.tabelkelas tbody").html("");
							},
							success: function(msg) {
								$("#wait").remove();
								$('#listpenghub').html(msg);
							}
						});
				});
				</script>
				<script type="text/javascript" src="<?=$this->config->item('js');?>upload.js"></script>
				<script type="text/javascript">
				function getadd(obj,date) {

				}
				</script>
				    <div class="hr"> </div>
                    <div class="clear"> </div>
					<h2 class="float-left" class="aktifitasakademik"> Buku Penghubung Ortu </h2>
                    
                    <div class="tabs-container">
                        <ul class="tabs-frame">
                            <li id="listlap"><a style="cursor:pointer;" class="current">Daftar Laporan</a></li>
                        </ul>
                        <div class="tabs-frame-content listlap">

							<div id="listpenghub">
                            <table class="adddata lap">
									<tbody>
										<tr>
											<th>No</th>
											<th>Subject</th>
											<th>Keterangan</th>
											<th>Tindakan</th>
										</tr>
										<tr>
											<td width="1"></td>
											<td class="title" ></td>
											<td ></td>
											<td ></td>
										</tr>
									</tbody>
							</table>
							</div>
                        </div>
                       
                    </div>    