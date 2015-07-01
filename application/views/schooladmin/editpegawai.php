<script>
	$(document).ready(function(){
		$.validator.addMethod("notEqual", function(value, element, param) {
		  return this.optional(element) || value != param;
		}, "Please choose a value!");

		
		$(".edituseraccount").each(function(){
			$container = $(this).next("div.error-container");
			//Validate Starts
			$(this).validate({
				onfocusout: function(element) {	$(element).valid();	},
				errorContainer: $container,
				rules:{
				  nama:{required:true,minlength:3,notEqual:'Nama'},
				  /*hp:{required:true,minlength:3,notEqual:'Hp'},
				  alamat:{required:true,minlength:3,notEqual:'Alamat'},*/
				  username:{required:true,notEqual:'Username'},
				  password:{required:true,minlength:3,notEqual:'Password'}
				  /*,message:{required:true,minlength:10}*/
				}
			});//Validate End

		});
		
		//Submit Starts		   
		$(".addaccountclose").click(function(){
			$(".addaccount").remove();
		});
		$(".edituseraccount").submit(function(e){
			var listtype='';
			$frm = $(this);
			$nama = $frm.find('*[name=nama]').val();
			/*$hp = $frm.find('*[name=hp]').val();
			$alamat = $frm.find('*[name=alamat]').val();*/
			$username = $frm.find('*[name=username]').val();
			$password = $frm.find('*[name=password]').val();

			if($frm.find('*[name=nama]').is('.valid') && $frm.find('*[name=username]').is('.valid') && $frm.find('*[name=password]').is('.valid') ) {
				$.ajax({
					type: "POST",
					data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&'+$(this).serialize(),
					url: $(this).attr('action'),
					beforeSend: function() {
						$("#ajax").html("<img src='<?=$this->config->item('images').'loading.png';?>' />");
					},
					success: function(msg) {
						$(".addaccount").remove();	
							$.ajax({
								type: "POST",
								data: "<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&ajax=1",
								url: '<?php echo base_url(); ?>admin/schooladmin/dataakun/guru/0',
								beforeSend: function() {
									$("#ajax").html("<img src='<?=$this->config->item('images').'loading.png';?>' />");
								},
								success: function(msg) {
									$("#ajax").html(msg);			
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
				<div class="addaccountclose"></div>
                    <h3> Edit data  </h3>
                     <div class="ajax_message"></div>
                     <form class="edituseraccount" action="<?php echo base_url(); ?>admin/schooladmin/editpegawai" method="post">
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                    	<p class="column one-third">
                            Nama :<input name="nama" type="text" class="required" placeholder="Nama"  value="<?=$dataedit[0]['nama']?>" />
                        </p>
                    	<p class="column one-third">
                           Hp : <input name="hp" type="text" placeholder="HP"  value="<?=$dataedit[0]['hp']?>" />
                        </p>
                    	<p class="column one-third">
                           Alamat:<textarea name="alamat"   placeholder="Alamat" ><?=$dataedit[0]['alamat']?></textarea>
                        </p>
                    	<p class="column one-third">
                            Username:<input name="username" type="text" class="required" placeholder="Username"  value="<?=$dataedit[0]['username']?>" />
                        </p>
                    	<p class="column one-third">
                            Password:<input name="password" type="text" class="required" placeholder="Password"  value="<?=$dataedit[0]['password']?>" />
                        </p>
                        <p>
                            <input name="save" type="hidden" value="Simpan"/>
                            <input name="id_pegawai" type="hidden" value="<?=$dataedit[0]['id']?>"/>
                            <input name="ajax" type="hidden" value="1"/>
                            <input name="submit" type="submit" value="Simpan" class="button small grey" />
                        </p>
                    </form>
                    <div class="error-container" style="display:none;"> Semua field harus di isi!  </div>
					</div>
            
	
            
