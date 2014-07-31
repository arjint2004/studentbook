<script type="text/javascript" src="<?=$this->config->item('js').'passwordstreng.js';?>" charset="utf-8"></script>	
<script>
    $(function(){
	<? if(isset($_POST['kabupaten'])){?>
	    $.post("<?=site_url('sos/sekolah/get_kota')?>",{ id : $('select#provinsi').val()  },
             function(data){
                var select ="<option value=''>Pilih Kabupaten</option>";
                var selected ="";
				var idkab=parseInt(<?=$_POST['kabupaten']?>);
                $.each( data, function(i, n){
					//alert(n.IDkota);
					if(idkab==n.IDkota){ selected='selected';}else{selected='';}
					select = select + '<option '+selected+' value="' + n.IDkota + '">' + n.NmKota + '</option>';
				})
                $("#kabupaten").html(select);
				
            }, "json");
		<? } ?>
		
        $("#provinsi").live("change",function(){
          var provinsi = $("#provinsi option:selected").val();
          $.post("<?=site_url('sos/sekolah/get_kota')?>",{ id : $(this).val()  },
             function(data){
                var select ="";
                $.each( data, function(i, n){
                  select = select + '<option value="' + n.IDkota + '">' + n.NmKota + '</option>';
              })
                $("#kabupaten").html(select);
                if(kabupaten) $("#kabupaten select").val(kabupaten);
            }, "json"
            );
      })
	  
        $("#email_sk").live("blur",function(){
			var self = $(this);
			$.ajax({
					type: "POST",
					data: 'username='+$(self).val(),
					url: '<?=base_url()?>homepage/cekusername',
					beforeSend: function() {
						$(self).after("<img id='wait' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
					},
					success: function(msg) {
						$("#wait").remove();
						if(msg>0){
							$('span#cekusername').remove();
							$(self).after('<span id="cekusername" style="color:red;">Email sudah terdaftar</span>');
							$(self).val('');
							$(self).focus();
						}else{
							$('span#cekusername').remove();
						}
						
					}
			});
			return false;
        })
		
        $("select#jenjang").live("change",function(){
			$("input#bentuk").val($(this).find(":selected").text());
        }) ;
		
		$("#password").live("keyup",function(e){
			e.stopImmediatePropagation();
			//checkPassword($(this).val());
			runPassword($(this).val(), $(this));
		});
		/*$("#passwordk").live("blur",function(e){
			e.stopImmediatePropagation();
			var sl=$("#passwordk");
			$('#cekpass').remove();
			if($(this).val() != $(this).parent('div').parent('div').prev().children('div').next().children('input').val()){
				$(this).after('<div style="font-size: 11px; color: red; float: left; width: 100%; margin: 5px 0px 0px;" id="cekpass">*) Password harus sama</div>');
				$(this).val('');
				$(this).focus();
			}
		});*/
    });
</script>
<style>
    .error {
        font-size: small;
        color: red;
    }
    #sp3{
        margin-top: 22px;
    } 
    .span3{
        margin-top: 17px;
    }
</style>


        
            <!-- **Content Full Width** -->
            <div class="content content-full-width">
                <h4>Gratis Selamanya!</h4>
                <p>
                    Pendaftar harus atas nama institusi sekolah secara resmi dengan
                    memasukkan data yang lengkap dan benar ke dalam form di bawah ini.
                    Kami akan melakukan verifikasi atas data yang Anda masukkan sebelum
                    melakukan approval atas pendaftaran Anda.
                </p>
				<!--<h2 style="margin-top:20px;margin-bottom:0;">LANGKAH 1</h2>-->
                <div class="hr"></div>
                <form method="POST" action="<?=site_url('sekolah/daftar_sekolah')?>">
                    <div class="row-fluid">
                        <div class="span3" id="sp3">
                            Jenjang Sekolah
                        </div>
                        <div class="span9">
                            <?=jejnjangoption('id="jenjang"')?>
							<input type="hidden" id="bentuk" name="bentuk" value="" />
							<br />
							<?=form_error('jenjang','<span class="error">','</span>')?>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span3">
                            Nama Sekolah
                        </div>
                        <div class="span9">
                            <input type="text" name="sekolah" value="<?=set_value('sekolah')?>"/>
                            <?=form_error('sekolah','<span class="error">','</span>')?>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span3">
                            Alamat Sekolah
                        </div>
                        <div class="span9">
                            <input type="text" name="alamat" value="<?=set_value('alamat')?>"/>
                            <?=form_error('alamat','<span class="error">','</span>')?>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span3">
                            Provinsi 
                        </div>
                        <div class="span9">
                            <?php
                                if(!empty($provinsi)) {
                                    echo '<select name="provinsi" id="provinsi">';
									echo '<option value="">Pilih Provinsi</option>';
                                    foreach($provinsi as $pro) {
										if($_POST['provinsi']==$pro->IDprov){$sl='selected';}else{$sl='';}
                                        echo '<option '.$sl.' value="'.$pro->IDprov.'">'.$pro->NmProv.'</option>';
                                    }
                                    echo '</select>';
                                }
                            ?>
							<br />
							<?=form_error('provinsi','<span class="error">','</span>')?>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span3">
                            Kabupaten / Kota
                        </div>
                        <div class="span9">
                            <select name="kabupaten" id="kabupaten">
                                <option value="">Pilih Kabupaten</option>
                            </select>
							<br />
                            <?=form_error('kabupaten','<span class="error">','</span>')?>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span3">
                            Nomor Telepon Sekolah
                        </div>
                        <div class="span9">
                            <input type="text" name="telp" value="<?=set_value('telp')?>"/>
                            <?=form_error('telp','<span class="error">','</span>')?>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span3">
                            Nama Pendaftar
                        </div>
                        <div class="span9">
                            <input type="text" name="nama_pendaftar" value="<?=set_value('nama_pendaftar')?>"/>
                            <?=form_error('nama_pendaftar','<span class="error">','</span>')?>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span3">
                            Nomor Telepon Pendaftar
                        </div>
                        <div class="span9">
                            <input type="text" name="selular" value="<?=set_value('selular')?>"/>
                            <?=form_error('selular','<span class="error">','</span>')?>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span3">
                           Email Pendaftar
                        </div>
                        <div class="span9">
                            <input type="text" class="email" name="email_pendaftar" value="<?=set_value('email_pendaftar')?>"/>
                            <?=form_error('email_pendaftar','<span class="error">','</span>')?>
                        </div>
                    </div>
                    <!--<div class="row-fluid">
                        <div class="span3">
                            Username
                        </div>
                        <div class="span9">
                            <input type="text" name="username" value="<?//=set_value('username')?>"/>
                            <?//=form_error('username','<span class="error">','</span>')?>
                        </div>
                    </div>-->
                    <div class="row-fluid">
                        <div class="span3">
                            Email Sekolah
                        </div>
                        <div class="span9">
                            <input type="text" class="email" placeholder="Email Sekolah akan dipakai sebagai username" id="email_sk" name="email_sk" value="<?=set_value('email_sk')?>"/>
							
                            <?=form_error('email_sk','<span class="error">','</span>')?>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span3">
                            Password
                        </div>
                        <div class="span9">
                            <input type="password" name="password" id="password" value="<?=set_value('password')?>"/>
                            <?=form_error('password','<span class="error">','</span>')?>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span3">
                            Konfirmasi Password
                        </div>
                        <div class="span9">
                            <input type="password" name="konfirmasi" id="passwordk" value="<?=set_value('konfirmasi')?>"/>
                            <?=form_error('konfirmasi','<span class="error">','</span>')?>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span3">
                            
                        </div>
                        <div class="span9">
                            <input type="submit" name="submit" value="Daftar Sekarang"/>
                        </div>
                    </div>
                </form>
                <div class="clear"> </div>
            </div> <!-- **Content Full Width - End** -->   	
