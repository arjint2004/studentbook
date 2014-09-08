<script>
		$(document).ready(function() {
			         $(".modalbuatrpp").fancybox({
                        'showCloseButton'  : true,
                        'autoScale'  : true,
                        'height'  : 768,
                        'onComplete'  : function() {
						 var offset=$('#buatrpp').offset();
						 $('#fancybox-wrap').css('top',offset.top+'px !important');
                        
                       }
                     });
			/*var $window = $(window), $menu = $("#buttonasbin");
			$window.bind('scroll', function() {
				var pos = +$window.scrollTop();
				if (pos > 584) {
					$menu.addClass("fixed");
				}
				else {
					$menu.removeClass("fixed");
				}
			}).trigger("scroll");*/
			
			$('#smsnotifikasi').load('<?=base_url('akademik/sms')?>');
			$('#tababsensi').bind('click', function() {
				$.ajax({
					type: "GET",
					data: '',
					url: '<?=base_url('akademik/absensi')?>',
					beforeSend: function() {
						$('#tababsensi').append("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
					},
					success: function(msg) {
						$("#wait").remove();			
						$("#absensi").html(msg);			
					}
				});
			});
			$('#tabarekapbsensi').bind('click', function() {
				$.ajax({
					type: "GET",
					data: '',
					url: '<?=base_url('akademik/absensi/rekapabsensi')?>',
					beforeSend: function() {
						$('#tabarekapbsensi').append("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
					},
					success: function(msg) {
						$("#wait").remove();			
						$("#rekapbsensi").html(msg);			
					}
				});
			});
			
			$('#jurnaltab').bind('click', function() {
				$.ajax({
					type: "GET",
					data: '',
					url: '<?=base_url('akademik/jurnalwali/addjurnal')?>',
					beforeSend: function() {
						$('#jurnaltab').append("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
					},
					success: function(msg) {
						$("#wait").remove();			
						$("#jurnal").html(msg);			
					}
				});
			});
			$('#raporttab').bind('click', function() {
				if($('select#kelasraport').val()==''){
					$('select#kelasraport').css('border','1px solid red');
					return false;
				}else{$('select#kelasraport').css('border','none');}
				if($('select#siswaraport').val()==''){
					$('select#siswaraport').css('border','1px solid red');
					return false;				
				}else{$('select#siswaraport').css('border','none');}
				$.ajax({
					type: "GET",
					data: '',
					url: '<?=base_url('akademik/raport/index')?>/'+$('select#siswaraport').val(),
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
				if($('select#kelasraport').val()==''){
					$('select#kelasraport').css('border','1px solid red');
					return false;
				}else{$('select#kelasraport').css('border','none');}
				if($('select#siswaraport').val()==''){
					$('select#siswaraport').css('border','1px solid red');
					return false;				
				}else{$('select#siswaraport').css('border','none');}
				$.ajax({
					type: "GET",
					data: '',
					url: '<?=base_url('akademik/raport/ekstrakurikuler')?>/'+$('select#siswaraport').val(),
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
				if($('select#kelasraport').val()==''){
					$('select#kelasraport').css('border','1px solid red');
					return false;
				}else{$('select#kelasraport').css('border','none');}
				if($('select#siswaraport').val()==''){
					$('select#siswaraport').css('border','1px solid red');
					return false;				
				}else{$('select#siswaraport').css('border','none');}
				$.ajax({
					type: "GET",
					data: '',
					url: '<?=base_url('akademik/raport/kegiatan')?>/'+$('select#siswaraport').val(),
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
				if($('select#kelasraport').val()==''){
					$('select#kelasraport').css('border','1px solid red');
					return false;
				}else{$('select#kelasraport').css('border','none');}
				if($('select#siswaraport').val()==''){
					$('select#siswaraport').css('border','1px solid red');
					return false;				
				}else{$('select#siswaraport').css('border','none');}
				$.ajax({
					type: "GET",
					data: '',
					url: '<?=base_url('akademik/raport/kepribadian')?>/'+$('select#siswaraport').val(),
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
				if($('select#kelasraport').val()==''){
					$('select#kelasraport').css('border','1px solid red');
					return false;
				}else{$('select#kelasraport').css('border','none');}
				if($('select#siswaraport').val()==''){
					$('select#siswaraport').css('border','1px solid red');
					return false;				
				}else{$('select#siswaraport').css('border','none');}
				$.ajax({
					type: "GET",
					data: '',
					url: '<?=base_url('akademik/raport/prestasi')?>/'+$('select#siswaraport').val(),
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
				if($('select#kelasraport').val()==''){
					$('select#kelasraport').css('border','1px solid red');
					return false;
				}else{$('select#kelasraport').css('border','none');}
				if($('select#siswaraport').val()==''){
					$('select#siswaraport').css('border','1px solid red');
					return false;				
				}else{$('select#siswaraport').css('border','none');}
				$.ajax({
					type: "GET",
					data: '',
					url: '<?=base_url('akademik/raport/absensi')?>/'+$('select#siswaraport').val(),
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
				if($('select#kelasraport').val()==''){
					$('select#kelasraport').css('border','1px solid red');
					return false;
				}else{$('select#kelasraport').css('border','none');}
				if($('select#siswaraport').val()==''){
					$('select#siswaraport').css('border','1px solid red');
					return false;				
				}else{$('select#siswaraport').css('border','none');}
				$.ajax({
					type: "GET",
					data: '',
					url: '<?=base_url('akademik/raport/keterangan')?>/'+$('select#siswaraport').val()+'/'+$('select#kelasraport').val(),
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
				if($('select#kelasraport').val()==''){
					$('select#kelasraport').css('border','1px solid red');
					return false;
				}else{$('select#kelasraport').css('border','none');}
				if($('select#siswaraport').val()==''){
					$('select#siswaraport').css('border','1px solid red');
					return false;				
				}else{$('select#siswaraport').css('border','none');}
				$.ajax({
					type: "GET",
					data: '',
					url: '<?=base_url('akademik/raport/catatan')?>/'+$('select#siswaraport').val(),
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
					data: 'id_kelas='+$(obj).val(),
					url: '<?=base_url('akademik/raport/setkenaikan')?>/'+$(obj).val(),
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
				
		$(document).ready(function() { 
		
					$('#tabpertlist').bind('click', function() {
						var thisobj=$(this);
						$($('div#tabpertlistcnt').children('a')).each(function(i) {
								$(this).parent('div').children('a').attr('class', 'readmore');
								lastreadmore=$(this);
						});
						
						
						$('div#subject'+$(thisobj).attr('tab')).remove();	
						$(lastreadmore).parent('div').append('<div class="" id="subject'+$(thisobj).attr('tab')+'"></div>');

						$.ajax({
									type: 'GET',
									url: '<? echo base_url();?>akademik/instrumen/pembelajaranlist',
									data: '',
									beforeSend: function() {
										$(thisobj).append("<img style='float: right; position: relative; right: 19px; top: 2px;' id='wait"+$(thisobj).attr('id')+"' src='<?=$this->config->item('images').'loading.png';?>' />");
									},
									success: function(data) {
										$('#wait'+$(thisobj).attr('id')+'').remove();
										$('#nilai').html('');
										$('#subject'+$(thisobj).attr('tab')).html(data);
										$('a#datapertemuan').attr('class','readmore selected');
									}
							});
							return false;
					});
					
					var lastreadmore;
					
						$('div.tabs-frame-content').each(function(i) {
							$(this).append('<br id="brsubject" class="clear" /> ');
						});
						$('div#nilaitab').append('<br id="brsubject" class="clear" /> ');
					$('.readmore').bind('click', function() {
						var thisobj=$(this);
						$($(this).parent('div').children('a')).each(function(i) {
								$(this).parent('div').children('a').attr('class', 'readmore');
								lastreadmore=$(this);
						});
						
						
						$('div#subject'+$(thisobj).attr('tab')).remove();	
						$(lastreadmore).parent('div').append('<div class="" id="subject'+$(thisobj).attr('tab')+'"></div>');
						
						$($(thisobj).parent('div').children('a')).each(function(i) {
							$(this).parent('div').children('a').attr('class', 'readmore');
							lastreadmore=$(this);
						});
						$(thisobj).attr('class','readmore selected');
						
						switch($(thisobj).attr('tab'))
							{
							//Area Akademik
							case 'evaluasi':
								var url='';
								if($(this).attr('id')=='catatanguru'){
									url='<? echo base_url();?>akademik/catatanguru/index';
								}else if($(this).attr('id')=='risettindakankelas'){
									url='<? echo base_url();?>akademik/risettindakankelas/index';
								}else if($(this).attr('id')=='addpertemuan'){
									url='<? echo base_url();?>akademik/instrumen/addpertemuan';
								}else if($(this).attr('id')=='datapertemuan'){
									url='<? echo base_url();?>akademik/instrumen/pembelajaranlist';
								}
								ajax(url,thisobj);
								return false;
							break;
							
							case 'perencanaan':
								var url='';
								if($(this).attr('id')=='pembelajaran'){
									url='<? echo base_url();?>akademik/perencanaan/pembelajaran';
								}else if($(this).attr('id')=='timelinepembelajaran'){
									url='<? echo base_url();?>akademik/perencanaan/timelinepembelajaran';
								}else if($(this).attr('id')=='pertemuan'){
									url='<? echo base_url();?>akademik/perencanaan/pertemuan';
								}else if($(this).attr('id')=='buatrpp'){
									return false;
								}
								ajax(url,thisobj); 
								return false;
							break;
							case 'administrasi':
								var url='<? echo base_url();?>akademik/administrasi/admin';
								$.ajax({
										type: 'POST',
										url: url,
										data: 'jenis='+$(this).attr('id'),
										beforeSend: function() {
											$(thisobj).append("<img style='float: right; position: absolute; top: -5px; right: 3px;' id='wait"+$(thisobj).attr('id')+"' src='<?=$this->config->item('images').'loaderhover.gif';?>' />");
										},
										success: function(data) {
											$('#wait'+$(thisobj).attr('id')+'').remove();
											$('#nilai').html('');
											$('#subject'+$(thisobj).attr('tab')).html(data);
											$($(thisobj).parent('div').children('a')).each(function(i) {
													$(this).parent('div').children('a').attr('class', 'readmore');
													lastreadmore=$(this);
											});
											$(thisobj).attr('class','readmore selected');
										}
								});								
								//ajax(url,thisobj);
								return false;
							break;
							case 'nilai':
								if($(this).attr('id')=='rekapitulasinilai'){
									var url='<? echo base_url();?>akademik/rekapnilai/index';
									ajax(url,thisobj);
									return false;
								}
								if($(this).attr('id')=='psikomotorik' || $(this).attr('id')=='afektif'){
									var url='<? echo base_url();?>akademik/nilai/psikoafektif/'+$(this).attr('id');
									ajax(url,thisobj);
									return false;
								}
								$.ajax({
									type: 'GET',
									url: '<? echo base_url();?>akademik/nilai/listSubject/'+$(this).attr('id'),
									data: '',
									beforeSend: function() {
										
										$(thisobj).append("<img style='float: right; position: absolute; top: -5px; right: 3px;' id='wait' src='<?=$this->config->item('images').'loaderhover.gif';?>' />");
									},
									success: function(data) {
										$('#wait').remove();
										$('#nilai').html('');
										$('#subject'+$(thisobj).attr('tab')).html(data);
										$($(thisobj).parent('div').children('a')).each(function(i) {
												$(this).parent('div').children('a').attr('class', 'readmore');
												lastreadmore=$(this);
										});
										$(thisobj).attr('class','readmore selected');
										//$('#subject'+$(thisobj).attr('tab')).scrollintoview({ speed:'1100'});
									}
								});
								return false;
							break;
							  
							case 'otentik':
								$.ajax({
										type: 'GET',
										url: '<? echo base_url();?>akademik/nilaiotentik/pranilai/'+$(this).attr('id'),
										data: '',
										beforeSend: function() {
											$(thisobj).append("<img style='float: right; position: absolute; top: -5px; right: 3px;' id='wait' src='<?=$this->config->item('images').'loaderhover.gif';?>' />");
										},
										success: function(data) {
											$('#wait').remove();
											$('#nilai').html('');
											$('#subject'+$(thisobj).attr('tab')).html(data);
											$($(thisobj).parent('div').children('a')).each(function(i) {
													$(this).parent('div').children('a').attr('class', 'readmore');
													lastreadmore=$(this);
											});
											$(thisobj).attr('class','readmore selected');
											//$('#subject'+$(thisobj).attr('tab')).scrollintoview({ speed:'1100'});
										}
								});
									return false;
							break;
							  
							case 'pembelajaran':
								var url='';
								if($(this).attr('id')=='materi_pelajaran'){
									url='<? echo base_url();?>akademik/materi';
								}else if($(this).attr('id')=='daftar_pr'){
									url='<? echo base_url();?>akademik/kirimpr/daftarpr';
								}else if($(this).attr('id')=='daftar_tugas'){
									url='<? echo base_url();?>akademik/kirimtugas/daftartugas';
								}
								ajax(url,thisobj);
								return false;
							break;
							  
							case 'ujian':
								var url='';
								if($(this).attr('id')=='daftar_harian'){
									url='<? echo base_url();?>akademik/kirimharian/daftarharian';
								}else if($(this).attr('id')=='daftar_uas'){
									url='<? echo base_url();?>akademik/kirimuas/daftaruas';
								}else if($(this).attr('id')=='daftar_uts'){
									url='<? echo base_url();?>akademik/kirimuts/daftaruts';
								}
								ajax(url,thisobj);
								return false;
							break;
							
							//AREA WALI KELAS
							case 'wali_input':
								var url='';
								if($(this).attr('id')=='kepribadian'){
									url='<? echo base_url();?>akademik/kepribadian/index';
								}else if($(this).attr('id')=='prestasi'){
									url='<? echo base_url();?>akademik/prestasi/index';
								}else if($(this).attr('id')=='lain_lain'){
									url='<? echo base_url();?>akademik/lain_lain/index';
								}
								ajax(url,thisobj);
								return false;
							break;
							case 'wali_preview':
								var url='';
								if($(this).attr('id')=='ekstrakurikuler'){
									url='<? echo base_url();?>akademik/nilaiekstrakurikuler/index';
								}else if($(this).attr('id')=='kegiatan_sekolah'){
									url='<? echo base_url();?>akademik/nilaikegiatansekolah/index';
								}
								ajax(url,thisobj);
								return false;
							break;
							case 'wali_jurnal':
								var url='';
								if($(this).attr('id')=='daftar_jurnal'){
									url='<? echo base_url();?>akademik/jurnalwali/index';
								}else if($(this).attr('id')=='buat_jurnal'){
									url='<? echo base_url();?>akademik/jurnalwali/addjurnal';
								}
								ajax(url,thisobj);
								return false;
							break;
							
							default:
							  
							}
					});
					function ajax(url,thisobj){
							$.ajax({
									type: 'GET',
									url: url,
									data: '',
									beforeSend: function() {
										$(thisobj).append("<img style='float: right; position: absolute; top: -5px; right: 3px;' id='wait"+$(thisobj).attr('id')+"' src='<?=$this->config->item('images').'loaderhover.gif';?>' />");
									},
									success: function(data) {
										$('#wait'+$(thisobj).attr('id')+'').remove();
										$('#nilai').html('');
										$('#subject'+$(thisobj).attr('tab')).html(data);
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
					$("select#kelasraport").change(function(e){
							$.ajax({
								type: "POST",
								data: $("form#jurnalwaliform").serialize(),
								url: '<?=base_url()?>akademik/raport/getOptionSiswaByIdKelas/'+$(this).val(),
								beforeSend: function() {
									$("select#kelasraport").after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
									//$("#subjectlist table.tabelkelas tbody").html("");
								},
								success: function(msg) {
									$("#wait").remove();
									$("#siswaraport").html(msg);	
								}
							});
							return false;
					});//Submit End	
					$("select#siswaraport").change(function(e){
							$.ajax({
								type: "GET",
								data: '',
								url: '<?=base_url('akademik/raport/index')?>/'+$('select#siswaraport').val(),
								beforeSend: function() {
									$('#raporttab').append("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
								},
								success: function(msg) {
									$("#wait").remove();			
									$("#raport").html(msg);			
								}
							});
							return false;
					});//Submit End					
				});

					
			</script>