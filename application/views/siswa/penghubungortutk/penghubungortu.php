				
				<script>
					$(document).ready(function(){

					$('.unsellall').click( function() {
						$('#idsiswalaporan option').attr('selected', false);
						//add_id_ortu();
					});
					
					$('#listlap').click( function() {
						$('.listlap').show();
						$(this).children('a').addClass('current');
						$('#sendlap').children('a').removeClass('current');
						$('.sendlap').hide();
						$('.pengtk').hide();
						$('.menutk').hide();
					});
					$('#sendlap').click( function() {
						$('.listlap').hide();
						$('.pengtk').hide();
						$('.menutk').hide();
						$(this).children('a').addClass('current');
						$('#listlap').children('a').removeClass('current');
						$('#pengtk').children('a').removeClass('current');
						$('#menutk').children('a').removeClass('current');
						$('.sendlap').show();
					});
					$('#pengtk').click( function() {
						$('.listlap').hide();
						$('.sendlap').hide();
						$('.menutk').hide();
						$(this).children('a').addClass('current');
						$('#listlap').children('a').removeClass('current');
						$('#sendlap').children('a').removeClass('current');
						$('#menutk').children('a').removeClass('current');
						$('.pengtk').show();
					});
					$('#menutk').click( function() {
						$('.listlap').hide();
						$('.sendlap').hide();
						$('.pengtk').hide();
						$(this).children('a').addClass('current');
						$('#listlap').children('a').removeClass('current');
						$('#sendlap').children('a').removeClass('current');
						$('#pengtk').children('a').removeClass('current');
						$('.menutk').show();
					});
					
					$('.selall').click( function() {
						$('#idsiswalaporan option').attr('selected', 'selected');
						//add_id_ortu();
					});
					$("select#kelaslaporan,select#idkelasp,select#kelasperkemb").change(function(e){
						if($(this).attr('name')=='idkelasp'){
							var urll='<?=base_url()?>akademik/jurnalwali/penghubungortulist/0';
							var append='#listpenghub';
						}else if($(this).attr('id')=='kelasperkemb'){
							var urll='<?=base_url()?>akademik/jurnalwali/getOptionSiswaByIdKelas/'+$(this).val();
							var append='#siswaperkemb';				
						}else{
							var urll='<?=base_url()?>akademik/jurnalwali/getOptionSiswaByIdKelas/'+$(this).val();
							var append='#idsiswalaporan';
						}
						var obj=$(this);
						$.ajax({
							type: "POST",
							data: 'id_kelas=<?=$this->session->userdata['user_authentication']['id_kelas_siswa_det_jenjang']?>',
							url: urll,
							beforeSend: function() {
								$(obj).after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
								//$("#subjectlist table.tabelkelas tbody").html("");
							},
							success: function(msg) {
								$("#wait").remove();
								$(append).html(msg);
							}
						});
						return false;
					});//Submit End
				
				
				$("#kirimlaporan").each(function(){
					$container = $(this).next("div.error-container");
					//Validate Starts
					$(this).validate({
						onfocusout: function(element) {	$(element).valid();	},
						errorContainer: $container,
						rules:{
						  id_kelas:{required:true,notEqual:'Pilih Kelas'},
						  subject:{required:true,notEqual:'Pilih Kelas'},
						  keterangan:{required:true,notEqual:''}
						  /*,message:{required:true,minlength:10}*/
						}
					});//Validate End

				});
				
				$("select#idsiswalaporan").change(function(e){
					//add_id_ortu()
				});
				
				function add_id_ortu(){
					$('input.id_ortu').remove();
					$("select#idsiswalaporan option").each(function(e){
						if($(this).prop("selected") && $(this).attr("value")!=''){ 
							$('select#idsiswalaporan').parent('td').append('<input id="id_ortu'+$(this).val()+'" class="id_ortu" type="hidden" name="id_ortu['+$(this).val()+']" value="'+$(this).attr("id_ortu")+'" />');
						}
					});
				}
				
				$("a.simpanprg").click(function(e){
					$("form#penghubungortutkform").append("<div class=\"error-box\" style='display: block; top: 50%; position: fixed; left: 46%;'></div>");
					$(".error-box").html("Menyimpan Data").fadeIn("slow");
					$.ajax({
						type: "POST",
						data: $('form#penghubungortutkform').serialize(),
						url: $('form#penghubungortutkform').attr('action'),
						beforeSend: function() {
							
						},
						error	: function(){
									$(".error-box").delay(1000).html('Menyimpan data gagal');
									$(".error-box").delay(1000).fadeOut("slow",function(){
										$(this).remove();
									});
														
						},
						success: function(msg) {
									$("#wait").remove();
									$(".error-box").delay(1000).html('Data berhasil di simpan');
									$(".error-box").delay(1000).fadeOut("slow",function(){
										$(this).remove();
									});	
						}
					});
					return false;					
				});
				$("a.simpanprgmenu").click(function(e){
					$("form#penghubungortutkformmenu").append("<div class=\"error-box\" style='display: block; top: 50%; position: fixed; left: 46%;'></div>");
					$(".error-box").html("Menyimpan Data").fadeIn("slow");
					$.ajax({
						type: "POST",
						data: $('form#penghubungortutkformmenu').serialize(),
						url: $('form#penghubungortutkformmenu').attr('action'),
						beforeSend: function() {
							
						},
						error	: function(){
									$(".error-box").delay(1000).html('Menyimpan data gagal');
									$(".error-box").delay(1000).fadeOut("slow",function(){
										$(this).remove();
									});
														
						},
						success: function(msg) {
									$("#wait").remove();
									$(".error-box").delay(1000).html('Data berhasil di simpan');
									$(".error-box").delay(1000).fadeOut("slow",function(){
										$(this).remove();
									});	
						}
					});
					return false;					
				});
					
				});
				</script>
				<script type="text/javascript" src="<?=$this->config->item('js');?>upload.js"></script>
				
				    <div class="hr"> </div>
                    <div class="clear"> </div>
					<h2 class="float-left aktifitasakademik" > Buku Penghubung Ortu </h2>
                    
                    <div class="tabs-container">
                        <ul class="tabs-frame">
                            <li id="listlap"><a style="cursor:pointer;" class="current">Daftar Kegiatan</a></li>
                            <li id="pengtk"><a style="cursor:pointer;" >Perkembangan</a></li>
                            <li id="menutk"><a style="cursor:pointer;" >Menu Makan</a></li>
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
						<div class="tabs-frame-content pengtk" style="display:none;"  >
							<? //pr($_POST['program']);?>
							<script type="text/javascript">
								function getadd(obj,date) {
									if($(obj).attr('inputId')=='tanggalpengtk'){
										$("form#penghubungortutkform").append("<div class=\"error-box\" style='display: block; top: 50%; position: fixed; left: 46%;'></div>");
									}else if($(obj).attr('inputId')=='tanggalpengtkmenu'){
										$("form#penghubungortutkformmenu").append("<div class=\"error-box\" style='display: block; top: 50%; position: fixed; left: 46%;'></div>");
									}
									
									$(".error-box").html("Mengambil Data").fadeIn("slow");
									$.ajax({
										type: "POST",
										data: 'id_kelas=<?=$this->session->userdata['user_authentication']['id_kelas_siswa_det_jenjang']?>&id_kelasmanu=<?=$this->session->userdata['user_authentication']['id_kelas_siswa_det_jenjang']?>&id_det_jenjang=<?=$this->session->userdata['user_authentication']['id_siswa_det_jenjang']?>&tanggalpengtk='+date+'&type='+$(obj).attr('inputId')+'&onlyview=true&save=save',
										url: '<?=base_url()?>siswa/penghubungortutk/penghubungortu/',
										beforeSend: function() {
											
										},
										error	: function(){
													$(".error-box").delay(1000).html('Mengambil data gagal');
													$(".error-box").delay(1000).fadeOut("slow",function(){
														$(this).remove();
													});
																		
										},
										success: function(msg) {
													$("#wait").remove();
													if($(obj).attr('inputId')=='tanggalpengtk'){
														$("div#placeperkembangan").html(msg);
													}else if($(obj).attr('inputId')=='tanggalpengtkmenu'){
														$("div#placeperkembanganmenu").html(msg);
													}
													
													$(".error-box").delay(1000).html('Data berhasil di ambil');
													$(".error-box").delay(1000).fadeOut("slow",function(){
														$(this).remove();
													});	
										}
									});
									return false;
								}
								$(function() {
									$('#tanggalpengtk').datepick({
										inputId: 'tanggalpengtk',
										formId: 'penghubungortutkform',
									});
									$('#tanggalpengtkmenu').datepick({
										inputId: 'tanggalpengtkmenu',
										formId: 'penghubungortutkformmenu',
									});
								});
							</script>
							<form action="<? echo base_url();?>siswa/penghubungortutk/penghubungortu" id="penghubungortutkform" name="penghubungortutkform" method="post" >
							<table class="tabelfilter">
								<tr>
								<td>
									
									Tanggal :
										<input type="text" style="height:28px; width:110px;" id="tanggalpengtk" name="tanggalpengtk" readonly="" placeholder="Pilih Tanggal">
									
									</td>
								</tr>
							</table>
								<br />
								<br />
								<div id="placeperkembangan">
								<?=$this->load->view('siswa/penghubungortutk/perkembangan')?>
								</div>
								<br />
							</form>		
												
						</div>
						<div class="tabs-frame-content menutk" style="display:none;">
							<form action="<? echo base_url();?>siswa/penghubungortutk/penghubungortu" id="penghubungortutkformmenu" name="penghubungortutkformmenu" method="post" >
							<table class="tabelfilter">
								<tr>
								<td>
									Tanggal :
										<input type="text" style="height:28px; width:110px;" id="tanggalpengtkmenu" name="tanggalpengtkmenu" readonly="" placeholder="Pilih Tanggal">
									
									</td>
								</tr>
							</table>
								<div id="placeperkembanganmenu">
									<?=$this->load->view('siswa/penghubungortutk/menumakan')?>
								</div>
							</form>	
						</div>
                    </div>