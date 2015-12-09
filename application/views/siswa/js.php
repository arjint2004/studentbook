<script>
$(document).ready(function() {
					
					$('#tababsensi').bind('click', function() {
						$.ajax({
							type: "GET",
							data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&',
							url: '<?=base_url('siswa/absensi')?>',
							beforeSend: function() {
								$('#tababsensi').append("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
							},
							success: function(msg) {
								$("#wait").remove();			
								$("#absensi").html(msg);			
							}
						});
					});
					
					$('#jurnaltab').bind('click', function() {
						$.ajax({
							type: "GET",
							data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&',
							url: '<?=base_url('siswa/jurnalwali/addjurnal')?>',
							beforeSend: function() {
								$('#jurnaltab').append("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
							},
							success: function(msg) {
								$("#wait").remove();			
								$("#jurnal").html(msg);			
							}
						});
					});

					var lastreadmore;
					
					$('.readmore').bind('click', function() {
						var thisobj=$(this);
						$($(this).parent('div').children('a')).each(function(i) {
								$(this).parent('div').children('a').attr('class', 'readmore');
								lastreadmore=$(this);
						});
						
						$('#brsubject').remove();	
						$('div#subject').remove();	
						$(lastreadmore).after('<br id="brsubject" class="clear" /> <div id="subject"></div>');
						
						$($(thisobj).parent('div').children('a')).each(function(i) {
							$(this).parent('div').children('a').attr('class', 'readmore');
							lastreadmore=$(this);
						});
						$(thisobj).attr('class','readmore selected');
						
						switch($(thisobj).attr('tab'))
							{
							//Area siswa
							case 'evaluasi':
								var url='';
								if($(this).attr('id')=='rekapabsensi'){
									url='<? echo base_url();?>siswa/rekapabsensi/index';
								}else if($(this).attr('id')=='jurnalwalikelas'){
									url='<? echo base_url();?>siswa/jurnalwalikelas/index';
								}else if($(this).attr('id')=='catatanguru'){
									url='<? echo base_url();?>siswa/catatanguru/index';
								}else if($(this).attr('id')=='jurnalwalikelas'){
									url='<? echo base_url();?>siswa/jurnalwalikelas/index';
								}else if($(this).attr('id')=='rekapnilai'){
									url='<? echo base_url();?>siswa/rekapnilai/index';
								}
								ajax(url,thisobj);
								return false;
							break;
							
							  
							case 'pembelajaran':
								var url='';
								if($(this).attr('id')=='materi_pelajaran'){
									url='<? echo base_url();?>siswa/materi';
								}else if($(this).attr('id')=='daftar_pr'){
									url='<? echo base_url();?>siswa/kirimpr/daftarpr';
								}else if($(this).attr('id')=='daftar_tugas'){
									url='<? echo base_url();?>siswa/kirimtugas/daftartugas';
								}else if($(this).attr('id')=='soalonline'){
									url='<? echo base_url();?>siswa/soalonline';
								}
								ajax(url,thisobj);
								return false;
							break;
							  
							case 'ujian':
								var url='';
								if($(this).attr('id')=='daftar_harian'){
									url='<? echo base_url();?>siswa/kirimharian/daftarharian';
								}else if($(this).attr('id')=='daftar_uas'){
									url='<? echo base_url();?>siswa/kirimuas/daftaruas';
								}else if($(this).attr('id')=='daftar_uts'){
									url='<? echo base_url();?>siswa/kirimuts/daftaruts';
								}
								ajax(url,thisobj);
								return false;
							break;
							
							default:
							
							break;  
						}
					});
					function ajax(url,thisobj){
							$.ajax({
									type: 'GET',
									url: url,
									data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&',
									beforeSend: function() {
										$(thisobj).append("<img style='float: right; position: absolute; top: -5px; right: 3px;' id='wait' src='<?=$this->config->item('images').'loaderhover.gif';?>' />");
									},
									success: function(data) {
										$('#wait').remove();
										$('#nilai').html('');
										$('#subject').html(data);
										$($(thisobj).parent('div').children('a')).each(function(i) {
												$(this).parent('div').children('a').attr('class', 'readmore');
												lastreadmore=$(this);
										});
										$(thisobj).attr('class','readmore selected');
									}
							});
							return false;					
					}

					$('#utsbutton').bind('click', function() {

						
					});
					
					//RAPORT
					
					$('#raporttab').bind('click', function() {
						if($('input#kelasraport').val()==''){
							$('input#kelasraport').css('border','1px solid red');
							return false;
						}else{$('input#kelasraport').css('border','none');}
						if($('input#siswaraport').val()==''){
							$('input#siswaraport').css('border','1px solid red');
							return false;				
						}else{$('input#siswaraport').css('border','none');}
						$.ajax({
							type: "GET",
							data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&',
							url: '<?=base_url('siswa/raport/index')?>/'+$('input#siswaraport').val(),
							beforeSend: function() {
								$('#raporttab').append("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
							},
							success: function(msg) {
								$("#wait").remove();			
								$("#raport").html(msg);			
							}
						});
					});
					$('#raporekstrattab').bind('click', function() {
						if($('input#kelasraport').val()==''){
							$('input#kelasraport').css('border','1px solid red');
							return false;
						}else{$('input#kelasraport').css('border','none');}
						if($('input#siswaraport').val()==''){
							$('input#siswaraport').css('border','1px solid red');
							return false;				
						}else{$('input#siswaraport').css('border','none');}
						$.ajax({
							type: "GET",
							data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&',
							url: '<?=base_url('siswa/raport/ekstrakurikuler')?>/'+$('input#siswaraport').val(),
							beforeSend: function() {
								$('#raporekstrattab').append("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
							},
							success: function(msg) {
								$("#wait").remove();			
								$("#ekstraload").html(msg);			
							}
						});
					});
					$('#raportkegiatantab').bind('click', function() {
						if($('input#kelasraport').val()==''){
							$('input#kelasraport').css('border','1px solid red');
							return false;
						}else{$('input#kelasraport').css('border','none');}
						if($('input#siswaraport').val()==''){
							$('input#siswaraport').css('border','1px solid red');
							return false;				
						}else{$('input#siswaraport').css('border','none');}
						$.ajax({
							type: "GET",
							data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&',
							url: '<?=base_url('siswa/raport/kegiatan')?>/'+$('input#siswaraport').val(),
							beforeSend: function() {
								$('#raportkegiatantab').append("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
							},
							success: function(msg) {
								$("#wait").remove();			
								$("#kegiatanload").html(msg);			
							}
						});
					});
					$('#raportkepribadiantab').bind('click', function() {
						if($('input#kelasraport').val()==''){
							$('input#kelasraport').css('border','1px solid red');
							return false;
						}else{$('input#kelasraport').css('border','none');}
						if($('input#siswaraport').val()==''){
							$('input#siswaraport').css('border','1px solid red');
							return false;				
						}else{$('input#siswaraport').css('border','none');}
						$.ajax({
							type: "GET",
							data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&',
							url: '<?=base_url('siswa/raport/kepribadian')?>/'+$('input#siswaraport').val(),
							beforeSend: function() {
								$('#raportkepribadiantab').append("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
							},
							success: function(msg) {
								$("#wait").remove();			
								$("#kepribadianload").html(msg);			
							}
						});
					});
					$('#raportprestasitab').bind('click', function() {
						if($('input#kelasraport').val()==''){
							$('input#kelasraport').css('border','1px solid red');
							return false;
						}else{$('input#kelasraport').css('border','none');}
						if($('input#siswaraport').val()==''){
							$('input#siswaraport').css('border','1px solid red');
							return false;				
						}else{$('input#siswaraport').css('border','none');}
						$.ajax({
							type: "GET",
							data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&',
							url: '<?=base_url('siswa/raport/prestasi')?>/'+$('input#siswaraport').val(),
							beforeSend: function() {
								$('#raportprestasitab').append("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
							},
							success: function(msg) {
								$("#wait").remove();			
								$("#prestasiload").html(msg);			
							}
						});
					});
					$('#raportabsensitab').bind('click', function() {
						if($('input#kelasraport').val()==''){
							$('input#kelasraport').css('border','1px solid red');
							return false;
						}else{$('input#kelasraport').css('border','none');}
						if($('input#siswaraport').val()==''){
							$('input#siswaraport').css('border','1px solid red');
							return false;				
						}else{$('input#siswaraport').css('border','none');}
						$.ajax({
							type: "GET",
							data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&',
							url: '<?=base_url('siswa/raport/absensi')?>/'+$('input#siswaraport').val(),
							beforeSend: function() {
								$('#raportabsensitab').append("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
							},
							success: function(msg) {
								$("#wait").remove();			
								$("#absensiload").html(msg);			
							}
						});
					});
					$('#raportkenaikantab').bind('click', function() {
						if($('input#kelasraport').val()==''){
							$('input#kelasraport').css('border','1px solid red');
							return false;
						}else{$('input#kelasraport').css('border','none');}
						if($('input#siswaraport').val()==''){
							$('input#siswaraport').css('border','1px solid red');
							return false;				
						}else{$('input#siswaraport').css('border','none');}
						$.ajax({
							type: "GET",
							data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&',
							url: '<?=base_url('siswa/raport/keterangan')?>/'+$('input#siswaraport').val()+'/'+$('input#kelasraport').val(),
							beforeSend: function() {
								$('#raportkenaikantab').append("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
							},
							success: function(msg) {
								$("#wait").remove();			
								$("#kenaikanload").html(msg);			
							}
						});
					});
					$('#raportcatatantab').bind('click', function() {
						if($('input#kelasraport').val()==''){
							$('input#kelasraport').css('border','1px solid red');
							return false;
						}else{$('input#kelasraport').css('border','none');}
						if($('input#siswaraport').val()==''){
							$('input#siswaraport').css('border','1px solid red');
							return false;				
						}else{$('input#siswaraport').css('border','none');}
						$.ajax({
							type: "GET",
							data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&',
							url: '<?=base_url('siswa/raport/catatan')?>/'+$('input#siswaraport').val(),
							beforeSend: function() {
								$('#raportcatatantab').append("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
							},
							success: function(msg) {
								$("#wait").remove();			
								$("#catatanload").html(msg);			
							}
						});
					});
					$('#kelaskenaikan').bind('change', function() {
						var obj=$(this);
						$.ajax({
							type: "POST",
							data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&id_kelas='+$(obj).val(),
							url: '<?=base_url('siswa/raport/setkenaikan')?>/'+$(obj).val(),
							beforeSend: function() {
								$('#kelaskenaikan').after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
							},
							success: function(msg) {
								$("#wait").remove();			
								$("#kenaikankelulusanload").html(msg);			
							}
						});
					});
				});
				</script>