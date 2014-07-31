<script type="text/javascript" src="<?=$this->config->item('js').'ultimate-custom.js';?>" charset="utf-8"></script>
<script type="text/javascript" src="<?=$this->config->item('js').'passwordstreng.js';?>" charset="utf-8"></script>
<script>
$(document).ready(function(){
		$("#username").live("blur",function(e){
			e.stopImmediatePropagation();
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
							$('div#cekusername').remove();
							$(self).after('<div style="font-size: 11px; color: red; float: left; width: 100%; margin: 5px 0px 0px;" id="cekusername">*) Username sudah terdaftar</div>');
							$(self).val('');
							$(self).focus();
						}else{
							$('div#cekusername').remove();
						}
						
					}
			});
			return false;
        });
		
		$("#password").live("keyup",function(e){
			e.stopImmediatePropagation();
			//checkPassword($(this).val());
			runPassword($(this).val(), $(this));
		});
		$("#passwordk").live("blur",function(e){
			e.stopImmediatePropagation();
			var sl=$("#passwordk");
			$('#cekpass').remove();
			//alert($(this).val()+'=='+$(this).parent('td').parent('tr').prev().children('td#pwd').children('input#password').val());
			if($(this).val() != $(this).parent('td').parent('tr').prev().children('td#pwd').children('input#password').val()){
				$(this).after('<div style="font-size: 11px; color: red; float: left; width: 100%; margin: 5px 0px 0px;" id="cekpass">*) Password harus sama</div>');
				$(this).val('');
				$(this).focus();
			}
		});
		
		$("#accountform").each(function(){
			$container = $(this).next("div.error-container");
			//Validate Starts
			$(this).validate({
				onfocusout: function(element) {	$(element).valid();	},
				errorContainer: $container,
				rules:{
				  id_group:{required:true,notEqual:0},
				  username:{required:true,notEqual:''},
				  email:{required:true,notEqual:''},
				  password:{required:true,notEqual:''},
				  passwordk:{required:true,notEqual:''}
				}
			});//Validate End

		});
		$("#accountform").submit(function(e){
			var id_group=$('#accountform select#id_group').val();
			
			$frm = $(this);
			$id_group = $frm.find('*[name=id_group]').val();
			$username = $frm.find('*[name=username]').val();
			$email = $frm.find('*[name=email]').val();
			$password = $frm.find('*[name=password]').val();
			$passwordk = $frm.find('*[name=passwordk]').val();
			
			if($frm.find('*[name=username]').is('.valid')  && $frm.find('*[name=email]').is('.valid') && $frm.find('*[name=password]').is('.valid') && $frm.find('*[name=passwordk]').is('.valid')  && $frm.find('*[name=id_group]').is('.valid') ) {
				$.ajax({
					type: "POST",
					data: $(this).serialize(),
					url: $(this).attr('action'),
					beforeSend: function() {
						$("input#simpanaccount").after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
					},
					success: function(msg) {
						$(".addaccount").remove();	
							$.ajax({
								type: "POST",
								data: "ajax=1&id_group="+id_group,
								url: '<?php echo base_url(); ?>superadmin/super/accountlist',
								beforeSend: function() {
									$("input#simpanaccount").after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
								},
								success: function(msg) {
									//$("#wait").remove();			
									$('select#id_group').val(id_group);
									$("#listaccount").html(msg);			
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
<form action="<? echo base_url();?>superadmin/super/addaccount" id="accountform" name="accountform" method="post" >
	<div class="addaccountclose" onclick="$('.addaccount').remove();"></div>
	<h3> <?=$page_title?> </h3><?// pr($pelajaran);?>
		<table class="adddata">
			<tr>
				<td class="title">Pilih Otoritas</td>
				<td>:</td>
				<td>
					<select class="selectgroup selectfilter" id="id_group" name="id_group">
						<option value="0">Pilih Group Otoritas</option>
						<? foreach($group as $id_group=>$groupdata){?>
						<option <? if(@$_POST['id_group']==$id_group){echo 'selected';}?> value="<?=$id_group?>"><?=$groupdata?></option>
						<? } ?>
					</select>
				</td>
			</tr>
			<tr>
				<td width="30%" class='title'>Username</td>
				<td width="1">:</td>
				<td><input type="text" name="username" size="30" id="username" /></td>
			</tr>
			<tr>
				<td width="30%" class='title'>Email Pengguna</td>
				<td width="1">:</td>
				<td><input type="text" class="email" name="email" size="30" id="email" /></td>
			</tr>
			<tr>
				<td width="30%" class='title'>Password</td>
				<td width="1">:</td>
				<td id="pwd">
				<input type="password" name="password" id="password"  size="30" />
				<!--<br /><br />
				<!--<div style="font-size:11px;" id="response">*) Singkatan nama pelajarang yang akan digunakan untuk SMS notifikasi</div>-->
				</td>
			</tr>
			<tr>
				<td width="30%" class='title'>Konfirmasi Password</td>
				<td width="1">:</td>
				<td>
				<input type="password" name="passwordk" id="passwordk"  size="30" /><!--<br /><br />
				<!--<div style="font-size:11px;" id="response">*) Singkatan nama pelajarang yang akan digunakan untuk SMS notifikasi</div>-->
				</td>
			</tr>
			
			<tr>
				<td class="title" colspan="3"><input id="simpanaccount" type="submit" name="simpan" value="Simpan"/></td>
			</tr>
		</table>

	<input type="hidden" name="addpelajaran" value="1"/> 
	<?if($addjenis=='sub'){?>
		<input type="hidden" name="id_parent" value="<?=$pelajaran[0]['id']?>"/> 
	<? } ?>
	<input type="hidden" name="ajax" value="1"/> 
	</form>
	<div class="error-container" style="display:none;"> Semua field harus di isi atau dipilih!  </div>
</div>