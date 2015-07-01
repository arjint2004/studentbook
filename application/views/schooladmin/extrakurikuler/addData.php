				<script>
				$(document).ready(function(){
				
					$("#extrakurikulerform").each(function(){
					$container = $(this).find("div.error-container");
					//Validate Starts
					$(this).validate({
						onfocusout: function(element) {	$(element).valid();	},
						errorContainer: $container,
						rules:{
						  nama:{required:true,minlength:3,notEqual:'Nama'},
						  id_pegawai:{required:true,notEqual:'Pilih Guru Pengajar'}
						  /*,message:{required:true,minlength:10}*/
						}
					});//Validate End
				
					});
					
					$("#extrakurikulerform").submit(function(e){
					$frm = $(this);
					$nama = $frm.find('*[name=nama]').val();
					$id_pegawai = $frm.find('*[name=id_pegawai]').val();
					if($frm.find('*[name=nama]').is('.valid') && $frm.find('*[name=id_pegawai]').is('.valid')) {
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
										url: '<?php echo base_url(); ?>admin/extrakurikuler/listData',
										beforeSend: function() {
											$("#listkelas").html("<img src='<?=$this->config->item('images').'loading.png';?>' />");
										},
										success: function(msg) {
											$("#listkelas").html(msg);			
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
<form action="<? echo base_url();?>admin/extrakurikuler/adddata" id="extrakurikulerform" name="extrakurikulerform" method="post" >
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
	<div class="addaccountclose" onclick="$('.addaccount').remove();"></div>
	<h3> Tambah data extrakurikuler </h3>
		<table class="adddata">
			<tr>
				<td width="30%" class='title'>Nama extrakurikuler</td>
				<td width="1">:</td>
				<td><input type="text" name="nama" size="30" /></td>
			</tr>
			<tr>
				<td class="title">Pembina</td>
				<td>:</td>
				<td>
					<select name="id_pegawai" id="id_pegawai">
						<option value="" >Pilih Guru Pengajar</option>
						<? foreach($guru as $dataguru){?>
						<option value="<?=$dataguru['id']?>" ><?=$dataguru['nama']?></option>
						<? } ?>
					</select>
					<div style="font-size:11px;">Jika Pembina belum ada. Bisa diisikan lewat menu <a href="<?=base_url('admin/schooladmin/dataakun')?>">"data akun"</a> dengan klik link <i>Atur</i> pada setiap baris </div>
				</td>
			</tr>
			<tr>
				<td class="title">Aktif</td>
				<td>:</td>
				<td align="left">
					<input style="float:left;" type="checkbox" name="aktif" value="1" />
				</td>
			</tr>
			
			<tr>
				<td class="title" colspan="3"><input type="submit" name="simpan" value="Simpan"/> <div class="error-container" style="display:none;"> Field harus di isi!  </div></td>
			</tr>
		</table>
		
	<input type="hidden" name="addextrakurikuler" value="1"/> 
	<input type="hidden" name="ajax" value="1"/>
	</form>
	
</div>