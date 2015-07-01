<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    
    <title>Kohaci - PHP, CodeIgniter, &amp; Jquery image upload &amp; crop</title>
    <script src="<?php echo base_url();?>public/javascript/jquery-1.3.2.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>public/javascript/jquery.imgareaselect.min.js" type="text/javascript"></script>
    
    <?php if($large_photo_exists && $thumb_photo_exists == NULL):?>
    <script src="<?php echo base_url();?>public/javascript/jquery.imgpreview.js" type="text/javascript"></script>
    <script type="text/javascript">
    // <![CDATA[
        var thumb_width    = <?php echo $thumb_width ;?> ;
        var thumb_height   = <?php echo $thumb_height ;?> ;
        var image_width    = <?php echo $img['image_width'] ;?> ;
        var image_height   = <?php echo $img['image_height'] ;?> ;
    // ]]>
    </script>
    <?php endif ;?>
</head>
<body>

<h1>Photo Upload and Crop</h1>
<?php if($error) :?>
    <ul><li><strong>Error!</strong></li><li><?php echo $error ;?></li></ul>
<?php endif ;?>

<?php if($large_photo_exists && $thumb_photo_exists) :?>
	<?php echo $large_photo_exists."&nbsp;".$thumb_photo_exists; ?>
	<p><a href="<?php echo $_SERVER["PHP_SELF"];?>">Upload another</a></p>

<?php elseif($large_photo_exists && $thumb_photo_exists == NULL) :?>

<h2>Create Thumbnail</h2>
<div align="center">
        <img src="<?php echo base_url() . $upload_path.$img['file_name'];?>" style="float: left; margin-right: 10px;" id="thumbnail" alt="Create Thumbnail" />
        <div style="border:1px #e5e5e5 solid; float:left; position:relative; overflow:hidden; width:<?php echo $thumb_width;?>px; height:<?php echo $thumb_height;?>px;">
                <img src="<?php echo base_url() . $upload_path.$img['file_name'];?>" style="position: relative;" alt="Thumbnail Preview" />
        </div>
        <br style="clear:both;"/>
        <form name="thumbnail" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                <input type="hidden" name="x1" value="" id="x1" />
                <input type="hidden" name="y1" value="" id="y1" />
                <input type="hidden" name="x2" value="" id="x2" />
                <input type="hidden" name="y2" value="" id="y2" />
                <input type="hidden" name="file_name" value="<?php echo $img['file_name'] ;?>" />
                <input type="submit" name="upload_thumbnail" value="Save Thumbnail" id="save_thumb" />
        </form>
</div>

<hr />
<?php 	else : ?>

<h2>Upload Photo</h2>
<form name="photo" enctype="multipart/form-data" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
Photo <input type="file" name="image" size="30" /> <input type="submit" name="upload" value="Upload" />
</form>
<?php 	endif ?>

</body>
</html>

