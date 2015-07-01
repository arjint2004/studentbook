				<script>
					$(document).ready(function(){
						$("#jurnalwaliformcontent").each(function(){
						$container = $(this).next("div.error-container");
						//Validate Starts
						$(this).validate({
							onfocusout: function(element) {	$(element).valid();	},
							errorContainer: $container,
							rules:{
							  id_kelas:{required:true,notEqual:'Pilih Kelas'},
							  id_siswa_det_jenjang:{required:true,notEqual:'Pilih Siswa'},
							  tanggal:{required:true,notEqual:''},
							  jurnalwali:{required:true,notEqual:''},
							  /*file:{required:true,notEqual:''}
							  ,message:{required:true,minlength:10}*/
							}
						});//Validate End

					});
				
					//Submit Starts		   
					$("#jurnalwaliformcontent").submit(function(e){
						$frm = $(this);
						$id_kelas = $frm.find('*[name=id_kelas]').val();
						$tanggal = $frm.find('*[name=tanggal]').val();
						$id_siswa_det_jenjang = $frm.find('*[name=id_siswa_det_jenjang]').val();
						$jurnalwali = $frm.find('*[name=jurnalwali]').val();
						//$file = $frm.find('*[name=file]').val();
						
						if($frm.find('*[name=id_kelas]').is('.valid') && $frm.find('*[name=id_siswa_det_jenjang]').is('.valid') && $frm.find('*[name=jurnalwali]').is('.valid') /*&& $frm.find('*[name=file]').is('.valid')*/ && $frm.find('*[name=tanggal]').is('.valid')) {
							$.ajax({
								type: "POST",
								data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&'+$(this).serialize(),
								url: $(this).attr('action'),
								beforeSend: function() {
									$("#submitjurnal").after("<img id='wait' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
								},
								success: function(msg) {
									$("#wait").remove();	
									
									ajaxupload("<? echo base_url();?>akademik/jurnalwali/upload/"+msg,"response","image-list","file");
									//$('#subject').load('<? echo base_url();?>akademik/jurnalwali/daftarpr');	
								}
							});
							return false;
						}
						
						return false;
					});//Submit End
					$("#jurnalwaliformcontent select#kelas").change(function(e){
						$.ajax({
							type: "POST",
							data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&'+$("form#jurnalwaliformcontent").serialize(),
							url: '<?=base_url()?>akademik/jurnalwali/getOptionSiswaByIdKelas/'+$(this).val(),
							beforeSend: function() {
								$("#jurnalwaliformcontent select#kelas").after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
								//$("#subjectlist table.tabelkelas tbody").html("");
							},
							success: function(msg) {
								$("#wait").remove();
								$("#siswa").html(msg);	
							}
						});
						return false;
					});//Submit End
				});
				</script>
				<link type="text/css" href="<?=$this->config->item('css');?>datepick.css" rel="stylesheet">
				<script type="text/javascript" src="<?=$this->config->item('js');?>jquery.datepick.js"></script>
				<script type="text/javascript" src="<?=$this->config->item('js');?>jquery.datepick-id.js"></script>
				<script type="text/javascript" src="<?=$this->config->item('js');?>upload.js"></script>

				<script type="text/javascript">
				function getadd(obj,date) {

				}
				$(function() {
					$('#datekirimjurnal').datepick();
				});
				</script>
				<h3>Jurnal Wali Kelas</h3>
				<div class="hr"></div>
				<form action="<?=base_url()?>akademik/jurnalwali/addjurnal" method="post" id="jurnalwaliformcontent" >
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
				<div id="contentpage">
							<table class="tabelfilter">
								<tr>
								<td>
									Kelas :
										<select class="selectfilter" id="kelas" name="id_kelas">
											<option value="">Pilih Kelas</option>
											<? foreach($kelas as $datakelas){?>
											<option <? if(@$_POST['kelas']==$datakelas['id']){echo 'selected';}?> value="<?=$datakelas['id']?>"><?=$datakelas['kelas']?><?=$datakelas['nama']?></option>
											<? } ?>
										</select>

									
									Siswa :
										<select class="selectfilter" id="siswa" name="id_siswa_det_jenjang">
											<option value="">Pilih Siswa</option>
										</select>
										
									Tanggal :
									<input type="text" name="tanggal" style="width:100px;" value="<?=date('Y-m-d')?>" id="datekirimjurnal">
									</td>
								</tr>
							</table>
							<input type="hidden" name="ajax" value="1" />
							
							<div id="subjectlist">
								<?php //$this->load->view('akademik/jurnalwali/daftarjurnalwalilist'); ?>
							</div>
					</div>
					
					<div class="contentpagebox" id="contentpage">
						<h5>Referensi</h5>
						<div class="hr"></div>
						<a class="readmore" tab="wali_input" id="kepribadian" title="" onclick="$('#guru').scrollintoview({ speed:'1100'});"> Nilai </a>
						<a class="readmore" tab="wali_input" id="prestasi" title=""  onclick="$('#guru').scrollintoview({ speed:'1100'});"> Absensi </a>
						<a class="readmore" title="" tab="nilai" href="" id="<?=base64_encode('nilai lain_lain');?>">Ekstrakurikuler </a>
						<a class="readmore" title="" tab="nilai" href="" id="<?=base64_encode('nilai lain_lain');?>">Organisasi Siswa </a>
						<a class="readmore" title="" tab="nilai" href="" id="<?=base64_encode('nilai lain_lain');?>">Bimb Konseling </a>
						<a class="readmore" title="" tab="nilai" href="" id="<?=base64_encode('nilai lain_lain');?>" onclick="$('#guru').scrollintoview({ speed:'1100'});">Catatan Guru </a>
						<div class="clear"></div>
					</div>
					
					<div class="contentpagebox" id="contentpage">
						
							<textarea name="jurnalwali" style="width:98%; height:200px;"></textarea>
							<input type="file" name="file" size="30" id="file" multiple />
							<div id="response" style="font-size:11px;">Upload Video/Audio/Foto Yang berkaitan dengan jurnal.</div>
							<a class="readmore" title="" id="submitjurnal" onclick="$('#jurnalwaliformcontent').submit();">Submit</a>
						
						<div class="clear"></div>
					</div>
					</form>