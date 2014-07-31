<script>
	$(document).ready(function(){
		$("a.flows").click(function(){
				var obj=$(this);
				
				$.ajax({
					type: "GET",
					data: '',
					url: $(obj).attr('href'),
					beforeSend: function() {
						$(obj).append("<img id='wait' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loaderhover.gif';?>' />");
					},
					success: function(msg) {
						$("#wait").remove();
						$('div#addnyac<?=$id_kat?>').html(msg);
						
					}
				});
				return false;
		});
	});
</script>
<div class="addaccount<?=$id_kat?> addaccount">
<? //pr($kategori);?>
	<div class="addaccountclose" onclick="$('.addaccount<?=$id_kat?>').remove();"></div>
		<h5> <?//=$kategori[0]['nama_kategori']?> Posisi <?=$position?></h5> 
		<div id="addnya">
			<a class="readmorenoplus flows" title="artikel" href="<?=base_url()?>adminsb/admin/addslide/<?=$position?>/<?=$id_kat?>"> <span> Tambah Data </span></a>
			<a class="readmorenoplus flows" title="artikel" href="<?=base_url()?>adminsb/admin/addslide/<?=$position?>/<?=$id_kat?>/<?=$id_artikel?>"> <span> Edit Data </span></a>
			<a class="readmorenoplus flows" title="artikel" href="<?=base_url()?>adminsb/admin/addslideother/<?=$position?>/<?=$id_kat?>/<?=$id_artikel?>"> <span> Pilih Dari Artikel Lain </span></a>
			<div id="addnyac<?=$id_kat?>"></div>
		</div>
</div>
<br class="clear" />
<br />
