<!-- TinyMCE -->
	<script type="text/javascript" src="<?=$this->config->item('js');?>ckfinder/ckeditor/ckeditor.js"></script>
	<script type="text/javascript" src="<?=$this->config->item('js');?>ckfinder/ckfinder.js"></script>
<script type="text/javascript">

				
				/*js for content start*/
				jQuery(document).ready(function($){	
					<? if($simpan=='simpan'){?>
						$.ajax({
							type: "POST",
							data: "<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&ajax=1",
							url: '<?=base_url()?>admin/content/edit/<?=$title?>',
							beforeSend: function() {
								$("#listcontentloading").html("<img src='"+config_images+"loading.png' />");
							},
							success: function(msg) {
								$("#listcontent").html(msg);	
								//loadEditor($(obj).attr('id'))
							}
						});
					<? } ?>
					$('a.contentsek').click(function(){
					$("#listcontent").html('');	
						var obj=$(this);
						$.ajax({
							type: "POST",
							data: "<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&ajax=1",
							url: $(this).attr('href'),
							beforeSend: function() {
								$("#listcontentloading").html("<img src='"+config_images+"loading.png' />");
							},
							success: function(msg) {
								$("#listcontent").html(msg);	
								//loadEditor($(obj).attr('id'))
							}
						});
						return false;
					});

					
				});
				
				/*js for content end*/
			</script>
			
			<h1 class="with-subtitle"> Content Sekolah </h1>
				<h6 class="subtitle"> Pengaturan Content sekolah untuk data-data detail profile sekolah </h6>
                <div class="styled-elements">
					<a  href="<?=base_url()?>admin/content/edit/<?=base64_encode('Visi Misi')?>" title="guru" class="readmore readmoreasb contentsek"> <span> Visi & Misi </span></a>
					<a  href="<?=base_url()?>admin/content/edit/<?=base64_encode('Tujuan')?>" title="guru" class="readmore readmoreasb contentsek"> <span> Tujuan </span></a>
					<a  href="<?=base_url()?>admin/content/edit/<?=base64_encode('Motto')?>" title="guru" class="readmore readmoreasb contentsek"> <span> Motto </span></a>
					<a  href="<?=base_url()?>admin/content/edit/<?=base64_encode('Sejarah')?>" title="guru" class="readmore readmoreasb contentsek"> <span> Sejarah </span></a>
					<a  href="<?=base_url()?>admin/content/edit/<?=base64_encode('Kurikulum')?>" title="guru" class="readmore readmoreasb contentsek"> <span> Kurikulum </span></a>
					<a  href="<?=base_url()?>admin/content/edit/<?=base64_encode('Metode')?>" title="guru" class="readmore readmoreasb contentsek"> <span> Metode </span></a>
					<a  href="<?=base_url()?>admin/content/edit/<?=base64_encode('Target')?>" title="guru" class="readmore readmoreasb contentsek"> <span> Target </span></a>
					<a  href="<?=base_url()?>admin/content/edit/<?=base64_encode('Program')?>" title="guru" class="readmore readmoreasb contentsek"> <span> Program </span></a>
					<a  href="<?=base_url()?>admin/content/edit/<?=base64_encode('Prestasi')?>" title="guru" class="readmore readmoreasb contentsek"> <span> Prestasi </span></a>
					<a  href="<?=base_url()?>admin/content/edit/<?=base64_encode('Ekstrakurikuler')?>" title="guru" class="readmore readmoreasb contentsek"> <span> Ekstrakurikuler </span></a>
					<a  href="<?=base_url()?>admin/content/edit/<?=base64_encode('Fasilitas')?>" title="guru" class="readmore readmoreasb contentsek"> <span> Fasilitas </span></a>
					<a  href="<?=base_url()?>admin/content/edit/<?=base64_encode('Guru')?>" title="guru" class="readmore readmoreasb contentsek"> <span> Guru </span></a>
					<a  href="<?=base_url()?>admin/content/edit/<?=base64_encode('Karyawan')?>" title="guru" class="readmore readmoreasb contentsek"> <span> Karyawan </span></a>
					<a  href="<?=base_url()?>admin/content/edit/<?=base64_encode('Komite')?>" title="guru" class="readmore readmoreasb contentsek"> <span> Komite </span></a>
					<a  href="<?=base_url()?>admin/content/edit/<?=base64_encode('Pengantar')?>" title="guru" class="readmore readmoreasb contentsek"> <span> Pengantar </span></a>
					<div id="listcontent">
													
					</div>
                    <div class="hr"> </div>
                    <div class="clear"> </div>
                </div> <!-- **Styled Elements - End** -->  