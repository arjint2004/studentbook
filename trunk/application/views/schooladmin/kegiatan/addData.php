				<script>
				$(document).ready(function(){
				
					$("#kegiatanform").each(function(){
					$container = $(this).find("div.error-container");
					//Validate Starts
					$(this).validate({
						onfocusout: function(element) {	$(element).valid();	},
						errorContainer: $container,
						rules:{
						  nama:{required:true,minlength:3,notEqual:'Nama'}
						  /*,message:{required:true,minlength:10}*/
						}
					});//Validate End
				
					});
					
					$("#kegiatanform").submit(function(e){
					$frm = $(this);
					$nama = $frm.find('*[name=nama]').val();
					if($frm.find('*[name=nama]').is('.valid')) {
						$.ajax({
							type: "POST",
							data: $(this).serialize(),
							url: $(this).attr('action'),
							beforeSend: function() {
								$("input#simpan").after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
							},
							success: function(msg) {
								$(".addaccount").remove();
									$.ajax({
										type: "POST",
										data: "ajax=1",
										url: '<?php echo base_url(); ?>admin/kegiatan/listData',
										beforeSend: function() {
											$("input#simpan").after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
										},
										success: function(msg) {
											$("img#wait").remove();
											$.ajax({
												type: "POST",
												data: "ajax=1",
												url: base_url+'admin/kegiatan/listData',
												beforeSend: function() {
													$("#listkelasloading").html("<img src='"+config_images+"loading.png' />");
												},
												success: function(msg) {
													$("#listkelasloading").html("");
													$("#listkelas").html(msg);			
												}
											});
										}
									});			
							}
						});
						return false;
					}
					return false;
					});//Submit End
				});
				</script>
<div class="addaccount">
<form action="<? echo base_url();?>admin/kegiatan/adddata" id="kegiatanform" name="kegiatanform" method="post" >
	<div class="addaccountclose" onclick="$('.addaccount').remove();"></div>
	<h3> Tambah Data Pengembangan Diri </h3>
		<table class="adddata">
			<tr>
				<td width="30%" class='title'>Nama Pengembangan Diri</td>
				<td width="1">:</td>
				<td><input type="text" name="nama" size="30" /></td>
			</tr>
			<tr>
				<td class="title" colspan="3"><input type="submit" name="simpan" id="simpan" value="Simpan"/> <div class="error-container" style="display:none;"> Field harus di isi!  </div></td>
			</tr>
		</table>
		
	<input type="hidden" name="addkegiatan" value="1"/> 
	<input type="hidden" name="ajax" value="1"/>
	</form>
	
</div>