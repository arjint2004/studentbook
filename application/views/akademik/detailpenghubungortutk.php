<?=$this->load->view('akademik/mainakademik/topindex')?>					
				<script>
					$(document).ready(function(){

					$('.unsellall').click( function() {
						$('#idsiswalaporan option').attr('selected', false);
						//add_id_ortu();
					});
					
						$('.listlap').hide();
						$('#listlap').children('a').removeClass('current');
						$('.pengtk').show();
						$('#pengtk').children('a').addClass('current');
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
					
					$.ajax({
						type: "POST",
						data: 'id_kelas=<?=$this->session->userdata['user_authentication']['id_kelas_siswa_det_jenjang']?>',
						url: '<?=base_url('siswa/penghubungortutk/penghubungortulist/0')?>',
						beforeSend: function() {
						
						},
						success: function(msg) {
							$("#wait").remove();
							$('#listpenghub').html(msg);
						}
					});
				});
</script>
<?=$this->load->view('siswa/penghubungortutk/penghubungortu')?>	