			<script>
				$(document).ready(function(){
					$('#listaccount').load('<?=base_url()?>/superadmin/super/accountlist');
					$('#addAccount').click(function(){
						$('#listaccount').load('<?=base_url()?>/superadmin/super/addaccount');
					});
					/*$.ajax({
						type: "POST",
						data: "<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&ajax=1&id_Account="+$(thisobj).attr('id')+"&jenjang="+$('select#jenjangselect').val()+"&jurusan="+$('select#jurusanselect').val()+"&semester="+$('select#semesterselect').val(),
						url: base_url+'admin/Account/adddata',
						beforeSend: function() {
							$(thisobj).append("<img id='wait' src='"+config_images+"loaderhover.gif' />");
						},
						success: function(msg) {
							$("#wait").remove();			
							$("#ajaxside").html(msg);	
							$("#ajaxside").scrollintoview({ speed:'1100'}); 
						}
					});*/
				});
			</script>

<h1 class="with-subtitle"> Data User Account </h1>
<h6 class="subtitle"> Pengaturan Account </h6>
<div class="styled-elements">
	<a id="addAccount" title="Account" class="readmore readmoreasb"> <span> Tambah Account </span></a>
	<div id="ajaxside"></div>
	<div id="listaccount"></div>
    <div class="hr"></div>
    <div class="clear"></div>
</div> <!-- **Styled Elements - End** -->  