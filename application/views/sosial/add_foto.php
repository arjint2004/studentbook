<script src="<?=$this->config->item('js')?>jquery-1.3.2.min.js" type="text/javascript"></script>
<script src="<?=$this->config->item('js')?>jquery.imgareaselect.min.js" type="text/javascript"></script>
<?php if($large_photo_exists && $thumb_photo_exists == NULL):?>
<script src="<?=$this->config->item('js')?>jquery.imgpreview.js" type="text/javascript"></script>
<script type="text/javascript">
    var thumb_width    = <?php echo $thumb_width;?>;
    var thumb_height   = <?php echo $thumb_height;?> ;
    var image_width    = <?php echo $img['image_width'] ;?> ;
    var image_height   = <?php echo $img['image_height'] ;?> ;
    
    $(function(){
	$("#save_thumb").live('click',function() {
	    if($("#image_file").val()=='') {
		alert('Anda Harus Memilih Foto');
	    }
	});
    })
</script>
<?php endif ;?>

<div id="main">    
    <div class="container">
	<div class="column one-half" style="text-align: center;"> 
	    <h2>Foto Profil</h2>
	    <?php if($error) :?>
		<ul><li><strong>Error!</strong></li><li><?php echo $error ;?></li></ul>
	    <?php endif ;?>
	    
	    <?php if($large_photo_exists && $thumb_photo_exists) :?>
		    <?php echo $large_photo_exists."&nbsp;".$thumb_photo_exists; ?>
		    <p><a href="<?php echo $_SERVER["PHP_SELF"];?>">Upload another</a></p>
	    
	    <?php elseif($large_photo_exists && $thumb_photo_exists == NULL) :?>
	    <div align="center">
		    <img src="<?php echo base_url() . $upload_path.$img['file_name'];?>" style="margin-right: 10px;border:3px solid grey;" id="thumbnail" alt="Create Thumbnail" />
		    <!--<div style="border:3px solid grey; float:left; position:relative; overflow:hidden; width:<?php echo $thumb_width;?>px; height:<?php echo $thumb_height;?>px;">
			    <img src="<?php echo base_url() . $upload_path.$img['file_name'];?>" style="position: relative;height:150px;width: 150px;" alt="Thumbnail Preview" />
		    </div>-->
		    <br style="clear:both;"/>
		    <form name="thumbnail" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
			    <input type="hidden" name="x1" value="" id="x1" />
			    <input type="hidden" name="y1" value="" id="y1" />
			    <input type="hidden" name="x2" value="" id="x2" />
			    <input type="hidden" name="y2" value="" id="y2" />
			    <input type="hidden" name="file_name" value="<?php echo $img['file_name'] ;?>" />
			    <input type="submit" name="upload_thumbnail" value="Simpan Foto Profil" id="save_thumb" />
		    </form>
	    </div>
	    <hr />
	    <?php 	else : ?>
	    <img src="<?=$this->config->item('images')?>profil.jpg" alt="" title="" height="350">
	    <form name="photo" enctype="multipart/form-data" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
	    <input type="file" name="image" size="30" id="images_file"/>
	    <input type="submit" name="upload" value="Unggah Foto" />
	    
	    <?php 	endif ?> 
	</div>
	<div class="column one-half last"> 
	    <h2>DATA SEKOLAH</h2>
	    <dl style="margin: 0px;">
		<?php
		    if(!empty($sekolah)) {
			pr($sekolah);
			foreach($sekolah as $item) {
			    ?>
				<dt>Nama Sekolah</dt><dd>: <?=$item->nm_sekolah?></dd>
				<dt>Alamat</dt><dd>: <?=$item->alamat?></dd>
				<dt>Jenjang</dt><dd>: <?=$item->jenjang?></dd>
				<dt>Provinsi</dt><dd>: <?=$item->NmProv?></dd>
				<dt>Kota</dt><dd>: <?=$item->NmKota?></dd>
				<dt>No Sekolah</dt><dd>: <?=$item->no_sekolah?></dd>
				<dt>Telp Pribadi</dt><dd>: <?=$item->telp_pribadi?></dd>
				<dt>Selular</dt><dd>: <?=$item->selular?></dd>
				<dt>Username</dt><dd>: <?=$item->username?></dd>
			    <?php
			}
		    }
		?>
	    </dl>
	    <div class="float-right">
		<form method="POST" action="<?=site_url('sekolah/finish')?>">
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
		    <?php if(!empty($img['file_name'])) : ?>
			<input type="hidden" name="id" value="<?=$id?>" />
			<input type="hidden" name="file_name" value="<?php echo $img['file_name'] ;?>" />
		    <?php endif ?>
		    <input type="submit" class="button medium grey" name="Finish"/>
		</form>
	    </div>
	</div>
    </div>
<div>