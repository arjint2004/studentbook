				
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
						
					$('#listlap').click( function() {
						$('.listlap').show();
						$(this).children('a').addClass('current');
						$('.pengtk').hide();
						$('.menutk').hide();
					});
					$('#pengtk').click( function() {
						$('.listlap').hide();
						$('.menutk').hide();
						$(this).children('a').addClass('current');
						$('#listlap').children('a').removeClass('current');
						$('#menutk').children('a').removeClass('current');
						$('.pengtk').show();
					});
					$('#menutk').click( function() {
						$('.listlap').hide();
						$('.pengtk').hide();
						$(this).children('a').addClass('current');
						$('#listlap').children('a').removeClass('current');
						$('#pengtk').children('a').removeClass('current');
						$('.menutk').show();
					});
				});
				</script>
				<script type="text/javascript" src="<?=$this->config->item('js');?>upload.js"></script>
				<script type="text/javascript">
				function getadd(obj,date) {

				}
				</script>
                    <div class="clear"> </div>
					<h3 class="float-left" class="aktifitasakademik"> Buku Penghubung Ortu </h2>
				    <div class="hr"> </div>
                    <div class="tabs-container">
                        <ul class="tabs-frame">
                            <li id="listlap"><a style="cursor:pointer;" class="current">Laporan Kegiatan</a></li>
                           <!-- <li id="pengtk"><a style="cursor:pointer;" class="">Laporan Perkembangan</a></li>
                            <li id="menutk"><a style="cursor:pointer;" class="">Laporan Menu Makan</a></li>-->
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
                       <!--<div class="tabs-frame-content pengtk" style="display:none;">
					   ggh
                       </div> 
                       <div class="tabs-frame-content menutk" style="display:none;">
					   ghkghk
                       </div>  -->  
                    </div>    