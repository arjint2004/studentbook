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
				  nama:{required:true,notEqual:'Nama'},
				  NmOrtu:{required:true,notEqual:'Nama Orang Tua'},
				  kelas:{required:true,notEqual:'Pilih Kelas'},
				  hp:{required:true,notEqual:''},
				  kelas:{required:true,notEqual:'Pilih Kelas'}
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
			$hp = $frm.find('*[name=hp]').val();
			$kelas = $frm.find('*[name=kelas]').val();
			<?if($otoritas=='siswa'){?>
			if($frm.find('*[name=nama]').is('.valid') && $frm.find('*[name=NmOrtu]').is('.valid') && $frm.find('*[name=hp]').is('.valid') && $frm.find('*[name=kelas]').is('.valid')) {
				$.ajax({
					type: "POST",
					data: $(this).serialize(),
					url: $(this).attr('action'),
					beforeSend: function() {
						$("#adduser").html("<img src='<?=$this->config->item('images').'loading.png';?>' />");
					},
					success: function(msg) {
						$(".addaccount").remove();	
							$.ajax({
								type: "POST",
								data: "ajax=1&id_kelas="+$frm.find('*[name=kelas]').val(),
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
				<? //pr($siswa);?>
				<div class="addaccount">
				<div class="addaccountclose"></div>
                    <h3> Edit data <?=$otoritas?> </h3>
                     <div class="ajax_message"></div>
                     <form class="adduseraccount" action="<?php echo base_url(); ?>admin/schooladmin/editsiswa/<?=$otoritas?>" method="post">
                    	<p class="column one-third">Nama
                            <input name="nama" type="text" class="required"   value="<?=$siswa[0]['nama']?>" />
                        </p>
						<?if($otoritas=='siswa'){?>
                        <p class="column one-third">Kelas
                            		<select name="kelas" id="kelas" class="valid" style="width:210px">
										<option value="" >Pilih Kelas</option>
										<? foreach($kelas as $datakelas){?>
											<option value="<?=$datakelas['id']?>" <? if($siswa[0]['id_kelas']==$datakelas['id']){echo 'selected';}?> ><?=$datakelas['nama']?></option>
										<? } ?>
									</select>
                        </p>
                        <p class="column one-third">Nama Orang Tua
                            <input name="NmOrtu" type="text" value="<?=$siswa[0]['NmOrtu']?>" />
                        </p>
                        <p class="column one-third ">No HP Orang Tua
						<? if($siswa[0]['hportu']==''){$hportu='+62';}else{$hportu=$siswa[0]['hportu'];};?>
                            <input name="hp" type="text" value="<?=$hportu?>" />
                        </p>
						<? } ?>
                        <p >
                            <input name="save" type="hidden" value="Simpan"/>
                            <input name="id_siswa" type="hidden" value="<?=$siswa[0]['id']?>"/>
                            <input name="id_siswa_det_jenjang" type="hidden" value="<?=$siswa[0]['id_siswa_det_jenjang']?>"/>
                            <input name="ajax" type="hidden" value="1"/>
                            <input name="listtype" type="hidden" value="<?=$otoritas?>"/>
                            <input name="submit" type="submit" value="Simpan" class="button small grey" />
                        </p>
                    </form>
                    <div class="error-container" style="display:none;"> Semua field harus di isi!  </div>
					</div>
            
	
            
