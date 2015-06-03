<script>
	$(document).ready(function(){
		$.validator.addMethod("notEqual", function(value, element, param) {
		  return this.optional(element) || value != param;
		}, "Please choose a value!");

		
		$(".adduseraccount").each(function(){
			$container = $(this).next("div.error-container");
			//Validate Starts
			$(this).validate({
				onfocusout: function(element) {	$(element).valid();	},
				errorContainer: $container,
				rules:{
				  nama:{required:true,minlength:3,notEqual:'Nama'},
				  NmOrtu:{required:true,minlength:3,notEqual:'Nama Orang Tua'},
				  kelas:{required:true,notEqual:'Pilih Kelas'},
				  nis:{required:true,minlength:3,notEqual:'NIS'}
				  /*,message:{required:true,minlength:10}*/
				}
			});//Validate End

		});
		
		//Submit Starts		   
		$(".addaccountclose").click(function(){
			$(".addaccount").remove();
		});
		$(".adduseraccount").submit(function(e){
			var listtype='<?=$otoritas?>';
			$frm = $(this);
			$nama = $frm.find('*[name=nama]').val();
			$NmOrtu = $frm.find('*[name=NmOrtu]').val();
			$nis = $frm.find('*[name=nis]').val();
			<?if($otoritas=='siswa'){?>
			if($frm.find('*[name=nama]').is('.valid') && $frm.find('*[name=NmOrtu]').is('.valid') && $frm.find('*[name=nis]').is('.valid') && $frm.find('*[name=kelas]').is('.valid')) {
				$.ajax({
					type: "POST",
					data: $(this).serialize(),
					url: $(this).attr('action'),
					beforeSend: function() {
						$("#ajax"+listtype+"").html("<img id='waitaddsiswa' src='<?=$this->config->item('images').'loading.png';?>' />");
					},
					success: function(msg) {
						$("img#waitaddsiswa").remove();	
							$.ajax({
								type: "POST",
								data: "ajax=1&id_kelas="+$('select#kelassiswa').val(),
								url: '<?php echo base_url(); ?>admin/schooladmin/dataakun/'+listtype+'/0',
								beforeSend: function() {
									$("#ajax"+listtype+"").html("<img src='<?=$this->config->item('images').'loading.png';?>' />");
								},
								success: function(msg) {
									$("#ajax"+listtype+"").html(msg);					
								}
							});
						$(".addaccount").remove();				
					}
				});
				return false;
			}
			<? }else{ ?>
			if($frm.find('*[name=nama]').is('.valid')) {
				$.ajax({
					type: "POST",
					data: $(this).serialize(),
					url: $(this).attr('action'),
					beforeSend: function() {
						$("#ajax"+listtype+"").html("<img src='<?=$this->config->item('images').'loading.png';?>' />");
					},
					success: function(msg) {
						$(".addaccount").remove();	
							$.ajax({
								type: "POST",
								data: "ajax=1",
								url: '<?php echo base_url(); ?>admin/schooladmin/dataakun/'+listtype+'/0',
								beforeSend: function() {
									$("#ajax"+listtype+"").html("<img src='<?=$this->config->item('images').'loading.png';?>' />");
								},
								success: function(msg) {
									$("#ajax"+listtype+"").html(msg);			
								}
							});
					}
				});
				return false;
			}			
			<? } ?>
			return false;
		});//Submit End
		
	});
</script>
				<div class="addaccount">
				<div class="addaccountclose"></div>
                    <h3> Tambah data <?=$otoritas?> </h3>
                     <div class="ajax_message"></div>
                     <form class="adduseraccount" action="<?php echo base_url(); ?>admin/schooladmin/adduser/<?=$otoritas?>" method="post">
                    	<p class="column one-third">
                            <input name="nama" type="text" class="required" onblur="this.value=(this.value=='') ? 'Nama' : this.value;" onfocus="this.value=(this.value=='Nama') ? '' : this.value;"  value="Nama" />
                        </p>
						<?if($otoritas=='siswa'){?>
                        <p class="column one-third">
                            		<select name="kelas" id="kelassiswa" class="valid" style="width:210px">
										<option value="" >Pilih Kelas</option>
										<? foreach($kelas as $datakelas){?>
											<option value="<?=$datakelas['id']?>" ><?=$datakelas['nama']?></option>
										<? } ?>
									</select>
                        </p>
                        <p class="column one-third">
                            <input name="NmOrtu" type="text" onblur="this.value=(this.value=='') ? 'Nama Orang Tua' : this.value;" onfocus="this.value=(this.value=='Nama Orang Tua') ? '' : this.value;" value="Nama Orang Tua" />
                        </p>
                        <p class="column one-third ">
                            <input name="nis" type="text" onblur="this.value=(this.value=='') ? 'NIS' : this.value;" onfocus="this.value=(this.value=='NIS') ? '' : this.value;" value="NIS" />
                        </p>
                        <p class="column one-third ">
                            <input name="hp" type="text" onblur="this.value=(this.value=='') ? 'No HP Ortu' : this.value;" onfocus="this.value=(this.value=='No HP Ortu') ? '' : this.value;" value="No HP Ortu" />
                        </p>
						<? } ?>
                        <p >
                            <input name="save" type="hidden" value="Simpan"/>
                            <input name="ajax" type="hidden" value="1"/>
                            <input name="listtype" type="hidden" value="<?=$otoritas?>"/>
                            <input name="submit" type="submit" value="Simpan" id="adduserloadsiswa" class="button small grey" />
                        </p>
                    </form>
                    <div class="error-container" style="display:none;"> Semua field harus di isi!  </div>
					</div>
            
	
            
