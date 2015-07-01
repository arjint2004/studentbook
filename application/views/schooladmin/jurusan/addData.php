				<script>
				$(document).ready(function(){
				
					$("#jurusanform").each(function(){
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
					
					$("#jurusanform").submit(function(e){
					$frm = $(this);
					$nama = $frm.find('*[name=nama]').val();
					if($frm.find('*[name=nama]').is('.valid')) {
						$.ajax({
							type: "POST",
							data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&'+$(this).serialize(),
							url: $(this).attr('action'),
							beforeSend: function() {
								
							},
							success: function(msg) {
								$(".addaccount").remove();
									$.ajax({
										type: "POST",
										data: "<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&ajax=1",
										url: '<?php echo base_url(); ?>admin/jurusan/listData',
										beforeSend: function() {
											$("#listkelas").html("<img src='<?=$this->config->item('images').'loading.png';?>' />");
										},
										success: function(msg) {
											$("#listkelas").html(msg);
											$('div#step').load('<?=site_url()?>admin/schooladmin/completeregoption');
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
<form action="<? echo base_url();?>admin/jurusan/adddata" id="jurusanform" name="jurusanform" method="post" >
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
	<div class="addaccountclose" onclick="$('.addaccount').remove();"></div>
	<h3> Tambah data Jurusan </h3>
		<table class="adddata">
			<tr>
				<td width="30%" class='title'>Nama Jurusan</td>
				<td width="1">:</td>
				<td><input type="text" name="nama" size="30" /></td>
			</tr>
			<tr>
				<td class="title">Keterangan</td>
				<td>:</td>
				<td>
					<textarea cols="40" name="keterangan" rows="5"></textarea>
				</td>
			</tr>
			
			<tr>
				<td class="title" colspan="3"><input type="submit" name="simpan" value="Simpan"/> <div class="error-container" style="display:none;"> Field harus di isi!  </div></td>
			</tr>
		</table>
		
	<input type="hidden" name="addjurusan" value="1"/> 
	<input type="hidden" name="ajax" value="1"/>
	</form>
	
</div>