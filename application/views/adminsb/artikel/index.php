			<!-- TinyMCE -->
	<script type="text/javascript" src="<?=$this->config->item('js');?>ckfinder/ckeditor/ckeditor.js"></script>
	<script type="text/javascript" src="<?=$this->config->item('js');?>ckfinder/ckfinder.js"></script>
			<script>
				$(document).ready(function(){
					$('#listartikel').load('<?=base_url()?>adminsb/artikel/artikellist');
					$('#listartikeleg').click(function(e){
						//e.stopImmediatePropagation();
						$('#addartikelok').html('');
						$('#listartikel').load('<?=base_url()?>adminsb/artikel/artikellist');
						//$('#addartikel').hide();
					});
					$('#addartikel').click(function(e){
						//e.stopImmediatePropagation();
						$('#addartikelok').load('<?=base_url()?>adminsb/artikel/addartikel');
						//$('#addartikel').hide();
					});
					$('#addkatartikel').click(function(e){
						//e.stopImmediatePropagation();
						$('#addartikelok').load('<?=base_url()?>adminsb/artikel/addartikelkat');
						//$('#addartikel').hide();
					});
					$('#listkateg').click(function(e){
						//e.stopImmediatePropagation();
						$('#listartikel').load('<?=base_url()?>adminsb/artikel/listartikelkat/0');
						//$('#addartikel').hide();
					});
					/*$.ajax({
						type: "POST",
						data: "<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&ajax=1&id_artikel="+$(thisobj).attr('id')+"&jenjang="+$('select#jenjangselect').val()+"&jurusan="+$('select#jurusanselect').val()+"&semester="+$('select#semesterselect').val(),
						url: base_url+'admin/artikel/adddata',
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

<h1 class="with-subtitle"> Data Artikel & Berita </h1>
<h6 class="subtitle"> Pengaturan Data Artikel & Berita  </h6>
<div class="styled-elements">
	<a id="addartikel" title="artikel" class="readmore readmoreasb"> <span> Tambah Data Artikel </span></a>
	<a id="listartikeleg" title="artikel" class="readmorenoplus "> <span> Daftar Artikel </span></a>
	<a id="addkatartikel" title="artikel" class="readmore readmoreasb"> <span> Tambah Kategori </span></a>
	<a id="listkateg" title="artikel" class="readmorenoplus "> <span> Daftar Kategori </span></a>
	<div id="ajaxside"></div>
	<div id="addartikelok"></div>
	<div id="listartikel"></div>
    <div class="hr"></div>
    <div class="clear"></div>
</div> <!-- **Styled Elements - End** -->  